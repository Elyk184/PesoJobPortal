<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to {{ $contactSubmission->reference_code }}</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:680px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:24px;">
            <h1 style="margin:0 0 10px;font-size:24px;line-height:1.2;color:#0f172a;">Reply from PESO Admin</h1>
            <p style="margin:0 0 16px;font-size:14px;color:#475569;">Reference ID: <strong>{{ $contactSubmission->reference_code }}</strong></p>

            <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:14px;padding:16px;margin-bottom:20px;">
                <p style="margin:0 0 8px;font-size:13px;color:#64748b;">Original subject</p>
                <p style="margin:0;font-size:16px;font-weight:700;color:#0f172a;">{{ $contactSubmission->subject }}</p>
            </div>

            <div style="font-size:14px;line-height:1.7;white-space:pre-line;color:#1f2937;">
                {{ $replyMessage }}
            </div>

            <p style="margin:24px 0 0;font-size:12px;color:#64748b;">If you need to continue the conversation, reply to this email and keep the reference ID in the subject line.</p>
        </div>
    </div>
</body>
</html>