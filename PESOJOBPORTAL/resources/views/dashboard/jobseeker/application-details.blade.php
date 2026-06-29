@extends('layouts.dashboard')

@section('title', ($job->title ?? 'Application Details') . ' | Jobseeker')

@section('content')
<section aria-label="Application details" class="application-details-page">
    <style>
        .application-details-page {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: linear-gradient(135deg, #f8fbff 0%, #e8f1ff 100%);
            border: 1px solid #d8e4f6;
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .page-title {
            margin: 0;
            font-size: clamp(1.5rem, 2.5vw, 2rem);
            font-weight: 900;
            color: #17365d;
            line-height: 1.2;
        }

        .page-subtitle {
            margin: 0.5rem 0 0;
            color: #5f728b;
            font-size: 0.95rem;
        }

        .detail-card {
            background: #fff;
            border: 1px solid #e5edf8;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(15, 45, 82, 0.06);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 2px solid #e5edf8;
        }

        .job-title {
            margin: 0;
            font-size: clamp(1.3rem, 2vw, 1.75rem);
            font-weight: 900;
            color: #17365d;
            line-height: 1.25;
            flex: 1;
            min-width: 280px;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 1rem;
        }

        .job-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            background: #f3f7ff;
            color: #325c91;
            border: 1px solid #d8e4f6;
            font-size: 0.875rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .job-pill i {
            font-size: 0.9rem;
        }

        .posting-info {
            text-align: right;
            min-width: 140px;
        }

        .posting-label {
            font-size: 0.8rem;
            color: #6d7f98;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .posting-value {
            font-size: 0.95rem;
            color: #17365d;
            font-weight: 700;
        }

        .posting-value.expired {
            color: #dc2626;
        }

        .posting-value.active {
            color: #16a34a;
        }

        .section-title {
            margin: 0 0 1rem;
            font-size: 0.85rem;
            font-weight: 900;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #5f728b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5edf8;
            margin-left: 0.5rem;
        }

        .detail-text {
            color: #4f6178;
            line-height: 1.75;
            white-space: pre-line;
            font-size: 0.95rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .info-card {
            background: #f8fbff;
            border: 1px solid #e5edf8;
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }

        .info-card:hover {
            background: #f0f7ff;
            border-color: #d0e2f8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 45, 82, 0.08);
        }

        .info-label {
            color: #6d7f98;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.5rem;
        }

        .info-value {
            color: #17365d;
            font-weight: 800;
            font-size: 1.05rem;
            word-break: break-word;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #2f6fd5;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
            background: #fff;
            border: 1px solid #d8e4f6;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            background: #f3f7ff;
            border-color: #2f6fd5;
            transform: translateX(-4px);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 800;
            font-size: 0.875rem;
            letter-spacing: 0.02em;
        }

        .status-badge.warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .status-badge.info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .status-badge.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .status-badge.primary {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .status-badge.danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .status-badge.secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .application-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .application-meta-item {
            background: #f8fbff;
            border: 1px solid #e5edf8;
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }

        .application-meta-item:hover {
            background: #f0f7ff;
            border-color: #d0e2f8;
        }

        .application-meta-item .info-label {
            margin-bottom: 0.4rem;
        }

        .application-meta-item .info-value {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notes-card {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fcd34d;
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1.25rem;
        }

        .notes-card .info-label {
            color: #92400e;
            margin-bottom: 0.75rem;
        }

        .notes-card .detail-text {
            color: #78350f;
            font-style: italic;
        }

        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5edf8, transparent);
            margin: 1.5rem 0;
        }

        @media (max-width: 991.98px) {
            .card-header {
                flex-direction: column;
                gap: 1rem;
            }

            .posting-info {
                text-align: left;
                width: 100%;
                display: flex;
                gap: 1.5rem;
                flex-wrap: wrap;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .application-meta {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .detail-card {
                padding: 1.25rem;
            }

            .page-header {
                padding: 1.25rem;
            }

            .job-meta {
                flex-direction: column;
            }

            .job-pill {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>

    <a href="{{ route('jobseeker.applications') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back to Applications
    </a>

    <div class="application-details-page">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">{{ $job->title ?? 'Job no longer available' }}</h1>
            <p class="page-subtitle">Application details and job information</p>
        </div>

        <!-- Job Details Card -->
        <article class="detail-card">
            <div class="card-header">
                <div style="flex: 1;">
                    <h2 class="job-title">{{ $job->title ?? 'Job no longer available' }}</h2>
                    <div class="job-meta">
                        <span class="job-pill">
                            <i class="bi bi-building"></i>
                            {{ $job->employer_name ?? 'Employer unavailable' }}
                        </span>
                        <span class="job-pill">
                            <i class="bi bi-geo-alt"></i>
                            {{ $job->location ?? 'Location unavailable' }}
                        </span>
                        <span class="job-pill">
                            <i class="bi bi-clock"></i>
                            {{ ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A')) }}
                        </span>
                        @if($job->salary_range)
                            <span class="job-pill">
                                <i class="bi bi-cash-stack"></i>
                                {{ $job->salary_range }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="posting-info">
                    <div class="posting-label">Posted</div>
                    <div class="posting-value">{{ $job->created_at?->diffForHumans() ?? 'N/A' }}</div>
                    @if($job->application_end_date)
                        <div class="posting-label" style="margin-top: 0.75rem;">Deadline</div>
                        <div class="posting-value {{ $job->application_end_date->isPast() ? 'expired' : 'active' }}">
                            {{ $job->application_end_date->isPast() ? 'Expired' : $job->application_end_date->format('M d, Y') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="detail-section">
                <h3 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Job Description
                </h3>
                <div class="detail-text">{{ $job->description ?? 'No description provided.' }}</div>
            </div>

            <div class="divider"></div>

            <div class="detail-section">
                <h3 class="section-title">
                    <i class="bi bi-check-circle"></i>
                    Qualifications
                </h3>
                <div class="detail-text">{{ $job->qualifications ?? 'No qualifications listed.' }}</div>
            </div>

            @if(! empty($job->key_responsibilities))
                <div class="divider"></div>
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="bi bi-list-check"></i>
                        Key Responsibilities
                    </h3>
                    <div class="detail-text">{{ $job->key_responsibilities }}</div>
                </div>
            @endif

            @if(! empty($job->preferred_skills))
                <div class="divider"></div>
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="bi bi-star"></i>
                        Preferred Skills
                    </h3>
                    <div class="detail-text">{{ $job->preferred_skills }}</div>
                </div>
            @endif

            <div class="divider"></div>

            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">Company</div>
                    <div class="info-value">{{ $job->employer_name ?? 'N/A' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Vacancies</div>
                    <div class="info-value">{{ $job->vacancies ?? 1 }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Employment Type</div>
                    <div class="info-value">{{ ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A')) }}</div>
                </div>
                @if($job->salary_range)
                    <div class="info-card">
                        <div class="info-label">Salary Range</div>
                        <div class="info-value">{{ $job->salary_range }}</div>
                    </div>
                @endif
            </div>
        </article>

        <!-- Application Status Card -->
        <article class="detail-card">
            <h2 class="job-title" style="font-size: 1.3rem; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 2px solid #e5edf8;">
                <i class="bi bi-clipboard-check" style="color: #2f6fd5;"></i>
                Application Status
            </h2>

            <div class="application-meta">
                <div class="application-meta-item">
                    <div class="info-label">Current Status</div>
                    <div class="info-value">
                        <span class="status-badge {{ $statusClass }}">
                            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
                <div class="application-meta-item">
                    <div class="info-label">Applied On</div>
                    <div class="info-value">
                        <i class="bi bi-calendar-check" style="color: #2f6fd5;"></i>
                        {{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}
                    </div>
                </div>
                <div class="application-meta-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">
                        <i class="bi bi-clock-history" style="color: #2f6fd5;"></i>
                        {{ $application->updated_at?->diffForHumans() ?? 'N/A' }}
                    </div>
                </div>
                @if($application->interview_scheduled_at)
                    <div class="application-meta-item" style="background: #eff6ff; border-color: #3b82f6;">
                        <div class="info-label" style="color: #1e40af;">
                            <i class="bi bi-calendar-event" style="color: #2563eb;"></i>
                            Interview Scheduled
                        </div>
                        <div class="info-value" style="color: #1e3a8a;">
                            <i class="bi bi-clock" style="color: #2563eb;"></i>
                            {{ $application->interview_scheduled_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                @endif
                @if($application->resume_original_filename)
                    <div class="application-meta-item">
                        <div class="info-label">Resume Submitted</div>
                        <div class="info-value">
                            <i class="bi bi-file-earmark-text" style="color: #2f6fd5;"></i>
                            {{ $application->resume_original_filename }}
                        </div>
                    </div>
                @endif
            </div>

            @if(! empty($application->notes))
                <div class="notes-card">
                    <div class="info-label">
                        <i class="bi bi-chat-square-text"></i>
                        Your Cover Letter / Notes
                    </div>
                    <div class="detail-text">{{ $application->notes }}</div>
                </div>
            @endif
        </article>
    </div>
</section>
@endsection
