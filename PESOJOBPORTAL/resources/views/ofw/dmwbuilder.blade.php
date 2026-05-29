@extends('layouts.dashboard')

@section('title', 'DMW Request Builder')

@section('content')
@php
    $profile = $ofwProfile ?? null;
    $user = $ofwUser ?? auth()->user();
    $applicantName = old('applicant_name', $profile?->personal_information['first_name'] ?? $user->name ?? '');
    $email = old('email', $profile?->personal_information['email_address'] ?? $user->email ?? '');
    $phone = old('phone', $profile?->phone ?? '');
    $passportNumber = old('passport_number', $profile?->personal_information['passport_number'] ?? '');
    $contractEmployer = old('employer', '');
    $contractStart = old('contract_start', '');
    $contractEnd = old('contract_end', '');
    $requestDetails = old('request_details', '');
@endphp

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

    <div class="row g-3">
        <div class="col-12 col-xl-5">
            <form method="POST" action="{{ route('ofw.dmw-builder.save') }}" enctype="multipart/form-data" class="dashboard-section-card p-3 p-lg-4 h-100">
                @csrf

                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Form Fields</h3>
                    <div class="small text-muted">Fields marked <span class="text-danger">*</span> are required</div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="applicant_name">Full name <span class="text-danger">*</span></label>
                        <input type="text" name="applicant_name" id="applicant_name" class="form-control" value="{{ $applicantName }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $email }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" for="phone">Contact number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $phone }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" for="passport_number">Passport number <span class="text-danger">*</span></label>
                        <input type="text" name="passport_number" id="passport_number" class="form-control" value="{{ $passportNumber }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="address">Present address</label>
                        <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $profile?->present_address['full'] ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="employer">Employer / Overseas principal <span class="text-danger">*</span></label>
                        <input type="text" name="employer" id="employer" class="form-control" value="{{ $contractEmployer }}" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold" for="contract_start">Contract start date</label>
                        <input type="date" name="contract_start" id="contract_start" class="form-control" value="{{ $contractStart }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold" for="contract_end">Contract end date</label>
                        <input type="date" name="contract_end" id="contract_end" class="form-control" value="{{ $contractEnd }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="request_details">Nature of request / details <span class="text-danger">*</span></label>
                        <textarea name="request_details" id="request_details" class="form-control" rows="6" required>{{ $requestDetails }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Requested assistance (check all that apply) <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_repatriation" value="repatriation">
                            <label class="form-check-label" for="assistance_repatriation">Repatriation</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_legal" value="legal">
                            <label class="form-check-label" for="assistance_legal">Legal assistance</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_medical" value="medical">
                            <label class="form-check-label" for="assistance_medical">Medical assistance</label>
                        </div>
                        <div class="form-text">At least one assistance type is required.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Attachments (passport copy, contract) <span class="text-danger">*</span></label>
                        <input type="file" name="attachments[]" class="form-control mb-2" accept="application/pdf,image/*">
                        <input type="file" name="attachments[]" class="form-control mb-2" accept="application/pdf,image/*">
                        <div class="form-text">Upload required supporting documents. They will be appended to the generated PDF.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="signature_date">Date <span class="text-danger">*</span></label>
                        <input type="date" name="signature_date" id="signature_date" class="form-control" value="{{ old('signature_date') }}" required>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-save me-2"></i>Save Form (Draft)
                    </button>

                    <button type="submit" formaction="{{ route('ofw.dmw-submit') }}" class="btn btn-success flex-fill">
                        <i class="bi bi-send me-2"></i>Submit to Admin
                    </button>

                    <a href="{{ route('ofw.dmw-download') }}" class="btn btn-outline-secondary flex-fill">
                        <i class="bi bi-download me-2"></i>Download PDF (with attachments)
                    </a>
                </div>
            </form>
        </div>

        <div class="col-12 col-xl-7">
            <div class="dashboard-section-card p-3 p-lg-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Live Preview</h3>
                    <div class="d-flex gap-2">
                        <small class="text-muted">This preview shows the main fields that will be placed on the DMW form PDF.</small>
                    </div>
                </div>

                <div class="dmw-preview mx-auto">
                    <iframe src="{{ asset('forms/DMW REQUEST FOR ASSISTANCE FORM.pdf') }}" style="width:100%; height:800px; border:0;" title="DMW form preview"></iframe>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        .dmw-preview {
            max-width: 820px;
            background: #fff;
            border: 1px solid #d8dde5;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            padding: 24px;
            color: #111827;
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .dmw-preview h4 { margin: 0 0 8px 0; }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            // Simple client-side action: submit form to download route
            // Replace with actual download route when available
            const form = this.closest('form');
            // For now, submit the form (POST) — backend must handle PDF generation and merging
            form.submit();
        });
    </script>
@endpush

@endsection