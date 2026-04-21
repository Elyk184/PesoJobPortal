@extends('layouts.admin')

@section('title', $jobseeker->name . ' - Jobseeker Registration Details')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2>{{ $jobseeker->name }}</h2>
            <p class="text-muted">
                <i class="bi bi-person-circle me-2"></i>
                @if($jobseeker->is_approved === null)
                    <span class="badge bg-warning">Pending Approval</span>
                @elseif($jobseeker->is_approved)
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.jobseekers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-lg-8 mb-4">
            <!-- Contact Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-envelope-fill me-2"></i>Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $jobseeker->email }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Registered</small>
                            <strong>{{ $jobseeker->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            @if($jobseeker->profile)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($jobseeker->profile->phone)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Phone</small>
                                    <strong>{{ $jobseeker->profile->phone }}</strong>
                                </div>
                            @endif
                            @if($jobseeker->profile->date_of_birth)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <strong>{{ \Carbon\Carbon::parse($jobseeker->profile->date_of_birth)->format('d M, Y') }}</strong>
                                </div>
                            @endif
                            @if($jobseeker->profile->address)
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Address</small>
                                    <strong>{{ $jobseeker->profile->address }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Applications Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-check me-2"></i>Job Applications
                        <span class="badge bg-secondary ms-2">{{ $jobseeker->applications->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($jobseeker->applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employer</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobseeker->applications as $app)
                                        <tr>
                                            <td>{{ Str::limit($app->job?->title ?? 'N/A', 25) }}</td>
                                            <td>{{ Str::limit($app->job?->employer_name ?? 'N/A', 20) }}</td>
                                            <td>
                                                @if($app->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($app->status === 'accepted')
                                                    <span class="badge bg-success">Accepted</span>
                                                @elseif($app->status === 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $app->created_at->format('d M, Y') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>No applications yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Registration Status</h5>
                </div>
                <div class="card-body">
                    @if($jobseeker->is_approved === null)
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Pending Review</strong>
                            <p class="mb-0 mt-2 small">This jobseeker registration is awaiting approval.</p>
                        </div>

                        <!-- Approval Actions -->
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.jobseekers.approve', $jobseeker) }}" 
                                    class="btn btn-lg btn-success">
                                <i class="bi bi-check-circle me-2"></i>Approve Registration
                            </button>
                        </form>

                        <button type="button" class="btn btn-lg btn-danger w-100 mt-2" data-bs-toggle="modal" 
                                data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>Reject Registration
                        </button>
                    @elseif($jobseeker->is_approved)
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Approved</strong>
                            <p class="mb-0 mt-2 small">
                                Approved by: <strong>{{ $jobseeker->approver?->name ?? 'System' }}</strong><br>
                                On: <strong>{{ $jobseeker->approved_at?->format('d M, Y h:i A') }}</strong>
                            </p>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Rejected</strong>
                            <p class="mb-0 mt-2 small">
                                Reason: <strong>{{ $jobseeker->rejection_reason ?? 'No reason provided' }}</strong><br>
                                Rejected on: <strong>{{ $jobseeker->rejected_at?->format('d M, Y h:i A') }}</strong>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Total Applications</span>
                            <strong class="badge bg-secondary">{{ $jobseeker->applications->count() }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Applications Accepted</span>
                            <strong class="badge bg-success">{{ $jobseeker->applications->where('status', 'accepted')->count() }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Profile Completed</span>
                            <strong class="badge {{ $jobseeker->profile ? 'bg-success' : 'bg-warning' }}">
                                {{ $jobseeker->profile ? 'Yes' : 'No' }}
                            </strong>
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
                <h5 class="modal-title">Reject Jobseeker Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">You are about to reject the registration of <strong>{{ $jobseeker->name }}</strong>.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            id="rejection_reason"
                            name="rejection_reason" 
                            class="form-control" 
                            rows="4" 
                            placeholder="Explain why this registration is being rejected..."
                            required></textarea>
                        <small class="text-muted d-block mt-2">Minimum 10 characters. The jobseeker will be notified of this reason.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>Reject Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
