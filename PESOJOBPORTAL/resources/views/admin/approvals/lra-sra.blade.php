@extends('layouts.app')

@section('title', 'LRA/SRA Approvals | Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">
                <i class="bi bi-clipboard-check"></i> LRA/SRA Approval Requests
                <span class="badge bg-primary ms-2">{{ $pendingRequests->total() }} Pending</span>
            </h2>

            @if($pendingRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Employer</th>
                                <th>Documents</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRequests as $request)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ strtoupper($request->activity_type) }}</span>
                                    </td>
                                    <td>{{ $request->employer?->name ?? 'N/A' }}</td>
                                    <td>
                                        <small>
                                            <i class="bi bi-file-pdf"></i> LOI<br>
                                            <i class="bi bi-file-pdf"></i> Company Profile<br>
                                            <i class="bi bi-file-pdf"></i> Job Ad
                                        </small>
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form method="POST" class="d-flex gap-2" style="display: inline-flex;">
                                            @csrf
                                            <button type="submit" formaction="{{ route('admin.lra-sra.approve', $request) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('admin.lra-sra.reject', $request) }}" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject {{ strtoupper($request->activity_type) }} Request</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label">Rejection Note:</label>
                                                        <textarea class="form-control" name="notes" rows="4" required></textarea>
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
                    {{ $pendingRequests->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No pending LRA/SRA requests for approval.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
