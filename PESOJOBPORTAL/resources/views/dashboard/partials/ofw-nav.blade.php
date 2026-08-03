<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('ofw.dashboard') }}"
       class="btn btn-sm {{ request()->routeIs('ofw.dashboard') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
    <a href="{{ route('ofw.dmw-builder') }}"
       class="btn btn-sm {{ request()->routeIs('ofw.dmw-builder') ? 'btn-danger' : 'btn-outline-danger' }}">
        <i class="bi bi-file-earmark-text me-1"></i>DMW Builder
    </a>
</div>