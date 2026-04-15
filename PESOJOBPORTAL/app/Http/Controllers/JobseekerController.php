<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class JobseekerController extends Controller
{
    public function dashboard(): View
    {
        return view('jobseeker.dashboard');
    }

    public function vacancies(): View
    {
        return view('jobseeker.vacancies');
    }

    public function applications(): View
    {
        return view('jobseeker.applications');
    }

    public function profile(): View
    {
        return view('jobseeker.profile');
    }
}
