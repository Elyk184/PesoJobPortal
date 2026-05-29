<?php

namespace App\Http\Controllers;

use App\Models\OfwRequest;
use App\Models\PortalNotification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

// Optional runtime dependencies (FPDI / Imagick)
// FPDI will be referenced dynamically to avoid parse-time dependency errors if not installed

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
            Log::warning('Failed to read DMW attachments for user '.$ofwUser->id.': '.$e->getMessage());
            $rawAttachments = [];
        }

        $dmwAttachments = collect($rawAttachments)->map(fn($p) => asset('storage/'.$p))->values()->all();

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

        return view('ofw.dmwbuilder', [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
        ]);
    }

    public function saveDmwBuilder(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'passport_number' => ['required', 'string', 'max:100'],
            'employer' => ['required', 'string', 'max:255'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'request_details' => ['required', 'string', 'max:2000'],
            'assistance' => ['nullable', 'array'],
            'signature_date' => ['required', 'date'],
        ]);

        // Save draft to session for now. Integration with persistent storage can be added later.
        $request->session()->put('dmw_form_draft', $validated);

        // Handle attachments if provided
        if ($request->hasFile('attachments')) {
            $this->storeOfwAttachments($request, $request->file('attachments'));
        }

        return redirect()->route('ofw.dmw-builder')->with('status', 'Form draft saved. Use Download PDF to generate the document.');
    }

    public function submitDmwForm(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'passport_number' => ['required', 'string', 'max:100'],
            'employer' => ['required', 'string', 'max:255'],
            'contract_start' => ['nullable', 'date'],
            'contract_end' => ['nullable', 'date'],
            'request_details' => ['required', 'string', 'max:2000'],
            'assistance' => ['nullable', 'array'],
            'signature_date' => ['required', 'date'],
        ]);

        $user = $request->user();

        // read attachments metadata for this user
        $attachments = $this->readAttachments($user->id);

        // create OFW request record
        $ofw = OfwRequest::create([
            'user_id' => $user->id,
            'subject' => 'DMW Request for Assistance',
            'details' => $validated['request_details'],
            'status' => 'open',
            'notes' => json_encode([
                'form' => $validated,
                'attachments' => $attachments,
            ]),
        ]);

        // notify admins via PortalNotification + UserNotification
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
                \App\Models\UserNotification::create([
                    'user_id' => $admin->id,
                    'portal_notification_id' => $portal->id,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to notify admins for DMW submission: ' . $e->getMessage());
        }

        return redirect()->route('ofw.dashboard')->with('status', 'DMW request submitted to admin.');
    }

    protected function attachmentsMetaPath(int $userId): string
    {
        return storage_path("app/ofw_attachments/{$userId}.json");
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
        $stored = $this->readAttachments($user->id);

        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store("public/ofw_attachments/{$user->id}");
            // store relative path (without leading 'public/')
            $rel = preg_replace('#^public/#', '', $path);
            $stored[] = $rel;
        }

        $this->writeAttachments($user->id, $stored);
        return $stored;
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'attachment' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $files = $this->storeOfwAttachments($request, [$request->file('attachment')]);

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

        // delete file from storage
        $full = storage_path('app/public/' . $path);
        if (file_exists($full)) {
            @unlink($full);
        }

        array_splice($stored, $index, 1);
        $this->writeAttachments($user->id, $stored);

        return redirect()->back()->with('status', 'Attachment removed.');
    }

    /**
     * Download the DMW form PDF with user's attachments appended (resume if present).
     * Requires: public/forms/DMW REQUEST FOR ASSISTANCE FORM.pdf to exist.
     * Composer packages recommended: setasign/fpdi, setasign/fpdf. Imagick PHP extension
     * is used to convert image attachments to PDF when necessary.
     */
    public function downloadDmwForm(Request $request)
    {
        $user = $request->user();
        $profile = $user?->profile;

        $mainForm = public_path('forms/DMW REQUEST FOR ASSISTANCE FORM.pdf');
        if (! file_exists($mainForm)) {
            Log::error('DMW form PDF not found: ' . $mainForm);
            abort(404, 'Form template not found.');
        }

        // Prepare temp directory
        $tmpDir = storage_path('app/tmp/ofw_forms');
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $pdfFiles = [$mainForm];

        // Append user's resume if available (stored in profile->resume_path)
        if ($profile && ! empty($profile->resume_path)) {
            $resumePath = storage_path('app/public/' . ltrim($profile->resume_path, '/'));
            if (file_exists($resumePath)) {
                $pdfFiles[] = $resumePath;
            }
        }

        // Convert any non-pdf files to pdf (Imagick) and collect final list
        $converted = [];
        foreach ($pdfFiles as $path) {
            $lower = Str::lower($path);
            if (Str::endsWith($lower, '.pdf')) {
                $converted[] = $path;
                continue;
            }

            if (! extension_loaded('imagick') || ! class_exists('\\Imagick')) {
                Log::warning('Imagick not available — skipping non-PDF attachment: ' . $path);
                continue;
            }

            try {
                $out = $tmpDir . '/' . basename($path) . '.pdf';
                $im = new \Imagick();
                $im->setResolution(150, 150);
                $im->readImage($path);
                $im->setImageFormat('pdf');
                $im->writeImages($out, true);
                $im->clear();
                $im->destroy();
                $converted[] = $out;
            } catch (\Throwable $e) {
                Log::error('Failed to convert attachment to PDF: ' . $e->getMessage());
            }
        }

        // If FPDI isn't available, fall back to delivering the main form only
        $fpdiClass = '\\setasign\\Fpdi\\Fpdi';
        if (! class_exists($fpdiClass)) {
            Log::warning('FPDI not installed; serving main form only.');
            return response()->download($mainForm, 'DMW_REQUEST_FOR_ASSISTANCE.pdf');
        }

        // Merge PDFs using FPDI
        try {
            $fpdi = new $fpdiClass();
        } catch (\Throwable $e) {
            Log::error('Failed to instantiate FPDI: ' . $e->getMessage());
            return response()->download($mainForm, 'DMW_REQUEST_FOR_ASSISTANCE.pdf');
        }
        foreach ($converted as $file) {
            try {
                $pageCount = $fpdi->setSourceFile($file);
            } catch (\Throwable $e) {
                Log::error('FPDI setSourceFile failed for ' . $file . ': ' . $e->getMessage());
                continue;
            }

            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($tpl);
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($tpl);
            }
        }

        $mergedPath = $tmpDir . '/dmw_merged_' . $user->id . '_' . time() . '.pdf';
        $fpdi->Output($mergedPath, 'F');

        return response()->download($mergedPath, 'DMW_REQUEST_FOR_ASSISTANCE.pdf')->deleteFileAfterSend(true);
    }
}