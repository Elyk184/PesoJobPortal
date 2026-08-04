<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($activityType); ?> Certification - Approved

Hello <?php echo e($employerName); ?>,

Your **<?php echo e($activityType); ?> (<?php echo e(ucfirst(substr($activityType, 0, 3))); ?>)** certification has been **approved** and is now ready for use.

## Certification Details

- **Generated Date:** <?php echo e($certificationDate->format('F d, Y H:i')); ?>

- **Status:** Approved
- **Office:** Manolo Fortich Public Employment Service Office

## Next Steps

Please review the attached certification document. This certificate is valid for the specified recruitment activity period as mentioned in the document.

If you have any questions or need further assistance, please contact the Manolo Fortich PESO Office.

---

**Contact Information:**
- Email: peso@manolofortich.gov.ph
- Phone: 0917-808-676

<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> Manolo Fortich Public Employment Service Office. All rights reserved.
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\mail\certification-approval.blade.php ENDPATH**/ ?>