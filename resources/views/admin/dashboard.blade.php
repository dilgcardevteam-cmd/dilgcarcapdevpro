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
            --header-height: 80px;
        }
        @media (max-width: 1000px){
            .insight-grid,.insight-grid.insight-grid-alt{grid-template-columns:1fr}
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

        /* Header Styles (from Landing) */
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
            position: relative;
            z-index: 40;
        }

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
            background: linear-gradient(145deg, #002c76 0%, #17489f 58%, #1f7e3a 160%);
            box-shadow: 0 16px 34px rgba(2, 6, 23, 0.22);
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
            grid-template-columns: repeat(4, minmax(0, 1fr));
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

        #viewUserModal .close:hover,
        #viewUserModal .close:focus {
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

        #viewUserModal .field-with-icon input,
        #viewUserModal .field-with-icon select {
            padding-left: 36px;
        }

        #viewUserModal .field-with-icon select {
            padding-right: 34px;
        }

        #viewUserModal .form-group input:focus,
        #viewUserModal .form-group select:focus {
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

        .badge-role-admin { background: #1d4ed8; color: #ffffff; }
        .badge-role-registrar { background: #0284c7; color: #ffffff; }
        .badge-role-trainer { background: #16a34a; color: #ffffff; }
        .badge-role-trainee { background: #d97706; color: #ffffff; }

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
</head>
<body>
    <!-- Navbar -->
    <header class="header">
        <div class="header-left">
            
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
            </div>
        </div>
        <div class="header-right">
            <div class="profile-menu">
                <div class="user-profile-header" onclick="toggleProfileMenu(event)" style="cursor: pointer; display: flex; align-items: center; gap: 10px; margin-right: 10px;">
                    <div style="width: 40px; height: 40px; background-color: #ffffff; color: #9ca3af; border: 1px solid #9ca3af; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; overflow: hidden;">
                        @if(Auth::user()->profile_picture)
                            <img id="header_profile_image" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
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
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item {{ !request()->hasAny(['search', 'roles', 'statuses', 'page']) && !request('tab') ? 'active' : '' }}" onclick="showContent('dashboard-home', this)">
                    <div class="menu-icon"><i class="fas fa-home"></i></div>
                    <span class="menu-text">Dashboard</span>
                </li>
                <li class="menu-item {{ request()->hasAny(['search', 'roles', 'statuses', 'page']) || request('tab') == 'user-management' ? 'active' : '' }}" onclick="showContent('user-management', this)">
                    <div class="menu-icon"><i class="fas fa-users"></i></div>
                    <span class="menu-text">User Management</span>
                </li>
                <li class="menu-item {{ in_array(request('tab'), ['course-management', 'pending-courses', 'course-create']) ? 'active' : '' }}" onclick="showContent('course-management', this)">
                    <div class="menu-icon"><i class="fas fa-book"></i></div>
                    <span class="menu-text">Course Management</span>
                </li>
                <li class="menu-item {{ request('tab') == 'certification-management' ? 'active' : '' }}" onclick="showContent('certification-management', this)">
                    <div class="menu-icon"><i class="fas fa-certificate"></i></div>
                    <span class="menu-text">Certifications</span>
                </li>
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

                    </div>

                    <div class="stats-grid">
                        <div class="stat-card clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'user-management']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $userCount }}</h3>
                                <p>Total Accounts</p>
                                <div class="stat-meta">Active: {{ $activeUsersSafe }} | Pending: {{ $pendingUsersSafe }} | Blocked: {{ $frozenUsersSafe }}</div>
                            </div>
                        </div>

                        <div class="stat-card tone-green clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'course-management']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $courseCount }}</h3>
                                <p>Active Courses</p>
                                <div class="stat-meta">Archived: {{ $archivedCoursesSafe }}</div>
                            </div>
                        </div>

                        <div class="stat-card tone-orange clickable"
                            role="button"
                            tabindex="0"
                            onclick="window.location.href='{{ route('dashboard', ['tab' => 'pending-courses']) }}'"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="stat-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $pendingCoursesSafe }}</h3>
                                <p>Pending Course Reviews</p>
                            </div>
                        </div>

                        <div class="stat-card tone-slate clickable"
                            role="button"
                            tabindex="0"
                            onclick="showContent('certification-management', document.querySelector('.menu-item[onclick*=\'certification-management\']))"
                            onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); this.click(); }">
                            <div class="stat-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $certificationSafe }}</h3>
                                <p>Certification Templates</p>
                                <div class="stat-meta">Ready for issuance</div>
                            </div>
                        </div>
                    </div>

                    <div class="insight-grid">

                        @php
                            $provinceCounts = \App\Models\User::selectRaw('LOWER(TRIM(COALESCE(province,""))) as province, COUNT(*) as c')->groupBy('province')->pluck('c','province');
                            $pcMax = $provinceCounts->max() ?? 0;
                        @endphp
                        <div class="insight-panel">
                            <div class="insight-panel-header">
                                <h2>Users by Province</h2>
                                <span>Choropleth</span>
                            </div>
                            <div id="ph-map-wrap" style="display:flex;align-items:center;gap:18px;flex-wrap:wrap">
                                <div id="ph-map" style="width:100%;max-width:520px;height:360px;border:1px solid #e5eef7;border-radius:12px;overflow:hidden;background:#f8fbff;position:relative"></div>
                                <div id="ph-map-legend" style="display:grid;grid-template-columns:auto 1fr;gap:10px 12px;align-items:center;min-width:220px">
                                    <div style="width:12px;height:12px;border-radius:2px;background:#dbeafe"></div><div style="color:#002C76;font-weight:800">Low</div>
                                    <div style="width:12px;height:12px;border-radius:2px;background:#60a5fa"></div><div style="color:#002C76;font-weight:800">Medium</div>
                                    <div style="width:12px;height:12px;border-radius:2px;background:#1d4ed8"></div><div style="color:#002C76;font-weight:800">High</div>
                                </div>
                            </div>
                            <div id="ph-map-tooltip" style="position:absolute;display:none;background:#ffffff;border:1px solid #e5eef7;border-radius:8px;padding:8px 10px;box-shadow:0 8px 18px rgba(15,23,42,.08);pointer-events:none;color:#0B2C74;font-weight:700;font-size:.9rem"></div>
                            <div style="margin-top:10px;color:#64748b;font-size:.8rem">Map data © Contributors · Source: <a href="https://github.com/justinegealogo/philippines-region-province-citymuni-barangay" target="_blank" rel="noopener" style="color:#0B2C74;text-decoration:none">Philippines GeoJSON</a></div>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
                            <script>
                            (function(){
                              var countsInline = @json($provinceCounts);
                              var maxInline = @json($pcMax);
                              var container = document.getElementById('ph-map');
                              if(!container){ return; }
                              var width = container.clientWidth || 520, height = container.clientHeight || 360;
                              var svg = d3.select(container).append('svg').attr('width', width).attr('height', height);
                              var g = svg.append('g');
                              var tooltip = document.getElementById('ph-map-tooltip');
                              var urlLocal = '{{ asset('images/maps/ph-provinces.geojson') }}';
                              var urlRemote = 'https://raw.githubusercontent.com/justinegealogo/philippines-region-province-citymuni-barangay/master/geojson/philippines-province.geojson';
                              var urlRemote2 = 'https://raw.githubusercontent.com/faeldon/philippines-json-maps/master/2023/geojson/ph_provdists.lowres.geojson';
                              var countsUrl = '{{ route('stats.users.by-province') }}';
                              
                              function normalizeName(s){
                                return (s || '').toLowerCase().trim();
                              }
                              function render(geo){
                                if(!geo || !geo.features){ return; }
                                var projection = d3.geoMercator();
                                var path = d3.geoPath(projection);
                                projection.fitExtent([[10,10],[width-10,height-10]], geo);
                                var max = d3.max(Object.values(window.__provinceCounts || {})) || maxInline || 1;
                                var color = d3.scaleSequential(d3.interpolateBlues).domain([0, max]);
                                g.selectAll('path')
                                  .data(geo.features)
                                  .enter()
                                  .append('path')
                                  .attr('d', path)
                                  .attr('fill', function(d){
                                    var n = normalizeName(d.properties.NAME_1 || d.properties.name || d.properties.PROVINCE);
                                    var v = (window.__provinceCounts || {})[n] || 0;
                                    return color(v);
                                  })
                                  .attr('stroke', '#cfe0ff')
                                  .attr('stroke-width', 1.2)
                                  .on('mousemove', function(event, d){
                                    var n = (d.properties.NAME_1 || d.properties.name || d.properties.PROVINCE || '').trim();
                                    var v = (window.__provinceCounts || {})[normalizeName(n)] || 0;
                                    if(tooltip){
                                      tooltip.style.display='block';
                                      tooltip.innerHTML = n + ' · ' + v + ' users';
                                      var rect = container.getBoundingClientRect();
                                      tooltip.style.left = (event.clientX - rect.left + 12) + 'px';
                                      tooltip.style.top = (event.clientY - rect.top + 12) + 'px';
                                    }
                                  })
                                  .on('click', function(event, d){
                                    var n = (d.properties.NAME_1 || d.properties.name || d.properties.PROVINCE || '').trim();
                                    var v = (window.__provinceCounts || {})[normalizeName(n)] || 0;
                                    alert(n + ': ' + v + ' user(s)');
                                  })
                                  .on('mouseleave', function(){
                                    if(tooltip){ tooltip.style.display='none'; }
                                  });
                              }
                              function load(url){
                                d3.json(urlRemote).then(function(geo){ render(geo); }).catch(function(){
                                  d3.json(urlRemote2).then(function(geo){ render(geo); }).catch(function(){
                                    d3.json(urlLocal).then(function(geo){ render(geo); }).catch(function(){
                                      container.innerHTML = '<div style="padding:12px;color:#6b7280">Map data not found. Add file to '+urlLocal+'.</div>';
                                    });
                                  });
                                });
                              }
                              function loadCountsAndMap(){
                                window.__provinceCounts = countsInline || {};
                                fetch(countsUrl, {headers:{'X-Requested-With':'XMLHttpRequest'}})
                                  .then(function(res){ return res.ok ? res.json() : null; })
                                  .then(function(data){ 
                                    if(data && data.counts){ window.__provinceCounts = data.counts; } 
                                    load(urlLocal);
                                  })
                                  .catch(function(){ load(urlLocal); });
                              }
                              loadCountsAndMap();
                              window.addEventListener('resize', function(){
                                var w = container.clientWidth || 420, h = container.clientHeight || 320;
                                svg.attr('width', w).attr('height', h);
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
                                        <div id="total-courses" style="font-weight:800;color:#002C76;font-size:1.5rem;line-height:1">0</div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                        <div style="width:12px;height:12px;border-radius:50%;background:#002C76"></div><div style="color:#002C76;font-weight:800">Active <span id="course-legend-active" style="color:#6b7280;margin-left:6px"></span></div>
                                        <div style="width:12px;height:12px;border-radius:50%;background:#FFD700;border:1px solid #eab308"></div><div style="color:#002C76;font-weight:800">Pending <span id="course-legend-pending" style="color:#6b7280;margin-left:6px"></span></div>
                                        <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#002C76;font-weight:800">Archived <span id="course-legend-arch" style="color:#6b7280;margin-left:6px"></span></div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                (function(){
                                  function renderArcDonut(elId, parts, colors){
                                    var el=document.getElementById(elId);
                                    if(!el){return;}
                                    var width=220, height=220, r=80, ir=48;
                                    var svg=d3.select('#'+elId).append('svg').attr('width',width).attr('height',height);
                                    var g=svg.append('g').attr('transform','translate('+width/2+','+height/2+')');
                                    var total=parts.reduce(function(a,b){return a+b;},0);
                                    var pie=d3.pie().sort(null);
                                    var arc=d3.arc().innerRadius(ir).outerRadius(r).padAngle(0.03).cornerRadius(6);
                                    var data=pie(parts);
                                    g.selectAll('path').data(data).enter().append('path')
                                      .attr('d',arc)
                                      .attr('fill',function(d,i){return colors[i];})
                                      .attr('stroke','#ffffff')
                                      .attr('stroke-width','1.2')
                                      .on('mouseover', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1.03)'); })
                                      .on('mouseout', function(){ d3.select(this).transition().duration(150).attr('transform','scale(1)'); });
                                    // percentage labels on arcs
                                    g.selectAll('text').data(data).enter().append('text')
                                      .attr('transform', function(d){ return 'translate('+arc.centroid(d)+')'; })
                                      .attr('dy','.35em')
                                      .attr('text-anchor','middle')
                                      .attr('font-size','12px')
                                      .attr('fill','#0f172a')
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
                                  // Courses (no drafts)
                                  var cActive={{ $activeCoursesSafe ?? 0 }};
                                  var cPending={{ $pendingCoursesSafe ?? 0 }};
                                  var cArchived={{ $archivedCoursesSafe ?? 0 }};
                                  var cTotal=cActive+cPending+cArchived;
                                  document.getElementById('total-courses').innerText = cTotal;
                                  renderArcDonut('donut-courses', [cActive,cPending,cArchived], ['#002C76','#FFD700','#B10606']);
                                  document.getElementById('course-legend-active').innerText = cActive+' · '+pct(cActive,cTotal)+'%';
                                  document.getElementById('course-legend-pending').innerText = cPending+' · '+pct(cPending,cTotal)+'%';
                                  document.getElementById('course-legend-arch').innerText = cArchived+' · '+pct(cArchived,cTotal)+'%';
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
                                <li>
                                    <span>Pending user approvals</span>
                                    <strong>{{ $pendingUsersSafe }}</strong>
                                </li>
                                <li>
                                    <span>Blocked accounts</span>
                                    <strong>{{ $frozenUsersSafe }}</strong>
                                </li>
                                <li>
                                    <span>Course reviews waiting</span>
                                    <strong>{{ $pendingCoursesSafe }}</strong>
                                </li>
                            </ul>

                            <button type="button" class="focus-action" onclick="showContent('user-management', document.querySelector('.menu-item[onclick*=\'user-management\']))">
                                <i class="fas fa-bolt"></i> Open User Queue
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- User Management Section -->
            <section id="user-management" class="content-section {{ request()->hasAny(['search', 'roles', 'statuses', 'page']) || request('tab') == 'user-management' ? 'active' : '' }}">
                <div class="user-management-shell">
                    <div class="user-management-header">
                        <div>
                            <h1 class="welcome-title" style="margin-bottom: 0; font-weight: 700;">User Management</h1>
                            <p class="user-management-subtitle">Review accounts and manage user access.</p>
                        </div>
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
                                        <option value="role:admin">Admin</option>
                                        <option value="role:registrar">Registrar</option>
                                        <option value="role:trainer">Coach</option>
                                        <option value="role:trainee">Trainee</option>
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
                            <input type="checkbox" name="roles[]" value="trainer" class="filter-checkbox" {{ in_array('trainer', request('roles', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="roles[]" value="trainee" class="filter-checkbox" {{ in_array('trainee', request('roles', [])) ? 'checked' : '' }} hidden>
                            
                            <input type="checkbox" name="statuses[]" value="active" class="filter-checkbox" {{ in_array('active', request('statuses', [])) ? 'checked' : '' }} hidden>
                            <input type="checkbox" name="statuses[]" value="freeze" class="filter-checkbox" {{ in_array('freeze', request('statuses', [])) ? 'checked' : '' }} hidden>
                        </div>
                    </form>

                    <div id="usersTableContainer">
                        @include('admin.partials.users-table')
                    </div>
                </div>
            </section>

            <!-- Course Management Section -->
            <section id="course-management" class="content-section {{ request('tab') == 'course-management' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;">Course <strong>Management</strong></h1>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="courseSearchInput" placeholder="Search courses..." style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; width: 250px;">
                        <button onclick="navigateToSection('archived-courses')" style="background-color: #000080; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-box-archive"></i> Archived Courses
                        </button>
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
                </div>
                
                @if(session('success_course'))
                    <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('success_course') }}
                    </div>
                @endif

                <div class="course-grid">
                    <button type="button" class="course-card add-course-card" onclick="openAddCourseModal()" aria-label="Add Course" style="border:0;">
                        <span class="add-course-plus"><i class="fas fa-plus"></i></span>
                        <p class="add-course-title">Add Course</p>
                    </button>
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
                                    $img = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                }
                                if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                    $img = $course->image_path;
                                }
                                $ph = 'https://via.placeholder.com/600x300?text=' . urlencode($course->name);
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
                    <button type="button" onclick="navigateToSection('course-management')" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-arrow-left"></i> Back to Course Management
                    </button>
                </div>
                <div class="course-create-shell">
                    <iframe id="courseCreateFrame" title="Create course form" src="{{ request('tab') == 'course-create' ? route('admin.courses.create', ['embedded' => 1]) : '' }}"></iframe>
                </div>
            </section>

            <!-- Pending Courses Section -->
            <section id="pending-courses" class="content-section {{ request('tab') == 'pending-courses' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;">Pending <strong>Courses</strong></h1>
                    <button type="button" onclick="navigateToSection('course-management')" style="background-color: #002C76; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-arrow-left"></i> Back to Course Management
                    </button>
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
                                        $img = 'https://via.placeholder.com/300x150?text=' . urlencode($course->name);
                                    }
                                    if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                        $img = $course->image_path;
                                    }
                                    $ph = 'https://via.placeholder.com/600x300?text=' . urlencode($course->name);
                                @endphp
                                <img src="{{ $img }}" alt="{{ $course->name }}" style="width: 100%; height: 150px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ $ph }}'">
                                <div style="padding: 14px;">
                                    <h3 style="margin: 0 0 6px; color: #002C76; font-size: 1.05rem;">{{ $course->name }}</h3>
                                    <p style="color: #6b7280; font-size: .9rem; margin: 0 0 10px;">{{ Str::limit($course->description, 100) }}</p>
                                    @php
                                        $submitter = $course->users->firstWhere('role', 'trainer');
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

            <section id="draft-courses" class="content-section {{ request('tab') == 'draft-courses' ? 'active' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin:0;">Draft <strong>Courses</strong></h1>
                    <button type="button" onclick="navigateToSection('course-management')" style="background-color:#002C76;color:#fff;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;display:inline-flex;align-items:center;gap:8px">
                        <i class="fas fa-arrow-left"></i> Back to Course Management
                    </button>
                </div>
                <div id="draftCoursesMainContainer" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            </section>
            <section id="archived-courses" class="content-section {{ request('tab') == 'archived-courses' ? 'active' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <h1 class="welcome-title" style="margin:0;">Archived <strong>Courses</strong></h1>
                    <button type="button" onclick="navigateToSection('course-management')" style="background-color:#002C76;color:#fff;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;display:inline-flex;align-items:center;gap:8px">
                        <i class="fas fa-arrow-left"></i> Back to Course Management
                    </button>
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
                            <div class="course-card" role="button" tabindex="0" onclick="openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null)]) }})" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}" style="background:#fff;border-radius:10px;box-shadow:0 4px 6px rgba(0,0,0,0.05);overflow:hidden;cursor:pointer">
                                <img src="{{ $course->image_path ? asset('storage/' . $course->image_path).'?v='.$ver : 'https://via.placeholder.com/300x160?text=No+Image' }}" alt="{{ $course->name }}" style="width:100%;height:150px;object-fit:cover;filter:grayscale(100%)">
                                <div style="padding:15px">
                                    <h3 style="margin:0 0 8px;color:#6c757d;font-size:1rem">{{ $course->name }}</h3>
                                    <p style="color:#6c757d;margin-bottom:12px;font-size:.9rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $course->description }}</p>
                                    <div style="display:flex;gap:8px">
                                        <button type="button" onclick="event.stopPropagation(); openViewCourseModal({{ json_encode(['id' => $course->id, 'name' => $course->name, 'creator_name' => ($creator ? $creator->name : null)]) }})" style="flex:1;padding:8px;background:#17a2b8;color:#fff;border:none;border-radius:4px;cursor:pointer;text-align:center">View</button>
                                        <form action="{{ route('courses.restore', $course->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Unarchive this course?')" style="flex:1">
                                            @csrf
                                            <button type="submit" style="width:100%;padding:8px;background:#28a745;color:#fff;border:none;border-radius:4px;cursor:pointer">Unarchive</button>
                                        </form>
                                        <form action="{{ route('courses.force-delete', $course->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Permanently delete this course? This cannot be undone.')" style="flex:1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width:100%;padding:8px;background:#dc3545;color:#fff;border:none;border-radius:4px;cursor:pointer">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Certification Management Section -->
            <section id="certification-management" class="content-section {{ request('tab') == 'certification-management' ? 'active' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1 class="welcome-title" style="margin: 0;">Certification <strong>Management</strong></h1>
                    <button onclick="openAddCertificationModal()" style="background-color: var(--primary-green); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-plus"></i> Add Certification
                    </button>
                </div>

                @if(session('success_certification'))
                    <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('success_certification') }}
                    </div>
                @endif
                @if(session('error_certification'))
                    <div class="alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('error_certification') }}
                    </div>
                @endif

                <!-- Certifications List -->
                <h2 style="color: var(--primary-blue); border-bottom: 2px solid #eee; padding-bottom: 10px;">Certificates</h2>
                @if($certifications->isEmpty())
                    <div class="placeholder-content">
                        <p>No Certifications Added Yet</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
                        @foreach($certifications as $cert)
                            <div class="card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                                <h3 style="margin-top: 0; color: var(--primary-blue);">{{ $cert->name }}</h3>
                                <p style="color: #666; font-size: 0.9rem;"><strong>Category:</strong> {{ $cert->category ?? 'N/A' }}</p>
                                <div style="margin: 15px 0;">
                                    <a href="{{ Storage::url($cert->file_path) }}" target="_blank" style="color: var(--primary-blue); text-decoration: none;">
                                        <i class="fas fa-file-pdf"></i> View Certificate File
                                    </a>
                                </div>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <form action="{{ route('certifications.toggle-display', $cert->id) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <button type="submit" style="width: 100%; padding: 8px; background: {{ $cert->display_on_landing_page ? '#dc3545' : '#28a745' }}; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                            {{ $cert->display_on_landing_page ? 'Hide from Landing' : 'Display on Landing' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('certifications.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="width: 100%; padding: 8px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Course-based Certification -->
                <h2 style="color: var(--primary-blue); border-bottom: 2px solid #eee; padding-bottom: 10px;">Certify Enrolled Trainees</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:16px">
                    @foreach($courses as $course)
                    <a href="{{ route('admin.certifications.course', $course) }}" style="text-decoration:none;color:inherit">
                    <div class="course-card" data-course-id="{{ $course->id }}" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.05);overflow:hidden;cursor:pointer">
                        @php $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp; @endphp
                        <div style="height:120px;overflow:hidden">
                            @php
                                $img = null;
                                if (!empty($course->image_path)) {
                                    $path = public_path('storage/' . $course->image_path);
                                    if (file_exists($path)) {
                                        $img = asset('storage/' . $course->image_path) . '?v=' . $ver;
                                    }
                                }
                                if (!$img) {
                                    $img = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                }
                                if (!$img && !empty($course->image_path) && \Illuminate\Support\Str::startsWith($course->image_path, ['http://','https://'])) {
                                    $img = $course->image_path;
                                }
                                $ph = 'https://via.placeholder.com/600x300?text=' . urlencode($course->name);
                            @endphp
                            <img src="{{ $img }}" alt="{{ $course->name }}" style="width:100%;height:120px;object-fit:cover" onerror="this.onerror=null;this.src='{{ $ph }}'">
                        </div>
                        <div style="padding:12px">
                            <div style="font-weight:700;color:var(--primary-blue);line-height:1.2">{{ $course->name }}</div>
                            <div style="color:#6b7280;font-size:.85rem">{{ $course->subject_area ?? 'Uncategorized' }}</div>
                        </div>
                    </div>
                    </a>
                    @endforeach
                </div>
                <!-- Navigates to per-course certification page -->
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
                                    <div class="form-group">
                                        <label class="profile-field-label">
                                            <svg class="profile-field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path>
                                            </svg>
                                            Job Title
                                        </label>
                                        <input type="text" name="job_title" value="{{ Auth::user()->job_title }}" readonly class="profile-input">
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

                <div class="profile-section">
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
                            <label>Role</label>
                            <div class="field-with-icon">
                                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <select id="view_role" name="role" required disabled>
                                    <option value="admin">Admin</option>
                                    <option value="registrar">Registrar</option>
                                    <option value="trainer">Coach</option>
                                    <option value="trainee">Trainee</option>
                                </select>
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

                <div class="profile-section">
                    <p class="profile-section-title">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Location Details
                    </p>
                    <div class="profile-location-grid">
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

                <div class="profile-section">
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

    <!-- View Course Modal -->
    <div id="viewCourseModal" class="modal">
        <div class="modal-content">
            <div class="course-view-modal-header">
                <div class="course-view-modal-title-wrap">
                    <h2 id="view_course_name" class="course-view-modal-title">Course Details</h2>
                    <p id="view_course_creator" style="margin: 4px 0 0; color: #64748b; font-size: 0.85rem;">Created by: N/A</p>
                    <p id="view_course_created" style="margin: 0; color: #64748b; font-size: 0.85rem;">Created: N/A</p>
                </div>
                <button type="button" class="course-view-close" onclick="closeViewCourseModal()" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="course-view-modal-body">
                <div id="viewCourseLoading" class="course-view-loading">
                    <span>Loading course details...</span>
                </div>
                <iframe id="view_course_iframe" title="Course details"></iframe>
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

    <script>
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

                fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`)
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
                    ? `https://psgc.gitlab.io/api/regions/${code}/cities-municipalities/`
                    : `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`;

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

                fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`)
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

            fetch('https://psgc.gitlab.io/api/regions/')
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
                        option.textContent = `${region.name} (${region.regionName})`;
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

            function loadBarangays(cityCode, selectedBarangayValue = null) {
                resetSelect(barangaySelect, 'Select Barangay');
                syncViewLocationSelectState();

                if (!cityCode) {
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                    syncViewLocationSelectState();
                    return;
                }

                fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`)
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
                    ? `https://psgc.gitlab.io/api/regions/${code}/cities-municipalities/`
                    : `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`;

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

                fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`)
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

            fetch('https://psgc.gitlab.io/api/regions/')
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
                        option.textContent = `${region.name} (${region.regionName})`;
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

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
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
            } else {
                url.searchParams.set('tab', sectionId);
            }
            window.history.pushState({}, '', url.toString());
        }

        // Helper function to navigate to a section by ID
        function navigateToSection(sectionId) {
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

        function openViewModal(user) {
            const modal = document.getElementById('viewUserModal');
            const form = document.getElementById('viewUserForm');
            const formatLabel = (value) => {
                const raw = String(value || '').trim();
                if (!raw) return '-';
                if (raw.toLowerCase() === 'freeze') return 'Blocked';
                if (raw.toLowerCase() === 'trainer') return 'Coach';
                return raw.charAt(0).toUpperCase() + raw.slice(1);
            };
             
            // Populate fields
            document.getElementById('view_name').value = user.name;
            document.getElementById('view_email').value = user.email;
            document.getElementById('view_role').value = user.role;
            document.getElementById('view_status').value = user.status;
            document.getElementById('view_password').value = ''; // Reset password field

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
            initViewLocationDropdowns(
                user.region || '',
                user.province || '',
                user.city || '',
                user.barangay || ''
            );

            modal.style.display = 'flex';
        }

        function closeViewModal() {
            document.getElementById('viewUserModal').style.display = 'none';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key !== 'Escape') return;
            const modal = document.getElementById('viewUserModal');
            if (modal && modal.style.display === 'flex') {
                closeViewModal();
            }
        });

        function enableEditMode() {
            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('modalSubtitle').innerText = 'Modify fields below, then click Update User to apply changes.';
            
            // Enable inputs
            const inputs = document.querySelectorAll('#viewUserForm input, #viewUserForm select');
            inputs.forEach(input => input.disabled = false);
             
            // Buttons
            document.getElementById('btnEdit').style.display = 'none';
            document.getElementById('btnCancel').style.display = 'inline-flex';
            document.getElementById('btnUpdate').style.display = 'inline-flex';
            syncViewLocationSelectState();
        }

        function disableEditMode() {
            document.getElementById('modalTitle').innerText = 'User Details';
            document.getElementById('modalSubtitle').innerText = 'Switch to edit mode to update account information and access settings.';
            
            // Disable inputs
            const inputs = document.querySelectorAll('#viewUserForm input, #viewUserForm select');
            inputs.forEach(input => input.disabled = true);

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

        function submitUpdate() {
            if (confirm('Are you sure you want to update this user?')) {
                document.getElementById('viewUserForm').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const requestedTab = params.get('tab');
            if (requestedTab === 'profile-section') {
                showProfile();
            }

            if (requestedTab === 'course-create') {
                openAddCourseModal();
            } else if (requestedTab === 'course-management' && params.get('open_add_course') === '1') {
                openAddCourseModal();
            }

            const forceProfile = {{ isset($forceProfile) && $forceProfile ? 'true' : 'false' }};
            if (forceProfile) {
                showProfile();
                alert('Please complete your profile to continue.');
            }
        });

        const courseCreateEmbeddedUrl = @json(route('admin.courses.create', ['embedded' => 1]));

        function ensureCourseCreateFrameLoaded() {
            const frame = document.getElementById('courseCreateFrame');
            if (frame && !frame.getAttribute('src')) {
                frame.setAttribute('src', courseCreateEmbeddedUrl);
            }
        }

        // Add Course in Dashboard Main Content
        function openAddCourseModal() {
            // Clear the form for a new course
            sessionStorage.removeItem('draft_course_key');
            ensureCourseCreateFrameLoaded();
            // Clear form fields after iframe loads
            setTimeout(() => {
                const iframe = document.getElementById('courseCreateFrame');
                if (iframe && iframe.contentWindow) {
                    try {
                        const form = iframe.contentWindow.document.getElementById('courseForm');
                        if (form) form.reset();
                        // Explicitly clear main fields
                        const nameField = iframe.contentWindow.document.getElementById('name');
                        const descField = iframe.contentWindow.document.getElementById('description');
                        if (nameField) nameField.value = '';
                        if (descField) descField.value = '';
                        // Clear localStorage draft
                        iframe.contentWindow.localStorage.removeItem('draft_course_create');
                        iframe.contentWindow.localStorage.removeItem('draft_course_edit_');
                    } catch(e) {}
                }
            }, 500);
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
        function openDraftCoursesModal() {
            navigateToSection('draft-courses');
            renderDraftCoursesInMain();
        }
        function openArchivedCoursesModal() {
            navigateToSection('archived-courses');
        }

        function getDraftCoursesFromLocalStorage() {
            let drafts = [];
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (!key) continue;
                if (key === 'draft_course_create' || key.startsWith('draft_course_edit_')) {
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
        function renderDraftCoursesInMain() {
            const container = document.getElementById('draftCoursesMainContainer');
            const drafts = getDraftCoursesFromLocalStorage();
            
            if (drafts.length === 0) {
                container.innerHTML = '<p style="color: #6c757d; font-style: italic; grid-column: 1 / -1;">You have no draft courses yet.</p>';
                return;
            }
            
            container.innerHTML = '';
            drafts.forEach((draft, index) => {
                const courseName = draft.data.name || 'Untitled Course';
                const courseDesc = draft.data.description || 'No description';
                const card = document.createElement('div');
                card.className = 'course-card';
                card.style.cssText = 'background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; cursor: pointer;';
                card.innerHTML = `
                    <div style="width: 100%; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        <i class="fas fa-file-pen"></i>
                    </div>
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 8px; color: #333; font-size: 1rem;">${courseName}</h3>
                        <p style="color: #6c757d; margin-bottom: 12px; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${courseDesc}</p>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" onclick="event.stopPropagation(); editDraftCourse('${draft.key}');" style="flex: 1; padding: 8px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-align: center;">Edit</button>
                            <button type="button" onclick="event.stopPropagation(); deleteDraftCourse('${draft.key}')" style="flex: 1; padding: 8px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Delete</button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }
        function getDraftCoursesDashboardCount() {
            try {
                let count = 0;
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (!key) continue;
                    if (key === 'draft_course_create' || key.startsWith('draft_course_edit_')) {
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
            valueNode.textContent = String(getDraftCoursesDashboardCount());
        }

        document.addEventListener('DOMContentLoaded', refreshDraftCoursesDashboardCount);
        window.addEventListener('focus', refreshDraftCoursesDashboardCount);
        window.addEventListener('storage', function(event) {
            if (!event.key || event.key === 'draft_course_create' || event.key.startsWith('draft_course_edit_')) {
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

        function openViewCourseModal(course) {
            if (!course || !course.id) return;

            const modal = document.getElementById('viewCourseModal');
            const title = document.getElementById('view_course_name');
            const creator = document.getElementById('view_course_creator');
            const created = document.getElementById('view_course_created');
            const loader = document.getElementById('viewCourseLoading');
            const iframe = document.getElementById('view_course_iframe');
            const courseUrlBase = courseShowUrlTemplate.replace('__COURSE_ID__', encodeURIComponent(course.id));
            const activeSection = document.querySelector('.content-section.active');
            const isReadonlyContext = !!(activeSection && (activeSection.id === 'archived-courses' || activeSection.id === 'draft-courses'));
            const courseUrl = `${courseUrlBase}?embedded=1${isReadonlyContext ? '&readonly=1' : ''}`;

            if (title) {
                title.innerText = course.name ? course.name : 'Course Details';
            }
            if (creator) {
                creator.innerText = `Created by: ${course.creator_name ? course.creator_name : 'N/A'}`;
            }
            if (created) {
                created.innerText = `Created: ${course.created_at ? course.created_at : 'N/A'}`;
            }
            if (loader) {
                loader.style.display = 'flex';
            }
            if (iframe) {
                iframe.style.visibility = 'hidden';
                iframe.onload = function () {
                    if (loader) loader.style.display = 'none';
                    iframe.style.visibility = 'visible';
                };
                iframe.src = courseUrl;
            }

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            setCourseModalClickLock(isCourseManagementTabActive());
        }

        function closeViewCourseModal() {
            const modal = document.getElementById('viewCourseModal');
            const loader = document.getElementById('viewCourseLoading');
            const iframe = document.getElementById('view_course_iframe');

            modal.style.display = 'none';
            document.body.style.overflow = '';
            setCourseModalClickLock(false);

            if (iframe) {
                iframe.onload = null;
                iframe.removeAttribute('src');
                iframe.style.visibility = 'hidden';
            }
            if (loader) {
                loader.style.display = 'flex';
            }
        }



        // Close modal when clicking outside
        window.onclick = function(event) {
            const editUserModal = document.getElementById('editUserModal');
            const viewCourseModal = document.getElementById('viewCourseModal');
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
                closeViewCourseModal();
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
                // Store the storage key in session storage so course-create can load it
                sessionStorage.setItem('draft_course_key', storageKey);
                window.location.href = '/dashboard?tab=course-create';
            } catch(e) {
                alert('Error loading draft');
            }
        }
        function deleteDraftCourse(storageKey){
            if(!confirm('Delete this draft?')) return;
            localStorage.removeItem(storageKey);
            renderDraftCoursesInModal();
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
