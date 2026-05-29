@extends('layouts.dashboard')

@section('title', 'DMW Request Builder')

@section('content')
@php
    $profile = $ofwProfile ?? null;
    $user = $ofwUser ?? auth()->user();
    $draft = $dmwDraft ?? [];
    $applicantName = old('applicant_name', $draft['applicant_name'] ?? $profile?->personal_information['first_name'] ?? $user->name ?? '');
    $birthdate = old('birthdate', $draft['birthdate'] ?? '');
    $sex = old('sex', $draft['sex'] ?? '');
    $email = old('email', $draft['email'] ?? $profile?->personal_information['email_address'] ?? $user->email ?? '');
    $phone = old('phone', $draft['phone'] ?? $profile?->phone ?? '');
    $passportNumber = old('passport_number', $draft['passport_number'] ?? $profile?->personal_information['passport_number'] ?? '');
    $address = old('address', $draft['address'] ?? $profile?->present_address['full'] ?? '');
    $contractEmployer = old('employer', $draft['employer'] ?? '');
    $contractStart = old('contract_start', $draft['contract_start'] ?? '');
    $contractEnd = old('contract_end', $draft['contract_end'] ?? '');
    $requestDetails = old('request_details', $draft['request_details'] ?? '');
    $signatureDate = old('signature_date', $draft['signature_date'] ?? '');
    $assistance = old('assistance', $draft['assistance'] ?? []);
    if (! is_array($assistance)) {
        $assistance = [$assistance];
    }
@endphp

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

<section aria-label="DMW Request Builder">
    <div class="dashboard-topbar mb-3">
        <div>
            <div class="dashboard-topbar-title">DMW Request for Assistance - Builder</div>
            <div class="dashboard-topbar-subtitle">Fill the official form fields below. Required fields are marked *</div>
        </div>
        <a href="{{ route('ofw.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Please fix the highlighted problems.</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <div>
                <h3 class="h5 mb-0 fw-bold">Form Fields</h3>
                <small class="text-muted">Fill the fields below. The downloaded PDF will place them on the official DMW template and append your images as extra pages.</small>
            </div>
            <div class="small text-muted text-end">
                Max 10 images total, 100MB total size
            </div>
        </div>

        <form id="dmwbuilder-form" method="POST" action="{{ route('ofw.dmw-builder.save') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="applicant_name">Full name <span class="text-danger">*</span></label>
                    <input type="text" name="applicant_name" id="applicant_name" class="form-control" value="{{ $applicantName }}" required>
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ $birthdate }}">
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="sex">Sex</label>
                    <select name="sex" id="sex" class="form-select">
                        <option value="">Select</option>
                        <option value="male" @selected($sex === 'male')>Male</option>
                        <option value="female" @selected($sex === 'female')>Female</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $email }}" required>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="phone">Contact number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $phone }}" required>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="passport_number">Passport number <span class="text-danger">*</span></label>
                    <input type="text" name="passport_number" id="passport_number" class="form-control" value="{{ $passportNumber }}" required>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="employer">Employer / Overseas principal <span class="text-danger">*</span></label>
                    <input type="text" name="employer" id="employer" class="form-control" value="{{ $contractEmployer }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="address">Present address</label>
                    <textarea name="address" id="address" class="form-control" rows="2">{{ $address }}</textarea>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="contract_start">Contract start date</label>
                    <input type="date" name="contract_start" id="contract_start" class="form-control" value="{{ $contractStart }}">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="contract_end">Contract end date</label>
                    <input type="date" name="contract_end" id="contract_end" class="form-control" value="{{ $contractEnd }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="request_details">Nature of request / details <span class="text-danger">*</span></label>
                    <textarea name="request_details" id="request_details" class="form-control" rows="6" required>{{ $requestDetails }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Requested assistance (check all that apply) <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_repatriation" value="repatriation" @checked(in_array('repatriation', $assistance, true))>
                                <label class="form-check-label" for="assistance_repatriation">Repatriation</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_legal" value="legal" @checked(in_array('legal', $assistance, true))>
                                <label class="form-check-label" for="assistance_legal">Legal assistance</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_medical" value="medical" @checked(in_array('medical', $assistance, true))>
                                <label class="form-check-label" for="assistance_medical">Medical assistance</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-text">At least one assistance type is required.</div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold" for="attachments">Attachments</label>
                    <input type="file" name="attachments[]" id="attachments" class="form-control" accept="image/*" multiple>
                    <div class="form-text">Upload up to 10 images total. All images combined must stay under 100MB. They will be appended to the downloaded PDF.</div>
                </div>

                @if (!empty($dmwAttachments))
                    <div class="col-12">
                        <div class="border rounded-3 p-3 bg-light">
                            <div class="fw-semibold mb-2">Current attachments</div>
                            <div class="row g-2">
                                @foreach ($dmwAttachments as $attachment)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="d-flex align-items-center justify-content-between gap-2 border rounded-2 bg-white px-3 py-2 h-100">
                                            <a href="{{ $attachment['url'] }}" target="_blank" rel="noopener" class="text-decoration-none text-truncate">{{ $attachment['name'] }}</a>
                                            <form method="POST" action="{{ route('ofw.attachments.delete') }}" class="m-0">
                                                @csrf
                                                <input type="hidden" name="path" value="{{ $attachment['path'] }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12 col-lg-4">
                    <label class="form-label fw-semibold" for="signature_date">Date <span class="text-danger">*</span></label>
                    <input type="date" name="signature_date" id="signature_date" class="form-control" value="{{ $signatureDate }}" required>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-save me-2"></i>Save Form (Draft)
                </button>

                <button type="submit" formaction="{{ route('ofw.dmw-download') }}" class="btn btn-outline-secondary flex-fill">
                    <i class="bi bi-download me-2"></i>Download PDF
                </button>

                <button type="submit" formaction="{{ route('ofw.dmw-submit') }}" class="btn btn-success flex-fill">
                    <i class="bi bi-send me-2"></i>Submit to Admin
                </button>
            </div>
        </form>
    </div>
</section>

@endsection