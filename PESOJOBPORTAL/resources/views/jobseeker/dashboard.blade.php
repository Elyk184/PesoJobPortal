@extends('layouts.dashboard')

@section('title', 'Jobseeker Dashboard | PESO Job Portal')

@push('styles')
<style>
    .jobseeker-dashboard {
        --land-blue-900: #1e3a8a;
        --land-blue-800: #1e40af;
        --land-red-600: #dc2626;
        --land-yellow-300: #fcd34d;
        --land-white: #ffffff;
        --dash-bg: #f4f7fb;
        --dash-card: #ffffff;
        --dash-border: #dbe5f1;
        --dash-text: #1e2b3a;
        --dash-muted: #60758e;
        --dash-accent: var(--land-blue-900);
        --dash-success: var(--land-blue-800);
        --dash-warning: var(--land-yellow-300);
        --dash-violet: var(--land-red-600);
        color: var(--dash-text);
        font-family: "Manrope", "Segoe UI", sans-serif;
        background:
            radial-gradient(90rem 50rem at 92% -10%, #dfe8f8 0%, rgba(223, 232, 248, 0) 62%),
            radial-gradient(85rem 45rem at -12% 0%, #eaf1fb 0%, rgba(234, 241, 251, 0) 57%),
            var(--dash-bg);
        border-radius: 18px;
        padding: 16px;
    }

    .jobseeker-dashboard .dashboard-hero {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid var(--dash-border);
        background: linear-gradient(135deg, var(--land-white) 0%, #f6f9ff 44%, #edf3ff 100%);
        box-shadow: 0 12px 30px rgba(17, 30, 52, 0.08);
    }

    .jobseeker-dashboard .dashboard-hero::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--land-blue-900) 0%, var(--land-blue-800) 60%, var(--land-yellow-300) 100%);
    }

    .jobseeker-dashboard .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -60px;
        top: -60px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(30, 64, 175, 0.16) 0%, rgba(30, 64, 175, 0) 72%);
        pointer-events: none;
    }

    .jobseeker-dashboard .dashboard-hero-meta {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #3d5c83;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .jobseeker-dashboard .dashboard-hero .h4 {
        color: #1f3555;
    }

    .jobseeker-dashboard .dashboard-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--dash-border);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.76rem;
        color: var(--land-blue-900);
        background: #ffffff;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.08);
    }

    .jobseeker-dashboard .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .jobseeker-dashboard .quick-actions-grid .quick-action-btn:last-child {
        grid-column: span 2;
    }

    .jobseeker-dashboard .quick-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid #c5d3e9;
        border-radius: 10px;
        background: #fff;
        color: #1f3555;
        text-decoration: none;
        padding: 8px 10px;
        font-size: 0.78rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .jobseeker-dashboard .quick-action-btn:hover {
        border-color: var(--land-red-600);
        background: rgba(220, 38, 38, 0.08);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(10, 35, 80, 0.14);
    }

    .jobseeker-dashboard .completion-meter {
        min-width: 220px;
        width: 100%;
        max-width: 460px;
    }

    .jobseeker-dashboard .completion-meter .progress {
        height: 8px;
        border-radius: 999px;
        background: #e8eef6;
    }

    .jobseeker-dashboard .completion-meter .progress-bar {
        background: linear-gradient(90deg, var(--land-blue-900) 0%, var(--land-blue-800) 60%, var(--land-yellow-300) 100%);
    }

    .jobseeker-dashboard .dashboard-stat-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 14px;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .jobseeker-dashboard .dashboard-stat-card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--land-blue-900), var(--land-red-600));
        opacity: 0.9;
    }

    .jobseeker-dashboard .dashboard-stat-card:hover {
        border-color: #b8c9de;
        box-shadow: 0 10px 24px rgba(24, 43, 66, 0.08);
    }

    .jobseeker-dashboard .dashboard-stat-icon {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        background: #eaf2fc;
        color: var(--dash-accent);
        font-size: 1.08rem;
        border-radius: 10px;
    }

    .jobseeker-dashboard .stat-apps {
        background: rgba(30, 64, 175, 0.12);
        color: #1e40af;
    }

    .jobseeker-dashboard .stat-saved {
        background: rgba(252, 211, 77, 0.22);
        color: #8a6512;
    }

    .jobseeker-dashboard .dashboard-stat-trend {
        font-size: 0.74rem;
        color: var(--dash-muted);
        margin-top: 2px;
    }

    .jobseeker-dashboard .dashboard-stat-number {
        font-size: 1.45rem;
        line-height: 1;
        letter-spacing: -0.02em;
        color: #1b2e4a;
        font-weight: 800;
    }

    .jobseeker-dashboard .dashboard-stat-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #4f6480;
        margin-top: 3px;
    }

    .jobseeker-dashboard .section-head {
        border-bottom: 1px solid var(--dash-border);
        padding-bottom: 12px;
        margin-bottom: 14px;
    }

    .jobseeker-dashboard .section-head .h5 {
        color: #1f3555;
    }

    .jobseeker-dashboard .dashboard-section-card {
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .jobseeker-dashboard .dashboard-section-card:not(.dashboard-hero):hover {
        transform: translateY(-2px);
        border-color: #c9d8ea;
        box-shadow: 0 12px 26px rgba(18, 36, 58, 0.08);
    }

    .jobseeker-dashboard .dashboard-section-action,
    .jobseeker-dashboard .mark-read-btn,
    .jobseeker-dashboard .empty-action-btn {
        border-radius: 999px;
        font-weight: 700;
        border-color: #c5d3e5;
        transition: all 0.2s ease;
    }

    .jobseeker-dashboard .dashboard-section-action:hover,
    .jobseeker-dashboard .mark-read-btn:hover,
    .jobseeker-dashboard .empty-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(30, 58, 138, 0.1);
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

    .jobseeker-dashboard .status-progress {
        display: flex;
        height: 8px;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 12px;
        background: #e7edf5;
    }

    .jobseeker-dashboard .status-segment {
        height: 100%;
    }

    .jobseeker-dashboard .status-segment.pending { background: #f59e0b; }
    .jobseeker-dashboard .status-segment.interview { background: #1e40af; }
    .jobseeker-dashboard .status-segment.hired { background: #dc2626; }
    .jobseeker-dashboard .status-segment.recommended { background: #1e3a8a; }

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
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .jobseeker-dashboard a.status-item:hover {
        border-color: #c7d6e7;
        box-shadow: 0 6px 16px rgba(24, 43, 66, 0.06);
        transform: translateY(-1px);
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

    .jobseeker-dashboard .status-legend-pending .dot { background: #f59e0b; }
    .jobseeker-dashboard .status-legend-interview .dot { background: #1e40af; }
    .jobseeker-dashboard .status-legend-hired .dot { background: #dc2626; }
    .jobseeker-dashboard .status-legend-recommended .dot { background: #1e3a8a; }

    .jobseeker-dashboard .status-pending {
        border-left: 4px solid #f59e0b;
    }

    .jobseeker-dashboard .status-interview {
        border-left: 4px solid #1e40af;
    }

    .jobseeker-dashboard .status-hired {
        border-left: 4px solid #dc2626;
    }

    .jobseeker-dashboard .status-recommended {
        border-left: 4px solid #1e3a8a;
    }

    .jobseeker-dashboard .dashboard-empty-state {
        min-height: 180px;
        border: 1px dashed #cfdbe8;
        border-radius: 12px;
        background: #fbfdff;
        display: grid;
        place-items: center;
        text-align: center;
        padding: 12px;
    }

    .jobseeker-dashboard .recommended-job-card {
        border: 1px solid var(--dash-border);
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

    .jobseeker-dashboard .match-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.68rem;
        font-weight: 800;
        color: #1e40af;
        border: 1px solid #c7d8f5;
        border-radius: 999px;
        background: #eef4ff;
        padding: 4px 8px;
        margin-bottom: 8px;
        width: fit-content;
    }

    .jobseeker-dashboard .match-reason {
        font-size: 0.73rem;
        color: var(--dash-muted);
        margin-bottom: 8px;
        font-weight: 700;
    }

    .jobseeker-dashboard .notifications-list {
        display: grid;
        gap: 10px;
    }

    .jobseeker-dashboard .notification-group-title {
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--dash-muted);
        margin: 8px 0;
    }

    .jobseeker-dashboard .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        border: 1px solid var(--dash-border);
        border-radius: 10px;
        background: #fbfdff;
        padding: 10px 12px;
        text-decoration: none;
        color: inherit;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .jobseeker-dashboard .notification-item:hover {
        border-color: #c7d6e7;
        box-shadow: 0 4px 12px rgba(24, 43, 66, 0.06);
        transform: translateY(-1px);
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

    .jobseeker-dashboard .notification-priority {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-left: 8px;
    }

    .jobseeker-dashboard .prio-high { color: #b54708; }
    .jobseeker-dashboard .prio-medium { color: #0f5ba7; }
    .jobseeker-dashboard .prio-low { color: #2f8f5e; }

    .jobseeker-dashboard .recently-viewed-item {
        border: 1px solid var(--dash-border);
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

    .jobseeker-dashboard .skill-gap-card {
        border: 1px solid var(--dash-border);
        border-radius: 12px;
        background: #fbfdff;
        padding: 14px;
        height: 100%;
    }

    .jobseeker-dashboard .skill-gap-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .jobseeker-dashboard .skill-gap-score {
        font-size: 1.6rem;
        font-weight: 800;
        color: #2f4561;
    }

    .jobseeker-dashboard .skill-gap-score-label {
        font-size: 0.72rem;
        color: #60758e;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .jobseeker-dashboard .skill-gap-progress {
        height: 10px;
        border-radius: 999px;
        background: #e7edf5;
        overflow: hidden;
        margin-bottom: 14px;
    }

    .jobseeker-dashboard .skill-gap-progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #1e40af 0%, #fcd34d 100%);
        transition: width 0.6s ease;
    }

    .jobseeker-dashboard .skill-gap-progress-fill.low {
        background: linear-gradient(90deg, #ef4444 0%, #f59e0b 100%);
    }

    .jobseeker-dashboard .skill-gap-progress-fill.medium {
        background: linear-gradient(90deg, #f59e0b 0%, #3f8efc 100%);
    }

    .jobseeker-dashboard .skill-tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .jobseeker-dashboard .skill-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        border: 1px solid #dbe5f1;
        background: #f7faff;
        color: #3b536e;
    }

    .jobseeker-dashboard .skill-tag.matched {
        background: #f0fbf5;
        color: #277b49;
        border-color: #c8e9d9;
    }

    .jobseeker-dashboard .skill-tag.missing {
        background: #fff5f5;
        color: #b54708;
        border-color: #fcd5d5;
    }

    .jobseeker-dashboard .skill-tag.user-skill {
        background: #eef4ff;
        color: #2d65b1;
        border-color: #c7d8f5;
    }

    .jobseeker-dashboard .skill-section-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #647a92;
        margin-bottom: 6px;
        margin-top: 12px;
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

        .jobseeker-dashboard .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .jobseeker-dashboard .quick-actions-grid .quick-action-btn:last-child {
            grid-column: span 1;
        }
    }

    @media (max-width: 575.98px) {
        .jobseeker-dashboard {
            padding: 10px;
        }

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
    <div class="dashboard-section-card dashboard-hero p-3 p-lg-4 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-8">
                <div class="dashboard-hero-meta">Overview</div>
                <h2 class="h4 mb-1 fw-bold">Welcome back, {{ auth()->user()->name ?? 'Jobseeker' }}!</h2>
                <p class="mb-0 text-muted">
                    Your profile is {{ $profileCompletionPercent ?? 0 }}% complete.
                    Keep it updated to receive relevant job recommendations.
                </p>
            </div>
            <div class="col-12 col-lg-4">
                <div class="d-flex flex-column gap-2 completion-meter ms-lg-auto">
                    <span class="dashboard-pill">
                        <i class="bi bi-patch-check"></i>
                        {{ $profileCompletionLabel ?? 'Getting Started' }} ({{ $profileCompletionPercent ?? 0 }}%)
                    </span>
                    <div class="progress w-100" role="progressbar" aria-label="Profile completion" aria-valuenow="{{ $profileCompletionPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: {{ $profileCompletionPercent ?? 0 }}%;"></div>
                    </div>
                    <div class="quick-actions-grid">
                        <a href="{{ route('jobseeker.profile') }}" class="quick-action-btn"><i class="bi bi-person"></i>Update Profile</a>
                        <a href="{{ route('jobseeker.resume-builder') }}" class="quick-action-btn"><i class="bi bi-file-earmark-text"></i>Resume Builder</a>
                        <a href="{{ route('jobseeker.applications') }}" class="quick-action-btn"><i class="bi bi-send"></i>My Applications</a>
                    </div>
                </div>
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
                    <div class="dashboard-stat-trend">+{{ $kpiTrends['jobsThisWeek'] ?? 0 }} this week</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-apps"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="{{ $applicationStatusCounts['total'] ?? 0 }}">{{ $applicationStatusCounts['total'] ?? 0 }}</div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                    <div class="dashboard-stat-trend">+{{ $kpiTrends['applicationsThisWeek'] ?? 0 }} in 7 days</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-saved"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="{{ $recentlyViewedCount ?? 0 }}">{{ $recentlyViewedCount ?? 0 }}</div>
                    <div class="dashboard-stat-label">Recently Viewed</div>
                    <div class="dashboard-stat-trend">{{ $kpiTrends['interviewsThisWeek'] ?? 0 }} interview updates</div>
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
                    <a href="{{ route('jobseeker.dashboard', ['notifications' => 'read']) }}" class="btn btn-sm btn-outline-secondary mark-read-btn">Mark all as read</a>
                @endif
            </div>
        </div>

        @if (($dashboardNotifications ?? collect())->isNotEmpty())
            @php
                $todayNotifications = collect($dashboardNotifications)->filter(fn($notification) => \Illuminate\Support\Carbon::parse($notification['created_at'])->isToday())->values();
                $earlierNotifications = collect($dashboardNotifications)->filter(fn($notification) => !\Illuminate\Support\Carbon::parse($notification['created_at'])->isToday())->values();
            @endphp

            <div class="notifications-list">
                @if ($todayNotifications->isNotEmpty())
                    <div class="notification-group-title">Today</div>
                    @foreach ($todayNotifications as $notification)
                        <a href="{{ $notification['url'] }}" class="notification-item">
                            <div class="notification-icon"><i class="bi {{ $notification['icon'] }}"></i></div>
                            <div>
                                <div class="notification-title">
                                    {{ $notification['title'] }}
                                    <span class="notification-priority prio-{{ $notification['priority'] ?? 'low' }}">{{ $notification['priority'] ?? 'low' }}</span>
                                </div>
                                <div class="notification-message">{{ $notification['message'] }}</div>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if ($earlierNotifications->isNotEmpty())
                    <div class="notification-group-title">Earlier</div>
                    @foreach ($earlierNotifications as $notification)
                        <a href="{{ $notification['url'] }}" class="notification-item">
                            <div class="notification-icon"><i class="bi {{ $notification['icon'] }}"></i></div>
                            <div>
                                <div class="notification-title">
                                    {{ $notification['title'] }}
                                    <span class="notification-priority prio-{{ $notification['priority'] ?? 'low' }}">{{ $notification['priority'] ?? 'low' }}</span>
                                </div>
                                <div class="notification-message">{{ $notification['message'] }}</div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        @else
            <div class="dashboard-empty-state">
                <div>
                    <div class="empty-icon"><i class="bi bi-bell"></i></div>
                    <div class="fw-semibold text-secondary">All caught up.</div>
                    <div class="small">No new notifications right now.</div>
                        <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-sm btn-outline-primary mt-2 empty-action-btn">Browse New Jobs</a>
                </div>
            </div>
        @endif
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 190px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Application Status</h3>
            <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm btn-outline-primary dashboard-section-action">View All</a>
        </div>

        <div class="status-legend" aria-label="Application status legend">
            <span class="status-legend-item status-legend-pending"><span class="dot" aria-hidden="true"></span><i class="bi bi-hourglass-split"></i>Pending</span>
            <span class="status-legend-item status-legend-interview"><span class="dot" aria-hidden="true"></span><i class="bi bi-mic"></i>Interview</span>
            <span class="status-legend-item status-legend-hired"><span class="dot" aria-hidden="true"></span><i class="bi bi-person-check"></i>Hired</span>
            <span class="status-legend-item status-legend-recommended"><span class="dot" aria-hidden="true"></span><i class="bi bi-stars"></i>Recommended</span>
        </div>

        @php
            $pipelineTotal = max(1,
                (int) ($applicationStatusCounts['pending'] ?? 0)
                + (int) ($applicationStatusCounts['interview'] ?? 0)
                + (int) ($applicationStatusCounts['hired'] ?? 0)
                + (int) ($applicationStatusCounts['recommended'] ?? 0)
            );

            $pendingWidth = (($applicationStatusCounts['pending'] ?? 0) / $pipelineTotal) * 100;
            $interviewWidth = (($applicationStatusCounts['interview'] ?? 0) / $pipelineTotal) * 100;
            $hiredWidth = (($applicationStatusCounts['hired'] ?? 0) / $pipelineTotal) * 100;
            $recommendedWidth = (($applicationStatusCounts['recommended'] ?? 0) / $pipelineTotal) * 100;
        @endphp

        <div class="status-progress" aria-label="Application status distribution">
            <div class="status-segment pending" style="width: {{ $pendingWidth }}%"></div>
            <div class="status-segment interview" style="width: {{ $interviewWidth }}%"></div>
            <div class="status-segment hired" style="width: {{ $hiredWidth }}%"></div>
            <div class="status-segment recommended" style="width: {{ $recommendedWidth }}%"></div>
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

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 120px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-diagram-3 me-2"></i>Skill Gap Analysis</h3>
            <a href="{{ route('jobseeker.skill-gap') }}" class="btn btn-sm btn-outline-primary dashboard-section-action">View Full Analysis</a>
        </div>

        @if (($skillGapAnalysis['hasData'] ?? false) && ($skillGapAnalysis['totalMarketSkills'] ?? 0) > 0)
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="min-width: 80px;">
                        <div class="skill-gap-score">{{ $skillGapAnalysis['coveragePercent'] }}%</div>
                        <div class="skill-gap-score-label">Coverage</div>
                    </div>
                    <div class="skill-gap-progress flex-grow-1" style="min-width: 200px; margin-bottom: 0;">
                        @php
                            $progressClass = ($skillGapAnalysis['coveragePercent'] ?? 0) >= 70 ? '' : (($skillGapAnalysis['coveragePercent'] ?? 0) >= 40 ? 'medium' : 'low');
                        @endphp
                        <div class="skill-gap-progress-fill {{ $progressClass }}" style="width: {{ $skillGapAnalysis['coveragePercent'] }}%;"></div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <div class="fw-bold" style="color: #277b49; font-size: 1.1rem;">{{ count($skillGapAnalysis['matchedSkills'] ?? []) }}</div>
                        <div class="small text-muted">Matched</div>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold" style="color: #b54708; font-size: 1.1rem;">{{ count($skillGapAnalysis['missingSkills'] ?? []) }}</div>
                        <div class="small text-muted">Missing</div>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold" style="font-size: 1.1rem;">{{ $skillGapAnalysis['totalMarketSkills'] }}</div>
                        <div class="small text-muted">Market Skills</div>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="text-muted small">Complete your profile to see how your skills compare with market demand.</div>
                <a href="{{ route('jobseeker.profile') }}" class="btn btn-sm btn-outline-secondary">Go to Profile</a>
            </div>
        @endif
    </div>

</section>
@endsection
