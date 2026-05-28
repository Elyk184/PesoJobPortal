<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\PesoClearance;
use App\Models\PortalNotification;
use App\Models\EmployerNotification;
use App\Models\UserNotification;
use App\Models\UserProfile;
use App\Models\JobseekerPersonalInformation;
use App\Models\JobseekerAddress;
use App\Models\JobseekerEducation;
use App\Models\JobseekerTraining;
use App\Models\JobseekerExperience;
use App\Models\JobseekerEligibility;
use App\Models\JobseekerSkill;
use App\Models\JobseekerSkillsMeta;
use App\Models\JobseekerEmploymentStatus;
use App\Models\JobseekerJobPreference;
use App\Models\JobseekerLanguage;
use App\Models\JobseekerDisability;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class JobseekerController extends Controller
{
    // =========================================================================
    // DASHBOARD
    // =========================================================================

    public function dashboard(Request $request): View
    {
        $user   = Auth::user();
        $userId = $user?->id;

        // Load the normalized profile data for this user
        $profileData = $userId ? $this->loadProfileData($userId) : null;

        $activeJobsCount  = PesoJob::query()->where('status', 'active')->count();
        $sampleJobsCount  = count($this->sampleVacancies());
        $profileCompletionPercent = $this->calculateProfileCompletionPercent($user, $profileData);

        $jobsThisWeek = PesoJob::query()
            ->where('status', 'active')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $recommendedJobs              = $this->buildProfileBasedRecommendations($profileData);
        $isProfileMatchedRecommendations = $recommendedJobs->isNotEmpty();

        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = PesoJob::query()
                ->where('status', 'active')
                ->latest()
                ->limit(3)
                ->get()
                ->map(fn (PesoJob $job) => [
                    'title'            => $job->title,
                    'location'         => $job->location,
                    'employer_name'    => $job->employer_name,
                    'salary_range'     => $job->salary_range,
                    'description'      => $job->description,
                    'requirements_list'=> $this->extractJobRequirements($job),
                ])
                ->values();
        }

        $recentlyViewedJobIds = collect($request->session()->get('jobseeker_recently_viewed_job_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        $recentlyViewedJobs = collect();

        if ($recentlyViewedJobIds->isNotEmpty()) {
            $recentlyViewedMap = PesoJob::query()
                ->where('status', 'active')
                ->whereIn('id', $recentlyViewedJobIds->all())
                ->get()
                ->keyBy('id');

            $recentlyViewedJobs = $recentlyViewedJobIds
                ->map(fn ($id) => $recentlyViewedMap->get($id))
                ->filter()
                ->take(3)
                ->map(fn (PesoJob $job) => [
                    'title'         => $job->title,
                    'location'      => $job->location,
                    'employer_name' => $job->employer_name,
                    'salary_range'  => $job->salary_range,
                    'description'   => $job->description,
                ])
                ->values();
        }

        $isUsingSampleRecommendations = false;

        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = collect($this->sampleVacancies())->take(3)->values();
            $isUsingSampleRecommendations = true;
        }

        $applicationStatusCounts = [
            'pending'     => 0,
            'interview'   => 0,
            'hired'       => 0,
            'recommended' => 0,
            'total'       => 0,
        ];

        if ($userId) {
            $rawApplicationCounts = JobApplication::query()
                ->where('user_id', $userId)
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status');

            $applicationStatusCounts['pending']     = (int) ($rawApplicationCounts['pending']    ?? 0);
            $applicationStatusCounts['interview']   = (int) ($rawApplicationCounts['interviewed'] ?? 0);
            $applicationStatusCounts['hired']       = (int) ($rawApplicationCounts['hired']       ?? 0);
            $applicationStatusCounts['recommended'] = (int) ($rawApplicationCounts['reviewed']    ?? 0);
            $applicationStatusCounts['total']       = (int) $rawApplicationCounts->sum();
        }

        $applicationsThisWeek = $userId
            ? JobApplication::query()
                ->where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(7))
                ->count()
            : 0;

        $interviewsThisWeek = $userId
            ? JobApplication::query()
                ->where('user_id', $userId)
                ->where('status', 'interviewed')
                ->where('updated_at', '>=', now()->subDays(7))
                ->count()
            : 0;

        if ($request->query('notifications') === 'read') {
            $request->session()->put('jobseeker_notifications_read_at', now()->toIso8601String());
        }

        $notifications = collect();

        if ($profileCompletionPercent < 100) {
            $notifications->push([
                'type'       => 'profile',
                'priority'   => 'medium',
                'icon'       => 'bi-person-lines-fill',
                'title'      => 'Complete your profile',
                'message'    => 'Your profile is only ' . $profileCompletionPercent . '% complete. Add missing details to improve job matches.',
                'url'        => route('jobseeker.profile'),
                'created_at' => now(),
            ]);
        }

        if ($applicationStatusCounts['interview'] > 0) {
            $notifications->push([
                'type'       => 'interview',
                'priority'   => 'high',
                'icon'       => 'bi-mic',
                'title'      => 'Interview updates available',
                'message'    => 'You have ' . $applicationStatusCounts['interview'] . ' application(s) in interview status.',
                'url'        => route('jobseeker.applications', ['status' => 'interview']),
                'created_at' => now()->subMinutes(10),
            ]);
        }

        if ($applicationStatusCounts['pending'] > 0) {
            $notifications->push([
                'type'       => 'pending',
                'priority'   => 'medium',
                'icon'       => 'bi-hourglass-split',
                'title'      => 'Pending applications for review',
                'message'    => 'You currently have ' . $applicationStatusCounts['pending'] . ' pending application(s).',
                'url'        => route('jobseeker.applications', ['status' => 'pending']),
                'created_at' => now()->subMinutes(20),
            ]);
        }

        if ($jobsThisWeek > 0) {
            $notifications->push([
                'type'       => 'jobs',
                'priority'   => 'low',
                'icon'       => 'bi-briefcase',
                'title'      => 'New job posts this week',
                'message'    => $jobsThisWeek . ' new active job(s) were posted in the last 7 days.',
                'url'        => route('jobseeker.browse-jobs'),
                'created_at' => now()->subHours(1),
            ]);
        }

        $notifications = $notifications->sortByDesc('created_at')->values();

        $notificationsReadAt    = $request->session()->get('jobseeker_notifications_read_at');
        $notificationsReadAt    = $notificationsReadAt ? Carbon::parse($notificationsReadAt) : null;
        $unreadNotificationsCount = $notificationsReadAt
            ? $notifications->filter(fn ($item) => Carbon::parse($item['created_at'])->gt($notificationsReadAt))->count()
            : $notifications->count();

        $skillGapAnalysis = $this->buildSkillGapAnalysis($profileData);

        return view('jobseeker.dashboard', [
            'availableJobsCount'              => $activeJobsCount > 0 ? $activeJobsCount : $sampleJobsCount,
            'profileCompletionPercent'        => $profileCompletionPercent,
            'profileCompletionLabel'          => $this->profileCompletionLabel($profileCompletionPercent),
            'recommendedJobs'                 => $recommendedJobs,
            'isUsingSampleRecommendations'    => $isUsingSampleRecommendations,
            'isProfileMatchedRecommendations' => $isProfileMatchedRecommendations,
            'applicationStatusCounts'         => $applicationStatusCounts,
            'dashboardNotifications'          => $notifications,
            'unreadNotificationsCount'        => $unreadNotificationsCount,
            'recentlyViewedJobs'              => $recentlyViewedJobs,
            'recentlyViewedCount'             => $recentlyViewedJobIds->count(),
            'kpiTrends'                       => [
                'jobsThisWeek'         => $jobsThisWeek,
                'applicationsThisWeek' => $applicationsThisWeek,
                'interviewsThisWeek'   => $interviewsThisWeek,
            ],
            'skillGapAnalysis' => $skillGapAnalysis,
        ]);
    }

    // =========================================================================
    // VACANCIES / BROWSE JOBS
    // =========================================================================

    public function vacancies(Request $request): RedirectResponse
    {
        return redirect()->route('jobseeker.browse-jobs');
    }

    public function browseJobs(Request $request): View
    {
        $jobsQuery = PesoJob::query()
            ->activeApproved()
            ->with(['employer.companyProfile']);

        $search         = trim((string) $request->query('search', ''));
        $location       = trim((string) $request->query('location', ''));
        $industry       = trim((string) $request->query('industry', ''));
        $barangay       = trim((string) $request->query('barangay', ''));
        $employmentType = trim((string) $request->query('employment_type', ''));
        $sort           = (string) $request->query('sort', 'newest');

        if ($search !== '') {
            $jobsQuery->where(function ($q) use ($search) {
                $q->where('title',        'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('employer_name','like', '%' . $search . '%')
                  ->orWhere('location',    'like', '%' . $search . '%')
                  ->orWhere('requirements','like', '%' . $search . '%');
            });
        }

        if ($location !== '') {
            $jobsQuery->where('location', 'like', '%' . $location . '%');
        }

        if ($employmentType !== '') {
            $jobsQuery->where('job_type', $employmentType);
        }

        if ($industry !== '') {
            $jobsQuery->whereHas('employer.companyProfile', fn ($q) => $q->where('industry', $industry));
        }

        if ($barangay !== '') {
            $jobsQuery->whereHas('employer.companyProfile', fn ($q) => $q->where('barangay', $barangay));
        }

        match ($sort) {
            'expiring'    => $jobsQuery->orderBy('application_end_date', 'asc'),
            'salary_high' => $jobsQuery->orderByDesc('salary'),
            'salary_low'  => $jobsQuery->orderBy('salary'),
            default       => $jobsQuery->latest(),
        };

        $locations = PesoJob::query()->activeApproved()
            ->whereNotNull('location')->where('location', '!=', '')
            ->distinct()->orderBy('location')->pluck('location')->values();

        $industries = CompanyProfile::query()
            ->whereNotNull('industry')->where('industry', '!=', '')
            ->distinct()->orderBy('industry')->pluck('industry')->values();

        $barangays = CompanyProfile::query()
            ->whereNotNull('barangay')->where('barangay', '!=', '')
            ->distinct()->orderBy('barangay')->pluck('barangay')->values();

        $jobs = $jobsQuery->paginate(10)->withQueryString();
        $jobs->getCollection()->transform(function (PesoJob $job) {
            $job->setAttribute('requirements_list', $this->extractJobRequirements($job));
            return $job;
        });

        return view('jobseeker.browse-jobs', compact('jobs', 'locations', 'industries', 'barangays'));
    }

    // =========================================================================
    // APPLICATIONS
    // =========================================================================

    public function applications(Request $request): View
    {
        $statusMap = [
            'all'         => ['pending', 'reviewed', 'interview', 'interviewed', 'hired', 'rejected'],
            'pending'     => ['pending'],
            'reviewing'   => ['reviewed'],
            'shortlisted' => ['reviewed'],
            'interview'   => ['interview', 'interviewed'],
            'hired'       => ['hired'],
            'rejected'    => ['rejected'],
        ];

        $statusFilter = (string) $request->query('status', 'all');
        if (! array_key_exists($statusFilter, $statusMap)) {
            $statusFilter = 'all';
        }

        $userId = (int) Auth::id();

        $applications = JobApplication::query()
            ->where('user_id', $userId)
            ->whereIn('status', $statusMap[$statusFilter])
            ->with('job')
            ->orderByDesc('applied_at')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $rawStatusCounts = JobApplication::query()
            ->where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $statusCounts = [
            'all'         => (int) $rawStatusCounts->sum(),
            'pending'     => (int) ($rawStatusCounts['pending']  ?? 0),
            'reviewing'   => (int) ($rawStatusCounts['reviewed'] ?? 0),
            'shortlisted' => (int) ($rawStatusCounts['reviewed'] ?? 0),
            'interview'   => (int) (($rawStatusCounts['interview'] ?? 0) + ($rawStatusCounts['interviewed'] ?? 0)),
            'hired'       => (int) ($rawStatusCounts['hired']    ?? 0),
            'rejected'    => (int) ($rawStatusCounts['rejected'] ?? 0),
        ];

        return view('jobseeker.applications', compact('applications', 'statusCounts', 'statusFilter'));
    }

    // =========================================================================
    // RECOMMENDATIONS
    // =========================================================================

    public function recommendations(Request $request): View
    {
        $user        = $request->user();
        $profileData = $user ? $this->loadProfileData($user->id) : null;
        $recommendations  = $this->buildProfileBasedRecommendations($profileData);
        $profileHasSkills = $this->hasSkillsDetails($profileData);
        $activeJobsCount  = PesoJob::query()->where('status', 'active')->count();
        $appliedJobsCount = $user ? JobApplication::query()->where('user_id', $user->id)->count() : 0;

        return view('jobseeker.recommendations', [
            'recommendations'  => $recommendations,
            'recommendedCount' => $recommendations->count(),
            'activeJobsCount'  => $activeJobsCount,
            'appliedJobsCount' => $appliedJobsCount,
            'profileHasSkills' => $profileHasSkills,
        ]);
    }

    // =========================================================================
    // NOTIFICATIONS
    // =========================================================================

    public function notifications(Request $request): View
    {
        $userId = (int) $request->user()->id;

        $notifications = UserNotification::query()
            ->where('user_id', $userId)
            ->with('portalNotification')
            ->latest('id')
            ->limit(50)
            ->get();

        return view('jobseeker.notifications', [
            'notifications'        => $notifications,
            'unreadCount'          => (int) $notifications->whereNull('read_at')->count(),
            'latestNotificationId' => (int) ($notifications->max('id') ?? 0),
        ]);
    }

    public function notificationsFeed(Request $request): JsonResponse
    {
        $userId  = (int) $request->user()->id;
        $afterId = max(0, (int) $request->query('after_id', 0));

        $newNotifications = UserNotification::query()
            ->where('user_id', $userId)
            ->where('id', '>', $afterId)
            ->with('portalNotification')
            ->latest('id')
            ->get();

        $items    = $newNotifications->map(fn (UserNotification $n) => [
            'id'      => $n->id,
            'title'   => (string) data_get($n, 'portalNotification.title', 'Notification'),
            'message' => (string) data_get($n, 'portalNotification.message', ''),
        ])->values();

        $latestId   = $newNotifications->isNotEmpty() ? (int) $newNotifications->max('id') : $afterId;
        $unreadCount = UserNotification::query()->where('user_id', $userId)->whereNull('read_at')->count();

        return response()->json(['items' => $items, 'latest_id' => $latestId, 'unread_count' => (int) $unreadCount]);
    }

    public function markNotificationAsRead(Request $request, UserNotification $userNotification): JsonResponse
    {
        if ((int) $userNotification->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        if ($userNotification->read_at === null) {
            $userNotification->forceFill(['read_at' => now()])->save();
        }

        $unreadCount = UserNotification::query()
            ->where('user_id', (int) $request->user()->id)
            ->whereNull('read_at')
            ->count();

        return response()->json(['ok' => true, 'unread_count' => (int) $unreadCount]);
    }

    // =========================================================================
    // SKILL GAP
    // =========================================================================

    public function skillGap(): View
    {
        $user        = Auth::user();
        $profileData = $user ? $this->loadProfileData($user->id) : null;

        return view('jobseeker.skill-gap', [
            'skillGapAnalysis' => $this->buildSkillGapAnalysis($profileData),
        ]);
    }

    // =========================================================================
    // SAVED JOBS
    // =========================================================================

    public function savedJobs(): View
    {
        $userId      = (int) Auth::id();
        $savedJobIds = SavedJob::query()->where('user_id', $userId)->pluck('job_id')->all();
        $savedJobs   = collect();

        if (! empty($savedJobIds)) {
            $savedJobs = PesoJob::query()
                ->whereIn('id', $savedJobIds)
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(fn (PesoJob $job) => [
                    'id'               => $job->id,
                    'title'            => $job->title,
                    'location'         => $job->location,
                    'employer_name'    => $job->employer_name,
                    'salary_range'     => $job->salary_range,
                    'description'      => $job->description,
                    'requirements_list'=> $this->extractJobRequirements($job),
                    'created_at'       => $job->created_at,
                ]);
        }

        return view('jobseeker.saved-jobs', ['savedJobs' => $savedJobs, 'savedCount' => $savedJobs->count()]);
    }

    public function toggleSaveJob(PesoJob $job): JsonResponse|RedirectResponse
    {
        $userId   = (int) Auth::id();
        $existing = SavedJob::query()->where('user_id', $userId)->where('job_id', $job->id)->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            SavedJob::create(['user_id' => $userId, 'job_id' => $job->id]);
            $saved = true;
        }

        $savedCount = SavedJob::query()->where('user_id', $userId)->count();

        if (! request()->expectsJson()) {
            return $saved
                ? redirect()->route('jobseeker.saved-jobs')->with('success', 'Job saved to your bookmarks.')
                : back()->with('success', 'Job removed from your saved jobs.');
        }

        return response()->json(['saved' => $saved, 'saved_count' => $savedCount]);
    }

    // =========================================================================
    // PESO CLEARANCE
    // =========================================================================

    public function pesoClearance(): View
    {
        $userId = (int) Auth::id();

        $clearance = PesoClearance::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'expired'])
            ->latest('id')->first();

        $pendingRequest = PesoClearance::query()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->latest('id')->first();

        $hasClearance      = $clearance !== null;
        $isActive          = $hasClearance && $clearance->status === 'active';
        $isExpired         = $hasClearance && $clearance->expiry_date && $clearance->expiry_date->isPast();
        $hasPendingRequest = $pendingRequest !== null;

        if ($isExpired && $isActive) {
            $isActive = false;
        }

        return view('jobseeker.peso-clearance', [
            'clearance'          => $clearance,
            'pendingRequest'     => $pendingRequest,
            'hasClearance'       => $hasClearance,
            'hasPendingRequest'  => $hasPendingRequest,
            'isActive'           => $isActive,
            'isExpired'          => $isExpired,
            'canRequestClearance'=> ! $hasPendingRequest,
        ]);
    }

    public function requestPesoClearance(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'remarks'                          => ['nullable', 'string', 'max:500'],
            'peso_clearance_assurance_receipt' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'barangay_clearance'               => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'is_first_time_jobseeker'          => ['nullable', 'boolean'],
            'first_time_jobseeker_document'    => ['required_if:is_first_time_jobseeker,1', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if (PesoClearance::query()->where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('warning', 'You already have a pending PESO clearance request.');
        }

        $clearanceCount              = PesoClearance::query()->where('user_id', $user->id)->count();
        $pesoClearanceReceiptPath    = $request->file('peso_clearance_assurance_receipt')->store('peso-clearance/assurance-receipts', 'public');
        $barangayClearancePath       = $request->file('barangay_clearance')->store('peso-clearance/barangay-clearances', 'public');
        $firstTimeJobseekerDocPath   = $request->hasFile('first_time_jobseeker_document')
            ? $request->file('first_time_jobseeker_document')->store('peso-clearance/first-time-jobseeker-docs', 'public')
            : null;

        PesoClearance::create([
            'user_id'                               => $user->id,
            'request_date'                          => now(),
            'clearance_number'                      => 'REQ-' . now()->format('YmdHis') . '-' . str_pad((string) ($clearanceCount + 1), 3, '0', STR_PAD_LEFT),
            'issue_date'                            => null,
            'expiry_date'                           => null,
            'status'                                => 'pending',
            'remarks'                               => trim((string) $request->input('remarks', '')) ?: 'PESO clearance request submitted by jobseeker.',
            'peso_clearance_assurance_receipt_path' => $pesoClearanceReceiptPath,
            'barangay_clearance_path'               => $barangayClearancePath,
            'is_first_time_jobseeker'               => $request->boolean('is_first_time_jobseeker'),
            'first_time_jobseeker_document_path'    => $firstTimeJobseekerDocPath,
        ]);

        $adminIds = User::query()->where('role', 'admin')->pluck('id')->all();

        if (! empty($adminIds)) {
            $portalNotification = PortalNotification::create([
                'title'      => 'New PESO Clearance Request',
                'message'    => sprintf(
                    '%s submitted a PESO clearance request%s. Go to PESO Clearances to review the attached documents.',
                    $user->name ?? 'A jobseeker',
                    $request->boolean('is_first_time_jobseeker') ? ' as a first-time jobseeker' : ''
                ),
                'created_by' => $user->id,
            ]);

            UserNotification::query()->insert(
                collect($adminIds)->map(fn ($adminId) => [
                    'user_id'                => $adminId,
                    'portal_notification_id' => $portalNotification->id,
                    'read_at'                => null,
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ])->all()
            );
        }

        return back()->with('status', 'Your PESO clearance request has been sent to the admin for review.');
    }

    // =========================================================================
    // PROFILE — VIEW
    // =========================================================================

    public function profile(): View
    {
        return view('jobseeker.profile', $this->profileFormData(Auth::user()));
    }

    // =========================================================================
    // PROFILE — SAVE
    // =========================================================================

    public function saveProfile(Request $request): RedirectResponse
    {
        $user   = $request->user();
        $userId = $user->id;

        $validated = $request->validate([
            'personal_information.surname'        => ['required', 'string', 'max:100'],
            'personal_information.first_name'     => ['required', 'string', 'max:100'],
            'personal_information.middle_initial' => ['nullable', 'string', 'max:10'],
            'personal_information.suffix'         => ['nullable', 'string', 'max:20'],
            'personal_information.date_of_birth'  => ['nullable', 'date'],
            'personal_information.sex'            => ['nullable', 'in:Male,Female'],
            'personal_information.religion'       => ['nullable', 'string', 'max:100'],
            'personal_information.civil_status'   => ['nullable', 'string', 'max:50'],
            'personal_information.height'         => ['nullable', 'numeric'],
            'personal_information.tin'            => ['nullable', 'string', 'max:20'],
            'personal_information.contact_number' => ['nullable', 'string', 'max:50'],
            'personal_information.email_address'  => ['nullable', 'email', 'max:255'],
            'education_currently_in_school'       => ['nullable', 'boolean'],

            'present_address.house_no'     => ['nullable', 'string', 'max:255'],
            'present_address.barangay'     => ['nullable', 'string', 'max:100'],
            'present_address.municipality' => ['nullable', 'string', 'max:100'],
            'present_address.province'     => ['nullable', 'string', 'max:100'],

            'permanent_address.same_as_present' => ['nullable', 'boolean'],
            'permanent_address.house_no'        => ['nullable', 'string', 'max:255'],
            'permanent_address.barangay'        => ['nullable', 'string', 'max:100'],
            'permanent_address.municipality'    => ['nullable', 'string', 'max:100'],
            'permanent_address.province'        => ['nullable', 'string', 'max:100'],

            'education'           => ['nullable', 'array'],
            'education.*.school'  => ['nullable', 'string', 'max:255'],
            'education.*.course'  => ['nullable', 'string', 'max:255'],
            'education.*.year'    => ['nullable', 'string', 'max:20'],

            'training'                  => ['nullable', 'array'],
            'training.*.course'         => ['nullable', 'string', 'max:255'],
            'training.*.hours'          => ['nullable', 'string', 'max:10'],
            'training.*.institution'    => ['nullable', 'string', 'max:255'],
            'training.*.dates'          => ['nullable', 'string', 'max:100'],
            'training.*.skills'         => ['nullable', 'string', 'max:1000'],
            'training.*.certificates'   => ['nullable', 'string', 'max:255'],

            'experience'                  => ['nullable', 'array'],
            'experience.*.company'        => ['nullable', 'string', 'max:255'],
            'experience.*.title'          => ['nullable', 'string', 'max:255'],
            'experience.*.location'       => ['nullable', 'string', 'max:255'],
            'experience.*.status'         => ['nullable', 'string', 'max:50'],
            'experience.*.from_date'      => ['nullable', 'string', 'max:50'],
            'experience.*.to_date'        => ['nullable', 'string', 'max:50'],
            'experience.*.salary_amount'  => ['nullable', 'string', 'max:50'],
            'experience.*.salary_type'    => ['nullable', 'string', 'max:50'],
            'experience.*.details'        => ['nullable', 'string', 'max:2000'],
            'work_experience_has'         => ['nullable', 'boolean'],

            'eligibility'               => ['nullable', 'array'],
            'eligibility.*.eligibility' => ['nullable', 'string', 'max:255'],
            'eligibility.*.date_taken'  => ['nullable', 'string', 'max:50'],
            'eligibility.*.license'     => ['nullable', 'string', 'max:255'],
            'eligibility.*.valid_until' => ['nullable', 'string', 'max:50'],

            'other_skills.trade_manual'     => ['nullable', 'array'],
            'other_skills.it_technical'     => ['nullable', 'array'],
            'other_skills.soft_skills'      => ['nullable', 'array'],
            'other_skills.other_text'       => ['nullable', 'string', 'max:255'],
            'other_skills.with_certificate' => ['nullable', 'boolean'],
            'other_skills.by_experience'    => ['nullable', 'boolean'],

            'employment_status.wage_employed' => ['nullable', 'boolean'],
            'employment_status.self_employed' => ['nullable', 'boolean'],
            'employment_status.unemployed'    => ['nullable', 'boolean'],

            'job_preferences.part_time'       => ['nullable', 'boolean'],
            'job_preferences.full_time'       => ['nullable', 'boolean'],
            'job_preferences.local'           => ['nullable', 'boolean'],
            'job_preferences.overseas'        => ['nullable', 'boolean'],
            'job_preferences.occupation_text' => ['nullable', 'string', 'max:1000'],

            'languages'              => ['nullable', 'array'],
            'languages.*.language'   => ['nullable', 'string', 'max:100'],
            'languages.*.read'       => ['nullable', 'boolean'],
            'languages.*.write'      => ['nullable', 'boolean'],
            'languages.*.speak'      => ['nullable', 'boolean'],
            'languages.*.understand' => ['nullable', 'boolean'],
            'languages.*.other'      => ['nullable', 'string', 'max:100'],

            'disability.visual'     => ['nullable', 'boolean'],
            'disability.speech'     => ['nullable', 'boolean'],
            'disability.mental'     => ['nullable', 'boolean'],
            'disability.hearing'    => ['nullable', 'boolean'],
            'disability.physical'   => ['nullable', 'boolean'],
            'disability.other'      => ['nullable', 'boolean'],
            'disability.other_text' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($userId, $validated, $user) {

            $personal       = $validated['personal_information'] ?? [];
            $presentAddr    = $validated['present_address']      ?? [];
            $permanentRaw   = $validated['permanent_address']    ?? [];
            $sameAsPresent  = (bool) ($permanentRaw['same_as_present'] ?? false);
            $permanentAddr  = $sameAsPresent ? $presentAddr : $permanentRaw;

            // ── 1. Personal Information ──────────────────────────────────
            JobseekerPersonalInformation::updateOrCreate(
                ['user_id' => $userId],
                [
                    'first_name'          => $personal['first_name']     ?? null,
                    'middle_initial'      => $personal['middle_initial'] ?? null,
                    'surname'             => $personal['surname']         ?? null,
                    'suffix'              => $personal['suffix']          ?? null,
                    'date_of_birth'       => $personal['date_of_birth']  ?? null,
                    'sex'                 => $personal['sex']             ?? null,
                    'religion'            => $personal['religion']        ?? null,
                    'civil_status'        => $personal['civil_status']   ?? null,
                    'height'              => is_numeric($personal['height'] ?? null) ? $personal['height'] : null,
                    'tin'                 => $personal['tin']             ?? null,
                    'contact_number'      => $personal['contact_number'] ?? null,
                    'email_address'       => $personal['email_address']  ?? null,
                    'currently_in_school' => (bool) ($validated['education_currently_in_school'] ?? false),
                ]
            );

            // ── 2. Addresses ─────────────────────────────────────────────
            JobseekerAddress::updateOrCreate(
                ['user_id' => $userId, 'type' => 'present'],
                [
                    'house_no'     => $presentAddr['house_no']     ?? null,
                    'barangay'     => $presentAddr['barangay']     ?? null,
                    'municipality' => $presentAddr['municipality'] ?? null,
                    'province'     => $presentAddr['province']     ?? null,
                ]
            );

            JobseekerAddress::updateOrCreate(
                ['user_id' => $userId, 'type' => 'permanent'],
                [
                    'house_no'     => $permanentAddr['house_no']     ?? null,
                    'barangay'     => $permanentAddr['barangay']     ?? null,
                    'municipality' => $permanentAddr['municipality'] ?? null,
                    'province'     => $permanentAddr['province']     ?? null,
                ]
            );

            // ── 3. Education (replace all) ───────────────────────────────
            JobseekerEducation::where('user_id', $userId)->delete();
            foreach (($validated['education'] ?? []) as $i => $row) {
                if (collect($row)->filter()->isEmpty()) continue;
                JobseekerEducation::create([
                    'user_id'    => $userId,
                    'school'     => $row['school'] ?? null,
                    'course'     => $row['course'] ?? null,
                    'year'       => $row['year']   ?? null,
                    'sort_order' => $i,
                ]);
            }

            // ── 4. Training (replace all) ────────────────────────────────
            JobseekerTraining::where('user_id', $userId)->delete();
            foreach (($validated['training'] ?? []) as $i => $row) {
                if (collect($row)->filter()->isEmpty()) continue;
                JobseekerTraining::create([
                    'user_id'         => $userId,
                    'course'          => $row['course']       ?? null,
                    'hours'           => is_numeric($row['hours'] ?? null) ? (int) $row['hours'] : null,
                    'institution'     => $row['institution']  ?? null,
                    'inclusive_dates' => $row['dates']        ?? null,
                    'skills_acquired' => $row['skills']       ?? null,
                    'certificates'    => $row['certificates'] ?? null,
                    'sort_order'      => $i,
                ]);
            }

            // ── 5. Experience (replace all) ──────────────────────────────
            JobseekerExperience::where('user_id', $userId)->delete();
            foreach (($validated['experience'] ?? []) as $i => $row) {
                if (collect($row)->filter()->isEmpty()) continue;
                $salaryRaw = $row['salary_amount'] ?? null;
                JobseekerExperience::create([
                    'user_id'       => $userId,
                    'company'       => $row['company']     ?? null,
                    'title'         => $row['title']       ?? null,
                    'location'      => $row['location']    ?? null,
                    'status'        => $row['status']      ?? null,
                    'from_date'     => $row['from_date']   ?? null,
                    'to_date'       => $row['to_date']     ?? null,
                    'salary_amount' => is_numeric($salaryRaw) ? $salaryRaw : null,
                    'salary_type'   => $row['salary_type'] ?? null,
                    'details'       => $row['details']     ?? null,
                    'sort_order'    => $i,
                ]);
            }

            // ── 6. Eligibility (replace all) ─────────────────────────────
            JobseekerEligibility::where('user_id', $userId)->delete();
            foreach (($validated['eligibility'] ?? []) as $i => $row) {
                if (collect($row)->filter()->isEmpty()) continue;
                JobseekerEligibility::create([
                    'user_id'     => $userId,
                    'eligibility' => $row['eligibility'] ?? null,
                    'date_taken'  => $row['date_taken']  ?? null,
                    'license'     => $row['license']     ?? null,
                    'valid_until' => $row['valid_until'] ?? null,
                    'sort_order'  => $i,
                ]);
            }

            // ── 7. Skills (replace all) ───────────────────────────────────
            JobseekerSkill::where('user_id', $userId)->delete();

            $skillCategories = [
                'trade_manual' => $validated['other_skills']['trade_manual'] ?? [],
                'it_technical' => $validated['other_skills']['it_technical'] ?? [],
                'soft_skills'  => $validated['other_skills']['soft_skills']  ?? [],
            ];

            foreach ($skillCategories as $category => $skills) {
                foreach ((array) $skills as $skill) {
                    $skill = trim((string) $skill);
                    if ($skill !== '') {
                        JobseekerSkill::create([
                            'user_id'  => $userId,
                            'category' => $category,
                            'skill'    => $skill,
                        ]);
                    }
                }
            }

            $otherSkillText = trim((string) ($validated['other_skills']['other_text'] ?? ''));
            if ($otherSkillText !== '') {
                JobseekerSkill::create([
                    'user_id'  => $userId,
                    'category' => 'other',
                    'skill'    => $otherSkillText,
                ]);
            }

            // ── 8. Skills Meta ────────────────────────────────────────────
            JobseekerSkillsMeta::updateOrCreate(
                ['user_id' => $userId],
                [
                    'other_enabled'    => $otherSkillText !== '' ? 1 : 0,
                    'other_text'       => $otherSkillText ?: null,
                    'with_certificate' => (bool) ($validated['other_skills']['with_certificate'] ?? false),
                    'by_experience'    => (bool) ($validated['other_skills']['by_experience']    ?? false),
                ]
            );

            // ── 9. Employment Status ──────────────────────────────────────
            JobseekerEmploymentStatus::updateOrCreate(
                ['user_id' => $userId],
                [
                    'has_work_experience' => (bool) ($validated['work_experience_has']             ?? false),
                    'wage_employed'       => (bool) ($validated['employment_status']['wage_employed'] ?? false),
                    'self_employed'       => (bool) ($validated['employment_status']['self_employed'] ?? false),
                    'unemployed'          => (bool) ($validated['employment_status']['unemployed']    ?? false),
                ]
            );

            // ── 10. Job Preferences ───────────────────────────────────────
            JobseekerJobPreference::updateOrCreate(
                ['user_id' => $userId],
                [
                    'part_time'       => (bool) ($validated['job_preferences']['part_time']  ?? false),
                    'full_time'       => (bool) ($validated['job_preferences']['full_time']  ?? false),
                    'local'           => (bool) ($validated['job_preferences']['local']      ?? false),
                    'overseas'        => (bool) ($validated['job_preferences']['overseas']   ?? false),
                    'occupation_text' => trim((string) ($validated['job_preferences']['occupation_text'] ?? '')),
                ]
            );

            // ── 11. Languages (replace all) ───────────────────────────────
            JobseekerLanguage::where('user_id', $userId)->delete();
            foreach (($validated['languages'] ?? []) as $i => $row) {
                $lang  = trim((string) ($row['language'] ?? ''));
                $other = trim((string) ($row['other']    ?? ''));
                if ($lang === '' && $other === '') continue;
                JobseekerLanguage::create([
                    'user_id'        => $userId,
                    'language'       => $lang  !== '' ? $lang  : 'Others',
                    'other_specify'  => $other !== '' ? $other : null,
                    'can_read'       => (bool) ($row['read']       ?? false),
                    'can_write'      => (bool) ($row['write']      ?? false),
                    'can_speak'      => (bool) ($row['speak']      ?? false),
                    'can_understand' => (bool) ($row['understand'] ?? false),
                    'sort_order'     => $i,
                ]);
            }

            // ── 12. Disability ─────────────────────────────────────────────
            JobseekerDisability::updateOrCreate(
                ['user_id' => $userId],
                [
                    'visual'     => (bool) ($validated['disability']['visual']    ?? false),
                    'speech'     => (bool) ($validated['disability']['speech']    ?? false),
                    'mental'     => (bool) ($validated['disability']['mental']    ?? false),
                    'hearing'    => (bool) ($validated['disability']['hearing']   ?? false),
                    'physical'   => (bool) ($validated['disability']['physical']  ?? false),
                    'other'      => (bool) ($validated['disability']['other']     ?? false),
                    'other_text' => trim((string) ($validated['disability']['other_text'] ?? '')) ?: null,
                ]
            );

            // ── 13. Update user display name ───────────────────────────────
            $fullName = collect([
                $personal['first_name']     ?? '',
                $personal['middle_initial'] ?? '',
                $personal['surname']        ?? '',
                $personal['suffix']         ?? '',
            ])->filter()->join(' ');

            if ($fullName !== '') {
                $user->name = $fullName;
                $user->save();
            }
        });

        return redirect()
            ->route('jobseeker.profile')
            ->with('status', 'Profile saved successfully.');
    }

    // =========================================================================
    // RESUME BUILDER
    // =========================================================================

    public function resumeBuilder(): View
    {
        return view('jobseeker.resume-builder', $this->resumeBuilderData(Auth::user()));
    }

    public function exportResumeBuilder(): Response
    {
        $data = $this->resumeBuilderData(Auth::user());
        $pdf  = Pdf::loadView('jobseeker.resume-builder-pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->download(trim(($data['resumeName'] ?: 'resume') . '-harvard-style.pdf'));
    }

    public function saveResumeBuilder(Request $request): RedirectResponse
    {
        $user      = $request->user();
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'email'               => ['required', 'email', 'max:255'],
            'phone'               => ['nullable', 'string', 'max:50'],
            'address'             => ['nullable', 'string', 'max:500'],
            'objective'           => ['nullable', 'string', 'max:1000'],
            'skills'              => ['nullable', 'string', 'max:1000'],
            'education'           => ['nullable', 'array'],
            'education.*.school'  => ['nullable', 'string', 'max:255'],
            'education.*.course'  => ['nullable', 'string', 'max:255'],
            'education.*.year'    => ['nullable', 'string', 'max:50'],
            'experience'          => ['nullable', 'array'],
            'experience.*.title'  => ['nullable', 'string', 'max:255'],
            'experience.*.company'=> ['nullable', 'string', 'max:255'],
            'experience.*.period' => ['nullable', 'string', 'max:100'],
            'experience.*.details'=> ['nullable', 'string', 'max:1000'],
        ]);

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id'      => $user->id,
                'resume_name'  => $validated['name'],
                'resume_email' => $validated['email'],
                'phone'        => $validated['phone']    ?? null,
                'address'      => $validated['address']  ?? null,
                'objective'    => $validated['objective']?? null,
                'skills'       => $this->normalizeList($validated['skills'] ?? ''),
                'education'    => $this->normalizeResumeSection($validated['education']  ?? [], ['school', 'course', 'year']),
                'experience'   => $this->normalizeResumeSection($validated['experience'] ?? [], ['title', 'company', 'period', 'details']),
            ]
        );

        return redirect()->route('jobseeker.resume-builder')->with('status', 'Resume builder saved successfully.');
    }

    public function resetResumeBuilder(Request $request): RedirectResponse
    {
        $profile = $request->user()?->profile;

        if ($profile) {
            $profile->update(['resume_name' => '', 'resume_email' => '', 'objective' => '', 'resume_path' => null]);
        }

        return redirect()->route('jobseeker.resume-builder')->with('status', 'Resume builder reset successfully.');
    }

    // =========================================================================
    // APPLY FOR JOB
    // =========================================================================

    public function applyJob(PesoJob $job): View
    {
        return view('jobseeker.apply-job', ['job' => $job->load(['employer', 'employer.companyProfile'])]);
    }

    public function submitApplication(Request $request, PesoJob $job): RedirectResponse
    {
        $user      = $request->user();
        $validated = $request->validate([
            'letter'            => ['nullable', 'string', 'max:2000'],
            'resume'            => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'resume_type'       => ['required', 'in:upload,builder'],
            'use_resume_builder'=> ['nullable', 'boolean'],
        ]);

        $existingApplication = JobApplication::where('user_id', $user->id)->where('peso_job_id', $job->id)->first();
        if ($existingApplication) {
            return redirect()->route('jobseeker.applications')->with('error', 'You have already applied for this job.');
        }

        $resumePath = null;
        $resumeType = $validated['resume_type'];

        if ($request->hasFile('resume')) {
            $resumeType = 'upload';
        }

        if ($resumeType === 'upload') {
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
            } else {
                return redirect()->back()->withInput()->with('error', 'Please upload a resume or select another resume option.');
            }
        } elseif ($resumeType === 'builder') {
            $userProfile = $user->profile ?? $user->userProfile;
            if ($userProfile && $userProfile->resume_name && $userProfile->resume_email) {
                $resumePath = 'builder:' . $userProfile->id;
            } else {
                return redirect()->back()->withInput()->with('error', 'No resume found in Resume Builder. Please create one or upload a resume.');
            }
        }

        JobApplication::create([
            'user_id'     => $user->id,
            'peso_job_id' => $job->id,
            'status'      => 'pending',
            'notes'       => $validated['letter'] ?? null,
            'resume_path' => $resumePath,
            'resume_type' => $resumeType,
        ]);

        if (! empty($job->employer_id)) {
            try {
                EmployerNotification::query()->create([
                    'employer_id' => $job->employer_id,
                    'type'        => 'job_update',
                    'title'       => 'New Job Application Received',
                    'message'     => sprintf('%s applied for "%s". Review this in View Applicants or Notifications.', $user->name, $job->title),
                    'is_read'     => false,
                ]);
            } catch (\Throwable) {
                try {
                    EmployerNotification::query()->create([
                        'employer_id' => $job->employer_id,
                        'type'        => 'general',
                        'title'       => 'New Job Application Received',
                        'message'     => sprintf('%s applied for "%s". Review this in View Applicants or Notifications.', $user->name, $job->title),
                        'is_read'     => false,
                    ]);
                } catch (\Throwable) {
                    // Intentionally ignored
                }
            }
        }

        return redirect()->route('jobseeker.applications')->with('status', 'Application submitted successfully!');
    }

    // =========================================================================
    // PRIVATE — LOAD PROFILE DATA FROM NORMALIZED TABLES
    // =========================================================================

    /**
     * Load all profile data for a user from the normalized tables into a
     * single array that the rest of the controller can work with uniformly.
     *
     * @return array|null  Returns null if the user has no personal info row yet.
     */
    private function loadProfileData(int $userId): ?array
    {
        $personal    = JobseekerPersonalInformation::where('user_id', $userId)->first();
        $presentAddr = JobseekerAddress::where('user_id', $userId)->where('type', 'present')->first();
        $permAddr    = JobseekerAddress::where('user_id', $userId)->where('type', 'permanent')->first();

        // Return null if the user has never saved a profile yet
        if (! $personal) {
            return null;
        }

        $education = JobseekerEducation::where('user_id', $userId)
            ->orderBy('sort_order')->get()
            ->map(fn ($r) => ['school' => $r->school, 'course' => $r->course, 'year' => $r->year])
            ->all();

        $training = JobseekerTraining::where('user_id', $userId)
            ->orderBy('sort_order')->get()
            ->map(fn ($r) => [
                'course'       => $r->course,
                'hours'        => (string) ($r->hours ?? ''),
                'institution'  => $r->institution,
                'dates'        => $r->inclusive_dates,
                'skills'       => $r->skills_acquired,
                'certificates' => $r->certificates,
            ])->all();

        $experience = JobseekerExperience::where('user_id', $userId)
            ->orderBy('sort_order')->get()
            ->map(fn ($r) => [
                'company'       => $r->company,
                'title'         => $r->title,
                'location'      => $r->location,
                'status'        => $r->status,
                'from_date'     => $r->from_date,
                'to_date'       => $r->to_date,
                'salary_amount' => (string) ($r->salary_amount ?? ''),
                'salary_type'   => $r->salary_type,
                'details'       => $r->details,
            ])->all();

        $eligibility = JobseekerEligibility::where('user_id', $userId)
            ->orderBy('sort_order')->get()
            ->map(fn ($r) => [
                'eligibility' => $r->eligibility,
                'date_taken'  => $r->date_taken,
                'license'     => $r->license,
                'valid_until' => $r->valid_until,
            ])->all();

        // Skills grouped by category
        $skillRows   = JobseekerSkill::where('user_id', $userId)->get();
        $skillsMeta  = JobseekerSkillsMeta::where('user_id', $userId)->first();

        $otherSkills = [
            'trade_manual'    => $skillRows->where('category', 'trade_manual')->pluck('skill')->all(),
            'it_technical'    => $skillRows->where('category', 'it_technical')->pluck('skill')->all(),
            'soft_skills'     => $skillRows->where('category', 'soft_skills')->pluck('skill')->all(),
            'other_text'      => $skillsMeta?->other_text ?? '',
            'with_certificate'=> (bool) ($skillsMeta?->with_certificate ?? false),
            'by_experience'   => (bool) ($skillsMeta?->by_experience    ?? false),
        ];

        // Flat skills list for recommendation/gap analysis
        $skills = collect([
            ...$otherSkills['trade_manual'],
            ...$otherSkills['it_technical'],
            ...$otherSkills['soft_skills'],
            $otherSkills['other_text'],
        ])->filter()->unique()->values()->all();

        $empStatus  = JobseekerEmploymentStatus::where('user_id', $userId)->first();
        $jobPref    = JobseekerJobPreference::where('user_id', $userId)->first();
        $disability = JobseekerDisability::where('user_id', $userId)->first();

        $languages = JobseekerLanguage::where('user_id', $userId)
            ->orderBy('sort_order')->get()
            ->map(fn ($r) => [
                'language'   => $r->language,
                'read'       => (bool) $r->can_read,
                'write'      => (bool) $r->can_write,
                'speak'      => (bool) $r->can_speak,
                'understand' => (bool) $r->can_understand,
                'other'      => $r->other_specify ?? '',
            ])->all();

        return [
            // Personal
            'personal_information' => [
                'first_name'          => $personal->first_name,
                'middle_initial'      => $personal->middle_initial,
                'surname'             => $personal->surname,
                'suffix'              => $personal->suffix,
                'date_of_birth'       => $personal->date_of_birth,
                'sex'                 => $personal->sex,
                'religion'            => $personal->religion,
                'civil_status'        => $personal->civil_status,
                'height'              => $personal->height,
                'tin'                 => $personal->tin,
                'contact_number'      => $personal->contact_number,
                'email_address'       => $personal->email_address,
                'currently_in_school' => (bool) $personal->currently_in_school,
            ],
            // Addresses
            'present_address' => [
                'house_no'     => $presentAddr?->house_no,
                'barangay'     => $presentAddr?->barangay,
                'municipality' => $presentAddr?->municipality,
                'province'     => $presentAddr?->province,
            ],
            'permanent_address' => [
                'house_no'     => $permAddr?->house_no,
                'barangay'     => $permAddr?->barangay,
                'municipality' => $permAddr?->municipality,
                'province'     => $permAddr?->province,
            ],
            // Sections
            'education'   => $education,
            'training'    => $training,
            'experience'  => $experience,
            'eligibility' => $eligibility,
            // Skills
            'skills'      => $skills,
            'other_skills'=> $otherSkills,
            // Status / preferences
            'employment_status' => [
                'wage_employed'      => (bool) ($empStatus?->wage_employed       ?? false),
                'self_employed'      => (bool) ($empStatus?->self_employed       ?? false),
                'unemployed'         => (bool) ($empStatus?->unemployed          ?? false),
                'has_work_experience'=> (bool) ($empStatus?->has_work_experience ?? false),
            ],
            'job_preferences' => [
                'part_time'       => (bool) ($jobPref?->part_time  ?? false),
                'full_time'       => (bool) ($jobPref?->full_time  ?? false),
                'local'           => (bool) ($jobPref?->local      ?? false),
                'overseas'        => (bool) ($jobPref?->overseas   ?? false),
                'occupation_text' => $jobPref?->occupation_text ?? '',
            ],
            'languages'  => $languages,
            'disability' => [
                'visual'     => (bool) ($disability?->visual    ?? false),
                'speech'     => (bool) ($disability?->speech    ?? false),
                'mental'     => (bool) ($disability?->mental    ?? false),
                'hearing'    => (bool) ($disability?->hearing   ?? false),
                'physical'   => (bool) ($disability?->physical  ?? false),
                'other'      => (bool) ($disability?->other     ?? false),
                'other_text' => $disability?->other_text ?? '',
            ],
        ];
    }

    // =========================================================================
    // PRIVATE — PROFILE FORM DATA (for the profile edit view)
    // =========================================================================

    private function profileFormData(?User $user): array
    {
        $userId      = $user?->id;
        $profileData = $userId ? $this->loadProfileData($userId) : null;
        $displayName = trim((string) ($user?->name ?? ''));
        $nameParts   = $this->splitDisplayName($displayName);

        // Merge saved data over defaults so the form is pre-filled
        $personal = $profileData['personal_information'] ?? [];

        $personalInformation = [
            'surname'             => $personal['surname']        ?? $nameParts['surname'],
            'first_name'         => $personal['first_name']     ?? $nameParts['first_name'],
            'middle_initial'     => $personal['middle_initial'] ?? $nameParts['middle_initial'],
            'suffix'             => $personal['suffix']         ?? $nameParts['suffix'],
            'date_of_birth'      => $personal['date_of_birth']  ?? '',
            'sex'                => $personal['sex']            ?? '',
            'religion'           => $personal['religion']       ?? '',
            'civil_status'       => $personal['civil_status']   ?? '',
            'height'             => $personal['height']         ?? '',
            'tin'                => $personal['tin']            ?? '',
            'contact_number'     => $personal['contact_number'] ?? '',
            'email_address'      => $personal['email_address']  ?? $user?->email ?? '',
            'currently_in_school'=> $personal['currently_in_school'] ?? false,
        ];

        $presentAddress = array_merge(
            ['house_no' => '', 'barangay' => '', 'municipality' => '', 'province' => ''],
            $profileData['present_address'] ?? []
        );

        $permanentAddress = array_merge(
            ['same_as_present' => false, 'house_no' => '', 'barangay' => '', 'municipality' => '', 'province' => ''],
            $profileData['permanent_address'] ?? []
        );

        $educationRows  = ! empty($profileData['education'])  ? $profileData['education']  : [['school' => '', 'course' => '', 'year' => '']];
        $trainingRows   = ! empty($profileData['training'])   ? $profileData['training']   : [['course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '']];
        $experienceRows = ! empty($profileData['experience']) ? $profileData['experience'] : [['company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '']];
        $eligibilityRows= ! empty($profileData['eligibility'])? $profileData['eligibility']: [['eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '']];

        $otherSkills      = $profileData['other_skills']      ?? $this->defaultOtherSkills();
        $employmentStatus = $profileData['employment_status'] ?? $this->defaultEmploymentStatus();
        $jobPreferences   = $profileData['job_preferences']   ?? $this->defaultJobPreferences();
        $languages        = ! empty($profileData['languages']) ? $profileData['languages'] : $this->defaultLanguages();
        $disability       = $profileData['disability']        ?? $this->defaultDisability();

        // UserProfile is still used for resume builder only
        $userProfile = $user?->profile;

        return [
            'user'               => $user,
            'profile'            => $profileData,   // now an array, not an Eloquent model
            'personalInformation'=> $personalInformation,
            'presentAddress'     => $presentAddress,
            'permanentAddress'   => $permanentAddress,
            'educationRows'      => $educationRows,
            'trainingRows'       => $trainingRows,
            'experienceRows'     => $experienceRows,
            'eligibilityRows'    => $eligibilityRows,
            'otherSkills'        => $otherSkills,
            'employmentStatus'   => $employmentStatus,
            'jobPreferences'     => $jobPreferences,
            'languages'          => $languages,
            'disability'         => $disability,
            'resumeFileName'     => $userProfile?->resume_path ? basename($userProfile->resume_path) : null,
            'resumeFileUrl'      => $userProfile?->resume_path ? asset('storage/' . ltrim($userProfile->resume_path, '/')) : null,
        ];
    }

    // =========================================================================
    // PRIVATE — RESUME BUILDER DATA
    // =========================================================================

    private function resumeBuilderData(?User $user): array
    {
        $profile = $user?->profile;   // UserProfile (resume builder model)
        $userId  = $user?->id;

        $isResumeReset = $profile && $profile->resume_name === '' && $profile->resume_email === '';

        // Pull profile data from normalized tables to pre-populate the resume builder
        $profileData    = $userId ? $this->loadProfileData($userId) : null;
        $profilePersonal= $profileData['personal_information'] ?? [];
        $profileSkills  = $profileData['skills'] ?? [];

        $resumeName    = old('name',      $isResumeReset ? '' : ($profile?->resume_name  ?? $this->buildResumeNameFromProfile($user, $profilePersonal)));
        $resumeEmail   = old('email',     $isResumeReset ? '' : ($profile?->resume_email ?? data_get($profilePersonal, 'email_address', $user?->email ?? '')));
        $resumePhone   = old('phone',     $isResumeReset ? '' : ($profile?->phone        ?? data_get($profilePersonal, 'contact_number', '')));
        $resumeAddress = old('address',   $isResumeReset ? '' : ($profile?->address      ?? $this->formatAddress($profileData['present_address'] ?? [])));
        $resumeObjective= old('objective',$isResumeReset ? '' : ($profile?->objective    ?? $this->buildResumeObjectiveFromProfile($profilePersonal, $profileData)));
        $resumeSkills  = old('skills',    $isResumeReset ? '' : implode(', ', $profileSkills ?: ($profile?->skills ?? [])));

        $educationRows  = old('education',  $isResumeReset ? [] : ($profileData['education']  ?? []));
        $trainingRows   = old('training',   $isResumeReset ? [] : ($profileData['training']   ?? []));
        $experienceRows = old('experience', $isResumeReset ? [] : ($profileData['experience'] ?? []));
        $eligibilityRows= old('eligibility',$isResumeReset ? [] : ($profileData['eligibility']?? []));

        return [
            'user'           => $user,
            'profile'        => $profile,
            'resumeName'     => $resumeName,
            'resumeEmail'    => $resumeEmail,
            'resumePhone'    => $resumePhone,
            'resumeAddress'  => $resumeAddress,
            'resumeObjective'=> $resumeObjective,
            'resumeSkills'   => $resumeSkills,
            'educationRows'  => $educationRows,
            'trainingRows'   => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows'=> $eligibilityRows,
            'skillsPreview'  => collect(explode(',', $resumeSkills))->map(fn ($s) => trim($s))->filter()->values(),
        ];
    }

    // =========================================================================
    // PRIVATE — PROFILE COMPLETION
    // =========================================================================

    private function calculateProfileCompletionPercent(?User $user, ?array $profileData): int
    {
        $checks = [
            $this->hasBasicIdentity($user, $profileData),
            $this->hasContactDetails($user, $profileData),
            $this->hasAddressDetails($profileData),
            $this->hasEducationDetails($profileData),
            $this->hasExperienceDetails($profileData),
            $this->hasSkillsDetails($profileData),
        ];

        $completed = collect($checks)->filter()->count();
        return (int) round(($completed / count($checks)) * 100);
    }

    private function profileCompletionLabel(int $percent): string
    {
        if ($percent >= 100) return 'Profile Complete';
        if ($percent >= 67)  return 'Almost Complete';
        if ($percent >= 34)  return 'In Progress';
        return 'Getting Started';
    }

    private function hasBasicIdentity(?User $user, ?array $profileData): bool
    {
        $personal  = $profileData['personal_information'] ?? [];
        $firstName = trim((string) ($personal['first_name'] ?? ''));
        $surname   = trim((string) ($personal['surname']    ?? ''));

        if ($firstName !== '' && $surname !== '') return true;

        return trim((string) ($user?->name ?? '')) !== '';
    }

    private function hasContactDetails(?User $user, ?array $profileData): bool
    {
        $personal = $profileData['personal_information'] ?? [];
        $email    = trim((string) ($personal['email_address']  ?? $user?->email  ?? ''));
        $phone    = trim((string) ($personal['contact_number'] ?? ''));

        return $email !== '' && $phone !== '';
    }

    private function hasAddressDetails(?array $profileData): bool
    {
        $addr = $profileData['present_address'] ?? [];
        return trim((string) ($addr['barangay']     ?? '')) !== ''
            && trim((string) ($addr['municipality'] ?? '')) !== ''
            && trim((string) ($addr['province']     ?? '')) !== '';
    }

    private function hasEducationDetails(?array $profileData): bool
    {
        return ! empty($profileData['education'] ?? []);
    }

    private function hasExperienceDetails(?array $profileData): bool
    {
        return ! empty($profileData['experience'] ?? []);
    }

    private function hasSkillsDetails(?array $profileData): bool
    {
        $skills      = $profileData['skills']       ?? [];
        $otherSkills = $profileData['other_skills'] ?? [];

        if (! empty($skills)) return true;

        return ! empty($otherSkills['trade_manual'])
            || ! empty($otherSkills['it_technical'])
            || ! empty($otherSkills['soft_skills'])
            || trim((string) ($otherSkills['other_text'] ?? '')) !== '';
    }

    // =========================================================================
    // PRIVATE — RECOMMENDATIONS & SKILL GAP
    // =========================================================================

    private function buildProfileBasedRecommendations(?array $profileData)
    {
        $signals = $this->buildRecommendationSignalsFromProfile($profileData);

        if (collect($signals)->flatten()->isEmpty()) {
            return collect();
        }

        $activeJobs = PesoJob::query()->where('status', 'active')->latest()->limit(40)->get();

        $rankedJobs = $activeJobs
            ->map(function (PesoJob $job) use ($signals) {
                $matchDetails = $this->buildJobMatchDetails($job, $signals);
                return [
                    'job'           => $job,
                    'score'         => $matchDetails['score'],
                    'match_reasons' => $matchDetails['reasons'],
                    'created_at'    => $job->created_at?->getTimestamp() ?? 0,
                ];
            })
            ->filter(fn ($item) => $item['score'] > 0)
            ->sort(function ($left, $right) {
                if ($left['score'] === $right['score']) {
                    return $right['created_at'] <=> $left['created_at'];
                }
                return $right['score'] <=> $left['score'];
            })
            ->take(3)
            ->values();

        return $rankedJobs->map(function ($item) {
            $job = $item['job'];
            return [
                'title'             => $job->title,
                'location'          => $job->location,
                'employer_name'     => $job->employer_name,
                'salary_range'      => $job->salary_range,
                'description'       => $job->description,
                'requirements_list' => $this->extractJobRequirements($job),
                'match_score'       => $item['score'],
                'match_reasons'     => $item['match_reasons'],
            ];
        })->values();
    }

    private function buildRecommendationSignalsFromProfile(?array $profileData): array
    {
        if (! $profileData) {
            return ['skills' => [], 'occupations' => [], 'experience' => [], 'locations' => []];
        }

        $otherSkills = $profileData['other_skills'] ?? [];

        $skills = collect($profileData['skills'] ?? [])
            ->merge($otherSkills['trade_manual'] ?? [])
            ->merge($otherSkills['it_technical'] ?? [])
            ->merge($otherSkills['soft_skills']  ?? [])
            ->push((string) ($otherSkills['other_text'] ?? ''))
            ->all();

        $occupationPref  = (string) ($profileData['job_preferences']['occupation_text'] ?? '');
        $experienceTitles= collect($profileData['experience'] ?? [])->pluck('title')->all();

        $addr = $profileData['present_address'] ?? [];
        $locations = [
            (string) ($addr['barangay']     ?? ''),
            (string) ($addr['municipality'] ?? ''),
            (string) ($addr['province']     ?? ''),
        ];

        return [
            'skills'      => $this->normalizeRecommendationTerms($skills),
            'occupations' => $this->normalizeRecommendationTerms([$occupationPref]),
            'experience'  => $this->normalizeRecommendationTerms($experienceTitles),
            'locations'   => $this->normalizeRecommendationTerms($locations),
        ];
    }

    private function buildSkillGapAnalysis(?array $profileData): array
    {
        $empty = ['hasData' => false, 'userSkills' => [], 'marketSkills' => [], 'matchedSkills' => [], 'missingSkills' => [], 'coveragePercent' => 0, 'totalMarketSkills' => 0];

        if (! $profileData) return $empty;

        $otherSkills = $profileData['other_skills'] ?? [];

        $userSkills = collect($profileData['skills'] ?? [])
            ->merge($otherSkills['trade_manual'] ?? [])
            ->merge($otherSkills['it_technical'] ?? [])
            ->merge($otherSkills['soft_skills']  ?? [])
            ->push((string) ($otherSkills['other_text'] ?? ''));

        // Training skills
        $userSkills = $userSkills->merge(
            collect($profileData['training'] ?? [])
                ->pluck('skills')->filter()
                ->flatMap(fn ($t) => collect(preg_split('/[\r\n,]+/', (string) $t) ?: [])->map(fn ($s) => trim($s))->filter())
        );

        // Experience titles
        $userSkills = $userSkills->merge(
            collect($profileData['experience'] ?? [])->pluck('title')->filter()->map(fn ($t) => trim((string) $t))
        );

        $occupationPref = trim((string) ($profileData['job_preferences']['occupation_text'] ?? ''));
        if ($occupationPref !== '') $userSkills->push($occupationPref);

        $normalizedUserSkills = $userSkills
            ->map(fn ($s) => mb_strtolower(trim((string) $s)))
            ->filter(fn ($s) => mb_strlen($s) >= 2)
            ->unique()->values()->all();

        $activeJobs = PesoJob::query()->where('status', 'active')->get(['title', 'description', 'requirements', 'preferred_skills']);
        $marketSkillFrequency = [];

        foreach ($activeJobs as $job) {
            $jobText = implode(' ', [(string) $job->title, (string) $job->description, (string) $job->getRawOriginal('requirements'), (string) $job->preferred_skills]);
            foreach ($this->extractSkillCandidatesFromText($jobText) as $candidate) {
                $normalized = mb_strtolower(trim($candidate));
                if (mb_strlen($normalized) < 3) continue;
                $marketSkillFrequency[$normalized] = ($marketSkillFrequency[$normalized] ?? 0) + 1;
            }
        }

        arsort($marketSkillFrequency);
        $topMarketSkills = collect($marketSkillFrequency)->take(20)->keys()->values()->all();

        $matchedSkills = [];
        $missingSkills = [];

        foreach ($topMarketSkills as $marketSkill) {
            $isMatched = false;
            foreach ($normalizedUserSkills as $userSkill) {
                if (str_contains($marketSkill, $userSkill) || str_contains($userSkill, $marketSkill)) {
                    $isMatched = true;
                    break;
                }
            }
            $isMatched ? ($matchedSkills[] = $marketSkill) : ($missingSkills[] = $marketSkill);
        }

        $total           = count($topMarketSkills);
        $coveragePercent = $total > 0 ? (int) round((count($matchedSkills) / $total) * 100) : 0;

        return [
            'hasData'          => true,
            'userSkills'       => array_slice($normalizedUserSkills, 0, 15),
            'marketSkills'     => array_slice($topMarketSkills, 0, 10),
            'matchedSkills'    => array_slice($matchedSkills, 0, 10),
            'missingSkills'    => array_slice($missingSkills, 0, 10),
            'coveragePercent'  => $coveragePercent,
            'totalMarketSkills'=> $total,
        ];
    }

    // =========================================================================
    // PRIVATE — HELPERS
    // =========================================================================

    private function normalizeList(?string $value): array
    {
        if (! $value) return [];
        return collect(preg_split('/[\r\n,]+/', $value) ?: [])
            ->map(fn ($item) => trim($item))->filter()->values()->all();
    }

    private function normalizeResumeSection(array $rows, array $allowedKeys): array
    {
        return collect($rows)
            ->map(function ($row) use ($allowedKeys) {
                $clean = [];
                foreach ($allowedKeys as $key) {
                    $clean[$key] = trim((string) ($row[$key] ?? ''));
                }
                return $clean;
            })
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->values()->all();
    }

    private function normalizeRecommendationTerms(array $rawValues): array
    {
        $stopWords = ['the', 'and', 'for', 'with', 'from', 'that', 'this', 'are', 'your', 'you', 'job', 'work'];

        return collect($rawValues)
            ->map(fn ($v) => trim(mb_strtolower((string) $v)))
            ->filter()
            ->flatMap(function ($value) {
                $parts    = collect(preg_split('/[\r\n,\/|]+/', $value) ?: [])->map(fn ($p) => trim((string) $p))->filter();
                $expanded = [];
                foreach ($parts as $part) {
                    $expanded[] = $part;
                    foreach (preg_split('/\s+/', $part) ?: [] as $word) {
                        $word = trim((string) $word);
                        if ($word !== '') $expanded[] = $word;
                    }
                }
                return $expanded;
            })
            ->map(fn ($term) => trim((string) $term, " \t\n\r\0\x0B.-_"))
            ->filter(fn ($term) => mb_strlen($term) >= 3)
            ->reject(fn ($term) => in_array($term, $stopWords, true))
            ->unique()->values()->all();
    }

    private function buildJobMatchDetails(PesoJob $job, array $signals): array
    {
        $requirementsText = implode(' ', $this->extractJobRequirements($job));
        $haystack = mb_strtolower(implode(' ', [(string) $job->title, (string) $job->description, (string) $job->employer_name, (string) $job->location, $requirementsText]));

        $skillsMatches    = $this->countTermMatches($haystack, $signals['skills']      ?? []);
        $occupationMatches= $this->countTermMatches($haystack, $signals['occupations'] ?? []);
        $experienceMatches= $this->countTermMatches($haystack, $signals['experience']  ?? []);
        $locationMatches  = $this->countTermMatches($haystack, $signals['locations']   ?? []);

        $score = ($skillsMatches * 6) + ($occupationMatches * 8) + ($experienceMatches * 4) + ($locationMatches * 3);

        $reasons = collect([
            $occupationMatches > 0 ? 'Occupation Preference' : null,
            $skillsMatches     > 0 ? 'Skills Match'         : null,
            $experienceMatches > 0 ? 'Experience Match'     : null,
            $locationMatches   > 0 ? 'Location Match'       : null,
        ])->filter()->values()->all();

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function countTermMatches(string $haystack, array $terms): int
    {
        return collect($terms)
            ->filter(fn ($term) => $term !== '' && str_contains($haystack, mb_strtolower((string) $term)))
            ->count();
    }

    private function extractJobRequirements(PesoJob $job): array
    {
        $requirements = $job->requirements;
        if (is_array($requirements) && ! empty($requirements)) {
            return collect($requirements)->map(fn ($item) => trim((string) $item))->filter()->values()->all();
        }

        $rawRequirements = trim((string) $job->getRawOriginal('requirements'));
        if ($rawRequirements === '') return [];

        return collect(preg_split('/[\r\n,]+/', $rawRequirements) ?: [])
            ->map(fn ($item) => trim((string) $item))->filter()->values()->all();
    }

    private function extractSkillCandidatesFromText(string $text): array
    {
        $text       = mb_strtolower($text);
        $parts      = preg_split('#[\r\n,;·•|/\\\\]+#u', $text) ?: [$text];
        $candidates = [];
        $stopWords  = ['and','the','for','with','from','that','this','are','your','you','job','work','must','should','will','can','able','years','year','experience','required','preferred','qualifications','responsibilities','duties'];

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') continue;
            $cleanPart = trim(preg_replace('/^[-\s•·]+/', '', $part));
            if (mb_strlen($cleanPart) >= 3 && mb_strlen($cleanPart) <= 60) {
                $words          = preg_split('/\s+/', $cleanPart) ?: [];
                $hasOnlyStop    = true;
                foreach ($words as $w) {
                    if (! in_array($w, $stopWords, true)) { $hasOnlyStop = false; break; }
                }
                if (! $hasOnlyStop) $candidates[] = $cleanPart;
            }
        }

        foreach (preg_split('/[\s,;·•()]+/', $text) ?: [] as $word) {
            $word = trim($word, " \t\n\r\0\x0B.-_()");
            if (mb_strlen($word) >= 4 && mb_strlen($word) <= 25 && ! in_array($word, $stopWords, true)) {
                $candidates[] = $word;
            }
        }

        return $candidates;
    }

    private function formatAddress(array $address): string
    {
        return collect([
            $address['house_no']     ?? '',
            $address['barangay']     ?? '',
            $address['municipality'] ?? '',
            $address['province']     ?? '',
        ])->filter()->join(', ');
    }

    private function buildResumeNameFromProfile(?User $user, array $personalInformation): string
    {
        $parts = collect([
            data_get($personalInformation, 'first_name',     ''),
            data_get($personalInformation, 'middle_initial', ''),
            data_get($personalInformation, 'surname',        ''),
            data_get($personalInformation, 'suffix',         ''),
        ])->filter();

        return $parts->isNotEmpty() ? $parts->join(' ') : trim((string) ($user?->name ?? ''));
    }

    private function buildResumeObjectiveFromProfile(array $personalInformation, ?array $profileData): string
    {
        $occupation = trim((string) ($profileData['job_preferences']['occupation_text'] ?? ''));
        $skillText  = collect($profileData['skills'] ?? [])->take(3)->implode(', ');

        if ($occupation !== '' && $skillText !== '') {
            return 'To secure a position in ' . $occupation . ' where I can apply my skills in ' . $skillText . ' and contribute to organizational success.';
        }
        if ($occupation !== '') {
            return 'To secure a position in ' . $occupation . ' where I can contribute my skills and experience to a growing organization.';
        }
        if ($skillText !== '') {
            return 'To secure a position where I can apply my skills in ' . $skillText . ' and contribute to organizational success.';
        }

        $firstName = trim((string) data_get($personalInformation, 'first_name', ''));
        return $firstName !== '' ? 'To secure a position where I can apply my skills and contribute to the success of the organization.' : '';
    }

    private function splitDisplayName(string $displayName): array
    {
        $segments = collect(preg_split('/\s+/', trim($displayName)) ?: [])->filter()->values()->all();
        $suffixes = ['jr', 'jr.', 'sr', 'sr.', 'ii', 'iii', 'iv', 'v'];
        $suffix   = '';

        if (! empty($segments)) {
            $lastSegment = strtolower(rtrim((string) end($segments), ','));
            if (in_array($lastSegment, $suffixes, true)) {
                $suffix = array_pop($segments);
            }
        }

        $firstName     = $segments[0] ?? '';
        $middleInitial = '';
        $surname       = '';

        if (count($segments) === 2) {
            $surname = $segments[1] ?? '';
        } elseif (count($segments) === 3) {
            $secondSegment = (string) ($segments[1] ?? '');
            if (preg_match('/^[A-Za-z]\.?$/', $secondSegment)) {
                $middleInitial = $secondSegment;
                $surname       = $segments[2] ?? '';
            } else {
                $firstName = trim(($segments[0] ?? '') . ' ' . $secondSegment);
                $surname   = $segments[2] ?? '';
            }
        } elseif (count($segments) > 3) {
            $penultimate = (string) ($segments[count($segments) - 2] ?? '');
            if (preg_match('/^[A-Za-z]\.?$/', $penultimate)) {
                $surname       = array_pop($segments) ?? '';
                $middleInitial = array_pop($segments) ?? '';
                $firstName     = implode(' ', $segments);
            } else {
                $firstName = implode(' ', array_slice($segments, 0, 2));
                $surname   = array_pop($segments) ?? '';
            }
        }

        return ['first_name' => $firstName, 'middle_initial' => $middleInitial, 'surname' => $surname, 'suffix' => $suffix];
    }

    private function defaultOtherSkills(): array
    {
        return ['trade_manual' => [], 'it_technical' => [], 'soft_skills' => [], 'other_text' => '', 'with_certificate' => false, 'by_experience' => false];
    }

    private function defaultEmploymentStatus(): array
    {
        return ['wage_employed' => false, 'self_employed' => false, 'unemployed' => false, 'has_work_experience' => null];
    }

    private function defaultJobPreferences(): array
    {
        return ['part_time' => false, 'full_time' => false, 'local' => false, 'overseas' => false, 'occupation_text' => ''];
    }

    private function defaultLanguages(): array
    {
        return [
            ['language' => 'English', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Tagalog', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Visayan', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Others:', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
        ];
    }

    private function defaultDisability(): array
    {
        return ['visual' => false, 'speech' => false, 'mental' => false, 'hearing' => false, 'physical' => false, 'other' => false, 'other_text' => ''];
    }

    private function sampleVacancies(): array
    {
        return [
            ['title' => 'Office Staff / Admin Assistant', 'location' => 'Tankulan (Poblacion)', 'employer_name' => 'PESO Partner Office',         'salary_range' => 'Php 12,000 - Php 15,000', 'description' => 'Handles office documents, data encoding, filing, and front desk support.',                          'requirements_list' => ['MS Office', 'Filing', 'Encoding']],
            ['title' => 'Construction Laborer',           'location' => 'Damilag',              'employer_name' => 'Local Construction Contractor','salary_range' => 'Php 450/day',              'description' => 'Assists in basic construction tasks and follows workplace safety procedures.',                    'requirements_list' => ['Basic tools', 'Safety awareness']],
            ['title' => 'Cashier',                        'location' => 'Alae',                 'employer_name' => 'Community Retail Store',       'salary_range' => 'Php 11,500 - Php 13,000', 'description' => 'Handles customer payments, POS transactions, and end-of-day cash balancing.',                  'requirements_list' => ['Customer service', 'POS']],
            ['title' => 'Delivery Driver',                'location' => 'San Miguel',           'employer_name' => 'Local Logistics Partner',      'salary_range' => 'Php 13,000 - Php 16,000', 'description' => 'Delivers goods within Manolo Fortich and nearby routes with proper documentation.',            'requirements_list' => ['Driver license', 'Route familiarity']],
            ['title' => 'Sales Associate',                'location' => 'Santo Nino',           'employer_name' => 'Neighborhood Mart',            'salary_range' => 'Php 10,500 - Php 12,500', 'description' => 'Supports product display, customer assistance, and sales transactions.',                       'requirements_list' => ['Selling skills', 'Communication']],
            ['title' => 'Warehouse Helper',               'location' => 'Agusan Canyon',        'employer_name' => 'Agri Supply Distributor',      'salary_range' => 'Php 430/day',              'description' => 'Assists in loading, unloading, inventory checks, and stock arrangement.',                     'requirements_list' => ['Inventory handling', 'Physical fitness']],
        ];
    }
}