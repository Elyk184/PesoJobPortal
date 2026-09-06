<!DOCTYPE html>


<?php $__env->startSection('title', 'Job Opportunities - Link Job Resource Portal'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

:root{
    --jobs-brand-blue:#0f2d52;
    --jobs-brand-blue-2:#1f4b8f;
    --jobs-brand-red:#d72638;
    --jobs-brand-red-2:#f24b5d;
    --jobs-brand-gold:#f4cb57;
    --jobs-page:#eef2f7;
    --jobs-surface:#ffffff;
    --jobs-border:#d9e2ee;
    --jobs-ink:#23374f;
    --jobs-muted:#607287;
    --jobs-success:#2f9d62;
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--jobs-page);
    color:var(--jobs-ink);
}

/* HERO */
.jobs-hero{
    background:linear-gradient(120deg,var(--jobs-brand-blue) 0%,var(--jobs-brand-blue-2) 100%);
    color:#fff;
    padding:28px 20px 30px;
    position:relative;
    border-bottom:4px solid var(--jobs-brand-red);
    box-shadow:0 10px 30px rgba(10,35,80,.20);
}
.jobs-hero .lang-btn{
    position:absolute;
    top:16px;
    right:16px;
    width:38px;
    height:38px;
    border-radius:50%;
    border:1px solid rgba(255,255,255,.45);
    background:rgba(255,255,255,.14);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-decoration:none;
    font-size:18px;
}
.jobs-hero h1{
    font-weight:800;
    font-size:36px;
    margin-bottom:8px;
    letter-spacing:.2px;
}
.jobs-hero p{
    max-width:760px;
    margin:0 auto 14px;
    font-size:13px;
    opacity:.92;
}
.hero-actions .btn{
    border-radius:999px;
    font-weight:600;
    padding:7px 14px;
    font-size:13px;
}
.btn-jobseeker{
    background:linear-gradient(120deg,var(--jobs-brand-red),var(--jobs-brand-red-2));
    color:#fff;
    border:1px solid var(--jobs-brand-red);
    box-shadow:0 10px 20px rgba(215,38,56,.26);
}
.btn-jobseeker:hover{ color:#fff; filter:brightness(1.05); }
.btn-login{
    background:transparent;
    color:#fff;
    border:1px solid rgba(255,255,255,.7);
}
.btn-login:hover{
    background:rgba(255,255,255,.12);
    color:#fff;
}

/* FILTER BAR */
.filter-wrap{
    background:var(--jobs-surface);
    margin-top:14px;
    padding:12px 14px;
    border:1px solid var(--jobs-border);
    border-radius:14px;
    box-shadow:0 8px 22px rgba(15,45,82,.06);
}
.filter-wrap .row{
    row-gap:10px;
    align-items:end;
}
.filter-wrap .row > [class*='col-']{
    display:flex;
    flex-direction:column;
}
.filter-wrap .row > .d-flex{
    flex-direction:row;
    align-items:end;
}
.filter-wrap label{
    font-size:11px;
    font-weight:600;
    margin-bottom:4px;
    color:var(--jobs-muted);
}
.filter-wrap .form-control,
.filter-wrap .form-select{
    height:34px;
    font-size:12px;
    border-color:#ccd8e7;
}
.filter-wrap .filter-btn{
    width:100%;
    height:34px;
    background:linear-gradient(120deg,var(--jobs-brand-red),var(--jobs-brand-red-2));
    border:1px solid var(--jobs-brand-red);
    color:#fff;
    font-weight:600;
    border-radius:8px;
    font-size:12px;
}
.filter-wrap .filter-btn:hover{ filter:brightness(1.05); }

/* STATS */
.stats-row{
    margin-top:14px;
}
.stat-card{
    border-radius:12px;
    color:var(--jobs-ink);
    text-align:center;
    padding:10px 10px 8px;
    box-shadow:0 8px 20px rgba(15,45,82,.07);
    border:1px solid var(--jobs-border);
    min-height:108px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:2px;
}
.stat-card .icon{
    font-size:20px;
    line-height:1;
    margin-bottom:6px;
}
.stat-card .value{
    font-size:20px;
    font-weight:700;
    margin-bottom:2px;
    line-height:1.05;
}
.stat-card .label{
    font-size:12px;
    font-weight:600;
    line-height:1.25;
}
.stat-card .sub{
    font-size:12px;
    color:var(--jobs-muted);
}
.stat-blue{ background:#eef5ff; border-top:4px solid #2f6fd5; }
.stat-blue .icon,.stat-blue .value{ color:#2f6fd5; }
.stat-green{ background:#edf8f2; border-top:4px solid var(--jobs-success); }
.stat-green .icon,.stat-green .value{ color:var(--jobs-success); }
.stat-cyan{ background:#eef7fb; border-top:4px solid #2f7fb0; }
.stat-cyan .icon,.stat-cyan .value{ color:#2f7fb0; }
.stat-yellow{ background:#fff8e8; border-top:4px solid #c89622; }
.stat-yellow .icon,.stat-yellow .value{ color:#c89622; }

/* TABLE */
.jobs-table-wrap{
    margin-top:10px;
    border:1px solid var(--jobs-border);
    border-radius:14px;
    overflow:auto;
    background:var(--jobs-surface);
    box-shadow:0 10px 24px rgba(15,45,82,.08);
}
.jobs-table{
    width:100%;
    min-width:1280px;
    border-collapse:collapse;
    font-size:13px;
}
.jobs-table thead th{
    background:var(--jobs-brand-blue);
    color:#fff;
    padding:9px 8px;
    text-align:left;
    font-weight:600;
    border-right:1px solid rgba(255,255,255,.15);
    white-space:nowrap;
    vertical-align:middle;
}
.jobs-table tbody td{
    padding:8px 8px;
    border-top:1px solid #e2e8f0;
    vertical-align:middle;
    line-height:1.35;
}
.jobs-table tbody tr:nth-child(even){ background:#fafcff; }
.jobs-table tbody td:nth-child(5),
.jobs-table tbody td:nth-child(6),
.jobs-table tbody td:nth-child(7),
.jobs-table tbody td:nth-child(8),
.jobs-table tbody td:nth-child(9),
.jobs-table tbody td:nth-child(10),
.jobs-table tbody td:nth-child(11){
    vertical-align:middle;
}
.jobs-table tbody td:nth-child(6),
.jobs-table tbody td:nth-child(7),
.jobs-table tbody td:nth-child(8),
.jobs-table tbody td:nth-child(9),
.jobs-table tbody td:nth-child(10),
.jobs-table tbody td:nth-child(11){
    text-align:center;
}
.jobs-table .job-title{
    font-weight:700;
    margin-bottom:2px;
    color:var(--jobs-ink);
    line-height:1.25;
}
.jobs-table tbody td:nth-child(1){
    min-width:240px;
}
.jobs-table tbody td:nth-child(2),
.jobs-table tbody td:nth-child(3),
.jobs-table tbody td:nth-child(4),
.jobs-table tbody td:nth-child(5),
.jobs-table tbody td:nth-child(6),
.jobs-table tbody td:nth-child(7),
.jobs-table tbody td:nth-child(8),
.jobs-table tbody td:nth-child(9),
.jobs-table tbody td:nth-child(10),
.jobs-table tbody td:nth-child(11){
    vertical-align:middle;
}
.jobs-table .job-snippet{
    color:var(--jobs-muted);
    font-size:10px;
    line-height:1.5;
}
.badge-type{
    background:#e8eff9;
    color:#1f4b8f;
    border-radius:4px;
    padding:2px 8px;
    font-size:11px;
    text-transform:lowercase;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:72px;
}
.badge-open{
    background:var(--jobs-success);
    color:#fff;
    border-radius:4px;
    font-size:11px;
    padding:2px 6px;
    font-weight:600;
}
.badge-app{
    background:#1f4b8f;
    color:#fff;
    border-radius:10px;
    font-size:11px;
    padding:1px 7px;
    display:inline-block;
    font-weight:600;
    min-width:26px;
}
.deadline{
    color:var(--jobs-brand-red);
    font-weight:700;
}
.apply-btn{
    border:1px solid var(--jobs-brand-red);
    color:var(--jobs-brand-red);
    background:#fff;
    border-radius:6px;
    font-size:12px;
    padding:7px 10px;
    line-height:1.2;
    display:inline-flex;
    align-items:center;
    gap:4px;
    justify-content:center;
}
.apply-btn:hover{
    background:#fff2f4;
    color:var(--jobs-brand-red);
}

.jobs-summary{
    margin-top:16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    color:var(--jobs-muted);
    font-size:13px;
}
.jobs-summary strong{
    color:var(--jobs-ink);
}
.clear-filters-btn{
    border:1px solid var(--jobs-border);
    background:#fff;
    color:var(--jobs-ink);
    border-radius:999px;
    padding:5px 10px;
    font-size:11px;
    font-weight:600;
    text-decoration:none;
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:72px;
}
.clear-filters-btn:hover{
    background:#f6f9fd;
    color:var(--jobs-ink);
}
.jobs-pagination{
    margin-top:12px;
    padding-bottom:6px;
}

@media (min-width: 992px){
    .filter-wrap .col-lg-2.d-flex{
        align-self:end;
    }
}

.page-wrap{
    width:100%;
    max-width:none;
    margin:0;
    padding:0 12px 24px;
}

@media (max-width: 768px){
    .jobs-hero h1{ font-size:36px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="jobs-hero text-center">
    <a href="#" class="lang-btn" aria-label="Language"><i class="bi bi-translate"></i></a>
    <div class="container">
        <h1><i class="bi bi-briefcase me-2"></i> Job Opportunities</h1>
        <p>Discover exciting career opportunities in Manolo Fortich and surrounding areas. Verified jobs posted by approved employers.</p>
        <div class="hero-actions d-flex justify-content-center gap-2 flex-wrap">
            <a href="<?php echo e(route('register')); ?>" class="btn btn-jobseeker"><i class="bi bi-person-plus me-1"></i> Register as Jobseeker</a>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-login"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        </div>
    </div>
</section>

<div class="page-wrap">
    <div class="filter-wrap">
        <form method="GET" action="<?php echo e(url()->current()); ?>">
            <div class="row g-2 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label>Keyword</label>
                    <input type="text" name="keyword" value="<?php echo e($keyword ?? request('keyword')); ?>" class="form-control" placeholder="Job title, company...">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Location</label>
                    <input type="text" name="location" value="<?php echo e($location ?? request('location')); ?>" class="form-control" placeholder="e.g. Manolo Fortich">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Employment Type</label>
                    <select name="employment_type" class="form-select">
                        <option value="all" <?php echo e((($employmentType ?? request('employment_type', 'all')) === 'all') ? 'selected' : ''); ?>>All Types</option>
                        <?php $__currentLoopData = ($employmentTypes ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e((($employmentType ?? request('employment_type')) === $value) ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="filter-btn flex-grow-1"><i class="bi bi-search me-1"></i> Filter Jobs</button>
                    <a href="<?php echo e(route('jobs.index')); ?>" class="clear-filters-btn flex-shrink-0">Clear</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row g-3 stats-row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-blue">
                <div class="icon"><i class="bi bi-briefcase"></i></div>
                <div class="value"><?php echo e($activeJobsCount ?? 0); ?></div>
                <div class="label">Active Jobs</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-green">
                <div class="icon"><i class="bi bi-eye"></i></div>
                <div class="value"><?php echo e($totalViews ?? 0); ?></div>
                <div class="label">Total Views</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-cyan">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div class="value"><?php echo e($totalApplications ?? 0); ?></div>
                <div class="label">Total Applications</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-yellow">
                <div class="icon"><i class="bi bi-calendar-check"></i></div>
                <div class="value" style="font-size:30px;">Updated Daily</div>
                <div class="sub">Fresh Listings</div>
            </div>
        </div>
    </div>

    <div class="jobs-table-wrap">
        <table class="jobs-table">
            <thead>
                <tr>
                    <th style="width:33%">Job Title</th>
                    <th style="width:12%">Company</th>
                    <th style="width:16%">Location</th>
                    <th style="width:7%">Type</th>
                    <th style="width:9%">Salary</th>
                    <th style="width:5%">Vacancies</th>
                    <th style="width:5%">Status</th>
                    <th style="width:6%">Applications</th>
                    <th style="width:8%">Deadline</th>
                    <th style="width:6%">Posted</th>
                    <th style="width:8%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="job-title"><?php echo e($job->title); ?></div>
                        </td>
<td>
    <?php
        $employerId = $job->employer_id ?? null;
        $employerName = $job->employer_name ?? $job->employer?->name ?? 'N/A';
    ?>
    <?php if($employerId): ?>
        <a href="<?php echo e(route('companies.preview', $employerId)); ?>" class="text-decoration-none" style="color:inherit; font-weight:800;">
            <?php echo e($employerName); ?>

        </a>
    <?php else: ?>
        <strong><?php echo e($employerName); ?></strong>
    <?php endif; ?>
</td>
                        <td><i class="bi bi-geo-alt"></i> <?php echo e($job->location ?? '—'); ?></td>
                        <td><span class="badge-type"><?php echo e($job->job_type ?? '—'); ?></span></td>
                        <td><strong><?php echo e($job->salary_range ?? ($job->salary ? '₱'.number_format($job->salary) : 'Negotiable')); ?></strong></td>
                        <td><?php echo e($job->vacancies ?? 1); ?></td>
                        <td>
                            <?php if($job->status === 'active' && (!$job->is_filled)): ?>
                                <span class="badge-open">Open</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Closed</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge-app"><?php echo e($job->applications()->count()); ?></span></td>
                        <td class="deadline"><?php echo e($job->application_end_date ? $job->application_end_date->format('M d, Y') : '—'); ?></td>
                        <td><?php echo e($job->created_at->diffForHumans()); ?></td>
                        <td>
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('jobs.show', $job)); ?>" class="apply-btn"><i class="bi bi-arrow-right-circle"></i> View / Apply</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" class="text-center py-4">No job postings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="jobs-summary">
        <div>
            Showing <strong><?php echo e($jobs->firstItem() ?? 0); ?>-<?php echo e($jobs->lastItem() ?? 0); ?></strong>
            of <strong><?php echo e($jobs->total()); ?></strong> matching jobs.
            <span class="ms-2">Total active jobs available: <strong><?php echo e($activeJobsCount ?? 0); ?></strong>.</span>
        </div>
    </div>

    <div class="d-flex justify-content-center jobs-pagination">
        <?php echo e($jobs->links()); ?>

    </div>
</div>
<?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\jobs.blade.php ENDPATH**/ ?>