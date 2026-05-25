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





                    <button id="submitBtn" class="docs-submit" type="submit">Submit LRA/SRA Request</button>
                </form>

                <p class="docs-note">Tip: clear file names and complete documents help speed up review.</p>
            </section>

            <section class="docs-card">
                <h2>Request Requirements</h2>
                <div class="submission-list">
                    @php
                        $letterOfIntent = $REQUEST_FILES['letter_of_intent'] ?? false;
                        $requirements = [
                            ['name' => 'Letter of Intent', 'completed' => $letterOfIntent],
                            ['name' => 'Activity Type Selected', 'completed' => !empty(old('activity_type', $defaultActivityType))],
                        ];
                        $completedCount = collect($requirements)->filter(fn($req) => $req['completed'])->count();
                        $totalCount = count($requirements);
                        $percentage = round(($completedCount / $totalCount) * 100);
                    @endphp

                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-weight: 700; color: #12243f;">Submission Progress</span>
                            <span style="font-weight: 800; color: #1f4f97; font-size: 1.1rem;">{{ $percentage }}%</span>
                        </div>
                        <div style="width: 100%; height: 12px; border-radius: 999px; background: #e1e9f5; overflow: hidden;">
                            <div style="height: 100%; width: {{ $percentage }}%; background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 100%); transition: width 0.3s ease;"></div>
                        </div>
                    </div>

                    <div style="display: grid; gap: 0.7rem;">
                        @foreach($requirements as $requirement)
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.6rem; border-radius: 8px; background: {{ $requirement['completed'] ? '#eaf2ff' : '#f5f7fb' }};">
                                <div style="width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; {{ $requirement['completed'] ? 'background: #2f6ec8; color: #fff;' : 'background: #d8e2f1; color: #64748b;' }}">
                                    {{ $requirement['completed'] ? '✓' : '○' }}
                                </div>
                                <span style="color: {{ $requirement['completed'] ? '#12243f' : '#5f6f86' }}; font-weight: {{ $requirement['completed'] ? '700' : '500' }};">{{ $requirement['name'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Update submit button text based on activity type selection
            const activityTypeSelect = document.getElementById('activity_type');
            const submitBtn = document.getElementById('submitBtn');

            const updateButtonText = () => {
                const selectedValue = activityTypeSelect.value.toUpperCase();
                if (selectedValue === 'LRA' || selectedValue === 'SRA') {
                    submitBtn.textContent = `Submit ${selectedValue} Request`;
                } else {
                    submitBtn.textContent = 'Submit LRA/SRA Request';
                }
            };

            activityTypeSelect.addEventListener('change', updateButtonText);
            updateButtonText(); // Initial call in case there's a default value
        });
    </script>
@endsection
