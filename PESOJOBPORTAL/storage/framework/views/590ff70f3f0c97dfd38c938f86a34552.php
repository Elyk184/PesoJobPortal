<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="<?php echo e(route('jobseeker.dashboard')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('jobseeker.dashboard') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
     <a href="<?php echo e(route('jobseeker.browse-jobs')); ?>"
         class="btn btn-sm <?php echo e(request()->routeIs('jobseeker.browse-jobs') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-briefcase me-1"></i>Vacancies
    </a>
    <a href="<?php echo e(route('jobseeker.applications')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('jobseeker.applications') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-clipboard-check me-1"></i>Applications
    </a>
    <a href="<?php echo e(route('jobseeker.profile')); ?>"
       class="btn btn-sm <?php echo e(request()->routeIs('jobseeker.profile') ? 'btn-danger' : 'btn-outline-danger'); ?>">
        <i class="bi bi-person-lines-fill me-1"></i>Profile
    </a>
</div>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\partials\jobseeker-nav.blade.php ENDPATH**/ ?>