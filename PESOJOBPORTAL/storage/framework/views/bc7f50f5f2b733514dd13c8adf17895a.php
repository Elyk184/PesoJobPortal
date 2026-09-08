<?php $__env->startSection('title', 'My Applications | Jobseeker'); ?>

<?php $__env->startSection('content'); ?>
<section aria-label="Job applications" class="applications-page">
    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 applications-hero">
            <div>
                <h2 class="h4 mb-1 fw-bold applications-heading">My Applications</h2>
                <p class="mb-0 text-muted">Track every job you applied for and review the current hiring status in one place.</p>
            </div>
            <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-primary px-3 shadow-sm applications-hero-btn">
                <i class="bi bi-search me-2"></i>Browse More Jobs
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon"><i class="bi bi-send"></i></div>
                <div>
                    <div class="dashboard-stat-number"><?php echo e($statusCounts['all'] ?? 0); ?></div>
                    <div class="dashboard-stat-label">Total Applications</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #b45309;"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="dashboard-stat-number"><?php echo e($statusCounts['pending'] ?? 0); ?></div>
                    <div class="dashboard-stat-label">Pending Review</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;"><i class="bi bi-mic"></i></div>
                <div>
                    <div class="dashboard-stat-number"><?php echo e($statusCounts['interview'] ?? 0); ?></div>
                    <div class="dashboard-stat-label">Interview</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="dashboard-stat-card p-3 d-flex align-items-center gap-3">
                <div class="dashboard-stat-icon" style="background: rgba(34, 197, 94, 0.12); color: #15803d;"><i class="bi bi-person-check"></i></div>
                <div>
                    <div class="dashboard-stat-number"><?php echo e(($statusCounts['hired'] ?? 0) + ($statusCounts['rejected'] ?? 0)); ?></div>
                    <div class="dashboard-stat-label">Finalized</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex flex-column gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-clipboard-check me-2"></i>Application Status</h3>
            <div class="d-flex flex-wrap gap-2 status-filter-wrap">
                <a href="<?php echo e(route('jobseeker.applications')); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'all' ? 'btn-primary' : 'btn-outline-primary'); ?>">All (<?php echo e($statusCounts['all'] ?? 0); ?>)</a>
                <a href="<?php echo e(route('jobseeker.applications', ['status' => 'pending'])); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'pending' ? 'btn-warning' : 'btn-outline-warning'); ?>">Pending (<?php echo e($statusCounts['pending'] ?? 0); ?>)</a>
                <a href="<?php echo e(route('jobseeker.applications', ['status' => 'reviewing'])); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'reviewing' ? 'btn-info' : 'btn-outline-info'); ?>">Reviewing (<?php echo e($statusCounts['reviewing'] ?? 0); ?>)</a>
                <a href="<?php echo e(route('jobseeker.applications', ['status' => 'interviewed'])); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'interviewed' ? 'btn-primary' : 'btn-outline-primary'); ?>">Interview (<?php echo e($statusCounts['interviewed'] ?? 0); ?>)</a>
                <a href="<?php echo e(route('jobseeker.applications', ['status' => 'hired'])); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'hired' ? 'btn-success' : 'btn-outline-success'); ?>">Hired (<?php echo e($statusCounts['hired'] ?? 0); ?>)</a>
                <a href="<?php echo e(route('jobseeker.applications', ['status' => 'rejected'])); ?>" class="btn btn-sm status-filter-btn <?php echo e($statusFilter === 'rejected' ? 'btn-danger' : 'btn-outline-danger'); ?>">Rejected (<?php echo e($statusCounts['rejected'] ?? 0); ?>)</a>
                <?php
                    $currentQuery = request()->query();
                ?>
                <?php if((string) ($currentQuery['per_page'] ?? '') === 'all'): ?>
                    <a href="<?php echo e(route('jobseeker.applications', array_filter($currentQuery, fn($v, $k) => $k !== 'per_page', ARRAY_FILTER_USE_BOTH))); ?>" class="btn btn-sm btn-outline-secondary">Show paged</a>
                <?php else: ?>
                    <a href="<?php echo e(route('jobseeker.applications', array_merge($currentQuery, ['per_page' => 'all']))); ?>" class="btn btn-sm btn-outline-secondary">Show all</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if($applications->isEmpty()): ?>
            <div class="dashboard-empty-state text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-clipboard-x display-4 text-muted"></i>
                </div>
                <div class="fw-semibold text-secondary">
                    <?php if($statusFilter === 'all'): ?>
                        No applications yet.
                    <?php else: ?>
                        No applications found for this status.
                    <?php endif; ?>
                </div>
                <div class="small text-muted mb-3">Browse available jobs and submit your first application.</div>
                <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-primary px-4">Browse Jobs</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle applications-table mb-0">
                    <thead>
                        <tr>
                            <th>Job</th>
                            <th>Company</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $job = $application->job;
                                $status = strtolower((string) ($application->status ?? 'pending'));
                                $statusLabel = match ($status) {
                                    'pending' => 'Pending',
                                    'reviewing' => 'Reviewing',
                                    'shortlisted' => 'Shortlisted',
                                    'interview' => 'Interview',
                                    'interviewed' => 'Interview',
                                    'hired' => 'Hired',
                                    'rejected' => 'Rejected',
                                    default => ucfirst($status),
                                };
                                $statusClass = match ($status) {
                                    'pending' => 'warning',
                                    'reviewing' => 'info',
                                    'shortlisted' => 'success',
                                    'interview', 'interviewed' => 'primary',
                                    'hired' => 'success',
                                    'rejected' => 'danger',
                                    default => 'secondary',
                                };
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark d-flex align-items-center gap-2">
                                        <i class="bi bi-briefcase text-primary"></i>
                                        <span><?php echo e($job?->title ?? 'Job no longer available'); ?></span>
                                    </div>
                                    <div class="small text-muted"><?php echo e($job?->location ?? 'Location unavailable'); ?></div>
                                </td>
                                <td>
                                    <div class="small text-dark"><?php echo e($job?->employer_name ?? 'Employer unavailable'); ?></div>
                                    <div class="small text-muted"><?php echo e($job?->job_type ? ucfirst(str_replace('-', ' ', $job?->job_type)) : 'Employment type unavailable'); ?></div>
                                </td>
                                <td>
                                    <div class="small text-dark"><?php echo e(optional($application->applied_at ?? $application->created_at)->format('d M Y')); ?></div>
                                    <div class="small text-muted"><?php echo e(optional($application->applied_at ?? $application->created_at)->diffForHumans()); ?></div>
                                </td>
                                <td>
                                    <span class="badge app-status-pill text-bg-<?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('jobseeker.application.details', $application)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                            <tr class="applications-mobile-row">
                                <td colspan="5">
                                    <div class="application-card-mobile">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div>
                                                <div class="fw-semibold text-dark"><?php echo e($job?->title ?? 'Job no longer available'); ?></div>
                                                <div class="small text-muted"><?php echo e($job?->employer_name ?? 'Employer unavailable'); ?><span class="mx-1">|</span><?php echo e($job?->location ?? 'Location unavailable'); ?></div>
                                            </div>
                                            <span class="badge app-status-pill text-bg-<?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                                        </div>
                                        <div class="small text-muted mt-2">
                                            Applied <?php echo e(optional($application->applied_at ?? $application->created_at)->format('d M Y')); ?>

                                            <?php if(! empty($job?->salary_range)): ?>
                                                <span class="mx-1">|</span><?php echo e($job->salary_range); ?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="small text-muted">
                    Showing <?php echo e($applications->firstItem() ?? 0); ?> to <?php echo e($applications->lastItem() ?? 0); ?> of <?php echo e($applications->total()); ?> application(s)
                </div>
                <?php echo e($applications->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .applications-page .dashboard-section-card {
        border-radius: 14px;
    }

    .applications-hero {
        min-height: 84px;
    }

    .applications-heading {
        letter-spacing: 0.01em;
    }

    .applications-hero-btn {
        min-height: 40px;
        font-weight: 700;
    }

    .status-filter-wrap {
        width: 100%;
        align-items: center;
    }

    .status-filter-btn {
        flex: 1 1 0;
        border-radius: 999px;
        font-weight: 700;
        padding-inline: 0.75rem;
        min-width: 0;
    }

    .applications-table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #66758a;
        border-bottom: 1px solid #dbe5f1;
        background: #f8fbff;
        white-space: nowrap;
        padding: 0.85rem 0.75rem;
    }

    .applications-table tbody td {
        padding: 0.9rem 0.75rem;
        vertical-align: middle;
    }

    .applications-table tbody tr:hover {
        background: #fbfdff;
    }

    .app-status-pill {
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.01em;
        padding: 0.38rem 0.65rem;
    }

    .applications-mobile-row {
        display: none;
    }

    .application-card-mobile {
        display: none;
        padding: 0.85rem 0;
        border-top: 1px solid #edf2f7;
    }

    @media (max-width: 767.98px) {
        .status-filter-wrap {
            width: 100%;
        }

        .status-filter-btn {
            flex: 1 1 calc(50% - 0.5rem);
            text-align: center;
        }

        .applications-table thead,
        .applications-table tbody tr:not(.applications-mobile-row) {
            display: none;
        }

        .applications-mobile-row {
            display: table-row;
        }

        .application-card-mobile {
            display: block;
            border-radius: 10px;
            padding: 0.95rem 0;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\jobseeker\applications.blade.php ENDPATH**/ ?>