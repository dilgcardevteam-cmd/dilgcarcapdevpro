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
        .profile-dropdown .dropdown-meta{padding:10px 14px;border-bottom:1px solid #e5e7eb}
        .profile-dropdown .dropdown-meta-name{font-weight:700;color:#111827}
        .profile-dropdown .dropdown-meta-role{font-size:.85rem;color:#6b7280}
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
            background-color: #ffffff;
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
        .hero-metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;margin-top:16px}
        .hero-metric{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:14px;display:flex;align-items:center;justify-content:space-between;gap:12px}
        .hero-metric h4{margin:0;font-size:.95rem;color:#374151;font-weight:700}
        .metric-left{display:flex;align-items:center;gap:12px}
        .metric-icon{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:#e8effd;color:var(--primary-blue);font-size:1.1rem;flex-shrink:0}
        .metric-value{font-size:1.4rem;font-weight:800;color:var(--primary-blue)}

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
        .course-grid{
            display:grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap:24px;
            align-items:stretch;
        }
        @media (max-width: 1100px){ .course-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 700px){ .course-grid { grid-template-columns: 1fr; } }

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

        .course-card[role="button"],
        .course-card[role="link"] {
            cursor: pointer;
        }

        .course-card[role="button"]:focus-visible,
        .course-card[role="link"]:focus-visible {
            outline: 2px solid rgba(0, 44, 118, 0.35);
            outline-offset: 2px;
        }

        .course-image {
            aspect-ratio: 16 / 9;
            background-color: #eef2f7;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        .course-image::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(180deg, rgba(0,44,118,0.0) 0%, rgba(0,44,118,0.08) 70%, rgba(0,44,118,0.18) 100%);
            opacity:0;
            transition:opacity .2s ease;
        }
        .course-card:hover .course-image::after{
            opacity:1;
        }

        /* Course Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 8px;
        }
        .status-upcoming { background-color: #fef3c7; color: #92400e; }
        .status-ongoing { background-color: #dcfce7; color: #166534; }
        .status-completed { background-color: #fee2e2; color: #991b1b; }
        .status-not-set { background-color: #f3f4f6; color: #374151; }

        .course-schedule {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .course-schedule i { width: 16px; text-align: center; margin-right: 4px; }

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

        .course-footer{margin-top:auto;display:flex;justify-content:center;align-items:center;padding-top:12px;gap:10px;flex-wrap:wrap}

        .btn-view{display:inline-flex;align-items:center;justify-content:center;padding:10px 20px;background-color:var(--primary-blue);color:#fff;text-decoration:none;border-radius:999px;font-size:.9rem;transition:all .2s ease;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06);font-weight:700;white-space:nowrap;min-width:120px;max-width:100%;text-align:center}

        .btn-view:hover{background-color:#001f54;transform:translateY(-1px);box-shadow:0 10px 18px rgba(0,44,118,.22)}
        @media (max-width:480px){.course-footer .btn-view{width:100%}}

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
        .status-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;font-size:.78rem;font-weight:700}
        .status-enrolled{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0}
        .status-pending{background:#fff7ed;color:#9a3412;border:1px solid #fed7aa}
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
            background: #fff;
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
            color: #fff;
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
        #profile-section .profile-page-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;flex-wrap:wrap;width:100%}
        #profile-section .profile-page-btn{border:1px solid transparent;border-radius:999px;padding:10px 18px;font-weight:600;font-size:.9rem;display:inline-flex;align-items:center;gap:8px;cursor:pointer;transition:transform .2s ease,box-shadow .2s ease,background .2s ease,color .2s ease,border-color .2s ease;box-shadow:0 6px 14px rgba(15,23,42,.12)}
        #profile-section .profile-page-btn:active{transform:translateY(1px);box-shadow:0 3px 8px rgba(15,23,42,.14)}
        #profile-section .profile-page-btn.edit{background:#fff7ed;color:#9a3412;border-color:#fed7aa}
        #profile-section .profile-page-btn.cancel{background:#f1f5f9;color:#475569;border-color:#e2e8f0}
        #profile-section .profile-page-btn.save{background:var(--primary-green);color:#fff}
        #profile-section .profile-page-btn.save:hover{background:#6aa832}
        #profile-section .profile-page-alert{display:flex;align-items:center;gap:10px;background:#ecfdf3;border:1px solid #bbf7d0;color:#166534;padding:12px 14px;border-radius:12px;font-weight:600;font-size:.92rem}
        #profile-section .profile-page-alert.error{background:#fef2f2;border-color:#fecaca;color:#991b1b;align-items:flex-start}
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
        #profile-section .profile-page-panel.account-panel{border-color:#d8e5ff;background:linear-gradient(160deg,#f7fbff 0%,#fff 58%)}
        #profile-section .profile-page-panel.location-panel{border-color:#dbead2;background:linear-gradient(160deg,#f8fcf5 0%,#fff 58%)}
        #profile-section .profile-page-panel-wide{grid-column:1 / -1}
        #profile-section .profile-page-panel-header{display:flex;align-items:center;gap:10px;font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;color:#64748b;font-weight:700;margin-bottom:14px}
        #profile-section .profile-page-panel-header-rich{margin-bottom:16px;text-transform:none;letter-spacing:normal;align-items:flex-start}
        #profile-section .profile-page-header-icon{width:30px;height:30px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
        #profile-section .profile-page-panel.account-panel .profile-page-header-icon{background:#e0ebff;color:#1d4ed8}
        #profile-section .profile-page-panel.location-panel .profile-page-header-icon{background:#e3f2db;color:#2f7a15}
        #profile-section .profile-page-header-icon .icon-feather{width:16px;height:16px;stroke:currentColor;stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round}
        #profile-section .profile-page-panel-heading{display:flex;flex-direction:column;gap:2px}
        #profile-section .profile-page-panel-title{font-size:.75rem;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.08em;line-height:1.2}
        #profile-section .profile-page-panel-note{font-size:.78rem;color:#64748b;font-weight:500;line-height:1.2}
        #profile-section .profile-page-panel.account-panel .form-group,
        #profile-section .profile-page-panel.location-panel .form-group{background:rgba(255,255,255,.82);border:1px solid #e2e8f0;border-radius:12px;padding:10px 12px}
        #profile-section .profile-page-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 16px}
        #profile-section .profile-page-fields .form-group{margin-bottom:0}
        #profile-section .profile-page-fields label{display:block;margin-bottom:6px;color:#64748b;font-size:.72rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
        #profile-section .profile-input{width:100%;height:42px;padding:0 12px;border:1px solid #d7e0ea;border-radius:10px;box-sizing:border-box;background:#f8fafc;color:#0f172a;transition:border-color .2s ease,box-shadow .2s ease}
        #profile-section .profile-input:focus{outline:none;border-color:#2f5aa8;box-shadow:0 0 0 3px rgba(47,90,168,.15)}
        #profile-section .profile-input[readonly],#profile-section .profile-input:disabled{background:#f1f5f9;color:#475569;cursor:not-allowed}
        #profile-section .profile-page-help{color:#64748b;font-size:.8rem;display:block;margin-top:6px}
        @media(max-width:1100px){#profile-section .profile-page-grid{grid-template-columns:1fr}#profile-section .profile-page-fields{grid-template-columns:1fr}}
        @media(max-width:768px){#profile-section .profile-page-banner{flex-direction:column;align-items:flex-start}#profile-section .profile-page-actions{width:100%}}

        /* Home Page Pro Hero Styles */
        .home-hero-banner { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border-radius: 20px; padding: 35px; color: white; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15); }
        .home-hero-banner::after { content: ""; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; }
        .home-hero-title { font-size: 2rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em; }
        .home-hero-subtitle { font-size: 1rem; opacity: 0.9; margin-bottom: 25px; max-width: 600px; }
        .home-metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .home-metric-card { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 15px; transition: transform 0.2s; }
        .home-metric-card:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.15); }
        .home-metric-icon { width: 45px; height: 45px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #1e40af; font-size: 1.2rem; }
        .home-metric-info { display: flex; flex-direction: column; }
        .home-metric-value { font-size: 1.4rem; font-weight: 800; }
        .home-metric-label { font-size: 0.8rem; opacity: 0.8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

        /* New Classroom Styles */
        .filters-and-stats { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
        .filter-tabs { display: flex; gap: 10px; background-color: #eef2f7; padding: 5px; border-radius: 12px; }
        .filter-tab { background: none; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; color: #475569; cursor: pointer; transition: all .2s ease; }
        .filter-tab.active { background-color: #2563eb; color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
        .search-and-sort { display: flex; gap: 10px; }
        .search-input { border: 1px solid #d7e0ea; border-radius: 8px; padding: 8px 12px; font-size: .9rem; }
        .sort-dropdown { border: 1px solid #d7e0ea; border-radius: 8px; padding: 8px 12px; font-size: .9rem; background-color: white; }
        .course-stats { display: flex; gap: 20px; margin-bottom: 20px; font-weight: 600; color: #475569; }

        /* New Course Card Styles */
        .new-course-card { background: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); overflow: hidden; transition: all .2s ease; }
        .new-course-card:hover { transform: scale(1.03); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .card-banner { position: relative; aspect-ratio: 16/9; }
        .card-banner img { width: 100%; height: 100%; object-fit: cover; }
        .status-badge-new { position: absolute; top: 12px; left: 12px; padding: 5px 12px; border-radius: 8px; font-size: .75rem; font-weight: 700; color: white; }
        .status-badge-new.ongoing { background-color: #22c55e; }
        .status-badge-new.completed { background-color: #3b82f6; }
        .status-badge-new.upcoming { background-color: #f59e0b; }
        .status-badge-new.schedule-not-set { background-color: #6b7280; }
        .card-content { padding: 20px; display: flex; flex-direction: column; gap: 12px; }
        .card-title { font-size: 1.1rem; font-weight: 800; color: var(--primary-blue); margin: 0; }
        .progress-section { font-size: .85rem; }
        .progress-labels { display: flex; justify-content: space-between; margin-bottom: 5px; font-weight: 600; color: #64748b; }
        .progress-bar { background-color: #e2e8f0; border-radius: 999px; height: 8px; overflow: hidden; }
        .progress-fill { background-color: #22c55e; height: 100%; border-radius: 999px; }
        .module-progress { font-size: .85rem; font-weight: 600; color: #64748b; }
        .card-meta { display: grid; gap: 8px; font-size: .8rem; color: #475569; }
        .card-meta span { display: flex; align-items: center; gap: 8px; }
        .btn-gradient { display: block; text-align: center; border-radius: 12px; padding: 10px 18px; background: linear-gradient(135deg, #1e40af, #2563eb); color: white; font-weight: 700; text-decoration: none; transition: all .2s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3); }

        .new-course-card-link { text-decoration: none; color: inherit; }

        /* Responsive Grid */
        @media (min-width: 1024px) { .course-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 768px) and (max-width: 1023px) { .course-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 767px) { .course-grid { grid-template-columns: 1fr; } }

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
                    <div class="dropdown-meta">
                        <div class="dropdown-meta-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-meta-role">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('dashboard', ['tab' => 'profile-section']) }}">
                        <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
                    </a>
                    <a class="dropdown-item" href="#" onclick="showContent('certificates', null)">
                        <i class="fas fa-certificate"></i> <span>Certificates</span>
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
            <div class="header-title" style="padding: 12px 25px; border-bottom:1px solid rgba(255,255,255,0.1);">
                <img id="sidebarLogo" src="{{ asset('images/ddd-removebg-preview.png') }}" alt="CapDev Pro" style="height:75px">
            </div>
            <div style="padding: 12px 20px; display:flex; align-items:center; gap:12px; ">
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
                @if(in_array(Auth::user()->role, ['coach', 'trainer', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach']))
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">Go to Coach Dashboard</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Dashboard Home Section -->
            <div id="dashboard-home" class="content-section {{ in_array(request('tab'), ['classroom','calendar','announcements','certificates','profile-section']) ? '' : 'active' }}">
                <div class="home-hero-banner">
                    <h1 class="home-hero-title">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="home-hero-subtitle">Monitor your learning progress and quickly access your classes.</p>
                    
                    <div class="home-metrics-grid">
                        <div class="home-metric-card">
                            <div class="home-metric-icon"><i class="fas fa-book-open"></i></div>
                            <div class="home-metric-info">
                                <span class="home-metric-value">{{ $totalAvailableCourses }}</span>
                                <span class="home-metric-label">Available</span>
                            </div>
                        </div>
                        <div class="home-metric-card">
                            <div class="home-metric-icon"><i class="fas fa-user-graduate"></i></div>
                            <div class="home-metric-info">
                                <span class="home-metric-value">{{ $totalCoursesJoined }}</span>
                                <span class="home-metric-label">Joined</span>
                            </div>
                        </div>
                        <div class="home-metric-card">
                            <div class="home-metric-icon"><i class="fas fa-hourglass-half"></i></div>
                            <div class="home-metric-info">
                                <span class="home-metric-value">{{ $pendingCoursesCount ?? 0 }}</span>
                                <span class="home-metric-label">Pending</span>
                            </div>
                        </div>
                        <div class="home-metric-card">
                            <div class="home-metric-icon"><i class="fas fa-flag-checkered"></i></div>
                            <div class="home-metric-info">
                                <span class="home-metric-value">{{ $completedCoursesCount ?? 0 }}</span>
                                <span class="home-metric-label">Finished</span>
                            </div>
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

                <!-- Enrolled Courses (Active Only) -->
                <div class="section-header">
                    <h2 class="section-title">Enrolled Courses</h2>
                </div>
                <div class="course-grid">
                    @forelse($myCourses as $course)
                        <a href="{{ route('trainee.courses.show', $course) }}" class="new-course-card-link" data-status="{{ strtolower($course->course_status) }}" data-start-date="{{ $course->start_date ? $course->start_date->timestamp : 0 }}" data-progress="{{ $progressData[$course->id]['percentage'] ?? 0 }}">
                            <div class="new-course-card">
                                <div class="card-banner">
                                    <img src="{{ $course->image_path ? asset('storage/' . $course->image_path) : 'https://via.placeholder.com/400x200?text=No+Image' }}" alt="Course Image">
                                    <div class="status-badge-new {{ strtolower($course->course_status) }}">{{ $course->course_status }}</div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $course->name }}</h3>
                                    <div class="progress-section">
                                        <div class="progress-labels">
                                            <span>Progress</span>
                                            <span>{{ round($progressData[$course->id]['percentage'] ?? 0) }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $progressData[$course->id]['percentage'] ?? 0 }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="module-progress">
                                        <span>Assessments: {{ $progressData[$course->id]['completed'] ?? 0 }} / {{ $progressData[$course->id]['total'] ?? 0 }}</span>
                                        <span>Modules: {{ $progressData[$course->id]['total_modules'] ?? 0 }}</span>
                                    </div>
                                    <div class="card-meta">
                                        @php
                                            $coach = $course->users->whereIn('role', ['coach', 'trainer'])->first();
                                        @endphp
                                        <span><i class="fas fa-user"></i> Coach: {{ $coach->name ?? 'TBA' }}</span>
                                        <span><i class="fas fa-calendar-alt"></i> Start: {{ $course->start_date ? $course->start_date->format('M d') : 'TBA' }}</span>
                                        <span><i class="fas fa-calendar-check"></i> End: {{ $course->end_date ? $course->end_date->format('M d') : 'TBA' }}</span>
                                    </div>
                                    <div class="btn-gradient">Enter Class</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 28px; color: #6b7280;">
                            <i class="fas fa-graduation-cap" style="font-size: 2.2rem; opacity: 0.6;"></i>
                            <div style="margin-top: 8px;">You are not enrolled in any active courses yet.</div>
                        </div>
                    @endforelse
                </div>

                <!-- Available Courses List -->
                <div class="section-header" style="margin-top: 30px;">
                    <h2 class="section-title">Available Courses</h2>
                </div>

                <div class="course-grid">
                    @forelse($availableCourses as $course)
                        <div class="new-course-card" style="cursor: pointer;" onclick="openCourseDetails({{ $course->id }})">
                            <div class="card-banner">
                                @php
                                    $courseImage = null;
                                    if ($course->image_path) {
                                        $courseImage = asset('storage/' . $course->image_path);
                                    } else {
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
                                <img src="{{ $courseImage }}" alt="Course Image">
                                <div class="status-badge-new {{ strtolower($course->course_status) }}">{{ $course->course_status }}</div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">{{ $course->name }}</h3>
                                <p class="course-desc" style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 10px;">{{ Str::limit($course->description, 100) }}</p>

                                <div class="card-meta" style="margin-bottom: 15px;">
                                    @php
                                        $coachNames = $course->users ? $course->users->whereIn('role', ['coach', 'trainer', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach'])->pluck('name')->join(', ') : null;
                                        $enrollable = $course->isEnrollable();
                                    @endphp
                                    <span><i class="fas fa-user"></i> Coach: {{ $coachNames ?: 'TBA' }}</span>
                                    <span><i class="fas fa-calendar-alt"></i> Start: {{ $course->start_date ? $course->start_date->format('M d') : 'TBA' }}</span>
                                </div>
                                
                                <div style="display: flex; gap: 10px; margin-top: auto;">
                                    @if(!$enrollable)
                                        <button class="btn-gradient" style="background: #94a3b8; cursor: not-allowed; opacity: 0.7; flex: 1;" disabled>Closed</button>
                                    @else
                                        <button class="btn-gradient" style="background: linear-gradient(135deg, #059669, #10b981); flex: 1;" onclick="event.stopPropagation();openEnrollModal({{ $course->id }})">Enroll</button>
                                    @endif
                                    <button class="btn-gradient" style="background: linear-gradient(135deg, #64748b, #94a3b8); flex: 1;" onclick="event.stopPropagation();openCourseDetails({{ $course->id }})">Details</button>
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
            </div>

            <!-- Classroom Section -->
            <div id="classroom" class="content-section {{ request('tab') == 'classroom' ? 'active' : '' }}">
                <div class="section-header">
                    <h2 class="section-title">My Classes</h2>
                </div>

                <div class="filters-and-stats">
                    <div class="filter-tabs">
                        <button class="filter-tab active">All</button>
                        <button class="filter-tab">Ongoing</button>
                        <button class="filter-tab">Completed</button>
                        <button class="filter-tab">Upcoming</button>
                    </div>
                    <div class="search-and-sort">
                        <input type="text" class="search-input" placeholder="Search courses...">
                        <select class="sort-dropdown">
                            <option>Newest</option>
                            <option>Progress</option>
                            <option>Start Date</option>
                        </select>
                    </div>
                </div>

                <div class="course-stats">
                    <span>Total Courses: {{ $classroomCourses->count() }}</span>
                    <span>Ongoing: {{ $classroomCourses->where('course_status', 'Ongoing')->count() }}</span>
                    <span>Completed: {{ $classroomCourses->where('course_status', 'Completed')->count() }}</span>
                </div>

                <div class="course-grid">
                    @forelse($classroomCourses as $course)
                        <a href="{{ route('trainee.courses.show', $course) }}" class="new-course-card-link" data-status="{{ strtolower($course->course_status) }}" data-start-date="{{ $course->start_date ? $course->start_date->timestamp : 0 }}" data-progress="70">
                            <div class="new-course-card">
                                <div class="card-banner">
                                    <img src="{{ $course->image_path ? asset('storage/' . $course->image_path) : 'https://via.placeholder.com/400x200?text=No+Image' }}" alt="Course Image">
                                    <div class="status-badge-new {{ strtolower($course->course_status) }}">{{ $course->course_status }}</div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $course->name }}</h3>
                                    <div class="progress-section">
                                    <div class="progress-labels">
                                        <span>Progress</span>
                                        <span>{{ round($progressData[$course->id]['percentage']) }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $progressData[$course->id]['percentage'] }}%;"></div>
                                    </div>
                                </div>
                                <div class="module-progress">
                                    <span>
                                        Module: {{ $progressData[$course->id]['completed'] }} / {{ $progressData[$course->id]['total'] }}
                                        (Total Modules: {{ $progressData[$course->id]['total_modules'] }})
                                    </span>
                                </div>
                                    <div class="card-meta">
                                        @php
                                            $coach = $course->users->whereIn('role', ['coach', 'trainer'])->first();
                                        @endphp
                                        <span><i class="fas fa-user"></i> Coach: {{ $coach->name ?? 'TBA' }}</span>
                                        <span><i class="fas fa-calendar-alt"></i> Start: {{ $course->start_date ? $course->start_date->format('M d') : 'TBA' }}</span>
                                        <span><i class="fas fa-calendar-check"></i> End: {{ $course->end_date ? $course->end_date->format('M d') : 'TBA' }}</span>
                                    </div>
                                    @if($course->course_status == 'Ongoing')
                                        <div class="btn-gradient">Continue Course</div>
                                    @else
                                        <div class="btn-gradient">View Classroom</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>You are not enrolled in any courses yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Calendar Section -->
            <div id="calendar" class="content-section {{ request('tab') == 'calendar' ? 'active' : '' }}">
                
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

                <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-blue);">Upcoming Events</h3>
                    @php
                        $manualEvents = $calendarEvents->filter(fn($e) => !empty($e->id));
                    @endphp
                    @if($manualEvents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar" style="font-size: 3rem; color: var(--primary-green); margin-bottom: 10px;"></i>
                            <h3>No Events Scheduled</h3>
                            <p style="color: #666;">Upcoming class schedules and events will be displayed here.</p>
                        </div>
                    @else
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            @foreach($manualEvents as $event)
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
            <div id="announcements" class="content-section {{ request('tab') == 'announcements' ? 'active' : '' }}">
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

            <!-- Certificates Section -->
            <div id="certificates" class="content-section {{ request('tab') == 'certificates' ? 'active' : '' }}">
                <div class="control-hero">
                    <div class="control-hero-top">
                        <div>
                            <h1 class="control-hero-title">Welcome , {{ Auth::user()->name }}</h1>
                            <div class="control-hero-sub">Review your learning achievements and earned certificates.</div>
                        </div>
                        <div class="hero-actions">
                            <div class="hero-btn"><i class="fas fa-certificate"></i> Certificates Earned: {{ ($earnedCertificates ?? collect())->count() }}</div>
                        </div>
                    </div>
                </div>
                <div style="display:flex;border-bottom:1px solid #ddd;margin:0 0 16px;background:#fff;padding:0 20px;border-radius:10px 10px 0 0">
                    <button class="tab-btn active" onclick="/* single tab */void(0)">My Learning Achievements</button>
                </div>
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:0 0 12px 12px;padding:16px">
                    @php $list = $earnedCertificates ?? collect(); @endphp
                    @if($list->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-certificate" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 10px;"></i>
                            <h3>No Certificates Achieved Yet</h3>
                        </div>
                    @else
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px">
                            @foreach($list as $cert)
                                @php
                                    $issued = optional($cert->pivot)->issued_at ? \Carbon\Carbon::parse($cert->pivot->issued_at)->format('M d, Y') : null;
                                @endphp
                                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 4px 10px rgba(0,0,0,.05);overflow:hidden">
                                    <div style="padding:14px 16px;border-bottom:1px solid #eef2f7;display:flex;align-items:center;justify-content:center;gap:10px">
                                        <span style="display:inline-block;background:#d1fae5;color:#065f46;border-radius:6px;padding:4px 10px;font-weight:800;font-size:.8rem">Certificate</span>
                                    </div>
                                    <div style="padding:18px;display:flex;flex-direction:column;align-items:center;gap:12px">
                                        <i class="fas fa-certificate" style="font-size:3rem;color:var(--primary-blue)"></i>
                                        <div style="letter-spacing:.15em;color:#6b7280;font-weight:700">COURSE</div>
                                        <div style="font-weight:800;color:#002C76;text-align:center">{{ $cert->name }}</div>
                                    </div>
                                    <div style="padding:12px 16px;text-align:center">
                                        <button class="btn-view" onclick="openCertificateModal('{{ asset('images/capdev cert.jpg') }}','{{ Auth::user()->name }}','{{ $cert->name }}','{{ $issued ?? '—' }}','{{ optional($cert->pivot)->certificate_number ?? 'Cert 0001' }}','{{ route('admin.certifications.course.download.single', ['course' => optional($cert->pivot)->course_id, 'certification' => $cert->id, 'user' => Auth::id()]) }}')">View Certificate</button>
                                    </div>
                                    <div style="background:#f3f4f6;border-top:1px solid #e5e7eb;padding:10px 16px;color:#374151;font-weight:600;text-align:center">
                                        Issued On: {{ $issued ?? '—' }}
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

                                <div id="profile_upload_container" class="profile-page-upload" style="display: none;">
                                    <input type="hidden" name="profile_picture_cropped" id="profile_picture_cropped">
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" onchange="openCropperFromInput(this)">
                                    <span class="profile-page-help">PNG or JPG, square crop works best.</span>
                                </div>
                            </div>
                        </div>

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
                                        <div class="profile-input" style="display:flex;align-items:center;background:#f1f5f9;color:#475569;cursor:not-allowed;">{{ Auth::user()->status === 'pending' ? 'N/A' : (Auth::user()->account_id ?? 'N/A') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="profile-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="profile-input" required>
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
                                        $profileRegion = old('region', Auth::user()->region ?? '');
                                        $profileProvince = old('province', Auth::user()->province ?? '');
                                        $profileCity = old('city', Auth::user()->city ?? '');
                                        $profileBarangay = old('barangay', Auth::user()->barangay ?? '');
                                        $myRole = Auth::user()->role ?? '';
                                        $isCentral = in_array($myRole, ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'], true);
                                        $isRegional = in_array($myRole, ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'], true);
                                        $isProvincial = in_array($myRole, ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'], true);
                                        $labelRegion = ($isCentral || $isRegional || $isProvincial) ? 'Office Level' : 'Region';
                                        $labelProvince = $isCentral ? 'Office Type' : ($isRegional ? 'Region' : ($isProvincial ? 'Office' : 'Province'));
                                        $isBureau = is_string($profileProvince) && (stripos($profileProvince,'bureau') !== false);
                                        $labelCity = $isCentral ? ($isBureau ? 'Bureau' : 'Service') : 'City / Municipality';
                                    @endphp
                                    <div class="form-group">
                                        <label>{{ $labelRegion }}</label>
                                        <select id="profile_region" name="region" class="profile-input" data-selected="{{ $profileRegion }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>{{ $isCentral || $isRegional || $isProvincial ? 'Select Level' : 'Select Region' }}</option>
                                            @if($profileRegion)
                                                <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" id="group_profile_region_actual" @if(!$isRegional) style="display:none" @endif>
                                        <label>Region</label>
                                        <select id="profile_region_actual" @if($isRegional) name="region" @endif class="profile-input" data-selected="{{ $profileRegion }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>Select Region</option>
                                            @if($profileRegion)
                                                <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" @if($isRegional) style="display:none" @endif>
                                        <label>{{ $labelProvince }}</label>
                                        <select id="profile_province" name="province" class="profile-input" data-selected="{{ $profileProvince }}" disabled>
                                            <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>
                                                @if($isCentral) Select Office Type @elseif($isProvincial) Select Office @elseif($isRegional) Select Region @else Select Province @endif
                                            </option>
                                            @if($profileProvince)
                                                <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" @if($isRegional || $isProvincial) style="display:none" @endif>
                                        <label>{{ $labelCity }}</label>
                                        <select id="profile_city" name="city" class="profile-input" data-selected="{{ $profileCity }}" disabled>
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
                                            <select id="profile_barangay" name="barangay" class="profile-input" data-selected="{{ $profileBarangay }}" disabled>
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
                </form>
            </div>

            <!-- Course Details View -->
            <div id="course-details-view" class="content-section">
                <a onclick="showContent('dashboard-home', document.querySelector('a[onclick*=\'dashboard-home\']'))" class="back-link">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Dashboard
                </a>
                
                <!-- Course Header -->
                <div style="background: white; padding: 25px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                        <div style="display: flex; align-items: center; gap: 20px; min-width: 0;">
                            <div id="detail-header-icon" style="width: 60px; height: 60px; background: var(--primary-blue); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem;">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                            <div>
                                <h1 id="detail-title" style="margin: 0 0 5px; color: var(--primary-blue); font-size: 1.8rem;">Course Title</h1>
                                <div style="color: var(--light-text); font-size: 0.9rem;">
                                    <span id="detail-category-badge" style="background: #e9ecef; padding: 2px 8px; border-radius: 4px; font-weight: 500;">Category</span>
                                    <span style="margin: 0 10px;">•</span>
                                    <span id="detail-trainer">Coach: </span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                            <span id="detail-enroll-chip" class="status-chip" style="display:none;background:#fef2f2;border:1px solid #fecaca;color:#991b1b"><i class="fas fa-ban"></i> Enrollment Closed</span>
                            <button id="detail-enroll-btn" class="btn-view" style="background-color: #C9282D; padding: 12px 25px; font-size: 1rem; display: none; white-space: nowrap;" onclick="openEnrollModal()">
                                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>Enroll Now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div style="display: flex; border-bottom: 1px solid #ddd; margin-bottom: 25px; background: white; padding: 0 20px; border-radius: 10px 10px 0 0;">
                    <button class="tab-btn active" onclick="switchCourseTab('description')">Overview</button>
                    <button class="tab-btn" onclick="switchCourseTab('curriculum')">Topics</button>
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

                        <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                            <h4 style="margin-top: 0; color: var(--dark-text);">Subject Areas</h4>
                            <p id="detail-subject-area" style="color: var(--light-text);">General</p>
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div id="tab-curriculum" class="course-tab-content">
                        <h3 class="curriculum-title">Here’s what you will learn.</h3>
                        <div style="margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #eee; border-radius: 8px;">
                            <h4 style="margin-top: 0; color: var(--dark-text);"></h4>
                            <div id="curriculum-list" class="acc-list"></div>
                        </div>
                    </div>

                    <!-- Removed tabs: Classwork, People, Grades -->

                </div>
            </div>
            @if(request('tab') == 'help-support')
                @include('dashboard.help-support')
            @endif

        </div>
    </div>
    <div id="certificateModal" class="modal-overlay">
        <div class="modal-container" style="max-width:900px; position:relative">
            <button type="button" class="btn-cancel" onclick="closeCertificateModal()" style="position:absolute;top:12px;right:12px;padding:6px 12px;border-radius:6px">Close</button>
            <h2 class="modal-title">Certificate</h2>
            <div class="certificate-frame" style="position:relative">
                <img id="certificateImage" src="" alt="Certificate" crossorigin="anonymous" style="width:100%;height:auto;border-radius:8px;display:block">
                <div id="overlayName" style="position:absolute;left:50%;top:29.5%;transform:translateX(-50%);color:#0b1e3a;font-weight:800;font-size:3rem;text-align:center;white-space:nowrap;max-width:80%;overflow:hidden;text-overflow:ellipsis"></div>
                <div id="overlayCourse" style="position:absolute;left:50%;top:46.5%;transform:translateX(-50%);color:#0b1e3a;font-weight:700;font-size:2.5rem;text-align:center;white-space:nowrap;max-width:80%;overflow:hidden;text-overflow:ellipsis"></div>
                <div id="overlayCertNo" style="position:absolute;right:10%;bottom:14.4%;color:#0b1e3a;font-weight:800;font-size:1.1rem;text-align:right;white-space:nowrap"></div>
                <div id="overlayCompletion" style="position:absolute;right:7.5%;bottom:11.3%;color:#0b1e3a;font-weight:800;font-size:1.1rem;text-align:right;white-space:nowrap"></div>
            </div>
            <div style="display:flex;justify-content:flex-end;margin-top:14px">
                <a id="certificateDownloadBtn" href="#" onclick="downloadCertificateFramePDF(event)" style="display:inline-block;background-color:#002C76;color:#fff;padding:10px 18px;border-radius:6px;text-decoration:none;font-weight:700">Download PDF</a>
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

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
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

        var cropState = { }; // retained for backward compatibility; unused with Cropper.js
        var avatarCropper = null;
        var cropperReady = false;

        function ensureCropperLoaded(){
            return new Promise(function(resolve){
                if (window.Cropper) return resolve();
                if (!document.getElementById('cropperjs-css')) {
                    var link = document.createElement('link');
                    link.id = 'cropperjs-css';
                    link.rel = 'stylesheet';
                    link.href = 'https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css';
                    document.head.appendChild(link);
                }
                var existing = document.getElementById('cropperjs-js');
                if (existing) { existing.addEventListener('load', resolve); return; }
                var s = document.createElement('script');
                s.id = 'cropperjs-js';
                s.src = 'https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js';
                s.onload = resolve;
                document.body.appendChild(s);
            });
        }

        async function openCropperFromInput(input){
            if(!(input.files&&input.files[0])) return;
            var file = input.files[0];
            var dataUrl = await loadOrientedDataURL(file, 2048);
            await ensureCropperLoaded();
            var modal=document.getElementById('cropModal');
            var img=document.getElementById('cropImg');
            var applyBtn = document.getElementById('cropApplyBtn');
            if (applyBtn) { applyBtn.disabled = true; applyBtn.style.opacity = '.6'; }
            if (modal) { modal.style.display='flex'; }
            cropperReady = false;
            img.onload=function(){
                if (avatarCropper) { try { avatarCropper.destroy(); } catch(e) {} }
                avatarCropper = new window.Cropper(img, {
                    aspectRatio: 1,
                    viewMode: 2,
                    dragMode: 'move',
                    background: false,
                    guides: true,
                    autoCropArea: 1,
                    responsive: true,
                    movable: true,
                    zoomable: true,
                    zoomOnWheel: true,
                    minContainerWidth: 340,
                    minContainerHeight: 340,
                    ready: function(){
                        cropperReady = true;
                        if (applyBtn) { applyBtn.disabled = false; applyBtn.style.opacity = '1'; }
                    }
                });
                var slider = document.getElementById('cropZoom');
                if (slider) {
                    slider.value = 1;
                    slider.oninput = function(){ if(avatarCropper){ avatarCropper.zoomTo(parseFloat(this.value)); } };
                }
            };
            img.src=dataUrl;
        }

        async function loadOrientedDataURL(file, maxDim){
            if('createImageBitmap' in window){
                try{
                    const bmp = await createImageBitmap(file, { imageOrientation: 'from-image' });
                    const scale = Math.min(1, maxDim / Math.max(bmp.width, bmp.height));
                    const c = document.createElement('canvas');
                    c.width = Math.round(bmp.width * scale);
                    c.height = Math.round(bmp.height * scale);
                    const ctx = c.getContext('2d', { willReadFrequently: false });
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(bmp, 0, 0, c.width, c.height);
                    return c.toDataURL('image/jpeg', 0.92);
                }catch(e){}
            }
            const orientation = await readExifOrientation(file).catch(()=>1);
            const blobUrl = URL.createObjectURL(file);
            const im = await new Promise(function(res){ const t=new Image(); t.onload=function(){ res(t); }; t.src=blobUrl; });
            const iw = im.naturalWidth, ih = im.naturalHeight;
            const ratio = Math.min(1, maxDim / Math.max(iw, ih));
            let cw = Math.round(iw * ratio), ch = Math.round(ih * ratio);
            let c = document.createElement('canvas'), ctx = c.getContext('2d');
            // Handle EXIF orientation (1..8)
            if(orientation>=5 && orientation<=8){ c.width = ch; c.height = cw; } else { c.width = cw; c.height = ch; }
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
            ctx.drawImage(im, 0, 0, cw, ch);
            URL.revokeObjectURL(blobUrl);
            return c.toDataURL('image/jpeg', 0.92);
        }

        function readExifOrientation(file){
            return new Promise(function(resolve, reject){
                const fr = new FileReader();
                fr.onerror = reject;
                fr.onload = function(){
                    const view = new DataView(fr.result);
                    if(view.getUint16(0,false) != 0xFFD8) return resolve(1);
                    let offset = 2;
                    const length = view.byteLength;
                    while(offset < length){
                        const marker = view.getUint16(offset, false); offset += 2;
                        if(marker == 0xFFE1){
                            offset += 2; // skip length
                            if(view.getUint32(offset, false) != 0x45786966) return resolve(1); // "Exif"
                            offset += 6;
                            const little = view.getUint16(offset, false) == 0x4949; offset += 2;
                            if(view.getUint16(offset, little) != 0x002A) return resolve(1); offset += 2;
                            let ifdOffset = view.getUint32(offset, little); offset = offset - 4 + ifdOffset;
                            const entries = view.getUint16(offset, little); offset += 2;
                            for(let i=0;i<entries;i++){
                                const tag = view.getUint16(offset, little);
                                if(tag == 0x0112){ // Orientation
                                    const val = view.getUint16(offset+8, little);
                                    return resolve(val);
                                }
                                offset += 12;
                            }
                            break;
                        } else if((marker & 0xFF00) != 0xFF00){
                            break;
                        } else {
                            offset += view.getUint16(offset, false);
                        }
                    }
                    resolve(1);
                };
                fr.readAsArrayBuffer(file.slice(0, 128*1024));
            });
        }
        function applyTransform(){} // no-op with Cropper.js
        function cropStartDrag(){}  // no-op with Cropper.js
        function cropDrag(){}       // no-op with Cropper.js
        function cropEndDrag(){}    // no-op with Cropper.js
        function cropZoomChange(){} // handled by slider -> zoomTo
        function closeCropper(){
            if (avatarCropper) { try { avatarCropper.destroy(); } catch(e) {} avatarCropper=null; }
            cropperReady = false;
            document.getElementById('cropModal').style.display='none';
        }
        function applyCrop(){
            if(!avatarCropper || !cropperReady) return;
            var canvas = avatarCropper.getCroppedCanvas({ width: 512, height: 512, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
            if (!canvas) return;
            var dataUrl = canvas.toDataURL('image/jpeg', 0.92);
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
            <div id="cropViewport" style="width:320px;height:320px;margin:0 auto;border-radius:8px;overflow:hidden;background:#f3f4f6;position:relative">\
                <img id="cropImg" src="" style="max-width:100%;display:block;">\
            </div>\
            <div style="display:flex;align-items:center;gap:12px;margin-top:10px">\
                <input id="cropZoom" type="range" min="0.5" max="3" step="0.01" value="1" style="flex:1">\
                <button type="button" class="btn-view" onclick="closeCropper()">Cancel</button>\
                <button type="button" id="cropApplyBtn" class="btn-view" style="background:#16a34a;border-color:#16a34a" onclick="applyCrop()">Apply</button>\
            </div></div>';
            document.addEventListener('DOMContentLoaded',function(){ document.body.appendChild(modal); });
        })();
        function toggleSidebar() {
            var s = document.getElementById('sidebar');
            if(s){ s.classList.toggle('collapsed'); }
            document.body.classList.toggle('sidebar-collapsed');
            var LOGO_MAIN = "{{ asset('images/ddd-removebg-preview.png') }}";
            var LOGO_SMALL = "{{ asset('images/logo1.png') }}";
            var sidebarLogo = document.getElementById('sidebarLogo');
            var collapsed = document.body.classList.contains('sidebar-collapsed');
            if(sidebarLogo){ sidebarLogo.src = collapsed ? LOGO_SMALL : LOGO_MAIN; }
        }

        function showContent(sectionId, element) {
            const evt = window.event;
            if (evt && typeof evt.preventDefault === 'function') {
                evt.preventDefault();
            }

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
            var titleMap={'dashboard-home':'Dashboard','classroom':'Classroom','calendar':'Calendar','announcements':'Announcements','profile-section':'My Profile','certificates':'Certificates'};
            var titleEl=document.getElementById('headerSectionTitle');
            if(titleEl){ titleEl.textContent = titleMap[sectionId] || 'Dashboard'; }

            const url = new URL(window.location.href);
            if (sectionId === 'dashboard-home') {
                url.searchParams.delete('tab');
            } else {
                url.searchParams.set('tab', sectionId);
            }
            url.hash = '';
            window.history.pushState({}, '', url.toString());
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
            const selectedRegionActual = regionActualSelect ? (regionActualSelect.dataset.selected || '') : '';
            const selectedProvince = provinceSelect ? (provinceSelect.dataset.selected || '') : '';
            const selectedCity = citySelect ? (citySelect.dataset.selected || '') : '';
            const selectedBarangay = barangaySelect ? (barangaySelect.dataset.selected || '') : '';
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

            const resetSelect = (selectElement, placeholder) => {
                selectElement.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
            };
            const addFallbackOption = (selectElement, value, label = value) => {
                if (!value) return null;
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;
                option.selected = true;
                selectElement.appendChild(option);
                return option;
            };

            function loadBarangays(cityCode, selectedBarangayValue = null) {
                resetSelect(barangaySelect, 'Select Barangay');
                if (!cityCode) {
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    return;
                }
                fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`)
                    .then(r=>r.json())
                    .then(data=>{
                        data.sort((a,b)=>a.name.localeCompare(b.name));
                        let matched=false;
                        data.forEach(b=>{
                            const o=document.createElement('option');
                            o.value=b.name; o.textContent=b.name;
                            if (selectedBarangayValue && selectedBarangayValue===b.name){ o.selected=true; matched=true; }
                            barangaySelect.appendChild(o);
                        });
                        if (selectedBarangayValue && !matched) addFallbackOption(barangaySelect, selectedBarangayValue);
                    })
                    .catch(()=>{ if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue); });
            }
            function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
                const url = isRegion ? `{{ url('/psgc/regions') }}/${code}/cities` : `{{ url('/psgc/provinces') }}/${code}/cities`;
                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                fetch(url)
                    .then(r=>r.json())
                    .then(data=>{
                        data.sort((a,b)=>a.name.localeCompare(b.name));
                        let selectedCityCode=''; let matched=false;
                        data.forEach(c=>{
                            const o=document.createElement('option'); o.value=c.name; o.textContent=c.name; o.dataset.code=c.code;
                            if (selectedCityValue && selectedCityValue===c.name){ o.selected=true; selectedCityCode=c.code; matched=true; }
                            citySelect.appendChild(o);
                        });
                        if (selectedCityValue && !matched) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedCityCode) loadBarangays(selectedCityCode, selectedBarangayValue);
                        else if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    })
                    .catch(()=>{
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    });
            }
            function loadProvincesByRegion(regionCode, selectedProvinceValue = null, selectedCityValue = null, selectedBarangayValue = null) {
                resetSelect(provinceSelect, 'Select Province');
                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                if (!regionCode) {
                    if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                    if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    return;
                }
                fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`)
                    .then(r=>r.json())
                    .then(data=>{
                        data.sort((a,b)=>a.name.localeCompare(b.name));
                        let selectedProvinceCode=''; let matched=false;
                        data.forEach(p=>{
                            const o=document.createElement('option'); o.value=p.name; o.textContent=p.name; o.dataset.code=p.code;
                            if (selectedProvinceValue && selectedProvinceValue===p.name){ o.selected=true; selectedProvinceCode=p.code; matched=true; }
                            provinceSelect.appendChild(o);
                        });
                        if (selectedProvinceValue && !matched) addFallbackOption(provinceSelect, selectedProvinceValue);
                        if (selectedProvinceCode) fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                    })
                    .catch(()=>{
                        if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    });
            }
            if (regionSelect) {
                regionSelect.addEventListener('change', function(){
                    const code = this.options[this.selectedIndex]?.dataset?.code || '';
                    loadProvincesByRegion(code);
                });
            }
            provinceSelect.addEventListener('change', function(){
                const code = this.options[this.selectedIndex]?.dataset?.code || '';
                const isRegion = this.options[this.selectedIndex]?.dataset?.isRegion === 'true';
                if (!code) { resetSelect(citySelect,'Select City/Municipality'); resetSelect(barangaySelect,'Select Barangay'); return; }
                fetchCities(code, isRegion);
            });
            citySelect.addEventListener('change', function(){
                const code = this.options[this.selectedIndex]?.dataset?.code || '';
                loadBarangays(code);
            });

            if (isDILGMode) {
                const regionLabel = IS_OFFICE(myRole, 'central') ? 'DILG Central Office' : (IS_OFFICE(myRole, 'regional') ? 'DILG Regional Office' : 'DILG Provincial Office');
                resetSelect(regionSelect, 'Select Level');
                const opt = document.createElement('option');
                opt.value = regionLabel; opt.textContent = regionLabel; opt.selected = true; opt.dataset.code = 'DILG';
                regionSelect.appendChild(opt);
                const regionGroupLabel = regionSelect.closest('.form-group')?.querySelector('label'); if (regionGroupLabel) regionGroupLabel.textContent = 'Office Level';
                const provGroupLabel = provinceSelect.closest('.form-group')?.querySelector('label'); if (provGroupLabel) provGroupLabel.textContent = IS_OFFICE(myRole,'central') ? 'Office Type' : 'Office';
                const cityGroupLabel = citySelect.closest('.form-group')?.querySelector('label');
                if (IS_OFFICE(myRole, 'central')) {
                    resetSelect(provinceSelect, 'Select Office Type');
                    ['Bureau','Services'].forEach(lbl=>{ const o=document.createElement('option'); o.value=lbl; o.textContent=lbl; provinceSelect.appendChild(o); });
                    provinceSelect.addEventListener('change', function(){
                        const cat=this.value;
                        if (cityGroupLabel) cityGroupLabel.textContent = cat==='Bureau' ? 'Bureau' : 'Service';
                        resetSelect(citySelect, cat==='Bureau' ? 'Select Bureau' : 'Select Service');
                        const list=cat==='Bureau'?BUREAUS:SERVICES;
                        let matched=false;
                        list.forEach(item=>{
                            const o=document.createElement('option'); o.value=item; o.textContent=item;
                            if (selectedProvince && selectedProvince===item){ o.selected=true; matched=true; }
                            citySelect.appendChild(o);
                        });
                        if (selectedProvince && !matched) addFallbackOption(citySelect, selectedProvince);
                        citySelect.disabled=false;
                        const barangayGroup = barangaySelect.closest('.form-group'); if (barangayGroup) barangayGroup.style.display='none';
                    });
                    if (selectedProvince) {
                        const isB = BUREAUS.includes(selectedProvince);
                        provinceSelect.value = isB ? 'Bureau' : 'Services';
                        provinceSelect.dispatchEvent(new Event('change'));
                    }
                } else if (IS_OFFICE(myRole,'regional')) {
                    [provinceSelect, citySelect, barangaySelect].forEach(s=>{ const g=s.closest('.form-group'); if (g) g.style.display='none'; });
                    if (regionActualSelect) {
                        const g = document.getElementById('group_profile_region_actual'); if (g) g.style.display = '';
                        // Name swap: submit the actual region, keep level unsubmitted
                        try { regionSelect.setAttribute('name',''); } catch(e){}
                        regionActualSelect.setAttribute('name','region');
                        // Populate regions
                        fetch(`{{ url('/psgc/regions') }}`)
                            .then(r=>r.json())
                            .then(data=>{
                                resetSelect(regionActualSelect,'Select Region');
                                data.sort((a,b)=>a.name.localeCompare(b.name));
                                let matched=false;
                                data.forEach(reg=>{
                                    const o=document.createElement('option'); o.value=reg.name; o.textContent=reg.name; o.dataset.code=reg.code;
                                    if ((selectedRegionActual||selectedRegion) && (selectedRegionActual===reg.name || selectedRegion===reg.name)) { o.selected = true; matched = true; }
                                    regionActualSelect.appendChild(o);
                                });
                                if (!matched && (selectedRegionActual||selectedRegion)) {
                                    addFallbackOption(regionActualSelect, selectedRegionActual||selectedRegion);
                                }
                            })
                            .catch(()=>{
                                if (selectedRegionActual||selectedRegion) addFallbackOption(regionActualSelect, selectedRegionActual||selectedRegion);
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

            fetch(`{{ url('/psgc/regions') }}`)
                .then(r=>r.json())
                .then(data=>{
                    resetSelect(regionSelect, 'Select Region');
                    data.sort((a,b)=>a.name.localeCompare(b.name));
                    let selectedRegionCode=''; let matched=false;
                    data.forEach(region=>{
                        const o=document.createElement('option'); o.value=region.name; o.textContent=region.name; o.dataset.code=region.code;
                        if (selectedRegion && selectedRegion===region.name){ o.selected=true; selectedRegionCode=region.code; matched=true; }
                        regionSelect.appendChild(o);
                    });
                    if (selectedRegion && !matched) addFallbackOption(regionSelect, selectedRegion);
                    if (selectedRegionCode) loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
                    else {
                        if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                        if (selectedCity) addFallbackOption(citySelect, selectedCity);
                        if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                    }
                })
                .catch(()=>{
                    if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
                    if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                    if (selectedCity) addFallbackOption(citySelect, selectedCity);
                    if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                });
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
            // Coach display (prefer assigned coaches/trainers)
            (function(){
                const span = document.getElementById('detail-trainer');
                let coachText = 'TBA';
                if (course.users && Array.isArray(course.users)) {
                    const roles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                    const names = course.users.filter(u=>roles.includes(u.role||'')).map(u=>u.name).filter(Boolean);
                    if (names.length) coachText = names.join(', ');
                }
                if (span) span.innerText = "Coach: " + coachText;
            })();
            
            const hero = document.getElementById('detail-hero');
            if (course.image_path) {
                hero.style.backgroundImage = `url('${storageBaseUrl}/${course.image_path}')`;
            } else {
                hero.style.backgroundImage = "url('https://via.placeholder.com/800x300?text=No+Image')";
            }

            // Render curriculum accordion in Topics tab
            renderCurriculum(course.modules, isEnrolled, 'curriculum-list');
            enableCurriculumSelection('curriculum-list');

            // Removed: population for People, Classwork, and Grades

            // Update Enroll button in header
            const status = courseStatuses[courseId] || null;
            const enrollBtn = document.getElementById('detail-enroll-btn');
            const enrollChip = document.getElementById('detail-enroll-chip');
            enrollBtn.style.display = 'none';
            if (enrollChip) enrollChip.style.display = 'none';
            // Enrollment window gating
            (function(){
                try{
                    const now = new Date();
                    const start = course.enrollment_start_at ? new Date(course.enrollment_start_at) : null;
                    const end = course.enrollment_end_at ? new Date(course.enrollment_end_at) : null;
                    const notStarted = !!(start && now < new Date(start.getFullYear(), start.getMonth(), start.getDate()+0, 23,59,59));
                    const finished = !!(end && now > new Date(end.getFullYear(), end.getMonth(), end.getDate(), 23,59,59));
                    if (finished) {
                        if (enrollChip) enrollChip.style.display = 'inline-block';
                        return; // keep button hidden
                    }
                    if (notStarted) {
                        // hide button; could show "Not Yet Open" if desired
                        return;
                    }
                }catch(e){}
                // Only show if not enrolled and window is open
                if (status === 'active' || status === 'pending') {
                    enrollBtn.style.display = 'none';
                } else {
                    enrollBtn.style.display = 'inline-block';
                }
            })();
            
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
                    } else if (user.role === 'participant' || user.role === 'trainee') {
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
            if (materials && materials.length > 0) {
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
        function openCertificateModal(url, traineeName, courseName, issuedOn, certNo, downloadUrl){
            var m=document.getElementById('certificateModal');
            var img=document.getElementById('certificateImage');
            if(img){ img.src=url; }
            var n=document.getElementById('overlayName');
            var c=document.getElementById('overlayCourse');
            var cn=document.getElementById('overlayCertNo');
            var d=document.getElementById('overlayCompletion');
            var dl=document.getElementById('certificateDownloadBtn');
            if(n && traineeName){ n.textContent = traineeName; }
            if(c && courseName){ c.textContent = courseName; }
            if(cn){ cn.textContent = (certNo || '').toString(); }
            if(d){ d.textContent = issuedOn || '—'; }
            if(dl && downloadUrl){ dl.href = downloadUrl; }
            if(m){ m.style.display='flex'; }
        }
        function closeCertificateModal(){
            var m=document.getElementById('certificateModal');
            if(m){ m.style.display='none'; }
        }
        window.addEventListener('click',function(e){
            var m=document.getElementById('certificateModal');
            if(e.target===m){ closeCertificateModal(); }
        });
        document.addEventListener('keydown',function(e){
            if(e.key==='Escape'){ closeCertificateModal(); }
        });
        async function waitForCertificateImage(){
            var img=document.getElementById('certificateImage');
            if(!img) return;
            if(img.complete && img.naturalWidth>0) return;
            await new Promise((resolve)=>{ 
                img.onload = ()=>resolve(); 
                img.onerror = ()=>resolve(); 
            });
        }
        async function downloadCertificateFramePDF(e){
            if(e && e.preventDefault) e.preventDefault();
            var el=document.querySelector('.certificate-frame');
            if(!el) return;
            await waitForCertificateImage();
            var scale=Math.max(2, window.devicePixelRatio || 2);
            var canvas=await html2canvas(el,{scale:scale,useCORS:true,backgroundColor:null});
            var img=canvas.toDataURL('image/png');
            var pdf=new window.jspdf.jsPDF('l','mm','a4');
            var pageW=pdf.internal.pageSize.getWidth();
            var pageH=pdf.internal.pageSize.getHeight();
            var imgW=canvas.width;
            var imgH=canvas.height;
            var ratio=Math.min(pageW/imgW,pageH/imgH);
            var w=imgW*ratio;
            var h=imgH*ratio;
            var x=(pageW-w)/2;
            var y=(pageH-h)/2;
            pdf.addImage(img,'PNG',x,y,w,h);
            pdf.save('certificate.pdf');
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

    // Classroom Filter/Sort/Search Logic
    document.addEventListener('DOMContentLoaded', function() {
        const filterTabs = document.querySelectorAll('#classroom .filter-tab');
        const searchInput = document.querySelector('#classroom .search-input');
        const sortDropdown = document.querySelector('#classroom .sort-dropdown');
        const courseGrid = document.querySelector('#classroom .course-grid');
        const courseCards = Array.from(courseGrid.querySelectorAll('.new-course-card-link'));

        function updateCourses() {
            const activeFilter = document.querySelector('#classroom .filter-tab.active').innerText.toLowerCase();
            const searchTerm = searchInput.value.toLowerCase();
            const sortBy = sortDropdown.value;

            // 1. Sort
            let sortedCards = [...courseCards].sort((a, b) => {
                switch (sortBy) {
                    case 'Newest':
                        return b.dataset.startDate - a.dataset.startDate;
                    case 'Progress':
                        return b.dataset.progress - a.dataset.progress;
                    case 'Start Date':
                        return a.dataset.startDate - b.dataset.startDate;
                    default:
                        return 0;
                }
            });

            // 2. Filter and Search
            sortedCards.forEach(card => {
                const status = card.dataset.status;
                const title = card.querySelector('.card-title').innerText.toLowerCase();

                const isFilterMatch = activeFilter === 'all' || status === activeFilter;
                const isSearchMatch = title.includes(searchTerm);

                if (isFilterMatch && isSearchMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // 3. Re-append to grid
            sortedCards.forEach(card => courseGrid.appendChild(card));
        }

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                updateCourses();
            });
        });

        searchInput.addEventListener('input', updateCourses);
        sortDropdown.addEventListener('change', updateCourses);

        // Initial update
        updateCourses();
    });

    </script>
</body>
</html>
