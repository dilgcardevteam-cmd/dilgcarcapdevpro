<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CAPDEV PRO</title>
    
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
            --header-height: 64px;
        }
        @media (max-width: 1000px){
            .insight-grid,.insight-grid.insight-grid-alt{grid-template-columns:1fr}
        }

        .tab-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border:1px solid #e5e7eb;border-radius:10px;background:#fff;color:var(--primary-blue);font-weight:700;cursor:pointer}
        .tab-btn.active{background:#eef2ff;border-color:#c7d2fe}
        .btn{display:inline-flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;background:#fff;color:#111827;font-weight:700;cursor:pointer}
        .btn-blue{background:#0f3b8f;color:#fff;border-color:#0f3b8f}
        .btn-disabled{background:#e5e7eb;color:#6b7280;border-color:#e5e7eb;cursor:not-allowed}
        .btn-primary{background:#0B2C74;color:#fff;border-color:#0B2C74}
        .btn-primary:hover{filter:brightness(1.05)}
        .btn-danger{background:#dc2626;color:#fff;border-color:#dc2626}
        .btn-danger:hover{filter:brightness(1.05)}
        .pro-input{width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:10px;background:#fff}
        .empty-state{background:#fff;border:1px dashed #e5e7eb;border-radius:12px;padding:24px;text-align:center}
        .form-label{font-size:.85rem;color:#6b7280;margin-bottom:6px;font-weight:700}
        .input-pro{width:95%;padding:10px 12px;border:1px solid #e5eef7;border-radius:10px;background:#fff;transition:border-color .2s ease,box-shadow .2s ease}
        .input-pro:focus{outline:none;border-color:#c7d2fe;box-shadow:0 0 0 4px rgba(199,210,254,.35)}
        .panel-actions{display:flex;align-items:center;gap:10px}
        .roles-shell{display:grid;grid-template-columns:1fr 2fr;gap:24px}
        @media(max-width:1024px){.roles-shell{grid-template-columns:1fr}}
        .table-pro{width:100%;border-collapse:separate;border-spacing:0;border:1px solid #e5eef7;border-radius:12px;overflow:hidden}
        .table-pro thead th{background:#f8fafc;padding:12px;text-align:left;font-weight:800;color:#0B2C74;border-bottom:1px solid #e5eef7}
        .table-pro tbody td{padding:10px;border-bottom:1px solid #e5eef7}
        .table-pro tbody tr:last-child td{border-bottom:none}
        .card-muted{color:#64748b}
        .section-title{margin:0;color:#0B2C74;font-size:1.15rem;font-weight:800;letter-spacing:-.01em}
        .muted{color:#64748b}

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

        /* Header Styles (from Landing) */
        .header {
            background-color: white;
            padding: 0 24px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--header-height);
            box-sizing: border-box;
            z-index: 1000;
            margin-left: var(--sidebar-width);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-toggle,
        .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .header-toggle:hover,
        .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
        .header-section-title{margin-left:12px;font-weight:700;color:var(--primary-blue);font-size:1.2rem;letter-spacing:-.01em}

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
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
        .profile-dropdown .dropdown-meta{padding:10px 14px;border-bottom:1px solid #e5e7eb;background:#f8fafc;pointer-events:none}
        .profile-dropdown .dropdown-meta-name{font-weight:700;color:#111827;font-size:.9rem;line-height:1.2}
        .profile-dropdown .dropdown-meta-role{font-size:.8rem;color:#6b7280;margin-top:2px;line-height:1.2;text-transform:capitalize}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        .user-profile-header{
            padding:6px 8px;
            border-radius:999px;
            transition:transform .18s ease,box-shadow .22s ease,background-color .22s ease;
        }
        .user-profile-header:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 18px rgba(15,23,42,.16);
            background-color:#ffffff;
        }
        .user-profile-header:active{
            transform:translateY(-1px);
            box-shadow:0 5px 10px rgba(15,23,42,.14);
        }
        .user-profile-header .fa-chevron-down{
            transition:transform .18s ease,color .18s ease;
        }
        .user-profile-header:hover .fa-chevron-down{
            transform:translateY(-1px);
            color:#4b5563 !important;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
            margin-left: var(--sidebar-width);
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            color: white;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 40;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .header, .dashboard-container{transition:margin-left .3s ease}
        body.sidebar-collapsed .header{margin-left:var(--sidebar-collapsed-width)}
        body.sidebar-collapsed .dashboard-container{margin-left:var(--sidebar-collapsed-width)}

        .sidebar .header-title{display:flex;align-items:center;justify-content:center;padding:12px 0}
        .sidebar .header-title img{display:block;height:60px}
        .sidebar.collapsed .header-title{padding:12px 0}
        .sidebar.collapsed .header-title img{height:40px;margin:0 auto}

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
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            display: none;
        }

        .sidebar.collapsed .sidebar-toggle {
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: var(--bg-color);
            position: relative;
            z-index: 1;
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

        /* LMS Home */
        .lms-home {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .lms-home-hero {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            padding: 24px 24px 22px;
            background: linear-gradient(145deg, #153e8a 0%, #1b4ea9 58%, #2b66d9 100%);
            box-shadow: 0 16px 34px rgba(21, 62, 138, 0.24);
            color: #ffffff;
        }

        .lms-home-hero::before,
        .lms-home-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .lms-home-hero::before {
            width: 220px;
            height: 220px;
            top: -110px;
            right: -70px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        }

        .lms-home-hero::after {
            width: 280px;
            height: 280px;
            bottom: -170px;
            left: -90px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.14) 0%, transparent 74%);
        }

        .lms-home-headline {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .lms-home-kicker {
            margin: 0 0 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            font-weight: 700;
            opacity: 0.9;
        }

        .lms-welcome {
            color: #ffffff;
            margin: 0;
            font-size: 2rem;
            line-height: 1.12;
        }

        .lms-home-subtitle {
            margin: 10px 0 0;
            max-width: 700px;
            line-height: 1.5;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.92);
        }

        .admin-hero-stats-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 16px;
        }

        @media (min-width: 900px) {
            .admin-hero-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1200px) {
            .admin-hero-stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .admin-hero-stat-card {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.22s ease, background-color 0.22s ease, box-shadow 0.22s ease;
            min-height: 108px;
        }

        .admin-hero-stat-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.14);
        }

        .admin-hero-stat-card.clickable {
            cursor: pointer;
        }

        .admin-hero-stat-card.clickable:focus-visible {
            outline: 2px solid rgba(255, 255, 255, 0.92);
            outline-offset: 2px;
        }

        .admin-hero-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: #ffffff;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex: 0 0 auto;
        }

        .admin-hero-stat-card.tone-green .admin-hero-stat-icon {
            color: #15803d;
        }

        .admin-hero-stat-card.tone-orange .admin-hero-stat-icon {
            color: #b45309;
        }

        .admin-hero-stat-card.tone-slate .admin-hero-stat-icon {
            color: #334155;
        }

        .admin-hero-stat-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-hero-stat-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            color: #ffffff;
        }

        .admin-hero-stat-label {
            margin-top: 6px;
            font-size: 0.82rem;
            opacity: 0.9;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: rgba(255, 255, 255, 0.92);
        }

        .admin-hero-stat-meta {
            margin-top: 6px;
            font-size: 0.92rem;
            line-height: 1.4;
            color: rgba(255, 255, 255, 0.88);
        }

        .lms-home-quick {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .lms-pill-btn {
            border: 1px solid rgba(255, 255, 255, 0.38);
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            border-radius: 999px;
            padding: 9px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .lms-pill-btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.24);
            border-color: rgba(255, 255, 255, 0.56);
        }

        .lms-hero-metrics {
            margin-top: 16px;
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .lms-hero-chip {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            padding: 10px 12px;
            min-width: 168px;
        }

        .lms-hero-chip span {
            display: block;
            font-size: 0.74rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            opacity: 0.88;
        }

        .lms-hero-chip strong {
            display: block;
            margin-top: 2px;
            font-size: 1.22rem;
            line-height: 1.2;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 0;
        }

        .stat-card {
            background-color: #ffffff;
            padding: 16px;
            border-radius: 14px;
            border: 1px solid #dbe4f0;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.07);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            min-height: 92px;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
        }

        .stat-card.clickable {
            cursor: pointer;
        }

        .stat-card.clickable:focus-visible {
            outline: 2px solid #17489f;
            outline-offset: 2px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.12rem;
            flex-shrink: 0;
            margin-right: 0;
            color: var(--primary-blue);
            background: #eaf1ff;
        }

        .stat-card.tone-green .stat-icon {
            background: #e8f7e8;
            color: #1f7e3a;
        }

        .stat-card.tone-orange .stat-icon {
            background: #fff2e2;
            color: #b45309;
        }

        .stat-card.tone-slate .stat-icon {
            background: #edf2f7;
            color: #334155;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.66rem;
            color: var(--primary-blue);
            font-weight: 700;
            line-height: 1.04;
        }
        .donut-seg{transition:stroke-dasharray .9s cubic-bezier(.22,1,.36,1)}

        .stat-info p {
            margin: 3px 0 0;
            color: var(--light-text);
            font-size: 0.86rem;
        }

        .stat-meta {
            margin-top: 5px;
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
        }

        .insight-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 20px;
        }

        .insight-grid.insight-grid-alt {
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
        }

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

        .role-bar-list {
            display: grid;
            gap: 12px;
        }

        .role-bar-item {
            display: grid;
            gap: 6px;
        }

        .role-bar-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 10px;
        }

        .role-bar-top label {
            font-size: 0.83rem;
            color: #334155;
            font-weight: 600;
        }

        .role-bar-top strong {
            font-size: 0.8rem;
            color: #0f172a;
        }

        .role-bar-track {
            width: 100%;
            height: 9px;
            background: #edf2f7;
            border-radius: 999px;
            overflow: hidden;
        }

        .role-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #17489f 0%, #4f77cd 100%);
        }

        .role-bar-fill.green {
            background: linear-gradient(90deg, #1f7e3a 0%, #46a562 100%);
        }

        .role-bar-fill.orange {
            background: linear-gradient(90deg, #b45309 0%, #de8a40 100%);
        }

        .insight-footnote {
            margin-top: 10px;
            font-size: 0.79rem;
            color: #64748b;
        }

        .pipeline-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pipeline-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
            background: #f8fafc;
        }

        .pipeline-card.clickable {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .pipeline-card.clickable:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.1);
            border-color: #c9d7ea;
        }

        .pipeline-card.clickable:focus-visible {
            outline: 2px solid #17489f;
            outline-offset: 2px;
        }

        .pipeline-card span {
            display: block;
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 700;
        }

        .pipeline-card strong {
            display: block;
            margin-top: 3px;
            color: #0f172a;
            font-size: 1.28rem;
            line-height: 1.05;
        }

        .home-recent-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .home-recent-item {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            background: #ffffff;
        }

        .home-recent-title {
            margin: 0;
            color: #0f172a;
            font-size: 0.9rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .home-recent-meta {
            margin-top: 4px;
            font-size: 0.78rem;
            color: #64748b;
        }

        .focus-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 8px;
        }

        .focus-list li {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 9px 11px;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            color: #334155;
            font-size: 0.84rem;
            font-weight: 600;
        }

        .focus-list strong {
            font-size: 0.95rem;
            color: #0f172a;
        }

        .focus-action {
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            background: var(--primary-blue);
            color: #ffffff;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.82rem;
        }

        .focus-action:hover {
            background: #123d8f;
        }

        #course-management .course-card {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            transform: translateY(0);
            will-change: transform;
        }

        #course-management .course-card:hover,
        #course-management a:hover .course-card,
        #course-management a:focus-visible .course-card {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.16) !important;
        }

        #course-management .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        #course-management .add-course-card {
            height: 280px;
            border: 2px dashed #93c5fd;
            border-radius: 10px;
            background: linear-gradient(160deg, #f8fbff 0%, #eef6ff 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            color: #1d4ed8;
            cursor: pointer;
        }

        #course-management .add-course-plus {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #1d4ed8;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.3);
        }

        #course-management .add-course-title {
            margin: 0;
            font-size: 1.02rem;
            font-weight: 800;
            color: #1e3a8a;
        }

        #course-management .course-stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin: 0 0 20px;
        }

        #course-management .course-stat-card {
            border: 1px solid #dbe2ea;
            border-radius: 14px;
            background: #ffffff;
            padding: 14px 16px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 88px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        #course-management .course-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 24px rgba(15, 23, 42, 0.12);
        }

        #course-management .course-stat-label {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: #334155;
        }

        #course-management .course-stat-value {
            margin: 4px 0 0;
            font-size: 1.7rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        #course-management .course-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #ffffff;
            flex: 0 0 42px;
        }

        #course-management .course-stat-card.active .course-stat-icon { background: #1d4ed8; }
        #course-management .course-stat-card.pending .course-stat-icon { background: #d97706; }
        #course-management .course-stat-card.draft .course-stat-icon { background: #7c3aed; }
        #course-management .course-stat-card.archived .course-stat-icon { background: #475569; }
        #course-management .course-stat-card.library .course-stat-icon { background: #10b981; }

        #course-create .course-create-shell {
            background: #ffffff;
            border: 1px solid #dbe2ea;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        #courseCreateFrame {
            width: 100%;
            height: calc(100vh - 245px);
            min-height: 760px;
            border: 0;
            background: #ffffff;
            display: block;
            position: relative;
            z-index: 1;
        }

        #course-create:not(.active) #courseCreateFrame {
            pointer-events: none;
            visibility: hidden;
            height: 0;
            min-height: 0;
        }

        #course-create.active #courseCreateFrame {
            pointer-events: auto;
            visibility: visible;
        }

        /* Legacy add-course modal is superseded by the in-content course-create section. */
        #addCourseModal {
            display: none !important;
            pointer-events: none !important;
            visibility: hidden !important;
        }

        /* Placeholder Content */
        .placeholder-content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
            color: var(--light-text);
        }

        /* Profile Section */
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
            grid-column: 1 / -1;
            gap: 10px;
            flex-wrap: wrap;
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

        #profile-section .profile-page-btn.is-revealed {
            animation: profileBtnReveal 0.26s cubic-bezier(0.2, 0.7, 0.3, 1) both;
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

        @keyframes profileBtnReveal {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #profile-section .profile-page-btn {
                animation: none !important;
                transition: none;
            }
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

        #profile-section .profile-page-fields label {
            display: block;
            margin-bottom: 6px;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        #profile-section .profile-field-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        #profile-section .profile-field-icon {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
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

        .role-choice-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .role-choice-card {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border: 1.5px solid #d8e2ef; /* Slightly thicker default */
            border-radius: 14px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* Admin Default Colors */
        .role-choice-card.role-admin { border-color: #cbdcfc; } /* Light blue border */
        .role-choice-card.role-admin .role-choice-indicator { border-color: #2563eb; }
        .role-choice-card.role-admin .role-choice-desc { color: #4777e0; }

        /* TM Default Colors */
        .role-choice-card.role-tm { border-color: #fde6d7; } /* Light orange border */
        .role-choice-card.role-tm .role-choice-indicator { border-color: #f97316; }
        .role-choice-card.role-tm .role-choice-desc { color: #f28a41; }

        /* Coach Default Colors */
        .role-choice-card.role-coach { border-color: #fee2e2; } /* Light red border */
        .role-choice-card.role-coach .role-choice-indicator { border-color: #ef4444; }
        .role-choice-card.role-coach .role-choice-desc { color: #f06b6b; }

        /* Participant Default Colors */
        .role-choice-card.role-participant { border-color: #fef3c7; } /* Light yellow border */
        .role-choice-card.role-participant .role-choice-indicator { border-color: #fbbf24; }
        .role-choice-card.role-participant .role-choice-desc { color: #d9a41c; }

        .role-choice-card:hover {
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .role-choice-card.is-selected {
            border-width: 2.5px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        /* Role-specific selected states */
        .role-choice-card.role-admin.is-selected {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.04);
        }
        .role-choice-card.role-admin.is-selected .role-choice-indicator {
            background: rgba(37, 99, 235, 0.1);
        }
        .role-choice-card.role-admin.is-selected .role-choice-indicator::after {
            background: #2563eb;
        }

        .role-choice-card.role-tm.is-selected {
            border-color: #f97316;
            background: rgba(249, 115, 22, 0.04);
        }
        .role-choice-card.role-tm.is-selected .role-choice-indicator {
            background: rgba(249, 115, 22, 0.1);
        }
        .role-choice-card.role-tm.is-selected .role-choice-indicator::after {
            background: #f97316;
        }

        .role-choice-card.role-coach.is-selected {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.04);
        }
        .role-choice-card.role-coach.is-selected .role-choice-indicator {
            background: rgba(239, 68, 68, 0.1);
        }
        .role-choice-card.role-coach.is-selected .role-choice-indicator::after {
            background: #ef4444;
        }

        .role-choice-card.role-participant.is-selected {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.04);
        }
        .role-choice-card.role-participant.is-selected .role-choice-indicator {
            background: rgba(251, 191, 36, 0.1);
        }
        .role-choice-card.role-participant.is-selected .role-choice-indicator::after {
            background: #fbbf24;
        }

        .role-choice-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-choice-indicator {
            width: 20px;
            height: 20px;
            border-radius: 999px;
            border: 2px solid #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 20px;
            margin-top: 2px;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }

        .role-choice-indicator::after {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: transparent;
            transition: background-color 0.2s ease;
        }

        .role-choice-copy {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .role-choice-title {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .role-choice-desc {
            font-size: 0.82rem;
            color: #64748b;
            line-height: 1.4;
        }

        /* Course View Details Section */
        #course-view-details {
            background: #f8fafc;
            min-height: calc(100vh - 100px);
        }

        .course-view-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 32px 40px;
            margin: -24px -32px 24px -32px;
        }

        .course-view-nav {
            display: flex;
            gap: 32px;
            margin-top: 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .course-nav-item {
            padding: 12px 4px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            position: relative;
            transition: color 0.2s ease;
        }

        .course-nav-item:hover { color: #0f172a; }
        .course-nav-item.active { color: #2563eb; }
        .course-nav-item.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #2563eb;
            border-radius: 999px;
        }

        .course-content-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
        }

        .course-main-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .course-side-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .module-list-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .module-list-item:hover {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
        }

        .topic-badge {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            color: #475569;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .topic-badge:hover,
        .topic-badge:focus {
            border-color: #2563eb;
            color: #1d4ed8;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.12);
            outline: none;
        }

        .topic-badge.active {
            background: #eff6ff;
            border-color: #2563eb;
            color: #1d4ed8;
        }

        .topic-detail-panel {
            margin-top: 16px;
            padding: 18px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        }

        .topic-detail-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .topic-field-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .topic-choice-item {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            background: #ffffff;
        }

        .topic-choice-item.correct {
            border-color: #86efac;
            background: #f0fdf4;
            color: #166534;
        }

        .material-tag {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .material-tag:hover {
            background: #e0ecff;
            border-color: #93c5fd;
            color: #1d4ed8;
            transform: translateY(-1px);
        }

        .exam-detail-panel {
            margin-top: 16px;
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 12px;
        }

        .exam-question-item {
            padding: 12px 14px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }

        .exam-choice-list {
            display: grid;
            gap: 8px;
            margin-top: 10px;
        }

        .exam-choice-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #f8fafc;
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .exam-choice-item.correct {
            border-color: #86efac;
            background: #f0fdf4;
            color: #166534;
        }

        .permissions-panel-shell {
            border: none;
            background: transparent;
            padding: 0;
        }

        .permissions-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .permissions-header-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .permissions-header-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .permissions-header-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
        }

        .permissions-header-badge {
            background: #f1f5f9;
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .unsaved-badge {
            background: #fff1f2;
            color: #e11d48;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: none;
            align-items: center;
            gap: 4px;
            border: 1px solid #fecdd3;
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(225, 29, 72, 0); }
            100% { box-shadow: 0 0 0 0 rgba(225, 29, 72, 0); }
        }

        .permissions-header-desc {
            margin: 0;
            font-size: 0.88rem;
            color: #64748b;
        }

        .permissions-header-actions {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .select-all-box {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .select-all-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
        }

        .permissions-grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .permission-group-card {
            background: #ffffff;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .permission-group-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .permission-group-title {
            margin: 0 0 16px;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .permission-group-title::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e1;
        }

        .group-admin .permission-group-title { color: #2563eb; }
        .group-admin .permission-group-title::before { background: #2563eb; }
        
        .group-tm .permission-group-title { color: #f97316; }
        .group-tm .permission-group-title::before { background: #f97316; }
        
        .group-coach .permission-group-title { color: #ef4444; }
        .group-coach .permission-group-title::before { background: #ef4444; }
        
        .group-participant .permission-group-title { color: #fbbf24; }
        .group-participant .permission-group-title::before { background: #fbbf24; }

        /* Admin System (Blue) */
        .group-admin .permission-option-input:checked + .permission-option-circle {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.1);
        }
        .group-admin .permission-option-input:checked + .permission-option-circle::after {
            background: #2563eb;
        }
        .group-admin .permissions-save-btn {
            background: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .group-admin .permissions-save-btn:hover { background: #1d4ed8; }

        /* TM System (Orange) */
        .group-tm .permission-option-input:checked + .permission-option-circle {
            border-color: #f97316;
            background: rgba(249, 115, 22, 0.1);
        }
        .group-tm .permission-option-input:checked + .permission-option-circle::after {
            background: #f97316;
        }
        .group-tm .permissions-save-btn {
            background: #f97316;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }
        .group-tm .permissions-save-btn:hover { background: #ea580c; }

        /* Coach System (Red) */
        .group-coach .permission-option-input:checked + .permission-option-circle {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }
        .group-coach .permission-option-input:checked + .permission-option-circle::after {
            background: #ef4444;
        }
        .group-coach .permissions-save-btn {
            background: #ef4444;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        .group-coach .permissions-save-btn:hover { background: #dc2626; }

        /* Participant System (Yellow) */
        .group-participant .permission-option-input:checked + .permission-option-circle {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }
        .group-participant .permission-option-input:checked + .permission-option-circle::after {
            background: #fbbf24;
        }
        .group-participant .permissions-save-btn {
            background: #fbbf24;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.2);
        }
        .group-participant .permissions-save-btn:hover { background: #f59e0b; }

        .permission-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .permission-option {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 4px 0;
            transition: opacity 0.2s ease;
            user-select: none;
        }

        .permission-option.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .permission-option-input {
            position: absolute;
            opacity: 0;
            width: 22px;
            height: 22px;
            cursor: pointer;
            z-index: 2;
            margin: 0;
        }

        .select-all-box.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .permission-option-circle {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .permission-option-circle::after {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: transparent;
            transition: background 0.2s ease;
        }

        .permission-option-input:checked + .permission-option-circle {
            border-color: #f97316; /* Orange like in the picture */
            background: rgba(249, 115, 22, 0.1);
        }

        .permission-option-input:checked + .permission-option-circle::after {
            background: #f97316;
        }

        .permission-option-label {
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
            transition: color 0.2s ease;
        }

        .permission-option-input:checked ~ .permission-option-label {
            color: #0f172a;
        }

        /* Permission Accordion & Table Styles */
        .permission-accordion {
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #ffffff;
            margin-bottom: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .permission-accordion.active {
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
            border-color: #e2e8f0;
        }

        .permission-accordion-header {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            transition: background 0.2s ease;
            gap: 20px;
        }

        .permission-accordion-header:hover {
            background: #f8fafc;
        }

        .permission-role-info {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .permission-header-controls {
            display: flex;
            align-items: center;
            gap: 24px;
            pointer-events: auto;
        }

        .permission-role-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .permission-dropdown-indicator {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: transform 0.3s ease, background 0.2s ease;
            background: #f1f5f9;
        }

        .permission-accordion.active .permission-dropdown-indicator {
            transform: rotate(180deg);
            background: #e2e8f0;
            color: #0f172a;
        }

        .permission-accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-top: 1px solid transparent;
        }

        .permission-accordion.active .permission-accordion-content {
            max-height: 2000px;
            border-top: 1px solid #f1f5f9;
        }

        .permission-accordion-inner {
            padding: 24px;
        }

        .permission-table-wrapper {
            overflow-x: auto;
            margin-bottom: 24px;
        }

        .permission-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .permission-table th {
            padding: 12px 16px;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 2px solid #f1f5f9;
        }

        .permission-table td {
            padding: 16px;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }

        .permission-table tr:last-child td {
            border-bottom: none;
        }

        .permission-group-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.95rem;
        }

        .permission-group-desc {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.4;
            max-width: 400px;
        }

        .permission-cell-na {
            font-size: 0.75rem;
            font-weight: 700;
            color: #cbd5e1;
            text-align: center;
            user-select: none;
        }

        .permission-cell-check {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .accordion-admin.active { border-left: 4px solid #2563eb; }
        .accordion-tm.active { border-left: 4px solid #f97316; }
        .accordion-coach.active { border-left: 4px solid #ef4444; }
        .accordion-participant.active { border-left: 4px solid #fbbf24; }

        .accordion-admin .permission-role-name { color: #2563eb; }
        .accordion-tm .permission-role-name { color: #f97316; }
        .accordion-coach .permission-role-name { color: #ef4444; }
        .accordion-participant .permission-role-name { color: #f59e0b; }

        .permission-table .permission-option {
            justify-content: center;
            padding: 0;
            margin: 0;
        }

        .permissions-save-btn {
            background: #f97316;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }

        .permissions-save-btn:hover {
            background: #ea580c;
            transform: translateY(-1px);
        }

        .permissions-save-btn:active {
            transform: translateY(0);
        }

        .permissions-save-btn svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.5;
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

            #profile-section .profile-page-actions {
                width: 100%;
            }
        }

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
            margin: 10% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        #viewUserModal {
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        #viewUserModal .modal-content {
            margin: 0;
            width: min(920px, 94vw);
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }

        #viewUserModal {
            background-color: rgba(15, 23, 42, 0.58);
            backdrop-filter: blur(2px);
        }

        #cloneCourseModal {
            align-items: center;
            justify-content: center;
            background-color: rgba(15, 23, 42, 0.58);
            backdrop-filter: blur(2px);
        }

        #viewCourseModal {
            align-items: center;
            justify-content: center;
            padding: 18px;
            box-sizing: border-box;
            background-color: rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(2px);
        }

        #viewCourseModal .modal-content {
            margin: 0;
            width: min(1220px, 98vw);
            max-width: 1220px;
            height: calc(100vh - 36px);
            padding: 0;
            border: none;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 48px rgba(2, 6, 23, 0.4);
            background: #fff;
        }

        .course-view-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-shrink: 0;
        }

        .course-view-modal-title-wrap {
            min-width: 0;
        }

        .course-view-modal-title {
            margin: 0;
            color: var(--primary-blue);
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 760px;
        }

        .course-view-close {
            position: static;
            float: none;
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            color: #64748b;
            background: #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .course-view-close:hover {
            background: #cbd5e1;
            color: #1e293b;
        }

        .course-view-modal-body {
            position: relative;
            flex: 1;
            background: #fff;
        }

        .course-view-loading {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.95rem;
            background: #fff;
            z-index: 1;
        }

        #view_course_iframe {
            width: 100%;
            height: 100%;
            border: 0;
            visibility: hidden;
            background: #fff;
        }

        .profile-edit-modal {
            padding: 0;
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(2, 6, 23, 0.35);
            background: #ffffff;
        }

        #viewUserModal .close {
            position: absolute;
            top: 14px;
            right: 16px;
            float: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            color: #64748b;
            background: #f1f5f9;
            transition: all 0.2s ease;
        }

        #userDetailsMount .close {
            position: absolute;
            top: 14px;
            right: 16px;
            float: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            color: #64748b;
            background: #f1f5f9;
            transition: all 0.2s ease;
        }

        #viewUserModal .close:hover,
        #viewUserModal .close:focus {
            color: #0f172a;
            background: #e2e8f0;
        }

        #userDetailsMount .close:hover,
        #userDetailsMount .close:focus {
            color: #0f172a;
            background: #e2e8f0;
        }

        .profile-edit-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        }

        .profile-edit-headline {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .profile-user-brief {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .profile-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(145deg, #0b4f95 0%, #002c76 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-user-meta {
            min-width: 0;
        }

        .profile-edit-title {
            color: var(--primary-blue);
            margin: 0;
            font-size: 1.35rem;
            line-height: 1.2;
        }

        .profile-user-email {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 0.84rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 340px;
        }

        .profile-meta-badges {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
        }

        .profile-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            border: 1px solid transparent;
        }

        .profile-meta-chip .chip-label {
            opacity: 0.78;
            text-transform: uppercase;
            font-size: 0.68rem;
            letter-spacing: 0.04em;
        }

        .profile-meta-chip .chip-value {
            text-transform: capitalize;
        }

        .profile-meta-chip.role {
            background: #e8effd;
            border-color: #c7d8fb;
            color: #1e3a8a;
        }

        .profile-meta-chip.status {
            background: #ecfdf3;
            border-color: #bbf7d0;
            color: #166534;
        }

        .profile-meta-chip.status[data-status="freeze"] {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .profile-meta-chip.status[data-status="pending"] {
            background: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }

        .profile-edit-subtitle {
            margin: 0;
            color: #64748b;
            font-size: 0.88rem;
        }

        .profile-edit-subrow {
            margin-top: 10px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .profile-header-actions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .profile-edit-form {
            padding: 18px 24px 22px;
            background: linear-gradient(180deg, #fbfdff 0%, #ffffff 100%);
        }

        .profile-section {
            background: #ffffff;
            border: 1px solid #e5edf7;
            border-radius: 12px;
            padding: 14px 14px 16px;
        }

        .profile-section + .profile-section {
            margin-top: 12px;
        }

        .profile-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 12px;
            color: #1f3f78;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .profile-section-title svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .profile-edit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 16px;
        }

        .profile-location-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 16px;
            margin-top: 2px;
        }

        #viewUserModal .form-group {
            margin-bottom: 0;
        }

        #userDetailsMount .form-group {
            margin-bottom: 0;
        }

        .field-with-icon {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #64748b;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none;
        }

        #viewUserModal .form-group label {
            margin-bottom: 6px;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        #userDetailsMount .form-group label {
            margin-bottom: 6px;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        #viewUserModal .form-group input,
        #viewUserModal .form-group select {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d5deea;
            border-radius: 10px;
            box-sizing: border-box;
            background: #ffffff;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        #userDetailsMount .form-group input,
        #userDetailsMount .form-group select {
            width: 100%;
            height: 42px;
            padding: 0 12px;
            border: 1px solid #d5deea;
            border-radius: 10px;
            box-sizing: border-box;
            background: #ffffff;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        #viewUserModal .field-with-icon input,
        #viewUserModal .field-with-icon select {
            padding-left: 36px;
        }

        #userDetailsMount .field-with-icon input,
        #userDetailsMount .field-with-icon select {
            padding-left: 36px;
        }

        #viewUserModal .field-with-icon select {
            padding-right: 34px;
        }

        #userDetailsMount .field-with-icon select {
            padding-right: 34px;
        }

        #viewUserModal .form-group input:focus,
        #viewUserModal .form-group select:focus {
            outline: none;
            border-color: #2f5aa8;
            box-shadow: 0 0 0 3px rgba(47, 90, 168, 0.15);
        }

        #userDetailsMount .form-group input:focus,
        #userDetailsMount .form-group select:focus {
            outline: none;
            border-color: #2f5aa8;
            box-shadow: 0 0 0 3px rgba(47, 90, 168, 0.15);
        }

        #viewUserModal .form-group input:disabled,
        #viewUserModal .form-group select:disabled {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
            cursor: not-allowed;
        }

        #userDetailsMount .form-group input:disabled,
        #userDetailsMount .form-group select:disabled {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
            cursor: not-allowed;
        }

        .profile-password-wrap {
            position: relative;
        }

        .profile-password-wrap input {
            padding-right: 44px !important;
        }

        .password-toggle {
            position: absolute;
            right: 8px;
            top: 30px;
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-eye {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .password-toggle:hover {
            background: #f1f5f9;
            color: #334155;
        }

        .password-help {
            display: block;
            color: #64748b;
            margin-top: 6px;
            font-size: 0.78rem;
        }

        .modal-action-btn {
            border: 1.5px solid currentColor;
            background: transparent;
            border-radius: 999px;
            width: 36px;
            height: 36px;
            padding: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.16);
            transition: color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .modal-action-btn:hover {
            background: transparent;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.22);
            transform: translateY(-1px);
        }

        .modal-action-edit {
            color: #002C76;
        }

        .modal-action-cancel {
            color: #f97316;
        }

        .modal-action-update {
            color: #16a34a;
        }

        .modal-action-delete {
            color: #b91c1c;
        }

        .modal-action-edit:hover { color: #001f57; }
        .modal-action-cancel:hover { color: #ea580c; }
        .modal-action-update:hover { color: #15803d; }
        .modal-action-delete:hover { color: #991b1b; }

        .modal-action-icon {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
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
        .badge-role-trainer { background: #b91c1c; color: #ffffff; }
        .badge-role-coach { background: #b91c1c; color: #ffffff; }
        .badge-role-trainee { background: #f59e0b; color: #ffffff; }
        .badge-role-participant { background: #f59e0b; color: #ffffff; }

        /* Office Level Role Variants */
        .badge-role-central_office_admin, .badge-role-regional_office_admin, .badge-role-provincial_office_admin { background: #00215e; color: #ffffff; }
        .badge-role-central_office_training_manager, .badge-role-regional_office_training_manager, .badge-role-provincial_office_training_manager { background: #facc15; color: #1e293b; }
        .badge-role-central_office_coach, .badge-role-regional_office_coach, .badge-role-provincial_office_coach { background: #b91c1c; color: #ffffff; }
        .badge-role-central_office_participants, .badge-role-regional_office_participants, .badge-role-provincial_office_participants { background: #f59e0b; color: #ffffff; }

        .badge-status-active { background: #16a34a; color: #ffffff; }
        .badge-status-freeze { background: #dc2626; color: #ffffff; }
        .badge-status-pending { background: #d97706; color: #ffffff; }

        .actions-inline {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .inline-form {
            margin: 0;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .btn-action-view {
            background: transparent;
            color: #002C76;
            border: none;
        }
        .btn-action-view:hover {
            background: transparent;
            color: #002C76;
        }
        .btn-action-danger {
            background: transparent;
            color: #b91c1c;
            border: none;
        }
        .btn-action-danger:hover {
            background: transparent;
            color: #991b1b;
        }

        .btn-icon-only {
            width: 34px;
            height: 34px;
            padding: 0;
            gap: 0;
        }

        .btn-icon-only .icon-feather {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

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

        .user-details-shell {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 2px 0 12px;
        }

        .user-details-topbar {
            position: relative;
            display: block;
        }

        .user-details-back {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            min-height: 44px;
            border: 1px solid #d9e3f2;
            border-radius: 12px;
            background: #ffffff;
            color: #163f8a;
            padding: 0 16px;
            cursor: pointer;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: -0.01em;
            white-space: nowrap;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
            transition: transform 0.16s ease, box-shadow 0.16s ease, border-color 0.16s ease;
        }

        .user-details-back:hover {
            transform: translateY(-1px);
            border-color: #b8cae6;
            box-shadow: 0 12px 22px rgba(15, 23, 42, 0.07);
        }

        .user-details-hero {
            position: relative;
            overflow: hidden;
            border: 1px solid #dfe9fb;
            border-radius: 16px;
            padding: 68px 18px 14px;
            background: linear-gradient(135deg, #ffffff 0%, #f9fbff 54%, #edf4ff 100%);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.045);
        }

        .user-details-hero::after {
            content: "";
            position: absolute;
            right: -24px;
            bottom: -46px;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.12), rgba(96, 165, 250, 0.02) 66%, transparent 70%);
            pointer-events: none;
        }

        .user-details-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eaf1ff;
            color: #0f3b8f;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .user-details-headline {
            margin: 0;
            color: #0f172a;
            font-size: clamp(1.2rem, 1.45vw, 1.55rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.12;
            max-width: 640px;
        }

        .user-details-note {
            margin-top: 8px;
            color: #5b6b82;
            font-size: 0.9rem;
            line-height: 1.45;
            max-width: 680px;
        }

        #userDetailsMount .profile-edit-modal {
            width: 100%;
            max-width: none;
            margin-top: -2px;
            border-radius: 16px;
            border: 1px solid #e2eaf5;
            background: #ffffff;
            box-shadow: 0 20px 46px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        #userDetailsMount .close {
            top: 22px;
            right: 24px;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fbff;
            border: 1px solid #d8e2ef;
            box-shadow: none;
        }

        #userDetailsMount .profile-edit-header {
            position: relative;
            padding: 22px 24px 14px;
            background: #ffffff;
            border-bottom: 1px solid #e8eef6;
        }

        #userDetailsMount .profile-edit-header::after {
            display: none;
        }

        #userDetailsMount .profile-edit-headline {
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        #userDetailsMount .profile-user-brief {
            align-items: center;
            gap: 16px;
        }

        #userDetailsMount .profile-user-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(180deg, #1d4fa8 0%, #0b2c76 100%);
            border: none;
            box-shadow: none;
            color: #ffffff;
            font-size: 1.65rem;
            font-weight: 800;
        }

        #userDetailsMount .profile-edit-title,
        #userDetailsMount .profile-user-email,
        #userDetailsMount .profile-edit-subtitle {
            color: inherit;
        }

        #userDetailsMount .profile-edit-title {
            font-size: clamp(1.45rem, 1.7vw, 1.9rem);
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        #userDetailsMount .profile-user-email {
            margin-top: 6px;
            color: #64748b;
            opacity: 1;
            font-size: 0.94rem;
        }

        #userDetailsMount .profile-meta-badges {
            justify-content: flex-end;
            gap: 10px;
        }

        #userDetailsMount .profile-meta-chip {
            padding: 7px 12px;
            border-radius: 999px;
            border-width: 1px;
            font-size: 0.78rem;
            box-shadow: none;
        }

        #userDetailsMount .profile-edit-subrow {
            margin-top: 14px;
            padding: 0;
            border: none;
            border-radius: 0;
            background: transparent;
            backdrop-filter: none;
            align-items: center;
        }

        #userDetailsMount .profile-edit-subtitle {
            color: #64748b;
            max-width: 780px;
            font-size: 0.96rem;
        }

        #userDetailsMount .profile-header-actions {
            gap: 10px;
        }

        #userDetailsMount .modal-action-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            box-shadow: none;
            background: #ffffff;
        }

        #userDetailsMount .profile-edit-form {
            padding: 0 24px 22px;
            background: #ffffff;
        }

        #userDetailsMount .modal-tabs {
            display: flex !important;
            flex-wrap: wrap;
            gap: 14px !important;
            margin: 0;
            padding: 0 0 2px;
            border-bottom: 1px solid #e8eef6 !important;
        }

        #userDetailsMount .modal-tab {
            border: none !important;
            border-bottom: 2px solid transparent !important;
            background: transparent !important;
            color: #6b7a90 !important;
            padding: 14px 0 12px !important;
            border-radius: 0 !important;
            font-weight: 700 !important;
            transition: color 0.14s ease, border-color 0.14s ease;
            box-shadow: none !important;
        }

        #userDetailsMount .modal-tab:hover {
            transform: none;
            border-color: rgba(15, 59, 143, 0.28) !important;
            color: #173b83 !important;
        }

        #userDetailsMount .modal-tab.active {
            background: transparent !important;
            color: #0f3b8f !important;
            border-color: #0f3b8f !important;
            box-shadow: none;
        }

        #userDetailsMount .profile-section {
            margin-top: 16px;
            padding: 20px;
            border: 1px solid #e6edf7;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        #userDetailsMount .profile-section-title {
            margin-bottom: 16px;
            font-size: 0.92rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #173b83;
        }

        #userDetailsMount .profile-section-title svg {
            width: 17px;
            height: 17px;
        }

        #userDetailsMount .profile-edit-grid,
        #userDetailsMount .profile-location-grid {
            gap: 14px 18px;
        }

        #userDetailsMount .form-group label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4b5d74;
        }

        #userDetailsMount .field-with-icon input,
        #userDetailsMount .field-with-icon select {
            min-height: 56px;
            border-radius: 14px;
            border: 1px solid #dce5f1;
            background: #fbfdff;
            box-shadow: none;
        }

        #userDetailsMount .field-with-icon {
            border-radius: 14px;
        }

        #userDetailsMount .role-choice-grid {
            gap: 16px;
        }

        #userDetailsMount .role-choice-card {
            border-radius: 16px;
            padding: 20px 18px;
            box-shadow: none;
            border: 1px solid #e2eaf5;
            background: #fbfdff;
        }

        #userDetailsMount .permission-accordion {
            border-radius: 16px;
            box-shadow: none;
            border: 1px solid #e2eaf5;
        }

        #userDetailsMount .permission-accordion-header {
            padding: 18px 20px;
        }

        #userDetailsMount .permission-accordion-content {
            padding: 0 18px 18px;
        }

        #userDetailsMount .profile-password-wrap {
            max-width: 760px;
        }

        @media (max-width: 980px) {
            .user-details-topbar {
                grid-template-columns: 1fr;
            }

            .user-details-hero {
                padding: 12px 14px 14px;
            }

            .user-details-back {
                top: 10px;
                left: 10px;
            }

            .user-details-hero {
                padding: 58px 14px 14px;
            }

            #userDetailsMount .profile-edit-header {
                padding: 18px 18px 12px;
            }

            #userDetailsMount .profile-edit-headline,
            #userDetailsMount .profile-edit-subrow {
                flex-direction: column;
                align-items: flex-start;
            }

            #userDetailsMount .profile-meta-badges {
                justify-content: flex-start;
            }

            #userDetailsMount .profile-edit-form {
                padding: 0 16px 18px;
            }
        }

        @media (max-width: 640px) {
            .lms-pill-btn,
            .focus-action {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            #course-management .course-stats-grid {
                grid-template-columns: 1fr;
            }

            #courseCreateFrame {
                min-height: 560px;
                height: calc(100vh - 220px);
            }

            .pipeline-grid {
                grid-template-columns: 1fr;
            }

            .lms-hero-chip {
                min-width: 0;
                width: 100%;
            }
        }

        @media (min-width: 641px) and (max-width: 992px) {
            #course-management .course-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            #courseCreateFrame {
                min-height: 640px;
                height: calc(100vh - 230px);
            }
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
                padding: 10px 14px;
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

            .lms-home-hero {
                padding: 18px 18px 16px;
            }

            .lms-home-headline {
                flex-direction: column;
                align-items: flex-start;
            }

            .lms-home-quick {
                justify-content: flex-start;
            }

            .lms-welcome {
                font-size: 1.56rem;
            }

            .admin-hero-stat-card {
                padding: 18px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .insight-grid,
            .insight-grid.insight-grid-alt {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: min(94vw, 720px);
                margin: 20px auto;
                padding: 20px;
            }

            #viewUserModal {
                padding: 12px;
            }

            #viewUserModal .modal-content {
                width: 100%;
                max-height: calc(100vh - 24px);
                margin: 0;
            }

            #viewCourseModal {
                padding: 12px;
            }

            #viewCourseModal .modal-content {
                width: 100%;
                height: calc(100vh - 24px);
            }

            .course-view-modal-title {
                max-width: 58vw;
            }

            .profile-edit-header {
                padding: 16px 18px 14px;
            }

            .profile-edit-form {
                padding: 14px 18px 18px;
            }

            .profile-edit-headline {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-edit-subrow {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-header-actions {
                align-self: flex-end;
            }

            .profile-user-email {
                max-width: 100%;
            }

            .profile-section {
                padding: 12px;
            }

            .profile-edit-grid,
            .profile-location-grid {
                grid-template-columns: 1fr;
            }

            .modal-action-btn {
                width: 34px;
                height: 34px;
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

            .content-section [style*="min-width: 250px"],
            .content-section [style*="min-width: 300px"] {
                min-width: 0 !important;
            }
        }
    </style>
    <!-- PDF.js and docx-preview + html2canvas for client-side rendering -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.7.107/pdf.min.js" defer></script>
    <script>document.addEventListener('DOMContentLoaded',function(){ if(window['pdfjsLib']){ window['pdfjsLib'].GlobalWorkerOptions.workerSrc='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.7.107/pdf.worker.min.js'; } });</script>
    <script src="https://unpkg.com/docx-preview@0.3.4/dist/docx-preview.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
</head>
<body>
    <!-- Navbar -->
    <header class="header">
        <div class="header-left">
            <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div id="header-section-title" class="header-section-title">Access Control</div>
        </div>
        <div class="header-right">
            <div class="profile-menu">
                <div class="user-profile-header" onclick="toggleProfileMenu(event)" style="cursor: pointer; display: flex; align-items: center; gap: 10px; margin-right: 10px;">
                    <div style="width: 40px; height: 40px; background-color: #ffffff; color: #9ca3af; border: 1px solid #9ca3af; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; overflow: hidden;">
                        @if(Auth::user()->profile_picture)
                            <img id="header_profile_image" src="{{ Auth::user()->avatar_url }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
                            <span id="header_profile_initial" style="display: none;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @else
                            <img id="header_profile_image" src="" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <span id="header_profile_initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <i class="fas fa-chevron-down" style="font-size:.85rem;color:#666;margin-left:6px"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <div class="dropdown-meta">
                        <div class="dropdown-meta-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-meta-role">{{ Auth::user()->role }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('dashboard') }}?tab=profile-section">
                        <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard') }}?tab=help-support">
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
            <div class="header-title">
                <img id="sidebarLogo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item {{ !request()->hasAny(['search', 'roles', 'statuses', 'page']) && !request('tab') ? 'active' : '' }}" onclick="showContent('dashboard-home', this)">
                    <div class="menu-icon"><i class="fas fa-home"></i></div>
                    <span class="menu-text">Dashboard</span>
                </li>
                @if(Auth::user()->hasPermission('view_users'))
                <li class="menu-item {{ request()->hasAny(['search', 'roles', 'statuses', 'page']) || in_array(request('tab'), ['user-management', 'user-details-section']) ? 'active' : '' }}" onclick="showContent('user-management', this)">
                    <div class="menu-icon"><i class="fas fa-users"></i></div>
                    <span class="menu-text">User Management</span>
                </li>
                @endif
                @if(Auth::user()->hasPermission('view_courses'))
                <li class="menu-item {{ in_array(request('tab'), ['course-management', 'pending-courses', 'course-create', 'course-library']) ? 'active' : '' }}" onclick="showContent('course-management', this)">
                    <div class="menu-icon"><i class="fas fa-book"></i></div>
                    <span class="menu-text">Course Management</span>
                </li>
                @endif
                @if(Auth::user()->hasPermission('view_access_control'))
                    <li class="menu-item {{ request('tab') == 'access-management' ? 'active' : '' }}" onclick="showContent('access-management', this)">
                        <div class="menu-icon"><i class="fas fa-key"></i></div>
                        <span class="menu-text">Access Control</span>
                    </li>
                @endif
                @if(Auth::user()->hasPermission('view_certifications'))
                <li class="menu-item {{ request('tab') == 'certification-management' ? 'active' : '' }}" onclick="showContent('certification-management', this)">
                    <div class="menu-icon"><i class="fas fa-certificate"></i></div>
                    <span class="menu-text">Certifications</span>
                </li>
                @endif
                @if(Auth::check() && Auth::user()->role === 'super_admin')
                    <li class="menu-item {{ request('tab') == 'system-settings' ? 'active' : '' }}" onclick="showContent('system-settings', this)">
                        <div class="menu-icon"><i class="fas fa-cogs"></i></div>
                        <span class="menu-text">System Settings</span>
                    </li>
                @endif
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Home Section -->
            <section id="dashboard-home" class="content-section {{ !request()->hasAny(['search', 'roles', 'statuses', 'page']) && !request('tab') ? 'active' : '' }}">
                @php
                    $totalUsersSafe = max((int) ($userCount ?? 0), 1);
                    $activeUsersSafe = (int) ($activeUsersCount ?? 0);
                    $pendingUsersSafe = (int) ($pendingUsersTotal ?? 0);
                    $frozenUsersSafe = (int) ($frozenUsersCount ?? 0);
                    $trainersSafe = (int) ($trainersCount ?? 0);
                    $traineesSafe = (int) ($traineesCount ?? 0);
                    $opsSafe = (int) ($adminsCount ?? 0) + (int) ($registrarsCount ?? 0);
                    $approvalRate = (int) round(($activeUsersSafe / $totalUsersSafe) * 100);

                    $activeCoursesSafe = (int) ($courseCount ?? 0);
                    $pendingCoursesSafe = (int) ($pendingCoursesCount ?? 0);
                    $archivedCoursesSafe = (int) ($archivedCoursesCount ?? 0);
                    $certificationSafe = (int) ($certificationCount ?? 0);
                    $totalCoursePipeline = max($activeCoursesSafe + $pendingCoursesSafe + $archivedCoursesSafe, 1);
                    $pendingCourseShare = (int) round(($pendingCoursesSafe / $totalCoursePipeline) * 100);

                    $trainerShare = (int) round(($trainersSafe / $totalUsersSafe) * 100);
                    $traineeShare = (int) round(($traineesSafe / $totalUsersSafe) * 100);
                    $opsShare = (int) round(($opsSafe / $totalUsersSafe) * 100);
                @endphp

                <div class="lms-home">
                    <div class="lms-home-hero">
                        <div class="lms-home-headline">
                            <div>
                                <h1 class="welcome-title lms-welcome">Welcome, <strong>{{ Auth::user()->name }}</strong></h1>
                                <p class="lms-home-subtitle">
                                    Monitor learner onboarding, course readiness, and certification output in one view.
                                    Use this board to quickly spot bottlenecks and move training delivery forward.
                                </p>
                            </div>
                        </div>
                        <div class="admin-hero-stats-grid">
                        @if(Auth::user()->hasPermission('view_users'))
                        <div class="admin-hero-stat-card clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'user-management']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="admin-hero-stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="admin-hero-stat-info">
                                <span class="admin-hero-stat-value">{{ $userCount }}</span>
                                <span class="admin-hero-stat-label">Total Accounts</span>
                                <div class="admin-hero-stat-meta">Active: {{ $activeUsersSafe }} | Pending: {{ $pendingUsersSafe }} | Blocked: {{ $frozenUsersSafe }}</div>
                            </div>
                        </div>
                        @endif

                        @if(Auth::user()->hasPermission('view_courses'))
                        <div class="admin-hero-stat-card tone-green clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'course-management']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="admin-hero-stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="admin-hero-stat-info">
                                <span class="admin-hero-stat-value">{{ $courseCount }}</span>
                                <span class="admin-hero-stat-label">Active Courses</span>
                                <div class="admin-hero-stat-meta">Archived: {{ $archivedCoursesSafe }}</div>
                            </div>
                        </div>

                        <div class="admin-hero-stat-card tone-orange clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'pending-courses']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="admin-hero-stat-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="admin-hero-stat-info">
                                <span class="admin-hero-stat-value">{{ $pendingCoursesSafe }}</span>
                                <span class="admin-hero-stat-label">Pending Course Reviews</span>
                            </div>
                        </div>
                        @endif

                        @if(Auth::user()->hasPermission('view_certifications'))
                        <div class="admin-hero-stat-card tone-slate clickable"
                            role="button"
                            tabindex="0"
                            onclick="showContent('certification-management', document.querySelector('.menu-item[onclick*=\'certification-management\']))"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="admin-hero-stat-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="admin-hero-stat-info">
                                <span class="admin-hero-stat-value">{{ $certificationSafe }}</span>
                                <span class="admin-hero-stat-label">Certification Templates</span>
                                <div class="admin-hero-stat-meta">Ready for issuance</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>

                    <div class="insight-grid">

                        @php
                            $regionCounts = \App\Models\User::selectRaw('LOWER(TRIM(COALESCE(region,""))) as region, COUNT(*) as c')->groupBy('region')->pluck('c','region');
                            $provinceCounts = \App\Models\User::selectRaw('LOWER(TRIM(COALESCE(province,""))) as province, COUNT(*) as c')->groupBy('province')->pluck('c','province');
                            $rcMax = $regionCounts->max() ?? 0;
                            $pcMax = $provinceCounts->max() ?? 0;
                        @endphp
                        <div class="insight-panel" style="background:#fff; border:1px solid #e5e7eb; border-radius:20px; box-shadow:0 24px 48px rgba(2,6,23,.08); color:#0f172a;">
                            <div class="insight-panel-header">
                                <h2 id="ph-map-title">Users by Region</h2>
                                <span style="display:flex;align-items:center;gap:8px">
                                    <span>Choropleth</span>
                                    <select id="ph-map-mode" style="border:1px solid #e2e8f0;border-radius:999px;padding:6px 10px;background:#fff;color:#0b3b8f;font-weight:800">
                                        <option value="region" selected>By Region</option>
                                        <option value="province">By Province</option>
                                    </select>
                                </span>
                            </div>
                            <div id="ph-map-wrap" style="position:relative;background:linear-gradient(180deg,rgba(255,255,255,.10),rgba(255,255,255,.06));border:1px solid rgba(255,255,255,.10);border-radius:16px;padding:20px;box-shadow:inset 0 1px 0 rgba(255,255,255,.15);">
                                <div id="ph-map" style="width:100%;height:480px;overflow:hidden;background:#eaf2ff;border-radius:12px;position:relative;"></div>
                                
                                <div id="map-controls" style="position:absolute;top:30px;right:30px;display:flex;flex-direction:column;gap:8px;z-index:10;">
                                    <button type="button" id="btn-zoom-in" style="width:38px;height:38px;background:#ffffff;border:1px solid #cfe0ff;border-radius:10px;box-shadow:0 6px 14px rgba(2,6,23,.12);color:#0b3b8f;cursor:pointer;display:flex;align-items:center;justify-content:center" onmouseover="this.style.background='#f1f5fb';this.style.transform='scale(1.05)'" onmouseout="this.style.background='#ffffff';this.style.transform='scale(1)'"><i class="fas fa-plus"></i></button>
                                    <button type="button" id="btn-zoom-out" style="width:38px;height:38px;background:#ffffff;border:1px solid #cfe0ff;border-radius:10px;box-shadow:0 6px 14px rgba(2,6,23,.12);color:#0b3b8f;cursor:pointer;display:flex;align-items:center;justify-content:center" onmouseover="this.style.background='#f1f5fb';this.style.transform='scale(1.05)'" onmouseout="this.style.background='#ffffff';this.style.transform='scale(1)'"><i class="fas fa-minus"></i></button>
                                    <button type="button" id="btn-reset-zoom" style="width:38px;height:38px;background:#ffffff;border:1px solid #cfe0ff;border-radius:10px;box-shadow:0 6px 14px rgba(2,6,23,.12);color:#0b3b8f;cursor:pointer;display:flex;align-items:center;justify-content:center" title="Reset View" onmouseover="this.style.background='#f1f5fb';this.style.transform='scale(1.05)'" onmouseout="this.style.background='#ffffff';this.style.transform='scale(1)'"><i class="fas fa-expand"></i></button>
                                </div>

                                <div id="ph-map-legend" style="margin-top:20px;display:flex;align-items:center;justify-content:center;gap:24px;flex-wrap:wrap;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div style="width:14px;height:14px;border-radius:999px;background:#fde047;box-shadow:0 0 0 2px rgba(250,204,21,.4)"></div>
                                        <span style="font-size:0.9rem;color:#0b3b8f;font-weight:700;">Low (0â€“10)</span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div style="width:14px;height:14px;border-radius:999px;background:#fb923c;box-shadow:0 0 0 2px rgba(245,158,11,.4)"></div>
                                        <span style="font-size:0.9rem;color:#0b3b8f;font-weight:700;">Medium (11â€“50)</span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div style="width:14px;height:14px;border-radius:999px;background:#e11d48;box-shadow:0 0 0 2px rgba(239,68,68,.4)"></div>
                                        <span style="font-size:0.9rem;color:#0b3b8f;font-weight:700;">High (51+)</span>
                                    </div>
                                </div>
                                <div id="ph-map-total" style="margin-top:8px;text-align:center;color:#cbd5e1;font-size:.85rem;font-weight:700"></div>
                                
                            </div>
                            <div id="ph-map-tooltip" style="position:absolute;display:none;z-index:100;background:rgba(12,20,60,.8);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:12px;box-shadow:0 20px 40px rgba(2,6,23,.6);pointer-events:none;color:#e5e7eb;min-width:220px;"></div>
                            <div style="margin-top:10px;text-align:right;color:#94a3b8;font-size:.75rem">Map data © Contributors · Source: <a href="https://github.com/justinegealogo/philippines-region-province-citymuni-barangay" target="_blank" rel="noopener" style="color:#64748b;text-decoration:none;font-weight:500;">Philippines GeoJSON</a></div>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
                            <script>
                            (function(){
                              var countsInlineRegion = @json($regionCounts);
                              var countsInlineProvince = @json($provinceCounts);
                              var container = document.getElementById('ph-map');
                              if(!container){ return; }
                              
                              // Clear existing if any (for hot reload)
                              container.innerHTML = '';

                              var width = container.clientWidth || 800, height = container.clientHeight || 500;
                              
                              // Responsive SVG
                              var svg = d3.select(container).append('svg')
                                .attr('width', '100%')
                                .attr('height', '100%')
                                .attr('viewBox', `0 0 ${width} ${height}`)
                                .attr('preserveAspectRatio', 'xMidYMid meet');
                              
                              // Group for map content to allow zooming
                              var g = svg.append('g');

                              // Zoom behavior
                              var zoom = d3.zoom()
                                  .scaleExtent([1, 8])
                                  .on('zoom', function(event) {
                                      g.attr('transform', event.transform);
                                  });

                              svg.call(zoom);

                              // Zoom Controls
                              document.getElementById('btn-zoom-in').addEventListener('click', function() {
                                  svg.transition().duration(500).call(zoom.scaleBy, 1.3);
                              });
                              document.getElementById('btn-zoom-out').addEventListener('click', function() {
                                  svg.transition().duration(500).call(zoom.scaleBy, 1 / 1.3);
                              });
                              document.getElementById('btn-reset-zoom').addEventListener('click', function() {
                                  svg.transition().duration(750).call(zoom.transform, d3.zoomIdentity);
                              });

                              var tooltip = document.getElementById('ph-map-tooltip');
                              var urls = {
                                region: {
                                  // Use provinces geometry and color per region to avoid remote 404s
                                  geo: [
                                    '{{ asset('images/maps/ph-provinces.geojson') }}',
                                    'https://raw.githubusercontent.com/justinegealogo/philippines-region-province-citymuni-barangay/master/geojson/philippines-province.geojson',
                                    'https://raw.githubusercontent.com/faeldon/philippines-json-maps/master/2023/geojson/provdists.lowres.geojson'
                                  ],
                                  counts: '{{ route('stats.users.by-region') }}',
                                  gender: '{{ route('stats.users.gender-by-region') }}'
                                },
                                province: {
                                  geo: [
                                    '{{ asset('images/maps/ph-provinces.geojson') }}',
                                    'https://raw.githubusercontent.com/justinegealogo/philippines-region-province-citymuni-barangay/master/geojson/philippines-province.geojson',
                                    'https://raw.githubusercontent.com/faeldon/philippines-json-maps/master/2023/geojson/provdists.lowres.geojson'
                                  ],
                                  counts: '{{ route('stats.users.by-province') }}'
                                }
                              };
                              var regionAnalyticsUrl = '{{ route('stats.region.analytics') }}';
                              var modeSel = document.getElementById('ph-map-mode');
                              var mode = (modeSel && modeSel.value) || 'region';
                              
                              function normalizeRegion(s){
                                var t = (s || '').toLowerCase();
                                t = t.replace(/\(.*?\)/g, '');
                                t = t.replace(/\bregion\b/gi, '');
                                t = t.replace(/[^a-z\s-]/g, '');
                                t = t.replace(/\s+/g, ' ').trim();
                                if (t === 'ncr') t = 'national capital';
                                if (t === 'car') t = 'cordillera administrative';
                                return t;
                              }
                              function normalizeProvince(s){
                                return (s || '').toLowerCase().trim()
                                    .replace(/province of /g, '')
                                    .replace(/city of /g, '')
                                    .replace(/\./g, '')
                                    .trim();
                              }
                              function normalizeCounts(src, type){
                                var out = {};
                                for (var k in src) {
                                  if (!Object.prototype.hasOwnProperty.call(src, k)) continue;
                                  var nk = type==='region' ? normalizeRegion(k) : normalizeProvince(k);
                                  out[nk] = (out[nk] || 0) + (src[k] || 0);
                                }
                                return out;
                              }

                              function render(geo){
                                if(!geo || !geo.features){ return; }
                                var projection = d3.geoMercator();
                                var isProjected = false;
                                try {
                                    var c = geo.features[0].geometry.coordinates[0][0];
                                    if(Array.isArray(c[0])) c = c[0]; 
                                    if(Math.abs(c[0]) > 180 || Math.abs(c[1]) > 90) {
                                        isProjected = true;
                                    }
                                } catch(e){}

                                if(isProjected){
                                    projection = d3.geoIdentity().reflectY(true);
                                }

                                var path = d3.geoPath(projection);
                                projection.fitExtent([[20,20],[width-20,height-20]], geo);
                                
                                var max = d3.max(Object.values(window.__counts || {})) || 10;
                                
                                // Color Scale based on counts:
                                // 0 handled separately as gray; 1-10 Low, 11-50 Medium, 51+ High
                                var colorScale = d3.scaleThreshold()
                                    .domain([11, 51])
                                    .range(['#fde047', '#fb923c', '#e11d48']);

                                g.selectAll('path')
                                  .data(geo.features)
                                  .enter()
                                  .append('path')
                                  .attr('d', path)
                                  .attr('fill', function(d){
                                    var raw, n, v;
                                    if(mode==='region'){
                                      raw = d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '';
                                      n = normalizeRegion(raw);
                                    }else{
                                      raw = d.properties.PROVINCE || d.properties.NAME_1 || d.properties.name || '';
                                      n = normalizeProvince(raw);
                                    }
                                    v = (window.__counts || {})[n] || 0;
                                    return v === 0 ? '#f1f5f9' : colorScale(v);
                                  })
                                  .attr('stroke', function(d){
                                    if(mode==='region'){
                                      var raw = d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '';
                                      var n = normalizeRegion(raw);
                                      var v = (window.__counts || {})[n] || 0;
                                      return v>0 ? '#0B2C74' : '#93c5fd';
                                    }
                                    return '#cbd5e1';
                                  })
                                  .attr('stroke-width', function(d){
                                    if(mode==='region'){
                                      var raw = d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '';
                                      var n = normalizeRegion(raw);
                                      var v = (window.__counts || {})[n] || 0;
                                      return v>0 ? 1.2 : 0.8;
                                    }
                                    return 0.8;
                                  })
                                  .attr('vector-effect', 'non-scaling-stroke') // Keep stroke width constant on zoom
                                  .style('cursor', 'pointer')
                                  .style('transition', 'fill 0.2s ease, stroke 0.2s ease, filter 0.2s ease')
                                  .style('filter', function(d){
                                    if(mode==='region'){
                                      var raw = d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '';
                                      var n = normalizeRegion(raw);
                                      var v = (window.__counts || {})[n] || 0;
                                      return v>0 ? 'drop-shadow(0 6px 10px rgba(11,44,116,.18))' : 'none';
                                    }
                                    return 'none';
                                  })
                                  .on('mouseenter', function(event, d){
                                    d3.select(this)
                                        .style('filter','drop-shadow(0 8px 16px rgba(15,23,42,.25))')
                                        .raise();
                                    
                                    var label, v;
                                    if(mode==='region'){
                                      label = (d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '').trim();
                                      v = (window.__counts || {})[normalizeRegion(label)] || 0;
                                    }else{
                                      label = (d.properties.PROVINCE || d.properties.NAME_1 || d.properties.name || '').trim();
                                      v = (window.__counts || {})[normalizeProvince(label)] || 0;
                                    }
                                    
                                    if(tooltip){
                                      tooltip.style.display='block';
                                      var gcounts = {};
                                      if(mode==='region'){ gcounts = (window.__gender || {})[normalizeRegion(label)] || {}; }
                                      var m = gcounts.male || 0;
                                      var f = gcounts.female || 0;
                                      var o = (typeof gcounts.other === 'number') ? gcounts.other : Math.max(0, v - (m + f));
                                      var a = (window.__analytics || {})[normalizeRegion(label)] || {};
                                      var users = a.users || v;
                                      var coursesCompleted = a.courses_completed || 0;
                                      var certsIssued = a.certs_issued || 0;
                                      tooltip.innerHTML = ''
                                        + '<div style="font-weight:800;font-size:1rem;margin-bottom:2px;color:#e5e7eb">'+label+'</div>'
                                        + '<div style="display:grid;grid-template-columns:auto 1fr;gap:6px 8px;font-size:0.88rem;color:#cbd5e1;margin-top:6px">'
                                        +   '<span style="width:8px;height:8px;border-radius:50%;background:#3b82f6;margin-top:6px"></span><span><strong>Users</strong>: '+users+'</span>'
                                        +   '<span style="width:8px;height:8px;border-radius:50%;background:#22c55e;margin-top:6px"></span><span><strong>Courses Completed</strong>: '+coursesCompleted+'</span>'
                                        +   '<span style="width:8px;height:8px;border-radius:50%;background:#eab308;margin-top:6px"></span><span><strong>Certificates Issued</strong>: '+certsIssued+'</span>'
                                        + '</div>'
                                        + '<div style="display:flex;align-items:center;gap:12px;font-size:0.85rem;margin-top:8px">'
                                        +   '<span style="display:inline-flex;align-items:center;gap:6px;color:#93c5fd"><i class="fas fa-mars"></i> '+m+'</span>'
                                        +   '<span style="display:inline-flex;align-items:center;gap:6px;color:#fecaca"><i class="fas fa-venus"></i> '+f+'</span>'
                                        +   '<span style="display:inline-flex;align-items:center;gap:6px;color:#cbd5e1"><i class="fas fa-circle-notch"></i> '+o+'</span>'
                                        + '</div>';
                                      moveTooltip(event);
                                    }
                                  })
                                  .on('mousemove', function(event){
                                    moveTooltip(event);
                                  })
                                  .on('mouseleave', function(){
                                    d3.select(this).style('filter', function(){
                                      if(mode==='region'){
                                        var d = d3.select(this).datum();
                                        var raw = d.properties.REGION || d.properties.REGION_NAME || d.properties.region || d.properties.REGION_NAM || d.properties.NAME_1 || d.properties.name || '';
                                        var n = normalizeRegion(raw);
                                        var v = (window.__counts || {})[n] || 0;
                                        return v>0 ? 'drop-shadow(0 6px 10px rgba(11,44,116,.18))' : 'none';
                                      }
                                      return 'none';
                                    });
                                    if(tooltip){ tooltip.style.display='none'; }
                                  })
                                  .on('click', function(event, d){
                                      // Optional: Zoom into province on click
                                      var bounds = path.bounds(d);
                                      var dx = bounds[1][0] - bounds[0][0],
                                          dy = bounds[1][1] - bounds[0][1],
                                          x = (bounds[0][0] + bounds[1][0]) / 2,
                                          y = (bounds[0][1] + bounds[1][1]) / 2,
                                          scale = Math.max(1, Math.min(8, 0.9 / Math.max(dx / width, dy / height))),
                                          translate = [width / 2 - scale * x, height / 2 - scale * y];

                                      svg.transition().duration(750).call(
                                          zoom.transform,
                                          d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale)
                                      );
                                  });
                              }

                              function moveTooltip(event) {
                                  if(!tooltip) return;
                                  // Use page coordinates for absolute positioning
                                  var left = event.pageX + 15;
                                  var top = event.pageY + 15;
                                  
                                  // Boundary checks
                                  if (left + tooltip.offsetWidth > window.innerWidth) {
                                      left = event.pageX - tooltip.offsetWidth - 10;
                                  }
                                  if (top + tooltip.offsetHeight > window.innerHeight) {
                                      top = event.pageY - tooltip.offsetHeight - 10;
                                  }

                                  tooltip.style.left = left + 'px';
                                  tooltip.style.top = top + 'px';
                              }

                              function load(list){
                                if(!list || !list.length){
                                  container.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#64748b;background:#f8fafc;border-radius:12px;flex-direction:column;gap:10px;"><i class="fas fa-map-marked-alt" style="font-size:2rem;opacity:0.5"></i><span>Map data not available.</span></div>';
                                  return;
                                }
                                var u = list.shift();
                                d3.json(u).then(function(geo){ render(geo); }).catch(function(){ load(list); });
                              }
                              function loadCountsAndMap(){
                                try{
                                  var countsUrl = urls[mode].counts;
                                  var genderUrl = urls[mode].gender;
                                  var inline = mode==='region' ? countsInlineRegion : countsInlineProvince;
                                  window.__counts = normalizeCounts(inline || {}, mode);
                                  var p1 = fetch(countsUrl, {headers:{'X-Requested-With':'XMLHttpRequest'}})
                                    .then(function(res){ return res.ok ? res.json() : null; })
                                    .then(function(data){ 
                                      if(data && data.counts){ window.__counts = normalizeCounts(data.counts, mode); } 
                                      var total = Object.values(window.__counts || {}).reduce(function(a,b){ return a+(b||0); }, 0);
                                      var totEl = document.getElementById('ph-map-total'); if(totEl){ totEl.textContent = 'Total users: '+total; }
                                    });
                                  var p2 = (genderUrl && mode==='region')
                                    ? fetch(genderUrl, {headers:{'X-Requested-With':'XMLHttpRequest'}})
                                        .then(function(res){ return res.ok ? res.json() : null; })
                                        .then(function(data){ 
                                          var graw = (data && data.gender_counts) ? data.gender_counts : {}; 
                                          var gn = {}; 
                                          for (var k in graw) { 
                                            if (!Object.prototype.hasOwnProperty.call(graw, k)) continue; 
                                            var nk = normalizeRegion(k); 
                                            gn[nk] = graw[k]; 
                                          } 
                                          window.__gender = gn; 
                                        })
                                    : Promise.resolve();
                                  var p3 = fetch(regionAnalyticsUrl, {headers:{'X-Requested-With':'XMLHttpRequest'}})
                                    .then(function(res){ return res.ok ? res.json() : null; })
                                    .then(function(data){ window.__analytics = (data && data.analytics) ? data.analytics : {}; });
                                  Promise.all([p1,p2,p3]).then(function(){ load(urls[mode].geo.slice()); })
                                    .catch(function(){ load(urls[mode].geo.slice()); });
                                }catch(e){
                                  window.__counts = {};
                                  var total = 0; var totEl = document.getElementById('ph-map-total'); if(totEl){ totEl.textContent = 'Total users: '+total; }
                                  load(urls[mode].geo.slice());
                                }
                              }
                              loadCountsAndMap();
                              if(modeSel){
                                modeSel.addEventListener('change', function(){
                                  mode = this.value || 'region';
                                  var t = document.getElementById('ph-map-title');
                                  if(t){ t.textContent = mode==='region' ? 'Users by Region' : 'Users by Province'; }
                                  g.selectAll('*').remove();
                                  svg.transition().duration(300).call(zoom.transform, d3.zoomIdentity);
                                  loadCountsAndMap();
                                });
                              }
                              
                              // Handle window resize
                              var resizeTimer;
                              window.addEventListener('resize', function(){
                                clearTimeout(resizeTimer);
                                resizeTimer = setTimeout(function() {
                                    width = container.clientWidth;
                                    height = container.clientHeight;
                                    svg.attr('viewBox', `0 0 ${width} ${height}`);
                                    // Re-render or re-center logic if needed
                                }, 250);
                              });
                              
                            })();
                            </script>
                        </div>
                        <div class="insight-panel">
                            <div class="insight-panel-header">
                                <h2>Accounts & Courses Overview</h2>
                                <span>Totals</span>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start">
                                <div>
                                    <div id="donut-accounts" style="width:220px;height:220px;margin:0 auto"></div>
                                    <div style="margin-top:10px;text-align:center">
                                        <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Total Accounts</div>
                                        <div id="total-accounts" style="font-weight:800;color:#002C76;font-size:1.5rem;line-height:1">{{ $userCount }}</div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                        <div style="width:12px;height:12px;border-radius:50%;background:#002C76"></div><div style="color:#002C76;font-weight:800">Active <span id="acc-legend-active" style="color:#6b7280;margin-left:6px"></span></div>
                                        <div style="width:12px;height:12px;border-radius:50%;background:#FFD700;border:1px solid #eab308"></div><div style="color:#002C76;font-weight:800">Pending <span id="acc-legend-pending" style="color:#6b7280;margin-left:6px"></span></div>
                                        <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#002C76;font-weight:800">Blocked <span id="acc-legend-blocked" style="color:#6b7280;margin-left:6px"></span></div>
                                    </div>
                                </div>
                                <div>
                                    <div id="donut-courses" style="width:220px;height:220px;margin:0 auto"></div>
                                    <div style="margin-top:10px;text-align:center">
                                        <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Total Courses</div>
                                        <div id="total-courses" style="font-weight:800;color:#002C76;font-size:1.5rem;line-height:1">{{ $courseCount }}</div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                        <div style="width:12px;height:12px;border-radius:50%;background:#002C76"></div><div style="color:#002C76;font-weight:800">Published <span id="course-legend-published" style="color:#6b7280;margin-left:6px"></span></div>
                                        <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#002C76;font-weight:800">Unpublished <span id="course-legend-unpublished" style="color:#6b7280;margin-left:6px"></span></div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                (function(){
                                  function renderArcDonut(elId, parts, colors){
                                    var el=document.getElementById(elId);
                                    if(!el){return;}
                                    var width=220, height=220, r=80, ir=48;
                                    var total=parts.reduce(function(a,b){return a+b;},0);
                                    if(total===0){return;} // don't render if no data
                                    
                                    var svg=d3.select('#'+elId).append('svg').attr('width',width).attr('height',height);
                                    var g=svg.append('g').attr('transform','translate('+width/2+','+height/2+')');
                                    
                                    // Filter out zero parts to avoid padding/rendering issues with 0-angle segments
                                    var validParts = [];
                                    var validColors = [];
                                    parts.forEach(function(p, i){
                                        if(p > 0){
                                            validParts.push(p);
                                            validColors.push(colors[i]);
                                        }
                                    });
                                    
                                    // Use padAngle on pie layout, but only if there's more than one part
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
                                      .style('filter','drop-shadow(0 6px 10px rgba(17,24,39,.12))')
                                      .on('mouseover', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1.03)'); })
                                      .on('mouseout', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1)'); });
                                    
                                    paths.transition().duration(900).ease(d3.easeCubicOut).attrTween('d', function(d){
                                      var i=d3.interpolate({startAngle:d.startAngle, endAngle:d.startAngle}, d);
                                      return function(t){ return arc(i(t)); };
                                    });
                                    
                                    // percentage labels on arcs
                                    g.selectAll('text').data(data).enter().append('text')
                                      .attr('transform', function(d){ return 'translate('+arc.centroid(d)+')'; })
                                      .attr('dy','.35em')
                                      .attr('text-anchor','middle')
                                      .attr('font-size','12px')
                                      .attr('fill', function(d,i){ return validColors[i] === '#FFD700' ? '#0f172a' : '#ffffff'; })
                                      .text(function(d){ var p=total? Math.round((d.value/total)*100):0; return p>0? (p+'%'):''; });
                                  }
                                  // Accounts
                                  var aActive={{ $activeUsersCount }};
                                  var aPending={{ $pendingUsersTotal }};
                                  var aBlocked={{ $frozenUsersCount }};
                                  var aTotal={{ $userCount }};
                                  renderArcDonut('donut-accounts', [aActive,aPending,aBlocked], ['#002C76','#FFD700','#B10606']);
                                  function pct(n,t){ return t>0? Math.round((n/t)*100):0; }
                                  document.getElementById('acc-legend-active').innerText = aActive+' · '+pct(aActive,aTotal)+'%';
                                  document.getElementById('acc-legend-pending').innerText = aPending+' · '+pct(aPending,aTotal)+'%';
                                  document.getElementById('acc-legend-blocked').innerText = aBlocked+' · '+pct(aBlocked,aTotal)+'%';
                                  // Courses
                                  var cPublished={{ $publishedCoursesCount }};
                                  var cUnpublished={{ $unpublishedCoursesCount }};
                                  var cTotal=cPublished+cUnpublished;
                                  document.getElementById('total-courses').innerText = cTotal;
                                  renderArcDonut('donut-courses', [cPublished,cUnpublished], ['#002C76','#B10606']);
                                  document.getElementById('course-legend-published').innerText = cPublished+' · '+pct(cPublished,cTotal)+'%';
                                  document.getElementById('course-legend-unpublished').innerText = cUnpublished+' · '+pct(cUnpublished,cTotal)+'%';
                                })();
                            </script>
                        </div>
                    </div>

                    <div class="insight-grid insight-grid-alt">
                        <div class="insight-panel">
                            <div class="insight-panel-header">
                                <h2>Recently Added Courses</h2>
                                <span>Latest 5</span>
                            </div>

                            @if(isset($recentCourses) && $recentCourses->count())
                                <ul class="home-recent-list">
                                    @foreach($recentCourses as $recentCourse)
                                        <li class="home-recent-item">
                                            <p class="home-recent-title">{{ $recentCourse->name }}</p>
                                            <div class="home-recent-meta">
                                                {{ $recentCourse->subject_area ?? 'Uncategorized' }} | {{ $recentCourse->created_at->diffForHumans() }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="home-recent-item">
                                    <p class="home-recent-title">No recent course activity yet.</p>
                                    <div class="home-recent-meta">Create a new course to start populating this feed.</div>
                                </div>
                            @endif
                        </div>

                        <div class="insight-panel">
                            <div class="insight-panel-header">
                                <h2>Operational Focus</h2>
                                <span>Immediate priorities</span>
                            </div>

                            <ul class="focus-list">
                                <li role="button" tabindex="0" onclick="focusPendingUsers()" onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); focusPendingUsers(); }" style="cursor:pointer">
                                    <span>Pending user approvals</span>
                                    <strong>{{ $pendingUsersSafe }}</strong>
                                </li>
                                <li role="button" tabindex="0" onclick="focusBlockedUsers()" onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); focusBlockedUsers(); }" style="cursor:pointer">
                                    <span>Blocked accounts</span>
                                    <strong>{{ $frozenUsersSafe }}</strong>
                                </li>
                                <li role="button" tabindex="0" onclick="openPendingCourses()" onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); openPendingCourses(); }" style="cursor:pointer">
                                    <span>Course reviews waiting</span>
                                    <strong>{{ $pendingCoursesSafe }}</strong>
                                </li>
                            </ul>

                            
                        </div>
                    </div>
                </div>
            </section>

            <!-- Roles Management Section -->
            <section id="roles-management" class="content-section {{ request('tab') == 'roles-management' ? 'active' : '' }}">
                @php $canManageRoles = auth()->check() && auth()->user()->role === 'super_admin'; @endphp
                <div class="insight-panel">
                    <style>
                        .roles-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:24px;align-items:start}
                        .roles-card,.roles-form-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:16px;box-shadow:0 10px 24px rgba(15,23,42,.06)}
                        .roles-card-title{font-weight:800;color:#0B2C74;margin:0 0 12px}
                        .roles-table{width:100%;border-collapse:separate;border-spacing:0 6px}
                        .roles-table thead th{font-size:.85rem;color:#1f2937;text-align:left;padding:8px 10px;background:#f8fafc;border-top:1px solid #eef2f7;border-bottom:1px solid #eef2f7}
                        .roles-table thead th:first-child{border-radius:8px 0 0 8px}
                        .roles-table thead th:last-child{border-radius:0 8px 8px 0}
                        .roles-table tbody tr{background:#fff }
                        .roles-table tbody td{padding:10px 20px;border-top:1px solid #eef2f7;border-bottom:1px solid #eef2f7}
                        .roles-table tbody td:first-child{border-left:1px solid #eef2f7;border-radius:8px 0 0 8px}
                        .roles-table tbody td:last-child{border-right:1px solid #eef2f7;border-radius:0 8px 8px 0}
                        .roles-table .input-pro{height:14px;width:100%}
                        .role-actions{display:flex;gap:12px;flex-wrap:nowrap}
                        .btn-role{padding:6px 12px;font-size:.78rem;border-radius:8px}
                        .btn-role.btn-primary{background:#0B2C74;border-color:#0B2C74}
                        .btn-role.btn-danger{background:#e11d48;border-color:#e11d48}
                        .roles-form-card .form-label{display:block;margin:0 0 6px;color:#334155;font-weight:700}
                        .roles-form-card .input-pro{height:28px}
                        .roles-form-card .panel-actions{display:flex;justify-content:flex-end}
                        @media (max-width: 1100px){
                            .roles-grid{grid-template-columns:1fr}
                        }
                    </style>
                    <div class="insight-panel-header">
                        <!-- <h2 class="section-title">Roles Management</h2> -->
                        <span class="muted">Create and edit roles stored in the database</span>
                    </div>
                    @if(session('success_roles'))
                        <div style="background:#e6fffa;color:#065f46;padding:12px;border-radius:10px;margin-bottom:12px">
                            {{ session('success_roles') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div style="background:#fff7ed;color:#9a3412;padding:12px;border-radius:10px;margin-bottom:12px">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if(!$canManageRoles)
                        <div style="background:#fee2e2;color:#7f1d1d;padding:12px;border-radius:10px">You are not authorized to manage roles.</div>
                    @else
                        <div class="roles-grid">
                            <div class="roles-card">
                                <!-- <h3 class="roles-card-title">Roles Management</h3> -->
                                <div style="display:flex;justify-content:flex-start;align-items:center;margin-bottom:10px;gap:10px">
                                    <input id="rolesSearchInput" type="text" placeholder="Search roles..." class="input-pro" style="width:260px">
                                </div>
                                <table class="roles-table">
                                    <thead>
                                        <tr>
                                            <th style="width:40%">Name</th>
                                            <th style="width:35%">Display Name</th>
                                            <th style="width:25%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($roles ?? []) as $role)
                                            @php $formId = 'roleForm-'.$role->id; @endphp
                                            <tr>
                                                <td>
                                                    <input class="input-pro" type="text" name="name" value="{{ $role->name }}" disabled form="{{ $formId }}">
                                                </td>
                                                <td>
                                                    <input class="input-pro" type="text" name="display_name" value="{{ $role->display_name }}" disabled form="{{ $formId }}">
                                                </td>
                                                <td>
                                                    <div class="role-actions">
                                                        <form id="{{ $formId }}" method="POST" action="{{ route('admin.roles.update', $role) }}" style="display:inline-flex;gap:8px;align-items:center">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button" class="btn btn-primary btn-role role-edit-btn" data-mode="view" data-form="{{ $formId }}" data-row="{{ $role->id }}"><i class="fas fa-pen"></i>&nbsp;Edit</button>
                                                            <button type="submit" class="btn btn-primary btn-role role-save-btn" data-form="{{ $formId }}" data-row="{{ $role->id }}" style="display:none"><i class="fas fa-save"></i>&nbsp;Save</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline-flex">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-role" onclick="return confirm('Delete this role?')"><i class="fas fa-trash"></i>&nbsp;Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="card-muted" style="padding:12px;text-align:center">No roles found.</td>
                                            </tr>
                                        @endforelse
                                        <tr id="rolesNoMatchRow" style="display:none">
                                            <td colspan="3" class="card-muted" style="padding:12px;text-align:center">No matching roles.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="roles-form-card">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;color:#0B2C74;font-weight:800">Add Role</div>
                                <form method="POST" action="{{ route('admin.roles.store') }}" style="display:grid;gap:14px">
                                    @csrf
                                    <label class="form-label">Name</label>
                                    <input class="input-pro" type="text" name="name" placeholder="e.g. super_admin">
                                    <label class="form-label">Display Name</label>
                                    <input class="input-pro" type="text" name="display_name" placeholder="e.g. Super Admin">
                                    <div class="panel-actions">
                                        <button type="submit" class="btn btn-primary">Create Role</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
            <script>
            (function(){
                function getInputsByFormId(formId){
                    return document.querySelectorAll('input[form="'+formId+'"][name="name"], input[form="'+formId+'"][name="display_name"]');
                }
                document.querySelectorAll('.role-edit-btn').forEach(function(btn){
                    btn.addEventListener('click', function(){
                        var formId = this.getAttribute('data-form');
                        var saveBtn = this.parentElement.querySelector('.role-save-btn[data-form="'+formId+'"]');
                        getInputsByFormId(formId).forEach(function(i){ i.disabled = false; });
                        this.style.display = 'none';
                        if(saveBtn){ saveBtn.style.display = ''; }
                    });
                });
                var searchInput = document.getElementById('rolesSearchInput');
                if(searchInput){
                    searchInput.addEventListener('input', function(){
                        var q = (this.value || '').toLowerCase().trim();
                        var rows = document.querySelectorAll('.roles-table tbody tr');
                        var visible = 0;
                        rows.forEach(function(r){
                            if(r.id === 'rolesNoMatchRow') return;
                            var tds = r.querySelectorAll('td');
                            if(tds.length < 2) return;
                            var name = (tds[0].querySelector('input')?.value || tds[0].textContent || '').toLowerCase();
                            var disp = (tds[1].querySelector('input')?.value || tds[1].textContent || '').toLowerCase();
                            var show = !q || name.includes(q) || disp.includes(q);
                            r.style.display = show ? '' : 'none';
                            if(show) visible++;
                        });
                        var noRow = document.getElementById('rolesNoMatchRow');
                        if(noRow){ noRow.style.display = visible === 0 ? '' : 'none'; }
                    });
                }
            })();
            </script>

            @if(Auth::check() && Auth::user()->role === 'super_admin')
            <section id="system-settings" class="content-section {{ request('tab') == 'system-settings' ? 'active' : '' }}">
                <style>
                    .settings-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
                    .setting-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 10px 24px rgba(15,23,42,.08);padding:18px;cursor:pointer;transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease}
                    .setting-card:hover{transform:translateY(-2px);box-shadow:0 16px 32px rgba(15,23,42,.12);border-color:#cfe0ff}
                    .setting-head{display:flex;align-items:center;gap:12px;margin-bottom:8px}
                    .setting-icon{width:44px;height:44px;border-radius:12px;background:#eef2ff;color:#0b3b8f;display:flex;align-items:center;justify-content:center}
                    .setting-title{font-weight:800;color:#0b3b8f}
                    .setting-sub{color:#64748b;font-size:.9rem}
                    .settings-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
                    .btn-pill{display:inline-flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:999px;padding:8px 12px;background:#fff;color:#111827;font-weight:700;cursor:pointer}
                    .btn-blue{background:#0f3b8f;color:#fff;border-color:#0f3b8f}
                </style>
                <div id="settingsHome">
                    <div class="settings-bar">
                        <h2 style="margin:0;color:#002C76">System Settings</h2>
                    </div>
                    <div class="settings-grid">
                        <div class="setting-card" onclick="openSetting('location')">
                            <div class="setting-head">
                                <div class="setting-icon"><i class="fas fa-map-marked-alt"></i></div>
                                <div>
                                    <div class="setting-title">Location Master Data</div>
                                    <div class="setting-sub">PSGC 4Q 2025 Publication Datafile</div>
                                </div>
                            </div>
                            <div class="setting-sub">Import regions and provinces to keep address data authoritative.</div>
                        </div>
                        <div class="setting-card" onclick="openSetting('backup')">
                            <div class="setting-head">
                                <div class="setting-icon"><i class="fas fa-database"></i></div>
                                <div>
                                    <div class="setting-title">System Backup & Restore</div>
                                    <div class="setting-sub">Create, download, and restore backups</div>
                                </div>
                            </div>
                            <div class="setting-sub">Safeguard your data with on-demand backups and secure restore.</div>
                        </div>
                        @if(auth()->user()->role === 'super_admin')
                        <div class="setting-card" onclick="openSetting('academic-year')">
                            <div class="setting-head">
                                <div class="setting-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div>
                                    <div class="setting-title">Academic Year Management</div>
                                    <div class="setting-sub">Set and manage the active academic year for course creation.</div>
                                </div>
                            </div>
                            <div class="setting-sub">Control the academic years available in the system.</div>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="settingsLocation" style="display:none">
                    <style>
                        .import-wrap{display:grid;grid-template-columns:1.6fr .9fr;gap:18px}
                        .import-card{background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 12px 28px rgba(2,6,23,.08);overflow:hidden}
                        .import-hero{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;background:linear-gradient(135deg,#002C76 0%,#0b57d0 55%,#1e88e5 100%);color:#fff}
                        .hero-left{display:flex;align-items:center;gap:12px}
                        .hero-icon{width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center}
                        .hero-title{font-weight:800;letter-spacing:-.01em}
                        .hero-sub{opacity:.9;font-size:.9rem}
                        .import-body{padding:18px}
                        .drop-zone{border:2px dashed #cfe0ff;border-radius:14px;background:#f8fbff;padding:18px;display:flex;align-items:center;justify-content:center;min-height:140px;cursor:pointer;transition:border-color .18s ease, background .18s ease}
                        .drop-zone:hover{border-color:#90b4f8;background:#f0f6ff}
                        .dz-meta{margin-top:10px;display:flex;align-items:center;justify-content:space-between}
                        .dz-file{color:#0b3b8f;font-weight:700}
                        .progress{height:10px;border-radius:999px;background:#e5e7eb;overflow:hidden;margin-top:12px}
                        .progress > div{height:100%;width:0;background:#0f3b8f;transition:width .3s ease}
                        .chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
                        .chip{display:inline-flex;align-items:center;gap:6px;background:#eef2ff;color:#0f3b8f;border:1px solid #dbeafe;border-radius:999px;padding:6px 10px;font-weight:700}
                        .import-side{background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 12px 28px rgba(2,6,23,.08);padding:16px}
                        .side-head{display:flex;align-items:center;gap:10px;margin-bottom:8px;font-weight:800;color:#0b3b8f}
                        .side-list{list-style:none;margin:0;padding:0;display:grid;gap:8px;color:#64748b}
                        .cta-row{display:flex;align-items:center;gap:8px;margin-top:12px}
                        .btn-wide{min-width:160px}
                    </style>
                    <div class="import-wrap">
                        <div class="import-card">
                            <div class="import-hero">
                                <div class="hero-left">
                                    <div class="hero-icon"><i class="fas fa-map-marked-alt"></i></div>
                                    <div>
                                        <div class="hero-title">PSGC Location Master Data</div>
                                        <div class="hero-sub">Import regions and provinces</div>
                                    </div>
                                </div>
                                <button class="btn-pill" onclick="backSettingsHome()"><i class="fas fa-arrow-left"></i> Back</button>
                            </div>
                            <div class="import-body">
                                <div id="psgcDrop" class="drop-zone">
                                    <div style="text-align:center">
                                        <div style="font-weight:800;color:#0b3b8f">Drop file here or click to select</div>
                                        <div style="color:#64748b;margin-top:4px">Accepted: .csv</div>
                                    </div>
                                </div>
                                <form id="psgcImportForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.location.import') }}" style="margin-top:12px">
                                    @csrf
                                    <input id="psgcFile" type="file" name="psgc_file" accept=".csv,.xlsx" style="display:none">
                                    <div class="dz-meta">
                                        <div id="psgcFileName" class="dz-file">No file selected</div>
                                        <div class="cta-row">
                                            <div class="import-mode-wrap" style="display:flex;align-items:center;gap:8px;margin-right:auto">
                                                <label for="psgcMode" class="form-label" style="margin:0">Import Mode</label>
                                                <select id="psgcMode" name="mode" class="input-pro" style="max-width:220px">
                                                    <option value="insert_only">Insert Only</option>
                                                    <option value="insert_update" selected>Insert + Update</option>
                                                    <option value="replace_all">Replace All</option>
                                                </select>
                                            </div>
                                            <button id="psgcImportBtn" type="submit" class="btn btn-blue" disabled>Import</button>
                                            <a href="{{ url('/admin/system-settings/location/export') }}" class="btn" style="display:inline-flex;align-items:center;gap:8px"><i class="fas fa-download"></i> Export</a>
                                            <span id="psgcStatus" style="color:#64748b"></span>
                                        </div>
                                    </div>
                                    <div class="progress"><div id="psgcProg"></div></div>
                                </form>
                                <div class="chips" id="psgcResult" style="display:none"></div>
                            </div>
                        </div>
                        <div class="import-side">
                            <div class="side-head"><i class="fas fa-info-circle"></i> File Requirements</div>
                            <ul class="side-list">
                                <li>Headers: region, province, city/munacipility and barangay</li>
                                <li>UTF-8 CSV, comma-separated</li>
                                <li>Large files may take time to process</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="settingsBackup" style="display:none">
                    <div class="import-wrap">
                        <div class="import-card">
                            <div class="import-hero">
                                <div class="hero-left">
                                    <div class="hero-icon"><i class="fas fa-server"></i></div>
                                    <div>
                                        <div class="hero-title">System Backup & Restore</div>
                                        <div class="hero-sub">Create backups, download archives, and restore when needed</div>
                                    </div>
                                </div>
                                <button class="btn-pill" onclick="backSettingsHome()"><i class="fas fa-arrow-left"></i> Back</button>
                            </div>
                            <div class="import-body">
                                <div class="cta-row" style="justify-content:flex-end">
                                    <form method="POST" action="{{ url('/admin/system-settings/backup/create') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-blue" style="display:inline-flex;align-items:center;gap:8px"><i class="fas fa-file-archive"></i> Create Backup</button>
                                    </form>
                                </div>
                                <div style="margin-top:12px">
                                    <table class="backup-table" style="width:100%;border-collapse:separate;border-spacing:0">
                                        <thead>
                                            <tr>
                                                <th>Backup File</th>
                                                <th>Date Created</th>
                                                <th>File Size</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $backupDir = storage_path('app/backups');
                                                $backupFiles = [];
                                                if (is_dir($backupDir)) {
                                                    foreach (scandir($backupDir) as $f) {
                                                        if ($f === '.' || $f === '..') continue;
                                                        $p = $backupDir.DIRECTORY_SEPARATOR.$f;
                                                        if (is_file($p)) {
                                                            $backupFiles[] = ['name'=>$f,'mtime'=>filemtime($p),'size'=>filesize($p)];
                                                        }
                                                    }
                                                    usort($backupFiles, function($a,$b){ return $b['mtime'] <=> $a['mtime']; });
                                                }
                                            @endphp
                                            @forelse($backupFiles as $bk)
                                                <tr>
                                                    <td>{{ $bk['name'] }}</td>
                                                    <td>{{ \Carbon\Carbon::createFromTimestamp($bk['mtime'])->setTimezone(config('app.timezone'))->format('M d, Y h:ia') }}</td>
                                                    <td>{{ number_format($bk['size']/1024/1024, 2) }} MB</td>
                                                    <td>
                                                        <div class="backup-actions" style="display:flex;gap:8px">
                                                            <a class="btn" href="{{ url('/admin/system-settings/backup/download/'.$bk['name']) }}"><i class="fas fa-download"></i> Download</a>
                                                            <form method="POST" action="{{ url('/admin/system-settings/backup/delete/'.$bk['name']) }}" onsubmit="return confirm('Delete this backup?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn danger"><i class="fas fa-trash"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" style="color:#64748b; text-align:center; padding:30px 0;">No backups found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div style="margin-top:16px">
                                    <form method="POST" action="{{ url('/admin/system-settings/backup/restore') }}" enctype="multipart/form-data" onsubmit="return confirm('Restoring will replace the current database. Continue?')">
                                        @csrf
                                        <div style="display:flex;align-items:center;gap:10px">
                                            <input type="file" name="backup_file" accept=".zip,.sql" required>
                                            <input type="hidden" name="confirm" value="yes">
                                            <button type="submit" class="btn" style="display:inline-flex;align-items:center;gap:8px"><i class="fas fa-upload"></i> Restore Backup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="import-side">
                            <div class="side-head"><i class="fas fa-info-circle"></i> Backup Notes</div>
                            <ul class="side-list">
                                <li>Backups are stored under storage/app/backups.</li>
                                <li>Format: .zip containing CSV dumps per database table.</li>
                                <li>Restore only accepts .zip archives created by this system.</li>
                                <li>Restoring replaces current data. Confirm before proceeding.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="settingsAcademicYear" style="display:none">
                    <div class="import-wrap">
                        <div class="import-card">
                            <div class="import-hero">
                                <div class="hero-left">
                                    <div class="hero-icon"><i class="fas fa-calendar-alt"></i></div>
                                    <div>
                                        <div class="hero-title">Academic Year Management</div>
                                        <div class="hero-sub">Create and set the active academic year</div>
                                    </div>
                                </div>
                                <button class="btn-pill" onclick="backSettingsHome()"><i class="fas fa-arrow-left"></i> Back</button>
                            </div>
                            <div class="import-body">
                                <div class="cta-row" style="justify-content:flex-end">
                                    <button onclick="showAddAcademicYearForm()" class="btn btn-blue"><i class="fas fa-plus"></i> New Academic Year</button>
                                </div>
                                
                                <div id="addAcademicYearForm" style="display:none; margin-top:16px; padding:16px; border:1px solid #e5e7eb; border-radius:12px; background:#f8fafc;">
                                    <h3 style="margin-top:0; color:#0b3b8f">Add New Academic Year</h3>
                                    <form id="academicYearStoreForm" method="POST" action="{{ route('admin.settings.academic-year.store') }}">
                                        @csrf
                                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
                                            <div>
                                                <label class="form-label">Year Start</label>
                                                <input type="number" name="year_start" class="input-pro" placeholder="e.g. 2025" required min="2000" max="2100">
                                            </div>
                                            <div>
                                                <label class="form-label">Year End</label>
                                                <input type="number" name="year_end" class="input-pro" placeholder="e.g. 2026" required min="2000" max="2100">
                                            </div>
                                        </div>
                                        <div style="margin-top:16px; display:flex; gap:8px">
                                            <button type="submit" class="btn btn-blue">Save Academic Year</button>
                                            <button type="button" onclick="hideAddAcademicYearForm()" class="btn">Cancel</button>
                                        </div>
                                    </form>
                                </div>

                                <div style="margin-top:16px">
                                    <table class="table-pro" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Academic Year</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $academicYears = \App\Models\AcademicYear::orderBy('year_start', 'desc')->get();
                                            @endphp
                                            @forelse($academicYears as $ay)
                                                <tr style="{{ $ay->is_active ? 'background:#f0f7ff' : '' }}">
                                                    <td style="font-weight:700">{{ $ay->year_start }} – {{ $ay->year_end }}</td>
                                                    <td>
                                                        @if($ay->is_active)
                                                            <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:999px; font-size:.75rem; font-weight:800">ACTIVE</span>
                                                        @else
                                                            <span style="background:#f1f5f9; color:#64748b; padding:4px 10px; border-radius:999px; font-size:.75rem; font-weight:800">INACTIVE</span>
                                                        @endif
                                                    </td>
                                                    <td style="color:#64748b; font-size:.85rem">{{ $ay->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @if(!$ay->is_active)
                                                            <form method="POST" action="{{ route('admin.settings.academic-year.activate', $ay->id) }}" style="display:inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-blue" style="font-size:.75rem; padding:6px 10px">Set as Active</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" style="text-align:center; padding:30px; color:#64748b">No academic years found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="import-side">
                            <div class="side-head"><i class="fas fa-info-circle"></i> Academic Year Rules</div>
                            <ul class="side-list">
                                <li>Only one academic year can be active at a time.</li>
                                <li>Activating a new year automatically deactivates the current one.</li>
                                <li>New courses will be linked to the active academic year.</li>
                                <li>Existing courses will retain their linked academic year.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    function showAddAcademicYearForm(){
                        document.getElementById('addAcademicYearForm').style.display='block';
                    }
                    function hideAddAcademicYearForm(){
                        document.getElementById('addAcademicYearForm').style.display='none';
                    }
                    function openSetting(key){
                        if(key==='location'){
                            document.getElementById('settingsHome').style.display='none';
                            document.getElementById('settingsLocation').style.display='block';
                        } else if (key==='backup'){
                            document.getElementById('settingsHome').style.display='none';
                            document.getElementById('settingsBackup').style.display='block';
                        } else if (key==='academic-year'){
                            document.getElementById('settingsHome').style.display='none';
                            document.getElementById('settingsAcademicYear').style.display='block';
                        }
                    }
                    function backSettingsHome(){
                        var loc=document.getElementById('settingsLocation');
                        var bkp=document.getElementById('settingsBackup');
                        var ay=document.getElementById('settingsAcademicYear');
                        if(loc) loc.style.display='none';
                        if(bkp) bkp.style.display='none';
                        if(ay) ay.style.display='none';
                        document.getElementById('settingsHome').style.display='block';
                    }
                    (function(){
                        var form=document.getElementById('psgcImportForm');
                        if(!form) return;
                        var dz=document.getElementById('psgcDrop');
                        var fi=document.getElementById('psgcFile');
                        var fn=document.getElementById('psgcFileName');
                        var btn=document.getElementById('psgcImportBtn');
                        var prog=document.getElementById('psgcProg');
                        function setFile(f){
                            if(!f) return;
                            var name=f.name||'file';
                            var ext=(name.split('.').pop()||'').toLowerCase();
                            var dt=new DataTransfer();
                            dt.items.add(f);
                            fi.files=dt.files;
                            fn.textContent=name+' · '+Math.round(f.size/1024)+' KB';
                            if(ext==='csv'){
                                btn.disabled=false;
                                document.getElementById('psgcStatus').textContent='Ready to import';
                            }else{
                                btn.disabled=true;
                                document.getElementById('psgcStatus').textContent='Only CSV supported. Please convert the .xlsx file.';
                            }
                        }
                        dz.addEventListener('click', function(){ fi.click(); });
                        dz.addEventListener('dragover', function(e){ e.preventDefault(); dz.style.borderColor='#90b4f8'; });
                        dz.addEventListener('dragleave', function(){ dz.style.borderColor='#cfe0ff'; });
                        dz.addEventListener('drop', function(e){ e.preventDefault(); dz.style.borderColor='#cfe0ff'; var f=e.dataTransfer.files[0]; setFile(f); });
                        fi.addEventListener('change', function(){ var f=fi.files[0]; setFile(f); });
                        form.addEventListener('submit', function(ev){
                            ev.preventDefault();
                            var st=document.getElementById('psgcStatus');
                            var rs=document.getElementById('psgcResult');
                            st.textContent='Uploading...';
                            rs.style.display='none';
                            rs.innerHTML='';
                            prog.style.width='35%';
                            var fd=new FormData(form);
                                    var mode=document.getElementById('psgcMode').value||'insert_update';
                                    fd.append('mode', mode);
                            var startTime=performance.now();
                            fetch(form.action, {method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'}})
                                .then(function(r){ return r.json(); })
                                .then(function(j){
                                    if(j && j.ok){
                                        st.textContent='Import completed';
                                        prog.style.width='100%';
                                        rs.style.display='flex';
                                                var reg=j.regions||0, prov=j.provinces||0, cities=j.cities||0, brgys=j.barangays||0;
                                                var total=j.total_rows||0, ins=j.inserted||0, upd=j.updated||0, sk=j.skipped||0, err=j.errors||0;
                                        var elapsedSec=((performance.now()-startTime)/1000).toFixed(1);
                                        var banner='<div style=\"display:flex;align-items:center;gap:10px;background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;padding:12px 14px;border-radius:12px;font-weight:800\">'
                                            +'<i class=\"fas fa-check-circle\"></i>'
                                            +'<span>Import Completed Successfully</span>'
                                            +'<span style=\"margin-left:auto;font-weight:700;color:#065f46\">'+total.toLocaleString()+' records processed successfully in '+elapsedSec+' seconds.</span>'
                                            +'</div>';
                                        var statCard=function(bg,border,color,icon,label,val){
                                            return '<div style=\"background:'+bg+';border:1px solid '+border+';color:'+color+';border-radius:14px;padding:14px 16px;box-shadow:0 8px 18px rgba(15,23,42,.07)\">'
                                                +'<div style=\"display:flex;align-items:center;gap:10px\">'
                                                +'<div style=\"width:36px;height:36px;border-radius:12px;background:#ffffff22;display:flex;align-items:center;justify-content:center\"><i class=\"'+icon+'\"></i></div>'
                                                +'<div><div style=\"font-size:.78rem;font-weight:700;opacity:.9\">'+label+'</div><div style=\"font-size:1.3rem;font-weight:800\">'+val.toLocaleString()+'</div></div>'
                                                +'</div>'
                                                +'</div>';
                                        };
                                        var gridStats='<div style=\"display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px;margin-top:10px\">'
                                            +statCard('#eef6ff','#cfe0ff','#0B2C74','fas fa-list','Total Records',total)
                                            +statCard('#ecfdf5','#bbf7d0','#166534','fas fa-plus','Inserted',ins)
                                            +statCard('#eef2ff','#c7d2fe','#1e3a8a','fas fa-sync','Updated',upd)
                                            +statCard('#fff7ed','#fed7aa','#9a3412','fas fa-ban','Skipped',sk)
                                            +statCard('#fff5f5','#fecaca','#b10606','fas fa-exclamation-triangle','Errors',err)
                                            +'</div>';
                                        var breakdownCard=function(icon,label,val){
                                            return '<div style=\"background:#f8fafc;border:1px solid #dbe3f1;color:#0B2C74;border-radius:12px;padding:10px 12px;display:flex;align-items:center;gap:8px\">'
                                                +'<i class=\"'+icon+'\"></i><span style=\"font-weight:700\">'+label+'</span>'
                                                +'<span style=\"margin-left:auto;font-weight:800\">'+val.toLocaleString()+'</span></div>';
                                        };
                                        var breakdown='<div style=\"margin-top:12px;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;padding:12px\">'
                                            +'<div style=\"font-weight:800;color:#0B2C74;margin-bottom:8px\">Location Breakdown</div>'
                                            +'<div style=\"display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:8px\">'
                                            +breakdownCard('fas fa-map','Regions',reg)
                                            +breakdownCard('fas fa-flag','Provinces',prov)
                                            +breakdownCard('fas fa-city','Cities/Municipalities',cities)
                                            +breakdownCard('fas fa-home','Barangays',brgys)
                                            +'</div></div>';
                                        var actions='<div style=\"margin-top:12px;display:flex;align-items:center;gap:10px\">'
                                            +'<a href=\"{{ route('psgc.regions') }}\" target=\"_blank\" class=\"btn btn-primary\" style=\"display:inline-flex;align-items:center;gap:8px\"><i class=\"fas fa-eye\"></i> View Imported Data</a>'
                                            +'<button type=\"button\" id=\"psgcImportAgainBtn\" class=\"btn\" style=\"display:inline-flex;align-items:center;gap:8px\"><i class=\"fas fa-file-upload\"></i> Import Another File</button>'
                                            +'</div>';
                                        rs.innerHTML='<div style=\"width:100%;display:flex;flex-direction:column;gap:10px\">'+banner+gridStats+breakdown+actions+'</div>';
                                        var again=document.getElementById('psgcImportAgainBtn');
                                        if(again){
                                            again.addEventListener('click', function(){
                                                fi.value='';
                                                fn.textContent='No file selected';
                                                btn.disabled=true;
                                                document.getElementById('psgcStatus').textContent='';
                                                prog.style.width='0%';
                                                rs.style.display='none';
                                                rs.innerHTML='';
                                            });
                                        }
                                    }else{
                                        st.textContent='Import failed';
                                        prog.style.width='0%';
                                        rs.style.display='flex';
                                        rs.innerHTML='<span class="chip" style="background:#fff5f5;border-color:#fecaca;color:#b10606">'+((j && j.error)||'Error')+'</span>';
                                    }
                                })
                                .catch(function(){
                                    st.textContent='Import failed';
                                    prog.style.width='0%';
                                    rs.style.display='flex';
                                    rs.innerHTML='<span class="chip" style="background:#fff5f5;border-color:#fecaca;color:#b10606">Network or server error</span>';
                                });
                        });
                    })();
                </script>
            </section>
            @endif

            @include('components.help_support')
            <!-- User Management Section -->
            <section id="user-management" class="content-section {{ request()->hasAny(['search', 'roles', 'statuses', 'page']) || request('tab') == 'user-management' ? 'active' : '' }}">
                <div class="user-management-shell">
                    <div class="user-management-header">
                    </div>
                    
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
                                        @foreach(($roles ?? []) as $role)
                                            <option value="role:{{ $role->name }}">
                                                {{ $role->display_name ?? ucfirst(str_replace('_',' ', $role->name)) }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Status">
                                        <option value="status:active">Active</option>
                                        <option value="status:freeze">Blocked</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="filter-field">
                                <label for="sortUsers">Sort By</label>
                                <select id="sortUsers" name="sort" onchange="document.getElementById('filterForm').submit()" class="filter-select">
                                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    <option value="alpha" {{ request('sort') === 'alpha' ? 'selected' : '' }}>Alphabetical (Aâ€“Z)</option>
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
                            @foreach(($roles ?? []) as $role)
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="filter-checkbox" {{ in_array($role->name, request('roles', [])) ? 'checked' : '' }} hidden>
                            @endforeach
                            
                            <input type="checkbox" name="statuses[]" value="active" class="filter-checkbox" {{ in_array('active', request('statuses', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="statuses[]" value="freeze" class="filter-checkbox" {{ in_array('freeze', request('statuses', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="statuses[]" value="pending" class="filter-checkbox" {{ in_array('pending', request('statuses', [])) ? 'checked' : '' }} hidden>
                        </div>
                    </form>

                    <div id="usersTableContainer">
                        @include('admin.partials.users-table')
                    </div>
                </div>
            </section>

            <section id="user-details-section" class="content-section {{ request('tab') == 'user-details-section' ? 'active' : '' }}">
                <div class="user-details-shell">
                    <div class="user-details-topbar">
                        <button type="button" class="user-details-back" onclick="closeViewModal()">
                            <i class="fas fa-arrow-left"></i>
                            Back to User Management
                        </button>
                        <div class="user-details-hero">
                            <div class="user-details-kicker">
                                <i class="fas fa-user-shield"></i>
                                Account Workspace
                            </div>
                            <h2 class="user-details-headline">Review identity, access, and security in one focused admin workspace.</h2>
                            <div class="user-details-note">Manage the selected account directly in the main workspace with a cleaner profile flow for updates, role assignment, permissions, and security review.</div>
                        </div>
                    </div>
                    <div id="userDetailsMount"></div>
                </div>
            </section>

            <!-- Access Management Section (Super Admin) -->
            <section id="access-management" class="content-section {{ request('tab') == 'access-management' ? 'active' : '' }}">
                @php $canAccess = auth()->check() && auth()->user()->role === 'super_admin'; @endphp
                <div class="insight-panel">
                    <div class="insight-panel-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                        <div style="display:flex;align-items:center;gap:10px;flex:1">
                            <span class="muted">Assign system feature access per role</span>
                            <div style="position:relative;max-width:360px;flex:1">
                                <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b"></i>
                                <input id="accessRoleSearch" type="text" placeholder="Search rolesâ€¦" 
                                       style="width:100%;padding:10px 12px 10px 36px;border:1px solid #e5e7eb;border-radius:12px;background:#ffffff">
                            </div>
                        </div>
                        @if($canAccess)
                            <button type="button" onclick="openAddRoleModal()" class="btn-update" style="background:#002C76;color:#fff;border-color:#002C76;display:inline-flex;align-items:center;gap:8px; border-radius:8px">
                                <i class="fas fa-plus"></i> Add Role
                            </button>
                        @endif
                    </div>
                    @if(session('success_access'))
                        <div style="background:#e6fffa;color:#065f46;padding:12px;border-radius:10px;margin-bottom:12px">{{ session('success_access') }}</div>
                    @endif
                    @if(session('error_access'))
                        <div style="background:#fee2e2;color:#7f1d1d;padding:12px;border-radius:10px;margin-bottom:12px">{{ session('error_access') }}</div>
                    @endif
                    @if(!$canAccess)
                        <div style="background:#fee2e2;color:#7f1d1d;padding:12px;border-radius:10px">Only Super Admin can manage access.</div>
                    @else
                        <style>
                            .access-tabs{display:flex;gap:8px;margin-bottom:12px}
                            .access-tab{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#fff;color:#0B2C74;font-weight:800;cursor:pointer}
                            .access-tab.active{background:#eef2ff;border-color:#cfe0ff}
                            .accordion-item{border:1px solid #e5eef7;border-radius:12px;overflow:hidden;margin-bottom:10px}
                            .accordion-header{background:#f8fafc;padding:10px 12px;font-weight:800;color:#0B2C74;display:flex;align-items:center;justify-content:space-between;cursor:pointer}
                            .accordion-content{display:none;padding:12px;background:#fff}
                            .accordion-item.open .accordion-content{display:block}
                            /* Pro Modal Styles */
                            .pro-modal{background:linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 24px 48px rgba(2,6,23,.18);width:520px;max-width:95vw;overflow:hidden}
                            .pro-modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;border-bottom:1px solid #e5e7eb;background:linear-gradient(180deg,rgba(243,246,255,.8),rgba(255,255,255,.6))}
                            .pro-modal-title{display:flex;align-items:center;gap:10px;font-weight:800;color:#0B2C76}
                            .pro-modal-title .badge{width:36px;height:36px;border-radius:10px;background:#0B2C76;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800}
                            .pro-modal-close{background:#fff;border:1px solid #e5e7eb;border-radius:999px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;color:#64748b;cursor:pointer}
                            .pro-modal-body{padding:18px;display:grid;gap:14px}
                            .pro-field{display:grid;gap:6px}
                            .pro-label{font-size:.78rem;color:#64748b;font-weight:800;letter-spacing:.04em;text-transform:uppercase}
                            .pro-input{width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;background:#ffffff;font-size:.95rem}
                            .pro-modal-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:12px 18px;border-top:1px solid #e5e7eb;background:#f8fafc}
                            .btn-ghost{background:#fff;border:1px solid #e2e8f0;color:#475569;border-radius:999px;padding:10px 16px;font-weight:700}
                            .btn-solid{background:#00a859;border:1px solid #00a859;color:#fff;border-radius:999px;padding:10px 16px;font-weight:800}
                        </style>
                        <div class="access-tabs" style="display:none"></div>
                        @php
                            $permLabel = function($p){ return $p->display_name ?? ucfirst(str_replace('_',' ',$p->name)); };
                            $roleLabel = function($r){ return $r->display_name ?? ucfirst(str_replace('_',' ',$r->name)); };
                            $allPerms = ($permissions ?? collect());
                            $allRoles = ($roles ?? collect());
                            $priority = ['admin', 'training_manager', 'coach', 'participant'];
                            $sortedRoles = $allRoles->sort(function($a,$b) use ($priority){
                                $pa = array_search($a->name, $priority); $pb = array_search($b->name, $priority);
                                if ($pa !== false && $pb !== false) return $pa <=> $pb;
                                if ($pa !== false) return -1;
                                if ($pb !== false) return 1;
                                return strcmp($a->display_name ?? $a->name, $b->display_name ?? $b->name);
                            });
                        @endphp
                        <form method="POST" action="{{ route('admin.access.update') }}">
                            @csrf
                            @foreach($sortedRoles as $role)
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <span>{{ $roleLabel($role) }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="access-tabs">
                                            <button type="button" class="access-tab active" data-target="perms-role-{{ $role->id }}">Permissions</button>
                                        </div>
                                        <div id="perms-role-{{ $role->id }}" class="tab-pane" style="">
                                            <table class="table-pro">
                                                <thead>
                                                    <tr>
                                                        <th style="width:120px">Clear All <input type="checkbox" class="clear-all-perms"></th>
                                                        <th style="width:320px">Permissions</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $assigned = ($rolePermissions[$role->id] ?? []); @endphp
                                                    @foreach($allPerms as $p)
                                                        <tr>
                                                            <td style="text-align:center">
                                                                <input type="checkbox"
                                                                       name="matrix[{{ $role->id }}][{{ $p->id }}]"
                                                                       value="1"
                                                                       class="perm-check"
                                                                       {{ in_array($p->id, $assigned, true) ? 'checked' : '' }}>
                                                            </td>
                                                            <td>{{ $permLabel($p) }}</td>
                                                            <td class="card-muted">System permission: {{ $p->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="panel-actions" style="margin-top:12px">
                                            <button type="submit" class="btn btn-primary">Save Access</button>
                                        </div>
                                        <script>
                                        (function(){
                                            var wrap = document.currentScript.parentElement;
                                            var tabBtn = wrap.querySelector('.access-tab');
                                            if (tabBtn) {
                                                tabBtn.addEventListener('click', function(){
                                                    tabBtn.classList.add('active');
                                                    wrap.querySelectorAll('.tab-pane').forEach(function(p){
                                                        p.style.display = (p.id === tabBtn.getAttribute('data-target')) ? '' : 'none';
                                                    });
                                                });
                                            }
                                            var clearPerms = wrap.querySelector('.clear-all-perms');
                                            var permChecks = wrap.querySelectorAll('.perm-check');
                                            if(clearPerms){
                                                clearPerms.addEventListener('change', function(){
                                                    permChecks.forEach(function(c){ c.checked = clearPerms.checked; });
                                                });
                                            }
                                        })();
                                        </script>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                        @if(Auth::check() && Auth::user()->role === 'super_admin')
                        @endif
                        <script>
                        (function(){
                            var section = document.getElementById('access-management');
                            if(!section){ return; }
                            var search = document.getElementById('accessRoleSearch');
                            if(search){
                                search.addEventListener('input', function(){
                                    var q = (this.value || '').toLowerCase().trim();
                                    var items = section.querySelectorAll('.accordion-item');
                                    items.forEach(function(it){
                                        var name = (it.querySelector('.accordion-header span')?.textContent || '').toLowerCase();
                                        it.style.display = q ? (name.indexOf(q) !== -1 ? '' : 'none') : '';
                                    });
                                });
                            }
                            var headers = section.querySelectorAll('.accordion-header');
                            headers.forEach(function(h){
                                h.addEventListener('click', function(){
                                    var item = h.closest('.accordion-item');
                                    var isOpen = item.classList.contains('open');
                                    section.querySelectorAll('.accordion-item').forEach(function(it){
                                        it.classList.remove('open');
                                    });
                                    if(!isOpen){
                                        item.classList.add('open');
                                    }
                                });
                            });
                        })();
                        </script>
                    @endif
                </div>
            </section>
            <!-- Course Management Section -->
            <section id="course-management" class="content-section {{ request('tab') == 'course-management' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;">Course <strong>Management</strong></h1>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div style="position: relative; width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                            <input type="text" id="courseSearchInput" placeholder="Search courses..." style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; transition: border-color 0.2s ease;">
                        </div>
                        <div style="position: relative; width: 220px;">
                            <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                            <select id="academicYearFilterManagement" onchange="filterByAcademicYearManagement(this.value)" style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; appearance: none; background: #fff; cursor: pointer;">
                                <option value="all" {{ $selectedYearId === 'all' ? 'selected' : '' }}>All Academic Years</option>
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $selectedYearId == $ay->id ? 'selected' : '' }}>
                                        {{ $ay->year_start }} - {{ $ay->year_end }} {{ $ay->is_active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
                        </div>
                    </div>
                </div>

                @php
                    $activeCoursesCount = $courses->count();
                    $pendingCoursesCount = $pendingCourses->count();
                    $draftCoursesCount = 0;
                    $archivedCoursesCount = $archivedCourses->count();
                @endphp
                <div class="course-stats-grid">
                    <div class="course-stat-card active"
                         role="button"
                         tabindex="0"
                         onclick="showContent('course-management', document.querySelector('.menu-item[onclick*=\'course-management\']))"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Active Courses</p>
                            <p class="course-stat-value">{{ $activeCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-graduation-cap"></i></span>
                    </div>
                    <div class="course-stat-card pending"
                         role="button"
                         tabindex="0"
                         onclick="window.location.href='{{ route('dashboard', ['tab' => 'pending-courses']) }}'"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Pending Courses</p>
                            <p class="course-stat-value">{{ $pendingCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-hourglass-half"></i></span>
                    </div>
                    <div class="course-stat-card draft"
                         role="button"
                         tabindex="0"
                         onclick="navigateToSection('draft-courses')"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Draft Courses</p>
                            <p id="draftCoursesCount" class="course-stat-value">{{ $draftCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-file-pen"></i></span>
                    </div>
                    <div class="course-stat-card archived"
                         role="button"
                         tabindex="0"
                         onclick="navigateToSection('archived-courses')"
                         onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                        <div>
                            <p class="course-stat-label">Archived Courses</p>
                            <p class="course-stat-value">{{ $archivedCoursesCount }}</p>
                        </div>
                        <span class="course-stat-icon"><i class="fas fa-box-archive"></i></span>
                    </div>
                    <div class="course-stat-card library"
                         role="button"
                         tabindex="0"
                         onclick="showContent('course-library', document.querySelector('.menu-item[onclick*=\'course-management\']'))"
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

                <div class="course-grid">
                    @if(Auth::user()->hasPermission('create_courses'))
                    <button type="button" class="course-card add-course-card" onclick="openAddCourseModal()" aria-label="Add Course" style="border:0;">
                        <span class="add-course-plus"><i class="fas fa-plus"></i></span>
                        <p class="add-course-title">Add Course</p>
                    </button>
                    @endif
                    @foreach($courses as $course)
                        @php
                            $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp;
                            $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                        @endphp
                            <div class="course-card"
                             role="button"
                             tabindex="0"
                             onclick="openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null), 'created_at' => optional($course->created_at)->format('M d, Y')]) }})"
                             onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }"
                             style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; cursor: pointer; height: 280px; display: flex; flex-direction: column;">
                            @php
                                $img = null;
                                if (!empty($course->image_path)) {
                                    $path = public_path('storage/' . $course->image_path);
                                    if (file_exists($path)) {
                                        $img = asset('storage/' . $course->image_path) . '?v=' . $ver;
                                    } else {
                                        $path2 = public_path('images/' . ltrim($course->image_path, '/'));
                                        if (file_exists($path2)) {
                                            $img = asset('images/' . ltrim($course->image_path, '/')) . '?v=' . $ver;
                                        }
                                    }
                                }
                                if (!$img) {
                                    $img = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="160" viewBox="0 0 300 160"><rect width="300" height="160" rx="18" fill="#eef4ff"/><path d="M104 62h92a10 10 0 0 1 10 10v16a10 10 0 0 1-10 10h-92a10 10 0 0 1-10-10V72a10 10 0 0 1 10-10Z" fill="#dbe7fb"/><circle cx="122" cy="80" r="12" fill="#93c5fd"/><path d="M116 108l22-21 18 16 18-24 28 29H116Z" fill="#bfdbfe"/><text x="150" y="138" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="16" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 22, '')) . '</text></svg>');
                                }
                                if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                    $img = $course->image_path;
                                }
                                $ph = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 28, '')) . '</text></svg>');
                            @endphp
                            <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 160px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ $ph }}'">
                            <div style="padding: 15px; display: flex; flex-direction: column; gap: 6px; flex: 1;">
                                <h3 style="margin: 0; color: var(--primary-blue); font-size: 1.05rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->name }}</h3>
                                <p style="color: var(--light-text); margin: 0; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
                                <p style="color: var(--light-text); margin: 0; font-size: 0.85rem;">Created by: {{ $creator ? $creator->name : 'N/A' }}</p>
                                <p style="color: var(--light-text); margin: 0; font-size: 0.85rem;">Created: {{ optional($course->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Archived Courses list removed; use modal via the 'Archived Courses' button -->
            </section>

            <!-- Course Create Section -->
            <section id="course-create" class="content-section {{ request('tab') == 'course-create' ? 'active' : '' }}">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin:0;">Add <strong>Course</strong></h1>
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="openDraftCoursesModal()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            <i class="fas fa-file-pen"></i> Draft Courses
                        </button>
                        <button type="button" onclick="navigateToSection('course-management')" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Back to Course Management
                        </button>
                    </div>
                </div>
                <div class="course-create-shell">
                    <iframe id="courseCreateFrame" title="Create course form" src="{{ request('tab') == 'course-create' ? route('admin.courses.create', array_filter(['embedded' => 1, 'step' => request('step')])) : '' }}"></iframe>
                </div>
            </section>

            <!-- Pending Courses Section -->
            <section id="pending-courses" class="content-section {{ request('tab') == 'pending-courses' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;">Pending <strong>Courses</strong></h1>
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="openDraftCoursesModal()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            <i class="fas fa-file-pen"></i> Draft Courses
                        </button>
                        <button type="button" onclick="navigateToSection('course-management')" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Back to Course Management
                        </button>
                    </div>
                </div>

                @if(session('success_course'))
                    <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('success_course') }}
                    </div>
                @endif

                @if($pendingCourses->isEmpty())
                    <div class="placeholder-content">
                        <p>There are no submitted courses.</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
                        @foreach($pendingCourses as $course)
                            @php
                                $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp;
                                $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                            @endphp
                            <div class="course-card" role="button" tabindex="0" onclick='openViewCourseModal(@json(["id" => $course->id, "name" => $course->name, "creator_name" => ($creator ? $creator->name : null)]))' onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden; cursor: pointer;">
                                @php
                                    $img = null;
                                    if (!empty($course->image_path)) {
                                        $path = public_path('storage/' . $course->image_path);
                                        if (file_exists($path)) {
                                            $img = asset('storage/' . $course->image_path) . '?v=' . $ver;
                                        } else {
                                            $path2 = public_path('images/' . ltrim($course->image_path, '/'));
                                            if (file_exists($path2)) {
                                                $img = asset('images/' . ltrim($course->image_path, '/')) . '?v=' . $ver;
                                            }
                                        }
                                    }
                                    if (!$img) {
                                        $img = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="150" viewBox="0 0 300 150"><rect width="300" height="150" rx="18" fill="#eef4ff"/><path d="M98 58h104a10 10 0 0 1 10 10v14a10 10 0 0 1-10 10H98a10 10 0 0 1-10-10V68a10 10 0 0 1 10-10Z" fill="#dbe7fb"/><circle cx="122" cy="75" r="12" fill="#93c5fd"/><path d="M110 104l28-25 18 15 18-22 28 32H110Z" fill="#bfdbfe"/><text x="150" y="130" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="16" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 22, '')) . '</text></svg>');
                                    }
                                    if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                        $img = $course->image_path;
                                    }
                                    $ph = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 28, '')) . '</text></svg>');
                                @endphp
                                <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 150px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ $ph }}'">
                                <div style="padding: 14px;">
                                    <h3 style="margin: 0 0 6px; color: #002C76; font-size: 1.05rem;">{{ $course->name }}</h3>
                                    <p style="color: #6b7280; font-size: .9rem; margin: 0 0 10px;">{{ Str::limit($course->description, 100) }}</p>
                                    @php
                                        $submitter = $course->users->first(function($u){ return in_array($u->role, ['coach','trainer']); });
                                    @endphp
                                    @if($submitter)
                                        <p style="color: #6b7280; font-size: .9rem; margin: 0 0 10px;">
                                            <i class="fas fa-user"></i> Submitted by {{ $submitter->name }}
                                        </p>
                                    @endif
                                    <div style="display: flex; gap: 8px;">
                                        <button type="button" onclick='event.stopPropagation(); openViewCourseModal(@json(["id" => $course->id, "name" => $course->name, "creator_name" => ($creator ? $creator->name : null)]))' style="background: #17a2b8; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                            View
                                        </button>
                                        <form action="{{ route('courses.restore', $course->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Approve this course? It will be moved to Active.')" style="margin: 0;">
                                            @csrf
                                            <button type="submit" style="background: #28a745; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer;">
                                                Approve
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section id="archived-courses" class="content-section {{ request('tab') == 'archived-courses' ? 'active' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin:0;">Archived <strong>Courses</strong></h1>
                    <div style="display:flex; gap:10px;">
                        <button type="button" onclick="openDraftCoursesModal()" style="background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight:600;">
                            <i class="fas fa-file-pen"></i> Draft Courses
                        </button>
                        <button type="button" onclick="navigateToSection('course-management')" style="background-color:#002C76;color:#fff;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;display:inline-flex;align-items:center;gap:8px">
                            <i class="fas fa-arrow-left"></i> Back to Course Management
                        </button>
                    </div>
                </div>
                @if($archivedCourses->isEmpty())
                    <p style="color:#6c757d;font-style:italic;margin:0">There are no archived courses yet.</p>
                @else
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px">
                        @foreach($archivedCourses as $course)
                            @php
                                $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp;
                                $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
                            @endphp
                            <div class="course-card" role="button" tabindex="0" onclick="openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null)]) }})" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 8px 20px rgba(2,6,23,.06);overflow:hidden;cursor:pointer;transition:transform .12s ease, box-shadow .12s ease;position:relative">
                                <div style="position:relative">
                                    <img src="{{ $course->image_path ? asset('storage/' . $course->image_path).'?v='.$ver : 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"600\" height=\"300\" viewBox=\"0 0 600 300\"><rect width=\"600\" height=\"300\" rx=\"24\" fill=\"#eef4ff\"/><path d=\"M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z\" fill=\"#dbe7fb\"/><circle cx=\"244\" cy=\"143\" r=\"22\" fill=\"#93c5fd\"/><path d=\"M218 210l54-52 44 38 44-58 68 72H218Z\" fill=\"#bfdbfe\"/><text x=\"300\" y=\"256\" text-anchor=\"middle\" fill=\"#1d4ed8\" font-family=\"Arial, sans-serif\" font-size=\"24\" font-weight=\"700\">'.e(\Illuminate\Support\Str::limit($course->name, 28, '')).'</text></svg>') }}" alt="{{ $course->name }}" style="width:100%;height:150px;object-fit:cover;filter:grayscale(100%)">
                                    <span style="position:absolute;left:12px;top:12px;display:inline-block;background:#1f2937;color:#fff;border-radius:999px;padding:4px 10px;font-weight:800;font-size:.75rem;opacity:.9">Archived</span>
                                    <button type="button" class="kebab" onclick="event.stopPropagation(); toggleCertMenu('arch-{{ $course->id }}')" style="position:absolute;right:12px;top:12px"><i class="fas fa-ellipsis-v"></i></button>
                                    <div id="menu-arch-{{ $course->id }}" class="menu" style="right:12px;top:46px">
                                        <a href="#" onclick="event.stopPropagation(); openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null)]) }}); toggleCertMenu('arch-{{ $course->id }}'); return false;"><i class="fas fa-eye"></i> View</a>
                                        <form action="{{ route('courses.restore', $course->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Unarchive this course?')">
                                            @csrf
                                            <button type="submit"><i class="fas fa-rotate-left"></i> Unarchive</button>
                                        </form>
                                        <form action="{{ route('courses.force-delete', $course->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Permanently delete this course? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px">
                                    <div>
                                        <div style="font-weight:800;color:#0f3b8f;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $course->name }}</div>
                                        <div style="color:#6b7280;font-size:.88rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-top:6px">{{ $course->description }}</div>
                                    </div>
                                    <div style="display:flex;gap:8px;justify-content:flex-end"><span style="color:#6b7280;font-size:.85rem">Actions â€¢</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Certification Management Section -->
            <section id="certification-management" class="content-section {{ request('tab') == 'certification-management' ? 'active' : '' }}">
                <style>
                    .cert-shell{background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;box-shadow:0 12px 28px rgba(2,6,23,.06)}
                    .cert-tabs{display:flex;gap:8px;padding:10px;background:#f8fafc;border-bottom:1px solid #e5e7eb}
                    .cert-tabs .tab-btn{display:inline-flex;align-items:center;gap:8px;background:#fff;color:#0b3b8f;border:1px solid #dbeafe;border-radius:999px;padding:8px 12px;font-weight:800}
                    .cert-tabs .tab-btn.active{background:#0b3b8f;color:#fff;border-color:#0b3b8f}
                    .cert-layout{display:grid;grid-template-columns:1.2fr .9fr;gap:18px}

                   .cert-panel{background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 8px 20px rgba(2,6,23,.06);padding:16px}
                    #certification-management .pro-input{
                        width:100%;
                        padding:10px;
                        border:1px solid #e5e7eb;
                        border-radius:10px;
                        background:#f8fafc;
                        transition:border-color .18s ease, box-shadow .18s ease;
                        box-sizing:border-box;
                        min-width:0;
                    }
                    #certification-management .pro-input:focus{outline:none;border-color:#90b4f8;box-shadow:0 0 0 3px rgba(144,180,248,.35)}
                    #certification-management label{display:block;margin-bottom:6px;color:#0f3b8f;font-weight:800}
                    .dz{border:2px dashed #cfe0ff;border-radius:14px;background:#f8fbff;padding:18px;text-align:center}
                    .dz:hover{border-color:#90b4f8;background:#f0f6ff}
                    .cert-preview-head{font-weight:800;color:#0f3b8f;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between}
                    .cert-preview-box{position:relative;width:100%;aspect-ratio:1400/990;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;background:#f8fafc}
                    .btn-pill{display:inline-flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:999px;padding:8px 12px;background:#fff;color:#111827;font-weight:800}
                    .btn-blue{background:#0f3b8f;color:#fff;border-color:#0f3b8f}
                    .btn-green{background:#28a745;color:#fff;border-color:#28a745}
                    .btn-red{background:#dc3545;color:#fff;border-color:#dc3545}
                    .cert-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
                    .cert-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 8px 20px rgba(2,6,23,.06);overflow:hidden}
                    .cert-card-head{padding:10px 12px;border-bottom:1px solid #eef2f7;display:flex;align-items:center;justify-content:flex-end;gap:8px}
                    .cert-title{font-weight:800;color:#002C76}
                    .cert-chip{display:inline-block;background:#eef2ff;color:#0f3b8f;border-radius:6px;padding:4px 10px;font-weight:800;font-size:.8rem}
                    .cert-actions{padding:12px 16px;display:flex;gap:8px}
                    .cert-meta{padding:12px 16px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid #eef2f7}
                    .cert-empty{display:flex;align-items:center;justify-content:center;min-height:160px;color:#64748b;gap:10px}
                    .kebab{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:6px 10px;cursor:pointer;font-weight:800;color:#0f3b8f}
                    .kebab:hover{background:#f3f6ff}
                    .menu{position:absolute;right:12px;top:42px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 12px 24px rgba(2,6,23,.12);display:none;min-width:180px;z-index:5}
                    .menu.open{display:block}
                    .menu a,.menu form button{display:flex;gap:10px;align-items:center;width:100%;text-align:left;background:none;border:none;padding:10px 12px;color:#111827;text-decoration:none;font-weight:700}
                    .menu a:hover,.menu form button:hover{background:#f8fafc}
                    .flash-alert{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:12px;border-radius:10px;padding:10px 12px;font-weight:700}
                    .flash-success{border:1px solid #bbf7d0;background:#ecfdf3;color:#166534}
                    .flash-error{border:1px solid #f5c2c7;background:#fff5f5;color:#842029}
                    .flash-close{border:none;background:transparent;font-size:1.2rem;line-height:1;cursor:pointer;color:inherit;padding:4px 8px;border-radius:6px}
                    .flash-close:hover{background:rgba(0,0,0,.06)}
                    .flash-hide{opacity:0;transition:opacity .25s ease}
                    .sticky-preview{position:sticky;top:80px}
                    .cert-img-modal{position:fixed;inset:0;background:rgba(0,0,0,.65);display:none;align-items:center;justify-content:center;z-index:1200}
                    .cert-img-modal .box{max-width:92vw;max-height:90vh;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 22px 48px rgba(2,6,23,.35)}
                    .cert-img-modal img{display:block;max-width:92vw;max-height:90vh}
                    @media (max-width: 1024px){
                        .cert-layout{grid-template-columns:1fr}
                        .sticky-preview{position:static}
                    }
                </style>
                <div class="cert-shell">
                    <div class="cert-tabs">
                        <button id="certTabCreate" class="tab-btn active" onclick="switchCertTab('create')" aria-controls="certPaneCreate" aria-selected="true"><i class="fas fa-plus-circle"></i> Create Certificate</button>
                        <button id="certTabView" class="tab-btn" onclick="switchCertTab('view')" aria-controls="certPaneView" aria-selected="false"><i class="fas fa-list"></i> View Certificates</button>
                        <button id="certTabCertify" class="tab-btn" onclick="switchCertTab('certify')" aria-controls="certPaneCertify" aria-selected="false"><i class="fas fa-award"></i> Certify</button>
                    </div>
                    @if(session('success_certification'))
                        <div class="flash-alert flash-success" data-auto-dismiss="true">
                            <span>{{ session('success_certification') }}</span>
                            <button type="button" class="flash-close" onclick="this.parentElement.remove()">Ã—</button>
                        </div>
                    @endif
                    @if(session('error_certification'))
                        <div class="flash-alert flash-error" data-auto-dismiss="true">
                            <span>{{ session('error_certification') }}</span>
                            <button type="button" class="flash-close" onclick="this.parentElement.remove()">Ã—</button>
                        </div>
                    @endif
                    <div id="certPaneCreate" style="display:block;padding:16px">
                        <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data" id="certCreateForm">
                            @csrf
                            <div class="cert-layout">
                                <div class="cert-panel" style="padding:16px;display:grid;gap:12px">
                                    <div>
                                        <label style="font-weight:700;color:#0f3b8f">Certificate Name</label>
                                        <input type="text" name="name" placeholder="Certificate Name" class="pro-input" required>
                                    </div>
                                    <div>
                                        <label style="font-weight:700;color:#0f3b8f">Certificate Type</label>
                                        <select name="category" class="pro-input" required>
                                            <option value="">Select type</option>
                                            <option>Core Governance & Administration</option>
                                            <option>Finance & Compliance</option>
                                            <option>Digital Transformation</option>
                                            <option>ICT & Technical Skills</option>
                                            <option>Human Capital & Leadership</option>
                                            <option>Community & Development Planning</option>
                                            <option>Economic & Business Development</option>
                                            <option>Social Governance</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="font-weight:700;color:#0f3b8f">Template Mode</label>
                                        <div style="display:flex;gap:12px;flex-wrap:wrap">
                                            <label style="display:inline-flex;align-items:center;gap:8px">
                                                <input type="radio" name="certMode" id="certModeStandard" value="standard" checked> Use Standard Certificate
                                            </label>
                                            <label style="display:inline-flex;align-items:center;gap:8px">
                                                <input type="radio" name="certMode" id="certModeCustom" value="custom"> Create a New One
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label style="font-weight:700;color:#0f3b8f">Upload Certificate</label>
                                        <div class="dz" id="certUploadZone">
                                            <div style="margin-bottom:8px;color:#6b7280">Drag & drop PDF/PNG/JPG/DOCX or click to browse</div>
                                            <input id="certTemplateInput" type="file" name="file" accept=".pdf,.docx,image/png,image/jpeg,image/jpg" style="width:100%">
                                            <div style="margin-top:8px;color:#6b7280;font-size:.85rem">Max 10MB</div>
                                        </div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                        <div>
                                            <label style="font-weight:700;color:#0f3b8f">Recipient Name</label>
                                            <input id="certName" type="text" class="pro-input" placeholder="FULLNAME SAMPLE" value="FULLNAME SAMPLE">
                                        </div>
                                        <div>
                                            <label style="font-weight:700;color:#0f3b8f">Course / Training</label>
                                            <input id="certCourse" type="text" class="pro-input" placeholder="COURSE NAME SAMPLE" value="COURSE NAME SAMPLE">
                                        </div>
                                        <div>
                                            <label style="font-weight:700;color:#0f3b8f">Completion Date</label>
                                            <input id="certDate" type="date" class="pro-input" value="">
                                        </div>
                                        <div>
                                            <label style="font-weight:700;color:#0f3b8f">Certificate Number</label>
                                            <input id="certNumber" type="text" class="pro-input" placeholder="CERT-0000" value="CERT-0000">
                                        </div>
                                    </div>
                                    <div id="certControlsBox" style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px">
                                        <div><label>Name X</label><input id="posNameX" class="pro-input" type="number" value="320"></div>
                                        <div><label>Name Y</label><input id="posNameY" class="pro-input" type="number" value="285"></div>
                                        <div><label>Name Size</label><input id="fontName" class="pro-input" type="number" value="80"></div>
                                        <div></div>
                                        <div><label>Course X</label><input id="posCourseX" class="pro-input" type="number" value="365"></div>
                                        <div><label>Course Y</label><input id="posCourseY" class="pro-input" type="number" value="465"></div>
                                        <div><label>Course Size</label><input id="fontCourse" class="pro-input" type="number" value="60"></div>
                                        <div></div>
                                        <div><label>No. X</label><input id="posNumberX" class="pro-input" type="number" value="1120"></div>
                                        <div><label>No. Y</label><input id="posNumberY" class="pro-input" type="number" value="812"></div>
                                        <div><label>No. Size</label><input id="fontNumber" class="pro-input" type="number" value="25"></div>
                                        <div></div>
                                        <div><label>Date X</label><input id="posDateX" class="pro-input" type="number" value="1120"></div>
                                        <div><label>Date Y</label><input id="posDateY" class="pro-input" type="number" value="840"></div>
                                        <div><label>Date Size</label><input id="fontDate" class="pro-input" type="number" value="25"></div>
                                        <div></div>
                                    </div>
                                    <div style="display:flex;justify-content:flex-end;gap:8px">
                                        <button type="reset" class="btn-pill">Cancel</button>
                                        <button type="submit" class="btn-pill btn-blue">Create Certificate</button>
                                    </div>
                                </div>
                                <div class="cert-panel sticky-preview">
                                    <div class="cert-preview-head">
                                        <span>Live Preview</span>
                                        <a id="btnDownloadFinal" href="#" class="btn-pill btn-blue">Download Final</a>
                                    </div>
                                    <div id="certPreviewBox" class="cert-preview-box">
                                        <img id="certBg" alt="Template" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:none">
                                        <canvas id="certCanvas" style="position:absolute;inset:0;width:100%;height:100%;display:none"></canvas>
                                        <div id="ovName" style="position:absolute;left:30%;top:23%;transform:translateX(-0%);font-weight:800;font-size:2.2vw;color:#0b1e3a;white-space:nowrap;max-width:80%;overflow:hidden;text-overflow:ellipsis"></div>
                                        <div id="ovCourse" style="position:absolute;left:30%;top:33%;transform:translateX(-0%);font-weight:700;font-size:1.8vw;color:#0b1e3a;white-space:nowrap;max-width:80%;overflow:hidden;text-overflow:ellipsis"></div>
                                        <div id="ovNumber" style="position:absolute;left:79%;top:55%;font-weight:700;font-size:1.1vw;color:#0b1e3a;white-space:nowrap"></div>
                                        <div id="ovDate" style="position:absolute;left:79%;top:59%;font-weight:700;font-size:1.1vw;color:#0b1e3a;white-space:nowrap"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="certPaneView" style="display:none;padding:16px">
                        @if($certifications->isEmpty())
                            <div class="cert-empty"><i class="fas fa-certificate" style="font-size:2rem"></i><span>No Certifications Added Yet</span></div>
                        @else
                            <div id="certListWrapper">
                            <div class="cert-grid">
                                @foreach($certifications as $cert)
                                <div class="cert-card" style="position:relative">
                                    <div class="cert-card-head">
                                        <button class="kebab" type="button" onclick="toggleCertMenu({{ $cert->id }})"><i class="fas fa-ellipsis-v"></i></button>
                                        <div id="menu-{{ $cert->id }}" class="menu">
                                            <a href="{{ route('certifications.download', $cert->id) }}"><i class="fas fa-download"></i> Download</a>
                                            <form action="{{ route('certifications.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Delete this certificate?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    @php
                                        $ext = strtolower(pathinfo($cert->file_path ?? '', PATHINFO_EXTENSION));
                                    @endphp
                                    <div style="padding:14px 16px;border-top:1px solid #eef2f7">
                                        @if(in_array($ext, ['png','jpg','jpeg']))
                                            <img src="{{ route('certifications.download', ['certification'=>$cert->id, 'inline'=>1]) }}" alt="Certificate Template" style="width:100%;height:160px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;cursor:pointer" onclick="openCertImagePreview('{{ route('certifications.download', ['certification'=>$cert->id, 'inline'=>1]) }}')">
                                        @else
                                            <div class="cert-empty" style="gap:12px;flex-direction:column">
                                                <i class="fas fa-file-pdf" style="font-size:2rem;color:#0f3b8f"></i>
                                                <div style="color:#64748b">Template: {{ strtoupper($ext ?: 'FILE') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cert-meta">
                                        <div class="cert-title" style="font-size:1rem">{{ $cert->name }}</div>
                                        <span class="cert-chip">{{ $cert->category ?? 'â€”' }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </div>
                        @endif
                        <div id="certInlinePreview" style="display:none">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                                <button type="button" class="btn-pill" onclick="closeCertImagePreview()"><i class="fas fa-arrow-left"></i> Back</button>
                                <div style="font-weight:800;color:#0f3b8f">Preview</div>
                                <div style="width:120px"></div>
                            </div>
                            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;box-shadow:0 8px 20px rgba(2,6,23,.06);padding:12px">
                                <img id="certInlineImg" alt="Certificate Preview" style="display:block;width:100%;height:auto;border-radius:8px">
                            </div>
                        </div>
                    </div>
                    <div id="certPaneCertify" style="display:none;padding:16px">
                        <div class="cert-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr));">
                            @foreach($courses as $course)
                            <a href="{{ route('admin.certifications.course', $course) }}" style="text-decoration:none;color:inherit">
                                <div class="cert-card">
                                    @php $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp; @endphp
                                    @php
                                        $img = null;
                                        if (!empty($course->image_path)) {
                                            $path = public_path('storage/' . $course->image_path);
                                            if (file_exists($path)) {
                                                $img = asset('storage/' . $course->image_path) . '?v=' . $ver;
                                            }
                                        }
                                        if (!$img) { $img = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="160" viewBox="0 0 300 160"><rect width="300" height="160" rx="18" fill="#eef4ff"/><path d="M104 62h92a10 10 0 0 1 10 10v16a10 10 0 0 1-10 10h-92a10 10 0 0 1-10-10V72a10 10 0 0 1 10-10Z" fill="#dbe7fb"/><circle cx="122" cy="80" r="12" fill="#93c5fd"/><path d="M116 108l22-21 18 16 18-24 28 29H116Z" fill="#bfdbfe"/><text x="150" y="138" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="16" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 22, '')) . '</text></svg>'); }
                                        if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) { $img = $course->image_path; }
                                        $ph = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 28, '')) . '</text></svg>');
                                    @endphp
                                    <img src="{{ $img }}" alt="{{ $course->name }}" style="width:100%;height:120px;object-fit:cover" onerror="this.onerror=null;this.src='{{ $ph }}'">
                                    <div class="cert-card-head" style="border:none">
                                        <div class="cert-title">{{ $course->name }}</div>
                                        <span class="cert-chip">{{ $course->subject_area ?? 'Uncategorized' }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="certImgModal" class="cert-img-modal" onclick="closeCertImagePreview()">
                    <div class="box">
                        <img id="certImgModalImg" alt="Certificate Preview">
                    </div>
                </div>
            </section>

            <!-- Course Library Section -->
            <section id="course-library" class="content-section {{ request('tab') == 'course-library' ? 'active' : '' }}">
                <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <h2 style="margin: 0; color: #002C76; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-layer-group" style="color: #10b981;"></i> Course Library
                            </h2>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="position: relative; width: 300px;">
                                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                                    <input type="text" id="librarySearchInput" onkeyup="filterLibraryCourses()" placeholder="Search library..." style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; transition: border-color 0.2s ease;">
                                </div>
                                <div style="position: relative; width: 220px;">
                                    <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                                    <select id="academicYearFilter" onchange="filterByAcademicYear(this.value)" style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-weight: 500; outline: none; appearance: none; background: #fff; cursor: pointer;">
                                        <option value="all" {{ $selectedYearId === 'all' ? 'selected' : '' }}>All Academic Years</option>
                                        @foreach($academicYears as $ay)
                                            <option value="{{ $ay->id }}" {{ $selectedYearId == $ay->id ? 'selected' : '' }}>
                                                {{ $ay->year_start }} - {{ $ay->year_end }} {{ $ay->is_active ? '(Active)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn" onclick="showContent('course-management', document.querySelector('.menu-item[onclick*=\'course-management\']'))" style="background: #f1f5f9; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Back to Management
                        </button>
                    </div>
                    <div style="padding: 24px; min-height: 60vh; background: #f8fafc;">
                        @if(session('success_course'))
                            <div style="background-color: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bbf7d0; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-check-circle"></i> {{ session('success_course') }}
                            </div>
                        @endif
                        @if(session('error_course'))
                            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #fecaca; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error_course') }}
                            </div>
                        @endif
                        <div id="courseLibraryContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                            @foreach($courses as $course)
                                @php
                                    $img = null;
                                    if (!empty($course->image_path)) {
                                        $path = public_path('storage/' . $course->image_path);
                                        if (file_exists($path)) { $img = asset('storage/' . $course->image_path); }
                                    }
                                    if (!$img) {
                                        $img = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="160" viewBox="0 0 300 160"><rect width="300" height="160" rx="18" fill="#eef4ff"/><text x="150" y="80" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="14" font-weight="700">' . e(\Illuminate\Support\Str::limit($course->name, 22, '')) . '</text></svg>');
                                    }
                                @endphp
                                <div class="library-course-item" data-name="{{ strtolower($course->name) }}" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.2s ease; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);" onclick="openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null), 'created_at' => optional($course->created_at)->format('M d, Y')]) }})">
                                    <div style="position: relative;">
                                        <img src="{{ $img }}" style="width: 100%; height: 160px; object-fit: cover;">
                                        <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; color: #10b981; border: 1px solid #10b981;">
                                            ACTIVE
                                        </div>
                                    </div>
                                    <div style="padding: 16px;">
                                        <h3 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 800; line-height: 1.4;">{{ $course->name }}</h3>
                                        <p style="margin: 8px 0 0; font-size: 0.85rem; color: #64748b; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
                                        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">{{ optional($course->created_at)->format('M Y') }}</span>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <button type="button" onclick="event.stopPropagation(); openCloneCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name]) }})" style="background: #fff; color: #10b981; border: 1.5px solid #10b981; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s;">
                                                    <i class="fas fa-clone"></i> Clone
                                                </button>
                                                <span style="font-size: 0.8rem; color: #2563eb; font-weight: 700;">View Details <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Course View Details Section -->
            <section id="course-view-details" class="content-section">
                <div class="course-view-header">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                <span id="view_course_category_badge" style="background: #eef2ff; color: #2563eb; padding: 4px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Category</span>
                                <span id="view_course_status_badge" style="background: #ecfdf5; color: #10b981; padding: 4px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">Active</span>
                            </div>
                            <h1 id="pro_view_course_name" style="margin: 0; font-size: 2.25rem; font-weight: 800; color: #0f172a; line-height: 1.2;">Course Title</h1>
                            <div style="display: flex; align-items: center; gap: 24px; margin-top: 16px; color: #64748b; font-size: 0.9rem; font-weight: 500;">
                                <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-user-edit"></i> <span id="pro_view_course_creator">Admin</span></span>
                                <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-calendar-alt"></i> <span id="pro_view_course_date">Mar 18, 2026</span></span>
                                <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-certificate" style="color: #f59e0b;"></i> <span id="pro_view_course_cert">Certificate Enabled</span></span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <button type="button" class="btn" onclick="showContent('course-library')" style="background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button id="pro_view_edit_btn" type="button" class="btn" style="background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 10px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-edit"></i> Edit Course
                            </button>
                        </div>
                    </div>

                    <div class="course-view-nav">
                        <div class="course-nav-item active" onclick="switchCourseViewTab('overview', this)">Overview</div>
                        <div class="course-nav-item" onclick="switchCourseViewTab('modules', this)">Curriculum</div>
                        <div class="course-nav-item" onclick="switchCourseViewTab('exams', this)">Exams & Assessments</div>
                        <div class="course-nav-item" onclick="switchCourseViewTab('certificate', this)">Certificate</div>
                        <div class="course-nav-item" onclick="switchCourseViewTab('settings', this)">Settings</div>
                    </div>
                </div>

                <div style="padding: 0 40px 40px;">
                    <!-- Overview Tab -->
                    <div id="course-tab-overview" class="course-tab-content">
                        <div class="course-content-grid">
                            <div class="course-main-card">
                                <h3 style="margin: 0 0 20px; font-size: 1.25rem; font-weight: 800; color: #1e293b;">About this Course</h3>
                                <div id="pro_view_course_desc" style="font-size: 1.05rem; color: #475569; line-height: 1.7; white-space: pre-wrap;"></div>
                                
                                <div style="margin-top: 40px;">
                                    <h3 style="margin: 0 0 20px; font-size: 1.25rem; font-weight: 800; color: #1e293b;">Course Materials</h3>
                                    <div id="pro_view_materials_list" style="display: flex; flex-wrap: wrap; gap: 12px;">
                                        <!-- Materials tags injected here -->
                                    </div>
                                </div>
                            </div>
                            <div class="course-side-card">
                                <img id="pro_view_course_image" src="" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <p style="margin: 0; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Subject Area</p>
                                        <p id="pro_view_course_subject" style="margin: 4px 0 0; font-size: 0.95rem; font-weight: 700; color: #1e293b;"></p>
                                    </div>
                                    <div style="padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <p style="margin: 0; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Certification</p>
                                        <p id="pro_view_course_certification" style="margin: 4px 0 0; font-size: 0.95rem; font-weight: 700; color: #1e293b;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modules Tab -->
                    <div id="course-tab-modules" class="course-tab-content" style="display: none;">
                        <div style="max-width: 900px; margin: 0 auto;">
                            <div id="pro_view_modules_container">
                                <!-- Modules injected here -->
                            </div>
                        </div>
                    </div>

                    <!-- Exams Tab -->
                    <div id="course-tab-exams" class="course-tab-content" style="display: none;">
                        <div class="course-main-card" style="max-width: 900px; margin: 0 auto;">
                            <div id="pro_view_exams_container">
                                <div style="text-align: center; padding: 40px; color: #64748b;">
                                    <i class="fas fa-clipboard-list" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                                    <p style="font-weight: 600;">Course assessments and final exams will appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Tab -->
                    <div id="course-tab-certificate" class="course-tab-content" style="display: none;">
                        <div class="course-main-card" style="max-width: 900px; margin: 0 auto; text-align: center;">
                            <h3 style="margin: 0 0 24px; font-size: 1.25rem; font-weight: 800; color: #1e293b;">Course Certificate</h3>
                            <div id="pro_view_certificate_preview" style="padding: 40px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px;">
                                <div id="pro_view_certificate_body">
                                    <i class="fas fa-certificate" style="font-size: 4rem; color: #f59e0b; margin-bottom: 20px;"></i>
                                    <h4 id="pro_view_cert_name" style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a;">Certificate of Completion</h4>
                                    <p style="color: #64748b; margin-top: 12px; font-weight: 500;">Awarded upon successful completion of all course modules and assessments.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Tab -->
                    <div id="course-tab-settings" class="course-tab-content" style="display: none;">
                        <div class="course-main-card" style="max-width: 900px; margin: 0 auto;">
                            <h3 style="margin: 0 0 24px; font-size: 1.25rem; font-weight: 800; color: #1e293b;">Advanced Settings</h3>
                            <!-- Add settings like visibility, archive, etc. -->
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                                    <div>
                                        <p style="margin: 0; font-weight: 700; color: #1e293b;">Course Visibility</p>
                                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">Control whether participants can find this course.</p>
                                    </div>
                                    <span id="pro_view_course_visibility_badge" style="background: #ecfdf5; color: #10b981; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">PUBLIC</span>
                                </div>

                                <div id="pro_view_archive_section" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                                    <div>
                                        <p id="pro_view_archive_title" style="margin: 0; font-weight: 700; color: #1e293b;">Archive Course</p>
                                        <p id="pro_view_archive_desc" style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">Archived courses are hidden from participants but can be restored later.</p>
                                    </div>
                                    <form id="pro_view_archive_form" method="POST" action="">
                                        @csrf
                                        <input type="hidden" name="_method" id="pro_view_archive_method" value="DELETE">
                                        <button type="submit" id="pro_view_archive_btn" class="btn" style="background: #f8fafc; border: 1.5px solid #e2e8f0; color: #64748b; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                                            <i class="fas fa-archive" style="margin-right: 6px;"></i> Archive Course
                                        </button>
                                    </form>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 12px;">
                                    <div>
                                        <p style="margin: 0; font-weight: 700; color: #991b1b;">Delete Course</p>
                                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: #b91c1c;">Permanently remove this course and all its data. This action cannot be undone.</p>
                                    </div>
                                    <form id="pro_view_delete_form" method="POST" action="" onsubmit="return confirm('PERMANENTLY DELETE this course? This will remove all modules, assessments, and participant progress. THIS ACTION CANNOT BE UNDONE.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="background: #ef4444; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);">
                                            <i class="fas fa-trash-can" style="margin-right: 6px;"></i> Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Profile Section -->
            <section id="profile-section" class="content-section">
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

                                <div id="profile_upload_container" class="profile-page-upload" style="display: none;">
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/png,image/jpeg,.png,.jpg,.jpeg" onchange="previewProfileImage(this)">
                                    <span class="profile-page-help">PNG or JPEG only, up to 5 MB. Square crop works best.</span>
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
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                                                <path d="M7 11h10M7 15h10"></path>
                                            </svg>
                                            Account ID
                                        </label>
                                        <div class="profile-input" style="display: flex; align-items: center; background: #f1f5f9; color: #475569; cursor: not-allowed;">{{ Auth::user()->status === 'pending' ? 'N/A' : (Auth::user()->account_id ?? 'N/A') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <circle cx="12" cy="7" r="4"></circle>
                                                <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                                            </svg>
                                            Full Name
                                        </label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M3 6h18v12H3z"></path>
                                                <polyline points="3,7 12,13 21,7"></polyline>
                                            </svg>
                                            Email Address
                                        </label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <label class="profile-field-label" style="display:none">Job Title</label>
                                        <input type="hidden" name="job_title" value="">
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
                                @php
                                    $profileRegion = old('region', Auth::user()->region);
                                    $profileProvince = old('province', Auth::user()->province);
                                    $profileCity = old('city', Auth::user()->city);
                                    $profileBarangay = old('barangay', Auth::user()->barangay);
                                @endphp
                                <div class="profile-page-fields">
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            Region
                                        </label>
                                        <select id="profile_region" name="region" class="profile-input" data-selected="{{ $profileRegion }}" disabled>
                                            <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>Select Region</option>
                                            @if($profileRegion)
                                                <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <polygon points="1,6 1,22 8,19 16,22 23,19 23,3 16,6 8,3 1,6"></polygon>
                                                <line x1="8" y1="3" x2="8" y2="19"></line>
                                                <line x1="16" y1="6" x2="16" y2="22"></line>
                                            </svg>
                                            Province
                                        </label>
                                        <select id="profile_province" name="province" class="profile-input" data-selected="{{ $profileProvince }}" disabled>
                                            <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>Select Province</option>
                                            @if($profileProvince)
                                                <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <polygon points="3,11 22,2 13,21 11,13 3,11"></polygon>
                                            </svg>
                                            City / Municipality
                                        </label>
                                        <select id="profile_city" name="city" class="profile-input" data-selected="{{ $profileCity }}" disabled>
                                            <option value="" disabled {{ $profileCity ? '' : 'selected' }}>Select City/Municipality</option>
                                            @if($profileCity)
                                                <option value="{{ $profileCity }}" selected>{{ $profileCity }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M3 10.5 12 3l9 7.5"></path>
                                                <path d="M5 9.5V21h14V9.5"></path>
                                            </svg>
                                            Barangay
                                        </label>
                                        <select id="profile_barangay" name="barangay" class="profile-input" data-selected="{{ $profileBarangay }}" disabled>
                                            <option value="" disabled {{ $profileBarangay ? '' : 'selected' }}>Select Barangay</option>
                                            @if($profileBarangay)
                                                <option value="{{ $profileBarangay }}" selected>{{ $profileBarangay }}</option>
                                            @endif
                                        </select>
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
                    </div>
                </form>
            </section>
    <!-- Landing Page Display Section -->
    <section id="landing-page-display-section" class="content-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="color: var(--primary-blue); margin: 0;">Landing Page Display Details</h1>
            <button onclick="showContent('user-management', document.querySelector('.menu-item[onclick*=\'user-management\']'))" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                <i class="fas fa-arrow-left"></i> Back to Users
            </button>
        </div>

        <div class="card">
            <h2 style="color: var(--primary-blue); margin-top: 0; margin-bottom: 20px;" id="display_user_name_header">Edit Display Details</h2>
            
            <form id="landingPageDisplayForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="display_user_id" name="user_id">
                
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
                    <!-- Left Column: Image -->
                    <div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <div style="margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <img id="display_image_preview" src="" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                <div id="display_image_placeholder" style="text-align: center; color: #999;">
                                    <i class="fas fa-user-circle" style="font-size: 5rem; margin-bottom: 10px;"></i>
                                    <p>No image selected</p>
                                </div>
                            </div>
                            <input type="file" name="profile_picture" id="display_profile_picture" accept="image/*" onchange="previewDisplayImage(this)">
                            <small style="color: #666;">Recommended size: 500x500px or square ratio</small>
                        </div>
                    </div>
                    
                    <!-- Right Column: Details -->
                    <div>
                        <div class="form-group">
                            <label>Additional Details (Short Bio)</label>
                            <textarea id="display_additional_details" name="additional_details" rows="3" placeholder="Brief professional summary..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Display Section</label>
                            <select id="display_type" name="display_type" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                <option value="">Select Section</option>
                                <option value="our_team">Our Team</option>
                                <option value="past_trainees">Past Trainees</option>
                            </select>
                        </div>
                        
                        <div style="text-align: right; margin-top: 20px;">
                            <button type="button" onclick="removeDisplayDetails()" class="btn-update" style="background-color: #dc3545; margin-right: 10px;">
                                <i class="fas fa-trash"></i> Remove Display
                            </button>
                            <button type="submit" class="btn-update" style="background-color: var(--primary-green);">
                                <i class="fas fa-save"></i> Save Display Details
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
        </main>
    </div>



    <!-- Clone Course Modal -->
    <div id="cloneCourseModal" class="modal">
        <div class="modal-content" style="width: 450px; padding: 0; overflow: hidden; border: none; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="padding: 20px 24px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #002C76; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-clone" style="color: #10b981;"></i> Clone Course
                </h3>
                <span class="close" onclick="closeCloneCourseModal()" style="font-size: 1.25rem; color: #94a3b8; cursor: pointer;">&times;</span>
            </div>
            <form id="cloneCourseForm" method="POST" action="{{ route('admin.courses.clone') }}" style="padding: 24px;">
                @csrf
                <input type="hidden" id="clone_course_id" name="course_id">
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Source Course</label>
                    <input type="text" id="clone_course_name" readonly style="width: 100%; padding: 10px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; background: #f8fafc; color: #475569; font-weight: 600; font-size: 0.95rem; cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Target Academic Year</label>
                    <div style="position: relative;">
                        <i class="fas fa-calendar-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                        <select name="target_academic_year_id" required style="width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; font-weight: 600; outline: none; appearance: none; background: #fff; cursor: pointer;">
                            <option value="" disabled selected>Select Target Year</option>
                            @foreach($academicYears as $ay)
                                <option value="{{ $ay->id }}">
                                    {{ $ay->year_start }} - {{ $ay->year_end }} {{ $ay->is_active ? '(Active)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;"></i>
                    </div>
                </div>

                <div style="margin-bottom: 24px; background: #f1f5f9; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <p style="margin: 0 0 12px; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Cloning Options</p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none;">
                            <input type="checkbox" name="copy_modules" checked value="1" style="width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid #cbd5e1; accent-color: #10b981;">
                            <span style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">Copy all modules</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none;">
                            <input type="checkbox" name="copy_lessons" checked value="1" style="width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid #cbd5e1; accent-color: #10b981;">
                            <span style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">Copy all lessons/content</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none;">
                            <input type="checkbox" name="copy_assessments" checked value="1" style="width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid #cbd5e1; accent-color: #10b981;">
                            <span style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">Copy assessments/quizzes</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; margin-top: 4px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
                            <input type="checkbox" name="set_active" value="1" style="width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid #cbd5e1; accent-color: #10b981;">
                            <span style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">Set as Active Course</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="button" onclick="closeCloneCourseModal()" style="flex: 1; padding: 12px; border-radius: 10px; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; font-weight: 700; cursor: pointer; transition: all 0.2s;">Cancel</button>
                    <button type="submit" style="flex: 2; padding: 12px; border-radius: 10px; border: none; background: #10b981; color: #fff; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2); transition: all 0.2s;">Clone Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View/Edit User Modal -->
    <div id="viewUserModal" class="modal">
        <div class="modal-content profile-edit-modal">
            <span class="close" onclick="closeViewModal()">&times;</span>
            <div class="profile-edit-header">
                <div class="profile-edit-headline">
                    <div class="profile-user-brief">
                        <span id="modalUserInitial" class="profile-user-avatar">U</span>
                        <div class="profile-user-meta">
                            <h2 id="modalTitle" class="profile-edit-title">User Details</h2>
                            <p id="modalUserEmail" class="profile-user-email">-</p>
                        </div>
                    </div>
                    <div class="profile-meta-badges">
                        <span id="modalRoleBadge" class="profile-meta-chip role" data-role="">
                            <span class="chip-label">Role</span>
                            <span class="chip-value">-</span>
                        </span>
                        <span id="modalStatusBadge" class="profile-meta-chip status" data-status="">
                            <span class="chip-label">Status</span>
                            <span class="chip-value">-</span>
                        </span>
                    </div>
                </div>
                <div class="profile-edit-subrow">
                    <p id="modalSubtitle" class="profile-edit-subtitle">Switch to edit mode to update account information and access settings.</p>
                    <div class="profile-header-actions">
                        <button type="button" id="btnEdit" onclick="enableEditMode()" class="modal-action-btn modal-action-edit" title="Edit user" aria-label="Edit user">
                            <svg class="modal-action-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                            </svg>
                        </button>
                        <button type="button" id="btnCancel" onclick="disableEditMode()" class="modal-action-btn modal-action-cancel" style="display: none;" title="Cancel edit" aria-label="Cancel edit">
                            <svg class="modal-action-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                        <button type="button" id="btnUpdate" onclick="submitUpdate()" class="modal-action-btn modal-action-update" style="display: none;" title="Update user" aria-label="Update user">
                            <svg class="modal-action-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <form id="viewUserForm" class="profile-edit-form" method="POST">
                @csrf
                @method('PUT')

                @php
                    $roleNamesForAccess = isset($roles) ? $roles->pluck('name')->all() : [];
                    $pickAccessRole = function (array $candidates, string $fallback) use ($roleNamesForAccess) {
                        foreach ($candidates as $candidate) {
                            if (in_array($candidate, $roleNamesForAccess, true)) {
                                return $candidate;
                            }
                        }
                        return $fallback;
                    };
                    $adminAccessRole = $pickAccessRole(['admin', 'central_office_admin', 'regional_office_admin', 'provincial_office_admin', 'registrar'], 'admin');
                    $managerAccessRole = $pickAccessRole(['training_manager', 'central_office_training_manager', 'regional_office_training_manager', 'provincial_office_training_manager'], 'training_manager');
                    $coachAccessRole = $pickAccessRole(['trainer', 'coach', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach'], 'trainer');
                    $participantAccessRole = $pickAccessRole(['participant', 'trainee', 'central_office_participants', 'regional_office_participants', 'provincial_office_participants'], 'participant');
                @endphp
                <div class="modal-tabs" role="tablist" style="display:flex;gap:8px;border-bottom:1px solid #e5e7eb;margin:8px 0 14px;">
                    <button type="button" class="modal-tab" data-target="section-core" aria-selected="false" style="border:none;background:none;padding:10px 14px;border-bottom:2px solid transparent;color:#64748b;font-weight:700;border-radius:8px 8px 0 0;">Core Profile</button>
                    <button type="button" class="modal-tab active" data-target="section-roles" aria-selected="true" style="border:none;background:none;padding:10px 14px;border-bottom:2px solid var(--primary-blue);color:var(--primary-blue);font-weight:700;border-radius:8px 8px 0 0;">Roles</button>
                    <button type="button" class="modal-tab" data-target="section-permissions" aria-selected="false" style="border:none;background:none;padding:10px 14px;border-bottom:2px solid transparent;color:#64748b;font-weight:700;border-radius:8px 8px 0 0;">Permissions</button>
                    <button type="button" class="modal-tab" data-target="section-location" aria-selected="false" style="border:none;background:none;padding:10px 14px;border-bottom:2px solid transparent;color:#64748b;font-weight:700;border-radius:8px 8px 0 0;">Location Details</button>
                    <button type="button" class="modal-tab" data-target="section-security" aria-selected="false" style="border:none;background:none;padding:10px 14px;border-bottom:2px solid transparent;color:#64748b;font-weight:700;border-radius:8px 8px 0 0;">Security</button>
                </div>

                <div id="section-core" class="profile-section" style="display:none;">
                    <p class="profile-section-title">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="7" r="4"></circle>
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                        </svg>
                        Core Profile
                    </p>
                    <div class="profile-edit-grid">
                        <div class="form-group">
                            <label>Name</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="7" r="4"></circle>
                                    <path d="M5.5 21a6.5 6.5 0 0 1 13 0"></path>
                                </svg>
                                <input type="text" id="view_name" name="name" required disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 6h18v12H3z"></path>
                                    <polyline points="3,7 12,13 21,7"></polyline>
                                </svg>
                                <input type="email" id="view_email" name="email" required disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"></polyline>
                                </svg>
                                <select id="view_status" name="status" required disabled>
                                    <option value="active">Active</option>
                                    <option value="freeze">Blocked</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="section-roles" class="profile-section" style="display:block;">
                    <p class="profile-section-title">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        Roles
                    </p>
                    <input type="hidden" id="view_role" name="role" value="{{ $coachAccessRole }}">
                    <div class="role-choice-grid">
                        <label class="role-choice-card role-admin" data-role-value="{{ $adminAccessRole }}">
                            <input type="radio" class="role-choice-input" name="view_role_choice" value="{{ $adminAccessRole }}" disabled>
                            <span class="role-choice-indicator" aria-hidden="true"></span>
                            <span class="role-choice-copy">
                                <span class="role-choice-title">Admin</span>
                                <span class="role-choice-desc">
                                    • Manage users and access levels<br>
                                    • Configure system settings and security<br>
                                    • Monitor platform activity and audit logs<br>
                                    • Handle data backups and maintenance
                                </span>
                            </span>
                        </label>
                        <label class="role-choice-card role-tm" data-role-value="{{ $managerAccessRole }}">
                            <input type="radio" class="role-choice-input" name="view_role_choice" value="{{ $managerAccessRole }}" disabled>
                            <span class="role-choice-indicator" aria-hidden="true"></span>
                            <span class="role-choice-copy">
                                <span class="role-choice-title">Training Manager</span>
                                <span class="role-choice-desc">
                                    • Create and manage course content<br>
                                    • Assign coaches and participants<br>
                                    • Review and approve training modules<br>
                                    • Generate progress and impact reports
                                </span>
                            </span>
                        </label>
                        <label class="role-choice-card role-coach" data-role-value="{{ $coachAccessRole }}">
                            <input type="radio" class="role-choice-input" name="view_role_choice" value="{{ $coachAccessRole }}" disabled>
                            <span class="role-choice-indicator" aria-hidden="true"></span>
                            <span class="role-choice-copy">
                                <span class="role-choice-title">Coach</span>
                                <span class="role-choice-desc">
                                    • Guide learners and facilitate modules<br>
                                    • Grade assessments and provide feedback<br>
                                    • Track individual participant progress<br>
                                    • Moderate learning discussions
                                </span>
                            </span>
                        </label>
                        <label class="role-choice-card role-participant" data-role-value="{{ $participantAccessRole }}">
                            <input type="radio" class="role-choice-input" name="view_role_choice" value="{{ $participantAccessRole }}" disabled>
                            <span class="role-choice-indicator" aria-hidden="true"></span>
                            <span class="role-choice-copy">
                                <span class="role-choice-title">Participant</span>
                                <span class="role-choice-desc">
                                    • Access and complete training modules<br>
                                    • Participate in assessments and exercises<br>
                                    • Track personal learning achievements<br>
                                    • Engage with coaches and peers
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                <div id="section-permissions" class="profile-section" style="display:none;">
                    @php
                        $systemGroups = [
                            'admin' => [
                                'id' => 'system-admin',
                                'title' => 'Admin System',
                                'badge' => 'Admin',
                                'class' => 'group-admin',
                                'desc' => 'Manage user accounts, courses, and overall system security.',
                                'groups' => [
                                    'User Management' => [
                                        'desc' => 'Manage users, approvals, roles, activation, and blocking',
                                        'actions' => [
                                            'view' => ['perm' => 'view_users', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'create_users', 'allowed' => true, 'chosen' => false],
                                            'update' => ['perm' => 'edit_users', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_users', 'allowed' => true, 'chosen' => false]
                                        ]
                                    ],
                                    'Course Management' => [
                                        'desc' => 'Manage course creation, editing, archiving, and trainer assignment',
                                        'actions' => [
                                            'view' => ['perm' => 'view_courses', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'create_courses', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'edit_courses', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_courses', 'allowed' => true, 'chosen' => false]
                                        ]
                                    ],
                                    'Certification Management' => [
                                        'desc' => 'Manage certificate templates and issuance',
                                        'actions' => [
                                            'view' => ['perm' => 'view_certifications', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'create_certifications', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'edit_certifications', 'allowed' => true, 'chosen' => false],
                                            'delete' => ['perm' => 'delete_certifications', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'System Monitoring' => [
                                        'desc' => 'Monitor dashboards, active users, and system activity',
                                        'actions' => [
                                            'view' => ['perm' => 'view_monitoring', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Access Control' => [
                                        'desc' => 'Manage permissions and role access control',
                                        'actions' => [
                                            'view' => ['perm' => 'view_access_control', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'edit_access_control', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                ]
                            ],
                            'tm' => [
                                'id' => 'system-tm',
                                'title' => 'Training Manager System',
                                'badge' => 'Training Manager',
                                'class' => 'group-tm',
                                'desc' => 'Oversee training enrollments, course status, and activity reports.',
                                'groups' => [
                                    'User Management' => [
                                        'desc' => 'Approve, reject, and review users',
                                        'actions' => [
                                            'view' => ['perm' => 'view_users_tm', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_users_tm', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Training Management' => [
                                        'desc' => 'Enroll participants, remove participants, and assign users to courses',
                                        'actions' => [
                                            'view' => ['perm' => 'view_training', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_training', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_training', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_training', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Course Monitoring' => [
                                        'desc' => 'View course status and readiness tracking',
                                        'actions' => [
                                            'view' => ['perm' => 'view_course_monitoring', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Reports & Logs' => [
                                        'desc' => 'View activity logs and monitor user actions',
                                        'actions' => [
                                            'view' => ['perm' => 'view_reports', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ]
                                ]
                            ],
                            'coach' => [
                                'id' => 'system-coach',
                                'title' => 'Coach System',
                                'badge' => 'Coach',
                                'class' => 'group-coach',
                                'desc' => 'Manage assigned courses, upload materials, and track student progress.',
                                'groups' => [
                                    'Course Management' => [
                                        'desc' => 'Create courses, edit assigned courses, and upload materials',
                                        'actions' => [
                                            'view' => ['perm' => 'view_courses_coach', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_courses_coach', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_courses_coach', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Class Management' => [
                                        'desc' => 'Manage schedules and handle sessions',
                                        'actions' => [
                                            'view' => ['perm' => 'view_classes', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_classes', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_classes', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_classes', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Student Monitoring' => [
                                        'desc' => 'Track student progress and view enrolled students',
                                        'actions' => [
                                            'view' => ['perm' => 'view_students', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_students', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Communication' => [
                                        'desc' => 'Post announcements and notify students',
                                        'actions' => [
                                            'view' => ['perm' => 'view_communication', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_communication', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_communication', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_communication', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ]
                                ]
                            ],
                            'participant' => [
                                'id' => 'system-participant',
                                'title' => 'Participant System',
                                'badge' => 'Participant',
                                'class' => 'group-participant',
                                'desc' => 'Access training modules, complete assessments, and track learning progress.',
                                'groups' => [
                                    'Module Access' => [
                                        'desc' => 'Access training modules and complete exercises',
                                        'actions' => [
                                            'view' => ['perm' => 'view_modules', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Assessments' => [
                                        'desc' => 'Take assessments and view results',
                                        'actions' => [
                                            'view' => ['perm' => 'view_assessments', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_assessments', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Learning Progress' => [
                                        'desc' => 'Track personal achievements and course status',
                                        'actions' => [
                                            'view' => ['perm' => 'view_progress', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ],
                                    'Engagement' => [
                                        'desc' => 'Engage with coaches/peers and post discussions',
                                        'actions' => [
                                            'view' => ['perm' => 'view_engagement', 'allowed' => true, 'chosen' => true],
                                            'add' => ['perm' => 'add_engagement', 'allowed' => true, 'chosen' => true],
                                            'update' => ['perm' => 'update_engagement', 'allowed' => true, 'chosen' => true],
                                            'delete' => ['perm' => 'delete_engagement', 'allowed' => true, 'chosen' => true]
                                        ]
                                    ]
                                ]
                            ]
                        ];
                    @endphp

                    @foreach($systemGroups as $sysKey => $system)
                        <div class="permission-accordion accordion-{{ $sysKey }} {{ $system['class'] }}" id="{{ $system['id'] }}">
                            <div class="permission-accordion-header" onclick="toggleAccordion('{{ $system['id'] }}')">
                                <div class="permission-role-info">
                                    <span class="permission-role-name">{{ $system['badge'] }}</span>
                                    <span class="unsaved-badge" id="unsaved-{{ $system['id'] }}">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg>
                                        Unsaved
                                    </span>
                                </div>
                                <div class="permission-dropdown-indicator">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <div class="permission-accordion-content">
                                <div class="permission-accordion-inner">
                                    <div class="permissions-header-actions" style="margin-bottom: 20px; display: flex; justify-content: flex-end; gap: 24px; align-items: center;">
                                        <div class="select-all-box" onclick="toggleSystemPermissions('{{ $system['id'] }}')">
                                            <div class="permission-option-circle select-all-circle"></div>
                                            <span class="select-all-text">Select All</span>
                                        </div>
                                        {{-- Global Save handled by Update User --}}
                                    </div>
                                    <div class="permission-table-wrapper">
                                        <table class="permission-table">
                                            <thead>
                                                <tr>
                                                    <th>Permission Group</th>
                                                    <th style="width: 40%;">Description</th>
                                                    <th style="text-align: center;">View</th>
                                                    <th style="text-align: center;">Add</th>
                                                    <th style="text-align: center;">Update</th>
                                                    <th style="text-align: center;">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($system['groups'] as $groupTitle => $groupData)
                                                    <tr>
                                                        <td><div class="permission-group-name">{{ $groupTitle }}</div></td>
                                                        <td><div class="permission-group-desc">{{ $groupData['desc'] }}</div></td>
                                                        @foreach(['view', 'add', 'update', 'delete'] as $action)
                                                            <td class="permission-cell">
                                                                @if(isset($groupData['actions'][$action]))
                                                                    @php 
                                                                        $actionInfo = $groupData['actions'][$action];
                                                                        $pName = $actionInfo['perm'];
                                                                        $pId = $pName;
                                                                        if(isset($permissions)) {
                                                                            $found = $permissions->firstWhere('name', $pName);
                                                                            if($found) $pId = $found->id;
                                                                        }
                                                                        $isChosen = $actionInfo['chosen'] ?? true;
                                                                    @endphp
                                                                    <div class="permission-cell-check">
                                                                        <label class="permission-option" data-perm-name="{{ $pName }}" style="position: relative;">
                                                                            <input type="checkbox" name="permissions[]" value="{{ $pId }}" class="permission-option-input" {{ $isChosen ? 'checked' : '' }} disabled>
                                                                            <div class="permission-option-circle" style="position: relative; z-index: 1;"></div>
                                                                        </label>
                                                                    </div>
                                                                @else
                                                                    <div class="permission-cell-na">N/A</div>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="section-location" class="profile-section" style="display:none;">
                    <p class="profile-section-title">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Location Details
                    </p>
                    <div class="profile-location-grid">
                        <div class="form-group">
                            <label>Office Level</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                                </svg>
                                <select id="view_office_level" name="office_level" disabled>
                                    <option value="">Select Office Level</option>
                                    <option value="DILG Central Office">DILG Central Office</option>
                                    <option value="DILG Regional Office">DILG Regional Office</option>
                                    <option value="DILG Provincial Office">DILG Provincial Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <select id="view_region" name="region" onchange="handleViewRegionChange(this)" disabled>
                                    <option value="" disabled selected>Select Region</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <polygon points="1,6 1,22 8,19 16,22 23,19 23,3 16,6 8,3 1,6"></polygon>
                                    <line x1="8" y1="3" x2="8" y2="19"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                                <select id="view_province" name="province" onchange="handleViewProvinceChange(this)" disabled>
                                    <option value="" disabled selected>Select Province</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>City / Municipality</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <polygon points="3,11 22,2 13,21 11,13 3,11"></polygon>
                                </svg>
                                <select id="view_city" name="city" onchange="handleViewCityChange(this)" disabled>
                                    <option value="" disabled selected>Select City/Municipality</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Barangay</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 10.5 12 3l9 7.5"></path>
                                    <path d="M5 9.5V21h14V9.5"></path>
                                </svg>
                                <select id="view_barangay" name="barangay" disabled>
                                    <option value="" disabled selected>Select Barangay</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="section-security" class="profile-section" style="display:none;">
                    <p class="profile-section-title">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="10" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Security
                    </p>
                    <div class="form-group profile-password-wrap">
                        <label>Password</label>
                        <div class="field-with-icon">
                            <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="11" width="18" height="10" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="view_password" name="password" placeholder="********" disabled>
                        </div>
                        <button type="button" id="togglePassword" class="password-toggle" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" class="password-eye" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg id="eyeOffIcon" class="password-eye" viewBox="0 0 24 24" aria-hidden="true" style="display:none;">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.31 21.31 0 0 1 5.06-5.94"></path>
                                <path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a21.84 21.84 0 0 1-2.16 3.19"></path>
                                <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                        <small class="password-help">Leave blank to keep current password</small>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Add Course Modal -->
    <div id="addCourseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddCourseModal()">&times;</span>
            <h2 style="color: var(--primary-blue); margin-top: 0;">Add Course</h2>
            
            @if($errors->create_course->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->create_course->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Course Description</label>
                    <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
                </div>
                <div class="form-group">
                    <label>Subject Area Category</label>
                    <select name="subject_area" required>
                        <option value="" disabled selected>Select Subject Area</option>
                        <option value="Core Governance & Administration">Core Governance & Administration</option>
                        <option value="Finance & Compliance">Finance & Compliance</option>
                        <option value="Digital Transformation">Digital Transformation</option>
                        <option value="ICT & Technical Skills">ICT & Technical Skills</option>
                        <option value="Human Capital & Leadership">Human Capital & Leadership</option>
                        <option value="Community & Development Planning">Community & Development Planning</option>
                        <option value="Economic & Business Development">Economic & Business Development</option>
                        <option value="Social Governance">Social Governance</option>
                    </select>
                </div>
                <!-- Module Builder -->
                <div class="form-group">
                    <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom:8px;">
                        <label style="margin:0;">Modules & Topics</label>
                        <button type="button" onclick="createModule()" style="background-color: var(--primary-blue); color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">+ Create Module</button>
                    </div>
                    <div id="modulesContainer" style="display: flex; flex-direction: column; gap: 10px;"></div>
                </div>
                <!-- Removed Video URL -->
                <div class="form-group">
                    <label>Course Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeAddCourseModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancel</button>
                    <button type="submit" class="btn-update" style="background-color: var(--primary-green);">Add Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div id="editCourseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditCourseModal()">&times;</span>
            <h2>Edit Course</h2>

            @if($errors->update_course->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->update_course->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" id="edit_course_name" name="name" required>
                </div>
                <div class="form-group">
                    <label>Course Description</label>
                    <textarea id="edit_course_description" name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
                </div>
                <div class="form-group">
                    <label>Subject Area Category</label>
                    <select id="edit_course_subject_area" name="subject_area" required>
                        <option value="" disabled selected>Select Subject Area</option>
                        <option value="Core Governance & Administration">Core Governance & Administration</option>
                        <option value="Finance & Compliance">Finance & Compliance</option>
                        <option value="Digital Transformation">Digital Transformation</option>
                        <option value="ICT & Technical Skills">ICT & Technical Skills</option>
                        <option value="Human Capital & Leadership">Human Capital & Leadership</option>
                        <option value="Community & Development Planning">Community & Development Planning</option>
                        <option value="Economic & Business Development">Economic & Business Development</option>
                        <option value="Social Governance">Social Governance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Course Image (Leave blank to keep current)</label>
                    <input type="file" name="image" accept="image/*">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeEditCourseModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancel</button>
                    <button type="submit" class="btn-update">Update Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Draft Courses Modal -->
    <div id="draftCoursesModal" class="modal">
        <div class="modal-content" style="width: min(1000px, 95vw); max-height: 85vh; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                <h2 style="margin: 0; color: #002C76; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-file-pen"></i> Draft Courses
                </h2>
                <button type="button" class="close" onclick="closeDraftCoursesModal()" style="font-size: 28px; background: none; border: none; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            <div style="padding: 24px; overflow-y: auto; background: #f8fafc; flex: 1;">
                <div id="draftCoursesModalContainer" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <!-- Drafts will be rendered here via JS -->
                </div>
            </div>
            <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #fff; text-align: right;">
                <button type="button" onclick="closeDraftCoursesModal()" style="background: #64748b; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>

    <!-- Add Certification Modal -->
    <div id="addCertificationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddCertificationModal()">&times;</span>
            <h2 style="color: var(--primary-blue); margin-top: 0;">Add Certification</h2>
            <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Certification Name</label>
                    <input type="text" name="name" required placeholder="e.g. Certified Administrator">
                </div>
                <div class="form-group">
                    <label>Category (Optional)</label>
                    <select name="category">
                        <option value="" selected>Select Category</option>
                        <option value="Core Governance & Administration">Core Governance & Administration</option>
                        <option value="Finance & Compliance">Finance & Compliance</option>
                        <option value="Digital Transformation">Digital Transformation</option>
                        <option value="ICT & Technical Skills">ICT & Technical Skills</option>
                        <option value="Human Capital & Leadership">Human Capital & Leadership</option>
                        <option value="Community & Development Planning">Community & Development Planning</option>
                        <option value="Economic & Business Development">Economic & Business Development</option>
                        <option value="Social Governance">Social Governance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Certificate File (PDF/Image)</label>
                    <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeAddCertificationModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancel</button>
                    <button type="submit" class="btn-update" style="background-color: var(--primary-green);">Create Certification</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Certify User Modal -->
    <div id="certifyUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCertifyUserModal()">&times;</span>
            <h2 style="color: var(--primary-blue); margin-top: 0;">Certify User</h2>
            <p>Certifying: <strong id="certify_user_name"></strong></p>
            <form action="{{ route('certifications.certify-user') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="certify_user_id">
                <div class="form-group">
                    <label>Select Certification</label>
                    <select name="certification_id" required>
                        <option value="" disabled selected>Select a Certification</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}">{{ $cert->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeCertifyUserModal()" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancel</button>
                    <button type="submit" class="btn-update" style="background-color: var(--primary-blue);">Certify User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Role Modal (global overlay) -->
    @if(Auth::check() && Auth::user()->role === 'super_admin')
    <div id="addRoleModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="addRoleTitle" style="align-items:center;justify-content:center;padding:20px;box-sizing:border-box;">
        <div class="modal-content pro-modal" style="margin:0;">
            <div class="pro-modal-header">
                <div class="pro-modal-title">
                    <div class="badge"><i class="fas fa-user-shield"></i></div>
                    <div id="addRoleTitle">Add Role</div>
                </div>
                <button type="button" class="pro-modal-close" onclick="closeAddRoleModal()" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="pro-modal-body">
                    <div class="pro-field">
                        <label class="pro-label">Role Name</label>
                        <input class="pro-input" type="text" name="name" placeholder="e.g. super_admin" required>
                    </div>
                    <div class="pro-field">
                        <label class="pro-label">Display Name</label>
                        <input class="pro-input" type="text" name="display_name" placeholder="e.g. Super Admin">
                    </div>
                </div>
                <div class="pro-modal-actions">
                    <button type="button" class="btn-ghost" onclick="closeAddRoleModal()">Cancel</button>
                    <button type="submit" class="btn-solid">Create Role</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        // System Constants and Data
        const CAN_MANAGE_ACCESS = {{ (auth()->check() && in_array(auth()->user()->role, ['super_admin', 'admin', 'registrar', 'central_office_admin', 'regional_office_admin', 'provincial_office_admin'])) ? 'true' : 'false' }};
        const ALL_ROLE_PERMISSIONS = @json($rolePermissions);
        const ALL_ROLES = @json($roles);

        // Profile Edit Logic
        let isProfileEditing = false;

        function hasSelectableOptions(selectElement) {
            if (!selectElement) return false;
            return Array.from(selectElement.options).some((option) => option.value !== '');
        }

        function syncProfileLocationSelectState() {
            const regionSelect = document.getElementById('profile_region');
            const provinceSelect = document.getElementById('profile_province');
            const citySelect = document.getElementById('profile_city');
            const barangaySelect = document.getElementById('profile_barangay');
            if (!regionSelect || !provinceSelect || !citySelect || !barangaySelect) return;

            const applyState = (selectElement, canSelect) => {
                if (!selectElement) return;
                selectElement.disabled = !isProfileEditing || !canSelect;
                if (selectElement.disabled) {
                    selectElement.style.backgroundColor = '';
                    selectElement.style.cursor = 'not-allowed';
                    return;
                }
                selectElement.style.backgroundColor = 'white';
                selectElement.style.cursor = 'pointer';
            };

            applyState(regionSelect, hasSelectableOptions(regionSelect));
            applyState(provinceSelect, hasSelectableOptions(provinceSelect));
            applyState(citySelect, hasSelectableOptions(citySelect));
            applyState(barangaySelect, hasSelectableOptions(barangaySelect));
        }

        function initProfileLocationDropdowns() {
            const regionSelect = document.getElementById('profile_region');
            const provinceSelect = document.getElementById('profile_province');
            const citySelect = document.getElementById('profile_city');
            const barangaySelect = document.getElementById('profile_barangay');
            if (!regionSelect || !provinceSelect || !citySelect || !barangaySelect) return;
            if (regionSelect.dataset.initialized === 'true') return;
            regionSelect.dataset.initialized = 'true';

            const selectedRegion = regionSelect.dataset.selected || '';
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
                syncProfileLocationSelectState();

                if (!cityCode) {
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    syncProfileLocationSelectState();
                    return;
                }

                fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));
                        let matched = false;
                        data.forEach(barangay => {
                            const option = document.createElement('option');
                            option.value = barangay.name;
                            option.textContent = barangay.name;
                            if (selectedBarangayValue && selectedBarangayValue === barangay.name) {
                                option.selected = true;
                                matched = true;
                            }
                            barangaySelect.appendChild(option);
                        });

                        if (selectedBarangayValue && !matched) {
                            addFallbackOption(barangaySelect, selectedBarangayValue);
                        }

                        syncProfileLocationSelectState();
                    })
                    .catch(error => {
                        console.error('Error fetching barangays:', error);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncProfileLocationSelectState();
                    });
            }

            function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
                const url = isRegion
                    ? `{{ url('/psgc/regions') }}/${code}/cities`
                    : `{{ url('/psgc/provinces') }}/${code}/cities`;

                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                syncProfileLocationSelectState();

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));
                        let selectedCityCode = '';
                        let matched = false;

                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.dataset.code = city.code;
                            option.textContent = city.name;
                            if (selectedCityValue && selectedCityValue === city.name) {
                                option.selected = true;
                                selectedCityCode = city.code;
                                matched = true;
                            }
                            citySelect.appendChild(option);
                        });

                        if (selectedCityValue && !matched) {
                            addFallbackOption(citySelect, selectedCityValue);
                        }

                        syncProfileLocationSelectState();
                        if (selectedCityCode) {
                            loadBarangays(selectedCityCode, selectedBarangayValue);
                        } else if (selectedBarangayValue) {
                            addFallbackOption(barangaySelect, selectedBarangayValue);
                            syncProfileLocationSelectState();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncProfileLocationSelectState();
                    });
            }

            function loadProvincesByRegion(regionCode, selectedProvinceValue = null, selectedCityValue = null, selectedBarangayValue = null) {
                resetSelect(provinceSelect, 'Select Province');
                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                syncProfileLocationSelectState();

                if (!regionCode) {
                    if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                    if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    syncProfileLocationSelectState();
                    return;
                }

                fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));

                        if (data.length === 0 && regionCode === '130000000') {
                            const option = addFallbackOption(provinceSelect, regionSelect.value, regionSelect.value);
                            if (option) {
                                option.dataset.code = regionCode;
                                option.dataset.isRegion = 'true';
                            }
                            syncProfileLocationSelectState();
                            fetchCities(regionCode, true, selectedCityValue, selectedBarangayValue);
                            return;
                        }

                        let selectedProvinceCode = '';
                        let matched = false;
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.name;
                            option.dataset.code = province.code;
                            option.textContent = province.name;
                            if (selectedProvinceValue && selectedProvinceValue === province.name) {
                                option.selected = true;
                                selectedProvinceCode = province.code;
                                matched = true;
                            }
                            provinceSelect.appendChild(option);
                        });

                        if (selectedProvinceValue && !matched) {
                            addFallbackOption(provinceSelect, selectedProvinceValue);
                        }

                        syncProfileLocationSelectState();
                        if (selectedProvinceCode) {
                            fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                        } else if (selectedCityValue) {
                            addFallbackOption(citySelect, selectedCityValue);
                            if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                            syncProfileLocationSelectState();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching provinces:', error);
                        if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncProfileLocationSelectState();
                    });
            }

            regionSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const regionCode = selectedOption?.dataset?.code || '';
                loadProvincesByRegion(regionCode);
            });

            provinceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const provinceCode = selectedOption?.dataset?.code || '';
                const isRegion = selectedOption?.dataset?.isRegion === 'true';
                if (!provinceCode) {
                    resetSelect(citySelect, 'Select City/Municipality');
                    resetSelect(barangaySelect, 'Select Barangay');
                    syncProfileLocationSelectState();
                    return;
                }
                fetchCities(provinceCode, isRegion);
            });

            citySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const cityCode = selectedOption?.dataset?.code || '';
                loadBarangays(cityCode);
            });

            if (isDILGMode) {
                const regionLabel = IS_OFFICE(myRole, 'central') ? 'DILG Central Office' : (IS_OFFICE(myRole, 'regional') ? 'DILG Regional Office' : 'DILG Provincial Office');
                resetSelect(regionSelect, 'Select Level');
                const opt = document.createElement('option');
                opt.value = regionLabel;
                opt.textContent = regionLabel;
                opt.selected = true;
                opt.dataset.code = 'DILG';
                regionSelect.appendChild(opt);
                // Adjust labels for DILG mode
                const regionLabelEl = regionSelect.closest('.form-group')?.querySelector('.profile-field-label');
                if (regionLabelEl) {
                    regionLabelEl.childNodes[regionLabelEl.childNodes.length-1].textContent = 'Office Level';
                }
                const provLabelEl = provinceSelect.closest('.form-group')?.querySelector('.profile-field-label');
                if (provLabelEl) {
                    provLabelEl.childNodes[provLabelEl.childNodes.length-1].textContent = IS_OFFICE(myRole, 'central') ? 'Office Type' : 'Office';
                }
                // Office Type and Office selection for Central Office
                resetSelect(provinceSelect, IS_OFFICE(myRole, 'central') ? 'Select Office Type' : 'Select Office');
                if (IS_OFFICE(myRole, 'central')) {
                    ['Bureau','Services'].forEach(lbl => {
                        const o = document.createElement('option');
                        o.value = lbl;
                        o.textContent = lbl;
                        provinceSelect.appendChild(o);
                    });
                    function setProfileUnitLabel(cat){
                        const group = citySelect.closest('.form-group');
                        if (group) {
                            const lab = group.querySelector('.profile-field-label');
                            if (lab) { lab.childNodes[lab.childNodes.length-1].textContent = cat === 'Bureau' ? 'Bureau' : 'Service'; }
                        }
                    }
                    async function loadProfileCentralUnits(cat, selectedUnit=null){
                        setProfileUnitLabel(cat);
                        resetSelect(citySelect, cat === 'Bureau' ? 'Select Bureau' : 'Select Service');
                        const url = cat === 'Bureau' ? `{{ url('/dilg/central/bureaus') }}` : `{{ url('/dilg/central/services') }}`;
                        let matched=false;
                        try{
                            const res = await fetch(url);
                            if(!res.ok) throw new Error('Failed to fetch');
                            const data = await res.json();
                            (data || []).forEach(item=>{
                                const name = item.name || item.title || item.label || item.unit || item;
                                if(!name) return;
                                const o=document.createElement('option'); o.value=name; o.textContent=name;
                                if (selectedUnit && selectedUnit === name) { o.selected=true; matched=true; }
                                citySelect.appendChild(o);
                            });
                        }catch(e){
                            const fallback = cat === 'Bureau' ? BUREAUS : SERVICES;
                            fallback.forEach(item=>{
                                const o=document.createElement('option'); o.value=item; o.textContent=item;
                                if (selectedUnit && selectedUnit === item) { o.selected=true; matched=true; }
                                citySelect.appendChild(o);
                            });
                        }
                        // Hide Barangay for central
                        const barangayGroup = document.getElementById('profile_barangay')?.closest('.form-group');
                        if (barangayGroup) barangayGroup.style.display = 'none';
                        syncProfileLocationSelectState();
                    }
                    provinceSelect.addEventListener('change', function(){
                        const cat = this.value;
                        loadProfileCentralUnits(cat, selectedProvince || null);
                    });
                    if (selectedProvince || selectedCity) {
                        const p = String(selectedProvince || '').toLowerCase();
                        const guess = (p.startsWith('bureau') || p === 'bureaus') ? 'Bureau' : 'Services';
                        provinceSelect.value = guess;
                        loadProfileCentralUnits(guess, selectedCity || null);
                    }
                } else if (IS_OFFICE(myRole, 'regional')) {
                    // Two controls: Office Level (regionSelect) and Region (reuse provinceSelect)
                    const toHide = [citySelect, barangaySelect].map(s => s.closest('.form-group'));
                    toHide.forEach(g => { if (g) g.style.display = 'none'; });
                    const provLabelEl2 = provinceSelect.closest('.form-group')?.querySelector('.profile-field-label');
                    if (provLabelEl2) {
                        provLabelEl2.childNodes[provLabelEl2.childNodes.length-1].textContent = 'Region';
                    }
                    // Ensure names do not collide: use office_level for the level field, region for the second select
                    regionSelect.setAttribute('name','office_level');
                    provinceSelect.setAttribute('name','region');
                    resetSelect(provinceSelect, 'Select Region');
                    fetch(`{{ url('/psgc/regions') }}`)
                        .then(r=>r.json())
                        .then(data=>{
                            data.sort((a,b)=>a.name.localeCompare(b.name));
                            let matched=false;
                            data.forEach(reg=>{
                                const o=document.createElement('option');
                                o.value = reg.name;
                                o.dataset.code = reg.code;
                                o.textContent = reg.name;
                                if (selectedRegion && selectedRegion === reg.name) { o.selected=true; matched=true; }
                                provinceSelect.appendChild(o);
                            });
                            if (selectedRegion && !matched) addFallbackOption(provinceSelect, selectedRegion);
                            syncProfileLocationSelectState();
                        })
                        .catch(()=>{
                            if (selectedRegion) addFallbackOption(provinceSelect, selectedRegion);
                            syncProfileLocationSelectState();
                        });
                } else if (IS_OFFICE(myRole, 'provincial')) {
                    // Only Office/Province editable â€” aggregate provinces across all regions
                    resetSelect(provinceSelect, 'Select Office');
                    if (regionLabelEl) {
                        regionLabelEl.childNodes[regionLabelEl.childNodes.length-1].textContent = 'Office Level';
                    }
                    const provLabelEl3 = provinceSelect.closest('.form-group')?.querySelector('.profile-field-label');
                    if (provLabelEl3) {
                        provLabelEl3.childNodes[provLabelEl3.childNodes.length-1].textContent = 'Office';
                    }
                    fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(async regions=>{
                        let items = [];
                        for (const reg of regions) {
                            try {
                                const res = await fetch(`{{ url('/psgc/regions') }}/${reg.code}/provinces`);
                                const data = await res.json();
                                items = items.concat(data.map(p=>({code:p.code,name:p.name})));
                            } catch(e) {}
                        }
                        items.sort((a,b)=>a.name.localeCompare(b.name));
                        let matched=false;
                        items.forEach(p=>{
                            const o=document.createElement('option');
                            o.value = `${p.name} Office`;
                            o.dataset.code = p.code;
                            o.textContent = `${p.name} Office`;
                            if (selectedProvince && (selectedProvince === `${p.name} Office` || selectedProvince === p.name)) { o.selected=true; matched=true; }
                            provinceSelect.appendChild(o);
                        });
                        if (selectedProvince && !matched) addFallbackOption(provinceSelect, selectedProvince);
                    }).catch(()=>{ if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince); });
                    const groups = [citySelect, barangaySelect].map(s => s.closest('.form-group'));
                    groups.forEach(g => { if (g) g.style.display = 'none'; });
                }
                syncProfileLocationSelectState();
                return;
            }

            fetch(`{{ url('/psgc/regions') }}`)
                .then(response => response.json())
                .then(data => {
                    resetSelect(regionSelect, 'Select Region');
                    data.sort((a, b) => a.name.localeCompare(b.name));

                    let selectedRegionCode = '';
                    let matched = false;
                    data.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.name;
                        option.dataset.code = region.code;
                        option.textContent = region.name;
                        if (selectedRegion && selectedRegion === region.name) {
                            option.selected = true;
                            selectedRegionCode = region.code;
                            matched = true;
                        }
                        regionSelect.appendChild(option);
                    });

                    if (selectedRegion && !matched) {
                        addFallbackOption(regionSelect, selectedRegion);
                    }

                    syncProfileLocationSelectState();
                    if (selectedRegionCode) {
                        loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
                    } else {
                        if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                        if (selectedCity) addFallbackOption(citySelect, selectedCity);
                        if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                        syncProfileLocationSelectState();
                    }
                })
                .catch(error => {
                    console.error('Error fetching regions:', error);
                    if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
                    if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                    if (selectedCity) addFallbackOption(citySelect, selectedCity);
                    if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                    syncProfileLocationSelectState();
                });
        }

        const viewLocationHandlers = {
            loadProvincesByRegion: null,
            fetchCities: null,
            loadBarangays: null,
        };

        function isViewUserEditMode() {
            return document.getElementById('btnUpdate')?.style.display === 'inline-flex';
        }

        function syncViewLocationSelectState() {
            const regionSelect = document.getElementById('view_region');
            const provinceSelect = document.getElementById('view_province');
            const citySelect = document.getElementById('view_city');
            const barangaySelect = document.getElementById('view_barangay');
            if (!regionSelect || !provinceSelect || !citySelect || !barangaySelect) return;

            const isEditing = isViewUserEditMode();
            const applyState = (selectElement, canSelect) => {
                if (!selectElement) return;
                selectElement.disabled = !isEditing || !canSelect;
                if (selectElement.disabled) {
                    selectElement.style.backgroundColor = '';
                    selectElement.style.cursor = 'not-allowed';
                    return;
                }
                selectElement.style.backgroundColor = 'white';
                selectElement.style.cursor = 'pointer';
            };

            applyState(regionSelect, hasSelectableOptions(regionSelect));
            applyState(provinceSelect, hasSelectableOptions(provinceSelect));
            applyState(citySelect, hasSelectableOptions(citySelect));
            applyState(barangaySelect, hasSelectableOptions(barangaySelect));
        }

        function initViewLocationDropdowns(selectedRegion = '', selectedProvince = '', selectedCity = '', selectedBarangay = '') {
            const regionSelect = document.getElementById('view_region');
            const provinceSelect = document.getElementById('view_province');
            const citySelect = document.getElementById('view_city');
            const barangaySelect = document.getElementById('view_barangay');
            if (!regionSelect || !provinceSelect || !citySelect || !barangaySelect) return;

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

            const OFFICE_ROLES = {
                central: ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'],
                regional: ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'],
                provincial: ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants']
            };
            const BUREAUS = [
                'Bureau of Local Government Development','Bureau of Local Government Supervision','Bureau of Fire Protection',
                'Bureau of Jail Management and Penology','National Police Commission','Philippine National Police',
                'National Barangay Operations Office','Office of Project Development Services','Public Affairs and Communication Service'
            ];
            const SERVICES = [
                'Administrative Service','Financial and Management Service','Information Systems and Technology Management Service',
                'Internal Audit Service','Legal Service','Planning Service','Policy and Performance Monitoring Service','Local Government Capability Development Division'
            ];
            const currentRole = document.getElementById('view_role')?.value || '';
            const officeSelect = document.getElementById('view_office_level');
            let forced = window.FORCED_OFFICE_GROUP || null;
            if (!forced && officeSelect && officeSelect.value) {
                forced = officeSelect.value === 'DILG Central Office' ? 'central' : (officeSelect.value === 'DILG Regional Office' ? 'regional' : (officeSelect.value === 'DILG Provincial Office' ? 'provincial' : null));
            }
            if (!forced && selectedRegion) {
                forced = selectedRegion === 'DILG Central Office' ? 'central' : (selectedRegion === 'DILG Regional Office' ? 'regional' : (selectedRegion === 'DILG Provincial Office' ? 'provincial' : null));
            }
            if (!forced) {
                if (OFFICE_ROLES.central.includes(currentRole)) forced = 'central';
                else if (OFFICE_ROLES.regional.includes(currentRole)) forced = 'regional';
                else if (OFFICE_ROLES.provincial.includes(currentRole)) forced = 'provincial';
            }
            window.FORCED_OFFICE_GROUP = forced || null;
            const IS_OFFICE = (_, group) => window.FORCED_OFFICE_GROUP === group;
            const isDILGMode = ['central','regional','provincial'].includes(window.FORCED_OFFICE_GROUP || '');

            function loadBarangays(cityCode, selectedBarangayValue = null) {
                resetSelect(barangaySelect, 'Select Barangay');
                syncViewLocationSelectState();

                if (!cityCode) {
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    syncViewLocationSelectState();
                    return;
                }

                fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));
                        let matched = false;
                        data.forEach(barangay => {
                            const option = document.createElement('option');
                            option.value = barangay.name;
                            option.textContent = barangay.name;
                            if (selectedBarangayValue && selectedBarangayValue === barangay.name) {
                                option.selected = true;
                                matched = true;
                            }
                            barangaySelect.appendChild(option);
                        });

                        if (selectedBarangayValue && !matched) {
                            addFallbackOption(barangaySelect, selectedBarangayValue);
                        }

                        syncViewLocationSelectState();
                    })
                    .catch(error => {
                        console.error('Error fetching barangays:', error);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncViewLocationSelectState();
                    });
            }

            function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
                const url = isRegion
                    ? `{{ url('/psgc/regions') }}/${code}/cities`
                    : `{{ url('/psgc/provinces') }}/${code}/cities`;

                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                syncViewLocationSelectState();

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));
                        let selectedCityCode = '';
                        let matched = false;

                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.dataset.code = city.code;
                            option.textContent = city.name;
                            if (selectedCityValue && selectedCityValue === city.name) {
                                option.selected = true;
                                selectedCityCode = city.code;
                                matched = true;
                            }
                            citySelect.appendChild(option);
                        });

                        if (selectedCityValue && !matched) {
                            addFallbackOption(citySelect, selectedCityValue);
                        }

                        syncViewLocationSelectState();
                        if (selectedCityCode) {
                            loadBarangays(selectedCityCode, selectedBarangayValue);
                        } else if (selectedBarangayValue) {
                            addFallbackOption(barangaySelect, selectedBarangayValue);
                            syncViewLocationSelectState();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncViewLocationSelectState();
                    });
            }

            function loadProvincesByRegion(regionCode, selectedProvinceValue = null, selectedCityValue = null, selectedBarangayValue = null) {
                resetSelect(provinceSelect, 'Select Province');
                resetSelect(citySelect, 'Select City/Municipality');
                resetSelect(barangaySelect, 'Select Barangay');
                syncViewLocationSelectState();

                if (!regionCode) {
                    if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                    if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    syncViewLocationSelectState();
                    return;
                }

                fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`)
                    .then(response => response.json())
                    .then(data => {
                        data.sort((a, b) => a.name.localeCompare(b.name));

                        if (data.length === 0 && regionCode === '130000000') {
                            const option = addFallbackOption(provinceSelect, regionSelect.value, regionSelect.value);
                            if (option) {
                                option.dataset.code = regionCode;
                                option.dataset.isRegion = 'true';
                            }
                            syncViewLocationSelectState();
                            fetchCities(regionCode, true, selectedCityValue, selectedBarangayValue);
                            return;
                        }

                        let selectedProvinceCode = '';
                        let matched = false;
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.name;
                            option.dataset.code = province.code;
                            option.textContent = province.name;
                            if (selectedProvinceValue && selectedProvinceValue === province.name) {
                                option.selected = true;
                                selectedProvinceCode = province.code;
                                matched = true;
                            }
                            provinceSelect.appendChild(option);
                        });

                        if (selectedProvinceValue && !matched) {
                            addFallbackOption(provinceSelect, selectedProvinceValue);
                        }

                        syncViewLocationSelectState();
                        if (selectedProvinceCode) {
                            fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                        } else if (selectedCityValue) {
                            addFallbackOption(citySelect, selectedCityValue);
                            if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                            syncViewLocationSelectState();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching provinces:', error);
                        if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                        if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                        if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                        syncViewLocationSelectState();
                    });
            }

            viewLocationHandlers.loadProvincesByRegion = loadProvincesByRegion;
            viewLocationHandlers.fetchCities = fetchCities;
            viewLocationHandlers.loadBarangays = loadBarangays;

            resetSelect(regionSelect, 'Select Region');
            resetSelect(provinceSelect, 'Select Province');
            resetSelect(citySelect, 'Select City/Municipality');
            resetSelect(barangaySelect, 'Select Barangay');
            syncViewLocationSelectState();
            const regionGroup = regionSelect.closest('.form-group');
            const provinceGroup = provinceSelect.closest('.form-group');
            const cityGroup = citySelect.closest('.form-group');
            const barangayGroup = barangaySelect.closest('.form-group');
            if (regionGroup) regionGroup.style.display = '';
            if (provinceGroup) provinceGroup.style.display = '';
            if (cityGroup) cityGroup.style.display = '';
            if (barangayGroup) barangayGroup.style.display = '';

            if (isDILGMode) {
                const regionLabel = IS_OFFICE(currentRole, 'central') ? 'DILG Central Office' : (IS_OFFICE(currentRole, 'regional') ? 'DILG Regional Office' : 'DILG Provincial Office');
                if (officeSelect) { officeSelect.value = regionLabel; }
                const provLabelNode = provinceSelect.closest('.form-group')?.querySelector('label');
                if (provLabelNode) { provLabelNode.textContent = IS_OFFICE(currentRole, 'central') ? 'Office Type' : 'Office'; }
                if (IS_OFFICE(currentRole, 'central')) {
                    if (regionGroup) regionGroup.style.display = 'none';
                    resetSelect(provinceSelect, 'Select Office Type');
                    ['Bureau','Services'].forEach(lbl => { const o=document.createElement('option'); o.value=lbl; o.textContent=lbl; provinceSelect.appendChild(o); });
                    function setUnitLabel(cat){
                        const group = citySelect.closest('.form-group');
                        if (group) {
                            const lab = group.querySelector('label');
                            if (lab) lab.textContent = cat === 'Bureau' ? 'Bureau' : 'Service';
                        }
                    }
                    async function loadCentralUnits(cat, selectedUnit=null){
                        setUnitLabel(cat);
                        resetSelect(citySelect, cat === 'Bureau' ? 'Select Bureau' : 'Select Service');
                        const url = cat === 'Bureau' ? `{{ url('/dilg/central/bureaus') }}` : `{{ url('/dilg/central/services') }}`;
                        let matched=false;
                        try{
                            const res = await fetch(url);
                            if(!res.ok) throw new Error('Failed to fetch');
                            const data = await res.json();
                            (data || []).forEach(item=>{
                                const name = item.name || item.title || item.label || item.unit || item;
                                if(!name) return;
                                const o=document.createElement('option'); o.value=name; o.textContent=name;
                                if (selectedUnit && selectedUnit === name) { o.selected=true; matched=true; }
                                citySelect.appendChild(o);
                            });
                        }catch(e){
                            const fallback = cat === 'Bureau' ? BUREAUS : SERVICES;
                            fallback.forEach(item=>{
                                const o=document.createElement('option'); o.value=item; o.textContent=item;
                                if (selectedUnit && selectedUnit === item) { o.selected=true; matched=true; }
                                citySelect.appendChild(o);
                            });
                        }
                        if (selectedUnit && !matched) addFallbackOption(citySelect, selectedUnit);
                        const barangayGroup = barangaySelect.closest('.form-group'); if (barangayGroup) barangayGroup.style.display='none';
                        syncViewLocationSelectState();
                    }
                    provinceSelect.addEventListener('change', function(){
                        const cat = this.value;
                        loadCentralUnits(cat, selectedProvince || null);
                        syncViewLocationSelectState();
                    });
                    if (selectedProvince || selectedCity) {
                        const p = String(selectedProvince || '').toLowerCase();
                        const guess = (p.startsWith('bureau') || p === 'bureaus') ? 'Bureau' : 'Services';
                        provinceSelect.value = guess;
                        loadCentralUnits(guess, selectedCity || null);
                    }
                    regionSelect.required = false;
                    provinceSelect.required = true;
                    citySelect.required = true;
                    barangaySelect.required = false;
                } else if (IS_OFFICE(currentRole, 'regional')) {
                    // Show only Region; load full region list from DB (signup source)
                    if (regionGroup) regionGroup.style.display = '';
                    const groups = [provinceSelect, citySelect, barangaySelect].map(s => s.closest('.form-group'));
                    groups.forEach(g => { if (g) g.style.display = 'none'; });
                    resetSelect(regionSelect, 'Select Region');
                    fetch(`{{ url('/psgc/regions') }}`)
                        .then(r => r.json())
                        .then(data => {
                            data.sort((a,b)=>a.name.localeCompare(b.name));
                            let matched=false;
                            data.forEach(reg=>{
                                const o=document.createElement('option');
                                o.value = reg.name;
                                o.dataset.code = reg.code;
                                o.textContent = reg.name;
                                if (selectedRegion && selectedRegion === reg.name) { o.selected=true; matched=true; }
                                regionSelect.appendChild(o);
                            });
                            if (selectedRegion && !matched) addFallbackOption(regionSelect, selectedRegion);
                            syncViewLocationSelectState();
                        })
                        .catch(()=>{
                            if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
                            syncViewLocationSelectState();
                        });
                    regionSelect.required = true;
                    provinceSelect.required = false;
                    citySelect.required = false;
                    barangaySelect.required = false;
                } else if (IS_OFFICE(currentRole, 'provincial')) {
                    if (regionGroup) regionGroup.style.display = 'none';
                    // Keep Region hidden; render only Office (Province Offices)
                    resetSelect(regionSelect, 'Select Level');
                    const opt = document.createElement('option');
                    opt.value = regionLabel;
                    opt.textContent = regionLabel;
                    opt.selected = true;
                    opt.dataset.code = 'DILG';
                    regionSelect.appendChild(opt);
                    resetSelect(provinceSelect, 'Select Office');
                    fetch(`{{ url('/psgc/regions') }}`).then(r=>r.json()).then(async regions=>{
                        let items = [];
                        for (const reg of regions) {
                            try {
                                const res = await fetch(`{{ url('/psgc/regions') }}/${reg.code}/provinces`);
                                const data = await res.json();
                                items = items.concat(data.map(p=>({code:p.code,name:p.name})));
                            } catch(e) {}
                        }
                        items.sort((a,b)=>a.name.localeCompare(b.name));
                        let matched=false;
                        items.forEach(p=>{
                            const o=document.createElement('option');
                            o.value = `${p.name} Office`;
                            o.dataset.code = p.code;
                            o.textContent = `${p.name} Office`;
                            if (selectedProvince && (selectedProvince === `${p.name} Office` || selectedProvince === p.name)) { o.selected=true; matched=true; }
                            provinceSelect.appendChild(o);
                        });
                        if (selectedProvince && !matched) addFallbackOption(provinceSelect, selectedProvince);
                        syncViewLocationSelectState();
                    }).catch(()=>{
                        if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                        syncViewLocationSelectState();
                    });
                    const groups = [citySelect, barangaySelect].map(s => s.closest('.form-group'));
                    groups.forEach(g => { if (g) g.style.display = 'none'; });
                    regionSelect.required = false;
                    provinceSelect.required = true;
                    citySelect.required = false;
                    barangaySelect.required = false;
                }
                syncViewLocationSelectState();
                return;
            }

            fetch(`{{ url('/psgc/regions') }}`)
                .then(response => response.json())
                .then(data => {
                    resetSelect(regionSelect, 'Select Region');
                    data.sort((a, b) => a.name.localeCompare(b.name));

                    let selectedRegionCode = '';
                    let matched = false;
                    data.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.name;
                        option.dataset.code = region.code;
                        option.textContent = region.name;
                        if (selectedRegion && selectedRegion === region.name) {
                            option.selected = true;
                            selectedRegionCode = region.code;
                            matched = true;
                        }
                        regionSelect.appendChild(option);
                    });

                    if (selectedRegion && !matched) {
                        addFallbackOption(regionSelect, selectedRegion);
                    }

                    syncViewLocationSelectState();
                    if (selectedRegionCode) {
                        loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
                    } else {
                        if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                        if (selectedCity) addFallbackOption(citySelect, selectedCity);
                        if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                        syncViewLocationSelectState();
                    }
                })
                .catch(error => {
                    console.error('Error fetching regions:', error);
                    if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
                    if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                    if (selectedCity) addFallbackOption(citySelect, selectedCity);
                    if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
                    syncViewLocationSelectState();
                });
        }

        function handleViewRegionChange(selectElement) {
            const selectedOption = selectElement?.options?.[selectElement.selectedIndex];
            const regionCode = selectedOption?.dataset?.code || '';
            if (typeof viewLocationHandlers.loadProvincesByRegion === 'function') {
                viewLocationHandlers.loadProvincesByRegion(regionCode);
            }
        }

        function handleViewProvinceChange(selectElement) {
            const selectedOption = selectElement?.options?.[selectElement.selectedIndex];
            const provinceCode = selectedOption?.dataset?.code || '';
            const isRegion = selectedOption?.dataset?.isRegion === 'true';

            if (!provinceCode) {
                const citySelect = document.getElementById('view_city');
                const barangaySelect = document.getElementById('view_barangay');
                if (citySelect) citySelect.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';
                if (barangaySelect) barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
                syncViewLocationSelectState();
                return;
            }

            if (typeof viewLocationHandlers.fetchCities === 'function') {
                viewLocationHandlers.fetchCities(provinceCode, isRegion);
            }
        }

        function handleViewCityChange(selectElement) {
            const selectedOption = selectElement?.options?.[selectElement.selectedIndex];
            const cityCode = selectedOption?.dataset?.code || '';
            if (typeof viewLocationHandlers.loadBarangays === 'function') {
                viewLocationHandlers.loadBarangays(cityCode);
            }
        }

        function enableProfileEdit() {
            isProfileEditing = true;
            document.getElementById('btnEditProfile').style.display = 'none';
            document.getElementById('btnCancelProfile').style.display = 'inline-flex';
            document.getElementById('btnSaveProfile').style.display = 'inline-flex';
            document.getElementById('profile_upload_container').style.display = 'flex';
            document.getElementById('password_change_section').style.display = 'block';
            animateProfileActionButtons();
            
            const inputs = document.querySelectorAll('.profile-input');
            inputs.forEach(input => {
                if (input.tagName === 'SELECT') {
                    input.style.backgroundColor = 'white';
                    input.style.cursor = 'pointer';
                    return;
                }
                input.readOnly = false;
                input.style.backgroundColor = 'white';
                input.style.cursor = 'text';
            });
            syncProfileLocationSelectState();
        }

        function animateProfileActionButtons() {
            const buttons = [
                document.getElementById('btnCancelProfile'),
                document.getElementById('btnSaveProfile'),
            ];

            buttons.forEach((button, index) => {
                if (!button) return;
                button.classList.remove('is-revealed');
                button.style.animationDelay = '0ms';
                requestAnimationFrame(() => {
                    button.style.animationDelay = `${index * 70}ms`;
                    button.classList.add('is-revealed');
                });
            });
        }

        function cancelProfileEdit() {
            // Reload to reset
            window.location.reload();
        }

        function previewProfileImage(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const lowerName = String(file.name || '').toLowerCase();
            const allowedMimeTypes = ['image/png', 'image/jpeg'];
            const allowedByMime = allowedMimeTypes.includes(file.type);
            const allowedByExtension = /\.(png|jpe?g)$/i.test(lowerName);
            const maxBytes = 5 * 1024 * 1024;

            if (!allowedByMime && !allowedByExtension) {
                alert('Only PNG and JPEG images are allowed.');
                input.value = '';
                return;
            }

            if (file.size > maxBytes) {
                alert('Image is too large. Maximum allowed size is 5 MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile_preview');
                const initials = document.getElementById('profile_initials');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                if (initials) initials.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }

        function showProfile() {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show profile section
            const profileSection = document.getElementById('profile-section');
            if (profileSection) {
                profileSection.classList.add('active');
            }

            // Remove active class from sidebar menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
        }

        // Certification Modals
        function openAddCertificationModal() {
            document.getElementById('addCertificationModal').style.display = 'block';
        }

        function closeAddCertificationModal() {
            document.getElementById('addCertificationModal').style.display = 'none';
        }

        function openCertifyUserModal(userId, userName) {
            document.getElementById('certify_user_id').value = userId;
            document.getElementById('certify_user_name').textContent = userName;
            document.getElementById('certifyUserModal').style.display = 'block';
        }

        function closeCertifyUserModal() {
            document.getElementById('certifyUserModal').style.display = 'none';
        }

        function openAddRoleModal(){
            var ov=document.getElementById('addRoleModal');
            if(ov){ ov.style.display='flex'; setTimeout(()=>{ try{ ov.querySelector('input[name="name"]').focus(); }catch(e){} }, 50); }
        }
        function closeAddRoleModal(){
            var ov=document.getElementById('addRoleModal');
            if(ov){ ov.style.display='none'; }
        }
        document.addEventListener('keydown', function(ev){ if(ev.key==='Escape'){ closeAddRoleModal(); } });
        document.addEventListener('click', function(ev){ var ov=document.getElementById('addRoleModal'); if(!ov) return; if(ov.style.display==='flex' && ev.target===ov){ closeAddRoleModal(); } });

        function switchCertTab(tab){
            var tabs = ['create','view','certify'];
            tabs.forEach(function(name){
                var btn = document.getElementById('certTab'+name.charAt(0).toUpperCase()+name.slice(1));
                var pane = document.getElementById('certPane'+name.charAt(0).toUpperCase()+name.slice(1));
                if(btn){ btn.classList.toggle('active', name===tab); btn.setAttribute('aria-selected', String(name===tab)); }
                if(pane){ pane.style.display = name===tab ? 'block' : 'none'; }
            });
        }

        // Live template preview for Create Certificate
        const templateInput = document.getElementById('certTemplateInput');
        const bgImg = document.getElementById('certBg');
        const canvas = document.getElementById('certCanvas');
        const uploadZone = document.getElementById('certUploadZone');
        const controlsBox = document.getElementById('certControlsBox');
        const modeStandard = document.getElementById('certModeStandard');
        const modeCustom = document.getElementById('certModeCustom');
        const STANDARD_CERT_URL = "{{ asset('images/capdev cert.jpg') }}";
        const ov = {
            name: document.getElementById('ovName'),
            course: document.getElementById('ovCourse'),
            number: document.getElementById('ovNumber'),
            date: document.getElementById('ovDate'),
        };
        const f = {
            name: document.getElementById('certName'),
            course: document.getElementById('certCourse'),
            date: document.getElementById('certDate'),
            number: document.getElementById('certNumber'),
        };
        const pos = {
            nameX: document.getElementById('posNameX'),
            nameY: document.getElementById('posNameY'),
            courseX: document.getElementById('posCourseX'),
            courseY: document.getElementById('posCourseY'),
            numberX: document.getElementById('posNumberX'),
            numberY: document.getElementById('posNumberY'),
            dateX: document.getElementById('posDateX'),
            dateY: document.getElementById('posDateY'),
            fontName: document.getElementById('fontName'),
            fontCourse: document.getElementById('fontCourse'),
            fontNumber: document.getElementById('fontNumber'),
            fontDate: document.getElementById('fontDate'),
        };
        const STD = {
            nameX: 320, nameY: 285, fontName: 80,
            courseX: 365, courseY: 465, fontCourse: 60,
            numberX: 1120, numberY: 812, fontNumber: 25,
            dateX: 1120, dateY: 840, fontDate: 25
        };
        let currentBgDataUrl = null; // normalized 1400x990 png for server

        function updateOverlay() {
            function fmtDate(val){
                if(!val) return '00/00/0000';
                try{
                    const d = new Date(val);
                    const mm = String(d.getMonth()+1).padStart(2,'0');
                    const dd = String(d.getDate()).padStart(2,'0');
                    const yyyy = d.getFullYear();
                    if(isNaN(d.getTime())) return '00/00/0000';
                    return mm+'/'+dd+'/'+yyyy;
                }catch(_){ return '00/00/0000'; }
            }
            ov.name.textContent = f.name.value || 'FULLNAME SAMPLE';
            ov.course.textContent = f.course.value || 'COURSE NAME SAMPLE';
            ov.number.textContent = f.number.value || 'CERT-0000';
            ov.date.textContent = fmtDate(f.date.value);
            const box = document.getElementById('certPreviewBox');
            const w = 1400, h = 990;
            const rect = box.getBoundingClientRect();
            const rx = rect.width / w, ry = rect.height / h;
            ov.name.style.left = (pos.nameX.value * rx) + 'px';
            ov.name.style.top  = (pos.nameY.value * ry) + 'px';
            ov.course.style.left = (pos.courseX.value * rx) + 'px';
            ov.course.style.top  = (pos.courseY.value * ry) + 'px';
            ov.number.style.left = (pos.numberX.value * rx) + 'px';
            ov.number.style.top  = (pos.numberY.value * ry) + 'px';
            ov.date.style.left = (pos.dateX.value * rx) + 'px';
            ov.date.style.top  = (pos.dateY.value * ry) + 'px';
            ov.name.style.fontSize = (pos.fontName.value * rx) + 'px';
            ov.course.style.fontSize = (pos.fontCourse.value * rx) + 'px';
            ov.number.style.fontSize = (pos.fontNumber.value * rx) + 'px';
            ov.date.style.fontSize = (pos.fontDate.value * rx) + 'px';
        }
        ['input','change'].forEach(ev=>{
            [f.name,f.course,f.date,f.number,pos.nameX,pos.nameY,pos.courseX,pos.courseY,pos.numberX,pos.numberY,pos.dateX,pos.dateY,pos.fontName,pos.fontCourse,pos.fontNumber,pos.fontDate].forEach(el=>{
                if(el){ el.addEventListener(ev, updateOverlay); }
            });
        });
        updateOverlay();

        async function renderPdfFirstPageToImg(file){
            const url = URL.createObjectURL(file);
            const pdf = await window.pdfjsLib.getDocument(url).promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 2.0 });
            const cvs = document.createElement('canvas');
            const ctx = cvs.getContext('2d');
            cvs.width = viewport.width;
            cvs.height = viewport.height;
            await page.render({ canvasContext: ctx, viewport }).promise;
            URL.revokeObjectURL(url);
            return cvs.toDataURL('image/png');
        }
        async function renderDocxToImg(file){
            const container = document.createElement('div');
            container.style.position='absolute';
            container.style.left='-99999px';
            document.body.appendChild(container);
            await window.docx.renderAsync(file, container, undefined, { inWrapper:false });
            const dataUrl = await window.html2canvas(container, { scale:2 }).then(c=>c.toDataURL('image/png'));
            container.remove();
            return dataUrl;
        }
        async function setBackgroundFromFile(file){
            if(!file) return;
            if(file.size > 10*1024*1024){ alert('Max 10MB'); return; }
            const name = (file.name||'').toLowerCase();
            let dataUrl = null;
            if(name.endsWith('.png') || name.endsWith('.jpg') || name.endsWith('.jpeg')){
                dataUrl = await new Promise((res)=>{
                    const r = new FileReader(); r.onload = ()=>res(r.result); r.readAsDataURL(file);
                });
            } else if (name.endsWith('.pdf')){
                dataUrl = await renderPdfFirstPageToImg(file);
            } else if (name.endsWith('.docx')){
                dataUrl = await renderDocxToImg(file);
            } else {
                alert('Unsupported format'); return;
            }
            bgImg.src = dataUrl;
            bgImg.style.display='block';
            canvas.style.display='none';
            currentBgDataUrl = await normalizeBackground(dataUrl);
            updateOverlay();
        }
        async function normalizeBackground(dataUrl){
            // resize to 1400x990 for consistent PDF render
            return new Promise((resolve)=>{
                const img = new Image();
                img.onload = ()=>{
                    const w=1400,h=990; const c=document.createElement('canvas'); c.width=w; c.height=h;
                    const ctx=c.getContext('2d'); ctx.fillStyle='#fff'; ctx.fillRect(0,0,w,h);
                    const ratio = Math.min(w/img.width, h/img.height);
                    const dw = img.width*ratio, dh = img.height*ratio;
                    const dx = (w-dw)/2, dy = (h-dh)/2;
                    ctx.drawImage(img, dx, dy, dw, dh);
                    resolve(c.toDataURL('image/png'));
                };
                img.src = dataUrl;
            });
        }
        if(templateInput){
            templateInput.addEventListener('change', function(){
                const f = this.files && this.files[0];
                setBackgroundFromFile(f);
            });
        }
        // Support loading a standard certificate image as background
        async function setBackgroundFromUrl(url){
            return new Promise((resolve)=>{
                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.onload = async ()=>{
                    const c = document.createElement('canvas');
                    const ctx = c.getContext('2d');
                    c.width = img.naturalWidth || 1400;
                    c.height = img.naturalHeight || 990;
                    ctx.drawImage(img,0,0);
                    const dataUrl = c.toDataURL('image/png');
                    bgImg.src = dataUrl;
                    bgImg.style.display='block';
                    canvas.style.display='none';
                    currentBgDataUrl = await normalizeBackground(dataUrl);
                    updateOverlay();
                    resolve();
                };
                img.onerror = ()=>resolve();
                img.src = url;
            });
        }
        function applyModeUI(){
            if(modeStandard && modeStandard.checked){
                if(uploadZone){ uploadZone.style.display = 'none'; }
                if(controlsBox){ controlsBox.style.display = 'none'; }
                setBackgroundFromUrl(STANDARD_CERT_URL);
                // Apply standard coordinates and sizes
                pos.nameX.value = STD.nameX; pos.nameY.value = STD.nameY; pos.fontName.value = STD.fontName;
                pos.courseX.value = STD.courseX; pos.courseY.value = STD.courseY; pos.fontCourse.value = STD.fontCourse;
                pos.numberX.value = STD.numberX; pos.numberY.value = STD.numberY; pos.fontNumber.value = STD.fontNumber;
                pos.dateX.value = STD.dateX; pos.dateY.value = STD.dateY; pos.fontDate.value = STD.fontDate;
                updateOverlay();
            } else {
                if(uploadZone){ uploadZone.style.display = 'block'; }
                if(controlsBox){ controlsBox.style.display = 'grid'; }
                bgImg.src = '';
                bgImg.style.display='none';
                canvas.style.display='none';
                currentBgDataUrl = null;
                updateOverlay();
            }
        }
        if(modeStandard){ modeStandard.addEventListener('change', applyModeUI); }
        if(modeCustom){ modeCustom.addEventListener('change', applyModeUI); }
        applyModeUI();
        document.getElementById('btnDownloadFinal').addEventListener('click', async function(e){
            e.preventDefault();
            if(!currentBgDataUrl){ alert('Upload a template first.'); return; }
            const payload = {
                template_bg_data: currentBgDataUrl,
                recipient_name: f.name.value || '',
                course_name: f.course.value || '',
                completion_date: f.date.value || '',
                certificate_number: f.number.value || '',
                pos: {
                    name: { x: parseInt(pos.nameX.value||'0'), y: parseInt(pos.nameY.value||'0') },
                    course:{ x: parseInt(pos.courseX.value||'0'), y: parseInt(pos.courseY.value||'0') },
                    number:{ x: parseInt(pos.numberX.value||'0'), y: parseInt(pos.numberY.value||'0') },
                    date:  { x: parseInt(pos.dateX.value||'0'), y: parseInt(pos.dateY.value||'0') },
                },
                font: {
                    name: parseInt(pos.fontName.value||'38'),
                    course: parseInt(pos.fontCourse.value||'28'),
                    number: parseInt(pos.fontNumber.value||'16'),
                    date: parseInt(pos.fontDate.value||'16'),
                }
            };
            const res = await fetch('{{ route('admin.certifications.preview.generate') }}', {
                method:'POST',
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/pdf','Content-Type':'application/json'},
                body: JSON.stringify(payload)
            });
            if(!res.ok){ alert('Failed to generate certificate'); return; }
            const blob = await res.blob();
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href=url; a.download='certificate_preview.pdf'; a.click();
            setTimeout(()=>URL.revokeObjectURL(url), 1000);
        });

        function openCertImagePreview(url){
            var list=document.getElementById('certListWrapper');
            var prev=document.getElementById('certInlinePreview');
            var img=document.getElementById('certInlineImg');
            if(list) list.style.display='none';
            if(img){ img.src=url; }
            if(prev) prev.style.display='block';
        }
        function closeCertImagePreview(){
            var list=document.getElementById('certListWrapper');
            var prev=document.getElementById('certInlinePreview');
            var img=document.getElementById('certInlineImg');
            if(prev) prev.style.display='none';
            if(list) list.style.display='block';
            if(img){ img.src=''; }
        }
        document.addEventListener('keydown',function(e){
            if(e.key==='Escape'){ closeCertImagePreview(); }
        });

        function toggleCertMenu(id){
            var menu=document.getElementById('menu-'+id);
            if(!menu) return;
            var open=document.querySelectorAll('.menu.open'); open.forEach(function(m){ if(m!==menu) m.classList.remove('open'); });
            menu.classList.toggle('open');
        }
        document.addEventListener('click',function(e){
            var target=e.target;
            if(target.closest('.kebab') || target.closest('.menu')) return;
            document.querySelectorAll('.menu.open').forEach(function(m){ m.classList.remove('open'); });
        });

        // Auto-dismiss flash alerts after minimum 10 seconds with manual close support
        (function(){
            var alerts=document.querySelectorAll('.flash-alert[data-auto-dismiss]');
            alerts.forEach(function(a){
                setTimeout(function(){
                    if(!a) return;
                    a.classList.add('flash-hide');
                    setTimeout(function(){ a && a.remove(); }, 250);
                }, 10000);
            });
        })();

        // Filter Logic
        function addFilter(value) {
            if (!value) return;
            
            const [type, val] = value.split(':');
            const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
            
            // Find the checkbox
            const checkbox = document.querySelector(`input[name="${inputName}"][value="${val}"]`);
            if (checkbox) {
                checkbox.checked = true;
                renderActiveFilters();
                // Trigger change event for existing listeners
                checkbox.dispatchEvent(new Event('change'));
            }
            
            // Reset dropdown
            document.getElementById('filterDropdown').value = "";
        }

        function removeFilter(type, val) {
            const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
            const checkbox = document.querySelector(`input[name="${inputName}"][value="${val}"]`);
            if (checkbox) {
                checkbox.checked = false;
                renderActiveFilters();
                // Trigger change event for existing listeners
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
                const label = val === 'freeze'
                    ? 'Blocked'
                    : val === 'trainer'
                        ? 'Coach'
                    : val.charAt(0).toUpperCase() + val.slice(1);
                
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

        // Course-based certification now navigates to per-course page

        document.addEventListener('DOMContentLoaded', function() {
            // Initial render of active filters
            renderActiveFilters();
            initProfileLocationDropdowns();
            // Check for validation errors and reopen modals if necessary
            @if($errors->create_course->any())
                openAddCourseModal();
            @endif

            @if($errors->update_course->any())
                // We need to re-open the edit modal, but we might not have the course ID easily available if it was a redirect.
                // However, Laravel's old() helper can help populate the form, but the modal ID logic is tricky without the ID.
                // For now, if there's an update error, we might just show a global alert or rely on the user clicking edit again.
                // Actually, let's just make sure the Add modal opens. 
                // For Edit, since we need the specific course data, it's harder to auto-open without passing the ID back.
                // But typically validation redirects back.
            @endif

            // Auto-dismiss alerts after 3 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-success');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000);

            const filterForm = document.getElementById('filterForm');
            const searchInput = document.getElementById('searchInput');
            const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
            const tableContainer = document.getElementById('usersTableContainer');

            function fetchUsers(url) {
                // Add opacity to indicate loading
                tableContainer.style.opacity = '0.5';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    tableContainer.style.opacity = '1';
                    
                    // Update URL without page reload
                    window.history.pushState({}, '', url);

                    // Re-attach pagination listeners since content was replaced
                    attachPaginationListeners();
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableContainer.style.opacity = '1';
                });
            }

            function buildQueryString() {
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);
                return '?' + params.toString();
            }

            // Debounce function for search input
            let debounceTimer;
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const url = "{{ route('dashboard') }}" + buildQueryString();
                    fetchUsers(url);
                }, 300); // Wait 300ms after last keystroke
            });

            // Handle checkbox changes
            filterCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const url = "{{ route('dashboard') }}" + buildQueryString();
                    fetchUsers(url);
                });
            });

            // Handle pagination clicks
            function attachPaginationListeners() {
                const paginationLinks = tableContainer.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.href;
                        fetchUsers(url);
                    });
                });
            }

            // Initial attachment of pagination listeners
            attachPaginationListeners();

            // Course Search Logic
            const courseSearchInput = document.getElementById('courseSearchInput');
            if(courseSearchInput){
                courseSearchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const cards = document.querySelectorAll('#course-management .course-card');
                    
                    cards.forEach(card => {
                        if (card.classList.contains('add-course-card')) {
                            card.style.display = '';
                            return;
                        }
                        const titleNode = card.querySelector('h3');
                        if (!titleNode) {
                            card.style.display = '';
                            return;
                        }
                        const title = titleNode.textContent.toLowerCase();
                        if (title.includes(filter)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });

        // Operational Focus helpers
        function focusPendingUsers(){
            showContent('user-management', document.querySelector('.menu-item[onclick*=\'user-management\']'));
            addFilter('status:pending');
        }
        function focusBlockedUsers(){
            showContent('user-management', document.querySelector('.menu-item[onclick*=\'user-management\']'));
            addFilter('status:freeze');
        }
        function openPendingCourses(){
            window.location.href='{{ route('dashboard', ['tab' => 'pending-courses']) }}';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
            const LOGO_MAIN = "{{ asset('images/capdev_pro_w-removebg-preview.png') }}";
            const LOGO_SMALL = "{{ asset('images/logo1.png') }}";
            const sidebarLogo = document.getElementById('sidebarLogo');
            const collapsed = document.body.classList.contains('sidebar-collapsed');
            if(sidebarLogo){ sidebarLogo.src = collapsed ? LOGO_SMALL : LOGO_MAIN; }
        }

        function showContent(sectionId, element) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Update active menu item
            if (element) {
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });
                element.classList.add('active');
            }

            // Keep address bar in sync with selected sidebar section.
            const url = new URL(window.location.href);
            if (sectionId === 'dashboard-home') {
                url.searchParams.delete('tab');
                url.searchParams.delete('step');
            } else {
                url.searchParams.set('tab', sectionId);
                if (sectionId !== 'course-create') {
                    url.searchParams.delete('step');
                }
            }
            window.history.pushState({}, '', url.toString());

            const titles = {
                'dashboard-home': 'Dashboard',
                'user-management': 'User Management',
                'user-details-section': 'User Details',
                'course-management': 'Course Management',
                'course-library': 'Course Library',
                'roles-management': 'Roles Management',
                'certification-management': 'Certifications',
                'system-settings': 'System Settings',
                'access-management': 'Access Control'
            };
            const sidebarTitleEl = document.getElementById('sidebar-section-title');
            if(sidebarTitleEl){ sidebarTitleEl.textContent = titles[sectionId] || 'Dashboard'; }
            const headerTitleEl = document.getElementById('header-section-title');
            if(headerTitleEl){ headerTitleEl.textContent = titles[sectionId] || 'Dashboard'; }
        }
        
        document.addEventListener('DOMContentLoaded', function(){
            const active = document.querySelector('.content-section.active');
            if(active){
                const id = active.id;
                const titles = {
                    'dashboard-home': 'Dashboard',
                    'user-management': 'User Management',
                    'user-details-section': 'User Details',
                    'course-management': 'Course Management',
                    'course-library': 'Course Library',
                    'roles-management': 'Roles Management',
                    'certification-management': 'Certifications',
                    'access-management': 'Access Control'
                };
                const headerTitleEl = document.getElementById('header-section-title');
                if(headerTitleEl){ headerTitleEl.textContent = titles[id] || 'Dashboard'; }
                const sidebarTitleEl = document.getElementById('sidebar-section-title');
                if(sidebarTitleEl){ sidebarTitleEl.textContent = titles[id] || 'Dashboard'; }
            }
        });

        // Helper function to navigate to a section by ID
        function navigateToSection(sectionId) {
            if (sectionId === 'draft-courses') {
                openDraftCoursesModal();
                return;
            }
            const menuItem = Array.from(document.querySelectorAll('.menu-item')).find(item => 
                item.getAttribute('onclick') && item.getAttribute('onclick').includes(sectionId)
            );
            showContent(sectionId, menuItem);
        }

        // Modal Functions
        function openDisplaySection(user) {
            // Hide all sections and show display section
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('landing-page-display-section').classList.add('active');
            
            // Remove active class from menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            // Populate Form Fields
            document.getElementById('display_user_name_header').innerText = 'Edit Display Details: ' + user.name;
            document.getElementById('display_user_id').value = user.id;
            document.getElementById('display_additional_details').value = user.additional_details || '';
            document.getElementById('display_type').value = user.display_type || '';
            
            // Handle Image Preview
            const preview = document.getElementById('display_image_preview');
            const placeholder = document.getElementById('display_image_placeholder');
            
            if (user.profile_picture) {
                preview.src = '/storage/' + user.profile_picture;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
            
            // Set Form Action
            const form = document.getElementById('landingPageDisplayForm');
            form.action = `/users/${user.id}/display-details`;
        }

        function previewDisplayImage(input) {
            const preview = document.getElementById('display_image_preview');
            const placeholder = document.getElementById('display_image_placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeDisplayDetails() {
            if (!confirm('Are you sure you want to remove this user from the landing page display?')) return;
            
            const form = document.getElementById('landingPageDisplayForm');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_display';
            input.value = '1';
            form.appendChild(input);
            form.submit();
        }

        function getUserManagementMenuItem() {
            return document.querySelector('.menu-item[onclick*=\'user-management\']');
        }

        function initializeUserDetailsSection() {
            const mount = document.getElementById('userDetailsMount');
            const modal = document.getElementById('viewUserModal');
            const content = modal ? modal.querySelector('.modal-content.profile-edit-modal') : null;
            if (!mount || !modal || !content || mount.contains(content)) return;
            mount.appendChild(content);
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        let currentViewingUser = null;

        function openViewModal(user) {
            currentViewingUser = user;
            // Persist for refresh
            sessionStorage.setItem('current_viewing_user', JSON.stringify(user));
            const form = document.getElementById('viewUserForm');
            const formatLabel = (value) => {
                const raw = String(value || '').trim();
                if (!raw) return '-';
                const lower = raw.toLowerCase();
                if (lower === 'freeze') return 'Blocked';
                if (lower === 'trainer' || lower === 'coach' || lower.endsWith('_coach')) return 'Coach';
                if (lower === 'training_manager' || lower.endsWith('_training_manager')) return 'Training Manager';
                if (lower === 'admin' || lower.endsWith('_admin')) return 'Admin';
                if (lower === 'participant' || lower === 'trainee' || lower.endsWith('_participants')) return 'Participant';
                return raw.charAt(0).toUpperCase() + raw.slice(1);
            };
             
            // Populate fields
            document.getElementById('view_name').value = user.name;
            document.getElementById('view_email').value = user.email;
            document.getElementById('view_role').value = normalizeAccessRole(user.role);
            document.getElementById('view_status').value = user.status;
            document.getElementById('view_password').value = ''; // Reset password field
            applyAccessRole(user.role || '');

            const initial = document.getElementById('modalUserInitial');
            if (initial) {
                const name = String(user.name || '').trim();
                initial.textContent = name ? name.charAt(0).toUpperCase() : 'U';
            }
            const modalEmail = document.getElementById('modalUserEmail');
            if (modalEmail) modalEmail.textContent = user.email || '-';

            const roleBadge = document.getElementById('modalRoleBadge');
            if (roleBadge) {
                roleBadge.setAttribute('data-role', user.role || '');
                const roleValue = roleBadge.querySelector('.chip-value');
                if (roleValue) roleValue.textContent = formatLabel(user.role);
            }

            const statusBadge = document.getElementById('modalStatusBadge');
            if (statusBadge) {
                statusBadge.setAttribute('data-status', user.status || '');
                const statusValue = statusBadge.querySelector('.chip-value');
                if (statusValue) statusValue.textContent = formatLabel(user.status);
            }

            // Set Form Action
            form.action = `/users/${user.id}`;

            // Reset UI to View Mode
            disableEditMode();

            // Update Permissions UI
            const permCheckboxes = document.querySelectorAll('.permission-option-input');
            permCheckboxes.forEach(cb => cb.checked = false);
            
            // 1. Determine the relevant system block and expand it
            const role = String(user.role || '').toLowerCase();
            let targetSystemId = null;
            if (role === 'admin' || role.includes('_admin')) targetSystemId = 'system-admin';
            else if (role === 'training_manager' || role === 'registrar' || role.includes('_training_manager')) targetSystemId = 'system-tm';
            else if (role === 'trainer' || role === 'coach' || role.includes('_coach')) targetSystemId = 'system-coach';
            else if (role === 'participant' || role === 'trainee' || role.includes('_participants')) targetSystemId = 'system-participant';

            // Reset all accordions first
            document.querySelectorAll('.permission-accordion').forEach(acc => acc.classList.remove('active'));

            if (targetSystemId) {
                toggleAccordion(targetSystemId); // Expand the relevant accordion
            }

            // 2. Check permissions based on the database source of truth
            const roleObj = ALL_ROLES.find(r => r.name === user.role);
            const rolePermIds = roleObj ? (ALL_ROLE_PERMISSIONS[roleObj.id] || []) : [];
            
            permCheckboxes.forEach(cb => {
                const val = cb.value;
                const isNumeric = !isNaN(val) && !isNaN(parseFloat(val));
                
                if (isNumeric) {
                    const permId = parseInt(val);
                    if (rolePermIds.includes(permId)) {
                        cb.checked = true;
                    }
                } else {
                    // Fallback: if value is a string name, resolve it using PERM_LOOKUP
                    const resolvedId = Object.keys(PERM_LOOKUP).find(id => PERM_LOOKUP[id] === val);
                    if (resolvedId && rolePermIds.includes(parseInt(resolvedId))) {
                        cb.checked = true;
                    }
                }
            });

            // 3. Reset all "Unsaved" badges for initial load
            document.querySelectorAll('.unsaved-badge').forEach(badge => badge.style.display = 'none');
            updateAllSystemSelectStates();

            (function setInitialOfficeLevel(){
                const lvl = document.getElementById('view_office_level');
                let guess = null;
                if (user && user.region) {
                    if (user.region === 'DILG Central Office') guess = 'DILG Central Office';
                    else if (user.region === 'DILG Regional Office') guess = 'DILG Regional Office';
                    else if (user.region === 'DILG Provincial Office') guess = 'DILG Provincial Office';
                }
                if (!guess) {
                    const role = user.role || '';
                    const central = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                    const regional = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                    const provincial = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                    if (central.includes(role)) guess = 'DILG Central Office';
                    else if (regional.includes(role)) guess = 'DILG Regional Office';
                    else if (provincial.includes(role)) guess = 'DILG Provincial Office';
                }
                if (lvl && guess) {
                    lvl.value = guess;
                    window.FORCED_OFFICE_GROUP = guess === 'DILG Central Office' ? 'central' : (guess === 'DILG Regional Office' ? 'regional' : (guess === 'DILG Provincial Office' ? 'provincial' : null));
                } else {
                    window.FORCED_OFFICE_GROUP = null;
                }
            })();
            initViewLocationDropdowns(
                user.region || '',
                user.province || '',
                user.city || '',
                user.barangay || ''
            );
            initializeUserDetailsSection();
            showContent('user-details-section', getUserManagementMenuItem());
            const mainContent = document.querySelector('.main-content');
            if (mainContent) {
                mainContent.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            const officeSel = document.getElementById('view_office_level');
            if (officeSel) {
                officeSel.addEventListener('change', function(){
                    window.FORCED_OFFICE_GROUP = this.value === 'DILG Central Office' ? 'central' : (this.value === 'DILG Regional Office' ? 'regional' : (this.value === 'DILG Provincial Office' ? 'provincial' : null));
                    const curRegion = document.getElementById('view_region')?.value || '';
                    const curProvince = document.getElementById('view_province')?.value || '';
                    const curCity = document.getElementById('view_city')?.value || '';
                    const curBarangay = document.getElementById('view_barangay')?.value || '';
                    initViewLocationDropdowns(curRegion, curProvince, curCity, curBarangay);
                });
            }
            (function resetTabsToRoles(){
                const trigger = document.querySelector('.modal-tab[data-target="section-roles"]');
                if (trigger) trigger.click();
            })();
        }

        function closeViewModal() {
            disableEditMode();
            showContent('user-management', getUserManagementMenuItem());
        }

        document.addEventListener('keydown', function(event) {
            if (event.key !== 'Escape') return;
            const detailsSection = document.getElementById('user-details-section');
            if (detailsSection && detailsSection.classList.contains('active')) {
                closeViewModal();
            }
        });

        function enableEditMode() {
            console.log("Entering Edit Mode...");
            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('modalSubtitle').innerText = 'Modify fields below, then click Update User to apply changes.';
            
            // Enable inputs
            const inputs = document.querySelectorAll('#viewUserForm input, #viewUserForm select');
            inputs.forEach(input => input.disabled = false);
            
            const canManage = typeof CAN_MANAGE_ACCESS !== 'undefined' ? CAN_MANAGE_ACCESS : true;
            console.log("Can manage access:", canManage);
            
            const permOptions = document.querySelectorAll('.permission-option');
            permOptions.forEach(opt => {
                const input = opt.querySelector('.permission-option-input');
                if (input) input.disabled = !canManage;
                opt.classList.toggle('disabled', !canManage);
            });

            const selectAllBoxes = document.querySelectorAll('.select-all-box');
            selectAllBoxes.forEach(box => {
                box.classList.toggle('disabled', !canManage);
            });
             
            // Buttons
            document.getElementById('btnEdit').style.display = 'none';
            document.getElementById('btnCancel').style.display = 'inline-flex';
            document.getElementById('btnUpdate').style.display = 'inline-flex';
            syncViewLocationSelectState();
        }

        function disableEditMode() {
            document.getElementById('modalTitle').innerText = currentViewingUser ? currentViewingUser.name : 'User Details';
            document.getElementById('modalSubtitle').innerText = 'Switch to edit mode to update account information and access settings.';
            
            // Disable inputs
            const inputs = document.querySelectorAll('#viewUserForm input, #viewUserForm select');
            inputs.forEach(input => input.disabled = true);
            
            const permOptions = document.querySelectorAll('.permission-option');
            permOptions.forEach(opt => {
                const input = opt.querySelector('.permission-option-input');
                if (input) input.disabled = true;
                opt.classList.add('disabled');
            });

            const selectAllBoxes = document.querySelectorAll('.select-all-box');
            selectAllBoxes.forEach(box => {
                box.classList.add('disabled');
            });

            const passwordInput = document.getElementById('view_password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            if (passwordInput) passwordInput.type = 'password';
            if (eyeIcon) eyeIcon.style.display = 'block';
            if (eyeOffIcon) eyeOffIcon.style.display = 'none';
             
            // Buttons
            document.getElementById('btnEdit').style.display = 'inline-flex';
            document.getElementById('btnCancel').style.display = 'none';
            document.getElementById('btnUpdate').style.display = 'none';
            syncViewLocationSelectState();
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('view_password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            if (!passwordInput || !eyeIcon || !eyeOffIcon) return;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }

        function toggleAccordion(id) {
            const accordion = document.getElementById(id);
            if (!accordion) return;
            
            // Close other accordions
            document.querySelectorAll('.permission-accordion').forEach(acc => {
                if (acc.id !== id) {
                    acc.classList.remove('active');
                }
            });
            
            accordion.classList.toggle('active');
        }

        function toggleSystemPermissions(systemBlockId) {
            const block = document.getElementById(systemBlockId);
            if (!block) return;
            const inputs = block.querySelectorAll('.permission-option-input');
            if (inputs.length === 0) return;
            
            // Check if ANY are unchecked
            const anyUnchecked = Array.from(inputs).some(i => !i.checked);
            // If any are unchecked, we check them all. Otherwise, we uncheck them all.
            inputs.forEach(i => i.checked = anyUnchecked);
            
            updateSystemSelectState(systemBlockId);
            
            // Show unsaved badge
            const badge = document.getElementById(`unsaved-${systemBlockId}`);
            if (badge) badge.style.display = 'inline-flex';
        }

        function updateSystemSelectState(systemBlockId) {
            const block = document.getElementById(systemBlockId);
            if (!block) return;
            const inputs = block.querySelectorAll('.permission-option-input');
            const selectAllCircle = block.querySelector('.select-all-circle');
            if (!selectAllCircle || inputs.length === 0) return;
            
            const systemColors = {
                'system-admin': '#2563eb',
                'system-tm': '#f97316',
                'system-coach': '#ef4444',
                'system-participant': '#fbbf24'
            };
            const color = systemColors[systemBlockId] || '#f97316';
            const bgColor = color.startsWith('#') ? hexToRgb(color, 0.1) : 'rgba(249, 115, 22, 0.1)';
            
            const allChecked = Array.from(inputs).every(i => i.checked);
            if (allChecked) {
                selectAllCircle.style.borderColor = color;
                selectAllCircle.style.background = bgColor;
                selectAllCircle.classList.add('checked-all');
                // Dynamically update the ::after color
                selectAllCircle.setAttribute('data-color', color);
            } else {
                selectAllCircle.style.borderColor = '';
                selectAllCircle.style.background = '';
                selectAllCircle.classList.remove('checked-all');
                selectAllCircle.removeAttribute('data-color');
            }
        }

        function hexToRgb(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        function updateAllSystemSelectStates() {
            const systemBlocks = document.querySelectorAll('.permission-accordion');
            systemBlocks.forEach(block => updateSystemSelectState(block.id));
        }

        // Add a style rule for checked-all using data-color attribute
        const style = document.createElement('style');
        style.innerHTML = `
            .permission-option-circle.checked-all[data-color="#2563eb"]::after { background: #2563eb; }
            .permission-option-circle.checked-all[data-color="#f97316"]::after { background: #f97316; }
            .permission-option-circle.checked-all[data-color="#ef4444"]::after { background: #ef4444; }
            .permission-option-circle.checked-all[data-color="#fbbf24"]::after { background: #fbbf24; }
        `;
        document.head.appendChild(style);

        // Update Select All state and Unsaved badge when any permission is toggled
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('permission-option-input')) {
                const block = e.target.closest('.permission-accordion');
                if (block) {
                    updateSystemSelectState(block.id);
                    // Show unsaved badge for this block
                    const badge = document.getElementById(`unsaved-${block.id}`);
                    if (badge) badge.style.display = 'inline-flex';
                }
            }
        });

        function submitUpdate() {
            if (confirm('Are you sure you want to update this user?')) {
                const form = document.getElementById('viewUserForm');
                
                // Collect all checked permissions
                const checkedPerms = Array.from(document.querySelectorAll('.permission-option-input:checked')).map(cb => cb.value);
                // Collect all possible permissions shown in the UI
                const allUIPerms = Array.from(document.querySelectorAll('.permission-option-input')).map(cb => cb.value);
                
                let permInput = form.querySelector('input[name="permissions_data"]');
                if (!permInput) {
                    permInput = document.createElement('input');
                    permInput.type = 'hidden';
                    permInput.name = 'permissions_data';
                    form.appendChild(permInput);
                }
                
                let allPermInput = form.querySelector('input[name="all_ui_permissions"]');
                if (!allPermInput) {
                    allPermInput = document.createElement('input');
                    allPermInput.type = 'hidden';
                    allPermInput.name = 'all_ui_permissions';
                    form.appendChild(allPermInput);
                }

                permInput.value = JSON.stringify(checkedPerms);
                allPermInput.value = JSON.stringify(allUIPerms);

                const btn = document.getElementById('btnUpdate');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                    btn.disabled = true;
                }

                setTimeout(() => {
                    form.submit();
                }, 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            initializeUserDetailsSection();
            const params = new URLSearchParams(window.location.search);
            const requestedTab = params.get('tab');
            
            if (requestedTab === 'user-details-section') {
                const stored = sessionStorage.getItem('current_viewing_user');
                if (stored) {
                    try {
                        const user = JSON.parse(stored);
                        currentViewingUser = user; // Ensure global state is set
                        // Small delay to ensure initializeUserDetailsSection and DOM are stable
                        setTimeout(() => {
                            openViewModal(user);
                        }, 100);
                    } catch (e) {
                        console.error('Failed to restore user from session storage', e);
                    }
                }
            }

            if (requestedTab === 'profile-section') {
                showProfile();
            }

            if (requestedTab === 'course-create') {
                const isDraft = sessionStorage.getItem('load_draft') === '1';
                openAddCourseModal(isDraft, { preserveState: true });
            } else if (requestedTab === 'course-management' && params.get('open_add_course') === '1') {
                openAddCourseModal();
            }

            const forceProfile = {{ isset($forceProfile) && $forceProfile ? 'true' : 'false' }};
            if (forceProfile) {
                showProfile();
                alert('Please complete your profile to continue.');
            }

            const tabs = document.querySelectorAll('.modal-tab');
            const sections = ['section-core','section-roles','section-permissions','section-location','section-security'];
            tabs.forEach(btn => {
                btn.addEventListener('click', function(){
                    const target = this.getAttribute('data-target');
                    document.querySelectorAll('.modal-tab').forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-selected', 'false');
                        b.style.color = '#64748b';
                        b.style.borderBottomColor = 'transparent';
                    });
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');
                    this.style.color = 'var(--primary-blue)';
                    this.style.borderBottomColor = 'var(--primary-blue)';
                    sections.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.style.display = (id === target) ? 'block' : 'none';
                    });
                });
            });

            document.querySelectorAll('.role-choice-input').forEach(input => {
                input.addEventListener('change', function(){
                    if (this.disabled) return;
                    applyAccessRole(this.value || '');
                    const curRegion = document.getElementById('view_region')?.value || '';
                    const curProvince = document.getElementById('view_province')?.value || '';
                    const curCity = document.getElementById('view_city')?.value || '';
                    const curBarangay = document.getElementById('view_barangay')?.value || '';
                    initViewLocationDropdowns(curRegion, curProvince, curCity, curBarangay);
                });
            });
        });

        const courseCreateEmbeddedUrl = @json(route('admin.courses.create', ['embedded' => 1]));
        const COURSE_CREATE_STEP_SLUGS = new Set(['details', 'modules', 'certificate', 'finalize']);
        function getCourseCreateStepFromUrl(urlLike = window.location.href) {
            try {
                const url = new URL(urlLike, window.location.origin);
                const step = String(url.searchParams.get('step') || '').trim().toLowerCase();
                return COURSE_CREATE_STEP_SLUGS.has(step) ? step : '';
            } catch (e) {
                return '';
            }
        }
        function buildCourseCreateFrameUrl(options = {}) {
            const { step = getCourseCreateStepFromUrl(), bustCache = false } = options;
            const url = new URL(courseCreateEmbeddedUrl, window.location.origin);
            if (step && COURSE_CREATE_STEP_SLUGS.has(step)) {
                url.searchParams.set('step', step);
            }
            if (bustCache) {
                url.searchParams.set('t', String(Date.now()));
            }
            return url.toString();
        }

        const ROLE_ID_BY_NAME = @json(isset($roles) ? $roles->pluck('id','name') : []);
        const ROLE_PERMS = @json(isset($rolePermissions) ? $rolePermissions : []);
        const PERM_LOOKUP = @json(isset($permissions) ? $permissions->pluck('name','id') : []);

        const ACCESS_ROLE_VALUES = {
            admin: @json($adminAccessRole ?? 'admin'),
            training_manager: @json($managerAccessRole ?? 'training_manager'),
            coach: @json($coachAccessRole ?? 'trainer'),
            participant: @json($participantAccessRole ?? 'participant')
        };

        function normalizeAccessRole(roleName) {
            const raw = String(roleName || '').trim().toLowerCase();
            if (!raw) return '';
            if (raw === 'admin' || raw.endsWith('_admin')) return ACCESS_ROLE_VALUES.admin;
            if (raw === 'training_manager' || raw === 'registrar' || raw.endsWith('_training_manager')) return ACCESS_ROLE_VALUES.training_manager;
            if (raw === 'trainer' || raw === 'coach' || raw.endsWith('_coach')) return ACCESS_ROLE_VALUES.coach;
            if (raw === 'participant' || raw === 'trainee' || raw.endsWith('_participants')) return ACCESS_ROLE_VALUES.participant;
            return raw;
        }

        function syncRoleOptionSelection(roleName) {
            const normalized = normalizeAccessRole(roleName);
            const roleInput = document.getElementById('view_role');
            if (roleInput && normalized) roleInput.value = normalized;
            document.querySelectorAll('.role-choice-card').forEach(card => {
                const selected = card.getAttribute('data-role-value') === normalized;
                card.classList.toggle('is-selected', selected);
                const radio = card.querySelector('.role-choice-input');
                if (radio) radio.checked = selected;
            });
        }

        function applyAccessRole(roleName) {
            const normalized = normalizeAccessRole(roleName);
            const roleInput = document.getElementById('view_role');
            if (roleInput) roleInput.value = normalized;
            syncRoleOptionSelection(normalized);
            setPermissionsForRole(normalized);
        }

        function setPermissionsForRole(roleName) {
            const sel = document.getElementById('view_permissions');
            if (!sel) return;
            const normalized = normalizeAccessRole(roleName);
            const rid = ROLE_ID_BY_NAME && normalized ? ROLE_ID_BY_NAME[normalized] : null;
            const ids = (rid && ROLE_PERMS && ROLE_PERMS[rid]) ? ROLE_PERMS[rid].map(String) : [];
            Array.from(sel.options).forEach(opt => {
                opt.selected = ids.includes(String(opt.value));
            });
        }

        (function initPermissionsSelect() {
            const sel = document.getElementById('view_permissions');
            if (!sel) return;
        })();

        function ensureCourseCreateFrameLoaded() {
            const frame = document.getElementById('courseCreateFrame');
            if (frame && !frame.getAttribute('src')) {
                frame.setAttribute('src', buildCourseCreateFrameUrl());
            }
        }

        // Add Course in Dashboard Main Content
        function openAddCourseModal(forceDraft = false, options = {}) {
            const { preserveState = false } = options;
            // Signal to course-create NOT to load any draft unless explicitly told
            if (!forceDraft && !preserveState) {
                sessionStorage.setItem('load_draft', '0');
                sessionStorage.removeItem('draft_course_key');
                // Also clear the default draft keys for new courses to ensure it's empty
                localStorage.removeItem('draft_course_active_new');
                localStorage.removeItem('draft_course_create');
            }
            
            const frame = document.getElementById('courseCreateFrame');
            if (frame) {
                const nextSrc = buildCourseCreateFrameUrl({ bustCache: !preserveState });
                if (preserveState) {
                    if (!frame.getAttribute('src')) {
                        frame.src = nextSrc;
                    }
                } else {
                    frame.src = nextSrc;
                }
            }
            showContent('course-create', document.querySelector(".menu-item[onclick*='course-management']"));
        }
        function closeAddCourseModal() {
            showContent('course-management', document.querySelector(".menu-item[onclick*='course-management']"));
        }

        // Edit Course Modal
        function openEditCourseModal(course) {
            const modal = document.getElementById('editCourseModal');
            const form = document.getElementById('editCourseForm');
            form.action = `/courses/${course.id}`;
            document.getElementById('edit_course_name').value = course.name;
            document.getElementById('edit_course_description').value = course.description;
            document.getElementById('edit_course_subject_area').value = course.subject_area;
            modal.style.display = "block";
        }
        function closeEditCourseModal() {
            document.getElementById('editCourseModal').style.display = "none";
        }

        

        // Module Builder (Add Course Modal)
        let moduleCount = 0;
        function escapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
        function createModule() {
            const title = prompt('Enter module title');
            if (!title) return;
            const index = moduleCount++;
            const container = document.getElementById('modulesContainer');
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.05);';
            wrapper.innerHTML = `
                <input type="hidden" name="modules[${index}][title]" value="${escapeHtml(title)}">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;cursor:pointer;" onclick="toggleModuleBody(this.nextElementSibling)">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:28px;height:28px;border-radius:50%;background:var(--primary-green);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">${index+1}</div>
                        <h3 style="margin:0;color:var(--primary-blue);font-size:1rem;">Module ${index+1}: ${escapeHtml(title)}</h3>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="module-body" style="display:none;padding:10px 14px 14px 52px;">
                    <div class="topics"></div>
                    <button type="button" onclick="addTopic(this, ${index})" style="margin-top:8px;background:#00a859;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">+ Add Topic</button>
                </div>
            `;
            container.appendChild(wrapper);
        }
        function toggleModuleBody(body){
            if(!body) return;
            body.style.display = (body.style.display === 'none' || body.style.display === '') ? 'block' : 'none';
        }
        function addTopic(btn, moduleIndex){
            const title = prompt('Enter topic title');
            if (!title) return;
            const topics = btn.parentElement.querySelector('.topics');
            const idx = topics.children.length;
            const row = document.createElement('div');
            row.style.cssText = 'display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px dashed #eee;';
            row.innerHTML = `
                <input type="hidden" name="modules[${moduleIndex}][topics][${idx}][title]" value="${escapeHtml(title)}">
                <span style="color:#6b7280;">${moduleIndex+1}.${idx+1}</span>
                <span>${escapeHtml(title)}</span>
            `;
            topics.appendChild(row);
        }

        // Archived Courses Modal
        function openCloneCourseModal(course) {
            document.getElementById('clone_course_id').value = course.id;
            document.getElementById('clone_course_name').value = course.name;
            document.getElementById('cloneCourseModal').style.display = 'flex';
        }

        function closeCloneCourseModal() {
            document.getElementById('cloneCourseModal').style.display = 'none';
        }

        function filterByAcademicYearManagement(yearId) {
            const url = new URL(window.location.href);
            url.searchParams.set('academic_year_id', yearId);
            url.searchParams.set('tab', 'course-management');
            window.location.href = url.toString();
        }

        function filterByAcademicYear(yearId) {
            const url = new URL(window.location.href);
            url.searchParams.set('academic_year_id', yearId);
            url.searchParams.set('tab', 'course-library');
            window.location.href = url.toString();
        }

        function filterLibraryCourses() {
            const query = document.getElementById('librarySearchInput').value.toLowerCase();
            const items = document.querySelectorAll('.library-course-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function openDraftCoursesModal() {
            const modal = document.getElementById('draftCoursesModal');
            if (modal) {
                modal.style.display = 'flex';
                renderDraftCoursesInModal();
            }
        }
        function closeDraftCoursesModal() {
            const modal = document.getElementById('draftCoursesModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
        function openArchivedCoursesModal() {
            navigateToSection('archived-courses');
        }

        function getDraftCoursesFromLocalStorage() {
            let drafts = [];
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (!key) continue;
                if (key === 'draft_course_create' || key === 'draft_course_active_new' || key.startsWith('draft_course_new_') || key.startsWith('draft_course_edit_')) {
                    const raw = localStorage.getItem(key);
                    if (raw && raw !== '{}' && raw !== 'null') {
                        try {
                            const data = JSON.parse(raw);
                            drafts.push({ key: key, data: data });
                        } catch(e) {}
                    }
                }
            }
            return drafts;
        }
        function renderDraftCoursesInModal() {
            const container = document.getElementById('draftCoursesModalContainer');
            const drafts = getDraftCoursesFromLocalStorage();
            
            if (drafts.length === 0) {
                container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #fff; border-radius: 12px; border: 2px dashed #e5e7eb;"><i class="fas fa-file-pen" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 16px; display: block;"></i><p style="color: #64748b; font-weight: 600; margin: 0;">You have no draft courses yet.</p></div>';
                return;
            }
            
            container.innerHTML = '';
            drafts.forEach((draft, index) => {
                const courseName = draft.data.name || 'Untitled Course';
                const courseDesc = draft.data.description || 'No description';
                const card = document.createElement('div');
                card.style.cssText = 'background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s ease;';
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
        function renderDraftCoursesInMain() {
            // Deprecated, use renderDraftCoursesInModal
            renderDraftCoursesInModal();
        }
        function getDraftCoursesDashboardCount() {
            try {
                let count = 0;
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (!key) continue;
                    if (key === 'draft_course_create' || key === 'draft_course_active_new' || key.startsWith('draft_course_new_') || key.startsWith('draft_course_edit_')) {
                        const raw = localStorage.getItem(key);
                        if (raw && raw !== '{}' && raw !== 'null') {
                            count++;
                        }
                    }
                }
                return count;
            } catch (e) {
                return 0;
            }
        }

        function refreshDraftCoursesDashboardCount() {
            const valueNode = document.getElementById('draftCoursesCount');
            if (!valueNode) return;
            const count = getDraftCoursesDashboardCount();
            valueNode.textContent = String(count);
            
            // Also check if we should open the modal (from a redirect)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('open_drafts') === '1' || urlParams.get('tab') === 'draft-courses') {
                openDraftCoursesModal();
                // Clean up URL without refreshing
                let search = window.location.search
                    .replace(/[?&]open_drafts=1/, '')
                    .replace(/[?&]tab=draft-courses/, '');
                search = search.startsWith('&') ? '?' + search.substring(1) : search;
                const newUrl = window.location.pathname + search;
                window.history.replaceState({}, '', newUrl);
            }
        }

        document.addEventListener('DOMContentLoaded', refreshDraftCoursesDashboardCount);
        window.addEventListener('focus', refreshDraftCoursesDashboardCount);
        window.addEventListener('storage', function(event) {
            if (!event.key || event.key === 'draft_course_create' || event.key.startsWith('draft_course_new_') || event.key.startsWith('draft_course_edit_')) {
                refreshDraftCoursesDashboardCount();
            }
        });

        @if(session('open_archived_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            navigateToSection('archived-courses');
        });
        @endif

        // View Course Modal
        const courseShowUrlTemplate = @json(route('admin.courses.show', ['course' => '__COURSE_ID__']));

        function isCourseManagementTabActive() {
            const section = document.getElementById('course-management');
            return !!(section && section.classList.contains('active'));
        }

        function setCourseModalClickLock(isLocked) {
            const header = document.querySelector('.header');
            const dashboardContainer = document.querySelector('.dashboard-container');

            if (header) {
                header.style.pointerEvents = isLocked ? 'none' : '';
            }

            if (dashboardContainer) {
                dashboardContainer.style.pointerEvents = isLocked ? 'none' : '';
            }
        }

        function switchCourseViewTab(tabId, el) {
            // Update nav items
            document.querySelectorAll('.course-nav-item').forEach(item => item.classList.remove('active'));
            el.classList.add('active');

            // Update tab contents
            document.querySelectorAll('.course-tab-content').forEach(tab => tab.style.display = 'none');
            const targetTab = document.getElementById(`course-tab-${tabId}`);
            if (targetTab) {
                targetTab.style.display = 'block';
            }
        }

        async function openViewCourseModal(courseData) {
            // Instead of a modal, we now use the main content section
            showContent('course-view-details', document.querySelector('.menu-item[onclick*=\'course-management\']'));
            
            // Reset to Overview tab
            const firstTab = document.querySelector('.course-nav-item');
            if (firstTab) switchCourseViewTab('overview', firstTab);

            // Populate initial basic data
            document.getElementById('pro_view_course_name').innerText = courseData.name || 'Untitled Course';
            document.getElementById('pro_view_course_creator').innerText = courseData.creator_name || 'Admin';
            document.getElementById('pro_view_course_date').innerText = courseData.created_at || 'N/A';
            
            // Show loading states
            document.getElementById('pro_view_course_desc').innerHTML = '<p style="color:#94a3b8;">Loading course details...</p>';
            document.getElementById('pro_view_modules_container').innerHTML = '<div style="text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin" style="font-size:2rem;color:#2563eb;"></i></div>';
            
            try {
                const response = await fetch(`/courses/${courseData.id}/details-ajax`);
                const result = await response.json();
                
                if (result.ok) {
                    const c = result.course;
                    const escapeAdminHtml = (value) => String(value ?? '')
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#39;');
                    const parseTopicFields = (fieldsValue) => {
                        if (!fieldsValue) return [];
                        if (Array.isArray(fieldsValue)) return fieldsValue;
                        if (typeof fieldsValue === 'string') {
                            try {
                                const parsed = JSON.parse(fieldsValue);
                                return Array.isArray(parsed) ? parsed : [];
                            } catch (error) {
                                return [];
                            }
                        }
                        return [];
                    };
                    const renderAdminTopicFields = (fieldsValue) => {
                        const fields = parseTopicFields(fieldsValue);
                        if (!fields.length) {
                            return '<div class="topic-field-card" style="color:#64748b; font-weight:600;">No content added for this topic yet.</div>';
                        }

                        return fields.map((field, fieldIndex) => {
                            if (field.type === 'text') {
                                return `
                                    <div class="topic-field-card">
                                        ${field.html || '<div style="color:#64748b; font-weight:600;">No text content provided.</div>'}
                                    </div>
                                `;
                            }

                            if (field.type === 'question' && field.question) {
                                const question = field.question;
                                const options = Array.isArray(question.options) ? question.options : [];
                                const answerIndex = Number.isInteger(question.answer_index)
                                    ? question.answer_index
                                    : Number.parseInt(question.answer_index, 10);
                                const optionsHtml = options.length
                                    ? options.map((option, optionIndex) => `
                                        <div class="topic-choice-item ${optionIndex === answerIndex ? 'correct' : ''}">
                                            <span style="font-weight:800; min-width:22px;">${String.fromCharCode(65 + optionIndex)}.</span>
                                            <span>${escapeAdminHtml(option || '(Empty option)')}</span>
                                            ${optionIndex === answerIndex ? '<span style="margin-left:auto; font-size:0.75rem; font-weight:800;">CORRECT</span>' : ''}
                                        </div>
                                    `).join('')
                                    : '<div style="color:#64748b; font-weight:600;">No options added.</div>';

                                return `
                                    <div class="topic-field-card">
                                        <div style="font-size:0.75rem; font-weight:800; color:#2563eb; text-transform:uppercase; margin-bottom:8px;">Question ${fieldIndex + 1}</div>
                                        <div style="font-size:0.95rem; color:#1e293b; font-weight:700; margin-bottom:12px;">${escapeAdminHtml(question.title || 'Untitled question')}</div>
                                        <div style="display:grid; gap:10px;">
                                            ${optionsHtml}
                                        </div>
                                    </div>
                                `;
                            }

                            return `
                                <div class="topic-field-card">
                                    <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:8px;">Field Data</div>
                                    <pre style="margin:0; white-space:pre-wrap; color:#334155; font-size:0.85rem;">${escapeAdminHtml(JSON.stringify(field, null, 2))}</pre>
                                </div>
                            `;
                        }).join('');
                    };
                    const renderAdminTopicDetail = (moduleIndex, topicIndex, topic) => {
                        const subtopics = Array.isArray(topic?.subtopics) ? topic.subtopics : [];
                        if (subtopics.length > 0) {
                            return `
                                <div class="topic-detail-panel">
                                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:16px;">
                                        <div>
                                            <div style="font-size:0.75rem; font-weight:800; color:#2563eb; text-transform:uppercase;">Topic ${moduleIndex + 1}.${topicIndex + 1}</div>
                                            <div style="font-size:1rem; font-weight:800; color:#0f172a;">${escapeAdminHtml(topic?.title || 'Untitled Topic')}</div>
                                        </div>
                                        <span style="background:#eff6ff; color:#1d4ed8; font-size:0.75rem; font-weight:800; border-radius:999px; padding:6px 10px;">${subtopics.length} SUBTOPIC${subtopics.length === 1 ? '' : 'S'}</span>
                                    </div>
                                    <div style="display:grid; gap:12px;">
                                        ${subtopics.map((subtopic, subtopicIndex) => `
                                            <div class="topic-detail-card">
                                                <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:6px;">Subtopic ${moduleIndex + 1}.${topicIndex + 1}.${subtopicIndex + 1}</div>
                                                <div style="font-size:0.95rem; color:#1e293b; font-weight:700; margin-bottom:12px;">${escapeAdminHtml(subtopic?.title || 'Untitled Subtopic')}</div>
                                                <div style="display:grid; gap:10px;">
                                                    ${renderAdminTopicFields(subtopic?.fields ?? subtopic?.fields_json ?? null)}
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            `;
                        }

                        return `
                            <div class="topic-detail-panel">
                                <div style="margin-bottom:16px;">
                                    <div style="font-size:0.75rem; font-weight:800; color:#2563eb; text-transform:uppercase;">Topic ${moduleIndex + 1}.${topicIndex + 1}</div>
                                    <div style="font-size:1rem; font-weight:800; color:#0f172a;">${escapeAdminHtml(topic?.title || 'Untitled Topic')}</div>
                                </div>
                                <div style="display:grid; gap:10px;">
                                    ${renderAdminTopicFields(topic?.fields ?? topic?.fields_json ?? null)}
                                </div>
                            </div>
                        `;
                    };
                    
                    // Update badges
                    document.getElementById('view_course_category_badge').innerText = c.subject_area || 'General';
                    document.getElementById('pro_view_course_subject').innerText = c.subject_area || 'General';
                    const cert = c.certification || null;
                    document.getElementById('pro_view_course_certification').innerText = cert?.name || 'None';
                    document.getElementById('pro_view_course_cert').innerText = cert ? 'Certification Enabled' : 'No Certification';
                    document.getElementById('pro_view_cert_name').innerText = cert?.name || 'Certificate of Completion';
                    const certificateBody = document.getElementById('pro_view_certificate_body');
                    if (certificateBody) {
                        if (cert?.file_url) {
                            const certExt = (cert.file_path || '').split('.').pop().toLowerCase();
                            const isPdf = certExt === 'pdf';
                            const previewHtml = isPdf
                                ? `
                                    <div style="display:grid; gap:16px;">
                                        <iframe src="${cert.file_url}" style="width:100%; min-height:520px; border:1px solid #dbe2ee; border-radius:12px; background:#fff;" title="${cert.name} preview"></iframe>
                                        <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                                            <a href="${cert.file_url}" target="_blank" rel="noopener noreferrer" class="material-tag" style="justify-content:center;">
                                                <i class="fas fa-up-right-from-square"></i> Open Certificate
                                            </a>
                                        </div>
                                    </div>
                                `
                                : `
                                    <div style="display:grid; gap:16px;">
                                        <img src="${cert.file_url}" alt="${cert.name}" style="width:100%; max-height:520px; object-fit:contain; border:1px solid #dbe2ee; border-radius:12px; background:#fff; padding:12px;">
                                        <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                                            <a href="${cert.file_url}" target="_blank" rel="noopener noreferrer" class="material-tag" style="justify-content:center;">
                                                <i class="fas fa-up-right-from-square"></i> Open Certificate
                                            </a>
                                        </div>
                                    </div>
                                `;
                            certificateBody.innerHTML = `
                                <h4 id="pro_view_cert_name" style="margin: 0 0 16px; font-size: 1.5rem; font-weight: 800; color: #0f172a;">${cert.name}</h4>
                                ${previewHtml}
                                <p style="color: #64748b; margin-top: 4px; font-weight: 500;">Awarded upon successful completion of all course modules and assessments.</p>
                            `;
                        } else {
                            certificateBody.innerHTML = `
                                <i class="fas fa-certificate" style="font-size: 4rem; color: #f59e0b; margin-bottom: 20px;"></i>
                                <h4 id="pro_view_cert_name" style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a;">${cert?.name || 'Certificate of Completion'}</h4>
                                <p style="color: #64748b; margin-top: 12px; font-weight: 500;">Awarded upon successful completion of all course modules and assessments.</p>
                            `;
                        }
                    }
                    
                    // Description
                    document.getElementById('pro_view_course_desc').innerText = c.description || 'No description provided.';
                    
                    // Image
                    const imgEl = document.getElementById('pro_view_course_image');
                    if (c.image_path) {
                        imgEl.src = c.image_path;
                    } else {
                        imgEl.src = 'data:image/svg+xml;utf8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="160" viewBox="0 0 300 160"><rect width="300" height="160" rx="18" fill="#eef4ff"/><text x="150" y="80" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="14" font-weight="700">No Preview</text></svg>');
                    }

                    // Edit Button Link
                    const editBtn = document.getElementById('pro_view_edit_btn');
                    if (editBtn) {
                        editBtn.onclick = () => window.location.href = `/admin/courses/${c.id}/edit`;
                    }

                    // Archive and Delete forms
                    const archiveForm = document.getElementById('pro_view_archive_form');
                    const deleteForm = document.getElementById('pro_view_delete_form');
                    const archiveTitle = document.getElementById('pro_view_archive_title');
                    const archiveDesc = document.getElementById('pro_view_archive_desc');
                    const archiveBtn = document.getElementById('pro_view_archive_btn');
                    const archiveMethod = document.getElementById('pro_view_archive_method');

                    if (result.course.trashed) {
                        if (archiveForm) {
                            archiveForm.action = `/courses/${c.id}/restore`;
                            archiveForm.onsubmit = () => confirm('Unarchive this course?');
                        }
                        if (archiveMethod) archiveMethod.value = 'POST';
                        if (archiveTitle) archiveTitle.innerText = 'Restore Course';
                        if (archiveDesc) archiveDesc.innerText = 'Bring this course back to the library.';
                        if (archiveBtn) {
                            archiveBtn.innerHTML = '<i class="fas fa-rotate-left" style="margin-right: 6px;"></i> Restore Course';
                            archiveBtn.style.background = '#eff6ff';
                            archiveBtn.style.color = '#1e40af';
                            archiveBtn.style.borderColor = '#dbeafe';
                        }
                    } else {
                        if (archiveForm) {
                            archiveForm.action = `/courses/${c.id}`;
                            archiveForm.onsubmit = () => confirm('Are you sure you want to archive this course?');
                        }
                        if (archiveMethod) archiveMethod.value = 'DELETE';
                        if (archiveTitle) archiveTitle.innerText = 'Archive Course';
                        if (archiveDesc) archiveDesc.innerText = 'Archived courses are hidden from participants but can be restored later.';
                        if (archiveBtn) {
                            archiveBtn.innerHTML = '<i class="fas fa-archive" style="margin-right: 6px;"></i> Archive Course';
                            archiveBtn.style.background = '#f8fafc';
                            archiveBtn.style.color = '#64748b';
                            archiveBtn.style.borderColor = '#e2e8f0';
                        }
                    }

                    if (deleteForm) deleteForm.action = `/courses/${c.id}/force`;

                    const visibilityBadge = document.getElementById('pro_view_course_visibility_badge');
                    if (visibilityBadge) {
                        const isPublished = result.course.status === 'published' || result.course.is_published;
                        visibilityBadge.innerText = isPublished ? 'PUBLIC' : 'PRIVATE';
                        visibilityBadge.style.background = isPublished ? '#ecfdf5' : '#fef2f2';
                        visibilityBadge.style.color = isPublished ? '#10b981' : '#ef4444';
                    }

                    // Materials
                    const materialsContainer = document.getElementById('pro_view_materials_list');
                    materialsContainer.innerHTML = '';
                    if (c.materials && c.materials.length > 0) {
                        c.materials.forEach(m => {
                            const fileName = m.file_name || (m.file_path ? m.file_path.split('/').pop() : (m.title || 'Material'));
                            const ext = (fileName.split('.').pop() || '').toLowerCase();
                            let icon = 'fa-file';
                            if (ext === 'pdf') icon = 'fa-file-pdf';
                            else if (['doc', 'docx'].includes(ext)) icon = 'fa-file-word';
                            
                            const tag = document.createElement('a');
                            const fileUrl = m.file_url || (m.file_path ? `/storage/${m.file_path}` : '#');
                            tag.className = 'material-tag';
                            tag.href = fileUrl;
                            tag.target = '_blank';
                            tag.rel = 'noopener noreferrer';
                            tag.download = fileName;
                            tag.title = `Open ${fileName}`;
                            tag.innerHTML = `<i class="fas ${icon}"></i> ${fileName}`;
                            materialsContainer.appendChild(tag);
                        });
                    } else {
                        materialsContainer.innerHTML = '<p style="color:#94a3b8;font-size:0.9rem;font-weight:500;">No additional materials provided.</p>';
                    }

                    // Modules (Curriculum)
                    const modulesContainer = document.getElementById('pro_view_modules_container');
                    modulesContainer.innerHTML = '';
                    if (c.modules && c.modules.length > 0) {
                        c.modules.forEach((mod, idx) => {
                            const modItem = document.createElement('div');
                            modItem.className = 'module-list-item';
                            
                            let topicsHtml = '';
                            if (mod.topics && mod.topics.length > 0) {
                                topicsHtml = `
                                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:16px;">
                                        ${mod.topics.map((t, topicIdx) => `
                                            <button type="button" class="topic-badge" data-topic-index="${topicIdx}" aria-label="Open topic ${escapeAdminHtml(t.title || 'Topic')}">
                                                <i class="fas fa-play-circle" style="color:#2563eb;font-size:0.8rem;"></i>
                                                <span>${escapeAdminHtml(t.title || 'Untitled Topic')}</span>
                                            </button>
                                        `).join('')}
                                    </div>
                                `;
                            }

                            modItem.innerHTML = `
                                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                    <div>
                                        <span style="font-size:0.75rem; font-weight:800; color:#2563eb; text-transform:uppercase;">Module ${idx + 1}</span>
                                        <h4 style="margin:4px 0 0; font-size:1.15rem; font-weight:800; color:#0f172a;">${mod.title}</h4>
                                    </div>
                                    <span style="background:#f1f5f9; padding:4px 10px; border-radius:6px; font-size:0.7rem; font-weight:700; color:#64748b;">${mod.topics ? mod.topics.length : 0} TOPICS</span>
                                </div>
                                ${topicsHtml}
                                <div class="module-topic-detail-slot"></div>
                            `;
                            const topicDetailSlot = modItem.querySelector('.module-topic-detail-slot');
                            modItem.querySelectorAll('[data-topic-index]').forEach((topicBtn) => {
                                topicBtn.addEventListener('click', () => {
                                    const topicIndex = Number.parseInt(topicBtn.getAttribute('data-topic-index'), 10);
                                    const topic = Array.isArray(mod.topics) ? mod.topics[topicIndex] : null;
                                    if (!topic || !topicDetailSlot) {
                                        return;
                                    }

                                    const isAlreadyActive = topicBtn.classList.contains('active');
                                    modItem.querySelectorAll('[data-topic-index]').forEach((btn) => btn.classList.remove('active'));

                                    if (isAlreadyActive) {
                                        topicDetailSlot.innerHTML = '';
                                        return;
                                    }

                                    topicBtn.classList.add('active');
                                    topicDetailSlot.innerHTML = renderAdminTopicDetail(idx, topicIndex, topic);
                                });
                            });
                            modulesContainer.appendChild(modItem);
                        });
                    } else {
                        modulesContainer.innerHTML = '<div style="text-align:center;padding:40px;color:#64748b;"><p>No modules have been added to this curriculum yet.</p></div>';
                    }

                    // Assessments
                    const examsContainer = document.getElementById('pro_view_exams_container');
                    examsContainer.innerHTML = '';
                    if (c.assessments && c.assessments.length > 0) {
                        c.assessments.forEach((a, examIndex) => {
                            const typeLabel = (a.type || 'assessment').replace(/_/g, ' ').toUpperCase();
                            const metaBits = [
                                `<span><i class="fas fa-tasks"></i> ${typeLabel}</span>`,
                                `<span><i class="fas fa-question-circle"></i> ${a.question_count} Questions</span>`,
                                `<span><i class="fas fa-clock"></i> ${a.due_date}</span>`
                            ];
                            if (a.module_title) {
                                metaBits.push(`<span><i class="fas fa-layer-group"></i> ${a.module_title}</span>`);
                            }
                            const questions = Array.isArray(a.questions) ? a.questions : [];
                            const detailId = `pro-view-exam-detail-${examIndex}`;
                            const detailHtml = questions.length > 0
                                ? questions.map((q, qIdx) => {
                                    const text = q.text || q.question || q.title || `Question ${qIdx + 1}`;
                                    const qType = (q.type || 'question').replace(/_/g, ' ').toUpperCase();
                                    const choices = Array.isArray(q.choices) ? q.choices : (Array.isArray(q.options) ? q.options : []);
                                    const answerIndex = Number.isInteger(q.answer_index) ? q.answer_index : Number.parseInt(q.answer_index, 10);
                                    let answerHtml = '';
                                    if ((q.type || '') === 'multiple_choice' && choices.length > 0) {
                                        answerHtml = `
                                            <div class="exam-choice-list">
                                                ${choices.map((choice, choiceIdx) => `
                                                    <div class="exam-choice-item ${choiceIdx === answerIndex ? 'correct' : ''}">
                                                        <span style="font-weight:800; min-width:22px;">${String.fromCharCode(65 + choiceIdx)}.</span>
                                                        <span>${choice || '(Empty choice)'}</span>
                                                        ${choiceIdx === answerIndex ? '<span style="margin-left:auto; font-size:0.75rem; font-weight:800;">CORRECT</span>' : ''}
                                                    </div>
                                                `).join('')}
                                            </div>
                                        `;
                                    } else if ((q.type || '') === 'true_false') {
                                        const tfAnswer = q.answer === true ? 'True' : (q.answer === false ? 'False' : 'Not set');
                                        answerHtml = `
                                            <div class="exam-choice-list">
                                                <div class="exam-choice-item ${q.answer === true ? 'correct' : ''}">
                                                    <span style="font-weight:800; min-width:22px;">A.</span>
                                                    <span>True</span>
                                                    ${q.answer === true ? '<span style="margin-left:auto; font-size:0.75rem; font-weight:800;">CORRECT</span>' : ''}
                                                </div>
                                                <div class="exam-choice-item ${q.answer === false ? 'correct' : ''}">
                                                    <span style="font-weight:800; min-width:22px;">B.</span>
                                                    <span>False</span>
                                                    ${q.answer === false ? '<span style="margin-left:auto; font-size:0.75rem; font-weight:800;">CORRECT</span>' : ''}
                                                </div>
                                            </div>
                                            <div style="margin-top:10px; font-size:0.85rem; color:#64748b; font-weight:700;">Answer: ${tfAnswer}</div>
                                        `;
                                    } else if ((q.type || '') === 'identification') {
                                        answerHtml = `
                                            <div style="margin-top:10px; padding:10px 12px; border:1px dashed #cbd5e1; border-radius:10px; background:#f8fafc;">
                                                <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:4px;">Expected Answer</div>
                                                <div style="font-size:0.92rem; color:#1e293b; font-weight:700;">${q.answer || 'No answer set.'}</div>
                                            </div>
                                        `;
                                    } else if ((q.type || '') === 'essay') {
                                        answerHtml = `
                                            <div style="margin-top:10px; padding:10px 12px; border:1px dashed #cbd5e1; border-radius:10px; background:#f8fafc;">
                                                <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:4px;">Manual Review</div>
                                                <div style="font-size:0.92rem; color:#1e293b; font-weight:700;">Essay answer checked by trainer after submission.</div>
                                            </div>
                                        `;
                                    }
                                    return `
                                        <div class="exam-question-item">
                                            <div style="font-size:0.75rem; font-weight:800; color:#2563eb; text-transform:uppercase; margin-bottom:6px;">${qType}</div>
                                            <div style="font-size:0.95rem; color:#1e293b; font-weight:600;">${qIdx + 1}. ${text}</div>
                                            ${answerHtml}
                                        </div>
                                    `;
                                }).join('')
                                : '<p style="margin:0; color:#64748b;">No questions found for this exam.</p>';
                            const examItem = document.createElement('div');
                            examItem.style.cssText = 'padding:20px; background:#fff; border:1px solid #e2e8f0; border-radius:12px; margin-bottom:12px;';
                            examItem.innerHTML = `
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
                                    <div>
                                        <h4 style="margin:0; font-weight:800; color:#1e293b;">${a.title}</h4>
                                        <div style="margin-top:4px; display:flex; gap:16px; font-size:0.8rem; color:#64748b; font-weight:600; flex-wrap:wrap;">
                                            ${metaBits.join('')}
                                        </div>
                                    </div>
                                    <button type="button" class="btn" data-exam-toggle="${detailId}" style="background:#f1f5f9; color:#2563eb; font-weight:700; font-size:0.8rem; padding:6px 12px; border-radius:6px;">View Details</button>
                                </div>
                                <div id="${detailId}" class="exam-detail-panel" style="display:none;">
                                    <div style="display:grid; gap:12px;">
                                        <div>
                                            <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:6px;">Description</div>
                                            <div style="color:#475569; font-size:0.92rem;">${a.description || 'No description provided.'}</div>
                                        </div>
                                        <div>
                                            <div style="font-size:0.75rem; font-weight:800; color:#94a3b8; text-transform:uppercase; margin-bottom:10px;">Questions</div>
                                            <div style="display:grid; gap:10px;">
                                                ${detailHtml}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            const toggleBtn = examItem.querySelector('[data-exam-toggle]');
                            const detailEl = examItem.querySelector(`#${detailId}`);
                            if (toggleBtn && detailEl) {
                                toggleBtn.addEventListener('click', () => {
                                    const isOpen = detailEl.style.display !== 'none';
                                    detailEl.style.display = isOpen ? 'none' : 'block';
                                    toggleBtn.textContent = isOpen ? 'View Details' : 'Hide Details';
                                });
                            }
                            examsContainer.appendChild(examItem);
                        });
                    } else {
                        examsContainer.innerHTML = `
                            <div style="text-align: center; padding: 40px; color: #64748b;">
                                <i class="fas fa-clipboard-list" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                                <p style="font-weight: 600;">No assessments found for this course.</p>
                            </div>`;
                    }

                }
            } catch (err) {
                console.error("Failed to load course details:", err);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            const courseId = params.get('course_id');

            if (tab === 'course-view-details' && courseId) {
                openViewCourseModal({
                    id: courseId,
                    name: 'Loading...',
                    creator_name: 'Admin',
                    created_at: 'N/A'
                });
            }
        });

        function closeViewCourseModal() {
            showContent('course-library', document.querySelector('.menu-item[onclick*=\'course-management\']'));
        }



        // Close modal when clicking outside
        window.onclick = function(event) {
            const editUserModal = document.getElementById('editUserModal');
            const draftCoursesModal = document.getElementById('draftCoursesModal');
            const archivedCoursesModal = document.getElementById('archivedCoursesModal');

            if (event.target == editUserModal) {
                editUserModal.style.display = "none";
            }
            if (event.target == draftCoursesModal) {
                closeDraftCoursesModal();
            }
            if (event.target == archivedCoursesModal) {
                closeArchivedCoursesModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                // closeViewCourseModal(); // No longer needed for main content view
            }
        });
    </script>
    <script>
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
        function editDraftCourse(storageKey){
            const raw = localStorage.getItem(storageKey);
            if(!raw){ alert('Draft not found'); return; }
            try {
                const data = JSON.parse(raw);
                // Signal to course-create to LOAD this specific draft
                sessionStorage.setItem('load_draft', '1');
                sessionStorage.setItem('draft_course_key', storageKey);
                window.location.href = '/dashboard?tab=course-create';
            } catch(e) {
                alert('Error loading draft');
            }
        }
        function deleteDraftCourse(storageKey){
            if(!confirm('Delete this draft?')) return;
            localStorage.removeItem(storageKey);
            renderDraftCoursesInMain();
            refreshDraftCoursesDashboardCount();
        }
        document.addEventListener('click',function(ev){
            var menu=document.querySelector('.profile-menu');
            var d=document.getElementById('profileDropdown');
            if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}
        });
        document.querySelectorAll('.donut-chart').forEach(function(chart){
          var segs = chart.querySelectorAll('.donut-seg');
          segs.forEach(function(seg, i){
            var len = parseFloat(seg.getAttribute('data-length')) || 0;
            var circ = parseFloat(seg.getAttribute('data-circ')) || 0;
            if(len<=0){ return; }
            seg.setAttribute('stroke-dasharray', '0 ' + circ);
            setTimeout(function(){
              seg.setAttribute('stroke-dasharray', len + ' ' + circ);
            }, 60 + (i*80));
          });
        });
    </script>
</body>
</html>
