<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OfwController extends Controller
{
    public function dashboard(Request $request): View
    {
        $ofwUser = $request->user()->loadMissing('profile');
        $ofwProfile = $ofwUser->profile;

        return view('dashboard.ofw', [
            'ofwUser' => $ofwUser,
            'ofwProfile' => $ofwProfile,
            'profileSummary' => [
                'name' => $ofwProfile?->personal_information['first_name'] ?? $ofwUser->name,
                'email' => $ofwProfile?->personal_information['email_address'] ?? $ofwUser->email,
                'phone' => $ofwProfile?->phone ?? $ofwProfile?->personal_information['contact_number'] ?? null,
                'address' => $ofwProfile?->address ?? $ofwProfile?->present_address['municipality'] ?? null,
            ],
        ]);
    }
}