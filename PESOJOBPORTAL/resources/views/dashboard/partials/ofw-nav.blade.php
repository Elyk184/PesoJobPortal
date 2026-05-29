@php
    $user = $ofwUser ?? auth()->user();
@endphp

<aside class="dashboard-sidebar">
    @php($portalAcceptsUrl = route('ofw.dashboard') . '#portal-accepts')
    <div class="d-flex align-items-center justify-content-between d-lg-none">
        <div class="dashboard-brand">
            <div class="dashboard-brand-mark">
                <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
            </div>
            <div>
                <div class="dashboard-brand-kicker">Link Job Resource Portal</div>
                <div class="dashboard-brand-title">OFW Portal</div>
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
            <div class="dashboard-brand-title">OFW Portal</div>
        </div>
    </div>

    <div class="dashboard-user-card">
        <div class="dashboard-user-avatar">
            {{ strtoupper(substr($user->name ?? 'O', 0, 1)) }}
        </div>
        <div>
            <div class="dashboard-user-name">{{ $user->name ?? 'OFW' }}</div>
            <div class="dashboard-user-role">{{ strtoupper($user->role ?? 'OFW') }}</div>
        </div>
    </div>

    <nav class="dashboard-nav" aria-label="OFW dashboard navigation">
        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Overview</div>
            <a href="{{ $portalAcceptsUrl }}" class="dashboard-nav-link">
                <i class="bi bi-info-circle"></i>
                <span>Accepted Requests</span>
            </a>
            <a href="{{ route('ofw.dashboard') . '#submitted-requests' }}" class="dashboard-nav-link">
                <i class="bi bi-list-check"></i>
                <span>Submitted Requests</span>
            </a>
        </div>

        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Forms</div>
            <a href="{{ route('ofw.dashboard') . '#owwa-request' }}" class="dashboard-nav-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>OWWA Form</span>
            </a>
            @if(optional($user)->role === 'ofw')
            <a href="{{ route('ofw.dmw-builder') }}" class="dashboard-nav-link">
                <i class="bi bi-journal-text"></i>
                <span>DMW Form</span>
            </a>
            @endif
        </div>

        <div class="dashboard-nav-section">
            <div class="dashboard-nav-label">Support</div>
            <a href="{{ $portalAcceptsUrl }}" class="dashboard-nav-link">
                <i class="bi bi-shield-check"></i>
                <span>Portal Guidelines</span>
            </a>
            <a href="{{ route('ofw.dashboard') . '#submitted-requests' }}" class="dashboard-nav-link">
                <i class="bi bi-clock-history"></i>
                <span>Case Tracking</span>
            </a>
        </div>
    </nav>

    <div class="dashboard-highlight">
        <div class="dashboard-highlight-label">Submission rule</div>
        <div class="dashboard-highlight-value">Use official forms only</div>
        <div class="dashboard-highlight-note">Requests are tracked after submission.</div>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="dashboard-logout">
        @csrf
        <button type="submit" class="btn btn-light w-100 fw-semibold">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </button>
    </form>
</aside>