<!DOCTYPE html>
<html>
<head>
    <title>Account Approved</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'DM Sans', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #002C76;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        .logo {
            height: 60px;
            width: auto;
        }
        .content {
            padding: 30px;
        }
        h2 {
            color: #002C76;
            margin-top: 0;
        }
        .status-badge {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn-login {
            display: inline-block;
            background-color: #002C76;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none !important;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #001a47;
        }
        .footer {
            background-color: #002C76;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
        /* Mobile responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logos -->
        <div class="header">
            <!-- Note: In production, use absolute URLs for images in emails -->
            <img src="{{ $message->embed(public_path('images/LGRRC_logo.png')) }}" alt="LGRRC Logo" class="logo">
            <img src="{{ $message->embed(public_path('images/CAPDEV-PRO-LOGO.png')) }}" alt="CAPDEV PRO Logo" class="logo">
        </div>

        <!-- Main Content -->
        <div class="content">
            <h2>Your Account Has Been Approved!</h2>
            <p>Dear {{ $user->name }},</p>
            
            <p>We are pleased to inform you that your account registration has been reviewed and approved by the Registrar.</p>
            
            <div style="text-align: center; margin: 25px 0;">
                <span class="status-badge">APPROVED & ACTIVE</span>
            </div>

            <p>You can now log in to the CapDevPro system and access your dashboard to start your learning journey.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="btn-login" style="color: #ffffff !important; text-decoration: none !important;">Log In to Dashboard</a>
            </div>

            <p style="font-size: 12px; color: #777; margin-top: 10px; text-align: center;">
                If the button above doesn't work, copy and paste this link into your browser:<br>
                <a href="{{ route('login') }}" style="color: #002C76;">{{ route('login') }}</a>
            </p>
            
            <p style="margin-top: 30px;">
                Welcome to the team!<br>
                <strong>The CapDevPro Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Department of the Interior and Local Government – Cordillera Administrative Region (DILG-CAR). All rights reserved.</p>
        </div>
    </div>
</body>
</html>

