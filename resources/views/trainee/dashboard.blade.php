<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainee Dashboard - CAPDEV PRO</title>
    
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
            margin-left: var(--sidebar-width);
            transition: margin-left .3s ease;
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
        .header-section-title{margin-left:12px;font-size:1.1rem;color:var(--primary-blue);font-weight:700;letter-spacing:-.01em}

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
        .profile-menu{position:relative}
        .profile-dropdown{position:absolute;top:44px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            margin-left: var(--sidebar-width);
            transition: margin-left .3s ease;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            color: white;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            z-index: 900;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        .sidebar .header-title{display:flex;align-items:center;justify-content:center}
        .sidebar .header-title img{display:block;height:60px}
        .sidebar.collapsed .header-title{padding:12px 0}
        .sidebar.collapsed .header-title img{height:40px;margin:0 auto}

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

        .nav-item {
            border-bottom: 1px solid rgba(255,255,255,0.1);
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

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid var(--primary-green);
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .nav-icon {
            width: 25px;
            font-size: 1.1rem;
            text-align: center;
            margin-right: 15px;
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
        .bg-orange { background-color: #fff3e0; color: #f57c00; }
        .bg-purple { background-color: #f3e5f5; color: #7b1fa2; }

        /* Control Hero */
        .control-hero{background:linear-gradient(135deg,#002C76 0%, #0b57d0 55%, #1e88e5 100%);color:#fff;border-radius:14px;padding:22px;margin-bottom:24px;box-shadow:0 10px 24px rgba(0,0,0,.08)}
        .control-hero-top{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
        .control-hero-title{font-size:1.6rem;font-weight:800;letter-spacing:-.02em;margin:0}
        .control-hero-sub{opacity:.9;font-size:.95rem;margin-top:6px}
        .hero-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .hero-btn{border:1px solid rgba(255,255,255,.3);border-radius:999px;padding:10px 16px;font-weight:700;color:#fff;display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.06)}
        .hero-btn:hover{background:rgba(255,255,255,.12)}
        .hero-metrics{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-top:16px}
        .hero-metric{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);border-radius:12px;padding:12px}
        .hero-metric h4{margin:0 0 6px;font-size:.95rem;color:#fff}
        .hero-meter{height:8px;border-radius:999px;background:rgba(255,255,255,.25);overflow:hidden}
        .hero-meter > span{display:block;height:100%;background:#7fb73d;width:0}

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

        .section-title {
            font-size: 1.5rem;
            color: var(--primary-blue);
            font-weight: 700;
            margin: 0;
        }

        /* Course List */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 24px;
            align-items: stretch;
        }
        @media (min-width: 640px) { .course-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (min-width: 900px) { .course-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (min-width: 1200px){ .course-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        @media (min-width: 1400px){ .course-grid { grid-template-columns: repeat(5, minmax(0, 1fr)); } }

        .course-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            border: 1px solid #eef2f7;
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
        }

        .course-image {
            aspect-ratio: 16 / 9;
            background-color: #eef2f7;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        .course-content {
            padding: 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .course-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin: 0;
            line-height: 1.25;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-desc {
            color: #6b7280;
            font-size: 0.85rem;
            line-height: 1.4;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 6px;
        }

        .btn-view {
            padding: 8px 12px;
            background-color: var(--primary-blue);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-view:hover {
            background-color: #001f54;
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
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-confirm {
            background-color: var(--primary-green);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }

        .btn-cancel {
            background-color: #d9534f;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .curriculum-title{font-size:1.6rem;color:var(--dark-text);margin:0 0 16px}
        .acc-list{display:grid;gap:12px}
        .acc-item{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden}
        .acc-header{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;cursor:pointer}
        .acc-left{display:flex;align-items:center;gap:12px}
        .acc-icon{width:36px;height:36px;border-radius:50%;border:3px solid var(--primary-green);display:flex;align-items:center;justify-content:center;color:var(--primary-green);font-size:1rem}
        .acc-title{font-weight:700;color:var(--dark-text)}
        .acc-toggle{color:#9ca3af;transition:transform .2s ease}
        .acc-body{display:none;background:#fafafa;padding:0}
        .acc-item.open .acc-body{display:block}
        .topic-acc{border-top:1px solid #eef2f7}
        .topic-header{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;cursor:pointer;background:#fff}
        .topic-left{display:flex;align-items:center;gap:10px}
        .topic-bullet{width:22px;height:22px;border:2px solid #a7f3d0;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#10b981;font-size:.75rem}
        .topic-title{font-weight:600;color:#374151}
        .topic-toggle{color:#9ca3af;transition:transform .2s ease}
        .topic-body{display:none;background:#fafafa}
        .topic-acc.open .topic-body{display:block}
        .field-card{padding:14px 20px;border-top:1px solid #eef2f7;background:#fafafa}
        .field-question{padding:14px 20px;border-top:1px solid #eef2f7;background:#fff}
        .lock-msg{padding:16px 20px;border-top:1px solid #eef2f7;color:#6b7280;display:flex;align-items:center;gap:10px}
        .topic-acc.open .topic-toggle{transform:rotate(180deg)}
        .acc-item.open .acc-toggle{transform:rotate(180deg)}

        /* Calendar Styles */
        .calendar-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .calendar-month-year {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dark-text);
        }
        
        .calendar-nav-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--dark-text);
            padding: 5px 15px;
            border-radius: 5px;
        }
        
        .calendar-nav-btn:hover {
            background-color: #f0f0f0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #ddd;
            border-left: 1px solid #ddd;
        }

        .calendar-day-header {
            padding: 15px;
            text-align: center;
            font-weight: 500;
            background-color: white;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            color: var(--dark-text);
        }

        .calendar-day {
            min-height: 120px;
            padding: 8px;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            position: relative;
            background: white;
            transition: background-color 0.2s;
        }

        .calendar-day:hover {
            background-color: #f9f9f9;
        }

        .calendar-day.empty {
            background-color: #fcfcfc;
        }

        .calendar-day.today {
            background-color: #fffde7; /* Light yellow as in image */
        }

        .day-number {
            font-size: 0.95rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--dark-text);
        }

        .event-badge {
            display: block;
            background-color: var(--primary-green);
            color: white;
            font-size: 0.75rem;
            padding: 2px 5px;
            border-radius: 3px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
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

            .dashboard-container {
                flex-direction: column;
                overflow: visible;
                margin-left: 0;
            }

            .sidebar,
            .sidebar.collapsed {
                width: 100%;
                max-width: 100%;
                position: static;
            }

            .sidebar-toggle {
                display: inline-block;
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

            .stats-grid,
            .course-grid {
                gap: 14px;
            }

            .calendar-container {
                overflow-x: auto;
            }

            .calendar-grid {
                min-width: 680px;
            }

            .notification-dropdown {
                width: min(92vw, 320px) !important;
                right: 0 !important;
                left: auto !important;
            }

            table {
                min-width: 720px;
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
        body.sidebar-collapsed .header { margin-left: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .dashboard-container { margin-left: var(--sidebar-collapsed-width); }

        /* Profile Section (trainee aligned to admin design) */
        #profile-section .profile-page{display:flex;flex-direction:column;gap:24px}
        #profile-section .profile-page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap}
        #profile-section .profile-page-title{margin:0;font-size:2rem;color:var(--primary-blue);letter-spacing:-.02em}
        #profile-section .profile-page-subtitle{margin:6px 0 0;color:#6b7280;font-size:.95rem;max-width:560px}
        #profile-section .profile-page-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        #profile-section .profile-page-btn{border:1px solid transparent;border-radius:999px;padding:10px 18px;font-weight:600;font-size:.9rem;display:inline-flex;align-items:center;gap:8px;cursor:pointer;transition:transform .2s ease,box-shadow .2s ease,background .2s ease,color .2s ease,border-color .2s ease;box-shadow:0 6px 14px rgba(15,23,42,.12)}
        #profile-section .profile-page-btn:active{transform:translateY(1px);box-shadow:0 3px 8px rgba(15,23,42,.14)}
        #profile-section .profile-page-btn.edit{background:#fff7ed;color:#9a3412;border-color:#fed7aa}
        #profile-section .profile-page-btn.cancel{background:#f1f5f9;color:#475569;border-color:#e2e8f0}
        #profile-section .profile-page-btn.save{background:var(--primary-green);color:#fff}
        #profile-section .profile-page-btn.save:hover{background:#6aa832}
        #profile-section .profile-page-alert{display:flex;align-items:center;gap:10px;background:#ecfdf3;border:1px solid #bbf7d0;color:#166534;padding:12px 14px;border-radius:12px;font-weight:600;font-size:.92rem}
        #profile-section .profile-page-banner{display:flex;align-items:center;gap:20px;padding:20px;border-radius:16px;border:1px solid #e2e8f0;background:radial-gradient(circle at top left, rgba(127,183,61,.12), transparent 50%),radial-gradient(circle at top right, rgba(0,44,118,.12), transparent 48%),#fff;box-shadow:0 12px 24px rgba(15,23,42,.08)}
        #profile-section .profile-page-avatar{width:92px;height:92px;border-radius:22px;overflow:hidden;background:#e2e8f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:3px solid #fff;box-shadow:0 10px 18px rgba(15,23,42,.18)}
        #profile-section .profile-page-avatar img{width:100%;height:100%;object-fit:cover}
        #profile-section .profile-page-identity{flex:1;min-width:0}
        #profile-section .profile-page-name{font-size:1.4rem;color:var(--primary-blue);font-weight:700;margin-bottom:6px}
        #profile-section .profile-page-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap;color:#475569;font-size:.9rem}
        #profile-section .profile-page-chip{display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;background:#e8effd;color:#1e3a8a;font-weight:700;text-transform:uppercase;letter-spacing:.08em;font-size:.68rem}
        #profile-section .profile-page-upload{margin-top:12px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
        #profile-section .profile-page-upload input[type=file]{font-size:.82rem}
        #profile-section .profile-page-upload input[type=file]::file-selector-button{border:none;background:var(--primary-blue);color:#fff;padding:8px 12px;border-radius:8px;font-weight:600;cursor:pointer;margin-right:10px}
        #profile-section .profile-page-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
        #profile-section .profile-page-panel{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:16px;box-shadow:0 6px 14px rgba(15,23,42,.06)}
        #profile-section .profile-page-panel-wide{grid-column:1 / -1}
        #profile-section .profile-page-panel-header{display:flex;align-items:center;gap:10px;font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;color:#64748b;font-weight:700;margin-bottom:14px}
        #profile-section .profile-page-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 16px}
        #profile-section .profile-page-fields .form-group{margin-bottom:0}
        #profile-section .profile-page-fields label{display:block;margin-bottom:6px;color:#64748b;font-size:.72rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
        #profile-section .profile-input{width:100%;height:42px;padding:0 12px;border:1px solid #d7e0ea;border-radius:10px;box-sizing:border-box;background:#f8fafc;color:#0f172a;transition:border-color .2s ease,box-shadow .2s ease}
        #profile-section .profile-input:focus{outline:none;border-color:#2f5aa8;box-shadow:0 0 0 3px rgba(47,90,168,.15)}
        #profile-section .profile-input[readonly]{background:#f1f5f9;color:#475569;cursor:not-allowed}
        #profile-section .profile-page-help{color:#64748b;font-size:.8rem;display:block;margin-top:6px}
        @media(max-width:1100px){#profile-section .profile-page-grid{grid-template-columns:1fr}#profile-section .profile-page-fields{grid-template-columns:1fr}}
        @media(max-width:768px){#profile-section .profile-page-banner{flex-direction:column;align-items:flex-start}#profile-section .profile-page-actions{width:100%}}

    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()" style="color: var(--primary-blue); padding: 10px 14px; font-size: 1.2rem;">
                <i class="fas fa-bars"></i>
            </button>
            <div id="headerSectionTitle" class="header-section-title">Dashboard</div>
        </div>
        <div class="header-right">
            <!-- Notification Bell -->
            <div class="notification-container" style="position: relative; margin-right: 20px;">
                <div class="notification-bell" onclick="toggleNotifications()" style="cursor: pointer; position: relative; color: var(--primary-blue); font-size: 1.2rem;">
                    <i class="fas fa-bell"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="notification-badge" style="position: absolute; top: -8px; right: -8px; background-color: #d9534f; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; font-weight: bold;">{{ $unreadNotificationsCount }}</span>
                    @endif
                </div>
                
                <div id="notificationDropdown" class="notification-dropdown" style="display: none; position: absolute; top: 40px; right: 0; width: 300px; background-color: white; border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000; overflow: hidden;">
                    <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-weight: bold; color: var(--primary-blue); display: flex; justify-content: space-between; align-items: center;">
                        <span>Notifications</span>
                        <span style="font-size: 0.8rem; color: var(--light-text);">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }} New</span>
                    </div>
                    <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="notification-item" onclick="markAsRead('{{ $notification->id }}', '{{ $notification->link }}')" style="padding: 10px 15px; border-bottom: 1px solid #eee; cursor: pointer; background-color: {{ $notification->is_read ? 'white' : '#e3f2fd' }}; transition: background-color 0.2s;">
                                    <div style="font-size: 0.9rem; font-weight: bold; color: var(--dark-text); margin-bottom: 5px;">
                                        @if(!$notification->is_read) <span style="display: inline-block; width: 8px; height: 8px; background-color: #007bff; border-radius: 50%; margin-right: 5px;"></span> @endif
                                        {{ $notification->title }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 5px;">{{ $notification->message }}</div>
                                    <div style="font-size: 0.7rem; color: #aaa;">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        @else
                            <div style="padding: 20px; text-align: center; color: var(--light-text);">No notifications</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="profile-menu">
                <div class="user-profile" onclick="toggleProfileMenu(event)" style="cursor: pointer;">
                    @php
                        $avatarSrc = Auth::user()->profile_picture
                            ? asset('storage/' . Auth::user()->profile_picture)
                            : asset('images/user.png');
                    @endphp
                    <img src="{{ $avatarSrc }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    <i class="fas fa-chevron-down" style="font-size:.85rem;color:#666"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <a class="dropdown-item" href="{{ route('profile.setup') }}">
                        <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
                    </a>
                    <a class="dropdown-item" href="mailto:support@capdevpro.local">
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
            <div class="header-title" style="padding: 12px 25px; border-bottom:1px solid rgba(255,255,255,0.1);">
                <img id="sidebarLogo" src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro" style="height:60px">
            </div>
            <div style="padding: 12px 20px; display:flex; align-items:center; gap:12px; border-bottom:1px solid rgba(255,255,255,0.1);">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="showContent('dashboard-home', this)">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showContent('classroom', this)">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">Classroom</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showContent('calendar', this)">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-text">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showContent('announcements', this)">
                        <i class="fas fa-bullhorn nav-icon"></i>
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Dashboard Home Section -->
            <div id="dashboard-home" class="content-section {{ request('tab') ? '' : 'active' }}">
                <div class="control-hero">
                    <div class="control-hero-top">
                        <div>
                            <h1 class="control-hero-title">Welcome, {{ Auth::user()->name }}</h1>
                            <div class="control-hero-sub">Monitor your learning progress and quickly access your classes.</div>
                        </div>
                        <div class="hero-actions">
                            @if(isset($myCourses) && $myCourses->isNotEmpty())
                            <a class="hero-btn" href="#" onclick="showContent('classroom', document.querySelector('a[onclick*=\'classroom\']'))"><i class="fas fa-door-open"></i> Enter Classroom</a>
                            @else
                            <a class="hero-btn" href="#" style="pointer-events:none;opacity:.6"><i class="fas fa-door-open"></i> Enter Classroom</a>
                            @endif
                            <a class="hero-btn" href="#" onclick="showContent('announcements', document.querySelector('a[onclick*=\'announcements\']'))"><i class="fas fa-bullhorn"></i> Announcements</a>
                        </div>
                    </div>
                    <div class="hero-metrics">
                        <div class="hero-metric">
                            <h4>Available Courses</h4>
                            <div style="font-size:1.4rem;font-weight:800">{{ $totalAvailableCourses }}</div>
                            <div class="hero-meter"><span style="width: {{ min(100, ($totalAvailableCourses ?? 0)*10) }}%"></span></div>
                        </div>
                        <div class="hero-metric">
                            <h4>Courses Joined</h4>
                            <div style="font-size:1.4rem;font-weight:800">{{ $totalCoursesJoined }}</div>
                            <div class="hero-meter"><span style="width: {{ min(100, ($totalCoursesJoined ?? 0)*20) }}%"></span></div>
                        </div>
                        <div class="hero-metric">
                            <h4>Pending Enrollments</h4>
                            <div style="font-size:1.4rem;font-weight:800">{{ $pendingCoursesCount ?? 0 }}</div>
                            <div class="hero-meter"><span style="background:#f57c00;width: {{ min(100, ($pendingCoursesCount ?? 0)*20) }}%"></span></div>
                        </div>
                    </div>
                </div>
                @if(session('success_join'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    <i class="fas fa-check-circle"></i> {{ session('success_join') }}
                </div>
                @endif
                @if(session('error'))
                <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif

                <!-- Available Courses List -->
                <div class="section-header">
                    <h2 class="section-title">Available Courses</h2>
                </div>

                <div class="course-grid">
                    @forelse($availableCourses as $course)
                        <div class="course-card">
                            <div class="course-image" style="background-image: url('{{ $course->image_path ? asset('storage/' . $course->image_path) : 'https://via.placeholder.com/300x160?text=No+Image' }}');"></div>
                            <div class="course-content">
                                <div class="course-title">{{ $course->name }}</div>
                                <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                <div class="course-footer">
                                    <div style="display: flex; gap: 5px;">
                                        <button class="btn-view" style="background-color: var(--primary-green);" onclick="openEnrollModal({{ $course->id }})">Enroll Now</button>
                                        <button class="btn-view" onclick="openCourseDetails({{ $course->id }})">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>No available courses at the moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Enrolled Courses (Active Only) -->
                <div class="section-header">
                    <h2 class="section-title">Enrolled Courses</h2>
                </div>
                <div class="course-grid">
                    @forelse($myCourses as $course)
                        <div class="course-card">
                            <div class="course-image" style="background-image: url('{{ $course->image_path ? asset('storage/' . $course->image_path) : 'https://via.placeholder.com/300x160?text=No+Image' }}');"></div>
                            <div class="course-content">
                                <div class="course-title">{{ $course->name }}</div>
                                <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                <div class="course-footer">
                                    <span style="font-size: 0.8rem; color: #777;">
                                        <i class="fas fa-check-circle" style="color: var(--primary-green);"></i> Enrolled
                                    </span>
                                    <a class="btn-view" href="{{ route('trainee.courses.show', $course) }}">Enter Class</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 28px; color: #6b7280;">
                            <i class="fas fa-graduation-cap" style="font-size: 2.2rem; opacity: 0.6;"></i>
                            <div style="margin-top: 8px;">You are not enrolled in any active courses yet.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Classroom Section -->
            <div id="classroom" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">My Classroom</h2>
                </div>
                
                <div class="stats-grid" style="margin-top:-6px;margin-bottom:20px">
                    <div class="stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalCoursesJoined }}</h3>
                            <p>Courses Joined</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-orange">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $pendingCoursesCount ?? 0 }}</h3>
                            <p>Pending Enrolled Courses</p>
                        </div>
                    </div>
                </div>
                
                <div class="course-grid">
                    @forelse($classroomCourses as $course)
                        <div class="course-card">
                            <div class="course-image" style="background-image: url('{{ $course->image_path ? asset('storage/' . $course->image_path) : 'https://via.placeholder.com/300x160?text=No+Image' }}');"></div>
                            <div class="course-content">
                                <div class="course-title">{{ $course->name }}</div>
                                <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                <div class="course-footer">
                                    @php
                                        $st = $courseStatuses[$course->id] ?? 'active';
                                    @endphp
                                    @if($st === 'pending')
                                        <span style="font-size: 0.85rem; color: #f57c00; font-weight: 700;">Pending Approval</span>
                                        <a class="btn-view" href="{{ route('trainee.courses.show', $course) }}" style="pointer-events:none; opacity:.6;">Enter Class</a>
                                    @else
                                        <span style="font-size: 0.8rem; color: #777;">
                                            <i class="fas fa-check-circle" style="color: var(--primary-green);"></i> Enrolled
                                        </span>
                                        <a class="btn-view" href="{{ route('trainee.courses.show', $course) }}">Enter Class</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; background: white; padding: 40px; border-radius: 10px; text-align: center;">
                            <i class="fas fa-chalkboard-teacher" style="font-size: 4rem; color: var(--primary-blue); margin-bottom: 20px; opacity: 0.5;"></i>
                            <h3>No Active Classes Yet</h3>
                            <p style="color: #666;">Once your enrollment is approved by the registrar, your courses will appear here.</p>
                            <button class="btn-view" onclick="showContent('dashboard-home', document.querySelector('a[onclick*=\'dashboard-home\']'))" style="margin-top: 20px;">Browse Courses</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Calendar Section -->
            <div id="calendar" class="content-section">
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

                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-blue);">Upcoming Events</h3>
                    @if($calendarEvents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar" style="font-size: 3rem; color: var(--primary-green); margin-bottom: 10px;"></i>
                            <h3>No Events Scheduled</h3>
                            <p style="color: #666;">Upcoming class schedules and events will be displayed here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($calendarEvents as $event)
                                <div style="border-left: 4px solid var(--primary-green); background: #f9f9f9; padding: 15px; border-radius: 4px;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
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
                                        <div style="text-align: right; color: #777; font-size: 0.85rem;">
                                            <i class="fas fa-user"></i> {{ $event->user->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Announcements Section -->
            <div id="announcements" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Announcements</h2>
                </div>
                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    @if($announcements->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-bullhorn" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                            <h3>No Announcements</h3>
                            <p style="color: #666;">Important updates will be posted here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($announcements as $a)
                                <div style="border: 1px solid #eee; border-radius: 8px; padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <h3 style="margin: 0; color: var(--primary-blue);">{{ $a->title }}</h3>
                                        <span style="color: #777; font-size: 0.85rem;">{{ $a->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p style="margin-top: 10px; color: #444; white-space: pre-line;">{{ $a->message }}</p>
                                    <div style="margin-top: 8px; color: #777; font-size: 0.85rem;">
                                        <i class="fas fa-user"></i> Posted by {{ $a->user->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profile-section" class="content-section {{ request('tab') == 'profile-section' ? 'active' : '' }}">
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="profile-page">
                        <div class="profile-page-header">
                            <div>
                                <h1 class="profile-page-title">My Profile</h1>
                                <p class="profile-page-subtitle">Keep your account information current and review your access details in one place.</p>
                            </div>
                            <div class="profile-page-actions">
                                <button type="button" id="btnEditProfile" onclick="enableProfileEdit()" class="profile-page-btn edit">
                                    <i class="fas fa-pen"></i>
                                    Edit Profile
                                </button>
                                <button type="button" id="btnCancelProfile" onclick="cancelProfileEdit()" class="profile-page-btn cancel" style="display: none;">
                                    <i class="fas fa-xmark"></i>
                                    Cancel
                                </button>
                                <button type="submit" id="btnSaveProfile" class="profile-page-btn save" style="display: none;">
                                    <i class="fas fa-save"></i>
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        @if(session('success_profile'))
                            <div class="profile-page-alert">
                                <i class="fas fa-circle-check"></i>
                                <span>{{ session('success_profile') }}</span>
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

                                <div id="profile_upload_container" class="profile-page-upload" style="display: none;">
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" onchange="previewProfileImage(this)">
                                    <span class="profile-page-help">PNG or JPG, square crop works best.</span>
                                </div>
                            </div>
                        </div>

                        <div class="profile-page-grid">
                            <div class="profile-page-panel">
                                <div class="profile-page-panel-header">Account</div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="profile-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="profile-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Job Title</label>
                                        <input type="text" name="job_title" value="{{ Auth::user()->job_title ?? '' }}" readonly class="profile-input" placeholder="Not set">
                                    </div>
                                </div>
                            </div>

                            <div class="profile-page-panel">
                                <div class="profile-page-panel-header">Location</div>
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label>Region</label>
                                        <input type="text" name="region" value="{{ Auth::user()->region ?? '' }}" readonly class="profile-input" placeholder="Not set">
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <input type="text" name="province" value="{{ Auth::user()->province ?? '' }}" readonly class="profile-input" placeholder="Not set">
                                    </div>
                                    <div class="form-group">
                                        <label>City / Municipality</label>
                                        <input type="text" name="city" value="{{ Auth::user()->city ?? '' }}" readonly class="profile-input" placeholder="Not set">
                                    </div>
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <input type="text" name="barangay" value="{{ Auth::user()->barangay ?? '' }}" readonly class="profile-input" placeholder="Not set">
                                    </div>
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
                        </div>
                    </div>
                </form>
            </div>

            <!-- Course Details View -->
            <div id="course-details-view" class="content-section">
                <a onclick="showContent('dashboard-home', document.querySelector('a[onclick*=\'dashboard-home\']'))" class="back-link">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Dashboard
                </a>
                
                <!-- Course Header -->
                <div style="background: white; padding: 25px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div id="detail-header-icon" style="width: 60px; height: 60px; background: var(--primary-blue); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem;">
                            <i class="fas fa-chalkboard"></i>
                        </div>
                        <div>
                            <h1 id="detail-title" style="margin: 0 0 5px; color: var(--primary-blue); font-size: 1.8rem;">Course Title</h1>
                            <div style="color: var(--light-text); font-size: 0.9rem;">
                                <span id="detail-category-badge" style="background: #e9ecef; padding: 2px 8px; border-radius: 4px; font-weight: 500;">Category</span>
                                <span style="margin: 0 10px;">•</span>
                                <span id="detail-trainer">Trainer: </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div style="display: flex; border-bottom: 1px solid #ddd; margin-bottom: 25px; background: white; padding: 0 20px; border-radius: 10px 10px 0 0;">
                    <button class="tab-btn active" onclick="switchCourseTab('description')">Overview</button>
                    <button class="tab-btn" onclick="switchCourseTab('curriculum')">Curriculum</button>
                </div>

                <!-- Tab Contents -->
                <div style="background: white; padding: 30px; border-radius: 0 0 10px 10px; min-height: 400px;">
                    
                    <!-- Description Tab -->
                    <div id="tab-description" class="course-tab-content active">
                        <div class="detail-hero" id="detail-hero" style="margin-bottom: 30px; height: 250px;"></div>
                        
                        <h3 style="color: var(--primary-blue); margin-bottom: 15px;">About this Course</h3>
                        <p id="detail-description" style="line-height: 1.8; color: #444; white-space: pre-line; font-size: 1.05rem;">
                            Course description goes here...
                        </p>
                        <div id="detail-video-container" style="margin-top: 20px;"></div>

                        <div id="detail-enroll-container" style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #eee; border-radius: 8px; display: none; align-items: center; gap: 15px;">
                            <button id="detail-enroll-btn" class="btn-view" style="background-color: var(--primary-green); padding: 12px 25px; font-size: 1rem;" onclick="openEnrollModal()">
                                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>Enroll Now
                            </button>
                            <span id="detail-status-text" style="font-weight: bold; font-size: 1.1rem;"></span>
                        </div>

                        <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                            <h4 style="margin-top: 0; color: var(--dark-text);">Subject Areas</h4>
                            <p id="detail-subject-area" style="color: var(--light-text);">General</p>
                        </div>

                        <div style="margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #eee; border-radius: 8px;">
                            <h4 style="margin-top: 0; color: var(--dark-text);"></h4>
                            <div id="curriculum-list-overview" class="acc-list"></div>
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div id="tab-curriculum" class="course-tab-content">
                        <h3 class="curriculum-title">Here’s what you will learn.</h3>
                        <div id="curriculum-list" class="acc-list"></div>
                    </div>

                    <!-- Removed tabs: Classwork, People, Grades -->

                </div>
            </div>

        </div>
    </div>

    <!-- Enrollment Confirmation Modal -->
    <div id="enrollModal" class="modal-overlay">
        <div class="modal-container">
            <div style="margin-bottom: 20px;">
                <i class="fas fa-question-circle" style="font-size: 4rem; color: var(--primary-blue);"></i>
            </div>
            <h2 class="modal-title">Confirm Enrollment</h2>
            <p style="color: #666; margin-bottom: 25px;">Are you sure you want to enroll in this course?</p>
            
            <form id="enrollForm" method="POST" action="">
                @csrf
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeEnrollModal()">Cancel</button>
                    <button type="submit" class="btn-confirm">Yes, Enroll</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const storageBaseUrl = "{{ asset('storage') }}";
        const coursesData = {};
        const courseStatuses = @json($courseStatuses);
        @foreach($availableCourses as $course)
            coursesData[{{ $course->id }}] = @json($course);
        @endforeach

        const enrolledCourseIds = @json($myCourses->pluck('id'));
        const myCoursesFull = @json($myCourses);

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
            
            // This is a simplified reset. Ideally we'd revert to the server state, but reloading page is easiest or tracking original src.
            // For now, reload the page to cancel is the safest to reset everything including file input
            location.reload(); 
        }

        function previewProfileImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const imgPreview = document.getElementById('profile_preview');
                    const initialDiv = document.getElementById('profile_initials');
                    
                    if (initialDiv) initialDiv.style.display = 'none';
                    imgPreview.style.display = 'block';
                    imgPreview.src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleSidebar() {
            var s = document.getElementById('sidebar');
            if(s){ s.classList.toggle('collapsed'); }
            document.body.classList.toggle('sidebar-collapsed');
            var LOGO_MAIN = "{{ asset('images/CAPDEV-PRO-LOGO.png') }}";
            var LOGO_SMALL = "{{ asset('images/logo1.png') }}";
            var sidebarLogo = document.getElementById('sidebarLogo');
            var collapsed = document.body.classList.contains('sidebar-collapsed');
            if(sidebarLogo){ sidebarLogo.src = collapsed ? LOGO_SMALL : LOGO_MAIN; }
        }

        function showContent(sectionId, element) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Update nav active state
            if (element) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                element.classList.add('active');
            }
            var titleMap={'dashboard-home':'Dashboard','classroom':'Classroom','calendar':'Calendar','announcements':'Announcements','profile-section':'My Profile'};
            var titleEl=document.getElementById('headerSectionTitle');
            if(titleEl){ titleEl.textContent = titleMap[sectionId] || 'Dashboard'; }
        }

        function openCourseDetails(courseId) {
            // Check if it's an enrolled course first (has full data including users)
            let course = myCoursesFull.find(c => c.id === courseId);
            const isEnrolled = !!course;
            
            // If not found in enrolled, fallback to available courses (limited data)
            if (!course) {
                course = coursesData[courseId];
            }
            
            if (!course) return;
            
            currentCourseId = courseId;
            
            // Populate Header & Description
            document.getElementById('detail-title').innerText = course.name;
            document.getElementById('detail-description').innerText = course.description;
            document.getElementById('detail-category-badge').innerText = course.subject_area || 'General';
            document.getElementById('detail-subject-area').innerText = course.subject_area || 'General';
            document.getElementById('detail-trainer').innerText = "Trainer: " + (course.users && course.users.find(u => u.role === 'trainer') ? course.users.find(u => u.role === 'trainer').name : 'TBA');
            
            const hero = document.getElementById('detail-hero');
            if (course.image_path) {
                hero.style.backgroundImage = `url('${storageBaseUrl}/${course.image_path}')`;
            } else {
                hero.style.backgroundImage = "url('https://via.placeholder.com/800x300?text=No+Image')";
            }

            // Render curriculum accordions in both Overview and Curriculum tabs
            renderCurriculum(course.modules, isEnrolled, 'curriculum-list');
            renderCurriculum(course.modules, isEnrolled, 'curriculum-list-overview');
            enableCurriculumSelection('curriculum-list');
            enableCurriculumSelection('curriculum-list-overview');

            // Render course video if available
            const videoWrap = document.getElementById('detail-video-container');
            videoWrap.innerHTML = '';
            const isVideoFile = (p)=>/\.(mp4|webm|ogg)$/i.test(p||'');
            if (course.video_path && isVideoFile(course.video_path)) {
                const src = `${storageBaseUrl}/${course.video_path}`;
                videoWrap.innerHTML = `<video controls style="width:100%;max-height:360px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.08)"><source src="${src}"></video>`;
            } else if (course.video_url) {
                const url = course.video_url;
                if (/youtube\.com|youtu\.be/.test(url)) {
                    let id = null;
                    const yt = url.match(/(?:v=|youtu\.be\/)([A-Za-z0-9_-]+)/);
                    if (yt && yt[1]) id = yt[1];
                    const embed = id ? `https://www.youtube.com/embed/${id}` : url;
                    videoWrap.innerHTML = `<div style="position:relative;padding-top:56.25%"><iframe src="${embed}" title="Video" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:8px" allowfullscreen></iframe></div>`;
                } else if (isVideoFile(url)) {
                    videoWrap.innerHTML = `<video controls style="width:100%;max-height:360px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.08)"><source src="${url}"></video>`;
                } else {
                    videoWrap.innerHTML = `<a href="${url}" target="_blank" style="color: var(--primary-green); text-decoration: none;">Open course video</a>`;
                }
            }

            // Removed: population for People, Classwork, and Grades

            // Update Enroll Button inside Description
            const status = courseStatuses[courseId] || null;
            const enrollContainer = document.getElementById('detail-enroll-container');
            const enrollBtn = document.getElementById('detail-enroll-btn');
            const statusText = document.getElementById('detail-status-text');
            
            enrollContainer.style.display = 'flex'; // Default to visible container
            
            if (status === 'active') {
                enrollBtn.style.display = 'none';
                statusText.innerText = '✅ You are enrolled in this course';
                statusText.style.color = 'var(--primary-green)';
                enrollContainer.style.background = '#e8f5e9';
                enrollContainer.style.border = '1px solid #c8e6c9';
            } else if (status === 'pending') {
                enrollBtn.style.display = 'none';
                statusText.innerText = '⏳ Enrollment Pending Approval';
                statusText.style.color = '#f57c00';
                enrollContainer.style.background = '#fff3e0';
                enrollContainer.style.border = '1px solid #ffe0b2';
            } else {
                // Not enrolled
                enrollBtn.style.display = 'inline-block';
                statusText.innerText = 'Join this course to access materials and assessments.';
                statusText.style.color = '#666';
                enrollContainer.style.background = '#fff';
                enrollContainer.style.border = '1px solid #eee';
            }

            // Handle Enrolled vs Not Enrolled UI state
            // If not enrolled, maybe hide Classwork/People tabs or show them as locked?
            // The requirement didn't specify locking, but logically they should be accessible only if enrolled.
            // For now, I'll leave them accessible but they will be empty if data is missing.
            
            // Switch view
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.getElementById('course-details-view').classList.add('active');
            
            // Default to description tab
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
            } else {
                teachersList.innerHTML = '<p style="color: #777; font-style: italic;">Join class to view people.</p>';
            }
        }

        function renderMaterials(materials, isEnrolled = false) {
            const list = document.getElementById('materials-list');
            list.innerHTML = '';
            if (!isEnrolled) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-lock" style="font-size: 3rem; color: #dee2e6; margin-bottom: 15px;"></i><h3>Locked</h3><p>You must be enrolled to view materials.</p></div>';
            } else if (materials && materials.length > 0) {
                materials.forEach(mat => {
                    const path = mat.file_path || '';
                    const isVideo = /\.(mp4|webm|ogg)$/i.test(path);
                    const fileUrl = path ? `${storageBaseUrl}/${path}` : '';
                    if (isVideo && fileUrl) {
                        list.innerHTML += `
                            <div style="padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 10px;">
                                <div style="font-weight: 600; margin-bottom: 8px;">${mat.title || 'Video'}</div>
                                <video controls style="width:100%;max-height:360px;border-radius:6px">
                                    <source src="${fileUrl}">
                                </video>
                                ${mat.description ? `<div style="font-size:.85rem;color:#777;margin-top:6px;">${mat.description}</div>` : ''}
                            </div>`;
                    } else {
                        list.innerHTML += `
                            <div style="padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                                <div style="font-size: 1.5rem; color: var(--primary-blue);"><i class="fas fa-file-alt"></i></div>
                                <div>
                                    <div style="font-weight: bold;">${mat.title || 'Material'}</div>
                                    <div style="font-size: 0.85rem; color: #777;">${mat.description || ''}</div>
                                    ${fileUrl ? `<a href="${fileUrl}" target="_blank" style="color: var(--primary-green); text-decoration: none; font-size: 0.9rem;">View File</a>` : ''}
                                </div>
                            </div>`;
                    }
                });
            } else {
                list.innerHTML = '<p style="color: #999; text-align: center;">No materials uploaded yet.</p>';
            }
        }

        function renderAssessments(assessments, isEnrolled = false) {
            const list = document.getElementById('assessments-list');
            list.innerHTML = '';
            if (!isEnrolled) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-lock" style="font-size: 3rem; color: #dee2e6; margin-bottom: 15px;"></i><h3>Locked</h3><p>You must be enrolled to view assessments.</p></div>';
            } else if (assessments && assessments.length > 0) {
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

        document.addEventListener('DOMContentLoaded', function () {
            const requestedTab = new URLSearchParams(window.location.search).get('tab');
            if (requestedTab === 'profile-section') {
                showProfile();
            }

            const forceProfile = {{ isset($forceProfile) && $forceProfile ? 'true' : 'false' }};
            if (forceProfile) {
                showProfile();
                alert('Please complete your profile to continue.');
            }
        });

        function renderOutline(modules) {
            const container = document.getElementById('detail-outline');
            container.innerHTML = '';
            if (!modules || modules.length === 0) {
                container.innerHTML = '<p style="color:#777;">No outline provided.</p>';
                return;
            }
            modules.forEach((m, idx) => {
                const topicsHtml = (m.topics && m.topics.length) 
                    ? `<ul style="margin:8px 0 0 18px; color:#555;">${m.topics.map(t => `<li>${typeof t === 'string' ? t : (t.title || '')}</li>`).join('')}</ul>`
                    : '';
                container.innerHTML += `
                    <div style="border:1px solid #eee; border-radius:8px; padding:12px;">
                        <div style="font-weight:600; color:#002C76;">Module ${idx+1}: ${m.title || m.name || 'Untitled Module'}</div>
                        ${topicsHtml}
                    </div>
                `;
            });
        }

        function renderCurriculum(modules, isEnrolled, targetId='curriculum-list'){
            const list=document.getElementById(targetId);
            list.innerHTML='';
            if(!modules||modules.length===0){list.innerHTML='<p style="color:#777;">No curriculum available.</p>';return;}
            modules.forEach((m,idx)=>{
                const id=`acc-${idx}`;
                const topics=(m.topics&&m.topics.length)?m.topics:[];
                const body=topics.map((t,i)=>{
                    const tid=`${id}-t-${i}`;
                    const title=(typeof t==='string'?t:(t.title||'Topic'));
                    return `
                    <div class="topic-acc" id="${tid}">
                        <div class="topic-header" onclick="toggleTopic('${tid}')">
                            <div class="topic-left">
                                <div class="topic-bullet"><i class="fas fa-play" style="font-size:.6rem;"></i></div>
                                <div class="topic-title">${idx+1}.${i+1}. ${title}</div>
                            </div>
                            <div class="topic-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="topic-body">
                            ${renderTopicFields(t && (t.fields !== undefined ? t.fields : (t.fields_json ?? null)), isEnrolled)}
                        </div>
                    </div>`;
                }).join('');
                list.innerHTML+=`
                    <div class="acc-item" id="${id}">
                        <div class="acc-header" onclick="toggleCurriculum('${id}')">
                            <div class="acc-left">
                                <div class="acc-icon"><i class="fas fa-list"></i></div>
                                <div class="acc-title">${m.title||m.name||('Module '+(idx+1))}</div>
                            </div>
                            <div class="acc-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="acc-body">${body}</div>
                    </div>
                `;
            });
        }
        function toggleCurriculum(id){
            const item=document.getElementById(id);
            if(!item)return;
            item.classList.toggle('open');
        }
        function toggleTopic(id){
            const item=document.getElementById(id);
            if(!item)return;
            item.classList.toggle('open');
        }
        function enableCurriculumSelection(containerId){
            const container=document.getElementById(containerId);
            if(!container) return;
            container.addEventListener('click', (e)=>{
                const target=e.target.closest('.field-card,.field-question,.topic-acc,.acc-item');
                if(!target) return;
                container.querySelectorAll('.selected').forEach(n=>n.classList.remove('selected'));
                target.classList.add('selected');
            });
        }
        function renderTopicFields(fieldsJson, isEnrolled){
            if(!isEnrolled){
                return `<div class="lock-msg"><i class="fas fa-lock"></i> You must be enrolled to view this topic's content.</div>`;
            }
            if(!fieldsJson){ return `<div class="field-card" style="color:#777;">No fields added.</div>`; }
            let fields=[];
            try{
                fields = typeof fieldsJson==='string' ? JSON.parse(fieldsJson) : (fieldsJson||[]);
            }catch(e){
                return `<div class="field-card">${fieldsJson}</div>`;
            }
            if(!fields || fields.length===0){
                return `<div class="field-card" style="color:#777;">No fields added.</div>`;
            }
            return fields.map((f, idx)=>{
                const bg = (idx % 2 === 0) ? '#ffffff' : '#f8fafc';
                const baseStyle = `background:${bg};border:1px solid #eee;border-radius:8px;padding:12px;margin:8px 0;`;
                if(f.type==='text'){
                    return `<div class="field-card" style="${baseStyle}">${f.html||''}</div>`;
                } else if(f.type==='question' && f.question){
                    const q=f.question;
                    const group=`q_${Math.random().toString(36).slice(2)}`;
                    const opts=(q.options||[]).map((o,i)=>`
                        <label style="display:flex;align-items:center;gap:8px;margin:6px 0;">
                            <input type="radio" name="${group}" ${q.answer_index===i?'checked':''}>
                            <span>${o}</span>
                        </label>`).join('');
                    return `<div class="field-question" style="${baseStyle}">
                        <div style="font-weight:600;color:#111827;margin-bottom:6px;">${q.title||'Question'}</div>
                        <div>${opts}</div>
                    </div>`;
                } else {
                    return `<div class="field-card" style="${baseStyle}">${JSON.stringify(f)}</div>`;
                }
            }).join('');
        }

        function renderGrades(assessments) {
            const tbody = document.getElementById('grades-body');
            tbody.innerHTML = '';
            
            if (assessments && assessments.length > 0) {
                let hasGrades = false;
                assessments.forEach(ass => {
                    // Check if there are any grades for this assessment (already filtered by user_id in controller)
                    const grade = ass.grades && ass.grades.length > 0 ? ass.grades[0] : null;
                    const score = grade ? grade.score : '-';
                    const status = grade ? 'Graded' : 'Pending';
                    const statusColor = grade ? 'var(--primary-green)' : '#999';
                    
                    if (grade) hasGrades = true;

                    tbody.innerHTML += `
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: 500;">${ass.title}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">${ass.type.toUpperCase()}</span>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: var(--primary-blue);">${score}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <span style="color: ${statusColor}; font-weight: 500;">${status}</span>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" style="padding: 30px; text-align: center; color: #777;">No assessments found.</td></tr>';
            }
        }

        function switchCourseTab(tabName) {
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.tab-btn[onclick="switchCourseTab('${tabName}')"]`).classList.add('active');
            
            // Update tab content
            document.querySelectorAll('.course-tab-content').forEach(content => content.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
        }

        function switchClassworkSubTab(subTabName) {
            // Update sub-tab buttons
            document.querySelectorAll('.sub-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.sub-tab-btn[onclick="switchClassworkSubTab('${subTabName}')"]`).classList.add('active');
            
            // Update sub-tab content
            document.querySelectorAll('.classwork-subtab').forEach(content => content.classList.remove('active'));
            document.getElementById(`subtab-${subTabName}`).classList.add('active');
        }
        
        function openEnrollModal(courseId) {
            if (courseId) {
                currentCourseId = courseId;
            }
            if (!currentCourseId) return;
            
            const form = document.getElementById('enrollForm');
            form.action = `/courses/${currentCourseId}/join`;
            
            document.getElementById('enrollModal').style.display = 'flex';
        }
        
        function closeEnrollModal() {
            document.getElementById('enrollModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('enrollModal');
            if (event.target == modal) {
                closeEnrollModal();
            }
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
            renderCalendar();
        });
    // Notification Logic
    function toggleNotifications() {
        var dropdown = document.getElementById('notificationDropdown');
        if (dropdown.style.display === 'none') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
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
                var badge = document.querySelector('.notification-badge');
                if (badge) {
                    var count = parseInt(badge.innerText);
                    if (count > 1) {
                        badge.innerText = count - 1;
                        var headerCount = document.querySelector('.notification-dropdown span:last-child');
                        if (headerCount) {
                            headerCount.innerText = (count - 1) + ' New';
                        }
                    } else {
                        badge.remove();
                        var headerCount = document.querySelector('.notification-dropdown span:last-child');
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
            if (dropdown) dropdown.style.display = 'none';
        }
    });

    // Profile dropdown
    function toggleProfileMenu(e){
        e.stopPropagation();
        var d = document.getElementById('profileDropdown');
        if(!d) return;
        d.style.display = (d.style.display==='block') ? 'none' : 'block';
    }
    function hideProfileMenu(){
        var d = document.getElementById('profileDropdown');
        if(d) d.style.display = 'none';
    }
    document.addEventListener('click', function(ev){
        var menu = document.querySelector('.profile-menu');
        var d = document.getElementById('profileDropdown');
        if(menu && d && !menu.contains(ev.target)){
            d.style.display = 'none';
        }
    });

    </script>
</body>
</html>
