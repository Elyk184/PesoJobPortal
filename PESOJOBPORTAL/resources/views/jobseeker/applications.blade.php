@extends('layouts.dashboard')

@section('title', 'Applications | Jobseeker')

@section('content')
<section class="container py-4" aria-label="Applications tracker">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">My Applications</h1>
            <p class="mb-0 text-muted">Track your application status (static demo).</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Application Status</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th>Job</th>
                            <th>Status</th>
                            <th>Next step</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-semibold">Office Staff / Admin Assistant</div>
                                <div class="text-muted small">Submitted via portal</div>
                            </td>
                            <td><span class="badge text-bg-secondary">Pending PESO Review</span></td>
                            <td class="text-muted">Wait for PESO screening</td>
                            <td class="text-end"><button class="btn btn-sm btn-outline-secondary" disabled>View</button></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-semibold">Construction Laborer</div>
                                <div class="text-muted small">Referred to employer</div>
                            </td>
                            <td><span class="badge text-bg-info">Referred</span></td>
                            <td class="text-muted">Employer review</td>
                            <td class="text-end"><button class="btn btn-sm btn-outline-secondary" disabled>View</button></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-semibold">Cashier</div>
                                <div class="text-muted small">Interview scheduled</div>
                            </td>
                            <td><span class="badge text-bg-primary">Interview Scheduled</span></td>
                            <td class="text-muted">Attend interview</td>
                            <td class="text-end"><button class="btn btn-sm btn-outline-secondary" disabled>View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h6 class="fw-semibold mb-2">Status flow</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-secondary">Pending PESO Review</span>
                    <span class="badge rounded-pill text-bg-info">Referred</span>
                    <span class="badge rounded-pill text-bg-primary">Interview Scheduled</span>
                    <span class="badge rounded-pill text-bg-success">Hired</span>
                    <span class="badge rounded-pill text-bg-danger">Not Selected</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
