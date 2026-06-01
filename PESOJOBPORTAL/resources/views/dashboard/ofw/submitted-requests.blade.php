@extends('layouts.dashboard')

@section('title', 'OFW | Submitted Requests')

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
    <section aria-label="Submitted OFW RFA requests">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Submitted Requests</div>
                <div class="dashboard-topbar-subtitle">Recent OWWA RFA submissions and status updates</div>
            </div>

            <a href="{{ route('ofw.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4 mb-4">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <h3 class="h5 mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Submitted Requests</h3>
                <span class="badge rounded-pill text-bg-light text-secondary">{{ ($submittedRequests ?? collect())->count() }} recent</span>
            </div>

            @if (($submittedRequests ?? collect())->isNotEmpty())
                <div class="list-group list-group-flush">
                    @foreach ($submittedRequests as $submittedRequest)
                        <div class="list-group-item px-0 d-flex flex-column flex-md-row justify-content-between gap-2">
                            <div>
                                <div class="fw-semibold text-secondary">{{ $submittedRequest->subject ?? 'OWWA Request for Assistance' }}</div>
                                <div class="small text-muted">
                                    Submitted {{ optional($submittedRequest->created_at)->format('M d, Y') }}
                                    @if (! empty($submittedRequest->details))
                                        | {{ \Illuminate\Support\Str::limit($submittedRequest->details, 90) }}
                                    @endif
                                </div>
                            </div>
                            <span class="badge rounded-pill text-bg-light text-secondary align-self-start">
                                {{ str_replace('_', ' ', ucfirst($submittedRequest->status ?? 'open')) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="dashboard-empty-state">
                    <div>
                        <div class="fs-1 mb-2"><i class="bi bi-inbox"></i></div>
                        <div class="fw-semibold text-secondary">No submitted requests yet.</div>
                        <div class="small">Submit an OWWA request to start tracking your case here.</div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
