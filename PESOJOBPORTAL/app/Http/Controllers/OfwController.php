<?php

namespace App\Http\Controllers;

use App\Models\OfwRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfwController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('dashboard.ofw', $this->dashboardData($request));
    }

    public function acceptedRequests(Request $request): View
    {
        return view('dashboard.ofw.accepted-requests', $this->dashboardData($request));
    }

    public function owwaRequest(Request $request): View
    {
        return view('dashboard.ofw.owwa-request', $this->dashboardData($request));
    }

    public function submittedRequests(Request $request): View
    {
        return view('dashboard.ofw.submitted-requests', $this->dashboardData($request));
    }

    private function dashboardData(Request $request): array
    {
        $ofwUser = $request->user()->loadMissing('profile');
        $ofwProfile = $ofwUser->profile;
        $requestQuery = OfwRequest::query()->where('user_id', $ofwUser->id);

        return [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
            'submittedRequests' => (clone $requestQuery)
                ->latest()
                ->take(6)
                ->get(),
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
        ];
    }
}
