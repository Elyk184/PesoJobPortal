@extends('layouts.dashboard')

@section('title', 'Jobseeker Dashboard | PESO Job Portal')

@section('content')
<section aria-label="Jobseeker dashboard">
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

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Welcome back, {{ auth()->user()->name ?? 'Jobseeker' }}!</h2>
                <p class="mb-0 text-muted">Your profile is complete. Keep it updated to receive relevant job recommendations.</p>
            </div>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-primary px-3 shadow-sm">
                <i class="bi bi-search me-2"></i>Browse Jobs
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="dashboard-stat-number">4</div>
                    <div class="dashboard-stat-label">Available Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number">4</div>
                    <div class="dashboard-stat-label">Applications Sent</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(220, 164, 42, 0.12); color: var(--dash-warning);"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="dashboard-stat-number">3</div>
                    <div class="dashboard-stat-label">Saved Jobs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Application Status</h3>
            <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="dashboard-status-card p-3" style="background: rgba(255, 244, 206, 0.75); border-color: rgba(220, 164, 42, 0.2);">
                    <div class="dashboard-status-number" style="color: var(--dash-warning);">0</div>
                    <div class="dashboard-status-label" style="color: var(--dash-warning);">Pending Review</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="dashboard-status-card p-3" style="background: rgba(225, 243, 236, 0.9); border-color: rgba(47, 157, 98, 0.18);">
                    <div class="dashboard-status-number" style="color: var(--dash-success);">1</div>
                    <div class="dashboard-status-label" style="color: var(--dash-success);">Interview</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="dashboard-status-card p-3" style="background: rgba(223, 235, 255, 0.9); border-color: rgba(45, 107, 224, 0.18);">
                    <div class="dashboard-status-number" style="color: #2d6be0;">2</div>
                    <div class="dashboard-status-label" style="color: #2d6be0;">Hired</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="dashboard-status-card p-3" style="background: rgba(237, 230, 251, 0.9); border-color: rgba(142, 118, 217, 0.18);">
                    <div class="dashboard-status-number" style="color: var(--dash-purple);">0</div>
                    <div class="dashboard-status-label" style="color: var(--dash-purple);">Recommended</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-stars me-2"></i>Recommended Jobs</h3>
            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>

        <div class="dashboard-empty-state">
            <div>
                <div class="fs-1 mb-2">✦</div>
                <div class="fw-semibold text-secondary">No job recommendations yet.</div>
                <div class="small">Complete your profile to get personalized job suggestions.</div>
            </div>
        </div>
    </div>
</section>
@endsection
