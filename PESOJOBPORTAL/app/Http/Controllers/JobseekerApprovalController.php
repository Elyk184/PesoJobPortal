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

        // Get available jobs from employers (active/approved jobs)
        $availableJobs = \App\Models\PesoJob::where('status', 'active')
            ->whereNotNull('approved_at')
            ->with('employer.companyProfile')
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
        
        // Get available jobs from employers (active/approved jobs)
        $availableJobs = \App\Models\PesoJob::where('status', 'active')
            ->whereNotNull('approved_at')
            ->with('employer.companyProfile')
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

        $job = \App\Models\PesoJob::with('employer.companyProfile')->findOrFail($request->job_id);
        
        // Get employer and company information
        $employerName = $job->employer?->name ?? 'Unknown Employer';
        $companyName = $job->employer?->companyProfile?->company_name ?? $employerName;

        // Create a portal notification
        $notification = \App\Models\PortalNotification::create([
            'title' => "Job Recommendation: {$job->title}",
            'message' => $request->message ?? "We recommend this job for you: {$job->title} at {$companyName}",
            'created_by' => auth()->id(),
        ]);

        // Attach to the jobseeker
        $jobseeker->userNotifications()->create([
            'portal_notification_id' => $notification->id,
        ]);

        return back()->with('success', "Job recommendation sent to {$jobseeker->name}!");
    }

    /**
     * Recommend an applicant to an employer
     */
    public function recommendApplicant(Request $request, User $jobseeker): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'employer_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:peso_jobs,id',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            // Get the job and verify it belongs to the selected employer
            $job = \App\Models\PesoJob::findOrFail($request->job_id);
            if ($job->employer_id != $request->employer_id) {
                return back()->with('error', 'Selected job does not belong to the selected employer.');
            }

            // Check if jobseeker has applied to this job
            $jobApplication = JobApplication::where('user_id', $jobseeker->id)
                ->where('peso_job_id', $job->id)
                ->first();

            if (!$jobApplication) {
                return back()->with('error', "{$jobseeker->name} has not applied to this job position.");
            }

            // Check if already recommended to this employer for this job
            $existing = \App\Models\RecommendedApplicant::where('job_application_id', $jobApplication->id)
                ->where('recommended_to_user_id', $request->employer_id)
                ->where('status', '!=', 'rejected')
                ->first();

            if ($existing) {
                return back()->with('error', "You have already recommended {$jobseeker->name} to this employer for this position.");
            }

            // Create recommendation record
            $recommendation = \App\Models\RecommendedApplicant::create([
                'job_application_id' => $jobApplication->id,
                'peso_job_id' => $job->id,
                'recommended_by_user_id' => auth()->id(),
                'recommended_to_user_id' => $request->employer_id,
                'recommendation_reason' => $request->message ?? null,
                'recommendation_type' => 'admin_to_employer',
                'status' => 'pending',
            ]);

            // Create notification for employer
            $employer = User::findOrFail($request->employer_id);
            $companyName = $employer->companyProfile?->company_name ?? $employer->name;
            
            \App\Models\UserNotification::create([
                'user_id' => $request->employer_id,
                'type' => 'applicant_recommended',
                'title' => "Applicant Recommendation: {$jobseeker->name}",
                'message' => "Admin has recommended {$jobseeker->name} for the {$job->title} position",
                'related_id' => $jobApplication->id,
            ]);

            return back()->with('success', "{$jobseeker->name} has been recommended to {$companyName}!");
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

