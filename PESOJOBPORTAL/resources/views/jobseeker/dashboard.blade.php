@extends('layouts.dashboard')

@section('title', 'Jobseeker Dashboard | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Jobseeker dashboard">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">Jobseeker Dashboard</h1>
            <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'Jobseeker' }}.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                        <h5 class="card-title mb-0 fw-semibold">Active Job Vacancies</h5>
                        <a class="btn btn-sm btn-danger" href="{{ route('jobseeker.vacancies') }}">View all</a>
                    </div>
                    <p class="text-muted mb-3">Preview of available jobs (static demo).</p>

                    <div class="list-group">
                        <div class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div>
                                <div class="fw-semibold">Office Staff / Admin Assistant</div>
                                <div class="text-muted small">Manolo Fortich • Admin/Clerical • Skills: MS Office, Filing</div>
                            </div>
                            <span class="badge text-bg-success">Open</span>
                        </div>
                        <div class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div>
                                <div class="fw-semibold">Construction Laborer</div>
                                <div class="text-muted small">Barangay Damilag • Construction • Skills: Basic tools</div>
                            </div>
                            <span class="badge text-bg-success">Open</span>
                        </div>
                        <div class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div>
                                <div class="fw-semibold">Cashier</div>
                                <div class="text-muted small">Barangay Tankulan • Retail • Skills: Customer service</div>
                            </div>
                            <span class="badge text-bg-warning">Expiring soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                        <h5 class="card-title mb-0 fw-semibold">My Application Status</h5>
                        <a class="btn btn-sm btn-outline-danger" href="{{ route('jobseeker.applications') }}">Open tracker</a>
                    </div>
                    <p class="text-muted mb-3">Track the progress of your applications.</p>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="text-muted">
                                    <th>Job</th>
                                    <th>Status</th>
                                    <th class="text-end">Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">Office Staff / Admin Assistant</div>
                                        <div class="text-muted small">PESO Review</div>
                                    </td>
                                    <td><span class="badge text-bg-secondary">Pending PESO Review</span></td>
                                    <td class="text-end text-muted">—</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">Construction Laborer</div>
                                        <div class="text-muted small">Employer Screening</div>
                                    </td>
                                    <td><span class="badge text-bg-info">Referred</span></td>
                                    <td class="text-end text-muted">—</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">Cashier</div>
                                        <div class="text-muted small">Interview Stage</div>
                                    </td>
                                    <td><span class="badge text-bg-primary">Interview Scheduled</span></td>
                                    <td class="text-end text-muted">—</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <div class="small fw-semibold mb-2">Status flow</div>
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
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">PESO Clearance</h5>
                    <p class="text-muted mb-3">View-only clearance status.</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-semibold">Status</span>
                        <span class="badge text-bg-secondary">Not yet verified</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Notifications</h5>
                    <p class="text-muted mb-3">Updates from PESO (static demo).</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="fw-semibold">Job match</div>
                            <div class="text-muted small">New job posts that match your skills.</div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="fw-semibold">Job fair / recruitment event</div>
                            <div class="text-muted small">Upcoming PESO recruitment schedules.</div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="fw-semibold">PESO programs</div>
                            <div class="text-muted small">Training and livelihood announcements.</div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Smart Features (Optional)</h5>
                    <p class="text-muted mb-3">Planned improvements (coming soon).</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary" type="button" disabled>
                            <i class="bi bi-stars me-2"></i>Job matching recommendations
                        </button>
                        <button class="btn btn-outline-secondary" type="button" disabled>
                            <i class="bi bi-file-earmark-text me-2"></i>Resume builder
                        </button>
                        <button class="btn btn-outline-secondary" type="button" disabled>
                            <i class="bi bi-graph-up-arrow me-2"></i>Skill gap suggestions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
