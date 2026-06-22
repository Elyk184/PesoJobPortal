<?php $__env->startSection('title', 'Edit Job - PESO'); ?>
<?php $__env->startSection('hide_header', true); ?>

<?php $__env->startSection('content'); ?>
<style>
    .edit-job-shell {
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
        margin-bottom: 1.25rem;
    }

    .hero-title {
        font-size: 1.55rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
    }

    .hero-subtitle {
        margin: 0;
        color: rgba(255,255,255,0.9);
    }

    .job-form-card {
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        border: 1px solid #edf1f8;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
        padding: 2rem;
    }

    .section-divider {
        border-top: 1px dashed #dfe5f1;
        margin: 2rem 0;
    }

    .form-block {
        border: 1px solid #e4ebf7;
        border-radius: 14px;
        padding: 1.25rem;
        background: linear-gradient(180deg, #f9fbff 0%, #f5f8ff 100%);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.92rem;
    }

    .form-control, .form-select {
        border: 1px solid #d6dbe7;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        background: #fff;
        font-size: 0.93rem;
        color: #1e293b;
    }

    textarea.form-control {
        min-height: 120px;
        line-height: 1.45;
    }

    .btn-post-job {
        background: linear-gradient(135deg, #11468f 0%, #1c78d1 100%);
        border: 1px solid #0f3f80;
        color: #fff;
        padding: 0.875rem 2rem;
        font-weight: 700;
        border-radius: 12px;
        letter-spacing: 0.01em;
    }

    .btn-save-draft {
        background: linear-gradient(135deg, #334155 0%, #1f2937 100%);
        border: 1px solid #1f2937;
        color: white;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1px solid #f4b8c0;
        color: #9f1239;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-row {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        margin-top: 1.25rem;
    }

    .text-muted { color: #64748b !important; font-size: 0.82rem; font-weight: 500; }
</style>

<div class="edit-job-shell">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="composer-hero mb-4">
                <h2 class="hero-title">Edit Job Posting</h2>
                <p class="hero-subtitle">Update the details of your job listing.</p>
            </div>

            <div class="job-form-card">
                <form action="<?php echo e(route('employer.jobs.update', $job)); ?>" method="POST" id="jobPostForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="form-block mb-4">
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title" value="<?php echo e(old('title', $job->title)); ?>" required>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="6" required><?php echo e(old('description', $job->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="location" name="location" value="<?php echo e(old('location', $job->location)); ?>" required>
                                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="employment_type" name="employment_type" required>
                                    <option value="">Select employment type</option>
                                    <?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php echo e(old('employment_type', $job->job_type) === $value ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
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
unset($__errorArgs, $__bag); ?>" id="vacancies" name="vacancies" value="<?php echo e(old('vacancies', $job->vacancies)); ?>" required min="1" max="999">
                            <?php $__errorArgs = ['vacancies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <div class="form-block mb-4">
                        <div class="mb-3">
                            <label for="key_responsibilities" class="form-label">Responsibilities</label>
                            <textarea class="form-control <?php $__errorArgs = ['key_responsibilities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="key_responsibilities" name="key_responsibilities" rows="5"><?php echo e(old('key_responsibilities', $job->key_responsibilities)); ?></textarea>
                            <?php $__errorArgs = ['key_responsibilities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications</label>
                            <textarea class="form-control <?php $__errorArgs = ['qualifications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="qualifications" name="qualifications" rows="5"><?php echo e(old('qualifications', $job->qualifications)); ?></textarea>
                            <?php $__errorArgs = ['qualifications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="preferred_skills" class="form-label">Required Skills</label>
                            <textarea class="form-control <?php $__errorArgs = ['preferred_skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="preferred_skills" name="preferred_skills" rows="4"><?php echo e(old('preferred_skills', $job->preferred_skills)); ?></textarea>
                            <?php $__errorArgs = ['preferred_skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label">Experience</label>
                            <textarea class="form-control <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="experience" name="experience" rows="4"><?php echo e(old('experience', $job->experience)); ?></textarea>
                            <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">Education</label>
                            <textarea class="form-control <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="education" name="education" rows="4"><?php echo e(old('education', $job->education)); ?></textarea>
                            <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="benefits" class="form-label">Benefits</label>
                            <textarea class="form-control <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="benefits" name="benefits" rows="4"><?php echo e(old('benefits', $job->benefits)); ?></textarea>
                            <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <div class="form-block mb-4">
                        <div class="mb-3">
                            <label class="form-label">Salary Range (PHP)</label>
                            <?php
                                $salaryText = old('salary_range', $job->salary_range ?? $job->salary ?? '');
                                $salaryMin = old('salary_min');
                                $salaryMax = old('salary_max');
                                if ($salaryMin === null || $salaryMax === null) {
                                    $min = null; $max = null;
                                    if (is_string($salaryText) && str_contains($salaryText, '-')) {
                                        [$a, $b] = array_map('trim', explode('-', $salaryText, 2));
                                        $min = is_numeric($a) ? (float)$a : null;
                                        $max = is_numeric($b) ? (float)$b : null;
                                    }
                                    $salaryMin = $salaryMin ?? ($min !== null ? $min : '');
                                    $salaryMax = $salaryMax ?? ($max !== null ? $max : '');
                                }
                            ?>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" class="form-control <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="salary_min" name="salary_min" placeholder="Min" value="<?php echo e($salaryMin); ?>" min="0" step="1000">
                                    <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="salary_max" name="salary_max" placeholder="Max" value="<?php echo e($salaryMax); ?>" min="0" step="1000">
                                    <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="application_deadline" class="form-label">Last Date to Apply</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['application_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="application_deadline" name="application_deadline" value="<?php echo e(old('application_deadline', $job->application_end_date)); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>">
                            <?php $__errorArgs = ['application_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Fields marked with * are required.</p>
                    </div>

                    <div class="btn-row">
                        <a href="<?php echo e(route('employer.jobs.manage', ['status' => $job->status === 'closed' ? 'archived' : $job->status])); ?>" class="btn-cancel">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" name="save_as_draft" value="1" class="btn-save-draft">
                            <i class="bi bi-file-earmark me-2"></i>Save as Draft
                        </button>
                        <button type="submit" class="btn-post-job">
                            <i class="bi bi-check-lg me-2"></i>Update Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('dashboard.employer.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/employer/edit-job.blade.php ENDPATH**/ ?>