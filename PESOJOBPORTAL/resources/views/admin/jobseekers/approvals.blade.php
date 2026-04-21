@extends('layouts.admin')

@section('title', 'Jobseeker Approvals | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Jobseeker Approvals', 'subtitle' => 'Review and approve pending jobseeker registrations', 'icon' => 'bi-person-check'])

<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
        @if($jobseekers->count() > 0)
            <table class="table data-table w-100">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Applications</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobseekers as $jobseeker)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($jobseeker->name, 25) }}</strong>
                            </td>
                            <td>{{ Str::limit($jobseeker->email, 20) }}</td>
                            <td><small>{{ $jobseeker->created_at->format('d M, Y') }}</small></td>
                            <td>
                                <span class="badge bg-info">{{ $jobseeker->applications_count ?? 0 }} apps</span>
                            </td>
                            <td class="text-center">
                                <form method="POST" class="d-inline-flex gap-2">
                                    @csrf
                                    <a href="{{ route('admin.jobseekers.show', $jobseeker) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button type="submit" formaction="{{ route('admin.jobseekers.approve', $jobseeker) }}" 
                                            class="btn btn-sm btn-success" title="Approve">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $jobseeker->id }}" title="Reject">
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
                                        <h5 class="modal-title">Reject Registration</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.jobseekers.reject', $jobseeker) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <p class="text-muted mb-3">Rejecting: <strong>{{ $jobseeker->name }}</strong></p>
                                            <div class="mb-3">
                                                <label for="reason_{{ $jobseeker->id }}" class="form-label">
                                                    Reason <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="reason_{{ $jobseeker->id }}" name="reason" class="form-control" rows="4" 
                                                          placeholder="Explain why this registration is being rejected..." required></textarea>
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
                {{ $jobseekers->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>All caught up!</strong> No pending jobseeker approvals.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>

@endsection
