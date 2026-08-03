@php
    $user = auth()->user();
    $role = $user?->role ?? 'jobseeker';
    $brandTitle = match ($role) {
        'ofw' => 'OFW Portal',
        'employer' => 'Employer Portal',
        'admin' => 'Admin Portal',
        default => 'Jobseeker Portal',
    };
@endphp

<style>
    .dashboard-sidebar .sidebar-badge {
        margin-left: auto;
        min-width: 22px;
        height: 22px;
        padding: 0 7px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ef4444;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        line-height: 1;
        flex-shrink: 0;
    }
    .dashboard-sidebar .sidebar-badge.visually-hidden {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0,0,0,0) !important;
        white-space: nowrap !important;
        border: 0 !important;
    }
</style>

<aside class="dashboard-sidebar">
    <div class="d-flex align-items-center justify-content-between d-lg-none">
        <div class="dashboard-brand">
            <div class="dashboard-brand-mark">
                <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
            </div>
            <div>
                <div class="dashboard-brand-kicker">Link Job Resource Portal</div>
                <div class="dashboard-brand-title">{{ $brandTitle }}</div>
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
            <div class="dashboard-brand-title">{{ $brandTitle }}</div>
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
        @if ($role === 'ofw')
            <div class="dashboard-nav-section">
                <div class="dashboard-nav-label">Overview</div>
                <a href="{{ route('ofw.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('ofw.dashboard') ? 'is-active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="dashboard-nav-section">
                <div class="dashboard-nav-label">Assistance</div>
                <a href="{{ route('ofw.owwa-request') }}" class="dashboard-nav-link {{ request()->routeIs('ofw.owwa-request') || request()->routeIs('ofw.rfa.form') ? 'is-active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>OWWA RFA</span>
                </a>
                <a href="{{ route('ofw.dmw-builder') }}" class="dashboard-nav-link {{ request()->routeIs('ofw.dmw-builder') ? 'is-active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>DMW Form</span>
                </a>
                <a href="{{ route('ofw.accepted-requests') }}" class="dashboard-nav-link {{ request()->routeIs('ofw.accepted-requests') ? 'is-active' : '' }}">
                    <i class="bi bi-info-circle"></i>
                    <span>Accepted Requests</span>
                </a>
                <a href="{{ route('ofw.submitted-requests') }}" class="dashboard-nav-link {{ request()->routeIs('ofw.submitted-requests') ? 'is-active' : '' }}">
                    <i class="bi bi-list-check"></i>
                    <span>Submitted Requests</span>
                </a>
            </div>
        @elseif ($role === 'employer')
            <div class="dashboard-nav-section">
                <div class="dashboard-nav-label">Overview</div>
                <a href="{{ route('employer.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('employer.dashboard') ? 'is-active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="dashboard-nav-section">
                <div class="dashboard-nav-label">Employer Tools</div>
                <a href="{{ route('employer.jobs.post') }}" class="dashboard-nav-link {{ request()->routeIs('employer.jobs.post') ? 'is-active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Post Job</span>
                </a>
                <a href="{{ route('employer.jobs.manage') }}" class="dashboard-nav-link {{ request()->routeIs('employer.jobs.manage') ? 'is-active' : '' }}">
                    <i class="bi bi-briefcase"></i>
                    <span>Manage Jobs</span>
                </a>
            </div>
        @elseif ($role === 'admin')
            <div class="dashboard-nav-section">
                <div class="dashboard-nav-label">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        @else
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
                    <span>Best Fit</span>
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
                    @php
                        $userUnread = 0;
                        $userRecommendationUnread = 0;
                        if ($user) {
                            $userUnread = \App\Models\UserNotification::query()
                                ->where('user_id', $user->id)
                                ->whereNull('read_at')
                                ->count();

                            $userRecommendationUnread = \App\Models\UserNotification::query()
                                ->where('user_id', $user->id)
                                ->whereNull('read_at')
                                ->whereHas('portalNotification', function ($q) {
                                    $q->where('title', 'like', 'Job Recommendation:%');
                                })
                                ->count();
                        }
                    @endphp
                    @if($userUnread > 0)
                        <span id="notificationUnreadBadge" class="sidebar-badge {{ $userRecommendationUnread > 0 ? 'recommend' : '' }}">{{ $userUnread }}</span>
                    @else
                        <span id="notificationUnreadBadge" class="sidebar-badge visually-hidden" aria-hidden="true"></span>
                    @endif
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
        @endif
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="dashboard-logout">
        @csrf
        <button type="submit" class="btn btn-light w-100 fw-semibold">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </button>
    </form>
</aside>
