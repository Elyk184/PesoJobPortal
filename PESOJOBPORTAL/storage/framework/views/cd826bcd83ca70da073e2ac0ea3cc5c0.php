<?php $__env->startSection('title', $pageTitle); ?>

<?php $__env->startSection('dashboard-mobile-brand'); ?>
    <div class="dashboard-mobile-brand">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-sidebar'); ?>
    <?php echo $__env->make('dashboard.partials.ofw-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="dashboard-section-card p-4">
        <h1 class="h4 fw-bold mb-2"><?php echo e($heading); ?></h1>
        <p class="text-muted mb-4"><?php echo e($message); ?></p>
        <a class="btn btn-outline-primary" href="<?php echo e(route('ofw.dashboard')); ?>">Back to Dashboard</a>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\placeholder.blade.php ENDPATH**/ ?>