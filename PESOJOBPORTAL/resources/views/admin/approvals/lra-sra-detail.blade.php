@extends('layouts.admin')

@section('title', strtoupper($activityRequest->activity_type) . ' Request - LRA/SRA Review')

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
                    <!-- Activity Type & Status -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Activity Type</small>
                            <strong class="h6">
                                <span class="badge" style="background-color: {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }}; padding: 0.5rem 0.75rem;">
                                    {{ strtoupper($activityRequest->activity_type) }}
                                </span>
                            </strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Current Status</small>
                            <strong class="h6">
                                <span class="badge" style="background-color: 
                                    @if($activityRequest->status === 'pending') #f59e0b
                                    @elseif($activityRequest->status === 'approved') #10b981
                                    @else #ef4444 @endif; padding: 0.5rem 0.75rem;">
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">
                                    {{ $activityRequest->status === 'approved' ? 'Approved' : 'Rejected' }} Date
                                </small>
                                <strong class="h6">{{ optional($activityRequest->approved_at)->format('d M, Y h:i A') ?? 'N/A' }}</strong>
                            </div>
                            @if($activityRequest->approvedBy)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Reviewed By</small>
                                    <strong class="h6">{{ $activityRequest->approvedBy->name }}</strong>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($activityRequest->notes)
                        <hr>
                        <div>
                            <small class="text-muted d-block mb-2">{{ $activityRequest->status === 'approved' ? 'Approval' : 'Rejection' }} Notes</small>
                            <div class="alert alert-{{ $activityRequest->status === 'approved' ? 'success' : 'danger' }} border-0" role="alert">
                                {{ $activityRequest->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-pdf me-2"></i>Submitted Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Letter of Intent -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <div style="font-size: 2.5rem; color: #ef4444; margin-bottom: 0.75rem;">
                                    <i class="bi bi-file-pdf"></i>
                                </div>
                                <p class="mb-1"><strong>Letter of Intent</strong></p>
                                @if($activityRequest->letter_of_intent_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->letter_of_intent_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->letter_of_intent_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>

                        <!-- Company Profile -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <div style="font-size: 2.5rem; color: #ef4444; margin-bottom: 0.75rem;">
                                    <i class="bi bi-file-pdf"></i>
                                </div>
                                <p class="mb-1"><strong>Company Profile</strong></p>
                                @if($activityRequest->company_profile_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->company_profile_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->company_profile_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>

                        <!-- Job Advertisement -->
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <div style="font-size: 2.5rem; color: #ef4444; margin-bottom: 0.75rem;">
                                    <i class="bi bi-file-pdf"></i>
                                </div>
                                <p class="mb-1"><strong>Job Advertisement</strong></p>
                                @if($activityRequest->job_advertisement_path)
                                    <small class="text-muted d-block mb-2">{{ basename($activityRequest->job_advertisement_path) }}</small>
                                    <a href="{{ asset('storage/' . $activityRequest->job_advertisement_path) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
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
                            <small class="text-muted d-block">Position</small>
                            <strong>{{ $activityRequest->employer->profile->establishment_contact_position ?? 'N/A' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Phone</small>
                            <strong>{{ $activityRequest->employer->profile->establishment_phone ?? 'N/A' }}</strong>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted d-block">Address</small>
                            <strong>
                                {{ trim(implode(', ', array_filter([
                                    $activityRequest->employer->profile->street_village,
                                    $activityRequest->employer->profile->barangay,
                                    $activityRequest->employer->profile->city_municipality,
                                    $activityRequest->employer->profile->province,
                                ]))) ?: 'N/A' }}
                            </strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Review Status</h5>
                </div>
                <div class="card-body">
                    @if($activityRequest->status === 'pending')
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Awaiting Approval</strong>
                            <p class="mb-0 mt-2 small">Review the request details and documents above, then approve or reject this request.</p>
                        </div>
                    @elseif($activityRequest->status === 'approved')
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Approved</strong>
                            <p class="mb-0 mt-2 small">
                                Approved by: <strong>{{ $activityRequest->approvedBy?->name ?? 'System' }}</strong><br>
                                On: <strong>{{ $activityRequest->approved_at?->format('d M, Y h:i A') }}</strong>
                            </p>
                        </div>
                    @elseif($activityRequest->status === 'rejected')
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Rejected</strong>
                            <p class="mb-0 mt-2 small">
                                Reason: <strong>{{ $activityRequest->notes ?? 'No reason provided' }}</strong>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($activityRequest->status === 'pending')
                <div class="d-grid gap-2 mb-4">
                    <form method="POST" class="d-grid">
                        @csrf
                        <button type="submit" formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}" 
                                class="btn btn-lg btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve Request
                        </button>
                    </form>

                    <button type="button" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-2"></i>Reject Request
                    </button>
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
                            Rejecting: <strong>{{ $activityRequest->employer?->name ?? 'N/A' }}</strong><br>
                            <span class="text-uppercase fw-bold" style="color: {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }};">
                                {{ $activityRequest->activity_type }}
                            </span>
                        </p>
                        <div class="mb-0">
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
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
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
