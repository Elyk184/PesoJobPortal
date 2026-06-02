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

<<<<<<< HEAD
        return [
=======
        $rawAttachments = [];
        try {
            $rawAttachments = $this->readAttachments($ofwUser->id);
        } catch (\Throwable $e) {
            Log::warning('Failed to read DMW attachments for user ' . $ofwUser->id . ': ' . $e->getMessage());
        }

        $dmwAttachments = collect($rawAttachments)->map(fn (string $path) => asset('storage/' . $path))->values()->all();

        return view('dashboard.ofw', [
>>>>>>> 26fcc21c858b8cb66dc7c98e0ce921d300a044d2
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
<<<<<<< HEAD
        ];
    }
}
=======
            'dmwAttachments' => $dmwAttachments,
        ]);
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

        $validated = array_merge($request->session()->get('dmw_form_draft', []), $this->validateDmwDraftRequest($request));
        if (empty($validated['signature_date'])) {
            $validated['signature_date'] = now()->toDateString();
        }

        if (empty($validated['assistance']) || ! is_array($validated['assistance'])) {
            $validated['assistance'] = [];
        }

        $user = $request->user();

        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        $attachments = $this->readAttachments($user->id);
        $draft = array_merge($request->session()->get('dmw_form_draft', []), $validated);
        $request->session()->put('dmw_form_draft', $draft);

        try {
            return $this->renderDmwPdf($user->id, $draft, $attachments);
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
        $mainForm = public_path('forms/DMW REQUEST FOR ASSISTANCE FORM.pdf');
        if (! file_exists($mainForm)) {
            Log::error('DMW form PDF not found: ' . $mainForm);
            abort(404, 'Form template not found.');
        }

        $tmpDir = storage_path('app/tmp/ofw_forms');
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $fpdiClass = '\\setasign\\Fpdi\\Fpdi';
        if (! class_exists($fpdiClass)) {
            Log::warning('FPDI not installed; serving main form only.');
            return response()->download($mainForm, 'DMW_REQUEST_FOR_ASSISTANCE.pdf');
        }

        try {
            /** @var \setasign\Fpdi\Fpdi $fpdi */
            $fpdi = new $fpdiClass();
        } catch (\Throwable $e) {
            Log::error('Failed to instantiate FPDI: ' . $e->getMessage());
            return response()->download($mainForm, 'DMW_REQUEST_FOR_ASSISTANCE.pdf');
        }

        $templatePages = $fpdi->setSourceFile($mainForm);
        $fieldCoords = $this->resolveDmwFieldCoords();

        for ($pageNumber = 1; $pageNumber <= $templatePages; $pageNumber++) {
            try {
                $templateId = $fpdi->importPage($pageNumber);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);

                if ($pageNumber === 1) {
                    $this->writeDmwFields($fpdi, $formData, $fieldCoords, $size['width'], $size['height']);
                }
            } catch (\Throwable $e) {
                Log::error('Failed rendering DMW template page ' . $pageNumber . ': ' . $e->getMessage());
            }
        }

        foreach ($attachments as $index => $attachmentPath) {
            $attachmentFullPath = storage_path('app/public/' . $attachmentPath);
            if (! file_exists($attachmentFullPath)) {
                continue;
            }
            $mime = mime_content_type($attachmentFullPath) ?: '';

            // If attachment is already a PDF, append it directly. If it's an image, convert to PDF first.
            if (strtolower($mime) === 'application/pdf' || str_ends_with($attachmentFullPath, '.pdf')) {
                $pdfToAppend = $attachmentFullPath;
            } else {
                $pdfToAppend = $this->attachmentImageToPdf($attachmentFullPath, $tmpDir, $userId, $index);
            }

            if (! $pdfToAppend || ! file_exists($pdfToAppend)) {
                continue;
            }

            try {
                $pageCount = $fpdi->setSourceFile($pdfToAppend);
                for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                    $templateId = $fpdi->importPage($pageNumber);
                    $size = $fpdi->getTemplateSize($templateId);
                    $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                    $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                    $fpdi->useTemplate($templateId);
                }
            } catch (\Throwable $e) {
                Log::error('Failed appending attachment page ' . $pdfToAppend . ': ' . $e->getMessage());
            }
        }

        $mergedPath = $tmpDir . '/dmw_merged_' . $userId . '_' . time() . '.pdf';
        $fpdi->Output($mergedPath, 'F');

        return response()->download($mergedPath, 'DMW_REQUEST_FOR_ASSISTANCE.pdf')->deleteFileAfterSend(true);
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

    protected function writeDmwFields(\setasign\Fpdi\Fpdi $pdf, array $formData, array $fieldCoords, float $pageWidth, float $pageHeight): void
    {
        $fieldValues = [
            'name' => $formData['applicant_name'] ?? '',
            'birthdate' => $formData['birthdate'] ?? '',
            'sex' => ucfirst((string) ($formData['sex'] ?? '')),
            'passport' => $formData['passport_number'] ?? '',
            'contact' => $formData['phone'] ?? '',
            'email' => $formData['email'] ?? '',
            // 'employer' removed from form
            'contract' => trim(implode(' to ', array_filter([
                $formData['contract_start'] ?? '',
                $formData['contract_end'] ?? '',
            ]))),
            'narrative' => $formData['request_details'] ?? '',
            'civil_status' => $formData['civil_status'] ?? '',
            'address_abroad' => $formData['address_abroad'] ?? '',
            'address_ph' => $formData['address_ph'] ?? '',
            'relative_name' => trim(implode(' ', array_filter([$formData['relative_last'] ?? '', $formData['relative_first'] ?? '', $formData['relative_middle'] ?? '']))),
            'relative_relationship' => $formData['relative_relationship'] ?? '',
            'relative_contact' => $formData['relative_mobile'] ?? '',
            'bank_account_no' => $formData['bank_account_no'] ?? '',
            'bank_name' => $formData['bank_name'] ?? '',
            'bank_branch' => $formData['bank_branch'] ?? '',
            'account_name' => $formData['account_name'] ?? '',
            'signature_printed' => $formData['signature_printed'] ?? '',
        ];

        $pdf->SetTextColor(0, 0, 0);

        foreach ($fieldValues as $fieldKey => $value) {
            if ($value === '') {
                continue;
            }

            $coords = $fieldCoords[$fieldKey] ?? [];
            $this->writeDmwText($pdf, (string) $value, $coords, $pageWidth, $pageHeight, $fieldKey === 'narrative');
        }

        $assistance = array_map('strtolower', $formData['assistance'] ?? []);
        $assistKeys = [
            'legal', 'medical', 'repatriation', 'rescue', 'welfare_senior', 'shipment', 'compassionate', 'food', 'transportation', 'temporary_shelter', 'others'
        ];

        foreach ($assistKeys as $option) {
            $coords = $fieldCoords['help-' . $option] ?? [];
            if (in_array($option, $assistance, true)) {
                $this->writeDmwText($pdf, 'X', $coords, $pageWidth, $pageHeight, false);
            }
        }

        // Additional single-line fields
        foreach (['civil_status', 'address_abroad', 'address_ph', 'relative_name', 'relative_relationship', 'relative_contact', 'bank_account_no', 'bank_name', 'bank_branch', 'account_name', 'signature_printed'] as $fieldKey) {
            $value = $fieldValues[$fieldKey] ?? '';
            if ($value !== '') {
                $coords = $fieldCoords[$fieldKey] ?? [];
                $this->writeDmwText($pdf, (string) $value, $coords, $pageWidth, $pageHeight, false);
            }
        }
    }

    protected function writeDmwText(\setasign\Fpdi\Fpdi $pdf, string $text, array $coords, float $pageWidth, float $pageHeight, bool $multiline = false): void
    {
        $left = (float) ($coords['left'] ?? 0);
        $top = (float) ($coords['top'] ?? 0);
        $width = (float) ($coords['width'] ?? 20);
        $fontSize = (float) ($coords['fontSize'] ?? 10);

        $x = ($pageWidth * $left) / 100;
        $y = ($pageHeight * $top) / 100;
        $w = max(10, ($pageWidth * $width) / 100);

        $pdf->SetFont('Helvetica', '', $fontSize);
        $pdf->SetXY($x, $y);

        if ($multiline) {
            $pdf->MultiCell($w, 4.5, $this->sanitizePdfText($text), 0, 'L');
            return;
        }

        $pdf->Cell($w, 4.5, $this->sanitizePdfText($text), 0, 0, 'L');
    }

    protected function sanitizePdfText(string $text): string
    {
        $clean = html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8');
        return preg_replace('/[\r\n]+/', ' ', $clean) ?? $clean;
    }

    protected function resolveDmwFieldCoords(): array
    {
        $defaults = $this->dmwFieldDefaults();
        $saved = $this->readFieldCoords();

        foreach ($saved as $key => $coords) {
            if (! isset($defaults[$key])) {
                continue;
            }

            $defaults[$key] = array_merge($defaults[$key], is_array($coords) ? $coords : []);
        }

        return $defaults;
    }

    protected function dmwFieldDefaults(): array
    {
        return [
            'name' => ['page' => 1, 'left' => 10, 'top' => 12, 'width' => 70, 'fontSize' => 12],
            'birthdate' => ['page' => 1, 'left' => 10, 'top' => 18, 'width' => 30, 'fontSize' => 10],
            'sex' => ['page' => 1, 'left' => 60, 'top' => 18, 'width' => 20, 'fontSize' => 10],
            'passport' => ['page' => 1, 'left' => 10, 'top' => 24, 'width' => 35, 'fontSize' => 10],
            'contact' => ['page' => 1, 'left' => 10, 'top' => 30, 'width' => 45, 'fontSize' => 10],
            'email' => ['page' => 1, 'left' => 10, 'top' => 34, 'width' => 55, 'fontSize' => 10],
            // employer default removed
            'contract' => ['page' => 1, 'left' => 10, 'top' => 50, 'width' => 70, 'fontSize' => 10],
            'narrative' => ['page' => 1, 'left' => 6, 'top' => 60, 'width' => 88, 'fontSize' => 10],
            'civil_status' => ['page' => 1, 'left' => 10, 'top' => 22, 'width' => 45, 'fontSize' => 10],
            'address_abroad' => ['page' => 1, 'left' => 10, 'top' => 38, 'width' => 88, 'fontSize' => 10],
            'address_ph' => ['page' => 1, 'left' => 10, 'top' => 42, 'width' => 88, 'fontSize' => 10],
            'relative_name' => ['page' => 1, 'left' => 10, 'top' => 54, 'width' => 70, 'fontSize' => 10],
            'relative_relationship' => ['page' => 1, 'left' => 10, 'top' => 58, 'width' => 40, 'fontSize' => 10],
            'relative_contact' => ['page' => 1, 'left' => 52, 'top' => 58, 'width' => 42, 'fontSize' => 10],
            'bank_account_no' => ['page' => 1, 'left' => 10, 'top' => 80, 'width' => 30, 'fontSize' => 10],
            'bank_name' => ['page' => 1, 'left' => 42, 'top' => 80, 'width' => 30, 'fontSize' => 10],
            'bank_branch' => ['page' => 1, 'left' => 74, 'top' => 80, 'width' => 20, 'fontSize' => 10],
            'account_name' => ['page' => 1, 'left' => 10, 'top' => 84, 'width' => 60, 'fontSize' => 10],
            'signature_printed' => ['page' => 1, 'left' => 10, 'top' => 90, 'width' => 50, 'fontSize' => 10],
            'help-repatriation' => ['page' => 1, 'left' => 10, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-legal' => ['page' => 1, 'left' => 28, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-medical' => ['page' => 1, 'left' => 46, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-rescue' => ['page' => 1, 'left' => 64, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-welfare_senior' => ['page' => 1, 'left' => 10, 'top' => 56, 'width' => 5, 'fontSize' => 10],
            'help-shipment' => ['page' => 1, 'left' => 28, 'top' => 56, 'width' => 5, 'fontSize' => 10],
            'help-compassionate' => ['page' => 1, 'left' => 46, 'top' => 56, 'width' => 5, 'fontSize' => 10],
            'help-food' => ['page' => 1, 'left' => 64, 'top' => 56, 'width' => 5, 'fontSize' => 10],
            'help-transportation' => ['page' => 1, 'left' => 10, 'top' => 60, 'width' => 5, 'fontSize' => 10],
            'help-temporary_shelter' => ['page' => 1, 'left' => 28, 'top' => 60, 'width' => 5, 'fontSize' => 10],
            'help-others' => ['page' => 1, 'left' => 46, 'top' => 60, 'width' => 30, 'fontSize' => 10],
        ];
    }
}
>>>>>>> 26fcc21c858b8cb66dc7c98e0ce921d300a044d2
