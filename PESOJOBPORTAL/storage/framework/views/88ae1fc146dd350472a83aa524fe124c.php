<?php $__env->startSection('title', 'OFW Form Submissions | PESO Admin'); ?>

<?php
    $pageTitle = 'OFW Requests';
    $pageSubtitle = 'Review OWWA RFA and DMW RFA PDFs submitted by OFW users';
    $pageIcon = 'bi-file-earmark-pdf';

    $filters = [
        'all'       => 'All Requests',
        'rfa'       => 'OWWA RFA',
        'dmw'       => 'DMW RFA',
        'submitted' => 'Submitted Requests',
        'accepted'  => 'Accepted Requests',
    ];
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <div class="dashboard-card">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterKey => $filterLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.ofw-submissions', ['filter' => $filterKey])); ?>"
                   class="btn btn-sm <?php echo e($filter === $filterKey ? 'btn-primary' : 'btn-outline-primary'); ?>">
                    <?php echo e($filterLabel); ?>

                    <span class="badge <?php echo e($filter === $filterKey ? 'text-bg-light text-primary' : 'text-bg-primary'); ?> ms-1">
                        <?php echo e($ofwStats[$filterKey] ?? 0); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($submissions->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Submitted By</th>
                            <th>Form Type</th>
                            <th>Status</th>
                            <th>File Name</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($submission->user?->name ?? 'Unknown User'); ?></td>
                                <td>
                                    <span class="badge text-bg-primary">
                                        <?php echo e($submission->form_type === 'rfa' ? 'OWWA RFA' : 'DMW RFA'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($submission->status === 'accepted' ? 'text-bg-success' : 'text-bg-warning text-dark'); ?>">
                                        <?php echo e(ucfirst($submission->status ?? 'submitted')); ?>

                                    </span>
                                </td>
                                <td><?php echo e($submission->pdf_filename); ?></td>
                                <td><?php echo e(optional($submission->created_at)->format('M d, Y h:i A')); ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="<?php echo e(route('admin.ofw-submissions.download', $submission)); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>Download PDF
                                        </a>

                                        <?php if($submission->status !== 'accepted'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.ofw-submissions.accept', $submission)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check2-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" action="<?php echo e(route('admin.ofw-submissions.delete', $submission)); ?>"
                                              onsubmit="return confirm('Delete this submission? This cannot be undone.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($submissions->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">No OFW DMW/RFA submissions yet.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/ofw-submissions.blade.php ENDPATH**/ ?>