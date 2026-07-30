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
    .profile-top-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .profile-main {
        flex: 1;
        min-width: 230px;
    }
    .profile-meta-wrap {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 0.6rem;
    }
    .user-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: linear-gradient(135deg,#6ea8ff,#2b67b1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 1.8rem;
        flex-shrink: 0;
    }
    .user-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
    .user-initials { font-size: 1.25rem; }
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
    .meta-card i {
        font-size: 0.95rem;
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
    .star-rating i:focus { outline: 3px solid rgba(255,193,7,0.18); border-radius:4px; }
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
    .interview-schedule-pane {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 3px solid #ff9800;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
    }
    .interview-popup {
        position: fixed;
        inset: 0;
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: rgba(15, 23, 42, 0.55);
    }
    .interview-popup.is-open {
        display: flex;
    }
    .interview-popup-card {
        width: 100%;
        max-width: 560px;
        border-radius: 16px;
        border: 3px solid #ff9800;
        background: #fffbf0;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
        overflow: hidden;
    }
    @media (max-width: 991.98px) {
        .profile-header {
            padding: 1.75rem 1.5rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
        }
        .user-avatar { width:72px; height:72px; }
        .profile-header .d-flex {
            align-items: flex-start !important;
            gap: 1rem;
        }
        .profile-top-row {
            align-items: flex-start;
            gap: 0.75rem;
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
    @media (max-width: 575.98px) {
        .right-sticky { position: static; }
        .profile-header { padding-bottom: 1.25rem; }
        .meta-card {
            width: 100%;
            justify-content: flex-start;
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

<div class="row">
    <div class="col-lg-8">
        <div class="profile-header">
            <div class="d-flex align-items-center gap-3">
                @if(!empty($application->applicant->avatar))
                    <div class="user-avatar">
                        <img src="{{ Storage::url($application->applicant->avatar) }}" alt="{{ $application->applicant->name }}">
                    </div>
                @else
                    <div class="user-avatar user-initials" aria-hidden="true">{{ strtoupper(substr($application->applicant->name ?? '', 0, 1)) }}</div>
                @endif
                <div class="profile-main">
                    <div class="profile-top-row">
                        <div>
                            <h3 style="margin: 0 0 0.35rem 0; font-size: 1.65rem; font-weight: 800;">{{ $application->applicant->name }}</h3>
                            <p style="margin: 0; opacity: 0.9; font-size: 0.95rem;">{{ $application->applicant->email ?? 'No email on file' }}</p>
                        </div>
                        <div>
                            @php
                                $sclass = match($application->status) {
                                    'pending' => 'status-pending',
                                    'reviewing' => 'status-reviewing',
                                    'recommended' => 'status-shortlisted',
                                    'interviewed' => 'status-interview',
                                    'hired' => 'status-hired',
                                    'rejected' => 'status-rejected',
                                    default => 'status-pending'
                                };
                            @endphp
                            <span class="status-chip {{ $sclass }}" aria-label="Application status: {{ $application->status }}">{{ ucfirst($application->status) }}</span>
                        </div>
                    </div>

                    <div class="profile-meta-wrap">
                        <div class="meta-card" aria-hidden="true">
                            <i class="bi bi-briefcase-fill"></i>
                            <span>Applied for: {{ $application->jobPost->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card">
            <h5 class="mb-3 section-title"><i class="bi bi-file-earmark-text text-primary"></i>Application Details</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <span class="label-muted">Applied Date</span>
                    <p class="mb-0" style="font-weight: 600; font-size: 0.95rem;">{{ optional($application->applied_at)->format('F d, Y') }}</p>
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
                            @case('recommended')
                                <span class="status-chip status-shortlisted">Recommended</span>
                                @break
                            @case('interviewed')
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

            @if($application->resume_path)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--as-border);">
                <a href="{{ route('employer.applications.resume.download', $application->id) }}" class="btn btn-primary">
                    <i class="bi bi-download"></i> Download Resume
                </a>
            </div>
            @endif

            @if($application->cover_letter)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--as-border);">
                <span class="label-muted">Cover Letter</span>
                <p class="mb-0" style="font-size: 0.95rem; line-height: 1.6; color: #334155;">{{ $application->cover_letter }}</p>
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
                <div class="mb-4">
                    <label class="form-label">Feedback Type</label>
                    <select id="feedbackType" name="feedback_type" class="form-select">
                        <option value="">Select feedback type</option>
                        <option value="interview_experience">Interview Experience</option>
                        <option value="job_performance">Job Performance</option>
                        <option value="professionalism">Professionalism</option>
                        <option value="general">General Feedback</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Rating (Optional)</label>
                    <div class="star-rating" id="starRating" role="radiogroup" aria-label="Rating">
                        <i class="bi bi-star" data-value="1" role="radio" tabindex="0" aria-checked="false" aria-label="1 star" onclick="setRating(1)"></i>
                        <i class="bi bi-star" data-value="2" role="radio" tabindex="0" aria-checked="false" aria-label="2 stars" onclick="setRating(2)"></i>
                        <i class="bi bi-star" data-value="3" role="radio" tabindex="0" aria-checked="false" aria-label="3 stars" onclick="setRating(3)"></i>
                        <i class="bi bi-star" data-value="4" role="radio" tabindex="0" aria-checked="false" aria-label="4 stars" onclick="setRating(4)"></i>
                        <i class="bi bi-star" data-value="5" role="radio" tabindex="0" aria-checked="false" aria-label="5 stars" onclick="setRating(5)"></i>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="">
                </div>
                <div class="mb-4">
                    <label class="form-label">Feedback</label>
                    <textarea id="feedbackText" name="feedback" class="form-control" rows="4" placeholder="Write your feedback about this applicant..." style="resize: vertical;"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    @if($application->resume_path)
                        <a href="{{ route('employer.applications.resume.download', $application->id) }}" class="btn btn-outline-primary">Download Resume</a>
                    @endif
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
                    <select name="status" class="form-select" id="statusSelect" onchange="window.__handleInterviewStatusChange && window.__handleInterviewStatusChange(this.value)">
                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="recommended" {{ $application->status == 'recommended' ? 'selected' : '' }}>Recommended</option>
                        <option value="interviewed" {{ $application->status == 'interviewed' ? 'selected' : '' }}>Interview</option>
                        <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Not Selected</option>
                    </select>
                </div>
                <div id="interviewScheduleModal" class="interview-popup" aria-hidden="true">
                    <div class="interview-popup-card" role="dialog" aria-modal="true" aria-labelledby="interviewScheduleModalLabel">
                        <div class="modal-header" style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%); border-bottom: 2px solid #ffc107;">
                            <h5 class="modal-title" id="interviewScheduleModalLabel" style="font-weight: 700; color: #856404; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="bi bi-calendar-event-fill" style="font-size: 1.3rem;"></i>
                                📅 Schedule Interview
                            </h5>
                            <button type="button" class="btn-close" id="closeInterviewModal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 1.5rem; background: #fffbf0;">
                            <div class="mb-3">
                                <label for="interviewScheduledAt" class="form-label" style="font-weight: 600; color: #856404; margin-bottom: 0.5rem; display: block;">Interview Date & Time <span style="color: #dc3545;">*</span></label>
                                <input type="datetime-local" name="interview_scheduled_at" id="interviewScheduledAt" class="form-control" value="{{ $application->interview_scheduled_at ? $application->interview_scheduled_at->format('Y-m-d\\TH:i') : '' }}" style="border-radius: 10px; padding: 0.85rem 1rem; font-size: 1rem; border-color: #ffc107; background-color: #fff;">
                                <small style="margin-top: 0.5rem; display: block; color: #856404; font-weight: 500;">⏰ Select the date and time for the interview.</small>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #fffbf0; border-top: 1px solid #ffc107;">
                            <button type="button" class="btn btn-secondary" id="cancelInterviewSchedule">Cancel</button>
                            <button type="button" class="btn btn-warning" id="saveInterviewDate" style="background: #ff9800; border-color: #ff9800; font-weight: 600;">
                                <i class="bi bi-check-lg"></i> Save Interview Date
                            </button>
                        </div>
                    </div>
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
@endsection

@push('scripts')
<script>
    function showInterviewModal() {
        const status = String(document.getElementById('statusSelect')?.value || '').trim();
        if (status !== 'interviewed') return;

        const interviewModalEl = document.getElementById('interviewScheduleModal');
        const interviewDateInput = document.getElementById('interviewScheduledAt');
        if (!interviewModalEl) return;

        if (interviewDateInput && !interviewDateInput.value) {
            const now = new Date();
            now.setHours(now.getHours() + 1);
            now.setMinutes(0);
            const localIso = new Date(now.getTime() - (now.getTimezoneOffset() * 60000)).toISOString().slice(0, 16);
            interviewDateInput.value = localIso;
        }

        interviewModalEl.classList.add('is-open');
        interviewModalEl.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    function hideInterviewModal() {
        const interviewModalEl = document.getElementById('interviewScheduleModal');
        if (!interviewModalEl) return;

        interviewModalEl.classList.remove('is-open');
        interviewModalEl.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    function setRating(value) {
        const input = document.getElementById('ratingInput');
        if (input) input.value = value;
        const stars = Array.from(document.querySelectorAll('#starRating i'));
        stars.forEach((star, index) => {
            const active = index < value;
            star.classList.toggle('bi-star-fill', active);
            star.classList.toggle('bi-star', !active);
            star.style.color = active ? '#ffc107' : '#ddd';
            star.setAttribute('aria-checked', active ? 'true' : 'false');
        });
    }

    function initInterviewScheduler() {
        const statusSelect = document.getElementById('statusSelect');
        const feedbackForm = document.getElementById('feedbackForm');
        const statusForm = document.getElementById('statusForm');

        hideInterviewModal();

        window.__handleInterviewStatusChange = function (value) {
            if (String(value || '').trim() === 'interviewed') {
                showInterviewModal();
            } else {
                hideInterviewModal();
            }
        };

        if (statusSelect) {
            statusSelect.addEventListener('change', function () {
                window.__handleInterviewStatusChange(this.value);
            });
        }

        const closeInterviewModalBtn = document.getElementById('closeInterviewModal');
        const cancelInterviewScheduleBtn = document.getElementById('cancelInterviewSchedule');
        if (closeInterviewModalBtn) {
            closeInterviewModalBtn.addEventListener('click', hideInterviewModal);
        }
        if (cancelInterviewScheduleBtn) {
            cancelInterviewScheduleBtn.addEventListener('click', hideInterviewModal);
        }

        const saveInterviewDateBtn = document.getElementById('saveInterviewDate');
        if (saveInterviewDateBtn) {
            saveInterviewDateBtn.addEventListener('click', function () {
                hideInterviewModal();
            });
        }

        if (statusForm && feedbackForm) {
            statusForm.addEventListener('submit', async function (e) {
                const status = document.getElementById('statusSelect')?.value;
                const interviewDate = document.getElementById('interviewScheduledAt')?.value;

                // Validate interview date is required when status is interviewed
                if (status === 'interviewed' && !interviewDate) {
                    e.preventDefault();
                    alert('Please select an interview date and time before updating the status to Interview.');
                    showInterviewModal();
                    document.getElementById('interviewScheduledAt')?.focus();
                    return;
                }

                const feedbackText = (feedbackForm.querySelector('textarea[name="feedback"]') || {}).value || '';
                const feedbackType = (feedbackForm.querySelector('select[name="feedback_type"]') || {}).value || '';
                const rating = (feedbackForm.querySelector('input[name="rating"]') || {}).value || '';

                if (feedbackText.trim().length > 0 || rating || feedbackType) {
                    e.preventDefault();

                    // Validate interview date before submitting feedback
                    if (status === 'interviewed' && !interviewDate) {
                        alert('Please select an interview date and time before updating the status to Interview.');
                        showInterviewModal();
                        document.getElementById('interviewScheduledAt')?.focus();
                        return;
                    }

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
                    statusForm.submit();
                }
            });
        }

        // keyboard support for star-rating
        const stars = document.querySelectorAll('#starRating i[role="radio"]');
        stars.forEach(st => {
            st.addEventListener('keydown', function (ev) {
                if (ev.key === 'Enter' || ev.key === ' ') {
                    ev.preventDefault();
                    const v = Number(this.getAttribute('data-value')) || 0;
                    setRating(v);
                }
                if (ev.key === 'ArrowLeft' || ev.key === 'ArrowDown') {
                    ev.preventDefault();
                    const prev = this.previousElementSibling;
                    if (prev) prev.focus();
                }
                if (ev.key === 'ArrowRight' || ev.key === 'ArrowUp') {
                    ev.preventDefault();
                    const next = this.nextElementSibling;
                    if (next) next.focus();
                }
            });
            st.addEventListener('focus', function () { this.classList.add('focus-visible'); });
            st.addEventListener('blur', function () { this.classList.remove('focus-visible'); });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInterviewScheduler);
    } else {
        initInterviewScheduler();
    }
</script>
@endpush
