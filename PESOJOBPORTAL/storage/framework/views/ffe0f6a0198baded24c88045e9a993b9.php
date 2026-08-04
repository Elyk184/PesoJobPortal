<?php $__env->startSection('title', 'Post New Job - PESO'); ?>
<?php $__env->startSection('hide_header', true); ?>

<?php $__env->startSection('content'); ?>
<style>
    .post-job-shell {
        --accent: #1f4f97;
        --accent-soft: #e8f0ff;
        --ink: #1f2937;
        --muted: #6b7280;
        --line: #e5e7eb;
        --bg-soft: #f4f7fc;
        font-family: "Poppins", "Segoe UI", Tahoma, sans-serif;
        color: var(--ink);
    }
    .composer-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 1.6rem;
        background: linear-gradient(135deg, #1f4f97 0%, #2f6ec8 45%, #5ca2ff 100%);
        color: #fff;
        box-shadow: 0 10px 28px rgba(31, 79, 151, 0.28);
    }
    .composer-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(255, 255, 255, 0.14);
        border-radius: 50%;
        right: -60px;
        top: -80px;
    }
    .hero-title {
        position: relative;
        z-index: 1;
        font-size: 1.55rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
    }
    .hero-subtitle {
        position: relative;
        z-index: 1;
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
    }
    .hero-meta {
        position: relative;
        z-index: 1;
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .hero-chip {
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 999px;
        padding: 0.3rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.15);
    }
    .notice-card {
        border: 0;
        border-radius: 14px;
        padding: 1rem 1.1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        box-shadow: 0 2px 10px rgba(17, 24, 39, 0.05);
    }
    .notice-card i {
        margin-top: 2px;
        font-size: 1.05rem;
    }
    .notice-company {
        background: #eef6ff;
        color: #0f3d7a;
    }
    .notice-approval {
        background: #fff7e9;
        color: #7a510f;
    }
    .job-form-card {
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        border: 1px solid #edf1f8;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
        padding: 2rem;
    }
    .form-grid-two {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.9rem;
    }
    .form-grid-two .mb-3 {
        margin-bottom: 0 !important;
    }
    .form-label {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 0.92rem;
        letter-spacing: 0.01em;
    }
    .form-block .mb-3 {
        border: 1px solid #e4ebf7;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        background: linear-gradient(180deg, #f9fbff 0%, #f5f8ff 100%);
        margin-bottom: 0.95rem !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .form-block .mb-3:focus-within {
        border-color: #8cb5f7;
        box-shadow: 0 0 0 4px rgba(47, 110, 200, 0.12);
        background: #ffffff;
    }
    .form-control, .form-select {
        border: 1px solid #d6dbe7;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s, transform 0.2s;
        background: #fff;
        font-size: 0.93rem;
        color: #1e293b;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
    }
    .form-control::placeholder,
    .form-select::placeholder {
        color: #94a3b8;
    }
    .form-control:hover,
    .form-select:hover {
        border-color: #b9c7df;
        background: #ffffff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2f6ec8;
        box-shadow: 0 0 0 4px rgba(47, 110, 200, 0.14);
        background: #fff;
        transform: translateY(-1px);
    }
    textarea.form-control {
        min-height: 120px;
        line-height: 1.45;
    }
    .text-muted {
        color: #64748b !important;
        font-size: 0.8rem;
    }
    .invalid-feedback,
    .text-danger.small {
        font-size: 0.79rem;
        font-weight: 600;
    }
    .is-invalid {
        border-color: #e11d48 !important;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12) !important;
    }
    .form-control[readonly] {
        background: #eef3fb;
        border-color: #d5deee;
        color: #334155;
    }
    .salary-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .salary-input-group .form-control {
        flex: 1;
    }
    .salary-separator {
        color: var(--muted);
        font-weight: 600;
    }
    .btn-post-job {
        background: linear-gradient(135deg, #11468f 0%, #1c78d1 100%);
        border: 1px solid #0f3f80;
        color: #fff;
        padding: 0.875rem 2rem;
        font-weight: 700;
        border-radius: 12px;
        letter-spacing: 0.01em;
        transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        box-shadow: 0 8px 18px rgba(17, 70, 143, 0.35);
    }
    .btn-post-job:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(17, 70, 143, 0.4);
        filter: saturate(1.05);
    }
    .btn-post-job:active {
        transform: translateY(0);
        box-shadow: 0 5px 12px rgba(17, 70, 143, 0.35);
    }
    .btn-save-draft {
        background: linear-gradient(135deg, #334155 0%, #1f2937 100%);
        border: 1px solid #1f2937;
        color: white;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        box-shadow: 0 7px 16px rgba(17, 24, 39, 0.28);
    }
    .btn-save-draft:hover {
        background: linear-gradient(135deg, #263445 0%, #111827 100%);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 9px 18px rgba(17, 24, 39, 0.35);
    }
    .btn-save-draft:active {
        transform: translateY(0);
    }
    .btn-cancel {
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1px solid #f4b8c0;
        color: #9f1239;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
        box-shadow: 0 6px 14px rgba(190, 24, 93, 0.12);
    }
    .btn-cancel:hover {
        background: linear-gradient(135deg, #ffe4e6 0%, #fecdd3 100%);
        color: #881337;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(190, 24, 93, 0.18);
    }
    .btn-cancel:active {
        transform: translateY(0);
    }
    .section-divider {
        border-top: 1px dashed #dfe5f1;
        margin: 2rem 0;
    }
    .form-block {
        position: relative;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 14px;
        padding: 1.2rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .form-block::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-top-left-radius: 14px;
        border-bottom-left-radius: 14px;
        background: #cfd8e6;
    }
    .form-block:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.07);
    }
    .block-primary {
        border-color: #d7e4fb;
    }
    .block-primary::before {
        background: #2f6ec8;
    }
    .block-success {
        border-color: #d6eee1;
    }
    .block-success::before {
        background: #1c8c5d;
    }
    .block-info {
        border-color: #d8ecf8;
    }
    .block-info::before {
        background: #2c79b7;
    }
    .block-warning {
        border-color: #f4e4c6;
    }
    .block-warning::before {
        background: #bf7a19;
    }
    .section-title {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        margin-bottom: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }
    .section-title > i,
    .section-title .section-icon {
        margin-top: 0.12rem;
    }
    .section-title-basic {
        align-items: center;
        gap: 0.5rem;
    }
    .section-title-basic > i {
        margin-top: 0;
    }
    .section-heading {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }
    .section-caption {
        margin: 0;
        color: var(--muted);
        font-size: 0.82rem;
        font-weight: 500;
    }
    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .form-actions {
        position: sticky;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(6px);
        margin: 1.25rem -2rem -2rem;
        padding: 1rem 2rem;
        border-top: 1px solid #e7ebf3;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }
    .form-actions .btn {
        width: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
    }
    .form-actions .btn:focus-visible {
        outline: 0;
        box-shadow: 0 0 0 3px #ffffff, 0 0 0 6px rgba(47, 110, 200, 0.35);
    }
    .action-buttons {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .required-note {
        margin: 0;
        color: #64748b;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    @media (max-width: 992px) {
        .job-form-card {
            padding: 1.3rem;
        }
        .form-block .mb-3 {
            padding: 0.8rem 0.85rem;
        }
        .form-actions {
            margin: 1rem -1.3rem -1.3rem;
            padding: 0.9rem 1.3rem;
        }
    }
    @media (max-width: 768px) {
        .composer-hero {
            padding: 1.25rem;
        }
        .hero-title {
            font-size: 1.35rem;
        }
        .salary-input-group {
            flex-direction: column;
            align-items: stretch;
        }
        .salary-separator {
            text-align: center;
        }
        .form-grid-two {
            grid-template-columns: 1fr;
        }
        .form-actions {
            position: static;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            border-radius: 12px;
            margin: 1rem 0 0;
            padding: 0;
            border: 0;
            background: transparent;
            backdrop-filter: none;
        }
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        .form-actions .btn {
            width: 100%;
        }
        .form-block:hover {
            transform: none;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .form-block,
        .btn-post-job,
        .btn-save-draft {
            transition: none;
        }
    }
</style>

<div class="post-job-shell">
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="composer-hero mb-4">
            <h2 class="hero-title">Create a New Job Post</h2>
            <p class="hero-subtitle">Design a clear, compelling listing to attract qualified candidates faster.</p>
            <div class="hero-meta">
                <span class="hero-chip"><i class="bi bi-shield-check me-1"></i>Employer Portal</span>
                <span class="hero-chip"><i class="bi bi-clock-history me-1"></i>Estimated completion: 5-8 mins</span>
            </div>
        </div>

        <!-- Company Info Banner -->
        <div class="notice-card notice-company mb-4" role="alert">
            <i class="bi bi-building me-2"></i>
            <div>
                <strong>Posting as:</strong> <?php echo e($companyProfile->company_name); ?>

                <?php if($companyProfile->is_verified): ?>
                <span class="badge bg-success ms-2"><i class="bi bi-check-circle me-1"></i>Verified</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approval Notice -->
        <div class="notice-card notice-approval mb-4" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            <div>
                <strong>Note:</strong> All job postings are submitted for admin approval before becoming active. You can view the status of your submissions in Manage Jobs. Once approved by admin, jobs will appear in Active Jobs and be visible to jobseekers.
            </div>
        </div>

        <!-- Job Post Form -->
        <div class="job-form-card">
            <form action="<?php echo e(route('employer.jobs.store')); ?>" method="POST" id="jobPostForm">
                <?php echo csrf_field(); ?>

                <!-- Basic Information Section -->
                <div class="mb-4 form-block block-primary">
                    <h5 class="section-title section-title-basic">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span class="section-heading">
                            Basic Information
                            <small class="section-caption">Core details applicants see first.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                               value="<?php echo e($companyProfile->company_name); ?>" readonly>
                        <input type="hidden" name="company_name" value="<?php echo e($companyProfile->company_name); ?>">
                        <small class="text-muted">This is automatically populated from your company profile</small>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="title" name="title"
                               placeholder="e.g. Senior Software Engineer"
                               value="<?php echo e(old('title')); ?>" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Choose a clear, specific title that describes the role</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="description" name="description" rows="6"
                                  placeholder="Provide an overview of the role..."
                                  required><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-grid-two mb-3">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="location" name="location"
                                   placeholder="e.g. Manila, Philippines or Remote"
                                   value="<?php echo e(old('location')); ?>" required>
                            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="employment_type" name="employment_type" required>
                                <option value="">Select employment type</option>
                                <?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php echo e(old('employment_type') == $value ? 'selected' : ''); ?>>
                                        <?php echo e($label); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vacancies" class="form-label">Number of Vacancies <span class="text-danger">*</span></label>
                        <input type="number" class="form-control <?php $__errorArgs = ['vacancies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="vacancies" name="vacancies"
                               placeholder="e.g. 5"
                               value="<?php echo e(old('vacancies', 1)); ?>" required min="1">
                        <?php $__errorArgs = ['vacancies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Key Responsibilities Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-primary">
                    <h5 class="section-title">
                        <div class="section-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-list-task"></i>
                        </div>
                        <span class="section-heading">
                            Responsibilities
                            <small class="section-caption">List the day-to-day tasks and ownership areas.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control bullet-field <?php $__errorArgs = ['key_responsibilities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="key_responsibilities" name="key_responsibilities" rows="5"
                                  placeholder="List the main duties and responsibilities for this role..." required><?php echo e(old('key_responsibilities')); ?></textarea>
                        <?php $__errorArgs = ['key_responsibilities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Qualifications Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-success">
                    <h5 class="section-title">
                        <div class="section-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check2-square"></i>
                        </div>
                        <span class="section-heading">
                            Qualifications
                            <small class="section-caption">Include required education, licenses, and credentials.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control bullet-field <?php $__errorArgs = ['qualifications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="qualifications" name="qualifications" rows="5"
                                  placeholder="List the required qualifications..." required><?php echo e(old('qualifications')); ?></textarea>
                        <?php $__errorArgs = ['qualifications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Required Skills Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-info">
                    <h5 class="section-title">
                        <div class="section-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-star"></i>
                        </div>
                        <span class="section-heading">
                            Required Skills
                            <small class="section-caption">Highlight technical and soft skills for this role.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control bullet-field <?php $__errorArgs = ['preferred_skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="preferred_skills" name="preferred_skills" rows="4"
                                  placeholder="List the required skills for this position..." required><?php echo e(old('preferred_skills')); ?></textarea>
                        <?php $__errorArgs = ['preferred_skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Experience Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-primary">
                    <h5 class="section-title">
                        <div class="section-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <span class="section-heading">
                            Experience
                            <small class="section-caption">Mention years, tools, and domain background preferred.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control bullet-field <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="experience" name="experience" rows="4"
                                  placeholder="e.g. 2-3 years of experience in software development..." required><?php echo e(old('experience')); ?></textarea>
                        <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Education Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-success">
                    <h5 class="section-title">
                        <div class="section-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <span class="section-heading">
                            Education
                            <small class="section-caption">Set the minimum educational attainment expected.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="education" name="education" rows="4"
                                  placeholder="e.g. Bachelor's degree in Computer Science or related field..." required><?php echo e(old('education')); ?></textarea>
                        <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-warning">
                    <h5 class="section-title">
                        <div class="section-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-gift"></i>
                        </div>
                        <span class="section-heading">
                            Benefits
                            <small class="section-caption">Show perks that make your offer more competitive.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <textarea class="form-control bullet-field <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="benefits" name="benefits" rows="4"
                                  placeholder="List the benefits and perks..." required><?php echo e(old('benefits')); ?></textarea>
                        <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Salary Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-success">
                    <h5 class="section-title">
                        <div class="section-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-cash"></i>
                        </div>
                        <span class="section-heading">
                            Salary (Optional)
                            <small class="section-caption">Transparent pay ranges often improve application quality.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Salary Range (PHP)</label>
                        <div class="salary-input-group">
                            <input type="number" class="form-control <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="salary_min" name="salary_min"
                                   placeholder="Min"
                                   value="<?php echo e(old('salary_min')); ?>" min="0" step="1000" required>
                            <span class="salary-separator">to</span>
                            <input type="number" class="form-control <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                    id="salary_max" name="salary_max"
                                   placeholder="Max"
                                   value="<?php echo e(old('salary_max')); ?>" min="0" step="1000" required>
                        </div>
                        <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Deadline Section -->
                <div class="section-divider"></div>
                <div class="mb-4 form-block block-warning">
                    <h5 class="section-title">
                        <div class="section-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-calendar"></i>
                        </div>
                        <span class="section-heading">
                            Application Deadline (Optional)
                            <small class="section-caption">Use a deadline to create urgency and planning clarity.</small>
                        </span>
                    </h5>

                    <div class="mb-3">
                        <label for="application_deadline" class="form-label">Last Date to Apply</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['application_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="application_deadline" name="application_deadline"
                               value="<?php echo e(old('application_deadline')); ?>" required
                               min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>">
                        <?php $__errorArgs = ['application_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 form-actions">
                    <div>
                        <p class="required-note"><i class="bi bi-asterisk text-danger"></i>Fields marked with * are required.</p>
                    </div>
                    <div class="action-buttons">
                        <a href="<?php echo e(route('employer.dashboard')); ?>" class="btn btn-cancel">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" name="save_as_draft" value="1" class="btn btn-save-draft">
                            <i class="bi bi-file-earmark me-2"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn btn-post-job text-white">
                            <i class="bi bi-check-lg me-2"></i>Post Job
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const minDate = tomorrow.toISOString().split('T')[0];
        document.getElementById('application_deadline').min = minDate;

        const bulletFields = document.querySelectorAll('.bullet-field');
        const bulletPrefix = '\u2022 ';

        const normalizeBullets = (text) => {
            const normalized = text.replace(/\r\n/g, '\n');

            return normalized
                .split('\n')
                .map((line) => {
                    const trimmed = line.trim();

                    if (trimmed === '') {
                        return '';
                    }

                    if (trimmed.startsWith(bulletPrefix)) {
                        return trimmed;
                    }

                    if (trimmed.startsWith('- ') || trimmed.startsWith('* ')) {
                        return bulletPrefix + trimmed.slice(2).trimStart();
                    }

                    return bulletPrefix + trimmed;
                })
                .join('\n');
        };

        const addOpeningBullet = (field) => {
            if (field.value.trim() !== '') {
                return;
            }

            field.value = bulletPrefix;
            field.setSelectionRange(bulletPrefix.length, bulletPrefix.length);
        };

        bulletFields.forEach((field) => {
            if (field.value.trim() !== '') {
                field.value = normalizeBullets(field.value);
            }

            field.addEventListener('focus', () => addOpeningBullet(field));
            field.addEventListener('click', () => addOpeningBullet(field));

            field.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter') {
                    return;
                }

                event.preventDefault();

                const start = field.selectionStart;
                const end = field.selectionEnd;
                const value = field.value;
                const insertion = '\n' + bulletPrefix;

                field.value = value.slice(0, start) + insertion + value.slice(end);
                const newCursor = start + insertion.length;
                field.setSelectionRange(newCursor, newCursor);
            });

            field.addEventListener('paste', (event) => {
                const clipboardText = (event.clipboardData || window.clipboardData)?.getData('text') ?? '';

                if (clipboardText.trim() === '') {
                    return;
                }

                event.preventDefault();

                const start = field.selectionStart;
                const end = field.selectionEnd;
                const value = field.value;

                const isOnlyOpeningBullet = value.trim() === bulletPrefix.trim();
                const before = isOnlyOpeningBullet ? '' : value.slice(0, start);
                const after = isOnlyOpeningBullet ? '' : value.slice(end);
                const pastedBullets = normalizeBullets(clipboardText).trim();

                const needsLeadingBreak = before.length > 0 && !before.endsWith('\n');
                const needsTrailingBreak = after.length > 0 && !after.startsWith('\n');

                const insertion =
                    (needsLeadingBreak ? '\n' : '') +
                    pastedBullets +
                    (needsTrailingBreak ? '\n' : '');

                field.value = before + insertion + after;

                const cursor = before.length + insertion.length;
                field.setSelectionRange(cursor, cursor);
            });

            field.addEventListener('blur', () => {
                if (field.value.trim() === '' || field.value.trim() === bulletPrefix.trim()) {
                    field.value = '';
                    return;
                }

                field.value = normalizeBullets(field.value);
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/employer/post-new-job.blade.php ENDPATH**/ ?>