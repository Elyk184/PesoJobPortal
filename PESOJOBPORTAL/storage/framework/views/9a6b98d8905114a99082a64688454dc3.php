<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>OWWA Request for Assistance Form</title>
<style>
@page { margin: 0; }
* { box-sizing: border-box; }
body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 9pt; }
.page { width: 184mm; min-height: 273mm; height: auto; margin: 0 auto; padding: 10mm 0 14mm; page-break-after: always; page-break-inside: avoid; position: relative; background: #fbfdfe; }
.page:last-child { page-break-after: auto; }
.header { display: table; width: 100%; height: 66px; table-layout: fixed; margin-bottom: 4px; }
.header > div { display: table-cell; vertical-align: middle; text-align: center; }
.header .logo { width: 66px; text-align: left; }
.header .stamp { width: 92px; text-align: center; border: 2px solid #b91c1c; color: #b91c1c; font-weight: bold; font-size: 8pt; line-height: 1.35; padding: 7px 5px; }
.logo img { max-width: 66px; max-height: 66px; }
.header-center { line-height: 1.25; }
.header-center p { margin: 0 0 3px; font-size: 8.5pt; line-height: 1.15; }
.header-center .bold { font-weight: bold; }
.header-center .main-title { font-weight: bold; font-size: 12pt; text-transform: uppercase; margin-top: 7px; }
.divider { border: 0; border-top: 1.5px solid #000; margin: 5px 0; }
.title { text-align: center; font-weight: bold; font-size: 12pt; text-decoration: underline; margin: 7px 0 5px; }
.section-title { font-weight: bold; font-size: 9pt; margin: 9px 0 4px; text-transform: uppercase; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px 0; }
.grid { display: table; width: 100%; table-layout: fixed; }
.grid > div { display: table-cell; padding-right: 8px; vertical-align: bottom; }
.grid > div:last-child { padding-right: 0; }
.g2 > div { width: 50%; }
.g3 > div { width: 33.33%; }
.g4 > div { width: 25%; }
.g5 > div { width: 20%; }
.field { min-height: 27px; padding: 3px 2px; border-bottom: 1px solid #777; }
.field .label { display: block; font-size: 7.5pt; font-weight: bold; margin-bottom: 3px; }
.value { min-height: 12px; }
.check-grid { display: table; width: 100%; table-layout: fixed; }
.check-grid > div { display: table-cell; width: 33.33%; vertical-align: top; padding: 2px 8px 2px 0; font-size: 8pt; line-height: 1.45; }
.others { font-size: 8.5pt; border-bottom: 1px solid #777; padding: 4px 2px; }
.box { border: 1px solid #b9d6e1; background: #eaf5f8; padding: 6px 9px; }
.text-box { min-height: 105px; white-space: pre-wrap; line-height: 1.45; }
.notice { border: 1px solid #000; padding: 7px 10px; margin: 12px 0; font-size: 8pt; font-style: italic; line-height: 1.45; text-align: center; }
.attachments { border: 1px solid #b9d6e1; background: #eaf5f8; padding: 6px 9px; }
.row { padding: 4px 0; border-bottom: 1px solid #b9d6e1; }
.row:last-child { border-bottom: 0; }
.label { font-weight: bold; }
.page-number { position: absolute; right: 0; bottom: 10mm; font-size: 8.5pt; }
.attachment { text-align: center; padding-top: 20px; }
.attachment-title { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }
.attachment-subtitle { font-size: 8.5pt; color: #555; margin-top: 3px; }
.uploaded { width: 100%; height: 218mm; margin-top: 14px; border: 1px solid #999; text-align: center; padding: 6mm; }
.uploaded img { max-width: 100%; max-height: 204mm; }
</style>
</head>
<body>
<div class="page">
  <div class="header">
    <div class="logo"><?php if($owwa_logo): ?><img src="<?php echo e($owwa_logo); ?>" alt="OWWA"><?php endif; ?></div>
    <div class="header-center"><p>DEPARTMENT OF LABOR AND EMPLOYMENT</p><p class="bold">OVERSEAS WORKERS WELFARE ADMINISTRATION</p><p>Regional Welfare Office No. 10</p><p>Cagayan de Oro City</p><p class="main-title">REQUEST FOR ASSISTANCE FORM</p></div>
    <div class="stamp">THIS FORM IS<br>NOT FOR SALE</div>
  </div>
  <hr class="divider">
  <div class="grid g2"><div><div class="field"><span class="label">E-Cares Ticket Number:</span><div class="value"><?php echo e($e_cares_ticket_number ?? ''); ?></div></div></div><div><div class="field"><span class="label">Date:</span><div class="value"><?php echo e($date ?? ''); ?></div></div></div></div>
  <div class="section-title">Nature of Case / Request</div>
  <div class="box check-grid">
    <?php $__currentLoopData = array_chunk($case_options ?? [], 3, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caseKey => $caseLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>[<?php echo e(in_array($caseKey, $nature_of_case ?? [], true) ? 'X' : ' '); ?>] <?php echo e($caseLabel); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <?php if(!empty($nature_of_case_other)): ?><div class="others"><span class="label">Others:</span> <?php echo e($nature_of_case_other); ?></div><?php endif; ?>
  <div class="section-title">OFW's Background and Employment Record</div>
  <div class="grid g4"><div><div class="field"><span class="label">Name of OFW: [ First ]</span><div class="value"><?php echo e($ofw_first ?? ''); ?></div></div></div><div><div class="field"><span class="label">[ Middle ]</span><div class="value"><?php echo e($ofw_middle ?? ''); ?></div></div></div><div><div class="field"><span class="label">[ Last ]</span><div class="value"><?php echo e($ofw_last ?? ''); ?></div></div></div><div><div class="field"><span class="label">Contact No.</span><div class="value"><?php echo e($contact_no ?? ''); ?></div></div></div></div>
  <div class="grid g5"><div><div class="field"><span class="label">Position:</span><div class="value"><?php echo e($position ?? ''); ?></div></div></div><div><div class="field"><span class="label">Sex:</span><div class="value"><?php echo e($sex ?? ''); ?></div></div></div><div><div class="field"><span class="label">Birthdate:</span><div class="value"><?php echo e($birthdate ?? ''); ?></div></div></div><div><div class="field"><span class="label">Age:</span><div class="value"><?php echo e($age ?? ''); ?></div></div></div><div><div class="field"><span class="label">Civil Status:</span><div class="value"><?php echo e($civil_status ?? ''); ?></div></div></div></div>
  <div class="grid g3"><div><div class="field"><span class="label">Facebook Name:</span><div class="value"><?php echo e($facebook_name ?? ''); ?></div></div></div><div><div class="field"><span class="label">Highest Educational Attainment:</span><div class="value"><?php echo e($highest_education ?? ''); ?></div></div></div><div><div class="field"><span class="label">Religion:</span><div class="value"><?php echo e($religion ?? ''); ?></div></div></div></div>
  <div class="grid g2"><div><div class="field"><span class="label">No. of Children:</span><div class="value"><?php echo e($children_count ?? ''); ?></div></div></div><div><div class="field"><span class="label">Name of Employer:</span><div class="value"><?php echo e($employer_name ?? ''); ?></div></div></div></div>
  <div class="field"><span class="label">Jobsite:</span><div class="value"><?php echo e($jobsite ?? ''); ?></div></div>
  <div class="grid g2"><div><div class="field"><span class="label">Tel. No. / Fax No.:</span><div class="value"><?php echo e($tel_fax ?? ''); ?></div></div></div><div><div class="field"><span class="label">Monthly Salary:</span><div class="value"><?php echo e($monthly_salary ?? ''); ?></div></div></div></div>
  <div class="field"><span class="label">Name of Foreign Recruitment Agency:</span><div class="value"><?php echo e($foreign_recruitment_agency ?? ''); ?></div></div>
  <div class="grid g2"><div><div class="field"><span class="label">Address and Tel. No.:</span><div class="value"><?php echo e($agency_address_tel ?? ''); ?></div></div></div><div><div class="field"><span class="label">Name of Local Agency:</span><div class="value"><?php echo e($local_agency ?? ''); ?></div></div></div></div>
  <div class="grid g2"><div><div class="field"><span class="label">Date of Latest Departure From the Philippines:</span><div class="value"><?php echo e($latest_departure ?? ''); ?></div></div></div><div><div class="field"><span class="label">OFW's Previous Employment (Please Specify Country):</span><div class="value"><?php echo e($previous_employment_country ?? ''); ?></div></div></div></div>
  <div class="grid g3"><div><div class="field"><span class="label">For Death Case: Date of Death:</span><div class="value"><?php echo e($death_date ?? ''); ?></div></div></div><div><div class="field"><span class="label">Cause of Death:</span><div class="value"><?php echo e($death_cause ?? ''); ?></div></div></div><div><div class="field"><span class="label">Place of Death:</span><div class="value"><?php echo e($death_place ?? ''); ?></div></div></div></div>
  <div class="section-title">Facts of the Case</div><div class="box text-box"><?php echo e($facts_of_case ?? ''); ?></div>
  <div class="section-title">Requesting Party</div>
  <div class="grid g2"><div><div class="field"><span class="label">Name & Signature of Requesting Party:</span><div class="value"><?php echo e($requesting_party ?? ''); ?></div></div></div><div><div class="field"><span class="label">Relationship to OFW:</span><div class="value"><?php echo e($relationship_to_ofw ?? ''); ?></div></div></div></div>
  <div class="grid g2"><div><div class="field"><span class="label">Complete Address:</span><div class="value"><?php echo e($complete_address ?? ''); ?></div></div></div><div><div class="field"><span class="label">Phone No. / Email Address:</span><div class="value"><?php echo e($phone_email ?? ''); ?></div></div></div></div>
  <div class="notice">I certify that the information provided in this form is true and correct to the best of my knowledge.</div>
  <div class="page-number">1</div>
</div>
<?php if($contract_image): ?><div class="page"><div class="attachment"><div class="attachment-title">Page 2 - Employment Contract</div><div class="attachment-subtitle">Uploaded image attachment</div><div class="uploaded"><img src="<?php echo e($contract_image); ?>" alt="Employment Contract"></div></div><div class="page-number">2</div></div><?php endif; ?>
<?php if($passport_image): ?><div class="page"><div class="attachment"><div class="attachment-title">Page 3 - Passport / Travel Document</div><div class="attachment-subtitle">Uploaded image attachment</div><div class="uploaded"><img src="<?php echo e($passport_image); ?>" alt="Passport"></div></div><div class="page-number">3</div></div><?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/ofw/rfa-form-pdf.blade.php ENDPATH**/ ?>