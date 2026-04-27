@extends('layouts.app')

@section('title', $job->title . ' - Job Review')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2>{{ $job->title }}</h2>
            <p class="text-muted">
                <i class="bi bi-briefcase me-2"></i>
                @if($job->status === 'pending')
                    <span class="badge bg-warning">Pending Approval</span>
                @elseif($job->status === 'active')
                    <span class="badge bg-success">Active</span>
                @elseif($job->status === 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @else
                    <span class="badge bg-danger">{{ ucfirst($job->status) }}</span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.job-approvals') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Approvals
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <!-- Job Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Job Details</h5>
                </div>
                <div class="card-body">
                    <!-- Basic Info -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Job Title</small>
                            <strong class="h6">{{ $job->title }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Employment Type</small>
                            <strong class="h6">{{ ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A')) }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Location</small>
                            <strong class="h6">{{ $job->location ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Vacancies</small>
                            <strong class="h6">{{ $job->vacancies ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Posted Date</small>
                            <strong class="h6">{{ $job->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Application Deadline</small>
                            <strong class="h6">{{ $job->application_end_date ? \Carbon\Carbon::parse($job->application_end_date)->format('d M, Y') : 'N/A' }}</strong>
                        </div>
                    </div>

                    <!-- Salary Info -->
                    @if($job->salary_range || $job->salary)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block">Salary Range</small>
                            <strong class="h6">{{ $job->salary_range ?? $job->salary ?? 'Not specified' }}</strong>
                        </div>
                    @endif

                    <!-- Description -->
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Job Description</small>
                        <div class="border-start border-3 ps-3">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Key Responsibilities -->
                    @if($job->key_responsibilities)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Key Responsibilities</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->key_responsibilities)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Qualifications -->
                    @if($job->qualifications)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Qualifications</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->qualifications)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Experience -->
                    @if($job->experience)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Experience Required</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->experience)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Education -->
                    @if($job->education)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Education Requirements</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->education)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Benefits -->
                    @if($job->benefits)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Benefits</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->benefits)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Preferred Skills -->
                    @if($job->preferred_skills)
                        <hr>
                        <div class="mb-0">
                            <small class="text-muted d-block mb-2">Preferred Skills</small>
                            <div class="border-start border-3 ps-3">
                                {!! nl2br(e($job->preferred_skills)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Employer Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Employer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Employer Name</small>
                        <strong>{{ $job->employer_name ?? 'N/A' }}</strong>
                    </div>
                    @if($job->employer)
                        <div class="mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $job->employer->email }}</strong>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted d-block">Employer Status</small>
                            @if($job->employer->is_employer_verified)
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Verified</span>
                            @else
                                <span class="badge bg-warning"><i class="bi bi-exclamation-circle me-1"></i>Unverified</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Review Status</h5>
                </div>
                <div class="card-body">
                    @if($job->status === 'pending')
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Awaiting Approval</strong>
                            <p class="mb-0 mt-2 small">Review the job details above and approve or reject this posting.</p>
                        </div>
                    @elseif($job->status === 'active')
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Approved</strong>
                            <p class="mb-0 mt-2 small">
                                Approved by: <strong>{{ $job->approver?->name ?? 'System' }}</strong><br>
                                On: <strong>{{ $job->approved_at?->format('d M, Y h:i A') }}</strong>
                            </p>
                        </div>
                    @elseif($job->status === 'draft')
                        <div class="alert alert-secondary" role="alert">
                            <i class="bi bi-file-earmark me-2"></i>
                            <strong>Rejected</strong>
                            <p class="mb-0 mt-2 small">
                                Reason: <strong>{{ $job->rejection_reason ?? 'No reason provided' }}</strong>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($job->status === 'pending')
                <div class="d-grid gap-2">
                    <form method="POST" class="d-grid">
                        @csrf
                        <button type="submit" formaction="{{ route('admin.jobs.approve', $job) }}" class="btn btn-lg btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve Job Posting
                        </button>
                    </form>

                    <button type="button" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-2"></i>Reject Job Posting
                    </button>
                </div>
            @endif

            <!-- Statistics -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Applications</span>
                            <strong class="badge bg-secondary">{{ $job->applications->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Reject Job Posting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.jobs.reject', $job) }}">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">You are about to reject the job posting for <strong>{{ $job->title }}</strong>.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            id="rejection_reason"
                            name="rejection_reason" 
                            class="form-control" 
                            rows="4" 
                            placeholder="Explain why this job posting is being rejected..."
                            required></textarea>
                        <small class="text-muted d-block mt-2">The employer will be notified of this reason.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>Reject Posting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
