<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incomplete Activity Reminder</title>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #002C76;
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            height: 60px;
            width: auto;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #ffffff;
        }
        .content {
            padding: 48px 40px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
        }
        .message {
            margin-bottom: 32px;
            color: #475569;
            font-size: 16px;
        }
        .activities-card {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #002C76;
        }
        .activities-title {
            font-weight: 800;
            color: #64748b;
            margin-bottom: 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .activity-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #1e293b;
            font-size: 15px;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-name {
            font-weight: 500;
            color: #334155;
        }
        .activity-status {
            font-size: 11px;
            background: #e0f2fe;
            color: #002C76;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .cta-container {
            text-align: center;
            margin-top: 40px;
        }
        .btn {
            display: inline-block;
            background-color: #002C76;
            color: #ffffff !important;
            padding: 16px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 44, 118, 0.2);
        }
        .footer {
            background-color: #f8fafc;
            padding: 32px 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
        }
        .footer p {
            margin: 8px 0;
        }
        .footer a {
            color: #002C76;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/CAPDEV-PRO-LOGO.png')) }}" alt="CapDev Pro Logo">
            <h1>Course Progress Reminder</h1>
        </div>
        <div class="content">
            <div class="greeting">Hello {{ $participant->name }},</div>
            <div class="message">
                We hope you're having a productive day! This is a gentle reminder regarding your progress in the course: <strong>{{ $course->name }}</strong>. 
                Our records show that there are some activities waiting for your completion.
            </div>
            
            <div class="activities-card">
                <div class="activities-title">Pending Activities</div>
                <ul class="activity-list">
                    @foreach ($incompleteActivities as $activity)
                        <li class="activity-item">
                            <span class="activity-name">• {{ $activity->title }}</span>
                            <span class="activity-status">Incomplete</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <p class="message">
                Completing these activities will help you stay on track and ensure you get the most out of this training. 
                Please click the button below to resume your learning journey.
            </p>
            
            <div class="cta-container">
                <a href="{{ route('trainer.courses.enter', $course) }}" class="btn">Resume Your Course</a>
            </div>
        </div>
        <div class="footer">
            <p>This is an automated message from <strong>CapDev Pro</strong>.</p>
            <p>&copy; {{ date('Y') }} DILG CapDev Pro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>