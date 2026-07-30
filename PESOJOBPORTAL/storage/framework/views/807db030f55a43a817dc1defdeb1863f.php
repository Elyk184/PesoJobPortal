<?php $__env->startSection('title', 'Saved Jobs | Jobseeker'); ?>

<?php $__env->startSection('content'); ?>
<section aria-label="Saved jobs" class="saved-jobs-page">

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">
                    Saved Jobs
                    <span class="badge bg-light text-dark border ms-2" id="savedCountBadge"><?php echo e($savedCount); ?></span>
                </h2>
                <p class="mb-0 text-muted">Jobs you bookmarked to apply later.</p>
            </div>
            <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-primary px-3 shadow-sm">
                <i class="bi bi-briefcase me-2"></i>Browse Jobs
            </a>
        </div>
    </div>

    <div class="dashboard-section-card p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
            <h3 class="h5 mb-0 fw-bold"><i class="bi bi-bookmark me-2"></i>Saved Job Posts</h3>
            <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-sm btn-outline-primary">Browse All Jobs</a>
        </div>

        <?php if($savedJobs->isEmpty()): ?>
            <div class="dashboard-empty-state text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-bookmark fs-1 text-primary" aria-hidden="true"></i>
                </div>
                <div class="fw-semibold text-secondary">No saved jobs yet.</div>
                <div class="small mb-3">Save interesting job posts while browsing and review them here anytime.</div>
                <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-primary btn-lg px-4">Browse Jobs</a>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php $__currentLoopData = $savedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12">
                        <article class="saved-job-item p-3 p-lg-4">
                            <div class="saved-job-top">
                                <div class="saved-job-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="saved-job-main">
                                    <div class="saved-job-title"><?php echo e($job['title']); ?></div>
                                    <div class="saved-job-subtitle">
                                        <span><i class="bi bi-building me-1"></i><?php echo e($job['employer_name']); ?></span>
                                        <span class="mx-2 text-muted">|</span>
                                        <span><i class="bi bi-geo-alt me-1"></i><?php echo e($job['location']); ?></span>
                                    </div>
                                </div>
                                <div class="saved-job-actions">
                                    <a href="<?php echo e(route('jobseeker.apply-job', $job['id'])); ?>" class="btn btn-primary btn-sm px-3">
                                        View
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm px-3" onclick="toggleSaveJob(<?php echo e($job['id']); ?>, this)" title="Remove from saved jobs">
                                        <i class="bi bi-bookmark-x me-1"></i>Remove
                                    </button>
                                </div>
                            </div>

                            <?php if(! empty($job['salary_range'])): ?>
                                <div class="saved-job-meta">
                                    <span class="saved-meta-item"><i class="bi bi-cash-stack me-1"></i><?php echo e($job['salary_range']); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="saved-job-desc"><?php echo e(\Illuminate\Support\Str::limit($job['description'], 160)); ?></div>

                            <?php if(! empty($job['requirements_list'])): ?>
                                <div class="saved-job-tags">
                                    <?php $__currentLoopData = collect($job['requirements_list'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge rounded-pill text-bg-light border"><?php echo e($requirement); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleSaveJob(jobId, button) {
        fetch('<?php echo e(url('jobseeker/saved-jobs')); ?>/' + jobId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (!data.saved) {
                // Job was unsaved — remove the card with animation
                const card = button.closest('.col-12');
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => card.remove(), 300);

                if (typeof data.saved_count !== 'undefined') {
                    const badge = document.getElementById('savedCountBadge');
                    if (badge) badge.textContent = String(data.saved_count);
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .saved-jobs-page .dashboard-section-card {
        border-radius: 14px;
    }

    .saved-job-item {
        border-radius: 14px;
        border: 1px solid var(--dash-border);
        background: var(--dash-surface);
        transition: box-shadow 0.18s ease, transform 0.12s ease;
    }

    .saved-job-item:hover {
        box-shadow: 0 12px 30px rgba(15, 45, 82, 0.06);
        transform: translateY(-2px);
    }

    .saved-job-top {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .saved-job-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--dash-page-bg);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        color: var(--dash-accent);
        font-size: 1.15rem;
    }

    .saved-job-main {
        min-width: 0;
        flex: 1;
    }

    .saved-job-title {
        font-weight: 800;
        color: var(--dash-text);
        line-height: 1.2;
        margin-top: 2px;
    }

    .saved-job-subtitle {
        margin-top: 4px;
        font-size: 0.9rem;
        color: var(--dash-muted);
        line-height: 1.35;
        word-break: break-word;
    }

    .saved-job-actions {
        display: inline-flex;
        gap: 8px;
        flex: 0 0 auto;
    }

    .saved-job-meta {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .saved-meta-item {
        display: inline-flex;
        align-items: center;
        color: var(--dash-muted);
        font-size: 0.92rem;
    }

    .saved-job-desc {
        margin-top: 10px;
        color: var(--dash-muted);
        font-size: 0.95rem;
    }

    .saved-job-tags {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }


    @media (max-width: 575.98px) {
        .saved-job-top {
            flex-direction: column;
        }

        .saved-job-actions {
            width: 100%;
        }

        .saved-job-actions .btn {
            flex: 1;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/saved-jobs.blade.php ENDPATH**/ ?>