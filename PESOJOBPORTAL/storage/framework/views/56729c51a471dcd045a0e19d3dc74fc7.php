<?php $__env->startSection('title', 'Associations | PESO Admin'); ?>

<?php
    $pageTitle = 'Associations';
    $pageSubtitle = 'Review worker association registration requests';
    $pageIcon = 'bi-people-fill';

    $filters = [
        'all'       => 'All Requests',
        'submitted' => 'Submitted Requests',
        'accepted'  => 'Accepted Requests',
        'rejected'  => 'Rejected Requests',
    ];
?>

<?php $__env->startSection('content'); ?>
<style>
    .assoc-action-btn {
        padding: 0.15rem 0.45rem;
        font-size: 0.72rem;
    }
    .assoc-action-btn i { font-size: 0.78rem; }
</style>
<div class="admin-dashboard">
    <div class="dashboard-card">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterKey => $filterLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.associations', ['filter' => $filterKey])); ?>"
                   class="btn btn-sm <?php echo e($filter === $filterKey ? 'btn-primary' : 'btn-outline-primary'); ?>">
                    <?php echo e($filterLabel); ?>

                    <span class="badge <?php echo e($filter === $filterKey ? 'text-bg-light text-primary' : 'text-bg-primary'); ?> ms-1">
                        <?php echo e($stats[$filterKey] ?? 0); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($requests->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Submitted By</th>
                            <th>Association Name</th>
                            <th>Contact Person</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($req->user?->name ?? 'Unknown User'); ?></td>
                                <td><?php echo e($req->association_name); ?></td>
                                <td><?php echo e($req->contact_person); ?></td>
                                <td>
                                    <span class="badge <?php echo e($req->status === 'accepted' ? 'text-bg-success' : ($req->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning text-dark')); ?>">
                                        <?php echo e(ucfirst($req->status ?? 'submitted')); ?>

                                    </span>
                                </td>
                                <td><?php echo e(optional($req->created_at)->format('M d, Y h:i A')); ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="<?php echo e(route('admin.associations.download', $req)); ?>" target="_blank"
                                           class="btn btn-sm btn-outline-primary assoc-action-btn">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>Download PDF
                                        </a>

                                        <?php if($req->status !== 'accepted' && $req->status !== 'rejected'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.associations.accept', $req)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success assoc-action-btn">
                                                    <i class="bi bi-check2-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if($req->status !== 'rejected' && $req->status !== 'accepted'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.associations.reject', $req)); ?>"
                                                  onsubmit="return confirm('Reject this association request?');">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger assoc-action-btn">
                                                    <i class="bi bi-x-circle me-1"></i>Reject
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if($req->status === 'accepted' || $req->status === 'rejected'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.associations.undo', $req)); ?>"
                                                  onsubmit="return confirm('Undo this action and revert to submitted?');">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary assoc-action-btn">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Undo
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" action="<?php echo e(route('admin.associations.delete', $req)); ?>"
                                              onsubmit="return confirm('Delete this association request? This cannot be undone.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger assoc-action-btn">
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
                <?php echo e($requests->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">No association registration requests yet.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/associations.blade.php ENDPATH**/ ?>