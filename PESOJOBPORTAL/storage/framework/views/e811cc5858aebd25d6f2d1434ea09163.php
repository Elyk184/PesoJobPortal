<?php $__env->startSection('title', 'Jobseeker Dashboard | PESO Job Portal'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

    .jobseeker-dashboard {
        --land-blue-900: #1e3a8a;
        --land-blue-800: #1e40af;
        --land-blue-500: #3b82f6;
        --land-blue-300: #93c5fd;
        --land-blue-200: #bfdbfe;
        --land-white: #ffffff;
        --dash-bg: #f4f7fb;
        --dash-card: #ffffff;
        --dash-border: #dbe5f1;
        --dash-text: #1e2b3a;
        --dash-muted: #60758e;
        --dash-accent: var(--land-blue-900);
        --dash-success: var(--land-blue-800);
        --dash-warning: var(--land-blue-300);
        --dash-violet: var(--land-blue-500);
        color: var(--dash-text);
        font-family: "Poppins", "Segoe UI", sans-serif;
        background:
            radial-gradient(90rem 50rem at 92% -10%, rgba(30, 64, 175, 0.12) 0%, rgba(30, 64, 175, 0) 62%),
            radial-gradient(85rem 45rem at -12% 0%, rgba(191, 219, 254, 0.38) 0%, rgba(191, 219, 254, 0) 57%),
            var(--dash-bg);
        border-radius: 18px;
        padding: 18px;
    }

    .jobseeker-dashboard .dashboard-hero {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid #d8e4f5;
        background: linear-gradient(135deg, #ffffff 0%, #f7faff 45%, #eef4ff 100%);
        box-shadow: 0 14px 34px rgba(17, 30, 52, 0.08);
    }

    .jobseeker-dashboard .dashboard-hero::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--land-blue-900) 0%, var(--land-blue-800) 58%, var(--land-blue-300) 100%);
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
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .jobseeker-dashboard .dashboard-hero .h4 {
        color: #0a3764;
    }

    .jobseeker-dashboard .dashboard-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #c7d8f5;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.76rem;
        color: var(--land-blue-900);
        background: #ffffff;
        font-weight: 700;
        box-shadow: 0 6px 16px rgba(30, 58, 138, 0.08);
    }

    .jobseeker-dashboard .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .jobseeker-dashboard .quick-actions-grid .quick-action-btn:last-child {
        grid-column: span 2;
    }

    .jobseeker-dashboard .quick-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid #c7d8f5;
        border-radius: 12px;
        background: #fff;
        color: #0a3764;
        text-decoration: none;
        padding: 10px 12px;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .jobseeker-dashboard .quick-action-btn:hover {
        border-color: var(--land-blue-900);
        background: rgba(191, 219, 254, 0.28);
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
        background: linear-gradient(90deg, var(--land-blue-900) 0%, var(--land-blue-800) 55%, var(--land-blue-300) 100%);
    }

    .jobseeker-dashboard .dashboard-stat-card {
        background: var(--dash-card);
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .jobseeker-dashboard .dashboard-stat-card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--land-blue-900), var(--land-blue-800) 58%, var(--land-blue-300));
        opacity: 0.9;
    }

    .jobseeker-dashboard .dashboard-stat-card:hover {
        border-color: #b6c9e3;
        box-shadow: 0 12px 28px rgba(24, 43, 66, 0.09);
        transform: translateY(-1px);
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
        background: rgba(191, 219, 254, 0.42);
        color: #1e40af;
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
        border-bottom: 1px solid #d8e4f5;
        padding-bottom: 12px;
        margin-bottom: 16px;
        min-height: 46px;
    }

    .jobseeker-dashboard .section-head .h5 {
        color: #1f3555;
    }

    .jobseeker-dashboard .dashboard-section-card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
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

    .jobseeker-dashboard .status-segment.pending { background: #dbeafe; }
    .jobseeker-dashboard .status-segment.interview { background: #93c5fd; }
    .jobseeker-dashboard .status-segment.hired { background: #3b82f6; }
    .jobseeker-dashboard .status-segment.recommended { background: #1e40af; }

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
        margin-bottom: 14px;
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

    .jobseeker-dashboard .status-legend-pending .dot { background: #dbeafe; }
    .jobseeker-dashboard .status-legend-interview .dot { background: #93c5fd; }
    .jobseeker-dashboard .status-legend-hired .dot { background: #3b82f6; }
    .jobseeker-dashboard .status-legend-recommended .dot { background: #1e40af; }

    .jobseeker-dashboard .status-pending {
        border-left: 4px solid #bfdbfe;
    }

    .jobseeker-dashboard .status-interview {
        border-left: 4px solid #93c5fd;
    }

    .jobseeker-dashboard .status-hired {
        border-left: 4px solid #3b82f6;
    }

    .jobseeker-dashboard .status-recommended {
        border-left: 4px solid #1e40af;
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
        background: #eff6ff;
        color: #2563eb;
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

    .jobseeker-dashboard .prio-high { color: #1e3a8a; }
    .jobseeker-dashboard .prio-medium { color: #1e40af; }
    .jobseeker-dashboard .prio-low { color: #3b82f6; }

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

    .jobseeker-dashboard .skill-gap-summary {
        border: 1px solid #d8e4f5;
        border-radius: 16px;
        background: linear-gradient(135deg, #f8fbff 0%, #eef4ff 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
    }

    .jobseeker-dashboard .skill-gap-summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: rgba(30, 64, 175, 0.12);
        color: #1e40af;
        flex: 0 0 auto;
        font-size: 1.15rem;
    }

    .jobseeker-dashboard .skill-gap-summary-score {
        font-size: clamp(2rem, 4vw, 2.7rem);
        line-height: 1;
        font-weight: 900;
        letter-spacing: -0.04em;
        color: #1e3a8a;
    }

    .jobseeker-dashboard .skill-gap-summary-label {
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #5f7591;
        margin-top: 4px;
    }

    .jobseeker-dashboard .skill-gap-mini-stat {
        border: 1px solid #d8e4f5;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.82);
        padding: 12px 14px;
        min-height: 92px;
        box-shadow: 0 8px 18px rgba(18, 36, 58, 0.05);
    }

    .jobseeker-dashboard .skill-gap-mini-stat .dashboard-stat-number {
        margin-top: 4px;
    }

    .jobseeker-dashboard .skill-gap-chip-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .jobseeker-dashboard .skill-gap-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 0.78rem;
        font-weight: 700;
        border: 1px solid #cfe0f7;
        background: #f7fbff;
        color: #2d65b1;
    }

    .jobseeker-dashboard .skill-gap-chip.matched {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1e40af;
    }

    .jobseeker-dashboard .skill-gap-chip.missing {
        border-color: #dbeafe;
        background: #f8fbff;
        color: #2563eb;
    }

    .jobseeker-dashboard .skill-gap-chip.market {
        border-color: #c7d8f5;
        background: #ffffff;
        color: #0a3764;
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
        background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 55%, #bfdbfe 100%);
        transition: width 0.6s ease;
    }

    .jobseeker-dashboard .skill-gap-progress-fill.low {
        background: linear-gradient(90deg, #bfdbfe 0%, #93c5fd 100%);
    }

    .jobseeker-dashboard .skill-gap-progress-fill.medium {
        background: linear-gradient(90deg, #bfdbfe 0%, #3b82f6 100%);
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
        background: #eff6ff;
        color: #1e40af;
        border-color: #bfdbfe;
    }

    .jobseeker-dashboard .skill-tag.missing {
        background: #f8fbff;
        color: #2563eb;
        border-color: #dbeafe;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="jobseeker-dashboard" aria-label="Jobseeker dashboard">
    <div class="dashboard-section-card dashboard-hero p-3 p-lg-4 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-8">
                <div class="dashboard-hero-meta">Overview</div>
                <h2 class="h4 mb-1 fw-bold">Welcome back, <?php echo e(auth()->user()->name ?? 'Jobseeker'); ?>!</h2>
                <p class="mb-0 text-muted">
                    Your profile is <?php echo e($profileCompletionPercent ?? 0); ?>% complete.
                    Keep it updated to receive relevant job recommendations.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="<?php echo e($availableJobsCount ?? 0); ?>"><?php echo e($availableJobsCount ?? 0); ?></div>
                    <div class="dashboard-stat-label">Available Jobs</div>
                    <div class="dashboard-stat-trend">+<?php echo e($kpiTrends['jobsThisWeek'] ?? 0); ?> this week</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-apps"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="<?php echo e($applicationStatusCounts['total'] ?? 0); ?>"><?php echo e($applicationStatusCounts['total'] ?? 0); ?></div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                    <div class="dashboard-stat-trend">+<?php echo e($kpiTrends['applicationsThisWeek'] ?? 0); ?> in 7 days</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-saved"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="dashboard-stat-number" data-counter-target="<?php echo e($recentlyViewedCount ?? 0); ?>"><?php echo e($recentlyViewedCount ?? 0); ?></div>
                    <div class="dashboard-stat-label">Recently Viewed</div>
                    <div class="dashboard-stat-trend"><?php echo e($kpiTrends['interviewsThisWeek'] ?? 0); ?> interview updates</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 140px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head mb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-clipboard-data me-2"></i>Application Status</h3>
            <a href="<?php echo e(route('jobseeker.applications')); ?>" class="btn btn-sm btn-outline-primary dashboard-section-action">View Applications</a>
        </div>

        <div class="status-legend mb-3" aria-label="Application status legend">
            <span class="status-legend-item status-legend-pending"><span class="dot" aria-hidden="true"></span><i class="bi bi-hourglass-split"></i>Pending</span>
            <span class="status-legend-item status-legend-interview"><span class="dot" aria-hidden="true"></span><i class="bi bi-mic"></i>Interview</span>
            <span class="status-legend-item status-legend-hired"><span class="dot" aria-hidden="true"></span><i class="bi bi-person-check"></i>Hired</span>
            <span class="status-legend-item status-legend-recommended"><span class="dot" aria-hidden="true"></span><i class="bi bi-stars"></i>Reviewed</span>
        </div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dashboard-stat-card p-3 h-100">
                    <div class="dashboard-stat-icon stat-saved mb-3"><i class="bi bi-hourglass-split"></i></div>
                    <div class="dashboard-stat-label">Pending Review</div>
                    <div class="dashboard-stat-number"><?php echo e($applicationStatusCounts['pending'] ?? 0); ?></div>
                    <div class="small text-muted">Waiting for screening</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dashboard-stat-card p-3 h-100">
                    <div class="dashboard-stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;"><i class="bi bi-mic"></i></div>
                    <div class="dashboard-stat-label mt-3">Interview</div>
                    <div class="dashboard-stat-number"><?php echo e($applicationStatusCounts['interview'] ?? 0); ?></div>
                    <div class="small text-muted">Interview stage applications</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dashboard-stat-card p-3 h-100">
                    <div class="dashboard-stat-icon" style="background: rgba(34, 197, 94, 0.12); color: #15803d;"><i class="bi bi-person-check"></i></div>
                    <div class="dashboard-stat-label mt-3">Hired</div>
                    <div class="dashboard-stat-number"><?php echo e($applicationStatusCounts['hired'] ?? 0); ?></div>
                    <div class="small text-muted">Successfully placed</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dashboard-stat-card p-3 h-100">
                    <div class="dashboard-stat-icon" style="background: rgba(168, 85, 247, 0.12); color: #7c3aed;"><i class="bi bi-stars"></i></div>
                    <div class="dashboard-stat-label mt-3">Reviewed</div>
                    <div class="dashboard-stat-number"><?php echo e($applicationStatusCounts['recommended'] ?? 0); ?></div>
                    <div class="small text-muted">Checked by recruiters</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 160px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head mb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-activity me-2"></i>Activity &amp; Insights</h3>
            <a href="<?php echo e(route('jobseeker.applications')); ?>" class="btn btn-sm btn-outline-primary dashboard-section-action">View Applications</a>
        </div>

        <div class="row g-3 align-items-stretch">
            <div class="col-12 col-lg-5">
                <div class="dashboard-stat-card h-100 p-3">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                        <div>
                            <div class="dashboard-stat-label mb-1">Profile progress</div>
                            <div class="h4 mb-1 fw-bold"><?php echo e($profileCompletionPercent ?? 0); ?>%</div>
                            <div class="small text-muted"><?php echo e($profileCompletionLabel ?? 'Getting Started'); ?></div>
                        </div>
                        <div class="dashboard-stat-icon" style="background: rgba(30, 64, 175, 0.12); color: #1e40af;"><i class="bi bi-person-check"></i></div>
                    </div>

                    <div class="progress mb-3" style="height: 8px; border-radius: 999px; background: #e8eef6;">
                        <div class="progress-bar" style="width: <?php echo e($profileCompletionPercent ?? 0); ?>%; background: linear-gradient(90deg, var(--land-blue-900) 0%, var(--land-blue-800) 60%, var(--land-blue-300) 100%);"></div>
                    </div>

                    <div class="small text-muted">
                        Complete missing profile details to improve matching, visibility, and response rates.
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="row g-3 h-100">
                    <div class="col-12 col-md-4">
                        <div class="dashboard-stat-card p-3 h-100">
                            <div class="dashboard-stat-icon stat-apps mb-3"><i class="bi bi-send"></i></div>
                            <div class="dashboard-stat-label">Applications this week</div>
                            <div class="dashboard-stat-number"><?php echo e($kpiTrends['applicationsThisWeek'] ?? 0); ?></div>
                            <div class="small text-muted">Recent submissions and follow-ups</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="dashboard-stat-card p-3 h-100">
                            <div class="dashboard-stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;"><i class="bi bi-mic"></i></div>
                            <div class="dashboard-stat-label mt-3">Interview activity</div>
                            <div class="dashboard-stat-number"><?php echo e($kpiTrends['interviewsThisWeek'] ?? 0); ?></div>
                            <div class="small text-muted">Updates in the last 7 days</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="dashboard-stat-card p-3 h-100">
                            <div class="dashboard-stat-icon stat-saved mb-3"><i class="bi bi-stars"></i></div>
                            <div class="dashboard-stat-label">Pending review</div>
                            <div class="dashboard-stat-number"><?php echo e($applicationStatusCounts['pending'] ?? 0); ?></div>
                            <div class="small text-muted">Applications waiting for action</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4 dashboard-skeleton" style="--skeleton-height: 120px;">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-diagram-3 me-2"></i>Skill Gap Analysis</h3>
            <a href="<?php echo e(route('jobseeker.skill-gap')); ?>" class="btn btn-sm btn-outline-primary dashboard-section-action">View Full Analysis</a>
        </div>

        <?php if(($skillGapAnalysis['hasData'] ?? false) && ($skillGapAnalysis['totalMarketSkills'] ?? 0) > 0): ?>
            <div class="skill-gap-summary p-3 p-lg-4 mb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="skill-gap-summary-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div>
                                <div class="skill-gap-summary-label mb-1">Market coverage</div>
                                <div class="skill-gap-summary-score"><?php echo e($skillGapAnalysis['coveragePercent']); ?>%</div>
                                <div class="small text-muted mt-1">How closely your profile matches in-demand skills.</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <?php
                            $progressClass = ($skillGapAnalysis['coveragePercent'] ?? 0) >= 70 ? '' : (($skillGapAnalysis['coveragePercent'] ?? 0) >= 40 ? 'medium' : 'low');
                        ?>
                        <div class="skill-gap-progress mb-2" style="margin-bottom: 10px;">
                            <div class="skill-gap-progress-fill <?php echo e($progressClass); ?>" style="width: <?php echo e($skillGapAnalysis['coveragePercent']); ?>%;"></div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                            <span class="skill-gap-chip matched"><i class="bi bi-check2-circle"></i><?php echo e(count($skillGapAnalysis['matchedSkills'] ?? [])); ?> matched</span>
                            <span class="skill-gap-chip missing"><i class="bi bi-exclamation-circle"></i><?php echo e(count($skillGapAnalysis['missingSkills'] ?? [])); ?> missing</span>
                            <span class="skill-gap-chip market"><i class="bi bi-briefcase"></i><?php echo e($skillGapAnalysis['totalMarketSkills']); ?> market skills</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <div class="skill-gap-mini-stat d-flex align-items-center gap-3 h-100">
                        <div class="dashboard-stat-icon" style="background: rgba(30, 64, 175, 0.12); color: #1e40af;"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <div class="dashboard-stat-label">Matched Skills</div>
                            <div class="dashboard-stat-number"><?php echo e(count($skillGapAnalysis['matchedSkills'] ?? [])); ?></div>
                            <div class="small text-muted">Skills already in demand</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="skill-gap-mini-stat d-flex align-items-center gap-3 h-100">
                        <div class="dashboard-stat-icon" style="background: rgba(191, 219, 254, 0.55); color: #2563eb;"><i class="bi bi-exclamation-triangle"></i></div>
                        <div>
                            <div class="dashboard-stat-label">Skills to Consider</div>
                            <div class="dashboard-stat-number"><?php echo e(count($skillGapAnalysis['missingSkills'] ?? [])); ?></div>
                            <div class="small text-muted">Gaps to close next</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="skill-gap-mini-stat d-flex align-items-center gap-3 h-100">
                        <div class="dashboard-stat-icon" style="background: rgba(147, 197, 253, 0.28); color: #1e3a8a;"><i class="bi bi-stars"></i></div>
                        <div>
                            <div class="dashboard-stat-label">Total Market Skills</div>
                            <div class="dashboard-stat-number"><?php echo e($skillGapAnalysis['totalMarketSkills']); ?></div>
                            <div class="small text-muted">Current job demand snapshot</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-lg-5">
                    <div class="dashboard-section-card p-3 h-100" style="border-radius: 16px;">
                        <h4 class="h6 fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Your Current Skills</h4>
                        <?php if(! empty($skillGapAnalysis['userSkills'])): ?>
                            <div class="skill-gap-chip-row">
                                <?php $__currentLoopData = $skillGapAnalysis['userSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill-gap-chip matched"><i class="bi bi-check2"></i><?php echo e(ucwords($skill)); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-muted small">No skills found in your profile. Add skills to see the comparison.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="dashboard-section-card p-3 h-100" style="border-radius: 16px;">
                        <?php if(! empty($skillGapAnalysis['missingSkills'])): ?>
                            <h4 class="h6 fw-bold mb-3"><i class="bi bi-lightning-charge me-2" style="color: #1e40af;"></i>Skills in Demand You May Be Missing</h4>
                            <div class="skill-gap-chip-row">
                                <?php $__currentLoopData = $skillGapAnalysis['missingSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill-gap-chip missing">
                                        <i class="bi bi-plus-circle"></i><?php echo e(ucwords($skill)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="alert alert-info mt-3 mb-0 small">
                                <i class="bi bi-lightbulb me-1"></i> Consider upskilling in these areas to improve your job match rate.
                            </div>
                        <?php else: ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-check-circle-fill" style="color: #1e40af; font-size: 1.3rem;"></i>
                                <span class="fw-bold h5 mb-0" style="color: #1e3a8a;">Excellent Coverage!</span>
                            </div>
                            <p class="text-muted mb-0">Your skillset covers all top market demands. Keep your profile updated as new roles are posted.</p>
                        <?php endif; ?>

                        <?php if(! empty($skillGapAnalysis['matchedSkills'])): ?>
                            <h4 class="h6 fw-bold mb-3 mt-4"><i class="bi bi-check2-circle me-2" style="color: #1e40af;"></i>Skills You Have That Are In Demand</h4>
                            <div class="skill-gap-chip-row">
                                <?php $__currentLoopData = $skillGapAnalysis['matchedSkills']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill-gap-chip matched">
                                        <i class="bi bi-check2"></i><?php echo e(ucwords($skill)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="text-muted small">Complete your profile to see how your skills compare with market demand.</div>
                <a href="<?php echo e(route('jobseeker.profile')); ?>" class="btn btn-sm btn-outline-secondary">Go to Profile</a>
            </div>
        <?php endif; ?>
    </div>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\63965\PesoJobPortal\PESOJOBPORTAL\resources\views/jobseeker/dashboard.blade.php ENDPATH**/ ?>