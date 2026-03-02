<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPDEV PRO OTP</title>
</head>
<body style="margin:0;background:#f6f7fb;font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f6f7fb;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellspacing="0" cellpadding="0" border="0" style="width:560px;max-width:92vw;background:#ffffff;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 8px 20px rgba(15,23,42,.08);">
                    <tr>
                        <td style="padding:24px 22px;text-align:center;">
                            <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CAPDEV PRO" style="height:52px;margin-bottom:10px;">
                            <h1 style="margin:10px 0 4px 0;font-size:22px;line-height:1.2;color:#0b57d0;">Password Reset Verification</h1>
                            <p style="margin:4px 0 12px 0;color:#334155;font-size:14px;">Use the code below to continue resetting your password.</p>
                            <div style="display:inline-block;padding:12px 18px;border-radius:12px;background:#f8fafc;border:1px solid #e5e7eb;margin:6px 0 14px 0;">
                                <span style="font-size:28px;letter-spacing:6px;font-weight:900;color:#111827;">{{ $code }}</span>
                            </div>
                            <p style="margin:0;color:#475569;font-size:13px;">Code expires in {{ $minutes }} minutes.</p>
                            <div style="height:1px;background:#e5e7eb;margin:18px 0;"></div>
                            <p style="margin:0 0 12px 0;color:#475569;font-size:13px;">If you did not request this, you can ignore this email.</p>
                            <a href="{{ url('/') }}" style="display:inline-block;padding:10px 16px;border-radius:999px;background:#0b57d0;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;">Visit CAPDEV PRO</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
