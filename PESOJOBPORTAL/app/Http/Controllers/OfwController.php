<?php

namespace App\Http\Controllers;

use App\Models\OfwRequest;
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
        ]);
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