<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RfaController extends Controller
{
    private const DEFAULT_CONTRACT_PATH = 'attachments/contract.pdf';
    private const DEFAULT_PASSPORT_PATH = 'attachments/passport.jpg';

    public function create(): View
    {
        return view('rfa.form', [
            'caseOptions' => $this->caseOptions(),
        ]);
    }

    public function download(Request $request): Response|RedirectResponse
    {
        $validated = $request->validate([
            'e_cares_ticket_number' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date'],
            'nature_of_case' => ['nullable', 'array'],
            'nature_of_case.*' => ['string', 'max:100'],
            'nature_of_case_other' => ['nullable', 'string', 'max:255'],
            'ofw_first' => ['nullable', 'string', 'max:100'],
            'ofw_middle' => ['nullable', 'string', 'max:100'],
            'ofw_last' => ['nullable', 'string', 'max:100'],
            'contact_no' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:150'],
            'sex' => ['nullable', 'string', 'max:50'],
            'birthdate' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'string', 'max:20'],
            'civil_status' => ['nullable', 'string', 'max:50'],
            'facebook_name' => ['nullable', 'string', 'max:150'],
            'highest_education' => ['nullable', 'string', 'max:150'],
            'religion' => ['nullable', 'string', 'max:100'],
            'children_count' => ['nullable', 'string', 'max:20'],
            'employer_name' => ['nullable', 'string', 'max:150'],
            'jobsite' => ['nullable', 'string', 'max:150'],
            'tel_fax' => ['nullable', 'string', 'max:100'],
            'monthly_salary' => ['nullable', 'string', 'max:100'],
            'foreign_recruitment_agency' => ['nullable', 'string', 'max:150'],
            'agency_address_tel' => ['nullable', 'string', 'max:200'],
            'local_agency' => ['nullable', 'string', 'max:150'],
            'latest_departure' => ['nullable', 'string', 'max:100'],
            'previous_employment_country' => ['nullable', 'string', 'max:100'],
            'death_date' => ['nullable', 'string', 'max:50'],
            'death_cause' => ['nullable', 'string', 'max:150'],
            'death_place' => ['nullable', 'string', 'max:150'],
            'facts_of_case' => ['nullable', 'string', 'max:2000'],
            'requesting_party' => ['nullable', 'string', 'max:150'],
            'relationship_to_ofw' => ['nullable', 'string', 'max:100'],
            'complete_address' => ['nullable', 'string', 'max:200'],
            'phone_email' => ['nullable', 'string', 'max:150'],
            'contract_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'passport' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        try {
            $attachments = [];

            foreach (['contract', 'passport'] as $field) {
                $file = $request->file($field);

                if ($file && $file->isValid()) {
                    $mime = $file->getMimeType(); // e.g. image/jpeg, application/pdf
                    $isImage = str_starts_with($mime, 'image/');
                    $dataUri = null;

                    if ($isImage) {
                        $binary = file_get_contents($file->getRealPath());
                        $b64 = base64_encode($binary);
                        $dataUri = "data:{$mime};base64,{$b64}";
                    }

                    $attachments[$field] = [
                        'available' => true,
                        'is_image' => $isImage,
                        'filename' => $file->getClientOriginalName(),
                        'data_uri' => $dataUri, // null for PDFs (can't render inline in DOMPDF)
                    ];
                } else {
                    $attachments[$field] = [
                        'available' => false,
                        'is_image' => false,
                        'filename' => null,
                        'data_uri' => null,
                    ];
                }
            }

            $data = array_merge($validated, [
                'caseOptions' => $this->caseOptions(),
                'caseSelections' => $validated['nature_of_case'] ?? [],
                'page1Background' => public_path('images/rfa.png'),
                'attachments' => [
                    'contract' => $attachments['contract'],
                    'passport' => $attachments['passport'],
                ],
            ]);

            $pdf = Pdf::loadView('rfa.pdf', $data)
                ->setPaper('legal', 'portrait');

            return $pdf->download('rfa.pdf');
        } catch (Throwable $exception) {
            Log::error('RFA PDF export failed.', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('rfa.form')
                ->withErrors(['rfa_export' => 'Unable to export PDF right now. Please try again.']);
        }
    }

    private function caseOptions(): array
    {
        return [
            'maltreatment_mistreatment' => 'Maltreatment / Mistreatment',
            'sexual_abuse_raped' => 'Sexual Abuse / Raped',
            'poor_working_living_condition' => 'Poor Working / Living Condition',
            'delayed_unpaid_salary' => 'Delayed / Unpaid Salary',
            'contract_violation_substitution' => 'Contract Violation / Substitution',
            'airport_assistance' => 'Airport Assistance',
            'health_medical_problems' => 'Health / Medical Problems',
            'personal_problems' => 'Personal Problems',
            'immigration_problems' => 'Immigration Problems',
            'stranded' => 'Stranded',
            'money_claims_insurance_benefits' => 'Money Claims / Insurance / Benefits',
            'whereabouts_verify_condition' => 'Whereabouts / Verify Condition',
            'delayed_non_remittance' => 'Delayed / Non-remittance',
        ];
    }

    private function storeOrDefault(Request $request, string $field, string $defaultPath): ?string
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store('attachments');
        }

        return Storage::disk('local')->exists($defaultPath) ? $defaultPath : null;
    }

    private function buildAttachmentData(?string $path, string $label): array
    {
        if ($path === null) {
            return [
                'label' => $label,
                'available' => false,
            ];
        }

        $fullPath = Storage::disk('local')->path($path);
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png'], true);
        $dataUri = null;

        if ($isImage && is_file($fullPath)) {
            $mime = $extension === 'jpg' ? 'image/jpeg' : 'image/' . $extension;
            $dataUri = 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($fullPath));
        }

        return [
            'label' => $label,
            'available' => is_file($fullPath),
            'is_image' => $isImage,
            'is_pdf' => $extension === 'pdf',
            'filename' => basename($fullPath),
            'data_uri' => $dataUri,
            'path' => $fullPath,
        ];
    }
}
