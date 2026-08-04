<?php $__env->startSection('title', 'Browse Jobs - PESO'); ?>
<?php $__env->startSection('page-title', 'Browse Jobs'); ?>
<?php $__env->startSection('page-subtitle', 'Find your dream job'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Job Listings - Full Width with Horizontal Filters -->
    <div class="col-12">
        <!-- Horizontal Filters Section -->
        <div class="jobseeker-card mb-4">
            <div class="jobseeker-card-body p-3">
                <form action="<?php echo e(route('jobseeker.browse-jobs')); ?>" method="GET" id="filterForm">
                    <!-- Filter Header with Toggle -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="bi bi-funnel me-2"></i>Filters
                            <?php if(request()->has('search') || request()->has('location') || request()->has('industry') || request()->has('barangay') || request()->has('employment_type')): ?>
                                <span class="badge bg-primary ms-2">Active</span>
                            <?php endif; ?>
                        </h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary d-lg-none" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                <i class="bi bi-sliders"></i> More
                            </button>
                        </div>
                    </div>

                    <!-- Horizontal Filter Row -->
                    <div class="filter-row">
                        <div class="row g-2">
                            <!-- Search -->
                            <div class="col-12 col-lg-3">
                                <label class="form-label small fw-semibold">Search</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Job title, keywords..." value="<?php echo e(request('search')); ?>">
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-6 col-lg-2">
                                <label class="form-label small fw-semibold">Location</label>
                                <select name="location" class="form-select form-select-sm">
                                    <option value="">All Locations</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($location); ?>" <?php echo e(request('location') == $location ? 'selected' : ''); ?>>
                                            <?php echo e($location); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Industry -->
                            <div class="col-6 col-lg-2">
                                <label class="form-label small fw-semibold">Industry</label>
                                <select name="industry" class="form-select form-select-sm">
                                    <option value="">All Industries</option>
                                    <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($industry); ?>" <?php echo e(request('industry') == $industry ? 'selected' : ''); ?>>
                                            <?php echo e($industry); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Employment Type -->
                            <div class="col-6 col-lg-2">
                                <label class="form-label small fw-semibold">Employment Type</label>
                                <select name="employment_type" class="form-select form-select-sm">
                                    <option value="">All Types</option>
                                    <option value="full_time" <?php echo e(request('employment_type') == 'full_time' ? 'selected' : ''); ?>>Full Time</option>
                                    <option value="part_time" <?php echo e(request('employment_type') == 'part_time' ? 'selected' : ''); ?>>Part Time</option>
                                    <option value="contract" <?php echo e(request('employment_type') == 'contract' ? 'selected' : ''); ?>>Contract</option>
                                    <option value="temporary" <?php echo e(request('employment_type') == 'temporary' ? 'selected' : ''); ?>>Temporary</option>
                                    <option value="internship" <?php echo e(request('employment_type') == 'internship' ? 'selected' : ''); ?>>Internship</option>
                                    <option value="freelance" <?php echo e(request('employment_type') == 'freelance' ? 'selected' : ''); ?>>Freelance</option>
                                </select>
                            </div>

                            <!-- Sort + Actions -->
                            <div class="col-12 col-lg-3">
                                <label class="form-label small fw-semibold">Sort By</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="sort" class="form-select form-select-sm">
                                        <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                                        <option value="expiring" <?php echo e(request('sort') == 'expiring' ? 'selected' : ''); ?>>Expiring Soon</option>
                                        <option value="salary_high" <?php echo e(request('sort') == 'salary_high' ? 'selected' : ''); ?>>Highest Salary</option>
                                        <option value="salary_low" <?php echo e(request('sort') == 'salary_low' ? 'selected' : ''); ?>>Lowest Salary</option>
                                    </select>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <button type="submit" class="btn btn-primary btn-sm px-2 d-inline-flex align-items-center gap-1 text-nowrap" aria-label="Filter">
                                            <i class="bi bi-funnel"></i>
                                            <span>Filter</span>
                                        </button>
                                        <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-outline-secondary btn-sm px-2 d-inline-flex align-items-center gap-1 text-nowrap" aria-label="Clear All" title="Clear All">
                                            <i class="bi bi-x-circle"></i>
                                            <span>Clear All</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsible Additional Filters -->
                        <div class="collapse mt-3" id="filterCollapse">
                            <div class="row g-2 pt-2 border-top">
                                <!-- Barangay -->
                                <div class="col-6 col-lg-3">
                                    <label class="form-label small fw-semibold">Barangay</label>
                                    <select name="barangay" class="form-select form-select-sm">
                                        <option value="">All Barangays</option>
                                        <?php $__currentLoopData = $barangays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barangay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($barangay); ?>" <?php echo e(request('barangay') == $barangay ? 'selected' : ''); ?>>
                                                <?php echo e($barangay); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filter Tags -->
                    <?php if(request()->has('search') || request()->has('location') || request()->has('industry') || request()->has('barangay') || request()->has('employment_type')): ?>
                        <div class="mt-3 pt-2 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">Active Filters:</small>
                                <?php if(request('search')): ?>
                                    <span class="badge bg-light text-dark border">
                                        Search: <?php echo e(request('search')); ?>

                                        <a href="<?php echo e(request()->fullUrlWithQuery(['search' => null])); ?>" class="text-decoration-none ms-1">&times;</a>
                                    </span>
                                <?php endif; ?>
                                <?php if(request('location')): ?>
                                    <span class="badge bg-light text-dark border">
                                        Location: <?php echo e(request('location')); ?>

                                        <a href="<?php echo e(request()->fullUrlWithQuery(['location' => null])); ?>" class="text-decoration-none ms-1">&times;</a>
                                    </span>
                                <?php endif; ?>
                                <?php if(request('industry')): ?>
                                    <span class="badge bg-light text-dark border">
                                        Industry: <?php echo e(request('industry')); ?>

                                        <a href="<?php echo e(request()->fullUrlWithQuery(['industry' => null])); ?>" class="text-decoration-none ms-1">&times;</a>
                                    </span>
                                <?php endif; ?>
                                <?php if(request('barangay')): ?>
                                    <span class="badge bg-light text-dark border">
                                        Barangay: <?php echo e(request('barangay')); ?>

                                        <a href="<?php echo e(request()->fullUrlWithQuery(['barangay' => null])); ?>" class="text-decoration-none ms-1">&times;</a>
                                    </span>
                                <?php endif; ?>
                                <?php if(request('employment_type')): ?>
                                    <span class="badge bg-light text-dark border">
                                        Type: <?php echo e(\Illuminate\Support\Str::of(request('employment_type'))->replace(['_', '-'], ' ')->title()); ?>

                                        <a href="<?php echo e(request()->fullUrlWithQuery(['employment_type' => null])); ?>" class="text-decoration-none ms-1">&times;</a>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="jobseeker-card">
            <div class="jobseeker-card-header">
                <h5 class="jobseeker-card-title">
                    <i class="bi bi-briefcase me-2"></i>Available Jobs
                    <span class="badge bg-primary ms-2"><?php echo e($jobs->total()); ?></span>
                </h5>
                <small class="text-muted">Page <?php echo e($jobs->currentPage()); ?> of <?php echo e($jobs->lastPage()); ?></small>
            </div>
            <div class="jobseeker-card-body p-0">
                <?php if($jobs->count() > 0): ?>
                    <div class="job-list">
                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12">
                                <article class="job-card p-3 mb-3 d-flex flex-column flex-md-row align-items-start gap-3">
                                    <div class="logo-placeholder rounded-3 bg-light d-flex align-items-center justify-content-center me-3">
                                        <i class="bi bi-briefcase fs-3 text-secondary"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="job-title mb-1">
                                                    <a href="<?php echo e(route('jobseeker.apply-job', $job)); ?>" class="stretched-link text-dark"><?php echo e($job->title); ?></a>
                                                </h5>
                                                <p class="text-muted mb-1 small">
                                                    <i class="bi bi-building me-1"></i><?php echo e($job->company_name ?? 'Company'); ?>

                                                    <span class="mx-1">|</span>
                                                    <i class="bi bi-geo-alt me-1"></i><?php echo e($job->location); ?>

                                                </p>
                                            </div>
                                            <div class="text-md-end d-none d-md-block">
                                                <small class="text-muted">Posted <?php echo e($job->created_at->diffForHumans()); ?></small>
                                            </div>
                                        </div>

                                        <div class="job-tags mt-2">
                                            <span class="job-tag">
                                                <i class="bi bi-clock me-1"></i><?php echo e(ucfirst($job->employment_type)); ?>

                                            </span>
                                            <?php if($job->salary_min || $job->salary_max): ?>
                                                <span class="job-tag">
                                                    <i class="bi bi-currency-dollar me-1"></i>
                                                    <?php if($job->salary_min && $job->salary_max): ?>
                                                        ₱<?php echo e(number_format($job->salary_min)); ?> - ₱<?php echo e(number_format($job->salary_max)); ?>

                                                    <?php elseif($job->salary_min): ?>
                                                        From ₱<?php echo e(number_format($job->salary_min)); ?>

                                                    <?php else: ?>
                                                        Up to ₱<?php echo e(number_format($job->salary_max)); ?>

                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if($job->application_deadline): ?>
                                                <span class="job-tag job-tag-<?php echo e($job->application_deadline->isPast() ? 'danger' : ($job->application_deadline->diffInDays() <= 7 ? 'warning' : 'success')); ?>">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    <?php if($job->application_deadline->isPast()): ?>
                                                        Expired
                                                    <?php else: ?>
                                                        Expires <?php echo e($job->application_deadline->format('M d, Y')); ?>

                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <p class="mb-0 small text-muted mt-2"><?php echo e(\Illuminate\Support\Str::limit($job->description, 140)); ?></p>
                                    </div>

                                    <div class="job-card-actions ms-auto text-end d-flex flex-row flex-wrap align-items-center justify-content-end gap-2">
                                        <a href="<?php echo e(route('jobseeker.apply-job', $job)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php
                                                $isSaved = \App\Models\SavedJob::where('job_id', $job->id)->where('user_id', auth()->id())->exists();
                                            ?>
                                            <button
                                                type="button"
                                                class="btn btn-sm <?php echo e($isSaved ? 'btn-primary' : 'btn-outline-primary'); ?> js-save-job-btn"
                                                title="<?php echo e($isSaved ? 'Unsave' : 'Save'); ?>"
                                                aria-pressed="<?php echo e($isSaved ? 'true' : 'false'); ?>"
                                                data-job-id="<?php echo e($job->id); ?>"
                                                data-saved="<?php echo e($isSaved ? '1' : '0'); ?>"
                                                data-save-url="<?php echo e(route('jobseeker.saved-jobs.toggle', $job)); ?>"
                                            >
                                                <i class="bi <?php echo e($isSaved ? 'bi-bookmark-fill' : 'bi-bookmark'); ?> js-save-job-icon"></i>
                                            </button>
                                        <?php endif; ?>
                                        <small class="text-muted d-block d-md-none w-100 text-end">Posted <?php echo e($job->created_at->diffForHumans()); ?></small>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Showing <?php echo e($jobs->firstItem()); ?> to <?php echo e($jobs->lastItem()); ?> of <?php echo e($jobs->total()); ?> jobs
                            </small>
                            <?php echo e($jobs->appends(request()->query())->links()); ?>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-briefcase display-1 text-muted"></i>
                        <h5 class="mt-3">No jobs found</h5>
                        <p class="text-muted">Try adjusting your filters or check back later for new opportunities.</p>
                        <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>" class="btn btn-primary">
                            Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .jobseeker-card {
        border: 1px solid rgba(15, 45, 82, 0.08);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 45, 82, 0.06);
        overflow: hidden;
        background: #fff;
    }

    .jobseeker-card-body {
        padding: 1rem;
    }

    .jobseeker-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.1rem;
        border-bottom: 1px solid rgba(15, 45, 82, 0.08);
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.95), rgba(255, 255, 255, 0.98));
    }

    .jobseeker-card-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        color: #17365d;
        display: flex;
        align-items: center;
    }

    .jobseeker-card-title .badge {
        border-radius: 999px;
        padding: 0.35rem 0.6rem;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .filter-row {
        background: linear-gradient(180deg, #f8fafc, #ffffff);
        padding: 16px;
        border: 1px solid rgba(15, 45, 82, 0.08);
        border-radius: 14px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
    }
    .filter-row .form-control, .filter-row .form-select {
        min-height: 42px;
        border-radius: 10px;
        border-color: #d8e2ef;
        box-shadow: none;
    }
    .filter-row .btn {
        min-height: 42px;
        border-radius: 10px;
        font-weight: 700;
    }

    .filter-row .input-group-text {
        border-color: #d8e2ef;
        color: #6c7a89;
        border-radius: 10px 0 0 10px;
        background: #fff;
    }

    .filter-row .input-group .form-control {
        border-radius: 0 10px 10px 0;
    }

    .filter-row label {
        color: #52657a;
        margin-bottom: 0.35rem;
    }

    .filter-row .badge {
        border-radius: 999px;
        padding: 0.35rem 0.65rem;
    }

    .job-list {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }
    .job-title a {
        color: #2c3e50;
        text-decoration: none;
        font-weight: 800;
    }
    .job-title a:hover {
        color: #3498db;
    }
    .job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }
    .job-tag {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #f3f6fb;
        color: #54657a;
        border: 1px solid rgba(15, 45, 82, 0.08);
    }
    .job-tag-success { background: rgba(25, 135, 84, 0.1); color: #198754; }
    .job-tag-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .job-tag-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .job-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .job-card {
        background: linear-gradient(180deg, #ffffff, #fbfdff);
        border: 1px solid rgba(15, 45, 82, 0.09);
        border-left: 4px solid #2f6fd5;
        border-radius: 16px;
        transition: box-shadow 0.18s ease, transform 0.12s ease, border-color 0.12s ease;
        position: relative;
        padding: 1rem 1rem 0.95rem;
    }

    .job-card:hover {
        box-shadow: 0 16px 35px rgba(15, 45, 82, 0.1);
        transform: translateY(-3px);
        border-left-color: #d72638;
    }

    .job-card .logo-placeholder {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        border-radius: 14px;
        border: 1px solid rgba(15, 45, 82, 0.08);
    }

    .job-card-actions {
        min-width: 118px;
        display: flex;
        align-items: flex-end;
        position: relative;
        z-index: 3;
    }
    .job-card .stretched-link {
        text-decoration: none;
    }
    .job-card .stretched-link:hover { color: #0d6efd; }

    .job-card h5 {
        line-height: 1.2;
    }

    .job-card .text-muted.small {
        line-height: 1.45;
    }

    .job-card .btn {
        border-radius: 10px;
        font-weight: 700;
    }

    .job-card .btn-outline-primary {
        border-color: rgba(47, 111, 213, 0.3);
    }

    .job-card .btn-outline-secondary {
        border-color: rgba(108, 117, 125, 0.25);
    }

    .js-save-job-btn {
        min-width: 42px;
        position: relative;
        z-index: 4;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .job-actions {
            justify-content: flex-start;
            margin-top: 10px;
        }

        .job-card-actions {
            min-width: 100%;
            align-items: flex-start;
        }

        .job-card {
            padding: 0.9rem;
        }
    }

    /* Form controls styling */
    .form-select-sm, .form-control-sm {
        border-radius: 6px;
    }

    .input-group-text {
        background: #fff;
        border-radius: 6px 0 0 6px;
    }

    .input-group .form-control {
        border-radius: 0 6px 6px 0;
    }

    @media (max-width: 576px) {
        .jobseeker-card-header,
        .filter-row,
        .jobseeker-card-body {
            padding-left: 0.8rem;
            padding-right: 0.8rem;
        }

        .job-card {
            padding: 0.85rem;
        }

        .job-card .logo-placeholder {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
        }
    }
</style>
<?php $__env->startPush('scripts'); ?>
<script>
    (function () {
        const form = document.getElementById('filterForm');
        if (!form) return;

        // Auto-submit selects on change
        Array.from(form.querySelectorAll('select')).forEach(function (sel) {
            sel.addEventListener('change', function () { form.submit(); });
        });

        // Debounced search submit
        const searchInput = form.querySelector('input[name="search"]');
        if (searchInput) {
            let timer = null;
            searchInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () { form.submit(); }, 600);
            });
        }
    })();

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.js-save-job-btn');

        if (! button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const saveUrl = button.dataset.saveUrl;
        const icon = button.querySelector('.js-save-job-icon');
        const wasSaved = button.dataset.saved === '1';

        const setSavedState = function (isSaved) {
            button.dataset.saved = isSaved ? '1' : '0';
            button.title = isSaved ? 'Unsave' : 'Save';
            button.setAttribute('aria-pressed', isSaved ? 'true' : 'false');
            button.classList.toggle('btn-primary', isSaved);
            button.classList.toggle('btn-outline-primary', ! isSaved);

            if (icon) {
                icon.className = isSaved ? 'bi bi-bookmark-fill js-save-job-icon' : 'bi bi-bookmark js-save-job-icon';
            }
        };

        button.disabled = true;

        setSavedState(! wasSaved);

        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            setSavedState(Boolean(data.saved));
        })
        .catch(error => {
            console.error('Error saving job:', error);
            setSavedState(wasSaved);
        })
        .finally(() => {
            button.disabled = false;
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\jobseeker\browse-jobs.blade.php ENDPATH**/ ?>