<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - Training Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root{--blue:#0b3a82;--blue-dark:#083272;--accent:#2563eb;--bg:#f4f7fb;--text:#0f172a;--muted:#64748b;--border:#e2e8f0;--sidebar:250px;--sidebar-collapsed:76px;--header:72px}
        *{box-sizing:border-box}
        body{margin:0;font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text)}
        .sidebar{position:fixed;inset:0 auto 0 0;width:var(--sidebar);background:var(--blue-dark);color:#fff;z-index:50;transition:width .22s ease,transform .25s ease}
        .sidebar-brand{height:76px;display:flex;align-items:center;justify-content:center;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.1)}
        .sidebar-logo{max-width:190px;max-height:54px;object-fit:contain}
        .sidebar-menu{list-style:none;margin:20px 0 0;padding:0}
        .menu-item{display:flex;align-items:center;gap:16px;min-height:52px;padding:0 22px;color:#fff;text-decoration:none;font-weight:800;white-space:nowrap;cursor:pointer}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1)}
        .menu-icon{width:26px;text-align:center;font-size:1.05rem}
        .menu-text{overflow:hidden;text-overflow:ellipsis}
        .portal-row{justify-content:space-between;margin-bottom:12px}
        .portal-row .portal-left{display:flex;align-items:center;gap:16px;min-width:0}
        .header{position:fixed;top:0;left:var(--sidebar);right:0;height:var(--header);background:#fff;border-bottom:1px solid #e8edf5;display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:40;transition:left .22s ease}
        .header-left{display:flex;align-items:center;gap:14px}
        .toggle{width:46px;height:46px;border-radius:15px;border:1px solid #dbe4f0;background:#fff;color:var(--blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;cursor:pointer;box-shadow:0 8px 18px rgba(15,23,42,.05)}
        .header-title{font-size:1.2rem;font-weight:900;color:var(--blue);margin:0}
        .profile{display:flex;align-items:center;gap:14px;color:#64748b;font-weight:800}
        .avatar{width:46px;height:46px;border-radius:999px;border:1px solid #cbd5e1;display:flex;align-items:center;justify-content:center;color:#94a3b8;background:#fff;font-size:1.15rem;font-weight:900}
        .page{margin-left:var(--sidebar);padding-top:var(--header);min-height:100vh;transition:margin-left .22s ease}
        .course-hero{background:#fff;padding:22px 40px 0;border-bottom:1px solid var(--border)}
        .hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:20px}
        .chips{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:10px}
        .chip{display:inline-flex;align-items:center;gap:8px;border-radius:6px;padding:6px 14px;font-size:.78rem;font-weight:900;letter-spacing:.06em;text-transform:uppercase}
        .chip.blue{background:#eef4ff;color:#2563eb}
        .chip.green{background:#e8f8ee;color:#059669}
        .course-title{margin:0;font-size:2.35rem;line-height:1.05;font-weight:900;letter-spacing:0;color:#0b1220}
        .meta{display:flex;gap:24px;flex-wrap:wrap;margin-top:18px;color:#64748b;font-weight:800}
        .meta span{display:inline-flex;align-items:center;gap:8px}
        .meta i{color:#7c8798}
        .actions{display:flex;gap:12px;flex-wrap:wrap;justify-content:flex-end}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:42px;border-radius:10px;padding:0 18px;border:1px solid #dbe4f0;background:#fff;color:#334155;text-decoration:none;font-weight:900;cursor:pointer}
        .btn.primary{background:#2563eb;border-color:#2563eb;color:#fff;box-shadow:0 8px 18px rgba(37,99,235,.2)}
        .tabs{display:flex;gap:34px;margin-top:28px;overflow:auto;border-bottom:1px solid var(--border)}
        .tab{position:relative;border:0;background:transparent;color:#64748b;font-weight:900;font-size:.98rem;padding:0 4px 16px;cursor:pointer;white-space:nowrap}
        .tab.active{color:#2563eb}
        .tab.active:after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:4px;border-radius:999px;background:#2563eb}
        .content{padding:26px 38px 40px}
        .layout{display:grid;grid-template-columns:minmax(0,1fr) 350px;gap:26px;align-items:start}
        .panel{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:0 10px 24px rgba(15,23,42,.07);margin-bottom:26px;overflow:hidden}
        .panel-head{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:24px 26px 12px}
        .panel-title{margin:0;font-size:1.15rem;font-weight:900}
        .panel-body{padding:18px 26px 26px}
        .text{font-weight:800;color:#334155;line-height:1.65;white-space:pre-line}
        .icon-btn{width:40px;height:40px;border-radius:12px;border:1px solid #dbeafe;background:#f8fbff;color:#2563eb;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;cursor:pointer}
        .tiny-btn{display:inline-flex;align-items:center;gap:8px;border:1px solid #bfdbfe;background:#eff6ff;color:#2563eb;border-radius:10px;padding:10px 14px;text-decoration:none;font-weight:900}
        .accordion{display:flex;flex-direction:column;gap:12px}
        .acc-item{border:1px solid var(--border);border-radius:14px;background:#fff;overflow:hidden}
        .acc-header{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 16px;cursor:pointer}
        .acc-left{display:flex;align-items:center;gap:14px;min-width:0}
        .acc-num{width:32px;height:32px;border-radius:999px;background:#2563eb;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;flex:0 0 32px}
        .acc-name{font-weight:900;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .acc-right{display:flex;align-items:center;gap:12px;flex:0 0 auto}
        .pill{border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;color:#334155;font-weight:900;font-size:.8rem;padding:7px 12px}
        .acc-body{display:none;padding:0 16px 16px 62px}
        .topic{display:flex;align-items:center;gap:12px;padding:10px 0;border-top:1px solid #f1f5f9;color:#334155;font-weight:800}
        .stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}
        .stat{background:#fff;border:1px solid var(--border);border-radius:16px;box-shadow:0 8px 18px rgba(15,23,42,.06);padding:22px;display:flex;align-items:center;gap:16px;min-height:116px}
        .stat-ico{width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex:0 0 52px}
        .stat-ico.blue{background:#eff6ff;color:#2563eb}.stat-ico.green{background:#dcfce7;color:#059669}.stat-ico.orange{background:#fff7ed;color:#f97316}.stat-ico.purple{background:#f3e8ff;color:#8b5cf6}
        .stat-label{font-size:.78rem;color:#94a3b8;font-weight:900;text-transform:uppercase;letter-spacing:.08em}
        .stat-value{margin-top:5px;font-size:1.2rem;font-weight:900;color:#0f172a}
        .stat-sub{margin-top:3px;color:#64748b;font-weight:800;font-size:.86rem}
        .preview-img{width:100%;aspect-ratio:4 / 3;object-fit:cover;border-radius:14px;border:1px solid var(--border);display:block;background:#f8fafc}
        .kv{display:grid;gap:0}
        .kv-row{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.1fr);gap:16px;padding:14px 0;border-bottom:1px solid #edf2f7}
        .kv-row:last-child{border-bottom:0}
        .kv-label{display:flex;align-items:center;gap:10px;color:#64748b;font-weight:900}
        .kv-label i{color:#94a3b8}
        .kv-value{text-align:right;font-weight:900;color:#0f172a}
        .empty{padding:22px;text-align:center;color:#64748b;font-weight:900;border:1px dashed #cbd5e1;border-radius:14px;background:#fbfdff}
        .certificate-shell{max-width:1240px;margin:6px auto 0;background:#fff;border:1px solid #dbe4f0;border-radius:22px;box-shadow:0 10px 24px rgba(15,23,42,.06);padding:42px 42px 52px}
        .certificate-title{text-align:center;margin:0 0 30px;font-size:1.55rem;font-weight:900;color:#0f172a}
        .certificate-stage{border:2px dashed #cbd8e8;border-radius:18px;background:#fbfdff;padding:54px 52px;display:flex;flex-direction:column;align-items:center;gap:26px}
        .certificate-name{margin:0;font-size:1.8rem;line-height:1.2;font-weight:900;color:#0f172a;text-align:center}
        .certificate-frame{width:min(100%,980px);background:#fff;border:1px solid #dbe4f0;border-radius:14px;padding:14px;box-shadow:0 1px 0 rgba(15,23,42,.03)}
        .certificate-img{display:block;width:100%;height:auto;max-height:760px;object-fit:contain;background:#fff}
        .settings-shell{max-width:1220px;margin:6px auto 0;background:#fff;border:1px solid #dbe4f0;border-radius:22px;box-shadow:0 10px 24px rgba(15,23,42,.06);padding:42px}
        .settings-title{margin:0 0 28px;font-size:1.55rem;font-weight:900;color:#0f172a}
        .setting-card{border:1px solid #dfe7f2;border-radius:16px;background:#fff;padding:26px;margin-bottom:20px;display:grid;grid-template-columns:minmax(0,1fr) auto;gap:22px;align-items:center}
        .setting-card.danger{background:#fff1f1;border-color:#fecaca}
        .setting-heading{font-size:1.18rem;font-weight:900;color:#0f172a;margin:0 0 6px}
        .setting-card.danger .setting-heading{color:#b91c1c}
        .setting-copy{margin:0;color:#64748b;font-size:1rem;font-weight:700;line-height:1.45}
        .setting-card.danger .setting-copy{color:#dc2626}
        .setting-date-pill{display:inline-flex;align-items:center;justify-content:center;min-height:34px;border-radius:8px;background:#f1f5f9;color:#0f172a;padding:0 14px;font-weight:900;margin-bottom:16px}
        .setting-label{display:block;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;font-size:.78rem;font-weight:900;margin-bottom:8px}
        .setting-form{display:flex;flex-direction:column;gap:16px;align-items:stretch}
        .setting-input-wrap{position:relative}
        .setting-input{width:20%;height:54px;border:1px solid #dbe4f0;border-radius:10px;padding:0 20px 0 16px;font-weight:900;font-size:.98rem;color:#0f172a;outline:none}
        .setting-input:focus{border-color:#93c5fd;box-shadow:0 0 0 3px rgba(37,99,235,.12)}
        .setting-calendar{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#0f172a;pointer-events:none}
        .setting-action{height:54px;border:0;border-radius:10px;background:#0b3a82;color:#fff;padding:0 24px;font-weight:900;font-size:.95rem;cursor:pointer;align-self:flex-end}
        .status-badge{display:inline-flex;align-items:center;justify-content:center;border-radius:9px;background:#e8f8ee;color:#10b981;font-weight:900;text-transform:uppercase;padding:10px 16px}
        .setting-btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;height:44px;border-radius:10px;padding:0 22px;font-weight:900;cursor:pointer;border:1px solid #dbe4f0;background:#f8fafc;color:#64748b;text-decoration:none}
        .setting-btn.delete{border:0;background:#ef4444;color:#fff;box-shadow:0 10px 18px rgba(239,68,68,.18)}
        .tab-pane{display:none}.tab-pane.active{display:block}
        body.sidebar-collapsed .sidebar{width:var(--sidebar-collapsed)}
        body.sidebar-collapsed .header{left:var(--sidebar-collapsed)}
        body.sidebar-collapsed .page{margin-left:var(--sidebar-collapsed)}
        body.sidebar-collapsed .menu-text,body.sidebar-collapsed .portal-row .fa-chevron-up{display:none}
        body.sidebar-collapsed .sidebar-logo{content:url("{{ asset('images/logo1.png') }}");width:44px;height:44px}
        @media (max-width:1100px){.layout{grid-template-columns:1fr}.stats{grid-template-columns:repeat(2,minmax(0,1fr))}.course-title{font-size:1.9rem}}
        @media (max-width:760px){.sidebar{transform:translateX(-100%);width:250px}.sidebar.open{transform:translateX(0)}.header,.page{left:0;margin-left:0}.course-hero{padding:20px 18px 0}.content{padding:20px 16px 32px}.hero-top{flex-direction:column}.stats{grid-template-columns:1fr}.kv-row{grid-template-columns:1fr}.kv-value{text-align:left}.certificate-shell,.settings-shell{padding:24px 16px}.certificate-stage{padding:28px 16px}.certificate-name{font-size:1.35rem}.setting-card{grid-template-columns:1fr;padding:20px}.setting-form{flex-direction:column}.setting-input{border-radius:10px}.setting-action{border-radius:10px;margin-top:0}}
    </style>
</head>
<body>
@php
    $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
    $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
    $creator = $course->users()->whereIn('role', $coachRoles)->orderBy('course_user.created_at', 'asc')->first()
        ?: $course->submittedBy
        ?: $course->trainer
        ?: $course->users()->orderBy('course_user.created_at', 'asc')->first();
    $createdBy = $creator ? ($creator->name . ' (' . str_replace('_', ' ', $creator->role ?? '') . ')') : '-';
    $subjectText = method_exists($course, 'subjectAreaText') ? ($course->subjectAreaText() ?: '-') : ($course->subject_area ?? '-');
    $isPublished = (bool) ($course->is_published ?? false);
    $modulesArr = is_array($course->modules) ? $course->modules : [];
    $participantsCount = $course->users()->whereIn('role', $participantRoles)->wherePivot('status', 'active')->count();
    $assessmentsCount = $course->assessments()->count();
    $enrollStart = optional($course->enrollment_start_date)->format('M d, Y');
    $enrollEnd = optional($course->enrollment_end_date)->format('M d, Y');
    $enrollText = ($enrollStart || $enrollEnd) ? (($enrollStart ?: '-') . ' - ' . ($enrollEnd ?: '-')) : '-';
    $durationStart = optional($course->start_date)->format('M d, Y');
    $durationEnd = optional($course->end_date)->format('M d, Y');
    $durationText = ($durationStart || $durationEnd) ? (($durationStart ?: '-') . ' - ' . ($durationEnd ?: '-')) : ($course->duration ?? '-');
    $previewUrl = route('trainee.courses.show', $course);
    $imageUrl = $course->image_url;
@endphp
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" alt="CAPDEV PRO">
    </div>
    <ul class="sidebar-menu">
        <li class="menu-item portal-row active">
            <span class="portal-left"><span class="menu-icon"><i class="fas fa-layer-group"></i></span><span class="menu-text">Training Manager Portal</span></span>
            <i class="fas fa-chevron-up"></i>
        </li>
        <li><a class="menu-item" href="{{ route('dashboard', ['portal' => 'tm']) }}"><span class="menu-icon"><i class="fas fa-home"></i></span><span class="menu-text">Dashboard</span></a></li>
        <li><a class="menu-item" href="{{ route('dashboard', ['portal' => 'tm', 'tab' => 'user-management']) }}"><span class="menu-icon"><i class="fas fa-users"></i></span><span class="menu-text">User Management</span></a></li>
        <li><a class="menu-item active" href="{{ route('dashboard', ['portal' => 'tm', 'tab' => 'course-management']) }}"><span class="menu-icon"><i class="fas fa-book"></i></span><span class="menu-text">Course Management</span></a></li>
        <li><a class="menu-item" href="{{ route('dashboard', ['portal' => 'tm', 'tab' => 'certification-management']) }}"><span class="menu-icon"><i class="fas fa-certificate"></i></span><span class="menu-text">Certifications</span></a></li>
    </ul>
</aside>
<header class="header">
    <div class="header-left">
        <button class="toggle" type="button" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <h1 class="header-title">Dashboard</h1>
    </div>
    <div class="profile">
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
        <i class="fas fa-chevron-down"></i>
    </div>
</header>
<main class="page">
    <section class="course-hero">
        <div class="hero-top">
            <div>
                <div class="chips">
                    <span class="chip blue">{{ $subjectText }}</span>
                    <span class="chip green">{{ $isPublished ? 'Published' : 'Draft' }}</span>
                </div>
                <h2 class="course-title">{{ $course->name }}</h2>
                <div class="meta">
                    <span><i class="fas fa-user-pen"></i> {{ $createdBy }}</span>
                    <span><i class="fas fa-calendar-days"></i> {{ $durationText }}</span>
                    <span><i class="fas fa-certificate"></i> {{ $course->certification ? 'Certification Enabled' : 'No Certification' }}</span>
                </div>
            </div>
            <div class="actions">
                <a class="btn" href="{{ route('dashboard', ['portal' => 'tm', 'tab' => 'course-management']) }}"><i class="fas fa-arrow-left"></i> Back</a>
                <a class="btn primary" href="{{ route('admin.courses.edit', $course) }}"><i class="fas fa-pen-to-square"></i> Edit Course</a>
            </div>
        </div>
        <div class="tabs" role="tablist">
            <button class="tab active" type="button" data-tab="overview" onclick="switchTab('overview', this)">Overview</button>
            <button class="tab" type="button" data-tab="modules" onclick="switchTab('modules', this)">Modules &amp; Topics</button>
            <button class="tab" type="button" data-tab="enrollment" onclick="switchTab('enrollment', this)">Enrollment</button>
            <button class="tab" type="button" data-tab="examinations" onclick="switchTab('examinations', this)">Examinations</button>
            <button class="tab" type="button" data-tab="certificate" onclick="switchTab('certificate', this)">Certificate</button>
            <button class="tab" type="button" data-tab="settings" onclick="switchTab('settings', this)">Settings</button>
        </div>
    </section>
    <section class="content">
        <div id="tab-overview" class="tab-pane active">
            <div class="layout">
                <div>
                    <section class="panel">
                        <div class="panel-head">
                            <h3 class="panel-title">Course Description</h3>
                            <a class="icon-btn" href="{{ route('admin.courses.edit', $course) }}" title="Edit course"><i class="fas fa-pen"></i></a>
                        </div>
                        <div class="panel-body"><div class="text">{{ $course->description ?: '-' }}</div></div>
                    </section>
                    @include('registrar.partials.course-overview-modules', ['modulesArr' => $modulesArr])
                    <div class="stats">
                        <div class="stat"><div class="stat-ico blue"><i class="fas fa-users"></i></div><div><div class="stat-label">Participants</div><div class="stat-value">{{ $participantsCount }}</div><div class="stat-sub">Enrolled</div></div></div>
                        <div class="stat"><div class="stat-ico green"><i class="fas fa-calendar-check"></i></div><div><div class="stat-label">Enrollment Date</div><div class="stat-value">{{ $enrollText }}</div></div></div>
                        <div class="stat"><div class="stat-ico orange"><i class="fas fa-clock"></i></div><div><div class="stat-label">Duration</div><div class="stat-value">{{ $durationText }}</div></div></div>
                        <div class="stat"><div class="stat-ico purple"><i class="fas fa-list-check"></i></div><div><div class="stat-label">Total Modules</div><div class="stat-value">{{ count($modulesArr) }}</div><div class="stat-sub">Modules</div></div></div>
                    </div>
                </div>
                <aside>
                    <section class="panel">
                        <div class="panel-head">
                            <h3 class="panel-title">Course Preview</h3>
                            <a class="tiny-btn" href="{{ $previewUrl }}" target="_blank" rel="noopener">Preview Course <i class="fas fa-arrow-up-right-from-square"></i></a>
                        </div>
                        <div class="panel-body"><img class="preview-img" src="{{ $imageUrl }}" alt="{{ $course->name }}"></div>
                    </section>
                    <section class="panel">
                        <div class="panel-head"><h3 class="panel-title">Course Details</h3></div>
                        <div class="panel-body">
                            <div class="kv">
                                <div class="kv-row"><div class="kv-label"><i class="fas fa-layer-group"></i> Course Category</div><div class="kv-value">{{ $subjectText }}</div></div>
                                <div class="kv-row"><div class="kv-label"><i class="fas fa-user"></i> Created By</div><div class="kv-value">{{ $creator?->name ?? '-' }}</div></div>
                                <div class="kv-row"><div class="kv-label"><i class="fas fa-calendar-day"></i> Created On</div><div class="kv-value">{{ optional($course->created_at)->format('M d, Y') ?: '-' }}</div></div>
                                <div class="kv-row"><div class="kv-label"><i class="fas fa-clock-rotate-left"></i> Last Updated</div><div class="kv-value">{{ optional($course->updated_at)->format('M d, Y') ?: '-' }}</div></div>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
        <div id="tab-modules" class="tab-pane">@include('registrar.partials.course-overview-modules', ['modulesArr' => $modulesArr])</div>
        <div id="tab-enrollment" class="tab-pane">
            <section class="panel"><div class="panel-head"><h3 class="panel-title">Enrollment</h3><a class="tiny-btn" href="{{ route('registrar.courses.participants', $course) }}"><i class="fas fa-users"></i> Manage Participants</a></div><div class="panel-body"><div class="kv"><div class="kv-row"><div class="kv-label"><i class="fas fa-calendar-check"></i> Enrollment Window</div><div class="kv-value">{{ $enrollText }}</div></div><div class="kv-row"><div class="kv-label"><i class="fas fa-users"></i> Participants</div><div class="kv-value">{{ $participantsCount }}</div></div><div class="kv-row"><div class="kv-label"><i class="fas fa-circle-info"></i> Status</div><div class="kv-value">{{ $isPublished ? 'Published' : 'Draft' }}</div></div></div></div></section>
        </div>
        <div id="tab-examinations" class="tab-pane">
            <section class="panel"><div class="panel-head"><h3 class="panel-title">Examinations</h3></div><div class="panel-body">@if($assessmentsCount)<div class="kv"><div class="kv-row"><div class="kv-label"><i class="fas fa-clipboard-question"></i> Total Assessments</div><div class="kv-value">{{ $assessmentsCount }}</div></div></div>@else<div class="empty">No examinations added yet.</div>@endif</div></section>
        </div>
        <div id="tab-certificate" class="tab-pane">
            @php
                $certificate = $course->certification;
                $certificateName = $certificate?->name ?: $course->name;
                $certificateImg = $certificate?->file_path
                    ? route('media.public', ['path' => $certificate->file_path])
                    : asset('images/capdev cert.jpg');
            @endphp
            <section class="certificate-shell">
                <h3 class="certificate-title">Course Certificate</h3>
                <div class="certificate-stage">
                    <h4 class="certificate-name">{{ $certificateName }}</h4>
                    <div class="certificate-frame">
                        <img class="certificate-img" src="{{ $certificateImg }}" alt="{{ $certificateName }} certificate template">
                    </div>
                </div>
            </section>
        </div>
        <div id="tab-settings" class="tab-pane">
            @php
                $expirationValue = optional($course->course_expiration_date)->format('Y-m-d');
                $expirationDisplay = optional($course->course_expiration_date)->format('M d, Y') ?: 'Not set';
            @endphp
            <section class="settings-shell">
                <h3 class="settings-title">Advanced Settings</h3>

                <div class="setting-card" style="display: block;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                        <div>
                            <h4 class="setting-heading">Course Expiration Date</h4>
                            <p class="setting-copy">Set the date when the course content becomes inaccessible to participants.</p>
                        </div>
                        <div class="setting-date-pill" style="margin-bottom: 0; flex-shrink: 0;">{{ $expirationDisplay }}</div>
                    </div>

                    <form class="setting-form" method="POST" action="{{ route('admin.courses.expiration', $course) }}" style="margin-top:24px">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="setting-label" for="course_expiration_date">Select Date</label>
                            <div class="setting-input-wrap">
                                <input class="setting-input" id="course_expiration_date" type="date" name="course_expiration_date" value="{{ $expirationValue }}" required>
                            </div>
                        </div>
                        <button type="submit" class="setting-action">Update Expiration</button>
                    </form>
                </div>

                <div class="setting-card">
                    <div>
                        <h4 class="setting-heading">Course Visibility</h4>
                        <p class="setting-copy">Control whether participants can find this course.</p>
                    </div>
                    <span class="status-badge">{{ $course->is_published ? 'Public' : 'Private' }}</span>
                </div>

                <div class="setting-card">
                    <div>
                        <h4 class="setting-heading">Archive Course</h4>
                        <p class="setting-copy">Archived courses are hidden from participants but can be restored later.</p>
                    </div>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="margin:0" onsubmit="return confirm('Archive this course?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="setting-btn"><i class="fas fa-box-archive"></i> Archive Course</button>
                    </form>
                </div>

                <div class="setting-card danger">
                    <div>
                        <h4 class="setting-heading">Delete Course</h4>
                        <p class="setting-copy">Permanently remove this course and all its data. This action cannot be undone.</p>
                    </div>
                    <form action="{{ route('courses.force-delete', $course->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Permanently delete this course? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="setting-btn delete"><i class="fas fa-trash-can"></i> Delete Permanently</button>
                    </form>
                </div>
            </section>
        </div>
    </section>
</main>
<script>
    function toggleSidebar(){
        if(window.matchMedia('(max-width: 760px)').matches){document.getElementById('sidebar').classList.toggle('open');return;}
        document.body.classList.toggle('sidebar-collapsed');
    }
    function switchTab(key, el){
        document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
        if(el) el.classList.add('active');
        document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
        const pane=document.getElementById('tab-'+key);
        if(pane) pane.classList.add('active');
    }
    function toggleAccBody(header){
        const body=header.nextElementSibling;
        const icon=header.querySelector('.fa-chevron-down');
        if(!body) return;
        const open=body.style.display==='block';
        body.style.display=open?'none':'block';
        if(icon) icon.style.transform=open?'rotate(0deg)':'rotate(180deg)';
    }
    function toggleAllModules(btn){
        const root=btn.closest('.panel');
        const bodies=root ? root.querySelectorAll('.acc-body') : document.querySelectorAll('.acc-body');
        const shouldOpen=Array.from(bodies).some(b=>b.style.display!=='block');
        bodies.forEach(b=>b.style.display=shouldOpen?'block':'none');
        if(btn) btn.textContent=shouldOpen?'Collapse All':'Expand All';
    }
</script>
</body>
</html>
