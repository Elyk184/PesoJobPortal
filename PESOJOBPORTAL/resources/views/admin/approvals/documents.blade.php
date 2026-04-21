@extends('layouts.app')

@section('title', 'Document Verification | Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">
                <i class="bi bi-file-earmark"></i> Document Verification
                <span class="badge bg-primary ms-2">{{ $pendingDocuments->total() }} Pending</span>
            </h2>

            @if($pendingDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Employer</th>
                                <th>Document Type</th>
                                <th>File</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingDocuments as $doc)
                                <tr>
                                    <td>{{ $doc->user?->name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-secondary">{{ $doc->document_type }}</span></td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="link-primary">
                                            <i class="bi bi-download"></i> View File
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <form method="POST" class="d-flex gap-2" style="display: inline-flex;">
                                            @csrf
                                            <button type="submit" formaction="{{ route('admin.documents.approve', $doc->id) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $doc->id }}">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $doc->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('admin.documents.reject', $doc->id) }}" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Document</h5>
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
                    {{ $pendingDocuments->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No pending documents for verification.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
