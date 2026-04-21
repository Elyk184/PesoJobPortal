@extends('layouts.app')

@section('title', 'Job Approvals | Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">
                <i class="bi bi-file-check"></i> Job Approvals
                <span class="badge bg-primary ms-2">{{ $pendingJobs->total() }} Pending</span>
            </h2>

            @if($pendingJobs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Job Title</th>
                                <th>Employer</th>
                                <th>Location</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingJobs as $job)
                                <tr>
                                    <td>
                                        <strong>{{ $job->title }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                                    </td>
                                    <td>{{ $job->employer?->name ?? 'N/A' }}</td>
                                    <td>{{ $job->location }}</td>
                                    <td>{{ $job->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form method="POST" class="d-flex gap-2" style="display: inline-flex;">
                                            @csrf
                                            <button type="submit" formaction="{{ route('admin.jobs.approve', $job) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $job->id }}">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $job->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('admin.jobs.reject', $job) }}" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Job</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label">Rejection Reason:</label>
                                                        <textarea class="form-control" name="rejection_reason" rows="4" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $pendingJobs->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No pending job approvals.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
