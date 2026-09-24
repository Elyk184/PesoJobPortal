<?php $__env->startSection('title', 'Association | Submitted Requests'); ?>

<?php $__env->startSection('dashboard-mobile-brand'); ?>
    <div class="dashboard-mobile-brand">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo">
        <span>Association Portal</span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-sidebar'); ?>
    <?php echo $__env->make('dashboard.partials.association-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section aria-label="Submitted requests">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Submitted Requests</div>
                <div class="dashboard-topbar-subtitle">All your association requests and their current status</div>
            </div>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4">
            <?php if($submittedRequests->isEmpty()): ?>
                <p class="text-muted mb-0">No requests submitted yet.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Association</th>
                                <th>Type</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $submittedRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($req->subject); ?></td>
                                    <td><?php echo e($req->association_name); ?></td>
                                    <td><?php echo e($req->request_type); ?></td>
                                    <td><?php echo e($req->contact_person); ?></td>
                                    <td>
                                        <span class="badge text-bg-<?php echo e(match($req->status) { 'submitted' => 'warning', 'accepted' => 'success', 'rejected' => 'danger', 'open' => 'primary', 'under_review' => 'warning', 'resolved' => 'success', default => 'secondary' }); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $req->status))); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($req->created_at->format('M d, Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/association/submitted-requests.blade.php ENDPATH**/ ?>