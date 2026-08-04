<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo e($resumeName ?: 'Resume'); ?></title>
    <style>
        @page {
            margin: 40px 44px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            background: #f3f4f6;
        }

        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #111827;
            font-size: 0.98rem;
            line-height: 1.55;
        }

        .resume-page {
            background: #ffffff;
            border: 1px solid #d8dde5;
            padding: 34px 40px;
        }

        .resume-header {
            text-align: center;
            padding-bottom: 14px;
            margin-bottom: 20px;
            border-bottom: 1px solid #111827;
        }

        .resume-name {
            font-size: 2.15rem;
            margin-bottom: 0;
            letter-spacing: 0.02em;
            font-weight: 700;
        }

        .resume-contact {
            font-size: 0.95rem;
            color: #374151;
            margin-top: 6px;
        }

        .resume-section {
            margin-bottom: 20px;
        }

        .resume-section h2 {
            font-size: 1.02rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 9px;
            padding-bottom: 4px;
            border-bottom: 1px solid #111827;
        }

        .resume-section p {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
            margin: 0;
        }

        .resume-item {
            font-size: 0.98rem;
            margin-bottom: 16px;
        }

        .item-header {
            display: table;
            width: 100%;
            table-layout: fixed;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .item-title,
        .item-year {
            display: table-cell;
            vertical-align: top;
        }

        .item-year {
            text-align: right;
            white-space: nowrap;
            padding-left: 12px;
        }

        .item-company {
            font-style: italic;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .item-details {
            margin: 0;
            line-height: 1.5;
        }

        .skills-list {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
            margin-top: 2px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="resume-page">
        <div class="resume-header">
            <h1 class="resume-name"><?php echo e($resumeName); ?></h1>
            <div class="resume-contact"><?php echo e(collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ')); ?></div>
        </div>

        <?php if($resumeObjective): ?>
        <section class="resume-section">
            <h2>Objective</h2>
            <p><?php echo e($resumeObjective); ?></p>
        </section>
        <?php endif; ?>

        <?php if($educationRows && collect($educationRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
        <section class="resume-section">
            <h2>Education</h2>
            <?php $__empty_1 = true; $__currentLoopData = $educationRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if(collect($item)->filter()->isNotEmpty()): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title"><?php echo e($item['school'] ?? ''); ?></div>
                            <div class="item-year"><?php echo e($item['year'] ?? ''); ?></div>
                        </div>
                        <div class="item-company"><?php echo e($item['course'] ?? ''); ?></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if($trainingRows && collect($trainingRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
        <section class="resume-section">
            <h2>Training</h2>
            <?php $__empty_1 = true; $__currentLoopData = $trainingRows ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if(collect($item)->filter()->isNotEmpty()): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title"><?php echo e($item['course'] ?? ''); ?></div>
                            <div class="item-year"><?php echo e($item['dates'] ?? ''); ?></div>
                        </div>
                        <div class="item-company"><?php echo e($item['institution'] ?? ''); ?></div>
                        <p class="item-details"><?php echo e(collect([$item['hours'] ?? '', $item['skills'] ?? '', $item['certificates'] ?? ''])->filter()->join(' | ')); ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if($experienceRows && collect($experienceRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
        <section class="resume-section">
            <h2>Experience</h2>
            <?php $__empty_1 = true; $__currentLoopData = $experienceRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if(collect($item)->filter()->isNotEmpty()): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title"><?php echo e($item['title'] ?? ''); ?></div>
                            <div class="item-year"><?php echo e($item['period'] ?? ''); ?></div>
                        </div>
                        <div class="item-company"><?php echo e($item['company'] ?? ''); ?></div>
                        <p class="item-details"><?php echo e($item['details'] ?? ''); ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if($eligibilityRows && collect($eligibilityRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty()): ?>
        <section class="resume-section">
            <h2>Eligibility</h2>
            <?php $__empty_1 = true; $__currentLoopData = $eligibilityRows ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if(collect($item)->filter()->isNotEmpty()): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title"><?php echo e($item['eligibility'] ?? ''); ?></div>
                            <div class="item-year"><?php echo e($item['valid_until'] ?? ''); ?></div>
                        </div>
                        <div class="item-company"><?php echo e($item['license'] ?? ''); ?></div>
                        <p class="item-details"><?php echo e($item['date_taken'] ?? ''); ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if($skillsPreview->count()): ?>
        <section class="resume-section">
            <h2>Skills</h2>
            <p class="skills-list"><?php echo e($skillsPreview->join(', ')); ?></p>
        </section>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/jobseeker/resume-builder-pdf.blade.php ENDPATH**/ ?>