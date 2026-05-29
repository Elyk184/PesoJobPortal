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
                <div class="dashboard-topbar-title">OWWA Request for Assistance</div>
                <div class="dashboard-topbar-subtitle">Submit, track, and manage official OFW assistance requests</div>
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
                    <p class="mb-0 text-muted">Use the official forms below to submit an assistance request and monitor its progress.</p>
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
                    <a href="#owwa-request" class="btn btn-danger px-3 shadow-sm">
                        <i class="bi bi-file-earmark-plus me-2"></i>Open OWWA Form
                    </a>
                    <a href="#dmw-request" class="btn btn-outline-primary px-3">
                        <i class="bi bi-journal-text me-2"></i>Open DMW Form
                    </a>
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

        <div class="dashboard-section-card p-3 p-lg-4 mb-4" id="portal-accepts">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <h3 class="h5 mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>What this portal accepts</h3>
            </div>

            <p class="mb-3 text-muted">
                As agreed with the officer-in-charge, this OFW portal accepts only formal assistance requests using the official forms.
                Choose the correct form below and submit only one request per case.
            </p>

            <ul class="mb-0 text-secondary">
                <li>OWWA Request for Assistance (RFA)</li>
                <li>DMW Request for Assistance (RFA)</li>
                <li>After submission, use My Submitted Requests to track case status.</li>
            </ul>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-6" id="owwa-request">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i>OWWA Request for Assistance</h3>
                        <span class="badge rounded-pill text-bg-danger">Primary</span>
                    </div>

                    <p class="text-muted mb-3">
                        Use the OWWA form for support concerns handled under OWWA assistance workflows.
                    </p>

                    <a href="#portal-accepts" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Open OWWA Form
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-6" id="dmw-request">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-journal-text me-2"></i>DMW Request for Assistance</h3>
                        <span class="badge rounded-pill text-bg-primary">Secondary</span>
                    </div>

                    <p class="text-muted mb-3">
                        Use the DMW form for cases that need Department of Migrant Workers assistance and coordination.
                    </p>
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
                </div>
            </div>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4 mb-4" id="submitted-requests">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <h3 class="h5 mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>My Submitted Requests</h3>
                <span class="badge rounded-pill text-bg-light text-secondary">View status</span>
            </div>

            <div class="dashboard-empty-state">
                <div>
                    <div class="fs-1 mb-2">✦</div>
                    <div class="fw-semibold text-secondary">No submitted requests yet.</div>
                    <div class="small">Submit an OWWA or DMW request to start tracking your case here.</div>
                </div>
            </div>
        </div>
    </section>
@endsection