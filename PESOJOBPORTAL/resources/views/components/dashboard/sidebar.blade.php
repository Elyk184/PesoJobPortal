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
                <div class="dashboard-brand-kicker">Link Job Resource Portal</div>
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
            <div class="dashboard-brand-kicker">Link Job Resource Portal</div>
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
        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Overview</div>
            <a href="{{ route('jobseeker.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.dashboard') ? 'is-active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Job Search</div>
            <a href="{{ route('jobseeker.browse-jobs') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.browse-jobs') || request()->routeIs('jobseeker.vacancies') ? 'is-active' : '' }}">
                <i class="bi bi-briefcase"></i>
                <span>Browse Jobs</span>
            </a>
            <a href="{{ route('jobseeker.saved-jobs') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.saved-jobs') ? 'is-active' : '' }}">
                <i class="bi bi-bookmark"></i>
                <span>Saved Jobs</span>
            </a>
            <a href="{{ route('jobseeker.recommendations') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.recommendations') ? 'is-active' : '' }}">
                <i class="bi bi-stars"></i>
                <span>Recommendations</span>
            </a>
        </div>

        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">My Applications</div>
            <a href="{{ route('jobseeker.applications') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.applications') ? 'is-active' : '' }}">
                <i class="bi bi-send"></i>
                <span>Applied Jobs</span>
            </a>
            <a href="{{ route('jobseeker.notifications') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.notifications') ? 'is-active' : '' }}">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </div>

        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Account</div>
            <a href="{{ route('jobseeker.profile') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.profile') ? 'is-active' : '' }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
            </a>
            <a href="{{ route('jobseeker.resume-builder') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.resume-builder') ? 'is-active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Resume Builder</span>
            </a>
            <a href="{{ route('jobseeker.skill-gap') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.skill-gap') ? 'is-active' : '' }}">
                <i class="bi bi-graph-up"></i>
                <span>Skill Gap</span>
            </a>
            <a href="{{ route('jobseeker.peso-clearance') }}" class="dashboard-nav-link {{ request()->routeIs('jobseeker.peso-clearance') ? 'is-active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>PESO Clearance</span>
            </a>
        </div>
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
