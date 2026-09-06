<?php $__env->startSection('title', 'Alerts & Notifications | PESO Admin'); ?>

<?php
    $pageTitle = 'Alerts & Notifications';
    $pageSubtitle = 'Manage system alerts and notifications';
    $pageIcon = 'bi-bell';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .alerts-shell { display: grid; gap: 1rem; }
        .alerts-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        .alerts-stat { background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(13,31,60,0.06); border: 1px solid #e7edf5; }
        .alerts-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; font-weight: 700; margin-bottom: 0.35rem; }
        .alerts-stat-value { font-size: 2rem; font-weight: 800; color: #0d1f3c; line-height: 1; }
        .alerts-stat-note { font-size: 13px; color: #6b7280; margin-top: 0.45rem; }
        .alerts-panel { background: white; border-radius: 18px; border: 1px solid #e7edf5; box-shadow: 0 6px 18px rgba(13,31,60,0.05); overflow: hidden; }
        .alerts-panel-head { padding: 1.15rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .alerts-panel-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
        .alerts-panel-head p { margin: 0; color: #6b7280; font-size: 0.9rem; }
        .alerts-list { padding: 1rem 1.25rem 1.25rem; display: grid; gap: 0.9rem; }
        .alert-item { background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%); padding: 1rem 1.1rem; border-radius: 14px; border: 1px solid #edf2f7; display: flex; gap: 1rem; align-items: flex-start; }
        .alert-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex: 0 0 auto; font-size: 1.05rem; background: #eff6ff; }
        .alert-info { flex: 1; min-width: 0; }
        .alert-title { font-weight: 800; color: #0d1f3c; margin-bottom: 0.3rem; }
        .alert-message { color: #5f6c80; font-size: 14px; margin-bottom: 0.55rem; line-height: 1.55; }
        .alert-meta { display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; align-items: center; font-size: 12px; color: #8b95a7; }
        .alert-actions { display: flex; gap: 0.5rem; align-items: flex-start; flex-shrink: 0; }
        .btn-small { padding: 0.55rem 0.9rem; border: none; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; }
        .btn-dismiss { background: #eef2f7; color: #1f2937; }
        .btn-dismiss:hover { background: #dbe3ee; }
        .alerts-empty { background: #fff; border: 1px dashed #dbe4ee; border-radius: 16px; padding: 2.25rem 1.5rem; text-align: center; color: #64748b; }
    </style>

    <div class="alerts-shell">
        <div class="alerts-summary">
            <div class="alerts-stat">
                <div class="alerts-stat-label">Unread Alerts</div>
                <div class="alerts-stat-value"><?php echo e($adminUnreadNotificationsCount ?? 0); ?></div>
                <div class="alerts-stat-note">Pending PESO and portal notifications</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Pending Job Approvals</div>
                <div class="alerts-stat-value"><?php echo e($adminSidebarCounts['pendingJobApprovals'] ?? 0); ?></div>
                <div class="alerts-stat-note">Job posts waiting for review</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Employer Verifications</div>
                <div class="alerts-stat-value"><?php echo e($adminSidebarCounts['pendingEmployerVerification'] ?? 0); ?></div>
                <div class="alerts-stat-note">Company profiles awaiting approval</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Pending LRA/SRA Approvals</div>
                <div class="alerts-stat-value"><?php echo e($adminSidebarCounts['pendingLraSraApprovals'] ?? 0); ?></div>
                <div class="alerts-stat-note">Requests awaiting certification</div>
            </div>
            <div class="alerts-stat">
                <div class="alerts-stat-label">Pending PESO Clearances</div>
                <div class="alerts-stat-value"><?php echo e($adminSidebarCounts['pendingPesoClearances'] ?? 0); ?></div>
                <div class="alerts-stat-note">Requests awaiting admin action</div>
            </div>
        </div>

        <div class="alerts-panel">
            <div class="alerts-panel-head">
                <div>
                    <h3>Recent Alerts</h3>
                    <p>Live notifications from the PESO clearance workflow and other portal updates.</p>
                </div>
                <span class="badge text-bg-primary rounded-pill px-3 py-2"><?php echo e($adminUnreadNotificationsCount ?? 0); ?> unread</span>
            </div>

            <div class="alerts-list">
                <?php $__empty_1 = true; $__currentLoopData = ($adminNotifications ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $title = (string) data_get($notification, 'portalNotification.title', 'Notification');
                        $message = (string) data_get($notification, 'portalNotification.message', '');
                        $createdAt = data_get($notification, 'portalNotification.created_at');
                        $alertText = mb_strtolower($title . ' ' . $message);
                        $isJobApproval = str_contains($alertText, 'job post') || str_contains($alertText, 'job approval');
                        $isEmployerVerification = str_contains($alertText, 'employer verification') || str_contains($alertText, 'company verification') || str_contains($alertText, 'business permit');
                        $isLraSra = str_contains($alertText, 'lra') || str_contains($alertText, 'sra') || str_contains($alertText, 'recruitment activity');
                        $isPesoClearance = str_contains($alertText, 'peso clearance');
                    ?>
                    <div class="alert-item">
                        <div class="alert-icon" style="color: <?php echo e($isPesoClearance ? '#f59e0b' : ($isLraSra ? '#ec4899' : ($isEmployerVerification ? '#16a34a' : '#2563eb'))); ?>; background: <?php echo e($isPesoClearance ? 'rgba(245, 158, 11, 0.12)' : ($isLraSra ? 'rgba(236, 72, 153, 0.12)' : ($isEmployerVerification ? 'rgba(22, 163, 74, 0.12)' : 'rgba(37, 99, 235, 0.12)'))); ?>;">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div class="alert-info">
                            <div class="alert-title"><?php echo e($title); ?></div>
                            <div class="alert-message"><?php echo e($message); ?></div>
                            <div class="alert-meta">
                                <span><i class="bi bi-clock me-1"></i><?php echo e($createdAt ? $createdAt->diffForHumans() : 'Recently'); ?></span>
                                <?php if($isJobApproval): ?>
                                    <span class="badge text-bg-primary rounded-pill">Job Approval</span>
                                <?php endif; ?>
                                <?php if($isEmployerVerification): ?>
                                    <span class="badge text-bg-success rounded-pill">Employer Verification</span>
                                <?php endif; ?>
                                <?php if($isLraSra): ?>
                                    <span class="badge rounded-pill" style="background:#ec4899; color:white;">LRA/SRA Request</span>
                                <?php endif; ?>
                                <?php if($isPesoClearance): ?>
                                    <span class="badge text-bg-warning text-dark rounded-pill">PESO Clearance</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="alert-actions">
                            <?php if($isJobApproval): ?>
                                <a href="<?php echo e(route('admin.job-approvals')); ?>" class="btn-small btn-dismiss" style="background:#2563eb; color:#fff; text-decoration:none;">Open Queue</a>
                            <?php endif; ?>
                            <?php if($isEmployerVerification): ?>
                                <a href="<?php echo e(route('admin.employer-verification')); ?>" class="btn-small btn-dismiss" style="background:#16a34a; color:#fff; text-decoration:none;">Review Queue</a>
                            <?php endif; ?>
                            <?php if($isLraSra): ?>
                                <a href="<?php echo e(route('admin.lra-sra-approvals')); ?>" class="btn-small btn-dismiss" style="background:#ec4899; color:#fff; text-decoration:none;">Review Queue</a>
                            <?php endif; ?>
                            <?php if($isPesoClearance): ?>
                                <a href="<?php echo e(route('admin.peso-clearances')); ?>" class="btn-small btn-dismiss" style="background:#f59e0b; color:#fff; text-decoration:none;">Open Queue</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="alerts-empty">
                        <div class="fw-semibold mb-1">No admin notifications yet</div>
                        <div class="small">New job approvals, employer verifications, and PESO clearance requests will appear here as alerts.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\alerts-notifications.blade.php ENDPATH**/ ?>