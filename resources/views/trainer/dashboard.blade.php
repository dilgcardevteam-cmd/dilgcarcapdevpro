<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - CAPDEV PRO</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #002C76;
            --primary-green: #7fb73d;
            --dark-text: #333333;
            --light-text: #58585b;
            --bg-color: #f4f6f9;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --header-height: 80px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark-text);
            background-color: var(--bg-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            backdrop-filter: blur(2px);
        }

        /* Header Styles */
        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--header-height);
            box-sizing: border-box;
            z-index: 1000;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            transition: left .3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-logo {
            height: 50px;
            margin-right: 20px;
        }

        .header-title img {
            height: 50px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Modern Notification Styles */
        .notification-container {
            position: relative;
        }
        
        .notification-bell {
            cursor: pointer;
            position: relative;
            color: var(--primary-blue);
            font-size: 1.25rem;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .notification-bell:hover {
            background-color: #f1f5f9;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .notification-bell:active {
            transform: translateY(0);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 999px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: 0.7rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 55px;
            right: 0;
            width: 380px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            z-index: 1200;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            animation: dropdownFadeIn 0.2s ease-out;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notification-header {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            background-color: white;
        }

        .notification-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .notification-header-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1e293b;
        }

        .mark-all-read {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-blue);
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
        }

        .mark-all-read:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .notification-header-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f8fafc;
        }

        .notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            gap: 14px;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }

        .notification-item.unread {
            background-color: #f0f7ff;
        }

        .notification-item.unread:hover {
            background-color: #e5f1ff;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        /* Notification Types Icons */
        .icon-course { background-color: #e0ebff; color: #1d4ed8; }
        .icon-student { background-color: #ecfdf5; color: #059669; }
        .icon-assessment { background-color: #fff7ed; color: #d97706; }
        .icon-calendar { background-color: #fef2f2; color: #dc2626; }
        .icon-announcement { background-color: #f5f3ff; color: #7c3aed; }
        .icon-default { background-color: #f1f5f9; color: #475569; }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-item-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .notification-item.unread .notification-item-title {
            padding-right: 15px;
        }

        .unread-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 8px;
            height: 8px;
            background-color: #3b82f6;
            border-radius: 50%;
        }

        .notification-item-message {
            font-size: 0.82rem;
            color: #64748b;
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-item-time {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .notification-footer {
            padding: 14px;
            text-align: center;
            background-color: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }

        .view-all-link {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-blue);
            text-decoration: none;
            transition: color 0.2s;
        }

        .view-all-link:hover {
            color: #1d4ed8;
        }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            color: #e2e8f0;
            margin-bottom: 12px;
        }

        .empty-state-text {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .notification-dropdown {
                width: calc(100vw - 32px);
                right: -50px;
            }
        }

        /* Bell Shake Animation */
        @keyframes bellShake {
            0% { transform: rotate(0); }
            15% { transform: rotate(10deg); }
            30% { transform: rotate(-10deg); }
            45% { transform: rotate(5deg); }
            60% { transform: rotate(-5deg); }
            75% { transform: rotate(2deg); }
            100% { transform: rotate(0); }
        }

        .bell-shake {
            animation: bellShake 0.6s ease-in-out;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 15px;
            color: var(--dark-text);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            transition: margin-left .3s ease;
        }

        /* Hero */
        .control-hero{background:linear-gradient(135deg,#991b1b 0%,#dc2626 58%,#ef4444 100%);color:#fff;border-radius:22px;padding:34px 36px;position:relative;overflow:hidden;margin-bottom:26px;box-shadow:0 14px 34px rgba(220,38,38,.24)}
        .control-hero::after{content:"";position:absolute;top:-48%;right:-8%;width:320px;height:320px;background:rgba(255,255,255,.1);border-radius:50%}
        .control-hero-top{position:relative;z-index:1;display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:24px}
        .control-hero-left{display:flex;align-items:flex-start;gap:16px}
        .control-hero-badge{width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;flex:0 0 auto}
        .control-hero-title{font-size:2.05rem;font-weight:800;letter-spacing:-.02em;line-height:1.05;margin:0}
        .control-hero-sub{opacity:.92;font-size:1.02rem;max-width:640px;margin-top:10px}
        .hero-stats-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:16px}
        @media (min-width: 900px){ .hero-stats-grid{grid-template-columns:repeat(2,1fr)} }
        @media (min-width: 1200px){ .hero-stats-grid{grid-template-columns:repeat(4,1fr)} }
        .hero-stat-card{display:flex;align-items:center;gap:16px;background:rgba(255,255,255,.14);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.24);border-radius:18px;padding:20px 22px;transition:transform .18s ease, background-color .18s ease}
        .hero-stat-card:hover{transform:translateY(-4px);background:rgba(255,255,255,.2)}
        .hero-stat-icon{width:52px;height:52px;border-radius:16px;background:#fff;color:#b91c1c;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex:0 0 auto}
        .hero-stat-info{display:flex;flex-direction:column}
        .hero-stat-value{font-size:2rem;font-weight:800;line-height:1}
        .hero-stat-label{font-size:.82rem;opacity:.88;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-top:6px}

        .profile-menu{position:relative}
        .profile-dropdown{position:absolute;top:50px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-meta{padding:10px 14px;border-bottom:1px solid #e5e7eb}
        .profile-dropdown .dropdown-meta-name{font-weight:700;color:#111827}
        .profile-dropdown .dropdown-meta-role{font-size:.85rem;color:#6b7280}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        .profile-trigger{display:flex;align-items:center;gap:8px;cursor:pointer}
        .profile-caret{font-size:.9rem;color:#666}
        .profile-trigger.open .profile-caret{transform:rotate(180deg);transition:transform .2s}

        .sidebar-brand{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)}
        .sidebar-logo{height:70px}
        .sidebar.collapsed .sidebar-brand{justify-content:center;padding:8px 0}
        .sidebar.collapsed .sidebar-logo{height:44px;width:44px;margin:0 auto;display:block;object-fit:contain}
        .header-toggle,
        .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .header-toggle:hover,
        .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
        .header-section-title{margin-left:12px;font-weight:700;color:var(--primary-blue);font-size:1.2rem;letter-spacing:-.01em}

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            color: white;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        .sidebar-collapsed .header{
            left: var(--sidebar-collapsed-width);
        }
        .sidebar-collapsed .dashboard-container{
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            padding: 15px;
            cursor: pointer;
            text-align: right;
            font-size: 1.2rem;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0px;
                --header-height: 64px;
            }
            .header {
                left: 0 !important;
                padding: 0 12px !important;
                height: var(--header-height);
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(8px);
            }
            .dashboard-container {
                margin-left: 0 !important;
                padding-top: var(--header-height);
            }
            .sidebar {
                position: fixed !important;
                top: 0;
                left: -280px;
                bottom: 0;
                width: 280px !important;
                z-index: 2100;
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 20px 0 50px rgba(0,0,0,0.15);
            }
            .sidebar.mobile-open {
                transform: translateX(280px);
            }
            .sidebar-overlay {
                backdrop-filter: blur(4px);
                background: rgba(15, 23, 42, 0.4);
                transition: opacity 0.3s ease;
            }
            .sidebar-overlay.mobile-open {
                display: block;
                opacity: 1;
            }
            .main-content {
                padding: 12px !important;
            }
            .hero-stats-grid {
                grid-template-columns: repeat(1, 1fr) !important;
                gap: 12px !important;
            }
            .header-toggle {
                display: flex !important;
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: #f1f5f9;
                border: none;
                color: var(--primary-blue);
                margin-right: 10px;
            }
            .header-right .user-profile span {
                display: none;
            }
            .header-logo {
                height: 32px;
                margin-right: 8px;
            }
            .header-title img {
                height: 32px;
            }
            .control-hero-title {
                font-size: 1.4rem !important;
            }
            .control-hero {
                padding: 20px 18px !important;
                border-radius: 16px !important;
            }
            .notification-dropdown {
                width: min(92vw, 320px) !important;
                right: 0 !important;
                left: auto !important;
            }
            .welcome-title {
                font-size: 1.4rem !important;
                margin-bottom: 20px !important;
            }
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-icon {
            width: 25px;
            font-size: 1.1rem;
            text-align: center;
            margin-right: 15px;
        }
        
        .nav-text {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .nav-portal {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-portal-toggle {
            width: 100%;
            position: relative;
            overflow: visible;
            padding-right: 58px;
            box-sizing: border-box;
        }
        
        .nav-chevron {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
            background: transparent;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: none;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .nav-chevron::before {
            content: "";
            display: block;
            width: 8px;
            height: 8px;
            border-right: 3px solid #ffffff;
            border-bottom: 3px solid #ffffff;
            transform: rotate(45deg);
        }
        
        .nav-portal.open .nav-chevron {
            transform: translateY(-50%) rotate(180deg);
            background-color: transparent;
        }
        
        .nav-portal-list {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease;
        }
        
        .nav-portal.open .nav-portal-list {
            max-height: 420px;
        }
        
        .nav-portal-list .nav-link {
            padding: 12px 25px 12px 54px;
        }
        
        .sidebar.collapsed .nav-portal-list {
            max-height: 0 !important;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 15px;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: var(--bg-color);
        }

        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 20px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .stat-info p {
            margin: 5px 0 0;
            color: var(--light-text);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .bg-blue { background-color: #e3f2fd; color: #1976d2; }
        .bg-green { background-color: #e8f5e9; color: #388e3c; }

        /* Content Sections */
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .section-header{display:none}

        .section-title {
            font-size: 1.5rem;
            color: var(--primary-blue);
            font-weight: 700;
            margin: 0;
        }
        .status-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;font-size:.78rem;font-weight:700}
        .status-enrolled{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0}
        .status-pending{background:#fff7ed;color:#9a3412;border:1px solid #fed7aa}

        /* Course List */
        .course-grid{
            display:grid;
            grid-template-columns:repeat(4, minmax(0, 1fr));
            gap:24px;
            align-items:stretch;
        }
        @media (max-width:1100px){ .course-grid{grid-template-columns:repeat(2, minmax(0,1fr));} }
        @media (max-width:700px){ .course-grid{grid-template-columns:1fr;} }

        .course-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 22px rgba(0,0,0,0.06);
            border: 1px solid #e9edf5;
            transition: transform .2s ease, box-shadow .2s ease;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        }

        .course-image {
            background-color: #eef2f7;
            background-size: cover;
            background-position: center;
            aspect-ratio: 16/9;
            width: 100%;
            position: relative;
        }
        .course-image::after{
            content:"";
            position:absolute;
            inset:0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 60%, rgba(0,0,0,.05) 100%);
            pointer-events:none;
        }

        .course-content {
            padding: 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-blue);
            letter-spacing: -0.01em;
        }

        .course-desc {
            color: var(--light-text);
            font-size: 0.95rem;
            line-height: 1.55;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3.6em;
        }

        .course-footer{margin-top:auto;display:flex;justify-content:center;align-items:center;padding-top:12px;gap:10px;flex-wrap:wrap}
        .course-footer span{
            display:inline-flex;
            align-items:center;
            gap:6px;
            background:#f0f4ff;
            color:#1e40af;
            border:1px solid #dbeafe;
            border-radius:20px;
            padding:5px 12px;
            font-weight:600;
            font-size:.75rem;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .btn-view{display:inline-flex;align-items:center;justify-content:center;padding:10px 20px;background-color:var(--primary-blue);color:#fff;text-decoration:none;border-radius:999px;font-size:.9rem;transition:all .2s ease;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06);font-weight:700;white-space:nowrap;min-width:120px;max-width:100%;text-align:center}

        .btn-view:hover{background-color:#001f54;transform:translateY(-1px);box-shadow:0 10px 18px rgba(0,44,118,.22)}
        @media (max-width:480px){.course-footer .btn-view{width:100%}}

        /* Course Tabs */
        .tab-btn {
            background: none;
            border: none;
            padding: 15px 25px;
            font-size: 1rem;
            color: var(--light-text);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: var(--primary-blue);
        }

        .tab-btn.active {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-blue);
        }

        .course-tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .course-tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sub Tabs */
        .sub-tab-btn {
            background: white;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--light-text);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sub-tab-btn:hover {
            background: #f8f9fa;
        }

        .sub-tab-btn.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .classwork-subtab {
            display: none;
        }

        .classwork-subtab.active {
            display: block;
        }

        /* People List */
        .person-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .person-item:last-child {
            border-bottom: none;
        }

        .person-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .person-info {
            flex: 1;
        }

        .person-name {
            font-weight: 500;
            color: var(--dark-text);
        }

        /* Course Detail View */
        .detail-hero {
            height: 300px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-bottom: 30px;
            position: relative;
        }

        .detail-content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            cursor: pointer;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }

        /* Action Buttons */
        .btn-action {
            background-color: var(--primary-green);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action:hover {
            background-color: #6da332;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f8f9fa;
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--primary-blue);
            font-weight: 700;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-text);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: inherit;
        }

        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-with-icon i {
            position: absolute;
            left: 12px;
            color: #94a3b8;
        }

        .input-with-icon input {
            padding-left: 35px !important;
        }

        .btn-cancel {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background-color: #e2e8f0;
        }

        .btn-save {
            background-color: #0f3b8f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-save:hover {
            background-color: #0b2c74;
            transform: translateY(-1px);
        }

        .form-footer {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Calendar Styles */
        .calendar-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eef2f7;
        }
        
        .calendar-month-year {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary-blue);
            letter-spacing: -.02em;
        }
        
        .calendar-nav-btn {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            font-size: 1rem;
            color: #0f172a;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all .2s ease;
        }
        
        .calendar-nav-btn:hover {
            background-color: #e2e8f0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #eef2f7;
            border-left: 1px solid #eef2f7;
        }

        .calendar-day-header {
            padding: 12px;
            text-align: center;
            font-weight: 700;
            background-color: #fff;
            border-right: 1px solid #eef2f7;
            border-bottom: 1px solid #eef2f7;
            color: #374151;
            text-transform: uppercase;
            font-size: .75rem;
        }

        .calendar-day {
            min-height: 120px;
            padding: 10px;
            border-right: 1px solid #eef2f7;
            border-bottom: 1px solid #eef2f7;
            position: relative;
            background: white;
            transition: background-color 0.2s, box-shadow .2s ease;
        }

        .calendar-day:hover {
            background-color: #f8fafc;
            box-shadow: inset 0 0 0 2px rgba(0,44,118,.08);
        }

        .calendar-day.empty {
            background-color: #fcfcfc;
        }

        .calendar-day.today {
            background: linear-gradient(180deg,#fff9c4 0%, #fffde7 100%);
            box-shadow: inset 0 0 0 2px #fde68a;
        }

        .day-number {
            font-size: 0.9rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: #111827;
        }

        .event-badge {
            display: block;
            background-color: var(--primary-green);
            color: white;
            font-size: 0.72rem;
            padding: 6px 8px;
            border-radius: 999px;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,.06);
            border: 1px solid rgba(255,255,255,.6);
        }
        .event-badge:hover{filter:brightness(.95)}
        .calendar-legend{display:flex;gap:8px;align-items:center}
        .legend-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;border:1px solid #e5e7eb;background:#f8fafc;font-size:.78rem;font-weight:700;color:#374151}
        .legend-dot{width:10px;height:10px;border-radius:50%}

        @media (max-width: 992px) {
            body {
                height: auto;
                min-height: 100vh;
                overflow-x: hidden;
                overflow-y: auto;
            }

            .header {
                height: auto;
                padding: 12px 14px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .header-logo {
                height: 38px;
                margin-right: 10px;
            }

            .header-title img {
                height: 36px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
            }

            .notification-dropdown {
                width: min(92vw, 320px);
                right: 0;
                left: auto;
            }

            .dashboard-container {
                flex-direction: column;
                overflow: visible;
            }

            .sidebar,
            .sidebar.collapsed {
                width: 100%;
                max-width: 100%;
            }

            .sidebar-toggle {
                display: none;
            }

            .nav-menu {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
            }

            .nav-item {
                flex: 0 0 auto;
                border-bottom: none;
            }

            .nav-link {
                padding: 12px 14px;
            }

            .sidebar.collapsed .nav-text {
                display: inline;
            }

            .sidebar.collapsed .nav-link {
                justify-content: flex-start;
                padding: 12px 14px;
            }

            .sidebar.collapsed .nav-icon {
                margin-right: 12px;
            }

            .main-content {
                padding: 16px;
                overflow: visible;
            }

            .section-header {
                flex-wrap: wrap;
                gap: 10px;
            }

            .control-hero{padding:24px 20px}
            .control-hero-top{margin-bottom:18px}
            .control-hero-title{font-size:1.7rem}
            .hero-stat-card{padding:18px}
            .course-grid{gap:18px;grid-template-columns:repeat(2,minmax(0,1fr))}
            .course-card{border-radius:14px}
            .course-image{aspect-ratio:16/9}
            .course-title{font-size:1.15rem}
            .course-desc{-webkit-line-clamp:3}

            .detail-content {
                padding: 18px;
            }

            .calendar-container {
                overflow-x: auto;
            }

            .calendar-grid {
                min-width: 680px;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 720px;
            }

            .modal-container {
                width: min(94vw, 560px);
                padding: 18px;
            }

            .content-section [style*="grid-template-columns: 1fr 1fr"],
            .content-section [style*="grid-template-columns: 1fr 1fr 1fr"],
            .content-section [style*="grid-template-columns: 1fr 2fr"] {
                grid-template-columns: 1fr !important;
            }

            .content-section [style*="display: flex"][style*="justify-content: space-between"] {
                flex-wrap: wrap !important;
                gap: 10px !important;
            }
        }

        #profile-section .profile-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        #profile-section .profile-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        #profile-section .profile-page-title {
            margin: 0;
            font-size: 2rem;
            color: var(--primary-blue);
            letter-spacing: -0.02em;
        }

        #profile-section .profile-page-subtitle {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 0.95rem;
            max-width: 560px;
        }

        #profile-section .profile-page-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
        }

        #profile-section .profile-page-btn {
            border: 1px solid transparent;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12);
        }

        #profile-section .profile-page-btn:active {
            transform: translateY(1px);
            box-shadow: 0 3px 8px rgba(15, 23, 42, 0.14);
        }

        #profile-section .profile-page-btn.edit {
            background: #fff7ed;
            color: #9a3412;
            border-color: #fed7aa;
        }

        #profile-section .profile-page-btn.cancel {
            background: #f1f5f9;
            color: #475569;
            border-color: #e2e8f0;
        }

        #profile-section .profile-page-btn.save {
            background: var(--primary-green);
            color: #ffffff;
        }

        #profile-section .profile-page-btn.save:hover {
            background: #6aa832;
        }

        #profile-section .profile-page-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.92rem;
        }

        #profile-section .profile-page-alert.error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
            align-items: flex-start;
        }

        #profile-section .profile-page-alert.error ul {
            margin: 0;
            padding-left: 18px;
        }

        #profile-section .profile-page-banner {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: radial-gradient(circle at top left, rgba(127, 183, 61, 0.12), transparent 50%),
                        radial-gradient(circle at top right, rgba(0, 44, 118, 0.12), transparent 48%),
                        #ffffff;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }

        #profile-section .profile-page-avatar {
            width: 92px;
            height: 92px;
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 3px solid #ffffff;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.18);
        }

        #profile-section .profile-page-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #profile-section .profile-page-identity {
            flex: 1;
            min-width: 0;
        }

        #profile-section .profile-page-name {
            font-size: 1.4rem;
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 6px;
        }

        #profile-section .profile-page-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            color: #475569;
            font-size: 0.9rem;
        }

        #profile-section .profile-page-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e8effd;
            color: #1e3a8a;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.68rem;
        }

        #profile-section .profile-page-upload {
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        #profile-section .profile-page-upload input[type="file"] {
            font-size: 0.82rem;
        }

        #profile-section .profile-page-upload input[type="file"]::file-selector-button {
            border: none;
            background: var(--primary-blue);
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 10px;
        }

        #profile-section .profile-page-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        #profile-section .profile-page-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.06);
        }

        #profile-section .profile-page-panel.account-panel {
            border-color: #d8e5ff;
            background: linear-gradient(160deg, #f7fbff 0%, #ffffff 58%);
        }

        #profile-section .profile-page-panel.location-panel {
            border-color: #dbead2;
            background: linear-gradient(160deg, #f8fcf5 0%, #ffffff 58%);
        }

        #profile-section .profile-page-panel-wide {
            grid-column: 1 / -1;
        }

        #profile-section .profile-page-panel-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 14px;
        }

        #profile-section .profile-page-panel-header-rich {
            margin-bottom: 16px;
            text-transform: none;
            letter-spacing: normal;
            align-items: flex-start;
        }

        #profile-section .profile-page-header-icon {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        #profile-section .profile-page-panel.account-panel .profile-page-header-icon {
            background: #e0ebff;
            color: #1d4ed8;
        }

        #profile-section .profile-page-panel.location-panel .profile-page-header-icon {
            background: #e3f2db;
            color: #2f7a15;
        }

        #profile-section .profile-page-header-icon .icon-feather {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        #profile-section .profile-page-panel-heading {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        #profile-section .profile-page-panel-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            line-height: 1.2;
        }

        #profile-section .profile-page-panel-note {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
            line-height: 1.2;
        }

        #profile-section .profile-page-panel.account-panel .form-group,
        #profile-section .profile-page-panel.location-panel .form-group {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 12px;
        }

        #profile-section .profile-page-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 16px;
        }

        #profile-section .profile-page-fields .form-group {
            margin-bottom: 0;
        }

        #profile-section .profile-page-fields label,
        #profile-section .profile-field-label {
            display: block;
            margin-bottom: 6px;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        #profile-section .profile-input {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d7e0ea;
            border-radius: 10px;
            box-sizing: border-box;
            background: #f8fafc;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        #profile-section .profile-input:focus {
            outline: none;
            border-color: #2f5aa8;
            box-shadow: 0 0 0 3px rgba(47, 90, 168, 0.15);
        }

        #profile-section .profile-input[readonly],
        #profile-section .profile-input:disabled {
            background: #f1f5f9;
            color: #475569;
            cursor: not-allowed;
        }

        #profile-section .profile-page-help {
            color: #64748b;
            font-size: 0.8rem;
            display: block;
            margin-top: 6px;
        }

        @media (max-width: 1100px) {
            #profile-section .profile-page-grid {
                grid-template-columns: 1fr;
            }

            #profile-section .profile-page-fields {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            #profile-section .profile-page-banner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

    </style>
</head>
<body>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="header-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div id="header-section-title" class="header-section-title">Dashboard</div>
        </div>
        <div class="header-right">
            <!-- Notification Bell -->
            <div class="notification-container">
                <div class="notification-bell {{ (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0) ? 'bell-shake' : '' }}" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="notification-badge">{{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}</span>
                    @endif
                </div>
                
                <div id="notificationDropdown" class="notification-dropdown">
                    <div class="notification-header">
                        <div class="notification-header-top">
                            <span class="notification-header-title">Notifications</span>
                            <span class="mark-all-read" onclick="markAllAsRead()">Mark all as read</span>
                        </div>
                        <div class="notification-header-subtitle">Stay updated with your assigned courses and activities.</div>
                    </div>
                    <div class="notification-list" id="notificationList">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                                @php
                                    $iconClass = 'icon-default';
                                    $icon = 'fa-bell';
                                    
                                    if (str_contains(strtolower($notification->title), 'course')) {
                                        $iconClass = 'icon-course'; $icon = 'fa-book';
                                    } elseif (str_contains(strtolower($notification->title), 'student') || str_contains(strtolower($notification->title), 'enrolled')) {
                                        $iconClass = 'icon-student'; $icon = 'fa-user-graduate';
                                    } elseif (str_contains(strtolower($notification->title), 'assessment') || str_contains(strtolower($notification->title), 'submitted')) {
                                        $iconClass = 'icon-assessment'; $icon = 'fa-file-alt';
                                    } elseif (str_contains(strtolower($notification->title), 'session') || str_contains(strtolower($notification->title), 'calendar')) {
                                        $iconClass = 'icon-calendar'; $icon = 'fa-calendar-alt';
                                    } elseif (str_contains(strtolower($notification->title), 'announcement')) {
                                        $iconClass = 'icon-announcement'; $icon = 'fa-bullhorn';
                                    }
                                @endphp
                                <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}" onclick="markAsRead('{{ $notification->id }}', '{{ $notification->link }}')">
                                    <div class="notification-icon {{ $iconClass }}">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-item-title">{{ $notification->title }}</div>
                                        <div class="notification-item-message">{{ $notification->message }}</div>
                                        <div class="notification-item-time">
                                            <i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    @if(!$notification->is_read)
                                        <div class="unread-indicator"></div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="far fa-bell-slash"></i></div>
                                <div class="empty-state-text">No new notifications yet.</div>
                            </div>
                        @endif
                    </div>
                    <div class="notification-footer">
                        <a href="{{ route('dashboard', ['tab' => 'notifications']) }}" class="view-all-link">View All Notifications</a>
                    </div>
                </div>
            </div>

            <div class="profile-menu">
                <div class="profile-trigger" onclick="toggleProfileMenu()">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Profile" style="width:35px;height:35px;border-radius:50%;object-fit:cover" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
                    @else
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U',0,1)) }}
                        </div>
                    @endif
                    <i class="fas fa-chevron-down profile-caret"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <div class="dropdown-meta">
                        <div class="dropdown-meta-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-meta-role">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile.setup') }}">
                        <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard', ['tab' => 'help-support']) }}">
                        <i class="fas fa-life-ring"></i> <span>Help & Support</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="dropdown-item danger" style="width:100%;background:none;border:none;text-align:left;">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
            </div>
            <ul class="nav-menu">
                @php
                    $coachCreateCourseActive = request()->routeIs('trainer.courses.create');
                    $coachCreateCourseVisible = strtolower((string) Auth::user()->role) === 'coach'
                        && Auth::user()->hasPermission('add_courses_coach');
                    $portalActive = $coachCreateCourseActive
                        || !request('tab')
                        || in_array(request('tab'), ['dashboard-home','my-courses','calendar','announcements'], true);
                @endphp
                <li class="nav-portal {{ $portalActive ? 'open' : '' }}" id="portal-dropdown-coach">
                    <a href="#" class="nav-link nav-portal-toggle {{ $portalActive ? 'active' : '' }}" onclick="togglePortalDropdown(event,'portal-dropdown-coach')">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span class="nav-text">Coach Portal</span>
                        <span class="nav-chevron"></span>
                    </a>
                    <ul class="nav-portal-list" id="portal-dropdown-list-coach">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ (!request('tab') && ! $coachCreateCourseActive) || request('tab') === 'dashboard-home' ? 'active' : '' }}" onclick="showContent('dashboard-home', this)">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        @if(Auth::user()->hasPermission('view_courses_coach'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['tab' => 'my-courses']) }}" class="nav-link {{ request('tab') === 'my-courses' ? 'active' : '' }}" onclick="showContent('my-courses', this)">
                                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                <span class="nav-text">My Courses</span>
                            </a>
                        </li>
                        @endif
                        @if($coachCreateCourseVisible)
                        <li class="nav-item">
                            <a href="{{ route('trainer.courses.create') }}" class="nav-link {{ $coachCreateCourseActive ? 'active' : '' }}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <span class="nav-text">Create Course</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_classes'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['tab' => 'calendar']) }}" class="nav-link {{ request('tab') === 'calendar' ? 'active' : '' }}" onclick="showContent('calendar', this)">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <span class="nav-text">Calendar</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_communication'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['tab' => 'announcements']) }}" class="nav-link {{ request('tab') === 'announcements' ? 'active' : '' }}" onclick="showContent('announcements', this)">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <span class="nav-text">Announcements</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @if(Auth::user()->role !== 'super_admin' && Auth::user()->hasPermission('view_modules'))
                <li class="nav-portal" id="portal-dropdown-participant">
                    <a href="#" class="nav-link nav-portal-toggle" onclick="togglePortalDropdown(event,'portal-dropdown-participant')">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span class="nav-text">Participant Portal</span>
                        <span class="nav-chevron"></span>
                    </a>
                    <ul class="nav-portal-list" id="portal-dropdown-list-participant">
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'participant']) }}" class="nav-link">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'classroom']) }}" class="nav-link">
                                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                <span class="nav-text">Classroom</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'calendar']) }}" class="nav-link">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <span class="nav-text">Calendar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'announcements']) }}" class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <span class="nav-text">Announcements</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->role !== 'super_admin' && (Auth::user()->hasPermission('view_training') || Auth::user()->hasPermission('view_users_tm') || Auth::user()->hasPermission('update_users_tm')))
                <li class="nav-portal" id="portal-dropdown-tm">
                    <a href="#" class="nav-link nav-portal-toggle" onclick="togglePortalDropdown(event,'portal-dropdown-tm')">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span class="nav-text">Training Manager Portal</span>
                        <span class="nav-chevron"></span>
                    </a>
                    <ul class="nav-portal-list" id="portal-dropdown-list-tm">
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'tm']) }}" class="nav-link">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(
                    Auth::user()->hasPermission('view_users')
                    || Auth::user()->hasPermission('create_users')
                    || Auth::user()->hasPermission('edit_users')
                    || Auth::user()->hasPermission('delete_users')
                    || Auth::user()->hasPermission('view_monitoring')
                    || Auth::user()->hasPermission('view_access_control')
                    || Auth::user()->hasPermission('edit_access_control')
                )
                <li class="nav-portal" id="portal-dropdown-admin">
                    <a href="#" class="nav-link nav-portal-toggle" onclick="togglePortalDropdown(event,'portal-dropdown-admin')">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span class="nav-text">Admin Portal</span>
                        <span class="nav-chevron"></span>
                    </a>
                    <ul class="nav-portal-list" id="portal-dropdown-list-admin">
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'admin']) }}" class="nav-link">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        @if(Auth::user()->hasPermission('view_users'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'user-management']) }}" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <span class="nav-text">User Management</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_courses'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'course-management']) }}" class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <span class="nav-text">Course Management</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_certifications'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'certification-management']) }}" class="nav-link">
                                <i class="fas fa-certificate nav-icon"></i>
                                <span class="nav-text">Certifications</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 'super_admin')
                        <li class="nav-item">
                            <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'access-management']) }}" class="nav-link">
                                <i class="fas fa-shield-alt nav-icon"></i>
                                <span class="nav-text">Access Control</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Dashboard Home Section -->
            <div id="dashboard-home" class="content-section {{ request('tab') ? '' : 'active' }}">
                {{-- Legacy session filter block kept temporarily during move; hidden intentionally. --}}
                @if(false)
                <!-- Academic Year Selector -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; background: #fff; padding: 12px 20px; border-radius: 16px; border: 1px solid #e5eef7; box-shadow: 0 4px 15px rgba(0,44,118,0.03);">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); color: #002C76; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 2px;">Session Filter</div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 1.1rem; font-weight: 800; color: #002C76; letter-spacing: -0.01em;">
                                    Academic Year {{ $selectedYear ? $selectedYear->year_start . ' – ' . $selectedYear->year_end : 'N/A' }}
                                </span>
                                @if($selectedYear && $selectedYear->is_active)
                                    <span style="background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 800; border: 1px solid #bbf7d0;">ACTIVE</span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 800; border: 1px solid #e2e8f0;">INACTIVE</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @php
                            $academicYears = $academicYears ?? collect();
                            $currentIndex = $academicYears->search(fn($ay) => $ay->id == $selectedYearId);
                            $prevYear = $currentIndex !== false && $currentIndex < $academicYears->count() - 1 ? $academicYears[$currentIndex + 1] : null;
                            $nextYear = $currentIndex !== false && $currentIndex > 0 ? $academicYears[$currentIndex - 1] : null;
                        @endphp
                        
                        <a href="{{ $prevYear ? route('dashboard', ['academic_year_id' => $prevYear->id]) : '#' }}" 
                           class="btn" 
                           title="Previous Year"
                           style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: {{ $prevYear ? '#f1f5f9' : 'transparent' }}; border: {{ $prevYear ? '1px solid #e2e8f0' : 'none' }}; color: {{ $prevYear ? '#002C76' : '#cbd5e1' }}; {{ !$prevYear ? 'cursor: not-allowed;' : '' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        
                        <div style="position: relative;">
                            <select onchange="window.location.href='{{ route('dashboard') }}?academic_year_id=' + this.value" 
                                    style="appearance: none; background: transparent; border: none; padding: 0 25px 0 10px; height: 36px; font-weight: 700; color: #002C76; cursor: pointer; outline: none; min-width: 140px; font-size: 0.9rem;">
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $ay->id == $selectedYearId ? 'selected' : '' }}>
                                        {{ $ay->year_start }} – {{ $ay->year_end }} {{ $ay->is_active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b; font-size: 0.7rem;"></i>
                        </div>

                        <a href="{{ $nextYear ? route('dashboard', ['academic_year_id' => $nextYear->id]) : '#' }}" 
                           class="btn" 
                           title="Next Year"
                           style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: {{ $nextYear ? '#f1f5f9' : 'transparent' }}; border: {{ $nextYear ? '1px solid #e2e8f0' : 'none' }}; color: {{ $nextYear ? '#002C76' : '#cbd5e1' }}; {{ !$nextYear ? 'cursor: not-allowed;' : '' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                @endif
                @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif

                <div class="control-hero">
                    <div class="control-hero-top">
                        <div class="control-hero-left">
                            <div class="control-hero-badge"><i class="fas fa-chalkboard-teacher"></i></div>
                            <div>
                                <h1 class="control-hero-title">Welcome, {{ Auth::user()->name }}</h1>
                                <div class="control-hero-sub">Monitor learning outcomes and efficiently manage classes.</div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-stats-grid">
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-book-open"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $totalCoursesTeaching }}</span>
                                <span class="hero-stat-label">Courses Teaching</span>
                            </div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-user-graduate"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $totalStudents }}</span>
                                <span class="hero-stat-label">Total Students</span>
                            </div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-calendar-check"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ isset($calendarEvents) ? $calendarEvents->count() : 0 }}</span>
                                <span class="hero-stat-label">Upcoming Events</span>
                            </div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-bell"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }}</span>
                                <span class="hero-stat-label">New Notifications</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course List (Shortcut) -->
                <div class="section-header">
                    <h2 class="section-title">Dashboard</h2>
                </div>

                <!-- Academic Year Selector -->
                @php
                    $academicYears = $academicYears ?? collect();
                    $currentIndex = $academicYears->search(fn($ay) => $ay->id == $selectedYearId);
                    $prevYear = $currentIndex !== false && $currentIndex < $academicYears->count() - 1 ? $academicYears[$currentIndex + 1] : null;
                    $nextYear = $currentIndex !== false && $currentIndex > 0 ? $academicYears[$currentIndex - 1] : null;
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin:4px 0 18px;background:#fff;padding:12px 20px;border-radius:16px;border:1px solid #e5eef7;box-shadow:0 4px 15px rgba(0,44,118,0.03);">
                    <div style="display:flex;align-items:center;gap:16px;flex:1;min-width:260px;">
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 100%);color:#002C76;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:inset 0 2px 4px rgba(0,0,0,0.02);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:2px;">Session Filter</div>
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                <span style="font-size:1.1rem;font-weight:800;color:#002C76;letter-spacing:-0.01em;">
                                    Academic Year {{ $selectedYear ? $selectedYear->year_start . ' – ' . $selectedYear->year_end : 'N/A' }}
                                </span>
                                @if($selectedYear && $selectedYear->is_active)
                                    <span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:999px;font-size:0.7rem;font-weight:800;border:1px solid #bbf7d0;">ACTIVE</span>
                                @else
                                    <span style="background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:999px;font-size:0.7rem;font-weight:800;border:1px solid #e2e8f0;">INACTIVE</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;">
                        <a href="{{ $prevYear ? route('dashboard', ['academic_year_id' => $prevYear->id]) : '#' }}"
                           class="btn"
                           title="Previous Year"
                           style="width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:10px;background:{{ $prevYear ? '#f1f5f9' : 'transparent' }};border:{{ $prevYear ? '1px solid #e2e8f0' : 'none' }};color:{{ $prevYear ? '#002C76' : '#cbd5e1' }};{{ !$prevYear ? 'cursor: not-allowed;' : '' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>

                        <div style="position:relative;">
                            <select onchange="window.location.href='{{ route('dashboard') }}?academic_year_id=' + this.value"
                                    style="appearance:none;background:transparent;border:none;padding:0 25px 0 10px;height:36px;font-weight:700;color:#002C76;cursor:pointer;outline:none;min-width:140px;font-size:0.9rem;">
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $ay->id == $selectedYearId ? 'selected' : '' }}>
                                        {{ $ay->year_start }} – {{ $ay->year_end }} {{ $ay->is_active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);pointer-events:none;color:#64748b;font-size:0.7rem;"></i>
                        </div>

                        <a href="{{ $nextYear ? route('dashboard', ['academic_year_id' => $nextYear->id]) : '#' }}"
                           class="btn"
                           title="Next Year"
                           style="width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:10px;background:{{ $nextYear ? '#f1f5f9' : 'transparent' }};border:{{ $nextYear ? '1px solid #e2e8f0' : 'none' }};color:{{ $nextYear ? '#002C76' : '#cbd5e1' }};{{ !$nextYear ? 'cursor: not-allowed;' : '' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Assigned Courses by Training Manager -->
                <div style="background:white;border:1px solid #e9edf5;border-radius:14px;box-shadow:0 8px 22px rgba(0,0,0,.06);padding:18px;margin-bottom:18px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                        <h3 style="margin:0;color:#002C76;font-weight:800;letter-spacing:-.02em">Assigned Courses</h3>
                        <div style="color:#64748b;font-weight:700">{{ isset($myCourses) ? $myCourses->count() : 0 }} assigned</div>
                    </div>
                    <div class="course-grid" style="margin-top:12px">
                        @forelse($myCourses ?? collect() as $course)
                            @php
                                $courseImage = null;
                                if ($course->image_path) {
                                    $courseImage = $course->image_url;
                                }
                                if (!$courseImage) {
                                    $courseNameLower = strtolower($course->name);
                                    if (str_contains($courseNameLower, 'research')) {
                                        $courseImage = asset('images/Basic Research.png');
                                    } elseif (str_contains($courseNameLower, 'services') || str_contains($courseNameLower, 'facilities')) {
                                        $courseImage = asset('images/Basic Services.png');
                                    } elseif (str_contains($courseNameLower, 'nature') || str_contains($courseNameLower, 'types')) {
                                        $courseImage = asset('images/Nature and Types.png');
                                    } elseif (str_contains($courseNameLower, 'creation') || str_contains($courseNameLower, 'lgu')) {
                                        $courseImage = asset('images/Creation.png');
                                    } elseif (str_contains($courseNameLower, 'autonomy') || str_contains($courseNameLower, 'decentralization')) {
                                        $courseImage = asset('images/Local Autonomy.png');
                                    } else {
                                        $courseImage = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                    }
                                }
                                $participantRoles = ['trainee','participant','central_office_participants','regional_office_participants','provincial_office_participants'];
                                $studentsCount = $course->users ? $course->users->whereIn('role', $participantRoles)->count() : 0;
                            @endphp
                            <div class="course-card" style="cursor: pointer; position: relative;" role="link" tabindex="0" onclick="window.location.href='{{ route('trainer.courses.enter', $course) }}'" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();window.location.href='{{ route('trainer.courses.enter', $course) }}';}">
                                <div class="course-image">
                                    <img src="{{ $courseImage }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @if(!$course->trainer_ready)
                                        <div style="position: absolute; top: 12px; right: 12px; background: #f97316; color: white; padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i> Not Set
                                        </div>
                                    @endif
                                </div>
                                <div class="course-content">
                                    <div class="course-title">{{ $course->name }}</div>
                                    @php
                                        $subjectAreaText = trim((string) ($course->subject_area ?? ''));
                                    @endphp
                                    @if($subjectAreaText !== '')
                                        <div style="display:flex;align-items:center;gap:8px;margin:2px 0 8px;color:#475569;font-size:0.82rem;font-weight:700;">
                                            <i class="fas fa-layer-group" style="color:#94a3b8;"></i>
                                            <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($subjectAreaText, 70) }}</span>
                                        </div>
                                    @endif
                                    <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                    
                                    @if(!$course->trainer_ready)
                                        <div style="margin-top: 10px; padding: 8px 12px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                                            <i class="fas fa-info-circle" style="color: #ea580c; font-size: 0.9rem;"></i>
                                            <span style="color: #9a3412; font-size: 0.8rem; font-weight: 600;">This course is not yet configured.</span>
                                        </div>
                                    @endif

                                    <div class="course-footer">
                                         <div style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 999px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                             <i class="fas fa-users" style="font-size: 0.8rem;"></i>
                                             <span>{{ $studentsCount }} Students</span>
                                         </div>
                                         @if(!$course->trainer_ready)
                                             <button class="btn-view" onclick="event.stopPropagation(); openDurationModal({{ $course->id }}, '{{ $course->start_date ? $course->start_date->format('Y-m-d') : '' }}', '{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}')" style="background: #f97316; border-color: #f97316; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2); cursor: pointer; border-radius: 999px;">
                                                 <i class="fas fa-cog" style="margin-right: 4px;"></i> Set Up Now
                                             </button>
                                         @else
                                             <a class="btn-view" href="{{ route('trainer.courses.enter', $course) }}" onclick="event.stopPropagation();">Enter Class</a>
                                         @endif
                                     </div>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1/-1; text-align: center; padding: 24px; color: #6c757d;">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: 8px; opacity: 0.5;"></i>
                                <div>No assigned courses yet.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Removed Enrolled Courses (replaced by Assigned) -->
                <div style="display:none;background:white;border:1px solid #e9edf5;border-radius:14px;box-shadow:0 8px 22px rgba(0,0,0,.06);padding:18px;margin-bottom:18px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                        <h3 style="margin:0;color:#002C76;font-weight:800;letter-spacing:-.02em">Enrolled Courses</h3>
                        @php
                            // Filter active enrolled courses only
                            $activeEnrolled = $myCourses->filter(function($c) {
                                $u = $c->users->firstWhere('id', Auth::id());
                                return $u && ($u->pivot->status ?? 'active') === 'active';
                            });
                        @endphp
                        <div style="color:#64748b;font-weight:700">{{ $activeEnrolled->count() }} enrolled</div>
                    </div>
                    <div class="course-grid" style="margin-top:12px">
                    @forelse($activeEnrolled as $course)
                        @php
                            // Status is definitely active here due to filter
                            $myStatus = 'active';
                        @endphp
                        <div class="course-card" style="cursor: pointer; position: relative;" role="link" tabindex="0" onclick="window.location.href='{{ route('trainer.courses.enter', $course) }}'" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();window.location.href='{{ route('trainer.courses.enter', $course) }}';}">
                            @php
                                $courseImage = null;
                                if ($course->image_path) {
                                    $courseImage = $course->image_url;
                                }
                                if (!$courseImage) {
                                    // Fallback to local images based on course name
                                    $courseNameLower = strtolower($course->name);
                                    if (str_contains($courseNameLower, 'research')) {
                                        $courseImage = asset('images/Basic Research.png');
                                    } elseif (str_contains($courseNameLower, 'services') || str_contains($courseNameLower, 'facilities')) {
                                        $courseImage = asset('images/Basic Services.png');
                                    } elseif (str_contains($courseNameLower, 'nature') || str_contains($courseNameLower, 'types')) {
                                        $courseImage = asset('images/Nature and Types.png');
                                    } elseif (str_contains($courseNameLower, 'creation') || str_contains($courseNameLower, 'lgu')) {
                                        $courseImage = asset('images/Creation.png');
                                    } elseif (str_contains($courseNameLower, 'autonomy') || str_contains($courseNameLower, 'decentralization')) {
                                        $courseImage = asset('images/Local Autonomy.png');
                                    } else {
                                        $courseImage = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                    }
                                }
                            @endphp
                            <div class="course-image">
                                <img src="{{ $courseImage }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if(!$course->trainer_ready)
                                    <div style="position: absolute; top: 12px; right: 12px; background: #f97316; color: white; padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i> Not Set
                                    </div>
                                @endif
                            </div>
                            <div class="course-content">
                                    <div class="course-title">{{ $course->name }}</div>
                                    @php
                                        $subjectAreaText = trim((string) ($course->subject_area ?? ''));
                                    @endphp
                                    @if($subjectAreaText !== '')
                                        <div style="display:flex;align-items:center;gap:8px;margin:2px 0 8px;color:#475569;font-size:0.82rem;font-weight:700;">
                                            <i class="fas fa-layer-group" style="color:#94a3b8;"></i>
                                            <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($subjectAreaText, 70) }}</span>
                                        </div>
                                    @endif
                                    <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>

                                    @if(!$course->trainer_ready)
                                        <div style="margin-top: 10px; padding: 8px 12px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                                            <i class="fas fa-info-circle" style="color: #ea580c; font-size: 0.9rem;"></i>
                                            <span style="color: #9a3412; font-size: 0.8rem; font-weight: 600;">This course is not yet configured.</span>
                                        </div>
                                    @endif

                                <div class="course-footer">
                                    <span>
                                        <i class="fas fa-users"></i>
                                        @php
                                            $participantRoles = ['trainee','participant','central_office_participants','regional_office_participants','provincial_office_participants'];
                                            $studentsCount = $course->users
                                                ? $course->users->filter(fn($u)=>in_array($u->role, $participantRoles))->count()
                                                : 0;
                                        @endphp
                                        {{ $studentsCount }} Students
                                    </span>
                                    @if(!$course->trainer_ready)
                                         <button class="btn-view" onclick="event.stopPropagation(); openDurationModal({{ $course->id }}, '{{ $course->start_date ? $course->start_date->format('Y-m-d') : '' }}', '{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}')" style="background: #f97316; border-color: #f97316; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2); cursor: pointer; border-radius: 999px;">
                                             <i class="fas fa-cog" style="margin-right: 4px;"></i> Set Up Now
                                         </button>
                                     @else
                                         <a class="btn-view" href="{{ route('trainer.courses.enter', $course) }}" onclick="event.stopPropagation();">Enter Class</a>
                                     @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>You have not been assigned to any courses yet.</p>
                        </div>
                    @endforelse
                </div>
                </div>
            </div>
            @if(request('tab') == 'help-support' || request('tab') == 'help_support')
                @include('dashboard.help-support')
            @endif

            <!-- My Courses Section (Same as above but dedicated page) -->
            <div id="my-courses" class="content-section {{ request('tab') === 'my-courses' ? 'active' : '' }}">
                <div class="section-header">
                    <h2 class="section-title">Assigned Courses by the Training Manager</h2>
                </div>
                
                <div class="course-grid">
                    @forelse($myCourses as $course)
                        @php
                            // For coaches/trainers, once course is approved (unarchived), treat as active
                            $myStatus = 'active';
                        @endphp
                        <div class="course-card" style="cursor: pointer; position: relative;" role="link" tabindex="0" onclick="window.location.href='{{ route('trainer.courses.enter', $course) }}'" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();window.location.href='{{ route('trainer.courses.enter', $course) }}';}">
                            @php
                                $courseImage = null;
                                if ($course->image_path) {
                                    $courseImage = $course->image_url;
                                }
                                if (!$courseImage) {
                                    // Fallback to local images based on course name
                                    $courseNameLower = strtolower($course->name);
                                    if (str_contains($courseNameLower, 'research')) {
                                        $courseImage = asset('images/Basic Research.png');
                                    } elseif (str_contains($courseNameLower, 'services') || str_contains($courseNameLower, 'facilities')) {
                                        $courseImage = asset('images/Basic Services.png');
                                    } elseif (str_contains($courseNameLower, 'nature') || str_contains($courseNameLower, 'types')) {
                                        $courseImage = asset('images/Nature and Types.png');
                                    } elseif (str_contains($courseNameLower, 'creation') || str_contains($courseNameLower, 'lgu')) {
                                        $courseImage = asset('images/Creation.png');
                                    } elseif (str_contains($courseNameLower, 'autonomy') || str_contains($courseNameLower, 'decentralization')) {
                                        $courseImage = asset('images/Local Autonomy.png');
                                    } else {
                                        $courseImage = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                    }
                                }
                            @endphp
                            <div class="course-image">
                                <img src="{{ $courseImage }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if(!$course->trainer_ready)
                                    <div style="position: absolute; top: 12px; right: 12px; background: #f97316; color: white; padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 800; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i> Not Set
                                    </div>
                                @endif
                            </div>
                            <div class="course-content">
                                    <div class="course-title">{{ $course->name }}</div>
                                    <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>

                                    @if(!$course->trainer_ready)
                                        <div style="margin-top: 10px; padding: 8px 12px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                                            <i class="fas fa-info-circle" style="color: #ea580c; font-size: 0.9rem;"></i>
                                            <span style="color: #9a3412; font-size: 0.8rem; font-weight: 600;">This course is not yet configured.</span>
                                        </div>
                                    @endif

                                 <div class="course-footer">
                                     <div style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 999px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                         <i class="fas fa-users" style="font-size: 0.8rem;"></i>
                                         <span>{{ $studentsCount }} Students</span>
                                     </div>
                                     @if(!$course->trainer_ready)
                                         <button class="btn-view" onclick="event.stopPropagation(); openDurationModal({{ $course->id }}, '{{ $course->start_date ? $course->start_date->format('Y-m-d') : '' }}', '{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}')" style="background: #f97316; border-color: #f97316; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2); cursor: pointer; border-radius: 999px;">
                                             <i class="fas fa-cog" style="margin-right: 4px;"></i> Set Up Now
                                         </button>
                                     @else
                                         <a class="btn-view" href="{{ route('trainer.courses.enter', $course) }}" onclick="event.stopPropagation();">Enter Class</a>
                                     @endif
                                 </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #6c757d;">
                            <p>No courses found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Course Details View -->
            <div id="course-details-view" class="content-section">
                <div class="back-link" onclick="showContent('my-courses', document.querySelector('a[onclick*=\'my-courses\']'))">
                    <i class="fas fa-arrow-left"></i> &nbsp; Back to My Courses
                </div>

                <div class="detail-hero" id="detail-hero"></div>

                <div class="detail-content">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                        <div>
                            <span style="background-color: var(--primary-blue); color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; margin-bottom: 10px; display: inline-block;" id="detail-category-badge">Category</span>
                            <h1 id="detail-title" style="margin: 10px 0; color: var(--primary-blue);">Course Title</h1>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div style="border-bottom: 1px solid #ddd; margin-bottom: 30px; display: flex;">
                        <button class="tab-btn active" onclick="switchCourseTab('description')">Description</button>
                        <button class="tab-btn" onclick="switchCourseTab('classwork')">Classwork</button>
                        <button class="tab-btn" onclick="switchCourseTab('people')">People</button>
                        <button class="tab-btn" onclick="switchCourseTab('grades')">Grades</button>
                    </div>

                    <!-- Description Tab -->
                    <div id="tab-description" class="course-tab-content active">
                        <h3 style="color: var(--primary-blue);">About this Course</h3>
                        <p id="detail-description" style="line-height: 1.6; color: #555;">Course description goes here.</p>
                        
                        <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                                <div style="color: #777; font-size: 0.9rem; margin-bottom: 5px;">Subject Area</div>
                                <div style="font-weight: bold; color: var(--primary-blue);" id="detail-subject-area">Subject</div>
                            </div>
                        </div>
                    </div>

                    <!-- Classwork Tab -->
                    <div id="tab-classwork" class="course-tab-content">
                        <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                            <button class="sub-tab-btn active" onclick="switchClassworkSubTab('materials')">
                                <i class="fas fa-book"></i> Materials
                            </button>
                            <button class="sub-tab-btn" onclick="switchClassworkSubTab('assessments')">
                                <i class="fas fa-tasks"></i> Assessments
                            </button>
                        </div>

                        <!-- Materials Sub-Tab -->
                        <div id="subtab-materials" class="classwork-subtab active">
                            <button class="btn-action" onclick="openUploadModal()">
                                <i class="fas fa-plus"></i> Upload Material
                            </button>
                            
                            <div id="materials-list">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <!-- Assessments Sub-Tab -->
                        <div id="subtab-assessments" class="classwork-subtab">
                            <button class="btn-action" onclick="openCreateAssessmentModal()">
                                <i class="fas fa-plus"></i> Create Assessment
                            </button>
                            
                            <div id="assessments-list">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>

                    <!-- People Tab -->
                    <div id="tab-people" class="course-tab-content">
                        <h3 style="color: var(--primary-blue); border-bottom: 2px solid var(--primary-blue); padding-bottom: 10px; margin-bottom: 20px;">Teachers</h3>
                        <div id="people-teachers-list"></div>

                        <h3 style="color: var(--primary-blue); border-bottom: 2px solid var(--primary-blue); padding-bottom: 10px; margin-bottom: 20px; margin-top: 40px;">
                            Classmates (<span id="people-count">0</span>)
                        </h3>
                        <div id="people-students-list"></div>
                    </div>

                    <!-- Grades Tab -->
                    <div id="tab-grades" class="course-tab-content">
                        <div class="table-container">
                            <table id="grades-table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <!-- Assessment columns will be added dynamically -->
                                        <th>Total Score</th>
                                    </tr>
                                </thead>
                                <tbody id="grades-body">
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div id="calendar" class="content-section {{ request('tab') === 'calendar' ? 'active' : '' }}">
                <div class="section-header">
                    <h2 class="section-title">Calendar</h2>
                </div>
                
                <!-- Visual Calendar -->
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="calendar-nav-btn" onclick="prevMonth()"><i class="fas fa-chevron-left"></i></button>
                        <div class="calendar-month-year" id="calendar-month-year"></div>
                        <button class="calendar-nav-btn" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-legend" style="margin-bottom:12px">
                        <span class="legend-chip"><span class="legend-dot" style="background:#007bff"></span> Class</span>
                        <span class="legend-chip"><span class="legend-dot" style="background:#dc3545"></span> Deadline</span>
                        <span class="legend-chip"><span class="legend-dot" style="background:#28a745"></span> Event</span>
                    </div>
                    <div class="calendar-grid" id="calendar-grid">
                        <!-- Headers -->
                        <div class="calendar-day-header">Sun</div>
                        <div class="calendar-day-header">Mon</div>
                        <div class="calendar-day-header">Tue</div>
                        <div class="calendar-day-header">Wed</div>
                        <div class="calendar-day-header">Thu</div>
                        <div class="calendar-day-header">Fri</div>
                        <div class="calendar-day-header">Sat</div>
                        <!-- Days will be generated by JS -->
                    </div>
                </div>

                <!-- Event Creation Form -->
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
                    <form action="{{ route('trainer.calendar-events.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label class="form-label">Start Time</label>
                                <input type="datetime-local" name="start_time" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">End Time (Optional)</label>
                                <input type="datetime-local" name="end_time" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="event">Event</option>
                                    <option value="class">Class</option>
                                    <option value="deadline">Deadline</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn-action" style="margin-bottom: 0;">
                                <i class="fas fa-calendar-plus"></i> Add Event
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Upcoming Events List -->
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-blue);">Upcoming Events</h3>
                    @php
                        $manualEvents = $calendarEvents->filter(fn($e) => !empty($e->id));
                    @endphp
                    @if($manualEvents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar" style="font-size: 3rem; color: var(--primary-green); margin-bottom: 10px;"></i>
                            <h3>No Events Scheduled</h3>
                            <p style="color: #666;">Add events to display them here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($manualEvents as $event)
                                <div style="border-left: 4px solid var(--primary-green); background: #f9f9f9; padding: 15px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h4 style="margin: 0; color: var(--dark-text);">{{ $event->title }}</h4>
                                        <p style="margin: 5px 0 0; color: #666; font-size: 0.9rem;">
                                            <i class="fas fa-clock"></i> {{ $event->start_time->format('M d, Y h:i A') }}
                                            @if($event->end_time)
                                                - {{ $event->end_time->format('h:i A') }}
                                            @endif
                                            <span style="display: inline-block; background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; margin-left: 10px; text-transform: uppercase;">{{ $event->type }}</span>
                                        </p>
                                        @if($event->description)
                                            <p style="margin: 5px 0 0; color: #555; font-size: 0.9rem;">{{ $event->description }}</p>
                                        @endif
                                    </div>
                                    @if($event->id)
                                    <form action="{{ route('trainer.calendar-events.destroy', $event->id) }}" method="POST" data-confirm-message="Are you sure you want to delete this event?" data-confirm-title="Delete Event">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Announcements Section -->
            <div id="announcements" class="content-section {{ request('tab') === 'announcements' ? 'active' : '' }}">
                <div class="section-header">
                    <h2 class="section-title">Announcements</h2>
                </div>
                
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
                    <form action="{{ route('trainer.announcements.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn-action" style="margin-bottom: 0;">
                                <i class="fas fa-bullhorn"></i> Post Announcement
                            </button>
                        </div>
                    </form>
                </div>

                <div style="background: white; padding: 20px; border-radius: 16px; box-shadow: 0 10px 24px rgba(0,0,0,0.06); border:1px solid #e5e7eb;">
                    @if(session('success'))
                        <div style="background-color: #ecfdf3; color: #166534; padding: 12px 14px; border-radius: 12px; margin-bottom: 15px; border: 1px solid #bbf7d0; font-weight:600;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if($announcements->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-bullhorn" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                            <h3>No Announcements</h3>
                            <p style="color: #666;">Important updates will be posted here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($announcements as $a)
                                <div style="border-left: 4px solid var(--primary-blue); border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; background:#fff; box-shadow:0 6px 14px rgba(0,0,0,.05);">
                                    <div style="display: flex; justify-content: space-between; align-items: center; gap:12px; flex-wrap:wrap">
                                        <h3 style="margin: 0; color: var(--primary-blue); font-weight:800; letter-spacing:-.01em">{{ $a->title }}</h3>
                                        <span style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#374151;border:1px solid #e2e8f0;padding:6px 10px;border-radius:999px;font-size:.8rem;font-weight:700">{{ $a->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p style="margin-top: 10px; color: #444; white-space: pre-line; line-height:1.7">{{ $a->message }}</p>
                                    <div style="margin-top: 8px; color: #777; font-size: 0.85rem; display:flex; align-items:center; gap:8px;">
                                        <span style="display:inline-flex;align-items:center;gap:6px;background:#e8effd;color:#1e3a8a;border:1px solid #c7d2fe;padding:4px 10px;border-radius:999px;font-weight:700"><i class="fas fa-user"></i> {{ $a->user->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profile-section" class="content-section">
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="profile-page">
                        <div class="profile-page-header">
                            <div>
                                <h1 class="profile-page-title">My Profile</h1>
                                <p class="profile-page-subtitle">Keep your account information current and review your access details in one place.</p>
                            </div>
                        </div>

                        @if(session('success_profile'))
                            <div class="profile-page-alert">
                                <i class="fas fa-circle-check"></i>
                                <span>{{ session('success_profile') }}</span>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="profile-page-alert error">
                                <i class="fas fa-circle-exclamation"></i>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="profile-page-banner">
                            <div class="profile-page-avatar">
                                @php
                                    $avatarSrc = Auth::user()->profile_picture
                                        ? asset('storage/' . Auth::user()->profile_picture)
                                        : asset('images/user.png');
                                @endphp
                                <img id="profile_preview" src="{{ $avatarSrc }}" alt="Profile picture">
                            </div>
                            <div class="profile-page-identity">
                                <div class="profile-page-name">{{ Auth::user()->name }}</div>
                                <div class="profile-page-meta">
                                    <span class="profile-page-chip">{{ strtoupper(Auth::user()->role ?? '') }}</span>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                                <div id="profile_upload_container" class="profile-page-upload" style="display:none">
                                    <input type="hidden" name="profile_picture_cropped" id="profile_picture_cropped">
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" onchange="openCropperFromInput(this)">
                                    <span class="profile-page-help">PNG or JPEG only, up to 5 MB. Square crop works best.</span>
                                </div>
                            </div>
                        </div>

                        @php
                            $profileRegion = old('region', Auth::user()->region ?? '');
                            $profileProvince = old('province', Auth::user()->province ?? '');
                            $profileCity = old('city', Auth::user()->city ?? '');
                            $profileBarangay = old('barangay', Auth::user()->barangay ?? '');
                            $myRole = Auth::user()->role ?? '';
                            $centralRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                            $regionalRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                            $provincialRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                            $isCentral = in_array($myRole, $centralRoles, true);
                            $isRegional = in_array($myRole, $regionalRoles, true);
                            $isProvincial = in_array($myRole, $provincialRoles, true);
                            $labelRegion = ($isCentral || $isRegional || $isProvincial) ? 'Office Level' : 'Region';
                            $labelProvince = $isCentral ? 'Office Type' : ($isRegional ? 'Region' : ($isProvincial ? 'Office' : 'Province'));
                            $isBureau = is_string($profileProvince) && (stripos($profileProvince, 'bureau') !== false || strtolower($profileProvince) === 'bureau');
                            $labelCity = $isCentral ? ($isBureau ? 'Bureau' : 'Service') : 'City / Municipality';
                        @endphp
                        <div class="profile-page-grid">
                            <div class="profile-page-panel account-panel">
                                <div class="profile-page-panel-header profile-page-panel-header-rich">
                                    <span class="profile-page-header-icon" aria-hidden="true">
                                        <svg class="icon-feather" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"></circle><path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path></svg>
                                    </span>
                                    <div class="profile-page-panel-heading">
                                        <span class="profile-page-panel-title">Account</span>
                                        <span class="profile-page-panel-note">Identity and contact details</span>
                                    </div>
                                </div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label class="profile-field-label">Account ID</label>
                                        <div class="profile-input" style="display:flex;align-items:center;background:#f1f5f9;color:#475569;cursor:not-allowed;">{{ Auth::user()->status === 'pending' ? 'N/A' : (Auth::user()->account_id ?? 'N/A') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">Full Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">Email Address</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="profile-input">
                                    </div>
                                </div>
                            </div>

                            <div class="profile-page-panel location-panel">
                                <div class="profile-page-panel-header profile-page-panel-header-rich">
                                    <span class="profile-page-header-icon" aria-hidden="true">
                                        <svg class="icon-feather" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    </span>
                                    <div class="profile-page-panel-heading">
                                        <span class="profile-page-panel-title">Location</span>
                                        <span class="profile-page-panel-note">Assigned service area details</span>
                                    </div>
                                </div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label>{{ $labelRegion }}</label>
                                        <select id="profile_region" @if(!($isCentral || $isRegional || $isProvincial)) name="region" @endif class="profile-input" data-selected="{{ $profileRegion }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>
                                                {{ ($isCentral || $isRegional || $isProvincial) ? 'Select Level' : 'Select Region' }}
                                            </option>
                                            @if($profileRegion)
                                                <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" id="group_profile_region_actual" @if(!$isRegional) style="display:none" @endif>
                                        <label>Region</label>
                                        <select id="profile_region_actual" @if($isRegional) name="region" @endif class="profile-input" data-selected="{{ $isRegional ? $profileRegion : '' }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>Select Region</option>
                                        </select>
                                    </div>
                                    <div class="form-group" @if($isRegional) style="display:none" @endif>
                                        <label>{{ $labelProvince }}</label>
                                        <select id="profile_province" @if(!$isRegional) name="province" @endif class="profile-input" data-selected="{{ $profileProvince }}" disabled>
                                            <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>
                                                @if($isCentral) Select Office Type @elseif($isProvincial) Select Office @else Select Province @endif
                                            </option>
                                            @if($profileProvince)
                                                <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" @if($isRegional || $isProvincial) style="display:none" @endif>
                                        <label>{{ $labelCity }}</label>
                                        <select id="profile_city" @if(!($isRegional || $isProvincial)) name="city" @endif class="profile-input" data-selected="{{ $profileCity }}" disabled>
                                            <option value="" disabled {{ $profileCity ? '' : 'selected' }}>
                                                @if($isCentral) {{ $isBureau ? 'Select Bureau' : 'Select Service' }} @else Select City/Municipality @endif
                                            </option>
                                            @if($profileCity)
                                                <option value="{{ $profileCity }}" selected>{{ $profileCity }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    @if(!$isCentral)
                                        <div class="form-group" @if($isRegional || $isProvincial) style="display:none" @endif>
                                            <label>Barangay</label>
                                            <select id="profile_barangay" @if(!($isRegional || $isProvincial)) name="barangay" @endif class="profile-input" data-selected="{{ $profileBarangay }}" disabled>
                                                <option value="" disabled {{ $profileBarangay ? '' : 'selected' }}>Select Barangay</option>
                                                @if($profileBarangay)
                                                    <option value="{{ $profileBarangay }}" selected>{{ $profileBarangay }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" id="profile_barangay" name="barangay" value="">
                                    @endif
                                </div>
                            </div>

                            <div id="password_change_section" class="profile-page-panel profile-page-panel-wide" style="display: none;">
                                <div class="profile-page-panel-header">Security</div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="profile-input" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="profile-input" readonly>
                                    </div>
                                </div>
                                <div class="profile-page-help">Leave blank to keep your current password.</div>
                            </div>

                            <div class="profile-page-actions">
                                <button type="button" id="btnEditProfile" onclick="enableProfileEdit()" class="profile-page-btn edit">
                                    <i class="fas fa-pen"></i> Edit Profile
                                </button>
                                <button type="button" id="btnCancelProfile" onclick="cancelProfileEdit()" class="profile-page-btn cancel" style="display:none;">
                                    <i class="fas fa-xmark"></i> Cancel
                                </button>
                                <button type="submit" id="btnSaveProfile" class="profile-page-btn save" style="display:none;">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Set Course Duration Modal -->
    <div id="durationModal" class="modal-overlay">
        <div class="modal-container" style="max-width: 420px; border-radius: 16px; padding: 0; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-header" style="padding: 20px 24px; background: linear-gradient(180deg, #f8fbff 0%, #f3f7ff 100%); border-bottom: 1px solid #e2e8f0; margin-bottom: 0;">
                <h3 class="modal-title" style="font-size: 1.25rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-calendar-alt" style="color: #0f3b8f;"></i> Set Course Duration
                </h3>
                <button class="close-modal" onclick="closeDurationModal()" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; font-size: 1.1rem; color: #64748b; transition: all 0.2s;">&times;</button>
            </div>
            <form id="durationForm" method="POST" style="padding: 24px;">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label" style="font-weight: 700; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">Start Date</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-day"></i>
                        <input type="date" name="start_date" id="duration_start_date" class="form-control" required style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px; font-size: 1rem;">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 700; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">End Date</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-check"></i>
                        <input type="date" name="end_date" id="duration_end_date" class="form-control" required style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px; font-size: 1rem;">
                    </div>
                </div>
                <div class="form-footer" style="padding: 16px 24px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; margin: 0 -24px -24px -24px; display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn-cancel" onclick="closeDurationModal()">Cancel</button>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Material Modal -->
    <div id="uploadModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Upload Material</h3>
                <button class="close-modal" onclick="closeUploadModal()">&times;</button>
            </div>
            <form action="{{ route('trainer.upload-material') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" id="upload_course_id">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="form-footer">
                    <button type="button" class="logout-btn" style="background-color: #6c757d;" onclick="closeUploadModal()">Cancel</button>
                    <button type="submit" class="btn-action" style="margin-bottom: 0;">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Assessment Modal -->
    <div id="assessmentModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Create Assessment</h3>
                <button class="close-modal" onclick="closeAssessmentModal()">&times;</button>
            </div>
            <form action="{{ route('trainer.create-assessment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" id="assessment_course_id">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="seatwork">Seatwork</option>
                        <option value="quiz">Quiz</option>
                        <option value="exam">Exam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Due Date (Optional)</label>
                    <input type="datetime-local" name="due_date" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Attach File (Optional)</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="form-footer">
                    <button type="button" class="logout-btn" style="background-color: #6c757d;" onclick="closeAssessmentModal()">Cancel</button>
                    <button type="submit" class="btn-action" style="margin-bottom: 0;">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Enroll Confirmation Modal -->
    <div id="enrollModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Enrollment</h3>
                <button class="close-modal" onclick="closeEnrollModal()">&times;</button>
            </div>
            <div style="margin-bottom: 10px; color:#555" id="enrollModalMsg">Are you sure you want to enroll in this course?</div>
            <div class="form-footer">
                <button type="button" class="logout-btn" style="background-color:#d9534f" onclick="closeEnrollModal()">Cancel</button>
                <form id="enrollForm" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-action" style="margin-bottom:0;background-color:#0b57d0"><i class="fas fa-check"></i> Yes, Enroll</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const storageBaseUrl = "{{ asset('storage') }}";
        const myCourses = @json($myCourses);
        let currentCourseId = null;

        function showProfile() {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show profile section
            document.getElementById('profile-section').classList.add('active');
            
            // Deactivate all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
        }

        function enableProfileEdit() {
            document.getElementById('btnEditProfile').style.display = 'none';
            document.getElementById('btnCancelProfile').style.display = 'inline-block';
            document.getElementById('btnSaveProfile').style.display = 'inline-block';
            document.getElementById('profile_upload_container').style.display = 'block';
            document.getElementById('password_change_section').style.display = 'block';
            
            const inputs = document.querySelectorAll('.profile-input');
            inputs.forEach(input => {
                if (input.tagName === 'SELECT') {
                    input.disabled = false;
                    input.style.backgroundColor = 'white';
                    input.style.cursor = 'pointer';
                } else {
                    input.readOnly = false;
                    input.style.backgroundColor = 'white';
                    input.style.cursor = 'text';
                }
            });
            initProfileLocationDropdowns();
        }

        function cancelProfileEdit() {
            // Reload to reset everything including file inputs and previews
            window.location.reload();
        }

        var cropState = {}; var avatarCropper=null;
        function ensureCropperLoaded(){
            return new Promise(function(resolve){
                if(window.Cropper) return resolve();
                if(!document.getElementById('cropperjs-css')){
                    var l=document.createElement('link'); l.id='cropperjs-css'; l.rel='stylesheet'; l.href='https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css'; document.head.appendChild(l);
                }
                var existing=document.getElementById('cropperjs-js');
                if(existing){ existing.addEventListener('load', resolve); return; }
                var s=document.createElement('script'); s.id='cropperjs-js'; s.src='https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js'; s.onload=resolve; document.body.appendChild(s);
            });
        }
        async function openCropperFromInput(input){
            if(!(input.files&&input.files[0])) return;
            var file = input.files[0];
            var dataUrl = await loadOrientedDataURL(file, 2048);
            await ensureCropperLoaded();
            var modal=document.getElementById('cropModal');
            var img=document.getElementById('cropImg');
            img.onload=function(){
                if(avatarCropper){ try{ avatarCropper.destroy(); }catch(e){} }
                avatarCropper = new window.Cropper(img, { aspectRatio:1, viewMode:2, dragMode:'move', background:false, guides:true, autoCropArea:1, responsive:true, movable:true, zoomable:true, zoomOnWheel:true });
                var slider=document.getElementById('cropZoom'); if(slider){ slider.value=1; slider.oninput=function(){ if(avatarCropper){ avatarCropper.zoomTo(parseFloat(this.value)); } }; }
                modal.style.display='flex';
            };
            img.src=dataUrl;
        }
        async function loadOrientedDataURL(file, maxDim){
            if('createImageBitmap' in window){
                try{
                    const bmp = await createImageBitmap(file, { imageOrientation: 'from-image' });
                    const scale = Math.min(1, maxDim/Math.max(bmp.width,bmp.height));
                    const c=document.createElement('canvas'); c.width=Math.round(bmp.width*scale); c.height=Math.round(bmp.height*scale);
                    const ctx = c.getContext('2d'); ctx.imageSmoothingQuality='high'; ctx.drawImage(bmp,0,0,c.width,c.height);
                    return c.toDataURL('image/jpeg',0.92);
                }catch(e){}
            }
            const orientation = await readExifOrientation(file).catch(()=>1);
            const blobUrl = URL.createObjectURL(file);
            const im = await new Promise(function(res){ const t=new Image(); t.onload=function(){ res(t); }; t.src=blobUrl; });
            const iw=im.naturalWidth, ih=im.naturalHeight;
            const ratio=Math.min(1, maxDim/Math.max(iw,ih));
            let cw=Math.round(iw*ratio), ch=Math.round(ih*ratio);
            let c=document.createElement('canvas'), ctx=c.getContext('2d');
            if(orientation>=5 && orientation<=8){ c.width=ch; c.height=cw; } else { c.width=cw; c.height=ch; }
            ctx.imageSmoothingQuality='high';
            switch(orientation){
                case 2: ctx.translate(c.width,0); ctx.scale(-1,1); break;
                case 3: ctx.translate(c.width,c.height); ctx.rotate(Math.PI); break;
                case 4: ctx.translate(0,c.height); ctx.scale(1,-1); break;
                case 5: ctx.rotate(0.5*Math.PI); ctx.translate(0,-c.width); ctx.scale(1,-1); break;
                case 6: ctx.rotate(0.5*Math.PI); ctx.translate(0,-c.width); break;
                case 7: ctx.rotate(0.5*Math.PI); ctx.translate(c.height,-c.width); ctx.scale(-1,1); break;
                case 8: ctx.rotate(-0.5*Math.PI); ctx.translate(-c.height,0); break;
            }
            ctx.drawImage(im,0,0,cw,ch);
            URL.revokeObjectURL(blobUrl);
            return c.toDataURL('image/jpeg',0.92);
        }
        function readExifOrientation(file){
            return new Promise(function(resolve,reject){
                const fr=new FileReader();
                fr.onerror=reject;
                fr.onload=function(){
                    const view=new DataView(fr.result);
                    if(view.getUint16(0,false)!=0xFFD8) return resolve(1);
                    let offset=2, length=view.byteLength;
                    while(offset<length){
                        const marker=view.getUint16(offset,false); offset+=2;
                        if(marker==0xFFE1){
                            offset+=2;
                            if(view.getUint32(offset,false)!=0x45786966) return resolve(1);
                            offset+=6;
                            const little=view.getUint16(offset,false)==0x4949; offset+=2;
                            if(view.getUint16(offset,little)!=0x002A) return resolve(1); offset+=2;
                            let ifdOffset=view.getUint32(offset,little); offset=offset-4+ifdOffset;
                            const entries=view.getUint16(offset,little); offset+=2;
                            for(let i=0;i<entries;i++){
                                const tag=view.getUint16(offset,little);
                                if(tag==0x0112){ const val=view.getUint16(offset+8,little); return resolve(val); }
                                offset+=12;
                            }
                            break;
                        } else if((marker & 0xFF00)!=0xFF00){ break; } else { offset+=view.getUint16(offset,false); }
                    }
                    resolve(1);
                };
                fr.readAsArrayBuffer(file.slice(0,128*1024));
            });
        }
        function applyTransform(){}
        function cropStartDrag(ev){ cropState.dragging=true; cropState.startX=ev.clientX; cropState.startY=ev.clientY; ev.preventDefault(); }
        function cropDrag(ev){ if(!cropState.dragging) return; cropState.posX+=ev.clientX-cropState.startX; cropState.posY+=ev.clientY-cropState.startY; cropState.startX=ev.clientX; cropState.startY=ev.clientY; applyTransform(); }
        function cropEndDrag(){ cropState.dragging=false; }
        function cropZoomChange(v){ cropState.scale=parseFloat(v); applyTransform(); }
        function closeCropper(){ if(avatarCropper){ try{ avatarCropper.destroy(); }catch(e){} avatarCropper=null; } document.getElementById('cropModal').style.display='none'; }
        function applyCrop(){
            if(!avatarCropper) return;
            var c = avatarCropper.getCroppedCanvas({ width:512, height:512, imageSmoothingEnabled:true, imageSmoothingQuality:'high' });
            var dataUrl=c.toDataURL('image/jpeg',0.92);
            document.getElementById('profile_picture_cropped').value=dataUrl;
            var pv=document.getElementById('profile_preview'); var init=document.getElementById('profile_initials'); if(init) init.style.display='none';
            pv.src=dataUrl; pv.style.display='block';
            try{ document.getElementById('profile_picture_input').value=''; }catch(e){}
            closeCropper();
        }

        function toggleSidebar() {
            var s = document.getElementById('sidebar');
            var overlay = document.querySelector('.sidebar-overlay');
            var isMobile = window.innerWidth <= 992;

            if (isMobile) {
                s.classList.toggle('mobile-open');
                overlay.classList.toggle('mobile-open');
                return;
            }

            s.classList.toggle('collapsed');
            var collapsed = s.classList.contains('collapsed');
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            var logo = document.querySelector('.sidebar-logo');
            if (logo) {
                var full = logo.getAttribute('data-full-src');
                var small = logo.getAttribute('data-collapsed-src');
                logo.src = collapsed ? small : full;
            }
            if (collapsed) { document.querySelectorAll('.nav-portal').forEach(function(p){ p.classList.remove('open'); }); }
        }
        
        function togglePortalDropdown(ev, dropdownId){
            if(ev){ ev.preventDefault(); ev.stopPropagation(); }
            var s=document.getElementById('sidebar');
            if(s && s.classList.contains('collapsed')) return;
            var dd=document.getElementById(dropdownId || 'portal-dropdown-coach');
            if(!dd) return;
            dd.classList.toggle('open');
        }

        function initProfileLocationDropdowns() {
            const regionSelect = document.getElementById('profile_region');
            const regionActualSelect = document.getElementById('profile_region_actual');
            const provinceSelect = document.getElementById('profile_province');
            const citySelect = document.getElementById('profile_city');
            const barangaySelect = document.getElementById('profile_barangay');
            if (!regionSelect) return;
            if (regionSelect.dataset.initialized === 'true') return;
            regionSelect.dataset.initialized = 'true';

            const selectedRegion = regionSelect.dataset.selected || '';
            const selectedRegionActual = regionActualSelect?.dataset?.selected || '';
            const selectedProvince = provinceSelect.dataset.selected || '';
            const selectedCity = citySelect.dataset.selected || '';
            const selectedBarangay = barangaySelect.dataset.selected || '';
            const myRole = '{{ Auth::user()->role }}';
            const OFFICE_ROLES = {
                central: ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'],
                regional: ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'],
                provincial: ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants']
            };
            const IS_OFFICE = (role, group) => OFFICE_ROLES[group].includes(role);
            const isDILGMode = IS_OFFICE(myRole, 'central') || IS_OFFICE(myRole, 'regional') || IS_OFFICE(myRole, 'provincial');
            const BUREAUS = [
                'Bureau of Local Government Development','Bureau of Local Government Supervision','Bureau of Fire Protection',
                'Bureau of Jail Management and Penology','National Police Commission','Philippine National Police',
                'National Barangay Operations Office','Office of Project Development Services','Public Affairs and Communication Service'
            ];
            const SERVICES = [
                'Administrative Service','Financial and Management Service','Information Systems and Technology Management Service',
                'Internal Audit Service','Legal Service','Planning Service','Policy and Performance Monitoring Service','Local Government Capability Development Division'
            ];

            const resetSelect = (selectElement, placeholder) => { selectElement.innerHTML = `<option value="" disabled selected>${placeholder}</option>`; };
            const addFallbackOption = (selectElement, value, label = value) => { if (!value) return null; const o=document.createElement('option'); o.value=value; o.textContent=label; o.selected=true; selectElement.appendChild(o); return o; };
            function loadBarangays(cityCode, selectedBarangayValue = null) {
                resetSelect(barangaySelect, 'Select Barangay');
                if (!cityCode) { if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); return; }
                fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`).then(r=>r.json()).then(data=>{
                    data.sort((a,b)=>a.name.localeCompare(b.name)); let matched=false;
                    data.forEach(b=>{ const o=document.createElement('option'); o.value=b.name; o.textContent=b.name; if (selectedBarangayValue&&selectedBarangayValue===b.name){ o.selected=true; matched=true; } barangaySelect.appendChild(o); });
                    if (selectedBarangayValue && !matched) addFallbackOption(barangaySelect, selectedBarangayValue);
                }).catch(()=>{ if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); });
            }
            function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
                const url = isRegion ? `{{ url('/psgc/regions') }}/${code}/cities` : `{{ url('/psgc/provinces') }}/${code}/cities`;
                resetSelect(citySelect, 'Select City/Municipality'); resetSelect(barangaySelect, 'Select Barangay');
                fetch(url).then(r=>r.json()).then(data=>{
                    data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedCityCode=''; let matched=false;
                    data.forEach(c=>{ const o=document.createElement('option'); o.value=c.name; o.textContent=c.name; o.dataset.code=c.code; if (selectedCityValue&&selectedCityValue===c.name){ o.selected=true; selectedCityCode=c.code; matched=true; } citySelect.appendChild(o); });
                    if (selectedCityValue && !matched) addFallbackOption(citySelect, selectedCityValue);
                    if (selectedCityCode) loadBarangays(selectedCityCode, selectedBarangayValue); else if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                }).catch(()=>{ if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue); if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); });
            }
            function loadProvincesByRegion(regionCode, selectedProvinceValue = null, selectedCityValue = null, selectedBarangayValue = null) {
                resetSelect(provinceSelect, 'Select Province'); resetSelect(citySelect, 'Select City/Municipality'); resetSelect(barangaySelect, 'Select Barangay');
                if (!regionCode) { if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue); if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue); if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); return; }
                fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`).then(r=>r.json()).then(data=>{
                    data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedProvinceCode=''; let matched=false;
                    data.forEach(p=>{ const o=document.createElement('option'); o.value=p.name; o.textContent=p.name; o.dataset.code=p.code; if (selectedProvinceValue&&selectedProvinceValue===p.name){ o.selected=true; selectedProvinceCode=p.code; matched=true; } provinceSelect.appendChild(o); });
                    if (selectedProvinceValue && !matched) addFallbackOption(provinceSelect, selectedProvinceValue);
                    if (selectedProvinceCode) fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                }).catch(()=>{ if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue); if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue); if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); });
            }
            regionSelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; loadProvincesByRegion(code); });
            provinceSelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; const isRegion=this.options[this.selectedIndex]?.dataset?.isRegion==='true'; if (!code){ resetSelect(citySelect,'Select City/Municipality'); resetSelect(barangaySelect,'Select Barangay'); return; } fetchCities(code, isRegion); });
            citySelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; loadBarangays(code); });

            if (isDILGMode) {
                const regionLabel = IS_OFFICE(myRole,'central') ? 'DILG Central Office' : (IS_OFFICE(myRole,'regional') ? 'DILG Regional Office' : 'DILG Provincial Office');
                resetSelect(regionSelect,'Select Level'); const opt=document.createElement('option'); opt.value=regionLabel; opt.textContent=regionLabel; opt.selected=true; opt.dataset.code='DILG'; regionSelect.appendChild(opt);
                const regionLabelNode = regionSelect.closest('.form-group')?.querySelector('label'); if (regionLabelNode) regionLabelNode.textContent = 'Office Level';
                const provLabelNode = provinceSelect.closest('.form-group')?.querySelector('label'); if (provLabelNode) provLabelNode.textContent = IS_OFFICE(myRole,'central') ? 'Office Type' : 'Office';
                const cityLabelNode = citySelect.closest('.form-group')?.querySelector('label');
                if (IS_OFFICE(myRole,'central')) {
                    let officeType = selectedProvince || '';
                    let officeItem = selectedCity || '';
                    if (officeType !== 'Bureau' && officeType !== 'Services') {
                        if (!officeItem && (BUREAUS.includes(officeType) || SERVICES.includes(officeType))) {
                            officeItem = officeType;
                            officeType = BUREAUS.includes(officeItem) ? 'Bureau' : 'Services';
                        } else if (officeItem) {
                            if (BUREAUS.includes(officeItem)) officeType = 'Bureau';
                            else if (SERVICES.includes(officeItem)) officeType = 'Services';
                        } else {
                            officeType = 'Services';
                        }
                    }
                    resetSelect(provinceSelect,'Select Office Type'); ['Bureau','Services'].forEach(lbl=>{ const o=document.createElement('option'); o.value=lbl; o.textContent=lbl; provinceSelect.appendChild(o); });
                    provinceSelect.addEventListener('change', function(){
                        const cat=this.value; if (cityLabelNode) cityLabelNode.textContent = cat==='Bureau' ? 'Bureau' : 'Service';
                        resetSelect(citySelect, cat==='Bureau' ? 'Select Bureau' : 'Select Service');
                        const list=cat==='Bureau'?BUREAUS:SERVICES; let matched=false;
                        list.forEach(item=>{ const o=document.createElement('option'); o.value=item; o.textContent=item; if (officeItem && officeItem===item){ o.selected=true; matched=true; } citySelect.appendChild(o); });
                        if (officeItem && !matched) addFallbackOption(citySelect, officeItem);
                        citySelect.disabled = provinceSelect.disabled;
                        const barangayGroup=barangaySelect.closest('.form-group'); if (barangayGroup) barangayGroup.style.display='none';
                    });
                    if (officeType) {
                        provinceSelect.value = officeType;
                        provinceSelect.dispatchEvent(new Event('change'));
                    }
                } else if (IS_OFFICE(myRole,'regional')) {
                    const regActualGroup = regionActualSelect?.closest('.form-group');
                    if (regActualGroup) regActualGroup.style.display = '';
                    [provinceSelect, citySelect, barangaySelect].forEach(s=>{ const g=s.closest('.form-group'); if (g) g.style.display='none'; });
                    if (regionActualSelect) {
                        regionActualSelect.innerHTML = '<option value="" disabled selected>Select Region</option>';
                        fetch(`{{ url('/psgc/regions') }}`)
                            .then(r=>r.json())
                            .then(data=>{
                                data.sort((a,b)=>a.name.localeCompare(b.name));
                                let matched=false;
                                data.forEach(reg=>{
                                    const o=document.createElement('option');
                                    o.value = reg.name; o.textContent = reg.name; o.dataset.code = reg.code;
                                    if (selectedRegionActual && selectedRegionActual === reg.name) { o.selected=true; matched=true; }
                                    regionActualSelect.appendChild(o);
                                });
                                if (selectedRegionActual && !matched) {
                                    const o=document.createElement('option');
                                    o.value = selectedRegionActual; o.textContent = selectedRegionActual; o.selected = true;
                                    regionActualSelect.appendChild(o);
                                }
                            })
                            .catch(()=>{
                                if (selectedRegionActual) {
                                    const o=document.createElement('option');
                                    o.value = selectedRegionActual; o.textContent = selectedRegionActual; o.selected = true;
                                    regionActualSelect.appendChild(o);
                                }
                            });
                    }
                } else if (IS_OFFICE(myRole,'provincial')) {
                    resetSelect(provinceSelect,'Select Office');
                    fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(async regions=>{
                        let items=[]; for (const reg of regions){ try{ const res=await fetch(`{{ url('/psgc/regions') }}/${reg.code}/provinces`); const data=await res.json(); items=items.concat(data.map(p=>({code:p.code,name:p.name}))); }catch(e){} }
                        items.sort((a,b)=>a.name.localeCompare(b.name)); let matched=false;
                        items.forEach(p=>{ const o=document.createElement('option'); o.value=`${p.name} Office`; o.textContent=`${p.name} Office`; o.dataset.code=p.code; if (selectedProvince && (selectedProvince===`${p.name} Office` || selectedProvince===p.name)){ o.selected=true; matched=true; } provinceSelect.appendChild(o); });
                        if (selectedProvince && !matched) addFallbackOption(provinceSelect, selectedProvince);
                    }).catch(()=>{ if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); });
                    [citySelect, barangaySelect].forEach(s=>{ const g=s.closest('.form-group'); if (g) g.style.display='none'; });
                }
                return;
            }
            fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(data=>{
                resetSelect(regionSelect,'Select Region'); data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedRegionCode=''; let matched=false;
                data.forEach(region=>{ const o=document.createElement('option'); o.value=region.name; o.textContent=region.name; o.dataset.code=region.code; if (selectedRegion&&selectedRegion===region.name){ o.selected=true; selectedRegionCode=region.code; matched=true; } regionSelect.appendChild(o); });
                if (selectedRegion && !matched) addFallbackOption(regionSelect, selectedRegion);
                if (selectedRegionCode) loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
                else { if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay); }
            }).catch(()=>{ if (selectedRegion) addFallbackOption(regionSelect, selectedRegion); if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay); });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initProfileLocationDropdowns();
        });

        function showContent(id, element) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(id).classList.add('active');

            if (element) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                element.classList.add('active');
            }
            var portal = element ? element.closest('.nav-portal') : null;
            if (portal) portal.classList.add('open');
            updateHeaderTitle(id);

            // Close sidebar on mobile
            if (window.innerWidth <= 992) {
                var s = document.getElementById('sidebar');
                var overlay = document.querySelector('.sidebar-overlay');
                if (s && s.classList.contains('mobile-open')) {
                    s.classList.remove('mobile-open');
                    overlay.classList.remove('mobile-open');
                }
            }
        }

        (function(){
            var modal=document.createElement('div');
            modal.id='cropModal';
            modal.style.cssText='position:fixed;inset:0;background:rgba(0,0,0,.6);display:none;align-items:center;justify-content:center;z-index:2000';
            modal.innerHTML='<div style="background:#fff;border-radius:12px;width:420px;max-width:95vw;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.2)">\
            <div style="font-weight:700;margin-bottom:8px">Crop Photo</div>\
            <div id="cropViewport" onmousedown="cropStartDrag(event)" onmousemove="cropDrag(event)" onmouseup="cropEndDrag()" onmouseleave="cropEndDrag()" style="width:320px;height:320px;margin:0 auto;border-radius:8px;overflow:hidden;background:#f3f4f6;position:relative">\
                <img id="cropImg" src="" style="position:absolute;top:50%;left:50%;transform:translate(0,0) scale(1);transform-origin:center center;user-select:none;pointer-events:none;">\
            </div>\
            <div style="display:flex;align-items:center;gap:12px;margin-top:10px">\
                <input id="cropZoom" type="range" min="0.5" max="3" step="0.01" value="1" oninput="cropZoomChange(this.value)" style="flex:1">\
                <button type="button" class="btn-view" onclick="closeCropper()">Cancel</button>\
                <button type="button" class="btn-view" style="background:#16a34a;border-color:#16a34a" onclick="applyCrop()">Apply</button>\
            </div></div>';
            document.addEventListener('DOMContentLoaded',function(){ document.body.appendChild(modal); });
        })();

        function openCourseDetails(courseId) {
            const course = myCourses.find(c => c.id === courseId);
            if (!course) return;

            currentCourseId = courseId;
            document.getElementById('upload_course_id').value = courseId;
            document.getElementById('assessment_course_id').value = courseId;

            // Populate Header & Description
            document.getElementById('detail-title').innerText = course.name;
            document.getElementById('detail-description').innerText = course.description;
            document.getElementById('detail-category-badge').innerText = course.subject_area || 'General';
            document.getElementById('detail-subject-area').innerText = course.subject_area || 'General';
            
            const hero = document.getElementById('detail-hero');
            hero.style.backgroundImage = `url('${course.image_url || "https://via.placeholder.com/800x300?text=No+Image"}')`;

            // Populate People
            renderPeople(course.users);

            // Populate Materials
            renderMaterials(course.materials);

            // Populate Assessments
            renderAssessments(course.assessments);

            // Populate Grades Table
            renderGrades(course);

            // Show View
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.getElementById('course-details-view').classList.add('active');
            
            switchCourseTab('description');
        }

        function renderPeople(users) {
            const teachersList = document.getElementById('people-teachers-list');
            const studentsList = document.getElementById('people-students-list');
            teachersList.innerHTML = '';
            studentsList.innerHTML = '';
            let studentCount = 0;

            if (users) {
                users.forEach(user => {
                    const initial = user.name.charAt(0).toUpperCase();
                    const item = `
                        <div class="person-item">
                            <div class="person-avatar">${initial}</div>
                            <div class="person-info">
                                <div class="person-name">${user.name}</div>
                            </div>
                        </div>
                    `;

                    if (user.role === 'trainer') {
                        teachersList.innerHTML += item;
                    } else if (user.role === 'trainee') {
                        studentsList.innerHTML += item;
                        studentCount++;
                    }
                });
            }
            document.getElementById('people-count').innerText = `${studentCount} students`;
        }

        function renderMaterials(materials) {
            const list = document.getElementById('materials-list');
            list.innerHTML = '';
            if (materials && materials.length > 0) {
                materials.forEach(mat => {
                    list.innerHTML += `
                        <div style="padding: 15px; border: 1px solid #eee; border-radius: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 1.5rem; color: var(--primary-blue);"><i class="fas fa-file-alt"></i></div>
                            <div>
                                <div style="font-weight: bold;">${mat.title}</div>
                                <div style="font-size: 0.85rem; color: #777;">${mat.description || ''}</div>
                                <a href="${storageBaseUrl}/${mat.file_path}" target="_blank" style="color: var(--primary-green); text-decoration: none; font-size: 0.9rem;">View File</a>
                            </div>
                        </div>
                    `;
                });
            } else {
                list.innerHTML = '<p style="color: #999; text-align: center;">No materials uploaded yet.</p>';
            }
        }

        function renderAssessments(assessments) {
            const list = document.getElementById('assessments-list');
            list.innerHTML = '';
            if (assessments && assessments.length > 0) {
                assessments.forEach(ass => {
                    list.innerHTML += `
                        <div style="padding: 15px; border: 1px solid #eee; border-radius: 5px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 1.5rem; color: var(--primary-blue);"><i class="fas fa-tasks"></i></div>
                            <div>
                                <div style="font-weight: bold;">${ass.title} <span style="font-size: 0.7rem; background: #eee; padding: 2px 6px; border-radius: 4px;">${ass.type.toUpperCase()}</span></div>
                                <div style="font-size: 0.85rem; color: #777;">${ass.description || ''}</div>
                                ${ass.file_path ? `<a href="${storageBaseUrl}/${ass.file_path}" target="_blank" style="color: var(--primary-green); text-decoration: none; font-size: 0.9rem;">View Attachment</a>` : ''}
                            </div>
                        </div>
                    `;
                });
            } else {
                list.innerHTML = '<p style="color: #999; text-align: center;">No assessments created yet.</p>';
            }
        }

        function renderGrades(course) {
            const thead = document.querySelector('#grades-table thead tr');
            const tbody = document.getElementById('grades-body');
            
            // Clear existing rows and headers (keep Student Name and Total)
            thead.innerHTML = '<th>Student Name</th>';
            tbody.innerHTML = '';

            const assessments = course.assessments || [];
            
            // Add assessment headers
            assessments.forEach(ass => {
                thead.innerHTML += `<th>${ass.title} (${ass.type})</th>`;
            });
            thead.innerHTML += '<th>Total Score</th>';

            // Get students
            const students = course.users.filter(u => u.role === 'trainee');

            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="100%" style="text-align: center; color: #999;">No students enrolled.</td></tr>';
                return;
            }

            students.forEach(student => {
                let row = `<tr><td>${student.name}</td>`;
                let totalScore = 0;

                assessments.forEach(ass => {
                    // Find grade for this student and assessment
                    // Note: grades are eager loaded on assessment: assessment.grades
                    const grade = ass.grades ? ass.grades.find(g => g.user_id === student.id) : null;
                    const score = grade ? parseFloat(grade.score) : 0;
                    totalScore += score;
                    
                    row += `<td>
                        <input type="number" 
                               class="form-control" 
                               style="width: 80px; padding: 5px;" 
                               value="${grade ? score : ''}" 
                               onchange="updateGrade(${student.id}, ${ass.id}, this.value)"
                               placeholder="-">
                    </td>`;
                });

                row += `<td>${totalScore}</td></tr>`;
                tbody.innerHTML += row;
            });
        }

        function updateGrade(studentId, assessmentId, score) {
            if (score === '') return;

            fetch('{{ route('trainer.update-grade') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    student_id: studentId,
                    assessment_id: assessmentId,
                    score: score
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optional: show a toast or highlight
                } else {
                    alert('Failed to update grade');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating grade');
            });
        }

        function switchCourseTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.tab-btn[onclick="switchCourseTab('${tabName}')"]`).classList.add('active');
            
            document.querySelectorAll('.course-tab-content').forEach(content => content.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
        }

        function switchClassworkSubTab(subTabName) {
            document.querySelectorAll('.sub-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.sub-tab-btn[onclick="switchClassworkSubTab('${subTabName}')"]`).classList.add('active');
            
            document.querySelectorAll('.classwork-subtab').forEach(content => content.classList.remove('active'));
            document.getElementById(`subtab-${subTabName}`).classList.add('active');
        }

        function openUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
        }

        function openDurationModal(courseId, startDate, endDate) {
            const modal = document.getElementById('durationModal');
            const form = document.getElementById('durationForm');
            const startInput = document.getElementById('duration_start_date');
            const endInput = document.getElementById('duration_end_date');

            form.action = `/trainer/courses/${courseId}/duration`;
            startInput.value = startDate;
            endInput.value = endDate;

            modal.style.display = 'flex';
        }

        function closeDurationModal() {
            document.getElementById('durationModal').style.display = 'none';
        }

        function openCreateAssessmentModal() {
            document.getElementById('assessmentModal').style.display = 'flex';
        }

        function closeAssessmentModal() {
            document.getElementById('assessmentModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = 'none';
            }
        }
        // Enroll Modal Logic
        let enrollCourseId = null;
        function openEnrollModal(id, name){
            enrollCourseId = id;
            var m = document.getElementById('enrollModal');
            var msg = document.getElementById('enrollModalMsg');
            if(msg){ msg.textContent = 'Are you sure you want to enroll in "' + name + '"?'; }
            // set form action
            var f = document.getElementById('enrollForm');
            if(f){ f.setAttribute('action', '{{ url('/courses') }}/' + id + '/join'); }
            m.style.display = 'flex';
        }
        function closeEnrollModal(){
            var m = document.getElementById('enrollModal');
            m.style.display = 'none';
        }

        // Calendar Logic
        let currentDate = new Date();
        const calendarEvents = @json($calendarEvents);

        function renderCalendar() {
            const monthYear = document.getElementById('calendar-month-year');
            const calendarGrid = document.getElementById('calendar-grid');
            
            // Clear existing days (keep headers)
            const headers = calendarGrid.querySelectorAll('.calendar-day-header');
            calendarGrid.innerHTML = '';
            headers.forEach(header => calendarGrid.appendChild(header));

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            monthYear.innerText = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Empty slots for previous month
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day', 'empty');
                calendarGrid.appendChild(emptyDay);
            }

            // Days of the month
            const today = new Date();
            for (let i = 1; i <= daysInMonth; i++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                
                // Highlight today
                if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayElement.classList.add('today');
                }

                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                dayNumber.innerText = i;
                dayElement.appendChild(dayNumber);

                // Add events for this day
                const currentDayStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                
                const dayEvents = calendarEvents.filter(event => {
                    // Handle ISO string format YYYY-MM-DDTHH:mm:ss.000000Z
                    const eventDate = event.start_time.substring(0, 10); 
                    return eventDate === currentDayStr;
                });

                dayEvents.forEach(event => {
                    const eventBadge = document.createElement('div');
                    eventBadge.classList.add('event-badge');
                    eventBadge.innerText = event.title;
                    eventBadge.title = `${event.title} (${event.type})`;
                    
                    // Color coding based on type
                    if (event.type === 'class') {
                        eventBadge.style.backgroundColor = '#007bff';
                    } else if (event.type === 'deadline') {
                        eventBadge.style.backgroundColor = '#dc3545';
                    } else {
                        eventBadge.style.backgroundColor = '#28a745'; // default/event
                    }

                    dayElement.appendChild(eventBadge);
                });

                calendarGrid.appendChild(dayElement);
            }
        }

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        // Initialize calendar on load
        document.addEventListener('DOMContentLoaded', function() {
            const requestedTab = new URLSearchParams(window.location.search).get('tab');
            if (requestedTab === 'profile-section') {
                showProfile();
            }
            renderCalendar();
        });

        // Notification Logic
        function toggleNotifications() {
            var dropdown = document.getElementById('notificationDropdown');
            var bell = document.querySelector('.notification-bell');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                if(bell) bell.classList.remove('active');
            } else {
                dropdown.style.display = 'block';
                if(bell) {
                    bell.classList.add('active');
                    bell.classList.remove('bell-shake');
                }
            }
        }

        function markAsRead(notificationId, link) {
            event.stopPropagation();

            fetch('/notifications/' + notificationId + '/mark-as-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update badge
                    var badge = document.querySelector('.notification-badge');
                    if (badge) {
                        var countText = badge.textContent.replace('+', '');
                        var count = parseInt(countText);
                        if (count > 1) {
                            badge.textContent = (count - 1) > 9 ? '9+' : (count - 1);
                        } else {
                            badge.remove();
                        }
                    }
                    
                    // Update item UI
                    var item = document.querySelector(`.notification-item[onclick*="'${notificationId}'"]`);
                    if (item) {
                        item.classList.remove('unread');
                        var indicator = item.querySelector('.unread-indicator');
                        if (indicator) indicator.remove();
                    }
                    
                    // Redirect if link exists
                    if (link && link !== 'null' && link !== '') {
                        window.location.href = link;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (link && link !== 'null' && link !== '') {
                    window.location.href = link;
                }
            });
        }

        function markAllAsRead() {
            event.stopPropagation();
            
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove all unread styles
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        var indicator = item.querySelector('.unread-indicator');
                        if (indicator) indicator.remove();
                    });
                    
                    // Remove badge
                    var badge = document.querySelector('.notification-badge');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var container = document.querySelector('.notification-container');
            var dropdown = document.getElementById('notificationDropdown');
            var bell = document.querySelector('.notification-bell');
            
            if (container && !container.contains(event.target)) {
                if (dropdown) dropdown.style.display = 'none';
                if (bell) bell.classList.remove('active');
            }
        });
        function toggleProfileMenu(){
            var d=document.getElementById('profileDropdown');
            var trigger=document.querySelector('.profile-trigger');
            if(!d) return;
            var open=d.style.display==='block';
            d.style.display=open?'none':'block';
            if(trigger){
                trigger.classList.toggle('open', !open);
            }
        }
        document.addEventListener('click',function(ev){
            var menu=document.querySelector('.profile-menu');
            var d=document.getElementById('profileDropdown');
            if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}
        });
        function updateHeaderTitle(id){
            var titleEl=document.getElementById('header-section-title');
            if(!titleEl) return;
            var section=document.getElementById(id);
            var title='Dashboard';
            if(section){
                var h=section.querySelector('.section-title');
                if(h){ title=h.textContent.trim(); }
                else if(id==='course-details-view'){
                    var dt=document.getElementById('detail-title');
                    if(dt){ title=dt.textContent.trim(); }
                } else if(id==='dashboard-home'){ title='Dashboard'; }
            }
            titleEl.textContent=title;
        }
        document.addEventListener('DOMContentLoaded',function(){
            var active=document.querySelector('.content-section.active');
            var id=active?active.id:'dashboard-home';
            updateHeaderTitle(id);
            try{
                document.querySelectorAll('#dashboard-home select option').forEach(function(option){
                    option.textContent = (option.textContent || '').replace(/â€“/g, '-');
                });
                document.querySelectorAll('#dashboard-home span').forEach(function(span){
                    if((span.textContent || '').indexOf('Academic Year') !== -1){
                        span.textContent = (span.textContent || '').replace(/â€“/g, '-');
                    }
                });
            }catch(_){}
        });
    </script>
</body>
</html>
