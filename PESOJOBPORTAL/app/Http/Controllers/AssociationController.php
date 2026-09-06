<?php

namespace App\Http\Controllers;

use App\Models\AssociationProfile;
use App\Models\AssociationRequest;
use App\Models\PortalNotification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AssociationController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('dashboard.association.dashboard', $this->dashboardData($request));
    }

    public function submittedRequests(Request $request): View
    {
        return view('dashboard.association.submitted-requests', $this->dashboardData($request));
    }

    public function acceptedRequests(Request $request): View
    {
        $data = $this->dashboardData($request);
        $data['acceptedRequests'] = AssociationRequest::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'accepted')
            ->latest()
            ->get();
        return view('dashboard.association.accepted-requests', $data);
    }

    public function registrationForm(Request $request): View
    {
        return view('dashboard.association.registration-form', $this->dashboardData($request));
    }

    public function profile(Request $request): View
    {
        $data = $this->dashboardData($request);
        $data['associationProfile'] = AssociationProfile::firstOrNew(['user_id' => $request->user()->id]);
        return view('dashboard.association.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'association_name' => ['nullable', 'string', 'max:255'],
            'contact_person'   => ['nullable', 'string', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'email'            => ['nullable', 'email', 'max:255'],
            'address'          => ['nullable', 'string', 'max:500'],
        ]);

        $profile = AssociationProfile::firstOrNew(['user_id' => $request->user()->id]);
        $profile->fill($validated)->save();

        return redirect()->route('association.profile')->with('status', 'Profile updated successfully.');
    }

    private function dashboardData(Request $request): array
    {
        $associationUser = $request->user()->loadMissing('associationProfile');
        $associationProfile = $associationUser->associationProfile;
        $requestQuery = AssociationRequest::query()->where('user_id', $associationUser->id);

        return [
            'associationUser' => $associationUser,
            'associationProfile' => $associationProfile,
            'submittedRequests' => (clone $requestQuery)->latest()->take(6)->get(),
            'requestStats' => [
                'open' => (clone $requestQuery)->where('status', 'open')->count(),
                'under_review' => (clone $requestQuery)->where('status', 'under_review')->count(),
                'resolved' => (clone $requestQuery)->where('status', 'resolved')->count(),
            ],
            'profileSummary' => [
                'name'    => $associationProfile?->association_name ?? $associationUser->name,
                'email'   => $associationProfile?->email ?? $associationUser->email,
                'phone'   => $associationProfile?->phone,
                'address' => $associationProfile?->address,
            ],
        ];
    }

    public function submitRegistration(Request $request)
    {
        $validated = $request->validate([
            'association_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'president_last_name' => ['required', 'string', 'max:100'],
            'president_first_name' => ['required', 'string', 'max:100'],
            'president_middle_name' => ['nullable', 'string', 'max:100'],
            'president_address' => ['required', 'string', 'max:500'],
            'contact_no' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'date_organized' => ['required', 'date'],
            'date_cbl_ratification' => ['nullable', 'date'],
            'place_of_operation' => ['required', 'string', 'max:500'],
            'male_members' => ['required', 'integer', 'min:0'],
            'female_members' => ['required', 'integer', 'min:0'],
            'total_members' => ['required', 'integer', 'min:0'],
            'occupation' => ['required', 'array'],
            'occupation_other_text' => ['nullable', 'string', 'max:255'],
            'declaration' => ['accepted'],
            'president_signature' => ['required', 'string', 'max:255'],
            'signature_location' => ['nullable', 'string', 'max:255'],
            'signature_date' => ['nullable', 'date'],
            'id_no' => ['nullable', 'string', 'max:100'],
            'constitution_document' => ['nullable', 'file', 'max:10240'],
            'financial_report' => ['nullable', 'file', 'max:10240'],
            'additional_documents.*' => ['nullable', 'file', 'max:10240'],
        ]);

        $user = $request->user();
        $documents = [];

        if ($request->hasFile('constitution_document')) {
            $documents['constitution'] = $request->file('constitution_document')->store("association_registration/{$user->id}", 'public');
        }

        if ($request->hasFile('financial_report')) {
            $documents['financial_report'] = $request->file('financial_report')->store("association_registration/{$user->id}", 'public');
        }

        if ($request->hasFile('additional_documents')) {
            $additionalDocs = [];
            foreach ($request->file('additional_documents') as $file) {
                $additionalDocs[] = $file->store("association_registration/{$user->id}", 'public');
            }
            $documents['additional'] = $additionalDocs;
        }

        $presidentName = trim($validated['president_first_name'] . ' ' . ($validated['president_middle_name'] ?? '') . ' ' . $validated['president_last_name']);

        AssociationRequest::create([
            'user_id' => $user->id,
            'subject' => "Application for Registration of Worker's Association",
            'details' => 'Registration application for ' . $validated['association_name'],
            'association_name' => $validated['association_name'],
            'contact_person' => $presidentName,
            'contact_number' => $validated['contact_no'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'request_type' => 'Association Registration',
            'document_path' => $documents['constitution'] ?? null,
            'status' => 'open',
            'notes' => ['registration_data' => $validated, 'documents' => $documents],
        ]);

        try {
            $portal = PortalNotification::create([
                'title' => 'New Association Registration Application from ' . $validated['association_name'],
                'message' => "Worker's Association registration submitted for review.",
                'created_by' => $user->id,
            ]);

            \App\Models\User::where('role', 'admin')->get()->each(function ($admin) use ($portal) {
                UserNotification::create(['user_id' => $admin->id, 'portal_notification_id' => $portal->id]);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to notify admins for Association Registration: ' . $e->getMessage());
        }

        return redirect()->route('association.dashboard')
            ->with('status', "Worker's Association registration application submitted successfully.");
    }
}
