<?php

namespace App\Services;

use App\Models\PesoClearance;
use Illuminate\Support\Facades\Storage;

class PesoClearanceDocumentService
{
    /**
     * Copy PESO clearance template image
     */
    public function generateClearanceDocument(PesoClearance $clearance): ?string
    {
        try {
            return $this->copyClearanceTemplate($clearance);
        } catch (\Exception $e) {
            \Log::error('Failed to generate clearance document', [
                'clearance_id' => $clearance->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Copy clearance template image and store
     */
    public function copyClearanceTemplate(PesoClearance $clearance): ?string
    {
        try {
            // Ensure storage directory exists
            Storage::disk('local')->makeDirectory('peso-clearances', 0755, true);

            $templatePath = public_path('images/peso-clearance-template.jpg');

            // If template exists, copy it; otherwise create a simple placeholder
            if (file_exists($templatePath)) {
                $fileName = 'clearance-' . $clearance->id . '-' . now()->timestamp . '.jpg';
                $path = 'peso-clearances/' . $fileName;
                $templateContent = file_get_contents($templatePath);
                Storage::disk('local')->put($path, $templateContent);
            } else {
                // Create digital document
                $fileName = 'clearance-' . $clearance->id . '-' . now()->timestamp . '.txt';
                $path = 'peso-clearances/' . $fileName;
                
                $content = "================================================================================\n";
                $content .= "                         PESO CLEARANCE DOCUMENT\n";
                $content .= "================================================================================\n\n";
                $content .= "Clearance Number: " . $clearance->clearance_number . "\n";
                $content .= "Applicant: " . ($clearance->user?->name ?? 'Unknown') . "\n";
                $content .= "Status: " . ucfirst($clearance->status) . "\n";
                $content .= "Generated: " . now()->format('F d, Y \a\t h:i A') . "\n";
                $content .= "Request Date: " . ($clearance->request_date ? $clearance->request_date->format('F d, Y') : 'N/A') . "\n";
                if ($clearance->issue_date) {
                    $content .= "Issue Date: " . $clearance->issue_date->format('F d, Y') . "\n";
                }
                $content .= "Validity: " . ($clearance->validity_period ?? '1 Year') . "\n";
                $content .= "Company/Organization: " . ($clearance->company_name ?? 'N/A') . "\n";
                $content .= "\n";
                $content .= "================================================================================\n";
                $content .= "This is an official PESO Clearance document.\n";
                $content .= "For verification, please contact the Philippine Employment Service Office.\n";
                $content .= "================================================================================\n";
                
                Storage::disk('local')->put($path, $content);
            }

            return $path;
        } catch (\Exception $e) {
            \Log::error('Failed to copy clearance template', [
                'clearance_id' => $clearance->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Store clearance document path in database
     */
    public function saveClearanceDocumentPath(PesoClearance $clearance, string $documentPath): bool
    {
        try {
            $clearance->update([
                'document_path' => $documentPath,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to save document path', [
                'clearance_id' => $clearance->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get clearance document URL
     */
    public function getClearanceDocumentUrl(PesoClearance $clearance): ?string
    {
        if (!isset($clearance->document_path) || !$clearance->document_path) {
            return null;
        }

        return Storage::url($clearance->document_path);
    }

    /**
     * Download clearance document
     */
    public function downloadClearanceDocument(PesoClearance $clearance)
    {
        if (!isset($clearance->document_path) || !$clearance->document_path) {
            return null;
        }

        $fileName = 'PESO-Clearance-' . ($clearance->user?->name ?? 'Document') . '-' . now()->format('YmdHis') . '.jpg';

        return Storage::download($clearance->document_path, $fileName);
    }
}
