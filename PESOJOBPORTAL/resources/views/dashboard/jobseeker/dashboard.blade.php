@extends('layouts.dashboard')

@section('title', 'Jobseeker Dashboard | PESO Job Portal')

@push('styles')
<style>
    .jobseeker-dashboard {
        color: #2e3f52;
    }

    .jobseeker-dashboard .dashboard-topbar {
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .jobseeker-dashboard .dashboard-topbar-title {
        font-size: 1.12rem;
        font-weight: 800;
    }

    .jobseeker-dashboard .dashboard-hero {
        border-radius: 14px;
        border: 1px solid #d4deea;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }

    .jobseeker-dashboard .dashboard-hero-meta {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #62758b;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .jobseeker-dashboard .dashboard-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #d4deea;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.76rem;
        color: #3f566e;
        background: #ffffff;
        font-weight: 700;
    }

    .jobseeker-dashboard .completion-meter {
        min-width: 220px;
    }

    .jobseeker-dashboard .completion-meter .progress {
        height: 8px;
        border-radius: 999px;
        background: #e8eef6;
    }

    .jobseeker-dashboard .completion-meter .progress-bar {
        background: linear-gradient(90deg, #3f8efc 0%, #2f8f5e 100%);
    }

    .jobseeker-dashboard .dashboard-stat-card {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .jobseeker-dashboard .dashboard-stat-card:hover {
        border-color: #c7d6e7;
        box-shadow: 0 6px 16px rgba(24, 43, 66, 0.06);
    }

    .jobseeker-dashboard .dashboard-stat-icon {
        border-radius: 10px;
    }

    .jobseeker-dashboard .stat-apps {
        background: rgba(39, 123, 73, 0.12);
        color: #277b49;
    }

    .jobseeker-dashboard .stat-saved {
        background: rgba(204, 141, 36, 0.14);
        color: #a06d19;
    }

    .jobseeker-dashboard .section-head {
        border-bottom: 1px solid #e2e9f2;
        padding-bottom: 12px;
        margin-bottom: 14px;
    }

    .jobseeker-dashboard .dashboard-skeleton {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }

    :root:not(.dashboard-ready) .jobseeker-dashboard .dashboard-skeleton {
        min-height: var(--skeleton-height, 180px);
    }

    :root:not(.dashboard-ready) .jobseeker-dashboard .dashboard-skeleton > * {
        opacity: 0;
    }

    :root:not(.dashboard-ready) .jobseeker-dashboard .dashboard-skeleton::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(90deg, #edf3fa 0%, #f7fbff 48%, #edf3fa 100%);
        background-size: 220% 100%;
        animation: dashboardSkeletonShimmer 1.2s linear infinite;
        border: 1px solid #dbe5f1;
    }

    @keyframes dashboardSkeletonShimmer {
        from {
            background-position: 200% 0;
        }

        to {
            background-position: -20% 0;
        }
    }

    .jobseeker-dashboard .status-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .jobseeker-dashboard .status-item {
        border: 1px solid #dbe5f1;
        border-radius: 12px;
        background: #fbfdff;
        padding: 14px;
        min-height: 86px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .jobseeker-dashboard a.status-item {
        color: inherit;
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .jobseeker-dashboard a.status-item:hover {
        border-color: #c7d6e7;
        box-shadow: 0 6px 16px rgba(24, 43, 66, 0.06);
    }

    .jobseeker-dashboard .status-item-label {
        font-size: 0.74rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #647a92;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .jobseeker-dashboard .status-item-value {
        font-size: 1.45rem;
        line-height: 1;
        font-weight: 800;
        color: #2f4561;
    }

    .jobseeker-dashboard .status-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .jobseeker-dashboard .status-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid #dbe5f1;
        background: #f7faff;
        color: #3b536e;
    }

    .jobseeker-dashboard .status-legend-item .dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
    }

    .jobseeker-dashboard .status-legend-pending .dot { background: #c69123; }
    .jobseeker-dashboard .status-legend-interview .dot { background: #2f8f5e; }
    .jobseeker-dashboard .status-legend-hired .dot { background: #2d65b1; }
    .jobseeker-dashboard .status-legend-recommended .dot { background: #7f67c7; }

    .jobseeker-dashboard .status-pending {
        border-left: 4px solid #c69123;
    }

    .jobseeker-dashboard .status-interview {
        border-left: 4px solid #2f8f5e;
    }

    .jobseeker-dashboard .status-hired {
        border-left: 4px solid #2d65b1;
    }

    .jobseeker-dashboard .status-recommended {
        border-left: 4px solid #7f67c7;
    }

    .jobseeker-dashboard .dashboard-empty-state {
        min-height: 180px;
        border: 1px dashed #cfdbe8;
        border-radius: 12px;
        background: #fbfdff;
    }

    .jobseeker-dashboard .recommended-job-card {
        border: 1px solid #dbe5f1;
        border-radius: 12px;
        background: #fbfdff;
        padding: 14px;
        height: 100%;
    }

    .jobseeker-dashboard .recommended-job-title {
        font-weight: 700;
        color: #2f4561;
    }

    .jobseeker-dashboard .recommended-job-meta {
        font-size: 0.86rem;
        color: #6c8098;
    }

    .jobseeker-dashboard .notifications-list {
        display: grid;
        gap: 10px;
    }

    .jobseeker-dashboard .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        border: 1px solid #dbe5f1;
        border-radius: 10px;
        background: #fbfdff;
        padding: 10px 12px;
        text-decoration: none;
        color: inherit;
    }

    .jobseeker-dashboard .notification-item:hover {
        border-color: #c7d6e7;
        box-shadow: 0 4px 12px rgba(24, 43, 66, 0.06);
    }

    .jobseeker-dashboard .notification-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        background: #edf3fa;
        color: #456487;
        flex: 0 0 auto;
    }

    .jobseeker-dashboard .notification-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #2f4561;
        margin-bottom: 2px;
    }

    .jobseeker-dashboard .notification-message {
        font-size: 0.8rem;
        color: #60758e;
    }

    .jobseeker-dashboard .recently-viewed-item {
        border: 1px solid #dbe5f1;
        border-radius: 10px;
        background: #fbfdff;
        padding: 10px 12px;
        height: 100%;
    }

    .jobseeker-dashboard .recently-viewed-title {
        font-weight: 700;
        color: #2f4561;
        margin-bottom: 2px;
    }

    .jobseeker-dashboard .recently-viewed-meta {
        font-size: 0.8rem;
        color: #60758e;
    }

    .jobseeker-dashboard .empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        margin: 0 auto 10px;
        background: #edf3fa;
        color: #456487;
        font-size: 1.3rem;
    }

    @media (max-width: 991.98px) {
        .jobseeker-dashboard .status-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .jobseeker-dashboard .status-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        requestAnimationFrame(function () {
            document.documentElement.classList.add('dashboard-ready');
        });

        const counters = document.querySelectorAll('[data-counter-target]');

        if (!counters.length) {
            return;
        }

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        counters.forEach(function (element) {
            const target = Number(element.getAttribute('data-counter-target')) || 0;

            if (prefersReducedMotion || target <= 0) {
                element.textContent = target.toLocaleString();
                return;
            }

            const duration = 900;
            const startTime = performance.now();

            function tick(now) {
                const progress = Math.min((now - startTime) / duration, 1);
                const easedProgress = 1 - Math.pow(1 - progress, 3);
                const currentValue = Math.round(target * easedProgress);

                element.textContent = currentValue.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(tick);
                }
            }

            requestAnimationFrame(tick);
        });
    })();
</script>
@endpush

@section('content')
<section class="jobseeker-dashboard" aria-label="Jobseeker dashboard">
    <div class="dashboard-topbar">
        <div>
            <div class="dashboard-topbar-title">Dashboard</div>
            <div class="dashboard-topbar-subtitle">Find your dream job</div>
        </div>
        <div class="d-none d-md-block text-end">
            <div class="fw-semibold text-secondary">{{ auth()->user()->name ?? 'Jobseeker' }}</div>
            <div class="dashboard-topbar-subtitle">Jobseeker Portal</div>
        </div>
    </div>

    <div class="dashboard-section-card dashboard-hero p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="dashboard-hero-meta">Overview</div>
                <h2 class="h4 mb-1 fw-bold">Welcome back, {{ auth()->user()->name ?? 'Jobseeker' }}!</h2>
                <p class="mb-0 text-muted">
                    Your profile is {{ $profileCompletionPercent ?? 0 }}% complete.
                    Keep it updated to receive relevant job recommendations.
                </p>
            </div>
            <div class="d-flex flex-column align-items-lg-end gap-2 completion-meter">
                <span class="dashboard-pill">
                    <i class="bi bi-patch-check"></i>
                    {{ $profileCompletionLabel ?? 'Getting Started' }} ({{ $profileCompletionPercent ?? 0 }}%)
                </span>
                <div class="progress w-100" role="progressbar" aria-label="Profile completion" aria-valuenow="{{ $profileCompletionPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: {{ $profileCompletionPercent ?? 0 }}%;"></div>
                </div>
                <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-primary px-3 shadow-sm">
                    <i class="bi bi-search me-2"></i>Browse Jobs
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="{{ $availableJobsCount ?? 0 }}">{{ $availableJobsCount ?? 0 }}</div>
                    <div class="dashboard-stat-label">Available Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-apps"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="{{ $applicationStatusCounts['total'] ?? 0 }}">{{ $applicationStatusCounts['total'] ?? 0 }}</div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-saved"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="{{ $recentlyViewedCount ?? 0 }}">{{ $recentlyViewedCount ?? 0 }}</div>
                    <div class="dashboard-stat-label">Recently Viewed</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 180px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-bell me-2"></i>Notifications</h3>
            <div class="d-flex align-items-center gap-2">
                <span class="badge text-bg-danger">{{ $unreadNotificationsCount ?? 0 }} unread</span>
                @if (($unreadNotificationsCount ?? 0) > 0)
                    <a href="{{ route('jobseeker.dashboard', ['notifications' => 'read']) }}" class="btn btn-sm btn-outline-secondary">Mark all as read</a>
                @endif
            </div>
        </div>

        @if (($dashboardNotifications ?? collect())->isNotEmpty())
            <div class="notifications-list">
                @foreach ($dashboardNotifications as $notification)
                    <a href="{{ $notification['url'] }}" class="notification-item">
                        <div class="notification-icon"><i class="bi {{ $notification['icon'] }}"></i></div>
                        <div>
                            <div class="notification-title">{{ $notification['title'] }}</div>
                            <div class="notification-message">{{ $notification['message'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty-state">
                <div>
                    <div class="empty-icon"><i class="bi bi-bell"></i></div>
                    <div class="fw-semibold text-secondary">All caught up.</div>
                    <div class="small">No new notifications right now.</div>
                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary mt-2">Browse New Jobs</a>
                </div>
            </div>
        @endif
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 190px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Application Status</h3>
            <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="status-legend" aria-label="Application status legend">
            <span class="status-legend-item status-legend-pending"><span class="dot" aria-hidden="true"></span><i class="bi bi-hourglass-split"></i>Pending</span>
            <span class="status-legend-item status-legend-interview"><span class="dot" aria-hidden="true"></span><i class="bi bi-mic"></i>Interview</span>
            <span class="status-legend-item status-legend-hired"><span class="dot" aria-hidden="true"></span><i class="bi bi-person-check"></i>Hired</span>
            <span class="status-legend-item status-legend-recommended"><span class="dot" aria-hidden="true"></span><i class="bi bi-stars"></i>Recommended</span>
        </div>

        <div class="status-grid">
            <a href="{{ route('jobseeker.applications', ['status' => 'pending']) }}" class="status-item status-pending">
                <div class="status-item-label">Pending Review</div>
                <div class="status-item-value" data-counter-target="{{ $applicationStatusCounts['pending'] ?? 0 }}">{{ $applicationStatusCounts['pending'] ?? 0 }}</div>
            </a>
            <a href="{{ route('jobseeker.applications', ['status' => 'interview']) }}" class="status-item status-interview">
                <div class="status-item-label">Interview</div>
                <div class="status-item-value" data-counter-target="{{ $applicationStatusCounts['interview'] ?? 0 }}">{{ $applicationStatusCounts['interview'] ?? 0 }}</div>
            </a>
            <a href="{{ route('jobseeker.applications', ['status' => 'hired']) }}" class="status-item status-hired">
                <div class="status-item-label">Hired</div>
                <div class="status-item-value" data-counter-target="{{ $applicationStatusCounts['hired'] ?? 0 }}">{{ $applicationStatusCounts['hired'] ?? 0 }}</div>
            </a>
            <a href="{{ route('jobseeker.applications', ['status' => 'recommended']) }}" class="status-item status-recommended">
                <div class="status-item-label">Recommended</div>
                <div class="status-item-value" data-counter-target="{{ $applicationStatusCounts['recommended'] ?? 0 }}">{{ $applicationStatusCounts['recommended'] ?? 0 }}</div>
            </a>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 180px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recently Viewed Jobs</h3>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary">Browse More</a>
        </div>

        @if (($recentlyViewedJobs ?? collect())->isNotEmpty())
            <div class="row g-3">
                @foreach ($recentlyViewedJobs as $job)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="recently-viewed-item">
                            <div class="recently-viewed-title">{{ $job['title'] }}</div>
                            <div class="recently-viewed-meta mb-1">{{ $job['location'] }} • {{ $job['employer_name'] }}</div>
                            @if (! empty($job['salary_range']))
                                <div class="small mb-1"><strong>Salary:</strong> {{ $job['salary_range'] }}</div>
                            @endif
                            <div class="small text-muted">{{ \Illuminate\Support\Str::limit($job['description'], 80) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty-state">
                <div>
                    <div class="empty-icon"><i class="bi bi-clock-history"></i></div>
                    <div class="fw-semibold text-secondary">No recently viewed jobs yet.</div>
                    <div class="small">Open the vacancies page to build your recent list.</div>
                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary mt-2">Go to Vacancies</a>
                </div>
            </div>
        @endif
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 dashboard-skeleton" style="--skeleton-height: 220px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-stars me-2"></i>Recommended Jobs</h3>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        @if (($recommendedJobs ?? collect())->isNotEmpty())
            @if ($isUsingSampleRecommendations ?? false)
                <div class="alert alert-warning py-2 px-3 small mb-3" role="alert">
                    Showing sample recommendations while waiting for active job posts.
                </div>
            @endif

            <div class="row g-3">
                @foreach ($recommendedJobs as $job)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="recommended-job-card d-flex flex-column">
                            <div class="recommended-job-title mb-1">{{ $job['title'] }}</div>
                            <div class="recommended-job-meta mb-2">{{ $job['location'] }} • {{ $job['employer_name'] }}</div>

                            @if (! empty($job['salary_range']))
                                <div class="small mb-2"><strong>Salary:</strong> {{ $job['salary_range'] }}</div>
                            @endif

                            <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($job['description'], 100) }}</p>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @forelse (collect($job['requirements_list'])->take(3) as $requirement)
                                    <span class="badge rounded-pill text-bg-light">{{ $requirement }}</span>
                                @empty
                                    <span class="badge rounded-pill text-bg-light">No listed requirements</span>
                                @endforelse
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="dashboard-empty-state">
                <div>
                    <div class="empty-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="fw-semibold text-secondary">No job recommendations yet.</div>
                    <div class="small">Complete your profile to get personalized job suggestions.</div>
                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary mt-2">Browse Vacancies</a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
