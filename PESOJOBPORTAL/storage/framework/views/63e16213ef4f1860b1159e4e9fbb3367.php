<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Message</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:680px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:24px;">
            <h1 style="margin:0 0 16px;font-size:24px;line-height:1.2;color:#0f172a;">New Contact Form Submission</h1>
            <p style="margin:0 0 24px;font-size:14px;color:#475569;">A visitor submitted a message through the PESO contact form.</p>

            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:14px;">
                <tr>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;width:140px;font-weight:700;vertical-align:top;">Name</td>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;"><?php echo e($contactData['name']); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;font-weight:700;vertical-align:top;">Email</td>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;"><?php echo e($contactData['email']); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;font-weight:700;vertical-align:top;">Phone</td>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;"><?php echo e($contactData['phone'] ?: 'N/A'); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;font-weight:700;vertical-align:top;">Subject</td>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;"><?php echo e($contactData['subject']); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;font-weight:700;vertical-align:top;">Message</td>
                    <td style="padding:10px 0;border-top:1px solid #e5e7eb;white-space:pre-line;"><?php echo e($contactData['message']); ?></td>
                </tr>
            </table>
        </div>

        <p style="margin:16px 0 0;font-size:12px;color:#64748b;text-align:center;">Sent from the PESO Manolo Fortich contact form.</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\emails\contact-form-message.blade.php ENDPATH**/ ?>