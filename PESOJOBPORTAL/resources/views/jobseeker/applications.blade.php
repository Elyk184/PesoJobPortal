@extends('layouts.dashboard')

@section('title', 'Applications | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Applications tracker">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">My Applications</h1>
            <p class="mb-0 text-muted">Track your application status for {{ $applications->total() }} submitted application(s).</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Application Status</h5>
            
            @if($applications->count() > 0)
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
                            @foreach($applications as $application)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $application->job->title ?? 'Job Deleted' }}</div>
                                        <div class="text-muted small">{{ $application->job->employer->name ?? 'Company' }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusBadges = [
                                                'pending' => 'secondary',
                                                'referred' => 'info',
                                                'interview_scheduled' => 'primary',
                                                'hired' => 'success',
                                                'rejected' => 'danger',
                                                'not_selected' => 'danger',
                                            ];
                                            $statusLabel = ucfirst(str_replace('_', ' ', $application->status));
                                            $badgeColor = $statusBadges[$application->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge text-bg-{{ $badgeColor }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-muted">
                                        @if($application->status === 'pending')
                                            Wait for PESO screening
                                        @elseif($application->status === 'referred')
                                            Employer review
                                        @elseif($application->status === 'interview_scheduled')
                                            Attend interview
                                        @elseif($application->status === 'hired')
                                            Congratulations!
                                        @else
                                            Application closed
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary" title="View details" disabled>
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($applications->hasPages())
                    <nav aria-label="Applications pagination" class="mt-3">
                        <ul class="pagination justify-content-center mb-0">
                            @if($applications->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $applications->previousPageUrl() }}">Previous</a></li>
                            @endif

                            @foreach($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
                                @if($page == $applications->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if($applications->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $applications->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                @endif
            @else
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>No applications yet</strong> - You haven't submitted any job applications. <a href="{{ route('jobseeker.vacancies') }}" class="alert-link">Browse available jobs</a> to get started!
                </div>
            @endif

            <div class="mt-4">
                <h6 class="fw-semibold mb-2">Status flow</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-secondary">Pending</span>
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
