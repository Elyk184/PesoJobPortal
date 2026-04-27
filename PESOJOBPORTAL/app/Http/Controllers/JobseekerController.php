<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\PesoClearance;
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
                ->map(function (PesoJob $job) {
                    return [
                        'title' => $job->title,
                        'location' => $job->location,
                        'employer_name' => $job->employer_name,
                        'salary_range' => $job->salary_range,
                        'description' => $job->description,
                    ];
                })
                ->values();
        }

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
            $applicationStatusCounts['interview'] = (int) ($rawApplicationCounts['interviewed'] ?? 0);
            $applicationStatusCounts['hired'] = (int) ($rawApplicationCounts['hired'] ?? 0);
            $applicationStatusCounts['recommended'] = (int) ($rawApplicationCounts['reviewed'] ?? 0);
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
                'url' => route('jobseeker.vacancies'),
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

        return view('jobseeker.dashboard', [
            'availableJobsCount' => $activeJobsCount > 0 ? $activeJobsCount : $sampleJobsCount,
            'profileCompletionPercent' => $profileCompletionPercent,
            'profileCompletionLabel' => $this->profileCompletionLabel($profileCompletionPercent),
            'recommendedJobs' => $recommendedJobs,
            'isUsingSampleRecommendations' => $isUsingSampleRecommendations,
            'isProfileMatchedRecommendations' => $isProfileMatchedRecommendations,
            'applicationStatusCounts' => $applicationStatusCounts,
            'dashboardNotifications' => $notifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'recentlyViewedJobs' => $recentlyViewedJobs,
            'recentlyViewedCount' => $recentlyViewedJobIds->count(),
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
        $manoloFortichBarangays = [
            'Agusan Canyon',
            'Alae',
            'Dahilayan',
            'Dalirig',
            'Damilag',
            'Dicklum',
            'Guilang-guilang',
            'Kalugmanan',
            'Lindaban',
            'Lingion',
            'Lunocan',
            'Maluko',
            'Mambatangan',
            'Mampayag',
            'Mantibugao',
            'Minsuro',
            'San Miguel',
            'Sankanan',
            'Santiago',
            'Santo Nino',
            'Tankulan (Poblacion)',
            'Ticala',
        ];

        $keyword = trim((string) $request->query('keyword', ''));
        $location = trim((string) $request->query('location', ''));
        $skills = trim((string) $request->query('skills', ''));
        $employer = trim((string) $request->query('employer', ''));
        $sort = (string) $request->query('sort', 'newest');

        if (! in_array($location, $manoloFortichBarangays, true)) {
            $location = '';
        }

        $jobsQuery = PesoJob::query()->where('status', 'active');

        if ($keyword !== '') {
            $jobsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhere('employer_name', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%')
                    ->orWhere('requirements', 'like', '%' . $keyword . '%');
            });
        }

        if ($location !== '') {
            $jobsQuery->where('location', 'like', '%' . $location . '%');
        }

        if ($skills !== '') {
            $jobsQuery->where(function ($query) use ($skills) {
                $query->where('requirements', 'like', '%' . $skills . '%')
                    ->orWhere('description', 'like', '%' . $skills . '%')
                    ->orWhere('title', 'like', '%' . $skills . '%');
            });
        }

        if ($employer !== '') {
            $jobsQuery->where('employer_name', 'like', '%' . $employer . '%');
        }

        if ($sort === 'oldest') {
            $jobsQuery->oldest();
        } elseif ($sort === 'title_asc') {
            $jobsQuery->orderBy('title');
        } elseif ($sort === 'location_asc') {
            $jobsQuery->orderBy('location')->orderByDesc('created_at');
        } else {
            $jobsQuery->latest();
        }

        $jobs = $jobsQuery->paginate(9)->withQueryString();

        $jobs->getCollection()->transform(function (PesoJob $job) {
            $job->setAttribute('requirements_list', $this->extractJobRequirements($job));

            return $job;
        });

        $currentPageJobIds = $jobs->getCollection()
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->values();

        if ($currentPageJobIds->isNotEmpty()) {
            $existingViewedIds = collect($request->session()->get('jobseeker_recently_viewed_job_ids', []))
                ->map(fn ($id) => (int) $id)
                ->filter(fn ($id) => $id > 0);

            $mergedViewedIds = $currentPageJobIds
                ->concat($existingViewedIds)
                ->unique()
                ->take(15)
                ->values()
                ->all();

            $request->session()->put('jobseeker_recently_viewed_job_ids', $mergedViewedIds);
        }

        return view('jobseeker.vacancies', [
            'jobs' => $jobs,
            'locations' => collect($manoloFortichBarangays),
            'sampleJobs' => collect($this->sampleVacancies()),
            'filters' => [
                'keyword' => $keyword,
                'location' => $location,
                'skills' => $skills,
                'employer' => $employer,
                'sort' => $sort,
            ],
        ]);
    }

    public function applications(Request $request): View
    {
        $statusMap = [
            'all' => ['pending', 'reviewed', 'interviewed', 'hired', 'rejected'],
            'pending' => ['pending'],
            'recommended' => ['reviewed'],
            'interview' => ['interviewed'],
            'hired' => ['hired'],
            'rejected' => ['rejected'],
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

        $statusSummary = [
            'all' => (int) $rawStatusCounts->sum(),
            'pending' => (int) ($rawStatusCounts['pending'] ?? 0),
            'recommended' => (int) ($rawStatusCounts['reviewed'] ?? 0),
            'interview' => (int) ($rawStatusCounts['interviewed'] ?? 0),
            'hired' => (int) ($rawStatusCounts['hired'] ?? 0),
            'rejected' => (int) ($rawStatusCounts['rejected'] ?? 0),
        ];

        return view('jobseeker.applications', [
            'applications' => $applications,
            'statusFilter' => $statusFilter,
            'statusSummary' => $statusSummary,
        ]);
    }

    public function recommendations(): View
    {
        $user = Auth::user();
        $profile = $user?->profile;
        $userId = (int) ($user?->id ?? 0);

        $signals = $this->buildRecommendationSignalsFromProfile($profile);
        $profileHasSkills = collect([
            $signals['skills'] ?? [],
            $signals['occupations'] ?? [],
            $signals['experience'] ?? [],
        ])->flatten()->isNotEmpty();

        $activeJobs = PesoJob::query()
            ->where('status', 'active')
            ->latest()
            ->limit(60)
            ->get();

        $recommendations = $activeJobs
            ->map(function (PesoJob $job) use ($signals) {
                $matchDetails = $this->buildJobMatchDetails($job, $signals);

                $requirementsText = implode(' ', $this->extractJobRequirements($job));
                $haystack = mb_strtolower(implode(' ', [
                    (string) $job->title,
                    (string) $job->description,
                    (string) $job->employer_name,
                    (string) $job->location,
                    $requirementsText,
                ]));

                $matchedSkills = collect($signals['skills'] ?? [])
                    ->filter(fn ($term) => $term !== '' && str_contains($haystack, mb_strtolower((string) $term)))
                    ->take(6)
                    ->values()
                    ->all();

                return [
                    'job' => $job,
                    'score' => (int) ($matchDetails['score'] ?? 0),
                    'matched_skills' => $matchedSkills,
                    'reasons' => $matchDetails['reasons'] ?? [],
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
            ->take(12)
            ->values();

        $activeJobsCount = PesoJob::query()
            ->where('status', 'active')
            ->count();

        $appliedJobsCount = $userId > 0
            ? JobApplication::query()->where('user_id', $userId)->count()
            : 0;

        return view('jobseeker.recommendations', [
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

        return view('jobseeker.notifications', [
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

        return view('jobseeker.skill-gap', [
            'skillGapAnalysis' => $skillGapAnalysis,
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

        return view('jobseeker.saved-jobs', [
            'savedJobs' => $savedJobs,
            'savedCount' => $savedJobs->count(),
        ]);
    }

    public function toggleSaveJob(PesoJob $job): JsonResponse
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

        return view('jobseeker.peso-clearance', [
            'clearance' => $clearance,
            'pendingRequest' => $pendingRequest,
            'hasClearance' => $hasClearance,
            'hasPendingRequest' => $hasPendingRequest,
            'isActive' => $isActive,
            'isExpired' => $isExpired,
            'canRequestClearance' => $canRequestClearance,
        ]);
    }

    public function requestPesoClearance(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'remarks' => ['nullable', 'string', 'max:500'],
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

        PesoClearance::create([
            'user_id' => $user->id,
            'request_date' => now(),
            'clearance_number' => 'REQ-' . now()->format('YmdHis') . '-' . str_pad((string) ($clearanceCount + 1), 3, '0', STR_PAD_LEFT),
            'issue_date' => null,
            'expiry_date' => null,
            'status' => 'pending',
            'remarks' => trim((string) $request->input('remarks', '')) ?: 'PESO clearance request submitted by jobseeker.',
        ]);

        return back()->with('status', 'Your PESO clearance request has been sent to the admin for review.');
    }

    public function profile(): View
    {
        return view('jobseeker.profile', $this->profileFormData(Auth::user()));
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
            'personal_information.sex' => ['nullable', 'in:Male,Female,Prefer not to say'],
            'personal_information.religion' => ['nullable', 'string', 'max:255'],
            'personal_information.civil_status' => ['nullable', 'string', 'max:255'],
            'personal_information.height' => ['nullable', 'string', 'max:20'],
            'personal_information.tin' => ['nullable', 'string', 'max:50'],
            'personal_information.contact_number' => ['nullable', 'string', 'max:50'],
            'personal_information.email_address' => ['nullable', 'email', 'max:255'],
            'education_currently_in_school' => ['nullable', 'boolean'],

            'present_address.house_no' => ['nullable', 'string', 'max:255'],
            'present_address.barangay' => ['nullable', 'string', 'max:255'],
            'present_address.municipality' => ['nullable', 'string', 'max:255'],
            'present_address.province' => ['nullable', 'string', 'max:255'],

            'permanent_address.same_as_present' => ['nullable', 'boolean'],
            'permanent_address.house_no' => ['nullable', 'string', 'max:255'],
            'permanent_address.barangay' => ['nullable', 'string', 'max:255'],
            'permanent_address.municipality' => ['nullable', 'string', 'max:255'],
            'permanent_address.province' => ['nullable', 'string', 'max:255'],

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
            'other_skills.other_text' => ['nullable', 'string', 'max:255'],
            'other_skills.with_certificate' => ['nullable', 'boolean'],
            'other_skills.by_experience' => ['nullable', 'boolean'],

            'employment_status.wage_employed' => ['nullable', 'boolean'],
            'employment_status.self_employed' => ['nullable', 'boolean'],
            'employment_status.unemployed' => ['nullable', 'boolean'],

            'job_preferences.part_time' => ['nullable', 'boolean'],
            'job_preferences.full_time' => ['nullable', 'boolean'],
            'job_preferences.local' => ['nullable', 'boolean'],
            'job_preferences.overseas' => ['nullable', 'boolean'],
            'job_preferences.occupation_text' => ['nullable', 'string', 'max:1000'],

            'languages' => ['nullable', 'array'],
            'languages.*.language' => ['nullable', 'string', 'max:255'],
            'languages.*.read' => ['nullable', 'boolean'],
            'languages.*.write' => ['nullable', 'boolean'],
            'languages.*.speak' => ['nullable', 'boolean'],
            'languages.*.understand' => ['nullable', 'boolean'],
            'languages.*.other' => ['nullable', 'string', 'max:255'],

            'disability.visual' => ['nullable', 'boolean'],
            'disability.speech' => ['nullable', 'boolean'],
            'disability.mental' => ['nullable', 'boolean'],
            'disability.hearing' => ['nullable', 'boolean'],
            'disability.physical' => ['nullable', 'boolean'],
            'disability.other' => ['nullable', 'boolean'],
            'disability.other_text' => ['nullable', 'string', 'max:255'],
        ]);

        $personal = $validated['personal_information'] ?? [];
        $presentAddress = $validated['present_address'] ?? [];
        $permanentAddress = $validated['permanent_address'] ?? [];
        $personal['currently_in_school'] = (bool) ($validated['education_currently_in_school'] ?? false);
        $educationRows = $this->normalizeResumeSection($validated['education'] ?? [], ['school', 'course', 'year']);
        $trainingRows = $this->normalizeResumeSection($validated['training'] ?? [], ['course', 'hours', 'institution', 'dates', 'skills', 'certificates']);
        $experienceRows = $this->normalizeResumeSection($validated['experience'] ?? [], ['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details']);
        $eligibilityRows = $this->normalizeResumeSection($validated['eligibility'] ?? [], ['eligibility', 'date_taken', 'license', 'valid_until']);

        $otherSkills = [
            'trade_manual' => $this->normalizeList(implode(', ', $validated['other_skills']['trade_manual'] ?? [])),
            'it_technical' => $this->normalizeList(implode(', ', $validated['other_skills']['it_technical'] ?? [])),
            'soft_skills' => $this->normalizeList(implode(', ', $validated['other_skills']['soft_skills'] ?? [])),
            'other_text' => trim((string) ($validated['other_skills']['other_text'] ?? '')),
            'with_certificate' => (bool) ($validated['other_skills']['with_certificate'] ?? false),
            'by_experience' => (bool) ($validated['other_skills']['by_experience'] ?? false),
        ];

        $employmentStatus = [
            'wage_employed' => (bool) ($validated['employment_status']['wage_employed'] ?? false),
            'self_employed' => (bool) ($validated['employment_status']['self_employed'] ?? false),
            'unemployed' => (bool) ($validated['employment_status']['unemployed'] ?? false),
            'has_work_experience' => (bool) ($validated['work_experience_has'] ?? false),
        ];

        $jobPreferences = [
            'part_time' => (bool) ($validated['job_preferences']['part_time'] ?? false),
            'full_time' => (bool) ($validated['job_preferences']['full_time'] ?? false),
            'local' => (bool) ($validated['job_preferences']['local'] ?? false),
            'overseas' => (bool) ($validated['job_preferences']['overseas'] ?? false),
            'occupation_text' => trim((string) ($validated['job_preferences']['occupation_text'] ?? '')),
        ];

        $languages = $this->normalizeLanguageRows($validated['languages'] ?? []);

        $disability = [
            'visual' => (bool) ($validated['disability']['visual'] ?? false),
            'speech' => (bool) ($validated['disability']['speech'] ?? false),
            'mental' => (bool) ($validated['disability']['mental'] ?? false),
            'hearing' => (bool) ($validated['disability']['hearing'] ?? false),
            'physical' => (bool) ($validated['disability']['physical'] ?? false),
            'other' => (bool) ($validated['disability']['other'] ?? false),
            'other_text' => trim((string) ($validated['disability']['other_text'] ?? '')),
        ];

        $fullName = collect([
            $personal['first_name'] ?? '',
            $personal['middle_initial'] ?? '',
            $personal['surname'] ?? '',
            $personal['suffix'] ?? '',
        ])->filter()->join(' ');

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'personal_information' => $personal,
                'present_address' => $presentAddress,
                'permanent_address' => $permanentAddress,
                'resume_name' => $fullName ?: $user->name,
                'resume_email' => $personal['email_address'] ?? $user->email,
                'phone' => $personal['contact_number'] ?? null,
                'address' => $this->formatAddress($presentAddress),
                'skills' => $this->buildSkillList($otherSkills),
                'education' => $educationRows,
                'training' => $trainingRows,
                'experience' => $experienceRows,
                'eligibility' => $eligibilityRows,
                'other_skills' => $otherSkills,
                'employment_status' => $employmentStatus,
                'job_preferences' => $jobPreferences,
                'languages' => $languages,
                'disability' => $disability,
            ]
        );

        $user->name = $fullName ?: $user->name;
        $user->save();

        return redirect()
            ->route('jobseeker.profile')
            ->with('status', 'Profile saved successfully.');
    }

    public function resumeBuilder(): View
    {
        $data = $this->resumeBuilderData(Auth::user());

        return view('jobseeker.resume-builder', $data);
    }

    public function exportResumeBuilder(): Response
    {
        $data = $this->resumeBuilderData(Auth::user());

        $pdf = Pdf::loadView('jobseeker.resume-builder-pdf', $data)
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

    private function profileFormData(?User $user): array
    {
        $profile = $user?->profile;
        $displayName = trim((string) ($user?->name ?? ''));
        $nameParts = $this->splitDisplayName($displayName);

        $personalInformation = array_merge([
            'surname' => $nameParts['surname'],
            'first_name' => $nameParts['first_name'],
            'middle_initial' => $nameParts['middle_initial'],
            'suffix' => $nameParts['suffix'],
            'date_of_birth' => '',
            'sex' => 'Female',
            'religion' => '',
            'civil_status' => '',
            'height' => '',
            'tin' => '',
            'contact_number' => $profile?->phone ?? '',
            'email_address' => $profile?->resume_email ?? $user?->email ?? '',
            'currently_in_school' => (bool) data_get($profile, 'personal_information.currently_in_school', false),
        ], $profile?->personal_information ?? []);

        $presentAddress = array_merge([
            'house_no' => '',
            'barangay' => '',
            'municipality' => '',
            'province' => '',
        ], $profile?->present_address ?? $this->splitAddress((string) ($profile?->address ?? '')));

        $permanentAddress = array_merge([
            'same_as_present' => false,
            'house_no' => '',
            'barangay' => '',
            'municipality' => '',
            'province' => '',
        ], $profile?->permanent_address ?? []);

        $educationRows = $profile?->education ?? [[ 'school' => '', 'course' => '', 'year' => '' ]];
        $trainingRows = $profile?->training ?? [[ 'course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '' ]];
        $experienceRows = $profile?->experience ?? [[ 'company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '' ]];
        $eligibilityRows = $profile?->eligibility ?? [[ 'eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '' ]];

        $otherSkills = $profile?->other_skills ?? $this->defaultOtherSkills();
        $employmentStatus = $profile?->employment_status ?? $this->defaultEmploymentStatus();
        $employmentStatus['has_work_experience'] = data_get($profile, 'employment_status.has_work_experience', null);
        $jobPreferences = $profile?->job_preferences ?? $this->defaultJobPreferences();
        $languages = $profile?->languages ?? $this->defaultLanguages();
        $disability = $profile?->disability ?? $this->defaultDisability();

        return [
            'user' => $user,
            'profile' => $profile,
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
            'resumeFileName' => $profile?->resume_path ? basename($profile->resume_path) : null,
            'resumeFileUrl' => $profile?->resume_path ? asset('storage/' . ltrim($profile->resume_path, '/')) : null,
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
        $delimiters = '/[\r\n,;·•|\\\/]+/';
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
}
