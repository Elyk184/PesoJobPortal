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
     * Display list of all jobseekers for job recommendations
     */
    public function index(): View
    {
        $jobseekers = User::where('role', 'jobseeker')
            ->with('profile')
            ->withCount('applications')
            ->latest()
            ->paginate(15);

        // Get available jobs from employers
        $availableJobs = \App\Models\PesoJob::where('status', 'approved')
            ->with('company')
            ->get();

        return view('admin.jobseekers.approvals', [
            'jobseekers' => $jobseekers,
            'availableJobs' => $availableJobs,
        ]);
    }

    /**
     * Show jobseeker profile with recommended jobs
     */
    public function show(User $jobseeker): View
    {
        $jobseeker->load('profile', 'applications.job');
        
        // Get available jobs from employers
        $availableJobs = \App\Models\PesoJob::where('status', 'approved')
            ->with('company')
            ->get();

        return view('admin.jobseekers.profile', [
            'jobseeker' => $jobseeker,
            'availableJobs' => $availableJobs,
        ]);
    }

    /**
     * Recommend a job to a jobseeker
     */
    public function recommendJob(Request $request, User $jobseeker): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'job_id' => 'required|exists:peso_jobs,id',
            'message' => 'nullable|string|max:500',
        ]);

        $job = \App\Models\PesoJob::findOrFail($request->job_id);

        // Create a portal notification
        $notification = \App\Models\PortalNotification::create([
            'title' => "Job Recommendation: {$job->title}",
            'message' => $request->message ?? "We recommend this job for you: {$job->title} at {$job->company->company_name}",
            'created_by' => auth()->id(),
        ]);

        // Attach to the jobseeker
        $jobseeker->userNotifications()->create([
            'portal_notification_id' => $notification->id,
        ]);

        return back()->with('success', "Job recommendation sent to {$jobseeker->name}!");
    }
}

