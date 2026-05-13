@extends('layouts.auth')

@section('content')
@php
    $user = Auth::user();
    $isProfileCompleted = (bool) ($user->profile_completed ?? false);
    $initialTab = 'tab-info';

    if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation')) {
        $initialTab = 'tab-password';
    }

    $fullNameParsed = trim($user->name ?? '');
    $tokens = $fullNameParsed !== '' ? preg_split('/\s+/', $fullNameParsed) : [];
    $firstParsed = $tokens[0] ?? '';
    $lastParsed = count($tokens) > 1 ? $tokens[count($tokens) - 1] : '';
    $middleParsed = count($tokens) > 2 ? implode(' ', array_slice($tokens, 1, -1)) : '';

    $avatarSrc = $user->avatar_url;
@endphp
<style>
    :root {
        --primary-blue: #002C76;
        --primary-green: #7fb73d;
        --bg-color: #f4f6f9;
        --sidebar-width: 250px;
        --sidebar-collapsed-width: 70px;
        --header-height: 80px;
    }
    body > .header:first-of-type { display: none !important; }
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
    .header-left{display:flex;align-items:center}
    .header-section-title{margin-left:12px;font-weight:700;color:var(--primary-blue);font-size:1.2rem;letter-spacing:-.01em}
    .header-toggle,
    .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
    .header-toggle:hover,
    .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
    .profile-menu{position:relative}
    .user-profile-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 5px 16px 5px 5px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .user-profile-header:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        background-color: #f8fafc;
    }
    .user-profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .user-profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .user-profile-initial {
        font-weight: 800;
        color: #64748b;
        font-size: 1.1rem;
    }
    .user-profile-header .fa-chevron-down {
        font-size: 0.8rem;
        color: #64748b;
        transition: transform 0.2s ease;
    }
    .user-profile-header:hover .fa-chevron-down {
        color: #1e293b;
    }
    .profile-dropdown{position:absolute;top:50px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
    .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
    .profile-dropdown .dropdown-item:hover{background:#f8fafc}
    .profile-dropdown .danger{color:#b91c1c}
    .notification-container{position:relative;margin-right:10px}
    .notification-bell{cursor:pointer;position:relative;color:var(--primary-blue);font-size:1.2rem;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background-color .2s}
    .notification-bell:hover{background-color:#f5f5f5}
    .notification-badge{position:absolute;top:5px;right:5px;background:#d9534f;color:#fff;border-radius:50%;padding:2px 6px;font-size:.7rem;font-weight:700;border:2px solid #fff}
    .notification-dropdown{display:none;position:absolute;top:50px;right:-10px;width:320px;background:#fff;border-radius:8px;box-shadow:0 5px 20px rgba(0,0,0,.15);z-index:1000;overflow:hidden;border:1px solid #eee}
    .notification-header{padding:15px;border-bottom:1px solid #eee;font-weight:700;color:var(--primary-blue);display:flex;justify-content:space-between;align-items:center;background:#f9f9f9}
    .notification-list{max-height:350px;overflow-y:auto}
    .notification-item{padding:15px;border-bottom:1px solid #f0f0f0;cursor:pointer;transition:background-color .2s;display:block;text-decoration:none;color:inherit}
    .notification-item:hover{background:#f9f9f9}
    .notification-item.unread{background:#e3f2fd}
    .notification-item.unread:hover{background:#daeefc}
    .notification-title{font-size:.9rem;font-weight:700;color:#333;margin-bottom:5px;display:flex;align-items:center}
    .unread-dot{display:inline-block;width:8px;height:8px;background:#007bff;border-radius:50%;margin-right:8px;flex-shrink:0}
    .notification-message{font-size:.85rem;color:#58585b;margin-bottom:5px;line-height:1.4}
    .notification-time{font-size:.75rem;color:#999}
    .empty-notifications{padding:30px;text-align:center;color:#58585b;font-style:italic}
    .dashboard-container{display:flex;flex:1;overflow:hidden;margin-top:var(--header-height);margin-left:var(--sidebar-width);height:calc(100vh - var(--header-height));transition:margin-left .3s ease}
    .sidebar{width:var(--sidebar-width);background-color:var(--primary-blue);color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
    .sidebar.collapsed{width:var(--sidebar-collapsed-width)}
    body.sidebar-collapsed .header{left:var(--sidebar-collapsed-width)}
    body.sidebar-collapsed .dashboard-container{margin-left:var(--sidebar-collapsed-width)}
    .sidebar-brand{display:flex;align-items:center;justify-content:center;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.12)}
    .sidebar-logo{height:70px}
    .nav-menu{list-style:none;padding:10px 6px;margin:0;flex:1;display:block}
    .nav-item{margin:4px 6px}
    .nav-link{display:flex;align-items:center;gap:12px;padding:12px 16px;color:#e6eefb;text-decoration:none;border-radius:8px;transition:background-color .2s,color .2s}
    .nav-link:hover,.nav-link.active{background-color:rgba(255,255,255,.12);color:#ffffff}
    .nav-icon{width:22px;font-size:1.1rem;text-align:center}
    .main-content{flex:1;padding:30px;overflow-y:auto;background-color:var(--bg-color)}
    .content-section{display:none}
    .content-section.active{display:block}
    @media (max-width: 992px){
        .dashboard-container{flex-direction:column;overflow:visible}
        .sidebar,.sidebar.collapsed{width:100%;max-width:100%}
        .main-content{padding:16px;overflow:visible}
        .nav-menu{display:block;overflow:visible;white-space:normal}
    }
</style>
<style>
        width: 100%;
        flex: 1;
        box-sizing: border-box;
        padding: 0;
        display: flex;
        display: flex;
        overflow-x: hidden;
    }

    .profile-page .setup-wrap {
        width: 100%;
        margin: 0;
        padding: 16px 20px 20px;
        box-sizing: border-box;
        display: flex;
        flex: 1;
    }

    .profile-page .setup-card {
        width: 100%;
        flex: 1;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .profile-page .card-head {
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .profile-page .card-title {
        margin: 0;
        color: #002c76;
        font-size: 1.35rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-page .header-quick {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .profile-page .logout-link {
        text-decoration: none;
        color: #1f2937;
        font-weight: 600;
    }

    .profile-page .logout-link:hover {
        color: #002c76;
    }

    .profile-page .badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 0.83rem;
        font-weight: 700;
    }

    .profile-page .badge-required {
        background: #fef3c7;
        color: #92400e;
    }

    .profile-page .badge-ready {
        background: #dcfce7;
        color: #166534;
    }

    .profile-page .content {
        padding: 22px;
    }

    .profile-page .alert {
        background: #ecfdf3;
        color: #14532d;
        border: 1px solid #bbf7d0;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .profile-page .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .profile-page .tabs-container {
        display: flex;
        gap: 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 16px;
        overflow-x: auto;
    }

    .profile-page .tab-btn {
        background: transparent;
        border: 0;
        border-bottom: 3px solid transparent;
        color: #6b7280;
        padding: 13px 16px;
        cursor: pointer;
        font-weight: 700;
        white-space: nowrap;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    .profile-page .tab-btn:hover {
        color: #1f2937;
    }

    .profile-page .tab-btn.active {
        color: #002c76;
        border-bottom-color: #7fb73d;
    }

    .profile-page .tab-pane {
        display: none;
    }

    .profile-page .tab-pane.active {
        display: block;
    }

    .profile-page .why {
        color: #4b5563;
        margin: 0 0 18px;
    }

    .profile-page .require {
        color: #dc2626;
    }

    .profile-page .avatar-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        padding: 12px;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        flex-wrap: wrap;
    }

    .profile-page .avatar {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        background: #e5e7eb;
        object-fit: cover;
        border: 3px solid #002c76;
        flex: 0 0 auto;
    }

    .profile-page .section-title {
        margin: 18px 0 8px;
        color: #002c76;
        font-size: 1.02rem;
    }

    .profile-page .form-group {
        display: flex;
        flex-direction: column;
    }

    .profile-page label {
        font-size: 0.9rem;
        color: #475569;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .profile-page input[type='text'],
    .profile-page input[type='email'],
    .profile-page input[type='password'],
    .profile-page textarea,
    .profile-page select {
        width: 100%;
        max-width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-sizing: border-box;
        background: #fff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .profile-page input:focus,
    .profile-page textarea:focus,
    .profile-page select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.14);
    }

    .profile-page textarea {
        min-height: 110px;
        resize: vertical;
    }

    .profile-page input[readonly] {
        background: #f8fafc;
        color: #6b7280;
    }

    .profile-page .grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .profile-page .single-col {
        grid-column: 1 / -1;
    }

    .profile-page .password-panel {
        padding-top: 6px;
    }

    .profile-page .password-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .profile-page .password-header .icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #e9f0ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-page .password-header h2 {
        margin: 0;
        font-size: 1.2rem;
        color: #0f172a;
    }

    .profile-page .password-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.94rem;
    }

    .profile-page .password-hr {
        border: 0;
        border-top: 1px solid #e5e7eb;
        margin: 16px 0;
    }

    .profile-page .history-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-page .history-item {
        padding: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
    }

    .profile-page .history-title {
        font-weight: 700;
        color: #002c76;
    }

    .profile-page .history-message {
        font-size: 0.9rem;
        color: #475569;
        margin-top: 2px;
    }

    .profile-page .history-time {
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .profile-page .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .profile-page .btn {
        padding: 11px 18px;
        border: 0;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
    }

    .profile-page .btn-primary {
        background: #7fb73d;
        color: #fff;
    }

    .profile-page .btn-primary:hover {
        background: #6ba02f;
    }

    .profile-page .btn-password {
        background: #2563eb;
    }

    .profile-page .btn-password:hover {
        background: #1d4ed8;
    }

    @media (max-width: 960px) {
        .profile-page .setup-wrap {
            padding: 12px;
        }

        .profile-page .grid {
            grid-template-columns: 1fr;
        }

        .profile-page .content {
            padding: 16px;
        }

        .profile-page .card-head {
            padding: 16px;
        }
    }
</style>

<script>
    const profileTabIds = ['tab-info', 'tab-password', 'tab-history'];

    function previewImage(input) {
        const img = document.getElementById('preview');
        if (!img || !input.files || !input.files[0]) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }

    function applyTabState(id, updateHash = false) {
        const targetId = profileTabIds.includes(id) ? id : 'tab-info';

        profileTabIds.forEach(function (tabId) {
            const pane = document.getElementById(tabId);
            if (pane) {
                pane.classList.toggle('active', tabId === targetId);
            }
        });

        document.querySelectorAll('.tab-btn').forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.tabTarget === targetId);
        });

        if (updateHash) {
            const nextHash = '#' + targetId;
            if (window.location.hash !== nextHash) {
                window.location.hash = nextHash;
            }
        }
    }

    function showTab(id) {
        applyTabState(id, true);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const defaultTab = @json($initialTab);
        const hashTab = window.location.hash ? window.location.hash.substring(1) : '';
        const initial = profileTabIds.includes(hashTab) ? hashTab : defaultTab;
        applyTabState(initial, false);
    });

    window.addEventListener('hashchange', function () {
        const hashTab = window.location.hash ? window.location.hash.substring(1) : 'tab-info';
        if (profileTabIds.includes(hashTab)) {
            applyTabState(hashTab, false);
        }
    });
</script>

<header class="header">
    <div class="header-left">
        <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <div id="header-section-title" class="header-section-title">Dashboard</div>
    </div>
    <div style="display:flex;align-items:center;gap:10px">
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
                    <span style="font-size:.8rem;color:#58585b;background:#eee;padding:2px 8px;border-radius:10px;">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }} New</span>
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
                                <div class="notification-time"><i class="far fa-clock" style="margin-right:3px;"></i> {{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-notifications">
                            <i class="far fa-bell-slash" style="font-size:2rem;color:#ddd;margin-bottom:10px;display:block;"></i>
                            No notifications yet
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <div class="profile-menu">
        <div class="profile-trigger" onclick="toggleProfileMenu()">
            @if(Auth::user()->profile_picture)
                <img src="{{ Auth::user()->avatar_url }}" alt="Profile" style="width:35px;height:35px;border-radius:50%;object-fit:cover" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
            @else
                <div style="width:35px;height:35px;border-radius:50%;background:#002C76;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U',0,1)) }}
                </div>
            @endif
            <i class="fas fa-chevron-down profile-caret"></i>
        </div>
        <div id="profileDropdown" class="profile-dropdown">
            <a class="dropdown-item" href="#" onclick="openProfileSettings();return false;">
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
            <div id="profileSettingsOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:2500;">
                <div style="position:absolute;top:56px;left:0;right:0;bottom:0;display:flex;justify-content:center;">
                    <div style="width:min(1200px,95vw);height:calc(100% - 72px);padding:14px;box-sizing:border-box;">
                        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 12px 24px rgba(15,23,42,.12);height:100%;overflow:auto;position:relative;">
                            <div style="position:sticky;top:0;display:flex;justify-content:space-between;align-items:center;padding:14px;border-bottom:1px solid #e5e7eb;background:#fff;border-radius:14px 14px 0 0">
                                <div style="font-weight:800;color:#002C76">Profile Settings</div>
                                <button type="button" onclick="closeProfileSettings()" style="border:none;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:8px 12px;cursor:pointer">Close</button>
                            </div>
                            <div class="content" style="padding:18px;">
                                @if(session('profile_required'))
                                    <div class="alert">Please complete your coCoach so we can personalize your experience and enable course access.</div>
                                @endif
                                @if(session('success_profile'))
                                    <div class="alert">{{ session('success_profile') }}</div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-error">
                                        <ul style="margin:0 0 0 18px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="tabs-container">
                                    <button type="button" class="tab-btn" data-tab-target="tab-info" onclick="showTab('tab-info')">Personal Information</button>
                                    @if($isProfileCompleted)
                                        <button type="button" class="tab-btn" data-tab-target="tab-password" onclick="showTab('tab-password')">Password</button>
                                        <button type="button" class="tab-btn" data-tab-target="tab-history" onclick="showTab('tab-history')">History</button>
                                    @endif
                                </div>
                                <div id="tab-info" class="tab-pane">
                                    <p class="why">All fields marked with <span class="require">*</span> are required.</p>
                                    <form action="{{ route('profile.setup.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section" value="info">
                                        <div class="avatar-wrap">
                                            <img id="preview" class="avatar" src="{{ $avatarSrc }}" alt="Profile picture preview">
                                            <div class="form-group" style="margin:0;">
                                                <label>coCoach Picture</label>
                                                <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                                            </div>
                                        </div>
                                        <h3 class="section-title">Basic Details</h3>
                                        <div class="grid">
                                            <div class="form-group">
                                                <label>Account ID</label>
                                                <div style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; background: #f8fafc; color: #6b7280; display: flex; align-items: center; cursor: not-allowed;">{{ $user->status === 'pending' ? 'N/A' : ($user->account_id ?? 'N/A') }}</div>
                                            </div>
                                            <div class="form-group">
                                                <label>First Name <span class="require">*</span></label>
                                                <input type="text" name="first_name" value="{{ old('first_name', $firstParsed) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" name="middle_name" value="{{ old('middle_name', $middleParsed) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name <span class="require">*</span></label>
                                                <input type="text" name="last_name" value="{{ old('last_name', $lastParsed) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email <span class="require">*</span></label>
                                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number <span class="require">*</span></label>
                                                <input type="text" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sex <span class="require">*</span></label>
                                                <select name="gender" required>
                                                    <option value="" {{ old('gender', $user->gender) == '' ? 'selected' : '' }}>Select Sex</option>
                                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                    <option value="Prefer not to say" {{ old('gender', $user->gender) == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Agency <span class="require">*</span></label>
                                                <select name="agency" required>
                                                    <option value="" {{ old('agency', $user->agency) == '' ? 'selected' : '' }}>Select Agency</option>
                                                    <option value="DILG" {{ old('agency', $user->agency) == 'DILG' ? 'selected' : '' }}>DILG</option>
                                                    <option value="LGU" {{ old('agency', $user->agency) == 'LGU' ? 'selected' : '' }}>LGU</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h3 class="section-title">Address</h3>
                                        @php
                                            $profileRegion = old('region', $user->region);
                                            $profileProvince = old('province', $user->province);
                                            $profileCity = old('city', $user->city);
                                            $profileBarangay = old('barangay', $user->barangay);
                                        @endphp
                                        <div class="grid">
                                            <div class="form-group">
                                                <label>Region <span class="require">*</span></label>
                                                <select id="setup_region" name="region" required data-selected="{{ $profileRegion }}">
                                                    <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>Select Region</option>
                                                    @if($profileRegion)
                                                        <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Province <span class="require">*</span></label>
                                                <select id="setup_province" name="province" required data-selected="{{ $profileProvince }}">
                                                    <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>Select Province</option>
                                                    @if($profileProvince)
                                                        <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>City/Municipality <span class="require">*</span></label>
                                                <select id="setup_city" name="city" required data-selected="{{ $profileCity }}">
                                                    <option value="" disabled {{ $profileCity ? '' : 'selected' }}>Select City/Municipality</option>
                                                    @if($profileCity)
                                                        <option value="{{ $profileCity }}" selected>{{ $profileCity }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Barangay <span class="require">*</span></label>
                                                <select id="setup_barangay" name="barangay" required data-selected="{{ $profileBarangay }}">
                                                    <option value="" disabled {{ $profileBarangay ? '' : 'selected' }}>Select Barangay</option>
                                                    @if($profileBarangay)
                                                        <option value="{{ $profileBarangay }}" selected>{{ $profileBarangay }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn btn-primary" type="submit">{{ $isProfileCompleted ? 'Save Changes' : 'Submit for Approval' }}</button>
                                        </div>
                                    </form>
                                </div>
                                @if($isProfileCompleted)
                                <div id="tab-password" class="tab-pane">
                                    <form action="{{ route('profile.setup.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="section" value="password">
                                        <div class="password-panel">
                                            <div class="password-header">
                                                <div class="icon"><i class="fas fa-lock"></i></div>
                                                <div>
                                                    <h2>Change Password</h2>
                                                    <p>Ensure your account is using a long, random password to stay secure.</p>
                                                </div>
                                            </div>
                                            <hr class="password-hr">
                                            <div class="grid">
                                                <div class="form-group single-col">
                                                    <label>Current Password</label>
                                                    <input type="password" name="current_password" required>
                                                </div>
                                                <div class="form-group single-col">
                                                    <label>New Password</label>
                                                    <input type="password" name="password" required>
                                                </div>
                                                <div class="form-group single-col">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="password_confirmation" required>
                                                </div>
                                            </div>
                                            <div class="actions" style="justify-content:flex-start;">
                                                <button class="btn btn-primary btn-password" type="submit">Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="tab-history" class="tab-pane">
                                    @if(isset($notifications) && $notifications->count())
                                        <div class="history-list">
                                            @foreach($notifications as $n)
                                                <div class="history-item">
                                                    <div class="history-title">{{ $n->title }}</div>
                                                    <div class="history-message">{{ $n->message }}</div>
                                                    <div class="history-time">{{ $n->created_at->diffForHumans() }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert" style="background:#f8fafc; color:#475569; border-color:#e2e8f0;">
                                            No account history or announcements yet.
                                        </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</header>
<div class="dashboard-container">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img class="sidebar-logo" src="{{ asset('images/CAPDEV PRO WHITE.png') }}" data-full-src="{{ asset('images/CAPDEV PRO WHITE.png') }}" data-collapsed-src="{{ asset('images/CAPDEV PRO WHITE.png') }}" alt="CapDev Pro">
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active" onclick="showContent('dashboard-home', this); return false;">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard', ['tab' => 'my-courses']) }}" class="nav-link">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <span class="nav-text">My Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard', ['tab' => 'calendar']) }}" class="nav-link">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                    <span class="nav-text">Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard', ['tab' => 'announcements']) }}" class="nav-link">
                    <i class="fas fa-bullhorn nav-icon"></i>
                    <span class="nav-text">Announcements</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
    <div id="dashboard-home" class="content-section">
        <div class="control-hero">
            <div class="control-hero-top">
                <div>
                    <div class="control-hero-title">Welcome, Coach</div>
                    <div class="control-hero-sub">Monitor learning outcomes and efficiently manage classes.</div>
                </div>
            </div>
            <div class="hero-metrics" style="margin-top:14px">
                <div class="hero-metric">
                    <div class="metric-left">
                        <div class="metric-icon"><i class="fas fa-book"></i></div>
                        <div>
                            <div class="metric-value">0</div>
                            <div style="color:#6b7280;font-weight:700;font-size:.9rem">Courses Teaching</div>
                        </div>
                    </div>
                </div>
                <div class="hero-metric">
                    <div class="metric-left">
                        <div class="metric-icon" style="background:#e8f5e9;color:#2e7d32"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="metric-value">0</div>
                            <div style="color:#6b7280;font-weight:700;font-size:.9rem">Total Students</div>
                        </div>
                    </div>
                </div>
                <div class="hero-metric">
                    <div class="metric-left">
                        <div class="metric-icon" style="background:#e0f2fe;color:#0369a1"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <div class="metric-value">0</div>
                            <div style="color:#6b7280;font-weight:700;font-size:.9rem">Upcoming Events</div>
                        </div>
                    </div>
                </div>
                <div class="hero-metric">
                    <div class="metric-left">
                        <div class="metric-icon" style="background:#fff7ed;color:#9a3412"><i class="fas fa-bell"></i></div>
                        <div>
                            <div class="metric-value">0</div>
                            <div style="color:#6b7280;font-weight:700;font-size:.9rem">New Notifications</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 10px 24px rgba(15,23,42,.08);padding:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <div style="font-weight:800;color:#0f172a">Available Courses</div>
                    <div style="color:#6b7280;font-weight:700">0 available</div>
                </div>
                <div style="border-radius:12px;border:1px dashed #d8e1ef;background:#f8fafc;padding:18px;text-align:center;color:#64748b">
                    <div style="font-size:1.6rem;margin-bottom:6px"><i class="fas fa-book-open"></i></div>
                    No available courses at the moment.
                </div>
            </div>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 10px 24px rgba(15,23,42,.08);padding:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <div style="font-weight:800;color:#0f172a">Enrolled Courses</div>
                    <div style="color:#6b7280;font-weight:700">0 enrolled</div>
                </div>
                <div style="border-radius:12px;border:1px dashed #d8e1ef;background:#f8fafc;padding:18px;text-align:center;color:#64748b">
                    <div style="font-size:1.6rem;margin-bottom:6px"><i class="fas fa-folder-open"></i></div>
                    You have not been assigned to any courses yet.
                </div>
            </div>
        </div>
    </div>
    <div id="profile-section" class="content-section active">
<div class="profile-page">
    <div class="setup-wrap">
        <div class="setup-card">
            <div class="card-head">
                <h1 class="card-title"><i class="fas fa-user-cog"></i> {{ $isProfileCompleted ? 'coCoach Settings' : 'Complete Your coCoach' }}</h1>
                <div class="header-quick">
                    @if(!$isProfileCompleted)
                        <span class="badge badge-required"><i class="fas fa-lock"></i> Required before dashboard</span>
                    @else
                        <span class="badge badge-ready"><i class="fas fa-check-circle"></i> Account active</span>
                    @endif
                </div>
            </div>

            
        </div>
    </div>
</div>
    </div>

<script>
function toggleSidebar() {
    var s=document.getElementById('sidebar');
    s.classList.toggle('collapsed');
    var collapsed=s.classList.contains('collapsed');
    document.body.classList.toggle('sidebar-collapsed', collapsed);
    var logo=document.querySelector('.sidebar-logo');
    if(logo){
        var full=logo.getAttribute('data-full-src');
        var small=logo.getAttribute('data-collapsed-src');
        if(full&&small){ logo.src=collapsed?small:full; }
    }
}
function toggleProfileMenu(e){
    if(e) e.stopPropagation();
    var d=document.getElementById('profileDropdown');
    if(!d) return;
    var open=d.style.display==='block';
    d.style.display=open?'none':'block';
}
function openProfileSettings(){
    var ov=document.getElementById('profileSettingsOverlay');
    if(ov){ ov.style.display='block'; }
    // Ensure the tabs reflect active state
    showTab('tab-info');
}
function closeProfileSettings(){
    var ov=document.getElementById('profileSettingsOverlay');
    if(ov){ ov.style.display='none'; }
}
document.addEventListener('click',function(ev){
    var menu=document.querySelector('.profile-menu');
    var d=document.getElementById('profileDropdown');
    if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}
});
function toggleNotifications(){
    var dropdown=document.getElementById('notificationDropdown');
    if(!dropdown) return;
    dropdown.style.display=(dropdown.style.display==='block')?'none':'block';
}
function markAsRead(notificationId, link){
    event.stopPropagation();
    fetch('/notifications/' + notificationId + '/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    }).then(r=>r.json()).then(data=>{
        var badge=document.querySelector('.notification-badge');
        if(badge){
            var count=parseInt(badge.innerText);
            if(count>1){
                badge.innerText=count-1;
                var headerCount=document.querySelector('.notification-header span:last-child');
                if(headerCount){ headerCount.innerText=(count-1)+' New'; }
            }else{
                badge.remove();
                var headerCount=document.querySelector('.notification-header span:last-child');
                if(headerCount){ headerCount.innerText='0 New'; }
            }
        }
        if(link&&link!=='null'&&link!==''){ window.location.href=link; }
    }).catch(()=>{ if(link&&link!=='null'&&link!==''){ window.location.href=link; }});
}
document.addEventListener('click',function(e){
    var container=document.querySelector('.notification-container');
    var dropdown=document.getElementById('notificationDropdown');
    if(container&&dropdown&&!container.contains(e.target)){ dropdown.style.display='none'; }
});
function updateHeaderTitle(id){
    var titleEl=document.getElementById('header-section-title');
    if(!titleEl) return;
    if(id==='dashboard-home') titleEl.textContent='Dashboard';
    else if(id==='profile-section') titleEl.textContent='coCoach';
}
function showContent(id, el){
    document.querySelectorAll('.content-section').forEach(s=>s.classList.remove('active'));
    var target=document.getElementById(id);
    if(target){ target.classList.add('active'); }
    document.querySelectorAll('.nav-link').forEach(a=>a.classList.remove('active'));
    if(el){ el.classList.add('active'); }
    updateHeaderTitle(id);
}
</script>
<script>
function initSetupLocationDropdowns() {
    const regionSelect = document.getElementById('setup_region');
    const provinceSelect = document.getElementById('setup_province');
    const citySelect = document.getElementById('setup_city');
    const barangaySelect = document.getElementById('setup_barangay');
    
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

        if (!cityCode) {
            if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
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
            })
            .catch(error => {
                console.error('Error fetching barangays:', error);
                if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            });
    }

    function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
        const url = isRegion
            ? `https://psgc.gitlab.io/api/regions/${code}/cities-municipalities/`
            : `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`;

        resetSelect(citySelect, 'Select City/Municipality');
        resetSelect(barangaySelect, 'Select Barangay');

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

                if (selectedCityCode) {
                    loadBarangays(selectedCityCode, selectedBarangayValue);
                } else if (selectedBarangayValue) {
                    addFallbackOption(barangaySelect, selectedBarangayValue);
                }
            })
            .catch(error => {
                console.error('Error fetching cities:', error);
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

                if (selectedProvinceCode) {
                    fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                } else if (selectedCityValue) {
                    addFallbackOption(citySelect, selectedCityValue);
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                }
            })
            .catch(error => {
                console.error('Error fetching provinces:', error);
                if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
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

            if (selectedRegionCode) {
                loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
            } else {
                if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
                if (selectedCity) addFallbackOption(citySelect, selectedCity);
                if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
            }
        })
        .catch(error => {
            console.error('Error fetching regions:', error);
            if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
            if (selectedProvince) addFallbackOption(provinceSelect, selectedProvince);
            if (selectedCity) addFallbackOption(citySelect, selectedCity);
            if (selectedBarangay) addFallbackOption(barangaySelect, selectedBarangay);
        });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initSetupLocationDropdowns();
});
</script>
@endsection



