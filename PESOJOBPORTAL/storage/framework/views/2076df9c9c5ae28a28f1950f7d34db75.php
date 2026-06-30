<?php $__env->startSection('title', 'Applicants - PESO'); ?>
<?php $__env->startSection('hide_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
    .applicants-page {
        --ap-primary: #075cb2;
        --ap-primary-soft: #ecf3ff;
        --ap-border: #d9e6f6;
        --ap-shadow: 0 12px 26px rgba(21, 61, 117, 0.08);
        --ap-landing-blue: #075cb2;
        --ap-landing-blue-soft: #3498db;
        --ap-landing-blue-deep: #2980b9;
    }
    .page-hero {
        background: linear-gradient(135deg, var(--ap-landing-blue) 0%, var(--ap-landing-blue-soft) 100%);
        border: 2px solid rgba(7, 92, 178, 0.5);
        border-radius: 18px;
        padding: 2rem 2rem;
        box-shadow: 0 12px 24px rgba(7, 92, 178, 0.28);
    }
    .page-hero-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .hero-copy {
        flex: 1 1 420px;
    }
    .hero-meta {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #ffffff;
        border-radius: 999px;
        padding: 0.55rem 1rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .hero-meta i {
        font-size: 0.95rem;
    }
    .page-hero h4 {
        color: #ffffff;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .page-hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.92);
        line-height: 1.5;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--ap-border);
        padding: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 1.25rem;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(15, 49, 96, 0.06);
        position: relative;
        overflow: hidden;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(31, 79, 143, 0.08), transparent);
        border-radius: 50%;
        transition: all 0.6s ease;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(15, 49, 96, 0.14);
        border-color: #b8d5f0;
    }
    .stat-card:hover::before {
        top: -20%;
        right: -20%;
    }
    .stat-card.clickable-stat {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card.clickable-stat:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 32px rgba(15, 49, 96, 0.22);
        border-color: #2b67b1;
        background: linear-gradient(135deg, #ffffff 0%, #f0f6ff 100%);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .stat-icon.bg-primary {
        background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);
    }
    .stat-icon.bg-warning {
        background: linear-gradient(135deg, #ff9800 0%, #ffb74d 100%);
    }
    .stat-icon.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #51cf66 100%);
    }
    .stat-icon.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    }
    .stat-info {
        position: relative;
        z-index: 1;
        flex: 1;
    }
    .stat-info h3 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 0.25rem 0;
        color: #0f172a;
        letter-spacing: -0.5px;
    }
    .stat-info p {
        margin: 0;
        color: #7a8a9a;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .filter-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--ap-border);
        padding: 2.25rem;
        box-shadow: 0 4px 12px rgba(15, 49, 96, 0.05);
        transition: all 0.3s ease;
    }
    .filters-grid {
        display: grid;
        grid-template-columns: 1.1fr 1.1fr 1.6fr auto;
        gap: 1.1rem;
        align-items: end;
    }
    .filter-field {
        min-width: 0;
    }
    .filter-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1.2rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid #e4edf7;
    }
    .filter-title {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #1c4c85;
        letter-spacing: 0.2px;
    }
    .filter-title i {
        color: #2b67b1;
    }
    .filter-caption {
        margin: 0;
        color: #73849a;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .label-with-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .filter-card .form-label {
        color: #274f82;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.6rem;
        display: block;
    }
    .filter-card .form-control,
    .filter-card .form-select {
        border: 1.5px solid #d3dfe8;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        height: 46px;
        font-size: 0.95rem;
        color: #243447;
        transition: all 0.25s ease;
        background: #fafbfc;
    }
    .filter-card .form-control::placeholder {
        color: #7b8a9a;
    }
    .filter-card .form-control:hover,
    .filter-card .form-select:hover {
        border-color: #b8d5f0;
        background: #ffffff;
    }
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #2b67b1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(43, 103, 177, 0.12);
    }
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: nowrap;
    }
    .filter-actions .btn {
        transition: all 0.25s ease;
        font-weight: 600;
        border-radius: 10px;
        height: 46px;
        padding: 0.7rem 1.2rem;
        white-space: nowrap;
    }
    .filter-actions .btn-primary {
        background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);
        border: none;
        box-shadow: 0 4px 12px rgba(31, 79, 143, 0.2);
    }
    .filter-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(31, 79, 143, 0.3);
    }
    .btn-reset-filters {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        min-width: 112px;
        color: #125b5b;
        background: #e8f7f5;
        border: 1.5px solid #8ed7ce;
        box-shadow: 0 2px 10px rgba(18, 91, 91, 0.08);
    }
    .btn-reset-filters:hover {
        color: #0f4e4e;
        background: #d7f0ed;
        border-color: #56b9ab;
    }
    .btn-reset-filters i {
        font-size: 0.9rem;
    }
    .table-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
        white-space: nowrap;
    }

    .applicants-table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--ap-border);
        box-shadow: 0 4px 16px rgba(15, 49, 96, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    /* Make the applicants table card stretch edge-to-edge within the page */
    .applicants-table-card.full-bleed {
        border-radius: 16px;
        margin-left: 0;
        margin-right: 0;
        width: 100%;
    }
    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.8rem 1.1rem;
        background: #f8fbff;
        border-bottom: 1px solid #deebf9;
    }
    .table-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #1a467d;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .table-count {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        background: #eaf3ff;
        color: #1f4f8f;
        border: 1px solid #cadff7;
        padding: 0.35rem 0.7rem;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .th-label {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }
    .table {
        width: 100%;
        min-width: unset;
        margin-bottom: 0;
    }
    .table thead {
        background: linear-gradient(90deg, #f0f6ff 0%, #f3f8ff 100%);
    }
    .table thead th {
        border-bottom: 2px solid #d8e6f6;
        font-weight: 700;
        color: #1f4f8f;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 1.25rem 1.25rem;
        background: transparent;
    }
    .table tbody td {
        padding: 1.25rem 1.25rem;
        vertical-align: middle;
        border-color: #f1f5f9;
    }
    /* Removed inconsistent first-child padding for uniformity */
    .d-flex.align-items-start.gap-3 {
        gap: 1rem;
    }
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 6px 12px rgba(15,49,96,0.08);
    }
    .user-initials {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 4px 10px rgba(15,49,96,0.06);
    }
    .user-info .name {
        display: block;
        font-weight: 700;
        margin-bottom: 0.1rem;
    }
    .user-info .email {
        display: block;
        color: #6b7280;
        font-size: 0.88rem;
    }
    .table-actions {
        justify-content: flex-end;
        align-items: flex-start;
    }
    @media (min-width: 992px) {
        .table thead th:nth-child(1),
        .table tbody td:nth-child(1) { text-align: left; }
        .table thead th:nth-child(2),
        .table tbody td:nth-child(2) { text-align: left; }
        .table thead th:nth-child(3),
        .table tbody td:nth-child(3) { text-align: left; }
        .table thead th:nth-child(4),
        .table tbody td:nth-child(4) { text-align: center; }
        .table thead th:nth-child(5),
        .table tbody td:nth-child(5) { text-align: center; }
        .table thead th:nth-child(6),
        .table tbody td:nth-child(6) { text-align: center; }
    }
    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e8f0f8;
    }
    .table tbody tr:hover {
        background: linear-gradient(90deg, #f8fbff 0%, #f0f7ff 100%);
        box-shadow: 0 4px 12px rgba(31, 79, 143, 0.08);
        transform: translateY(-1px);
    }
    .table tbody td {
        vertical-align: middle;
        padding: 0.9rem 1rem;
        color: #334155;
        font-size: 0.92rem;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #dbe4ee;
        transition: all 0.2s ease;
    }
    .table tbody tr:hover .user-avatar {
        border-color: #b8d5f0;
        box-shadow: 0 4px 8px rgba(31, 79, 143, 0.15);
    }
    .user-initials {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.08rem;
        min-width: 0;
    }
    .user-info .name {
        font-weight: 600;
        color: #0f172a;
        word-break: break-word;
    }
    .user-info .email {
        font-size: 0.85rem;
        color: #7a8a9a;
        word-break: break-all;
    }
    .applicant-link {
        color: #0f172a;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .applicant-link:hover { color: #2b67b1; text-decoration: underline; }
    .applicant-link:focus { outline: 3px solid rgba(43,103,177,0.18); border-radius: 6px; }

    .job-title { max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .action-btn:focus { outline: 3px solid rgba(43,103,177,0.18); }
    .status-badge {
        padding: 0.5em 0.9em;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid transparent;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .status-badge i {
        font-size: 0.5rem;
    }
    .action-btn {
        border-radius: 999px;
        padding: 0.4rem 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.18s ease;
        border: 1px solid transparent;
        font-size: 0.9rem;
        min-width: 64px;
        height: auto;
        white-space: nowrap;
    }
    .action-btn i { font-size: 0.92rem; }
    .action-text {
        display: inline-block;
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        line-height: 1;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 49, 96, 0.12);
    }
    /* Clear, readable colored pills */
    .action-btn.btn-outline-primary {
        background: #057a73;
        color: #ffffff;
        border-color: transparent !important;
    }
    .action-btn.btn-outline-primary:hover { background: #04645e; }
    .action-btn.btn-outline-success {
        background: #2d8f3a;
        color: #ffffff;
        border-color: transparent !important;
    }
    .action-btn.btn-outline-success:hover { background: #26762f; }
    .action-btn.btn-outline-danger {
        background: #c92b2b;
        color: #ffffff;
        border-color: transparent !important;
    }
    .action-btn.btn-outline-danger:hover { background: #a22424; }
    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
    }
    .empty-state i {
        font-size: 4.5rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    .empty-state h5 {
        color: #334155;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }
    .empty-state p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.95rem;
    }

    @media (max-width: 1199px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .filters-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .stat-card {
            padding: 1.5rem;
        }
        .stat-icon {
            width: 54px;
            height: 54px;
            font-size: 1.5rem;
        }
        .stat-info h3 {
            font-size: 1.75rem;
        }
    }
    @media (max-width: 991.98px) {
        .page-hero {
            padding: 1.5rem;
        }
        .hero-meta {
            width: 100%;
            justify-content: center;
        }
        .filter-card {
            padding: 1.5rem;
        }
        .filter-card-header {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        .filters-grid {
            grid-template-columns: 1fr;
        }
        .filter-actions {
            width: 100%;
            margin-top: 0.5rem;
        }
        .filter-actions .btn {
            flex: 1;
        }
        .btn-reset-filters {
            min-width: 0;
        }
        .stat-card {
            padding: 1.5rem;
            gap: 1rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
        .stat-info h3 {
            font-size: 1.5rem;
        }
        .table-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    @media (min-width: 992px) {
        .filters-row-desktop {
            flex-wrap: nowrap;
        }
        .action-btn {
            width: auto;
            min-width: 72px;
            padding: 0.45rem 0.95rem;
            border-radius: 999px;
        }
        .action-text {
            display: inline;
        }
    }
    @media (max-width: 768px) {
        .page-hero {
            padding: 1rem;
        }
        .filter-card {
            padding: 1rem;
        }
        .table thead th {
            padding: 0.85rem 0.75rem;
            font-size: 0.7rem;
        }
        .table tbody td {
            padding: 0.9rem 0.75rem;
            font-size: 0.85rem;
        }
        .table tbody td:first-child {
            padding-left: 1rem;
        }
        .table thead th:first-child {
            padding-left: 1rem;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            font-size: 0.85rem;
            padding: 0;
            min-width: 36px;
        }
        .table-actions {
            gap: 0.4rem;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
        }
        .user-initials {
            width: 38px;
            height: 38px;
            font-size: 0.8rem;
        }
    }

    /* Improve table usability: sticky header and scroll for large result sets */
    .table-responsive {
        max-height: 56vh;
        overflow: auto;
    }
    .table-responsive .table thead th {
        position: sticky;
        top: 0;
        z-index: 3;
        background: linear-gradient(90deg, #f0f6ff 0%, #f3f8ff 100%);
    }

    /* On smaller screens show icon-only action buttons for compactness */
    @media (max-width: 768px) {
        .action-text { display: none; }
        .action-btn { width: 36px; height: 36px; padding: 0; }
    }
</style>

<div class="applicants-page">
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-hero">
                <div class="page-hero-content">
                    <div class="hero-copy">
                        <h4>All Applicants</h4>
                        <p>Manage application progress, review candidate details, and move hiring decisions faster.</p>
                    </div>
                    <div class="hero-meta">
                        <i class="bi bi-people"></i>
                        <span><?php echo e($totalApplicants); ?> Total Applicants</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Overview Section -->
    <div class="stats-grid mb-4">
        <div>
            <div class="stat-card clickable-stat" data-filter-type="reset" style="cursor: pointer;" title="Click to show all applicants">
                <div class="stat-icon bg-primary text-white"><i class="bi bi-people-fill"></i></div>
                <div class="stat-info">
                    <h3><?php echo e($totalApplicants); ?></h3>
                    <p>Total Applicants</p>
                </div>
            </div>
        </div>
        <div>
            <div class="stat-card clickable-stat" data-filter-type="status" data-filter-value="pending" style="cursor: pointer;" title="Click to show pending applicants">
                <div class="stat-icon bg-warning text-white"><i class="bi bi-clock-history"></i></div>
                <div class="stat-info">
                    <h3><?php echo e($pendingReview); ?></h3>
                    <p>Pending</p>
                </div>
            </div>
        </div>
        <div>
            <div class="stat-card clickable-stat" data-filter-type="status" data-filter-value="recommended" style="cursor: pointer;" title="Click to show recommended applicants">
                <div class="stat-icon bg-info text-white"><i class="bi bi-star-fill"></i></div>
                <div class="stat-info">
                    <h3><?php echo e($recommended ?? 0); ?></h3>
                    <p>Recommended</p>
                </div>
            </div>
        </div>
        <div>
            <div class="stat-card clickable-stat" data-filter-type="status" data-filter-value="hired" style="cursor: pointer;" title="Click to show approved applicants">
                <div class="stat-icon bg-success text-white"><i class="bi bi-check-circle-fill"></i></div>
                <div class="stat-info">
                    <h3><?php echo e($approved); ?></h3>
                    <p>Approved</p>
                </div>
            </div>
        </div>
        <div>
            <div class="stat-card clickable-stat" data-filter-type="status" data-filter-value="rejected" style="cursor: pointer;" title="Click to show rejected applicants">
                <div class="stat-icon bg-danger text-white"><i class="bi bi-x-circle-fill"></i></div>
                <div class="stat-info">
                    <h3><?php echo e($rejected); ?></h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-card">
                <div class="filter-card-header">
                    <h5 class="filter-title"><i class="bi bi-sliders"></i>Filter Applicants</h5>
                    <p class="filter-caption">Use fields below to find matching candidates faster.</p>
                </div>
                <form method="GET" class="filters-grid filters-row-desktop">
                    <div class="filter-field">
                        <label class="form-label fw-medium"><span class="label-with-icon"><i class="bi bi-briefcase"></i>Job Position</span></label>
                        <select name="job_id" class="form-select">
                            <option value="">All Jobs</option>
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($job->id); ?>" <?php echo e(request('job_id') == $job->id ? 'selected' : ''); ?>>
                                <?php echo e($job->title); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="filter-field">
                        <label class="form-label fw-medium"><span class="label-with-icon"><i class="bi bi-clipboard-check"></i>Application Status</span></label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="reviewing" <?php echo e(request('status') == 'reviewing' ? 'selected' : ''); ?>>Reviewing</option>
                            <option value="recommended" <?php echo e(request('status') == 'recommended' ? 'selected' : ''); ?>>Recommended</option>
                            <option value="interviewed" <?php echo e(request('status') == 'interviewed' ? 'selected' : ''); ?>>Interviewed</option>
                            <option value="hired" <?php echo e(request('status') == 'hired' ? 'selected' : ''); ?>>Hired</option>
                            <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="filter-field">
                        <label class="form-label fw-medium"><span class="label-with-icon"><i class="bi bi-search"></i>Search Applicant</span></label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="filter-field">
                        <div class="d-flex gap-2 filter-actions">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel-fill me-1"></i>Filter
                            </button>
                            <a href="<?php echo e(route('employer.applicants.index')); ?>" class="btn btn-reset-filters" title="Reset Filters">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Reset</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="applicants-table-card full-bleed">
                <div class="table-card-header">
                    <h5 class="table-title"><i class="bi bi-person-lines-fill"></i>Applicant Results</h5>
                    <span class="table-count"><i class="bi bi-people"></i><?php echo e($referredApplications->count()); ?> records</span>
                </div>
                <?php if($referredApplications->isEmpty()): ?>
                <div class="text-center empty-state">
                    <i class="bi bi-inbox text-muted d-block mb-3" style="font-size: 4rem;"></i>
                    <h5 class="mb-2">No Applicants Found</h5>
                    <p class="text-muted">Try adjusting your filters or check back later.</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><span class="th-label"><i class="bi bi-person"></i>Name</span></th>
                                <th><span class="th-label"><i class="bi bi-briefcase"></i>Job Applied</span></th>
                                <th><span class="th-label"><i class="bi bi-calendar-event"></i>Date Applied</span></th>
                                <th><span class="th-label"><i class="bi bi-activity"></i>Status</span></th>
                                <th><span class="th-label"><i class="bi bi-clock-history"></i>Timeline</span></th>
                                <th><span class="th-label"><i class="bi bi-lightning-charge"></i>Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $referredApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // Handle both job applications and recommendations
                                $isRecommendation = $application->applicant_type === 'recommendation';
                                $applicant = $isRecommendation ? $application->jobseeker : $application->user;
                                $job = $isRecommendation ? $application->job : $application->jobPost;
                                $dateApplied = $isRecommendation ? $application->created_at : $application->applied_at;
                                $applicantName = $isRecommendation ? $application->user_name : $application->applicant->name;
                                $applicantEmail = $isRecommendation ? $application->user_email : $application->applicant->email;
                                $applicantAvatar = $isRecommendation ? ($applicant->avatar ?? null) : ($application->applicant->avatar ?? null);
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if($applicantAvatar): ?>
                                        <img src="<?php echo e(Storage::url($applicantAvatar)); ?>" alt="<?php echo e($applicantName); ?>" class="user-avatar">
                                        <?php else: ?>
                                        <div class="user-initials" style="background: linear-gradient(135deg, #1f4f8f 0%, #2b67b1 100%);">
                                            <?php echo e(strtoupper(substr($applicantName, 0, 1))); ?>

                                        </div>
                                        <?php endif; ?>
                                        <div class="user-info">
                                            <?php if(!$isRecommendation): ?>
                                                <a href="<?php echo e(route('employer.applications.show', $application->id)); ?>" class="applicant-link name"><?php echo e($applicantName); ?></a>
                                            <?php else: ?>
                                                <span class="name"><?php echo e($applicantName); ?></span>
                                            <?php endif; ?>
                                            <span class="email"><?php echo e($applicantEmail); ?></span>
                                            <?php if($isRecommendation): ?>
                                            <span class="badge bg-info-subtle text-info ms-2" style="font-size: 0.75rem;">Recommended</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="job-title" title="<?php echo e($job->title ?? 'N/A'); ?>"><?php echo e(\Illuminate\Support\Str::limit($job->title ?? 'N/A', 60)); ?></td>
                                <td><?php echo e($dateApplied->format('M d, Y')); ?></td>
                                <td>
                                    <?php
                                        $statusClasses = [
                                            'pending' => 'bg-light text-dark',
                                            'reviewing' => 'bg-info bg-opacity-25 text-info-emphasis',
                                            'recommended' => 'bg-primary bg-opacity-25 text-primary-emphasis',
                                            'interviewed' => 'bg-secondary bg-opacity-25 text-secondary-emphasis',
                                            'hired' => 'bg-success bg-opacity-25 text-success-emphasis',
                                            'rejected' => 'bg-danger bg-opacity-25 text-danger-emphasis',
                                        ];
                                    ?>
                                    <span class="status-badge <?php echo e($statusClasses[$application->status] ?? 'bg-light text-dark'); ?>">
                                        <i class="bi bi-circle-fill" style="font-size: 0.45rem;"></i>
                                        <?php echo e($application->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php
                                        $now = now();
                                        $diff = (int) abs($dateApplied->diffInDays($now));
                                        if ($diff == 0) {
                                            $timelineText = 'Today';
                                        } elseif ($diff == 1) {
                                            $timelineText = '1 day ago';
                                        } elseif ($diff < 7) {
                                            $timelineText = $diff . ' days ago';
                                        } elseif ($diff < 14) {
                                            $timelineText = '1 week ago';
                                        } elseif ($diff < 30) {
                                            $weeks = floor($diff / 7);
                                            $timelineText = $weeks . ' weeks ago';
                                        } elseif ($diff < 60) {
                                            $timelineText = '1 month ago';
                                        } else {
                                            $months = floor($diff / 30);
                                            $timelineText = $months . ' months ago';
                                        }
                                    ?>
                                    <span style="font-size: 0.85rem; color: #637892; font-weight: 600;">
                                        <i class="bi bi-clock" style="font-size: 0.8rem; margin-right: 0.3rem;"></i><?php echo e($timelineText); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <?php if($isRecommendation): ?>
                                            <button type="button" class="btn btn-sm btn-outline-primary action-btn" title="View Details" onclick="alert('Recommendation Details\n\nFrom: <?php echo e($application->recommendedBy->name ?? 'Admin'); ?>\n\nMessage: <?php echo e($application->recommendation_reason ?? 'No message provided'); ?>')">
                                                <i class="bi bi-eye-fill"></i>
                                                <span class="action-text">View</span>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('employer.applications.show', $application->id)); ?>" class="btn btn-sm btn-outline-primary action-btn" title="View Details">
                                                <i class="bi bi-eye-fill"></i>
                                                <span class="action-text">View</span>
                                            </a>
                                            <?php if($application->status != 'hired'): ?>
                                            <form method="POST" action="<?php echo e(route('employer.applications.update', $application->id)); ?>" class="ajax-status-form" data-application-id="<?php echo e($application->id); ?>" data-action="<?php echo e(route('employer.applications.update', $application->id)); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="hidden" name="status" value="hired">
                                                <button type="submit" class="btn btn-sm btn-outline-success action-btn" title="Mark as Hired" onclick="return confirm('Are you sure you want to mark this applicant as hired?')">
                                                    <i class="bi bi-check-lg"></i>
                                                    <span class="action-text">Hire</span>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            <?php if($application->status != 'rejected'): ?>
                                            <form method="POST" action="<?php echo e(route('employer.applications.update', $application->id)); ?>" class="ajax-status-form" data-application-id="<?php echo e($application->id); ?>" data-action="<?php echo e(route('employer.applications.update', $application->id)); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Reject Applicant" onclick="return confirm('Are you sure you want to reject this applicant?')">
                                                    <i class="bi bi-x-lg"></i>
                                                    <span class="action-text">Reject</span>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = '<?php echo e(csrf_token()); ?>';
    function mapStatusToClasses(status) {
        const map = {
            pending: 'bg-light text-dark',
            reviewing: 'bg-info bg-opacity-25 text-info-emphasis',
            recommended: 'bg-primary bg-opacity-25 text-primary-emphasis',
            interviewed: 'bg-secondary bg-opacity-25 text-secondary-emphasis',
            hired: 'bg-success bg-opacity-25 text-success-emphasis',
            rejected: 'bg-danger bg-opacity-25 text-danger-emphasis'
        };
        return map[status] || 'bg-light text-dark';
    }

    document.querySelectorAll('form.ajax-status-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to change this applicant\'s status?')) return;
            const action = form.dataset.action;
            const applicationId = form.dataset.applicationId;
            const formData = new FormData(form);
            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(json => {
                if (json.success) {
                    // find the table row for this application
                    const row = document.querySelector('form.ajax-status-form[data-application-id="' + applicationId + '"]').closest('tr');
                    if (!row) return;
                    const badge = row.querySelector('.status-badge');
                    if (badge) {
                        // update text
                        badge.textContent = '';
                        const icon = document.createElement('i');
                        icon.className = 'bi bi-circle-fill';
                        icon.style.fontSize = '0.45rem';
                        badge.appendChild(icon);
                        badge.append(' ' + json.application.status);
                        // replace classes
                        badge.className = 'status-badge ' + mapStatusToClasses(json.application.status);
                    }
                } else {
                    alert(json.message || 'Failed to update status');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred while updating status');
            });
        });
    });

    // Handle clickable stat cards
    document.querySelectorAll('.stat-card.clickable-stat').forEach(card => {
        card.addEventListener('click', function() {
            const filterType = this.dataset.filterType;
            const filterValue = this.dataset.filterValue;
            const statusSelect = document.querySelector('select[name="status"]');
            const filterForm = document.querySelector('form.filters-grid');

            if (filterType === 'reset') {
                // Reset all filters
                document.querySelector('select[name="job_id"]').value = '';
                statusSelect.value = '';
                document.querySelector('input[name="search"]').value = '';
            } else if (filterType === 'status') {
                // Set the status filter and submit
                statusSelect.value = filterValue;
            }

            // Scroll to filter section
            document.querySelector('.filter-card').scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Highlight the status dropdown briefly to show it's selected
            statusSelect.style.borderColor = '#2b67b1';
            statusSelect.style.boxShadow = '0 0 0 4px rgba(43, 103, 177, 0.2)';
            setTimeout(() => {
                statusSelect.style.borderColor = '';
                statusSelect.style.boxShadow = '';
            }, 2000);

            // Auto-submit the form after a brief delay
            setTimeout(() => {
                filterForm.submit();
            }, 400);
        });
    });
});
</script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/employer/view-applicants.blade.php ENDPATH**/ ?>