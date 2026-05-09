<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPDEV PRO</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/dm-sans.css') }}">
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
            overflow-x: hidden; /* Prevent horizontal scroll */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            background-color: #eef3ff;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.55);
            z-index: -1;
            pointer-events: none;
        }

        .site-bg-video {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.33;
            filter: saturate(75%) brightness(1.15);
            z-index: -2;
            pointer-events: none;
        }

        main {
            background: transparent;
        }

        /* Welcome Section */
        .welcome-section {
            width: 100%;
            height: auto; /* Remove fixed height to fit image */
            display: block; /* Remove flex centering */
            background-color: transparent;
            position: relative;
            padding: .2in; /* Added 1 inch spacing for image framing */
            margin: 0;
            box-sizing: border-box; /* Ensure padding doesn't cause overflow */
        }

        .welcome-image {
            width: 75%;
            height: auto;
            max-width: 75%;
            opacity: 0;
            animation: fadeIn 1.5s ease-out forwards;
            display: block;
            margin: 0 auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
            color: var(--primary-blue);
            font-size: 1.5rem;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translate(-50%, 0); }
            40% { transform: translate(-50%, -10px); }
            60% { transform: translate(-50%, -5px); }
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
            display: none; /* Hidden on mobile for simplicity */
        }

        @media(min-width: 768px) {
            .nav-menu {
                display: flex;
                gap: 20px;
                align-items: center;
            }
            .nav-item {
                text-decoration: none;
                color: var(--dark-text);
                font-weight: 600;
                font-size: 15px;
                transition: color 0.3s ease;
                position: relative;
            }

            .nav-item::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -4px;
                left: 0;
                background-color: var(--primary-blue);
                transition: width 0.3s ease;
            }

            .nav-item:hover {
                color: var(--primary-blue);
            }

            .nav-item:hover::after {
                width: 100%;
            }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-login {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-login:hover {
            background-color: #001a47;
            transform: translateY(-1px);
        }

        .btn-signup {
            background-color: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 8px 23px; /* Adjusted padding for border width */
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-signup:hover {
            background-color: var(--primary-blue);
            color: white;
            transform: translateY(-1px);
        }

        /* Hero Section */
        .hero {
            padding: 60px 30px;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column-reverse;
            align-items: center;
            gap: 40px;
            min-height: 100vh; /* Make it a full screen section */
            justify-content: center;
        }

        @media(min-width: 992px) {
            .hero {
                flex-direction: row;
                text-align: left;
                padding: 80px 30px;
            }
        }

        .hero-content {
            flex: 1;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .hero-content.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-image {
            flex: 1;
            width: 100%;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1.2s ease-out, transform 1.2s ease-out;
        }

        .hero-image.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .hero-image img {
            width: 100%;
            border-radius: 20px 0 20px 0; /* Stylized border radius matching NetAcad */
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.5s ease;
        }

        .hero-image:hover img {
            transform: scale(1.02);
        }

        h1 {
            font-size: 2.5rem;
            line-height: 1.2;
            margin-bottom: 20px;
            font-weight: 300;
        }

        h1 strong {
            font-weight: 700;
            display: block;
        }

        .hero-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #000000; /* Pure black for maximum readability */
            margin-bottom: 30px;
        }

        .hero-text strong {
            font-weight: 700;
            color: var(--primary-black); /* Make the specific emphasized text stand out */
        }

        .btn-cta {
            background-color: var(--primary-green);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-cta:hover {
            background-color: #6da032;
        }

        .stats-bar {
            background-color: white;
            padding: 40px 20px;
            border-top: 1px solid #eee;
            margin-top: 40px;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            text-align: center;
            gap: 30px;
        }

        .stat-item h3 {
            font-size: 2rem;
            color: var(--dark-text);
            margin: 0 0 10px;
            font-weight: 300;
        }

        .stat-item p {
            font-size: 0.9rem;
            color: #333333; /* Darker text */
            margin: 0;
        }

        /* Subject Areas Section */
        .subject-section {
            padding: 80px 30px;
            background-color: transparent;
            text-align: center;
        }

        .subject-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 2.5rem;
            color: var(--dark-text);
            margin-bottom: 50px;
            font-weight: 400;
        }

        .subject-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .subject-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
        }

        .subject-card {
            background-color: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-decoration: none;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align content to the left */
            gap: 20px; /* Space between icon and text */
            min-height: 120px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        .subject-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--primary-blue);
        }

        .subject-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .subject-card:hover .subject-icon {
            transform: scale(1.1);
        }

        .subject-name {
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            line-height: 1.4;
            z-index: 1;
            color: var(--primary-blue);
            flex: 1; /* Allow text to take remaining space */
        }
        
        .subject-card:hover .subject-name {
            color: #001a47;
        }

        .subject-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,44,118,0.05) 0%, rgba(0,44,118,0) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .subject-card:hover::before {
            opacity: 1;
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

        /* Available Courses Section Styles */
        .course-card {
            background-color: white;
            border-radius: 8px; /* Slightly sharper corners than subjects */
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-decoration: none;
            color: var(--dark-text);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #eee;
            text-align: left;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .course-image-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background-color: #f0f0f0;
            overflow: hidden;
        }

        .course-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-image {
            transform: scale(1.05);
        }

        .course-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--primary-green);
            color: white;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 4px;
            z-index: 2;
        }

        .course-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .course-provider {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #666;
        }
        
        .course-provider img {
            height: 20px;
            margin-right: 8px;
        }

        .course-meta {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-title-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-description {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .course-footer {
            display: none; /* Hidden as per request */
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: auto;
            font-size: 0.85rem;
            color: #666;
            gap: 15px;
        }

        .course-footer-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Carousel Styles */
        .carousel-wrapper {
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px; /* Space for arrows */
        }

        .carousel-container {
            overflow: hidden;
            width: 100%;
        }

        .carousel-track {
            display: flex;
            gap: 30px;
            transition: transform 0.5s ease-in-out;
            padding: 10px 0 20px 0; /* Space for shadows */
        }

        /* Center the track items when they don't fill the container */
        .carousel-track.justify-center {
            justify-content: center;
        }

        .carousel-slide {
            flex: 0 0 calc(25% - 22.5px); /* 4 items minus gap */
            min-width: 280px;
        }

        @media (max-width: 1200px) {
            .carousel-slide {
                flex: 0 0 calc(33.333% - 20px); /* 3 items */
            }
        }

        @media (max-width: 900px) {
            .carousel-slide {
                flex: 0 0 calc(50% - 15px); /* 2 items */
            }
        }

        @media (max-width: 600px) {
            .carousel-slide {
                flex: 0 0 100%; /* 1 item */
            }
            .carousel-wrapper {
                padding: 0 10px;
            }
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;
            border: none;
            box-shadow: none;
            color: #002C76; /* Force Primary Blue */
            font-size: 2rem; /* Larger icon size */
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 100; /* Ensure it is on top */
            transition: all 0.3s;
            padding: 10px;
            opacity: 1; /* Fully visible */
        }

        .carousel-btn:hover {
            background-color: transparent;
            color: #001a47; /* Darker blue on hover */
            transform: translateY(-50%) scale(1.2);
        }

        .carousel-btn.prev {
            left: 0;
        }

        .carousel-btn.next {
            right: 0;
        }

        /* Certificate Section Styles */
        .certificate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
        }

        .certificate-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            background-color: #f0f0f0;
        }

        .certificate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .certificate-card img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Name Blur Effect */
        .blur-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 30%; /* Covers the central name area */
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.1); /* Subtle overlay */
            pointer-events: none; /* Allows clicks to pass through if needed */
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
                flex-wrap: wrap;
                gap: 8px;
            }

            .btn-login, .btn-signup {
                font-size: 13px;
                padding: 8px 14px;
            }

            .welcome-section {
                padding: 12px;
            }

            .hero {
                min-height: auto;
                padding: 30px 16px;
                gap: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .subject-section {
                padding-left: 16px;
                padding-right: 16px;
            }

            .subject-grid,
            .course-grid,
            .certificate-grid {
                padding-left: 0;
                padding-right: 0;
                gap: 16px;
                grid-template-columns: 1fr;
            }

            .carousel-wrapper {
                padding-left: 14px;
                padding-right: 14px;
            }

            #about-us > div {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #about-us [style*="min-width: 300px"] {
                min-width: 0 !important;
            }
        }
    </style>
</head>
<body>
    <video class="site-bg-video" autoplay muted loop playsinline>
        <source src="{{ asset('bckgrnd.mp4') }}" type="video/mp4">
    </video>

    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CAPDEV PRO" class="header-logo" onerror="this.style.display='none'">
        </div>
        <div class="nav-menu">
            <a href="#home" class="nav-item">Home</a>
            <a href="#subject-areas" class="nav-item">Subject Areas</a>
            <a href="#available-courses" class="nav-item">Courses</a>
            <a href="#about-us" class="nav-item">About Us</a>
        </div>
        <div class="header-right">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="btn-login" style="display: flex; align-items: center; gap: 10px; padding: 5px 15px;">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                    @else
                        <div style="width: 30px; height: 30px; background-color: white; color: var(--primary-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <span>Dashboard</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline-block;margin-left:8px">
                    @csrf
                    <button type="submit" class="btn-login" style="background:#ef4444;color:#fff;border:none">Logout</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endif
        </div>
    </header>

    <main>
        <!-- Welcome Section -->
        <section class="welcome-section" id="home">
            <div class="welcome-content">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="WELCOME TO CAPDEV PRO" class="welcome-image">
            </div>
            <div class="scroll-indicator">
            </div>
        </section>

        <section class="hero">
            <div class="hero-content">
                <h1>
                    Strengthening Local Governance in the Cordillera through
                    <strong>Competence and Innovation</strong>
                </h1>
                <p class="hero-text">
                    The <strong>CAPDEVPRO CLGRRC E-Learning Portal</strong> serves as the central digital platform for the Department of the Interior and Local Government – Cordillera Administrative Region (DILG-CAR) Capacity Development Program. It is designed to institutionalize knowledge management and enhance the skills and competencies of local government personnel across the region.
                    <br><br>
                    Through a comprehensive suite of competency-based modules tailored to CAR’s governance needs, the portal provides accessible and specialized training in public administration, technical proficiency, and service delivery. By leveraging digital technology, this initiative ensures continuous professional development, fosters excellence in local governance, promotes transparency, and strengthens public accountability throughout the Cordillera Administrative Region.
                </p>
            </div>
            <div class="hero-image">
            <img src="{{ asset('images/Department of Interior Local Government PNG.png') }}" alt="DILG-CAR LMS Hero Image">
        </div>
        </section>



        <!-- Subject Areas Section -->
        <section class="subject-section" id="subject-areas">
            <h2 class="subject-title">SUBJECT AREAS</h2>
            <div class="subject-grid">
                <a href="{{ route('subject.show', 'public-administrative-financial') }}" class="subject-card">
                    <img src="{{ asset('images/personal.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Public Administrative & Financial</span>
                </a>
                <a href="{{ route('subject.show', 'technical-infrastructure') }}" class="subject-card">
                    <img src="{{ asset('images/infrastructure.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Technical & Infrastructure</span>
                </a>
                <a href="{{ route('subject.show', 'information-technology') }}" class="subject-card">
                    <img src="{{ asset('images/information.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Information & Technology</span>
                </a>
                <a href="{{ route('subject.show', 'health-social-services') }}" class="subject-card">
                    <img src="{{ asset('images/health.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Health & Social Services</span>
                </a>
                <a href="{{ route('subject.show', 'public-safety-regulation') }}" class="subject-card">
                    <img src="{{ asset('images/public-safety.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Public Safety & Regulation</span>
                </a>
                <a href="{{ route('subject.show', 'legal-governance') }}" class="subject-card">
                    <img src="{{ asset('images/city-hall.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Legal & Governance</span>
                </a>
                <a href="{{ route('subject.show', 'business-economic-development') }}" class="subject-card">
                    <img src="{{ asset('images/economic.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Business & Economic Development</span>
                </a>
                <a href="{{ route('subject.show', 'environment-agriculture') }}" class="subject-card">
                    <img src="{{ asset('images/save-the-world.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Environment & Agriculture</span>
                </a>
                <a href="{{ route('subject.show', 'education-culture-community') }}" class="subject-card">
                    <img src="{{ asset('images/community-center.png') }}" class="subject-icon" alt="Icon">
                    <span class="subject-name">Education, Culture & Community</span>
                </a>
            </div>
        </section>

        <!-- Available Courses Section -->
        <section class="subject-section" id="available-courses">
            <h2 class="subject-title">AVAILABLE COURSES</h2>
            <div class="carousel-wrapper">
                <button class="carousel-btn prev" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                <div class="carousel-container">
                    <div class="carousel-track" id="courseTrack">
                        <!-- Course 1 -->
                        <div class="carousel-slide">
                            <a href="{{ route('subject.show', 'basic-research') }}" class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset('images/Basic Research.png') }}" class="course-image" alt="Basic Research">
                                    <!-- Badge removed -->
                                </div>
                                <div class="course-content">
                                    <div class="course-provider">
                                        <img src="{{ asset('images/LGRRC_logo.png') }}" alt="LGRRC">
                                        <span>DILG-CAR</span>
                                    </div>
                                    <h3 class="course-title-text">BASIC RESEARCH</h3>
                                    <p class="course-description">
                                        Learn the fundamentals of research methodology, data collection, and analysis tailored for local governance applications.
                                    </p>
                                    <!-- Footer removed -->
                                </div>
                            </a>
                        </div>

                        <!-- Course 2 -->
                        <div class="carousel-slide">
                            <a href="{{ route('subject.show', 'basic-services-facilities') }}" class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset('images/Basic Services.png') }}" class="course-image" alt="Basic Services">
                                    <!-- Badge removed -->
                                </div>
                                <div class="course-content">
                                    <div class="course-provider">
                                        <img src="{{ asset('images/LGRRC_logo.png') }}" alt="LGRRC">
                                        <span>DILG-CAR</span>
                                    </div>
                                    <h3 class="course-title-text">BASIC SERVICES AND FACILITIES</h3>
                                    <p class="course-description">
                                        Understand the essential services and facilities that Local Government Units are mandated to provide to their constituents.
                                    </p>
                                    <!-- Footer removed -->
                                </div>
                            </a>
                        </div>

                        <!-- Course 3 -->
                        <div class="carousel-slide">
                            <a href="{{ route('subject.show', 'nature-types-local-governments') }}" class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset('images/Nature and Types.png') }}" class="course-image" alt="Nature and Types">
                                    <!-- Badge removed -->
                                </div>
                                <div class="course-content">
                                    <div class="course-provider">
                                        <img src="{{ asset('images/LGRRC_logo.png') }}" alt="LGRRC">
                                        <span>DILG-CAR</span>
                                    </div>
                                    <h3 class="course-title-text">NATURE AND TYPES OF LOCAL GOVERNMENTS</h3>
                                    <p class="course-description">
                                        Explore the different types of LGUs in the Philippines, their distinct roles, powers, and functions in the political structure.
                                    </p>
                                    <!-- Footer removed -->
                                </div>
                            </a>
                        </div>

                        <!-- Course 4 -->
                        <div class="carousel-slide">
                            <a href="{{ route('subject.show', 'creation-lgu') }}" class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset('images/Creation.png') }}" class="course-image" alt="Creation of LGUs">
                                    <!-- Badge removed -->
                                </div>
                                <div class="course-content">
                                    <div class="course-provider">
                                        <img src="{{ asset('images/LGRRC_logo.png') }}" alt="LGRRC">
                                        <span>DILG-CAR</span>
                                    </div>
                                    <h3 class="course-title-text">CREATION, CONVERSION, DIVISION, MERGER, AND ABOLITION OF LGUs</h3>
                                    <p class="course-description">
                                        A comprehensive guide on the legal processes and requirements for creating, modifying, or dissolving Local Government Units.
                                    </p>
                                    <!-- Footer removed -->
                                </div>
                            </a>
                        </div>

                        <!-- Course 5 -->
                        <div class="carousel-slide">
                            <a href="{{ route('subject.show', 'local-autonomy-decentralization') }}" class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset('images/Local Autonomy.png') }}" class="course-image" alt="Local Autonomy">
                                    <!-- Badge removed -->
                                </div>
                                <div class="course-content">
                                    <div class="course-provider">
                                        <img src="{{ asset('images/LGRRC_logo.png') }}" alt="LGRRC">
                                        <span>DILG-CAR</span>
                                    </div>
                                    <h3 class="course-title-text">LOCAL AUTONOMY AND SYSTEM OF DECENTRALIZATION</h3>
                                    <p class="course-description">
                                        Deep dive into the principles of local autonomy and decentralization as enshrined in the Constitution and the Local Government Code.
                                    </p>
                                    <!-- Footer removed -->
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="carousel-btn next" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </section>

        <!-- About Us Section -->
        <section class="subject-section" id="about-us" style="background-color: transparent;">
            <h2 class="subject-title">ABOUT US</h2>
            <div style="max-width: 1000px; margin: 0 auto; text-align: left; padding: 0 30px;">
                <div style="font-size: 1.1rem; line-height: 1.8; color: var(--light-text); margin-bottom: 50px; text-align: justify;">
                    <p>
                        The Capacity Development Learning Management System (Cap Dev LMS) is an online learning platform programmed by the Department of the Interior and Local Government – Cordillera Administrative Region (DILG-CAR) to support the continuous development of Local Government Units (LGUs). Capacity development focuses on improving the knowledge, skills, and competencies of local officials and personnel so they can perform their duties effectively and responsibly. Through the use of digital technology, DILG-CAR designed the Cap Dev LMS to make training programs more accessible, organized, and responsive to the needs of LGUs in the region.
                    </p>
                    <p>
                        The Cap Dev LMS functions as a Learning Management System, which allows training materials, modules, and assessments to be delivered online. This platform supports blended learning by combining face-to-face trainings with self-paced online courses. LGU personnel can access learning resources anytime and anywhere, which is especially important in the Cordillera Administrative Region where geographical challenges may limit physical attendance. The system also helps standardize training content and ensures that participants receive consistent and quality learning experiences.
                    </p>
                    <p>
                        Overall, the Cap Dev LMS plays an important role in strengthening local governance and public service delivery. By providing a structured and flexible platform for learning, DILG-CAR enables LGUs to continuously enhance their capabilities and align their practices with national and regional development goals. The program reflects the department’s commitment to innovation, good governance, and the professional growth of public servants through modern and sustainable learning approaches.
                    </p>
                </div>

                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; margin-bottom: 50px;">
                    <!-- Vision -->
                    <div style="flex: 1; min-width: 300px; max-width: 450px; text-align: left; background-color: #fff5f5; padding: 25px; border-radius: 10px; border-left: 5px solid #dc3545;">
                        <h3 style="color: #dc3545; margin-bottom: 15px; font-size: 1.5rem;"><i class="fas fa-eye" style="margin-right: 10px;"></i> Our Vision</h3>
                        <p style="color: var(--dark-text); line-height: 1.6; font-weight: 500;">
                            A highly trusted Department and Partner in nurturing local governments and sustaining peaceful, safe, progressive, resilient, and inclusive communities towards a comfortable and secure life for Filipinos by 2040.
                        </p>
                    </div>
                    <!-- Mission -->
                    <div style="flex: 1; min-width: 300px; max-width: 450px; text-align: left; background-color: #f0f7ff; padding: 25px; border-radius: 10px; border-left: 5px solid var(--primary-blue);">
                        <h3 style="color: var(--primary-blue); margin-bottom: 15px; font-size: 1.5rem;"><i class="fas fa-bullseye" style="margin-right: 10px;"></i> Our Mission</h3>
                        <p style="color: var(--dark-text); line-height: 1.6; font-weight: 500;">
                            The Department shall ensure peace and order, public safety and security, uphold excellence in local governance and enable resilient and inclusive communities.
                        </p>
                    </div>
                </div>

                <!-- Shared Values -->
                <div style="text-align: center; margin-bottom: 60px; background-color: #fff9db; padding: 30px; border-radius: 10px; border: 1px solid #f1c40f;">
                    <h3 style="color: #d4ac0d; margin-bottom: 15px; font-size: 1.5rem; text-transform: uppercase;">DILG Shared Values</h3>
                    <p style="color: var(--dark-text); font-size: 1.3rem; font-weight: bold; font-style: italic;">
                        "Ang DILG ay Matino, Mahusay at Maaasahan"
                    </p>
                </div>

                <!-- Contact Information -->
                <div style="text-align: center; border-top: 1px solid #eee; padding-top: 50px;">
                    <h3 style="color: var(--dark-text); margin-bottom: 20px; font-size: 1.5rem;">Contact Information</h3>
                    <p style="color: var(--light-text); line-height: 1.8; margin-bottom: 10px;">
                        For queries and concerns, you may find the contact information by clicking <a href="#" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">HERE</a>.
                    </p>
                    <p style="color: var(--light-text); line-height: 1.8; margin-bottom: 10px;">
                        Also, you may directly email us at <a href="mailto:dilgcarcloud@gmail.com" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">dilgcarcloud@gmail.com</a> and copy furnished (cc) our Human Resource and Records Section at <a href="mailto:dilgcar.hr@gmail.com" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">dilgcar.hr@gmail.com</a> or <a href="mailto:dilgcarfad@gmail.com" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">dilgcarfad@gmail.com</a>.
                    </p>
                    <p style="color: var(--light-text); line-height: 1.8;">
                        Further, you may also check out the Civil Service Commission (CSC) Career Opportunities <a href="#" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">HERE</a>.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p class="footer-logo-text">DILG CAR - Universidad De Dagupan IT Students</p>
        <p>&copy; 2026 CAPDEV PRO. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Custom Smooth Scroll Function with Easing
            function smoothScroll(targetId, duration) {
                const target = document.querySelector(targetId);
                if (!target) return;

                const headerOffset = 80; // Height of the fixed header
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerOffset;
                const startPosition = window.scrollY;
                const distance = targetPosition - startPosition;
                let startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    const run = ease(timeElapsed, startPosition, distance, duration);
                    window.scrollTo(0, run);

                    if (timeElapsed < duration) requestAnimationFrame(animation);
                }

                // Ease-in-out Quadratic function
                function ease(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t + b;
                    t--;
                    return -c / 2 * (t * (t - 2) - 1) + b;
                }

                requestAnimationFrame(animation);
            }

            // Apply to navigation links
            document.querySelectorAll('.nav-item[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    smoothScroll(targetId, 1000); // 1000ms = 1 second scroll duration
                });
            });

            // Check for section query parameter and scroll if needed
            const urlParams = new URLSearchParams(window.location.search);
            const sectionParam = urlParams.get('section');
            
            if (sectionParam) {
                const targetSection = document.getElementById(sectionParam);
                if (targetSection) {
                    // specific timeout to ensure layout is ready
                    setTimeout(() => {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }, 100);
                    
                    // Clean URL to prevent staying here on reload
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }
            }

            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target); // Only animate once
                    }
                });
            }, observerOptions);

            const heroContent = document.querySelector('.hero-content');
            const heroImage = document.querySelector('.hero-image');

            if (heroContent) observer.observe(heroContent);
            if (heroImage) observer.observe(heroImage);

            // Carousel Navigation logic
            function setupCarousel(trackId, prevBtnId, nextBtnId) {
                const track = document.getElementById(trackId);
                const prevBtn = document.getElementById(prevBtnId);
                const nextBtn = document.getElementById(nextBtnId);
                
                if (!track || !prevBtn || !nextBtn) return;
                
                let currentIndex = 0;
                
                function getVisibleSlides() {
                    const width = window.innerWidth;
                    if (width <= 600) return 1;
                    if (width <= 900) return 2;
                    if (width <= 1200) return 3;
                    return 4;
                }
                
                function updateCarousel() {
                    const slides = track.querySelectorAll('.carousel-slide');
                    if (slides.length === 0) return;
                    
                    const slideWidth = slides[0].offsetWidth;
                    const gap = 30; // CSS gap
                    const moveAmount = slideWidth + gap;
                    
                    track.style.transform = `translateX(-${currentIndex * moveAmount}px)`;
                    
                    // Optional: Hide buttons if no scroll needed
                    const slidesCount = slides.length;
                    const visibleSlides = getVisibleSlides();
                    if (slidesCount <= visibleSlides) {
                        prevBtn.style.display = 'none';
                        nextBtn.style.display = 'none';
                        track.style.transform = 'translateX(0)';
                        track.classList.add('justify-center'); // Center items if fewer than visible limit
                    } else {
                        prevBtn.style.display = 'flex';
                        nextBtn.style.display = 'flex';
                        track.classList.remove('justify-center'); // Default left align for scrolling
                    }
                }

                nextBtn.addEventListener('click', () => {
                    const slidesCount = track.querySelectorAll('.carousel-slide').length;
                    const visibleSlides = getVisibleSlides();
                    const maxIndex = slidesCount - visibleSlides;
                    
                    if (currentIndex < maxIndex) {
                        currentIndex++;
                    } else {
                        currentIndex = 0; // Loop back to start
                    }
                    updateCarousel();
                });

                prevBtn.addEventListener('click', () => {
                    const slidesCount = track.querySelectorAll('.carousel-slide').length;
                    const visibleSlides = getVisibleSlides();
                    const maxIndex = slidesCount - visibleSlides;

                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = maxIndex; // Loop to end
                    }
                    updateCarousel();
                });

                window.addEventListener('resize', () => {
                    currentIndex = 0; // Reset on resize
                    updateCarousel();
                });
                
                // Initial update to check visibility
                updateCarousel();
            }

            // Initialize Carousels
            setupCarousel('courseTrack', 'prevBtn', 'nextBtn');
        });
    </script>
</body>
</html>
