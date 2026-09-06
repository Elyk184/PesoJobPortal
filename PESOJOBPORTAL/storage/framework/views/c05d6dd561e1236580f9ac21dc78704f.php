<?php $__env->startSection('title', 'OFW | My Profile'); ?>

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
<section aria-label="OFW Profile">
    <div class="dashboard-topbar mb-4">
        <div>
            <div class="dashboard-topbar-title">My Profile</div>
            <div class="dashboard-topbar-subtitle">Personal information used to pre-fill your RFA forms</div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('ofw.profile.update')); ?>">
        <?php echo csrf_field(); ?>

        <div class="vstack gap-3">

            
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-person-circle me-2 text-danger"></i>Personal Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">First Name</label>
                        <input class="form-control" name="first_name" value="<?php echo e(old('first_name', $ofwProfile->first_name)); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Middle Name</label>
                        <input class="form-control" name="middle_name" value="<?php echo e(old('middle_name', $ofwProfile->middle_name)); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Last Name</label>
                        <input class="form-control" name="last_name" value="<?php echo e(old('last_name', $ofwProfile->last_name)); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Suffix</label>
                        <input class="form-control" name="suffix" placeholder="Jr., Sr., II" value="<?php echo e(old('suffix', $ofwProfile->suffix)); ?>">
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" class="form-control" name="birthdate" value="<?php echo e(old('birthdate', $ofwProfile->birthdate?->format('Y-m-d'))); ?>">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Sex</label>
                        <select class="form-select" name="sex">
                            <option value="">— Select —</option>
                            <option value="male" <?php if(old('sex', $ofwProfile->sex) === 'male'): echo 'selected'; endif; ?>>Male</option>
                            <option value="female" <?php if(old('sex', $ofwProfile->sex) === 'female'): echo 'selected'; endif; ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Civil Status</label>
                        <select class="form-select" name="civil_status">
                            <option value="">— Select —</option>
                            <option value="single" <?php if(old('civil_status', $ofwProfile->civil_status) === 'single'): echo 'selected'; endif; ?>>Single</option>
                            <option value="married" <?php if(old('civil_status', $ofwProfile->civil_status) === 'married'): echo 'selected'; endif; ?>>Married</option>
                            <option value="widow" <?php if(old('civil_status', $ofwProfile->civil_status) === 'widow'): echo 'selected'; endif; ?>>Widow/Widower</option>
                            <option value="separated" <?php if(old('civil_status', $ofwProfile->civil_status) === 'separated'): echo 'selected'; endif; ?>>Separated</option>
                            <option value="soloparent" <?php if(old('civil_status', $ofwProfile->civil_status) === 'soloparent'): echo 'selected'; endif; ?>>Solo Parent</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Religion</label>
                        <input class="form-control" name="religion" value="<?php echo e(old('religion', $ofwProfile->religion)); ?>">
                    </div>
                </div>
            </div>

            
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-telephone me-2 text-danger"></i>Contact Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Contact Number</label>
                        <input class="form-control" name="contact_number" value="<?php echo e(old('contact_number', $ofwProfile->contact_number)); ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control" name="email" value="<?php echo e(old('email', $ofwProfile->email)); ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Passport Number</label>
                        <input class="form-control" name="passport_number" value="<?php echo e(old('passport_number', $ofwProfile->passport_number)); ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Facebook Name</label>
                        <input class="form-control" name="facebook_name" value="<?php echo e(old('facebook_name', $ofwProfile->facebook_name)); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address (Philippines)</label>
                        <textarea class="form-control" name="address_philippines" rows="2"><?php echo e(old('address_philippines', $ofwProfile->address_philippines)); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address Abroad</label>
                        <textarea class="form-control" name="address_abroad" rows="2"><?php echo e(old('address_abroad', $ofwProfile->address_abroad)); ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-briefcase me-2 text-danger"></i>Employment Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Employer Name</label>
                        <input class="form-control" name="employer_name" value="<?php echo e(old('employer_name', $ofwProfile->employer_name)); ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Jobsite / Country</label>
                        <input class="form-control" name="jobsite_country" value="<?php echo e(old('jobsite_country', $ofwProfile->jobsite_country)); ?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Monthly Salary</label>
                        <input class="form-control" name="monthly_salary" value="<?php echo e(old('monthly_salary', $ofwProfile->monthly_salary)); ?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Local Recruitment Agency</label>
                        <input class="form-control" name="local_agency" value="<?php echo e(old('local_agency', $ofwProfile->local_agency)); ?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Foreign Recruitment Agency</label>
                        <input class="form-control" name="foreign_agency" value="<?php echo e(old('foreign_agency', $ofwProfile->foreign_agency)); ?>">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end pb-2">
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Save Profile
                </button>
            </div>

        </div>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\profile.blade.php ENDPATH**/ ?>