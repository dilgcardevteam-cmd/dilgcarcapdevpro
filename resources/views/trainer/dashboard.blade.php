<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard - CAPDEV PRO</title>
    
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

        /* Notification Styles */
        .notification-container {
            position: relative;
            margin-right: 10px;
        }
        
        .notification-bell {
            cursor: pointer;
            position: relative;
            color: var(--primary-blue);
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .notification-bell:hover {
            background-color: #f5f5f5;
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #d9534f;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            font-weight: bold;
            border: 2px solid white;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: -10px;
            width: 320px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .notification-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            color: var(--primary-blue);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .notification-item:hover {
            background-color: #f9f9f9;
        }

        .notification-item.unread {
            background-color: #e3f2fd;
        }

        .notification-item.unread:hover {
            background-color: #daeefc;
        }

        .notification-title {
            font-size: 0.9rem;
            font-weight: bold;
            color: var(--dark-text);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .unread-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #007bff;
            border-radius: 50%;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .notification-message {
            font-size: 0.85rem;
            color: var(--light-text);
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #999;
        }

        .empty-notifications {
            padding: 30px;
            text-align: center;
            color: var(--light-text);
            font-style: italic;
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
        }

        /* Hero */
        .control-hero{background:linear-gradient(135deg,#002C76 0%, #0b57d0 55%, #1e88e5 100%);color:#fff;border-radius:14px;padding:22px;margin-bottom:24px;box-shadow:0 10px 24px rgba(0,0,0,.08)}
        .control-hero-top{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
        .control-hero-title{font-size:1.6rem;font-weight:800;letter-spacing:-.02em;margin:0}
        .control-hero-sub{opacity:.9;font-size:.95rem;margin-top:6px}
        .hero-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .hero-btn{border:1px solid rgba(255,255,255,.3);border-radius:999px;padding:10px 16px;font-weight:700;color:#fff;display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.06)}
        .hero-btn:hover{background:rgba(255,255,255,.12)}

        .profile-menu{position:relative}
        .profile-dropdown{position:absolute;top:50px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
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
        .header-toggle{background:none;border:none;color:var(--primary-blue);font-size:1.3rem;padding:8px 12px;border-radius:6px;cursor:pointer}
        .header-toggle:hover{background:#f0f2f7}
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

        /* Course List */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            align-items: stretch;
        }
        @media (max-width: 1200px){
            .course-grid{grid-template-columns: repeat(3, minmax(0,1fr));}
        }
        @media (max-width: 900px){
            .course-grid{grid-template-columns: repeat(2, minmax(0,1fr));}
        }
        @media (max-width: 600px){
            .course-grid{grid-template-columns: 1fr;}
        }

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

        .course-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 8px;
        }
        .course-footer span{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:#e8f0ff;
            color:#0f3b8f;
            border:1px solid #cfe0ff;
            border-radius:999px;
            padding:6px 10px;
            font-weight:700;
            font-size:.85rem;
        }

        .btn-view {
            padding: 10px 16px;
            background-color: var(--primary-blue);
            color: white;
            text-decoration: none;
            border-radius: 999px;
            font-size: 0.95rem;
            transition: background .2s ease, transform .15s ease, box-shadow .2s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(0,44,118,.18);
            font-weight: 700;
        }

        .btn-view:hover {
            background-color: #001f54;
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(0,44,118,.22);
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

        .form-footer {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

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

            .stats-grid{gap:14px}
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

    </style>
</head>
<body>
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
                <div class="notification-bell" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                    @endif
                </div>
                
                <div id="notificationDropdown" class="notification-dropdown">
                    <div class="notification-header">
                        <span>Notifications</span>
                        <span style="font-size: 0.8rem; color: var(--light-text); background: #eee; padding: 2px 8px; border-radius: 10px;">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }} New</span>
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
                                    <div class="notification-time">
                                        <i class="far fa-clock" style="margin-right: 3px;"></i> {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-notifications">
                                <i class="far fa-bell-slash" style="font-size: 2rem; color: #ddd; margin-bottom: 10px; display: block;"></i>
                                No notifications yet
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="profile-menu">
                <div class="profile-trigger" onclick="toggleProfileMenu()">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" style="width:35px;height:35px;border-radius:50%;object-fit:cover">
                    @else
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U',0,1)) }}
                        </div>
                    @endif
                    <i class="fas fa-chevron-down profile-caret"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <a class="dropdown-item" href="{{ route('profile.setup') }}">
                        <i class="fas fa-user-cog"></i> <span>Profile</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('trainer.courses.create') }}">
                        <i class="fas fa-plus-circle"></i> <span>Create Course</span>
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
            <div class="sidebar-brand">
                <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="showContent('dashboard-home', this)">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showContent('my-courses', this)">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">My Courses</span>
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
            <div id="dashboard-home" class="content-section active">
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
                        <div>
                            <h1 class="control-hero-title">Welcome, {{ Auth::user()->name }}</h1>
                            <div class="control-hero-sub">Monitor learning outcomes and efficiently manage classes.</div>
                        </div>
                        <div class="hero-actions">
                            <a class="hero-btn" href="#" onclick="showContent('my-courses', document.querySelector('a[onclick*=\'my-courses\']'))"><i class="fas fa-chalkboard-teacher"></i> Manage Courses</a>
                            <a class="hero-btn" href="#" onclick="showContent('calendar', document.querySelector('a[onclick*=\'calendar\']'))"><i class="fas fa-calendar-alt"></i> Calendar</a>
                            <a class="hero-btn" href="#" onclick="showContent('announcements', document.querySelector('a[onclick*=\'announcements\']'))"><i class="fas fa-bullhorn"></i> Announcements</a>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon bg-blue">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalCoursesTeaching }}</h3>
                            <p>Courses Teaching</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalStudents }}</h3>
                            <p>Total Students</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-blue">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ isset($calendarEvents) ? $calendarEvents->count() : 0 }}</h3>
                            <p>Upcoming Events</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }}</h3>
                            <p>New Notifications</p>
                        </div>
                    </div>
                </div>

                <!-- Course List (Shortcut) -->
                <div class="section-header">
                    <h2 class="section-title">Dashboard</h2>
                </div>

                <div class="course-grid">
                    @forelse($myCourses as $course)
                        <div class="course-card">
                            @php
                                $courseImage = null;
                                if ($course->image_path) {
                                    $courseImage = asset('storage/' . $course->image_path);
                                } else {
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
                            <div class="course-image" style="background-image: url('{{ $courseImage }}');"></div>
                            <div class="course-content">
                                <div class="course-title">{{ $course->name }}</div>
                                <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                <div class="course-footer">
                                    <span style="font-size: 0.8rem; color: #777;">
                                        <i class="fas fa-users"></i> {{ $course->users->where('role', 'trainee')->count() }} Students
                                    </span>
                                    <a class="btn-view" href="{{ route('trainer.courses.enter', $course) }}">Enter Class</a>
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

            <!-- My Courses Section (Same as above but dedicated page) -->
            <div id="my-courses" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">My Courses</h2>
                </div>
                
                <div class="course-grid">
                    @forelse($myCourses as $course)
                        <div class="course-card">
                            @php
                                $courseImage = null;
                                if ($course->image_path) {
                                    $courseImage = asset('storage/' . $course->image_path);
                                } else {
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
                            <div class="course-image" style="background-image: url('{{ $courseImage }}');"></div>
                            <div class="course-content">
                                <div class="course-title">{{ $course->name }}</div>
                                <div class="course-desc">{{ Str::limit($course->description, 100) }}</div>
                                <div class="course-footer">
                                    <span style="font-size: 0.8rem; color: #777;">
                                        <i class="fas fa-users"></i> {{ $course->users->where('role', 'trainee')->count() }} Students
                                    </span>
                                    <a class="btn-view" href="{{ route('trainer.courses.enter', $course) }}">Enter Class</a>
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
                    @if($calendarEvents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar" style="font-size: 3rem; color: var(--primary-green); margin-bottom: 10px;"></i>
                            <h3>No Events Scheduled</h3>
                            <p style="color: #666;">Add events to display them here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($calendarEvents as $event)
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
                                    <form action="{{ route('trainer.calendar-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    @if(session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
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
            <div id="profile-section" class="content-section">
                <div class="section-header">
                    <h2 class="section-title">My Profile</h2>
                </div>
                <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div style="display: flex; align-items: center; margin-bottom: 30px;">
                            <div style="position: relative; margin-right: 20px;">
                                @if(Auth::user()->profile_picture)
                                    <img id="profile_preview" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-blue);">
                                @else
                                    <div id="profile_initials" style="width: 100px; height: 100px; background-color: var(--primary-blue); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 3rem;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <img id="profile_preview" src="" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-blue); display: none;">
                                @endif
                                
                                <div id="profile_upload_container" style="display: none; margin-top: 10px; text-align: center;">
                                    <label for="profile_picture_input" style="cursor: pointer; color: var(--primary-blue); font-size: 0.9rem; font-weight: 500;">
                                        <i class="fas fa-camera"></i> Change Photo
                                    </label>
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" onchange="previewProfileImage(this)" style="display: none;">
                                </div>
                            </div>
                            <div>
                                <h2 style="margin: 0; color: var(--primary-blue);">{{ Auth::user()->name }}</h2>
                                <p style="margin: 5px 0 0; color: var(--light-text);">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <div style="margin-left: auto;">
                                <button type="button" id="btnEditProfile" class="btn-view" onclick="enableProfileEdit()">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </button>
                                <button type="button" id="btnCancelProfile" class="btn-cancel" onclick="cancelProfileEdit()" style="display: none; margin-right: 10px; background-color: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">
                                    Cancel
                                </button>
                                <button type="submit" id="btnSaveProfile" class="btn-confirm" style="display: none; background-color: var(--primary-green); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control profile-input" value="{{ Auth::user()->name }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control profile-input" value="{{ Auth::user()->email }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Region</label>
                                <input type="text" name="region" class="form-control profile-input" value="{{ Auth::user()->region ?? '' }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-control profile-input" value="{{ Auth::user()->province ?? '' }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">City / Municipality</label>
                                <input type="text" name="city" class="form-control profile-input" value="{{ Auth::user()->city ?? '' }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="barangay" class="form-control profile-input" value="{{ Auth::user()->barangay ?? '' }}" readonly style="background-color: #f8f9fa; cursor: default;">
                            </div>
                        </div>

                        <div id="password_change_section" style="display: none; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                            <h3 style="color: var(--primary-blue); font-size: 1.1rem; margin-bottom: 15px;">Change Password <small style="color: #666; font-weight: normal; font-size: 0.8rem;">(Leave blank to keep current)</small></h3>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control profile-input">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control profile-input">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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
                input.readOnly = false;
                input.style.backgroundColor = 'white';
                input.style.cursor = 'text';
            });
        }

        function cancelProfileEdit() {
            // Reload to reset everything including file inputs and previews
            window.location.reload();
        }

        function previewProfileImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    var preview = document.getElementById('profile_preview');
                    var initials = document.getElementById('profile_initials');
                    
                    if (initials) initials.style.display = 'none';
                    
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleSidebar() {
            var s=document.getElementById('sidebar');
            s.classList.toggle('collapsed');
            var collapsed=s.classList.contains('collapsed');
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            var logo=document.querySelector('.sidebar-logo');
            if(logo){
                var full=logo.getAttribute('data-full-src');
                var small=logo.getAttribute('data-collapsed-src');
                logo.src=collapsed?small:full;
            }
        }

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
            updateHeaderTitle(id);
        }

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
            if (course.image_path) {
                hero.style.backgroundImage = `url('${storageBaseUrl}/${course.image_path}')`;
            } else {
                hero.style.backgroundImage = "url('https://via.placeholder.com/800x300?text=No+Image')";
            }

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
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
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
                        var count = parseInt(badge.innerText);
                        if (count > 1) {
                            badge.innerText = count - 1;
                            // Update header count too
                            var headerCount = document.querySelector('.notification-header span:last-child');
                            if (headerCount) {
                                headerCount.innerText = (count - 1) + ' New';
                            }
                        } else {
                            badge.remove();
                            var headerCount = document.querySelector('.notification-header span:last-child');
                            if (headerCount) {
                                headerCount.innerText = '0 New';
                            }
                        }
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

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var container = document.querySelector('.notification-container');
            var dropdown = document.getElementById('notificationDropdown');
            
            if (container && !container.contains(event.target)) {
                if (dropdown) dropdown.style.display = 'none';
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
        });
    </script>
</body>
</html>
