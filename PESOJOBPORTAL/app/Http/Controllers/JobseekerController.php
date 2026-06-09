<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\PesoJob;
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
use App\Models\SavedJob;
use App\Models\PesoClearance;
use App\Models\PortalNotification;
use App\Models\EmployerNotification;
use App\Models\UserNotification;
use App\Models\UserProfile;
use App\Models\JobseekerProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class JobseekerController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = Auth::user();
        $profile = $user?->profile;
        $userId = $user?->id;
        $activeJobsCount = PesoJob::query()->where('status', 'active')->count();
        $sampleJobsCount = count($this->sampleVacancies());
        $profileCompletionPercent = $this->calculateProfileCompletionPercent($user, $profile);
        $jobsThisWeek = PesoJob::query()
            ->where('status', 'active')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $recommendedJobs = $this->buildProfileBasedRecommendations($profile);
        $isProfileMatchedRecommendations = $recommendedJobs->isNotEmpty();

        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = PesoJob::query()
                ->where('status', 'active')
                ->latest()
                ->limit(3)
                ->get()
                ->map(function (PesoJob $job) {
                    return [
                        'title' => $job->title,
                        'location' => $job->location,
                        'employer_name' => $job->employer_name,
                        'salary_range' => $job->salary_range,
                        'description' => $job->description,
                        'requirements_list' => $this->extractJobRequirements($job),
                    ];
                })
                ->values();
        }

        $savedJobsCount = $userId
            ? SavedJob::query()->where('user_id', $userId)->count()
            : 0;

        $isUsingSampleRecommendations = false;

        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = collect($this->sampleVacancies())
                ->take(3)
                ->values();
            $isUsingSampleRecommendations = true;
        }

        $applicationStatusCounts = [
            'pending' => 0,
            'interview' => 0,
            'hired' => 0,
            'recommended' => 0,
            'total' => 0,
        ];

        if ($userId) {
            $rawApplicationCounts = JobApplication::query()
                ->where('user_id', $userId)
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status');

            $applicationStatusCounts['pending'] = (int) ($rawApplicationCounts['pending'] ?? 0);
            $applicationStatusCounts['interview'] = (int) (($rawApplicationCounts['interview'] ?? 0) + ($rawApplicationCounts['interviewed'] ?? 0));
            $applicationStatusCounts['hired'] = (int) ($rawApplicationCounts['hired'] ?? 0);
            $applicationStatusCounts['recommended'] = (int) (($rawApplicationCounts['reviewing'] ?? 0) + ($rawApplicationCounts['reviewed'] ?? 0) + ($rawApplicationCounts['shortlisted'] ?? 0));
            $applicationStatusCounts['total'] = (int) $rawApplicationCounts->sum();
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
                ->whereIn('status', ['interview', 'interviewed'])
                ->where('updated_at', '>=', now()->subDays(7))
                ->count()
            : 0;

        if ($request->query('notifications') === 'read') {
            $request->session()->put('jobseeker_notifications_read_at', now()->toIso8601String());
        }

        $notifications = collect();

        if ($profileCompletionPercent < 100) {
            $notifications->push([
                'type' => 'profile',
                'priority' => 'medium',
                'icon' => 'bi-person-lines-fill',
                'title' => 'Complete your profile',
                'message' => 'Your profile is only ' . $profileCompletionPercent . '% complete. Add missing details to improve job matches.',
                'url' => route('jobseeker.profile'),
                'created_at' => now(),
            ]);
        }

        if ($applicationStatusCounts['interview'] > 0) {
            $notifications->push([
                'type' => 'interview',
                'priority' => 'high',
                'icon' => 'bi-mic',
                'title' => 'Interview updates available',
                'message' => 'You have ' . $applicationStatusCounts['interview'] . ' application(s) in interview status.',
                'url' => route('jobseeker.applications', ['status' => 'interview']),
                'created_at' => now()->subMinutes(10),
            ]);
        }

        if ($applicationStatusCounts['pending'] > 0) {
            $notifications->push([
                'type' => 'pending',
                'priority' => 'medium',
                'icon' => 'bi-hourglass-split',
                'title' => 'Pending applications for review',
                'message' => 'You currently have ' . $applicationStatusCounts['pending'] . ' pending application(s).',
                'url' => route('jobseeker.applications', ['status' => 'pending']),
                'created_at' => now()->subMinutes(20),
            ]);
        }

        if ($jobsThisWeek > 0) {
            $notifications->push([
                'type' => 'jobs',
                'priority' => 'low',
                'icon' => 'bi-briefcase',
                'title' => 'New job posts this week',
                'message' => $jobsThisWeek . ' new active job(s) were posted in the last 7 days.',
                'url' => route('jobseeker.browse-jobs'),
                'created_at' => now()->subHours(1),
            ]);
        }

        $notifications = $notifications
            ->sortByDesc('created_at')
            ->values();

        $notificationsReadAt = $request->session()->get('jobseeker_notifications_read_at');
        $notificationsReadAt = $notificationsReadAt ? Carbon::parse($notificationsReadAt) : null;

        $unreadNotificationsCount = $notificationsReadAt
            ? $notifications->filter(fn ($item) => Carbon::parse($item['created_at'])->gt($notificationsReadAt))->count()
            : $notifications->count();

        $skillGapAnalysis = $this->buildSkillGapAnalysis($profile);

        return view('dashboard.jobseeker.dashboard', [
            'availableJobsCount' => $activeJobsCount > 0 ? $activeJobsCount : $sampleJobsCount,
            'profileCompletionPercent' => $profileCompletionPercent,
            'profileCompletionLabel' => $this->profileCompletionLabel($profileCompletionPercent),
            'recommendedJobs' => $recommendedJobs,
            'isUsingSampleRecommendations' => $isUsingSampleRecommendations,
            'isProfileMatchedRecommendations' => $isProfileMatchedRecommendations,
            'applicationStatusCounts' => $applicationStatusCounts,
            'dashboardNotifications' => $notifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'savedJobsCount' => $savedJobsCount,
            'kpiTrends' => [
                'jobsThisWeek' => $jobsThisWeek,
                'applicationsThisWeek' => $applicationsThisWeek,
                'interviewsThisWeek' => $interviewsThisWeek,
            ],
            'skillGapAnalysis' => $skillGapAnalysis,
        ]);
    }

    public function vacancies(Request $request): View
    {
        return view('dashboard.jobseeker.vacancies');
    }

    public function browseJobs(Request $request): View
    {
        $jobsQuery = PesoJob::query()
            ->activeApproved()
            ->with(['employer.companyProfile']);

        $search = trim((string) $request->query('search', ''));
        $location = trim((string) $request->query('location', ''));
        $industry = trim((string) $request->query('industry', ''));
        $barangay = trim((string) $request->query('barangay', ''));
        $employmentType = trim((string) $request->query('employment_type', ''));
        $sort = (string) $request->query('sort', 'newest');

        if ($search !== '') {
            $jobsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('employer_name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('requirements', 'like', '%' . $search . '%');
            });
        }

        if ($location !== '') {
            $jobsQuery->where('location', 'like', '%' . $location . '%');
        }

        if ($employmentType !== '') {
            $jobsQuery->where('job_type', $employmentType);
        }

        if ($industry !== '') {
            $jobsQuery->whereHas('employer.companyProfile', function ($q) use ($industry) {
                $q->where('industry', $industry);
            });
        }

        if ($barangay !== '') {
            $jobsQuery->whereHas('employer.companyProfile', function ($q) use ($barangay) {
                $q->where('barangay', $barangay);
            });
        }

        // Sorting
        if ($sort === 'expiring') {
            $jobsQuery->orderBy('application_end_date', 'asc');
        } elseif ($sort === 'salary_high') {
            $jobsQuery->orderByDesc('salary');
        } elseif ($sort === 'salary_low') {
            $jobsQuery->orderBy('salary');
        } else {
            $jobsQuery->latest();
        }

        $locations = PesoJob::query()
            ->activeApproved()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->values();

        $industries = CompanyProfile::query()
            ->whereNotNull('industry')
            ->where('industry', '!=', '')
            ->distinct()
            ->orderBy('industry')
            ->pluck('industry')
            ->values();

        $barangays = CompanyProfile::query()
            ->whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay')
            ->values();

        $jobs = $jobsQuery->paginate(10)->withQueryString();

        $jobs->getCollection()->transform(function (PesoJob $job) {
            $job->setAttribute('requirements_list', $this->extractJobRequirements($job));
            return $job;
        });

        return view('dashboard.jobseeker.browse-jobs', [
            'jobs' => $jobs,
            'locations' => $locations,
            'industries' => $industries,
            'barangays' => $barangays,
        ]);
    }

    public function applications(Request $request): View
    {
        $statusMap = [
            'all' => ['pending', 'reviewing', 'reviewed', 'shortlisted', 'interview', 'interviewed', 'hired', 'rejected'],
            'pending' => ['pending'],
            'reviewing' => ['reviewing', 'reviewed'],
            'shortlisted' => ['shortlisted'],
            'interview' => ['interview', 'interviewed'],
            'hired' => ['hired'],
            'rejected' => ['rejected'],
        ];

        $statusFilter = (string) $request->query('status', 'all');

        if (! array_key_exists($statusFilter, $statusMap)) {
            $statusFilter = 'all';
        }

        $userId = (int) Auth::id();

        $query = JobApplication::query()
            ->where('user_id', $userId)
            ->whereIn('status', $statusMap[$statusFilter])
            ->with('job')
            ->orderByDesc('applied_at')
            ->orderByDesc('created_at');

        $perPageParam = (string) $request->query('per_page', '10');
        $perPage = $perPageParam === 'all' ? max(1, $query->count()) : (int) max(1, intval($perPageParam));

        $applications = $query->paginate($perPage)->withQueryString();

        $rawStatusCounts = JobApplication::query()
            ->where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $statusCounts = [
            'all' => (int) $rawStatusCounts->sum(),
            'pending' => (int) ($rawStatusCounts['pending'] ?? 0),
            'reviewing' => (int) (($rawStatusCounts['reviewing'] ?? 0) + ($rawStatusCounts['reviewed'] ?? 0)),
            'shortlisted' => (int) ($rawStatusCounts['shortlisted'] ?? 0),
            'interview' => (int) (($rawStatusCounts['interview'] ?? 0) + ($rawStatusCounts['interviewed'] ?? 0)),
            'hired' => (int) ($rawStatusCounts['hired'] ?? 0),
            'rejected' => (int) ($rawStatusCounts['rejected'] ?? 0),
        ];

        return view('dashboard.jobseeker.applications', [
            'applications' => $applications,
            'statusCounts' => $statusCounts,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function recommendations(Request $request): View
    {
        $user = $request->user();
        $profile = $user?->profile;
        $recommendations = $this->buildProfileBasedRecommendations($profile);
        $profileHasSkills = $this->hasSkillsDetails($profile);
        $activeJobsCount = PesoJob::query()
            ->where('status', 'active')
            ->count();
        $appliedJobsCount = $user ? JobApplication::query()->where('user_id', $user->id)->count() : 0;

        return view('dashboard.jobseeker.recommendations', [
            'recommendations' => $recommendations,
            'recommendedCount' => $recommendations->count(),
            'activeJobsCount' => $activeJobsCount,
            'appliedJobsCount' => $appliedJobsCount,
            'profileHasSkills' => $profileHasSkills,
        ]);
    }

    public function notifications(Request $request): View
    {
        $userId = (int) $request->user()->id;

        $notifications = UserNotification::query()
            ->where('user_id', $userId)
            ->with('portalNotification')
            ->latest('id')
            ->limit(50)
            ->get();

        return view('dashboard.jobseeker.notifications', [
            'notifications' => $notifications,
            'unreadCount' => (int) $notifications->whereNull('read_at')->count(),
            'latestNotificationId' => (int) ($notifications->max('id') ?? 0),
        ]);
    }

    public function notificationsFeed(Request $request): JsonResponse
    {
        $userId = (int) $request->user()->id;
        $afterId = max(0, (int) $request->query('after_id', 0));

        $newNotifications = UserNotification::query()
            ->where('user_id', $userId)
            ->where('id', '>', $afterId)
            ->with('portalNotification')
            ->latest('id')
            ->get();

        $items = $newNotifications
            ->map(function (UserNotification $notification) {
                return [
                    'id' => $notification->id,
                    'title' => (string) data_get($notification, 'portalNotification.title', 'Notification'),
                    'message' => (string) data_get($notification, 'portalNotification.message', ''),
                ];
            })
            ->values();

        $latestId = $newNotifications->isNotEmpty()
            ? (int) $newNotifications->max('id')
            : $afterId;

        $unreadCount = UserNotification::query()
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'items' => $items,
            'latest_id' => $latestId,
            'unread_count' => (int) $unreadCount,
        ]);
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

        return response()->json([
            'ok' => true,
            'unread_count' => (int) $unreadCount,
        ]);
    }

    public function skillGap(): View
    {
        $user = Auth::user();
        $profile = $user?->profile;
        $skillGapAnalysis = $this->buildSkillGapAnalysis($profile);
        $savedJobsGap = $this->buildSavedJobsSkillGap($profile);

        return view('dashboard.jobseeker.skill-gap', [
            'skillGapAnalysis' => $skillGapAnalysis,
            'savedJobsGap' => $savedJobsGap,
        ]);
    }

    public function savedJobs(): View
    {
        $userId = (int) Auth::id();

        $savedJobIds = SavedJob::query()
            ->where('user_id', $userId)
            ->pluck('job_id')
            ->all();

        $savedJobs = collect();

        if (! empty($savedJobIds)) {
            $savedJobs = PesoJob::query()
                ->whereIn('id', $savedJobIds)
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(function (PesoJob $job) {
                    return [
                        'id' => $job->id,
                        'title' => $job->title,
                        'location' => $job->location,
                        'employer_name' => $job->employer_name,
                        'salary_range' => $job->salary_range,
                        'description' => $job->description,
                        'requirements_list' => $this->extractJobRequirements($job),
                        'created_at' => $job->created_at,
                    ];
                });
        }

        return view('dashboard.jobseeker.saved-jobs', [
            'savedJobs' => $savedJobs,
            'savedCount' => $savedJobs->count(),
        ]);
    }

    public function toggleSaveJob(PesoJob $job): JsonResponse|RedirectResponse
    {
        $userId = (int) Auth::id();

        $existing = SavedJob::query()
            ->where('user_id', $userId)
            ->where('job_id', $job->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            SavedJob::create([
                'user_id' => $userId,
                'job_id' => $job->id,
            ]);
            $saved = true;
        }

        $savedCount = SavedJob::query()
            ->where('user_id', $userId)
            ->count();

        if (! request()->expectsJson()) {
            if ($saved) {
                return redirect()
                    ->route('jobseeker.saved-jobs')
                    ->with('success', 'Job saved to your bookmarks.');
            }

            return back()->with('success', 'Job removed from your saved jobs.');
        }

        return response()->json([
            'saved' => $saved,
            'saved_count' => $savedCount,
        ]);
    }

    public function pesoClearance(): View
    {
        $userId = (int) Auth::id();

        $clearance = PesoClearance::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'expired'])
            ->with(['issuedClearance'])
            ->latest('id')
            ->first();


        $pendingRequest = PesoClearance::query()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        $hasClearance = $clearance !== null;
        $isActive = $hasClearance && $clearance->status === 'active';
        $isExpired = $hasClearance && $clearance->expiry_date && $clearance->expiry_date->isPast();
        $hasPendingRequest = $pendingRequest !== null;
        $canRequestClearance = ! $hasPendingRequest;

        if ($isExpired && $isActive) {
            $isActive = false;
        }

        return view('dashboard.jobseeker.peso-clearance', [
            'clearance' => $clearance,
            'pendingRequest' => $pendingRequest,
            'hasClearance' => $hasClearance,
            'hasPendingRequest' => $hasPendingRequest,
            'isActive' => $isActive,
            'isExpired' => $isExpired,
            'canRequestClearance' => $canRequestClearance,
        ]);
    }

    public function viewPesoClearanceDocument(): View
    {
        $userId = (int) Auth::id();

        $clearance = PesoClearance::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'expired'])
            ->with(['issuedClearance'])
            ->latest('id')
            ->first();

        if (! $clearance) {
            abort(404);
        }

        $issuedClearance = $clearance->issuedClearance;
        $hasDocument = !empty($issuedClearance?->document_path) || !empty($clearance->document_path);

        if (! $hasDocument) {
            return back()->with('error', 'Clearance document not generated yet.');
        }

        // Reuse the admin HTML view ("copied" behavior).
        $sexRecord = JobseekerPersonalInformation::query()
            ->where('user_id', $clearance->user_id)
            ->first();

        $sex = $sexRecord?->sex ?? null;

        $possessivePronoun = 'their';
        $objectivePronoun = 'him/her';

        if ($sex) {
            $s = strtolower($sex);
            if (in_array($s, ['male', 'm', 'man'])) {
                $possessivePronoun = 'his';
                $objectivePronoun = 'him';
            } elseif (in_array($s, ['female', 'f', 'woman'])) {
                $possessivePronoun = 'her';
                $objectivePronoun = 'her';
            }
        }

        $residenceAddress = $issuedClearance?->residence_address ?? $clearance->residence_address ?? '';
        $companyName = $issuedClearance?->company_name ?? $clearance->company_name ?? '';

        // Admin view expects these keys.
        return view('admin.clearance-document-view', [
            'clearance' => $clearance,
            'autoResidenceAddress' => $this->formatJobseekerAutoResidenceAddress($clearance),
            'residenceAddress' => $residenceAddress,
            'companyName' => $companyName,
            'possessivePronoun' => $possessivePronoun,
            'objectivePronoun' => $objectivePronoun,
        ]);
    }

    public function downloadPesoClearanceDocument()
    {
        $userId = (int) Auth::id();

        $clearance = PesoClearance::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'expired'])
            ->with(['issuedClearance'])
            ->latest('id')
            ->first();

        if (! $clearance) {
            abort(404);
        }

        $issuedClearance = $clearance->issuedClearance;
        $documentPath = $issuedClearance?->document_path ?: $clearance->document_path;

        if (! $documentPath) {
            return back()->with('error', 'Document not found.');
        }

        if (! \Illuminate\Support\Facades\Storage::disk('local')->exists($documentPath)) {
            return back()->with('error', 'Document not found.');
        }

        return \Illuminate\Support\Facades\Storage::download(
            $documentPath,
            'clearance-' . $clearance->clearance_number . '.pdf'
        );
    }

    private function formatJobseekerAutoResidenceAddress(PesoClearance $clearance): string
    {
        $presentAddress = JobseekerAddress::query()
            ->where('user_id', $clearance->user_id)
            ->whereIn('type', ['present', 'permanent'])
            ->orderByRaw("CASE WHEN type='present' THEN 0 ELSE 1 END")
            ->latest('updated_at')
            ->first();

        $parts = array_filter([
            $presentAddress?->barangay,
            $presentAddress?->municipality,
            $presentAddress?->province,
        ], fn ($value) => filled($value));

        return $parts ? ucwords(strtolower(implode(', ', $parts))) : 'Manolo Fortich, Bukidnon';
    }

    public function requestPesoClearance(Request $request): RedirectResponse
    {
        $user = $request->user();


        $request->validate([
            'remarks' => ['nullable', 'string', 'max:500'],
            'peso_clearance_assurance_receipt' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'barangay_clearance' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'is_first_time_jobseeker' => ['nullable', 'boolean'],
            'first_time_jobseeker_document' => ['required_if:is_first_time_jobseeker,1', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $hasPendingRequest = PesoClearance::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return back()->with('warning', 'You already have a pending PESO clearance request.');
        }

        $clearanceCount = PesoClearance::query()
            ->where('user_id', $user->id)
            ->count();

        $pesoClearanceReceiptPath = $request->file('peso_clearance_assurance_receipt')
            ->store('peso-clearance/assurance-receipts', 'public');
        $barangayClearancePath = $request->file('barangay_clearance')
            ->store('peso-clearance/barangay-clearances', 'public');
        $firstTimeJobseekerDocPath = $request->hasFile('first_time_jobseeker_document')
            ? $request->file('first_time_jobseeker_document')->store('peso-clearance/first-time-jobseeker-docs', 'public')
            : null;

        $clearance = PesoClearance::create([
            'user_id' => $user->id,
            'request_date' => now(),
            'clearance_number' => 'REQ-' . now()->format('YmdHis') . '-' . str_pad((string) ($clearanceCount + 1), 3, '0', STR_PAD_LEFT),
            'issue_date' => null,
            'expiry_date' => null,
            'status' => 'pending',
            'remarks' => trim((string) $request->input('remarks', '')) ?: 'PESO clearance request submitted by jobseeker.',
            'peso_clearance_assurance_receipt_path' => $pesoClearanceReceiptPath,
            'barangay_clearance_path' => $barangayClearancePath,
            'is_first_time_jobseeker' => $request->boolean('is_first_time_jobseeker'),
            'first_time_jobseeker_document_path' => $firstTimeJobseekerDocPath,
        ]);

        $adminIds = User::query()
            ->where('role', 'admin')
            ->pluck('id')
            ->all();

        if (! empty($adminIds)) {
            $portalNotification = PortalNotification::create([
                'title' => 'New PESO Clearance Request',
                'message' => sprintf(
                    '%s submitted a PESO clearance request%s. Go to PESO Clearances to review the attached documents.',
                    $user->name ?? 'A jobseeker',
                    $request->boolean('is_first_time_jobseeker') ? ' as a first-time jobseeker' : ''
                ),
                'created_by' => $user->id,
            ]);

            $adminNotifications = collect($adminIds)->map(function ($adminId) use ($portalNotification) {
                return [
                    'user_id' => $adminId,
                    'portal_notification_id' => $portalNotification->id,
                    'read_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->all();

            UserNotification::query()->insert($adminNotifications);
        }

        return back()->with('status', 'Your PESO clearance request has been sent to the admin for review.');
    }

    public function profile(): View
    {
        return view('dashboard.jobseeker.profile', $this->profileFormData(Auth::user()));
    }

    public function saveProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'personal_information.surname' => ['required', 'string', 'max:255'],
            'personal_information.first_name' => ['required', 'string', 'max:255'],
            'personal_information.middle_initial' => ['nullable', 'string', 'max:10'],
            'personal_information.suffix' => ['nullable', 'string', 'max:50'],
            'personal_information.date_of_birth' => ['nullable', 'date'],
            'personal_information.sex' => ['nullable', 'in:Male,Female'],
            'personal_information.religion' => ['nullable', 'string', 'max:100'],
            'personal_information.civil_status' => ['nullable', 'string', 'max:50'],
            'personal_information.height' => ['nullable', 'string', 'max:20'],
            'personal_information.tin' => ['nullable', 'string', 'max:20'],
            'personal_information.contact_number' => ['nullable', 'string', 'max:50'],
            'personal_information.email_address' => ['nullable', 'email', 'max:255'],
            'education_currently_in_school' => ['nullable', 'boolean'],

            'present_address.house_no' => ['nullable', 'string', 'max:255'],
            'present_address.barangay' => ['nullable', 'string', 'max:100'],
            'present_address.municipality' => ['nullable', 'string', 'max:100'],
            'present_address.province' => ['nullable', 'string', 'max:100'],

            'permanent_address.same_as_present' => ['nullable', 'boolean'],
            'permanent_address.house_no' => ['nullable', 'string', 'max:255'],
            'permanent_address.barangay' => ['nullable', 'string', 'max:100'],
            'permanent_address.municipality' => ['nullable', 'string', 'max:100'],
            'permanent_address.province' => ['nullable', 'string', 'max:100'],

            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.course' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],

            'training' => ['nullable', 'array'],
            'training.*.course' => ['nullable', 'string', 'max:255'],
            'training.*.hours' => ['nullable', 'string', 'max:50'],
            'training.*.institution' => ['nullable', 'string', 'max:255'],
            'training.*.dates' => ['nullable', 'string', 'max:100'],
            'training.*.skills' => ['nullable', 'string', 'max:1000'],
            'training.*.certificates' => ['nullable', 'string', 'max:255'],

            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.title' => ['nullable', 'string', 'max:255'],
            'experience.*.location' => ['nullable', 'string', 'max:255'],
            'experience.*.status' => ['nullable', 'string', 'max:255'],
            'experience.*.from_date' => ['nullable', 'string', 'max:100'],
            'experience.*.to_date' => ['nullable', 'string', 'max:100'],
            'experience.*.salary_amount' => ['nullable', 'string', 'max:50'],
            'experience.*.salary_type' => ['nullable', 'string', 'max:50'],
            'experience.*.details' => ['nullable', 'string', 'max:2000'],
            'work_experience_has' => ['nullable', 'boolean'],

            'eligibility' => ['nullable', 'array'],
            'eligibility.*.eligibility' => ['nullable', 'string', 'max:255'],
            'eligibility.*.date_taken' => ['nullable', 'string', 'max:50'],
            'eligibility.*.license' => ['nullable', 'string', 'max:255'],
            'eligibility.*.valid_until' => ['nullable', 'string', 'max:50'],

            'other_skills.trade_manual' => ['nullable', 'array'],
            'other_skills.it_technical' => ['nullable', 'array'],
            'other_skills.soft_skills' => ['nullable', 'array'],
            'other_skills.other_enabled' => ['nullable', 'boolean'],
            'other_skills.other_text' => ['nullable', 'string', 'max:255'],
            'other_skills.with_certificate' => ['nullable', 'boolean'],
            'other_skills.by_experience' => ['nullable', 'boolean'],

            'employment_status.wage_employed' => ['nullable', 'boolean'],
            'employment_status.wage_employed_specify' => ['nullable', 'string', 'max:255'],
            'employment_status.self_employed' => ['nullable', 'boolean'],
            'employment_status.self_employed_specify' => ['nullable', 'string', 'max:255'],
            'employment_status.unemployed' => ['nullable', 'boolean'],

            'job_preferences.part_time' => ['nullable', 'boolean'],
            'job_preferences.full_time' => ['nullable', 'boolean'],
            'job_preferences.local' => ['nullable', 'boolean'],
            'job_preferences.overseas' => ['nullable', 'boolean'],
            'job_preferences.occupation_text' => ['nullable', 'string', 'max:1000'],

            'languages' => ['nullable', 'array'],
            'languages.*.language' => ['nullable', 'string', 'max:100'],
            'languages.*.read' => ['nullable', 'boolean'],
            'languages.*.write' => ['nullable', 'boolean'],
            'languages.*.speak' => ['nullable', 'boolean'],
            'languages.*.understand' => ['nullable', 'boolean'],
            'languages.*.other' => ['nullable', 'string', 'max:100'],

            'disability.visual' => ['nullable', 'boolean'],
            'disability.speech' => ['nullable', 'boolean'],
            'disability.mental' => ['nullable', 'boolean'],
            'disability.hearing' => ['nullable', 'boolean'],
            'disability.physical' => ['nullable', 'boolean'],
            'disability.other' => ['nullable', 'boolean'],
            'disability.other_text' => ['nullable', 'string', 'max:255'],
        ]);

        $userId = $user->id;

        $personal = $validated['personal_information'] ?? [];
        $personal['currently_in_school'] = (bool) ($validated['education_currently_in_school'] ?? false);
        $this->savePersonalInformation($userId, $personal);

        $fullName = collect([
            $personal['first_name'] ?? '',
            $personal['middle_initial'] ?? '',
            $personal['surname'] ?? '',
            $personal['suffix'] ?? '',
        ])->filter()->join(' ');

        if ($fullName !== '') {
            $user->name = $fullName;
            $user->save();
        }

        $presentAddress = $validated['present_address'] ?? [];
        $permanentAddress = $validated['permanent_address'] ?? [];

        if ((bool) ($permanentAddress['same_as_present'] ?? false)) {
            $permanentAddress = array_merge($permanentAddress, [
                'house_no' => $presentAddress['house_no'] ?? '',
                'barangay' => $presentAddress['barangay'] ?? '',
                'municipality' => $presentAddress['municipality'] ?? '',
                'province' => $presentAddress['province'] ?? '',
            ]);
        }

        $this->saveAddresses($userId, $presentAddress, $permanentAddress);

        $this->saveResumeSection(
            $userId,
            JobseekerEducation::class,
            $this->normalizeResumeSection($validated['education'] ?? [], ['school', 'course', 'year'])
        );

        $trainingRows = $this->normalizeResumeSection(
            $validated['training'] ?? [],
            ['course', 'hours', 'institution', 'dates', 'skills', 'certificates']
        );

        $trainingRows = array_map(function (array $row): array {
            return [
                'course' => $row['course'] ?? '',
                'hours' => is_numeric($row['hours'] ?? '') ? (int) $row['hours'] : null,
                'institution' => $row['institution'] ?? '',
                'inclusive_dates' => $row['dates'] ?? '',
                'skills_acquired' => $row['skills'] ?? '',
                'certificates' => $row['certificates'] ?? '',
            ];
        }, $trainingRows);

        $this->saveResumeSection($userId, JobseekerTraining::class, $trainingRows);

        $experienceRows = $this->normalizeResumeSection(
            $validated['experience'] ?? [],
            ['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details']
        );

        $experienceRows = array_map(function (array $row): array {
            $salaryRaw = trim((string) ($row['salary_amount'] ?? ''));
            $row['salary_amount'] = is_numeric($salaryRaw) ? (float) $salaryRaw : null;
            return $row;
        }, $experienceRows);

        $this->saveResumeSection($userId, JobseekerExperience::class, $experienceRows);

        $this->saveResumeSection(
            $userId,
            JobseekerEligibility::class,
            $this->normalizeResumeSection($validated['eligibility'] ?? [], ['eligibility', 'date_taken', 'license', 'valid_until'])
        );

        $otherSkills = $validated['other_skills'] ?? [];
        $this->saveSkills($userId, $otherSkills);
        $this->saveSkillsMeta($userId, $otherSkills);

        $this->saveEmploymentStatus(
            $userId,
            $validated['employment_status'] ?? [],
            (bool) ($validated['work_experience_has'] ?? false)
        );

        $this->saveJobPreferences($userId, $validated['job_preferences'] ?? []);
        $this->saveLanguages($userId, $validated['languages'] ?? []);
        $this->saveDisability($userId, $validated['disability'] ?? []);

        return redirect()
            ->route('jobseeker.profile')
            ->with('status', 'Profile saved successfully.');
    }

    public function resumeBuilder(): View
    {
        $data = $this->resumeBuilderData(Auth::user());

        return view('dashboard.jobseeker.resume-builder', $data);
    }

    public function exportResumeBuilder(): Response
    {
        $data = $this->resumeBuilderData(Auth::user());

        $pdf = Pdf::loadView('dashboard.jobseeker.resume-builder-pdf', $data)
            ->setPaper('a4', 'portrait');

        $fileName = trim(($data['resumeName'] ?: 'resume') . '-harvard-style.pdf');

        return $pdf->download($fileName);
    }

    public function saveResumeBuilder(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'objective' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.course' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],
            'experience' => ['nullable', 'array'],
            'experience.*.title' => ['nullable', 'string', 'max:255'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.period' => ['nullable', 'string', 'max:100'],
            'experience.*.details' => ['nullable', 'string', 'max:1000'],
            'training' => ['nullable', 'array'],
            'training.*.course' => ['nullable', 'string', 'max:255'],
            'training.*.institution' => ['nullable', 'string', 'max:255'],
            'training.*.dates' => ['nullable', 'string', 'max:100'],
            'training.*.hours' => ['nullable', 'string', 'max:100'],
            'training.*.skills' => ['nullable', 'string', 'max:500'],
            'training.*.certificates' => ['nullable', 'string', 'max:255'],
            'eligibility' => ['nullable', 'array'],
            'eligibility.*.eligibility' => ['nullable', 'string', 'max:255'],
            'eligibility.*.license' => ['nullable', 'string', 'max:255'],
            'eligibility.*.date_taken' => ['nullable', 'string', 'max:100'],
            'eligibility.*.valid_until' => ['nullable', 'string', 'max:100'],
        ]);

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'resume_name' => $validated['name'],
                'resume_email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'skills' => $this->normalizeList($validated['skills'] ?? ''),
                'education' => $this->normalizeResumeSection($validated['education'] ?? [], ['school', 'course', 'year']),
                'experience' => $this->normalizeResumeSection($validated['experience'] ?? [], ['title', 'company', 'period', 'details']),
                'training' => $this->normalizeResumeSection($validated['training'] ?? [], ['course', 'institution', 'dates', 'hours', 'skills', 'certificates']),
                'eligibility' => $this->normalizeResumeSection($validated['eligibility'] ?? [], ['eligibility', 'license', 'date_taken', 'valid_until']),
            ]
        );

        return redirect()
            ->route('jobseeker.resume-builder')
            ->with('status', 'Resume builder saved successfully.');
    }

    public function resetResumeBuilder(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user?->profile;

        if ($profile) {
            $profile->update([
                // Marker values indicate "resume reset mode" while preserving profile data.
                'resume_name' => '',
                'resume_email' => '',
                'objective' => '',
                'resume_path' => null,
            ]);
        }

        return redirect()
            ->route('jobseeker.resume-builder')
            ->with('status', 'Resume builder reset successfully.');
    }

    private function normalizeList(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $value) ?: [])
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeResumeSection(array $rows, array $allowedKeys): array
    {
        return collect($rows)
            ->map(function ($row) use ($allowedKeys) {
                $cleanRow = [];

                foreach ($allowedKeys as $key) {
                    $cleanRow[$key] = trim((string) ($row[$key] ?? ''));
                }

                return $cleanRow;
            })
            ->filter(function ($row) {
                return collect($row)->filter()->isNotEmpty();
            })
            ->values()
            ->all();
    }

    private function normalizeLanguageRows(array $rows): array
    {
        return collect($rows)
            ->map(function ($row) {
                return [
                    'language' => trim((string) ($row['language'] ?? '')),
                    'read' => (bool) ($row['read'] ?? false),
                    'write' => (bool) ($row['write'] ?? false),
                    'speak' => (bool) ($row['speak'] ?? false),
                    'understand' => (bool) ($row['understand'] ?? false),
                    'other' => trim((string) ($row['other'] ?? '')),
                ];
            })
            ->filter(function ($row) {
                return $row['language'] !== '' || $row['other'] !== '';
            })
            ->values()
            ->all();
    }

    private function buildSkillList(array $otherSkills): array
    {
        $skills = array_merge(
            $otherSkills['trade_manual'] ?? [],
            $otherSkills['it_technical'] ?? [],
            $otherSkills['soft_skills'] ?? [],
            array_filter([(string) ($otherSkills['other_text'] ?? '')])
        );

        return collect($skills)
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function buildResumeNameFromProfile(?User $user, array $personalInformation): string
    {
        $parts = collect([
            data_get($personalInformation, 'first_name', ''),
            data_get($personalInformation, 'middle_initial', ''),
            data_get($personalInformation, 'surname', ''),
            data_get($personalInformation, 'suffix', ''),
        ])->filter();

        return $parts->isNotEmpty() ? $parts->join(' ') : trim((string) ($user?->name ?? ''));
    }

    private function buildResumeSkillsFromProfile(?UserProfile $profile): array
    {
        if (! $profile) {
            return [];
        }

        $skills = $profile->skills ?? [];

        if (! empty($skills)) {
            return $skills;
        }

        return $this->buildSkillList($profile->other_skills ?? []);
    }

    private function buildResumeObjectiveFromProfile(array $personalInformation, ?UserProfile $profile): string
    {
        $occupation = trim((string) data_get($profile, 'job_preferences.occupation_text', ''));
        $skillText = collect($profile?->skills ?? [])->take(3)->implode(', ');

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

        return $firstName !== ''
            ? 'To secure a position where I can apply my skills and contribute to the success of the organization.'
            : '';
    }

    private function formatAddress(array $address): string
    {
        return collect([
            $address['house_no'] ?? '',
            $address['barangay'] ?? '',
            $address['municipality'] ?? '',
            $address['province'] ?? '',
        ])->filter()->join(', ');
    }

    private function extractYearsOfExperience(array $experienceRows): ?int
    {
        if (empty($experienceRows)) {
            return null;
        }

        $totalYears = 0;
        foreach ($experienceRows as $experience) {
            $fromDate = $experience['from_date'] ?? null;
            $toDate = $experience['to_date'] ?? null;

            if ($fromDate && $toDate) {
                try {
                    $from = \Carbon\Carbon::parse($fromDate);
                    $to = \Carbon\Carbon::parse($toDate);
                    $totalYears += $from->diffInYears($to);
                } catch (\Exception $e) {
                    // Skip if date parsing fails
                    continue;
                }
            }
        }

        return $totalYears > 0 ? $totalYears : null;
    }

    private function resumeBuilderData(?\App\Models\User $user): array
    {
        $profile = $user?->profile;

        $isResumeReset = $profile
            && $profile->resume_name === ''
            && $profile->resume_email === '';

        $profilePersonal = $profile?->personal_information ?? [];
        $profilePresentAddress = $profile?->present_address ?? [];
        $profilePermanentAddress = $profile?->permanent_address ?? [];
        $profileSkills = $profile?->skills ?? [];
        $profileEducationRows = $profile?->education ?? [];
        $profileTrainingRows = $profile?->training ?? [];
        $profileExperienceRows = $profile?->experience ?? [];
        $profileEligibilityRows = $profile?->eligibility ?? [];

        $resumeName = old('name', $isResumeReset ? '' : ($profile->resume_name ?? $this->buildResumeNameFromProfile($user, $profilePersonal)));
        $resumeEmail = old('email', $isResumeReset ? '' : ($profile->resume_email ?? data_get($profilePersonal, 'email_address', $user?->email ?? '')));
        $resumePhone = old('phone', $isResumeReset ? '' : ($profile->phone ?? data_get($profilePersonal, 'contact_number', '')));
        $resumeAddress = old('address', $isResumeReset ? '' : ($profile->address ?? ($this->formatAddress($profilePresentAddress) ?: $this->formatAddress($profilePermanentAddress))));
        $resumeObjective = old('objective', $isResumeReset ? '' : ($profile->objective ?? $this->buildResumeObjectiveFromProfile($profilePersonal, $profile)));
        $resumeSkills = old('skills', $isResumeReset ? '' : implode(', ', $profileSkills ?: $this->buildResumeSkillsFromProfile($profile)));
        $educationRows = old('education', $isResumeReset ? [] : $profileEducationRows);
        $trainingRows = old('training', $isResumeReset ? [] : $profileTrainingRows);
        $experienceRows = old('experience', $isResumeReset ? [] : $profileExperienceRows);
        $eligibilityRows = old('eligibility', $isResumeReset ? [] : $profileEligibilityRows);

        return [
            'user' => $user,
            'profile' => $profile,
            'resumeName' => $resumeName,
            'resumeEmail' => $resumeEmail,
            'resumePhone' => $resumePhone,
            'resumeAddress' => $resumeAddress,
            'resumeObjective' => $resumeObjective,
            'resumeSkills' => $resumeSkills,
            'educationRows' => $educationRows,
            'trainingRows' => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows' => $eligibilityRows,
            'skillsPreview' => collect(explode(',', $resumeSkills))->map(fn ($item) => trim($item))->filter()->values(),
        ];
    }

    private function savePersonalInformation(int $userId, array $data): void
    {
        JobseekerPersonalInformation::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'first_name' => $data['first_name'] ?? '',
                'middle_initial' => $data['middle_initial'] ?? null,
                'surname' => $data['surname'] ?? '',
                'suffix' => $data['suffix'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'sex' => $data['sex'] ?? null,
                'religion' => $data['religion'] ?? null,
                'civil_status' => $data['civil_status'] ?? null,
                'height' => $data['height'] ?? null,
                'tin' => $data['tin'] ?? null,
                'contact_number' => $data['contact_number'] ?? null,
                'email_address' => $data['email_address'] ?? null,
                'currently_in_school' => (bool) ($data['currently_in_school'] ?? false),
            ]
        );
    }

    private function saveAddresses(int $userId, array $present, array $permanent): void
    {
        foreach (['present' => $present, 'permanent' => $permanent] as $type => $address) {
            JobseekerAddress::updateOrCreate(
                ['user_id' => $userId, 'type' => $type],
                [
                    'user_id' => $userId,
                    'type' => $type,
                    'house_no' => $address['house_no'] ?? null,
                    'barangay' => $address['barangay'] ?? null,
                    'municipality' => $address['municipality'] ?? null,
                    'province' => $address['province'] ?? null,
                ]
            );
        }
    }

    private function saveResumeSection(int $userId, string $modelClass, array $rows): void
    {
        $modelClass::where('user_id', $userId)->delete();

        foreach (array_values($rows) as $sortOrder => $row) {
            $modelClass::create(array_merge(
                ['user_id' => $userId, 'sort_order' => $sortOrder],
                $row
            ));
        }
    }

    private function saveSkills(int $userId, array $otherSkills): void
    {
        JobseekerSkill::where('user_id', $userId)->delete();

        $categoryMap = [
            'trade_manual' => 'trade_manual',
            'it_technical' => 'it_technical',
            'soft_skills' => 'soft_skills',
        ];

        $inserts = [];

        foreach ($categoryMap as $formKey => $category) {
            foreach ((array) ($otherSkills[$formKey] ?? []) as $skill) {
                $skill = trim((string) $skill);
                if ($skill !== '') {
                    $inserts[] = [
                        'user_id' => $userId,
                        'category' => $category,
                        'skill' => $skill,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        $otherText = trim((string) ($otherSkills['other_text'] ?? ''));
        if ($otherText !== '') {
            $inserts[] = [
                'user_id' => $userId,
                'category' => 'other',
                'skill' => $otherText,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (! empty($inserts)) {
            JobseekerSkill::insert($inserts);
        }
    }

    private function saveSkillsMeta(int $userId, array $otherSkills): void
    {
        JobseekerSkillsMeta::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'other_enabled' => (bool) ($otherSkills['other_enabled'] ?? false),
                'other_text' => trim((string) ($otherSkills['other_text'] ?? '')),
                'with_certificate' => (bool) ($otherSkills['with_certificate'] ?? false),
                'by_experience' => (bool) ($otherSkills['by_experience'] ?? false),
            ]
        );
    }

    private function saveEmploymentStatus(int $userId, array $status, bool $hasWorkExperience): void
    {
        JobseekerEmploymentStatus::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'has_work_experience' => $hasWorkExperience,
                'wage_employed' => (bool) ($status['wage_employed'] ?? false),
                'wage_employed_specify' => trim((string) ($status['wage_employed_specify'] ?? '')),
                'self_employed' => (bool) ($status['self_employed'] ?? false),
                'self_employed_specify' => trim((string) ($status['self_employed_specify'] ?? '')),
                'unemployed' => (bool) ($status['unemployed'] ?? false),
            ]
        );
    }

    private function saveJobPreferences(int $userId, array $prefs): void
    {
        JobseekerJobPreference::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'part_time' => (bool) ($prefs['part_time'] ?? false),
                'full_time' => (bool) ($prefs['full_time'] ?? false),
                'occupation_text' => trim((string) ($prefs['occupation_text'] ?? '')),
                'local' => (bool) ($prefs['local'] ?? false),
                'overseas' => (bool) ($prefs['overseas'] ?? false),
            ]
        );
    }

    private function saveLanguages(int $userId, array $rows): void
    {
        JobseekerLanguage::where('user_id', $userId)->delete();

        foreach (array_values($rows) as $sortOrder => $row) {
            $language = trim((string) ($row['language'] ?? ''));
            if ($language === '' && trim((string) ($row['other'] ?? '')) === '') {
                continue;
            }

            JobseekerLanguage::create([
                'user_id' => $userId,
                'language' => $language,
                'other_specify' => trim((string) ($row['other'] ?? '')),
                'can_read' => (bool) ($row['read'] ?? false),
                'can_write' => (bool) ($row['write'] ?? false),
                'can_speak' => (bool) ($row['speak'] ?? false),
                'can_understand' => (bool) ($row['understand'] ?? false),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function saveDisability(int $userId, array $data): void
    {
        JobseekerDisability::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'visual' => (bool) ($data['visual'] ?? false),
                'speech' => (bool) ($data['speech'] ?? false),
                'mental' => (bool) ($data['mental'] ?? false),
                'hearing' => (bool) ($data['hearing'] ?? false),
                'physical' => (bool) ($data['physical'] ?? false),
                'other' => (bool) ($data['other'] ?? false),
                'other_text' => trim((string) ($data['other_text'] ?? '')),
            ]
        );
    }

    private function profileFormData(?User $user): array
    {
        if (! $user) {
            return $this->blankProfileFormData();
        }

        $userId = $user->id;
        $pi = JobseekerPersonalInformation::where('user_id', $userId)->first();

        $personalInformation = [
            'first_name' => $pi?->first_name ?? '',
            'middle_initial' => $pi?->middle_initial ?? '',
            'surname' => $pi?->surname ?? '',
            'suffix' => $pi?->suffix ?? '',
            'date_of_birth' => $pi?->date_of_birth ?? '',
            'sex' => $pi?->sex ?? '',
            'religion' => $pi?->religion ?? '',
            'civil_status' => $pi?->civil_status ?? '',
            'height' => $pi?->height ?? '',
            'tin' => $pi?->tin ?? '',
            'contact_number' => $pi?->contact_number ?? '',
            'email_address' => $pi?->email_address ?? $user->email ?? '',
            'currently_in_school' => (bool) ($pi?->currently_in_school ?? false),
        ];

        $addresses = JobseekerAddress::where('user_id', $userId)->get()->keyBy('type');

        $presentRow = $addresses->get('present');
        $permanentRow = $addresses->get('permanent');

        $presentAddress = [
            'house_no' => $presentRow?->house_no ?? '',
            'barangay' => $presentRow?->barangay ?? '',
            'municipality' => $presentRow?->municipality ?? '',
            'province' => $presentRow?->province ?? '',
        ];

        $permanentAddress = [
            'same_as_present' => false,
            'house_no' => $permanentRow?->house_no ?? '',
            'barangay' => $permanentRow?->barangay ?? '',
            'municipality' => $permanentRow?->municipality ?? '',
            'province' => $permanentRow?->province ?? '',
        ];

        $educationRows = JobseekerEducation::where('user_id', $userId)->orderBy('sort_order')->get(['school', 'course', 'year'])->toArray();

        if (empty($educationRows)) {
            $educationRows = [['school' => '', 'course' => '', 'year' => '']];
        }

        $trainingRows = JobseekerTraining::where('user_id', $userId)->orderBy('sort_order')->get(['course', 'hours', 'institution', 'inclusive_dates', 'skills_acquired', 'certificates'])->map(fn ($row) => [
            'course' => $row->course ?? '',
            'hours' => (string) ($row->hours ?? ''),
            'institution' => $row->institution ?? '',
            'dates' => $row->inclusive_dates ?? '',
            'skills' => $row->skills_acquired ?? '',
            'certificates' => $row->certificates ?? '',
        ])->toArray();

        if (empty($trainingRows)) {
            $trainingRows = [['course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '']];
        }

        $experienceRows = JobseekerExperience::where('user_id', $userId)->orderBy('sort_order')->get(['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details'])->map(fn ($row) => [
            'company' => $row->company ?? '',
            'title' => $row->title ?? '',
            'location' => $row->location ?? '',
            'status' => $row->status ?? '',
            'from_date' => $row->from_date ?? '',
            'to_date' => $row->to_date ?? '',
            'salary_amount' => $row->salary_amount !== null ? (string) $row->salary_amount : '',
            'salary_type' => $row->salary_type ?? '',
            'details' => $row->details ?? '',
        ])->toArray();

        if (empty($experienceRows)) {
            $experienceRows = [['company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '']];
        }

        $eligibilityRows = JobseekerEligibility::where('user_id', $userId)->orderBy('sort_order')->get(['eligibility', 'date_taken', 'license', 'valid_until'])->toArray();

        if (empty($eligibilityRows)) {
            $eligibilityRows = [['eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '']];
        }

        $skillRows = JobseekerSkill::where('user_id', $userId)->get();
        $meta = JobseekerSkillsMeta::where('user_id', $userId)->first();

        $otherSkills = [
            'trade_manual' => $skillRows->where('category', 'trade_manual')->pluck('skill')->all(),
            'it_technical' => $skillRows->where('category', 'it_technical')->pluck('skill')->all(),
            'soft_skills' => $skillRows->where('category', 'soft_skills')->pluck('skill')->all(),
            'other_enabled' => (bool) ($meta?->other_enabled ?? false),
            'other_text' => $skillRows->where('category', 'other')->pluck('skill')->first() ?? ($meta?->other_text ?? ''),
            'with_certificate' => $meta?->with_certificate,
            'by_experience' => $meta?->by_experience,
        ];

        $es = JobseekerEmploymentStatus::where('user_id', $userId)->first();

        $employmentStatus = [
            'has_work_experience' => $es?->has_work_experience,
            'wage_employed' => (bool) ($es?->wage_employed ?? false),
            'wage_employed_specify' => $es?->wage_employed_specify ?? '',
            'self_employed' => (bool) ($es?->self_employed ?? false),
            'self_employed_specify' => $es?->self_employed_specify ?? '',
            'unemployed' => (bool) ($es?->unemployed ?? false),
        ];

        $jp = JobseekerJobPreference::where('user_id', $userId)->first();

        $jobPreferences = [
            'part_time' => (bool) ($jp?->part_time ?? false),
            'full_time' => (bool) ($jp?->full_time ?? false),
            'local' => (bool) ($jp?->local ?? false),
            'overseas' => (bool) ($jp?->overseas ?? false),
            'occupation_text' => $jp?->occupation_text ?? '',
        ];

        $languages = JobseekerLanguage::where('user_id', $userId)->orderBy('sort_order')->get()->map(fn ($row) => [
            'language' => $row->language ?? '',
            'read' => (bool) $row->can_read,
            'write' => (bool) $row->can_write,
            'speak' => (bool) $row->can_speak,
            'understand' => (bool) $row->can_understand,
            'other' => $row->other_specify ?? '',
        ])->toArray();

        if (empty($languages)) {
            $languages = $this->defaultLanguages();
        }

        $dis = JobseekerDisability::where('user_id', $userId)->first();

        $disability = [
            'visual' => (bool) ($dis?->visual ?? false),
            'speech' => (bool) ($dis?->speech ?? false),
            'mental' => (bool) ($dis?->mental ?? false),
            'hearing' => (bool) ($dis?->hearing ?? false),
            'physical' => (bool) ($dis?->physical ?? false),
            'other' => (bool) ($dis?->other ?? false),
            'other_text' => $dis?->other_text ?? '',
        ];

        return [
            'user' => $user,
            'profile' => null,
            'personalInformation' => $personalInformation,
            'presentAddress' => $presentAddress,
            'permanentAddress' => $permanentAddress,
            'educationRows' => $educationRows,
            'trainingRows' => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows' => $eligibilityRows,
            'otherSkills' => $otherSkills,
            'employmentStatus' => $employmentStatus,
            'jobPreferences' => $jobPreferences,
            'languages' => $languages,
            'disability' => $disability,
            'resumeFileName' => null,
            'resumeFileUrl' => null,
        ];
    }

    private function blankProfileFormData(): array
    {
        return [
            'user' => null,
            'profile' => null,
            'personalInformation' => [
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
            ],
            'presentAddress' => ['house_no' => '', 'barangay' => '', 'municipality' => '', 'province' => ''],
            'permanentAddress' => ['same_as_present' => false, 'house_no' => '', 'barangay' => '', 'municipality' => '', 'province' => ''],
            'educationRows' => [['school' => '', 'course' => '', 'year' => '']],
            'trainingRows' => [['course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '']],
            'experienceRows' => [['company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '']],
            'eligibilityRows' => [['eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '']],
            'otherSkills' => $this->defaultOtherSkills(),
            'employmentStatus' => $this->defaultEmploymentStatus(),
            'jobPreferences' => $this->defaultJobPreferences(),
            'languages' => $this->defaultLanguages(),
            'disability' => $this->defaultDisability(),
            'resumeFileName' => null,
            'resumeFileUrl' => null,
        ];
    }

    private function defaultOtherSkills(): array
    {
        return [
            'trade_manual' => [],
            'it_technical' => [],
            'soft_skills' => [],
            'other_text' => '',
            'with_certificate' => false,
            'by_experience' => false,
        ];
    }

    private function defaultEmploymentStatus(): array
    {
        return [
            'wage_employed' => false,
            'self_employed' => false,
            'unemployed' => false,
            'has_work_experience' => null,
        ];
    }

    private function defaultJobPreferences(): array
    {
        return [
            'part_time' => false,
            'full_time' => false,
            'local' => false,
            'overseas' => false,
            'occupation_text' => '',
        ];
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
        return [
            'visual' => false,
            'speech' => false,
            'mental' => false,
            'hearing' => false,
            'physical' => false,
            'other' => false,
            'other_text' => '',
        ];
    }

    private function splitDisplayName(string $displayName): array
    {
        $segments = collect(preg_split('/\s+/', trim($displayName)) ?: [])
            ->filter()
            ->values()
            ->all();

        $suffixes = ['jr', 'jr.', 'sr', 'sr.', 'ii', 'iii', 'iv', 'v'];
        $suffix = '';

        if (! empty($segments)) {
            $lastSegment = strtolower(rtrim((string) end($segments), ','));

            if (in_array($lastSegment, $suffixes, true)) {
                $suffix = array_pop($segments);
            }
        }

        $firstName = $segments[0] ?? '';
        $middleInitial = '';
        $surname = '';

        if (count($segments) === 2) {
            $surname = $segments[1] ?? '';
        } elseif (count($segments) === 3) {
            $secondSegment = (string) ($segments[1] ?? '');

            if (preg_match('/^[A-Za-z]\.?$/', $secondSegment)) {
                $middleInitial = $secondSegment;
                $surname = $segments[2] ?? '';
            } else {
                $firstName = trim(($segments[0] ?? '') . ' ' . $secondSegment);
                $surname = $segments[2] ?? '';
            }
        } elseif (count($segments) > 3) {
            $penultimateSegment = (string) ($segments[count($segments) - 2] ?? '');

            if (preg_match('/^[A-Za-z]\.?$/', $penultimateSegment)) {
                $surname = array_pop($segments) ?? '';
                $middleInitial = array_pop($segments) ?? '';
                $firstName = implode(' ', $segments);
            } else {
                $firstName = implode(' ', array_slice($segments, 0, 2));
                $surname = array_pop($segments) ?? '';
            }
        }

        return [
            'first_name' => $firstName,
            'middle_initial' => $middleInitial,
            'surname' => $surname,
            'suffix' => $suffix,
        ];
    }

    private function splitAddress(string $address): array
    {
        $segments = collect(preg_split('/[\r\n,]+/', $address) ?: [])
            ->map(fn ($segment) => trim($segment))
            ->filter()
            ->values()
            ->all();

        return [
            'house_no' => $segments[0] ?? '',
            'barangay' => $segments[1] ?? '',
            'municipality' => $segments[2] ?? '',
            'province' => $segments[3] ?? '',
        ];
    }

    private function extractJobRequirements(PesoJob $job): array
    {
        $requirements = $job->requirements;

        if (is_array($requirements) && ! empty($requirements)) {
            return collect($requirements)
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->values()
                ->all();
        }

        $rawRequirements = trim((string) $job->getRawOriginal('requirements'));

        if ($rawRequirements === '') {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $rawRequirements) ?: [])
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function buildProfileBasedRecommendations(?UserProfile $profile)
    {
        $signals = $this->buildRecommendationSignalsFromProfile($profile);

        if (collect($signals)->flatten()->isEmpty()) {
            return collect();
        }

        $activeJobs = PesoJob::query()
            ->where('status', 'active')
            ->latest()
            ->limit(40)
            ->get();

        $rankedJobs = $activeJobs
            ->map(function (PesoJob $job) use ($signals) {
                $matchDetails = $this->buildJobMatchDetails($job, $signals);

                return [
                    'job' => $job,
                    'score' => $matchDetails['score'],
                    'match_reasons' => $matchDetails['reasons'],
                    'created_at' => $job->created_at?->getTimestamp() ?? 0,
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

        return $rankedJobs
            ->map(function ($item) {
                /** @var PesoJob $job */
                $job = $item['job'];

                return [
                    'title' => $job->title,
                    'location' => $job->location,
                    'employer_name' => $job->employer_name,
                    'salary_range' => $job->salary_range,
                    'description' => $job->description,
                    'requirements_list' => $this->extractJobRequirements($job),
                    'match_score' => $item['score'],
                    'match_reasons' => $item['match_reasons'],
                ];
            })
            ->values();
    }

    private function buildRecommendationSignalsFromProfile(?UserProfile $profile): array
    {
        if (! $profile) {
            return [
                'skills' => [],
                'occupations' => [],
                'experience' => [],
                'locations' => [],
            ];
        }

        $otherSkills = $profile->other_skills ?? [];

        $skills = collect($profile->skills ?? [])
            ->merge($otherSkills['trade_manual'] ?? [])
            ->merge($otherSkills['it_technical'] ?? [])
            ->merge($otherSkills['soft_skills'] ?? [])
            ->push((string) ($otherSkills['other_text'] ?? ''))
            ->all();

        $occupationPref = (string) data_get($profile, 'job_preferences.occupation_text', '');

        $experienceTitles = collect($profile->experience ?? [])
            ->pluck('title')
            ->all();

        $locations = [
            (string) data_get($profile, 'present_address.barangay', ''),
            (string) data_get($profile, 'present_address.municipality', ''),
            (string) data_get($profile, 'present_address.province', ''),
        ];

        return [
            'skills' => $this->normalizeRecommendationTerms($skills),
            'occupations' => $this->normalizeRecommendationTerms([$occupationPref]),
            'experience' => $this->normalizeRecommendationTerms($experienceTitles),
            'locations' => $this->normalizeRecommendationTerms($locations),
        ];
    }

    private function normalizeRecommendationTerms(array $rawValues): array
    {
        $stopWords = ['the', 'and', 'for', 'with', 'from', 'that', 'this', 'are', 'your', 'you', 'job', 'work'];

        return collect($rawValues)
            ->map(fn ($value) => trim(mb_strtolower((string) $value)))
            ->filter()
            ->flatMap(function ($value) {
                $parts = collect(preg_split('/[\r\n,\/|]+/', $value) ?: [])
                    ->map(fn ($part) => trim((string) $part))
                    ->filter();

                $expanded = [];

                foreach ($parts as $part) {
                    $expanded[] = $part;

                    foreach (preg_split('/\s+/', $part) ?: [] as $word) {
                        $word = trim((string) $word);

                        if ($word !== '') {
                            $expanded[] = $word;
                        }
                    }
                }

                return $expanded;
            })
            ->map(fn ($term) => trim((string) $term, " \t\n\r\0\x0B.-_"))
            ->filter(fn ($term) => mb_strlen($term) >= 3)
            ->reject(fn ($term) => in_array($term, $stopWords, true))
            ->unique()
            ->values()
            ->all();
    }

    private function scoreJobAgainstProfileSignals(PesoJob $job, array $signals): int
    {
        $details = $this->buildJobMatchDetails($job, $signals);

        return $details['score'];
    }

    private function buildJobMatchDetails(PesoJob $job, array $signals): array
    {
        $requirementsText = implode(' ', $this->extractJobRequirements($job));

        $haystack = mb_strtolower(implode(' ', [
            (string) $job->title,
            (string) $job->description,
            (string) $job->employer_name,
            (string) $job->location,
            $requirementsText,
        ]));

        $skillsMatches = $this->countTermMatches($haystack, $signals['skills'] ?? []);
        $occupationMatches = $this->countTermMatches($haystack, $signals['occupations'] ?? []);
        $experienceMatches = $this->countTermMatches($haystack, $signals['experience'] ?? []);
        $locationMatches = $this->countTermMatches($haystack, $signals['locations'] ?? []);

        $score = ($skillsMatches * 6)
            + ($occupationMatches * 8)
            + ($experienceMatches * 4)
            + ($locationMatches * 3);

        $reasons = collect([
            $occupationMatches > 0 ? 'Occupation Preference' : null,
            $skillsMatches > 0 ? 'Skills Match' : null,
            $experienceMatches > 0 ? 'Experience Match' : null,
            $locationMatches > 0 ? 'Location Match' : null,
        ])->filter()->values()->all();

        return [
            'score' => $score,
            'reasons' => $reasons,
        ];
    }

    private function countTermMatches(string $haystack, array $terms): int
    {
        return collect($terms)
            ->filter(fn ($term) => $term !== '' && str_contains($haystack, mb_strtolower((string) $term)))
            ->count();
    }

    private function buildSavedJobsSkillGap(?UserProfile $profile): array
    {
        $user = Auth::user();

        if (! $user || ! $profile) {
            return [
                'hasData' => false,
                'matched_skills_unique_count' => 0,
                'missing_skills' => [],
            ];
        }

        $savedJobIds = SavedJob::query()
            ->where('user_id', (int) $user->id)
            ->pluck('job_id')
            ->all();

        if ($savedJobIds === []) {
            return [
                'hasData' => false,
                'matched_skills_unique_count' => 0,
                'missing_skills' => [],
            ];
        }

        $savedJobs = PesoJob::query()
            ->whereIn('id', $savedJobIds)
            ->where('status', 'active')
            ->get(['title', 'description', 'requirements', 'preferred_skills']);

        if ($savedJobs->isEmpty()) {
            return [
                'hasData' => false,
                'matched_skills_unique_count' => 0,
                'missing_skills' => [],
            ];
        }

        $userSkills = collect();
        $userSkills = $userSkills->merge($profile->skills ?? []);

        $otherSkills = $profile->other_skills ?? [];
        $userSkills = $userSkills
            ->merge($otherSkills['trade_manual'] ?? [])
            ->merge($otherSkills['it_technical'] ?? [])
            ->merge($otherSkills['soft_skills'] ?? [])
            ->push((string) ($otherSkills['other_text'] ?? ''));

        $trainingSkills = collect($profile->training ?? [])
            ->pluck('skills')
            ->filter()
            ->flatMap(function ($skillsText) {
                return collect(preg_split('/[\r\n,]+/', (string) $skillsText) ?: [])
                    ->map(fn ($s) => trim($s))
                    ->filter();
            });
        $userSkills = $userSkills->merge($trainingSkills);

        $experienceTitles = collect($profile->experience ?? [])
            ->pluck('title')
            ->filter()
            ->map(fn ($t) => trim((string) $t));
        $userSkills = $userSkills->merge($experienceTitles);

        $occupationPref = trim((string) data_get($profile, 'job_preferences.occupation_text', ''));
        if ($occupationPref !== '') {
            $userSkills->push($occupationPref);
        }

        $normalizedUserSkills = $userSkills
            ->map(fn ($s) => mb_strtolower(trim((string) $s)))
            ->filter(fn ($s) => mb_strlen($s) >= 2)
            ->unique()
            ->values()
            ->all();

        $jobSkillFrequency = [];

        foreach ($savedJobs as $job) {
            $jobText = implode(' ', [
                (string) $job->title,
                (string) $job->description,
                (string) $job->getRawOriginal('requirements'),
                (string) $job->preferred_skills,
            ]);

            foreach ($this->extractSkillCandidatesFromText($jobText) as $candidate) {
                $normalized = mb_strtolower(trim($candidate));

                if (mb_strlen($normalized) < 3) {
                    continue;
                }

                $jobSkillFrequency[$normalized] = ($jobSkillFrequency[$normalized] ?? 0) + 1;
            }
        }

        arsort($jobSkillFrequency);

        $savedJobSkills = collect($jobSkillFrequency)
            ->take(20)
            ->keys()
            ->values()
            ->all();

        $matchedSkills = [];
        $missingSkills = [];

        foreach ($savedJobSkills as $savedJobSkill) {
            $isMatched = false;

            foreach ($normalizedUserSkills as $userSkill) {
                if (str_contains($savedJobSkill, $userSkill) || str_contains($userSkill, $savedJobSkill)) {
                    $isMatched = true;
                    break;
                }
            }

            if ($isMatched) {
                $matchedSkills[] = $savedJobSkill;
                continue;
            }

            $missingSkills[] = $savedJobSkill;
        }

        return [
            'hasData' => true,
            'matched_skills_unique_count' => count(array_unique($matchedSkills)),
            'missing_skills' => array_values(array_unique($missingSkills)),
        ];
    }

    private function buildSkillGapAnalysis(?UserProfile $profile): array
    {
        if (! $profile) {
            return [
                'hasData' => false,
                'userSkills' => [],
                'marketSkills' => [],
                'matchedSkills' => [],
                'missingSkills' => [],
                'coveragePercent' => 0,
                'totalMarketSkills' => 0,
            ];
        }

        // Extract user skills from profile
        $userSkills = collect();

        // Primary skills array
        $userSkills = $userSkills->merge($profile->skills ?? []);

        // Other skills categories
        $otherSkills = $profile->other_skills ?? [];
        $userSkills = $userSkills
            ->merge($otherSkills['trade_manual'] ?? [])
            ->merge($otherSkills['it_technical'] ?? [])
            ->merge($otherSkills['soft_skills'] ?? [])
            ->push((string) ($otherSkills['other_text'] ?? ''));

        // Training skills
        $trainingSkills = collect($profile->training ?? [])
            ->pluck('skills')
            ->filter()
            ->flatMap(function ($skillsText) {
                return collect(preg_split('/[\r\n,]+/', (string) $skillsText) ?: [])
                    ->map(fn ($s) => trim($s))
                    ->filter();
            });
        $userSkills = $userSkills->merge($trainingSkills);

        // Experience titles
        $experienceTitles = collect($profile->experience ?? [])
            ->pluck('title')
            ->filter()
            ->map(fn ($t) => trim((string) $t));
        $userSkills = $userSkills->merge($experienceTitles);

        // Job preference occupation
        $occupationPref = trim((string) data_get($profile, 'job_preferences.occupation_text', ''));
        if ($occupationPref !== '') {
            $userSkills->push($occupationPref);
        }

        $normalizedUserSkills = $userSkills
            ->map(fn ($s) => mb_strtolower(trim((string) $s)))
            ->filter(fn ($s) => mb_strlen($s) >= 2)
            ->unique()
            ->values()
            ->all();

        // Extract market skills from active job postings
        $activeJobs = PesoJob::query()
            ->where('status', 'active')
            ->get(['title', 'description', 'requirements', 'preferred_skills']);

        $marketSkillFrequency = [];

        foreach ($activeJobs as $job) {
            $jobText = implode(' ', [
                (string) $job->title,
                (string) $job->description,
                (string) $job->getRawOriginal('requirements'),
                (string) $job->preferred_skills,
            ]);

            // Extract skill-like terms (words/phrases that appear to be skills)
            $skillCandidates = $this->extractSkillCandidatesFromText($jobText);

            foreach ($skillCandidates as $candidate) {
                $normalized = mb_strtolower(trim($candidate));
                if (mb_strlen($normalized) < 3) {
                    continue;
                }
                $marketSkillFrequency[$normalized] = ($marketSkillFrequency[$normalized] ?? 0) + 1;
            }
        }

        // Sort by frequency and take top market skills
        arsort($marketSkillFrequency);
        $topMarketSkills = collect($marketSkillFrequency)
            ->take(20)
            ->keys()
            ->values()
            ->all();

        // Find matches and gaps
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
            if ($isMatched) {
                $matchedSkills[] = $marketSkill;
            } else {
                $missingSkills[] = $marketSkill;
            }
        }

        $totalMarketSkills = count($topMarketSkills);
        $coveragePercent = $totalMarketSkills > 0
            ? (int) round((count($matchedSkills) / $totalMarketSkills) * 100)
            : 0;

        return [
            'hasData' => true,
            'userSkills' => array_slice($normalizedUserSkills, 0, 15),
            'marketSkills' => array_slice($topMarketSkills, 0, 10),
            'matchedSkills' => array_slice($matchedSkills, 0, 10),
            'missingSkills' => array_slice($missingSkills, 0, 10),
            'coveragePercent' => $coveragePercent,
            'totalMarketSkills' => $totalMarketSkills,
        ];
    }

    private function extractSkillCandidatesFromText(string $text): array
    {
        $text = mb_strtolower($text);

        // Common skill separators and delimiters
        $delimiters = '#[\r\n,;·•|/\\\\]+#u';
        $parts = preg_split($delimiters, $text) ?: [$text];

        $candidates = [];
        $stopWords = ['and', 'the', 'for', 'with', 'from', 'that', 'this', 'are', 'your', 'you', 'job', 'work', 'must', 'should', 'will', 'can', 'able', 'years', 'year', 'experience', 'required', 'preferred', 'qualifications', 'responsibilities', 'duties'];

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }

            // Try the whole part first as a skill phrase
            $cleanPart = trim(preg_replace('/^[-\s•·]+/', '', $part));
            if (mb_strlen($cleanPart) >= 3 && mb_strlen($cleanPart) <= 60) {
                $words = preg_split('/\s+/', $cleanPart) ?: [];
                $hasOnlyStopWords = true;
                foreach ($words as $w) {
                    if (! in_array($w, $stopWords, true)) {
                        $hasOnlyStopWords = false;
                        break;
                    }
                }
                if (! $hasOnlyStopWords) {
                    $candidates[] = $cleanPart;
                }
            }
        }

        // Also extract individual meaningful words as potential skills
        $words = preg_split('/[\s,;·•()]+/', $text) ?: [];
        foreach ($words as $word) {
            $word = trim($word, " \t\n\r\0\x0B.-_()");
            if (mb_strlen($word) >= 4 && mb_strlen($word) <= 25 && ! in_array($word, $stopWords, true)) {
                $candidates[] = $word;
            }
        }

        return $candidates;
    }

    private function sampleVacancies(): array
    {
        return [
            [
                'title' => 'Office Staff / Admin Assistant',
                'location' => 'Tankulan (Poblacion)',
                'employer_name' => 'PESO Partner Office',
                'salary_range' => 'Php 12,000 - Php 15,000',
                'description' => 'Handles office documents, data encoding, filing, and front desk support.',
                'requirements_list' => ['MS Office', 'Filing', 'Encoding'],
            ],
            [
                'title' => 'Construction Laborer',
                'location' => 'Damilag',
                'employer_name' => 'Local Construction Contractor',
                'salary_range' => 'Php 450/day',
                'description' => 'Assists in basic construction tasks and follows workplace safety procedures.',
                'requirements_list' => ['Basic tools', 'Safety awareness'],
            ],
            [
                'title' => 'Cashier',
                'location' => 'Alae',
                'employer_name' => 'Community Retail Store',
                'salary_range' => 'Php 11,500 - Php 13,000',
                'description' => 'Handles customer payments, POS transactions, and end-of-day cash balancing.',
                'requirements_list' => ['Customer service', 'POS'],
            ],
            [
                'title' => 'Delivery Driver',
                'location' => 'San Miguel',
                'employer_name' => 'Local Logistics Partner',
                'salary_range' => 'Php 13,000 - Php 16,000',
                'description' => 'Delivers goods within Manolo Fortich and nearby routes with proper documentation.',
                'requirements_list' => ['Driver license', 'Route familiarity'],
            ],
            [
                'title' => 'Sales Associate',
                'location' => 'Santo Nino',
                'employer_name' => 'Neighborhood Mart',
                'salary_range' => 'Php 10,500 - Php 12,500',
                'description' => 'Supports product display, customer assistance, and sales transactions.',
                'requirements_list' => ['Selling skills', 'Communication'],
            ],
            [
                'title' => 'Warehouse Helper',
                'location' => 'Agusan Canyon',
                'employer_name' => 'Agri Supply Distributor',
                'salary_range' => 'Php 430/day',
                'description' => 'Assists in loading, unloading, inventory checks, and stock arrangement.',
                'requirements_list' => ['Inventory handling', 'Physical fitness'],
            ],
        ];
    }

    private function calculateProfileCompletionPercent(?User $user, ?UserProfile $profile): int
    {
        $checks = [
            $this->hasBasicIdentity($user, $profile),
            $this->hasContactDetails($user, $profile),
            $this->hasAddressDetails($profile),
            $this->hasEducationDetails($profile),
            $this->hasExperienceDetails($profile),
            $this->hasSkillsDetails($profile),
        ];

        $completedChecks = collect($checks)->filter()->count();

        return (int) round(($completedChecks / count($checks)) * 100);
    }

    private function profileCompletionLabel(int $percent): string
    {
        if ($percent >= 100) {
            return 'Profile Complete';
        }

        if ($percent >= 67) {
            return 'Almost Complete';
        }

        if ($percent >= 34) {
            return 'In Progress';
        }

        return 'Getting Started';
    }

    private function hasBasicIdentity(?User $user, ?UserProfile $profile): bool
    {
        $name = trim((string) ($profile?->resume_name ?: $user?->name));
        $personal = $profile?->personal_information ?? [];

        if (
            trim((string) data_get($personal, 'first_name', '')) !== ''
            && trim((string) data_get($personal, 'surname', '')) !== ''
        ) {
            return true;
        }

        return $name !== '';
    }

    private function hasContactDetails(?User $user, ?UserProfile $profile): bool
    {
        $personal = $profile?->personal_information ?? [];
        $email = trim((string) ($profile?->resume_email ?: data_get($personal, 'email_address', $user?->email ?? '')));
        $phone = trim((string) ($profile?->phone ?: data_get($personal, 'contact_number', '')));

        return $email !== '' && $phone !== '';
    }

    private function hasAddressDetails(?UserProfile $profile): bool
    {
        $present = $profile?->present_address ?? [];
        $formattedAddress = trim((string) ($profile?->address ?? ''));

        if (
            trim((string) data_get($present, 'barangay', '')) !== ''
            && trim((string) data_get($present, 'municipality', '')) !== ''
            && trim((string) data_get($present, 'province', '')) !== ''
        ) {
            return true;
        }

        return $formattedAddress !== '';
    }

    private function hasEducationDetails(?UserProfile $profile): bool
    {
        return ! empty($profile?->education ?? []);
    }

    private function hasExperienceDetails(?UserProfile $profile): bool
    {
        return ! empty($profile?->experience ?? []);
    }

    private function hasSkillsDetails(?UserProfile $profile): bool
    {
        $skills = $profile?->skills ?? [];
        $otherSkills = $profile?->other_skills ?? [];

        if (! empty($skills)) {
            return true;
        }

        return ! empty($otherSkills['trade_manual'])
            || ! empty($otherSkills['it_technical'])
            || ! empty($otherSkills['soft_skills'])
            || trim((string) ($otherSkills['other_text'] ?? '')) !== '';
    }

    public function applyJob(PesoJob $job): View
    {
        return view('dashboard.jobseeker.apply-job', [
            'job' => $job->load(['employer', 'employer.companyProfile']),
        ]);
    }

    public function submitApplication(Request $request, PesoJob $job): RedirectResponse
    {
        $user = $request->user();

        // Validate based on resume type
        $validated = $request->validate([
            'letter' => ['nullable', 'string', 'max:2000'],
            'resume' => ['nullable', 'file', 'extensions:pdf,doc,docx', 'max:5120'],
            'resume_type' => ['required', 'in:upload,builder'],
            'use_resume_builder' => ['nullable', 'boolean'],
        ]);

        // Check if already applied
        $existingApplication = JobApplication::where('user_id', $user->id)
            ->where('peso_job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()
                ->route('jobseeker.applications')
                ->with('error', 'You have already applied for this job.');
        }

        $resumePath = null;
        $resumeOriginalFilename = null;
        $resumeFileExtension = null;
        $resumeType = $validated['resume_type'];

        // If an actual file was uploaded, always treat the submission as an upload.
        // This protects the flow when the hidden resume type gets out of sync in the UI.
        if ($request->hasFile('resume')) {
            $resumeType = 'upload';
        }

        // Handle resume based on type
        if ($resumeType === 'upload') {
            if ($request->hasFile('resume')) {
                $resumeFile = $request->file('resume');
                $resumePath = $resumeFile->store('resumes', 'public');
                $resumeOriginalFilename = $resumeFile->getClientOriginalName();
                $resumeFileExtension = $resumeFile->getClientOriginalExtension();
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Please upload a resume or select another resume option.');
            }
        } elseif ($resumeType === 'builder') {
            $userProfile = $user->profile ?? $user->userProfile;
            if ($userProfile && $userProfile->resume_name && $userProfile->resume_email) {
                // Store a reference to resume builder generated resume
                $resumePath = 'builder:' . $userProfile->id;
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'No resume found in Resume Builder. Please create one or upload a resume.');
            }
        }

        // Create new application
        $application = JobApplication::create([
            'user_id' => $user->id,
            'peso_job_id' => $job->id,
            'status' => 'pending',
            'notes' => $validated['letter'] ?? null,
            'resume_path' => $resumePath,
            'resume_original_filename' => $resumeOriginalFilename,
            'resume_file_extension' => $resumeFileExtension,
            'resume_type' => $resumeType,
        ]);

        // Notify employer about the new applicant. Keep application flow resilient if notification fails.
        if (! empty($job->employer_id)) {
            try {
                EmployerNotification::query()->create([
                    'employer_id' => $job->employer_id,
                    'type' => 'job_update',
                    'title' => 'New Job Application Received',
                    'message' => sprintf(
                        '%s applied for "%s". Review this in View Applicants or Notifications.',
                        $user->name,
                        $job->title
                    ),
                    'is_read' => false,
                ]);
            } catch (\Throwable) {
                try {
                    EmployerNotification::query()->create([
                        'employer_id' => $job->employer_id,
                        'type' => 'general',
                        'title' => 'New Job Application Received',
                        'message' => sprintf(
                            '%s applied for "%s". Review this in View Applicants or Notifications.',
                            $user->name,
                            $job->title
                        ),
                        'is_read' => false,
                    ]);
                } catch (\Throwable) {
                    // Intentionally ignored so application submission still succeeds.
                }
            }
        }

        return redirect()
            ->route('jobseeker.applications')
            ->with('status', 'Application submitted successfully!');
    }

    /**
     * Calculate jobseeker profile completion percentage
     */
    private function calculateJobseekerProfileCompletion(array $profileData): int
    {
        $completionFields = 0;
        $totalFields = 0;

        // Personal Information (6 main fields: first_name, surname, date_of_birth, sex, contact_number, email)
        $totalFields += 6;
        if (!empty($profileData['personal']['first_name'])) $completionFields++;
        if (!empty($profileData['personal']['surname'])) $completionFields++;
        if (!empty($profileData['personal']['date_of_birth'])) $completionFields++;
        if (!empty($profileData['personal']['sex'])) $completionFields++;
        if (!empty($profileData['personal']['contact_number'])) $completionFields++;
        if (!empty($profileData['personal']['email_address'])) $completionFields++;

        // Address (4 fields: house_no, barangay, municipality, province)
        $totalFields += 4;
        $address = $profileData['presentAddress'] ?? [];
        if (!empty($address['house_no'])) $completionFields++;
        if (!empty($address['barangay'])) $completionFields++;
        if (!empty($address['municipality'])) $completionFields++;
        if (!empty($address['province'])) $completionFields++;

        // Education (at least 1 entry)
        $totalFields += 1;
        $education = $profileData['education'] ?? [];
        if (!empty($education) && count($education) > 0) {
            $completionFields++;
        }

        // Training (at least 1 entry)
        $totalFields += 1;
        $training = $profileData['training'] ?? [];
        if (!empty($training) && count($training) > 0) {
            $completionFields++;
        }

        // Work Experience (at least 1 entry)
        $totalFields += 1;
        $experience = $profileData['experience'] ?? [];
        if (!empty($experience) && count($experience) > 0) {
            $completionFields++;
        }

        // Languages (at least 1 language)
        $totalFields += 1;
        $languages = $profileData['languages'] ?? [];
        if (!empty($languages) && count($languages) > 0) {
            $completionFields++;
        }

        return $totalFields > 0 ? (int) round(($completionFields / $totalFields) * 100) : 0;
    }
}
