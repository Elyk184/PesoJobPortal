@extends('layouts.admin')

@section('title', 'Jobseeker Registration Approvals')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-person-check-fill me-2"></i>Jobseeker Registration Approvals</h2>
            <p class="text-muted">Review and approve pending jobseeker registrations</p>
        </div>
        <div class="badge bg-warning text-dark" style="font-size: 1.1rem;">
            {{ $pendingJobseekers->total() }} Pending
        </div>
    </div>

    @if($pendingJobseekers->count() > 0)
        <!-- Approvals Table -->
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Profile Status</th>
                            <th>Applications</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingJobseekers as $jobseeker)
                            <tr>
                                <td>
                                    <strong>{{ $jobseeker->name }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($jobseeker->email, 30) }}</small>
                                </td>
                                <td>
                                    <small>{{ $jobseeker->created_at->format('d M, Y') }}</small>
                                </td>
                                <td>
                                    @if($jobseeker->profile)
                                        <span class="badge bg-info text-dark">Completed</span>
                                    @else
                                        <span class="badge bg-secondary">Incomplete</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $appCount = $jobseeker->applications->count();
                                    @endphp
                                    <span class="badge bg-light text-dark">{{ $appCount }} application@if($appCount !== 1)s@endif</span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" class="d-flex gap-2 justify-content-center" style="display: inline-flex;">
                                        @csrf
                                        <button type="submit" formaction="{{ route('admin.jobseekers.approve', $jobseeker) }}" 
                                                class="btn btn-sm btn-success" title="Approve this jobseeker">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $jobseeker->id }}" title="Reject this jobseeker">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $jobseeker->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Jobseeker Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $jobseeker->name }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason_{{ $jobseeker->id }}" class="form-label">
                                                        Reason for Rejection <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        id="rejection_reason_{{ $jobseeker->id }}"
                                                        name="rejection_reason" 
                                                        class="form-control" 
                                                        rows="4" 
                                                        placeholder="Explain why this registration is being rejected..."
                                                        required></textarea>
                                                    <small class="text-muted d-block mt-2">The jobseeker will be notified of this reason.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Reject Registration
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $pendingJobseekers->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>All caught up!</strong> There are no pending jobseeker registrations to review.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endsection
