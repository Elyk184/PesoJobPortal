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
                    <div class="dashboard-stat-number">{{ $availableJobsCount ?? 0 }}</div>
                    <div class="dashboard-stat-label">Available Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-apps"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number">4</div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon stat-saved"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="dashboard-stat-number">3</div>
                    <div class="dashboard-stat-label">Saved Jobs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Application Status</h3>
            <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="status-grid">
            <div class="status-item status-pending">
                <div class="status-item-label">Pending Review</div>
                <div class="status-item-value">0</div>
            </div>
            <div class="status-item status-interview">
                <div class="status-item-label">Interview</div>
                <div class="status-item-value">1</div>
            </div>
            <div class="status-item status-hired">
                <div class="status-item-label">Hired</div>
                <div class="status-item-value">2</div>
            </div>
            <div class="status-item status-recommended">
                <div class="status-item-label">Recommended</div>
                <div class="status-item-value">0</div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between gap-3 section-head">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-stars me-2"></i>Recommended Jobs</h3>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="dashboard-empty-state">
            <div>
                <div class="empty-icon"><i class="bi bi-briefcase"></i></div>
                <div class="fw-semibold text-secondary">No job recommendations yet.</div>
                <div class="small">Complete your profile to get personalized job suggestions.</div>
            </div>
        </div>
    </div>
</section>
@endsection
