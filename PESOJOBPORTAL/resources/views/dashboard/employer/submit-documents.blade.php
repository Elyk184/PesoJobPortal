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

        .docs-preview {
            display: grid;
            gap: 0.75rem;
        }

        .docs-preview-header {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .docs-preview-logo {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            object-fit: cover;
            background: #fff;
            border: 1px solid #d8e2f1;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .docs-preview-logo.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5d718e;
            font-weight: 800;
            font-size: 1.05rem;
            background: linear-gradient(135deg, #e8f1ff 0%, #dfeaff 100%);
        }

        .docs-preview-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            background: #eaf2ff;
            color: #1f4f97;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .docs-preview-panel {
            border: 1px solid #dbe6f5;
            border-radius: 14px;
            background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
            padding: 0.95rem;
        }

        .docs-preview-title {
            margin: 0.2rem 0 0.25rem;
            color: #12243f;
            font-size: 1rem;
            font-weight: 800;
        }

        .docs-preview-text {
            margin: 0;
            color: #5f6f86;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .docs-upload-state {
            font-size: 0.86rem;
            color: #64748b;
            margin-top: 0.45rem;
        }

        .docs-upload-state strong {
            color: #12243f;
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

        .submission-item {
            border: 1px solid #e3eaf4;
            border-radius: 14px;
            padding: 0.95rem 1rem;
            background: linear-gradient(180deg, #fbfdff 0%, #f7faff 100%);
        }

        .submission-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.7rem;
            margin-bottom: 0.35rem;
            flex-wrap: wrap;
        }

        .submission-type {
            color: #12243f;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .submission-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #fff;
            background: #2f6ec8;
        }

        .submission-meta {
            margin: 0;
            color: #60708a;
            font-size: 0.92rem;
        }

        @media (max-width: 992px) {
            .docs-grid {
                grid-template-columns: 1fr;
            }

            .docs-helper-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .docs-page {
                margin: -0.7rem;
                padding: 0.8rem;
            }

            .docs-hero {
                padding: 1.15rem;
            }

            .docs-hero h1 {
                font-size: 1.45rem;
            }

            .docs-submit {
                width: 100%;
            }
        }
    </style>

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

                <form class="docs-form" method="POST" action="{{ route('employer.recruitment.request') }}" enctype="multipart/form-data">
                    @csrf

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

                    <!-- SRA Specific Fields -->
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

                    <!-- LRA Specific Fields -->
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
                        <textarea id="job_vacancies_text" name="job_vacancies_text" rows="6" style="width: 100%; border: 1px solid #c8d6ea; border-radius: 10px; background: #fff; padding: 0.6rem 0.7rem; font-size: 0.92rem; font-family: inherit;" placeholder="Enter job vacancy details here..."></textarea>
                    </div>
                    <button id="submitBtn" class="docs-submit" type="submit">Submit LRA/SRA Request</button>
                </form>

                <p class="docs-note">Tip: clear file names and complete documents help speed up review.</p>
            </section>

            <section class="docs-card">
                <h2>Request Requirements</h2>
                <div class="submission-list" id="requirementsList">
                    <!-- Requirements will be populated by JavaScript -->
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Update submit button text based on activity type selection
            const activityTypeSelect = document.getElementById('activity_type');
            const submitBtn = document.getElementById('submitBtn');
            const letterOfIntentInput = document.getElementById('letter_of_intent');
            const requirementsList = document.getElementById('requirementsList');

            const sraRequirements = [
                { name: 'Letter of Intent (Addressed to ROGELIO N. QUIÑO, MUNICIPAL MAYOR, MANOLO FORTICH, THRU: LORRAINE A. REQUINTON - PESO MANAGER)', field: 'letter_of_intent' },
                { name: 'DMW CERTIFICATE', field: 'dmw_certificate' },
                { name: 'APPOINTMENT OF RECRUITMENT OFFICER AND ID', field: 'recruitment_officer_id' },
                { name: 'UPDATED JOB ORDER BALANCE', field: 'job_order_balance' },
                { name: 'LATEST DEPLOYMENT REPORT', field: 'deployment_report' },
                { name: 'AFFIDAVIT OF UNDERTAKING (TO FOLLOW)', field: 'affidavit_undertaking' },
                { name: 'SRA AUTHORITY (TO FOLLOW)', field: 'sra_authority_file' },
            ];

            const lraRequirements = [
                { name: 'Letter of Intent', field: 'letter_of_intent' },
                { name: 'Business Permit', field: 'business_permit' },
                { name: 'APPOINTMENT OF RECRUITMENT OFFICER AND ID', field: 'lra_recruitment_officer_id' },
                { name: 'Job Vacancies', field: 'job_vacancies' },
            ];

            const updateVisibleFields = () => {
                const activityType = activityTypeSelect.value;

                // Hide all SRA fields
                document.getElementById('sra_dmw_certificate').style.display = 'none';
                document.getElementById('sra_recruitment_officer').style.display = 'none';
                document.getElementById('sra_job_order_balance').style.display = 'none';
                document.getElementById('sra_deployment_report').style.display = 'none';
                document.getElementById('sra_affidavit').style.display = 'none';
                document.getElementById('sra_authority').style.display = 'none';

                // Hide all LRA fields
                document.getElementById('lra_business_permit').style.display = 'none';
                document.getElementById('lra_recruitment_officer').style.display = 'none';
                document.getElementById('lra_job_vacancies').style.display = 'none';
                document.getElementById('lra_job_vacancies_text').style.display = 'none';

                // Show relevant fields
                if (activityType === 'sra') {
                    document.getElementById('sra_dmw_certificate').style.display = 'block';
                    document.getElementById('sra_recruitment_officer').style.display = 'block';
                    document.getElementById('sra_job_order_balance').style.display = 'block';
                    document.getElementById('sra_deployment_report').style.display = 'block';
                    document.getElementById('sra_affidavit').style.display = 'block';
                    document.getElementById('sra_authority').style.display = 'block';
                } else if (activityType === 'lra') {
                    document.getElementById('lra_business_permit').style.display = 'block';
                    document.getElementById('lra_recruitment_officer').style.display = 'block';
                    document.getElementById('lra_job_vacancies').style.display = 'block';
                    document.getElementById('lra_job_vacancies_text').style.display = 'block';
                }
            };

            const updateRequirements = () => {
                const activityType = activityTypeSelect.value;
                let requirements = [];

                if (activityType === 'sra') {
                    requirements = sraRequirements;
                } else if (activityType === 'lra') {
                    requirements = lraRequirements;
                } else {
                    // Default: show SRA requirements as template
                    requirements = sraRequirements;
                }

                const completedCount = requirements.filter(req => {
                    if (req.field) {
                        // Special handling for job_vacancies - can be either file OR text
                        if (req.field === 'job_vacancies') {
                            const fileInput = document.getElementById('job_vacancies');
                            const textInput = document.getElementById('job_vacancies_text');
                            const hasFile = fileInput && fileInput.files.length > 0;
                            const hasText = textInput && textInput.value.trim().length > 0;
                            return hasFile || hasText;
                        } else {
                            const input = document.getElementById(req.field);
                            if (input && input.type === 'file') {
                                return input.files.length > 0;
                            }
                        }
                    }
                    return false;
                }).length;
                const totalCount = requirements.length;
                const percentage = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;

                let html = `
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-weight: 700; color: #12243f;">Submission Progress</span>
                            <span style="font-weight: 800; color: #1f4f97; font-size: 1.1rem;">${percentage}%</span>
                        </div>
                        <div style="width: 100%; height: 12px; border-radius: 999px; background: #e1e9f5; overflow: hidden;">
                            <div style="height: 100%; width: ${percentage}%; background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 100%); transition: width 0.3s ease;"></div>
                        </div>
                    </div>

                    <div style="display: grid; gap: 0.7rem;">
                `;

                requirements.forEach(req => {
                    let isCompleted = false;
                    if (req.field) {
                        // Special handling for job_vacancies - can be either file OR text
                        if (req.field === 'job_vacancies') {
                            const fileInput = document.getElementById('job_vacancies');
                            const textInput = document.getElementById('job_vacancies_text');
                            const hasFile = fileInput && fileInput.files.length > 0;
                            const hasText = textInput && textInput.value.trim().length > 0;
                            isCompleted = hasFile || hasText;
                        } else {
                            const input = document.getElementById(req.field);
                            if (input && input.type === 'file') {
                                isCompleted = input.files.length > 0;
                            }
                        }
                    }

                    html += `
                        <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.6rem; border-radius: 8px; background: ${isCompleted ? '#eaf2ff' : '#f5f7fb'};">
                            <div style="width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; ${isCompleted ? 'background: #2f6ec8; color: #fff;' : 'background: #d8e2f1; color: #64748b;'}">
                                ${isCompleted ? '✓' : '○'}
                            </div>
                            <span style="color: ${isCompleted ? '#12243f' : '#5f6f86'}; font-weight: ${isCompleted ? '700' : '500'};">${req.name}</span>
                        </div>
                    `;
                });

                html += '</div>';
                requirementsList.innerHTML = html;
            };

            const updateButtonText = () => {
                const selectedValue = activityTypeSelect.value.toUpperCase();
                if (selectedValue === 'LRA' || selectedValue === 'SRA') {
                    submitBtn.textContent = `Submit ${selectedValue} Request`;
                } else {
                    submitBtn.textContent = 'Submit LRA/SRA Request';
                }
            };

            // Get all file inputs for tracking
            const fileInputs = document.querySelectorAll('input[type="file"]');

            activityTypeSelect.addEventListener('change', () => {
                updateButtonText();
                updateVisibleFields();
                updateRequirements();
            });

            fileInputs.forEach(input => {
                input.addEventListener('change', updateRequirements);
            });

            // Add listener for job_vacancies_text textarea
            const jobVacanciesText = document.getElementById('job_vacancies_text');
            if (jobVacanciesText) {
                jobVacanciesText.addEventListener('input', updateRequirements);
            }

            updateButtonText(); // Initial call in case there's a default value
            updateVisibleFields(); // Initial call to hide/show fields
            updateRequirements(); // Initial call to show requirements
        });
    </script>
@endsection
