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

        return view('dashboard.ofw', [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
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
        $validated = $this->validateDmwRequest($request);
        $request->session()->put('dmw_form_draft', $validated);

        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
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
        $validated = $this->validateDmwRequest($request);
        $user = $request->user();

        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        $attachments = $this->readAttachments($user->id);
        $draft = array_merge($request->session()->get('dmw_form_draft', []), $validated);
        $request->session()->put('dmw_form_draft', $draft);

        return $this->renderDmwPdf($user->id, $draft, $attachments);
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:102400'],
        ]);

        $this->storeOfwAttachments($request, [$request->file('attachment')]);

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
            'applicant_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'sex' => ['nullable', 'in:male,female'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'passport_number' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:1000'],
            'employer' => ['required', 'string', 'max:255'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'request_details' => ['required', 'string', 'max:2000'],
            'assistance' => ['required', 'array', 'min:1'],
            'assistance.*' => ['string', 'in:repatriation,legal,medical'],
            'signature_date' => ['required', 'date'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png', 'max:102400'],
        ]);

        $incomingAttachments = $request->file('attachments', []);
        $incomingAttachments = is_array($incomingAttachments) ? array_values(array_filter($incomingAttachments)) : [];

        if ($incomingAttachments !== []) {
            $this->assertAttachmentLimits($request->user()->id, $incomingAttachments);
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

            $path = $file->store("public/ofw_attachments/{$user->id}");
            $rel = preg_replace('#^public/#', '', $path);
            $stored[] = $rel;
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

            $attachmentPdf = $this->attachmentImageToPdf($attachmentFullPath, $tmpDir, $userId, $index);
            if (! $attachmentPdf) {
                continue;
            }

            try {
                $pageCount = $fpdi->setSourceFile($attachmentPdf);
                for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                    $templateId = $fpdi->importPage($pageNumber);
                    $size = $fpdi->getTemplateSize($templateId);
                    $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                    $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                    $fpdi->useTemplate($templateId);
                }
            } catch (\Throwable $e) {
                Log::error('Failed appending attachment page ' . $attachmentPdf . ': ' . $e->getMessage());
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
            'employer' => $formData['employer'] ?? '',
            'contract' => trim(implode(' to ', array_filter([
                $formData['contract_start'] ?? '',
                $formData['contract_end'] ?? '',
            ]))),
            'narrative' => $formData['request_details'] ?? '',
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
        foreach (['repatriation', 'legal', 'medical'] as $option) {
            $coords = $fieldCoords['help-' . $option] ?? [];
            if (in_array($option, $assistance, true)) {
                $this->writeDmwText($pdf, 'X', $coords, $pageWidth, $pageHeight, false);
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
            'employer' => ['page' => 1, 'left' => 10, 'top' => 46, 'width' => 70, 'fontSize' => 10],
            'contract' => ['page' => 1, 'left' => 10, 'top' => 50, 'width' => 70, 'fontSize' => 10],
            'narrative' => ['page' => 1, 'left' => 6, 'top' => 60, 'width' => 88, 'fontSize' => 10],
            'help-repatriation' => ['page' => 1, 'left' => 10, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-legal' => ['page' => 1, 'left' => 28, 'top' => 52, 'width' => 5, 'fontSize' => 10],
            'help-medical' => ['page' => 1, 'left' => 46, 'top' => 52, 'width' => 5, 'fontSize' => 10],
        ];
    }
}