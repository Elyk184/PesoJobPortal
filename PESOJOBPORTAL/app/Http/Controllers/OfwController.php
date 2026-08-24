<?php

namespace App\Http\Controllers;

use App\Models\OfwFormSubmission;
use App\Models\OfwProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $totalSubmitted = OfwFormSubmission::query()
            ->where('user_id', $ofwUser->id)
            ->count();

        $profileSummary = [
            'name' => $profile?->resume_name ?: $ofwUser->name,
            'email' => $profile?->resume_email ?: $ofwUser->email,
            'phone' => $profile?->phone,
            'address' => $profile?->address,
        ];

        $requestStats = [
            'open' => $totalSubmitted,
            'under_review' => $totalSubmitted,
            'resolved' => 0,
        ];

        $submittedRequests = OfwFormSubmission::query()
            ->where('user_id', $ofwUser->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('ofw.dashboard', compact('ofwUser', 'profileSummary', 'requestStats', 'submittedRequests'));
    }

    public function owwaRequest()
    {
        return redirect()->route('ofw.rfa.form');
    }

    public function acceptedRequests(): View
    {
        $acceptedRequests = OfwFormSubmission::query()
            ->where('user_id', auth()->id())
            ->where('status', 'accepted')
            ->latest('accepted_at')
            ->paginate(10);

        return view('ofw.accepted-requests', compact('acceptedRequests'));
    }

    public function submittedRequests(): View
    {
        $submittedRequests = OfwFormSubmission::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('ofw.submitted-requests', compact('submittedRequests'));
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

    public function downloadRfa(Request $request): RedirectResponse
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

        $filename = 'owwa-rfa-form-' . $request->user()->id . '-' . now()->format('YmdHis') . '.pdf';
        $pdfPath = 'ofw-submissions/' . $request->user()->id . '/' . $filename;

        Storage::put($pdfPath, $pdf->output());

        OfwFormSubmission::create([
            'user_id' => $request->user()->id,
            'form_type' => 'rfa',
            'status' => 'submitted',
            'pdf_path' => $pdfPath,
            'pdf_filename' => $filename,
        ]);

        return redirect()->route('ofw.submitted-requests')
            ->with('success', 'OWWA RFA form submitted successfully. Admin can now review your PDF.');
    }

    public function downloadDmw(Request $request): RedirectResponse
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

        $pdf = Pdf::loadView('ofw.dmw-pdf', $validated)
            ->setPaper([0, 0, 595.28, 1000], 'portrait');

        $filename = 'dmw-rfa-form-' . $request->user()->id . '-' . now()->format('YmdHis') . '.pdf';
        $pdfPath = 'ofw-submissions/' . $request->user()->id . '/' . $filename;

        Storage::put($pdfPath, $pdf->output());

        OfwFormSubmission::create([
            'user_id' => $request->user()->id,
            'form_type' => 'dmw',
            'status' => 'submitted',
            'pdf_path' => $pdfPath,
            'pdf_filename' => $filename,
        ]);

        return redirect()->route('ofw.submitted-requests')
            ->with('success', 'DMW form submitted successfully. Admin can now review your PDF.');
    }

    public function downloadSubmittedRequest(OfwFormSubmission $submission, Request $request): BinaryFileResponse
    {
        abort_unless((int) $submission->user_id === (int) $request->user()->id, 403);
        abort_unless(Storage::exists($submission->pdf_path), 404);

        return Storage::download($submission->pdf_path, $submission->pdf_filename);
    }

    public function profile(Request $request): View
    {
        $ofwProfile = OfwProfile::firstOrNew(['user_id' => $request->user()->id]);

        return view('ofw.profile', compact('ofwProfile'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'          => ['nullable', 'string', 'max:100'],
            'middle_name'         => ['nullable', 'string', 'max:100'],
            'last_name'           => ['nullable', 'string', 'max:100'],
            'suffix'              => ['nullable', 'string', 'max:20'],
            'birthdate'           => ['nullable', 'date'],
            'sex'                 => ['nullable', 'in:male,female'],
            'civil_status'        => ['nullable', 'in:single,married,widow,separated,soloparent'],
            'religion'            => ['nullable', 'string', 'max:100'],
            'contact_number'      => ['nullable', 'string', 'max:50'],
            'email'               => ['nullable', 'email', 'max:255'],
            'passport_number'     => ['nullable', 'string', 'max:100'],
            'facebook_name'       => ['nullable', 'string', 'max:255'],
            'address_philippines' => ['nullable', 'string', 'max:500'],
            'address_abroad'      => ['nullable', 'string', 'max:500'],
            'employer_name'       => ['nullable', 'string', 'max:255'],
            'jobsite_country'     => ['nullable', 'string', 'max:100'],
            'monthly_salary'      => ['nullable', 'string', 'max:50'],
            'local_agency'        => ['nullable', 'string', 'max:255'],
            'foreign_agency'      => ['nullable', 'string', 'max:255'],
        ]);

        OfwProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return redirect()->route('ofw.profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function deleteSubmittedRequest(OfwFormSubmission $submission, Request $request): RedirectResponse
    {
        abort_unless((int) $submission->user_id === (int) $request->user()->id, 403);

        if (Storage::exists($submission->pdf_path)) {
            Storage::delete($submission->pdf_path);
        }

        $submission->delete();

        return redirect()->route('ofw.submitted-requests')
            ->with('success', 'Request has been deleted successfully.');
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
