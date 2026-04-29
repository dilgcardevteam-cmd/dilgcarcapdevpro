<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dashboard - CAPDEV PRO</title>
    
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

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            backdrop-filter: blur(2px);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-toggle,
        .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .header-toggle:hover,
        .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}

        .header-title img {
            height: 50px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        /* Notification (pro style) */
        .notification-container{position:relative;margin-right:10px}
        .notification-bell{cursor:pointer;position:relative;color:#0B2C74;font-size:1.2rem;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background-color .18s ease}
        .notification-bell:hover{background:#f1f5f9}
        .notification-badge{position:absolute;top:5px;right:5px;background:#dc2626;color:#fff;border-radius:999px;padding:2px 6px;font-size:.7rem;font-weight:800;border:2px solid #fff;box-shadow:0 2px 6px rgba(220,38,38,.3)}
        .notification-dropdown{display:none;position:absolute;top:50px;right:-10px;width:320px;background:#fff;border-radius:14px;box-shadow:0 12px 28px rgba(2,6,23,.12);z-index:1000;overflow:hidden;border:1px solid #e5e7eb}
        .notification-header{padding:14px;border-bottom:1px solid #e5e7eb;font-weight:800;color:#0B2C74;display:flex;justify-content:space-between;align-items:center;background:#f8fafc}
        .chip-new{background:#eef2ff;color:#0B2C74;border:1px solid #e5e7eb;border-radius:999px;padding:2px 8px;font-size:.78rem;font-weight:800}
        .notification-list{max-height:350px;overflow-y:auto}
        .notification-item{padding:12px 14px;border-bottom:1px solid #f0f3f7;cursor:pointer;transition:background-color .18s ease;display:block;text-decoration:none;color:inherit}
        .notification-item:hover{background:#f9fbff}
        .notification-item.unread{background:#eef6ff}
        .notification-title{font-size:.95rem;font-weight:800;color:#0B2C74;display:flex;align-items:center;gap:8px}
        .unread-dot{width:8px;height:8px;border-radius:50%;background:#0B2C74;display:inline-block}
        .notification-message{font-size:.85rem;color:#64748b;margin-top:4px}
        .notification-time{font-size:.78rem;color:#9aa3af;margin-top:6px}

        /* Custom Dropdown with Tooltip */
        .fow-dropdown-container {
            position: relative;
            width: 100%;
        }

        .fow-dropdown-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            color: #1e293b;
            transition: all 0.2s ease;
            width: 100%;
        }

        .fow-dropdown-trigger:hover {
            border-color: #cbd5e1;
        }

        .fow-dropdown-container.open .fow-dropdown-trigger {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(0, 44, 118, 0.1);
        }

        .fow-dropdown-options {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            display: none;
            max-height: 250px;
            overflow-y: auto;
            padding: 6px;
        }

        .fow-dropdown-container.open .fow-dropdown-options {
            display: block;
        }

        .fow-option {
            position: static;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            color: #475569;
            transition: all 0.2s ease;
        }

        .fow-option:hover {
            background: #f1f5f9;
            color: var(--primary-blue);
        }

        .fow-tooltip {
            position: absolute;
            left: calc(100% + 20px);
            top: 0;
            width: 280px;
            background: #0b2c74;
            color: #fff;
            padding: 16px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(11, 44, 116, 0.2);
            display: none;
            z-index: 2001;
            pointer-events: none;
            text-align: left;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .fow-tooltip.visible {
            display: block;
            opacity: 1;
        }

        /* Tooltip visibility handled by JS */

        .fow-tooltip-title {
            font-weight: 700;
            font-size: 0.8rem;
            margin-bottom: 6px;
            color: var(--primary-green);
            text-transform: uppercase;
        }

        .fow-tooltip-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .fow-tooltip-list li {
            font-size: 0.85rem;
            line-height: 1.4;
            margin-bottom: 4px;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .fow-tooltip-list li::before {
            content: '•';
            color: var(--primary-green);
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
        .profile-menu{position:relative}
        .profile-dropdown{position:absolute;top:44px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-meta{padding:10px 14px;border-bottom:1px solid #e5e7eb}
        .profile-dropdown .dropdown-meta-name{font-weight:700;color:#111827}
        .profile-dropdown .dropdown-meta-role{font-size:.85rem;color:#6b7280}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        /* Courses list (Trainer–Trainee) */
        .course-row{border:1px solid #e5e7eb;border-radius:12px;padding:14px;display:flex;align-items:center;gap:12px;text-decoration:none;background:#fff;transition:box-shadow .15s ease, border-color .15s ease}
        .course-row:hover{box-shadow:0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -2px rgba(0,0,0,.05);border-color:#d1d5db}
        .course-icon{width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#002C76}
        .course-meta{flex:1;min-width:0}
        .course-title{font-weight:700;color:#002C76}
        .course-sub{font-size:.9rem;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .course-counts{display:flex;gap:16px;color:#374151}
        .course-counts .blue{color:#0ea5e9}
        .course-counts .green{color:#10b981}
        .course-grid{display:grid;gap:18px}
        @media (min-width: 640px) { .course-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (min-width: 900px) { .course-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (min-width: 1200px){ .course-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        @media (min-width: 1400px){ .course-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        .course-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.06);transition:transform .2s, box-shadow .2s;display:flex;flex-direction:column;border:1px solid #eef2f7;text-decoration:none;min-height:210px}
        .course-card:hover{transform:translateY(-4px);box-shadow:0 10px 24px rgba(0,0,0,.08)}
        .course-image{aspect-ratio:16 / 9;background-color:#eef2f7;background-size:cover;background-position:center;flex-shrink:0}
        .course-content{padding:16px;display:flex;flex-direction:column;gap:10px;flex:1}
        .course-title{font-size:1.05rem;font-weight:800;color:#002C76;margin:0;line-height:1.25;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .course-sub{color:#6b7280;font-size:.9rem;line-height:1.4;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .course-footer{margin-top:auto;display:flex;justify-content:space-between;align-items:center;padding-top:10px;gap:12px}
        .course-counts{display:flex;gap:16px;color:#374151;flex-wrap:wrap;row-gap:6px}
        .btn-view{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 16px;min-height:38px;min-width:120px;background-color:#0B2C74;color:#fff;text-decoration:none;border-radius:12px;font-size:.9rem;font-weight:700;letter-spacing:.2px;white-space:nowrap;transition:transform .15s ease, box-shadow .15s ease, background .2s;border:none;cursor:pointer;flex-shrink:0;box-shadow:0 6px 16px rgba(11,44,116,.18)}
        .btn-view:hover{background-color:#06235d;transform:translateY(-1px);box-shadow:0 10px 20px rgba(6,35,93,.2)}
        .count-label{color:#6b7280;font-size:.8rem;margin-left:4px}

        #course-management .add-course-card{
            height:280px;
            border:2px dashed #93c5fd;
            border-radius:10px;
            background:linear-gradient(160deg,#f8fbff 0%,#eef6ff 100%);
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:12px;
            text-decoration:none;
            color:#1d4ed8;
            cursor:pointer;
        }
        #course-management .add-course-plus{
            width:64px;
            height:64px;
            border-radius:50%;
            background:#1d4ed8;
            color:#fff;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:1.35rem;
            box-shadow:0 10px 20px rgba(29,78,216,.3);
        }
        #course-management .add-course-title{margin:0;font-size:1.02rem;font-weight:800;color:#1e3a8a}
        #course-management .course-stats-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:14px;margin:0 0 20px}
        #course-management .course-stat-card{
            border:1px solid #dbe2ea;
            border-radius:14px;
            background:#fff;
            padding:14px 16px;
            box-shadow:0 8px 18px rgba(15,23,42,.06);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            min-height:88px;
            cursor:pointer;
            transition:transform .2s ease, box-shadow .2s ease;
        }
        #course-management .course-stat-card:hover{transform:translateY(-4px);box-shadow:0 14px 24px rgba(15,23,42,.12)}
        #course-management .course-stat-label{margin:0;font-size:.9rem;font-weight:700;color:#334155}
        #course-management .course-stat-value{margin:4px 0 0;font-size:1.7rem;font-weight:800;color:#0f172a;line-height:1}
        #course-management .course-stat-icon{width:42px;height:42px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;flex:0 0 42px}
        #course-management .course-stat-card.active .course-stat-icon{background:#1d4ed8}
        #course-management .course-stat-card.pending .course-stat-icon{background:#d97706}
        #course-management .course-stat-card.draft .course-stat-icon{background:#7c3aed}
        #course-management .course-stat-card.archived .course-stat-icon{background:#475569}
        #course-management .course-stat-card.library .course-stat-icon{background:#10b981}
        @media (max-width: 640px){ #course-management .course-stats-grid{grid-template-columns:1fr} }
        @media (min-width: 641px) and (max-width: 992px){ #course-management .course-stats-grid{grid-template-columns:repeat(2,minmax(0,1fr))} }

        #course-create .course-create-shell{
            background:#ffffff;
            border:1px solid #dbe2ea;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 8px 20px rgba(15,23,42,.08);
        }
        #courseCreateFrameTM{
            width:100%;
            height:calc(100vh - 245px);
            min-height:760px;
            border:0;
            background:#ffffff;
            display:block;
            position:relative;
            z-index:1;
        }
        #course-create:not(.active) #courseCreateFrameTM{
            pointer-events:none;
            visibility:hidden;
            height:0;
            min-height:0;
        }
        #course-create.active #courseCreateFrameTM{
            pointer-events:auto;
            visibility:visible;
        }

        /* Hero control (match trainer style) */
        .control-hero{background:linear-gradient(135deg,#c96a09 0%,#f59e0b 58%,#ffb11b 100%);color:#fff;border-radius:22px;padding:34px 36px;position:relative;overflow:hidden;box-shadow:0 14px 34px rgba(11,44,116,.2);margin-bottom:24px}
        .control-hero::after{content:"";position:absolute;top:-48%;right:-8%;width:320px;height:320px;background:rgba(255,255,255,.1);border-radius:50%}
        .control-hero.is-training-manager{background:linear-gradient(135deg,#c96a09 0%,#f59e0b 58%,#ffb11b 100%);color:#fff;box-shadow:0 14px 34px rgba(245,158,11,.24)}
        .control-hero-top{position:relative;z-index:1;display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:24px}
        .control-hero-left{display:flex;align-items:flex-start;gap:16px}
        .control-hero-badge{width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;flex:0 0 auto}
        .control-hero-title{font-size:2.05rem;font-weight:800;letter-spacing:-.02em;line-height:1.05}
        .control-hero-sub{font-size:1.02rem;opacity:.92;max-width:640px;margin-top:10px}
        .hero-stats-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:16px}
        @media (min-width: 900px){ .hero-stats-grid{grid-template-columns:repeat(2,1fr)} }
        @media (min-width: 1200px){ .hero-stats-grid{grid-template-columns:repeat(4,1fr)} }
        .hero-stat-card{display:flex;align-items:center;gap:16px;background:rgba(255,255,255,.14);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.24);border-radius:18px;padding:20px 22px;transition:transform .18s ease, background-color .18s ease}
        .hero-stat-card:hover{transform:translateY(-4px);background:rgba(255,255,255,.2)}
        .hero-stat-icon{width:52px;height:52px;border-radius:16px;background:#fff;color:#c96a09;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex:0 0 auto}
        .hero-stat-info{display:flex;flex-direction:column}
        .hero-stat-value{font-size:2rem;font-weight:800;line-height:1}
        .hero-stat-label{font-size:.82rem;opacity:.88;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-top:6px}

        /* Distribution card */
        .dist-card{background:#fff;border:1px solid #eef2f7;border-radius:16px;padding:18px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
        .dist-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
        .dist-title{margin:0;color:#0B2C74;font-weight:800}
        .dist-total{color:#6b7280;font-size:.9rem}
        .dist-row{margin:10px 0}
        .dist-label{color:#0B2C74;font-weight:700;margin-bottom:6px}
        .dist-bar{height:10px;background:#e5e7eb;border-radius:999px;overflow:hidden}
        .dist-bar > div{height:100%;border-radius:999px;transition:width .3s ease}
        .dist-blue{background:#4e79e8}
        .dist-green{background:#10b981}
        .dist-orange{background:#f59e0b}

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
        }

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
            overflow-y: auto;
        }
        .sidebar-brand{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)}
        .sidebar-logo{height:70px}
        .sidebar.collapsed .sidebar-brand{justify-content:center;padding:8px 0}
        .sidebar.collapsed .sidebar-logo{height:44px;width:44px;margin:0 auto;display:block;object-fit:contain}

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-toggle {
            padding: 15px;
            text-align: right;
            cursor: pointer;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-toggle i {
            font-size: 1.2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            padding: 15px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            white-space: nowrap;
            overflow: hidden;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
        }

        .menu-icon {
            width: 30px;
            text-align: center;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .menu-text {
            transition: opacity 0.3s;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            display: none;
        }
        
        .menu-dropdown {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .menu-dropdown-toggle {
            width: 100%;
            position: relative;
            overflow: visible;
            padding-right: 58px;
            box-sizing: border-box;
        }

        .menu-chevron {
            margin-left: 0;
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

        .menu-chevron i {
            display: none;
        }

        .menu-chevron::before {
            content: "";
            display: block;
            width: 8px;
            height: 8px;
            border-right: 3px solid #ffffff;
            border-bottom: 3px solid #ffffff;
            transform: rotate(45deg);
        }

        .menu-dropdown.open .menu-chevron {
            transform: translateY(-50%) rotate(180deg);
            background-color: transparent;
        }

        .menu-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease;
        }

        .menu-dropdown.open .menu-dropdown-list {
            max-height: 420px;
        }

        .menu-item.menu-sub-item {
            padding: 12px 20px 12px 44px;
        }

        .sidebar.collapsed .menu-dropdown-list {
            max-height: 0 !important;
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
                position: fixed;
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
            .stats-grid {
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
            .modal-content {
                width: 92% !important;
                padding: 20px !important;
                margin: 15% auto;
            }
            .header-right .user-profile-header span,
            .header-right .user-profile-header i {
                display: none;
            }
            .user-profile-header div {
                width: 36px !important;
                height: 36px !important;
            }
            .header-logo {
                height: 32px;
                margin-right: 8px;
            }
            .header-title img {
                height: 32px;
            }
            .user-filter-grid {
                grid-template-columns: 1fr !important;
                gap: 10px !important;
            }
            .welcome-title {
                font-size: 1.4rem !important;
                margin-bottom: 20px !important;
            }
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: var(--bg-color);
        }

        .content-section {
            display: none;
            animation: fadeIn 0.3s ease-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-title {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-weight: 300;
        }

        .welcome-title strong {
            font-weight: 700;
        }

        /* Stats Cards */

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-update {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-update:hover {
            background-color: #001a47;
        }
        
        /* Pagination Styles */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: center;
            margin-top: 20px;
        }
        .page-item {
            margin: 0 2px;
        }
        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: var(--primary-blue);
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
        }
        .page-link:hover {
            z-index: 2;
            color: #001a47;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            cursor: auto;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* User Management */
        .user-management-shell {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .user-management-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 14px;
        }

        .user-management-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .user-management-alert {
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .user-filter-panel {
            background: linear-gradient(160deg, #ffffff 0%, #f8fbff 100%);
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(0, 44, 118, 0.07);
        }

        .user-filter-grid {
            display: grid;
            grid-template-columns: minmax(280px, 1.5fr) minmax(210px, 1fr) minmax(210px, 1fr) auto;
            gap: 14px;
            align-items: flex-end;
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-field label {
            margin: 0;
            color: #1f3f78;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .filter-search-wrap {
            position: relative;
        }

        .filter-search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            height: 44px;
            border: 1px solid #d4dae3;
            border-radius: 10px;
            box-sizing: border-box;
            background: #ffffff;
            color: #0f172a;
            padding: 0 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-search-wrap .filter-input {
            padding-left: 38px;
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: #2f5aa8;
            box-shadow: 0 0 0 3px rgba(47, 90, 168, 0.15);
        }

        .filter-action {
            display: flex;
            align-items: flex-end;
        }

        .btn-reset-filters {
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 16px;
            border-radius: 10px;
            border: 1px solid #d6dde8;
            text-decoration: none;
            color: #475569;
            background: #ffffff;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-reset-filters:hover {
            border-color: #9fb1cf;
            color: #1f3f78;
            background: #f8fbff;
        }

        .active-filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 0;
            min-height: 0;
            grid-column: 2 / 3;
            grid-row: 2;
            align-self: start;
        }

        .active-filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            border: 1px solid rgba(0, 44, 118, 0.18);
            background: rgba(0, 44, 118, 0.08);
            color: #0f2f68;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .active-filter-chip .chip-remove {
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 44, 118, 0.16);
            color: #0f2f68;
            cursor: pointer;
            padding: 0;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .active-filter-chip .chip-remove:hover {
            background: #dc2626;
            color: #ffffff;
        }

        .users-table-shell {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .users-table-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 14px 18px;
            background: linear-gradient(180deg, #fbfcff 0%, #f4f7fb 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .users-table-meta strong {
            color: var(--primary-blue);
            font-size: 0.96rem;
        }

        .users-table-meta span {
            color: #64748b;
            font-size: 0.84rem;
        }

        .users-table-wrap {
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            min-width: 980px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .users-table thead th {
            padding: 12px 14px;
            text-align: center;
            background: #f8fafc;
            color: #3a4f7a;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .users-table thead th:first-child {
            text-align: center;
        }

        .users-table tbody td {
            padding: 14px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
            text-align: center;
            color: #0f172a;
            font-size: 0.9rem;
        }

        .users-table tbody td:first-child {
            text-align: left;
        }

        .users-table tbody tr:last-child td {
            border-bottom: none;
        }

        .users-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .users-table tbody tr:hover {
            background: #f8fbff;
        }

        .user-identity {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            min-width: 230px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(145deg, #1f4f9f, #002c76);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-name {
            display: block;
            font-weight: 600;
            line-height: 1.2;
        }

        .mono-text {
            font-family: "Courier New", Courier, monospace;
            font-size: 0.82rem;
            color: #334155;
        }

        .muted-cell {
            color: #64748b;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: capitalize;
            letter-spacing: 0.01em;
        }

        .badge-role-admin { background: #00215e; color: #ffffff; }
        .badge-role-registrar { background: #00215e; color: #ffffff; }
        .badge-role-training_manager { background: #facc15; color: #1e293b; }
        .badge-role-coach { background: #b91c1c; color: #ffffff; }
        .badge-role-trainer { background: #b91c1c; color: #ffffff; }
        .badge-role-trainee { background: #f59e0b; color: #ffffff; }
        .badge-role-participant { background: #f59e0b; color: #ffffff; }

        /* Office Level Role Variants */
        .badge-role-central_office_admin, .badge-role-regional_office_admin, .badge-role-provincial_office_admin { background: #00215e; color: #ffffff; }
        .badge-role-central_office_training_manager, .badge-role-regional_office_training_manager, .badge-role-provincial_office_training_manager { background: #facc15; color: #1e293b; }
        .badge-role-central_office_coach, .badge-role-regional_office_coach, .badge-role-provincial_office_coach { background: #b91c1c; color: #ffffff; }
        .badge-role-central_office_participants, .badge-role-regional_office_participants, .badge-role-provincial_office_participants { background: #f59e0b; color: #ffffff; }

        .badge-status-active { background: #16a34a; color: #ffffff; }
        .badge-status-freeze { background: #dc2626; color: #ffffff; }
        .badge-status-pending { background: #facc15; color: #1e293b; }

        .actions-inline {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        /* Overview container */
        .insight-panel {
            background: #ffffff;
            border: 1px solid #e5eef7;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        }
        .insight-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .insight-panel-header h2 {
            margin: 0;
            color: #0B2C74;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -.01em;
        }
        .insight-panel-header span {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            border-radius: 8px;
            padding: 8px 11px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            white-space: nowrap;
        }

        .btn-table-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);
        }

        .insight-grid {
            display: grid;
            grid-template-columns: 1.1fr 1.6fr;
            gap: 20px;
        }
        .insight-col {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .btn-action-manage { background: #e8eefb; color: #1e40af; }

        .table-empty {
            padding: 40px 20px;
            text-align: center;
            color: #64748b;
        }

        .table-empty i {
            display: block;
            font-size: 1.8rem;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .users-pagination {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }

        .users-page-number {
            margin-top: 14px;
            text-align: right;
            color: #64748b;
            font-size: 0.84rem;
            font-weight: 600;
        }

        /* Transfer List Styles */
        .transfer-section {
            margin-bottom: 25px;
        }
        .transfer-section h3 {
            color: var(--primary-blue);
            font-size: 1.1rem;
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .transfer-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }
        .transfer-box {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            height: 300px;
            background: white;
        }
        .transfer-header {
            background: #f8f9fa;
            padding: 8px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            text-align: center;
            color: #495057;
        }
        .transfer-search {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            background: #fff;
        }
        .transfer-search input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 0.9rem;
        }
        .transfer-list {
            flex: 1;
            overflow-y: auto;
            padding: 5px;
        }
        .transfer-item {
            display: flex;
            align-items: center;
            padding: 6px 8px;
            border-bottom: 1px solid #f1f1f1;
            transition: background 0.2s;
        }
        .transfer-item:hover {
            background-color: #f8f9fa;
        }
        .transfer-item:last-child {
            border-bottom: none;
        }
        .transfer-item label {
            margin-left: 8px;
            cursor: pointer;
            flex: 1;
            font-size: 0.95rem;
            user-select: none;
        }
        .transfer-item input[type="checkbox"] {
            cursor: pointer;
            width: 16px;
            height: 16px;
        }
        .transfer-controls {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .transfer-btn {
            padding: 6px 12px;
            cursor: pointer;
            background: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-weight: bold;
            color: #495057;
            transition: all 0.2s;
        }
        .transfer-btn:hover {
            background: #dee2e6;
            border-color: #adb5bd;
        }

        .notification-dropdown {
            width: min(92vw, 320px) !important;
            right: 0 !important;
            left: auto !important;
        }

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

            .control-hero {
                padding: 24px 20px;
            }

            .control-hero-top {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 18px;
            }

            .control-hero-title {
                font-size: 1.7rem;
            }

            .hero-stat-card {
                padding: 18px;
            }

            .user-profile-header {
                margin-right: 0 !important;
            }

            .dashboard-container {
                flex-direction: column;
                overflow: visible;
            }

            .sidebar,
            .sidebar.collapsed {
                width: 100%;
                max-width: 100%;
                overflow: visible;
            }

            .sidebar-toggle {
                display: none;
            }

            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
            }

            .menu-item {
                flex: 0 0 auto;
                padding: 12px 14px;
            }

            .sidebar.collapsed .menu-text {
                opacity: 1;
                display: inline;
            }

            .main-content {
                padding: 16px;
                overflow: visible;
            }

            .welcome-title {
                font-size: 1.5rem;
                margin-bottom: 18px;
            }

            .stats-grid {
                gap: 14px;
            }

            .transfer-container {
                flex-direction: column;
            }

            .transfer-box {
                width: 100%;
                height: 260px;
            }

            .modal-content {
                width: min(94vw, 720px);
                margin: 20px auto;
                padding: 20px;
            }

            #usersTableContainer,
            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 720px;
            }

            .user-management-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-filter-panel {
                padding: 16px;
                border-radius: 12px;
            }

            .user-filter-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .active-filters-row {
                grid-column: 1 / -1;
                grid-row: auto;
                margin-top: 8px;
            }

            .filter-action {
                width: 100%;
            }

            .btn-reset-filters {
                width: 100%;
            }

            .users-table {
                min-width: 820px;
            }

            .users-table-meta {
                padding: 12px 14px;
            }

            .content-section [style*="grid-template-columns: 1fr 1fr"],
            .content-section [style*="grid-template-columns: 1fr 2fr"],
            .content-section [style*="grid-template-columns: 1fr 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .content-section [style*="display: flex"][style*="justify-content: space-between"] {
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            .content-section [style*="min-width: 200px"],
            .content-section [style*="min-width: 250px"],
            .content-section [style*="min-width: 300px"] {
                min-width: 0 !important;
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

        #profile-section .profile-page-fields label {
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
    <!-- Navbar -->
    <header class="header">
        <div class="header-left">
            <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <h2 id="page-title" style="margin: 0 0 0 15px; font-size: 1.25rem; color: var(--primary-blue); font-weight: 700;">Dashboard</h2>
        </div>
        <div class="header-right">
            <!-- Notification Bell -->
            <div class="notification-container">
                <div class="notification-bell" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                    @endif
                </div>
                
                <div id="notificationDropdown" class="notification-dropdown">
                    <div class="notification-header">
                        <span>Notifications</span>
                        <span class="chip-new">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }} New</span>
                    </div>
                    <div class="notification-list">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}" onclick="markAsRead('{{ $notification->id }}', '{{ $notification->link }}')">
                                    <div class="notification-title">
                                        @if(!$notification->is_read) <span class="unread-dot"></span> @endif
                                        {{ $notification->title }}
                                    </div>
                                    <div class="notification-message">{{ $notification->message }}</div>
                                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="notification-item" style="text-align:center;color:#64748b">No notifications</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="profile-menu">
                <div class="user-profile-header" onclick="toggleProfileMenu(event)" style="cursor: pointer; display: flex; align-items: center; gap: 10px; margin-right: 10px;">
                    <div style="width: 40px; height: 40px; background-color: var(--primary-blue); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <i class="fas fa-chevron-down" style="font-size:.85rem;color:#666;margin-left:6px"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <div class="dropdown-meta">
                        <div class="dropdown-meta-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-meta-role">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('dashboard', ['tab' => 'profile-section']) }}">
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
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
            </div>
            <ul class="sidebar-menu">
                @php
                    $portalQuery = strtolower((string) request()->query('portal', ''));
                    $tmPortalActive = ($portalQuery === '' || in_array($portalQuery, ['tm', 'training_manager'], true))
                        && (!request('tab') || in_array(request('tab'), ['user-management','trainer-trainee-management','activity-logs'], true));
                    $coachPortalActive = ($portalQuery === 'coach');
                    $participantPortalActive = ($portalQuery === 'participant');
                    $adminPortalActive = ($portalQuery === 'admin');
                    $canCoachPortal = Auth::user()->hasPermission('view_courses_coach') || Auth::user()->hasPermission('view_classes') || Auth::user()->hasPermission('view_communication');
                    $canParticipantPortal = Auth::user()->hasPermission('view_modules');
                    $canAdminPortal = Auth::user()->hasPermission('view_users')
                        || Auth::user()->hasPermission('create_users')
                        || Auth::user()->hasPermission('edit_users')
                        || Auth::user()->hasPermission('delete_users')
                        || Auth::user()->hasPermission('view_monitoring')
                        || Auth::user()->hasPermission('view_access_control')
                        || Auth::user()->hasPermission('edit_access_control');
                @endphp
                <li class="menu-dropdown {{ $tmPortalActive ? 'open' : '' }}" id="portal-dropdown-tm">
                    <div class="menu-item menu-dropdown-toggle {{ $tmPortalActive ? 'active' : '' }}" onclick="togglePortalDropdown(event,'portal-dropdown-tm')">
                        <div class="menu-icon"><i class="fas fa-layer-group"></i></div>
                        <span class="menu-text">Training Manager Portal</span>
                        <span class="menu-chevron"></span>
                    </div>
                    <ul class="menu-dropdown-list" id="portal-dropdown-list-tm">
                        <li class="menu-item menu-sub-item {{ !request('tab') ? 'active' : '' }}" onclick="showContent('dashboard-home', this)">
                            <div class="menu-icon"><i class="fas fa-home"></i></div>
                            <span class="menu-text">Dashboard</span>
                        </li>
                        @if(Auth::user()->hasPermission('view_training'))
                        <li class="menu-item menu-sub-item {{ request('tab') == 'course-management' ? 'active' : '' }}" onclick="showContent('course-management', this)">
                            <div class="menu-icon"><i class="fas fa-book"></i></div>
                            <span class="menu-text">Course Management</span>
                        </li>
                        @endif
                        @if(Auth::user()->canManageUsers())
                        <li class="menu-item menu-sub-item {{ request('tab') == 'user-management' ? 'active' : '' }}" onclick="showContent('user-management', this)">
                            <div class="menu-icon"><i class="fas fa-users"></i></div>
                            <span class="menu-text">User Management</span>
                        </li>
                        @endif
                        @if(Auth::user()->canManageTraining())
                        <li class="menu-item menu-sub-item {{ request('tab') == 'trainer-trainee-management' ? 'active' : '' }}" onclick="showContent('trainer-trainee-management', this)">
                            <div class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="menu-text">Training Management</span>
                        </li>
                        @endif
                        @if(Auth::user()->canViewReports())
                        <li class="menu-item menu-sub-item {{ request('tab') == 'activity-logs' ? 'active' : '' }}" onclick="showContent('activity-logs', this)">
                            <div class="menu-icon"><i class="fas fa-clock-rotate-left"></i></div>
                            <span class="menu-text">Activity Logs</span>
                        </li>
                        @endif
                    </ul>
                </li>
                @if($canCoachPortal)
                <li class="menu-dropdown {{ $coachPortalActive ? 'open' : '' }}" id="portal-dropdown-coach">
                    <div class="menu-item menu-dropdown-toggle {{ $coachPortalActive ? 'active' : '' }}" onclick="togglePortalDropdown(event,'portal-dropdown-coach')">
                        <div class="menu-icon"><i class="fas fa-layer-group"></i></div>
                        <span class="menu-text">Coach Portal</span>
                        <span class="menu-chevron"></span>
                    </div>
                    <ul class="menu-dropdown-list" id="portal-dropdown-list-coach">
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'coach']) }}'">
                            <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <span class="menu-text">Dashboard</span>
                        </li>
                        @if(Auth::user()->hasPermission('view_courses_coach'))
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'coach', 'tab' => 'my-courses']) }}'">
                            <div class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="menu-text">My Courses</span>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_classes'))
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'coach', 'tab' => 'calendar']) }}'">
                            <div class="menu-icon"><i class="fas fa-calendar-alt"></i></div>
                            <span class="menu-text">Calendar</span>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view_communication'))
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'coach', 'tab' => 'announcements']) }}'">
                            <div class="menu-icon"><i class="fas fa-bullhorn"></i></div>
                            <span class="menu-text">Announcements</span>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if($canParticipantPortal)
                <li class="menu-dropdown {{ $participantPortalActive ? 'open' : '' }}" id="portal-dropdown-participant">
                    <div class="menu-item menu-dropdown-toggle {{ $participantPortalActive ? 'active' : '' }}" onclick="togglePortalDropdown(event,'portal-dropdown-participant')">
                        <div class="menu-icon"><i class="fas fa-layer-group"></i></div>
                        <span class="menu-text">Participant Portal</span>
                        <span class="menu-chevron"></span>
                    </div>
                    <ul class="menu-dropdown-list" id="portal-dropdown-list-participant">
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'participant']) }}'">
                            <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <span class="menu-text">Dashboard</span>
                        </li>
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'participant', 'tab' => 'classroom']) }}'">
                            <div class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="menu-text">Classroom</span>
                        </li>
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'participant', 'tab' => 'calendar']) }}'">
                            <div class="menu-icon"><i class="fas fa-calendar-alt"></i></div>
                            <span class="menu-text">Calendar</span>
                        </li>
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'participant', 'tab' => 'announcements']) }}'">
                            <div class="menu-icon"><i class="fas fa-bullhorn"></i></div>
                            <span class="menu-text">Announcements</span>
                        </li>
                    </ul>
                </li>
                @endif
                @if($canAdminPortal)
                <li class="menu-dropdown {{ $adminPortalActive ? 'open' : '' }}" id="portal-dropdown-admin">
                    <div class="menu-item menu-dropdown-toggle {{ $adminPortalActive ? 'active' : '' }}" onclick="togglePortalDropdown(event,'portal-dropdown-admin')">
                        <div class="menu-icon"><i class="fas fa-layer-group"></i></div>
                        <span class="menu-text">Admin Portal</span>
                        <span class="menu-chevron"></span>
                    </div>
                    <ul class="menu-dropdown-list" id="portal-dropdown-list-admin">
                        <li class="menu-item menu-sub-item" onclick="window.location.href='{{ route('dashboard', ['portal' => 'admin']) }}'">
                            <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <span class="menu-text">Dashboard</span>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Home Section -->
            <section id="dashboard-home" class="content-section {{ !request('tab') ? 'active' : '' }}">
                @php
                    $isTrainingManagerHero = in_array(Auth::user()->role, ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'], true);
                @endphp
                <div class="control-hero {{ $isTrainingManagerHero ? 'is-training-manager' : '' }}">
                    <div class="control-hero-top">
                        <div class="control-hero-left">
                            <div class="control-hero-badge"><i class="fas fa-gauge-high"></i></div>
                            <div>
                                <div class="control-hero-title">Welcome, {{ Auth::user()->name }}</div>
                                <div class="control-hero-sub">Monitor learner activation, course readiness, and certification output.</div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-stats-grid">
                        @if(Auth::user()->hasPermission('view_users_tm'))
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-user-clock"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $unapprovedCount }}</span>
                                <span class="hero-stat-label">Total Unapproved Users</span>
                            </div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-user-check"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $approvedCount }}</span>
                                <span class="hero-stat-label">Total Approved Users</span>
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->hasPermission('view_training'))
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-book"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $totalCourses }}</span>
                                <span class="hero-stat-label">Total Courses</span>
                            </div>
                        </div>
                        <div class="hero-stat-card">
                            <div class="hero-stat-icon"><i class="fas fa-user-hourglass"></i></div>
                            <div class="hero-stat-info">
                                <span class="hero-stat-value">{{ $pendingTraineesCount }}</span>
                                <span class="hero-stat-label">Pending Participants</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="insight-panel" style="margin-top:14px">
                @php
                    $pct = function($n,$t){ return $t>0 ? round(($n/$t)*100) : 0; };
                @endphp
                <div class="insight-grid" style="margin-top:14px">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
                        @if(Auth::user()->hasPermission('view_users_tm'))
                        <div class="insight-panel">
                    <div class="insight-panel-header">
                        <h2>Accounts & Courses Overview</h2>
                        <span>Totals</span>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">
                        <div>
                            <div style="display:flex;justify-content:center;gap:8px;margin-bottom:8px">
                                <button id="tm-tab-role" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#0B2C74;color:#fff;font-weight:800">Roles</button>
                                <button id="tm-tab-status" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#fff;color:#0B2C74;font-weight:800">Status</button>
                            </div>
                            <div id="tm-accounts-role" style="display:block">
                                <div id="tm-donut-accounts-role" style="width:220px;height:220px;margin:0 auto"></div>
                                <div style="margin-top:10px;text-align:center">
                                    <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Total Accounts</div>
                                    <div style="font-weight:800;color:#0B2C74;font-size:1.5rem;line-height:1">{{ $userCount }}</div>
                                </div>
                                <div style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px" id="tm-legend-role">
                                    <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Admin <span id="tm-role-admin" style="color:#6b7280;margin-left:6px"></span></div>
                                    <div style="width:12px;height:12px;border-radius:50%;background:#FFD700;border:1px solid #eab308"></div><div style="color:#0B2C74;font-weight:800">Training Manager <span id="tm-role-tm" style="color:#6b7280;margin-left:6px"></span></div>
                                    <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#0B2C74;font-weight:800">Coaches <span id="tm-role-coach" style="color:#6b7280;margin-left:6px"></span></div>
                                    <div style="width:12px;height:12px;border-radius:50%;background:#f59e0b"></div><div style="color:#0B2C74;font-weight:800">Participants <span id="tm-role-part" style="color:#6b7280;margin-left:6px"></span></div>
                                </div>
                            </div>
                            <div id="tm-accounts-status" style="display:none">
                                <div id="tm-donut-accounts-status" style="width:220px;height:220px;margin:0 auto"></div>
                                <div style="margin-top:10px;text-align:center">
                                    <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Total Accounts</div>
                                    <div style="font-weight:800;color:#0B2C74;font-size:1.5rem;line-height:1">{{ $userCount }}</div>
                                </div>
                                <div style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px" id="tm-legend-status">
                                    <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Active <span id="tm-acc-legend-active" style="color:#6b7280;margin-left:6px"></span></div>
                                    <div style="width:12px;height:12px;border-radius:50%;background:#FFD700;border:1px solid #eab308"></div><div style="color:#0B2C74;font-weight:800">Pending <span id="tm-acc-legend-pending" style="color:#6b7280;margin-left:6px"></span></div>
                                    <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#0B2C74;font-weight:800">Blocked <span id="tm-acc-legend-blocked" style="color:#6b7280;margin-left:6px"></span></div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->hasPermission('view_course_monitoring'))
                        <div>
                            <div style="display:flex;justify-content:center;gap:8px;margin-bottom:8px">
                                <button id="tm-course-tab-summary" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#0B2C74;color:#fff;font-weight:800">Status</button>
                                <button id="tm-course-tab-distribution" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#fff;color:#0B2C74;font-weight:800">Distribution</button>
                            </div>
                            <div id="tm-donut-courses" style="width:220px;height:220px;margin:0 auto"></div>
                            <div style="margin-top:10px;text-align:center">
                                <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Total Courses</div>
                                <div id="tm-total-courses" style="font-weight:800;color:#0B2C74;font-size:1.5rem;line-height:1">{{ $cActive }}</div>
                            </div>
                            <div id="tm-legend-course-summary" style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Published <span id="tm-course-legend-published" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#0B2C74;font-weight:800">Unpublished <span id="tm-course-legend-unpublished" style="color:#6b7280;margin-left:6px"></span></div>
                            </div>
                            <div id="tm-legend-course-distribution" style="display:none;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Classroom with Coach <span id="tm-course-legend-withcoach" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#0B2C74;font-weight:800">Classroom without Coach <span id="tm-course-legend-withoutcoach" style="color:#6b7280;margin-left:6px"></span></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
                    <script>
                        (function(){
                          function renderArcDonut(elId, parts, colors){
                            var el=document.getElementById(elId);
                            if(!el){return;}
                            var width=220, height=220, r=80, ir=48;
                            var total=parts.reduce(function(a,b){return a+b;},0);
                            if(total===0){return;}

                            var svg=d3.select('#'+elId).append('svg').attr('width',width).attr('height',height);
                            var g=svg.append('g').attr('transform','translate('+width/2+','+height/2+')');
                            
                            var validParts = [];
                            var validColors = [];
                            parts.forEach(function(p, i){
                                if(p > 0){
                                    validParts.push(p);
                                    validColors.push(colors[i]);
                                }
                            });

                            var pie=d3.pie().sort(null);
                            if(validParts.length > 1){
                                pie.padAngle(0.03);
                            }

                            var arc=d3.arc().innerRadius(ir).outerRadius(r).cornerRadius(6);
                            var data=pie(validParts);
                            var paths=g.selectAll('path').data(data).enter().append('path')
                              .attr('d',arc)
                              .attr('fill',function(d,i){return validColors[i];})
                              .attr('stroke','#ffffff')
                              .attr('stroke-width','1.2')
                              .on('mouseover', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1.03)'); })
                              .on('mouseout', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1)'); });
                            paths.transition().duration(900).ease(d3.easeCubicOut).attrTween('d', function(d){
                              var i=d3.interpolate({startAngle:d.startAngle, endAngle:d.startAngle}, d);
                              return function(t){ return arc(i(t)); };
                            });
                            g.selectAll('text').data(data).enter().append('text')
                              .attr('transform', function(d){ return 'translate('+arc.centroid(d)+')'; })
                              .attr('dy','.35em')
                              .attr('text-anchor','middle')
                              .attr('font-size','12px')
                              .attr('fill', function(d,i){ return validColors[i] === '#FFD700' ? '#0f172a' : '#ffffff'; })
                              .text(function(d){ var p=total? Math.round((d.value/total)*100):0; return p>0? (p+'%'):''; });
                          }
                          function pct(n,t){ return t>0? Math.round((n/t)*100):0; }
                          var aActive={{ $aActive }};
                          var aPending={{ $aPending }};
                          var aBlocked={{ $aBlocked }};
                          var aTotal={{ $userCount }};
                          var rAdmin={{ $rAdmins }};
                          var rTM={{ $rTM }};
                          var rCoach={{ $rCoaches }};
                          var rPart={{ $rParticipants }};
                          function drawRole(){
                            var c=document.getElementById('tm-donut-accounts-role');
                            if(c){ c.innerHTML=''; }
                            renderArcDonut('tm-donut-accounts-role', [rAdmin,rTM,rCoach,rPart], ['#0B2C74','#FFD700','#B10606','#f59e0b']);
                            document.getElementById('tm-role-admin').innerText = rAdmin+' · '+pct(rAdmin,aTotal)+'%';
                            document.getElementById('tm-role-tm').innerText = rTM+' · '+pct(rTM,aTotal)+'%';
                            document.getElementById('tm-role-coach').innerText = rCoach+' · '+pct(rCoach,aTotal)+'%';
                            document.getElementById('tm-role-part').innerText = rPart+' · '+pct(rPart,aTotal)+'%';
                          }
                          function drawStatus(){
                            var c=document.getElementById('tm-donut-accounts-status');
                            if(c){ c.innerHTML=''; }
                            renderArcDonut('tm-donut-accounts-status', [aActive,aPending,aBlocked], ['#0B2C74','#FFD700','#B10606']);
                            document.getElementById('tm-acc-legend-active').innerText = aActive+' · '+pct(aActive,aTotal)+'%';
                            document.getElementById('tm-acc-legend-pending').innerText = aPending+' · '+pct(aPending,aTotal)+'%';
                            document.getElementById('tm-acc-legend-blocked').innerText = aBlocked+' · '+pct(aBlocked,aTotal)+'%';
                          }
                          // initial render: roles
                          drawRole();
                          var tabRole=document.getElementById('tm-tab-role');
                          var tabStatus=document.getElementById('tm-tab-status');
                          var roleBox=document.getElementById('tm-accounts-role');
                          var statusBox=document.getElementById('tm-accounts-status');
                          tabRole.addEventListener('click', function(){
                            roleBox.style.display='block';
                            statusBox.style.display='none';
                            tabRole.style.background='#0B2C74';
                            tabRole.style.color='#fff';
                            tabStatus.style.background='#fff';
                            tabStatus.style.color='#0B2C74';
                            drawRole();
                          });
                          tabStatus.addEventListener('click', function(){
                            roleBox.style.display='none';
                            statusBox.style.display='block';
                            tabStatus.style.background='#0B2C74';
                            tabStatus.style.color='#fff';
                            tabRole.style.background='#fff';
                            tabRole.style.color='#0B2C74';
                            drawStatus();
                          });
                          var cActive={{ $cActive }};
                          var cPublished={{ $publishedCoursesCount }};
                          var cUnpublished={{ $unpublishedCoursesCount }};
                          var cWithCoach={{ $cWithCoach }};
                          var cWithoutCoach={{ $cWithoutCoach }};
                          var cTotal = cActive;
                          function drawCourseDistribution(){
                            var dLegend=document.getElementById('tm-legend-course-distribution');
                            var sLegend=document.getElementById('tm-legend-course-summary');
                            if(dLegend) dLegend.style.display='grid';
                            if(sLegend) sLegend.style.display='none';
                            var btnS=document.getElementById('tm-course-tab-summary');
                            var btnD=document.getElementById('tm-course-tab-distribution');
                            if(btnS&&btnD){ btnS.style.background='#fff'; btnS.style.color='#0B2C74'; btnD.style.background='#0B2C74'; btnD.style.color='#fff'; }
                            var el=document.getElementById('tm-donut-courses'); if(el){ el.innerHTML=''; }
                            renderArcDonut('tm-donut-courses', [cWithCoach,cWithoutCoach], ['#0B2C74','#B10606']);
                            document.getElementById('tm-course-legend-withcoach').innerText = cWithCoach+' · '+pct(cWithCoach,cTotal)+'%';
                            document.getElementById('tm-course-legend-withoutcoach').innerText = cWithoutCoach+' · '+pct(cWithoutCoach,cTotal)+'%';
                          }
                          function drawCourseSummary(){
                            var dLegend=document.getElementById('tm-legend-course-distribution');
                            var sLegend=document.getElementById('tm-legend-course-summary');
                            if(dLegend) dLegend.style.display='none';
                            if(sLegend) sLegend.style.display='grid';
                            var btnS=document.getElementById('tm-course-tab-summary');
                            var btnD=document.getElementById('tm-course-tab-distribution');
                            if(btnS&&btnD){ btnS.style.background='#0B2C74'; btnS.style.color='#fff'; btnD.style.background='#fff'; btnD.style.color='#0B2C74'; }
                            var el=document.getElementById('tm-donut-courses'); if(el){ el.innerHTML=''; }
                            renderArcDonut('tm-donut-courses', [cPublished,cUnpublished], ['#0B2C74','#B10606']);
                            document.getElementById('tm-course-legend-published').innerText = cPublished+' · '+pct(cPublished,cTotal)+'%';
                            document.getElementById('tm-course-legend-unpublished').innerText = cUnpublished+' · '+pct(cUnpublished,cTotal)+'%';
                          }
                          drawCourseSummary();
                          var tabCourseSummary=document.getElementById('tm-course-tab-summary');
                          var tabCourseDistribution=document.getElementById('tm-course-tab-distribution');
                          if(tabCourseSummary){ tabCourseSummary.addEventListener('click', drawCourseSummary); }
                          if(tabCourseDistribution){ tabCourseDistribution.addEventListener('click', drawCourseDistribution); }
                        })();

    function openDraftCoursesModal() {
        const modal = document.getElementById('draftCoursesModal');
        if (modal) {
            modal.style.display = 'flex';
            renderDraftCoursesInModal();
        }
    }
    function closeDraftCoursesModal() {
        const modal = document.getElementById('draftCoursesModal');
        if (modal) modal.style.display = 'none';
    }
    function getDraftCoursesFromLocalStorage() {
        let drafts = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (!key) continue;
            const isDraftKey =
                key === 'draft_course_create' ||
                key === 'draft_course_active_new' ||
                key.startsWith('draft_course_active_new_u_') ||
                key.startsWith('draft_course_new_') ||
                key.startsWith('draft_course_edit_');
            if (!isDraftKey) continue;
            const raw = localStorage.getItem(key);
            if (raw && raw !== '{}' && raw !== 'null') {
                try {
                    const data = JSON.parse(raw);
                    drafts.push({ key: key, data: data });
                } catch (e) {}
            }
        }
        return drafts;
    }
    function renderDraftCoursesInModal() {
        const container = document.getElementById('draftCoursesModalContainer');
        if (!container) return;
        const drafts = getDraftCoursesFromLocalStorage();
        if (drafts.length === 0) {
            container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #fff; border-radius: 12px; border: 2px dashed #e5e7eb;"><p style="color: #64748b; font-weight: 600; margin: 0;">You have no draft courses yet.</p></div>';
            return;
        }
        container.innerHTML = '';
        drafts.forEach((draft) => {
            const courseName = draft.data.name || 'Untitled Course';
            const courseDesc = draft.data.description || 'No description';
            const card = document.createElement('div');
            card.style.cssText = 'background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; display: flex; flex-direction: column;';
            card.innerHTML = `
                <div style="width: 100%; height: 160px; background: linear-gradient(135deg, #002C76 0%, #0056b3 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3.5rem;">
                    <i class="fas fa-file-pen"></i>
                </div>
                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                    <h3 style="margin: 0 0 10px; color: #002C76; font-size: 1.15rem; font-weight: 800; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${courseName}</h3>
                    <p style="color: #64748b; margin-bottom: 20px; font-size: 0.95rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">${courseDesc}</p>
                    <div style="display: flex; gap: 10px; margin-top: auto;">
                        <button type="button" onclick="event.stopPropagation(); editDraftCourse('${draft.key}');" style="flex: 1; padding: 10px; background: #002C76; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button" onclick="event.stopPropagation(); deleteDraftCourse('${draft.key}')" style="padding: 10px 14px; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 0.95rem;"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }
    function editDraftCourse(storageKey) {
        const raw = localStorage.getItem(storageKey);
        if (!raw) { alert('Draft not found'); return; }
        try {
            JSON.parse(raw);
            sessionStorage.setItem('load_draft', '1');
            sessionStorage.setItem('draft_course_key', storageKey);
            closeDraftCoursesModal();
            openAddCourseModalTM(true, { preserveState: false });
        } catch (e) {
            alert('Error loading draft');
        }
    }
    function deleteDraftCourse(storageKey) {
        localStorage.removeItem(storageKey);
        renderDraftCoursesInModal();
    }
                    </script>
                    </div>
                    <div class="insight-panel">
                        <div class="insight-panel-header">
                            <h2>Users Trend</h2>
                            <span>Last 12 Months</span>
                        </div>
                        @php
                            $monthLabels = [];
                            $monthCounts = [];
                            for($i=11; $i>=0; $i--){
                                $m = \Carbon\Carbon::now()->subMonths($i);
                                $monthLabels[] = $m->format('M');
                                $start = $m->copy()->startOfMonth();
                                $end = $m->copy()->endOfMonth();
                                $monthCounts[] = \App\Models\User::whereBetween('created_at', [$start, $end])->count();
                            }
                        @endphp
                        <div id="tm-line-users" style="width:100%;min-width:480px;height:280px"></div>
                        <script>
                            (function(){
                                var labels = @json($monthLabels);
                                var data = @json($monthCounts);
                                var elId = 'tm-line-users';
                                var el = document.getElementById(elId);
                                if(!el){ return; }
                                var panel = el.closest('.insight-panel');
                                var width = Math.max(480, (panel ? panel.clientWidth - 40 : (el.clientWidth || 640)));
                                var height = 280, margin = {top:18,right:28,bottom:32,left:40};
                                var svg = d3.select('#'+elId).append('svg').attr('width', '100%').attr('height', height).attr('viewBox','0 0 '+width+' '+height).attr('preserveAspectRatio','xMidYMid meet');
                                var innerW = width - margin.left - margin.right;
                                var innerH = height - margin.top - margin.bottom;
                                var g = svg.append('g').attr('transform','translate('+margin.left+','+margin.top+')');
                                var x = d3.scalePoint().domain(labels).range([0, innerW]).padding(0.5);
                                var y = d3.scaleLinear().domain([0, d3.max(data)||0]).nice().range([innerH, 0]);
                                g.append('g').attr('transform','translate(0,'+innerH+')').call(d3.axisBottom(x).tickSizeOuter(0)).selectAll('text').style('fill','#334155').style('font-weight','700');
                                g.append('g').call(d3.axisLeft(y).ticks(5).tickSizeOuter(0)).selectAll('text').style('fill','#334155').style('font-weight','700');
                                var grid = g.append('g').attr('stroke','#e5e7eb').attr('stroke-width',1).attr('opacity',0.7);
                                grid.selectAll('line').data(y.ticks(5)).enter().append('line').attr('x1',0).attr('x2',innerW).attr('y1',function(d){return y(d);}).attr('y2',function(d){return y(d);});
                                var defs = svg.append('defs');
                                var grad = defs.append('linearGradient').attr('id','trendGrad').attr('x1','0').attr('y1','0').attr('x2','0').attr('y2','1');
                                grad.append('stop').attr('offset','0%').attr('stop-color','#0B2C74').attr('stop-opacity',0.25);
                                grad.append('stop').attr('offset','100%').attr('stop-color','#0B2C74').attr('stop-opacity',0);
                                var line = d3.line().x(function(d,i){ return x(labels[i]); }).y(function(d){ return y(d); }).curve(d3.curveMonotoneX);
                                var area = d3.area().x(function(d,i){ return x(labels[i]); }).y0(innerH).y1(function(d){ return y(d); }).curve(d3.curveMonotoneX);
                                g.append('path').datum(data).attr('fill','url(#trendGrad)').attr('d', area);
                                var path = g.append('path').datum(data).attr('fill','none').attr('stroke','#0B2C74').attr('stroke-width',2.5).attr('d', line);
                                var totalLen = path.node().getTotalLength();
                                path.attr('stroke-dasharray', totalLen+' '+totalLen).attr('stroke-dashoffset', totalLen)
                                    .transition().duration(900).ease(d3.easeCubicOut).attr('stroke-dashoffset', 0);
                                var points = g.selectAll('circle').data(data).enter().append('circle')
                                    .attr('cx', function(d,i){ return x(labels[i]); })
                                    .attr('cy', function(d){ return y(d); })
                                    .attr('r', 4)
                                    .attr('fill', '#0B2C74')
                                    .style('opacity', 0)
                                    .transition().delay(900).duration(250).style('opacity', 1);
                                var tip = d3.select('#'+elId).append('div').style('position','absolute').style('display','none').style('background','#fff').style('border','1px solid #e5e7eb').style('border-radius','8px').style('padding','6px 8px').style('box-shadow','0 10px 20px rgba(17,24,39,.12)').style('color','#0B2C74').style('font-weight','800').style('font-size','.85rem');
                                g.selectAll('circle').on('mouseenter', function(event, d){
                                    var i = Array.prototype.indexOf.call(points.nodes(), this);
                                    tip.style('display','block').html(labels[i]+': '+d);
                                    var bx = event.pageX, by = event.pageY;
                                    tip.style('left', (bx+12)+'px').style('top', (by-24)+'px');
                                }).on('mouseleave', function(){ tip.style('display','none'); });
                            })();
                        </script>
                    </div></div>
                </div>
            </section>

            <!-- User Management Section -->
            <section id="user-management" class="content-section {{ request('tab') == 'user-management' ? 'active' : '' }}">
                <div class="user-management-shell">
                    
                    @if(session('success_user'))
                        <div class="user-management-alert">
                            {{ session('success_user') }}
                        </div>
                    @endif

                    <!-- Search and Filter Section -->
                    <form id="filterForm" class="user-filter-panel" method="GET" action="{{ route('dashboard') }}">
                        <input type="hidden" name="tab" value="user-management">
                        <div class="user-filter-grid">
                            <div class="filter-field">
                                <label for="searchInput">Search Name</label>
                                <div class="filter-search-wrap">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Search by name..." class="filter-input">
                                </div>
                            </div>

                            <div class="filter-field">
                                <label for="filterDropdown">Filters</label>
                                <select id="filterDropdown" onchange="addFilter(this.value)" class="filter-select">
                                    <option value="">+ Add Filter</option>
                                    <optgroup label="Roles">
                                        <option value="role:admin">Admin</option>
                                        <option value="role:training_manager">Training Manager</option>
                                        <option value="role:coach">Coach</option>
                                        <option value="role:participant">Participant</option>
                                    </optgroup>
                                    <optgroup label="Status">
                                        <option value="status:active">Active</option>
                                        <option value="status:freeze">Blocked</option>
                                        <option value="status:pending">Pending</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="filter-field">
                                <label for="sortUsers">Sort By</label>
                                <select id="sortUsers" name="sort" onchange="document.getElementById('filterForm').dispatchEvent(new Event('change'))" class="filter-select">
                                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    <option value="alpha" {{ request('sort') === 'alpha' ? 'selected' : '' }}>Alphabetical (A–Z)</option>
                                </select>
                            </div>

                            <div class="filter-action">
                                <a href="{{ route('dashboard', ['tab' => 'user-management']) }}" class="btn-reset-filters">
                                    <i class="fas fa-rotate-left"></i>
                                    Reset Filters
                                </a>
                            </div>
                            <div id="activeFiltersContainer" class="active-filters-row"></div>
                        </div>

                        <!-- Hidden inputs for form submission -->
                        <div id="hiddenFilterInputs">
                            <input type="checkbox" name="roles[]" value="admin" class="filter-checkbox" {{ in_array('admin', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="registrar" class="filter-checkbox" {{ in_array('registrar', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="training_manager" class="filter-checkbox" {{ in_array('training_manager', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="trainer" class="filter-checkbox" {{ in_array('trainer', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="coach" class="filter-checkbox" {{ in_array('coach', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="trainee" class="filter-checkbox" {{ in_array('trainee', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="participant" class="filter-checkbox" {{ in_array('participant', request('roles', [])) ? 'checked' : '' }} hidden>

                            <input type="checkbox" name="statuses[]" value="active" class="filter-checkbox" {{ in_array('active', request('statuses', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="statuses[]" value="freeze" class="filter-checkbox" {{ in_array('freeze', request('statuses', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="statuses[]" value="pending" class="filter-checkbox" {{ in_array('pending', request('statuses', [])) ? 'checked' : '' }} hidden>
                        </div>
                    </form>

                    <div id="usersTableContainer">
                        @include('registrar.partials.users-table')
                    </div>
                </div>
            </section>

            <!-- Training Management Section -->
            <section id="trainer-trainee-management" class="content-section {{ request('tab') == 'trainer-trainee-management' ? 'active' : '' }}">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 class="welcome-title" style="margin: 0;">Training <strong>Management</strong></h1>
            <div style="position: relative; width: 220px;">
                <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                <select id="academicYearFilterTM" onchange="filterByAcademicYearTM(this.value)" style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; appearance: none; background: #fff; cursor: pointer;">
                    <option value="all" {{ $selectedYearId === 'all' ? 'selected' : '' }}>All Academic Years</option>
                    @foreach($academicYears as $ay)
                        <option value="{{ $ay->id }}" {{ $selectedYearId == $ay->id ? 'selected' : '' }}>
                            {{ $ay->year_start }} {{ $ay->is_active ? '(Active)' : '' }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
            </div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    @php
                        $totalCourses = (isset($courses) && $courses instanceof \Illuminate\Support\Collection) ? $courses->count() : 0;
                        $unpublishedCount = (isset($courses) && $courses instanceof \Illuminate\Support\Collection) ? $courses->filter(fn($c)=> !(bool)($c->is_published ?? false))->count() : 0;
                        $publishedCount = (isset($courses) && $courses instanceof \Illuminate\Support\Collection) ? $courses->filter(fn($c)=> (bool)($c->is_published ?? false))->count() : 0;
                    @endphp
                    <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#f8fafc">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#4f46e5"><i class="fas fa-layer-group"></i></div>
                                <div style="font-weight:700;color:#0f172a">Courses</div>
                            </div>
                            <div style="font-weight:800;font-size:1.4rem;color:#0f172a">{{ $totalCourses }}</div>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#fff7ed">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#ffedd5;color:#9a3412"><i class="fas fa-eye-slash"></i></div>
                                <div style="font-weight:700;color:#9a3412">Unpublished Courses</div>
                            </div>
                            <div style="font-weight:800;font-size:1.4rem;color:#9a3412">{{ $unpublishedCount }}</div>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#ecfdf5">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#d1fae5;color:#065f46"><i class="fas fa-bullhorn"></i></div>
                                <div style="font-weight:700;color:#065f46">Published Courses</div>
                            </div>
                            <div style="font-weight:800;font-size:1.4rem;color:#065f46">{{ $publishedCount }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fas fa-chalkboard-teacher" style="color:#002C76;"></i>
                            <h3 style="margin:0;color:#002C76;">Unpublished Courses</h3>
                        </div>
                        @php 
                            $draftCourses = (isset($courses) && $courses instanceof \Illuminate\Support\Collection) 
                                ? $courses->filter(fn($c)=> !(bool)($c->is_published ?? false))->values()
                                : collect();
                        @endphp
                        <span style="color:#6b7280;">Total: {{ $draftCourses->count() }}</span>
                    </div>
                    <a id="courses-section"></a>
                    @if(!isset($draftCourses) || $draftCourses->isEmpty())
                        <div style="padding:20px;border:1px dashed #e5e7eb;border-radius:8px;text-align:center;color:#6b7280;">
                            There are no courses found.
                        </div>
                    @else
                        <div class="course-grid">
                            @foreach($draftCourses as $course)
                                @php
                                    $coachRolesAll = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                                    $participantRolesAll = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
                                    $trainerCount = $course->users
                                        ? $course->users->filter(fn($u)=>in_array($u->role, $coachRolesAll) && (optional($u->pivot)->status ?? 'active') === 'active')->count()
                                        : 0;
                                    $traineeCount = $course->users
                                        ? $course->users->filter(fn($u)=>in_array($u->role, $participantRolesAll) && optional($u->pivot)->status === 'active')->count()
                                        : 0;
                                @endphp
                                <div class="course-card" style="cursor:pointer;position:relative" onclick="if(!event.target.closest('button') && !event.target.closest('form')) window.location='{{ route('registrar.courses.participants', $course) }}'">
                                    @php
                                        $img = $course->image_url;
                                    @endphp
                                    <div class="course-image">
                                        <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="course-content">
                                        <div class="course-title">{{ $course->name }}</div>
                                        <div class="course-sub">{{ $course->subject_area ?? 'Uncategorized' }}</div>
                                        <div class="course-footer" style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap">
                                        <div class="course-counts">
                                                <span title="Coaches"><i class="fas fa-user blue"></i> {{ $trainerCount }} <span class="count-label">{{ $trainerCount == 1 ? 'Coach' : 'Coaches' }}</span></span>
                                                <span title="Participants"><i class="fas fa-users green"></i> {{ $traineeCount }} <span class="count-label">{{ $traineeCount == 1 ? 'Participant' : 'Participants' }}</span></span>
                                        </div>
                                            <div style="display:flex;align-items:center;gap:8px">
                                                <span class="status-chip" style="padding:4px 10px;border-radius:999px;font-weight:700;background:#fff7ed;color:#9a3412;border:1px solid #fed7aa">
                                                    Unpublished
                                                </span>
                                                @if(Auth::user()->canManageTraining())
                                                @php
                                                    $currentTrainer = $course->users->filter(fn($u) => in_array($u->role, ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach']))->first();
                                                    $trainerId = $currentTrainer ? $currentTrainer->id : '';
                                                @endphp
                                                <button type="button" class="btn-view" style="background:#0f3b8f;border-color:transparent"
                                                    onclick="event.stopPropagation(); openPublishModal('{{ route('courses.publish', $course, false) }}','{{ addslashes($course->name) }}', '{{ $trainerId }}')">
                                                    <i class="fas fa-bullhorn"></i> Publish Course
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
            <!-- Publish Modal -->
            <div id="publishModal" class="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(2,6,23,.55);z-index:3000;align-items:center;justify-content:center;">
                <div id="publishModalCard" role="dialog" aria-modal="true" aria-labelledby="publishModalTitle" style="width:min(94vw, 500px); border-radius:24px; background:#fff; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); overflow:hidden; border:none;">
                    <div style="background:linear-gradient(135deg, #0f3b8f 0%, #1e40af 100%); padding:24px; color:white; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:rgba(255,255,255,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-bullhorn" style="font-size:1.2rem;"></i>
                            </div>
                            <div>
                                <h3 id="publishModalTitle" style="margin:0; font-size:1.1rem; font-weight:800; letter-spacing:-0.01em;">Publish Course</h3>
                                <div id="publishCourseName" style="font-size:0.8rem; opacity:0.9; font-weight:500; margin-top:2px;"></div>
                            </div>
                        </div>
                        <button type="button" onclick="closePublishModal()" style="background:rgba(255,255,255,0.1); border:none; color:white; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>

                    <form id="publishForm" method="POST" action="" style="padding:28px;">
                        @csrf
                        <input type="hidden" name="return_tab" value="trainer-trainee-management">
                        <input type="hidden" name="published" value="1">
                        
                        <div style="margin-bottom:24px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                                <label for="publishTrainer" style="font-size:0.9rem; color:#475569; font-weight:700; display:flex; align-items:center; gap:8px;">
                                    <i class="fas fa-user-tie" style="color:#0f3b8f;"></i> Select Coach
                                </label>
                                <a href="javascript:void(0)" onclick="showContent('user-management', document.querySelector('[onclick*=\'user-management\']'))" style="font-size:0.75rem; color:#0f3b8f; text-decoration:none; font-weight:700; background:#eff6ff; padding:4px 10px; border-radius:6px; transition:all 0.2s;">
                                    <i class="fas fa-plus" style="font-size:0.7rem;"></i> Add New
                                </a>
                            </div>
                            <div style="position:relative;">
                                <select id="publishTrainer" name="trainer_id" style="width:100%; padding:14px 16px; border:2px solid #f1f5f9; border-radius:14px; font-size:0.95rem; appearance:none; background:#f8fafc; cursor:pointer; transition:all 0.2s; color:#1e293b; font-weight:500; outline:none;" onfocus="this.style.borderColor='#0f3b8f'; this.style.background='#fff';" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc';">
                                    <option value="">-- No Coach Assigned --</option>
                                    @php
                                        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                                        $availableCoaches = (isset($potentialParticipants) ? $potentialParticipants : collect())->filter(fn($u) => in_array($u->role, $coachRoles))->sortBy('name');
                                    @endphp
                                    @foreach($availableCoaches as $coach)
                                        <option value="{{ $coach->id }}">{{ $coach->name }} ({{ ucwords(str_replace('_', ' ', $coach->role)) }})</option>
                                    @endforeach
                                </select>
                                <div style="position:absolute; right:16px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8;">
                                    <i class="fas fa-chevron-down" style="font-size:0.8rem;"></i>
                                </div>
                            </div>
                            @if($availableCoaches->isEmpty())
                                <div style="margin-top:10px; padding:12px; background:#fff7ed; border-radius:12px; border:1px solid #ffedd5; display:flex; gap:10px;">
                                    <i class="fas fa-exclamation-triangle" style="color:#f59e0b; margin-top:2px;"></i>
                                    <div style="font-size:0.8rem; color:#92400e; line-height:1.4;">
                                        <strong>No coaches found.</strong><br>
                                        Go to User Management to create or activate a coach account.
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div style="display:flex; gap:50px; margin-bottom:32px;">
                            <div style="flex:1;">
                                <label for="enrollStart" style="display:block; margin-bottom:10px; font-size:0.9rem; color:#475569; font-weight:700;">
                                    <i class="fas fa-calendar-alt" style="color:#0f3b8f; margin-right:6px;"></i> Start Date
                                </label>
                                <input id="enrollStart" name="enrollment_start_date" type="date" style="width:84%; padding:14px; border:2px solid #f1f5f9; border-radius:14px; font-size:0.95rem; background:#f8fafc; outline:none; transition:all 0.2s; color:#1e293b; font-weight:500;" onfocus="this.style.borderColor='#0f3b8f'; this.style.background='#fff';" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc';">
                            </div>
                            <div style="flex:1;">
                                <label for="enrollEnd" style="display:block; margin-bottom:10px; font-size:0.9rem; color:#475569; font-weight:700;">
                                    <i class="fas fa-flag-checkered" style="color:#0f3b8f; margin-right:6px;"></i> End Date
                                </label>
                                <input id="enrollEnd" name="enrollment_end_date" type="date" style="width:84%; padding:14px; border:2px solid #f1f5f9; border-radius:14px; font-size:0.95rem; background:#f8fafc; outline:none; transition:all 0.2s; color:#1e293b; font-weight:500;" onfocus="this.style.borderColor='#0f3b8f'; this.style.background='#fff';" onblur="this.style.borderColor='#f1f5f9'; this.style.background='#f8fafc';">
                            </div>
                        </div>

                        <div id="publishError" style="display:none; color:#ef4444; margin-bottom:24px; padding:14px; background:#fef2f2; border-radius:14px; font-size:0.85rem; font-weight:600; border:1px solid #fee2e2; align-items:center; gap:10px;">
                            <i class="fas fa-circle-exclamation"></i>
                            <span id="publishErrorText"></span>
                        </div>

                        <div style="display:flex; gap:12px;">
                            <button type="button" style="flex:1; background:#f1f5f9; color:#475569; border:none; padding:16px; border-radius:14px; font-weight:700; cursor:pointer; transition:all 0.2s; font-size:0.95rem;" onclick="closePublishModal()">
                                Cancel
                            </button>
                            <button id="publishSubmitBtn" type="submit" style="flex:2; background:#0f3b8f; color:#fff; border:none; padding:16px; border-radius:14px; font-weight:700; cursor:pointer; transition:all 0.2s; font-size:0.95rem; box-shadow:0 10px 15px -3px rgba(15,59,143,0.3);">
                                <i class="fas fa-check-circle" style="margin-right:8px;"></i> Confirm & Publish
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function openPublishModal(actionUrl, courseName, trainerId){
                    var m=document.getElementById('publishModal');
                    var f=document.getElementById('publishForm');
                    var name=document.getElementById('publishCourseName');
                    var err=document.getElementById('publishError');
                    var trainerSelect = document.getElementById('publishTrainer');
                    if(f){ f.setAttribute('action', actionUrl); }
                    if(name){ name.textContent = 'Course: '+courseName; }
                    if(err){ err.style.display='none'; err.textContent=''; }
                    if(trainerSelect){ trainerSelect.value = trainerId || ''; }
                    if(m){ m.style.display='flex'; }
                }
                function closePublishModal(){
                    var m=document.getElementById('publishModal');
                    if(m){ m.style.display='none'; }
                }
                (function(){
                    var form=document.getElementById('publishForm');
                    var btn=document.getElementById('publishSubmitBtn');
                    var err=document.getElementById('publishError');
                    var errText=document.getElementById('publishErrorText');
                    if(form){
                        form.addEventListener('submit', function(e){
                            var s=document.getElementById('enrollStart')?.value;
                            var t=document.getElementById('enrollEnd')?.value;
                            if(!s || !t){
                                e.preventDefault();
                                if(err){ err.style.display='flex'; }
                                if(errText){ errText.textContent='Please select both Start Date and End Date.'; }
                                return false;
                            }
                            if(new Date(t) < new Date(s)){
                                e.preventDefault();
                                if(err){ err.style.display='flex'; }
                                if(errText){ errText.textContent='End Date must be on or after Start Date.'; }
                                return false;
                            }
                            if(btn){ 
                                btn.disabled=true; 
                                btn.style.opacity='0.8';
                                btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Publishing…'; 
                            }
                        });
                    }
                })();
            </script>
            <section id="published-courses" class="content-section {{ request('tab') == 'trainer-trainee-management' ? 'active' : '' }}">
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-top:16px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fas fa-bullhorn" style="color:#0f3b8f;"></i>
                            <h3 style="margin:0;color:#002C76;">Published Courses</h3>
                        </div>
                        @php 
                            $pcs = (isset($publishedCourses) && $publishedCourses instanceof \Illuminate\Support\Collection) 
                                ? $publishedCourses 
                                : ((isset($courses) && $courses instanceof \Illuminate\Support\Collection) ? $courses->filter(fn($c)=> (bool)($c->is_published ?? false))->values() : collect());
                        @endphp
                        <span style="color:#6b7280;">Total: {{ $pcs->count() }}</span>
                    </div>
                    @if($pcs->isEmpty())
                        <div style="padding:20px;border:1px dashed #e5e7eb;border-radius:8px;text-align:center;color:#6b7280;">
                            No published courses yet.
                        </div>
                    @else
                        <div class="course-grid">
                            @foreach($pcs as $course)
                                @php
                                    $coachRolesAll = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                                    $participantRolesAll = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
                                    $trainerCount = $course->users
                                        ? $course->users->filter(fn($u)=>in_array($u->role, $coachRolesAll) && (optional($u->pivot)->status ?? 'active') === 'active')->count()
                                        : 0;
                                    $traineeCount = $course->users
                                        ? $course->users->filter(fn($u)=>in_array($u->role, $participantRolesAll) && optional($u->pivot)->status === 'active')->count()
                                        : 0;
                                    $img = $course->image_url;
                                @endphp
                                <div class="course-card" style="cursor:pointer;position:relative" onclick="if(!event.target.closest('button') && !event.target.closest('form')) window.location='{{ route('registrar.courses.participants', $course, false) }}'">
                                    <div class="course-image">
                                         <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                     </div>
                                    <div class="course-content">
                                        <div class="course-title">{{ $course->name }}</div>
                                        <div class="course-sub">{{ $course->subject_area ?? 'Uncategorized' }}</div>
                                        <div class="course-footer" style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap">
                                            <div class="course-counts">
                                                <span title="Coaches"><i class="fas fa-user blue"></i> {{ $trainerCount }} <span class="count-label">{{ $trainerCount == 1 ? 'Coach' : 'Coaches' }}</span></span>
                                                <span title="Participants"><i class="fas fa-users green"></i> {{ $traineeCount }} <span class="count-label">{{ $traineeCount == 1 ? 'Participant' : 'Participants' }}</span></span>
                                            </div>
                                            @php
                                                $s = optional($course->enrollment_start_at)->format('M d, Y');
                                                $e = optional($course->enrollment_end_at)->format('M d, Y');
                                            @endphp
                                            @if($s || $e)
                                                <div class="muted" style="font-size:.85rem;margin-top:6px">
                                                    <i class="fas fa-calendar-alt" style="color:#0f3b8f"></i>
                                                    <span style="margin-left:6px">Enrollment: {{ $s ?: '—' }} — {{ $e ?: '—' }}</span>
                                                </div>
                                            @endif
                                            <div style="display:flex;align-items:center;gap:8px">
                                                <span class="status-chip" style="padding:4px 10px;border-radius:999px;font-weight:700;background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0">
                                                    Published
                                                </span>
                                                @if(Auth::user()->canManageTraining())
                                                <form method="POST" action="{{ route('courses.publish', $course, false) }}" style="margin:0" data-confirm-message="Are you sure?" data-confirm-title="Confirm Action">
                                                    @csrf
                                                    <input type="hidden" name="return_tab" value="trainer-trainee-management">
                                                    <input type="hidden" name="published" value="0">
                                                    <button type="submit" class="btn-view" style="background:#ef4444;border-color:transparent" onclick="event.stopPropagation()">
                                                        <i class="fas fa-eye-slash"></i> Close Course
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
            <script>
                (function(){
                    function scrollToHash(){
                        if(location.hash){
                            var el = document.querySelector(location.hash);
                            if(el && typeof el.scrollIntoView==='function'){
                                el.scrollIntoView({behavior:'smooth', block:'start'});
                            }
                        }
                    }
                    if(document.readyState === 'loading'){
                        document.addEventListener('DOMContentLoaded', scrollToHash);
                    }else{
                        scrollToHash();
                    }
                })();
            </script>

            @if(Auth::user()->hasPermission('view_training'))
            <section id="course-management" class="content-section {{ request('tab') == 'course-management' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;"> <strong>Course Management</strong></h1>
                    <div style="display: flex; gap: 55px; align-items: center;">
                        <div style="position: relative; width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                            <input type="text" id="courseSearchInputTM" placeholder="Search courses..." style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; transition: border-color 0.2s ease;">
                        </div>
                        <div style="position: relative; width: 220px;">
                            <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                            <select id="academicYearFilterManagementTM" onchange="filterByAcademicYearCourseManagementTM(this.value)" style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; appearance: none; background: #fff; cursor: pointer;">
                                <option value="all" {{ $selectedYearId === 'all' ? 'selected' : '' }}>All Academic Years</option>
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $selectedYearId == $ay->id ? 'selected' : '' }}>
                                        {{ $ay->year_start }} {{ $ay->is_active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
                        </div>
                    </div>
                </div>

                @php
                    $activeCoursesCount = (isset($courses) && $courses instanceof \Illuminate\Support\Collection)
                        ? $courses->filter(fn($c) => (bool) ($c->is_published ?? false))->count()
                        : 0;
                    $pendingCoursesCountLocal = (isset($pendingCourses) && $pendingCourses instanceof \Illuminate\Support\Collection)
                        ? $pendingCourses->count()
                        : (int) ($pendingCoursesCount ?? 0);
                    $draftCoursesCount = (isset($courses) && $courses instanceof \Illuminate\Support\Collection)
                        ? $courses->filter(fn($c) => !(bool) ($c->is_published ?? false))->count()
                        : 0;
                    $archivedCoursesCount = (isset($archivedCourses) && $archivedCourses instanceof \Illuminate\Support\Collection)
                        ? $archivedCourses->count()
                        : 0;
                @endphp

                <div class="course-stats-grid">
                    <div class="course-stat-card active" role="button" tabindex="0"
                         onclick="showContent('course-management', null)"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Active Courses</p>
                            <p class="course-stat-value">{{ $activeCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-graduation-cap"></i></span>
                    </div>
                    <div class="course-stat-card pending" role="button" tabindex="0"
                         onclick="showContent('pending-courses', null)"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Pending Courses</p>
                            <p class="course-stat-value">{{ $pendingCoursesCountLocal }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-hourglass-half"></i></span>
                    </div>
                    <div class="course-stat-card draft" role="button" tabindex="0"
                         onclick="openDraftCoursesModal()"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Draft Courses</p>
                            <p class="course-stat-value">{{ $draftCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-file-pen"></i></span>
                    </div>
                    <div class="course-stat-card archived" role="button" tabindex="0"
                         onclick="showContent('archived-courses', null)"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Archived Courses</p>
                            <p class="course-stat-value">{{ $archivedCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-box-archive"></i></span>
                    </div>
                    <div class="course-stat-card library" role="button" tabindex="0"
                         onclick="showContent('course-library', null)"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Course Library</p>
                            <p class="course-stat-value">View</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-layer-group"></i></span>
                    </div>
                </div>

                @if(session('success_course'))
                    <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('success_course') }}
                    </div>
                @endif

                <div id="courseGridTM" class="course-grid">
                    @if(Auth::user()->hasPermission('create_courses'))
                        <a class="course-card add-course-card" href="javascript:void(0)" onclick="openAddCourseModalTM()" aria-label="Add Course" style="border:0;">
                            <span class="add-course-plus"><i class="fas fa-plus"></i></span>
                            <p class="add-course-title">Add Course</p>
                        </a>
                    @endif
                    @foreach(($courses ?? collect())->sortByDesc('created_at') as $course)
                        @php
                            $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                            $img = !empty($course->image_path) ? $course->image_url : null;
                            if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                $img = $course->image_path;
                            }
                            $startText = $course->start_date ? $course->start_date->format('M d, Y') : 'Not set';
                        @endphp
                        <a class="course-card js-course-card-tm" href="{{ route('admin.courses.show', $course) }}" data-course-name="{{ strtolower($course->name) }}" style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; cursor: pointer; height: 280px; display: flex; flex-direction: column;">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 160px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 160px; background:#eef4ff;"></div>
                            @endif
                            <div style="padding: 15px; display: flex; flex-direction: column; gap: 6px; flex: 1;">
                                <h3 style="margin: 0; color: var(--primary-blue); font-size: 1.05rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->name }}</h3>
                                <p style="color: var(--light-text); margin: 0; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
                                <div style="margin-top: auto; display: flex; flex-direction: column; gap: 4px;">
                                    <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        Created by: {{ $creator ? $creator->name : 'N/A' }}
                                    </div>
                                    <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        Start: {{ $startText }}
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; gap:10px;">
                                        @if(!$course->course_expiration_date)
                                            <span style="background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; padding: 4px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-calendar-times"></i> Set Expiration
                                            </span>
                                        @else
                                            <span style="color:var(--light-text);font-size:0.85rem;font-weight:600;white-space:nowrap;">Expires: {{ \Carbon\Carbon::parse($course->course_expiration_date)->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section id="course-create" class="content-section {{ request('tab') == 'course-create' ? 'active' : '' }}">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin:0;">Add <strong>Course</strong></h1>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <span id="tmDraftSavedIndicator" style="font-size:0.86rem;color:#64748b;font-weight:700;display:none;">Draft saved at <span id="tmDraftSavedTime"></span></span>
                        <button type="button" onclick="openImportCourseLibraryInCreateTM()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            Import from Course Library
                        </button>
                        <button type="button" onclick="showContent('course-management', document.querySelector(\".menu-item[onclick*='course-management']\"))" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Back to Course Management
                        </button>
                    </div>
                </div>
                <div class="course-create-shell">
                    <iframe id="courseCreateFrameTM" title="Create course form" src="{{ request('tab') == 'course-create' ? route('admin.courses.create', array_filter(['embedded' => 1, 'step' => request('step')])) : '' }}"></iframe>
                </div>
            </section>

            <section id="course-library" class="content-section {{ request('tab') == 'course-library' ? 'active' : '' }}">
                <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <h2 style="margin: 0; color: #002C76; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-layer-group" style="color: #10b981;"></i> Course Library
                            </h2>
                            <div style="display: flex; align-items: center; gap: 55px;">
                                <div style="position: relative; width: 300px;">
                                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                                    <input type="text" id="librarySearchInputTM" onkeyup="filterLibraryCoursesTM()" placeholder="Search library..." style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; transition: border-color 0.2s ease;">
                                </div>
                                <div style="position: relative; width: 220px;">
                                    <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                                    <select id="academicYearFilterLibraryTM" onchange="filterByAcademicYearCourseLibraryTM(this.value)" style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; appearance: none; background: #fff; cursor: pointer;">
                                        <option value="all" {{ $selectedYearId === 'all' ? 'selected' : '' }}>All Academic Years</option>
                                        @foreach($academicYears as $ay)
                                            <option value="{{ $ay->id }}" {{ $selectedYearId == $ay->id ? 'selected' : '' }}>
                                                {{ $ay->year_start }} {{ $ay->is_active ? '(Active)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="showContent('course-management', null)" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            Back to Course Management
                        </button>
                    </div>
                    <div style="padding: 24px; min-height: 60vh; background: #f8fafc;">
                        @php
                            $libraryCourses = isset($publishedCourses) ? $publishedCourses : collect([]);
                        @endphp
                        @if($libraryCourses->isEmpty())
                            <div style="color:#6c757d;font-style:italic;margin:0">There are no published courses in the library yet.</div>
                        @else
                            <div id="courseLibraryContainerTM" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px;">
                                @foreach($libraryCourses->sortByDesc('created_at') as $course)
                                    @php
                                        $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                                        $img = !empty($course->image_path) ? $course->image_url : null;
                                        if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                            $img = $course->image_path;
                                        }
                                        $startText = $course->start_date ? $course->start_date->format('M d, Y') : 'Not set';
                                    @endphp
                                    <a class="library-course-item js-library-course-tm" data-name="{{ strtolower($course->name) }}" href="{{ route('admin.courses.show', $course) }}" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.2s ease; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); text-decoration:none; display:flex; flex-direction:column; height:280px;">
                                        @if($img)
                                            <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 160px; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 160px; background:#eef4ff;"></div>
                                        @endif
                                        <div style="padding: 15px; display: flex; flex-direction: column; gap: 6px; flex: 1;">
                                            <h3 style="margin: 0; color: var(--primary-blue); font-size: 1.05rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->name }}</h3>
                                            <p style="color: var(--light-text); margin: 0; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
                                            <div style="margin-top: auto; display: flex; flex-direction: column; gap: 4px;">
                                                <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                    Created by: {{ $creator ? $creator->name : 'N/A' }}
                                                </div>
                                                <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                    Start: {{ $startText }}
                                                </div>
                                                @if($course->course_expiration_date)
                                                    <span style="color:var(--light-text);font-size:0.85rem;font-weight:600;white-space:nowrap;">Expires: {{ \Carbon\Carbon::parse($course->course_expiration_date)->format('M d, Y') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section id="pending-courses" class="content-section {{ request('tab') == 'pending-courses' ? 'active' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin: 0;">Pending <strong>Courses</strong></h1>
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="openDraftCoursesModal()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            Draft Courses
                        </button>
                        <button type="button" onclick="showContent('course-management', null)" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            Back to Course Management
                        </button>
                    </div>
                </div>

                @if(isset($pendingCourses) && $pendingCourses->count())
                    <div class="course-grid">
                        @foreach($pendingCourses as $course)
                            @php
                                $submitter = $course->users->first(function ($u) {
                                    return in_array(strtolower((string) $u->role), [
                                        'coach',
                                        'trainer',
                                        'central_office_coach',
                                        'regional_office_coach',
                                        'provincial_office_coach',
                                    ], true);
                                });
                            @endphp
                            <div class="course-card">
                                <div class="course-image" style="background-image:url('{{ $course->image_url }}')"></div>
                                <div class="course-content">
                                    <h3 class="course-title">{{ $course->name }}</h3>
                                    <div class="course-sub">{{ Str::limit($course->description, 120) }}</div>
                                    @if($submitter)
                                        <div class="course-sub" style="margin-top:-4px"><i class="fas fa-user"></i> Submitted by {{ $submitter->name }}</div>
                                    @endif
                                    <div class="course-footer">
                                        <div class="course-counts">
                                            <span style="font-weight:900;color:#f59e0b">Pending</span>
                                        </div>
                                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                                            <a class="btn-view" href="{{ route('admin.courses.show', $course) }}" style="min-width:auto;padding:10px 12px;text-decoration:none;background:#0ea5e9;box-shadow:0 6px 16px rgba(14,165,233,.18)"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('courses.restore', $course->id) }}" method="POST" data-confirm-message="Approve this course? It will be published." data-confirm-title="Approve Course" style="margin:0">
                                                @csrf
                                                <input type="hidden" name="return_tab" value="pending-courses">
                                                <button type="submit" class="btn-view" style="min-width:auto;padding:10px 12px;background:#10b981;box-shadow:0 6px 16px rgba(16,185,129,.18)"><i class="fas fa-check"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding:20px;border:1px dashed #e5e7eb;border-radius:8px;text-align:center;color:#6b7280;background:#fff">
                        There are no pending course submissions.
                    </div>
                @endif
            </section>

            <section id="archived-courses" class="content-section {{ request('tab') == 'archived-courses' ? 'active' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin: 0;">Archived <strong>Courses</strong></h1>
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="openDraftCoursesModal()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            Draft Courses
                        </button>
                        <button type="button" onclick="showContent('course-management', null)" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            Back to Course Management
                        </button>
                    </div>
                </div>

                @if(isset($archivedCourses) && $archivedCourses->count())
                    <div class="course-grid">
                        @foreach($archivedCourses as $course)
                            @php
                                $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                                $img = !empty($course->image_path) ? $course->image_url : null;
                                if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                    $img = $course->image_path;
                                }
                                $startText = $course->start_date ? $course->start_date->format('M d, Y') : 'Not set';
                            @endphp
                            <div class="course-card" style="position:relative">
                                <div class="course-image" style="background-image:url('{{ $img ?: '' }}');filter:grayscale(100%);"></div>
                                <div class="course-content">
                                    <h3 class="course-title">{{ $course->name }}</h3>
                                    <div class="course-sub">{{ Str::limit($course->description, 120) }}</div>
                                    <div style="margin-top:auto;display:flex;flex-direction:column;gap:4px">
                                        <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Created by: {{ $creator ? $creator->name : 'N/A' }}</div>
                                        <div style="color:var(--light-text);font-size:0.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Start: {{ $startText }}</div>
                                        <div class="course-footer" style="padding-top:10px">
                                            <span style="font-weight:900;color:#475569">Archived</span>
                                            <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end">
                                                <a class="btn-view" href="{{ route('admin.courses.show', $course) }}" style="min-width:auto;padding:10px 12px;text-decoration:none;background:#0ea5e9;box-shadow:0 6px 16px rgba(14,165,233,.18)">View</a>
                                                <form action="{{ route('courses.restore', $course->id) }}" method="POST" style="margin:0">
                                                    @csrf
                                                    <input type="hidden" name="return_tab" value="archived-courses">
                                                    <button type="submit" class="btn-view" style="min-width:auto;padding:10px 12px;background:#10b981;box-shadow:0 6px 16px rgba(16,185,129,.18)">Unarchive</button>
                                                </form>
                                                <form action="{{ route('courses.force-delete', $course->id) }}" method="POST" style="margin:0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-view" style="min-width:auto;padding:10px 12px;background:#dc2626;box-shadow:0 6px 16px rgba(220,38,38,.18)">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="color:#6c757d;font-style:italic;margin:0">There are no archived courses yet.</div>
                @endif
            </section>
            @endif

            <section id="activity-logs" class="content-section {{ request('tab') == 'activity-logs' ? 'active' : '' }}">
                <div style="background:#fff;padding:20px;border-radius:12px;box-shadow:0 10px 24px rgba(15,23,42,.08);">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <i class="fas fa-clock-rotate-left" style="color:#002C76;"></i>
                            <h3 style="margin:0;color:#002C76">Activity Logs</h3>
                        </div>
                        <span style="color:#6b7280">Recent</span>
                    </div>
                    @php
                        $actor = Auth::user();
                        $actorName = ($actor && in_array($actor->role,['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'])) ? $actor->name : 'Training Manager';
                        $logs = collect();
                        $recent = isset($notifications) ? $notifications->take(20) : collect();
                        foreach($recent as $n){
                            $logs->push([
                                'title' => $n->title,
                                'desc' => $n->message,
                                'time' => $n->created_at,
                            ]);
                        }
                        // Branch role sets
                        $levelRoles = [];
                        $coachLevelRoles = [];
                        $participantLevelRoles = [];
                        if($actor){
                            if ($actor->role === 'central_office_training_manager') {
                                $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                                $coachLevelRoles = ['central_office_coach'];
                                $participantLevelRoles = ['central_office_participants'];
                            } elseif ($actor->role === 'regional_office_training_manager') {
                                $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                                $coachLevelRoles = ['regional_office_coach'];
                                $participantLevelRoles = ['regional_office_participants'];
                            } elseif ($actor->role === 'provincial_office_training_manager') {
                                $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                                $coachLevelRoles = ['provincial_office_coach'];
                                $participantLevelRoles = ['provincial_office_participants'];
                            } else {
                                $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
                                $coachLevelRoles = ['coach','trainer'];
                                $participantLevelRoles = ['participant','trainee'];
                            }
                        }
                        // Approved/Updated users limited to branch
                        $approvedUsers = \App\Models\User::whereIn('role',$levelRoles)->where('status','active')->whereColumn('updated_at','>','created_at')->orderBy('updated_at','desc')->take(20)->get();
                        foreach($approvedUsers as $u){ $logs->push(['title'=>'Approved User','desc'=>$actorName.' approved '.$u->name,'time'=>$u->updated_at]); }
                        $updatedUsers = \App\Models\User::whereIn('role',$levelRoles)->whereColumn('updated_at','>','created_at')->orderBy('updated_at','desc')->take(20)->get();
                        foreach($updatedUsers as $u){
                            $logs->push(['title'=>'Edited Status','desc'=>$actorName.' set status to '.ucfirst($u->status).' for '.$u->name,'time'=>$u->updated_at]);
                            $logs->push(['title'=>'Edited Role','desc'=>$actorName.' set role to '.str_replace('_',' ', $u->role).' for '.$u->name,'time'=>$u->updated_at]);
                        }
                        // Coach assignments limited to branch
                        $coachAssignments = \DB::table('course_user')
                            ->join('courses','course_user.course_id','=','courses.id')
                            ->join('users','course_user.user_id','=','users.id')
                            ->whereIn('users.role',$coachLevelRoles)
                            ->select('courses.name as course_name','users.name as user_name','course_user.created_at as at')
                            ->orderBy('course_user.created_at','desc')
                            ->take(10)->get();
                        foreach($coachAssignments as $r){ $logs->push(['title'=>'Assigned Coach','desc'=>$actorName.' assigned coach '.$r->user_name.' to '.$r->course_name,'time'=>$r->at]); }
                        // Enrollments limited to branch
                        $enrollments = \DB::table('course_user')
                            ->join('courses','course_user.course_id','=','courses.id')
                            ->join('users','course_user.user_id','=','users.id')
                            ->whereIn('users.role',$participantLevelRoles)
                            ->where('course_user.status','active')
                            ->select('courses.name as course_name','users.name as user_name','course_user.created_at as at')
                            ->orderBy('course_user.created_at','desc')
                            ->take(10)->get();
                        foreach($enrollments as $r){ $logs->push(['title'=>'Enrolled Participant','desc'=>$actorName.' enrolled '.$r->user_name.' to '.$r->course_name,'time'=>$r->at]); }
                        $logs = $logs->sortByDesc('time')->take(30);
                    @endphp
                    <ul style="list-style:none;margin:0;padding:0;display:grid;gap:10px">
                        @forelse($logs as $l)
                            <li style="border:1px solid #e5e7eb;border-radius:12px;padding:12px;background:#fff;box-shadow:0 8px 20px rgba(17,24,39,.06)">
                                <div style="display:flex;align-items:center;justify-content:space-between">
                                    <div style="font-weight:800;color:#0B2C74">{{ $l['title'] }}</div>
                                    <span style="color:#94a3b8;font-size:.78rem">{{ \Carbon\Carbon::parse($l['time'])->diffForHumans() }}</span>
                                </div>
                                <div style="color:#64748b;font-size:.9rem;margin-top:6px">{{ $l['desc'] }}</div>
                            </li>
                        @empty
                            <li class="muted">No activity yet.</li>
                        @endforelse
                    </ul>
                </div>
            </section>

            <!-- Profile Section -->
            <section id="profile-section" class="content-section">
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
                            <i class="fas fa-triangle-exclamation"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif
                    <div class="profile-page-banner">
                        <div class="profile-page-avatar">
                            <img id="profile_preview" src="{{ Auth::user()->avatar_url }}" alt="Profile picture" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
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
                                <span class="profile-page-help">PNG or JPG, square crop works best.</span>
                            </div>
                        </div>
                    </div>
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="profile-page-grid">
                            <div class="profile-page-panel account-panel">
                                <div class="profile-page-panel-header profile-page-panel-header-rich">
                                    <span class="profile-page-header-icon" aria-hidden="true">
                                        <svg class="icon-feather" viewBox="0 0 24 24">
                                            <circle cx="12" cy="7" r="4"></circle>
                                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                                        </svg>
                                    </span>
                                    <div class="profile-page-panel-heading">
                                        <span class="profile-page-panel-title">Account</span>
                                        <span class="profile-page-panel-note">Identity and contact details</span>
                                    </div>
                                </div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label>Account ID</label>
                                        <div class="profile-input" style="background:#f1f5f9;color:#475569;cursor:not-allowed;display:flex;align-items:center;">{{ Auth::user()->status === 'pending' ? 'N/A' : (Auth::user()->account_id ?? 'N/A') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="profile-input">
                                    </div>
                                </div>
                            </div>
                            <div class="profile-page-panel location-panel">
                                <div class="profile-page-panel-header profile-page-panel-header-rich">
                                    <span class="profile-page-header-icon" aria-hidden="true">
                                        <svg class="icon-feather" viewBox="0 0 24 24">
                                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </span>
                                    <div class="profile-page-panel-heading">
                                        <span class="profile-page-panel-title">Location</span>
                                        <span class="profile-page-panel-note">Assigned service area details</span>
                                    </div>
                                </div>
                                <div class="profile-page-fields">
                                    @php
                                        $profileRegion = old('region', Auth::user()->region);
                                        $profileProvince = old('province', Auth::user()->province);
                                        $profileCity = old('city', Auth::user()->city);
                                        $profileBarangay = old('barangay', Auth::user()->barangay);
                                        $myRole = Auth::user()->role ?? '';
                                        $centralRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                                        $regionalRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                                        $provincialRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                                        $isCentral = in_array($myRole, $centralRoles, true);
                                        $isRegional = in_array($myRole, $regionalRoles, true);
                                        $isProvincial = in_array($myRole, $provincialRoles, true);
                                    @endphp
                                    <div class="form-group">
                                        @if($isCentral)
                                        <label>Office Level</label>
                                        @else
                                        <label>{{ ($isCentral || $isRegional || $isProvincial) ? 'Office Level' : 'Region' }}</label>
                                        @endif
                                        <select id="profile_region" name="{{ ($isCentral || $isRegional || $isProvincial) ? 'office_level' : 'region' }}" class="profile-input" data-selected="{{ $profileRegion }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>
                                                {{ ($isCentral || $isRegional || $isProvincial) ? 'Select Level' : 'Select Region' }}
                                            </option>
                                            @if($profileRegion)
                                                <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" @if(!$isRegional) style="display:none" @endif>
                                        <label>Region</label>
                                        <select id="profile_region_actual" name="region" class="profile-input" data-selected="{{ $isRegional ? (old('region', Auth::user()->region ?? '')) : '' }}" disabled>
                                            <option value="" disabled selected>Select Region</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        @if($isCentral)
                                        <label>Office Type</label>
                                        @else
                                        <label>Province</label>
                                        @endif
                                        <select id="profile_province" name="province" class="profile-input" data-selected="{{ $profileProvince }}" disabled>
                                            <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>
                                                {{ $isCentral ? 'Select Office Type' : 'Select Province' }}
                                            </option>
                                            @if($profileProvince)
                                                <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        @if($isCentral)
                                        <label>Service</label>
                                        @else
                                        <label>City / Municipality</label>
                                        @endif
                                        <select id="profile_city" name="city" class="profile-input" data-selected="{{ $profileCity }}" disabled>
                                            <option value="" disabled {{ $profileCity ? '' : 'selected' }}>
                                                {{ $isCentral ? 'Select Service' : 'Select City/Municipality' }}
                                            </option>
                                            @if($profileCity)
                                                <option value="{{ $profileCity }}" selected>{{ $profileCity }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <select id="profile_barangay" name="barangay" class="profile-input" data-selected="{{ $profileBarangay }}" disabled>
                                            <option value="" disabled {{ $profileBarangay ? '' : 'selected' }}>Select Barangay</option>
                                            @if($profileBarangay)
                                                <option value="{{ $profileBarangay }}" selected>{{ $profileBarangay }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="password_change_section" class="profile-page-panel profile-page-panel-wide" style="display:none">
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
                        </div>
                    </form>
                    <div class="profile-page-actions">
                        <button type="button" id="btnEditProfile" onclick="enableProfileEdit()" class="profile-page-btn edit">
                            <i class="fas fa-pen"></i>
                            Edit Profile
                        </button>
                        <button type="button" id="btnCancelProfile" onclick="cancelProfileEdit()" class="profile-page-btn cancel" style="display:none;">
                            <i class="fas fa-xmark"></i>
                            Cancel
                        </button>
                        <button type="submit" form="profileForm" id="btnSaveProfile" class="profile-page-btn save" style="display:none;">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </section>
            @if(request('tab') == 'help-support' || request('tab') == 'help_support')
                @include('dashboard.help-support')
            @endif
        </main>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="max-width: 720px; border-radius: 16px; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.12);">
            <span class="close" onclick="closeEditModal()" style="font-size: 24px; opacity: .6;">&times;</span>
            <h2 style="color: var(--primary-blue); margin-top: 0; font-size: 1.6rem;">Edit User</h2>
            <p style="margin: 6px 0 18px; color:#6c757d; font-size:.95rem;">Registrars can edit Role and Status only. Name and Email are view-only.</p>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_user_id">
                
                <div class="form-group">
                    <label for="edit_name" style="font-weight:600; color:#495057;">Name</label>
                    <input type="text" name="name" id="edit_name" readonly disabled
                           style="background:#f1f3f5; color:#6c757d; border:1px solid #e0e0e0; cursor:not-allowed;">
                </div>
                
                <div class="form-group">
                    <label for="edit_email" style="font-weight:600; color:#495057;">Email</label>
                    <input type="email" name="email" id="edit_email" readonly disabled
                           style="background:#f1f3f5; color:#6c757d; border:1px solid #e0e0e0; cursor:not-allowed;">
                </div>
                
                <div class="form-group">
                    <label for="edit_role" style="font-weight:600; color:#495057;">Role</label>
                    <select name="role" id="edit_role" required
                            style="background:#fff; border:1px solid #dee2e6; border-radius:10px; padding:12px;">
                        @foreach($availableRoles ?? [] as $role)
                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="display:flex; flex-direction:column; gap:8px;">
                    <label style="font-weight:600; color:#495057;">Field of Work</label>
                    <div class="fow-dropdown-container" id="edit-fow-dropdown">
                        <div class="fow-dropdown-trigger">
                            <span id="edit-fow-selected-text">Select Field of Work</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #94a3b8;"></i>
                        </div>
                        <div class="fow-dropdown-options">
                            @foreach($fieldOfWorks as $field)
                                <div class="fow-option" data-value="{{ $field->name }}" data-fow-id="{{ $field->id }}">
                                    {{ $field->name }}
                                </div>
                            @endforeach
                        </div>
                        @foreach($fieldOfWorks as $field)
                            @if($field->tooltip_content)
                                <div class="fow-tooltip" id="tooltip-{{ $field->id }}">
                                    <div class="fow-tooltip-title">Specific Types of Work:</div>
                                    <ul class="fow-tooltip-list">
                                        @foreach(explode("\n", str_replace("- ", "", $field->tooltip_content)) as $item)
                                            @if(trim($item))
                                                <li>{{ trim($item) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                        <input type="hidden" name="field_of_work" id="edit_field_of_work" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_status" style="font-weight:600; color:#495057;">Status</label>
                    <select name="status" id="edit_status" required
                            style="background:#fff; border:1px solid #dee2e6; border-radius:10px; padding:12px;">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="freeze">Blocked</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-update"
                        style="background: var(--primary-blue); color:#fff; border:none; padding:12px 18px; border-radius:12px; font-weight:600; box-shadow:0 6px 14px rgba(44,62,80,.18);">
                    Update User
                </button>
            </form>
        </div>
    </div>

    <!-- Draft Courses Modal -->
    <div id="draftCoursesModal" class="modal">
        <div class="modal-content" style="width: min(1000px, 95vw); max-height: 85vh; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                <h2 style="margin: 0; color: #002C76; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                    Draft Courses
                </h2>
                <button type="button" class="close" onclick="closeDraftCoursesModal()" style="font-size: 28px; background: none; border: none; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            <div style="padding: 24px; overflow-y: auto; background: #f8fafc; flex: 1;">
                <div id="draftCoursesModalContainer" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
                </div>
            </div>
            <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #fff; text-align: right;">
                <button type="button" onclick="closeDraftCoursesModal()" style="background: #64748b; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>

<script>
    function filterByAcademicYearTM(yearId) {
        const url = new URL(window.location.href);
        url.searchParams.set('academic_year_id', yearId);
        url.searchParams.set('tab', 'trainer-trainee-management');
        window.location.href = url.toString();
    }

    function filterByAcademicYearCourseManagementTM(yearId) {
        const url = new URL(window.location.href);
        url.searchParams.set('academic_year_id', yearId);
        url.searchParams.set('tab', 'course-management');
        window.location.href = url.toString();
    }

    function filterByAcademicYearCourseLibraryTM(yearId) {
        const url = new URL(window.location.href);
        url.searchParams.set('academic_year_id', yearId);
        url.searchParams.set('tab', 'course-library');
        window.location.href = url.toString();
    }

    (function(){
        function bindCourseSearch(){
            const input = document.getElementById('courseSearchInputTM');
            const grid = document.getElementById('courseGridTM');
            if(!input || !grid) return;
            input.addEventListener('input', function(){
                const q = String(input.value || '').toLowerCase().trim();
                const cards = grid.querySelectorAll('.js-course-card-tm');
                cards.forEach(card => {
                    const name = String(card.getAttribute('data-course-name') || '');
                    card.style.display = q ? (name.includes(q) ? '' : 'none') : '';
                });
            });
        }
        if(document.readyState === 'loading'){
            document.addEventListener('DOMContentLoaded', bindCourseSearch);
        }else{
            bindCourseSearch();
        }
    })();

    function filterLibraryCoursesTM() {
        const input = document.getElementById('librarySearchInputTM');
        const query = String(input ? input.value : '').toLowerCase().trim();
        const items = document.querySelectorAll('.js-library-course-tm');
        items.forEach(item => {
            const name = String(item.getAttribute('data-name') || '');
            item.style.display = query ? (name.includes(query) ? '' : 'none') : '';
        });
    }

    function toggleNotifications() {
        var dropdown = document.getElementById('notificationDropdown');
        if (!dropdown) return;
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
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
                var badge = document.querySelector('.notification-badge');
                if (badge) {
                    var count = parseInt(badge.innerText);
                    if (count > 1) {
                        badge.innerText = count - 1;
                        var headerCount = document.querySelector('.notification-header .chip-new');
                        if (headerCount) {
                            headerCount.innerText = (count - 1) + ' New';
                        }
                    } else {
                        badge.remove();
                        var headerCount = document.querySelector('.notification-header .chip-new');
                        if (headerCount) {
                            headerCount.innerText = '0 New';
                        }
                    }
                }
                
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

    document.addEventListener('click', function(event) {
        var container = document.querySelector('.notification-container');
        var dropdown = document.getElementById('notificationDropdown');
        
        if (container && !container.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const isMobile = window.innerWidth <= 992;

        if (isMobile) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('mobile-open');
            return;
        }

        sidebar.classList.toggle('collapsed');
        const collapsed = sidebar.classList.contains('collapsed');
        const header = document.querySelector('.header');
        const container = document.querySelector('.dashboard-container');
        const logo = document.querySelector('.sidebar-logo');
        const brand = document.querySelector('.sidebar-brand');
        if (collapsed) {
            sidebar.style.width = '70px';
            if (header) header.style.left = '70px';
            if (container) container.style.marginLeft = '70px';
            if (logo) {
                logo.style.height = '44px';
                logo.style.width = '44px';
                logo.style.display = 'block';
                logo.style.margin = '0 auto';
                const small = logo.getAttribute('data-collapsed-src');
                if (small) logo.src = small;
            }
            if (brand) brand.style.justifyContent = 'center';
            document.querySelectorAll('.menu-dropdown').forEach(function(p){ p.classList.remove('open'); });
        } else {
            sidebar.style.width = '250px';
            if (header) header.style.left = '250px';
            if (container) container.style.marginLeft = '250px';
            if (logo) {
                logo.style.height = '70px';
                logo.style.width = 'auto';
                logo.style.display = '';
                logo.style.margin = '';
                const full = logo.getAttribute('data-full-src');
                if (full) logo.src = full;
            }
            if (brand) brand.style.justifyContent = 'space-between';
        }
    }
    
    function togglePortalDropdown(ev, dropdownId) {
        if (ev) { ev.preventDefault(); ev.stopPropagation(); }
        const sidebar = document.getElementById('sidebar');
        if (sidebar && sidebar.classList.contains('collapsed')) return;
        const dd = document.getElementById(dropdownId);
        if (!dd) return;
        dd.classList.toggle('open');
    }

    function showContent(sectionId, menuItem) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.classList.remove('active');
        });

        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.add('active');
        }
        if (sectionId === 'trainer-trainee-management') {
            const published = document.getElementById('published-courses');
            if (published) {
                published.classList.add('active');
            }
        }

        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.classList.remove('active');
        });
        if (menuItem) {
            menuItem.classList.add('active');
        }
        const portal = menuItem ? menuItem.closest('.menu-dropdown') : null;
        if (portal && !(document.getElementById('sidebar')?.classList.contains('collapsed'))) portal.classList.add('open');

        // Update page title
        const titles = {
            'dashboard-home': 'Dashboard',
            'user-management': 'User Management',
            'trainer-trainee-management': 'Training Management',
            'course-management': 'Course Management',
            'course-create': 'Add Course',
            'pending-courses': 'Pending Courses',
            'archived-courses': 'Archived Courses',
            'course-library': 'Course Library'
        };
        const titleElement = document.getElementById('page-title');
        if (titleElement) {
            titleElement.textContent = titles[sectionId] || 'Dashboard';
        }

        // Keep address bar in sync with selected sidebar section.
        const url = new URL(window.location.href);
        if (sectionId === 'dashboard-home') {
            url.searchParams.delete('tab');
        } else {
            url.searchParams.set('tab', sectionId);
        }
        window.history.pushState({}, '', url.toString());

        // Close sidebar on mobile
        if (window.innerWidth <= 992) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('mobile-open');
            }
        }
    }

    function buildCourseCreateFrameUrlTM(options = {}) {
        const { bustCache = false } = options || {};
        const url = new URL(@json(route('admin.courses.create', ['embedded' => 1])));
        try {
            const topUrl = new URL(window.location.href);
            const step = topUrl.searchParams.get('step');
            if (step) url.searchParams.set('step', step);
        } catch (e) {}
        if (bustCache) url.searchParams.set('_', String(Date.now()));
        return url.toString();
    }

    function ensureCourseCreateFrameLoadedTM() {
        const frame = document.getElementById('courseCreateFrameTM');
        if (frame && !frame.getAttribute('src')) {
            frame.setAttribute('src', buildCourseCreateFrameUrlTM());
        }
    }

    function updateTMDraftSavedIndicator(timeText) {
        const wrap = document.getElementById('tmDraftSavedIndicator');
        const time = document.getElementById('tmDraftSavedTime');
        if (!wrap || !time) return;
        if (!timeText) {
            wrap.style.display = 'none';
            return;
        }
        time.textContent = String(timeText);
        wrap.style.display = 'inline';
    }

    window.addEventListener('message', function (event) {
        const data = event && event.data ? event.data : null;
        if (!data || typeof data !== 'object') return;
        if (data.type === 'course_draft_saved') {
            updateTMDraftSavedIndicator(data.time || '');
        }
    });

    function openImportCourseLibraryInCreateTM() {
        ensureCourseCreateFrameLoadedTM();
        showContent('course-create', document.querySelector(".menu-item[onclick*='course-management']"));
        const frame = document.getElementById('courseCreateFrameTM');
        if (!frame) return;
        const tryOpen = () => {
            try {
                if (frame.contentWindow && typeof frame.contentWindow.openImportLibraryModal === 'function') {
                    frame.contentWindow.openImportLibraryModal();
                    return true;
                }
            } catch (e) {}
            return false;
        };
        if (tryOpen()) return;
        frame.addEventListener('load', function onLoad() {
            frame.removeEventListener('load', onLoad);
            tryOpen();
        });
    }

    function openAddCourseModalTM(forceDraft = false, options = {}) {
        const { preserveState = false } = options || {};
        if (!forceDraft && !preserveState) {
            sessionStorage.setItem('load_draft', '0');
            sessionStorage.setItem('draft_course_key', 'draft_course_new_' + Date.now() + '_u_{{ auth()->id() }}');
        }
        updateTMDraftSavedIndicator('');
        const frame = document.getElementById('courseCreateFrameTM');
        if (frame) {
            const nextSrc = buildCourseCreateFrameUrlTM({ bustCache: !preserveState });
            if (preserveState) {
                if (!frame.getAttribute('src')) frame.src = nextSrc;
            } else {
                frame.src = nextSrc;
            }
        }
        showContent('course-create', document.querySelector(".menu-item[onclick*='course-management']"));
    }
    
    function showEditModal(user) {
        document.getElementById('edit_user_id').value = user.id;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_field_of_work').value = user.field_of_work || '';
        
        // Update custom dropdown text
        const selectedText = document.getElementById('edit-fow-selected-text');
        if (selectedText) {
            selectedText.textContent = user.field_of_work || 'Select Field of Work';
        }

        document.getElementById('edit_status').value = user.status;
        
        const form = document.getElementById('editForm');
        form.action = `/users/${user.id}`;
        
        document.getElementById('editModal').style.display = 'block';
    }
    
    // Add openEditModal alias since the button calls openEditModal
    const openEditModal = showEditModal;

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function showProfile() {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show profile section
        document.getElementById('profile-section').classList.add('active');
        
        // Deactivate all nav links
        document.querySelectorAll('.menu-item').forEach(link => {
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
            input.readOnly = false;
            input.style.backgroundColor = 'white';
            input.style.cursor = 'text';
        });
    }

    function cancelProfileEdit() {
        document.getElementById('btnEditProfile').style.display = 'inline-block';
        document.getElementById('btnCancelProfile').style.display = 'none';
        document.getElementById('btnSaveProfile').style.display = 'none';
        document.getElementById('profile_upload_container').style.display = 'none';
        document.getElementById('password_change_section').style.display = 'none';
        
        const inputs = document.querySelectorAll('.profile-input');
        inputs.forEach(input => {
            input.readOnly = true;
            input.style.backgroundColor = '#f8f9fa';
            input.style.cursor = 'default';
            input.value = input.defaultValue; // Reset to original value
        });
        
        // Reset image preview if changed
        const imgPreview = document.getElementById('profile_preview');
        const initialDiv = document.getElementById('profile_initials');
        
        location.reload(); 
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
                const scale=Math.min(1, maxDim/Math.max(bmp.width,bmp.height));
                const c=document.createElement('canvas'); c.width=Math.round(bmp.width*scale); c.height=Math.round(bmp.height*scale);
                const ctx=c.getContext('2d'); ctx.imageSmoothingQuality='high'; ctx.drawImage(bmp,0,0,c.width,c.height);
                return c.toDataURL('image/jpeg',0.92);
            }catch(e){}
        }
        const orientation = await readExifOrientation(file).catch(()=>1);
        const url=URL.createObjectURL(file);
        const im = await new Promise(function(res){ const t=new Image(); t.onload=function(){ res(t); }; t.src=url; });
        const iw=im.naturalWidth, ih=im.naturalHeight;
        const ratio=Math.min(1, maxDim/Math.max(iw,ih));
        let cw=Math.round(iw*ratio), ch=Math.round(ih*ratio);
        let c=document.createElement('canvas'), ctx=c.getContext('2d');
        if(orientation>=5&&orientation<=8){ c.width=ch; c.height=cw; } else { c.width=cw; c.height=ch; }
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
        URL.revokeObjectURL(url);
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
                    } else if((marker&0xFF00)!=0xFF00){ break; } else { offset+=view.getUint16(offset,false); }
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
    // Admin-like filtering logic (AJAX)
    function addFilter(value) {
        if (!value) return;
        const [type, val] = value.split(':');
        const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
        // Map UI role aliases to underlying role values supported by backend
        const roleMap = {
            'coach': 'coach',
            'participant': 'participant',
            'training_manager': 'training_manager',
            'trainer': 'coach',
            'trainee': 'participant',
            'super_admin': 'admin',
            'admin': 'admin',
            'central_office_admin': 'admin',
            'regional_office_admin': 'admin',
            'provincial_office_admin': 'admin',
            'central_office_coach': 'coach',
            'regional_office_coach': 'coach',
            'provincial_office_coach': 'coach',
            'central_office_participants': 'participant',
            'regional_office_participants': 'participant',
            'provincial_office_participants': 'participant',
            'central_office_training_manager': 'training_manager',
            'regional_office_training_manager': 'training_manager',
            'provincial_office_training_manager': 'training_manager'
        };
        const mappedVal = type === 'role' ? (roleMap[val] || val) : val;
        // For single-role view: uncheck other roles when selecting a role filter
        if (type === 'role') {
            document.querySelectorAll('input[name="roles[]"]').forEach(cb => { cb.checked = false; });
        }
        const checkbox = document.querySelector(`input[name="${inputName}"][value="${mappedVal}"]`);
        if (checkbox) {
            checkbox.checked = true;
            renderActiveFilters();
            checkbox.dispatchEvent(new Event('change'));
        }
        document.getElementById('filterDropdown').value = "";
    }

    function removeFilter(type, val) {
        const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
        const checkbox = document.querySelector(`input[name="${inputName}"][value="${val}"]`);
        if (checkbox) {
            checkbox.checked = false;
            renderActiveFilters();
            checkbox.dispatchEvent(new Event('change'));
        }
    }

    function renderActiveFilters() {
        const container = document.getElementById('activeFiltersContainer');
        if (!container) return;
        container.innerHTML = '';
        const checkboxes = document.querySelectorAll('#hiddenFilterInputs input[type="checkbox"]:checked');
        checkboxes.forEach(cb => {
            const type = cb.name === 'roles[]' ? 'role' : 'status';
            const val = cb.value;
            let label;
            if (val === 'freeze') {
                label = 'Blocked';
            } else if (val === 'training_manager') {
                label = 'Training Manager';
            } else if (val === 'participant') {
                label = 'Participant';
            } else {
                label = val.replace(/_/g, ' ');
                label = label.charAt(0).toUpperCase() + label.slice(1);
            }
            const chip = document.createElement('div');
            chip.className = 'active-filter-chip';
            chip.innerHTML = `
                <span>${label}</span>
                <button type="button" class="chip-remove" onclick="removeFilter('${type}', '${val}')" aria-label="Remove ${label} filter">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(chip);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderActiveFilters();

        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');
        const tableContainer = document.getElementById('usersTableContainer');
        const filterCheckboxes = document.querySelectorAll('.filter-checkbox');

        function fetchUsers(url) {
            tableContainer.style.opacity = '0.5';
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    tableContainer.style.opacity = '1';
                    window.history.pushState({}, '', url);
                    attachPaginationListeners();
                })
                .catch(() => { tableContainer.style.opacity = '1'; });
        }

        function buildQueryString() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            return '?' + params.toString();
        }

        // Debounced search
        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const url = "{{ route('dashboard') }}" + buildQueryString();
                fetchUsers(url);
            }, 300);
        });

        // Checkbox changes
        filterCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const url = "{{ route('dashboard') }}" + buildQueryString();
                fetchUsers(url);
            });
        });

        // Sort change via form 'change' event (triggered by select above)
        filterForm.addEventListener('change', function(e) {
            if (e.target && e.target.name === 'sort') {
                const url = "{{ route('dashboard') }}" + buildQueryString();
                fetchUsers(url);
            }
        });

        function attachPaginationListeners() {
            const links = tableContainer.querySelectorAll('.pagination a');
            links.forEach(link => {
                link.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    fetchUsers(this.href);
                });
            });
        }
        attachPaginationListeners();
    });

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    }
    
    document.addEventListener('DOMContentLoaded', function () {
        const requestedTab = new URLSearchParams(window.location.search).get('tab');
        
        // Set initial page title
        const titles = {
            'dashboard-home': 'Dashboard',
            'user-management': 'User Management',
            'trainer-trainee-management': 'Training Management',
            'course-management': 'Course Management',
            'course-create': 'Add Course',
            'pending-courses': 'Pending Courses',
            'archived-courses': 'Archived Courses',
            'course-library': 'Course Library',
            'activity-logs': 'Activity Logs'
        };
        const titleElement = document.getElementById('page-title');
        if (titleElement) {
            const tabKey = requestedTab || 'dashboard-home';
            titleElement.textContent = titles[tabKey] || 'Dashboard';
        }

        if (requestedTab === 'profile-section') {
            showProfile();
        }

        const forceProfile = {{ isset($forceProfile) && $forceProfile ? 'true' : 'false' }};
        if (forceProfile) {
            showProfile();
            alert('Please complete your profile to continue.');
        }
    });
    // Initialize PSGC location dropdowns for profile
    (function initRegistrarProfilePSGC(){
        const regionSelect = document.getElementById('profile_region');
        const regionActualSelect = document.getElementById('profile_region_actual');
        const provinceSelect = document.getElementById('profile_province');
        const citySelect = document.getElementById('profile_city');
        const barangaySelect = document.getElementById('profile_barangay');
        if (!regionSelect || regionSelect.dataset.initialized === 'true') return;
        regionSelect.dataset.initialized = 'true';
        const selectedRegion = regionSelect.dataset.selected || '';
        const selectedRegionActual = regionActualSelect?.dataset?.selected || '';
        const selectedProvince = provinceSelect?.dataset?.selected || '';
        const selectedCity = citySelect?.dataset?.selected || '';
        const selectedBarangay = barangaySelect?.dataset?.selected || '';
        const myRole = '{{ Auth::user()->role }}';
        const OFFICE_ROLES = {
            central: ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'],
            regional: ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'],
            provincial: ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants']
        };
        const IS_OFFICE = (role, group) => OFFICE_ROLES[group].includes(role);
        const isDILGMode = IS_OFFICE(myRole, 'central') || IS_OFFICE(myRole, 'regional') || IS_OFFICE(myRole, 'provincial');
        const BUREAUS = ['Bureau of Local Government Development','Bureau of Local Government Supervision','Bureau of Fire Protection','Bureau of Jail Management and Penology','National Police Commission','Philippine National Police','National Barangay Operations Office','Office of Project Development Services','Public Affairs and Communication Service'];
        const SERVICES = ['Administrative Service','Financial and Management Service','Information Systems and Technology Management Service','Internal Audit Service','Legal Service','Planning Service','Policy and Performance Monitoring Service','Local Government Capability Development Division'];
        const resetSelect = (sel, ph) => { if (!sel) return; sel.innerHTML = `<option value="" disabled selected>${ph}</option>`; };
        const addFallbackOption = (sel, val, label=val) => { if (!sel || !val) return null; const o=document.createElement('option'); o.value=val; o.textContent=label; o.selected=true; sel.appendChild(o); return o; };
        function loadBarangays(cityCode, selected=null){
            resetSelect(barangaySelect,'Select Barangay'); if (!cityCode){ if (selected) addFallbackOption(barangaySelect, selected); return; }
            fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`).then(r=>r.json()).then(data=>{ data.sort((a,b)=>a.name.localeCompare(b.name)); let matched=false; data.forEach(b=>{ const o=document.createElement('option'); o.value=b.name; o.textContent=b.name; if (selected && selected===b.name){ o.selected=true; matched=true; } barangaySelect.appendChild(o); }); if (selected && !matched) addFallbackOption(barangaySelect, selected); }).catch(()=>{ if (selected) addFallbackOption(barangaySelect, selected); });
        }
        function fetchCities(code, isRegion, selectedCity=null, selectedBrgy=null){
            const url = isRegion ? `{{ url('/psgc/regions') }}/${code}/cities` : `{{ url('/psgc/provinces') }}/${code}/cities`;
            resetSelect(citySelect,'Select City/Municipality'); resetSelect(barangaySelect,'Select Barangay');
            fetch(url).then(r=>r.json()).then(data=>{ data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedCode=''; let matched=false; data.forEach(c=>{ const o=document.createElement('option'); o.value=c.name; o.textContent=c.name; o.dataset.code=c.code; if (selectedCity && selectedCity===c.name){ o.selected=true; selectedCode=c.code; matched=true; } citySelect.appendChild(o); }); if (selectedCity && !matched) addFallbackOption(citySelect, selectedCity); if (selectedCode) loadBarangays(selectedCode, selectedBrgy); else if (selectedBrgy) addFallbackOption(barangaySelect, selectedBrgy); }).catch(()=>{ if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBrgy) addFallbackOption(barangaySelect, selectedBrgy); });
        }
        function loadProvincesByRegion(regionCode, selectedProv=null, selectedCity=null, selectedBrgy=null){
            resetSelect(provinceSelect, IS_OFFICE(myRole,'central')?'Select Office Type':(isDILGMode?'Select Office':'Select Province')); resetSelect(citySelect,'Select City/Municipality'); resetSelect(barangaySelect,'Select Barangay');
            if (!regionCode){ if (selectedProv) addFallbackOption(provinceSelect, selectedProv); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBrgy) addFallbackOption(barangaySelect, selectedBrgy); return; }
            if (isDILGMode){
                const provLabelNode = provinceSelect.closest('.form-group')?.querySelector('label'); if (provLabelNode) provLabelNode.textContent = IS_OFFICE(myRole,'central') ? 'Office Type' : 'Office';
                if (IS_OFFICE(myRole,'central')){
                    ['Bureaus','Services'].forEach(lbl=>{ const o=document.createElement('option'); o.value=lbl; o.textContent=lbl; provinceSelect.appendChild(o); });
                    provinceSelect.addEventListener('change', function(){ const cat=this.value; resetSelect(citySelect, cat==='Bureaus'?'Select Bureaus':'Select Services'); const list=cat==='Bureaus'?BUREAUS:SERVICES; let matched=false; list.forEach(item=>{ const o=document.createElement('option'); o.value=item; o.textContent=item; if (selectedProv && selectedProv===item){ o.selected=true; matched=true; } citySelect.appendChild(o); }); if (selectedProv && !matched) addFallbackOption(citySelect, selectedProv); const brgyGroup=barangaySelect.closest('.form-group'); if (brgyGroup) brgyGroup.style.display='none'; });
                    if (selectedProv){ const isB=BUREAUS.includes(selectedProv); provinceSelect.value=isB?'Bureaus':'Services'; provinceSelect.dispatchEvent(new Event('change')); }
                    return;
                }
                if (IS_OFFICE(myRole,'regional')){
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
                    return;
                }
                if (IS_OFFICE(myRole,'provincial')){
                    resetSelect(provinceSelect,'Select Office');
                    fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(async regions=>{
                        let items=[]; for (const reg of regions){ try{ const res=await fetch(`{{ url('/psgc/regions') }}/${reg.code}/provinces`); const data=await res.json(); items=items.concat(data.map(p=>({code:p.code,name:p.name}))); }catch(e){} }
                        items.sort((a,b)=>a.name.localeCompare(b.name)); let matched=false;
                        items.forEach(p=>{ const o=document.createElement('option'); o.value=`${p.name} Office`; o.textContent=`${p.name} Office`; o.dataset.code=p.code; if (selectedProv && (selectedProv===`${p.name} Office` || selectedProv===p.name)){ o.selected=true; matched=true; } provinceSelect.appendChild(o); });
                        if (selectedProv && !matched) addFallbackOption(provinceSelect, selectedProv);
                    }).catch(()=>{ if (selectedProv) addFallbackOption(provinceSelect, selectedProv); });
                    [citySelect, barangaySelect].forEach(s=>{ const g=s.closest('.form-group'); if (g) g.style.display='none'; });
                    return;
                }
            }
            fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`).then(r=>r.json()).then(data=>{ data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedCode=''; let matched=false; data.forEach(p=>{ const o=document.createElement('option'); o.value=p.name; o.textContent=p.name; o.dataset.code=p.code; if (selectedProv && selectedProv===p.name){ o.selected=true; selectedCode=p.code; matched=true; } provinceSelect.appendChild(o); }); if (selectedProv && !matched) addFallbackOption(provinceSelect, selectedProv); if (selectedCode) fetchCities(selectedCode, false, selectedCity, selectedBrgy); }).catch(()=>{ if (selectedProv) addFallbackOption(provinceSelect, selectedProv); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBrgy) addFallbackOption(barangaySelect, selectedBrgy); });
        }
        regionSelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; loadProvincesByRegion(code); });
        provinceSelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; const isRegion=this.options[this.selectedIndex]?.dataset?.isRegion==='true'; if (!code){ resetSelect(citySelect,'Select City/Municipality'); resetSelect(barangaySelect,'Select Barangay'); return; } fetchCities(code, isRegion); });
        citySelect.addEventListener('change', function(){ const code=this.options[this.selectedIndex]?.dataset?.code||''; loadBarangays(code); });
        if (isDILGMode){
            const label = IS_OFFICE(myRole,'central') ? 'DILG Central Office' : (IS_OFFICE(myRole,'regional') ? 'DILG Regional Office' : 'DILG Provincial Office');
            resetSelect(regionSelect,'Select Level'); const o=document.createElement('option'); o.value=label; o.textContent=label; o.selected=true; o.dataset.code='DILG'; regionSelect.appendChild(o);
            loadProvincesByRegion('DILG', selectedProvince || null, selectedCity || null, selectedBarangay || null);
            return;
        }
        fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(data=>{
            resetSelect(regionSelect,'Select Region'); data.sort((a,b)=>a.name.localeCompare(b.name)); let selectedCode=''; let matched=false;
            data.forEach(region=>{ const o=document.createElement('option'); o.value=region.name; o.textContent=region.name; o.dataset.code=region.code; if (selectedRegion && selectedRegion===region.name){ o.selected=true; selectedCode=region.code; matched=true; } regionSelect.appendChild(o); });
            if (selectedRegion && !matched) addFallbackOption(regionSelect, selectedRegion);
            if (selectedCode) loadProvincesByRegion(selectedCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
            else { if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay); }
        }).catch(()=>{ if (selectedRegion) addFallbackOption(regionSelect, selectedRegion); if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); if (selectedCity) addFallbackOption(citySelect, selectedCity); if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay); });
    })();
    function toggleProfileMenu(e){
        e.stopPropagation();
        var d=document.getElementById('profileDropdown');
        if(!d) return;
        d.style.display=(d.style.display==='block')?'none':'block';
    }
    function hideProfileMenu(){
        var d=document.getElementById('profileDropdown');
        if(d) d.style.display='none';
    }
    document.addEventListener('click',function(ev){
        var menu=document.querySelector('.profile-menu');
        var d=document.getElementById('profileDropdown');
        if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}

        // Handle custom dropdown close when clicking outside
        const fowDropdown = document.getElementById('edit-fow-dropdown');
        if (fowDropdown && !fowDropdown.contains(ev.target)) {
            fowDropdown.classList.remove('open');
        }
    });

    // Custom Dropdown JS for Registrar
    const editFowDropdown = document.getElementById('edit-fow-dropdown');
    if (editFowDropdown) {
        const trigger = editFowDropdown.querySelector('.fow-dropdown-trigger');
        const hiddenInput = document.getElementById('edit_field_of_work');
        const selectedText = document.getElementById('edit-fow-selected-text');
        const options = editFowDropdown.querySelectorAll('.fow-option');

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            editFowDropdown.classList.toggle('open');
        });

        options.forEach(option => {
                option.addEventListener('click', () => {
                    const value = option.dataset.value;
                    hiddenInput.value = value;
                    selectedText.textContent = value;
                    editFowDropdown.classList.remove('open');
                    // Hide all tooltips on selection
                    editFowDropdown.querySelectorAll('.fow-tooltip').forEach(t => t.classList.remove('visible'));
                });

                option.addEventListener('mouseenter', () => {
                    const fowId = option.dataset.fowId;
                    const tooltip = document.getElementById(`tooltip-${fowId}`);
                    if (tooltip) {
                        const optionRect = option.getBoundingClientRect();
                        const containerRect = editFowDropdown.getBoundingClientRect();
                        tooltip.style.top = `${optionRect.top - containerRect.top}px`;
                        tooltip.classList.add('visible');
                    }
                });

                option.addEventListener('mouseleave', () => {
                    const fowId = option.dataset.fowId;
                    const tooltip = document.getElementById(`tooltip-${fowId}`);
                    if (tooltip) {
                        tooltip.classList.remove('visible');
                    }
                });
            });
    }
</script>
</body>
</html>
