<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard.employer');
    }
}
