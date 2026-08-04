<?php $__env->startSection('title', 'Job Approvals | PESO Admin'); ?>

<?php
    $pageTitle = 'Job Approvals';
    $pageSubtitle = 'Review and approve pending job postings';
    $pageIcon = 'bi-file-check';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .data-table { font-size: 13px; }
        .data-table thead { background: #f3f4f6; }
        .data-table th { color: #0d1f3c; font-weight: 700; border-bottom: 2px solid #e5e7eb; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 13px 10px; vertical-align: middle; font-weight: 500; }
        .data-table tbody tr:hover { background: #f9fafb; }
    </style>

    <div class="dashboard-card">
            <?php if($pendingJobs->count() > 0): ?>
                <!-- Approvals Table -->
                <table class="table data-table w-100">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Location</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e(Str::limit($job->title, 25)); ?></strong><br>
                                    <small class="text-muted"><?php echo e(Str::limit($job->description, 50)); ?></small>
                                </td>
                                <td><?php echo e(Str::limit($job->employer?->name ?? 'N/A', 20)); ?></td>
                                <td><?php echo e(Str::limit($job->location, 20)); ?></td>
                                <td><small><?php echo e($job->created_at->format('d M, Y')); ?></small></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline-flex gap-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" formaction="<?php echo e(route('admin.jobs.approve', $job)); ?>" 
                                                class="btn btn-sm btn-success" title="Approve this job">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal<?php echo e($job->id); ?>" title="Reject this job">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                        <a href="<?php echo e(route('admin.jobs.review', $job)); ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </form>
                                </td>
                            </tr>

                            <!-- Rejection Modal -->
                            <div class="modal fade" id="rejectModal<?php echo e($job->id); ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Job Posting</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="<?php echo e(route('admin.jobs.reject', $job)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <p class="text-muted mb-3">Rejecting: <strong><?php echo e($job->title); ?></strong></p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason_<?php echo e($job->id); ?>" class="form-label">
                                                        Reason <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        id="rejection_reason_<?php echo e($job->id); ?>"
                                                        name="rejection_reason" 
                                                        class="form-control" 
                                                        rows="4" 
                                                        placeholder="Explain why this job posting is being rejected..."
                                                        required></textarea>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($pendingJobs->links('pagination::bootstrap-5')); ?>

                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>All caught up!</strong> No pending job approvals to review.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\approvals\jobs.blade.php ENDPATH**/ ?>