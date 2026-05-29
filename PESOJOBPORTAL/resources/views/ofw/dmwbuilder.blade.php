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
            <form id="dmwbuilder-form" method="POST" action="{{ route('ofw.dmw-builder.save') }}" enctype="multipart/form-data" class="dashboard-section-card p-3 p-lg-4 h-100">
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
                        @if(auth()->user()?->role === 'admin' || app()->environment() === 'local')
                            <button id="calibrate-toggle" class="btn btn-sm btn-outline-secondary ms-2">Calibrate overlay</button>
                        @endif
                    </div>
                </div>

                <div class="dmw-preview mx-auto position-relative" style="height:820px;" data-calibrate-url="{{ route('ofw.dmw-calibrate') }}" data-csrf="{{ csrf_token() }}">
                    <iframe id="dmw-preview-iframe" src="{{ asset('forms/DMW REQUEST FOR ASSISTANCE FORM.pdf') }}" style="width:100%; height:100%; border:0; display:block;" title="DMW form preview"></iframe>

                    <!-- HTML overlay: absolute-positioned elements that mirror form inputs -->
                    <div id="dmw-overlay" style="position:absolute; inset:0; pointer-events:none;">
                        <div class="overlay-text" id="ov-name" style="position:absolute; left:10%; top:12%; font-size:14px; color:#000;"></div>
                        <div class="overlay-text" id="ov-birthdate" style="position:absolute; left:10%; top:18%; font-size:12px; color:#000;"></div>
                        <div class="overlay-text" id="ov-sex" style="position:absolute; left:60%; top:18%; font-size:12px; color:#000;"></div>
                        <div class="overlay-text" id="ov-passport" style="position:absolute; left:10%; top:24%; font-size:12px; color:#000;"></div>
                        <div class="overlay-text" id="ov-contact" style="position:absolute; left:10%; top:30%; font-size:12px; color:#000;"></div>
                        <div class="overlay-text" id="ov-email" style="position:absolute; left:10%; top:34%; font-size:12px; color:#000;"></div>

                        <div class="overlay-text" id="ov-employer" style="position:absolute; left:10%; top:46%; font-size:12px; color:#000;"></div>
                        <div class="overlay-text" id="ov-contract" style="position:absolute; left:10%; top:50%; font-size:12px; color:#000;"></div>

                        <div class="overlay-text" id="ov-narrative" style="position:absolute; left:6%; top:60%; width:88%; font-size:12px; color:#000; white-space:pre-wrap;"></div>

                        <div class="overlay-check" id="ov-help-repatriation" style="position:absolute; left:10%; top:52%; width:12px; height:12px; color:#000;"></div>
                        <div class="overlay-check" id="ov-help-legal" style="position:absolute; left:28%; top:52%; width:12px; height:12px; color:#000;"></div>
                        <div class="overlay-check" id="ov-help-medical" style="position:absolute; left:46%; top:52%; width:12px; height:12px; color:#000;"></div>
                    </div>
                    <script id="dmw-field-coords" type="application/json">{!! json_encode($dmwFieldCoords ?? []) !!}</script>
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
        // embed saved coords from server (read from JSON script node)
        (function(){
            const el = document.getElementById('dmw-field-coords');
            try { window.dmwFieldCoords = el ? JSON.parse(el.textContent || '{}') : {}; } catch(e) { window.dmwFieldCoords = {}; }
        })();

        function applyFieldCoords(coords) {
            Object.entries(coords || {}).forEach(([key, pos]) => {
                const el = document.getElementById('ov-' + key);
                if (! el) return;
                if (pos.left !== undefined) el.style.left = (pos.left) + '%';
                if (pos.top !== undefined) el.style.top = (pos.top) + '%';
                if (pos.width !== undefined) el.style.width = (pos.width) + '%';
                if (pos.fontSize !== undefined) el.style.fontSize = (pos.fontSize) + 'px';
            });
        }

        // Realtime overlay: update overlay elements from form inputs
        (function () {
            const debounce = (fn, ms = 250) => { let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); }; };

            const mappings = [
                { sel: '#applicant_name', ov: 'ov-name' },
                { sel: '#contract_start', ov: 'ov-contract' },
                { sel: '#contract_end', ov: 'ov-contract' },
                { sel: '#passport_number', ov: 'ov-passport' },
                { sel: '#phone', ov: 'ov-contact' },
                { sel: '#email', ov: 'ov-email' },
                { sel: '#employer', ov: 'ov-employer' },
                { sel: '#request_details', ov: 'ov-narrative' },
            ];

            function updateOverlay() {
                mappings.forEach(m => {
                    const el = document.querySelector(m.sel);
                    const target = document.getElementById(m.ov);
                    if (!target) return;
                    if (!el) { target.textContent = ''; return; }
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA' || el.tagName === 'SELECT') {
                        target.textContent = el.value || '';
                    }
                });

                // sex radio
                const male = document.getElementById('sex_male');
                const female = document.getElementById('sex_female');
                const ovSex = document.getElementById('ov-sex');
                if (ovSex) {
                    if (male && male.checked) ovSex.textContent = 'Male';
                    else if (female && female.checked) ovSex.textContent = 'Female';
                    else ovSex.textContent = '';
                }

                // assistance checkboxes
                ['repatriation','legal','medical'].forEach((k, idx) => {
                    const cb = document.getElementById('assistance_' + k);
                    const ov = document.getElementById('ov-help-' + k);
                    if (!ov) return;
                    ov.textContent = cb && cb.checked ? '✔' : '';
                });
            }

            const debouncedUpdate = debounce(updateOverlay, 120);

            // attach listeners
            document.querySelectorAll('#dmwbuilder-form input, #dmwbuilder-form textarea, #dmwbuilder-form select').forEach(i => {
                i.addEventListener('input', debouncedUpdate);
                i.addEventListener('change', debouncedUpdate);
            });

            // initial sync after DOM ready
            document.addEventListener('DOMContentLoaded', () => {
                // apply any stored coords first
                applyFieldCoords(window.dmwFieldCoords || {});
                setTimeout(updateOverlay, 200);
            });
            // also run now
            updateOverlay();

            // Calibration UI (admin/local only)
            const calibrateToggle = document.getElementById('calibrate-toggle');
            if (calibrateToggle) {
                let calibrating = false;
                const preview = document.querySelector('.dmw-preview');
                calibrateToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    calibrating = !calibrating;
                    calibrateToggle.classList.toggle('active', calibrating);
                    calibrateToggle.textContent = calibrating ? 'Exit calibration' : 'Calibrate overlay';
                    if (calibrating) {
                        preview.style.cursor = 'crosshair';
                        document.getElementById('dmw-overlay').style.pointerEvents = 'auto';
                        alert('Click on the preview where you want to place a field, then enter the field key (for example: name, passport, employer, contract, narrative, help-repatriation, help-legal, help-medical).');
                    } else {
                        preview.style.cursor = '';
                        document.getElementById('dmw-overlay').style.pointerEvents = 'none';
                    }
                });

                preview.addEventListener('click', async function (ev) {
                    if (!calibrating) return;
                    const rect = preview.getBoundingClientRect();
                    const x = ev.clientX - rect.left;
                    const y = ev.clientY - rect.top;
                    const leftPct = Math.round((x / rect.width) * 10000) / 100; // two decimals
                    const topPct = Math.round((y / rect.height) * 10000) / 100;
                    const key = prompt('Enter field key to save at this position (e.g. name, passport, employer, contract, narrative, help-repatriation):');
                    if (!key) return alert('No key entered — cancelled');

                    // normalize hyphen fields to match element ids
                    const normalized = key.replace(/[^a-z0-9\-_]/gi, '').replace(/\s+/g, '-');

                    // update local coords
                    window.dmwFieldCoords = window.dmwFieldCoords || {};
                    window.dmwFieldCoords[normalized] = window.dmwFieldCoords[normalized] || {};
                    window.dmwFieldCoords[normalized].left = leftPct;
                    window.dmwFieldCoords[normalized].top = topPct;

                    applyFieldCoords(window.dmwFieldCoords);

                    // send to server
                    try {
                        const calibrateUrl = preview?.dataset?.calibrateUrl;
                        const csrfToken = preview?.dataset?.csrf;
                        const res = await fetch(calibrateUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken || ''
                            },
                            body: JSON.stringify({ coords: window.dmwFieldCoords })
                        });
                        if (!res.ok) throw new Error('Save failed');
                        alert('Coordinates saved. You can continue calibrating or exit.');
                    } catch (err) {
                        console.error(err);
                        alert('Failed to save coordinates to server');
                    }
                });
            }
        })();
    </script>
@endpush

@endsection