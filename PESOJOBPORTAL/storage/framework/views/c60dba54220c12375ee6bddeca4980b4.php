<?php $__env->startSection('title', 'Employer Dashboard'); ?>
<?php $__env->startSection('hide_header', true); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dashboard-shell {
        display: grid;
        gap: 20px;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(90deg, #0f2d52, #1f4b8f);
        border-radius: 14px;
        border: 2px solid #d72638;
        padding: 24px;
        color: #f5f7fb;
        box-shadow: 0 14px 26px rgba(15, 35, 64, 0.22);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.16);
        right: -60px;
        top: -80px;
    }

    .dashboard-hero h2 {
        position: relative;
        z-index: 1;
        margin: 0 0 8px;
        color: #ffffff;
        font-size: 24px;
    }

    .hero-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .hero-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .hero-main {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    .hero-company-logo,
    .hero-company-logo-fallback {
        position: relative;
        z-index: 1;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 10px;
    }

    .hero-company-logo {
        object-fit: contain;
        padding: 3px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 10px 24px rgba(15, 35, 64, 0.28);
    }

    .hero-company-logo-fallback {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.12);
        border: 2px dashed rgba(255, 255, 255, 0.38);
        color: #f5f7fb;
    }

    .hero-company-logo-fallback svg {
        width: 42px;
        height: 42px;
    }

    .hero-status-badge {
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(148, 163, 184, 0.35);
        background: rgba(248, 250, 252, 0.96);
        color: #0f172a;
    }

    .hero-status-badge.is-unverified {
        color: #b91c1c;
    }

    .dashboard-hero p {
        position: relative;
        z-index: 1;
        margin: 0;
        color: rgba(245, 247, 251, 0.92);
        max-width: 680px;
        line-height: 1.6;
    }

    .hero-badges {
        position: relative;
        z-index: 1;
        margin-top: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .hero-badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(215, 38, 56, 0.4);
        background: rgba(215, 38, 56, 0.16);
        color: #f5f7fb;
        backdrop-filter: blur(8px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
    }

    .metric-card {
        position: relative;
        overflow: hidden;
        padding: 18px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: linear-gradient(160deg, #ffffff 0%, #f6fbff 100%);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .metric-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #0f766e 0%, #22d3ee 100%);
    }

    .metric-card:hover {
        transform: translateY(-3px);
        border-color: #9ac8ef;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.12);
    }

    .metric-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .metric-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: #0b3f67;
        background: linear-gradient(135deg, #dff2ff 0%, #e6fffb 100%);
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .metric-card:hover .metric-icon {
        transform: scale(1.08) rotate(2deg);
    }

    .metric-value {
        font-size: 36px;
        line-height: 1.05;
        margin: 10px 0 0;
        color: #0f172a;
        font-weight: 700;
    }

    .metric-label {
        margin: 0;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
    }

    .quick-link {
        text-decoration: none;
        border: 1.5px solid #dbe4ee;
        border-radius: 12px;
        background: #ffffff;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.18s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-link::after {
        content: "";
        position: absolute;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(15, 118, 110, 0.06), transparent);
        transition: right 0.5s ease;
    }

    .quick-link:hover {
        transform: translateY(-2px);
        border-color: #0f766e;
        box-shadow: 0 12px 20px rgba(15, 118, 110, 0.1);
    }

    .quick-link:hover::after {
        right: 100%;
    }

    .quick-link-title {
        color: #0f172a;
        font-weight: 700;
        font-size: 14px;
        margin: 0;
    }

    .quick-link-note {
        color: #64748b;
        font-size: 12px;
        margin: 0;
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 18px;
        }

        .hero-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-side {
            width: 100%;
            align-items: flex-start;
        }

        .hero-main {
            align-items: flex-start;
        }

        .hero-company-logo,
        .hero-company-logo-fallback {
            width: 86px;
            height: 86px;
            margin-top: 6px;
        }

        .hero-company-logo-fallback svg {
            width: 34px;
            height: 34px;
        }

        .dashboard-hero h2 {
            font-size: 20px;
        }

        .metric-value {
            font-size: 28px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-shell fill-remaining">
        <div class="dashboard-hero">
            <div class="hero-top">
                <div class="hero-main">
                    <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"></path>
                        <path d="M12 6v6l4 2"></path>
                    </svg>
                    <div>
                        <h2 style="margin: 0 0 6px;">Employer Dashboard</h2>
                        <p style="margin: 0; color: rgba(236, 254, 255, 0.92); max-width: 720px;">Manage jobs, review applicants, and keep your hiring workflow moving from one place.</p>
                    </div>
                </div>

                <div class="hero-side">
                    <?php if(!empty($companyLogoUrl)): ?>
                        <img src="<?php echo e($companyLogoUrl); ?>" alt="Company Logo" class="hero-company-logo">
                    <?php else: ?>
                        <span class="hero-company-logo-fallback" aria-hidden="true">
                            <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;">
                                <path d="M3 21h18"></path>
                                <path d="M5 21V7l7-4 7 4v14"></path>
                                <path d="M9 10h6"></path>
                                <path d="M9 14h6"></path>
                            </svg>
                        </span>
                    <?php endif; ?>

                    <?php if($isVerifiedEmployer): ?>
                        <span class="hero-status-badge">Verified Employer</span>
                    <?php else: ?>
                        <span class="hero-status-badge is-unverified">Not Verified</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="hero-badges">
                <span class="hero-badge">Employer Dashboard</span>
                <span class="hero-badge">Live Snapshot</span>
                <span class="hero-badge">Updated Daily</span>
            </div>
        </div>

        <div class="panel">
            <h2>Dashboard Statistics</h2>

            <div class="stats-grid">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Active Job Posts</p>
                        <span class="metric-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h-3V2h-2v1H8"></path>
                                <path d="M7 11v3"></path>
                                <path d="M12 11v3"></path>
                                <path d="M17 11v3"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="metric-value"><?php echo e($stats['active_jobs_count']); ?></p>
                </div>

                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Total Applications</p>
                        <span class="metric-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                <path d="M9 10h6"></path>
                                <path d="M9 14h4"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="metric-value"><?php echo e($stats['total_applications']); ?></p>
                </div>

                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Pending Job Posts</p>
                        <span class="metric-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </span>
                    </div>
                    <p class="metric-value"><?php echo e($stats['pending_jobs_count']); ?></p>
                </div>

                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">New Applications Today</p>
                        <span class="metric-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 7-3 7h18s-3 0-3-7"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="metric-value"><?php echo e($stats['new_applications_today']); ?></p>
                </div>
            </div>
        </div>

        <?php if(($recentLraSraUpdates ?? collect())->isNotEmpty()): ?>
        <div class="panel" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-left: 4px solid #10b981;">
            <h2 style="color: #065f46;"><i class="bi bi-bell me-2" style="color: #10b981;"></i>LRA/SRA Status Updates</h2>
            <div style="display: grid; gap: 12px;">
                <?php $__currentLoopData = $recentLraSraUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background: white; border-radius: 8px; padding: 12px; border-left: 3px solid <?php echo e($update->status === 'approved' ? '#10b981' : '#ef4444'); ?>;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                            <div>
                                <strong style="color: #1f2937;"><?php echo e(strtoupper($update->activity_type)); ?> Request</strong>
                                <span class="badge" style="background: <?php echo e($update->status === 'approved' ? '#d1fae5' : '#fee2e2'); ?>; color: <?php echo e($update->status === 'approved' ? '#065f46' : '#7f1d1d'); ?>; margin-left: 8px; font-size: 0.75rem;">
                                    <?php echo e(ucfirst($update->status)); ?>

                                </span>
                            </div>
                        </div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 8px;">
                            <?php if($update->status === 'approved'): ?>
                                <i class="bi bi-check-circle" style="color: #10b981;"></i> Approved on <?php echo e(optional($update->approved_at)->format('M d, Y')); ?>

                            <?php else: ?>
                                <i class="bi bi-x-circle" style="color: #ef4444;"></i> Rejected on <?php echo e(optional($update->updated_at)->format('M d, Y')); ?>

                            <?php endif; ?>
                        </p>
                        <?php if($update->status === 'rejected' && $update->notes): ?>
                            <p style="color: #64748b; font-size: 0.85rem; background: #f9fafb; padding: 8px; border-radius: 4px; margin: 8px 0 0;">
                                <strong>Reason:</strong> <?php echo e($update->notes); ?>

                            </p>
                        <?php elseif($update->status === 'approved' && $update->certification_path): ?>
                            <p style="color: #047857; font-size: 0.85rem;">
                                <i class="bi bi-file-pdf" style="color: #10b981;"></i> <a href="<?php echo e(route('admin.lra-sra.view-certification', $update)); ?>" target="_blank" style="color: #10b981; text-decoration: none; font-weight: 600;">View Certificate</a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div style="text-align: center; margin-top: 8px;">
                    <a href="<?php echo e(route('employer.recruitment.index')); ?>" style="color: #10b981; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                        View All Requests <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="panel">
            <h2>Quick Actions</h2>
            <div class="quick-actions">
                <a class="quick-link" href="<?php echo e(route('employer.jobs.post')); ?>">
                    <span style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #0f766e;">
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>
                        <span class="quick-link-title">Post A New Job</span>
                    </span>
                    <span class="quick-link-note">Create and publish a new vacancy.</span>
                </a>
                <a class="quick-link" href="<?php echo e(route('employer.jobs.manage')); ?>">
                    <span style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #0f766e;">
                            <path d="M6 9a6 6 0 1 0 12 0A6 6 0 0 0 6 9z"></path>
                            <path d="M12 9v6"></path>
                            <path d="M15 12h-6"></path>
                        </svg>
                        <span class="quick-link-title">Manage Existing Jobs</span>
                    </span>
                    <span class="quick-link-note">Edit, archive, or extend active posts.</span>
                </a>
                <a class="quick-link" href="<?php echo e(route('employer.applicants.index')); ?>">
                    <span style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #0f766e;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="quick-link-title">Review Applicants</span>
                    </span>
                    <span class="quick-link-note">Track referrals and update decisions.</span>
                </a>
                <a class="quick-link" href="<?php echo e(route('employer.company-profile')); ?>">
                    <span style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #0f766e;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="quick-link-title">Update Company Profile</span>
                    </span>
                    <span class="quick-link-note">Keep your employer information current.</span>
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\employer.blade.php ENDPATH**/ ?>