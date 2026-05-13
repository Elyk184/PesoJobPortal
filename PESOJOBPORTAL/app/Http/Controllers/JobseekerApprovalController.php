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
        \Log::info('recommendApplicant called', [
            'jobseeker_id' => $jobseeker->id,
            'jobseeker_name' => $jobseeker->name,
            'request_data' => $request->all(),
        ]);

        $validated = $request->validate([
            'employer_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:peso_jobs,id',
            'message' => 'nullable|string|max:1000',
        ]);

        \Log::info('Validation passed', $validated);

        try {
            // Get the job and verify it belongs to the selected employer
            $job = \App\Models\PesoJob::findOrFail($validated['job_id']);
            \Log::info('Job found', ['job_id' => $job->id, 'job_title' => $job->title, 'employer_id' => $job->employer_id]);
            
            if ($job->employer_id != $validated['employer_id']) {
                \Log::warning('Job does not belong to employer', [
                    'job_employer_id' => $job->employer_id,
                    'requested_employer_id' => $validated['employer_id']
                ]);
                return back()->with('error', 'Selected job does not belong to the selected employer.');
            }

            // Get or create job application (admin can recommend even without prior application)
            $jobApplication = JobApplication::where('user_id', $jobseeker->id)
                ->where('peso_job_id', $validated['job_id'])
                ->first();

            if (!$jobApplication) {
                \Log::info('Creating job application for recommendation', [
                    'user_id' => $jobseeker->id,
                    'job_id' => $validated['job_id']
                ]);
                
                // Create a new job application entry for this recommendation
                $jobApplication = JobApplication::create([
                    'user_id' => $jobseeker->id,
                    'peso_job_id' => $validated['job_id'],
                    'status' => 'recommended',
                    'application_text' => 'Admin recommendation',
                ]);
            }

            // Check if already recommended to this employer for this job
            $existing = \App\Models\RecommendedApplicant::where('job_application_id', $jobApplication->id)
                ->where('recommended_to_user_id', $validated['employer_id'])
                ->where('status', '!=', 'rejected')
                ->first();

            \Log::info('Existing recommendation check', [
                'job_application_id' => $jobApplication->id,
                'employer_id' => $validated['employer_id'],
                'exists' => $existing ? 'yes' : 'no'
            ]);

            if ($existing) {
                \Log::warning('Applicant already recommended', [
                    'jobseeker' => $jobseeker->name,
                    'employer_id' => $validated['employer_id']
                ]);
                return back()->with('error', "You have already recommended {$jobseeker->name} to this employer for this position.");
            }

            // Create recommendation record
            $recommendation = \App\Models\RecommendedApplicant::create([
                'job_application_id' => $jobApplication->id,
                'peso_job_id' => $validated['job_id'],
                'recommended_by_user_id' => auth()->id(),
                'recommended_to_user_id' => $validated['employer_id'],
                'recommendation_reason' => $validated['message'] ?? null,
                'recommendation_type' => 'admin_to_employer',
                'status' => 'pending',
            ]);

            \Log::info('Recommendation created', [
                'recommendation_id' => $recommendation->id,
                'jobseeker' => $jobseeker->name,
                'job_id' => $validated['job_id']
            ]);

            // Create notification for employer
            $employer = User::findOrFail($validated['employer_id']);
            $companyName = $employer->companyProfile?->company_name ?? $employer->name;
            
            $notification = \App\Models\UserNotification::create([
                'user_id' => $validated['employer_id'],
                'type' => 'applicant_recommended',
                'title' => "Applicant Recommendation: {$jobseeker->name}",
                'message' => "Admin has recommended {$jobseeker->name} for the {$job->title} position",
                'related_id' => $jobApplication->id,
            ]);

            \Log::info('Notification created', [
                'notification_id' => $notification->id,
                'employer_id' => $validated['employer_id'],
                'employer_name' => $employer->name
            ]);

            $successMsg = "{$jobseeker->name} has been recommended to {$companyName}!";
            \Log::info('Recommendation successful', ['message' => $successMsg]);
            
            return back()->with('success', $successMsg);
        } catch (\Exception $e) {
            \Log::error('Recommendation failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

