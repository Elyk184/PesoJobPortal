<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfwController extends Controller
{
    private const RFA_CASE_OPTIONS = [
        'legal' => 'Legal Assistance',
        'medical' => 'Medical Assistance',
        'repatriation' => 'Repatriation',
        'rescue' => 'Rescue / Evacuation',
        'welfare' => 'Welfare Assistance for Senior OFW Returnees',
        'compassionate' => 'Compassionate Visit',
        'shipment' => 'Shipment of Human Remains / Cremains',
        'food' => 'Food Assistance',
        'transportation' => 'Transportation Assistance',
        'shelter' => 'Temporary Shelter',
        'others' => 'Others',
    ];

    public function dashboard(Request $request): View
    {
        $ofwUser = $request->user()->loadMissing('profile');
        $profile = $ofwUser->profile;

        $profileSummary = [
            'name' => $profile?->resume_name ?: $ofwUser->name,
            'email' => $profile?->resume_email ?: $ofwUser->email,
            'phone' => $profile?->phone,
            'address' => $profile?->address,
        ];

        $requestStats = [
            'open' => 0,
            'under_review' => 0,
            'resolved' => 0,
        ];

        $submittedRequests = collect();

        return view('ofw.dashboard', compact('ofwUser', 'profileSummary', 'requestStats', 'submittedRequests'));
    }

    public function owwaRequest()
    {
        return redirect()->route('ofw.rfa.form');
    }

    public function acceptedRequests(): View
    {
        return view('ofw.placeholder', [
            'pageTitle' => 'Accepted Requests',
            'heading' => 'Accepted Requests',
            'message' => 'This section will show OFW requests that have been accepted for processing.',
        ]);
    }

    public function submittedRequests(): View
    {
        return view('ofw.placeholder', [
            'pageTitle' => 'Submitted Requests',
            'heading' => 'Submitted Requests',
            'message' => 'This section will list the requests you have submitted.',
        ]);
    }

    public function dmwBuilder(): View
    {
        return view('ofw.dmwbuilder');
    }

    public function rfaForm(): View
    {
        return view('ofw.rfa-form', [
            'caseOptions' => self::RFA_CASE_OPTIONS,
        ]);
    }

    public function downloadRfa(Request $request)
    {
        $validated = $request->validate([
            'e_cares_ticket_number' => ['nullable', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'nature_of_case' => ['nullable', 'array'],
            'nature_of_case.*' => ['string', 'max:50'],
            'nature_of_case_other' => ['nullable', 'string', 'max:255'],
            'ofw_first' => ['nullable', 'string', 'max:255'],
            'ofw_middle' => ['nullable', 'string', 'max:255'],
            'ofw_last' => ['nullable', 'string', 'max:255'],
            'contact_no' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:255'],
            'sex' => ['nullable', 'string', 'max:100'],
            'birthdate' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'string', 'max:50'],
            'civil_status' => ['nullable', 'string', 'max:100'],
            'facebook_name' => ['nullable', 'string', 'max:255'],
            'highest_education' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:255'],
            'children_count' => ['nullable', 'string', 'max:50'],
            'employer_name' => ['nullable', 'string', 'max:255'],
            'jobsite' => ['nullable', 'string', 'max:255'],
            'tel_fax' => ['nullable', 'string', 'max:100'],
            'monthly_salary' => ['nullable', 'string', 'max:100'],
            'foreign_recruitment_agency' => ['nullable', 'string', 'max:255'],
            'agency_address_tel' => ['nullable', 'string', 'max:255'],
            'local_agency' => ['nullable', 'string', 'max:255'],
            'latest_departure' => ['nullable', 'string', 'max:100'],
            'previous_employment_country' => ['nullable', 'string', 'max:255'],
            'death_date' => ['nullable', 'string', 'max:100'],
            'death_cause' => ['nullable', 'string', 'max:255'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'facts_of_case' => ['nullable', 'string'],
            'requesting_party' => ['nullable', 'string', 'max:255'],
            'relationship_to_ofw' => ['nullable', 'string', 'max:255'],
            'complete_address' => ['nullable', 'string', 'max:255'],
            'phone_email' => ['nullable', 'string', 'max:255'],
            'contract' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
            'passport' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $data = array_merge($validated, [
            'nature_of_case' => $request->input('nature_of_case', []),
            'case_options' => self::RFA_CASE_OPTIONS,
            'contract_name' => $request->file('contract')?->getClientOriginalName(),
            'passport_name' => $request->file('passport')?->getClientOriginalName(),
            'owwa_logo' => $this->publicImageDataUri('images/owwa.png'),
            'contract_image' => $this->imageDataUri($request->file('contract')),
            'passport_image' => $this->imageDataUri($request->file('passport')),
            'generated_at' => now('Asia/Manila'),
            'case_labels' => collect($request->input('nature_of_case', []))
                ->map(fn ($case) => self::RFA_CASE_OPTIONS[$case] ?? ucfirst(str_replace('_', ' ', $case)))
                ->values()
                ->all(),
        ]);

        $pdf = Pdf::loadView('ofw.rfa-form-pdf', $data)
            ->setPaper([0, 0, 595.28, 1000], 'portrait');

        return $pdf->download('owwa-rfa-form.pdf');
    }

    public function downloadDmw(Request $request)
    {
        $validated = $request->validate([
            'mode' => ['nullable', 'array'],
            'mode.*' => ['string', 'in:online,walkin,referral'],
            'referral_by' => ['nullable', 'string', 'max:255'],
            'ofw_lastname' => ['nullable', 'string', 'max:255'],
            'ofw_firstname' => ['nullable', 'string', 'max:255'],
            'ofw_middlename' => ['nullable', 'string', 'max:255'],
            'ofw_birthdate' => ['nullable', 'date'],
            'ofw_sex' => ['nullable', 'string', 'in:male,female'],
            'civil_status' => ['nullable', 'array'],
            'civil_status.*' => ['string', 'in:single,married,widow,separated,soloparent'],
            'ofw_passport' => ['nullable', 'string', 'max:255'],
            'ofw_address_abroad' => ['nullable', 'string', 'max:1000'],
            'ofw_address_ph' => ['nullable', 'string', 'max:1000'],
            'ofw_contact' => ['nullable', 'string', 'max:255'],
            'ofw_email' => ['nullable', 'string', 'max:255'],
            'fam_lastname' => ['nullable', 'string', 'max:255'],
            'fam_firstname' => ['nullable', 'string', 'max:255'],
            'fam_middlename' => ['nullable', 'string', 'max:255'],
            'fam_birthdate' => ['nullable', 'date'],
            'relationship' => ['nullable', 'array'],
            'relationship.*' => ['string', 'in:spouse,child,sibling,others'],
            'relationship_others' => ['nullable', 'string', 'max:255'],
            'fam_id' => ['nullable', 'string', 'max:255'],
            'fam_address' => ['nullable', 'string', 'max:1000'],
            'fam_contact' => ['nullable', 'string', 'max:255'],
            'fam_email' => ['nullable', 'string', 'max:255'],
            'assistance' => ['nullable', 'array'],
            'assistance.*' => ['string', 'in:legal,medical,repatriation,rescue,welfare,compassionate,shipment,food,transportation,shelter,others'],
            'assistance_others' => ['nullable', 'string', 'max:255'],
            'narrative' => ['nullable', 'string', 'max:10000'],
            'has_bank' => ['nullable', 'boolean'],
            'bank_account_no' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'contract' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'passport' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        $validated['mode'] = $request->input('mode', []);
        $validated['civil_status'] = $request->input('civil_status', []);
        $validated['relationship'] = $request->input('relationship', []);
        $validated['assistance'] = $request->input('assistance', []);
        $validated['contract_image'] = $this->imageDataUri($request->file('contract'));
        $validated['passport_image'] = $this->imageDataUri($request->file('passport'));
        $validated['owwa_logo'] = $this->publicImageDataUri('images/owwa.png');
        $validated['bagong_logo'] = $this->publicImageDataUri('images/Logo-Bagong-Pilipinas.png');
        $validated['generated_at'] = now('Asia/Manila');

        return Pdf::loadView('ofw.dmw-pdf', $validated)
            ->setPaper('a4', 'portrait')
            ->download('dmw-request-for-assistance.pdf');
    }

    private function imageDataUri(?\Illuminate\Http\UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        return 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->getContent());
    }

    private function publicImageDataUri(string $relativePath): ?string
    {
        $path = public_path($relativePath);

        if (!is_file($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }
}