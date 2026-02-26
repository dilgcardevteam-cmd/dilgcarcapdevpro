<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - CAPDEV PRO</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #002C76;
            --primary-green: #7fb73d;
            --dark-text: #333333;
            --light-text: #58585b;
            --border-color: #e0e0e0;
            --bg-color: #ffffff;
            --auth-header-height: 100px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header - Matching Landing Page */
        .header {
            background-color: white;
            min-height: var(--auth-header-height);
            padding: 10px 30px;
            box-sizing: border-box;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-login-nav {
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

        .btn-login-nav:hover {
            background-color: #001a47;
            transform: translateY(-1px);
        }

        .btn-signup-nav {
            background-color: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 8px 23px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-signup-nav:hover {
            background-color: var(--primary-blue);
            color: white;
            transform: translateY(-1px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        @media (max-width: 768px) {
            :root {
                --auth-header-height: 78px;
            }

            .header {
                padding: 10px 14px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .header-logo {
                height: 38px;
                margin-right: 10px;
            }

            .nav-menu img {
                height: 36px !important;
            }

            .header-right {
                width: 100%;
                justify-content: flex-start;
            }

            .header-right a {
                font-size: 13px !important;
            }

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
    </header>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>


