@extends('dashboard.layouts.employer')

@section('title', 'Company Profile - PESO')

@push('styles')
<style>
    .profile-wrapper {
        display: flex;
        gap: 30px;
    }
    .profile-sidebar {
        width: 250px;
        flex-shrink: 0;
    }
    .profile-content {
        flex-grow: 1;
    }
    .profile-nav {
        position: sticky;
        top: 100px;
    }
    .profile-nav .nav-link {
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
        margin-bottom: 40px;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .section-heading {
        font-size: 20px;
        font-weight: 700;
        color: #1e3a5f;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #2d5aa0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-heading i {
        font-size: 22px;
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    <aside class="profile-sidebar">
        <nav class="nav profile-nav flex-column">
            <a class="nav-link" href="#company-logo-section"><i class="fas fa-image me-2"></i> Company Logo</a>
            <a class="nav-link" href="#verification-section"><i class="fas fa-shield-alt me-2"></i> Verification</a>
            <a class="nav-link" href="#account-info-section"><i class="fas fa-user-circle me-2"></i> Account Info</a>
            <a class="nav-link" href="#establishment-details-section"><i class="fas fa-building me-2"></i> Establishment Details</a>
            <a class="nav-link" href="#contact-details-section"><i class="fas fa-address-book me-2"></i> Contact Details</a>
            <a class="nav-link" href="#security-section"><i class="fas fa-lock me-2"></i> Security</a>
        </nav>
    </aside>

    <div class="profile-content">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if(session('success'))
            <div class="alert alert-success m-3 mb-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Company Logo Section -->
            <div id="company-logo-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-image"></i> Company Logo</h5>
                <div class="text-center mb-3">
                    @if($companyProfile && $companyProfile->logo_path)
                    <img src="{{ Storage::url($companyProfile->logo_path) }}" alt="Company Logo" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #2d5aa0;">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px; background: #e9ecef; border: 3px dashed #2d5aa0;">
                            <i class="bi bi-building" style="font-size: 5rem; color: #6c757d;"></i>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <label for="company_logo" class="btn btn-auth-custom d-inline-flex align-items-center justify-content-center" style="width: auto; padding: 10px 25px; cursor: pointer;">
                        <i class="bi bi-upload me-2"></i><span id="logo-label">{{ $companyProfile && $companyProfile->logo_path ? 'Change Logo' : 'Upload Logo' }}</span>
                    </label>
                    <input type="file" id="company_logo" name="company_logo" accept=".jpg,.jpeg,.png,.gif" style="display: none;" onchange="document.getElementById('logo-label').innerHTML = '<i class=\'bi bi-check-circle me-2\'></i>' + (this.files[0] ? this.files[0].name : 'Upload Logo')">
                    <small class="d-block text-muted mt-2">JPG, PNG, GIF (max 2MB)</small>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="trade_name" class="form-label-custom">Trade Name <span class="text-muted">optional</span></label>
                            <input type="text" class="form-control form-control-custom @error('trade_name') is-invalid @enderror"
                                   id="trade_name" name="trade_name" value="{{ old('trade_name', $companyProfile->trade_name ?? '') }}"
                                   placeholder="Trade or brand name">
                            @error('trade_name')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="acronym_abbreviation" class="form-label-custom">Acronym / Abbreviation <span class="text-muted">optional</span></label>
                            <input type="text" class="form-control form-control-custom @error('acronym_abbreviation') is-invalid @enderror"
                                   id="acronym_abbreviation" name="acronym_abbreviation" value="{{ old('acronym_abbreviation', $companyProfile->acronym_abbreviation ?? '') }}"
                                   placeholder="e.g. DMPI">
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
                            <label for="tin" class="form-label-custom">Tax Identification Number (TIN) <span class="text-muted">optional</span></label>
                            <input type="text" class="form-control form-control-custom @error('tin') is-invalid @enderror"
                                   id="tin" name="tin" value="{{ old('tin', $companyProfile->tin ?? '') }}"
                                   placeholder="000-000-000-000">
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
                            <label for="establishment_phone" class="form-label-custom">Telephone Number <span class="text-muted">optional</span></label>
                            <input type="tel" class="form-control form-control-custom @error('establishment_phone') is-invalid @enderror"
                                   id="establishment_phone" name="establishment_phone"
                                   value="{{ old('establishment_phone', $companyProfile->establishment_phone ?? '') }}"
                                   placeholder="(088) 000-0000">
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

            <!-- Security Section -->
            <div id="security-section" class="form-section">
                <h5 class="section-heading"><i class="fas fa-lock"></i> Security</h5>
                <div class="mb-4">
                    <label for="username" class="form-label-custom">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('username') is-invalid @enderror"
                           id="username" name="username" value="{{ old('username', $user->username ?? '') }}" required
                           placeholder="Choose a unique username">
                    @error('username')
                        <div class="form-error-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="password" class="form-label-custom">New Password</label>
                            <input type="password" class="form-control form-control-custom @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter new password">
                            @error('password')
                                <div class="form-error-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label-custom">Confirm New Password</label>
                            <input type="password" class="form-control form-control-custom"
                                   id="password_confirmation" name="password_confirmation"
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Leave password fields blank if you don't want to change your password.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('dashboard.employer') }}" class="btn btn-secondary-outline">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary-solid flex-grow-1">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('.form-section');
    const navLinks = document.querySelectorAll('.profile-nav .nav-link');

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
</script>
@endpush
@endsection


