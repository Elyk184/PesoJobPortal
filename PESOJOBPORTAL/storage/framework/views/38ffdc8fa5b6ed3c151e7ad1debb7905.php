<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OWWA RFA Form</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1, h2, h3, p { margin: 0 0 8px; }
        .header { text-align: center; margin-bottom: 12px; }
        .section { border: 1px solid #111; padding: 10px; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .row { margin-bottom: 6px; }
        .small { font-size: 9px; color: #444; }
        ul { margin: 4px 0 0 18px; padding: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>OVERSEAS WORKERS WELFARE ADMINISTRATION</h2>
        <h3>REQUEST FOR ASSISTANCE FORM</h3>
        <p class="small">Generated <?php echo e($generated_at->format('Y-m-d H:i')); ?></p>
    </div>

    <div class="section">
        <div class="row"><span class="label">E-Cares Ticket Number:</span> <?php echo e($e_cares_ticket_number ?? ''); ?></div>
        <div class="row"><span class="label">Date:</span> <?php echo e($date ?? ''); ?></div>
        <div class="row">
            <span class="label">Nature of Case / Request:</span>
            <?php if(!empty($case_labels)): ?>
                <ul>
                    <?php $__currentLoopData = $case_labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caseLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($caseLabel); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <span>None</span>
            <?php endif; ?>
        </div>
        <?php if(!empty($nature_of_case_other)): ?>
            <div class="row"><span class="label">Others:</span> <?php echo e($nature_of_case_other); ?></div>
        <?php endif; ?>
    </div>

    <div class="section">
        <div class="row"><span class="label">OFW Name:</span> <?php echo e(trim(($ofw_first ?? '') . ' ' . ($ofw_middle ?? '') . ' ' . ($ofw_last ?? ''))); ?></div>
        <div class="row"><span class="label">Contact No.:</span> <?php echo e($contact_no ?? ''); ?></div>
        <div class="row"><span class="label">Position:</span> <?php echo e($position ?? ''); ?></div>
        <div class="row"><span class="label">Sex:</span> <?php echo e($sex ?? ''); ?></div>
        <div class="row"><span class="label">Birthdate:</span> <?php echo e($birthdate ?? ''); ?></div>
        <div class="row"><span class="label">Age:</span> <?php echo e($age ?? ''); ?></div>
        <div class="row"><span class="label">Civil Status:</span> <?php echo e($civil_status ?? ''); ?></div>
        <div class="row"><span class="label">Facebook Name:</span> <?php echo e($facebook_name ?? ''); ?></div>
        <div class="row"><span class="label">Highest Educational Attainment:</span> <?php echo e($highest_education ?? ''); ?></div>
        <div class="row"><span class="label">Religion:</span> <?php echo e($religion ?? ''); ?></div>
        <div class="row"><span class="label">No. of Children:</span> <?php echo e($children_count ?? ''); ?></div>
        <div class="row"><span class="label">Name of Employer:</span> <?php echo e($employer_name ?? ''); ?></div>
        <div class="row"><span class="label">Jobsite:</span> <?php echo e($jobsite ?? ''); ?></div>
        <div class="row"><span class="label">Tel. No. / Fax No.:</span> <?php echo e($tel_fax ?? ''); ?></div>
        <div class="row"><span class="label">Monthly Salary:</span> <?php echo e($monthly_salary ?? ''); ?></div>
        <div class="row"><span class="label">Foreign Recruitment Agency:</span> <?php echo e($foreign_recruitment_agency ?? ''); ?></div>
        <div class="row"><span class="label">Agency Address / Tel.:</span> <?php echo e($agency_address_tel ?? ''); ?></div>
        <div class="row"><span class="label">Local Agency:</span> <?php echo e($local_agency ?? ''); ?></div>
        <div class="row"><span class="label">Latest Departure From the Philippines:</span> <?php echo e($latest_departure ?? ''); ?></div>
        <div class="row"><span class="label">Previous Employment Country:</span> <?php echo e($previous_employment_country ?? ''); ?></div>
        <div class="row"><span class="label">Death Date:</span> <?php echo e($death_date ?? ''); ?></div>
        <div class="row"><span class="label">Cause of Death:</span> <?php echo e($death_cause ?? ''); ?></div>
        <div class="row"><span class="label">Place of Death:</span> <?php echo e($death_place ?? ''); ?></div>
        <div class="row"><span class="label">Facts of the Case:</span><br><?php echo nl2br(e($facts_of_case ?? '')); ?></div>
    </div>

    <div class="section">
        <div class="row"><span class="label">Requesting Party:</span> <?php echo e($requesting_party ?? ''); ?></div>
        <div class="row"><span class="label">Relationship to OFW:</span> <?php echo e($relationship_to_ofw ?? ''); ?></div>
        <div class="row"><span class="label">Complete Address:</span> <?php echo e($complete_address ?? ''); ?></div>
        <div class="row"><span class="label">Phone No. / Email Address:</span> <?php echo e($phone_email ?? ''); ?></div>
    </div>

    <div class="section">
        <div class="row"><span class="label">Attachments:</span></div>
        <div class="row">Employment Contract: <?php echo e($contract_name ?? 'None uploaded'); ?></div>
        <div class="row">Passport: <?php echo e($passport_name ?? 'None uploaded'); ?></div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\rfa-form-pdf.blade.php ENDPATH**/ ?>