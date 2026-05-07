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
        .verification-detail-wrapper { max-width: 1200px; margin: 0 auto; }
        
        /* Header Section */
        .verification-header { 
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .company-header-info { display: flex; align-items: center; gap: 1.5rem; flex: 1; }
        .company-logo-box {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 8px 16px rgba(215, 38, 56, 0.2);
        }

        .company-logo-box img { width: 100%; height: 100%; object-fit: cover; }
        .company-logo-box-placeholder { 
            color: white;
            font-size: 48px;
            font-weight: 800;
        }

        .company-header-text h2 { 
            margin: 0 0 0.5rem 0;
            font-size: 28px;
            font-weight: 800;
            color: #0d1f3c;
        }

        .company-header-text p { 
            margin: 0.25rem 0;
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
        }

        .company-status-box { display: flex; flex-direction: column; align-items: flex-end; gap: 1rem; }
        .verification-status-display {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            gap: 0.5rem;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-under-review { background: #dbeafe; color: #1e40af; }
        .status-verified { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        /* Layout */
        .content-grid { display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }

        /* Cards */
        .detail-card {
            background: white;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
            margin-bottom: 2rem;
        }

        .detail-card h3 {
            margin: 0 0 1.5rem 0;
            font-size: 16px;
            font-weight: 800;
            color: #0d1f3c;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1.25rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .detail-card h3 i { 
            font-size: 18px;
            color: #d72638;
        }

        .info-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section:last-child { margin-bottom: 0; }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 14px;
            color: #0d1f3c;
            font-weight: 600;
        }

        /* Documents */
        .documents-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .doc-item {
            display: flex;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .doc-item:hover {
            border-color: #d72638;
            box-shadow: 0 4px 12px rgba(215, 38, 56, 0.1);
        }

        .doc-icon {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            color: white;
        }

        .doc-content { flex: 1; }
        .doc-name { font-weight: 700; color: #0d1f3c; font-size: 14px; margin-bottom: 0.25rem; }
        .doc-meta { font-size: 12px; color: #6b7280; }

        .doc-action { 
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .doc-action:hover { 
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .doc-missing {
            padding: 2rem;
            text-align: center;
            color: #9ca3af;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 12px;
            border: 2px dashed #d1d5db;
        }

        .doc-missing i { font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 0.5rem; }

        /* Sidebar */
        .verification-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-card {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .sidebar-card h4 {
            margin: 0 0 1rem 0;
            font-size: 14px;
            font-weight: 700;
            color: #0d1f3c;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-info-item {
            margin-bottom: 1.25rem;
        }

        .sidebar-info-item:last-child { margin-bottom: 0; }
        .sidebar-label { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; }
        .sidebar-value { font-size: 13px; color: #0d1f3c; font-weight: 600; }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-action {
            padding: 0.9rem 1.25rem;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-approve {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
        }

        .btn-back {
            background: #f3f4f6;
            color: #0d1f3c;
            box-shadow: none;
        }

        .btn-back:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        /* Verified State */
        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
            border: 2px solid #10b981;
            border-radius: 10px;
            color: #065f46;
            font-weight: 700;
            font-size: 13px;
            text-align: center;
            width: 100%;
            justify-content: center;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .form-group label {
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #334155;
            margin-bottom: 0.75rem;
        }

        .form-group textarea {
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 0.9rem;
            font-size: 14px;
            resize: vertical;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #d72638;
            box-shadow: 0 0 0 4px rgba(215, 38, 56, 0.1);
        }

        @media (max-width: 768px) {
            .verification-header { flex-direction: column; }
            .company-status-box { align-items: flex-start; width: 100%; }
            .content-grid { grid-template-columns: 1fr; }
            .info-section { grid-template-columns: 1fr; }
        }
    </style>

    <div class="verification-detail-wrapper">
        <!-- Header Section -->
        <div class="verification-header">
            <div class="company-header-info">
                <div class="company-logo-box">
                    @if($companyProfile->logo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->logo_path))
                        <img src="{{ asset('storage/' . $companyProfile->logo_path) }}" alt="Company Logo">
                    @else
                        <span class="company-logo-box-placeholder">{{ strtoupper(substr($companyProfile->company_name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="company-header-text">
                    <h2>{{ $companyProfile->company_name }}</h2>
                    <p><strong>Business Name:</strong> {{ $companyProfile->business_name ?? 'N/A' }}</p>
                    <p><strong>TIN:</strong> {{ $companyProfile->tin ?? 'N/A' }}</p>
                    <p><strong>Registered:</strong> {{ $companyProfile->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="company-status-box">
                <div class="verification-status-display {{ 'status-' . $companyProfile->verification_status }}">
                    @if($companyProfile->verification_status === 'pending')
                        <i class="bi bi-hourglass-split"></i>Pending
                    @elseif($companyProfile->verification_status === 'under_review')
                        <i class="bi bi-search"></i>Under Review
                    @elseif($companyProfile->verification_status === 'verified')
                        <i class="bi bi-check-circle-fill"></i>Verified
                    @else
                        <i class="bi bi-x-circle-fill"></i>Rejected
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column: Details -->
            <div>
                <!-- Basic Information -->
                <div class="detail-card">
                    <h3><i class="bi bi-info-circle"></i> Company Information</h3>
                    <div class="info-section">
                        <div class="info-item">
                            <span class="info-label">Trade Name</span>
                            <span class="info-value">{{ $companyProfile->trade_name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Acronym</span>
                            <span class="info-value">{{ $companyProfile->acronym_abbreviation ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Office Type</span>
                            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $companyProfile->office_type ?? 'N/A')) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Employer Type</span>
                            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $companyProfile->employer_type_detail ?? 'N/A')) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Workforce Size</span>
                            <span class="info-value">{{ ucfirst($companyProfile->workforce_size ?? 'N/A') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Line of Business</span>
                            <span class="info-value">{{ $companyProfile->line_of_business ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Verification Documents -->
                <div class="detail-card">
                    <h3><i class="bi bi-file-earmark"></i> Verification Documents</h3>
                    <div class="documents-section">
                        @php
                            $hasBusinessPermit = $companyProfile->business_permit_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->business_permit_path);
                            $hasDtiSec = $companyProfile->dti_sec_registration_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyProfile->dti_sec_registration_path);
                        @endphp

                        @if($hasBusinessPermit)
                            @php
                                $permitExt = pathinfo($companyProfile->business_permit_path, PATHINFO_EXTENSION);
                                $permitIsPdf = strtolower($permitExt) === 'pdf';
                            @endphp
                            <div class="doc-item">
                                <div class="doc-icon">
                                    <i class="bi {{ $permitIsPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}"></i>
                                </div>
                                <div class="doc-content">
                                    <div class="doc-name">Business Permit</div>
                                    <div class="doc-meta">{{ strtoupper($permitExt) }} • {{ round(\Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->business_permit_path) / 1024, 1) }} KB</div>
                                </div>
                                <a href="{{ asset('storage/' . $companyProfile->business_permit_path) }}" target="_blank" class="doc-action">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        @else
                            <div class="doc-missing">
                                <i class="bi bi-file-earmark-x"></i>
                                Business Permit not uploaded
                            </div>
                        @endif

                        @if($hasDtiSec)
                            @php
                                $dtiExt = pathinfo($companyProfile->dti_sec_registration_path, PATHINFO_EXTENSION);
                                $dtiIsPdf = strtolower($dtiExt) === 'pdf';
                            @endphp
                            <div class="doc-item">
                                <div class="doc-icon">
                                    <i class="bi {{ $dtiIsPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}"></i>
                                </div>
                                <div class="doc-content">
                                    <div class="doc-name">DTI/SEC Registration</div>
                                    <div class="doc-meta">{{ strtoupper($dtiExt) }} • {{ round(\Illuminate\Support\Facades\Storage::disk('public')->size($companyProfile->dti_sec_registration_path) / 1024, 1) }} KB</div>
                                </div>
                                <a href="{{ asset('storage/' . $companyProfile->dti_sec_registration_path) }}" target="_blank" class="doc-action">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        @else
                            <div class="doc-missing">
                                <i class="bi bi-file-earmark-x"></i>
                                DTI/SEC Registration not uploaded
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Address & Contact -->
                <div class="detail-card">
                    <h3><i class="bi bi-geo-alt"></i> Location & Contact</h3>
                    <div class="info-section">
                        <div class="info-item">
                            <span class="info-label">Street / Village</span>
                            <span class="info-value">{{ $companyProfile->street_village ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Barangay</span>
                            <span class="info-value">{{ $companyProfile->barangay ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">City / Municipality</span>
                            <span class="info-value">{{ $companyProfile->city_municipality ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Province</span>
                            <span class="info-value">{{ $companyProfile->province ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Contact Person</span>
                            <span class="info-value">{{ $companyProfile->establishment_contact_person ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Position</span>
                            <span class="info-value">{{ $companyProfile->establishment_contact_position ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value"><a href="mailto:{{ $companyProfile->establishment_email }}" style="color: #3b82f6; text-decoration: none;">{{ $companyProfile->establishment_email ?? 'N/A' }}</a></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $companyProfile->establishment_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="verification-sidebar">
                <!-- Employer Account Info -->
                <div class="sidebar-card">
                    <h4><i class="bi bi-person-circle"></i> Employer Account</h4>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">Account Name</div>
                        <div class="sidebar-value">{{ $companyProfile->employer->name ?? 'N/A' }}</div>
                    </div>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">Email</div>
                        <div class="sidebar-value"><a href="mailto:{{ $companyProfile->employer->email }}" style="color: #3b82f6;">{{ $companyProfile->employer->email ?? 'N/A' }}</a></div>
                    </div>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">Registration Date</div>
                        <div class="sidebar-value">{{ $companyProfile->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">Last Updated</div>
                        <div class="sidebar-value">{{ $companyProfile->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                <!-- HR Contact -->
                <div class="sidebar-card">
                    <h4><i class="bi bi-telephone"></i> HR Contact</h4>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">HR Person</div>
                        <div class="sidebar-value">{{ $companyProfile->contact_person_name ?? 'N/A' }}</div>
                    </div>
                    <div class="sidebar-info-item">
                        <div class="sidebar-label">HR Phone</div>
                        <div class="sidebar-value">{{ $companyProfile->contact_person_phone ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Actions -->
                @if($companyProfile->verification_status !== 'verified')
                    <div class="sidebar-card">
                        <h4><i class="bi bi-check-square"></i> Verification</h4>
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('admin.employer-verification.approve', $companyProfile->id) }}" style="display: flex; width: 100%;">
                                @csrf
                                <button type="submit" class="btn-action btn-approve" style="flex: 1;" onclick="return confirm('Approve this company profile?')">
                                    <i class="bi bi-check-circle"></i> Approve
                                </button>
                            </form>
                            <button type="button" class="btn-action btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal" style="flex: 1;">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                            <a href="{{ route('admin.employer-verification') }}" class="btn-action btn-back" style="flex: 1; justify-content: center;">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                @else
                    <div class="sidebar-card">
                        <div class="verified-badge">
                            <i class="bi bi-check-circle-fill"></i>
                            Profile Verified
                        </div>
                        <a href="{{ route('admin.employer-verification') }}" class="btn-action btn-back" style="margin-top: 1rem;">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                @endif
            </div>
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
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</div>

@endsection
