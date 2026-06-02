@extends('layouts.dashboard')

@section('title', 'OFW | Dashboard')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

@section('content')
    <section aria-label="OFW dashboard">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Dashboard</div>
                <div class="dashboard-topbar-subtitle">Overview for OWWA Request for Assistance submissions</div>
            </div>

            <div class="d-none d-md-block text-end">
                <div class="fw-semibold text-secondary">{{ $ofwUser->name ?? 'OFW' }}</div>
                <div class="dashboard-topbar-subtitle">OFW Portal</div>
            </div>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4 mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <h2 class="h4 mb-1 fw-bold">Welcome back, {{ $ofwUser->name ?? 'OFW' }}!</h2>
                    <p class="mb-0 text-muted">Review accepted request types, open the OWWA RFA form, and monitor your submitted requests from one dashboard.</p>
                </div>

                <div class="dashboard-highlight" style="min-width: 280px; background: #f7f9fc; color: #314458; border: 1px solid var(--dash-border); box-shadow: none;">
                    <div class="dashboard-highlight-label" style="color: var(--dash-muted);">OFW account info</div>
                    <div class="dashboard-highlight-value" style="color: #23374f;">{{ $profileSummary['name'] ?? $ofwUser->name ?? 'OFW' }}</div>
                    <div class="dashboard-highlight-note" style="color: var(--dash-muted);">
                        {{ $profileSummary['email'] ?? $ofwUser->email }}
                        @if (! empty($profileSummary['phone']))
                            <br>{{ $profileSummary['phone'] }}
                        @endif
                        @if (! empty($profileSummary['address']))
                            <br>{{ $profileSummary['address'] }}
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
<<<<<<< HEAD:PESOJOBPORTAL/resources/views/dashboard/ofw/dashboard.blade.php
                    <a href="{{ route('ofw.owwa-request') }}" class="btn btn-danger px-3 shadow-sm">
                        <i class="bi bi-file-earmark-plus me-2"></i>Start OWWA RFA
=======
                    <a href="{{ route('ofw.dashboard') . '#owwa-request' }}" class="btn btn-danger px-3 shadow-sm">
                        <i class="bi bi-file-earmark-plus me-2"></i>Open OWWA Form
                    </a>
                    @if(optional(auth()->user())->role === 'ofw')
                    <a href="{{ route('ofw.dashboard') . '#dmw-request' }}" class="btn btn-outline-primary px-3">
                        <i class="bi bi-journal-text me-2"></i>Open DMW Form
>>>>>>> 26fcc21c858b8cb66dc7c98e0ce921d300a044d2:PESOJOBPORTAL/resources/views/dashboard/ofw.blade.php
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon"><i class="bi bi-inbox"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ $requestStats['open'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Open Requests</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(47, 157, 98, 0.12); color: var(--dash-success);"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ $requestStats['under_review'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Under Review</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon" style="background: rgba(220, 164, 42, 0.12); color: var(--dash-warning);"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <div class="dashboard-stat-number">{{ $requestStats['resolved'] ?? 0 }}</div>
                        <div class="dashboard-stat-label">Resolved Cases</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Accepted Requests</h3>
                        <span class="badge rounded-pill text-bg-success">Available</span>
                    </div>
                    <p class="text-muted mb-3">
                        View the OFW concerns and details accepted for OWWA Request for Assistance processing.
                    </p>
<<<<<<< HEAD:PESOJOBPORTAL/resources/views/dashboard/ofw/dashboard.blade.php
                    <a href="{{ route('ofw.accepted-requests') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Open Page
=======

                    <a href="{{ route('ofw.dashboard') . '#portal-accepts' }}" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Open OWWA Form
>>>>>>> 26fcc21c858b8cb66dc7c98e0ce921d300a044d2:PESOJOBPORTAL/resources/views/dashboard/ofw.blade.php
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i>OWWA RFA</h3>
                        <span class="badge rounded-pill text-bg-danger">Form</span>
                    </div>
                    <p class="text-muted mb-3">
                        Start a new OWWA assistance request using the official RFA form.
                    </p>
<<<<<<< HEAD:PESOJOBPORTAL/resources/views/dashboard/ofw/dashboard.blade.php
                    <a href="{{ route('ofw.owwa-request') }}" class="btn btn-danger w-100">
                        <i class="bi bi-arrow-right me-2"></i>Open Page
                    </a>
=======
                    <div class="mb-3">
                        <a href="{{ route('ofw.dmw-builder') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Open DMW Form Builder
                        </a>

                        <form action="{{ route('ofw.attachments.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                            @csrf
                            <input type="file" name="attachment" accept="application/pdf,image/*" class="form-control form-control-sm" required>
                            <button class="btn btn-sm btn-secondary">Upload</button>
                        </form>
                    </div>

                    <div>
                        <div class="fw-semibold">Uploaded attachments</div>
                        @if(! empty($dmwAttachments))
                            <ul class="list-unstyled small mb-0">
                                @foreach($dmwAttachments as $idx => $att)
                                    <li class="d-flex align-items-center justify-content-between py-1">
                                        <a href="{{ $att }}" target="_blank">Attachment {{ $idx + 1 }}</a>
                                        <form action="{{ route('ofw.attachments.delete') }}" method="POST" class="mb-0">
                                            @csrf
                                            <input type="hidden" name="path" value="{{ ltrim(str_replace(asset('storage').'/', '', $att), '/') }}">
                                            <button class="btn btn-link btn-sm text-danger p-0">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small text-muted">No attachments uploaded yet. Upload passport and contract copies here to have them appended to the DMW PDF.</div>
                        @endif
                    </div>
>>>>>>> 26fcc21c858b8cb66dc7c98e0ce921d300a044d2:PESOJOBPORTAL/resources/views/dashboard/ofw.blade.php
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Submitted Requests</h3>
                        <span class="badge rounded-pill text-bg-light text-secondary">{{ ($submittedRequests ?? collect())->count() }} recent</span>
                    </div>
                    <p class="text-muted mb-3">
                        Review your latest submitted assistance requests and current processing status.
                    </p>
                    <a href="{{ route('ofw.submitted-requests') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Open Page
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
