<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($activityType); ?> Request - Approved

Hello <?php echo e($employerName); ?>,

Great news! Your **<?php echo e($activityType); ?> (<?php echo e(ucfirst(substr($activityType, 0, 3))); ?>)** request has been **APPROVED** by the Manolo Fortich Public Employment Service Office.

## Approval Details

- **Status:** Approved
- **Approved On:** <?php echo e($approvedAt->format('F d, Y H:i')); ?>

- **Office:** Manolo Fortich Public Employment Service Office

## Next Steps

Your certification document has been attached to your previous email. You can now proceed with your recruitment activities as outlined in the request.

If you have any questions or need further assistance, please contact the Manolo Fortich PESO Office.

---

**Contact Information:**
- Email: peso@manolofortich.gov.ph
- Phone: 0917-808-676

Thank you for choosing our services!

<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> Manolo Fortich Public Employment Service Office. All rights reserved.
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\mail\request-approved.blade.php ENDPATH**/ ?>