@extends('layouts.app')

@section('title', 'LRA/SRA Approvals | PESO Admin')

@section('content')
@include('admin.layouts.topbar', ['title' => 'LRA/SRA Approvals', 'subtitle' => 'Review and approve local recruitment and special recruitment agreement requests', 'icon' => 'bi-clipboard-check'])

<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
            @if($pendingRequests->count() > 0)
                <!-- Approvals Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Employer</th>
                            <th>Documents</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                            <tr>
                                <td>
                                    <span class="badge badge-activity bg-info">{{ strtoupper($request->activity_type) }}</span>
                                </td>
                                <td><strong>{{ Str::limit($request->employer?->name ?? 'N/A', 20) }}</strong></td>
                                <td>
                                    <small>
                                        <i class="bi bi-file-pdf"></i> LOI<br>
                                        <i class="bi bi-file-pdf"></i> Company Profile<br>
                                        <i class="bi bi-file-pdf"></i> Job Ad
                                    </small>
                                </td>
                                <td><small>{{ $request->created_at->format('d M, Y') }}</small></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        @csrf
                                        <a href="{{ route('admin.lra-sra.review', $request) }}" 
                                           class="btn btn-sm btn-info" title="Review this request">
                                            <i class="bi bi-eye"></i> Review
                                        </a>
                                        <button type="submit" formaction="{{ route('admin.lra-sra.approve', $request) }}" 
                                                class="btn btn-sm btn-success" title="Approve this request">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $request->id }}" title="Reject this request">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject {{ strtoupper($request->activity_type) }} Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.lra-sra.reject', $request) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $request->employer?->name ?? 'N/A' }}</strong> - <span class="text-uppercase fw-bold">{{ $request->activity_type }}</span></p>
                                                <div class="mb-3">
                                                    <label for="rejection_note_{{ $request->id }}" class="form-label">
                                                        Rejection Note <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        id="rejection_note_{{ $request->id }}"
                                                        name="notes" 
                                                        class="form-control" 
                                                        rows="4" 
                                                        placeholder="Explain why this request is being rejected..."
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
                    {{ $pendingRequests->links('pagination::bootstrap-5') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending LRA/SRA approvals to review.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

@endsection
