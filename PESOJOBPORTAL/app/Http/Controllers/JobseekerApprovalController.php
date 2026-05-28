<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobApplication;
use App\Models\JobseekerAddress;
use App\Models\JobseekerDisability;
use App\Models\JobseekerEducation;
use App\Models\JobseekerEmploymentStatus;
use App\Models\JobseekerEligibility;
use App\Models\JobseekerExperience;
use App\Models\JobseekerJobPreference;
use App\Models\JobseekerLanguage;
use App\Models\JobseekerPersonalInformation;
use App\Models\JobseekerSkill;
use App\Models\JobseekerSkillsMeta;
use App\Models\JobseekerTraining;
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
            ->with('jobseekerProfile')
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
        $jobseeker->load('applications.job.employer.companyProfile');

        $userId = $jobseeker->id;

        $personalInformation = JobseekerPersonalInformation::where('user_id', $userId)->first();

        $addresses = JobseekerAddress::where('user_id', $userId)
            ->get()
            ->keyBy('type');

        $presentAddress = $addresses->get('present');
        $permanentAddress = $addresses->get('permanent');

        $educationRows = JobseekerEducation::where('user_id', $userId)
            ->orderBy('sort_order')
            ->get(['school', 'course', 'year']);

        $trainingRows = JobseekerTraining::where('user_id', $userId)
            ->orderBy('sort_order')
            ->get(['course', 'hours', 'institution', 'inclusive_dates', 'skills_acquired', 'certificates']);

        $experienceRows = JobseekerExperience::where('user_id', $userId)
            ->orderBy('sort_order')
            ->get(['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details']);

        $eligibilityRows = JobseekerEligibility::where('user_id', $userId)
            ->orderBy('sort_order')
            ->get(['eligibility', 'date_taken', 'license', 'valid_until']);

        $skillRows = JobseekerSkill::where('user_id', $userId)->get();
        $skillsMeta = JobseekerSkillsMeta::where('user_id', $userId)->first();

        $otherSkills = [
            'trade_manual' => $skillRows->where('category', 'trade_manual')->pluck('skill')->all(),
            'it_technical' => $skillRows->where('category', 'it_technical')->pluck('skill')->all(),
            'soft_skills' => $skillRows->where('category', 'soft_skills')->pluck('skill')->all(),
            'other_enabled' => (bool) ($skillsMeta?->other_enabled ?? false),
            'other_text' => $skillRows->where('category', 'other')->pluck('skill')->first() ?? ($skillsMeta?->other_text ?? ''),
            'with_certificate' => $skillsMeta?->with_certificate,
            'by_experience' => $skillsMeta?->by_experience,
        ];

        $employmentStatusRow = JobseekerEmploymentStatus::where('user_id', $userId)->first();
        $jobPreferenceRow = JobseekerJobPreference::where('user_id', $userId)->first();
        $languages = JobseekerLanguage::where('user_id', $userId)
            ->orderBy('sort_order')
            ->get();
        $disabilityRow = JobseekerDisability::where('user_id', $userId)->first();

        $fullAddress = trim(implode(', ', array_filter([
            $presentAddress?->house_no,
            $presentAddress?->barangay,
            $presentAddress?->municipality,
            $presentAddress?->province,
        ])));
        
        // Get available jobs from employers (active/approved jobs)
        $availableJobs = \App\Models\PesoJob::where('status', 'active')
            ->whereNotNull('approved_at')
            ->with('employer.companyProfile')
            ->get();

        return view('admin.jobseekers.profile', [
            'jobseeker' => $jobseeker,
            'availableJobs' => $availableJobs,
            'personalInformation' => $personalInformation,
            'presentAddress' => $presentAddress,
            'permanentAddress' => $permanentAddress,
            'educationRows' => $educationRows,
            'trainingRows' => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows' => $eligibilityRows,
            'otherSkills' => $otherSkills,
            'employmentStatus' => $employmentStatusRow,
            'jobPreferences' => $jobPreferenceRow,
            'languages' => $languages,
            'disability' => $disabilityRow,
            'fullAddress' => $fullAddress,
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

            // Create recommendation record directly (no job application required)
            $recommendation = \App\Models\RecommendedApplicant::create([
                'jobseeker_id' => $jobseeker->id,
                'job_application_id' => null, // Can be null for admin recommendations
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
            
            // Create portal notification first
            $portalNotif = \App\Models\PortalNotification::create([
                'title' => "Applicant Recommendation: {$jobseeker->name}",
                'message' => "Admin has recommended {$jobseeker->name} for the {$job->title} position at {$companyName}",
                'created_by' => auth()->id(),
            ]);

            // Then create user notification
            $notification = $employer->userNotifications()->create([
                'portal_notification_id' => $portalNotif->id,
            ]);

            \Log::info('Notification created', [
                'notification_id' => $notification->id,
                'portal_notification_id' => $portalNotif->id,
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

