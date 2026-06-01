@extends('layouts.dashboard')

@section('title', 'OFW | OWWA RFA')

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
    <section aria-label="OWWA Request for Assistance">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">OWWA Request for Assistance</div>
                <div class="dashboard-topbar-subtitle">Open the official RFA form for OFW support concerns</div>
            </div>

            <a href="{{ route('ofw.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>

        <div class="row g-3 mb-4 justify-content-center">
            <div class="col-12 col-lg-7">
                <div class="dashboard-section-card h-100 p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                        <h3 class="h5 mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i>OWWA Request for Assistance</h3>
                        <span class="badge rounded-pill text-bg-danger">Primary</span>
                    </div>

                    <p class="text-muted mb-3">
                        Use the OWWA form for support concerns handled under OWWA assistance workflows.
                    </p>

                    <a href="{{ route('ofw.rfa.form') }}" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Open OWWA Form
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
