@extends('layouts.admin-dashboard')

@section('title', 'Company Profile Verification | PESO Admin')

<?php
    $pageTitle = 'Company Profile Review';
    $pageSubtitle = 'Review company profile details';
    $pageIcon = 'bi-building';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .detail-container { max-width: 900px; margin: 0 auto; }
        .detail-card { background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 2rem; }
        .card-header { border-bottom: 2px solid #d72638; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .card-header h3 { margin: 0; color: #0d1f3c; font-size: 18px; font-weight: 700; }
        .info-row { display: grid; grid-template-columns: 200px 1fr; gap: 2rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f0f0f0; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 700; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { color: #0d1f3c; font-size: 14px; }
        .logo-section { text-align: center; margin-bottom: 2rem; }
        .logo-img { width: 120px; height: 120px; border-radius: 10px; object-fit: cover; border: 2px solid #d72638; }
        .logo-placeholder { width: 120px; height: 120px; border-radius: 10px; background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 700; margin: 0 auto; }
        .status-badge { display: inline-block; padding: 0.5rem 1rem; border-radius: 8px; font-size: 13px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-under-review { background: #dbeafe; color: #1e40af; }
        .status-verified { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .action-buttons { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-approve { background: #10b981; color: white; }
        .btn-approve:hover { background: #059669; }
        .btn-reject { background: #ef4444; color: white; }
        .btn-reject:hover { background: #dc2626; }
        .btn-back { background: #6b7280; color: white; }
        .btn-back:hover { background: #4b5563; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #cdd9e5; border-radius: 8px; font-size: 14px; font-family: inherit; }
        .form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14); }
        .doc-preview { display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb; margin-bottom: 1rem; }
        .doc-preview:last-child { margin-bottom: 0; }
        .doc-icon { width: 48px; height: 48px; border-radius: 8px; background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0; }
        .doc-icon.pdf { background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); }
        .doc-icon.img { background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); }
        .doc-info { flex: 1; }
        .doc-name { font-weight: 600; color: #0d1f3c; font-size: 14px; margin-bottom: 2px; }
        .doc-meta { font-size: 12px; color: #6b7280; }
        .doc-actions { display: flex; gap: 0.5rem; }
        .doc-btn { padding: 0.5rem 1rem; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; }
        .doc-btn-view { background: #3b82f6; color: white; }
        .doc-btn-view:hover { background: #2563eb; color: white; }
        .doc-missing { padding: 1.5rem; text-align: center; color: #6b7280; background: #f9fafb; border-radius: 8px; border: 1px dashed #d1d5db; }
    </style>

    <div class="detail-container">
        <!-- Basic Info Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Company Information</h3>
            </div>

            <div class="logo-section">
                @if($companyProfile->logo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->logo_path))
                    <img class="logo-img" src="{{ asset('storage/' . $companyProfile->logo_path) }}" alt="Company Logo">
                @else
                    <div class="logo-placeholder">{{ strtoupper(substr($companyProfile->company_name, 0, 1)) }}</div>
                @endif
            </div>

            <div class="info-row">
                <div class="info-label">Company Name</div>
                <div class="info-value"><strong>{{ $companyProfile->company_name }}</strong></div>
            </div>

            <div class="info-row">
                <div class="info-label">Business Name</div>
                <div class="info-value">{{ $companyProfile->business_name ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Trade Name</div>
                <div class="info-value">{{ $companyProfile->trade_name ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Acronym / Abbreviation</div>
                <div class="info-value">{{ $companyProfile->acronym_abbreviation ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Tax ID (TIN)</div>
                <div class="info-value">{{ $companyProfile->tin ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($companyProfile->verification_status === 'pending')
                        <span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                    @elseif($companyProfile->verification_status === 'under_review')
                        <span class="status-badge status-under-review"><i class="bi bi-search me-1"></i>Under Review</span>
                    @elseif($companyProfile->verification_status === 'verified')
                        <span class="status-badge status-verified"><i class="bi bi-check-circle me-1"></i>Verified</span>
                    @else
                        <span class="status-badge status-rejected"><i class="bi bi-x-circle me-1"></i>Rejected</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Verification Documents Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Verification Documents</h3>
            </div>

            @php
                $hasBusinessPermit = $companyProfile->business_permit_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->business_permit_path);
                $hasDtiSec = $companyProfile->dti_sec_registration_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->dti_sec_registration_path);
            @endphp

            @if($hasBusinessPermit)
                @php
                    $permitExt = pathinfo($companyProfile->business_permit_path, PATHINFO_EXTENSION);
                    $permitIsPdf = strtolower($permitExt) === 'pdf';
                @endphp
                <div class="doc-preview">
                    <div class="doc-icon {{ $permitIsPdf ? 'pdf' : 'img' }}">
                        <i class="bi {{ $permitIsPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}"></i>
                    </div>
                    <div class="doc-info">
                        <div class="doc-name">Business Permit</div>
                        <div class="doc-meta">{{ strtoupper($permitExt) }} file &bull; {{ \Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->business_permit_path) > 0 ? round(\Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->business_permit_path) / 1024, 1) . ' KB' : 'Size unknown' }}</div>
                    </div>
                    <div class="doc-actions">
                        <a href="{{ asset('storage/' . $companyProfile->business_permit_path) }}" target="_blank" class="doc-btn doc-btn-view"><i class="bi bi-eye"></i> View</a>
                    </div>
                </div>
            @else
                <div class="doc-missing">
                    <i class="bi bi-file-earmark-x" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem; opacity: 0.6;"></i>
                    Business Permit not uploaded
                </div>
            @endif

            @if($hasDtiSec)
                @php
                    $dtiExt = pathinfo($companyProfile->dti_sec_registration_path, PATHINFO_EXTENSION);
                    $dtiIsPdf = strtolower($dtiExt) === 'pdf';
                @endphp
                <div class="doc-preview">
                    <div class="doc-icon {{ $dtiIsPdf ? 'pdf' : 'img' }}">
                        <i class="bi {{ $dtiIsPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}"></i>
                    </div>
                    <div class="doc-info">
                        <div class="doc-name">DTI/SEC Registration</div>
                        <div class="doc-meta">{{ strtoupper($dtiExt) }} file &bull; {{ \Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->dti_sec_registration_path) > 0 ? round(\Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->dti_sec_registration_path) / 1024, 1) . ' KB' : 'Size unknown' }}</div>
                    </div>
                    <div class="doc-actions">
                        <a href="{{ asset('storage/' . $companyProfile->dti_sec_registration_path) }}" target="_blank" class="doc-btn doc-btn-view"><i class="bi bi-eye"></i> View</a>
                    </div>
                </div>
            @else
                <div class="doc-missing">
                    <i class="bi bi-file-earmark-x" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem; opacity: 0.6;"></i>
                    DTI/SEC Registration not uploaded
                </div>
            @endif
        </div>

        <!-- Business Details Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Business Details</h3>
            </div>

            <div class="info-row">
                <div class="info-label">Office Type</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $companyProfile->office_type ?? 'N/A')) }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Employer Type</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $companyProfile->employer_type_detail ?? 'N/A')) }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Workforce Size</div>
                <div class="info-value">{{ ucfirst($companyProfile->workforce_size ?? 'N/A') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Line of Business</div>
                <div class="info-value">{{ $companyProfile->line_of_business ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Establishment Details Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Establishment Details</h3>
            </div>

            <div class="info-row">
                <div class="info-label">Address</div>
                <div class="info-value">
                    {{ trim(implode(', ', array_filter([
                        $companyProfile->street_village ?? null,
                        $companyProfile->barangay ?? null,
                        $companyProfile->city_municipality ?? null,
                        $companyProfile->province ?? null,
                    ]))) ?: 'N/A' }}
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Street / Village</div>
                <div class="info-value">{{ $companyProfile->street_village ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Barangay</div>
                <div class="info-value">{{ $companyProfile->barangay ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">City / Municipality</div>
                <div class="info-value">{{ $companyProfile->city_municipality ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Province</div>
                <div class="info-value">{{ $companyProfile->province ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Contact Details Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Contact Information</h3>
            </div>

            <div class="info-row">
                <div class="info-label">Contact Person (Owner/President)</div>
                <div class="info-value">{{ $companyProfile->establishment_contact_person ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Position</div>
                <div class="info-value">{{ $companyProfile->establishment_contact_position ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $companyProfile->establishment_email ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $companyProfile->establishment_phone ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">HR Contact Person</div>
                <div class="info-value">{{ $companyProfile->contact_person_name ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">HR Contact Phone</div>
                <div class="info-value">{{ $companyProfile->contact_person_phone ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Employer Info Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Employer Account</h3>
            </div>

            <div class="info-row">
                <div class="info-label">Account Name</div>
                <div class="info-value">{{ $companyProfile->employer->name ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Account Email</div>
                <div class="info-value">{{ $companyProfile->employer->email ?? 'N/A' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Registration Date</div>
                <div class="info-value">{{ $companyProfile->created_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($companyProfile->verification_status !== 'verified')
            <div class="detail-card">
                <div class="action-buttons">
                    <a href="{{ route('admin.employer-verification') }}" class="btn btn-back"><i class="bi bi-arrow-left me-1"></i>Back</a>

                    <form method="POST" action="{{ route('admin.employer-verification.approve', $companyProfile->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-approve" onclick="return confirm('Are you sure you want to approve this company profile?')"><i class="bi bi-check-lg me-1"></i>Approve</button>
                    </form>

                    <button type="button" class="btn btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="bi bi-x-lg me-1"></i>Reject</button>
                </div>
            </div>
        @else
            <div class="detail-card">
                <div class="action-buttons">
                    <a href="{{ route('admin.employer-verification') }}" class="btn btn-back"><i class="bi bi-arrow-left me-1"></i>Back</a>
                    <span style="color: #10b981; font-weight: 600;"><i class="bi bi-check-circle me-1"></i>This company profile is verified</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Company Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.employer-verification.reject', $companyProfile->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="verification_notes">Reason for Rejection</label>
                            <textarea id="verification_notes" name="verification_notes" rows="4" required placeholder="Please provide a reason for rejecting this company profile..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-reject">Reject Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</div>

@endsection
