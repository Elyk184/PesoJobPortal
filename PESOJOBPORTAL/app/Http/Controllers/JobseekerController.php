<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class JobseekerController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard.jobseeker');
    }

    public function vacancies(): View
    {
        return view('dashboard.jobseeker');
    }

    public function applications(): View
    {
        return view('dashboard.jobseeker');
    }

    public function profile(): View
    {
        return view('dashboard.jobseeker');
    }
}
