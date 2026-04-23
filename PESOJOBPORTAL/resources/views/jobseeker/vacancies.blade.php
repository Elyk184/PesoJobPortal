@extends('layouts.dashboard')

@section('title', 'Vacancies | Jobseeker')

@section('content')
<section class="container py-4" aria-label="Job vacancies">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">Active Job Vacancies</h1>
            <p class="mb-0 text-muted">Filter and sort available job posts (static demo).</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Filters</h5>
            <form class="row g-3" action="#" method="GET">
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Location</label>
                    <select class="form-select" disabled>
                        <option selected>All locations</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Industry</label>
                    <select class="form-select" disabled>
                        <option selected>All industries</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Skills</label>
                    <input class="form-control" placeholder="e.g., cashier, driving" disabled />
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Barangay</label>
                    <select class="form-select" disabled>
                        <option selected>All barangays</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label">Sort</label>
                    <select class="form-select" disabled>
                        <option selected>Newest</option>
                        <option>Expiring soon</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6 d-flex align-items-end justify-content-lg-end">
                    <button class="btn btn-danger" type="button" disabled>
                        <i class="bi bi-funnel me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <h5 class="card-title fw-semibold mb-1">Office Staff / Admin Assistant</h5>
                        <span class="badge text-bg-success">Open</span>
                    </div>
                    <p class="text-muted small mb-3">Manolo Fortich • Admin/Clerical</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge rounded-pill text-bg-light">MS Office</span>
                        <span class="badge rounded-pill text-bg-light">Filing</span>
                        <span class="badge rounded-pill text-bg-light">Encoding</span>
                    </div>
                    <button class="btn btn-outline-danger w-100" type="button" disabled>
                        <i class="bi bi-send me-2"></i>Apply (coming soon)
                    </button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <h5 class="card-title fw-semibold mb-1">Construction Laborer</h5>
                        <span class="badge text-bg-success">Open</span>
                    </div>
                    <p class="text-muted small mb-3">Barangay Damilag • Construction</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge rounded-pill text-bg-light">Basic tools</span>
                        <span class="badge rounded-pill text-bg-light">Safety</span>
                    </div>
                    <button class="btn btn-outline-danger w-100" type="button" disabled>
                        <i class="bi bi-send me-2"></i>Apply (coming soon)
                    </button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <h5 class="card-title fw-semibold mb-1">Cashier</h5>
                        <span class="badge text-bg-warning">Expiring soon</span>
                    </div>
                    <p class="text-muted small mb-3">Barangay Tankulan • Retail</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge rounded-pill text-bg-light">Customer service</span>
                        <span class="badge rounded-pill text-bg-light">POS</span>
                    </div>
                    <button class="btn btn-outline-danger w-100" type="button" disabled>
                        <i class="bi bi-send me-2"></i>Apply (coming soon)
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
