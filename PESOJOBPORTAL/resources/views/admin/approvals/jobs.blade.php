@extends('layouts.app')

@section('title', 'Job Approvals | PESO Admin')

@section('content')
@include('admin.layouts.topbar', ['title' => 'Job Approvals', 'subtitle' => 'Review and approve pending job postings', 'icon' => 'bi-file-check'])

<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
            @if($pendingJobs->count() > 0)
                <!-- Approvals Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Location</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingJobs as $job)
                            <tr>
                                <td>
                                    <strong>{{ Str::limit($job->title, 25) }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                                </td>
                                <td>{{ Str::limit($job->employer?->name ?? 'N/A', 20) }}</td>
                                <td>{{ Str::limit($job->location, 20) }}</td>
                                <td><small>{{ $job->created_at->format('d M, Y') }}</small></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        @csrf
                                        <button type="submit" formaction="{{ route('admin.jobs.approve', $job) }}" 
                                                class="btn btn-sm btn-success" title="Approve this job">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $job->id }}" title="Reject this job">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                        <a href="{{ route('admin.jobs.review', $job) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $job->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Job Posting</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.jobs.reject', $job) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $job->title }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason_{{ $job->id }}" class="form-label">
                                                        Reason <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        id="rejection_reason_{{ $job->id }}"
                                                        name="rejection_reason" 
                                                        class="form-control" 
                                                        rows="4" 
                                                        placeholder="Explain why this job posting is being rejected..."
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pendingJobs->links('pagination::bootstrap-5') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending job approvals to review.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

@endsection
