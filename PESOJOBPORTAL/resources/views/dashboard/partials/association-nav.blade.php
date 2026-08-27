<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('association.dashboard') }}"
       class="btn btn-sm {{ request()->routeIs('association.dashboard') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
    <a href="{{ route('association.registration-form') }}"
       class="btn btn-sm {{ request()->routeIs('association.registration-form') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-file-earmark-text me-1"></i>Association Registration
    </a>
    <a href="{{ route('association.submitted-requests') }}"
       class="btn btn-sm {{ request()->routeIs('association.submitted-requests') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-list-check me-1"></i>Submitted Requests
    </a>
    <a href="{{ route('association.accepted-requests') }}"
       class="btn btn-sm {{ request()->routeIs('association.accepted-requests') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-check2-circle me-1"></i>Accepted Requests
    </a>
    <a href="{{ route('association.profile') }}"
       class="btn btn-sm {{ request()->routeIs('association.profile') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-person-circle me-1"></i>My Profile
    </a>
</div>
