@extends('dashboard.employer.layout')

@section('title', 'Edit Job - PESO')
@section('hide_header', true)

@section('content')
<style>
    .edit-job-shell {
        --accent: #1f4f97;
        --accent-soft: #e8f0ff;
        --ink: #1f2937;
        --muted: #6b7280;
        --line: #e5e7eb;
        --bg-soft: #f4f7fc;
        --card-line: #dce6f5;
        font-family: "Poppins", "Segoe UI", Tahoma, sans-serif;
        color: var(--ink);
        position: relative;
    }

    .edit-job-shell::before,
    .edit-job-shell::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
        z-index: 0;
    }

    .edit-job-shell::before {
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.16), rgba(37, 99, 235, 0));
        top: -60px;
        right: -40px;
    }

    .edit-job-shell::after {
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(30, 64, 175, 0.12), rgba(30, 64, 175, 0));
        bottom: 20px;
        left: -40px;
    }

    .composer-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 1.6rem;
        background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 45%, #5ca2ff 100%);
        color: #fff;
        box-shadow: 0 10px 28px rgba(31, 79, 151, 0.28);
        margin-bottom: 1.25rem;
        z-index: 1;
    }

    .composer-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0));
        right: -40px;
        top: -30px;
    }

    .hero-title {
        font-size: 1.55rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
    }

    .hero-subtitle {
        margin: 0;
        color: rgba(255,255,255,0.9);
    }

    .hero-meta {
        margin-top: 0.85rem;
        display: flex;
        gap: 0.55rem;
        flex-wrap: wrap;
    }

    .hero-pill {
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.34);
        color: #eff6ff;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        backdrop-filter: blur(2px);
    }

    .job-form-card {
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        border: 1px solid var(--card-line);
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    .section-divider {
        border-top: 1px dashed #dfe5f1;
        margin: 2rem 0;
    }

    .form-block {
        border: 1px solid #e4ebf7;
        border-radius: 14px;
        padding: 1.25rem;
        background: linear-gradient(180deg, #f9fbff 0%, #f5f8ff 100%);
    }

    .block-title {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        color: #1e3a6b;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .block-title i {
        background: #dbeafe;
        color: #1d4ed8;
        width: 24px;
        height: 24px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.92rem;
    }

    .form-control, .form-select {
        border: 1px solid #d6dbe7;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        background: #fff;
        font-size: 0.93rem;
        color: #1e293b;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2f6ec8;
        box-shadow: 0 0 0 3px rgba(47, 110, 200, 0.15);
        background: #fff;
    }

    .form-control:hover,
    .form-select:hover {
        border-color: #b9c8e2;
    }

    .is-invalid {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1) !important;
    }

    textarea.form-control {
        min-height: 120px;
        line-height: 1.45;
    }

    .btn-post-job {
        background: linear-gradient(135deg, #11468f 0%, #1c78d1 100%);
        border: 1px solid #0f3f80;
        color: #fff;
        padding: 0.875rem 2rem;
        font-weight: 700;
        border-radius: 12px;
        letter-spacing: 0.01em;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-post-job:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 18px rgba(17, 70, 143, 0.24);
    }

    .btn-save-draft {
        background: linear-gradient(135deg, #334155 0%, #1f2937 100%);
        border: 1px solid #1f2937;
        color: white;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-save-draft:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 16px rgba(31, 41, 55, 0.26);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1px solid #f4b8c0;
        color: #9f1239;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-cancel:hover {
        color: #881337;
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(190, 24, 93, 0.15);
    }

    .btn-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.25rem;
        border-top: 1px dashed #dbe4f4;
        padding-top: 1.2rem;
    }

    .btn-row .left-note {
        flex: 1 1 240px;
    }

    .btn-row .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        flex: 1 1 280px;
    }

    .text-muted { color: #64748b !important; font-size: 0.82rem; font-weight: 500; }

    @media (max-width: 768px) {
        .job-form-card {
            padding: 1.2rem;
        }

        .composer-hero {
            padding: 1.2rem;
        }

        .btn-row .actions {
            width: 100%;
            justify-content: stretch;
        }

        .btn-row .actions > * {
            flex: 1 1 auto;
            text-align: center;
        }
    }
</style>

<div class="edit-job-shell">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="composer-hero mb-4">
                <h2 class="hero-title">Edit Job Posting</h2>
                <p class="hero-subtitle">Update the details of your job listing.</p>
                <div class="hero-meta">
                    <span class="hero-pill"><i class="bi bi-hash"></i> Job #{{ $job->id }}</span>
                    <span class="hero-pill"><i class="bi bi-briefcase"></i> {{ ucfirst($job->status ?? 'draft') }}</span>
                </div>
            </div>


            <div class="job-form-card">
                <form action="{{ route('employer.jobs.update', $job) }}" method="POST" id="jobPostForm">
                    @csrf
                    @method('PATCH')

                    <div class="form-block mb-4">
                        <h3 class="block-title"><i class="bi bi-pencil-square"></i> Core Details</h3>
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $job->title) }}" required>
                            @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $job->description) }}</textarea>
                            @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $job->location) }}" required>
                                @error('location')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                    <option value="">Select employment type</option>
                                    @foreach($employmentTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('employment_type', $job->job_type) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employment_type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="vacancies" class="form-label">Number of Vacancies <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('vacancies') is-invalid @enderror" id="vacancies" name="vacancies" value="{{ old('vacancies', $job->vacancies) }}" required min="1" max="999">
                            @error('vacancies')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <div class="form-block mb-4">
                        <h3 class="block-title"><i class="bi bi-list-check"></i> Requirements</h3>
                        <div class="mb-3">
                            <label for="key_responsibilities" class="form-label">Responsibilities</label>
                            <textarea class="form-control @error('key_responsibilities') is-invalid @enderror" id="key_responsibilities" name="key_responsibilities" rows="5">{{ old('key_responsibilities', $job->key_responsibilities) }}</textarea>
                            @error('key_responsibilities')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications</label>
                            <textarea class="form-control @error('qualifications') is-invalid @enderror" id="qualifications" name="qualifications" rows="5">{{ old('qualifications', $job->qualifications) }}</textarea>
                            @error('qualifications')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="preferred_skills" class="form-label">Required Skills</label>
                            <textarea class="form-control @error('preferred_skills') is-invalid @enderror" id="preferred_skills" name="preferred_skills" rows="4">{{ old('preferred_skills', $job->preferred_skills) }}</textarea>
                            @error('preferred_skills')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label">Experience</label>
                            <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="4">{{ old('experience', $job->experience) }}</textarea>
                            @error('experience')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">Education</label>
                            <textarea class="form-control @error('education') is-invalid @enderror" id="education" name="education" rows="4">{{ old('education', $job->education) }}</textarea>
                            @error('education')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="benefits" class="form-label">Benefits</label>
                            <textarea class="form-control @error('benefits') is-invalid @enderror" id="benefits" name="benefits" rows="4">{{ old('benefits', $job->benefits) }}</textarea>
                            @error('benefits')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <div class="form-block mb-4">
                        <h3 class="block-title"><i class="bi bi-cash-coin"></i> Compensation & Deadline</h3>
                        <div class="mb-3">
                            <label class="form-label">Salary Range (PHP)</label>
                            @php
                                $salaryText = old('salary_range', $job->salary_range ?? $job->salary ?? '');
                                $salaryMin = old('salary_min');
                                $salaryMax = old('salary_max');
                                if ($salaryMin === null || $salaryMax === null) {
                                    $min = null; $max = null;
                                    if (is_string($salaryText) && str_contains($salaryText, '-')) {
                                        [$a, $b] = array_map('trim', explode('-', $salaryText, 2));
                                        $min = is_numeric($a) ? (float)$a : null;
                                        $max = is_numeric($b) ? (float)$b : null;
                                    }
                                    $salaryMin = $salaryMin ?? ($min !== null ? $min : '');
                                    $salaryMax = $salaryMax ?? ($max !== null ? $max : '');
                                }
                            @endphp
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('salary_min') is-invalid @enderror" id="salary_min" name="salary_min" placeholder="Min" value="{{ $salaryMin }}" min="0" step="1000">
                                    @error('salary_min')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('salary_max') is-invalid @enderror" id="salary_max" name="salary_max" placeholder="Max" value="{{ $salaryMax }}" min="0" step="1000">
                                    @error('salary_max')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="application_deadline" class="form-label">Last Date to Apply</label>
                            <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" id="application_deadline" name="application_deadline" value="{{ old('application_deadline', $job->application_end_date) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('application_deadline')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Fields marked with * are required.</p>
                    </div>

                    <div class="btn-row">
                        <div class="left-note">
                            <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Tip: Fill required fields (*) then update.</p>
                        </div>

                        <div class="actions">
                            <a href="{{ route('employer.jobs.manage', ['status' => $job->status === 'closed' ? 'archived' : $job->status]) }}" class="btn-cancel">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" name="save_as_draft" value="1" class="btn-save-draft">
                                <i class="bi bi-file-earmark me-2"></i>Save as Draft
                            </button>
                            <button type="submit" class="btn-post-job">
                                <i class="bi bi-check-lg me-2"></i>Update Job
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

