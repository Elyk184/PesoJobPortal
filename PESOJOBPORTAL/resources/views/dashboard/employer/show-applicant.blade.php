@extends('dashboard.employer.layout')

@section('title', 'Applicant Details - PESO')
@section('page-title', 'Applicant Details')
@section('page-subtitle', 'Review and manage this applicant')

@push('styles')
<style>
    .applicant-show-page {
        --as-primary: #1f4f8f;
        --as-primary-deep: #153a69;
        --as-border: #d8e6f6;
        --as-soft-bg: #f4f8ff;
    }
    .profile-header {
        background: linear-gradient(135deg, #2e5bff 0%, #1a3db8 55%, #2750d5 100%);
        color: white;
        padding: 2.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 16px 30px rgba(30, 70, 180, 0.28);
    }
    .info-card {
        background: white;
        border-radius: 14px;
        border: 1px solid var(--as-border);
        box-shadow: 0 10px 24px rgba(21, 58, 105, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .section-title {
        color: var(--as-primary-deep);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 1.05rem;
    }
    .label-muted {
        color: #637892;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 0.5rem;
        display: block;
    }
    .status-chip {
        padding: 0.42rem 0.82rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .status-chip::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.8;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-reviewing { background: #e0e7ff; color: #4338ca; }
    .status-shortlisted { background: #dbeafe; color: #1d4ed8; }
    .status-interview { background: #fef3c7; color: #92400e; }
    .status-hired { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }
    .meta-card {
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 12px;
        padding: 0.65rem 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.8rem;
        font-weight: 600;
        color: #f7fbff;
    }
    .star-rating {
        display: inline-flex;
        gap: 5px;
    }
    .star-rating i {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        transition: color 0.2s;
    }
    .star-rating i.active,
    .star-rating i:hover {
        color: #ffc107;
    }
    .form-select,
    .form-control {
        border-color: #c8daf2;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        height: auto;
        font-size: 0.95rem;
    }
    .form-select:focus,
    .form-control:focus {
        border-color: #2b67b1;
        box-shadow: 0 0 0 3px rgba(43, 103, 177, 0.14);
    }
    .right-sticky {
        position: sticky;
        top: 96px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .btn-primary {
        background: #2b67b1;
        border: none;
        color: white;
        box-shadow: 0 4px 12px rgba(43, 103, 177, 0.2);
    }
    .btn-primary:hover {
        background: #1f4f8f;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43, 103, 177, 0.3);
    }
    .btn-outline-primary {
        border-color: #2b67b1;
        color: #2b67b1;
        background: white;
    }
    .btn-outline-primary:hover {
        background: #2b67b1;
        color: white;
        border-color: #2b67b1;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43, 103, 177, 0.2);
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #2b67b1 !important;
        box-shadow: 0 0 0 3px rgba(43, 103, 177, 0.15) !important;
    }
    textarea.form-control {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .alert {
        border-radius: 12px;
        border: 1px solid currentColor;
        opacity: 0.95;
    }
    @media (max-width: 991.98px) {
        .profile-header {
            padding: 1.75rem 1.5rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
        }
        .profile-header .d-flex {
            align-items: flex-start !important;
            gap: 1rem;
        }
        .info-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .right-sticky {
            position: static;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="applicant-show-page">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
@endif

<<<<<<< HEAD
<div class="row">
    <div class="col-lg-8">
        <div class="profile-header">
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar" style="width: 90px; height: 90px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-person text-white" style="font-size: 2.75rem;"></i>
                </div>
                <div style="flex: 1;">
                    <h3 style="margin: 0 0 0.35rem 0; font-size: 1.65rem; font-weight: 800;">{{ $application->applicant->name }}</h3>
                    <p style="margin: 0 0 1rem 0; opacity: 0.9; font-size: 0.95rem;">{{ $application->applicant->email ?? 'No email on file' }}</p>
                    <div class="meta-card">
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Applied for: {{ $application->jobPost->title }}</span>
=======
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
>>>>>>> 4c1b10f7917f5f74f5f74f58d2bd187f69cb4e99
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card">
            <h5 class="mb-3 section-title"><i class="bi bi-file-earmark-text text-primary"></i>Application Details</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <span class="label-muted">Applied Date</span>
                    <p class="mb-0" style="font-weight: 600; font-size: 0.95rem;">{{ $application->applied_at->format('F d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <span class="label-muted">Current Status</span>
                    <div>
                        @switch($application->status)
                            @case('pending')
                                <span class="status-chip status-pending">Pending</span>
                                @break
                            @case('reviewing')
                                <span class="status-chip status-reviewing">Reviewing</span>
                                @break
                            @case('shortlisted')
                                <span class="status-chip status-shortlisted">Shortlisted</span>
                                @break
                            @case('interview')
                                <span class="status-chip status-interview">Interview</span>
                                @break
                            @case('hired')
                                <span class="status-chip status-hired">Hired</span>
                                @break
                            @case('rejected')
                                <span class="status-chip status-rejected">Rejected</span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
            @if($application->cover_letter)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--as-border);">
                <span class="label-muted">Cover Letter / Notes</span>
                <p class="mb-0" style="font-size: 0.95rem; line-height: 1.6; color: #334155;">{{ $application->cover_letter }}</p>
            </div>
            @endif
            @if($application->resume_path)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--as-border);">
                <a href="{{ route('employer.applications.resume.download', $application->id) }}" class="btn btn-primary">
                    <i class="bi bi-download"></i> Download Resume
                </a>
            </div>
            @endif
        </div>

        <div class="info-card">
            <h5 class="mb-3 section-title"><i class="bi bi-chat-dots text-primary"></i>Leave Feedback</h5>

            @if($feedback)
            <div class="alert alert-info mb-4" style="background: #dbeafe; border-color: #93c5fd; color: #1e40af; border-radius: 12px; padding: 1rem;">
                <h6 class="alert-heading mb-2" style="font-weight: 700;">Previous Feedback</h6>
                <p class="mb-2">{{ $feedback->feedback }}</p>
                @if($feedback->rating)
                <div style="margin-bottom: 0.5rem;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}" style="color: #ffc107; font-size: 0.9rem;"></i>
                    @endfor
                </div>
                @endif
                <small style="opacity: 0.85;">Type: {{ ucfirst(str_replace('_', ' ', $feedback->feedback_type)) }}</small>
            </div>
            @endif

            <form id="feedbackForm" action="{{ route('employer.applications.feedback', $application->id) }}" method="POST">
                @csrf
<<<<<<< HEAD
                <div class="mb-4">
                    <label class="form-label">Feedback Type</label>
                    <select id="feedbackType" name="feedback_type" class="form-select" required>
                        <option value="">Select feedback type</option>
                        <option value="interview_experience">Interview Experience</option>
                        <option value="job_performance">Job Performance</option>
                        <option value="professionalism">Professionalism</option>
                        <option value="general">General Feedback</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Rating (Optional)</label>
                    <div class="star-rating" id="starRating">
                        <i class="bi bi-star" data-value="1" onclick="setRating(1)"></i>
                        <i class="bi bi-star" data-value="2" onclick="setRating(2)"></i>
                        <i class="bi bi-star" data-value="3" onclick="setRating(3)"></i>
                        <i class="bi bi-star" data-value="4" onclick="setRating(4)"></i>
                        <i class="bi bi-star" data-value="5" onclick="setRating(5)"></i>
=======
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
>>>>>>> 4c1b10f7917f5f74f5f74f58d2bd187f69cb4e99
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="">
                </div>
                <div class="mb-4">
                    <label class="form-label">Feedback</label>
                    <textarea id="feedbackText" name="feedback" class="form-control" rows="4" placeholder="Write your feedback about this applicant..." required style="resize: vertical;"></textarea>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="right-sticky">
        <div class="info-card">
            <h5 class="mb-4 section-title"><i class="bi bi-pencil-square text-primary"></i>Update Status</h5>
            <form id="statusForm" action="{{ route('employer.applications.update', $application->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="statusSelect" onchange="toggleInterviewDate()">
                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Not Selected</option>
                    </select>
                </div>
                <div class="mb-4" id="interviewDateField" style="display: {{ $application->status == 'interview' ? 'block' : 'none' }};">
                    <label class="form-label">Interview Date & Time</label>
                    <input type="datetime-local" name="interview_scheduled_at" class="form-control" value="{{ $application->interview_scheduled_at ? $application->interview_scheduled_at->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="mb-4">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Add notes about this applicant..." style="resize: vertical;">{{ $application->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg"></i> Update Status
                </button>
            </form>
        </div>

        <div class="info-card">
            <h5 class="mb-4 section-title"><i class="bi bi-briefcase text-primary"></i>Job Information</h5>
            <div style="padding: 0.5rem 0;">
                <p style="margin: 0 0 0.75rem 0; font-weight: 700; font-size: 1rem; color: #0f172a;">{{ $application->jobPost->title }}</p>
                <p style="margin: 0 0 0.5rem 0; color: #637892; font-size: 0.9rem;"><i class="bi bi-geo-alt me-2" style="color: #075cb2;"></i>{{ $application->jobPost->location }}</p>
                <p style="margin: 0; color: #637892; font-size: 0.9rem;"><i class="bi bi-briefcase me-2" style="color: #075cb2;"></i>{{ ucfirst(str_replace('_', ' ', $application->jobPost->employment_type)) }}</p>
            </div>
            <hr style="margin: 1.25rem 0;">
            <a href="{{ route('employer.jobs.manage') }}" class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-arrow-left"></i> Back to Jobs
            </a>
        </div>
        </div>
    </div>
</div>
</div>
<<<<<<< HEAD
=======

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

>>>>>>> 4c1b10f7917f5f74f5f74f58d2bd187f69cb4e99
@endsection

@push('scripts')
<script>
    function toggleInterviewDate() {
        const status = document.getElementById('statusSelect').value;
        const interviewField = document.getElementById('interviewDateField');
        if (status === 'interview') {
            interviewField.style.display = 'block';
        } else {
            interviewField.style.display = 'none';
        }
    }

    function setRating(value) {
        document.getElementById('ratingInput').value = value;
        const stars = document.querySelectorAll('#starRating i');
        stars.forEach((star, index) => {
            if (index < value) {
                star.classList.add('bi-star-fill');
                star.classList.remove('bi-star');
                star.style.color = '#ffc107';
            } else {
                star.classList.remove('bi-star-fill');
                star.classList.add('bi-star');
                star.style.color = '#ddd';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const feedbackForm = document.getElementById('feedbackForm');
        const statusForm = document.getElementById('statusForm');

        if (!statusForm) return;

        statusForm.addEventListener('submit', async function (e) {
            if (!feedbackForm) return; // nothing to copy

            const feedbackText = (feedbackForm.querySelector('textarea[name="feedback"]') || {}).value || '';
            const feedbackType = (feedbackForm.querySelector('select[name="feedback_type"]') || {}).value || '';
            const rating = (feedbackForm.querySelector('input[name="rating"]') || {}).value || '';

            // If there's feedback or rating or type selected, attempt to save it first
            if (feedbackText.trim().length > 0 || rating || feedbackType) {
                e.preventDefault();
                const data = new FormData(feedbackForm);
                try {
                    await fetch(feedbackForm.action, {
                        method: 'POST',
                        body: data,
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                } catch (err) {
                    console.error('Failed to save feedback before status update', err);
                }
                // continue with status update regardless of result
                statusForm.submit();
            }
        });
    });
</script>
@endpush

