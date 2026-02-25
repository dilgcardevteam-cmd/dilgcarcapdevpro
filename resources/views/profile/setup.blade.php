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

    $avatarSrc = $user->profile_picture
        ? asset('storage/' . $user->profile_picture)
        : asset('images/user.png');
@endphp

<style>
    .profile-page {
        width: 100%;
        flex: 1;
        box-sizing: border-box;
        padding: 0;
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

<div class="profile-page">
    <div class="setup-wrap">
        <div class="setup-card">
            <div class="card-head">
                <h1 class="card-title"><i class="fas fa-user-cog"></i> {{ $isProfileCompleted ? 'Profile Settings' : 'Complete Your Profile' }}</h1>
                <div class="header-quick">
                    <a class="logout-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                    @if(!$isProfileCompleted)
                        <span class="badge badge-required"><i class="fas fa-lock"></i> Required before dashboard</span>
                    @else
                        <span class="badge badge-ready"><i class="fas fa-check-circle"></i> Account active</span>
                    @endif
                </div>
            </div>

            <div class="content">
                @if(session('profile_required'))
                    <div class="alert">
                        Please complete your profile so we can personalize your experience and enable course access.
                    </div>
                @endif

                @if(session('success_profile'))
                    <div class="alert">
                        {{ session('success_profile') }}
                    </div>
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
                    <button type="button" class="tab-btn" data-tab-target="tab-password" onclick="showTab('tab-password')">Password</button>
                    <button type="button" class="tab-btn" data-tab-target="tab-history" onclick="showTab('tab-history')">History</button>
                </div>

                <div id="tab-info" class="tab-pane">
                    <p class="why">All fields marked with <span class="require">*</span> are required.</p>

                    <form action="{{ route('profile.setup.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section" value="info">

                        <div class="avatar-wrap">
                            <img id="preview" class="avatar" src="{{ $avatarSrc }}" alt="Profile picture preview">
                            <div class="form-group" style="margin:0;">
                                <label>Profile Picture</label>
                                <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>

                        <h3 class="section-title">Basic Details</h3>
                        <div class="grid">
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
                                <label>Gender</label>
                                <select name="gender">
                                    <option value="" {{ old('gender', $user->gender) == '' ? 'selected' : '' }}>Select</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Prefer not to say" {{ old('gender', $user->gender) == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title">Address</h3>
                        <div class="grid">
                            <div class="form-group">
                                <label>Region <span class="require">*</span></label>
                                <input type="text" name="region" value="{{ old('region', $user->region) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Province <span class="require">*</span></label>
                                <input type="text" name="province" value="{{ old('province', $user->province) }}" required>
                            </div>
                            <div class="form-group">
                                <label>City/Municipality <span class="require">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Barangay <span class="require">*</span></label>
                                <input type="text" name="barangay" value="{{ old('barangay', $user->barangay) }}" required>
                            </div>
                        </div>

                        <h3 class="section-title">Job Details</h3>
                        <div class="grid">
                            <div class="form-group single-col">
                                <label>Job/Position Title</label>
                                <input type="text" value="{{ $user->job_title }}" readonly>
                            </div>
                        </div>

                        <h3 class="section-title">Short Bio (Optional)</h3>
                        <div class="form-group">
                            <textarea name="description" placeholder="Tell us about your background...">{{ old('description', $user->description) }}</textarea>
                        </div>

                        <div class="actions">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>

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
            </div>
        </div>
    </div>
</div>
@endsection
