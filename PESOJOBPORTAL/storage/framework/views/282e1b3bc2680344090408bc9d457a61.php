<?php $__env->startSection('title', ($job->title ?? 'Application Details') . ' | Jobseeker'); ?>

<?php $__env->startSection('content'); ?>
<section aria-label="Application details" class="application-details-page">
    <style>
        .application-details-page {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .application-details-page::before,
        .application-details-page::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            filter: blur(0);
            z-index: -1;
            pointer-events: none;
        }

        .application-details-page::before {
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(47, 111, 213, 0.15) 0%, rgba(47, 111, 213, 0) 70%);
            top: -70px;
            right: -40px;
        }

        .application-details-page::after {
            width: 190px;
            height: 190px;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.12) 0%, rgba(22, 163, 74, 0) 70%);
            bottom: 60px;
            left: -45px;
        }

        .page-header {
            background: linear-gradient(135deg, #f8fbff 0%, #e8f1ff 100%);
            border: 1px solid #d8e4f6;
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::after {
            content: '';
            position: absolute;
            inset: auto -30px -30px auto;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(23, 54, 93, 0.16) 0%, rgba(23, 54, 93, 0) 75%);
            pointer-events: none;
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

        .page-header-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 1rem;
        }

        .header-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.48rem 0.82rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid #cfe0f7;
            background: rgba(255, 255, 255, 0.85);
            color: #2f4f79;
        }

        .header-chip i {
            color: #2f6fd5;
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .summary-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 0.9rem;
            margin-top: 1.25rem;
        }

        .summary-item {
            border-radius: 12px;
            border: 1px solid #d9e8fb;
            background: linear-gradient(165deg, #ffffff 0%, #f6faff 100%);
            padding: 0.9rem 1rem;
        }

        .summary-item .info-label {
            margin-bottom: 0.2rem;
        }

        .summary-item .summary-value {
            color: #153a69;
            font-weight: 900;
            font-size: 0.96rem;
        }

        .status-progress {
            margin-bottom: 1.1rem;
            padding: 1.1rem;
            border: 1px solid #dbe8f9;
            border-radius: 14px;
            background: linear-gradient(180deg, #fbfdff 0%, #f4f9ff 100%);
        }

        .status-progress-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #5f728b;
            font-weight: 800;
            margin-bottom: 0.8rem;
        }

        .status-steps {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 0.65rem;
            position: relative;
            align-items: start;
        }

        .status-step {
            text-align: center;
            position: relative;
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .status-step-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin: 0 auto 0.45rem;
            border: 2px solid #bdd3f0;
            background: #fff;
            display: grid;
            place-items: center;
            font-size: 0.55rem;
            color: transparent;
            font-weight: 900;
        }

        .status-step-text {
            font-size: 0.72rem;
            font-weight: 700;
            color: #6d7f98;
            line-height: 1.2;
            min-height: 2.1em;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            text-align: center;
        }

        .status-step.complete .status-step-dot {
            background: #1f7ae0;
            border-color: #1f7ae0;
            color: #fff;
        }

        .status-step.complete .status-step-text {
            color: #1d4d84;
        }

        .status-step.active .status-step-dot {
            border-color: #1f7ae0;
            box-shadow: 0 0 0 4px rgba(31, 122, 224, 0.16);
        }

        .status-step.active .status-step-text {
            color: #17365d;
        }

        .status-step.rejected .status-step-dot {
            border-color: #dc2626;
            background: #fee2e2;
            color: #dc2626;
        }

        .status-step.rejected .status-step-text {
            color: #991b1b;
        }

        .status-step::after {
            content: '';
            position: absolute;
            left: calc(50% + 12px);
            top: 9px;
            width: calc(100% - 24px);
            height: 2px;
            background: #d7e4f6;
            z-index: -1;
        }

        .status-step:last-child::after {
            display: none;
        }

        .status-step.complete::after {
            background: #1f7ae0;
        }

        .rejection-alert {
            margin-top: 0.9rem;
            border-radius: 12px;
            border: 1px solid #fecaca;
            background: #fff5f5;
            color: #9f1239;
            padding: 0.8rem 0.95rem;
            font-size: 0.88rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .application-meta-item {
            background: linear-gradient(180deg, #fbfdff 0%, #f4f9ff 100%);
            border: 1px solid #dbe7f6;
            border-radius: 16px;
            padding: 1.35rem;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-height: 108px;
            box-shadow: 0 8px 22px rgba(21, 58, 105, 0.06);
        }

        .application-meta-item--wide {
            grid-column: 1 / -1;
            padding: 1.45rem 1.5rem;
            background: linear-gradient(135deg, #eaf2ff 0%, #dbeafe 100%);
            border-color: #86b7fe;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.12);
        }

        .application-meta-item:hover {
            background: #f0f7ff;
            border-color: #d0e2f8;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(21, 58, 105, 0.1);
        }

        .application-meta-item .info-label {
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 0.77rem;
            font-weight: 800;
            color: #6d82a1;
        }

        .application-meta-item .info-value {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 1.6rem;
            flex-wrap: wrap;
            line-height: 1.35;
        }

        .application-meta-item--wide .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1e40af;
            font-size: 0.78rem;
        }

        .application-meta-item--wide .info-value {
            color: #1e3a8a;
            font-size: 1.02rem;
            font-weight: 900;
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
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .status-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                row-gap: 1rem;
            }

            .status-step::after {
                display: none;
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

            .page-header-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* UI alignment enhancements */
        .page-header {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            align-items: flex-start;
        }

        .card-header {
            align-items: center;
            gap: 1rem;
        }

        .posting-info {
            text-align: right;
            min-width: 160px;
        }

        .info-grid .info-card,
        .summary-strip .summary-item,
        .application-meta-item {
            min-height: 72px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .summary-strip {
            align-items: stretch;
        }

        .summary-item .summary-value {
            text-align: center;
        }

        .application-meta-item .info-value {
            align-items: center;
            gap: 0.5rem;
        }

        .back-link {
            vertical-align: middle;
        }

        .detail-text {
            word-break: break-word;
        }

        @media (max-width: 991.98px) {
            .posting-info {
                text-align: left;
            }

            .card-header {
                align-items: flex-start;
            }

            .application-meta {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .posting-info {
                text-align: left;
            }

            .application-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <a href="<?php echo e(route('jobseeker.applications')); ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Back to Applications
    </a>

    <div class="application-details-page">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title"><?php echo e($job->title ?? 'Job no longer available'); ?></h1>
            <p class="page-subtitle">Application details and job information</p>
            <div class="page-header-meta">
                <span class="header-chip">
                    <i class="bi bi-patch-check"></i>
                    <?php echo e($statusLabel); ?>

                </span>
                <span class="header-chip">
                    <i class="bi bi-calendar-check"></i>
                    Applied <?php echo e(optional($application->applied_at ?? $application->created_at)->format('M d, Y')); ?>

                </span>
                <?php if($job->application_end_date): ?>
                    <span class="header-chip">
                        <i class="bi bi-hourglass-split"></i>
                        Deadline <?php echo e($job->application_end_date->format('M d, Y')); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Job Details Card -->
        <article class="detail-card">
            <div class="card-header">
                <div style="flex: 1;">
                    <h2 class="job-title"><?php echo e($job->title ?? 'Job no longer available'); ?></h2>
                    <div class="job-meta">
                        <span class="job-pill">
                            <i class="bi bi-building"></i>
                            <?php echo e($job->employer_name ?? 'Employer unavailable'); ?>

                        </span>
                        <span class="job-pill">
                            <i class="bi bi-geo-alt"></i>
                            <?php echo e($job->location ?? 'Location unavailable'); ?>

                        </span>
                        <span class="job-pill">
                            <i class="bi bi-clock"></i>
                            <?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A'))); ?>

                        </span>
                        <?php if($job->salary_range): ?>
                            <span class="job-pill">
                                <i class="bi bi-cash-stack"></i>
                                <?php echo e($job->salary_range); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="posting-info">
                    <div class="posting-label">Posted</div>
                    <div class="posting-value"><?php echo e($job->created_at?->diffForHumans() ?? 'N/A'); ?></div>
                    <?php if($job->application_end_date): ?>
                        <div class="posting-label" style="margin-top: 0.75rem;">Deadline</div>
                        <div class="posting-value <?php echo e($job->application_end_date->isPast() ? 'expired' : 'active'); ?>">
                            <?php echo e($job->application_end_date->isPast() ? 'Expired' : $job->application_end_date->format('M d, Y')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-section">
                <h3 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Job Description
                </h3>
                <div class="detail-text"><?php echo e($job->description ?? 'No description provided.'); ?></div>
            </div>

            <div class="divider"></div>

            <div class="detail-section">
                <h3 class="section-title">
                    <i class="bi bi-check-circle"></i>
                    Qualifications
                </h3>
                <div class="detail-text"><?php echo e($job->qualifications ?? 'No qualifications listed.'); ?></div>
            </div>

            <?php if(! empty($job->key_responsibilities)): ?>
                <div class="divider"></div>
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="bi bi-list-check"></i>
                        Key Responsibilities
                    </h3>
                    <div class="detail-text"><?php echo e($job->key_responsibilities); ?></div>
                </div>
            <?php endif; ?>

            <?php if(! empty($job->preferred_skills)): ?>
                <div class="divider"></div>
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="bi bi-star"></i>
                        Preferred Skills
                    </h3>
                    <div class="detail-text"><?php echo e($job->preferred_skills); ?></div>
                </div>
            <?php endif; ?>

            <div class="divider"></div>

            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">Company</div>
                    <div class="info-value"><?php echo e($job->employer_name ?? 'N/A'); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Vacancies</div>
                    <div class="info-value"><?php echo e($job->vacancies ?? 1); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Employment Type</div>
                    <div class="info-value"><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A'))); ?></div>
                </div>
                <?php if($job->salary_range): ?>
                    <div class="info-card">
                        <div class="info-label">Salary Range</div>
                        <div class="info-value"><?php echo e($job->salary_range); ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="summary-strip">
                <div class="summary-item">
                    <div class="info-label">Application ID</div>
                    <div class="summary-value">#<?php echo e($application->id); ?></div>
                </div>
                <div class="summary-item">
                    <div class="info-label">Employer</div>
                    <div class="summary-value"><?php echo e($job->employer_name ?? 'N/A'); ?></div>
                </div>
                <div class="summary-item">
                    <div class="info-label">Job Type</div>
                    <div class="summary-value"><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A'))); ?></div>
                </div>
                <div class="summary-item">
                    <div class="info-label">Last Activity</div>
                    <div class="summary-value"><?php echo e($application->updated_at?->diffForHumans() ?? 'N/A'); ?></div>
                </div>
            </div>
        </article>

        <!-- Application Status Card -->
        <article class="detail-card">
            <h2 class="job-title" style="font-size: 1.3rem; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 2px solid #e5edf8;">
                <i class="bi bi-clipboard-check" style="color: #2f6fd5;"></i>
                Application Status
            </h2>

            <?php
                $statusFlow = [
                    'pending' => 'Submitted',
                    'reviewing' => 'Review',
                    'recommended' => 'Shortlisted',
                    'interviewed' => 'Interview',
                    'hired' => 'Hired',
                    'rejected' => 'Rejected',
                ];
                $currentStatus = $application->status ?? 'pending';
                $flowKeys = array_keys($statusFlow);
                $currentIndex = array_search($currentStatus, $flowKeys, true);
            ?>

            <!-- Progress tracker removed as requested -->

            <div class="application-meta">
                <div class="application-meta-item">
                    <div class="info-label">Current Status</div>
                    <div class="info-value">
                        <span class="status-badge <?php echo e($statusClass); ?>">
                            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                            <?php echo e($statusLabel); ?>

                        </span>
                    </div>
                </div>
                <div class="application-meta-item">
                    <div class="info-label">Applied On</div>
                    <div class="info-value">
                        <i class="bi bi-calendar-check" style="color: #2f6fd5;"></i>
                        <?php echo e(optional($application->applied_at ?? $application->created_at)->format('d M Y')); ?>

                    </div>
                </div>
                <div class="application-meta-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">
                        <i class="bi bi-clock-history" style="color: #2f6fd5;"></i>
                        <?php echo e($application->updated_at?->diffForHumans() ?? 'N/A'); ?>

                    </div>
                </div>
                <?php if($application->interview_scheduled_at): ?>
                    <div class="application-meta-item application-meta-item--wide">
                        <div class="info-label">
                            <i class="bi bi-calendar-event" style="color: #2563eb;"></i>
                            Interview Scheduled
                        </div>
                        <div class="info-value">
                            <i class="bi bi-clock" style="color: #2563eb;"></i>
                            <?php echo e($application->interview_scheduled_at->format('d M Y, h:i A')); ?>

                        </div>
                    </div>
                <?php endif; ?>
                <?php if($application->resume_original_filename): ?>
                    <div class="application-meta-item">
                        <div class="info-label">Resume Submitted</div>
                        <div class="info-value">
                            <i class="bi bi-file-earmark-text" style="color: #2f6fd5;"></i>
                            <?php echo e($application->resume_original_filename); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(! empty($application->notes)): ?>
                <div class="notes-card">
                    <div class="info-label">
                        <i class="bi bi-chat-square-text"></i>
                        Your Cover Letter / Notes
                    </div>
                    <div class="detail-text"><?php echo e($application->notes); ?></div>
                </div>
            <?php endif; ?>

            <?php if(! empty($application->employer_feedback)): ?>
                <div class="notes-card" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #93c5fd;">
                    <div class="info-label" style="color: #1d4ed8;">
                        <i class="bi bi-chat-dots"></i>
                        Employer Feedback
                    </div>
                    <div class="detail-text" style="color: #1e3a8a; font-style: normal;"><?php echo e($application->employer_feedback); ?></div>
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/application-details.blade.php ENDPATH**/ ?>