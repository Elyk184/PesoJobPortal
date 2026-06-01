<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesoJob;
use App\Models\JobApplication;

class WelcomeController extends Controller
{
    public function index()
    {
        $jobSeekers = User::where('role', 'jobseeker')->count();
        $employers = User::where('role', 'employer')->count();
        $jobsPosted = PesoJob::count();

        $totalApplications = JobApplication::count();
        $hired = JobApplication::where('status', 'hired')->count();
        $placementRate = $totalApplications > 0 ? (int) round(($hired / $totalApplications) * 100) : 0;

        return view('welcome', compact('jobSeekers', 'employers', 'jobsPosted', 'placementRate'));
    }
}
