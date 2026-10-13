<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply from PESO Manolo Fortich</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:680px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:24px;">
            <h1 style="margin:0 0 8px;font-size:22px;color:#0f172a;">Reply from PESO Manolo Fortich</h1>
            <p style="margin:0 0 24px;font-size:14px;color:#475569;">Hello <?php echo e($contactMessage->name); ?>, thank you for reaching out to us.</p>

            <div style="background:#f1f5f9;border-radius:10px;padding:16px;margin-bottom:24px;font-size:14px;color:#334155;white-space:pre-line;"><?php echo e($replyText); ?></div>

            <hr style="border:none;border-top:1px solid #e5e7eb;margin:0 0 16px;">
            <p style="margin:0 0 4px;font-size:12px;color:#64748b;font-weight:700;">Your original message:</p>
            <p style="margin:0 0 4px;font-size:12px;color:#64748b;"><strong>Subject:</strong> <?php echo e($contactMessage->subject); ?></p>
            <p style="margin:0;font-size:12px;color:#94a3b8;white-space:pre-line;"><?php echo e($contactMessage->message); ?></p>
        </div>
        <p style="margin:16px 0 0;font-size:12px;color:#64748b;text-align:center;">PESO Manolo Fortich &mdash; Public Employment Service Office</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/emails/contact-reply.blade.php ENDPATH**/ ?>