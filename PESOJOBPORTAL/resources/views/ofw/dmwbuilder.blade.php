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
                <div class="col-12">
                    <label class="form-label fw-semibold">Request type</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="request_type" id="request_online" value="online" @checked(old('request_type', $draft['request_type'] ?? '') === 'online')>
                        <label class="form-check-label" for="request_online">Online</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="request_type" id="request_walkin" value="walkin" @checked(old('request_type', $draft['request_type'] ?? '') === 'walkin')>
                        <label class="form-check-label" for="request_walkin">Walk-in</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="request_type" id="request_referral" value="referral" @checked(old('request_type', $draft['request_type'] ?? '') === 'referral')>
                        <label class="form-check-label" for="request_referral">Referral by</label>
                    </div>
                    <div class="d-inline-block ms-2" id="referral_by_wrapper" style="display: none; max-width: 40%;">
                        <input type="text" name="referral_by" id="referral_by" placeholder="Referral by" class="form-control" value="{{ old('referral_by', $draft['referral_by'] ?? '') }}">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Full name <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <input type="text" name="name_last" id="name_last" class="form-control" placeholder="Last name" value="{{ old('name_last', $draft['name_last'] ?? '') }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="text" name="name_first" id="name_first" class="form-control" placeholder="First name" value="{{ old('name_first', $draft['name_first'] ?? '') }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="text" name="name_middle" id="name_middle" class="form-control" placeholder="Middle name" value="{{ old('name_middle', $draft['name_middle'] ?? '') }}">
                        </div>
                    </div>
                    <input type="hidden" name="applicant_name" id="applicant_name" value="{{ $applicantName }}">
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
                    <label class="form-label fw-semibold" for="civil_status">Civil status</label>
                    <select name="civil_status" id="civil_status" class="form-select">
                        <option value="">Select</option>
                        <option value="single">Single / Walang Asawa</option>
                        <option value="married">Married / May Asawa</option>
                        <option value="widow">Widow / Widower</option>
                        <option value="separated">Separated / Hiwalay</option>
                        <option value="solo_parent">Solo Parent</option>
                    </select>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="email">Email / Facebook Account</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $email }}">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="phone">Contact No./Mobile</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $phone }}">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="passport_number">Passport / Travel Document No.</label>
                    <input type="text" name="passport_number" id="passport_number" class="form-control" value="{{ $passportNumber }}">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="address_abroad">Address abroad</label>
                    <input type="text" name="address_abroad" id="address_abroad" class="form-control" value="{{ old('address_abroad', $draft['address_abroad'] ?? '') }}">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label fw-semibold" for="address_ph">Address in the Philippines</label>
                    <input type="text" name="address_ph" id="address_ph" class="form-control" value="{{ old('address_ph', $draft['address_ph'] ?? '') }}">
                </div>

                <!-- Employer field removed per specification -->

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
                    <label class="form-label fw-semibold">B. Information of relative / contact person</label>
                    <div class="row g-2">
                        <div class="col-12 col-md-4"><input type="text" name="relative_last" class="form-control" placeholder="Relative last name" value="{{ old('relative_last', $draft['relative_last'] ?? '') }}"></div>
                        <div class="col-12 col-md-4"><input type="text" name="relative_first" class="form-control" placeholder="Relative first name" value="{{ old('relative_first', $draft['relative_first'] ?? '') }}"></div>
                        <div class="col-12 col-md-4"><input type="text" name="relative_middle" class="form-control" placeholder="Relative middle name" value="{{ old('relative_middle', $draft['relative_middle'] ?? '') }}"></div>
                        <div class="col-12 col-md-4 mt-2"><input type="date" name="relative_birthdate" class="form-control" placeholder="Birthdate" value="{{ old('relative_birthdate', $draft['relative_birthdate'] ?? '') }}"></div>
                        <div class="col-12 col-md-4 mt-2">
                            <select name="relative_relationship" class="form-select">
                                <option value="">Relationship to OFW</option>
                                <option value="spouse">Spouse / Asawa</option>
                                <option value="child">Child / Anak</option>
                                <option value="sibling">Sibling / Kapatid</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mt-2"><input type="text" name="relative_id_no" class="form-control" placeholder="ID No." value="{{ old('relative_id_no', $draft['relative_id_no'] ?? '') }}"></div>
                        <div class="col-12 mt-2"><input type="text" name="relative_address_ph" class="form-control" placeholder="Address in the Philippines" value="{{ old('relative_address_ph', $draft['relative_address_ph'] ?? '') }}"></div>
                        <div class="col-12 col-md-6 mt-2"><input type="text" name="relative_mobile" class="form-control" placeholder="Mobile / Phone No." value="{{ old('relative_mobile', $draft['relative_mobile'] ?? '') }}"></div>
                        <div class="col-12 col-md-6 mt-2"><input type="email" name="relative_email" class="form-control" placeholder="Email / Facebook" value="{{ old('relative_email', $draft['relative_email'] ?? '') }}"></div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label fw-semibold">C. Requested assistance (please check)</label>
                    <div class="row g-2">
                        @foreach([
                            'legal' => 'Legal assistance',
                            'medical' => 'Medical assistance',
                            'repatriation' => 'Repatriation',
                            'rescue' => 'Rescue / Evacuation',
                            'welfare_senior' => 'Welfare assistance for senior OFW returnees',
                            'shipment' => 'Shipment of human remains / Cremains',
                            'compassionate' => 'Compassionate visit',
                            'food' => 'Food assistance',
                            'transportation' => 'Transportation assistance',
                            'temporary_shelter' => 'Temporary shelter'
                        ] as $val => $label)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_{{ $val }}" value="{{ $val }}" @checked(in_array($val, $assistance, true))>
                                    <label class="form-check-label" for="assistance_{{ $val }}">{{ $label }}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="assistance[]" id="assistance_others" value="others" @checked(in_array('others', $assistance, true))>
                                <label class="form-check-label" for="assistance_others">Others</label>
                            </div>
                            <input type="text" name="assistance_others_text" class="form-control mt-1" placeholder="If others, please specify" value="{{ old('assistance_others_text', $draft['assistance_others_text'] ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Attachments</label>
                    <div class="alert alert-light border mb-0">
                        Use the uploader below to choose one file and upload it. Allowed: image or PDF. Max 10 files total, 100MB combined.
                    </div>
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

                <div class="col-12">
                    <h6 class="fw-semibold">E. Account details (if funds to be deposited)</h6>
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="bank_account_no">Bank Account No.</label>
                    <input type="text" name="bank_account_no" id="bank_account_no" class="form-control" value="{{ old('bank_account_no', $draft['bank_account_no'] ?? '') }}">
                </div>
                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="bank_name">Bank</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ old('bank_name', $draft['bank_name'] ?? '') }}">
                </div>
                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="bank_branch">Branch</label>
                    <input type="text" name="bank_branch" id="bank_branch" class="form-control" value="{{ old('bank_branch', $draft['bank_branch'] ?? '') }}">
                </div>
                <div class="col-12 col-lg-3">
                    <label class="form-label fw-semibold" for="account_name">Account Name</label>
                    <input type="text" name="account_name" id="account_name" class="form-control" value="{{ old('account_name', $draft['account_name'] ?? '') }}">
                </div>

                <div class="col-12 col-lg-4">
                    <label class="form-label fw-semibold" for="signature_printed">Signature over Printed Name</label>
                    <input type="text" name="signature_printed" id="signature_printed" class="form-control" value="{{ old('signature_printed', $draft['signature_printed'] ?? $user->name ?? '') }}">
                </div>

                <div class="col-12 col-lg-4">
                    <label class="form-label fw-semibold" for="signature_date">Date Signed <span class="text-danger">*</span></label>
                    <input type="date" name="signature_date" id="signature_date" class="form-control" value="{{ $signatureDate }}" required>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-save me-2"></i>Save Form (Draft)
                </button>

                <a href="{{ route('ofw.dmw-download') }}" class="btn btn-outline-secondary flex-fill">
                    <i class="bi bi-download me-2"></i>Download PDF
                </a>

                <button type="submit" formaction="{{ route('ofw.dmw-submit') }}" class="btn btn-success flex-fill">
                    <i class="bi bi-send me-2"></i>Submit to Admin
                </button>
            </div>
        </form>

        <div class="dashboard-section-card p-3 p-lg-4 mt-3">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <div>
                    <h3 class="h6 mb-0 fw-bold">Upload Attachment</h3>
                    <small class="text-muted">Upload one image or PDF at a time.</small>
                </div>
            </div>

            <form id="attachment-upload-form" action="{{ route('ofw.attachments.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-md-row gap-2 align-items-md-end">
                @csrf
                <div class="flex-grow-1">
                    <input type="file" name="attachment" id="attachments" class="form-control" accept="application/pdf,image/*">
                    <div class="small text-muted mt-1">No file selected.</div>
                    <div id="attachments-status" class="small text-muted mt-1">No file selected.</div>
                </div>
                <button type="submit" id="attachment-upload-button" class="btn btn-secondary">
                    <i class="bi bi-upload me-2"></i>Upload File
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('dmwbuilder-form');
        if (! form) return;

        const statusEl = document.createElement('div');
        statusEl.className = 'small text-muted mt-2 d-flex gap-2 align-items-center';
        statusEl.id = 'dmw-save-status';
        statusEl.innerHTML = '<span id="dmw-save-message">Draft auto-save enabled</span><span id="dmw-save-ts" class="text-muted"></span>';
        form.parentNode.insertBefore(statusEl, form.nextSibling);

        let timer = null;
        let inFlight = false;
        const attachmentsInput = document.getElementById('attachments');
        const attachmentsStatus = document.getElementById('attachments-status');
        const attachmentUploadForm = document.getElementById('attachment-upload-form');
        const attachmentUploadButton = document.getElementById('attachment-upload-button');
        const submitButtons = form.querySelectorAll('button[type="submit"]');

        function setStatus(text) {
            const msg = document.getElementById('dmw-save-message');
            if (msg) msg.textContent = text;
        }

        function setSavedTimestamp(date = new Date()) {
            const ts = document.getElementById('dmw-save-ts');
            if (! ts) return;
            const pad = (n) => n.toString().padStart(2, '0');
            const hh = pad(date.getHours());
            const mm = pad(date.getMinutes());
            const ss = pad(date.getSeconds());
            ts.textContent = `Saved at ${hh}:${mm}:${ss}`;
        }

        async function autosave() {
            if (inFlight) return;
            inFlight = true;
            setStatus('Saving draft...');
            try {
                const url = form.getAttribute('action');
                const tokenInput = document.querySelector('input[name="_token"]');
                const metaToken = document.querySelector('meta[name="csrf-token"]');
                const token = tokenInput ? tokenInput.value : (metaToken ? metaToken.getAttribute('content') : '');
                const formData = new FormData(form);
                if (token) {
                    formData.set('_token', token);
                }

                const resp = await fetch(url, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData,
                });

                if (! resp.ok) {
                    const body = await resp.text().catch(() => '');
                    console.error('Draft save failed', resp.status, body);
                    setStatus(resp.status === 419 ? 'Session expired. Refresh the page and try again.' : `Failed to save draft (${resp.status})`);
                } else {
                    const json = await resp.json().catch(() => null);
                    const message = (json && json.message) ? json.message : 'Draft saved';
                    setStatus(message);
                    setSavedTimestamp(new Date());
                }
            } catch (err) {
                setStatus('Error saving draft');
                console.error('Autosave error', err);
            } finally {
                inFlight = false;
            }
        }

        function scheduleSave() {
            if (timer) clearTimeout(timer);
            timer = setTimeout(autosave, 1500);
        }

        function updateAttachmentStatus() {
            if (! attachmentsInput || ! attachmentsStatus) return;

            const file = attachmentsInput.files && attachmentsInput.files[0];
            if (! file) {
                attachmentsStatus.textContent = 'No file selected.';
                return;
            }

            attachmentsStatus.textContent = `Selected file: ${file.name}`;
        }

        if (attachmentUploadForm) {
            attachmentUploadForm.addEventListener('submit', function () {
                if (attachmentUploadButton) {
                    attachmentUploadButton.disabled = true;
                }
                if (attachmentsStatus && attachmentsInput && attachmentsInput.files && attachmentsInput.files[0]) {
                    attachmentsStatus.textContent = 'Uploading file...';
                }
            });
        }

            if (attachmentUploadForm && attachmentsInput && attachmentUploadButton) {
                attachmentUploadForm.addEventListener('submit', function (event) {
                    const file = attachmentsInput.files && attachmentsInput.files[0];
                    if (! file) {
                        if (attachmentsStatus) {
                            attachmentsStatus.textContent = 'Choose a file first.';
                        }
                        event.preventDefault();
                        return;
                    }

                    if (attachmentsStatus) {
                        attachmentsStatus.textContent = 'Uploading file...';
                    }
                    attachmentUploadButton.disabled = true;
                });
            }

        if (attachmentsInput) {
            attachmentsInput.addEventListener('change', updateAttachmentStatus);
            updateAttachmentStatus();
        }

        // Attach listeners to inputs (skip file inputs)
        form.querySelectorAll('input, textarea, select').forEach(function (el) {
            if (el.type === 'file') return;
            el.addEventListener('input', scheduleSave);
            el.addEventListener('change', scheduleSave);
        });

        // initial status
        setStatus('Draft auto-save enabled');
    })();
</script>
@endpush

@push('scripts')
<script>
    (function () {
        function toggleReferral() {
            const referralRadio = document.getElementById('request_referral');
            const wrapper = document.getElementById('referral_by_wrapper');
            if (! wrapper || ! referralRadio) return;
            wrapper.style.display = referralRadio.checked ? 'inline-block' : 'none';
        }

        document.querySelectorAll('input[name="request_type"]').forEach(function (el) {
            el.addEventListener('change', toggleReferral);
        });

        // initialize on load
        document.addEventListener('DOMContentLoaded', function () {
            toggleReferral();
        });
    })();
</script>
@endpush