@extends('layouts.dashboard')

@section('title', 'OFW | Accepted Requests')

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
    <section aria-label="Accepted OFW RFA requests">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Accepted Requests</div>
                <div class="dashboard-topbar-subtitle">OWWA RFA concerns accepted by the OFW portal</div>
            </div>

            <a href="{{ route('ofw.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4 mb-4">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <h3 class="h5 mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Accepted Requests</h3>
                <span class="badge rounded-pill text-bg-success">Available</span>
            </div>

            <p class="mb-3 text-muted">
                This OFW portal currently accepts official OWWA Request for Assistance submissions from overseas Filipino workers
                and their qualified family representatives. Submit one complete request per concern so the PESO office can review,
                endorse, and coordinate the next action.
            </p>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="fw-semibold text-secondary mb-1"><i class="bi bi-life-preserver me-2 text-danger"></i>Assistance Concerns</div>
                        <div class="small text-muted">Welfare, employment, repatriation, documentation, or other urgent OFW-related concerns.</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="fw-semibold text-secondary mb-1"><i class="bi bi-person-lines-fill me-2 text-danger"></i>Requester Details</div>
                        <div class="small text-muted">OFW profile, family representative information, contact details, and current address.</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="fw-semibold text-secondary mb-1"><i class="bi bi-paperclip me-2 text-danger"></i>Supporting Information</div>
                        <div class="small text-muted">Case description, employment background, and details needed for review and coordination.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
