<?php $__env->startSection('title', 'Accepted Requests'); ?>

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
    <h1 class="h4 fw-bold mb-2">Accepted Requests</h1>
    <p class="text-muted mb-4">Your OWWA RFA and DMW RFA PDFs accepted by admin are listed below.</p>

    <?php if($acceptedRequests->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Form Type</th>
                        <th>File Name</th>
                        <th>Accepted At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $acceptedRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="badge text-bg-success">
                                    <?php echo e($submission->form_type === 'rfa' ? 'OWWA RFA' : 'DMW RFA'); ?>

                                </span>
                            </td>
                            <td><?php echo e($submission->pdf_filename); ?></td>
                            <td><?php echo e(optional($submission->accepted_at)->format('M d, Y h:i A')); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('ofw.submitted-requests.download', $submission)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Download PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($acceptedRequests->links('pagination::bootstrap-5')); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-info mb-0">You have no accepted OFW requests yet.</div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\accepted-requests.blade.php ENDPATH**/ ?>