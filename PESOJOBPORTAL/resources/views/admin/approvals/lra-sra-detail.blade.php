@extends('layouts.app')

@section('title', strtoupper($activityRequest->activity_type) . ' Request - Review')

@section('admin-content')
@include('admin.layouts.topbar', [
    'title' => strtoupper($activityRequest->activity_type) . ' Request Review',
    'subtitle' => 'Review and ' . ($activityRequest->status === 'pending' ? 'approve or reject' : 'view') . ' the LRA/SRA request documents',
    'icon' => 'bi-clipboard-check'
])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <div class="mb-4">
            <a href="{{ route('admin.lra-sra-approvals') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to Approvals
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

            <!-- Employer Details / Company Profile Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Company Profile</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Company Logo Section -->
                    <div class="p-4 border-bottom" style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                @if($activityRequest->employer?->profile?->logo_path)
                                    <img src="{{ asset('storage/' . $activityRequest->employer->profile->logo_path) }}" 
                                         alt="Company Logo" class="img-fluid rounded-lg shadow-sm" style="max-width: 120px; max-height: 120px; object-fit: cover;">
                                @else
                                    <div class="border-2 border-dashed rounded-lg p-4" style="background-color: #e5e7eb; aspect-ratio: 1;">
                                        <i class="bi bi-image" style="font-size: 2.5rem; color: #9ca3af;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <div class="ps-3">
                                    <h6 style="color: #0f4c8a; margin-bottom: 0.5rem;">{{ $activityRequest->employer->profile?->company_name ?? $activityRequest->employer->profile?->business_name ?? $activityRequest->employer?->name ?? 'N/A' }}</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $activityRequest->employer->profile?->trade_name ? '(' . $activityRequest->employer->profile->trade_name . ')' : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Information Table -->
                    <table class="table table-borderless mb-0" style="font-size: 0.95rem;">
                        <tbody>
                            <tr style="background-color: #f9fafb;">
                                <td style="padding: 1rem; font-weight: 600; color: #6b7280; width: 30%; border-top: 1px solid #e5e7eb;"><i class="bi bi-briefcase me-2" style="color: #0f4c8a;"></i>Business Name</td>
                                <td style="padding: 1rem; color: #1f2937; border-top: 1px solid #e5e7eb;">{{ $activityRequest->employer->profile?->business_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 1rem; font-weight: 600; color: #6b7280; border-top: 1px solid #e5e7eb;"><i class="bi bi-tag me-2" style="color: #0f4c8a;"></i>Tax ID (TIN)</td>
                                <td style="padding: 1rem; color: #1f2937; border-top: 1px solid #e5e7eb;">{{ $activityRequest->employer->profile?->tin ?? 'N/A' }}</td>
                            </tr>
                            <tr style="background-color: #f9fafb;">
                                <td style="padding: 1rem; font-weight: 600; color: #6b7280; border-top: 1px solid #e5e7eb;"><i class="bi bi-people me-2" style="color: #0f4c8a;"></i>Workforce Size</td>
                                <td style="padding: 1rem; color: #1f2937; border-top: 1px solid #e5e7eb;">
                                    <span class="badge" style="background-color: #dbeafe; color: #0c4a6e; padding: 0.4rem 0.8rem;">{{ ucfirst($activityRequest->employer->profile?->workforce_size ?? 'N/A') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 1rem; font-weight: 600; color: #6b7280; border-top: 1px solid #e5e7eb;"><i class="bi bi-diagram-3 me-2" style="color: #0f4c8a;"></i>Line of Business</td>
                                <td style="padding: 1rem; color: #1f2937; border-top: 1px solid #e5e7eb;">{{ $activityRequest->employer->profile?->line_of_business ?? 'N/A' }}</td>
                            </tr>
                            <tr style="background-color: #f9fafb;">
                                <td style="padding: 1rem; font-weight: 600; color: #6b7280; border-top: 1px solid #e5e7eb;"><i class="bi bi-building me-2" style="color: #0f4c8a;"></i>Office Type</td>
                                <td style="padding: 1rem; color: #1f2937; border-top: 1px solid #e5e7eb;">
                                    <span class="badge" style="background-color: #f0fdf4; color: #15803d; padding: 0.4rem 0.8rem;">{{ ucfirst(str_replace('_', ' ', $activityRequest->employer->profile?->office_type ?? 'N/A')) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Contact Information Section -->
                    <div style="border-top: 2px solid #e5e7eb; padding: 1.5rem; background: #f0fdf4;">
                        <h6 style="color: #0f4c8a; margin-bottom: 1rem; font-weight: 700;"><i class="bi bi-telephone me-2"></i>Contact Information</h6>
                        <table class="table table-borderless mb-0" style="font-size: 0.95rem;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280; width: 30%;"><i class="bi bi-person me-2" style="color: #059669;"></i>Contact Person</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->contact_person_name ?? $activityRequest->employer->profile?->establishment_contact_person ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-briefcase me-2" style="color: #059669;"></i>Position</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->establishment_contact_position ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-envelope me-2" style="color: #059669;"></i>Email</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;"><a href="mailto:{{ $activityRequest->employer->profile?->establishment_email ?? $activityRequest->employer?->email ?? '#' }}">{{ $activityRequest->employer->profile?->establishment_email ?? $activityRequest->employer?->email ?? 'N/A' }}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-phone me-2" style="color: #059669;"></i>Phone</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->establishment_phone ?? $activityRequest->employer->profile?->contact_person_phone ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Business Address Section -->
                    <div style="border-top: 2px solid #e5e7eb; padding: 1.5rem; background: #eff6ff;">
                        <h6 style="color: #0f4c8a; margin-bottom: 1rem; font-weight: 700;"><i class="bi bi-geo-alt me-2"></i>Business Address</h6>
                        <table class="table table-borderless mb-0" style="font-size: 0.95rem;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280; width: 30%;"><i class="bi bi-house me-2" style="color: #2563eb;"></i>Street / Village</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->street_village ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-map me-2" style="color: #2563eb;"></i>Barangay</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->barangay ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-building me-2" style="color: #2563eb;"></i>City / Municipality</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->city_municipality ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600; color: #6b7280;"><i class="bi bi-signpost me-2" style="color: #2563eb;"></i>Province</td>
                                    <td style="padding: 0.75rem 0; color: #1f2937;">{{ $activityRequest->employer->profile?->province ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Business Documents Section -->
                    <div style="border-top: 2px solid #e5e7eb; padding: 1.5rem; background: #fef3c7;">
                        <h6 style="color: #92400e; margin-bottom: 1rem; font-weight: 700;"><i class="bi bi-file-check me-2"></i>Business Documents</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3" style="background-color: #fffbeb; border-color: #fde68a;">
                                    <i class="bi bi-file-pdf" style="font-size: 1.5rem; color: #dc2626;"></i>
                                    <p class="mt-2 mb-1 small"><strong>Business Permit</strong></p>
                                    @if($activityRequest->employer->profile?->business_permit_path)
                                        <a href="{{ asset('storage/' . $activityRequest->employer->profile->business_permit_path) }}" 
                                           class="btn btn-sm btn-outline-warning mt-2" target="_blank">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    @else
                                        <small class="text-muted">Not provided</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3" style="background-color: #fffbeb; border-color: #fde68a;">
                                    <i class="bi bi-file-earmark-ruled" style="font-size: 1.5rem; color: #f59e0b;"></i>
                                    <p class="mt-2 mb-1 small"><strong>DTI/SEC Registration</strong></p>
                                    @if($activityRequest->employer->profile?->dti_sec_registration_path)
                                        <a href="{{ asset('storage/' . $activityRequest->employer->profile->dti_sec_registration_path) }}" 
                                           class="btn btn-sm btn-outline-warning mt-2" target="_blank">
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

            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            @if($activityRequest->status === 'pending')
                <!-- Request Summary Card -->
                <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #f9f5ff 100%); border-left: 4px solid #6366f1;">
                    <div class="card-body p-3">
                        <div class="text-center pb-2 border-bottom border-opacity-25">
                            <div style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 0.5rem;">Request Type</div>
                            <div class="badge" style="font-size: 0.85rem; padding: 0.4rem 0.8rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);">
                                <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                            </div>
                        </div>
                        <div class="mt-2" style="font-size: 0.85rem;">
                            <div class="mb-2 pb-2 border-bottom border-opacity-25">
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-building me-1"></i>Submitted by</p>
                                <p class="mb-0" style="font-size: 0.9rem; font-weight: 600; color: #1f2937;">{{ $activityRequest->employer?->name }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-calendar me-1"></i>Submitted on</p>
                                <p class="mb-0" style="font-size: 0.9rem; color: #374151;">{{ optional($activityRequest->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="card border-0 shadow-lg sticky-top" style="top: 20px; background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%); border-left: 4px solid #f59e0b; border-top: 2px solid #f59e0b;">
                    <div class="card-header border-0 py-2 px-3 border-bottom border-warning border-opacity-25" style="background: transparent;">
                        <h6 class="mb-0" style="font-weight: 700; color: #92400e; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-shield-check me-2"></i>REVIEW</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="background-color: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 0.35rem; padding: 0.5rem; margin-bottom: 0.75rem;" role="alert">
                            <small style="color: #1e40af; font-weight: 500; font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Review all details before deciding.</small>
                        </div>
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}" 
                                    class="btn btn-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; font-weight: 600; padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                                <i class="bi bi-check-circle me-1"></i>Approve
                            </button>
                            <button type="button" class="btn btn-sm" style="background: white; color: #dc2626; border: 2px solid #fca5a5; font-weight: 600; padding: 0.5rem 0.75rem; font-size: 0.85rem;" data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i>Reject
                            </button>
                        </form>
                        <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.05);">
                            <p style="font-size: 0.7rem; color: #6b7280; text-align: center; margin-bottom: 0;"><i class="bi bi-exclamation-triangle me-1" style="color: #f59e0b;"></i><strong style="color: #f59e0b;">PENDING</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Status Info Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
                    <div class="card-header border-0 py-2 px-3 border-bottom" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                        <h6 class="mb-0" style="font-weight: 700; color: #374151; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-info-circle me-2"></i>COMPANY</h6>
                    </div>
                    <div class="card-body p-3 small">
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-globe me-1"></i>BUSINESS</p>
                            <p class="mb-0" style="font-weight: 600;">{{ $activityRequest->employer->profile?->line_of_business ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-people me-1"></i>WORKFORCE</p>
                            <p class="mb-0" style="font-weight: 600;">{{ $activityRequest->employer->profile?->workforce_size ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-telephone me-1"></i>CONTACT</p>
                            <p class="mb-0" style="font-weight: 600; word-break: break-word;">{{ $activityRequest->employer->profile?->establishment_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Request Summary Card -->
                <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #f9f5ff 100%); border-left: 4px solid #6366f1;">
                    <div class="card-body p-3">
                        <div class="text-center pb-2 border-bottom border-opacity-25">
                            <div style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 0.5rem;">Request Type</div>
                            <div class="badge" style="font-size: 0.85rem; padding: 0.4rem 0.8rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);">
                                <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                            </div>
                        </div>
                        <div class="mt-2" style="font-size: 0.85rem;">
                            <div class="mb-2 pb-2 border-bottom border-opacity-25">
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-building me-1"></i>Submitted by</p>
                                <p class="mb-0" style="font-size: 0.9rem; font-weight: 600; color: #1f2937;">{{ $activityRequest->employer?->name }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-calendar me-1"></i>Submitted on</p>
                                <p class="mb-0" style="font-size: 0.9rem; color: #374151;">{{ optional($activityRequest->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Info Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
                    <div class="card-header border-0 py-2 px-3 border-bottom" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                        <h6 class="mb-0" style="font-weight: 700; color: #374151; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-info-circle me-2"></i>STATUS</h6>
                    </div>
                    <div class="card-body p-0">
                        @if($activityRequest->status === 'approved')
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #10b981; padding: 0.75rem;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.2rem; color: #059669; flex-shrink: 0;"></i>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-weight: 700; color: #065f46; font-size: 0.9rem; margin-bottom: 0.5rem;">Approved</p>
                                        <div style="background: white; border-radius: 0.3rem; padding: 0.5rem; font-size: 0.75rem; color: #374151;">
                                            <div style="display: grid; grid-template-columns: auto 1fr; gap: 0.25rem 0.5rem; word-break: break-word;">
                                                <span style="font-weight: 600; color: #059669;"><i class="bi bi-calendar-event" style="font-size: 0.7rem;"></i></span>
                                                <span>{{ optional($activityRequest->approved_at)->format('M d, Y') }}</span>
                                                <span style="font-weight: 600; color: #059669;"><i class="bi bi-person-check" style="font-size: 0.7rem;"></i></span>
                                                <span style="word-break: break-word;">{{ $activityRequest->approvedBy?->name ?? 'System' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($activityRequest->status === 'rejected')
                            <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left: 4px solid #ef4444; padding: 0.75rem;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-x-circle-fill me-2" style="font-size: 1.2rem; color: #dc2626; flex-shrink: 0;"></i>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-weight: 700; color: #7f1d1d; font-size: 0.9rem; margin-bottom: 0.5rem;">Rejected</p>
                                        <div style="background: white; border-radius: 0.3rem; padding: 0.5rem; font-size: 0.75rem; color: #374151;">
                                            <p style="font-weight: 600; color: #dc2626; margin-bottom: 0.3rem;"><i class="bi bi-exclamation-circle" style="font-size: 0.7rem;"></i> Reason:</p>
                                            <p style="margin-bottom: 0; color: #7f1d1d; font-style: italic; word-break: break-word; line-height: 1.3;">{{ $activityRequest->notes ?? 'No reason provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Rejection Modal -->
                                        <p style="font-weight: 700; color: #7f1d1d; font-size: 0.9rem; margin-bottom: 0.5rem;">Rejected</p>
                                        <div style="background: white; border-radius: 0.3rem; padding: 0.5rem; font-size: 0.75rem; color: #374151;">
                                            <p style="font-weight: 600; color: #dc2626; margin-bottom: 0.3rem;"><i class="bi bi-exclamation-circle" style="font-size: 0.7rem;"></i> Reason:</p>
                                            <p style="margin-bottom: 0; color: #7f1d1d; font-style: italic; word-break: break-word; line-height: 1.3;">{{ $activityRequest->notes ?? 'No reason provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            </div>
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
