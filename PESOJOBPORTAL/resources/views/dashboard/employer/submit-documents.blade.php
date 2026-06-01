@extends('dashboard.employer.layout')

@section('title', 'Submit Documents')
@section('hide_header', true)

@section('content')
    <style>
        .docs-page {
            margin: -1rem;
            padding: 1.2rem;
            min-height: 100vh;
            display: grid;
            gap: 16px;
            background:
                radial-gradient(circle at top right, rgba(45, 101, 177, 0.12), transparent 45%),
                radial-gradient(circle at bottom left, rgba(215, 38, 56, 0.08), transparent 40%),
                #eef3fb;
        }

        .docs-hero {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            padding: 1.35rem;
            color: #fff;
            background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 48%, #5ca2ff 100%);
            box-shadow: 0 14px 28px rgba(31, 79, 151, 0.24);
        }

        .docs-hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            right: -65px;
            top: -82px;
        }

        .docs-kicker {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.28rem 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .docs-hero h1 {
            position: relative;
            z-index: 1;
            margin: 0.7rem 0 0.3rem;
            font-size: 1.78rem;
            font-weight: 800;
        }

        .docs-hero p {
            position: relative;
            z-index: 1;
            margin: 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.92);
            line-height: 1.55;
        }

        .docs-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 16px;
            align-items: start;
        }

        .docs-card {
            background: #fff;
            border: 1px solid #d8e2f1;
            border-radius: 16px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            padding: 1.2rem;
        }

        .docs-card h2 {
            margin: 0 0 0.35rem;
            color: #12243f;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .docs-card p {
            color: #5f6f86;
            margin: 0 0 0.9rem;
        }

        .docs-form {
            display: grid;
            gap: 12px;
        }

        .docs-helper-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .docs-field {
            border: 1px solid #e1e9f5;
            border-radius: 12px;
            padding: 0.8rem 0.9rem;
            background: linear-gradient(180deg, #fafdff 0%, #f4f8ff 100%);
        }

        .docs-field label {
            display: block;
            margin: 0 0 0.45rem;
            color: #22334d;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .docs-field select,
        .docs-field input[type="file"] {
            width: 100%;
            border: 1px solid #c8d6ea;
            border-radius: 10px;
            background: #fff;
            padding: 0.6rem 0.7rem;
            font-size: 0.92rem;
        }

        .docs-submit {
            width: fit-content;
            border: 0;
            border-radius: 11px;
            padding: 0.72rem 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 100%);
            box-shadow: 0 10px 20px rgba(31, 79, 151, 0.22);
            cursor: pointer;
        }

        .docs-note {
            margin-top: 0.3rem;
            color: #6b778c;
            font-size: 0.9rem;
        }

        .submission-list {
            display: grid;
            gap: 0.7rem;
        }

        /* ── Modal Styles ───────────────────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.55);
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 460px;
            margin: 1rem;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
            animation: modalIn 0.22s ease;
        }

        @keyframes modalIn {
            from { transform: translateY(18px); opacity: 0; }
            to   { transform: translateY(0);   opacity: 1; }
        }

        .modal-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #e8f1ff 0%, #dfeaff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            margin-bottom: 1rem;
        }

        .modal-title {
            margin: 0 0 0.3rem;
            font-size: 1.22rem;
            font-weight: 800;
            color: #12243f;
        }

        .modal-desc {
            margin: 0 0 1.4rem;
            color: #5f6f86;
            font-size: 0.93rem;
            line-height: 1.55;
        }

        .modal-date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 0.9rem;
        }

        .modal-field label {
            display: block;
            font-size: 0.88rem;
            font-weight: 700;
            color: #22334d;
            margin-bottom: 0.4rem;
        }

        .modal-field input[type="date"] {
            width: 100%;
            border: 1px solid #c8d6ea;
            border-radius: 10px;
            background: #fff;
            padding: 0.62rem 0.75rem;
            font-size: 0.93rem;
            box-sizing: border-box;
            transition: border-color 0.15s;
            font-family: inherit;
        }

        .modal-field input[type="date"]:focus {
            outline: none;
            border-color: #2f6ec8;
            box-shadow: 0 0 0 3px rgba(47, 110, 200, 0.13);
        }

        .modal-summary {
            display: none;
            padding: 0.7rem 0.9rem;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 1.5rem;
        }

        .modal-cancel {
            flex: 1;
            padding: 0.72rem;
            border: 1px solid #c8d6ea;
            border-radius: 10px;
            background: #fff;
            color: #5f6f86;
            font-weight: 700;
            font-size: 0.93rem;
            cursor: pointer;
            font-family: inherit;
        }

        .modal-cancel:hover { background: #f4f8ff; }

        .modal-confirm {
            flex: 2;
            padding: 0.72rem;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.93rem;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(31, 79, 151, 0.22);
            font-family: inherit;
            transition: opacity 0.15s;
        }

        .modal-confirm:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            box-shadow: none;
        }

        @media (max-width: 992px) {
            .docs-grid { grid-template-columns: 1fr; }
            .docs-helper-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .docs-page { margin: -0.7rem; padding: 0.8rem; }
            .docs-hero { padding: 1.15rem; }
            .docs-hero h1 { font-size: 1.45rem; }
            .docs-submit { width: 100%; }
            .modal-date-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .modal-box { margin: 1rem; padding: 1.4rem; }
        }
    </style>

    {{-- ── Recruitment Date Modal ──────────────────────────────────── --}}
    <div class="modal-overlay" id="recruitmentModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-box">
            <div class="modal-icon">📅</div>
            <h2 class="modal-title" id="modalTitle">Recruitment Schedule</h2>
            <p class="modal-desc">
                Please specify the <strong>start</strong> and <strong>end dates</strong> for your
                <strong id="modalActivityLabel">LRA/SRA</strong> recruitment activity.
                The total number of days will be automatically calculated.
            </p>

            <div class="modal-date-row">
                <div class="modal-field">
                    <label for="modal_start_date">Start Date</label>
                    <input type="date" id="modal_start_date" required>
                </div>
                <div class="modal-field">
                    <label for="modal_end_date">End Date</label>
                    <input type="date" id="modal_end_date" required>
                </div>
            </div>

            <div class="modal-summary" id="modalSummary"></div>

            <div class="modal-actions">
                <button type="button" class="modal-cancel" id="modalCancelBtn">Cancel</button>
                <button type="button" class="modal-confirm" id="modalConfirmBtn" disabled>
                    Confirm &amp; Submit
                </button>
            </div>
        </div>
    </div>

    <div class="docs-page">
        <section class="docs-hero">
            <span class="docs-kicker">Compliance</span>
            <h1>Submit Documents</h1>
            <p>Upload the required files for LRA/SRA review. Choose the activity type and attach complete supporting documents for faster processing.</p>
        </section>

        <div class="docs-grid">
            <section class="docs-card">
                <h2>Submit Local / Special Recruitment Documents</h2>
                <p>Attach all required files before sending your request for review.</p>

                <form class="docs-form" id="mainForm" method="POST" action="{{ route('employer.recruitment.request') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Hidden fields populated by modal before submission --}}
                    <input type="hidden" name="recruitment_start_date" id="hidden_start_date">
                    <input type="hidden" name="recruitment_end_date"   id="hidden_end_date">
                    <input type="hidden" name="recruitment_days"       id="hidden_days">

                    <div class="docs-helper-grid">
                        <div class="docs-field">
                            <label for="activity_type">Activity Type</label>
                            <select id="activity_type" name="activity_type" required>
                                <option value="">Select</option>
                                <option value="lra" @selected(old('activity_type', $defaultActivityType) === 'lra')>LRA</option>
                                <option value="sra" @selected(old('activity_type', $defaultActivityType) === 'sra')>SRA</option>
                            </select>
                        </div>
                    </div>

                    <div class="docs-field">
                        <label for="letter_of_intent">Letter of Intent</label>
                        <input id="letter_of_intent" type="file" name="letter_of_intent" required accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    {{-- SRA Specific Fields --}}
                    <div id="sra_dmw_certificate" class="docs-field" style="display: none;">
                        <label for="dmw_certificate">DMW CERTIFICATE</label>
                        <input id="dmw_certificate" type="file" name="dmw_certificate" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="sra_recruitment_officer" class="docs-field" style="display: none;">
                        <label for="recruitment_officer_id">APPOINTMENT OF RECRUITMENT OFFICER AND ID</label>
                        <input id="recruitment_officer_id" type="file" name="recruitment_officer_id" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="sra_job_order_balance" class="docs-field" style="display: none;">
                        <label for="job_order_balance">UPDATED JOB ORDER BALANCE</label>
                        <input id="job_order_balance" type="file" name="job_order_balance" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="sra_deployment_report" class="docs-field" style="display: none;">
                        <label for="deployment_report">LATEST DEPLOYMENT REPORT</label>
                        <input id="deployment_report" type="file" name="deployment_report" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="sra_affidavit" class="docs-field" style="display: none;">
                        <label for="affidavit_undertaking">AFFIDAVIT OF UNDERTAKING (TO FOLLOW)</label>
                        <input id="affidavit_undertaking" type="file" name="affidavit_undertaking" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="sra_authority" class="docs-field" style="display: none;">
                        <label for="sra_authority_file">SRA AUTHORITY (TO FOLLOW)</label>
                        <input id="sra_authority_file" type="file" name="sra_authority_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    {{-- LRA Specific Fields --}}
                    <div id="lra_business_permit" class="docs-field" style="display: none;">
                        <label for="business_permit">Business Permit</label>
                        <input id="business_permit" type="file" name="business_permit" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="lra_recruitment_officer" class="docs-field" style="display: none;">
                        <label for="lra_recruitment_officer_id">APPOINTMENT OF RECRUITMENT OFFICER AND ID</label>
                        <input id="lra_recruitment_officer_id" type="file" name="lra_recruitment_officer_id" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="lra_job_vacancies" class="docs-field" style="display: none;">
                        <label for="job_vacancies">Job Vacancies - Upload File</label>
                        <input id="job_vacancies" type="file" name="job_vacancies" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                    </div>

                    <div id="lra_job_vacancies_text" class="docs-field" style="display: none;">
                        <label for="job_vacancies_text">Job Vacancies - Text Details</label>
                        <textarea id="job_vacancies_text" name="job_vacancies_text" rows="6"
                            style="width: 100%; border: 1px solid #c8d6ea; border-radius: 10px; background: #fff; padding: 0.6rem 0.7rem; font-size: 0.92rem; font-family: inherit;"
                            placeholder="Enter job vacancy details here..."></textarea>
                    </div>

                    <button id="submitBtn" class="docs-submit" type="button">Submit LRA/SRA Request</button>
                </form>

                <p class="docs-note">Tip: clear file names and complete documents help speed up review.</p>
            </section>

            <section class="docs-card">
                <h2>Request Requirements</h2>
                <div class="submission-list" id="requirementsList"></div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Existing logic ───────────────────────────────────────────────
            const activityTypeSelect = document.getElementById('activity_type');
            const submitBtn          = document.getElementById('submitBtn');
            const requirementsList   = document.getElementById('requirementsList');

            const sraRequirements = [
                { name: 'Letter of Intent (Addressed to ROGELIO N. QUIÑO, MUNICIPAL MAYOR, MANOLO FORTICH, THRU: LORRAINE A. REQUINTON - PESO MANAGER)', field: 'letter_of_intent' },
                { name: 'DMW CERTIFICATE',                                field: 'dmw_certificate' },
                { name: 'APPOINTMENT OF RECRUITMENT OFFICER AND ID',      field: 'recruitment_officer_id' },
                { name: 'UPDATED JOB ORDER BALANCE',                      field: 'job_order_balance' },
                { name: 'LATEST DEPLOYMENT REPORT',                       field: 'deployment_report' },
                { name: 'AFFIDAVIT OF UNDERTAKING (TO FOLLOW)',           field: 'affidavit_undertaking' },
                { name: 'SRA AUTHORITY (TO FOLLOW)',                      field: 'sra_authority_file' },
            ];

            const lraRequirements = [
                { name: 'Letter of Intent',                               field: 'letter_of_intent' },
                { name: 'Business Permit',                                field: 'business_permit' },
                { name: 'APPOINTMENT OF RECRUITMENT OFFICER AND ID',      field: 'lra_recruitment_officer_id' },
                { name: 'Job Vacancies',                                  field: 'job_vacancies' },
            ];

            const updateVisibleFields = () => {
                const type = activityTypeSelect.value;

                // Hide all conditional fields
                ['sra_dmw_certificate','sra_recruitment_officer','sra_job_order_balance',
                 'sra_deployment_report','sra_affidavit','sra_authority',
                 'lra_business_permit','lra_recruitment_officer','lra_job_vacancies','lra_job_vacancies_text']
                    .forEach(id => document.getElementById(id).style.display = 'none');

                if (type === 'sra') {
                    ['sra_dmw_certificate','sra_recruitment_officer','sra_job_order_balance',
                     'sra_deployment_report','sra_affidavit','sra_authority']
                        .forEach(id => document.getElementById(id).style.display = 'block');
                } else if (type === 'lra') {
                    ['lra_business_permit','lra_recruitment_officer','lra_job_vacancies','lra_job_vacancies_text']
                        .forEach(id => document.getElementById(id).style.display = 'block');
                }
            };

            const isFieldFilled = (field) => {
                if (field === 'job_vacancies') {
                    const fileInput = document.getElementById('job_vacancies');
                    const textInput = document.getElementById('job_vacancies_text');
                    return (fileInput && fileInput.files.length > 0) ||
                           (textInput && textInput.value.trim().length > 0);
                }
                const input = document.getElementById(field);
                return input && input.type === 'file' && input.files.length > 0;
            };

            const updateRequirements = () => {
                const type = activityTypeSelect.value;
                const requirements = type === 'lra' ? lraRequirements : sraRequirements;

                const completed = requirements.filter(r => isFieldFilled(r.field)).length;
                const total     = requirements.length;
                const pct       = total > 0 ? Math.round((completed / total) * 100) : 0;

                let html = `
                    <div style="margin-bottom:1.5rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <span style="font-weight:700;color:#12243f;">Submission Progress</span>
                            <span style="font-weight:800;color:#1f4f97;font-size:1.1rem;">${pct}%</span>
                        </div>
                        <div style="width:100%;height:12px;border-radius:999px;background:#e1e9f5;overflow:hidden;">
                            <div style="height:100%;width:${pct}%;background:linear-gradient(135deg,#1f4f97 0%,#2f6ec8 100%);transition:width 0.3s ease;"></div>
                        </div>
                    </div>
                    <div style="display:grid;gap:0.7rem;">`;

                requirements.forEach(req => {
                    const done = isFieldFilled(req.field);
                    html += `
                        <div style="display:flex;align-items:center;gap:0.8rem;padding:0.6rem;border-radius:8px;background:${done ? '#eaf2ff' : '#f5f7fb'};">
                            <div style="width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;${done ? 'background:#2f6ec8;color:#fff;' : 'background:#d8e2f1;color:#64748b;'}">
                                ${done ? '✓' : '○'}
                            </div>
                            <span style="color:${done ? '#12243f' : '#5f6f86'};font-weight:${done ? '700' : '500'};">${req.name}</span>
                        </div>`;
                });

                html += '</div>';
                requirementsList.innerHTML = html;
            };

            const updateButtonText = () => {
                const v = activityTypeSelect.value.toUpperCase();
                submitBtn.textContent = (v === 'LRA' || v === 'SRA')
                    ? `Submit ${v} Request`
                    : 'Submit LRA/SRA Request';
            };

            activityTypeSelect.addEventListener('change', () => {
                updateButtonText();
                updateVisibleFields();
                updateRequirements();
            });

            document.querySelectorAll('input[type="file"]').forEach(i =>
                i.addEventListener('change', updateRequirements));

            const jobVacanciesText = document.getElementById('job_vacancies_text');
            if (jobVacanciesText) jobVacanciesText.addEventListener('input', updateRequirements);

            updateButtonText();
            updateVisibleFields();
            updateRequirements();

            // ── Modal logic ──────────────────────────────────────────────────
            const form          = document.getElementById('mainForm');
            const modal         = document.getElementById('recruitmentModal');
            const startInput    = document.getElementById('modal_start_date');
            const endInput      = document.getElementById('modal_end_date');
            const summary       = document.getElementById('modalSummary');
            const confirmBtn    = document.getElementById('modalConfirmBtn');
            const cancelBtn     = document.getElementById('modalCancelBtn');
            const activityLabel = document.getElementById('modalActivityLabel');
            const hiddenStart   = document.getElementById('hidden_start_date');
            const hiddenEnd     = document.getElementById('hidden_end_date');
            const hiddenDays    = document.getElementById('hidden_days');

            // Open modal on submit button click (after native validation)
            submitBtn.addEventListener('click', function () {
                // Trigger native HTML5 validation on the form
                if (!form.reportValidity()) return;

                // Update modal label
                const type = activityTypeSelect.value.toUpperCase() || 'LRA/SRA';
                activityLabel.textContent = type;

                // Reset modal state
                const today = new Date().toISOString().split('T')[0];
                startInput.min   = today;
                startInput.value = '';
                endInput.value   = '';
                endInput.min     = today;
                summary.style.display  = 'none';
                confirmBtn.disabled    = true;

                modal.classList.add('active');
                setTimeout(() => startInput.focus(), 50);
            });

            // Recalculate duration whenever a date changes
            function recalculate() {
                if (!startInput.value || !endInput.value) {
                    summary.style.display = 'none';
                    confirmBtn.disabled = true;
                    return;
                }

                const start = new Date(startInput.value);
                const end   = new Date(endInput.value);

                if (end < start) {
                    summary.style.display    = 'block';
                    summary.style.background = '#fff0f0';
                    summary.style.color      = '#b91c1c';
                    summary.textContent      = '⚠ End date must be on or after the start date.';
                    confirmBtn.disabled = true;
                    return;
                }

                const days = Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1;
                summary.style.display    = 'block';
                summary.style.background = '#eaf2ff';
                summary.style.color      = '#1f4f97';
                summary.textContent      = `✓ Recruitment duration: ${days} day${days !== 1 ? 's' : ''} (${startInput.value} → ${endInput.value})`;
                confirmBtn.disabled = false;
            }

            startInput.addEventListener('change', function () {
                endInput.min = startInput.value;
                recalculate();
            });

            endInput.addEventListener('change', recalculate);

            // Confirm: populate hidden fields and submit the real form
            confirmBtn.addEventListener('click', function () {
                const start = new Date(startInput.value);
                const end   = new Date(endInput.value);
                const days  = Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1;

                hiddenStart.value = startInput.value;
                hiddenEnd.value   = endInput.value;
                hiddenDays.value  = days;

                modal.classList.remove('active');
                form.submit(); // bypass button click, submit directly
            });

            // Cancel button
            cancelBtn.addEventListener('click', () => modal.classList.remove('active'));

            // Click outside modal box to close
            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.classList.remove('active');
            });

            // Escape key to close
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
@endsection
