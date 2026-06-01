<?php

namespace App\Services;

use App\Models\PesoClearance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PesoClearanceDocumentService
{
    /**
     * Copy PESO clearance template image
     */
    public function generateClearanceDocument(PesoClearance $clearance): ?string
    {
        try {
            return $this->generatePdfDocument($clearance);
        } catch (\Exception $e) {
            Log::error('Failed to generate clearance document', [
                'clearance_id' => $clearance->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Generate PDF clearance document and store it locally.
     */
    public function generatePdfDocument(PesoClearance $clearance): ?string
    {
        try {
            // Ensure storage directory exists
            Storage::disk('local')->makeDirectory('peso-clearances', 0755, true);

            $pdf = app('dompdf.wrapper')->loadView('documents.peso-clearance-certificate', [
                'name' => $clearance->user?->name ?? 'APPLICANT NAME',
                'clearance_number' => $clearance->clearance_number ?? 'DRAFT',
                'issue_date' => $clearance->issue_date?->format('m/d/Y') ?? now()->format('m/d/Y'),
                'expiry_date' => $clearance->expiry_date?->format('m/d/Y') ?? now()->addYear()->format('m/d/Y'),
                'company_name' => $clearance->company_name ?? 'GENERAL SERVICES MULTIPURPOSE COOPERATIVE',
                'residence_address' => $clearance->residence_address ?? 'BARANGAY (LGU AREA)',
                'objective_pronoun' => 'him/her',
                'possessive_pronoun' => 'their',
            ])->setPaper('a4');

            $fileName = 'clearance-' . $clearance->id . '-' . now()->timestamp . '.pdf';
            $path = 'peso-clearances/' . $fileName;

            Storage::disk('local')->put($path, $pdf->output());

            return $path;
        } catch (\Exception $e) {
            Log::error('Failed to copy clearance template', [
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
            Log::error('Failed to save document path', [
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

        $fileName = 'PESO-Clearance-' . ($clearance->user?->name ?? 'Document') . '-' . now()->format('YmdHis') . '.pdf';

        return Storage::download($clearance->document_path, $fileName);
    }
}
