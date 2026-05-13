<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject['title'] }} - CAPDEVPRO</title>
    
    <!-- Fonts -->
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <style>
        :root {
            --primary-blue: #002C76;
            --primary-green: #7fb73d;
            --dark-text: #333333;
            --light-text: #58585b;
            --bg-color: #ffffff;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark-text);
            overflow-x: hidden;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-logo {
            height: 50px;
            margin-right: 20px;
        }

        .nav-menu {
            display: none;
        }

        @media(min-width: 768px) {
            .nav-menu {
                display: flex;
                gap: 20px;
            }
        }

        .header-right {
            display: flex;
            gap: 15px;
        }

        .btn-login, .btn-signup {
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-login {
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
        }

        .btn-login:hover {
            background-color: rgba(0, 44, 118, 0.05);
        }

        .btn-signup {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-signup:hover {
            background-color: #001a47;
        }

        /* Detail Section */
        .detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 10px 24px;
            color: var(--primary-blue);
            background-color: transparent;
            border: 2px solid var(--primary-blue);
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .back-btn:hover {
            background-color: var(--primary-blue);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 44, 118, 0.2);
        }
        
        .back-btn i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .back-btn:hover i {
            transform: translateX(-3px);
        }

        .detail-layout {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .detail-text-column {
            flex: 1;
        }

        .detail-image-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .subject-detail-image {
            width: 100%;
            max-width: 500px;
            height: 350px; /* Fixed height for uniformity */
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            object-fit: cover; /* Ensures image covers the area without distortion */
            object-position: center top; /* Focus on the top part, cropping bottom whitespace if any */
        }

        @media (max-width: 768px) {
            .header {
                padding: 12px 14px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .header-logo {
                height: 38px;
                margin-right: 10px;
            }

            .header-right {
                width: 100%;
                justify-content: flex-start;
            }

            .btn-login, .btn-signup {
                padding: 8px 14px;
                font-size: 0.85rem;
            }

            .detail-container {
                margin: 20px 12px;
                padding: 20px 16px;
            }

            .detail-title {
                font-size: 1.7rem;
                padding-bottom: 14px;
                margin-bottom: 14px;
            }

            .detail-description {
                font-size: 1rem;
            }

            .detail-content {
                font-size: 1rem;
                line-height: 1.6;
            }

            .detail-layout {
                flex-direction: column-reverse;
            }
            
            .subject-detail-image {
                height: auto;
                margin-bottom: 20px;
            }
        }

        .detail-title {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
            font-weight: 700;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .detail-description {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
            font-style: italic;
        }

        .detail-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark-text);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-blue);
            color: white;
            padding: 20px 20px; /* Reduced from 40px */
            text-align: center;
            margin-top: auto;
        }

        .footer p {
            margin: 5px 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .footer-logo-text {
            font-weight: 500;
            margin-bottom: 10px !important;
            font-size: 1rem !important;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="header-left">
            
            <div class="nav-menu">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro" style="height: 70px;">
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    </header>

    <main>
        <div class="detail-container">
            @if(isset($subject['type']) && $subject['type'] == 'course')
                <a href="{{ url('/?section=available-courses') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> <span>Back to Available Courses</span>
                </a>
            @else
                <a href="{{ url('/?section=subject-areas') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> <span>Back to Subject Areas</span>
                </a>
            @endif
            
            <div class="detail-layout">
                <div class="detail-text-column">
                    <h1 class="detail-title">{{ $subject['title'] }}</h1>
                    
                    @if(isset($subject['description']))
                        <p class="detail-description">{{ $subject['description'] }}</p>
                    @endif
                    
                    <div class="detail-content">
                        {{ $subject['content'] }}
                    </div>
                </div>
                
                <div class="detail-image-column">
                    <img
                        src="{{ asset($subject['image']) }}"
                        alt="{{ $subject['title'] }}"
                        class="subject-detail-image"
                        onerror="this.onerror=null;this.src='{{ asset('images/CAPDEV-PRO-LOGO.png') }}';"
                    >
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p class="footer-logo-text">DILG CAR - Universidad De Dagupan IT Students</p>
        <p>&copy; 2026 CAPDEVPRO. All rights reserved.</p>
    </footer>
</body>
</html>


