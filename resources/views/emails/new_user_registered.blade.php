<!DOCTYPE html>
<html>
<head>
    <title>Welcome to CapsDevPro</title>
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
        .info-box {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .info-item {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            width: 110px;
            display: inline-block;
        }
        .status-badge {
            display: inline-block;
            background-color: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
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
            <img src="{{ $message->embed(public_path('images/CAPDEV PRO.png')) }}" alt="CAPDEV PRO Logo" class="logo">
        </div>

        <!-- Main Content -->
        <div class="content">
            <h2>Welcome to CapDevPro!</h2>
            <p>Dear {{ $user->name }},</p>
            
            <p>Thank you for registering with the CapDevPro Learning Management System. We have successfully received your registration details.</p>
            
            <div style="text-align: center; margin: 25px 0;">
                <p>Your account status is currently:</p>
                <span class="status-badge">PENDING APPROVAL</span>
            </div>

            <p>You will receive another email notification once the Registrar has reviewed and activated your account. You will not be able to log in until your account is approved.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #333; font-size: 16px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Registration Details</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span> {{ $user->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span> {{ $user->email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Field of Work:</span> {{ $user->field_of_work }}
                </div>
                <div class="info-item">
                    <span class="info-label">Agency:</span> {{ $user->agency }}
                </div>
                <div class="info-item">
                    <span class="info-label">Region:</span> {{ $user->region }}
                </div>
                @php
                    $isDILG = (\Illuminate\Support\Str::contains((string) ($user->province ?? ''), 'Office')) || (empty($user->city) && empty($user->barangay));
                @endphp
                @if($isDILG)
                    <div class="info-item">
                        <span class="info-label">Provincial Office:</span> {{ $user->province }}
                    </div>
                @else
                    <div class="info-item">
                        <span class="info-label">Province:</span> {{ $user->province }}
                    </div>
                    <div class="info-item">
                        <span class="info-label">City:</span> {{ $user->city }}
                    </div>
                    <div class="info-item">
                        <span class="info-label">Barangay:</span> {{ $user->barangay }}
                    </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Date:</span> {{ $user->created_at->format('F d, Y h:i A') }}
                </div>
            </div>

            <p>Please wait for further updates.</p>
            
            <p style="margin-top: 30px;">
                Best regards,<br>
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


