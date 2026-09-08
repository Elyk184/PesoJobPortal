<?php $__env->startSection('title', 'Our Objectives | Link Job Resource Portal'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/objective-section.css')); ?>?v=<?php echo e(filemtime(public_path('css/objective-section.css'))); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="objective-page" id="objective" aria-label="Link Job Resource Portal Objectives">
    <div class="objective-hero container">
        <h1>Our Objectives</h1>
        <div class="underline" aria-hidden="true"></div>
        <p class="hero-lead">
            PESO Manolo Fortich is committed to building a responsive, inclusive, and opportunities-driven local labor ecosystem.
            These objectives guide our services and partnerships with workers, employers, and institutions.
        </p>
    </div>

    <div class="objective-content container">
        <div class="objectives-grid">
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 1</span>
                <h3>To create job opportunities for the residents of Manolo Fortich, reducing unemployment rates and promoting econimic growth in the municipality.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 2</span>
                <h3>To provide training and skills development programs for job seekers, enhancing their employability and productivity in the workplace.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 3</span>
                <h3>To promote entrepreneurship by providing access to resources, financial assistance, and business development services to aspiring entrepreneurs.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 4</span>
                <h3>To attracts investments in the municipality by showcasing its potential for growth, resources, and business opportunities.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 5</span>
                <h3>To strengthen partnerships with local stakeholders, government agencies, and private sectors in the implementation of the PESO program, fostering collaboration and innovation in promoting economic development.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</section>

<?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\objective.blade.php ENDPATH**/ ?>