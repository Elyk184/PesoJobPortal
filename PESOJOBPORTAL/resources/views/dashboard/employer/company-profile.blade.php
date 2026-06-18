@extends('dashboard.employer.layout')

@section('title', 'Company Profile - PESO')
@section('hide_header', true)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
    .container {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .profile-wrapper {
        display: block;
        width: 100%;
        min-height: calc(100vh - 180px);
        background: #f5f8fb;
    }
    .profile-sidebar {
        display: none;
    }
    .profile-content {
        width: 100%;
        padding-right: 360px;
        padding-top: 10px;
        padding-bottom: 24px;
    }
    .profile-content > form {
        width: 100%;
        display: grid;
        gap: 16px;
    }

    .profile-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 24px;
        background: #ffffff;
        border: 1px solid #d8e5f1;
        border-left: 6px solid #0f766e;
        border-radius: 14px;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.07);
    }

    .profile-hero-title {
        margin: 0;
        color: #10243f;
        font-size: 1.55rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .profile-hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .profile-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 999px;
        background: #eef7f6;
        color: #0f5f58;
        border: 1px solid #cce7e3;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .profile-chip.is-muted {
        background: #f4f7fb;
        color: #475569;
        border-color: #d8e1ea;
    }

    .profile-hero-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .profile-nav {
        position: sticky;
        top: 24px;
    }
    .profile-nav .nav-link {
        display: block;
        color: #6c757d;
        padding: 10px 15px;
        border-left: 3px solid transparent;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .profile-nav .nav-link:hover {
        color: #2d5aa0;
        background-color: #e9ecef;
    }
    .profile-nav .nav-link.active {
        color: #2d5aa0;
        border-left-color: #2d5aa0;
        background-color: #e9ecef;
    }
    .form-section {
        scroll-margin-top: 100px;
        margin: 0;
        padding: 20px;
        background: var(--panel, #fff);
        border: 1px solid var(--line, #dbe4ee);
        border-radius: 14px;
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.05);
        transition: box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .form-section:hover {
        border-color: #c2d7ea;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
    }
    .profile-content .header.panel {
        margin-left: 0;
        margin-right: 0;
        border-radius: 14px;
        margin-bottom: 0;
    }
    .section-heading {
        font-size: 18px;
        font-weight: 800;
        color: #10243f;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #dbe8f5;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-heading i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eef7f6;
        color: #0f766e;
        font-size: 17px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }

    .form-control-custom,
    .form-control,
    .form-select {
        border-radius: 12px;
        border: 1px solid #cdd9e5;
        padding: 11px 12px;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        background: #fbfdff;
        color: #10243f;
    }

    .form-control-custom:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14);
        background: #ffffff;
    }

    textarea.form-control-custom {
        min-height: 118px;
        resize: vertical;
    }

    .form-error-custom {
        margin-top: 6px;
        color: #b91c1c;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 16px;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-auth-custom,
    .btn-primary-solid {
        background: linear-gradient(135deg, #0f766e 0%, #0ea5a8 100%);
        color: #ffffff;
        border: 1px solid #0f766e;
        box-shadow: 0 10px 18px rgba(15, 118, 110, 0.2);
    }

    .btn-auth-custom:hover,
    .btn-primary-solid:hover {
        background: linear-gradient(135deg, #0d6a63 0%, #0d9597 100%);
        color: #ffffff;
        box-shadow: 0 14px 22px rgba(15, 118, 110, 0.28);
    }

    .btn-secondary-outline {
        border: 1px solid #94a3b8;
        color: #334155;
        background: #ffffff;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
    }

    .btn-secondary-outline:hover {
        border-color: #64748b;
        color: #0f172a;
        background: #f8fafc;
        box-shadow: 0 10px 18px rgba(15, 23, 42, 0.14);
    }

    .btn-outline-primary {
        border-color: #2563eb;
        color: #1d4ed8;
        background: #eff6ff;
        font-weight: 700;
    }

    .btn-outline-primary:hover {
        border-color: #1d4ed8;
        color: #ffffff;
        background: #1d4ed8;
    }

    .profile-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 14px;
        margin-top: 4px;
        padding: 14px 16px;
        background: #ffffff;
        border: 1px solid #dbe4ee;
        border-radius: 14px;
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.06);
    }

    .profile-actions .btn {
        width: 220px;
        justify-content: center;
    }

    .alert {
        border-radius: 12px;
        border-width: 1px;
    }

    .workforce-card {
        position: relative;
        display: block;
        height: 100%;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #d6e0ea;
        background: #fbfdff;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .workforce-card input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .workforce-card:has(input:checked) {
        border-color: #0f766e;
        background: #eef7f6;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
    }

    .workforce-buttons {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .workforce-name {
        color: #10243f;
        font-size: 0.98rem;
        font-weight: 800;
    }

    .workforce-range {
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 700;
        margin-top: 2px;
    }

    .workforce-card:hover {
        border-color: #93c5fd;
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        transform: translateY(-1px);
    }

    .office-type-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .office-type-group .form-check,
    .employer-type-container .form-check {
        margin: 0;
        padding: 10px 12px 10px 36px;
        border: 1px solid #d6e0ea;
        border-radius: 12px;
        background: #fbfdff;
    }

    .office-type-group .form-check-input,
    .employer-type-container .form-check-input {
        margin-left: -24px;
    }

    .office-type-group .form-check:has(.form-check-input:checked),
    .employer-type-container .form-check:has(.form-check-input:checked) {
        border-color: #0f766e;
        background: #eef7f6;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
    }

    .employer-type-container {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .employer-type-column {
        padding: 14px;
        border: 1px solid #dbe4ee;
        border-radius: 14px;
        background: #f8fbff;
    }

    .employer-type-column .form-check + .form-check {
        margin-top: 9px;
    }

    .employer-type-heading {
        margin-bottom: 10px;
        color: #0f4c8a;
        font-size: 0.78rem;
        font-weight: 900;
        letter-spacing: 0.08em;
    }

    .profile-completion-summary {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border: 1px solid #cddff5;
        position: fixed;
        top: 110px;
        right: 24px;
        width: 330px;
        z-index: 90;
        max-height: calc(100vh - 140px);
        overflow-y: auto;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.09);
    }

    .completion-meta {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }

    .completion-percent {
        font-size: 1.9rem;
        font-weight: 800;
        color: #0f4c8a;
        line-height: 1;
    }

    .completion-text {
        font-size: 0.92rem;
        color: #475569;
        font-weight: 600;
    }

    .completion-progress {
        height: 10px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .completion-progress .progress-bar {
        background: linear-gradient(90deg, #0f766e 0%, #0ea5a8 60%, #22c55e 100%);
        transition: width 0.25s ease;
    }

    .completion-status {
        margin: 0;
        font-size: 0.92rem;
        color: #334155;
        font-weight: 500;
    }

    .missing-fields-list {
        margin-top: 8px;
        padding-left: 1.1rem;
    }

    .missing-fields-list li + li {
        margin-top: 4px;
    }

    .missing-field-link {
        color: #9f1239;
        font-weight: 600;
        text-decoration: none;
    }

    .missing-field-link:hover {
        text-decoration: underline;
    }

    .field-missing {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.14) !important;
        background-color: #fff9f9;
    }

    .workforce-card.field-missing {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.14);
    }

    @media (max-width: 992px) {
        .profile-wrapper {
            min-height: auto;
        }

        .profile-content {
            padding-right: 0;
            padding-top: 0;
        }

        .profile-hero {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-hero-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .profile-completion-summary {
            position: static;
            top: auto;
            right: auto;
            width: 100%;
            max-height: none;
            overflow-y: visible;
        }

        .form-section {
            padding: 14px;
        }

        .workforce-buttons,
        .employer-type-container {
            grid-template-columns: 1fr;
        }

        .btn {
            width: 100%;
        }

        .profile-actions {
            flex-direction: column;
        }

        .profile-actions .btn {
            width: 100%;
            max-width: 320px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    <div class="profile-content">
        <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="logo_only" name="logo_only" value="0">

            <div class="profile-hero">
                <div>
                    <h1 class="profile-hero-title">{{ $companyProfile?->company_name ?? $companyProfile?->business_name ?? $user->name ?? 'Company Profile' }}</h1>
                    <div class="profile-hero-meta">
                        <span class="profile-chip">
                            <i class="bi bi-building-check"></i>
                            {{ $companyProfile?->verification_status ? ucwords(str_replace('_', ' ', $companyProfile->verification_status)) : 'Pending' }}
                        </span>
                        <span class="profile-chip is-muted">
                            <i class="bi bi-envelope"></i>
                            {{ $companyProfile?->establishment_email ?? $user->email ?? 'No email yet' }}
                        </span>
                    </div>
                </div>
                <div class="profile-hero-actions">
                    <a href="{{ route('employer.company-profile.download') }}" class="btn btn-outline-primary">
                        <i class="bi bi-download me-2"></i>Download PDF
                    </a>
                    <button type="submit" class="btn btn-primary-solid">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success m-3 mb-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @php
                $requiredProfileFields = [
                    ['key' => 'name', 'label' => 'Full Name', 'section' => 'account-info-section', 'filled' => filled(old('name', $user->name ?? null))],
                    ['key' => 'email', 'label' => 'Email Address', 'section' => 'account-info-section', 'filled' => filled(old('email', $user->email ?? null))],
                    ['key' => 'business_name', 'label' => 'Business Name', 'section' => 'establishment-details-section', 'filled' => filled(old('business_name', $companyProfile->business_name ?? null))],
                    ['key' => 'company_information', 'label' => 'Company Information', 'section' => 'establishment-details-section', 'filled' => filled(old('company_information', $companyProfile->company_information ?? null))],
                    ['key' => 'established_year', 'label' => 'Year Established', 'section' => 'establishment-details-section', 'filled' => filled(old('established_year', $companyProfile->established_year ?? null))],
                    ['key' => 'trade_name', 'label' => 'Trade Name', 'section' => 'establishment-details-section', 'filled' => filled(old('trade_name', $companyProfile->trade_name ?? null))],
                    ['key' => 'acronym_abbreviation', 'label' => 'Acronym / Abbreviation', 'section' => 'establishment-details-section', 'filled' => filled(old('acronym_abbreviation', $companyProfile->acronym_abbreviation ?? null))],
                    ['key' => 'office_type', 'label' => 'Office Type', 'section' => 'establishment-details-section', 'filled' => filled(old('office_type', $companyProfile->office_type ?? (empty($companyProfile) ? 'main_office' : null)))],
                    ['key' => 'tin', 'label' => 'Tax Identification Number (TIN)', 'section' => 'establishment-details-section', 'filled' => filled(old('tin', $companyProfile->tin ?? null))],
                    ['key' => 'employer_type_detail', 'label' => 'Employer Type', 'section' => 'establishment-details-section', 'filled' => filled(old('employer_type_detail', $companyProfile->employer_type_detail ?? null))],
                    ['key' => 'workforce_size', 'label' => 'Total Work Force', 'section' => 'establishment-details-section', 'filled' => filled(old('workforce_size', $companyProfile->workforce_size ?? null))],
                    ['key' => 'line_of_business', 'label' => 'Line of Business / Industry', 'section' => 'establishment-details-section', 'filled' => filled(old('line_of_business', $companyProfile->line_of_business ?? null))],
                    ['key' => 'street_village', 'label' => 'Street / Village', 'section' => 'establishment-details-section', 'filled' => filled(old('street_village', $companyProfile->street_village ?? null))],
                    ['key' => 'barangay', 'label' => 'Barangay', 'section' => 'establishment-details-section', 'filled' => filled(old('barangay', $companyProfile->barangay ?? null))],
                    ['key' => 'city_municipality', 'label' => 'Municipal / City', 'section' => 'establishment-details-section', 'filled' => filled(old('city_municipality', $companyProfile->city_municipality ?? null))],
                    ['key' => 'province', 'label' => 'Province', 'section' => 'establishment-details-section', 'filled' => filled(old('province', $companyProfile->province ?? null))],
                    ['key' => 'establishment_contact_person', 'label' => 'Name of Owner / President', 'section' => 'contact-details-section', 'filled' => filled(old('establishment_contact_person', $companyProfile->establishment_contact_person ?? null))],
                    ['key' => 'contact_person_name', 'label' => 'Contact Person', 'section' => 'contact-details-section', 'filled' => filled(old('contact_person_name', $companyProfile->contact_person_name ?? null))],
                    ['key' => 'establishment_contact_position', 'label' => 'Position', 'section' => 'contact-details-section', 'filled' => filled(old('establishment_contact_position', $companyProfile->establishment_contact_position ?? null))],
                    ['key' => 'establishment_phone', 'label' => 'Telephone Number', 'section' => 'contact-details-section', 'filled' => filled(old('establishment_phone', $companyProfile->establishment_phone ?? null))],
                    ['key' => 'contact_person_phone', 'label' => 'Mobile Number', 'section' => 'contact-details-section', 'filled' => filled(old('contact_person_phone', $companyProfile->contact_person_phone ?? null))],
                    ['key' => 'establishment_email', 'label' => 'E-mail Address', 'section' => 'contact-details-section', 'filled' => filled(old('establishment_email', $companyProfile->establishment_email ?? null))],
                    // Username is optional and not included in required profile fields
                ];

                $requiredCount = count($requiredProfileFields);
                $completedCount = collect($requiredProfileFields)->where('filled', true)->count();
                $completionPercent = $requiredCount > 0 ? (int) round(($completedCount / $requiredCount) * 100) : 0;
                $missingProfileFields = array_values(array_filter($requiredProfileFields, fn ($field) => !$field['filled']));
            @endphp

            <div id="profile-completion-section" class="form-section profile-completion-summary">
                <h5 class="section-heading"><i class="fas fa-chart-pie"></i> Profile Completion</h5>
                <div class="completion-meta">
                    <span id="completionPercentText" class="completion-percent">{{ $completionPercent }}%</span>
                    <span id="completionCountText" class="completion-text">{{ $completedCount }} of {{ $requiredCount }} required fields completed</span>
                </div>
                <div class="progress completion-progress" role="progressbar" aria-label="Profile completion" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $completionPercent }}">
                    <div id="completionProgressBar" class="progress-bar" style="width: {{ $completionPercent }}%"></div>
                </div>
                <p id="completionStatusText" class="completion-status">
                    {{ empty($missingProfileFields) ? 'Great job. Your required company profile fields are complete.' : 'Please complete the missing required fields listed below.' }}
                </p>

                <div id="missingFieldsReminder" class="alert alert-warning mt-3 mb-0 {{ empty($missingProfileFields) ? 'd-none' : '' }}">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Missing required fields:</strong>
                    <ul id="missingFieldsList" class="missing-fields-list mb-0">
                        @foreach($missingProfileFields as $missingField)
                            <li data-field="{{ $missingField['key'] }}">
                                <a href="#{{ $missingField['section'] }}" class="missing-field-link" data-scroll-target="{{ $missingField['section'] }}" data-field="{{ $missingField['key'] }}">
                                    {{ $missingField['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Company Logo Section -->
            <div id="company-logo-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-image"></i> Company Logo</h5>
                <div class="text-center mb-3">
                    @php
                        $hasCompanyLogo = $companyProfile && $companyProfile->logo_path && Storage::disk('public')->exists($companyProfile->logo_path);
                    @endphp
                    @if($hasCompanyLogo)
                    <img src="{{ asset('storage/' . $companyProfile->logo_path) }}" alt="Company Logo" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #2d5aa0;">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px; background: #e9ecef; border: 3px dashed #2d5aa0;">
                            <i class="bi bi-building" style="font-size: 5rem; color: #6c757d;"></i>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <label for="company_logo" class="btn btn-auth-custom d-inline-flex align-items-center justify-content-center" style="width: auto; padding: 10px 25px; cursor: pointer;">
                        <i class="bi bi-upload me-2"></i><span id="logo-label">{{ $hasCompanyLogo ? 'Change Logo' : 'Upload Logo' }}</span>
                    </label>
                    <input type="file" id="company_logo" name="company_logo" accept=".jpg,.jpeg,.png,.gif" style="display: none;" onchange="handleCompanyLogoChange(this)">
                    <small class="d-block text-muted mt-2">JPG, PNG, GIF (max 10MB). Logo uploads right after file selection.</small>
                </div>
            </div>

            <!-- Employer Verification Documents Section -->
            <div id="verification-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-shield-alt"></i> Employer Verification Documents</h5>
                <div class="mb-4">
                    @if($companyProfile && $companyProfile->verification_status == 'verified')
                    <div class="alert alert-success mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Verified Employer</strong> - Your company has been verified.
                    </div>
                    @elseif($companyProfile && $companyProfile->verification_status == 'under_review')
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-hourglass-split me-2"></i>
                        <strong>Under Review</strong> - Your documents are being reviewed (2-3 business days).
                    </div>
                    @elseif($companyProfile && $companyProfile->verification_status == 'rejected')
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <strong>Verification Rejected</strong>
                        @if($companyProfile->verification_notes)
                            <br><small>Reason: {{ $companyProfile->verification_notes }}</small>
                        @endif
                    </div>
                    @else
                    <div class="alert alert-warning mb-4">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <strong>Pending Verification</strong> - Upload your documents to get verified.
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">
                            <i class="bi bi-file-earmark-text me-2"></i>Business Permit
                            @if($companyProfile && $companyProfile->business_permit_path)
                                <span class="text-success ms-2"><i class="bi bi-check-circle-fill"></i> Uploaded</span>
                            @endif
                        </label>
                        @if($companyProfile && $companyProfile->business_permit_path)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $companyProfile->business_permit_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View Current
                            </a>
                        </div>
                        @endif
                        <input type="file" class="form-control form-control-custom" name="business_permit" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">PDF, JPG, PNG (max 5MB)</small>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-custom">
                            <i class="bi bi-file-earmark-ruled me-2"></i>DTI/SEC Registration
                            @if($companyProfile && $companyProfile->dti_sec_registration_path)
                                <span class="text-success ms-2"><i class="bi bi-check-circle-fill"></i> Uploaded</span>
                            @endif
                        </label>
                        @if($companyProfile && $companyProfile->dti_sec_registration_path)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $companyProfile->dti_sec_registration_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View Current
                            </a>
                        </div>
                        @endif
                        <input type="file" class="form-control form-control-custom" name="dti_sec_registration" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">PDF, JPG, PNG (max 5MB)</small>
                    </div>
                </div>

                @if(!$companyProfile || $companyProfile->verification_status !== 'verified')
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Upload documents for verification (2-3 business days review)
                </div>
                @endif
            </div>

            <!-- Account Information Section -->
            <div id="account-info-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-user-circle"></i> Account Information</h5>
                <div class="mb-4">
                    <label for="name" class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required autofocus
                           placeholder="Your full name">
                    @error('name')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                           placeholder="your.email@company.com">
                    @error('email')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Establishment Details Section -->
            <div id="establishment-details-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-building"></i> Establishment Details</h5>
                <div class="mb-4">
                    <label for="business_name" class="form-label-custom">Business Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('business_name') is-invalid @enderror"
                           id="business_name" name="business_name" value="{{ old('business_name', $companyProfile->business_name ?? '') }}"
                           placeholder="Registered business name" required>
                    @error('business_name')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="company_information" class="form-label-custom">Company Information <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-custom @error('company_information') is-invalid @enderror"
                              id="company_information" name="company_information" rows="4"
                              placeholder="Briefly describe your company, services, products, or operations" required>{{ old('company_information', $companyProfile->company_information ?? '') }}</textarea>
                    @error('company_information')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="established_year" class="form-label-custom">Year Established <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-custom @error('established_year') is-invalid @enderror"
                           id="established_year" name="established_year" value="{{ old('established_year', $companyProfile->established_year ?? '') }}"
                           placeholder="e.g. 2018" min="1900" max="{{ now()->year }}" required>
                    @error('established_year')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="trade_name" class="form-label-custom">Trade Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('trade_name') is-invalid @enderror"
                                   id="trade_name" name="trade_name" value="{{ old('trade_name', $companyProfile->trade_name ?? '') }}"
                                   placeholder="Trade or brand name" required>
                            @error('trade_name')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="acronym_abbreviation" class="form-label-custom">Acronym / Abbreviation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('acronym_abbreviation') is-invalid @enderror"
                                   id="acronym_abbreviation" name="acronym_abbreviation" value="{{ old('acronym_abbreviation', $companyProfile->acronym_abbreviation ?? '') }}"
                                   placeholder="e.g. DMPI" required>
                            @error('acronym_abbreviation')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label-custom">Office Type <span class="text-danger">*</span></label>
                            <div class="office-type-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="office_type" id="main_office" value="main_office" {{ old('office_type', $companyProfile->office_type ?? '') == 'main_office' ? 'checked' : (empty($companyProfile) ? 'checked' : '') }} required>
                                    <label class="form-check-label" for="main_office">Main Office</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="office_type" id="branch" value="branch" {{ old('office_type', $companyProfile->office_type ?? '') == 'branch' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="branch">Branch</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="tin" class="form-label-custom">Tax Identification Number (TIN) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('tin') is-invalid @enderror"
                                   id="tin" name="tin" value="{{ old('tin', $companyProfile->tin ?? '') }}"
                                   placeholder="000-000-000-000" required>
                            @error('tin')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">
                        Employer Type
                        <span class="text-danger">*</span>
                    </label>
                    <div class="employer-type-container">
                        <div class="employer-type-column">
                            <div class="employer-type-heading">PUBLIC</div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="national_gov" value="national_gov" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'national_gov' ? 'checked' : '' }}>
                                <label class="form-check-label" for="national_gov">National Government Agency</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="local_gov" value="local_gov" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'local_gov' ? 'checked' : '' }}>
                                <label class="form-check-label" for="local_gov">Local Government Unit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="gocc" value="gocc" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'gocc' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gocc">Government-owned and Controlled Corporation</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="state_college" value="state_college" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'state_college' ? 'checked' : '' }}>
                                <label class="form-check-label" for="state_college">State/Local University or College</label>
                            </div>
                        </div>
                        <div class="employer-type-column">
                            <div class="employer-type-heading">PRIVATE</div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="direct_hire" value="direct_hire" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'direct_hire' ? 'checked' : '' }}>
                                <label class="form-check-label" for="direct_hire">Direct Hire</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="local_recruitment" value="local_recruitment" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'local_recruitment' ? 'checked' : '' }}>
                                <label class="form-check-label" for="local_recruitment">Local Recruitment Agency</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="overseas_recruitment" value="overseas_recruitment" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'overseas_recruitment' ? 'checked' : '' }}>
                                <label class="form-check-label" for="overseas_recruitment">Overseas Recruitment Agency</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="employer_type_detail" id="do174" value="do174" {{ old('employer_type_detail', $companyProfile->employer_type_detail ?? '') == 'do174' ? 'checked' : '' }}>
                                <label class="form-check-label" for="do174">D.O. 174</label>
                            </div>
                        </div>
                    </div>
                    @error('employer_type_detail')
                        <div class="form-error-custom mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">
                        Total Work Force
                        <span class="text-danger">*</span>
                    </label>
                    <div class="workforce-buttons">
                        <label class="workforce-card">
                            <input type="radio" name="workforce_size" value="micro" {{ old('workforce_size', $companyProfile->workforce_size ?? '') == 'micro' ? 'checked' : '' }} required>
                            <div class="workforce-content">
                                <div class="workforce-name">Micro</div>
                                <div class="workforce-range">1-9</div>
                            </div>
                        </label>
                        <label class="workforce-card">
                            <input type="radio" name="workforce_size" value="small" {{ old('workforce_size', $companyProfile->workforce_size ?? '') == 'small' ? 'checked' : '' }}>
                            <div class="workforce-content">
                                <div class="workforce-name">Small</div>
                                <div class="workforce-range">10-99</div>
                            </div>
                        </label>
                        <label class="workforce-card">
                            <input type="radio" name="workforce_size" value="medium" {{ old('workforce_size', $companyProfile->workforce_size ?? '') == 'medium' ? 'checked' : '' }}>
                            <div class="workforce-content">
                                <div class="workforce-name">Medium</div>
                                <div class="workforce-range">100-199</div>
                            </div>
                        </label>
                        <label class="workforce-card">
                            <input type="radio" name="workforce_size" value="large" {{ old('workforce_size', $companyProfile->workforce_size ?? '') == 'large' ? 'checked' : '' }}>
                            <div class="workforce-content">
                                <div class="workforce-name">Large</div>
                                <div class="workforce-range">200 and up</div>
                            </div>
                        </label>
                    </div>
                    @error('workforce_size')
                        <div class="form-error-custom mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="line_of_business" class="form-label-custom">
                        Line of Business / Industry
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-custom @error('line_of_business') is-invalid @enderror"
                           id="line_of_business" name="line_of_business" value="{{ old('line_of_business', $companyProfile->line_of_business ?? '') }}"
                           placeholder="e.g. Food Processing, BPO, Construction" required>
                    @error('line_of_business')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="street_village" class="form-label-custom">
                        Street / Village
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-custom @error('street_village') is-invalid @enderror"
                           id="street_village" name="street_village" value="{{ old('street_village', $companyProfile->street_village ?? '') }}"
                           placeholder="House no., street name, subdivision/village" required>
                    @error('street_village')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="barangay" class="form-label-custom">
                                Barangay
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-custom @error('barangay') is-invalid @enderror"
                                   id="barangay" name="barangay" value="{{ old('barangay', $companyProfile->barangay ?? '') }}"
                                   placeholder="Barangay" required>
                            @error('barangay')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="city_municipality" class="form-label-custom">
                                Municipal / City
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-custom @error('city_municipality') is-invalid @enderror"
                                   id="city_municipality" name="city_municipality" value="{{ old('city_municipality', $companyProfile->city_municipality ?? '') }}"
                                   placeholder="Municipality or city" required>
                            @error('city_municipality')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="province" class="form-label-custom">
                        Province
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-custom @error('province') is-invalid @enderror"
                           id="province" name="province" value="{{ old('province', $companyProfile->province ?? '') }}"
                           placeholder="Province" required>
                    @error('province')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Establishment Contact Details Section -->
            <div id="contact-details-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-address-book"></i> Establishment Contact Details</h5>
                <div class="mb-4">
                    <label for="establishment_contact_person" class="form-label-custom">Name of Owner / President <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('establishment_contact_person') is-invalid @enderror"
                           id="establishment_contact_person" name="establishment_contact_person"
                           value="{{ old('establishment_contact_person', $companyProfile->establishment_contact_person ?? '') }}"
                           placeholder="Full name of owner or president" required>
                    @error('establishment_contact_person')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="establishment_contact_name" class="form-label-custom">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('contact_person_name') is-invalid @enderror"
                                   id="establishment_contact_name" name="contact_person_name"
                                   value="{{ old('contact_person_name', $companyProfile->contact_person_name ?? '') }}"
                                   placeholder="Full name" required>
                            @error('contact_person_name')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="establishment_contact_position" class="form-label-custom">Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('establishment_contact_position') is-invalid @enderror"
                                   id="establishment_contact_position" name="establishment_contact_position"
                                   value="{{ old('establishment_contact_position', $companyProfile->establishment_contact_position ?? '') }}"
                                   placeholder="e.g. HR Manager" required>
                            @error('establishment_contact_position')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="establishment_phone" class="form-label-custom">Telephone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-custom @error('establishment_phone') is-invalid @enderror"
                                   id="establishment_phone" name="establishment_phone"
                                   value="{{ old('establishment_phone', $companyProfile->establishment_phone ?? '') }}"
                                   placeholder="(088) 000-0000" required>
                            @error('establishment_phone')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="contact_person_phone" class="form-label-custom">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-custom @error('contact_person_phone') is-invalid @enderror"
                                   id="contact_person_phone" name="contact_person_phone"
                                   value="{{ old('contact_person_phone', $companyProfile->contact_person_phone ?? '') }}"
                                   placeholder="09XXXXXXXXX" required>
                            @error('contact_person_phone')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="establishment_email" class="form-label-custom">E-mail Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-custom @error('establishment_email') is-invalid @enderror"
                           id="establishment_email" name="establishment_email"
                           value="{{ old('establishment_email', $companyProfile->establishment_email ?? '') }}"
                           placeholder="company@email.com" required>
                    @error('establishment_email')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="profile-actions">
                <a href="{{ route('employer.company-profile.download') }}" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i>Download PDF
                </a>
                <a href="{{ route('employer.dashboard') }}" class="btn btn-secondary-outline">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary-solid">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('.form-section');
    const navLinks = document.querySelectorAll('.profile-nav .nav-link');

    const requiredFields = [
        { key: 'name', label: 'Full Name', sectionId: 'account-info-section', type: 'input', selector: '#name' },
        { key: 'email', label: 'Email Address', sectionId: 'account-info-section', type: 'input', selector: '#email' },
        { key: 'business_name', label: 'Business Name', sectionId: 'establishment-details-section', type: 'input', selector: '#business_name' },
        { key: 'company_information', label: 'Company Information', sectionId: 'establishment-details-section', type: 'input', selector: '#company_information' },
        { key: 'established_year', label: 'Year Established', sectionId: 'establishment-details-section', type: 'input', selector: '#established_year' },
        { key: 'trade_name', label: 'Trade Name', sectionId: 'establishment-details-section', type: 'input', selector: '#trade_name' },
        { key: 'acronym_abbreviation', label: 'Acronym / Abbreviation', sectionId: 'establishment-details-section', type: 'input', selector: '#acronym_abbreviation' },
        { key: 'office_type', label: 'Office Type', sectionId: 'establishment-details-section', type: 'radio', selector: 'input[name="office_type"]' },
        { key: 'tin', label: 'Tax Identification Number (TIN)', sectionId: 'establishment-details-section', type: 'input', selector: '#tin' },
        { key: 'employer_type_detail', label: 'Employer Type', sectionId: 'establishment-details-section', type: 'radio', selector: 'input[name="employer_type_detail"]' },
        { key: 'workforce_size', label: 'Total Work Force', sectionId: 'establishment-details-section', type: 'radio', selector: 'input[name="workforce_size"]' },
        { key: 'line_of_business', label: 'Line of Business / Industry', sectionId: 'establishment-details-section', type: 'input', selector: '#line_of_business' },
        { key: 'street_village', label: 'Street / Village', sectionId: 'establishment-details-section', type: 'input', selector: '#street_village' },
        { key: 'barangay', label: 'Barangay', sectionId: 'establishment-details-section', type: 'input', selector: '#barangay' },
        { key: 'city_municipality', label: 'Municipal / City', sectionId: 'establishment-details-section', type: 'input', selector: '#city_municipality' },
        { key: 'province', label: 'Province', sectionId: 'establishment-details-section', type: 'input', selector: '#province' },
        { key: 'establishment_contact_person', label: 'Name of Owner / President', sectionId: 'contact-details-section', type: 'input', selector: '#establishment_contact_person' },
        { key: 'contact_person_name', label: 'Contact Person', sectionId: 'contact-details-section', type: 'input', selector: '#establishment_contact_name' },
        { key: 'establishment_contact_position', label: 'Position', sectionId: 'contact-details-section', type: 'input', selector: '#establishment_contact_position' },
        { key: 'establishment_phone', label: 'Telephone Number', sectionId: 'contact-details-section', type: 'input', selector: '#establishment_phone' },
        { key: 'contact_person_phone', label: 'Mobile Number', sectionId: 'contact-details-section', type: 'input', selector: '#contact_person_phone' },
        { key: 'establishment_email', label: 'E-mail Address', sectionId: 'contact-details-section', type: 'input', selector: '#establishment_email' }
    ];

    const completionPercentText = document.getElementById('completionPercentText');
    const completionCountText = document.getElementById('completionCountText');
    const completionProgressBar = document.getElementById('completionProgressBar');
    const completionStatusText = document.getElementById('completionStatusText');
    const missingFieldsReminder = document.getElementById('missingFieldsReminder');
    const missingFieldsList = document.getElementById('missingFieldsList');

    const normalizeFilled = (value) => value !== null && value !== undefined && String(value).trim() !== '';

    const setMissingHighlight = (field, missing) => {
        if (field.type === 'radio') {
            const radios = document.querySelectorAll(field.selector);
            const radioCards = radios.length ? radios[0].closest('.workforce-buttons')?.querySelectorAll('.workforce-card') : [];

            radios.forEach(radio => {
                radio.classList.toggle('field-missing', missing);
            });

            if (radioCards && radioCards.length) {
                radioCards.forEach(card => card.classList.toggle('field-missing', missing));
            }

            return;
        }

        const element = document.querySelector(field.selector);
        if (element) {
            element.classList.toggle('field-missing', missing);
        }
    };

    const evaluateField = (field) => {
        if (field.type === 'radio') {
            return document.querySelector(`${field.selector}:checked`) !== null;
        }

        const element = document.querySelector(field.selector);
        return element ? normalizeFilled(element.value) : false;
    };

    const refreshProfileCompletion = () => {
        if (!completionPercentText || !completionCountText || !completionProgressBar || !completionStatusText || !missingFieldsList || !missingFieldsReminder) {
            return;
        }

        const missingFields = [];

        requiredFields.forEach(field => {
            const filled = evaluateField(field);
            setMissingHighlight(field, !filled);

            if (!filled) {
                missingFields.push(field);
            }
        });

        const total = requiredFields.length;
        const completed = total - missingFields.length;
        const percent = total > 0 ? Math.round((completed / total) * 100) : 0;

        completionPercentText.textContent = `${percent}%`;
        completionCountText.textContent = `${completed} of ${total} required fields completed`;
        completionProgressBar.style.width = `${percent}%`;
        completionProgressBar.parentElement?.setAttribute('aria-valuenow', String(percent));

        if (missingFields.length === 0) {
            completionStatusText.textContent = 'Great job. Your required company profile fields are complete.';
            missingFieldsReminder.classList.add('d-none');
            missingFieldsList.innerHTML = '';
            return;
        }

        completionStatusText.textContent = 'Please complete the missing required fields listed below.';
        missingFieldsReminder.classList.remove('d-none');
        missingFieldsList.innerHTML = missingFields.map(field => (
            `<li data-field="${field.key}"><a href="#${field.sectionId}" class="missing-field-link" data-scroll-target="${field.sectionId}" data-field="${field.key}">${field.label}</a></li>`
        )).join('');
    };

    requiredFields.forEach(field => {
        if (field.type === 'radio') {
            document.querySelectorAll(field.selector).forEach(radio => {
                radio.addEventListener('change', refreshProfileCompletion);
            });
            return;
        }

        const element = document.querySelector(field.selector);
        if (element) {
            element.addEventListener('input', refreshProfileCompletion);
            element.addEventListener('change', refreshProfileCompletion);
        }
    });

    document.addEventListener('click', function (event) {
        const reminderLink = event.target.closest('.missing-field-link');
        if (!reminderLink) {
            return;
        }

        event.preventDefault();
        const sectionId = reminderLink.getAttribute('data-scroll-target');
        const section = sectionId ? document.getElementById(sectionId) : null;
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        const field = requiredFields.find(item => item.key === reminderLink.getAttribute('data-field'));
        if (!field) {
            return;
        }

        if (field.type === 'radio') {
            const firstRadio = document.querySelector(field.selector);
            if (firstRadio) {
                firstRadio.focus();
            }
        } else {
            const targetInput = document.querySelector(field.selector);
            if (targetInput) {
                targetInput.focus();
            }
        }
    });

    refreshProfileCompletion();

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === entry.target.id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, { rootMargin: "-50% 0px -50% 0px" });

    sections.forEach(section => {
        observer.observe(section);
    });

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});

function handleCompanyLogoChange(input) {
    const label = document.getElementById('logo-label');
    const logoOnlyFlag = document.getElementById('logo_only');
    const form = input.closest('form');

    if (!input.files || !input.files[0] || !form) {
        return;
    }

    if (label) {
        label.textContent = 'Uploading...';
    }

    if (logoOnlyFlag) {
        logoOnlyFlag.value = '1';
    }

    form.submit();
}
</script>
@endpush
@endsection


