@extends('dashboard.employer.layout')

@section('content')

<style>
    .show-applicant-page {
        --sa-primary: #075cb2;
        --sa-primary-soft: #ecf3ff;
        --sa-border: #d9e6f6;
        --sa-shadow: 0 12px 26px rgba(21, 61, 117, 0.08);
    }



    .page-header {
        background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 12px 24px rgba(7, 92, 178, 0.18);
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header-left h2 {
        margin: 0 0 0.5rem 0;
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: -0.5px;
    }

    .page-header-left p {
        margin: 0;
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.95rem;
    }

    .page-header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .applicant-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--sa-border);
        box-shadow: 0 4px 12px rgba(15, 49, 96, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .applicant-info-section {
        padding: 2.5rem;
        border-bottom: 1px solid #f0f6ff;
    }

    .applicant-header {
        display: flex;
        gap: 1.75rem;
        align-items: flex-start;
    }

    .user-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #deebf9;
        box-shadow: 0 8px 20px rgba(31, 79, 143, 0.15);
        flex-shrink: 0;
    }

    .user-initials {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        font-size: 2.2rem;
        box-shadow: 0 8px 20px rgba(31, 79, 143, 0.15);
        flex-shrink: 0;
        background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);
    }

    .applicant-header-content {
        flex: 1;
    }

    .user-info h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    .user-info .email {
        display: block;
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #7a8a9a;
        margin-bottom: 0.5rem;
    }

    .info-label i {
        color: #075cb2;
        font-size: 0.9rem;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.65em 1.25em;
        border-radius: 999px;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: capitalize;
        border: 1px solid transparent;
        letter-spacing: 0.3px;
    }

    .status-badge-large i {
        font-size: 0.5rem;
    }

    .resume-section {
        padding: 2.5rem;
        border-bottom: 1px solid #f0f6ff;
    }

    .section-title {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
        font-weight: 800;
        color: #1f4f8f;
    }

    .section-title i {
        color: #075cb2;
        font-size: 1.2rem;
    }

    .resume-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .resume-btn {
        border-radius: 10px;
        padding: 0.65rem 1.2rem;
        font-size: 0.95rem;
        font-weight: 600;
        border: 1.5px solid transparent;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        height: 42px;
    }

    .resume-btn i {
        font-size: 0.95rem;
    }

    .resume-btn.btn-outline-primary {
        background: #057a73;
        color: #ffffff;
    }

    .resume-btn.btn-outline-primary:hover {
        background: #04645e;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(5, 122, 115, 0.2);
    }

    .resume-btn.btn-outline-secondary {
        background: #6c757d;
        color: #ffffff;
    }

    .resume-btn.btn-outline-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(108, 117, 125, 0.2);
    }

    .resume-btn.btn-outline-info {
        background: #17a2b8;
        color: #ffffff;
    }

    .resume-btn.btn-outline-info:hover {
        background: #138496;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(23, 162, 184, 0.2);
    }

    .resume-preview {
        background: #f8fbff;
        border: 1.5px solid #d9e6f6;
        border-radius: 12px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .resume-preview iframe {
        display: block;
        width: 100%;
        min-height: 600px;
        border: none;
    }

    .notes-section {
        padding: 2.5rem;
        border-bottom: 1px solid #f0f6ff;
    }

    .notes-content {
        background: #f8fbff;
        border: 1.5px solid #d9e6f6;
        border-radius: 12px;
        padding: 1.5rem;
        color: #334155;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .form-section {
        padding: 2.5rem;
        background: #f8fbff;
        border-top: 1px solid #f0f6ff;
    }

    .form-section h5 {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.75rem;
        font-size: 1.1rem;
        font-weight: 800;
        color: #1f4f8f;
    }

    .form-section h5 i {
        color: #075cb2;
        font-size: 1.2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 2fr auto;
        gap: 1.5rem;
        align-items: start;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #7a8a9a;
        margin-bottom: 0.65rem;
        display: block;
    }

    .form-control,
    .form-select {
        border: 1.5px solid #d3dfe8;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: #243447;
        transition: all 0.25s ease;
        background: #ffffff;
        height: auto;
    }

    .form-control::placeholder {
        color: #7b8a9a;
    }

    .form-control:hover,
    .form-select:hover {
        border-color: #b8d5f0;
        background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2b67b1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(43, 103, 177, 0.12);
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 0;
    }

    .form-actions .btn {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        height: 44px;
        transition: all 0.25s ease;
    }

    .form-actions .btn-primary {
        background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);
        border: none;
        box-shadow: 0 4px 12px rgba(31, 79, 143, 0.2);
    }

    .form-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(31, 79, 143, 0.3);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #ffffff;
        color: #1f4f8f;
        border: 1.5px solid #d9e6f6;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #f8fbff;
        border-color: #b8d5f0;
        color: #1f4f8f;
        transform: translateY(-2px);
    }

    .btn-back i {
        font-size: 0.9rem;
    }

    @media (max-width: 991.98px) {
        .page-header {
            flex-direction: column;
            text-align: center;
            padding: 2rem;
        }

        .applicant-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .resume-actions {
            justify-content: center;
        }

        .form-actions {
            flex-wrap: wrap;
        }
    }
</style>

<div class="show-applicant-page">
<div class="container-fluid py-5">
    <div class="page-header">
        <div class="page-header-left">
            <h2>Applicant Details</h2>
            <p>Review application, resume, and manage applicant status</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('employer.applicants.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <div class="applicant-card">
        <!-- Applicant Info Section -->
        <div class="applicant-info-section">
            <div class="applicant-header">
                @if($application->user->avatar)
                    <img src="{{ Storage::url($application->user->avatar) }}" alt="{{ $application->user->name }}" class="user-avatar">
                @else
                    <div class="user-initials">{{ strtoupper(substr($application->user->name, 0, 1)) }}</div>
                @endif
                <div class="applicant-header-content">
                    <div class="user-info">
                        <h4>{{ $application->user->name }}</h4>
                        <span class="email">{{ $application->user->email }}</span>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="bi bi-briefcase"></i>Applied For</span>
                            <span class="info-value">{{ $application->jobPost->title ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="bi bi-calendar-event"></i>Application Date</span>
                            <span class="info-value">{{ $application->applied_at?->format('M d, Y H:i') ?? $application->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="bi bi-activity"></i>Current Status</span>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-light text-dark',
                                    'reviewing' => 'bg-info bg-opacity-25 text-info-emphasis',
                                    'recommended' => 'bg-primary bg-opacity-25 text-primary-emphasis',
                                    'interviewed' => 'bg-secondary bg-opacity-25 text-secondary-emphasis',
                                    'hired' => 'bg-success bg-opacity-25 text-success-emphasis',
                                    'rejected' => 'bg-danger bg-opacity-25 text-danger-emphasis',
                                ];
                            @endphp
                            <span class="status-badge-large {{ $statusClasses[$application->status] ?? 'bg-light text-dark' }}">
                                <i class="bi bi-circle-fill"></i>
                                {{ $application->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resume Section -->
        @if($application->resume_path)
        <div class="resume-section">
            <h6 class="section-title"><i class="bi bi-file-earmark-pdf"></i>Resume</h6>
            @if($application->resume_type === 'builder')
                {{-- Resume Builder Type --}}
                <div class="resume-actions">
                    <button type="button" class="resume-btn btn-outline-info btn-preview-resume">
                        <i class="bi bi-eye-fill"></i>
                        <span>Show Resume</span>
                    </button>
                </div>
                @php
                    $builderResume = $application->user->profile ?? $application->user->userProfile;
                @endphp
                @if($builderResume)
                @php
                    $toText = function ($value): string {
                        if (is_array($value)) {
                            $parts = collect($value)
                                ->flatten()
                                ->filter(fn ($item) => $item !== null && $item !== '')
                                ->map(fn ($item) => is_scalar($item) ? (string) $item : json_encode($item))
                                ->map(fn ($item) => trim((string) $item))
                                ->filter()
                                ->values();

                            return $parts->join(' | ');
                        }

                        if (is_object($value)) {
                            return trim((string) json_encode($value));
                        }

                        return trim((string) $value);
                    };

                    $builderName = $toText($builderResume->resume_name ?? $application->user->name);
                    $builderEmail = $toText($builderResume->resume_email ?? $application->user->email);
                    $builderPhone = $toText($builderResume->phone ?? '');
                    $builderAddress = $toText($builderResume->address ?? '');
                    $builderObjective = $toText($builderResume->objective ?? '');
                    $builderSkills = collect(explode(',', $toText($builderResume->skills ?? '')))
                        ->map(fn ($item) => trim($item))
                        ->filter()
                        ->values();
                    $builderEducationRows = collect(is_array($builderResume->education ?? null) ? $builderResume->education : []);
                    $builderExperienceRows = collect(is_array($builderResume->experience ?? null) ? $builderResume->experience : []);
                    $builderTrainingRows = collect(is_array($builderResume->training ?? null) ? $builderResume->training : []);
                    $builderEligibilityRows = collect(is_array($builderResume->eligibility ?? null) ? $builderResume->eligibility : []);
                @endphp
                <div class="resume-preview" style="display:none; background:#fff; padding:2.25rem; border:1px solid #d9e6f6; border-radius:12px; margin-top:1rem; font-family: Georgia, 'Times New Roman', Times, serif; color:#111827; font-size:12px; line-height:1.55;">
                    <div style="text-align:center; margin-bottom:1rem;">
                        <h4 style="margin:0; font-size:24px; font-weight:700; letter-spacing:0.02em;">{{ $builderName }}</h4>
                        <div style="margin-top:6px; font-size:11px; color:#374151;">
                            {{ collect([$builderAddress, $builderPhone, $builderEmail])->filter()->join(' | ') }}
                        </div>
                    </div>

                    @if($builderObjective !== '')
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Objective</div>
                        <div style="white-space:pre-wrap;">{!! nl2br(e($builderObjective)) !!}</div>
                    </div>
                    @endif

                    @if($builderEducationRows->filter(fn ($row) => collect($row)->filter()->isNotEmpty())->isNotEmpty())
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Education</div>
                        @foreach ($builderEducationRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div style="margin-bottom:10px;">
                                    <div style="display:flex; justify-content:space-between; gap:12px; font-weight:700;">
                                        <div>{{ $item['school'] ?? '' }}</div>
                                        <div>{{ $item['year'] ?? '' }}</div>
                                    </div>
                                    <div style="color:#4b5563; font-style:italic;">{{ $item['course'] ?? '' }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    @if($builderExperienceRows->filter(fn ($row) => collect($row)->filter()->isNotEmpty())->isNotEmpty())
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Experience</div>
                        @foreach ($builderExperienceRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div style="margin-bottom:10px;">
                                    <div style="display:flex; justify-content:space-between; gap:12px; font-weight:700;">
                                        <div>{{ $item['title'] ?? '' }}</div>
                                        <div>{{ $item['period'] ?? $item['from_date'] ?? '' }}</div>
                                    </div>
                                    <div style="color:#4b5563; font-style:italic;">{{ $item['company'] ?? '' }}</div>
                                    <div>{{ $item['details'] ?? '' }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    @if($builderTrainingRows->filter(fn ($row) => collect($row)->filter()->isNotEmpty())->isNotEmpty())
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Training</div>
                        @foreach ($builderTrainingRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div style="margin-bottom:10px;">
                                    <div style="display:flex; justify-content:space-between; gap:12px; font-weight:700;">
                                        <div>{{ $item['course'] ?? '' }}</div>
                                        <div>{{ $item['hours'] ?? '' }}</div>
                                    </div>
                                    <div style="color:#4b5563; font-style:italic;">{{ $item['institution'] ?? '' }}</div>
                                    <div>{{ $item['dates'] ?? '' }}</div>
                                    <div>{{ $item['skills'] ?? '' }}</div>
                                    <div>{{ $item['certificates'] ?? '' }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    @if($builderEligibilityRows->filter(fn ($row) => collect($row)->filter()->isNotEmpty())->isNotEmpty())
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Eligibility</div>
                        @foreach ($builderEligibilityRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div style="margin-bottom:10px;">
                                    <div style="display:flex; justify-content:space-between; gap:12px; font-weight:700;">
                                        <div>{{ $item['eligibility'] ?? '' }}</div>
                                        <div>{{ $item['date_taken'] ?? '' }}</div>
                                    </div>
                                    <div style="color:#4b5563; font-style:italic;">{{ $item['license'] ?? '' }}</div>
                                    <div>{{ $item['valid_until'] ?? '' }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    @if($builderSkills->count())
                    <div style="margin-top:18px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #111827; padding-bottom:3px; margin-bottom:8px;">Skills</div>
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($builderSkills as $skill)
                                <li style="margin-bottom:4px;">{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @endif
            @else
                {{-- Uploaded Resume --}}
                @php
                    $uploadedResumeUrl = Storage::url($application->resume_path);
                    $uploadedResumeExt = strtolower(pathinfo($application->resume_path, PATHINFO_EXTENSION));
                @endphp
                <div class="resume-actions">
                    <button type="button" class="resume-btn btn-outline-info btn-preview-resume">
                        <i class="bi bi-eye-fill"></i>
                        <span>Preview</span>
                    </button>
                </div>
                <div class="resume-preview" style="display:none;">
                    @if(in_array($uploadedResumeExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ $uploadedResumeUrl }}" alt="Uploaded Resume" style="width:100%;height:auto;display:block;">
                    @elseif($uploadedResumeExt === 'pdf')
                        <iframe src="{{ $uploadedResumeUrl }}" frameborder="0" title="Resume Preview"></iframe>
                    @else
                        <div style="padding:1.5rem; background:#fff; border:1px solid #d9e6f6; border-radius:12px;">
                            <p style="margin:0 0 1rem 0; color:#334155; font-weight:600;">Preview is not available for this file type.</p>
                            <a href="{{ $uploadedResumeUrl }}" target="_blank" class="resume-btn btn-outline-secondary">
                                <i class="bi bi-box-arrow-up-right"></i>
                                <span>Open Uploaded File</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        @endif

        <!-- Notes / Cover Letter Section -->
        @if($application->notes)
        <div class="notes-section">
            <h6 class="section-title"><i class="bi bi-chat-left-text"></i>Cover Letter / Notes</h6>
            <div class="notes-content">
                {!! nl2br(e($application->notes)) !!}
            </div>
        </div>
        @endif

        <!-- Status Update Form Section -->
        <div class="form-section">
            <h5><i class="bi bi-pencil-square"></i>Update Application Status</h5>
            <form method="POST" action="{{ route('employer.applications.update', $application->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" id="applicationStatusSelect">
                            @php $s = $application->status; @endphp
                            <option value="pending" {{ $s === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewing" {{ $s === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                            <option value="recommended" {{ $s === 'recommended' ? 'selected' : '' }}>Recommended</option>
                            <option value="interviewed" {{ $s === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                            <option value="hired" {{ $s === 'hired' ? 'selected' : '' }}>Hired</option>
                            <option value="rejected" {{ $s === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group" id="interviewScheduleGroup" style="{{ $application->status === 'interviewed' ? '' : 'display:none;' }}">
                        <label class="form-label">Interview Schedule</label>
                        <input
                            type="datetime-local"
                            name="interview_scheduled_at"
                            id="interviewScheduledAt"
                            class="form-control"
                            value="{{ optional($application->interview_scheduled_at)->format('Y-m-d\\TH:i') }}"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">Feedback (optional)</label>
                        <textarea name="employer_feedback" rows="2" class="form-control" placeholder="Add any feedback for this applicant...">{{ $application->employer_feedback ?? '' }}</textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
// Preview toggle and lazy-load
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-preview-resume');
    if (!btn) return;
    const resumeSection = btn.closest('.resume-section');
    if (!resumeSection) return;
    const preview = resumeSection.querySelector('.resume-preview');
    if (!preview) return;

    const span = btn.querySelector('span');
    if (!span) return;

    // Check if this is an uploaded resume (has iframe/image) or builder resume (plain div)
    const iframe = preview.querySelector('iframe');

    if (preview.style.display === 'none' || preview.style.display === '') {
        preview.style.display = 'block';
        span.textContent = iframe ? 'Hide Preview' : 'Hide Resume';
    } else {
        preview.style.display = 'none';
        span.textContent = iframe ? 'Preview' : 'Show Resume';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('applicationStatusSelect');
    const scheduleGroup = document.getElementById('interviewScheduleGroup');
    const scheduledAtInput = document.getElementById('interviewScheduledAt');

    if (!statusSelect || !scheduleGroup || !scheduledAtInput) {
        return;
    }

    const syncInterviewScheduleVisibility = () => {
        const shouldShow = statusSelect.value === 'interviewed';
        scheduleGroup.style.display = shouldShow ? '' : 'none';
        scheduledAtInput.required = shouldShow;
        if (!shouldShow) {
            scheduledAtInput.value = '';
        }
    };

    statusSelect.addEventListener('change', syncInterviewScheduleVisibility);
    syncInterviewScheduleVisibility();
});
</script>

@endsection

