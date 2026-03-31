    <!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Participants - {{ $course->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--blue:#002C76;--primary-blue:#002C76;--green:#00a859;--bg:#f4f6f9;--text:#111827;--muted:#6b7280;--border:#e5e7eb;--ring:#60a5fa}
        body{font-family:'DM Sans', sans-serif;margin:0;background:var(--bg);color:var(--text)}
        .container{max-width:1100px;margin:28px auto;padding:0 18px 40px}
        .dashboard-container{display:flex;min-height:calc(100vh - 80px)}
        .sidebar{width:260px;background:var(--primary-blue);color:#fff;display:flex;flex-direction:column}
        .sidebar .sidebar-toggle{display:none}
        .sidebar .menu{list-style:none;margin:0;padding:12px 0}
        .sidebar .menu li a{display:flex;align-items:center;gap:12px;color:rgba(255,255,255,0.9);text-decoration:none;padding:12px 20px}
        .sidebar .menu li a:hover{background:rgba(255,255,255,0.1)}
        .sidebar .menu li.active a{background:rgba(255,255,255,0.15);font-weight:700}
        .menu i{width:20px;text-align:center}
        .main-content{flex:1;min-width:0}
        .topbar{display:flex;justify-content:flex-end;margin-bottom:14px}
        .back{color:#0d6efd;text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border:1px solid var(--border);background:#fff;border-radius:999px;box-shadow:0 1px 2px rgba(0,0,0,.05);transition:all .2s}
        .back:hover{background:#f8fafc;border-color:var(--ring);box-shadow:0 0 0 3px rgba(96,165,250,.15)}
        /* Header styles (reuse registrar dashboard) */
        .header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:1000}
        .header-left{display:flex;align-items:center}
        .header-title img{height:50px}
        .header-right{display:flex;align-items:center;gap:15px}
        .card{background:#fff;border:1px solid var(--border);border-radius:14px;box-shadow:0 8px 24px rgba(17,24,39,.06);margin-bottom:18px}
        .card h3{margin:0;padding:16px 18px;border-bottom:1px solid #eef2f7;color:var(--blue);font-size:1.05rem;display:flex;align-items:center;gap:10px}
        .card .body{padding:18px}
        .meta{display:flex;align-items:center;gap:12px;color:var(--muted);margin:10px 0 18px}
        .shell{background:#fafafa;border:1px solid var(--border);border-radius:12px;padding:8px;box-shadow:inset 0 1px 0 #f8fafc}
        .list{width:100%;min-height:260px;max-height:320px;border:1px solid var(--border);border-radius:10px;background:#fff;overflow:auto}
        .item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-bottom:1px solid #f1f5f9}
        .item:last-child{border-bottom:none}
        .item input[type=checkbox]{width:16px;height:16px}
        .item-label{color:var(--text)}
        .list:focus-within{border-color:var(--ring);box-shadow:0 0 0 3px rgba(96,165,250,.25)}
        .badge{display:inline-block;border-radius:999px;padding:2px 8px;font-size:.75rem}
        .b-pending{background:#fef3c7;color:#92400e}
        .b-active{background:#dcfce7;color:#065f46}
        .submit{margin-top:18px;text-align:right}
        .btn{border:none;background:var(--green);color:#fff;padding:12px 18px;border-radius:12px;cursor:pointer;font-weight:600}
        .btn:hover{filter:brightness(0.95)}
        .btn-blue{background:var(--blue);color:#fff}
        .btn-blue:hover{background:#001f54}
        .modal{display:none;position:fixed;z-index:2000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center}
        .modal-content{background:#fff;padding:24px;border-radius:16px;width:100%;max-width:400px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1)}
        .modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
        .modal-header h2{margin:0;font-size:1.25rem;color:var(--blue)}
        .close{cursor:pointer;font-size:1.5rem;color:var(--muted)}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;margin-bottom:6px;font-weight:600;color:#374151}
        .form-group input{width:100%;padding:10px;border:1px solid var(--border);border-radius:10px;box-sizing:border-box}
        .row{display:flex;align-items:center;gap:8px;margin:6px 0;color:#374151}
        .row i{color:#9ca3af}
        .info{font-size:.9rem;color:var(--muted);margin-top:6px}
        .summary-controls{display:flex;gap:10px;align-items:center;margin-bottom:10px}
        .summary-controls .search{max-width:360px;flex:1}
        .summary-controls select{border:1px solid var(--border);border-radius:10px;padding:9px 12px;background:#fff}
        .summary-table{display:grid;border:1px solid var(--border);border-radius:12px;overflow:hidden}
        .summary-header, .summary-row{display:grid;grid-template-columns:1.5fr 3fr .8fr}
        .summary-table.cols-4 .summary-header, .summary-table.cols-4 .summary-row{grid-template-columns:1.5fr 1fr 1.4fr .8fr}
        .summary-header{background:#f8fafc;font-weight:700;color:#374151}
        .summary-cell{padding:10px 12px;border-bottom:1px solid #eef2f7}
        .summary-row:last-child .summary-cell{border-bottom:none}
        .chips{display:flex;flex-wrap:wrap;gap:6px}
        .chip{background:#f1f5f9;color:#111827;border:1px solid var(--border);padding:4px 8px;border-radius:999px;font-size:.85rem}
        .badge{display:inline-block;background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;font-size:.7rem;padding:2px 6px;border-radius:999px;margin-left:8px;vertical-align:middle}
        .pager{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
        .pager .pages{display:flex;gap:6px;align-items:center}
        .pager button{border:1px solid var(--border);background:#fff;border-radius:8px;padding:6px 10px;cursor:pointer}
        .pager button.active{background:#eef2ff;border-color:#c7d2fe;color:#1e3a8a}
        .pager .info{color:var(--muted)}
        .tabs{display:flex;gap:8px;margin:10px 0 14px}
        .tab-btn{border:1px solid var(--border);background:#fff;color:#111827;padding:10px 14px;border-radius:10px;cursor:pointer;font-weight:600}
        .tab-btn.active{background:#eef2ff;border-color:#c7d2fe;color:#1e3a8a}
        .tab-panel{display:none}
        .tab-panel.active{display:block}
        .dual{display:grid;grid-template-columns:minmax(0,1fr) 84px minmax(0,1fr);gap:14px;align-items:stretch}
        .dual>div{min-width:0}
        .dual .actions{display:grid;gap:10px;justify-content:center;align-content:center}
        .dual .actions button{height:42px;min-width:42px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:#fff;border-radius:10px;cursor:pointer;box-shadow:0 1px 2px rgba(0,0,0,.05)}
        .dual .actions button:hover{background:#f8fafc}
        .col-title{font-weight:700;color:#111827;margin:2px 0 8px}
        .list-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;gap:10px;flex-wrap:nowrap}
        .search{position:relative;flex:1;min-width:0;max-width:100%}
        .search input{width:100%;max-width:100%;box-sizing:border-box;padding:10px 12px 10px 36px;border:1px solid var(--border);border-radius:10px;background:#fff}
        .search input:focus{border-color:var(--ring);box-shadow:0 0 0 3px rgba(96,165,250,.25)}
        .search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af}
        .count{font-size:.85rem;color:var(--muted);white-space:nowrap;margin-right:8px}
        .card .body{overflow:hidden}
        .stats-grid{display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:18px;margin-top:12px}
        @media (min-width:900px){.stats-grid{grid-template-columns:repeat(3,1fr)}}
        .stat-card{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:14px 16px;box-shadow:0 8px 24px rgba(17,24,39,.06)}
        .stat-icon{width:44px;height:44px;border-radius:999px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#1e3a8a}
        .stat-info h3{margin:0;font-size:1.6rem;color:#002C76}
        .stat-info p{margin:0;color:#6b7280}
    </style>
</head>
<body>
    <!-- Header replicated to retain look from registrar dashboard -->
    <header class="header">
        <div class="header-left">
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
            </div>
        </div>
        <div class="header-right">
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
                        <span style="font-size: 0.8rem; color: var(--muted);">{{ isset($unreadNotificationsCount) ? $unreadNotificationsCount : 0 }} New</span>
                    </div>
                    <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="notification-item" onclick="markAsRead('{{ $notification->id }}', '{{ $notification->link }}')" style="padding: 10px 15px; border-bottom: 1px solid #eee; cursor: pointer; background-color: {{ $notification->is_read ? 'white' : '#e3f2fd' }}; transition: background-color 0.2s;">
                                    <div style="font-size: 0.9rem; font-weight: bold; color: var(--text); margin-bottom: 5px;">
                                        @if(!$notification->is_read) <span style="display: inline-block; width: 8px; height: 8px; background-color: #007bff; border-radius: 50%; margin-right: 5px;"></span> @endif
                                        {{ $notification->title }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--muted); margin-bottom: 5px;">{{ $notification->message }}</div>
                                    <div style="font-size: 0.7rem; color: #aaa;">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        @else
                            <div style="padding: 12px 15px; color: var(--muted);">No notifications</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="menu">
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li><a href="{{ route('dashboard', ['tab' => 'user-management']) }}"><i class="fas fa-users"></i><span>User Management</span></a></li>
                <li class="active"><a href="{{ route('dashboard', ['tab' => 'trainer-trainee-management']) }}"><i class="fas fa-chalkboard-teacher"></i><span>Training Management</span></a></li>
            </ul>
        </aside>
        <main class="main-content">
    <div class="container">
        <div class="topbar">
            <a class="back" href="{{ route('dashboard', ['tab' => 'trainer-trainee-management']) }}"><i class="fas fa-arrow-left"></i> Back to Training Management</a>
        </div>
        <div class="card" style="margin-bottom:16px;">
            <h3>Course</h3>
            <div class="body">
                @php
                    $coachRolesAll = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                    $participantRolesAll = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
                    $trainersCount = $course->users ? $course->users->filter(fn($u)=>in_array($u->role, $coachRolesAll))->count() : 0;
                    $pendingTraineesCount = $course->users ? $course->users->filter(fn($u)=>in_array($u->role, $participantRolesAll) && optional($u->pivot)->status==='pending')->count() : 0;
                    $enrolledTraineesCount = $course->users ? $course->users->filter(fn($u)=>in_array($u->role, $participantRolesAll) && optional($u->pivot)->status==='active')->count() : 0;
                @endphp
                <div style="font-weight:700;color:#002C76;font-size:1.1rem;">{{ $course->name }}</div>
                <div class="meta">
                    <span><i class="fas fa-layer-group"></i> {{ $course->subject_area ?: 'Uncategorized' }}</span>
                </div>
                <p class="info">Select coaches and trainees to be active in this course. Selecting a trainee who previously requested to join will approve them.</p>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(13,110,253,0.12); color:#0d6efd;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $trainersCount }}</h3>
                            <p>Total Coaches</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(255,193,7,0.12); color:#fd7e14;">
                            <i class="fas fa-user-hourglass"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $pendingTraineesCount }}</h3>
                            <p>Pending Trainees</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(25,135,84,0.12); color:#198754;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $enrolledTraineesCount }}</h3>
                            <p>Enrolled Trainees</p>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                    <button class="btn-primary" onclick="openEnrollmentModal('{{ $course->enrollment_start ? $course->enrollment_start->format('Y-m-d\TH:i') : '' }}', '{{ $course->enrollment_end ? $course->enrollment_end->format('Y-m-d\TH:i') : '' }}')">
                        <i class="fas fa-calendar-alt"></i> Set Enrollment Schedule
                    </button>
                    <span style="margin-left: 10px; font-size: 0.9rem; color: #666;">
                        @if($course->enrollment_start || $course->enrollment_end)
                            Current: {{ $course->enrollment_start ? $course->enrollment_start->format('M d, Y g:i A') : 'TBA' }} - {{ $course->enrollment_end ? $course->enrollment_end->format('M d, Y g:i A') : 'TBA' }}
                        @else
                            Schedule not set
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('courses.updateParticipants', $course) }}" id="participantsForm">
            @csrf
            @method('PUT')
            <div class="tabs">
                <button type="button" class="tab-btn active" data-tab="trainers"><i class="fas fa-user-tie"></i> Coaches</button>
                <button type="button" class="tab-btn" data-tab="trainees"><i class="fas fa-user-graduate"></i> Participants</button>
            </div>
            <div id="tab-trainers" class="tab-panel active">
            <div class="card">
                <h3><i class="fas fa-list"></i> Coaches Summary</h3>
                <div class="body">
                    @if(isset($assignedTrainers) && $assignedTrainers->count())
                        @php $assignedIds = $course->users->whereIn('role',['coach','trainer'])->pluck('id')->toArray(); @endphp
                        <div class="summary-controls">
                            <div class="search" style="flex:1"><i class="fas fa-search"></i><input id="trainer_summary_search" type="text" placeholder="Search coach or course"></div>
                            <select id="trainer_summary_scope" aria-label="Scope">
                                <option value="all">All coaches</option>
                                <option value="assigned">Assigned only</option>
                            </select>
                            <select id="trainer_summary_filter" aria-label="Filter by total courses">
                                <option value="all">All totals</option>
                                <option value="0">0 courses</option>
                                <option value="1">1 course</option>
                                <option value="2">2 courses</option>
                                <option value="3plus">3+ courses</option>
                            </select>
                        </div>
                        <div class="summary-table" id="trainer_summary_table">
                            <div class="summary-header">
                                <div class="summary-cell">Name</div>
                                <div class="summary-cell">Courses</div>
                                <div class="summary-cell" style="text-align:right">Total</div>
                            </div>
                            @foreach($assignedTrainers as $t)
                                @php 
                                    $courses = $t->courses ?? collect(); 
                                    $courseNames = $courses->pluck('name')->filter()->values()->all();
                                    $courseText = strtolower(implode(' ', $courseNames));
                                @endphp
                                <div class="summary-row" data-name="{{ strtolower($t->name) }}" data-courses="{{ $courseText }}" data-count="{{ $courses->count() }}" data-assigned="{{ in_array($t->id, $assignedIds) ? '1' : '0' }}">
                                    <div class="summary-cell">{{ $t->name }} @if(in_array($t->id, $assignedIds))<span class="badge">Assigned</span>@endif</div>
                                    <div class="summary-cell">
                                        @if(count($courseNames))
                                            <div class="chips">
                                                @foreach($courseNames as $cn)
                                                    <span class="chip">{{ $cn }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span style="color:var(--muted)">—</span>
                                        @endif
                                    </div>
                                    <div class="summary-cell" style="text-align:right">{{ $courses->count() }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pager" id="trainer_summary_pager">
                            <div class="info"><span id="trainer_summary_range">Showing 0–0 of 0</span></div>
                            <div class="pages">
                                <button type="button" id="trainer_summary_prev">Prev</button>
                                <span id="trainer_summary_page_numbers"></span>
                                <button type="button" id="trainer_summary_next">Next</button>
                            </div>
                        </div>
                    @else
                        <div class="info">No coaches found.</div>
                    @endif
                </div>
            </div>
            <div class="card">
                <h3><i class="fas fa-user-tie"></i> Coaches</h3>
                <div class="body">
                    @php
                        $currentTrainers = $course->users->whereIn('role',['coach','trainer'])->pluck('id')->toArray();
                        $availableTrainers = $potentialTrainers->filter(fn($u)=>!in_array($u->id, $currentTrainers));
                    @endphp
                    <div class="dual">
                        <div>
                            <div class="col-title">Available options</div>
                            <div class="list-head">
                                <div class="count"><span id="avail_sel_count_tr">0</span> of <span id="avail_total_count_tr">{{ count($availableTrainers) }}</span> items selected</div>
                                <div class="search"><i class="fas fa-search"></i><input id="filter_available_trainers" type="text" placeholder="Find by name"></div>
                            </div>
                            <div class="shell">
                                <div id="available_trainers" class="list" aria-label="Available coaches">
                                    @foreach($availableTrainers as $user)
                                        <label class="item" data-id="{{ $user->id }}" data-name="{{ strtolower($user->name) }}">
                                            <input type="checkbox">
                                            <span class="item-label">{{ $user->name }} ({{ $user->email }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="button" onclick="moveSelected('available_trainers','selected_trainers')"><i class="fas fa-chevron-right"></i></button>
                            <button type="button" onclick="moveAll('available_trainers','selected_trainers')"><i class="fas fa-angles-right"></i></button>
                            <button type="button" onclick="moveAll('selected_trainers','available_trainers')"><i class="fas fa-angles-left"></i></button>
                            <button type="button" onclick="moveSelected('selected_trainers','available_trainers')"><i class="fas fa-chevron-left"></i></button>
                        </div>
                        <div>
                            <div class="col-title">Chosen options</div>
                            <div class="list-head">
                                <div class="count"><span id="sel_sel_count_tr">{{ count($currentTrainers) }}</span> of <span id="sel_total_count_tr">{{ count($currentTrainers) }}</span> items selected</div>
                                <div class="search"><i class="fas fa-search"></i><input id="filter_selected_trainers" type="text" placeholder="Find by name"></div>
                            </div>
                            <div class="shell">
                                <div id="selected_trainers" class="list" aria-label="Selected coaches">
                                    @foreach($potentialTrainers as $user)
                                        @if(in_array($user->id, $currentTrainers))
                                            <label class="item" data-id="{{ $user->id }}" data-name="{{ strtolower($user->name) }}">
                                                <input type="checkbox">
                                                <span class="item-label">{{ $user->name }} ({{ $user->email }})</span>
                                                <input type="hidden" name="trainer_ids[]" value="{{ $user->id }}">
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info">Move coaches to Selected to assign them to this course.</div>
                </div>
            </div>
            </div>
            <div id="tab-trainees" class="tab-panel">
            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;padding-right:18px">
                    <h3><i class="fas fa-list"></i> Participants Summary</h3>
                    <button type="button" class="btn btn-blue" onclick="openManualEnrollModal()"><i class="fas fa-plus"></i> Add Participants</button>
                </div>
                <div class="body">
                    @php 
                        $participantRolesAll = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
                        $courseTrainees = $course->users
                            ->whereIn('role',$participantRolesAll)
                            ->filter(fn($u)=> in_array(optional($u->pivot)->status, ['pending','active']));
                    @endphp
                    @if($courseTrainees->count())
                        <div class="summary-table cols-4" id="trainee_summary_table">
                            <div class="summary-header">
                                <div class="summary-cell">Name</div>
                                <div class="summary-cell">Account ID</div>
                                <div class="summary-cell">Enrolled At</div>
                                <div class="summary-cell" style="text-align:right">Action</div>
                            </div>
                            @foreach($courseTrainees as $t)
                                <div class="summary-row">
                                    <div class="summary-cell">{{ $t->name }}</div>
                                    <div class="summary-cell">{{ $t->status === 'pending' ? '—' : ($t->account_id ?? '—') }}</div>
                                    @php 
                                        $st = optional($t->pivot)->status; 
                                        $enrolledAt = ($st === 'active' && optional($t->pivot)->updated_at)
                                            ? optional($t->pivot->updated_at)->timezone(config('app.timezone'))->format('m/d/y g:ia')
                                            : '—';
                                    @endphp
                                    <div class="summary-cell">{{ $enrolledAt }}</div>
                                    <div class="summary-cell" style="text-align:right">
                                        <form action="{{ route('courses.participants.detach', [$course->id, $t->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this participant?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none;border:none;color:#dc3545;cursor:pointer;" title="Remove"><i class="fas fa-user-minus"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="info">No trainees found.</div>
                    @endif
                </div>
            </div>
            </div>
            <div class="submit">
                <button type="submit" class="btn"><i class="fas fa-save"></i> Save Participants</button>
            </div>
        </form>
    </div>
        </main>
    </div>
    <div id="manualEnrollModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Participants</h3>
                <button type="button" class="close-modal" onclick="closeManualEnrollModal()">&times;</button>
            </div>
            <form action="{{ route('courses.participants.manual', $course->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Select Users</label>
                    <div style="max-height:200px;overflow-y:auto;border:1px solid #ddd;padding:10px;border-radius:4px;">
                        @foreach($potentialTrainees as $pt)
                            <label style="display:block;margin-bottom:5px;">
                                <input type="checkbox" name="user_ids[]" value="{{ $pt->id }}"> {{ $pt->name }} ({{ $pt->email }})
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:15px;">
                    <button type="button" class="btn" style="background:#eee;color:#333" onclick="closeManualEnrollModal()">Cancel</button>
                    <button type="submit" class="btn btn-blue">Add Selected</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Enrollment Schedule Modal -->
    <div id="enrollmentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-user-plus"></i> Set Enrollment Schedule
                </h3>
                <button type="button" class="close-modal" onclick="closeEnrollmentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="enrollmentForm" method="POST" action="{{ route('trainer.courses.enrollment-schedule', $course->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" for="enroll_start" style="display:block;margin-bottom:5px;font-weight:bold;">Enrollment Start</label>
                        <input type="datetime-local" name="enrollment_start" id="enroll_start" class="form-control" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" required>
                        <small style="color:#666;display:block;margin-top:4px;">Date and time when trainees can start enrolling.</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" for="enroll_end" style="display:block;margin-bottom:5px;font-weight:bold;">Enrollment End</label>
                        <input type="datetime-local" name="enrollment_end" id="enroll_end" class="form-control" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;" required>
                        <small style="color:#666;display:block;margin-top:4px;">Date and time when enrollment closes.</small>
                    </div>
                </div>
                <div class="modal-footer" style="padding:15px;border-top:1px solid #eee;display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" class="btn" style="background:#eee;color:#333;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;" onclick="closeEnrollmentModal()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-blue" style="background:#007bff;color:white;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;">
                        <i class="fas fa-save"></i> Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
<script>
    function openManualEnrollModal() {
        document.getElementById('manualEnrollModal').style.display = 'flex';
    }
    function closeManualEnrollModal() {
        document.getElementById('manualEnrollModal').style.display = 'none';
    }
    window.onclick = function(event) {
        const manualModal = document.getElementById('manualEnrollModal');
        if (event.target == manualModal) {
            closeManualEnrollModal();
        }
        const enrollmentModal = document.getElementById('enrollmentModal');
        if (event.target == enrollmentModal) {
            closeEnrollmentModal();
        }
    }

    function openEnrollmentModal(start, end) {
        const modal = document.getElementById('enrollmentModal');
        const startInput = document.getElementById('enroll_start');
        const endInput = document.getElementById('enroll_end');

        if(start) startInput.value = start;
        if(end) endInput.value = end;

        modal.style.display = 'flex';
    }

    function closeEnrollmentModal() {
        document.getElementById('enrollmentModal').style.display = 'none';
    }
    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
            btn.classList.add('active');
            const id = 'tab-' + btn.dataset.tab;
            const panel = document.getElementById(id);
            if(panel) panel.classList.add('active');
        });
    });
    function moveSelected(fromId,toId){
        if(fromId === 'available_trainees' || toId === 'available_trainees') return;
        const from=document.getElementById(fromId);
        const to=document.getElementById(toId);
        const items=Array.from(from.querySelectorAll('.item input:checked')).map(cb=>cb.closest('.item'));
        items.forEach(it=>{
            it.querySelector('input[type=checkbox]').checked=false;
            to.appendChild(it);
        });
        syncHiddenInputs();
        syncAllCounts();
        applyFilterGeneric('filter_available_trainers','available_trainers','avail_total_count_tr');
        applyFilterGeneric('filter_selected_trainers','selected_trainers','sel_total_count_tr');
    }
    function moveAll(fromId,toId){
        if(fromId === 'available_trainees' || toId === 'available_trainees') return;
        const from=document.getElementById(fromId);
        const to=document.getElementById(toId);
        const items=Array.from(from.querySelectorAll('.item'));
        items.forEach(it=>{
            it.querySelector('input[type=checkbox]').checked=false;
            to.appendChild(it);
        });
        syncHiddenInputs();
        syncAllCounts();
        applyFilterGeneric('filter_available_trainers','available_trainers','avail_total_count_tr');
        applyFilterGeneric('filter_selected_trainers','selected_trainers','sel_total_count_tr');
    }
    document.getElementById('participantsForm').addEventListener('submit', function(){
        syncHiddenInputs();
    });
    function applyFilterGeneric(inputId, listId, totalSpanId){
        const q=document.getElementById(inputId).value.trim().toLowerCase();
        const sel=document.getElementById(listId);
        let total=0;
        Array.from(sel.querySelectorAll('.item')).forEach(it=>{
            const name=(it.getAttribute('data-name')||it.textContent||'').toLowerCase();
            const match=!q || name.includes(q);
            it.style.display = match ? '' : 'none';
            if(match) total++;
        });
        document.getElementById(totalSpanId).textContent=total;
    }
    function updateCounts(listId, selCountId, totalCountId){
        const el=document.getElementById(listId);
        const selectedVisible=Array.from(el.querySelectorAll('.item input:checked')).filter(cb=>cb.closest('.item').style.display!=='none').length;
        const totalVisible=Array.from(el.querySelectorAll('.item')).filter(it=>it.style.display!=='none').length;
        document.getElementById(selCountId).textContent=selectedVisible;
        document.getElementById(totalCountId).textContent=totalVisible;
    }
    function syncAllCounts(){
        updateCounts('available_trainees','avail_sel_count','avail_total_count');
        updateCounts('selected_trainees','sel_sel_count','sel_total_count');
        updateCounts('available_trainers','avail_sel_count_tr','avail_total_count_tr');
        updateCounts('selected_trainers','sel_sel_count_tr','sel_total_count_tr');
    }
    function syncHiddenInputs(){
        // trainers
        const selTr=document.getElementById('selected_trainers');
        selTr.querySelectorAll('input[type=hidden][name="trainer_ids[]"]').forEach(n=>n.remove());
        Array.from(selTr.querySelectorAll('.item')).forEach(it=>{
            const id=it.getAttribute('data-id');
            const h=document.createElement('input');
            h.type='hidden'; h.name='trainer_ids[]'; h.value=id;
            it.appendChild(h);
        });
        // trainees
        const selT=document.getElementById('selected_trainees');
        selT.querySelectorAll('input[type=hidden][name="trainee_ids[]"]').forEach(n=>n.remove());
        Array.from(selT.querySelectorAll('.item')).forEach(it=>{
            const id=it.getAttribute('data-id');
            const h=document.createElement('input');
            h.type='hidden'; h.name='trainee_ids[]'; h.value=id;
            it.appendChild(h);
        });
    }
    document.getElementById('available_trainers').addEventListener('change',syncAllCounts);
    document.getElementById('selected_trainers').addEventListener('change',syncAllCounts);
    if(document.getElementById('filter_available_trainers')) document.getElementById('filter_available_trainers').addEventListener('input',()=>applyFilterGeneric('filter_available_trainers','available_trainers','avail_total_count_tr'));
    if(document.getElementById('filter_selected_trainers')) document.getElementById('filter_selected_trainers').addEventListener('input',()=>applyFilterGeneric('filter_selected_trainers','selected_trainers','sel_total_count_tr'));
    // Ensure no items are pre-selected on load for all lists
    ['available_trainers','selected_trainers'].forEach(function(id){
        var el=document.getElementById(id);
        if(el){ el.querySelectorAll('.item input[type=checkbox]').forEach(function(cb){ cb.checked=false; }); }
    });
    applyFilterGeneric('filter_available_trainers','available_trainers','avail_total_count_tr');
    applyFilterGeneric('filter_selected_trainers','selected_trainers','sel_total_count_tr');
    syncHiddenInputs();
    syncAllCounts();
    // Header notifications
    function toggleNotifications(){
        const dd=document.getElementById('notificationDropdown');
        dd.style.display = dd.style.display==='block' ? 'none' : 'block';
    }
    function markAsRead(id,link){
        fetch('/notifications/'+id+'/mark-as-read',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({})})
        .then(()=>{ if(link && link!=='null' && link!==''){ window.location.href=link; }});
    }
    // Trainers summary search/filter
    const TS={page:1,size:10};
    function trainerSummaryMatches(){
        const q=(document.getElementById('trainer_summary_search')?.value||'').trim().toLowerCase();
        const f=document.getElementById('trainer_summary_filter')?.value||'all';
        const scope=document.getElementById('trainer_summary_scope')?.value||'all';
        const rows=Array.from(document.querySelectorAll('#trainer_summary_table .summary-row'));
        const matched=rows.filter(row=>{
            const name=row.getAttribute('data-name')||'';
            const courses=row.getAttribute('data-courses')||'';
            const count=parseInt(row.getAttribute('data-count')||'0',10);
            const assigned=row.getAttribute('data-assigned')==='1';
            const matchSearch=!q || name.includes(q) || courses.includes(q);
            let matchFilter=true;
            if(f==='0') matchFilter = count===0;
            else if(f==='1') matchFilter = count===1;
            else if(f==='2') matchFilter = count===2;
            else if(f==='3plus') matchFilter = count>=3;
            const matchScope = scope==='all' ? true : assigned;
            return matchSearch && matchFilter && matchScope;
        });
        const qv=(document.getElementById('trainer_summary_search')?.value||'').trim().toLowerCase();
        if(qv){
            matched.sort((a,b)=>{
                const na=a.getAttribute('data-name')||'';
                const nb=b.getAttribute('data-name')||'';
                const ia=na.indexOf(qv); const ib=nb.indexOf(qv);
                const sa=ia===-1?999:ia; const sb=ib===-1?999:ib;
                if(sa!==sb) return sa-sb;
                return na.localeCompare(nb);
            });
        }
        return matched;
    }
    function renderTrainerSummary(){
        const rows=Array.from(document.querySelectorAll('#trainer_summary_table .summary-row'));
        rows.forEach(r=>r.style.display='none');
        const matched=trainerSummaryMatches();
        const total=matched.length;
        const totalPages = Math.max(1, Math.ceil(total/TS.size));
        if(TS.page>totalPages) TS.page=totalPages;
        const start=(TS.page-1)*TS.size;
        const end=Math.min(start+TS.size, total);
        matched.slice(start,end).forEach(r=>r.style.display='grid');
        const range=document.getElementById('trainer_summary_range');
        if(range) range.textContent = total ? `Showing ${start+1}–${end} of ${total}` : 'Showing 0–0 of 0';
        const pn=document.getElementById('trainer_summary_page_numbers');
        if(pn){
            pn.innerHTML='';
            for(let i=1;i<=totalPages;i++){
                const b=document.createElement('button');
                b.type='button';
                b.textContent=String(i);
                if(i===TS.page) b.classList.add('active');
                b.addEventListener('click',()=>{TS.page=i; renderTrainerSummary();});
                pn.appendChild(b);
            }
        }
        const prev=document.getElementById('trainer_summary_prev');
        const next=document.getElementById('trainer_summary_next');
        if(prev){ prev.disabled = TS.page<=1; prev.onclick=()=>{ if(TS.page>1){TS.page--; renderTrainerSummary();} }; }
        if(next){ next.disabled = TS.page>=totalPages; next.onclick=()=>{ if(TS.page<totalPages){TS.page++; renderTrainerSummary();} }; }
    }
    function filterTrainerSummary(){ TS.page=1; renderTrainerSummary(); }
    document.getElementById('trainer_summary_search')?.addEventListener('input', filterTrainerSummary);
    document.getElementById('trainer_summary_filter')?.addEventListener('change', filterTrainerSummary);
    document.getElementById('trainer_summary_scope')?.addEventListener('change', filterTrainerSummary);
    renderTrainerSummary();
</script>
</body>
</html>
