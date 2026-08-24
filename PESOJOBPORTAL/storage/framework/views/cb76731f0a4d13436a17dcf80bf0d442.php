<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="<?php echo e(route('ofw.dashboard')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('ofw.dashboard') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
    <a href="<?php echo e(route('ofw.dmw-builder')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('ofw.dmw-builder') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-journal-text me-1"></i>DMW RFA
    </a>
    <a href="<?php echo e(route('ofw.rfa.form')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('ofw.rfa.form') || request()->routeIs('ofw.owwa-request') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-file-earmark-text me-1"></i>OWWA RFA
    </a>
    <a href="<?php echo e(route('ofw.accepted-requests')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('ofw.accepted-requests') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-check2-circle me-1"></i>Accepted Requests
    </a>
    <a href="<?php echo e(route('ofw.submitted-requests')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('ofw.submitted-requests') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-list-check me-1"></i>Submitted Requests
    </a>
</div>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/partials/ofw-nav.blade.php ENDPATH**/ ?>