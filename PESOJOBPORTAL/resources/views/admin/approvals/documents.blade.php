@extends('layouts.admin-dashboard')

@section('title', 'Document Verification | PESO Admin')

<?php
    $pageTitle = 'Document Verification';
    $pageSubtitle = 'Review and verify employer-submitted documents';
    $pageIcon = 'bi-file-earmark';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
            @if($pendingDocuments->count() > 0)
                <!-- Verification Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Employer</th>
                            <th>Document Type</th>
                            <th>File</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingDocuments as $doc)
                            <tr>
                                <td><strong>{{ Str::limit($doc->user?->name ?? 'N/A', 20) }}</strong></td>
                                <td>
                                    <span class="badge badge-doctype bg-secondary">{{ $doc->document_type }}</span>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="link-primary d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-file-earmark-pdf"></i> View File
                                    </a>
                                </td>
                                <td><small>{{ \Carbon\Carbon::parse($doc->created_at)->format('d M, Y') }}</small></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        @csrf
                                        <button type="submit" formaction="{{ route('admin.documents.approve', $doc->id) }}"
                                                class="btn btn-sm btn-success" title="Approve this document">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $doc->id }}" title="Reject this document">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal{{ $doc->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Document</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.documents.reject', $doc->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong>{{ $doc->user?->name ?? 'N/A' }}</strong> - <span class="text-uppercase fw-bold">{{ $doc->document_type }}</span></p>
                                                <div class="mb-3">
                                                    <label for="rejection_note_{{ $doc->id }}" class="form-label">
                                                        Rejection Note <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea
                                                        id="rejection_note_{{ $doc->id }}"
                                                        name="notes"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Explain why this document is being rejected..."
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
                    {{ $pendingDocuments->links('pagination::bootstrap-5') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending documents to verify.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

@endsection
