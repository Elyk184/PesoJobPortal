<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EmployerNotification;
use App\Models\JobApplication;
use App\Models\PesoJob;
use App\Models\PortalNotification;
use App\Models\RecruitmentActivityRequest;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserProfile;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(Request $request): View
    {
        $employer = $request->user()->loadMissing('companyProfile');
        $logoPath = $employer->companyProfile?->logo_path;
        $isVerifiedEmployer = (bool) $employer->is_employer_verified || ($employer->companyProfile?->verification_status === 'verified');

        if ($isVerifiedEmployer && ! $employer->is_employer_verified) {
            $employer->forceFill(['is_employer_verified' => true])->save();
        }

        $companyLogoUrl = ($logoPath && Storage::disk('public')->exists($logoPath))
            ? asset('storage/'.$logoPath)
            : null;

        return view('dashboard.employer', [
            'stats' => $this->buildDashboardStats($employer->id),
            'isVerifiedEmployer' => $isVerifiedEmployer,
            'companyLogoUrl' => $companyLogoUrl,
        ]);
    }

    public function postNewJobPage(Request $request): View
    {
        $employer = $request->user()->loadMissing('companyProfile');
        $companyProfile = $employer->companyProfile;
        $isVerifiedEmployer = (bool) $employer->is_employer_verified || ($companyProfile?->verification_status === 'verified');

        if ($isVerifiedEmployer && ! $employer->is_employer_verified) {
            $employer->forceFill(['is_employer_verified' => true])->save();
        }

        if ($companyProfile === null) {
            $companyProfile = (object) [
                'company_name' => $employer->name,
                'is_verified' => $isVerifiedEmployer,
            ];
        } else {
            $companyProfile->company_name = $companyProfile->company_name ?? $employer->name;
            $companyProfile->is_verified = (bool) ($companyProfile->is_verified
                ?? (($companyProfile->verification_status ?? null) === 'verified')
                ?? $isVerifiedEmployer);
        }

        return view('dashboard.employer.post-new-job', [
            'companyProfile' => $companyProfile,
            'employmentTypes' => $this->employmentTypes(),
            'isVerifiedEmployer' => $isVerifiedEmployer,
        ]);
    }

    public function manageJobsPage(Request $request): View
    {
        $employer = $request->user();
        $isVerifiedEmployer = (bool) $employer->is_employer_verified || ($employer->companyProfile?->verification_status === 'verified');

        if ($isVerifiedEmployer && ! $employer->is_employer_verified) {
            $employer->forceFill(['is_employer_verified' => true])->save();
        }

        $selectedTab = $request->query('status', 'active');
        $availableTabs = ['active', 'pending', 'draft', 'archived', 'filled', 'all'];

        if (! in_array($selectedTab, $availableTabs, true)) {
            $selectedTab = 'active';
        }

        $allJobs = $this->getEmployerJobs($employer->id);

        $tabCounts = [
            'active' => $allJobs->filter(fn ($job) => $job->status === 'active' && ! $job->is_filled && $job->archived_at === null)->count(),
            'pending' => $allJobs->where('status', 'pending')->count(),
            'draft' => $allJobs->where('status', 'draft')->count(),
            'archived' => $allJobs->filter(fn ($job) => $job->status === 'closed' && $job->is_filled === false)->count(),
            'filled' => $allJobs->where('is_filled', true)->count(),
            'all' => $allJobs->count(),
        ];

        $jobs = match ($selectedTab) {
            'active' => $allJobs->filter(fn ($job) => $job->status === 'active' && ! $job->is_filled && $job->archived_at === null),
            'pending' => $allJobs->where('status', 'pending'),
            'draft' => $allJobs->where('status', 'draft'),
            'archived' => $allJobs->filter(fn ($job) => $job->status === 'closed' && $job->is_filled === false),
            'filled' => $allJobs->where('is_filled', true),
            default => $allJobs,
        };

        return view('dashboard.employer.manage-jobs', [
            'jobs' => $jobs,
            'selectedTab' => $selectedTab,
            'tabCounts' => $tabCounts,
            'isVerifiedEmployer' => $isVerifiedEmployer,
        ]);
    }

    public function viewApplicantsPage(Request $request): View
    {
        $employer = $request->user()->loadMissing('companyProfile');
        $isVerifiedEmployer = (bool) $employer->is_employer_verified || ($employer->companyProfile?->verification_status === 'verified');

        if ($isVerifiedEmployer && ! $employer->is_employer_verified) {
            $employer->forceFill(['is_employer_verified' => true])->save();
        }

        $referredApplications = $this->getReferredApplications($employer->id);

        return view('dashboard.employer.view-applicants', [
            'referredApplications' => $referredApplications,
            'totalApplicants' => $referredApplications->count(),
            'pendingReview' => $referredApplications->whereNull('employer_status')->count(),
            'approved' => $referredApplications->where('employer_status', 'hired')->count(),
            'rejected' => $referredApplications->where('employer_status', 'not_selected')->count(),
            'jobs' => $this->getEmployerJobs($request->user()->id),
            'isVerifiedEmployer' => $isVerifiedEmployer,
        ]);
    }

    public function requestLraSraPage(Request $request): View
    {
        return view('dashboard.employer.request-lra-sra', [
            'recruitmentRequests' => $this->getRecruitmentRequests($request->user()->id),
        ]);
    }

    public function submitDocumentsPage(Request $request): View
    {
        $defaultActivityType = $request->query('activity_type');

        if (! in_array($defaultActivityType, ['lra', 'sra'], true)) {
            $defaultActivityType = null;
        }

        $employer = $request->user()->loadMissing('companyProfile');
        $companyProfile = $employer->companyProfile;

        $companyProfilePreview = [
            'company_name' => $companyProfile?->company_name ?? $employer->name,
            'logo_path' => $companyProfile?->logo_path,
            'establishment_contact_person' => $companyProfile?->establishment_contact_person,
            'establishment_contact_position' => $companyProfile?->establishment_contact_position,
            'establishment_phone' => $companyProfile?->establishment_phone,
            'establishment_email' => $companyProfile?->establishment_email,
            'street_village' => $companyProfile?->street_village,
            'barangay' => $companyProfile?->barangay,
            'city_municipality' => $companyProfile?->city_municipality,
            'province' => $companyProfile?->province,
        ];

        return view('dashboard.employer.submit-documents', [
            'defaultActivityType' => $defaultActivityType,
            'recruitmentRequests' => $this->getRecruitmentRequests($request->user()->id),
            'companyProfile' => $companyProfile,
            'companyProfilePreview' => $companyProfilePreview,
        ]);
    }

    public function companyProfilePage(Request $request): View
    {
        $employer = $request->user()->loadMissing('companyProfile');

        return view('dashboard.employer.company-profile', [
            'employer' => $employer,
            'user' => $employer,
            'companyProfile' => $employer->companyProfile,
            'isVerifiedEmployer' => (bool) $employer->is_employer_verified,
        ]);
    }

    public function downloadCompanyProfile(Request $request)
    {
        $employer = $request->user()->loadMissing('companyProfile');
        $companyProfile = $employer->companyProfile;
        $logoPath = $companyProfile?->logo_path;
        $logoFullPath = null;

        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            $logoFullPath = Storage::disk('public')->path($logoPath);
        }

        $pdf = Pdf::loadView('dashboard.employer.company-profile-pdf', [
            'employer' => $employer,
            'companyProfile' => $companyProfile,
            'logoFullPath' => $logoFullPath,
            'generatedAt' => now(),
        ])->setPaper('a4');

        return $pdf->download(sprintf(
            '%s-company-profile.pdf',
            Str::slug($companyProfile?->company_name ?? $employer->name)
        ));
    }

    public function updateCompanyProfile(Request $request): RedirectResponse
    {
        $employer = $request->user();

        if ($request->boolean('logo_only')) {
            $validated = $request->validate([
                'company_logo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            ]);

            $profile = CompanyProfile::firstOrCreate(
                ['user_id' => $employer->id],
                ['company_name' => $employer->name]
            );

            if ($profile->logo_path && Storage::disk('public')->exists($profile->logo_path)) {
                Storage::disk('public')->delete($profile->logo_path);
            }

            $profile->update([
                'logo_path' => $request->file('company_logo')->store('company-profiles', 'public'),
            ]);

            return back()->with('success', 'Company logo updated successfully.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$employer->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'trade_name' => ['nullable', 'string', 'max:255'],
            'acronym_abbreviation' => ['nullable', 'string', 'max:100'],
            'office_type' => ['required', 'in:main_office,branch'],
            'tin' => ['nullable', 'string', 'max:50'],
            'employer_type_detail' => ['required', 'in:national_gov,local_gov,gocc,state_college,direct_hire,local_recruitment,overseas_recruitment,do174'],
            'workforce_size' => ['required', 'in:micro,small,medium,large'],
            'line_of_business' => ['required', 'string', 'max:255'],
            'street_village' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city_municipality' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'establishment_contact_person' => ['required', 'string', 'max:255'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'establishment_contact_position' => ['required', 'string', 'max:255'],
            'establishment_phone' => ['nullable', 'string', 'max:50'],
            'contact_person_phone' => ['required', 'string', 'max:50'],
            'establishment_email' => ['required', 'email', 'max:255'],
            'company_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'business_permit' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'dti_sec_registration' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];

        if (Schema::hasColumn('users', 'username')) {
            $rules['username'] = ['nullable', 'string', 'max:100', 'alpha_dash', 'unique:users,username,'.$employer->id];
        }

        $validated = $request->validate($rules);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        if (Schema::hasColumn('users', 'username') && ! empty($validated['username'])) {
            $updateData['username'] = $validated['username'];
        }

        $employer->update($updateData);

        $profile = CompanyProfile::firstOrCreate(
            ['user_id' => $employer->id],
            ['company_name' => $validated['company_name'] ?? $employer->name]
        );

        $profileData = [];
        $currentVerificationStatus = $profile->verification_status;

        // Map input fields to CompanyProfile columns
        $fieldMapping = [
            'company_name' => 'company_name',
            'business_name' => 'business_name',
            'trade_name' => 'trade_name',
            'acronym_abbreviation' => 'acronym_abbreviation',
            'office_type' => 'office_type',
            'tin' => 'tin',
            'employer_type_detail' => 'employer_type_detail',
            'workforce_size' => 'workforce_size',
            'line_of_business' => 'line_of_business',
            'street_village' => 'street_village',
            'barangay' => 'barangay',
            'city_municipality' => 'city_municipality',
            'province' => 'province',
            'establishment_contact_person' => 'establishment_contact_person',
            'contact_person_name' => 'contact_person_name',
            'establishment_contact_position' => 'establishment_contact_position',
            'establishment_phone' => 'establishment_phone',
            'contact_person_phone' => 'contact_person_phone',
            'establishment_email' => 'establishment_email',
        ];

        foreach ($fieldMapping as $input => $column) {
            if (array_key_exists($input, $validated) && $validated[$input] !== null) {
                $profileData[$column] = $validated[$input];
            }
        }

        // Use business_name as company_name if not explicitly provided
        if (!isset($profileData['company_name']) || empty($profileData['company_name'])) {
            $profileData['company_name'] = $validated['business_name'] ?? '';
        }

        // Handle file uploads
        if ($request->hasFile('company_logo')) {
            if ($profile->logo_path && Storage::disk('public')->exists($profile->logo_path)) {
                Storage::disk('public')->delete($profile->logo_path);
            }
            $profileData['logo_path'] = $request->file('company_logo')->store('company-profiles', 'public');
        }

        if ($request->hasFile('business_permit')) {
            if ($profile->business_permit_path && Storage::disk('public')->exists($profile->business_permit_path)) {
                Storage::disk('public')->delete($profile->business_permit_path);
            }
            $storedPath = $request->file('business_permit')->store('company-documents', 'public');
            $profileData['business_permit_path'] = $storedPath;

            // Record the uploaded document for admin document verification workflow
            DB::table('employer_documents')->insert([
                'user_id' => $employer->id,
                'document_type' => 'business_permit',
                'file_path' => $storedPath,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($request->hasFile('dti_sec_registration')) {
            if ($profile->dti_sec_registration_path && Storage::disk('public')->exists($profile->dti_sec_registration_path)) {
                Storage::disk('public')->delete($profile->dti_sec_registration_path);
            }
            $storedPath = $request->file('dti_sec_registration')->store('company-documents', 'public');
            $profileData['dti_sec_registration_path'] = $storedPath;

            // Record the uploaded document for admin document verification workflow
            DB::table('employer_documents')->insert([
                'user_id' => $employer->id,
                'document_type' => 'dti_sec_registration',
                'file_path' => $storedPath,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Update verification status when BOTH required documents are present (either uploaded now or already stored)
        $willHaveBusinessPermit = isset($profileData['business_permit_path']) || ($profile->business_permit_path && Storage::disk('public')->exists($profile->business_permit_path));
        $willHaveDtiSec = isset($profileData['dti_sec_registration_path']) || ($profile->dti_sec_registration_path && Storage::disk('public')->exists($profile->dti_sec_registration_path));

        if ($willHaveBusinessPermit && $willHaveDtiSec && $profile->verification_status !== 'verified') {
            $profileData['verification_status'] = 'under_review';
        }

        if (! empty($profileData)) {
            $profile->update($profileData);
        }

        $nextVerificationStatus = $profileData['verification_status'] ?? $currentVerificationStatus;
        $becameUnderReview = $currentVerificationStatus !== 'under_review' && $nextVerificationStatus === 'under_review';

        if ($becameUnderReview) {
            $this->notifyAdmins(
                'Employer Verification Requires Review',
                sprintf(
                    "%s submitted Business Permit and DTI/SEC Registration for verification.",
                    $profileData['company_name'] ?? $profile->company_name ?? $employer->name
                ),
                $employer->id
            );
        }

        return back()->with('success', 'Company profile updated successfully.');
    }

    public function showApplication(Request $request, JobApplication $application): View
    {
        $employerId = $request->user()->id;

        if (! $application->job || $application->job->employer_id !== $employerId) {
            abort(403, 'You are not authorized to view this applicant.');
        }

        $application->load(['user.profile', 'jobPost']);

        return view('dashboard.employer.show-applicant', [
            'application' => $application,
            'isVerifiedEmployer' => (bool) $request->user()->is_employer_verified,
        ]);
    }

    public function notificationsPage(Request $request): View
    {
        $notifications = $this->getNotifications($request->user()->id, 50);
        $jobUnreadCount = $notifications->filter(function ($notification) {
            $type = strtolower((string) $notification->type);
            $title = strtolower((string) $notification->title);
            $message = strtolower((string) $notification->message);

            return ($type === 'job_update' || str_contains($title, 'job') || str_contains($message, 'job post'))
                && ! $notification->is_read;
        })->count();
        $verificationUnreadCount = $notifications->filter(function ($notification) {
            $type = strtolower((string) $notification->type);
            $title = strtolower((string) $notification->title);
            $message = strtolower((string) $notification->message);

            return ($type === 'verification_update' || str_contains($title, 'verification') || str_contains($message, 'verification'))
                && ! $notification->is_read;
        })->count();

        return view('dashboard.employer.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $notifications->where('is_read', false)->count(),
            'jobUnreadCount' => $jobUnreadCount,
            'verificationUnreadCount' => $verificationUnreadCount,
        ]);
    }

    public function storeJob(Request $request): RedirectResponse
    {
        $employer = $request->user();
        $isDraft = $request->boolean('save_as_draft');
        // All non-draft jobs go to pending approval by default
        $status = $isDraft ? 'draft' : 'pending';
        $status = $this->normalizeJobStatusForStorage($status);

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'in:full_time,part_time,contract,temporary,internship,freelance'],
            'vacancies' => ['required', 'integer', 'min:1', 'max:999'],
            'key_responsibilities' => ['nullable', 'string'],
            'qualifications' => ['nullable', 'string'],
            'preferred_skills' => ['nullable', 'string'],
            'experience' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'application_deadline' => ['nullable', 'date', 'after:today'],
        ];

        $validated = $request->validate($rules);

        // Map form fields to model
        $jobData = [
            'employer_id' => $employer->id,
            'employer_name' => $employer->companyProfile?->company_name ?? $employer->name,
            'title' => $validated['title'],
            'position' => $validated['title'], // Use title as position for legacy
            'description' => $validated['description'],
            'qualifications' => $validated['qualifications'] ?? $validated['description'],
            'location' => $validated['location'],
            'job_type' => $validated['employment_type'],
            'vacancies' => $validated['vacancies'],
            'key_responsibilities' => $validated['key_responsibilities'],
            'preferred_skills' => $validated['preferred_skills'],
            'experience' => $validated['experience'],
            'education' => $validated['education'],
            'benefits' => $validated['benefits'],
        ];

        // Salary
        if (isset($validated['salary_min']) || isset($validated['salary_max'])) {
            $jobData['salary_range'] = ($validated['salary_min'] ?? '') . ' - ' . ($validated['salary_max'] ?? '');
            $jobData['salary'] = $jobData['salary_range'];
        }

        // Dates
        $jobData['application_start_date'] = now()->toDateString();
        if ($validated['application_deadline']) {
            $jobData['application_end_date'] = $validated['application_deadline'];
        } else {
            $jobData['application_end_date'] = now()->addDays(30)->toDateString();
        }

        $jobData['status'] = $status;

        // Keep inserts compatible with environments where some optional columns
        // have not been migrated yet.
        $jobColumns = array_flip(Schema::getColumnListing('peso_jobs'));
        $jobData = array_intersect_key($jobData, $jobColumns);

        $job = PesoJob::create($jobData);

        if (! $isDraft) {
            $this->notifyAdmins(
                'Job Post Pending Approval',
                sprintf(
                    "%s submitted a new job post '%s' and it is waiting for admin approval.",
                    $employer->companyProfile?->company_name ?? $employer->name,
                    $job->title
                ),
                $employer->id
            );
        }

        $message = match (true) {
            $isDraft => 'Job saved as draft successfully.',
            default => 'Job submitted successfully and is now awaiting admin approval.',
        };

        return redirect()->route('employer.jobs.post')->with('success', $message);
    }

    public function extendJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $validated = $request->validate([
            'application_end_date' => ['required', 'date', 'after:today'],
        ]);

        $job->update([
            'application_end_date' => $validated['application_end_date'],
            'status' => 'active',
            'archived_at' => null,
        ]);

        return back()->with('success', 'Posting end date extended.');
    }

    public function archiveJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $job->update([
            'status' => 'closed',
            'archived_at' => now(),
        ]);

        return back()->with('success', 'Posting archived successfully.');
    }

    public function duplicateJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        if (! $request->user()->is_employer_verified) {
            return back()->with('error', 'Only verified employers can duplicate and republish jobs.');
        }

        $newJob = $job->replicate();
        $newJob->status = 'active';
        $newJob->archived_at = null;
        $newJob->is_filled = false;
        $newJob->filled_at = null;
        $newJob->application_start_date = now()->toDateString();
        $newJob->application_end_date = now()->addDays(30)->toDateString();
        $newJob->source_job_id = $job->id;
        $newJob->save();

        return back()->with('success', 'Job posting duplicated.');
    }

    public function markJobFilled(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $job->update([
            'is_filled' => true,
            'filled_at' => now(),
            'status' => 'closed',
        ]);

        return back()->with('success', 'Vacancy marked as filled.');
    }

    public function requestRecruitmentActivity(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'activity_type' => ['required', 'in:lra,sra'],
            'company_profile_source' => ['nullable', 'in:upload,profile_details'],
            'letter_of_intent' => ['required', 'file', 'extensions:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
            'company_profile' => ['nullable', 'file', 'extensions:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
            'job_advertisement' => ['nullable', 'file', 'extensions:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
        ]);

        $employer = $request->user()->loadMissing('companyProfile');
        $companyProfile = $employer->companyProfile;

        $companyProfileSource = $validated['company_profile_source'] ?? 'upload';
        $companyProfilePath = null;

        if ($request->hasFile('company_profile')) {
            $companyProfilePath = $request->file('company_profile')->store('recruitment-documents');
        } elseif ($companyProfileSource === 'profile_details' && $companyProfile) {
            $summaryLines = [
                'COMPANY PROFILE',
                '================',
                'Company Name: '.($companyProfile->company_name ?? $employer->name),
                'Logo Path: '.($companyProfile->logo_path ?? 'N/A'),
                'Establishment Contact Person: '.($companyProfile->establishment_contact_person ?? 'N/A'),
                'Establishment Contact Position: '.($companyProfile->establishment_contact_position ?? 'N/A'),
                'Establishment Phone: '.($companyProfile->establishment_phone ?? 'N/A'),
                'Establishment Email: '.($companyProfile->establishment_email ?? 'N/A'),
                'Address: '.trim(implode(', ', array_filter([
                    $companyProfile->street_village ?? null,
                    $companyProfile->barangay ?? null,
                    $companyProfile->city_municipality ?? null,
                    $companyProfile->province ?? null,
                ]))),
            ];

            $companyProfilePath = 'recruitment-documents/company-profile-'.now()->format('YmdHis').'.txt';
            Storage::disk('public')->put($companyProfilePath, implode("\n", $summaryLines));
        }

        if (! $companyProfilePath) {
            return back()
                ->withErrors(['company_profile' => 'Please upload a company profile file or choose the saved company profile details source.'])
                ->withInput();
        }

        $jobAdvertisementPath = $request->hasFile('job_advertisement')
            ? $request->file('job_advertisement')->store('recruitment-documents')
            : '';

        RecruitmentActivityRequest::create([
            'employer_id' => $employer->id,
            'activity_type' => $validated['activity_type'],
            'letter_of_intent_path' => $request->file('letter_of_intent')->store('recruitment-documents'),
            'company_profile_path' => $companyProfilePath,
            'job_advertisement_path' => $jobAdvertisementPath,
        ]);

        return back()->with('success', 'LRA/SRA request submitted successfully and is awaiting admin approval.');
    }

    private function notifyAdmins(string $title, string $message, ?int $createdBy = null): void
    {
        $adminIds = User::query()
            ->where('role', 'admin')
            ->pluck('id');

        if ($adminIds->isEmpty()) {
            return;
        }

        $portalNotification = PortalNotification::query()->create([
            'title' => $title,
            'message' => $message,
            'created_by' => $createdBy,
        ]);

        $rows = $adminIds->map(fn ($adminId) => [
            'user_id' => $adminId,
            'portal_notification_id' => $portalNotification->id,
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();

        UserNotification::query()->insert($rows);
    }

    public function updateApplicantDecision(Request $request, JobApplication $application)
    {
        $job = $application->job;

        if (! $job || (int) $job->employer_id !== (int) $request->user()->id) {
            abort(403, 'You can only update applicants referred to your postings.');
        }

        $previousStatus = $application->status;

        // Support a simple `status` payload from the UI for common stages, keep backward compatibility
        $validated = $request->validate([
            'status' => ['nullable', 'in:pending,reviewing,shortlisted,interview,hired,rejected'],
            'employer_status' => ['nullable', 'in:interview_scheduled,hired,not_selected'],
            'final_decision' => ['nullable', 'in:pending,hired,not_selected'],
            'employer_feedback' => ['nullable', 'string'],
            'interview_scheduled_at' => ['nullable', 'date'],
        ]);

        $newStatus = $validated['status'] ?? null;
        $update = [
            'employer_feedback' => $validated['employer_feedback'] ?? $application->employer_feedback,
            'interview_scheduled_at' => $application->interview_scheduled_at,
        ];

        if ($newStatus !== null) {
            switch ($newStatus) {
                case 'hired':
                    $update['employer_status'] = 'hired';
                    $update['final_decision'] = 'hired';
                    $update['status'] = 'hired';
                    break;
                case 'rejected':
                    $update['employer_status'] = 'not_selected';
                    $update['final_decision'] = 'not_selected';
                    $update['status'] = 'rejected';
                    break;
                case 'interview':
                    $update['employer_status'] = 'interview_scheduled';
                    $update['final_decision'] = 'pending';
                    $update['status'] = 'interview';
                    $update['interview_scheduled_at'] = $validated['interview_scheduled_at'] ?? $application->interview_scheduled_at;
                    break;
                case 'reviewing':
                case 'shortlisted':
                    $update['final_decision'] = 'pending';
                    $update['status'] = $newStatus;
                    // keep employer_status unchanged for these intermediate states
                    $update['interview_scheduled_at'] = null;
                    break;
                case 'pending':
                default:
                    $update['final_decision'] = 'pending';
                    $update['status'] = 'pending';
                    $update['interview_scheduled_at'] = null;
                    break;
            }
        } else {
            // fallback to older fields if provided
            if (isset($validated['employer_status'])) {
                $update['employer_status'] = $validated['employer_status'];
            }
            if (isset($validated['final_decision'])) {
                $update['final_decision'] = $validated['final_decision'];
                $update['status'] = $validated['final_decision'] === 'hired' ? 'hired' : ($validated['final_decision'] === 'not_selected' ? 'rejected' : 'interviewed');
            }
            if (($update['status'] ?? null) !== 'interview') {
                $update['interview_scheduled_at'] = null;
            }
        }

        DB::transaction(function () use ($application, $update, $job, $request, $previousStatus) {
            $application->update($update);

            if ($application->user_id && $application->status !== $previousStatus) {
                $statusLabel = $this->applicationStatusLabel($application->status);
                $message = sprintf(
                    'Your application for %s has been updated to %s.',
                    $job->title ?? 'a job posting',
                    $statusLabel
                );

                if ($application->status === 'interview' && ! empty($application->interview_scheduled_at)) {
                    $message .= ' Interview scheduled for ' . $application->interview_scheduled_at->format('M d, Y h:i A') . '.';
                }

                if (! empty($application->employer_feedback)) {
                    $message .= ' Feedback: ' . $application->employer_feedback;
                }

                $portalNotification = PortalNotification::create([
                    'title' => 'Application Status Updated',
                    'message' => $message,
                    'created_by' => $request->user()->id,
                ]);

                UserNotification::create([
                    'user_id' => $application->user_id,
                    'portal_notification_id' => $portalNotification->id,
                    'read_at' => null,
                ]);
            }
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $application->status]);
        }

        return back()->with('success', 'Applicant decision updated.');
    }

    public function markNotificationRead(Request $request, EmployerNotification $notification): RedirectResponse
    {
        if ((int) $notification->employer_id !== (int) $request->user()->id) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'Notification marked as read.');
    }

    private function assertJobOwnership(Request $request, PesoJob $job): void
    {
        if ((int) $job->employer_id !== (int) $request->user()->id) {
            abort(403, 'This posting does not belong to your employer account.');
        }
    }

    private function getEmployerJobs(int $employerId)
    {
        return PesoJob::query()
            ->where('employer_id', $employerId)
            ->withCount('applications')
            ->latest()
            ->get();
    }

    private function getRecruitmentRequests(int $employerId)
    {
        return RecruitmentActivityRequest::query()
            ->where('employer_id', $employerId)
            ->latest()
            ->get();
    }

    private function getReferredApplications(int $employerId)
    {
        return JobApplication::query()
            ->with(['user.profile', 'jobPost'])
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->latest()
            ->get();
    }

    private function getNotifications(int $employerId, int $limit = 20)
    {
        return EmployerNotification::query()
            ->where('employer_id', $employerId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    private function buildDashboardStats(int $employerId): array
    {
        $activeJobsCount = PesoJob::query()
            ->where('employer_id', $employerId)
            ->where('status', 'active')
            ->whereNull('archived_at')
            ->where('is_filled', false)
            ->count();

        $totalApplications = JobApplication::query()
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->count();

        $pendingJobsCount = PesoJob::query()
            ->where('employer_id', $employerId)
            ->where('status', 'pending')
            ->whereNull('archived_at')
            ->count();

        $newApplicationsToday = JobApplication::query()
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->whereDate('created_at', now()->toDateString())
            ->count();

        return [
            'active_jobs_count' => $activeJobsCount,
            'total_applications' => $totalApplications,
            'pending_jobs_count' => $pendingJobsCount,
            'new_applications_today' => $newApplicationsToday,
        ];
    }

    private function employmentTypes(): array
    {
        return [
            'full_time' => 'Full-time',
            'part_time' => 'Part-time',
            'contract' => 'Contract',
            'temporary' => 'Temporary',
            'internship' => 'Internship',
            'freelance' => 'Freelance',
        ];
    }

    private function normalizeJobStatusForStorage(string $requestedStatus): string
    {
        $fallback = 'active';

        try {
            $result = DB::selectOne("SHOW COLUMNS FROM `peso_jobs` LIKE 'status'");

            if (! $result || ! isset($result->Type)) {
                return $requestedStatus;
            }

            if (! str_starts_with($result->Type, 'enum(')) {
                return $requestedStatus;
            }

            preg_match_all("/'([^']+)'/", $result->Type, $matches);
            $allowedStatuses = $matches[1] ?? [];

            if (in_array($requestedStatus, $allowedStatuses, true)) {
                return $requestedStatus;
            }

            if (in_array($fallback, $allowedStatuses, true)) {
                return $fallback;
            }

            return $allowedStatuses[0] ?? $requestedStatus;
        } catch (\Throwable) {
            return $requestedStatus;
        }
    }

    private function applicationStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'reviewing' => 'Under Review',
            'shortlisted' => 'Shortlisted',
            'interview' => 'Interview Scheduled',
            'hired' => 'Hired',
            'rejected' => 'Rejected',
            default => ucfirst($status),
        };
    }
}
