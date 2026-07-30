<?php $__env->startSection('title', 'Resume Builder | Jobseeker'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $profile = $profile ?? null;
    $resumeName = old('name', $resumeName ?? ($profile->resume_name ?? ''));
    $resumeEmail = old('email', $resumeEmail ?? ($profile->resume_email ?? ''));
    $resumePhone = old('phone', $resumePhone ?? ($profile->phone ?? ''));
    $resumeAddress = old('address', $resumeAddress ?? ($profile->address ?? ''));
    $resumeObjective = old('objective', $resumeObjective ?? ($profile->objective ?? ''));
    $resumeSkills = old('skills', $resumeSkills ?? implode(', ', $profile->skills ?? []));

    $educationRows = old('education', $educationRows ?? ($profile->education ?? []));
    $trainingRows = old('training', $trainingRows ?? ($profile->training ?? []));
    $experienceRows = old('experience', $experienceRows ?? ($profile->experience ?? []));
    $eligibilityRows = old('eligibility', $eligibilityRows ?? ($profile->eligibility ?? []));

    $skillsPreview = collect(explode(',', $resumeSkills))->map(fn ($item) => trim($item))->filter()->values();
?>

<section aria-label="Resume builder">
    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Please fix the highlighted problems.</div>
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Build a clean, Harvard-style resume</h2>
                <p class="mb-0 text-muted">Your profile data now fills this draft automatically, and everything below is still editable.</p>
            </div>
            <div class="text-lg-end">
                <div class="fw-semibold text-secondary"><?php echo e($resumeName ?: 'Resume draft'); ?></div>
                <div class="small text-muted">Saved to your jobseeker profile</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-5">
            <form method="POST" action="<?php echo e(route('jobseeker.resume-builder.save')); ?>" class="dashboard-section-card p-3 p-lg-4 h-100">
                <?php echo csrf_field(); ?>

                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Resume Details</h3>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="name">Full name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo e($resumeName); ?>" placeholder="Enter your full name">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo e($resumeEmail); ?>" placeholder="Enter your email">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo e($resumePhone); ?>" placeholder="Enter your phone number">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter your address"><?php echo e($resumeAddress); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="objective">Career objective</label>
                        <textarea name="objective" id="objective" class="form-control" rows="4" placeholder="Write a short professional objective"><?php echo e($resumeObjective); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="skills">Skills</label>
                        <textarea name="skills" id="skills" class="form-control" rows="3" placeholder="Separate with commas or line breaks"><?php echo e($resumeSkills); ?></textarea>
                        <div class="form-text">Example: Communication, Microsoft Office, Customer Service</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Education</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="education">
                            <i class="bi bi-plus-lg me-1"></i>Add Education
                        </button>
                    </div>

                    <div class="vstack gap-3" id="education-rows">
                        <?php $__empty_1 = true; $__currentLoopData = $educationRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="education">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Education <?php echo e($index + 1); ?></div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="education[<?php echo e($index); ?>][school]" class="form-control" placeholder="School / University" value="<?php echo e($row['school'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="education[<?php echo e($index); ?>][course]" class="form-control" placeholder="Course / Strand" value="<?php echo e($row['course'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="education[<?php echo e($index); ?>][year]" class="form-control" placeholder="Year" value="<?php echo e($row['year'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Experience</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="experience">
                            <i class="bi bi-plus-lg me-1"></i>Add Experience
                        </button>
                    </div>

                    <div class="vstack gap-3" id="experience-rows">
                        <?php $__empty_1 = true; $__currentLoopData = $experienceRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="experience">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Experience <?php echo e($index + 1); ?></div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="experience[<?php echo e($index); ?>][title]" class="form-control" placeholder="Job title" value="<?php echo e($row['title'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="experience[<?php echo e($index); ?>][company]" class="form-control" placeholder="Company / Organization" value="<?php echo e($row['company'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="experience[<?php echo e($index); ?>][period]" class="form-control" placeholder="Year / Period" value="<?php echo e($row['period'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="experience[<?php echo e($index); ?>][details]" class="form-control" rows="3" placeholder="Short job description"><?php echo e($row['details'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Training</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="training">
                            <i class="bi bi-plus-lg me-1"></i>Add Training
                        </button>
                    </div>

                    <div class="vstack gap-3" id="training-rows">
                        <?php $__empty_1 = true; $__currentLoopData = $trainingRows ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="training">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Training <?php echo e($index + 1); ?></div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][course]" class="form-control" placeholder="Course / Training name" value="<?php echo e($row['course'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][institution]" class="form-control" placeholder="Institution / Provider" value="<?php echo e($row['institution'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][dates]" class="form-control" placeholder="Dates" value="<?php echo e($row['dates'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][hours]" class="form-control" placeholder="Hours" value="<?php echo e($row['hours'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][skills]" class="form-control" placeholder="Skills learned" value="<?php echo e($row['skills'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[<?php echo e($index); ?>][certificates]" class="form-control" placeholder="Certificates" value="<?php echo e($row['certificates'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Eligibility</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="eligibility">
                            <i class="bi bi-plus-lg me-1"></i>Add Eligibility
                        </button>
                    </div>

                    <div class="vstack gap-3" id="eligibility-rows">
                        <?php $__empty_1 = true; $__currentLoopData = $eligibilityRows ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="eligibility">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Eligibility <?php echo e($index + 1); ?></div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="eligibility[<?php echo e($index); ?>][eligibility]" class="form-control" placeholder="Eligibility / Exam" value="<?php echo e($row['eligibility'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[<?php echo e($index); ?>][license]" class="form-control" placeholder="License / Certificate No." value="<?php echo e($row['license'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[<?php echo e($index); ?>][date_taken]" class="form-control" placeholder="Date Taken" value="<?php echo e($row['date_taken'] ?? ''); ?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[<?php echo e($index); ?>][valid_until]" class="form-control" placeholder="Valid Until" value="<?php echo e($row['valid_until'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-save me-2"></i>Save Resume
                    </button>
                    <button type="submit" form="reset-resume-form" class="btn btn-outline-danger flex-fill">
                        <i class="bi bi-trash3 me-2"></i>Reset Resume
                    </button>
                </div>
            </form>
        </div>

        <div class="col-12 col-xl-7">
            <div class="dashboard-section-card p-3 p-lg-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Live Preview</h3>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('jobseeker.resume-builder.export')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Export PDF
                        </a>
                    </div>
                </div>

                <div class="resume-preview mx-auto">
                    <div class="resume-header text-center pb-3 mb-4 border-bottom">
                        <h1 class="resume-name"><?php echo e($resumeName); ?></h1>
                        <div class="resume-contact"><?php echo e(collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ')); ?></div>
                    </div>

                    <?php if($resumeObjective): ?>
                    <section class="resume-section mb-4">
                        <h2>Objective</h2>
                        <p><?php echo e($resumeObjective); ?></p>
                    </section>
                    <?php endif; ?>

                    <?php if($educationRows && collect($educationRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
                    <section class="resume-section mb-4">
                        <h2>Education</h2>
                        <?php $__empty_1 = true; $__currentLoopData = $educationRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if(collect($item)->filter()->isNotEmpty()): ?>
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold"><?php echo e($item['school'] ?? ''); ?></div>
                                        <div class="text-muted"><?php echo e($item['year'] ?? ''); ?></div>
                                    </div>
                                    <div class="fst-italic text-muted"><?php echo e($item['course'] ?? ''); ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </section>
                    <?php endif; ?>

                    <?php if($trainingRows && collect($trainingRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
                    <section class="resume-section mb-4">
                        <h2>Training</h2>
                        <?php $__empty_1 = true; $__currentLoopData = $trainingRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if(collect($item)->filter()->isNotEmpty()): ?>
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold"><?php echo e($item['course'] ?? ''); ?></div>
                                        <div class="text-muted"><?php echo e($item['dates'] ?? ''); ?></div>
                                    </div>
                                    <div class="fst-italic text-muted"><?php echo e($item['institution'] ?? ''); ?></div>
                                    <p class="mb-0"><?php echo e(collect([$item['hours'] ?? '', $item['skills'] ?? '', $item['certificates'] ?? ''])->filter()->join(' | ')); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </section>
                    <?php endif; ?>

                    <?php if($experienceRows && collect($experienceRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
                    <section class="resume-section mb-4">
                        <h2>Experience</h2>
                        <?php $__empty_1 = true; $__currentLoopData = $experienceRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if(collect($item)->filter()->isNotEmpty()): ?>
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold"><?php echo e($item['title'] ?? ''); ?></div>
                                        <div class="text-muted"><?php echo e($item['period'] ?? ''); ?></div>
                                    </div>
                                    <div class="fst-italic text-muted"><?php echo e($item['company'] ?? ''); ?></div>
                                    <p class="mb-0"><?php echo e($item['details'] ?? ''); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </section>
                    <?php endif; ?>

                    <?php if($eligibilityRows && collect($eligibilityRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
                    <section class="resume-section mb-4">
                        <h2>Eligibility</h2>
                        <?php $__empty_1 = true; $__currentLoopData = $eligibilityRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if(collect($item)->filter()->isNotEmpty()): ?>
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold"><?php echo e($item['eligibility'] ?? ''); ?></div>
                                        <div class="text-muted"><?php echo e($item['valid_until'] ?? ''); ?></div>
                                    </div>
                                    <div class="fst-italic text-muted"><?php echo e($item['license'] ?? ''); ?></div>
                                    <p class="mb-0"><?php echo e($item['date_taken'] ?? ''); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </section>
                    <?php endif; ?>

                    <?php if($skillsPreview->count()): ?>
                    <section class="resume-section mb-0">
                        <h2>Skills</h2>
                        <p class="mb-0"><?php echo e($skillsPreview->join(', ')); ?></p>
                    </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<form id="reset-resume-form" method="POST" action="<?php echo e(route('jobseeker.resume-builder.reset')); ?>" class="d-none">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<template id="education-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="education">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Education</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="School / University"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Course / Strand"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Year"></div>
        </div>
    </div>
</template>

<template id="experience-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="experience">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Experience</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Job title"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Company / Organization"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Year / Period"></div>
            <div class="col-12"><textarea class="form-control" rows="3" name="__NAME__" placeholder="Short job description"></textarea></div>
        </div>
    </div>
</template>

<template id="training-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="training">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Training</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Course / Training name"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Institution / Provider"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Dates"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Hours"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Skills learned"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Certificates"></div>
        </div>
    </div>
</template>

<template id="eligibility-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="eligibility">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Eligibility</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Eligibility / Exam"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="License / Certificate No."></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Date Taken"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Valid Until"></div>
        </div>
    </div>
</template>

<?php $__env->startPush('styles'); ?>
    <style>
        .resume-preview {
            max-width: 820px;
            background: #fff;
            border: 1px solid #d8dde5;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            padding: 36px 42px;
            color: #111827;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .resume-name {
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            margin: 0;
            letter-spacing: 0.02em;
            font-weight: 700;
        }

        .resume-contact {
            font-size: 0.95rem;
            color: #374151;
            margin-top: 8px;
        }

        .resume-section h2 {
            font-size: 1.02rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #111827;
        }

        .resume-section p,
        .resume-section li {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
        }

        .resume-item {
            font-size: 0.98rem;
        }

        @media (max-width: 575.98px) {
            .resume-preview {
                padding: 24px 18px;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function () {
            let educationCount = document.querySelectorAll('[data-row="education"]').length;
            let experienceCount = document.querySelectorAll('[data-row="experience"]').length;
            let trainingCount = document.querySelectorAll('[data-row="training"]').length;
            let eligibilityCount = document.querySelectorAll('[data-row="eligibility"]').length;

            function addRow(type) {
                const template = document.getElementById(type + '-template');
                const container = document.getElementById(type + '-rows');
                if (!template || !container) return;

                const clone = template.content.cloneNode(true);
                const row = clone.querySelector('[data-row="' + type + '"]');
                const fields = row.querySelectorAll('input, textarea');
                let rowIndex, names;

                if (type === 'education') {
                    rowIndex = educationCount++;
                    names = ['education[' + rowIndex + '][school]', 'education[' + rowIndex + '][course]', 'education[' + rowIndex + '][year]'];
                } else if (type === 'experience') {
                    rowIndex = experienceCount++;
                    names = ['experience[' + rowIndex + '][title]', 'experience[' + rowIndex + '][company]', 'experience[' + rowIndex + '][period]', 'experience[' + rowIndex + '][details]'];
                } else if (type === 'training') {
                    rowIndex = trainingCount++;
                    names = ['training[' + rowIndex + '][course]', 'training[' + rowIndex + '][institution]', 'training[' + rowIndex + '][dates]', 'training[' + rowIndex + '][hours]', 'training[' + rowIndex + '][skills]', 'training[' + rowIndex + '][certificates]'];
                } else if (type === 'eligibility') {
                    rowIndex = eligibilityCount++;
                    names = ['eligibility[' + rowIndex + '][eligibility]', 'eligibility[' + rowIndex + '][license]', 'eligibility[' + rowIndex + '][date_taken]', 'eligibility[' + rowIndex + '][valid_until]'];
                }

                fields.forEach(function (field, index) {
                    field.name = names[index];
                });

                container.appendChild(clone);
            }

            document.querySelectorAll('[data-add-row]').forEach(function (button) {
                button.addEventListener('click', function () {
                    addRow(button.getAttribute('data-add-row'));
                });
            });

            document.addEventListener('click', function (event) {
                if (event.target && event.target.matches('[data-remove-row]')) {
                    const row = event.target.closest('[data-row]');
                    if (row) {
                        row.remove();
                    }
                }
            });
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/resume-builder.blade.php ENDPATH**/ ?>