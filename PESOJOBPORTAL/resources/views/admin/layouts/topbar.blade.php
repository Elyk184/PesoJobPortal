<!-- Top Bar -->
<div class="admin-topbar">
    <div class="admin-topbar-left">
        <div class="topbar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        </div>
        <div class="topbar-title">
            <h2><i class="bi {{ $icon ?? 'bi-speedometer2' }} me-2"></i>{{ $title ?? 'Admin Page' }}</h2>
            <div class="topbar-subtitle">{{ $subtitle ?? 'Admin Portal' }}</div>
        </div>
    </div>
</div>
