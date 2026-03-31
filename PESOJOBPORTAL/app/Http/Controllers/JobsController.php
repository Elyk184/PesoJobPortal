<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\PesoJob;

class JobsController extends Controller
{
    public function index(): View
    {
        $jobs = PesoJob::where('status', 'active')
                       ->latest()
                       ->paginate(12);

        return view('jobs', compact('jobs'));
    }
}
?>

