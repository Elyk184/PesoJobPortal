@extends('layouts.admin')

@section('title', 'LRA/SRA Request Review')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2>{{ strtoupper($activityRequest->activity_type) }} Request Review</h2>
            <p class="text-muted">
                <i class="bi bi-clipboard-check me-2"></i>
                @if($activityRequest->status === 'pending')
                    <span class="badge bg-warning">Pending Approval</span>
                @elseif($activityRequest->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.lra-sra-approvals') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Approvals
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <!-- Request Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Request Details</h5>
                </div>
                <div class="card-body">
                    <!-- Basic Info -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Activity Type</small>
                            <strong class="h6">
                                <span class="badge" style="background-color: {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }};">
                                    {{ strtoupper($activityRequest->activity_type) }}
                                </span>
                            </strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Status</small>
                            <strong class="h6">
                                <span class="badge" style="background-color: 
                                    @if($activityRequest->status === 'pending') #f59e0b
                                    @elseif($activityRequest->status === 'approved') #10b981
                                    @else #ef4444 @endif;">
                                    {{ ucfirst($activityRequest->status) }}
                                </span>
                            </strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Submitted Date</small>
                            <strong class="h6">{{ $activityRequest->created_at->format('d M, Y h:i A') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Employer</small>
                            <strong class="h6">{{ $activityRequest->employer?->name ?? 'N/A' }}</strong>
                        </div>
                    </div>

                    @if($activityRequest->status !== 'pending')
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">
                                    {{ $activityRequest->status === 'approved' ? 'Approved' : 'Rejected' }} Date
                                </small>
                                <strong class="h6">{{ optional($activityRequest->approved_at)->format('d M, Y h:i A') ?? 'N/A' }}</strong>
                            </div>
                            @if($activityRequest->approvedBy)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">
                                        {{ $activityRequest->status === 'approved' ? 'Approved' : 'Reviewed' }} By
                                    </small>
                                    <strong class="h6">{{ $activityRequest->approvedBy->name }}</strong>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($activityRequest->notes)
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">{{ $activityRequest->status === 'approved' ? 'Approval' : 'Rejection' }} Notes</small>
                            <div class="alert alert-info border-0" role="alert">
                                {{ $activityRequest->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-file-earmark me-2"></i>Submitted Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Letter of Intent -->
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 text-center" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1"><strong>Letter of Intent</strong></p>
                                @if($activityRequest->letter_of_intent_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->letter_of_intent_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->letter_of_intent_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>

                        <!-- Company Profile -->
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 text-center" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1"><strong>Company Profile</strong></p>
                                @if($activityRequest->company_profile_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->company_profile_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->company_profile_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>

                        <!-- Job Advertisement -->
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 text-center" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1"><strong>Job Advertisement</strong></p>
                                @if($activityRequest->job_advertisement_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->job_advertisement_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->job_advertisement_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>
                    </div>
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
                        <small class="text-muted d-block">Company Name</small>
                        <strong>{{ $activityRequest->employer?->name ?? 'N/A' }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $activityRequest->employer?->email ?? 'N/A' }}</strong>
                    </div>
                    @if($activityRequest->employer?->profile)
                        <div class="mb-3">
                            <small class="text-muted d-block">Contact Person</small>
                            <strong>{{ $activityRequest->employer->profile->establishment_contact_person ?? 'N/A' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Phone</small>
                            <strong>{{ $activityRequest->employer->profile->establishment_phone ?? 'N/A' }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approval Actions (only if pending) -->
            @if($activityRequest->status === 'pending')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Approval Actions</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}" 
                                    class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Approve Request
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-2"></i>Reject Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Rejection Modal -->
@if($activityRequest->status === 'pending')
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject {{ strtoupper($activityRequest->activity_type) }} Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.lra-sra.reject', $activityRequest) }}">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Rejecting: <strong>{{ $activityRequest->employer?->name ?? 'N/A' }}</strong> - 
                            <span class="text-uppercase fw-bold">{{ $activityRequest->activity_type }}</span>
                        </p>
                        <div class="mb-3">
                            <label for="rejection_notes" class="form-label">
                                Rejection Reason <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                id="rejection_notes"
                                name="notes" 
                                class="form-control" 
                                rows="4" 
                                placeholder="Explain why this request is being rejected..."
                                required></textarea>
                            @error('notes')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
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
@endif

@endsection
