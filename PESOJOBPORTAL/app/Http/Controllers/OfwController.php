<?php

namespace App\Http\Controllers;

use App\Models\OfwRequest;
use App\Models\PortalNotification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OfwController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('dashboard.ofw.dashboard', $this->dashboardData($request));
    }

    public function acceptedRequests(Request $request): View
    {
        return view('dashboard.ofw.accepted-requests', $this->dashboardData($request));
    }

    public function owwaRequest(Request $request): View
    {
        return view('dashboard.ofw.owwa-request', $this->dashboardData($request));
    }

    public function submittedRequests(Request $request): View
    {
        return view('dashboard.ofw.submitted-requests', $this->dashboardData($request));
    }

    private function dashboardData(Request $request): array
    {
        $ofwUser = $request->user()->loadMissing('profile');
        $ofwProfile = $ofwUser->profile;
        $requestQuery = OfwRequest::query()->where('user_id', $ofwUser->id);

        $rawAttachments = [];
        try {
            $rawAttachments = $this->readAttachments($ofwUser->id);
        } catch (\Throwable $e) {
            Log::warning('Failed to read DMW attachments for user ' . $ofwUser->id . ': ' . $e->getMessage());
        }

        $dmwAttachments = collect($rawAttachments)->map(fn (string $path) => asset('storage/' . $path))->values()->all();

        return [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
            'submittedRequests' => (clone $requestQuery)
                ->latest()
                ->take(6)
                ->get(),
            'requestStats' => [
                'open' => (clone $requestQuery)->where('status', 'open')->count(),
                'under_review' => (clone $requestQuery)->where('status', 'under_review')->count(),
                'resolved' => (clone $requestQuery)->where('status', 'resolved')->count(),
            ],
            'profileSummary' => [
                'name' => data_get($ofwProfile, 'personal_information.first_name', $ofwUser->name),
                'email' => data_get($ofwProfile, 'personal_information.email_address', $ofwUser->email),
                'phone' => $ofwProfile?->phone ?? data_get($ofwProfile, 'personal_information.contact_number'),
                'address' => $ofwProfile?->address ?? data_get($ofwProfile, 'present_address.municipality'),
            ],
            'dmwAttachments' => $dmwAttachments,
        ];
    }

    public function dmwBuilder(Request $request): View
    {
        $ofwUser = $request->user()->loadMissing('profile');
        $ofwProfile = $ofwUser->profile;
        $draft = $request->session()->get('dmw_form_draft', []);

        $storedAttachments = [];
        try {
            $storedAttachments = collect($this->readAttachments($ofwUser->id))->map(function (string $path): array {
                return [
                    'path' => $path,
                    'name' => basename($path),
                    'url' => asset('storage/' . $path),
                ];
            })->values()->all();
        } catch (\Throwable $e) {
            Log::warning('Failed to read DMW attachments for builder: ' . $e->getMessage());
        }

        return view('ofw.dmwbuilder', [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
            'dmwDraft' => $draft,
            'dmwAttachments' => $storedAttachments,
        ]);
    }

    public function saveDmwBuilder(Request $request)
    {
        $isDraftSave = $request->expectsJson() || $request->wantsJson();
        $validated = $isDraftSave ? $this->validateDmwDraftRequest($request) : $this->validateDmwRequest($request);
        $request->session()->put('dmw_form_draft', $validated);

        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        if ($isDraftSave) {
            return response()->json(['status' => 'ok', 'message' => 'Draft saved.']);
        }

        return redirect()->route('ofw.dmw-builder')->with('status', 'Form draft saved.');
    }

    public function submitDmwForm(Request $request)
    {
        $validated = $this->validateDmwRequest($request);
        $user = $request->user();

        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        $attachments = $this->readAttachments($user->id);

        OfwRequest::create([
            'user_id' => $user->id,
            'subject' => 'DMW Request for Assistance',
            'details' => $validated['request_details'],
            'status' => 'open',
            'notes' => json_encode([
                'form' => $validated,
                'attachments' => $attachments,
            ]),
        ]);

        try {
            $title = 'New DMW request from ' . ($validated['applicant_name'] ?? $user->name);
            $message = substr($validated['request_details'], 0, 200);
            $portal = PortalNotification::create([
                'title' => $title,
                'message' => $message,
                'created_by' => $user->id,
            ]);

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                UserNotification::create([
                    'user_id' => $admin->id,
                    'portal_notification_id' => $portal->id,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to notify admins for DMW submission: ' . $e->getMessage());
        }

        return redirect()->route('ofw.dashboard')->with('status', 'DMW request submitted to admin.');
    }

    public function downloadDmwForm(Request $request)
    {
        Log::info('DMW download requested', ['ip' => $request->ip(), 'user_id' => optional($request->user())->id]);

        $user = $request->user();

        // Collect all form inputs directly from the builder's field names
        $builderData = $request->only([
            // OFW fields (Section A)
            'ofw_lastname', 'ofw_firstname', 'ofw_middlename',
            'ofw_birthdate', 'ofw_sex', 'civil_status',
            'ofw_passport', 'ofw_address_abroad', 'ofw_address_ph',
            'ofw_contact', 'ofw_email',
            // Mode / referral
            'mode', 'referral_by',
            // Family/Relative fields (Section B)
            'fam_lastname', 'fam_firstname', 'fam_middlename',
            'fam_birthdate', 'relationship', 'relationship_others',
            'fam_id', 'fam_address', 'fam_contact', 'fam_email',
            // Section C - assistance
            'assistance', 'assistance_others',
            // Section D - narrative
            'narrative',
            // Section E - bank
            'has_bank', 'bank_account_no', 'bank_name', 'bank_branch', 'bank_account_name',
            // Hidden mapped fields (fallback)
            'name_first', 'name_last', 'name_middle',
            'birthdate', 'sex', 'passport_number', 'phone', 'email',
            'request_details', 'request_type',
            'signature_date', 'signature_printed',
            'relative_last', 'relative_first', 'relative_middle',
            'relative_birthdate', 'relative_relationship',
            'relative_id_no', 'relative_address_ph', 'relative_mobile', 'relative_email',
            'account_name', 'address_abroad', 'address_ph',
            'assistance_others_text',
        ]);

        // Map builder field names to normalized names for the PDF template
        $formData = [
            'name_last'     => $builderData['ofw_lastname']  ?? ($builderData['name_last'] ?? ''),
            'name_first'    => $builderData['ofw_firstname'] ?? ($builderData['name_first'] ?? ''),
            'name_middle'   => $builderData['ofw_middlename'] ?? ($builderData['name_middle'] ?? ''),
            'birthdate'     => $builderData['ofw_birthdate'] ?? ($builderData['birthdate'] ?? ''),
            'sex'           => $builderData['ofw_sex']       ?? ($builderData['sex'] ?? ''),
            'civil_status'  => is_array($builderData['civil_status'] ?? null)
                                ? ($builderData['civil_status'][0] ?? '')
                                : ($builderData['civil_status'] ?? ''),
            'passport_number' => $builderData['ofw_passport'] ?? ($builderData['passport_number'] ?? ''),
            'address_abroad'  => $builderData['ofw_address_abroad'] ?? ($builderData['address_abroad'] ?? ''),
            'address_ph'      => $builderData['ofw_address_ph'] ?? ($builderData['address_ph'] ?? ''),
            'phone'           => $builderData['ofw_contact'] ?? ($builderData['phone'] ?? ''),
            'email'           => $builderData['ofw_email']   ?? ($builderData['email'] ?? ''),

            // Determine request mode
            'request_type'  => is_array($builderData['mode'] ?? null)
                                ? ($builderData['mode'][0] ?? '')
                                : ($builderData['mode'] ?? ($builderData['request_type'] ?? '')),
            'referral_by'   => $builderData['referral_by'] ?? '',

            // Section B - Relative
            'relative_last'         => $builderData['fam_lastname']  ?? ($builderData['relative_last'] ?? ''),
            'relative_first'        => $builderData['fam_firstname'] ?? ($builderData['relative_first'] ?? ''),
            'relative_middle'       => $builderData['fam_middlename'] ?? ($builderData['relative_middle'] ?? ''),
            'relative_birthdate'    => $builderData['fam_birthdate'] ?? ($builderData['relative_birthdate'] ?? ''),
            'relative_relationship' => is_array($builderData['relationship'] ?? null)
                                        ? ($builderData['relationship'][0] ?? '')
                                        : ($builderData['relationship'] ?? ($builderData['relative_relationship'] ?? '')),
            'relationship_others'   => $builderData['relationship_others'] ?? '',
            'relative_id_no'        => $builderData['fam_id'] ?? ($builderData['relative_id_no'] ?? ''),
            'relative_address_ph'   => $builderData['fam_address'] ?? ($builderData['relative_address_ph'] ?? ''),
            'relative_mobile'       => $builderData['fam_contact'] ?? ($builderData['relative_mobile'] ?? ''),
            'relative_email'        => $builderData['fam_email']   ?? ($builderData['relative_email'] ?? ''),

            // Section C - Assistance
            'assistance'            => is_array($builderData['assistance'] ?? null)
                                        ? array_filter($builderData['assistance'])
                                        : [],
            'assistance_others_text' => $builderData['assistance_others'] ?? ($builderData['assistance_others_text'] ?? ''),

            // Section D - Narrative
            'request_details' => $builderData['narrative'] ?? ($builderData['request_details'] ?? ''),

            // Section E - Bank
            'bank_account_no'  => $builderData['bank_account_no'] ?? '',
            'bank_name'        => $builderData['bank_name'] ?? '',
            'bank_branch'      => $builderData['bank_branch'] ?? '',
            'account_name'     => $builderData['bank_account_name'] ?? ($builderData['account_name'] ?? ''),

            // Signature
            'signature_printed' => $builderData['signature_printed'] ?? '',
            'signature_date'    => $builderData['signature_date'] ?? now()->toDateString(),
        ];

        // Handle file attachments
        if ($request->hasFile('contract_attachment')) {
            $this->storeOfwAttachments($request, [$request->file('contract_attachment')]);
        }
        if ($request->hasFile('passport_attachment')) {
            $this->storeOfwAttachments($request, [$request->file('passport_attachment')]);
        }
        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        $attachments = $this->readAttachments($user->id);

        // Save draft for future use
        $request->session()->put('dmw_form_draft', $formData);

        try {
            return $this->renderDmwPdf($user->id, $formData, $attachments);
        } catch (\Throwable $e) {
            Log::error('DMW render failed', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function uploadAttachment(Request $request)
    {
        // If PHP's upload limits (upload_max_filesize/post_max_size) are exceeded,
        // the uploaded file will be missing from the request. Give a helpful error.
        if (! $request->hasFile('attachment')) {
            return redirect()->back()->withErrors(['attachment' => 'No file uploaded. The file may exceed server limits (upload_max_filesize/post_max_size).']);
        }

        $request->validate([
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:102400'],
        ]);

        $file = $request->file('attachment');
        if (! $file->isValid()) {
            return redirect()->back()->withErrors(['attachment' => 'Upload failed. The file appears to be invalid.']);
        }

        $this->storeOfwAttachments($request, [$file]);

        return redirect()->route('ofw.dmw-builder')->with('status', 'Attachment uploaded.');
    }

    public function deleteAttachment(Request $request)
    {
        $request->validate(['path' => ['required', 'string']]);
        $user = $request->user();
        $stored = $this->readAttachments($user->id);
        $path = $request->input('path');

        $index = array_search($path, $stored, true);
        if ($index === false) {
            return redirect()->back()->withErrors(['attachment' => 'Attachment not found.']);
        }

        $full = storage_path('app/public/' . $path);
        if (file_exists($full)) {
            @unlink($full);
        }

        array_splice($stored, $index, 1);
        $this->writeAttachments($user->id, $stored);

        return redirect()->back()->with('status', 'Attachment removed.');
    }

    protected function validateDmwRequest(Request $request): array
    {
        $validated = $request->validate([
            'applicant_name' => ['nullable', 'string', 'max:255'],
            'name_last' => ['nullable', 'string', 'max:255'],
            'name_first' => ['nullable', 'string', 'max:255'],
            'name_middle' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'sex' => ['nullable', 'in:male,female'],
            'civil_status' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'passport_number' => ['nullable', 'string', 'max:100'],
            'address_abroad' => ['nullable', 'string', 'max:1000'],
            'address_ph' => ['nullable', 'string', 'max:1000'],
            'employer' => ['nullable', 'string', 'max:255'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'request_details' => ['required', 'string', 'max:4000'],
            'request_type' => ['nullable', 'in:online,walkin,referral'],
            'referral_by' => ['nullable', 'string', 'max:255'],
            'assistance' => ['required', 'array', 'min:1'],
            'assistance.*' => ['string', 'max:50'],
            'assistance_others_text' => ['nullable', 'string', 'max:255'],
            'relative_last' => ['nullable', 'string', 'max:255'],
            'relative_first' => ['nullable', 'string', 'max:255'],
            'relative_middle' => ['nullable', 'string', 'max:255'],
            'relative_birthdate' => ['nullable', 'date'],
            'relative_relationship' => ['nullable', 'string', 'max:100'],
            'relative_id_no' => ['nullable', 'string', 'max:100'],
            'relative_address_ph' => ['nullable', 'string', 'max:1000'],
            'relative_mobile' => ['nullable', 'string', 'max:50'],
            'relative_email' => ['nullable', 'email', 'max:255'],
            'bank_account_no' => ['nullable', 'string', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'signature_printed' => ['nullable', 'string', 'max:255'],
            'signature_date' => ['required', 'date'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png', 'max:102400'],
        ]);

        $incomingAttachments = $request->file('attachments', []);
        $incomingAttachments = is_array($incomingAttachments) ? array_values(array_filter($incomingAttachments)) : [];

        if ($incomingAttachments !== []) {
            $this->assertAttachmentLimits($request->user()->id, $incomingAttachments);
        }

        // Normalize applicant_name: prefer provided combined name, otherwise build from parts
        if (empty($validated['applicant_name'])) {
            $parts = array_filter([
                $validated['name_last'] ?? null,
                $validated['name_first'] ?? null,
                $validated['name_middle'] ?? null,
            ]);
            $validated['applicant_name'] = $parts ? implode(' ', $parts) : ($request->input('applicant_name') ?? '');
        }

        // Normalize request_type when radio input used
        if ($request->has('request_type')) {
            $validated['request_type'] = $request->input('request_type');
        }

        return $validated;
    }

    protected function validateDmwDraftRequest(Request $request): array
    {
        $fields = [
            'applicant_name',
            'name_last',
            'name_first',
            'name_middle',
            'birthdate',
            'sex',
            'civil_status',
            'email',
            'phone',
            'passport_number',
            'address_abroad',
            'address_ph',
            'contract_start',
            'contract_end',
            'request_type',
            'referral_by',
            'request_details',
            'assistance',
            'assistance_others_text',
            'relative_last',
            'relative_first',
            'relative_middle',
            'relative_birthdate',
            'relative_relationship',
            'relative_id_no',
            'relative_address_ph',
            'relative_mobile',
            'relative_email',
            'bank_account_no',
            'bank_name',
            'bank_branch',
            'account_name',
            'signature_printed',
            'signature_date',
        ];

        $validated = $request->only($fields);

        if (isset($validated['assistance']) && ! is_array($validated['assistance'])) {
            $validated['assistance'] = [$validated['assistance']];
        }

        if (empty($validated['applicant_name'])) {
            $parts = array_filter([
                $validated['name_last'] ?? null,
                $validated['name_first'] ?? null,
                $validated['name_middle'] ?? null,
            ]);
            $validated['applicant_name'] = $parts ? implode(' ', $parts) : ($request->input('applicant_name') ?? '');
        }

        if ($request->has('request_type')) {
            $validated['request_type'] = $request->input('request_type');
        }

        return $validated;
    }

    protected function assertAttachmentLimits(int $userId, array $incomingAttachments): void
    {
        $existingAttachments = $this->readAttachments($userId);
        $existingCount = count($existingAttachments);
        $existingBytes = 0;

        foreach ($existingAttachments as $existingPath) {
            $fullPath = storage_path('app/public/' . $existingPath);
            if (file_exists($fullPath)) {
                $existingBytes += (int) filesize($fullPath);
            }
        }

        $incomingCount = 0;
        $incomingBytes = 0;

        foreach ($incomingAttachments as $attachment) {
            if (! $attachment || ! $attachment->isValid()) {
                continue;
            }

            ++$incomingCount;
            $incomingBytes += (int) ($attachment->getSize() ?? 0);
        }

        if (($existingCount + $incomingCount) > 10) {
            throw ValidationException::withMessages([
                'attachments' => 'You can attach a maximum of 10 images in total.',
            ]);
        }

        $maxBytes = 100 * 1024 * 1024;
        if (($existingBytes + $incomingBytes) > $maxBytes) {
            throw ValidationException::withMessages([
                'attachments' => 'The total size of attached images cannot exceed 100MB.',
            ]);
        }
    }

    protected function attachmentsMetaPath(int $userId): string
    {
        return storage_path("app/ofw_attachments/{$userId}.json");
    }

    protected function fieldCoordsPath(): string
    {
        return storage_path('app/ofw_field_coords.json');
    }

    protected function readFieldCoords(): array
    {
        $path = $this->fieldCoordsPath();
        if (! file_exists($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    protected function writeFieldCoords(array $data): void
    {
        $dir = dirname($this->fieldCoordsPath());
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($this->fieldCoordsPath(), json_encode($data, JSON_PRETTY_PRINT));
    }

    public function saveDmwCoords(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && app()->environment() !== 'local') {
            abort(403);
        }

        $payload = $request->validate([
            'coords' => ['required', 'array'],
        ]);

        $existing = $this->readFieldCoords();
        $merged = array_merge($existing, $payload['coords']);
        $this->writeFieldCoords($merged);

        return response()->json(['status' => 'ok', 'coords' => $merged]);
    }

    protected function readAttachments(int $userId): array
    {
        $meta = $this->attachmentsMetaPath($userId);
        if (! file_exists($meta)) {
            return [];
        }

        $json = file_get_contents($meta);
        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    protected function writeAttachments(int $userId, array $data): void
    {
        $dir = dirname($this->attachmentsMetaPath($userId));
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($this->attachmentsMetaPath($userId), json_encode(array_values($data)));
    }

    protected function storeOfwAttachments(Request $request, array $files): array
    {
        $user = $request->user();
        $this->assertAttachmentLimits($user->id, $files);

        $stored = $this->readAttachments($user->id);

        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            // Store explicitly on the public disk so files go to storage/app/public
            $path = $file->store("ofw_attachments/{$user->id}", 'public');
            $stored[] = $path;
        }

        $this->writeAttachments($user->id, $stored);

        return $stored;
    }

    protected function renderDmwPdf(int $userId, array $formData, array $attachments)
    {
        $html = view('ofw.dmwpdf', [
            'formData'    => $formData,
            'attachments' => $attachments,
        ])->render();

        /** @var \Barryvdh\DomPDF\PDF $pdf */
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download('DMW_REQUEST_FOR_ASSISTANCE.pdf');
    }

    protected function attachmentImageToPdf(string $imagePath, string $tmpDir, int $userId, int $index): ?string
    {
        $mime = mime_content_type($imagePath) ?: '';
        if (! Str::startsWith($mime, 'image/')) {
            return null;
        }

        $data = file_get_contents($imagePath);
        if ($data === false) {
            return null;
        }

        $html = '<!doctype html><html><head><meta charset="utf-8"><style>@page{margin:0}html,body{width:100%;height:100%;margin:0}body{display:flex;align-items:center;justify-content:center;background:#fff}img{max-width:100%;max-height:100%;object-fit:contain}</style></head><body><img src="data:' . $mime . ';base64,' . base64_encode($data) . '" alt="attachment"></body></html>';
        $dompdf = app('dompdf.wrapper');
        $dompdf->loadHTML($html)->setPaper('a4', 'portrait');

        $pdfPath = $tmpDir . '/attachment_' . $userId . '_' . $index . '.pdf';
        file_put_contents($pdfPath, $dompdf->output());

        return $pdfPath;
    }

    // NOTE: The old FPDI-based writeDmwFields, writeDmwText, sanitizePdfText,
    // resolveDmwFieldCoords, and dmwFieldDefaults methods have been removed.
    // PDF generation now uses DomPDF with the ofw.dmwpdf Blade template.
}
