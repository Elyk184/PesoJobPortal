<?php $__env->startSection('title', 'Review Jobseeker | PESO Admin'); ?>

<?php
    $pageTitle = 'Jobseeker Review';
    $pageSubtitle = 'Review pending jobseeker registration';
    $pageIcon = 'bi-person-check';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .info-card { background: white; border-radius: 10px; padding: 1.75rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 1.5rem; }
        .info-card h5 { margin: 0 0 1.25rem 0; color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #d72638; padding-bottom: 0.75rem; font-size: 16px; }
        .info-group { margin-bottom: 1rem; }
        .info-label { font-size: 12px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { font-size: 14px; color: #1f2937; font-weight: 600; margin-top: 0.5rem; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 700; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .btn-sm { font-size: 12px; padding: 0.5rem 1rem; }
        .action-group { display: flex; gap: 0.75rem; margin-top: 1rem; }
    </style>

    <div class="row">
        <div class="col-lg-8">
            <!-- Contact Information -->
            <div class="info-card">
                <h5>Contact Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Full Name</div>
                            <div class="info-value"><?php echo e($jobseeker->name); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo e($jobseeker->email); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <?php if($jobseeker->profile): ?>
                <div class="info-card">
                    <h5>Profile Information</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-group">
                                <div class="info-label">Phone</div>
                                <div class="info-value"><?php echo e($jobseeker->profile->phone ?? 'N/A'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group">
                                <div class="info-label">Location</div>
                                <div class="info-value"><?php echo e($jobseeker->profile->location ?? 'N/A'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group">
                                <div class="info-label">Barangay</div>
                                <div class="info-value"><?php echo e($jobseeker->profile->barangay ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php if($jobseeker->profile->bio): ?>
                        <div class="info-group">
                            <div class="info-label">Bio</div>
                            <div class="info-value"><?php echo e($jobseeker->profile->bio); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Applications -->
            <?php if($jobseeker->applications->count() > 0): ?>
                <div class="info-card">
                    <h5>Job Applications (<?php echo e($jobseeker->applications->count()); ?>)</h5>
                    <style>
                        .apps-table { font-size: 13px; }
                        .apps-table thead { background: #f3f4f6; }
                        .apps-table th { padding: 0.75rem; color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 11px; text-transform: uppercase; }
                        .apps-table td { padding: 0.75rem; border-bottom: 1px solid #f0f0f0; }
                    </style>
                    <table class="table apps-table w-100 mb-0">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Applied</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jobseeker->applications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><small><?php echo e(Str::limit($app->job->title ?? 'N/A', 25)); ?></small></td>
                                    <td><small><?php echo e(Str::limit($app->job->employer->name ?? 'N/A', 15)); ?></small></td>
                                    <td><small><?php echo e($app->created_at->format('d M Y')); ?></small></td>
                                    <td>
                                        <span class="badge bg-secondary" style="font-size: 10px;"><?php echo e($app->status ?? 'pending'); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="info-card">
                <h5>Registration Status</h5>
                <div class="info-group">
                    <div class="info-label">Current Status</div>
                    <div class="info-value mt-2">
                        <span class="status-badge status-pending">Pending Review</span>
                    </div>
                </div>
                <div class="info-group mt-3">
                    <div class="info-label">Registered</div>
                    <div class="info-value"><?php echo e($jobseeker->created_at->format('d M, Y \a\t H:i')); ?></div>
                </div>

                <!-- Actions -->
                <div class="action-group">
                    <form method="POST" action="<?php echo e(route('admin.jobseekers.approve', $jobseeker)); ?>" class="flex-fill">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-success w-100">
                            <i class="bi bi-check-circle me-1"></i> Approve
                        </button>
                    </form>
                </div>
                <div class="action-group">
                    <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-1"></i> Reject
                    </button>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="info-card">
                <h5>Summary</h5>
                <div class="info-group">
                    <div class="info-label">Total Applications</div>
                    <div class="info-value"><?php echo e($jobseeker->applications->count()); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.jobseekers.reject', $jobseeker)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted mb-3">Rejecting registration for: <strong><?php echo e($jobseeker->name); ?></strong></p>
                    <div class="mb-3">
                        <label for="rejectReason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea id="rejectReason" name="reason" class="form-control" rows="4" 
                                  placeholder="Explain why this registration is being rejected..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\jobseekers\show.blade.php ENDPATH**/ ?>