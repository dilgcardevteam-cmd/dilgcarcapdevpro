<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COTM Dashboard - CAPDEV PRO</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        body {font-family: 'DM Sans', sans-serif;margin: 0;padding: 0;color: var(--dark-text);background-color: var(--bg-color);display: flex;flex-direction: column;height: 100vh;overflow: hidden;}
        .header {background-color: white;padding: 15px 30px;box-shadow: 0 2px 4px rgba(0,0,0,0.05);display: flex;align-items: center;justify-content: space-between;height: var(--header-height);box-sizing: border-box;z-index: 1000;position: fixed;top: 0;left: var(--sidebar-width);right: 0;}
        .header-left{display: flex;align-items: center;}
        .header-toggle{background:none;border:none;color:var(--primary-blue);font-size:1.3rem;padding:8px 12px;border-radius:6px;cursor:pointer}
        .header-toggle:hover{background:#f0f2f7}
        .header-title img {height: 50px;}
        .header-right {display: flex;align-items: center;gap: 15px;}
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
        .profile-menu{position:relative}
        .profile-dropdown{position:absolute;top:44px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-meta{padding:10px 14px;border-bottom:1px solid #e5e7eb}
        .profile-dropdown .dropdown-meta-name{font-weight:700;color:#111827}
        .profile-dropdown .dropdown-meta-role{font-size:.85rem;color:#6b7280}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        .dashboard-container {display: flex;flex: 1;overflow: hidden;margin-top: var(--header-height);margin-left: var(--sidebar-width);height: calc(100vh - var(--header-height));}
        .sidebar {width: var(--sidebar-width);background-color: var(--primary-blue);color: white;transition: width 0.3s ease;display: flex;flex-direction: column;position: fixed;top: 0;left: 0;height: 100vh;overflow-y: auto;}
        .sidebar-brand{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)}
        .sidebar-logo{height:70px}
        .sidebar.collapsed .sidebar-brand{justify-content:center;padding:8px 0}
        .sidebar.collapsed .sidebar-logo{height:44px;width:44px;margin:0 auto;display:block;object-fit:contain}
        .sidebar.collapsed {width: var(--sidebar-collapsed-width);}
        .sidebar-toggle {padding: 15px;text-align: right;cursor: pointer;border-bottom: 1px solid rgba(255,255,255,0.1);}
        .sidebar-menu {list-style: none;padding: 0;margin: 0;}
        .menu-item {padding: 15px 20px;cursor: pointer;display: flex;align-items: center;transition: background-color 0.2s;white-space: nowrap;overflow: hidden;}
        .menu-item:hover, .menu-item.active {background-color: rgba(255,255,255,0.1);}
        .menu-icon {width: 30px;text-align: center;margin-right: 15px;font-size: 1.1rem;}
        .menu-text {transition: opacity 0.3s;}
        .sidebar.collapsed .menu-text {opacity: 0;display: none;}
        .main-content {flex: 1;padding: 30px;overflow-y: auto;background-color: var(--bg-color);}
        .content-section {display: none;animation: fadeIn 0.3s ease-out;}
        .content-section.active {display: block;}
        @keyframes fadeIn {from { opacity: 0; transform: translateY(10px); }to { opacity: 1; transform: translateY(0); }}
        .welcome-title {font-size: 2rem;color: var(--primary-blue);margin-bottom: 30px;font-weight: 300;}
        .welcome-title strong {font-weight: 700;}
        .stats-grid{display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:16px;margin-bottom:24px}
        @media (min-width: 900px){ .stats-grid{grid-template-columns:repeat(2,1fr)} }
        @media (min-width: 1200px){ .stats-grid{grid-template-columns:repeat(4,1fr)} }
        .stat-card{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:14px 16px;box-shadow:0 8px 24px rgba(17,24,39,.06);transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease}
        .stat-card:hover {transform: translateY(-5px);}
        .stat-icon{width:44px;height:44px;border-radius:999px;display:flex;align-items:center;justify-content:center}
        .stat-info h3{margin:0;font-size:1.6rem;color:#002C76}
        .stat-info p{margin:0;color:#6b7280}
        .control-hero{background:linear-gradient(135deg,#ca8a04 0%,#facc15 58%,#fde047 100%);color:#1e293b;border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 10px 24px rgba(250,204,21,.24);margin-bottom:20px}
        .control-hero-left{display:flex;align-items:center;gap:14px}
        .control-hero-title{font-size:1.4rem;font-weight:800;letter-spacing:-.01em}
        .control-hero-sub{font-size:.95rem;opacity:.9}
        .hero-actions{display:flex;gap:10px;flex-wrap:wrap}
        .hero-btn{display:inline-flex;align-items:center;gap:8px;background:#fffdf1;color:#8a4b06;border:1px solid rgba(255,255,255,.72);border-radius:999px;padding:10px 14px;font-weight:800;text-decoration:none;box-shadow:0 6px 16px rgba(161,98,7,.14)}
        .hero-btn:hover{transform:translateY(-1px)}
        .insight-panel {background: #ffffff;border: 1px solid #e5eef7;border-radius: 16px;padding: 20px;box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);}
        .insight-panel-header {display: flex;justify-content: space-between;align-items: center;gap: 10px;margin-bottom: 16px;}
        .insight-panel-header h2 {margin: 0;color: #0B2C74;font-size: 1.15rem;font-weight: 800;letter-spacing: -.01em;}
        .insight-panel-header span {color: #64748b;font-size: 0.85rem;font-weight: 700;}
        .btn-table-action {display: inline-flex;align-items: center;gap: 6px;border: none;border-radius: 8px;padding: 8px 11px;cursor: pointer;font-size: 0.8rem;font-weight: 600;text-decoration: none;transition: transform 0.15s ease, box-shadow 0.2s ease, background-color 0.2s ease;white-space: nowrap;}
        .btn-table-action:hover {transform: translateY(-1px);box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);}
        .insight-grid {display: grid;grid-template-columns: 1.1fr 1.6fr;gap: 20px;}
        .insight-col {display: grid;grid-template-columns: 1fr;gap: 20px;}
        .btn-action-manage { background: #e8eefb; color: #1e40af; }
        .table-empty {padding: 40px 20px;text-align: center;color: #64748b;}
        .table-empty i {display: block;font-size: 1.8rem;color: #94a3b8;margin-bottom: 10px;}
        .users-pagination {margin-top: 10px;display: flex;justify-content: center;}
        .users-page-number {margin-top: 14px;text-align: right;color: #64748b;font-size: 0.84rem;font-weight: 600;}
        @media (max-width: 992px) {.header {height: auto;padding: 12px 14px;flex-wrap: wrap;gap: 10px}.header-logo {height: 38px;margin-right: 10px;}.header-title img {height: 36px;}.header-right {width: 100%;justify-content: space-between;flex-wrap: wrap;gap: 8px;}.user-profile-header {margin-right: 0 !important;}.dashboard-container {flex-direction: column;overflow: visible;}.sidebar,.sidebar.collapsed {width: 100%;max-width: 100%;overflow: visible;}.sidebar-toggle {display: none;}.sidebar-menu {display: flex;overflow-x: auto;white-space: nowrap;}.menu-item {flex: 0 0 auto;padding: 12px 14px;}.sidebar.collapsed .menu-text {opacity: 1;display: inline;}.main-content {padding: 16px;overflow: visible;}.welcome-title {font-size: 1.5rem;margin-bottom: 18px;}.stats-grid {gap: 14px;}}

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
        .badge-status-pending { background: #facc15; color: #1e293b; }

        .user-identity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #002C76;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
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

        .actions-inline {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
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

        #profile-section .profile-page-panel-header-rich {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 16px;
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
    <header class="header">
        <div class="header-left">
            <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <h2 id="page-title" style="margin: 0 0 0 15px; font-size: 1.25rem; color: var(--primary-blue); font-weight: 700;">Dashboard</h2>
        </div>
        <div class="header-right">
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
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item {{ !request('tab') ? 'active' : '' }}" onclick="showContent('dashboard-home', this)">
                    <div class="menu-icon"><i class="fas fa-home"></i></div>
                    <span class="menu-text">Dashboard</span>
                </li>
                <li class="menu-item {{ request('tab') == 'user-management' ? 'active' : '' }}" onclick="showContent('user-management', this)">
                    <div class="menu-icon"><i class="fas fa-users"></i></div>
                    <span class="menu-text">User Management</span>
                </li>
                <li class="menu-item {{ request('tab') == 'trainer-trainee-management' ? 'active' : '' }}" onclick="showContent('trainer-trainee-management', this)">
                    <div class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <span class="menu-text">Training Management</span>
                </li>
                <li class="menu-item {{ request('tab') == 'activity-logs' ? 'active' : '' }}" onclick="showContent('activity-logs', this)">
                    <div class="menu-icon"><i class="fas fa-clock-rotate-left"></i></div>
                    <span class="menu-text">Activity Logs</span>
                </li>
            </ul>
        </aside>
        <main class="main-content">
            <section id="dashboard-home" class="content-section {{ !request('tab') ? 'active' : '' }}">
                <div class="control-hero">
                    <div class="control-hero-left">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center"><i class="fas fa-gauge-high"></i></div>
                        <div>
                            <div class="control-hero-title">Welcome, {{ Auth::user()->name }}</div>
                            <div class="control-hero-sub">Monitor learner activation, course readiness, and certification output.</div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a class="hero-btn" href="{{ route('dashboard', ['tab' => 'user-management']) }}"><i class="fas fa-users"></i> Review Users</a>
                        <a class="hero-btn" href="{{ route('dashboard', ['tab' => 'trainer-trainee-management']) }}"><i class="fas fa-chalkboard-teacher"></i> Manage Courses</a>
                    </div>
                </div>
                <div class="stats-grid">
                    <div class="stat-card"><div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="fas fa-user-clock"></i></div><div class="stat-info"><h3>{{ $unapprovedCount }}</h3><p>Total Unapproved Users</p></div></div>
                    <div class="stat-card"><div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;"><i class="fas fa-user-check"></i></div><div class="stat-info"><h3>{{ $approvedCount }}</h3><p>Total Approved Users</p></div></div>
                    <div class="stat-card"><div class="stat-icon" style="background-color: rgba(99,102,241,0.12); color: #6366f1;"><i class="fas fa-book"></i></div><div class="stat-info"><h3>{{ $totalCourses }}</h3><p>Total Courses</p></div></div>
                    <div class="stat-card"><div class="stat-icon" style="background-color: rgba(255,193,7,0.12); color: #fd7e14;"><i class="fas fa-user-hourglass"></i></div><div class="stat-info"><h3>{{ $pendingTraineesCount }}</h3><p>Pending Participants</p></div></div>
                </div>
                @php
                    $userCount = \App\Models\User::count();
                    $aActive = \App\Models\User::where('status','active')->count();
                    $aPending = \App\Models\User::where('status','pending')->count();
                    $aBlocked = \App\Models\User::where('status','freeze')->count();
                    $cActive = \App\Models\Course::count();
                    $cNoCoachNoPart = \App\Models\Course::whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                        ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                        ->count();
                    $cNoCoachOnly = \App\Models\Course::whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                        ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                        ->count();
                    $cNoParticipantOnly = \App\Models\Course::whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                        ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                        ->count();
                    $cActiveBoth = \App\Models\Course::whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                        ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                        ->count();
                    $pct = function($n,$t){ return $t>0 ? round(($n/$t)*100) : 0; };
                @endphp
                <div class="insight-grid" style="margin-top:14px">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px"><div class="insight-panel">
                    <div class="insight-panel-header">
                        <h2>Accounts & Courses Overview</h2>
                        <span>Totals</span>
                    </div>
                    @php
                        $rAdmins = \App\Models\User::where('role','admin')->count();
                        $rTM = \App\Models\User::where('role','training_manager')->count();
                        $rCoaches = \App\Models\User::whereIn('role',['coach','trainer'])->count();
                        $rParticipants = \App\Models\User::whereIn('role',['participant','trainee'])->count();
                    @endphp
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
                        <div>
                            <div style="display:flex;justify-content:center;gap:8px;margin-bottom:8px">
                                <button id="tm-course-tab-summary" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#fff;color:#0B2C74;font-weight:800">Summary</button>
                                <button id="tm-course-tab-distribution" type="button" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:999px;background:#0B2C74;color:#fff;font-weight:800">Distribution</button>
                            </div>
                            <div id="tm-donut-courses" style="width:220px;height:220px;margin:0 auto"></div>
                            <div style="margin-top:10px;text-align:center">
                                <div style="color:#6b7280;font-size:.85rem;letter-spacing:.2px">Active Courses</div>
                                <div style="font-weight:800;color:#0B2C74;font-size:1.5rem;line-height:1">{{ $cActive }}</div>
                            </div>
                            <div id="tm-legend-course-distribution" style="display:grid;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Active <span id="tm-course-legend-active" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#FFD700;border:1px solid #eab308"></div><div style="color:#0B2C74;font-weight:800">Without Coach & Participants <span id="tm-course-legend-noboth" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#B10606"></div><div style="color:#0B2C74;font-weight:800">Without Coaches <span id="tm-course-legend-nocoach" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#f59e0b"></div><div style="color:#0B2C74;font-weight:800">Without Participants <span id="tm-course-legend-nopart" style="color:#6b7280;margin-left:6px"></span></div>
                            </div>
                            <div id="tm-legend-course-summary" style="display:none;grid-template-columns:auto 1fr;gap:12px 14px;align-items:center;justify-content:center;margin-top:8px">
                                <div style="width:12px;height:12px;border-radius:50%;background:#0B2C74"></div><div style="color:#0B2C74;font-weight:800">Active (Ready) <span id="tm-course-legend-summary-active" style="color:#6b7280;margin-left:6px"></span></div>
                                <div style="width:12px;height:12px;border-radius:50%;background:#f59e0b"></div><div style="color:#0B2C74;font-weight:800">Not Ready <span id="tm-course-legend-summary-notready" style="color:#6b7280;margin-left:6px"></span></div>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
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
                            var paths=g.selectAll('path').data(data).enter().append('path')
                              .attr('d',arc)
                              .attr('fill',function(d,i){return colors[i];})
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
                              .attr('fill','#0f172a')
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
                          var cNoBoth={{ $cNoCoachNoPart }};
                          var cNoCoachOnly={{ $cNoCoachOnly }};
                          var cNoPartOnly={{ $cNoParticipantOnly }};
                          var cTotal = cActive;
                          var cActiveBoth={{ $cActiveBoth }};
                          function drawCourseDistribution(){
                            var dLegend=document.getElementById('tm-legend-course-distribution');
                            var sLegend=document.getElementById('tm-legend-course-summary');
                            if(dLegend) dLegend.style.display='grid';
                            if(sLegend) sLegend.style.display='none';
                            var btnS=document.getElementById('tm-course-tab-summary');
                            var btnD=document.getElementById('tm-course-tab-distribution');
                            if(btnS&&btnD){ btnS.style.background='#fff'; btnS.style.color='#0B2C74'; btnD.style.background='#0B2C74'; btnD.style.color='#fff'; }
                            var el=document.getElementById('tm-donut-courses'); if(el){ el.innerHTML=''; }
                            renderArcDonut('tm-donut-courses', [cActiveBoth,cNoBoth,cNoCoachOnly,cNoPartOnly], ['#0B2C74','#FFD700','#B10606','#f59e0b']);
                            document.getElementById('tm-course-legend-active').innerText = cActiveBoth+' · '+pct(cActiveBoth,cTotal)+'%';
                            document.getElementById('tm-course-legend-noboth').innerText = cNoBoth+' · '+pct(cNoBoth,cTotal)+'%';
                            document.getElementById('tm-course-legend-nocoach').innerText = cNoCoachOnly+' · '+pct(cNoCoachOnly,cTotal)+'%';
                            document.getElementById('tm-course-legend-nopart').innerText = cNoPartOnly+' · '+pct(cNoPartOnly,cTotal)+'%';
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
                            var cNotReady = cNoBoth + cNoCoachOnly + cNoPartOnly;
                            renderArcDonut('tm-donut-courses', [cActiveBoth,cNotReady], ['#0B2C74','#f59e0b']);
                            document.getElementById('tm-course-legend-summary-active').innerText = cActiveBoth+' · '+pct(cActiveBoth,cTotal)+'%';
                            document.getElementById('tm-course-legend-summary-notready').innerText = cNotReady+' · '+pct(cNotReady,cTotal)+'%';
                          }
                          drawCourseDistribution();
                          var tabCourseSummary=document.getElementById('tm-course-tab-summary');
                          var tabCourseDistribution=document.getElementById('tm-course-tab-distribution');
                          if(tabCourseSummary){ tabCourseSummary.addEventListener('click', drawCourseSummary); }
                          if(tabCourseDistribution){ tabCourseDistribution.addEventListener('click', drawCourseDistribution); }
                        })();
                    </script>
                </div>
            </section>
            <section id="user-management" class="content-section {{ request('tab') == 'user-management' ? 'active' : '' }}">
                <div class="user-management-shell">
                    @if(session('success_user'))
                        <div class="user-management-alert">
                            {{ session('success_user') }}
                        </div>
                    @endif
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
                        <div class="users-table-shell">
                            <div class="users-table-wrap">
                                <table class="users-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Account ID</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Location</th>
                                            <th>Joined Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            @php
                                                $location = trim(($user->city ?? '') . (($user->city && $user->province) ? ', ' : '') . ($user->province ?? ''));
                                                $roleMap = isset($roleDisplay) && is_array($roleDisplay) ? $roleDisplay : [];
                                                $rawRole = $user->role;
                                                $roleClass = in_array($rawRole, ['super_admin','admin','registrar','training_manager','coach','trainer','trainee','participant']) ? ($rawRole === 'trainer' ? 'coach' : $rawRole) : 'trainee';
                                                $roleLabel = $roleMap[$rawRole] ?? ($rawRole === 'trainer' ? 'Coach' : ($rawRole === 'training_manager' ? 'Training Manager' : ucfirst(str_replace('_',' ',$rawRole))));
                                                $statusValue = $user->status ?? 'active';
                                                $statusClass = in_array($statusValue, ['active', 'freeze', 'pending']) ? $statusValue : 'active';
                                                $statusLabel = $statusValue === 'freeze' ? 'Blocked' : $statusValue;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="user-identity">
                                                        <span class="user-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                        <span class="user-name">{{ $user->name }}</span>
                                                    </div>
                                                </td>
                                                <td><span class="mono-text">{{ $user->status === 'pending' ? '-' : ($user->account_id ?? '-') }}</span></td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge-pill badge-role-{{ $roleClass }}">{{ $roleLabel }}</span></td>
                                                <td class="muted-cell">{{ $location !== '' ? $location : 'Not set' }}</td>
                                                <td class="muted-cell">{{ $user->created_at->setTimezone(config('app.timezone'))->format('M d, Y h:ia') }}</td>
                                                <td><span class="badge-pill badge-status-{{ $statusClass }}">{{ $statusLabel }}</span></td>
                                                <td>
                                                    <div class="actions-inline">
                                                        <button type="button" onclick='openEditModal(@json($user))' class="btn-table-action btn-action-manage">
                                                            <i class="fas fa-cog"></i>
                                                            Manage
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="table-empty">
                                                    <i class="fas fa-users-slash"></i>
                                                    No users found for the current filters.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="users-page-number">
                            Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                        </div>
                        <div class="users-pagination">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
            <section id="trainer-trainee-management" class="content-section {{ request('tab') == 'trainer-trainee-management' ? 'active' : '' }}">
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
                            <h3 style="margin:0;color:#002C76;">Courses</h3>
                        </div>
                        <span style="color:#6b7280;">Total: {{ isset($courses) ? $courses->count() : 0 }}</span>
                    </div>
                    @if(!isset($courses) || $courses->isEmpty())
                        <div style="padding:20px;border:1px dashed #e5e7eb;border-radius:8px;text-align:center;color:#6b7280;">
                            There are no courses found.
                        </div>
                    @else
                        <div class="course-grid">
                            @foreach($courses as $course)
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
                                <div class="course-card">
                                    @php
                                        $img = null;
                                        if (!empty($course->image_path)) {
                                            $path = public_path('storage/' . $course->image_path);
                                            if (file_exists($path)) {
                                                $img = asset('storage/' . $course->image_path);
                                            } else {
                                                $path2 = public_path('images/' . ltrim($course->image_path, '/'));
                                                if (file_exists($path2)) {
                                                    $img = asset('images/' . ltrim($course->image_path, '/'));
                                                }
                                            }
                                        }
                                        if (!$img) {
                                            $img = 'https://via.placeholder.com/300x160?text=' . urlencode($course->name);
                                        }
                                    @endphp
                                    <div class="course-image" style="background-image: url('{{ $img }}');"></div>
                                    <div class="course-content">
                                        <div class="course-title">{{ $course->name }}</div>
                                        <div class="course-sub">{{ $course->subject_area ?? 'Uncategorized' }}</div>
                                        <div class="course-footer" style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap">
                                            <div class="course-counts">
                                                <span title="Coaches"><i class="fas fa-user blue"></i> {{ $trainerCount }} <span class="count-label">{{ $trainerCount == 1 ? 'Coach' : 'Coaches' }}</span></span>
                                                <span title="Participants"><i class="fas fa-users green"></i> {{ $traineeCount }} <span class="count-label">{{ $traineeCount == 1 ? 'Participant' : 'Participants' }}</span></span>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:8px">
                                                @php $pub = (bool)($course->is_published ?? false); @endphp
                                                <span class="status-chip" style="padding:4px 10px;border-radius:999px;font-weight:700;{{ $pub ? 'background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0' : 'background:#fff7ed;color:#9a3412;border:1px solid #fed7aa' }}">
                                                    {{ $pub ? 'Published' : 'Unpublished' }}
                                                </span>
                                                <form method="POST" action="{{ route('courses.publish', $course) }}" onsubmit="return confirm('Are you sure?')" style="margin:0">
                                                    @csrf
                                                    <input type="hidden" name="return_tab" value="trainer-trainee-management">
                                                    <input type="hidden" name="published" value="{{ $pub ? '0':'1' }}">
                                                    <button type="submit" class="btn-view" style="background:{{ $pub?'#ef4444':'#10b981' }};border-color:transparent">
                                                        <i class="fas {{ $pub?'fa-eye-slash':'fa-bullhorn' }}"></i> {{ $pub ? 'Close Course' : 'Publish Course' }}
                                                    </button>
                                                </form>
                                                <a href="{{ route('registrar.courses.participants', $course) }}" class="btn-view">View Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
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
                        $actorName = (Auth::user() && Auth::user()->role === 'training_manager') ? Auth::user()->name : 'Training Manager';
                        $logs = collect();
                        $recent = isset($notifications) ? $notifications->take(20) : collect();
                        foreach($recent as $n){
                            $logs->push([
                                'title' => $n->title,
                                'desc' => $n->message,
                                'time' => $n->created_at,
                            ]);
                        }
                        $approvedUsers = \App\Models\User::where('status','active')->whereColumn('updated_at','>','created_at')->orderBy('updated_at','desc')->take(20)->get();
                        foreach($approvedUsers as $u){ $logs->push(['title'=>'Approved User','desc'=>$actorName.' approved '.$u->name,'time'=>$u->updated_at]); }
                        $updatedUsers = \App\Models\User::whereColumn('updated_at','>','created_at')->orderBy('updated_at','desc')->take(20)->get();
                        foreach($updatedUsers as $u){
                            $logs->push(['title'=>'Edited Status','desc'=>$actorName.' set status to '.ucfirst($u->status).' for '.$u->name,'time'=>$u->updated_at]);
                            $logs->push(['title'=>'Edited Role','desc'=>$actorName.' set role to '.str_replace('_',' ', $u->role).' for '.$u->name,'time'=>$u->updated_at]);
                        }
                        $coachAssignments = \DB::table('course_user')
                            ->join('courses','course_user.course_id','=','courses.id')
                            ->join('users','course_user.user_id','=','users.id')
                            ->whereIn('users.role',['coach','trainer'])
                            ->select('courses.name as course_name','users.name as user_name','course_user.created_at as at')
                            ->orderBy('course_user.created_at','desc')
                            ->take(10)->get();
                        foreach($coachAssignments as $r){ $logs->push(['title'=>'Assigned Coach','desc'=>$actorName.' assigned coach '.$r->user_name.' to '.$r->course_name,'time'=>$r->at]); }
                        $enrollments = \DB::table('course_user')
                            ->join('courses','course_user.course_id','=','courses.id')
                            ->join('users','course_user.user_id','=','users.id')
                            ->whereIn('users.role',['participant','trainee'])
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
                                        <div class="profile-input" style="display:flex;align-items:center;">{{ Auth::user()->status === 'pending' ? 'N/A' : (Auth::user()->account_id ?? 'N/A') }}</div>
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
                                    <div class="form-group">
                                        <label>Region</label>
                                        <input type="text" name="region" value="{{ Auth::user()->region }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <input type="text" name="province" value="{{ Auth::user()->province }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label>City / Municipality</label>
                                        <input type="text" name="city" value="{{ Auth::user()->city }}" readonly class="profile-input">
                                    </div>
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <input type="text" name="barangay" value="{{ Auth::user()->barangay }}" readonly class="profile-input">
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
<script>
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
        }).then(response => response.json()).then(data => {
            if (data.success) {
                var badge = document.querySelector('.notification-badge');
                if (badge) {
                    var count = parseInt(badge.innerText);
                    if (count > 1) {
                        badge.innerText = count - 1;
                        var headerCount = document.querySelector('.notification-header .chip-new');
                        if (headerCount) {headerCount.innerText = (count - 1) + ' New';}
                    } else {
                        badge.remove();
                        var headerCount = document.querySelector('.notification-header .chip-new');
                        if (headerCount) {headerCount.innerText = '0 New';}
                    }
                }
                if (link && link !== 'null' && link !== '') {window.location.href = link;}
            }
        }).catch(error => {if (link && link !== 'null' && link !== '') {window.location.href = link;}});
    }
    document.addEventListener('click', function(event) {
        var container = document.querySelector('.notification-container');
        var dropdown = document.getElementById('notificationDropdown');
        if (container && !container.contains(event.target)) {dropdown.style.display = 'none';}
    });
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
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
    function showContent(sectionId, menuItem) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {section.classList.remove('active');});
        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {selectedSection.classList.add('active');}
    if (sectionId === 'trainer-trainee-management') {
        const pub = document.getElementById('published-courses');
        if (pub) { pub.classList.add('active'); }
    }
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {item.classList.remove('active');});
        if (menuItem) {menuItem.classList.add('active');}
        const titles = {'dashboard-home': 'Dashboard','user-management': 'User Management','trainer-trainee-management': 'Training Management'};
        const titleElement = document.getElementById('page-title');
        if (titleElement) {titleElement.textContent = titles[sectionId] || 'Dashboard';}
        const url = new URL(window.location.href);
        if (sectionId === 'dashboard-home') {url.searchParams.delete('tab');} else {url.searchParams.set('tab', sectionId);}
        window.history.pushState({}, '', url.toString());
    }
    function showEditModal(user) {
        document.getElementById('edit_user_id').value = user.id;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_status').value = user.status;
        const form = document.getElementById('editForm');
        form.action = `/users/${user.id}`;
        document.getElementById('editModal').style.display = 'block';
    }
    const openEditModal = showEditModal;
    function closeEditModal() {document.getElementById('editModal').style.display = 'none';}
    function showProfile() {
        document.querySelectorAll('.content-section').forEach(section => {section.classList.remove('active');});
        document.getElementById('profile-section').classList.add('active');
        document.querySelectorAll('.menu-item').forEach(link => {link.classList.remove('active');});
    }
    function enableProfileEdit() {
        document.getElementById('btnEditProfile').style.display = 'none';
        document.getElementById('btnCancelProfile').style.display = 'inline-block';
        document.getElementById('btnSaveProfile').style.display = 'inline-block';
        document.getElementById('profile_upload_container').style.display = 'block';
        document.getElementById('password_change_section').style.display = 'block';
        const inputs = document.querySelectorAll('.profile-input');
        inputs.forEach(input => {input.readOnly = false;input.style.backgroundColor = 'white';input.style.cursor = 'text';});
    }
    function cancelProfileEdit() {
        document.getElementById('btnEditProfile').style.display = 'inline-block';
        document.getElementById('btnCancelProfile').style.display = 'none';
        document.getElementById('btnSaveProfile').style.display = 'none';
        document.getElementById('profile_upload_container').style.display = 'none';
        document.getElementById('password_change_section').style.display = 'none';
        const inputs = document.querySelectorAll('.profile-input');
        inputs.forEach(input => {input.readOnly = true;input.style.backgroundColor = '#f8f9fa';input.style.cursor = 'default';input.value = input.defaultValue;});
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
    function addFilter(value) {
        if (!value) return;
        const [type, val] = value.split(':');
        const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
        const roleMap = {'coach': 'coach','participant': 'participant','training_manager': 'training_manager','trainer': 'coach','trainee': 'participant','super_admin': 'admin','admin': 'admin','central_office_admin': 'admin','regional_office_admin': 'admin','provincial_office_admin': 'admin','central_office_coach': 'coach','regional_office_coach': 'coach','provincial_office_coach': 'coach','central_office_participants': 'participant','regional_office_participants': 'participant','provincial_office_participants': 'participant','central_office_training_manager': 'training_manager','regional_office_training_manager': 'training_manager','provincial_office_training_manager': 'training_manager'};
        const mappedVal = type === 'role' ? (roleMap[val] || val) : val;
        if (type === 'role') {document.querySelectorAll('input[name="roles[]"]').forEach(cb => { cb.checked = false; });}
        const checkbox = document.querySelector(`input[name="${inputName}"][value="${mappedVal}"]`);
        if (checkbox) {checkbox.checked = true;renderActiveFilters();checkbox.dispatchEvent(new Event('change'));}document.getElementById('filterDropdown').value = "";
    }
    function removeFilter(type, val) {
        const inputName = type === 'role' ? 'roles[]' : 'statuses[]';
        const checkbox = document.querySelector(`input[name="${inputName}"][value="${val}"]`);
        if (checkbox) {checkbox.checked = false;renderActiveFilters();checkbox.dispatchEvent(new Event('change'));}}
    function renderActiveFilters() {
        const container = document.getElementById('activeFiltersContainer');
        if (!container) return;
        container.innerHTML = '';
        const checkboxes = document.querySelectorAll('#hiddenFilterInputs input[type="checkbox"]:checked');
        checkboxes.forEach(cb => {
            const type = cb.name === 'roles[]' ? 'role' : 'status';
            const val = cb.value;
            let label;
            if (val === 'freeze') {label = 'Blocked';} else if (val === 'training_manager') {label = 'Training Manager';} else if (val === 'participant') {label = 'Participant';} else {label = val.replace(/_/g, ' ');label = label.charAt(0).toUpperCase() + label.slice(1);}
            const chip = document.createElement('div');
            chip.className = 'active-filter-chip';
            chip.innerHTML = `<span>${label}</span><button type="button" class="chip-remove" onclick="removeFilter('${type}', '${val}')" aria-label="Remove ${label} filter"><i class="fas fa-times"></i></button>`;
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
                .then(html => {tableContainer.innerHTML = html;tableContainer.style.opacity = '1';window.history.pushState({}, '', url);attachPaginationListeners();})
                .catch(() => { tableContainer.style.opacity = '1'; });
        }
        function buildQueryString() {const formData = new FormData(filterForm);const params = new URLSearchParams(formData);return '?' + params.toString();}
        let debounceTimer;
        searchInput.addEventListener('input', function() {clearTimeout(debounceTimer);debounceTimer = setTimeout(() => {const url = "{{ route('dashboard') }}" + buildQueryString();fetchUsers(url);}, 300);});
        filterCheckboxes.forEach(cb => {cb.addEventListener('change', function() {const url = "{{ route('dashboard') }}" + buildQueryString();fetchUsers(url);});});
        filterForm.addEventListener('change', function(e) {if (e.target && e.target.name === 'sort') {const url = "{{ route('dashboard') }}" + buildQueryString();fetchUsers(url);}});
        function attachPaginationListeners() {
            const links = tableContainer.querySelectorAll('.pagination a');
            links.forEach(link => {link.addEventListener('click', function(ev) {ev.preventDefault();fetchUsers(this.href);});});
        }
        attachPaginationListeners();
    });
    window.onclick = function(event) {if (event.target.classList.contains('modal')) {event.target.style.display = "none";}}
    document.addEventListener('DOMContentLoaded', function () {
        const requestedTab = new URLSearchParams(window.location.search).get('tab');
        const titles = {'dashboard-home': 'Dashboard','user-management': 'User Management','trainer-trainee-management': 'Training Management','activity-logs': 'Activity Logs'};
        const titleElement = document.getElementById('page-title');
        if (titleElement) {const tabKey = requestedTab || 'dashboard-home';titleElement.textContent = titles[tabKey] || 'Dashboard';}
        if (requestedTab === 'profile-section') {showProfile();}
        const forceProfile = {{ isset($forceProfile) && $forceProfile ? 'true' : 'false' }};
        if (forceProfile) {showProfile();alert('Please complete your profile to continue.');}
    });
    function toggleProfileMenu(e){e.stopPropagation();var d=document.getElementById('profileDropdown');if(!d) return;d.style.display=(d.style.display==='block')?'none':'block';}
    function hideProfileMenu(){var d=document.getElementById('profileDropdown');if(d) d.style.display='none';}
    document.addEventListener('click',function(ev){var menu=document.querySelector('.profile-menu');var d=document.getElementById('profileDropdown');if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}});
</script>
</body>
</html>
