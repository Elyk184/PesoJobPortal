@extends('layouts.dashboard')

@section('title', 'My Applications | Jobseeker')

@section('content')
<section aria-label="Job applications">
    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">My Applications</h2>
                <p class="mb-0 text-muted">Track every job you applied for and review the current hiring status in one place.</p>
            </div>
            <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary px-3 shadow-sm">
                <i class="bi bi-search me-2"></i>Browse More Jobs
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ $statusCounts['all'] ?? 0 }}</div>
                    <div class="dashboard-stat-label">Total Applications</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #b45309;"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ $statusCounts['pending'] ?? 0 }}</div>
                    <div class="dashboard-stat-label">Pending Review</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;"><i class="bi bi-mic"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ $statusCounts['interview'] ?? 0 }}</div>
                    <div class="dashboard-stat-label">Interview</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(34, 197, 94, 0.12); color: #15803d;"><i class="bi bi-person-check"></i></div>
                <div>
                    <div class="dashboard-stat-number">{{ ($statusCounts['hired'] ?? 0) + ($statusCounts['rejected'] ?? 0) }}</div>
                    <div class="dashboard-stat-label">Finalized</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-clipboard-check me-2"></i>Application Status</h3>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm {{ $statusFilter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All ({{ $statusCounts['all'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'pending']) }}" class="btn btn-sm {{ $statusFilter === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending ({{ $statusCounts['pending'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'reviewing']) }}" class="btn btn-sm {{ $statusFilter === 'reviewing' ? 'btn-info' : 'btn-outline-info' }}">Reviewing ({{ $statusCounts['reviewing'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'shortlisted']) }}" class="btn btn-sm {{ $statusFilter === 'shortlisted' ? 'btn-success' : 'btn-outline-success' }}">Shortlisted ({{ $statusCounts['shortlisted'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'interview']) }}" class="btn btn-sm {{ $statusFilter === 'interview' ? 'btn-primary' : 'btn-outline-primary' }}">Interview ({{ $statusCounts['interview'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'hired']) }}" class="btn btn-sm {{ $statusFilter === 'hired' ? 'btn-success' : 'btn-outline-success' }}">Hired ({{ $statusCounts['hired'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'rejected']) }}" class="btn btn-sm {{ $statusFilter === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Rejected ({{ $statusCounts['rejected'] ?? 0 }})</a>
            </div>
        </div>

        @if ($applications->isEmpty())
            <div class="dashboard-empty-state text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-clipboard-x display-4 text-muted"></i>
                </div>
                <div class="fw-semibold text-secondary">
                    @if ($statusFilter === 'all')
                        No applications yet.
                    @else
                        No applications found for this status.
                    @endif
                </div>
                <div class="small text-muted mb-3">Browse available jobs and submit your first application.</div>
                <a href="{{ route('jobseeker.browse-jobs') }}" class="btn btn-primary px-4">Browse Jobs</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle applications-table mb-0">
                    <thead>
                        <tr>
                            <th>Job</th>
                            <th>Company</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            @php
                                $job = $application->job;
                                $status = strtolower((string) ($application->status ?? 'pending'));
                                $statusLabel = match ($status) {
                                    'pending' => 'Pending',
                                    'reviewed' => 'Reviewed',
                                    'interviewed' => 'Interview',
                                    'hired' => 'Hired',
                                    'rejected' => 'Rejected',
                                    default => ucfirst($status),
                                };
                                $statusClass = match ($status) {
                                    'pending' => 'warning',
                                    'reviewed' => 'info',
                                    'interviewed' => 'primary',
                                    'hired' => 'success',
                                    'rejected' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $job?->title ?? 'Job no longer available' }}</div>
                                    <div class="small text-muted">{{ $job?->location ?? 'Location unavailable' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark">{{ $job?->employer_name ?? 'Employer unavailable' }}</div>
                                    <div class="small text-muted">{{ $job?->job_type ? ucfirst(str_replace('-', ' ', $job?->job_type)) : 'Employment type unavailable' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark">{{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ optional($application->applied_at ?? $application->created_at)->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="badge text-bg-{{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="small text-muted">
                                        @if (! empty($job?->salary_range))
                                            {{ $job->salary_range }}
                                        @elseif (! empty($application->notes))
                                            Has notes
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr class="applications-mobile-row">
                                <td colspan="5">
                                    <div class="application-card-mobile">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $job?->title ?? 'Job no longer available' }}</div>
                                                <div class="small text-muted">{{ $job?->employer_name ?? 'Employer unavailable' }}<span class="mx-1">|</span>{{ $job?->location ?? 'Location unavailable' }}</div>
                                            </div>
                                            <span class="badge text-bg-{{ $statusClass }}">{{ $statusLabel }}</span>
                                        </div>
                                        <div class="small text-muted mt-2">
                                            Applied {{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}
                                            @if (! empty($job?->salary_range))
                                                <span class="mx-1">|</span>{{ $job->salary_range }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="small text-muted">
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} application(s)
                </div>
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .applications-table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #66758a;
        border-bottom: 1px solid #dbe5f1;
        background: #f8fbff;
    }

    .applications-table tbody tr:hover {
        background: #fbfdff;
    }

    .applications-mobile-row {
        display: none;
    }

    .application-card-mobile {
        display: none;
        padding: 0.85rem 0;
        border-top: 1px solid #edf2f7;
    }

    @media (max-width: 767.98px) {
        .applications-table thead,
        .applications-table tbody tr:not(.applications-mobile-row) {
            display: none;
        }

        .applications-mobile-row {
            display: table-row;
        }

        .application-card-mobile {
            display: block;
        }
    }
</style>
@endpush
