<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>

<body style="margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background-color:#f4f4f4;color:#1f2937;line-height:1.6">
    <div style="max-width:448px;margin-left:auto;margin-right:auto;background-color:#ffffff;border-radius:0.5rem;box-shadow:0 4px 6px rgba(0,0,0,0.1);overflow:hidden">
        <div style="background-color:#2563eb;padding:1.25rem;text-align:center;color:#ffffff">
            <h1 style="margin:0;font-size:1.5rem;font-weight:normal">Password Reset</h1>
        </div>
        <div style="padding:2rem;text-align:center">
            <h2 style="font-size:1.25rem;color:#1f2937;margin-bottom:1rem">Reset Your Password</h2>
            <p style="font-size:1rem;color:#4b5563;margin-bottom:1.25rem">We received a request to reset your password. Use the 4-character code below to proceed:</p>
            <div style="display:inline-block;background-color:#eff6ff;color:#2563eb;font-size:1.5rem;font-weight:bold;padding:1rem 1.5rem;border-radius:0.375rem;margin-bottom:1.25rem;letter-spacing:0.1em">{{ $code }}</div>
            <p style="font-size:1rem;color:#4b5563;margin-bottom:0">This code is valid for 5 minutes. If you didn’t request this, please ignore this email.</p>
        </div>
        <div style="background-color:#f9fafb;padding:1.25rem;text-align:center;color:#6b7280;border-top:1px solid #e5e7eb">
            <p style="font-size:0.875rem;margin:0">Thanks,<br>The {{ env('APP_NAME', 'Your App') }} Team</p>
            <p style="font-size:0.875rem;margin-top:0.5rem;margin-bottom:0">Need help? <a href="mailto:support@example.com" style="color:#2563eb;text-decoration:none">Contact us</a></p>
        </div>
    </div>
</body>

</html>
