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
        return view('ofw.dmw-simple');
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
            'contract_name' => $request->file('contract')?->getClientOriginalName(),
            'passport_name' => $request->file('passport')?->getClientOriginalName(),
            'generated_at' => now('Asia/Manila'),
            'case_labels' => collect($request->input('nature_of_case', []))
                ->map(fn ($case) => self::RFA_CASE_OPTIONS[$case] ?? ucfirst(str_replace('_', ' ', $case)))
                ->values()
                ->all(),
        ]);

        $pdf = Pdf::loadView('ofw.rfa-form-pdf', $data)->setPaper('a4');

        return $pdf->download('owwa-rfa-form.pdf');
    }

    public function downloadDmw(Request $request)
    {
        return back()->with('error', 'OFW DMW download is not configured yet.');
    }
}