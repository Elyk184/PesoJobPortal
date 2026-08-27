@extends('layouts.dashboard')

@section('title', 'Association | Dashboard')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>Association Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.association-nav')
@endsection

@section('content')
    <section aria-label="Association dashboard">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Dashboard</div>
                <div class="dashboard-topbar-subtitle">Overview for Association submissions</div>
            </div>

            <div class="d-none d-md-block text-end">
                <div class="fw-semibold text-secondary">{{ $associationUser->name ?? 'Association' }}</div>
                <div class="dashboard-topbar-subtitle">Association Portal</div>
            </div>
        </div>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="dashboard-section-card p-3 p-lg-4 mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <h2 class="h4 mb-1 fw-bold">Welcome back, {{ $associationUser->name ?? 'Association' }}!</h2>
                    <p class="mb-0 text-muted">Submit new requests, upload documents, and monitor your submitted requests from one dashboard.</p>
                </div>

                <div class="dashboard-highlight" style="min-width: 280px; background: #f7f9fc; color: #314458; border: 1px solid var(--dash-border); box-shadow: none;">
                    <div class="dashboard-highlight-label" style="color: var(--dash-muted);">Association account info</div>
                    <div class="dashboard-highlight-value" style="color: #23374f;">{{ $profileSummary['name'] ?? $associationUser->name ?? 'Association' }}</div>
                    <div class="dashboard-highlight-note" style="color: var(--dash-muted);">
                        {{ $profileSummary['email'] ?? $associationUser->email }}
                        @if (! empty($profileSummary['phone']))
                            <br>{{ $profileSummary['phone'] }}
                        @endif
                        @if (! empty($profileSummary['address']))
                            <br>{{ $profileSummary['address'] }}
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('association.registration-form') }}" class="btn btn-danger px-3 shadow-sm">
                        <i class="bi bi-file-earmark-plus me-2"></i>Association Registration
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

        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Association Registration</h3>
                        <span class="badge rounded-pill text-bg-danger">Form</span>
                    </div>
                    <p class="text-muted mb-3">
                        Apply for Worker's Association (WA) registration with complete documentation.
                    </p>
                    <a href="{{ route('association.registration-form') }}" class="btn btn-danger w-100">
                        <i class="bi bi-arrow-right me-2"></i>Open Registration Form
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Submitted Requests</h3>
                        <span class="badge rounded-pill text-bg-light text-secondary">{{ ($submittedRequests ?? collect())->count() }} recent</span>
                    </div>
                    <p class="text-muted mb-3">
                        Review your latest submitted requests and current processing status.
                    </p>
                    <a href="{{ route('association.submitted-requests') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>View Requests
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-check2-circle me-2"></i>Accepted Requests</h3>
                        <span class="badge rounded-pill text-bg-success">Resolved</span>
                    </div>
                    <p class="text-muted mb-3">
                        View your WA registration requests that have been accepted or resolved.
                    </p>
                    <a href="{{ route('association.accepted-requests') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Open Page
                    </a>
                </div>
            </div>
        </div>

        @if($submittedRequests->isNotEmpty())
            <div class="dashboard-section-card p-3 p-lg-4">
                <h3 class="h5 mb-3 fw-bold">Recent Submissions</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Association Name</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedRequests as $request)
                                <tr>
                                    <td>{{ $request->subject }}</td>
                                    <td>{{ $request->association_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($request->status === 'open')
                                            <span class="badge bg-primary">Open</span>
                                        @elseif($request->status === 'under_review')
                                            <span class="badge bg-warning">Under Review</span>
                                        @else
                                            <span class="badge bg-success">Resolved</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>
@endsection
