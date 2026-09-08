<?php $__env->startSection('title', 'Request for Assistance (RFA) Form - DMW'); ?>

<?php $__env->startSection('dashboard-mobile-brand'); ?>
    <div class="dashboard-mobile-brand">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-sidebar'); ?>
    <?php echo $__env->make('dashboard.partials.ofw-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dmw-shell {
        background: linear-gradient(180deg, #dbe7f5 0%, #c9d8ea 100%);
        border-radius: 18px;
        padding: 16px;
    }

    .dmw-panel {
        background: #fff;
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(16, 42, 76, 0.12);
        overflow: hidden;
    }

    .dmw-hero {
        background: linear-gradient(135deg, #123355, #1f4b8f);
        color: #fff;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dmw-hero h1 {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .dmw-hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.82);
    }

    .dmw-body {
        padding: 22px 24px 24px;
        color: #314458;
    }

    .dmw-section {
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        padding: 18px;
        background: #f9fbfe;
        margin-bottom: 18px;
    }

    .dmw-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--dash-border);
    }

    .dmw-section-title h2 {
        font-size: 1.02rem;
        font-weight: 800;
        margin: 0;
    }

    .dmw-section-title span {
        color: var(--dash-muted);
        font-size: 0.82rem;
    }

    .dmw-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .dmw-grid.three {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .dmw-field label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: #23374f;
    }

    .dmw-field input[type="text"],
    .dmw-field input[type="date"],
    .dmw-field textarea,
    .dmw-field input[type="file"] {
        width: 100%;
        border: 1px solid #c9d4e2;
        border-radius: 12px;
        padding: 12px 14px;
        font: inherit;
        background: #fff;
        color: #24364b;
    }

    .dmw-field textarea {
        min-height: 140px;
        resize: vertical;
    }

    .dmw-options {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 14px;
    }

    .dmw-option {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 12px 14px;
        border: 1px solid #d9e3ef;
        border-radius: 12px;
        background: #fff;
    }

    .dmw-option input {
        margin-top: 3px;
    }

    .dmw-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .dmw-note {
        border-left: 4px solid #2d65b1;
        background: #eef5ff;
        color: #27415f;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 0.95rem;
    }

    @media (max-width: 991.98px) {
        .dmw-grid,
        .dmw-grid.three,
        .dmw-options {
            grid-template-columns: 1fr;
        }

        .dmw-body {
            padding: 18px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dmw-shell">
    <div class="dmw-panel">
        <div class="dmw-hero">
            <div>
                <h1>Request for Assistance (RFA) Form - DMW</h1>
                <p>Submit DMW-related request details and upload supporting files from the OFW portal.</p>
            </div>
            <span class="badge rounded-pill text-bg-warning text-dark">DMW Form</span>
        </div>

        <div class="dmw-body">
            <form method="POST" action="<?php echo e(route('ofw.dmw-download')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="signature_date" value="<?php echo e(now()->toDateString()); ?>">

                <div class="dmw-section">
                    <div class="dmw-section-title">
                        <h2>A. Basic OFW Information</h2>
                        <span>Primary details</span>
                    </div>

                    <div class="dmw-grid three">
                        <div class="dmw-field">
                            <label>First Name</label>
                            <input type="text" name="ofw_firstname" value="<?php echo e(old('ofw_firstname')); ?>">
                        </div>
                        <div class="dmw-field">
                            <label>Middle Name</label>
                            <input type="text" name="ofw_middlename" value="<?php echo e(old('ofw_middlename')); ?>">
                        </div>
                        <div class="dmw-field">
                            <label>Last Name</label>
                            <input type="text" name="ofw_lastname" value="<?php echo e(old('ofw_lastname')); ?>">
                        </div>
                    </div>

                    <div class="dmw-grid" style="margin-top:14px;">
                        <div class="dmw-field">
                            <label>Birthdate</label>
                            <input type="date" name="ofw_birthdate" value="<?php echo e(old('ofw_birthdate')); ?>">
                        </div>
                        <div class="dmw-field">
                            <label>Contact No.</label>
                            <input type="text" name="ofw_contact" value="<?php echo e(old('ofw_contact')); ?>">
                        </div>
                    </div>

                    <div class="dmw-grid" style="margin-top:14px;">
                        <div class="dmw-field">
                            <label>Address in the Philippines</label>
                            <input type="text" name="ofw_address_ph" value="<?php echo e(old('ofw_address_ph')); ?>">
                        </div>
                        <div class="dmw-field">
                            <label>Address Abroad</label>
                            <input type="text" name="ofw_address_abroad" value="<?php echo e(old('ofw_address_abroad')); ?>">
                        </div>
                    </div>
                </div>

                <div class="dmw-section">
                    <div class="dmw-section-title">
                        <h2>B. Nature of Request</h2>
                        <span>Select one or more</span>
                    </div>

                    <div class="dmw-options">
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="legal"> <span>Legal Assistance</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="medical"> <span>Medical Assistance</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="repatriation"> <span>Repatriation</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="rescue"> <span>Rescue / Evacuation</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="welfare"> <span>Welfare Assistance for Senior OFW Returnees</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="shipment"> <span>Shipment of Human Remains / Cremains</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="food"> <span>Food Assistance</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="transportation"> <span>Transportation Assistance</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="shelter"> <span>Temporary Shelter</span></label>
                        <label class="dmw-option"><input type="checkbox" name="assistance[]" value="others"> <span>Others: <input type="text" name="assistance_others" placeholder="Please specify" style="margin-top:8px;"></span></label>
                    </div>
                </div>

                <div class="dmw-section">
                    <div class="dmw-section-title">
                        <h2>C. Narrative</h2>
                        <span>Brief explanation of the request</span>
                    </div>

                    <div class="dmw-field">
                        <label>Facts of the Case</label>
                        <textarea name="facts_of_case" placeholder="Isalaysay ang inyong request..."><?php echo e(old('facts_of_case')); ?></textarea>
                    </div>
                </div>

                <div class="dmw-section">
                    <div class="dmw-section-title">
                        <h2>D. Attachments</h2>
                        <span>Upload supporting files</span>
                    </div>

                    <div class="dmw-grid">
                        <div class="dmw-field">
                            <label>Employment Contract</label>
                            <input type="file" name="contract_attachment" accept=".pdf,image/*">
                        </div>
                        <div class="dmw-field">
                            <label>Passport / Travel Document</label>
                            <input type="file" name="passport_attachment" accept=".pdf,image/*">
                        </div>
                    </div>

                    <div class="dmw-note mt-3">
                        The DMW download action is connected to the OFW portal. Once ready, this form can generate your PDF copy.
                    </div>
                </div>

                <div class="dmw-actions">
                    <a href="<?php echo e(route('ofw.dashboard')); ?>" class="btn btn-outline-secondary px-4">Back to Dashboard</a>
                    <button type="submit" class="btn btn-danger px-4 shadow-sm">
                        <i class="bi bi-download me-2"></i>Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\dmw-simple.blade.php ENDPATH**/ ?>