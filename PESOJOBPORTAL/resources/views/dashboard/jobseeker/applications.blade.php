@extends('layouts.dashboard')

@section('title', 'Applications | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Applications tracker">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">My Applications</h1>
            <p class="mb-0 text-muted">Track your application status across the PESO pipeline.</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <h5 class="card-title fw-semibold mb-0">Application Status</h5>
                <div class="small text-muted">Showing {{ $applications->total() }} application(s)</div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('jobseeker.applications') }}" class="btn btn-sm {{ $statusFilter === 'all' ? 'btn-danger' : 'btn-outline-secondary' }}">All ({{ $statusSummary['all'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'pending']) }}" class="btn btn-sm {{ $statusFilter === 'pending' ? 'btn-danger' : 'btn-outline-secondary' }}">Pending ({{ $statusSummary['pending'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'recommended']) }}" class="btn btn-sm {{ $statusFilter === 'recommended' ? 'btn-danger' : 'btn-outline-secondary' }}">Recommended ({{ $statusSummary['recommended'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'interview']) }}" class="btn btn-sm {{ $statusFilter === 'interview' ? 'btn-danger' : 'btn-outline-secondary' }}">Interview ({{ $statusSummary['interview'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'hired']) }}" class="btn btn-sm {{ $statusFilter === 'hired' ? 'btn-danger' : 'btn-outline-secondary' }}">Hired ({{ $statusSummary['hired'] ?? 0 }})</a>
                <a href="{{ route('jobseeker.applications', ['status' => 'rejected']) }}" class="btn btn-sm {{ $statusFilter === 'rejected' ? 'btn-danger' : 'btn-outline-secondary' }}">Rejected ({{ $statusSummary['rejected'] ?? 0 }})</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th>Job</th>
                            <th>Status</th>
                            <th>Applied</th>
                            <th>Next Step</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            @php
                                $statusMeta = match($application->status) {
                                    'pending' => ['label' => 'Pending PESO Review', 'class' => 'text-bg-secondary', 'next' => 'Wait for PESO screening'],
                                    'reviewed' => ['label' => 'Recommended', 'class' => 'text-bg-info', 'next' => 'Employer review in progress'],
                                    'interviewed' => ['label' => 'Interview', 'class' => 'text-bg-primary', 'next' => 'Prepare for interview updates'],
                                    'hired' => ['label' => 'Hired', 'class' => 'text-bg-success', 'next' => 'Coordinate onboarding with employer'],
                                    'rejected' => ['label' => 'Not Selected', 'class' => 'text-bg-danger', 'next' => 'Apply to other active vacancies'],
                                    default => ['label' => ucfirst((string) $application->status), 'class' => 'text-bg-light', 'next' => 'Check latest status updates'],
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $application->job?->title ?? 'Job posting unavailable' }}</div>
                                    <div class="text-muted small">{{ $application->job?->employer_name ?? 'Employer unavailable' }}</div>
                                </td>
                                <td><span class="badge {{ $statusMeta['class'] }}">{{ $statusMeta['label'] }}</span></td>
                                <td class="text-muted small">{{ optional($application->applied_at)->format('M d, Y h:i A') ?? optional($application->created_at)->format('M d, Y h:i A') }}</td>
                                <td class="text-muted">{{ $statusMeta['next'] }}</td>
                                <td class="text-end"><button class="btn btn-sm btn-outline-secondary" disabled>View</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">No applications found for this filter.</div>
                                    <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-sm btn-outline-danger mt-2">Browse Vacancies</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($applications->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
            @endif

            <div class="mt-4">
                <h6 class="fw-semibold mb-2">Status flow</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-secondary">Pending PESO Review</span>
                    <span class="badge rounded-pill text-bg-info">Recommended</span>
                    <span class="badge rounded-pill text-bg-primary">Interview</span>
                    <span class="badge rounded-pill text-bg-success">Hired</span>
                    <span class="badge rounded-pill text-bg-danger">Not Selected</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
