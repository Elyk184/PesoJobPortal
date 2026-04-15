@php
    $user = auth()->user();
@endphp

<aside class="dashboard-sidebar">
    <div class="d-flex align-items-center justify-content-between d-lg-none">
        <div class="dashboard-brand">
            <div class="dashboard-brand-mark">
                <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
            </div>
            <div>
                <div class="dashboard-brand-kicker">PESO Job Portal</div>
                <div class="dashboard-brand-title">Jobseeker Portal</div>
            </div>
        </div>

        <button type="button" class="dashboard-sidebar-close" data-dashboard-close aria-label="Close dashboard menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="dashboard-brand d-none d-lg-flex">
        <div class="dashboard-brand-mark">
            <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        </div>
        <div>
            <div class="dashboard-brand-kicker">PESO Job Portal</div>
            <div class="dashboard-brand-title">Jobseeker Portal</div>
        </div>
    </div>

    <div class="dashboard-user-card">
        <div class="dashboard-user-avatar">
            {{ strtoupper(substr($user->name ?? 'J', 0, 1)) }}
        </div>
        <div>
            <div class="dashboard-user-name">{{ $user->name ?? 'Jobseeker' }}</div>
            <div class="dashboard-user-role">{{ ucfirst($user->role ?? 'jobseeker') }}</div>
        </div>
    </div>

    <nav class="dashboard-nav" aria-label="Dashboard navigation">
        <a href="{{ route('jobseeker.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.dashboard') ? 'is-active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('jobseeker.vacancies') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.vacancies') ? 'is-active' : '' }}">
            <i class="bi bi-briefcase"></i>
            <span>Vacancies</span>
        </a>
        <a href="{{ route('jobseeker.applications') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.applications') ? 'is-active' : '' }}">
            <i class="bi bi-clipboard-check"></i>
            <span>Applications</span>
        </a>
        <a href="{{ route('jobseeker.profile') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.profile') ? 'is-active' : '' }}">
            <i class="bi bi-person-lines-fill"></i>
            <span>Profile</span>
        </a>
    </nav>

    <div class="dashboard-highlight">
        <div class="dashboard-highlight-label">PESO Clearance</div>
        <div class="dashboard-highlight-value">Not yet verified</div>
        <div class="dashboard-highlight-note">View-only status for portal use.</div>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="dashboard-logout">
        @csrf
        <button type="submit" class="btn btn-light w-100 fw-semibold">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </button>
    </form>
</aside>
