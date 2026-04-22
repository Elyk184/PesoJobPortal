@extends('layouts.admin')

@section('title', strtoupper($activityRequest->activity_type) . ' Request - Review')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>{{ strtoupper($activityRequest->activity_type) }} Request - Review</h2>
        </div>
        <a href="{{ route('admin.lra-sra-approvals') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Request Overview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted d-block mb-1">Activity Type</small>
                            <span class="badge" style="background-color: {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }}; padding: 0.5rem 0.75rem; font-size: 0.9rem;">
                                {{ strtoupper($activityRequest->activity_type) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block mb-1">Employer</small>
                            <strong>{{ $activityRequest->employer?->name ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block mb-1">Submitted</small>
                            <strong>{{ $activityRequest->created_at->format('M d, Y') }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block mb-1">Status</small>
                            <span class="badge" style="background-color: 
                                @if($activityRequest->status === 'pending') #f59e0b
                                @elseif($activityRequest->status === 'approved') #10b981
                                @else #ef4444 @endif; padding: 0.5rem 0.75rem; font-size: 0.9rem;">
                                {{ ucfirst($activityRequest->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-pdf me-2"></i>Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1 small"><strong>Letter of Intent</strong></p>
                                @if($activityRequest->letter_of_intent_path)
                                    <a href="{{ asset('storage/' . $activityRequest->letter_of_intent_path) }}" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1 small"><strong>Company Profile</strong></p>
                                @if($activityRequest->company_profile_path)
                                    <a href="{{ asset('storage/' . $activityRequest->company_profile_path) }}" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted">Not provided</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100" style="background-color: #f9fafb;">
                                <i class="bi bi-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                <p class="mt-2 mb-1 small"><strong>Job Advertisement</strong></p>
                                @if($activityRequest->job_advertisement_path)
                                    <a href="{{ asset('storage/' . $activityRequest->job_advertisement_path) }}" 
                                       class="btn btn-sm btn-outline-primary mt-2" target="_blank">
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

            <!-- Employer Details -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Employer Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Company Name</small>
                            <strong>{{ $activityRequest->employer?->name ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $activityRequest->employer?->email ?? 'N/A' }}</strong>
                        </div>
                        @if($activityRequest->employer?->profile)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Contact Person</small>
                                <strong>{{ $activityRequest->employer->profile->establishment_contact_person ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Position</small>
                                <strong>{{ $activityRequest->employer->profile->establishment_contact_position ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $activityRequest->employer->profile->establishment_phone ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-md-6 mb-0">
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
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            @if($activityRequest->status === 'pending')
                <!-- Action Card -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0">Review Actions</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}" 
                                    class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle me-1"></i>Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i>Reject
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Status Info Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="card-body">
                        @if($activityRequest->status === 'approved')
                            <div class="alert alert-success alert-sm mb-0" role="alert">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                <strong>Approved</strong>
                                <p class="mb-0 mt-2 small">
                                    {{ optional($activityRequest->approved_at)->format('M d, Y') }}<br>
                                    {{ $activityRequest->approvedBy?->name ?? 'Admin' }}
                                </p>
                            </div>
                        @elseif($activityRequest->status === 'rejected')
                            <div class="alert alert-danger alert-sm mb-0" role="alert">
                                <i class="bi bi-x-circle-fill me-1"></i>
                                <strong>Rejected</strong>
                                <p class="mb-0 mt-2 small">{{ $activityRequest->notes ?? 'No reason provided' }}</p>
                            </div>
                        @endif
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
                    <h5 class="modal-title">Reject Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.lra-sra.reject', $activityRequest) }}">
                    @csrf
                    <div class="modal-body">
                        <small class="text-muted">{{ strtoupper($activityRequest->activity_type) }} - {{ $activityRequest->employer?->name }}</small>
                        <div class="mb-0 mt-3">
                            <label for="rejection_notes" class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea id="rejection_notes" name="notes" class="form-control" rows="4" 
                                      placeholder="Explain why..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection
