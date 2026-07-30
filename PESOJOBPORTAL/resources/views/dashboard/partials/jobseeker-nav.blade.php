<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('jobseeker.dashboard') }}"
       class="btn btn-sm {{ request()->routeIs('jobseeker.dashboard') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
     <a href="{{ route('jobseeker.browse-jobs') }}"
         class="btn btn-sm {{ request()->routeIs('jobseeker.browse-jobs') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-briefcase me-1"></i>Vacancies
    </a>
    <a href="{{ route('jobseeker.applications') }}"
       class="btn btn-sm {{ request()->routeIs('jobseeker.applications') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-clipboard-check me-1"></i>Applications
    </a>
    <a href="{{ route('jobseeker.profile') }}"
       class="btn btn-sm {{ request()->routeIs('jobseeker.profile') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-person-lines-fill me-1"></i>Profile
    </a>
</div>
