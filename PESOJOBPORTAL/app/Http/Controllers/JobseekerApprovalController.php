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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

        // Get available jobs from employers (active or pending jobs)
        $availableJobs = \App\Models\PesoJob::whereIn('status', ['active', 'pending'])
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
        $jobseeker->load('applications.job.employer.companyProfile', 'profile');

        $userId = $jobseeker->id;
        $profile = $jobseeker->profile ?? UserProfile::where('user_id', $userId)->first();

        $personalInformation = $this->tableExists('jobseeker_personal_information')
            ? JobseekerPersonalInformation::where('user_id', $userId)->first()
            : null;
        $personalInformation ??= $this->profileObject($profile?->personal_information, $this->personalInformationDefaults([
            'email_address' => $jobseeker->email,
        ]));

        $addresses = $this->tableExists('jobseeker_addresses')
            ? JobseekerAddress::where('user_id', $userId)->get()->keyBy('type')
            : collect();

        $addressDefaults = [
            'house_no' => '',
            'barangay' => '',
            'municipality' => '',
            'province' => '',
        ];

        $presentAddress = $addresses->get('present') ?? $this->profileObject($profile?->present_address, $addressDefaults);
        $permanentAddress = $addresses->get('permanent') ?? $this->profileObject($profile?->permanent_address, $addressDefaults);

        $educationRows = $this->tableExists('jobseeker_education')
            ? JobseekerEducation::where('user_id', $userId)->orderBy('sort_order')->get(['school', 'course', 'year'])
            : collect();
        $educationRows = $educationRows->isNotEmpty()
            ? $educationRows
            : $this->profileRows($profile?->education, fn (array $row): array => [
                'school' => $row['school'] ?? '',
                'course' => $row['course'] ?? '',
                'year' => $row['year'] ?? '',
            ]);

        $trainingRows = $this->tableExists('jobseeker_training')
            ? JobseekerTraining::where('user_id', $userId)->orderBy('sort_order')->get(['course', 'hours', 'institution', 'inclusive_dates', 'skills_acquired', 'certificates'])
            : collect();
        $trainingRows = $trainingRows->isNotEmpty()
            ? $trainingRows
            : $this->profileRows($profile?->training, fn (array $row): array => [
                'course' => $row['course'] ?? '',
                'hours' => $row['hours'] ?? null,
                'institution' => $row['institution'] ?? '',
                'inclusive_dates' => $row['inclusive_dates'] ?? $row['dates'] ?? '',
                'skills_acquired' => $row['skills_acquired'] ?? $row['skills'] ?? '',
                'certificates' => $row['certificates'] ?? '',
            ]);

        $experienceRows = $this->tableExists('jobseeker_experience')
            ? JobseekerExperience::where('user_id', $userId)->orderBy('sort_order')->get(['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details'])
            : collect();
        $experienceRows = $experienceRows->isNotEmpty()
            ? $experienceRows
            : $this->profileRows($profile?->experience, fn (array $row): array => [
                'company' => $row['company'] ?? '',
                'title' => $row['title'] ?? '',
                'location' => $row['location'] ?? '',
                'status' => $row['status'] ?? false,
                'from_date' => $row['from_date'] ?? $row['period'] ?? '',
                'to_date' => $row['to_date'] ?? '',
                'salary_amount' => $row['salary_amount'] ?? '',
                'salary_type' => $row['salary_type'] ?? '',
                'details' => $row['details'] ?? '',
            ]);

        $eligibilityRows = $this->tableExists('jobseeker_eligibility')
            ? JobseekerEligibility::where('user_id', $userId)->orderBy('sort_order')->get(['eligibility', 'date_taken', 'license', 'valid_until'])
            : collect();
        $eligibilityRows = $eligibilityRows->isNotEmpty()
            ? $eligibilityRows
            : $this->profileRows($profile?->eligibility, fn (array $row): array => [
                'eligibility' => $row['eligibility'] ?? '',
                'date_taken' => $row['date_taken'] ?? '',
                'license' => $row['license'] ?? '',
                'valid_until' => $row['valid_until'] ?? '',
            ]);

        $skillRows = $this->tableExists('jobseeker_skills')
            ? JobseekerSkill::where('user_id', $userId)->get()
            : collect();
        $skillsMeta = $this->tableExists('jobseeker_skills_meta')
            ? JobseekerSkillsMeta::where('user_id', $userId)->first()
            : null;

        $otherSkills = [
            'trade_manual' => $skillRows->where('category', 'trade_manual')->pluck('skill')->all(),
            'it_technical' => $skillRows->where('category', 'it_technical')->pluck('skill')->all(),
            'soft_skills' => $skillRows->where('category', 'soft_skills')->pluck('skill')->all(),
            'other_enabled' => (bool) ($skillsMeta?->other_enabled ?? false),
            'other_text' => $skillRows->where('category', 'other')->pluck('skill')->first() ?? ($skillsMeta?->other_text ?? ''),
            'with_certificate' => $skillsMeta?->with_certificate,
            'by_experience' => $skillsMeta?->by_experience,
        ];

        if ($skillRows->isEmpty() && is_array($profile?->other_skills)) {
            $otherSkills = array_merge($otherSkills, $profile->other_skills);
        }

        $employmentStatusRow = $this->tableExists('jobseeker_employment_status')
            ? JobseekerEmploymentStatus::where('user_id', $userId)->first()
            : null;
        $employmentStatusRow ??= $this->profileObject($profile?->employment_status, [
            'has_work_experience' => null,
            'wage_employed' => false,
            'wage_employed_specify' => '',
            'self_employed' => false,
            'self_employed_specify' => '',
            'unemployed' => false,
        ]);

        $jobPreferenceRow = $this->tableExists('jobseeker_job_preferences')
            ? JobseekerJobPreference::where('user_id', $userId)->first()
            : null;
        $jobPreferenceRow ??= $this->profileObject($profile?->job_preferences, [
            'part_time' => false,
            'full_time' => false,
            'occupation_text' => '',
            'local' => false,
            'overseas' => false,
        ]);

        $languages = $this->tableExists('jobseeker_languages')
            ? JobseekerLanguage::where('user_id', $userId)->orderBy('sort_order')->get()
            : collect();
        $languages = $languages->isNotEmpty()
            ? $languages
            : $this->profileRows($profile?->languages, fn (array $row): array => [
                'language' => $row['language'] ?? '',
                'can_read' => (bool) ($row['can_read'] ?? $row['read'] ?? false),
                'can_write' => (bool) ($row['can_write'] ?? $row['write'] ?? false),
                'can_speak' => (bool) ($row['can_speak'] ?? $row['speak'] ?? false),
                'can_understand' => (bool) ($row['can_understand'] ?? $row['understand'] ?? false),
                'other_specify' => $row['other_specify'] ?? $row['other'] ?? '',
            ]);

        $disabilityRow = $this->tableExists('jobseeker_disability')
            ? JobseekerDisability::where('user_id', $userId)->first()
            : null;
        $disabilityRow ??= $this->profileObject($profile?->disability, [
            'visual' => false,
            'speech' => false,
            'mental' => false,
            'hearing' => false,
            'physical' => false,
            'other' => false,
            'other_text' => '',
        ]);

        $fullAddress = trim(implode(', ', array_filter([
            $presentAddress?->house_no,
            $presentAddress?->barangay,
            $presentAddress?->municipality,
            $presentAddress?->province,
        ])));

        // Get available jobs from employers (active or pending jobs)
        $availableJobs = \App\Models\PesoJob::whereIn('status', ['active', 'pending'])
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

    private function tableExists(string $table): bool
    {
        static $cache = [];

        return $cache[$table] ??= Schema::hasTable($table);
    }

    private function profileObject(mixed $data, array $defaults = []): ?object
    {
        if (! is_array($data)) {
            return empty($defaults) ? null : (object) $defaults;
        }

        return (object) array_merge($defaults, $data);
    }

    private function profileRows(mixed $rows, ?callable $map = null)
    {
        if (! is_array($rows)) {
            return collect();
        }

        return collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(fn (array $row) => (object) ($map ? $map($row) : $row))
            ->values();
    }

    private function personalInformationDefaults(array $overrides = []): array
    {
        return array_merge([
            'first_name' => '',
            'middle_initial' => '',
            'surname' => '',
            'suffix' => '',
            'date_of_birth' => '',
            'sex' => '',
            'religion' => '',
            'civil_status' => '',
            'height' => '',
            'tin' => '',
            'contact_number' => '',
            'email_address' => '',
            'currently_in_school' => false,
        ], $overrides);
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
        try {
            $portalNotification = \App\Models\PortalNotification::create([
                'title' => "Job Recommendation: {$job->title}",
                'message' => $request->message ?? "We recommend this job for you: {$job->title} at {$companyName}",
                'created_by' => auth()->id(),
            ]);

            Log::info('PortalNotification created for recommendJob', [
                'portal_notification_id' => $portalNotification->id,
                'title' => $portalNotification->title,
                'created_by' => $portalNotification->created_by,
            ]);

            // Attach to the jobseeker
            $jobseeker->userNotifications()->create([
                'portal_notification_id' => $portalNotification->id,
                'user_id' => $jobseeker->id,
            ]);

            Log::info('UserNotification created for recommendJob', [
                'user_id' => $jobseeker->id,
                'portal_notification_id' => $portalNotification->id,
            ]);

            return back()->with('success', "Job recommendation sent to {$jobseeker->name}! ");
        } catch (\Throwable $e) {
            Log::error('Failed to create recommendation notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to send recommendation notification: ' . $e->getMessage());
        }
    }

    /**
     * Recommend an applicant to an employer
     */
    public function recommendApplicant(Request $request, User $jobseeker): \Illuminate\Http\RedirectResponse
    {
        Log::info('recommendApplicant called', [
            'jobseeker_id' => $jobseeker->id,
            'jobseeker_name' => $jobseeker->name,
            'request_data' => $request->all(),
        ]);

        $validated = $request->validate([
            'employer_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:peso_jobs,id',
            'message' => 'nullable|string|max:1000',
        ]);

        Log::info('Validation passed', $validated);

        try {
            // Get the job and verify it belongs to the selected employer
            $job = \App\Models\PesoJob::findOrFail($validated['job_id']);
            Log::info('Job found', ['job_id' => $job->id, 'job_title' => $job->title, 'employer_id' => $job->employer_id]);

            if ($job->employer_id != $validated['employer_id']) {
                Log::warning('Job does not belong to employer', [
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

            Log::info('Recommendation created', [
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

            Log::info('Notification created', [
                'notification_id' => $notification->id,
                'portal_notification_id' => $portalNotif->id,
                'employer_id' => $validated['employer_id'],
                'employer_name' => $employer->name
            ]);

            $successMsg = "{$jobseeker->name} has been recommended to {$companyName}!";
            Log::info('Recommendation successful', ['message' => $successMsg]);

            return back()->with('success', $successMsg);
        } catch (\Exception $e) {
            Log::error('Recommendation failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
