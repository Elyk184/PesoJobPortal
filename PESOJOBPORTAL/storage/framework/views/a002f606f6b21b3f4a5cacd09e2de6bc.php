<?php $__env->startSection('title', $job->title . ' - Job Review'); ?>

<?php
    $pageTitle = 'Job Review';
    $pageSubtitle = 'Review and approve job posting';
    $pageIcon = 'bi-briefcase';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
<div class="container-lg py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2><?php echo e($job->title); ?></h2>
            <p class="text-muted">
                <i class="bi bi-briefcase me-2"></i>
                <?php if($job->status === 'pending'): ?>
                    <span class="badge bg-warning">Pending Approval</span>
                <?php elseif($job->status === 'active'): ?>
                    <span class="badge bg-success">Active</span>
                <?php elseif($job->status === 'draft'): ?>
                    <span class="badge bg-secondary">Draft</span>
                <?php else: ?>
                    <span class="badge bg-danger"><?php echo e(ucfirst($job->status)); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('admin.job-approvals')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Approvals
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <!-- Job Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Job Details</h5>
                </div>
                <div class="card-body">
                    <!-- Basic Info -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Job Title</small>
                            <strong class="h6"><?php echo e($job->title); ?></strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Employment Type</small>
                            <strong class="h6"><?php echo e(ucfirst(str_replace('_', ' ', $job->job_type ?? 'N/A'))); ?></strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Location</small>
                            <strong class="h6"><?php echo e($job->location ?? 'N/A'); ?></strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Vacancies</small>
                            <strong class="h6"><?php echo e($job->vacancies ?? 'N/A'); ?></strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Posted Date</small>
                            <strong class="h6"><?php echo e($job->created_at->format('d M, Y h:i A')); ?></strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Application Deadline</small>
                            <strong class="h6"><?php echo e($job->application_end_date ? \Carbon\Carbon::parse($job->application_end_date)->format('d M, Y') : 'N/A'); ?></strong>
                        </div>
                    </div>

                    <!-- Salary Info -->
                    <?php if($job->salary_range || $job->salary): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block">Salary Range</small>
                            <strong class="h6"><?php echo e($job->salary_range ?? $job->salary ?? 'Not specified'); ?></strong>
                        </div>
                    <?php endif; ?>

                    <!-- Description -->
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Job Description</small>
                        <div class="border-start border-3 ps-3">
                            <?php echo nl2br(e($job->description)); ?>

                        </div>
                    </div>

                    <!-- Key Responsibilities -->
                    <?php if($job->key_responsibilities): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Key Responsibilities</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->key_responsibilities)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Qualifications -->
                    <?php if($job->qualifications): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Qualifications</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->qualifications)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Experience -->
                    <?php if($job->experience): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Experience Required</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->experience)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Education -->
                    <?php if($job->education): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Education Requirements</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->education)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Benefits -->
                    <?php if($job->benefits): ?>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Benefits</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->benefits)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Preferred Skills -->
                    <?php if($job->preferred_skills): ?>
                        <hr>
                        <div class="mb-0">
                            <small class="text-muted d-block mb-2">Preferred Skills</small>
                            <div class="border-start border-3 ps-3">
                                <?php echo nl2br(e($job->preferred_skills)); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Employer Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Employer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Employer Name</small>
                        <strong><?php echo e($job->employer_name ?? 'N/A'); ?></strong>
                    </div>
                    <?php if($job->employer): ?>
                        <div class="mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong><?php echo e($job->employer->email); ?></strong>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted d-block">Employer Status</small>
                            <?php if($job->employer->is_employer_verified): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Verified</span>
                            <?php else: ?>
                                <span class="badge bg-warning"><i class="bi bi-exclamation-circle me-1"></i>Unverified</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Review Status</h5>
                </div>
                <div class="card-body">
                    <?php if($job->status === 'pending'): ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Awaiting Approval</strong>
                            <p class="mb-0 mt-2 small">Review the job details above and approve or reject this posting.</p>
                        </div>
                    <?php elseif($job->status === 'active'): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Approved</strong>
                            <p class="mb-0 mt-2 small">
                                Approved by: <strong><?php echo e($job->approver?->name ?? 'System'); ?></strong><br>
                                On: <strong><?php echo e($job->approved_at?->format('d M, Y h:i A')); ?></strong>
                            </p>
                        </div>
                    <?php elseif($job->status === 'draft'): ?>
                        <div class="alert alert-secondary" role="alert">
                            <i class="bi bi-file-earmark me-2"></i>
                            <strong>Rejected</strong>
                            <p class="mb-0 mt-2 small">
                                Reason: <strong><?php echo e($job->rejection_reason ?? 'No reason provided'); ?></strong>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <?php if($job->status === 'pending'): ?>
                <div class="d-grid gap-2">
                    <form method="POST" class="d-grid">
                        <?php echo csrf_field(); ?>
                        <button type="submit" formaction="<?php echo e(route('admin.jobs.approve', $job)); ?>" class="btn btn-lg btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve Job Posting
                        </button>
                    </form>

                    <button type="button" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-2"></i>Reject Job Posting
                    </button>
                </div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Applications</span>
                            <strong class="badge bg-secondary"><?php echo e($job->applications->count()); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Reject Job Posting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.jobs.reject', $job)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted mb-3">You are about to reject the job posting for <strong><?php echo e($job->title); ?></strong>.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            id="rejection_reason"
                            name="rejection_reason" 
                            class="form-control" 
                            rows="4" 
                            placeholder="Explain why this job posting is being rejected..."
                            required></textarea>
                        <small class="text-muted d-block mt-2">The employer will be notified of this reason.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>Reject Posting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\approvals\job-detail.blade.php ENDPATH**/ ?>