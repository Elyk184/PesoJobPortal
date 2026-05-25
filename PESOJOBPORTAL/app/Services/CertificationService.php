<?php

namespace App\Services;

use App\Models\RecruitmentActivityRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificationService
{
    /**
     * Generate a certification for an LRA/SRA request and save it as PDF
     */
    public function generateCertification(RecruitmentActivityRequest $activityRequest, User $admin): string
    {
        $type = strtoupper($activityRequest->activity_type);
        $employer = $activityRequest->employer;

        // Generate unique certification number
        $certNumber = $this->generateCertificationNumber($activityRequest);

        // Prepare data for PDF
        $data = [
            'cert_number' => $certNumber,
            'type' => $type,
            'type_full' => $type === 'LRA' ? 'Local Recruitment Activity' : 'Special Recruitment Activity',
            'employer_name' => $employer->name ?? 'Unknown',
            'company_profile' => $employer->companyProfile,
            'activity_request' => $activityRequest,
            'generated_date' => now(),
            'generated_by' => $admin->name,
            'issue_date' => now()->format('F d, Y'),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('admin.certifications.certification-pdf', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 20)
            ->setOption('margin-right', 15)
            ->setOption('margin-bottom', 20)
            ->setOption('margin-left', 15);

        // Save PDF to storage
        $filename = sprintf(
            '%s_CERTIFICATION_%s_%s.pdf',
            strtoupper($activityRequest->activity_type),
            $certNumber,
            now()->format('Ymdhis')
        );

        $path = sprintf('certifications/%s', $filename);
        Storage::disk('public')->put($path, $pdf->output());

        // Update the activity request with certification details
        $activityRequest->update([
            'certification_path' => $path,
            'certification_generated_at' => now(),
            'certification_generated_by' => $admin->id,
        ]);

        return $path;
    }

    /**
     * Generate a unique certification number
     */
    private function generateCertificationNumber(RecruitmentActivityRequest $activityRequest): string
    {
        $type = strtoupper($activityRequest->activity_type) === 'LRA' ? 'LRA' : 'SRA';
        $year = now()->format('Y');
        $id = str_pad($activityRequest->id, 5, '0', STR_PAD_LEFT);

        return sprintf('%s-%s-%s', $type, $year, $id);
    }

    /**
     * Check if certification exists for the request
     */
    public function hasCertification(RecruitmentActivityRequest $activityRequest): bool
    {
        return !empty($activityRequest->certification_path) &&
               Storage::disk('public')->exists($activityRequest->certification_path);
    }

    /**
     * Get certification file path or null
     */
    public function getCertificationPath(RecruitmentActivityRequest $activityRequest): ?string
    {
        if ($this->hasCertification($activityRequest)) {
            return $activityRequest->certification_path;
        }

        return null;
    }

    /**
     * Download certification file
     */
    public function downloadCertification(RecruitmentActivityRequest $activityRequest)
    {
        $path = $this->getCertificationPath($activityRequest);

        if (!$path) {
            throw new \Exception('Certification not found for this request.');
        }

        $filename = sprintf(
            '%s_Certification_%s.pdf',
            strtoupper($activityRequest->activity_type),
            $activityRequest->id
        );

        return Storage::disk('public')->download($path, $filename);
    }

    /**
     * View/stream certification file inline for preview
     */
    public function viewCertification(RecruitmentActivityRequest $activityRequest)
    {
        $path = $this->getCertificationPath($activityRequest);

        if (!$path) {
            throw new \Exception('Certification not found for this request.');
        }

        return response()->file(Storage::disk('public')->path($path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certification.pdf"',
        ]);
    }
}
