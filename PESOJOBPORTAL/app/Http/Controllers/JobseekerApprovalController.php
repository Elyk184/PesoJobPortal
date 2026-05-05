<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobApplication;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobseekerApprovalController extends Controller
{
    /**
     * Display list of pending job application approvals
     */
    public function index(): View
    {
        $applications = JobApplication::where('status', 'pending')
            ->whereNull('admin_status')
            ->with(['user', 'job'])
            ->latest()
            ->paginate(15);

        return view('admin.jobseekers.approvals', [
            'applications' => $applications,
        ]);
    }

    /**
     * Show application details for approval
     */
    public function show(JobApplication $application): View
    {
        return view('admin.jobseekers.show', [
            'application' => $application->load('user', 'job'),
        ]);
    }

    /**
     * Approve job application
     */
    public function approve(JobApplication $application): \Illuminate\Http\RedirectResponse
    {
        $application->update([
            'admin_status' => 'approved',
            'admin_approved_at' => now(),
            'admin_approved_by' => auth()->id(),
        ]);

        return back()->with('success', "Application from {$application->user->name} has been approved!");
    }

    /**
     * Reject job application
     */
    public function reject(Request $request, JobApplication $application): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:500',
        ]);

        $application->update([
            'admin_status' => 'rejected',
            'admin_notes' => $request->reason,
            'admin_approved_by' => auth()->id(),
        ]);

        return back()->with('success', "Application from {$application->user->name} has been rejected!");
    }
}
