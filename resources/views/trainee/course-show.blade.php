<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} · Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root{--blue:#002C76;--muted:#6b7280;--border:#e5e7eb;--ring:#60a5fa;--bg:#f4f6f9;--b:#2563eb;--bsoft:#eef2ff}
        body{margin:0;font-family:'DM Sans', sans-serif;background:var(--bg);color:#111827}
        :root{--app-sidebar-w:250px;--app-header-h:80px}
        .with-app-side{padding-left:var(--app-sidebar-w)}
        .side-collapsed{--app-sidebar-w:70px}
        .app-side{position:fixed;left:0;top:var(--app-header-h);bottom:0;width:var(--app-sidebar-w);background:#002C76;color:#fff;z-index:25;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,.12)}
        .app-side .app-side-header{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.12)}
        .app-side .app-initial{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.25);font-weight:800}
        .app-side a{color:rgba(255,255,255,.9);text-decoration:none;display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid rgba(255,255,255,.06)}
        .app-side a:hover{background:rgba(255,255,255,.08)}
        .app-side.collapsed .app-side-header div:nth-child(2){display:none}
        .app-side.collapsed a span{display:none}
        .app-side.collapsed a{justify-content:center}
        .app-side.collapsed .app-initial{margin:0 auto}
        @media (max-width: 900px){ .with-app-side{padding-left:0}.app-side{display:none}.app-side.side-open{display:flex;box-shadow:0 18px 38px rgba(0,0,0,.25)} }
        /* App Header */
        .app-header{background:#fff;min-height:80px;padding:10px 20px;box-shadow:0 2px 4px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:20}
        .app-header-left{display:flex;align-items:center;gap:12px}
        .app-header-logo{height:48px}
        .app-header-right a{color:#1a1a1a;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:6px}
        .round-btn{width:40px;height:40px;border-radius:50%;border:1px solid #dfe3ea;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#0f3b8f}
        /* Page Topbar (under header) */
        .topbar{display:flex;align-items:center;justify-content:space-between;background:#fff;border-bottom:1px solid var(--border);padding:10px 16px;position:sticky;top:80px;z-index:10}
        .back{color:#0d6efd;text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid var(--border);border-radius:999px;background:#fff}
        .layout{display:grid;grid-template-columns:320px 1fr;height:calc(100vh - 56px);gap:14px;padding:14px}
        .sidebar{border-right:1px solid var(--border);background:var(--blue);display:flex;flex-direction:column;border-radius:14px;overflow:hidden;box-shadow:0 14px 30px rgba(15,23,42,.14)}
        .sidebar h3{margin:12px 12px 8px;color:#fff;font-size:1rem}
        .search{padding:10px 12px 12px}
        .search input{width:100%;padding:10px 12px;border:1px solid rgba(255,255,255,0.25);border-radius:999px;background:#fff;font-weight:700}
        .outline{overflow:auto;padding:8px 8px 16px;scrollbar-width:thin}
        .module{border:1px solid var(--border);border-radius:10px;margin:8px;background:#fff}
        .module-header{display:flex;justify-content:space-between;align-items:center;padding:12px;cursor:pointer;background:#f0f6ff;border-radius:10px 10px 0 0}
        .module-title{font-weight:800;color:#111827;font-size:1.05rem;letter-spacing:-0.01em;display:flex;align-items:center;gap:10px}
        .module-kpi{font-weight:700;color:#1f2937;font-size:.9rem}
        .module-bar{height:6px;border-radius:999px;background:#e5efff;margin:8px 12px}
        .module-bar > span{display:block;height:100%;background:linear-gradient(90deg,#1d4ed8,#2563eb);border-radius:999px;width:0%}
        .topics{display:none;border-top:1px dashed var(--border);padding:0 0 10px;background:#fff;border-radius:0 0 10px 10px}
        .topic{padding:12px;border-radius:10px;margin:0;cursor:pointer;display:block;position:relative;background:#eff6ff;border-bottom:1px solid #dbeafe}
        .topic-head{display:flex;align-items:center;gap:8px}
        .topic-head .title{font-size:1rem;font-weight:800;color:#0f3b8f}
        .topic-head .count{margin-left:auto;color:#1e40af;font-weight:700;display:none}
        .topic-head .toggle{border:none;background:transparent;color:#0f3b8f;margin-left:6px;cursor:pointer;padding:4px;border-radius:6px}
        .topic-head .toggle:hover{background:#e0e7ff}
        .topic:hover{background:#f8fafc}
        .topic.active{background:#dbeafe}
        .subs{margin:8px 0 6px 0;padding:10px;border:1px solid #e5e7eb;border-radius:10px;display:none;background:#f8fafc;box-shadow:0 2px 6px rgba(0,0,0,0.05)}
        .sub-item{display:flex;align-items:flex-start;gap:10px;padding:10px 12px;border-radius:10px;margin:6px 0;cursor:pointer;background:#fff;border:1px solid #e5e7eb}
        .sub-item:hover{background:#f8fafc}
        .sub-item.active{background:#eef2ff;border-left:3px solid var(--b)}
        .sub-item span{font-size:.95rem;color:#111827}
        .sub-item.active span{font-weight:700}
        .sub-item .dot{width:18px;height:18px;border-radius:999px;border:2px solid #9ca3af;display:inline-flex;align-items:center;justify-content:center;background:#fff}
        .sub-item .dot.done{border-color:var(--b);background:var(--b);color:#fff}
        .sub-connector{position:relative;padding-left:10px}
        .sub-connector::before{content:'';position:absolute;left:-18px;top:0;bottom:0;border-left:2px dashed #d1d5db}
        .content{padding:16px;overflow:auto}
        .pane{background:#fff;border:1px solid var(--border);border-radius:16px;padding:18px}
        .pane h2{margin:6px 0 14px;color:#111827;font-size:1.75rem;font-weight:800;letter-spacing:-0.015em}
        .lock{display:flex;align-items:center;justify-content:center;height:420px;background:#e6eef7;border:2px dashed #bcd2ea;border-radius:12px;color:#223}
        .chips{display:flex;gap:8px;flex-wrap:wrap}
        .chip{background:#f1f5f9;border-radius:999px;border:1px solid var(--border);padding:4px 8px}
        .field{border:1px solid var(--border);border-radius:14px;margin:12px 0;padding:20px;background:#fff;min-height:96px}
        #contentBody .field:nth-child(even){background:#f8fafc}
        /* Pro content rendering */
        #contentBody .field img{max-width:100%;height:auto;border-radius:12px;display:block;margin:6px auto;box-shadow:0 10px 24px rgba(15,23,42,.08);border:1px solid var(--border)}
        #contentBody .field iframe{width:100%;aspect-ratio:16/9;height:auto;border:none;border-radius:14px;box-shadow:0 14px 28px rgba(15,23,42,.14);border:1px solid var(--border);background:#000}
        #contentBody .field table{width:100%;border-collapse:separate;border-spacing:0;border:1px solid var(--border);border-radius:14px;overflow:hidden;display:block}
        #contentBody .field thead{background:#f8fafc}
        #contentBody .field th,#contentBody .field td{padding:10px 12px;border-bottom:1px solid var(--border);min-width:90px}
        #contentBody .field tr:last-child td{border-bottom:none}
        #contentBody .field tr:nth-child(even){background:#fbfdff}
        #contentBody .field p{margin:.5em 0;line-height:1.7}
        .subgroup{margin:10px 0 18px}
        .subheader{background:#f8fafc;border:1px solid var(--border);border-radius:12px;padding:12px 14px;font-weight:800;color:#0f172a;font-size:1.05rem;display:flex;align-items:center;justify-content:space-between}
        .done-toggle{display:inline-flex;align-items:center;gap:8px;font-weight:600;color:#1e3a8a;font-size:.9rem}
        .done-toggle input[type=checkbox]{width:18px;height:18px}
        .question .q-title{font-size:1.25rem;font-weight:800;margin:6px 0 12px;color:#111827}
        .mc .mc-option{display:flex;align-items:center;gap:12px;padding:18px 18px;margin:12px 0;border:1px solid #e5e7eb;border-radius:14px;background:#f3f4f6;cursor:pointer;transition:all .15s ease}
        .mc .mc-option:hover{background:#eef2ff}
        .mc .mc-option.selected{background:#06b6d4;color:#fff;border-color:#0891b2;box-shadow:inset -12px -12px 0 0 rgba(255,255,255,0.15)}
        .mc .mc-option.submitted-correct{position:relative}
        .mc .mc-option.submitted-correct::before{content:'✓';position:absolute;left:-10px;top:50%;transform:translate(-50%,-50%);width:34px;height:34px;border-radius:50%;background:#fff;color:#10b981;display:flex;align-items:center;justify-content:center;font-weight:900;box-shadow:0 0 0 4px #10b981}
        .mc .mc-option.submitted-wrong{position:relative;border-color:#ef4444;background:#fee2e2;color:#b91c1c}
        .mc .mc-option.submitted-wrong::before{content:'✕';position:absolute;left:-10px;top:50%;transform:translate(-50%,-50%);width:34px;height:34px;border-radius:50%;background:#fff;color:#ef4444;display:flex;align-items:center;justify-content:center;font-weight:900;box-shadow:0 0 0 4px #ef4444}
        .mc .mc-radio{width:20px;height:20px;border:2px solid #9ca3af;border-radius:999px;display:inline-block;background:#fff;flex:0 0 auto}
        .mc .mc-option.selected .mc-radio{border-color:#fff;background:transparent;box-shadow:inset 0 0 0 6px #002C76, 0 0 0 2px #fff}
        /* True/False options styled like MC */
        .tf .tf-option{display:flex;align-items:center;gap:12px;padding:16px 18px;margin:10px 0;border:1px solid #e5e7eb;border-radius:14px;background:#f3f4f6;cursor:pointer;transition:all .15s ease}
        .tf .tf-option:hover{background:#eef2ff}
        .tf .tf-option.selected{background:#2563eb;color:#fff;border-color:#1d4ed8;box-shadow:inset -12px -12px 0 0 rgba(255,255,255,0.15)}
        .tf .mc-radio{width:20px;height:20px;border:2px solid #9ca3af;border-radius:999px;display:inline-block;background:#fff;flex:0 0 auto}
        .tf .tf-option.selected .mc-radio{border-color:#fff;background:transparent;box-shadow:inset 0 0 0 6px #002C76, 0 0 0 2px #fff}
        .tf .tf-option.submitted-correct{position:relative}
        .tf .tf-option.submitted-correct::before{content:'✓';position:absolute;left:-10px;top:50%;transform:translate(-50%,-50%);width:34px;height:34px;border-radius:50%;background:#fff;color:#10b981;display:flex;align-items:center;justify-content:center;font-weight:900;box-shadow:0 0 0 4px #10b981}
        .tf .tf-option.submitted-wrong{position:relative;border-color:#ef4444;background:#fee2e2;color:#b91c1c}
        .tf .tf-option.submitted-wrong::before{content:'✕';position:absolute;left:-10px;top:50%;transform:translate(-50%,-50%);width:34px;height:34px;border-radius:50%;background:#fff;color:#ef4444;display:flex;align-items:center;justify-content:center;font-weight:900;box-shadow:0 0 0 4px #ef4444}
        .mc-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:16px}
        .btn-green{flex:1;min-width:160px;background:var(--b);color:#fff;border:none;border-radius:12px;padding:14px 16px;font-weight:700;cursor:pointer}
        .btn-green:disabled{background:#e5e7eb;color:#9ca3af;cursor:not-allowed}
<<<<<<< HEAD
<<<<<<< HEAD
        .mc-actions [data-act="feedback"]{background:#fff;color:#0f3b8f;border:1px solid #c7d2fe}
        .mc-actions [data-act="reset"]{background:#0f3b8f;color:#fff}
        .mc-feedback{margin-top:8px;font-weight:700;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:10px;padding:10px}
=======
=======
>>>>>>> fc1b73832febb5eb8213c8b0091e514ff787652b
        .mc-feedback{margin-top:8px;font-weight:700}
        .btn-blue{
            background:linear-gradient(90deg,#002C76 0%, #0f3b8f 100%);
            color:#fff;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer;
            box-shadow:0 10px 20px rgba(37,99,235,.22);
            transition:transform .15s ease, box-shadow .2s ease, filter .2s ease;
        }
        .btn-blue:hover{ transform:translateY(-1px); box-shadow:0 14px 24px rgba(0,44,118,.28); filter:brightness(1.03); }
        .btn-blue:disabled{ background:#e5e7eb;color:#9ca3af;cursor:not-allowed; box-shadow:none; }
<<<<<<< HEAD
>>>>>>> 784202431884b5fe0713b51cfac0955a87223c63
=======
>>>>>>> fc1b73832febb5eb8213c8b0091e514ff787652b
        .view-only .module-bar,
        .view-only .module-kpi,
        .view-only .done-toggle,
        .view-only .topic .count,
        .view-only .sub-item .dot,
        .view-only .mc-actions { display:none !important; }
        .view-only .mc .mc-option { pointer-events:none; cursor:default; }
    </style>
    <style>
        :root{
            --blue:#002C76;
            --blue-700:#0f3b8f;
            --blue-500:#2563eb;
            --green:#7fb73d;
            --bg:#f4f6f9;
            --border:#e2e8f0;
            --card:#ffffff;
            --muted:#64748b;
            --shadow-sm:0 2px 8px rgba(15,23,42,.08);
            --shadow-md:0 14px 30px rgba(15,23,42,.14);
            --radius-lg:18px;
        }
        body{color:#0f172a;background:var(--bg)}
        .app-header{display:none}
        .topbar{padding:10px 20px;min-height:56px;background:#ffffff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:30}
        .hero{
            background:linear-gradient(90deg,#0f3b8f 0%, #2563eb 100%);
            color:#fff;
            padding:18px 20px;
            display:flex;align-items:center;justify-content:space-between;
            box-shadow:0 10px 24px rgba(15,23,42,.12);
        }
        .hero-left{display:flex;align-items:center;gap:12px}
        .hero-icon{width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center}
        .hero-title{font-weight:800;font-size:1.35rem;letter-spacing:-0.015em}
        .hero-sub{opacity:.9;font-size:.95rem}
        .hero-chip{background:rgba(255,255,255,.22);border:1px solid rgba(255,255,255,.3);padding:6px 10px;border-radius:999px;font-weight:700}
        .layout{height:100vh;grid-template-columns:320px 1fr;gap:0;padding:0}
        .content{padding-top:12px}
        .sidebar{
            background:#002C76;
            border-right:1px solid rgba(255,255,255,.12);
            padding-top:0;
            border-radius:0;
            box-shadow:none;
            overflow:visible;
            position:sticky;
            top:0;
            height:100vh;
        }
        .sidebar::before{
            content:'';
            display:block;
            height:72px;
            background:url('{{ asset('images/CAPDEV-PRO-LOGO.png') }}') no-repeat center;
            background-size:160px auto;
            border-bottom:1px solid rgba(255,255,255,.12);
        }
        .sidebar h3{
            margin:0 0 6px;
            padding:12px 18px;
            font-weight:700;
            letter-spacing:.01em;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            color:#fff;
            border-bottom:1px solid rgba(255,255,255,.12);
            border-left:4px solid var(--green);
            background:rgba(255,255,255,.08);
        }
        .back-slim{width:28px;height:28px;border-radius:999px;border:1px solid rgba(255,255,255,.35);display:inline-flex;align-items:center;justify-content:center;color:#fff;background:rgba(255,255,255,.08)}
        .back-slim:hover{background:rgba(255,255,255,.18)}
        .search{padding:10px 16px 6px;display:flex;justify-content:center}
        .search input{
            width:92%;
            padding:10px 14px;
            border-radius:12px;
            border:1px solid rgba(255,255,255,.35);
            box-shadow:inset 0 1px 1px rgba(0,0,0,.04);
            background:#ffffff;
        }
        .outline{padding:6px 12px 16px}
        .module{
            border-radius:12px;
            box-shadow:0 8px 18px rgba(15,23,42,.12);
            margin:10px 6px;
            border:1px solid #dbe2ee;
            overflow:hidden;
        }
        .module-header{
            background:#ffffff;
            border-radius:12px;
            padding:12px 14px;
            transition:background .15s ease, box-shadow .15s ease;
            display:flex;align-items:center;justify-content:space-between;gap:12px
        }
        .module:hover .module-header{background:#f8fbff}
        .module-title{font-weight:800;color:#0f172a}
        .module-kpi{color:#0f3b8f;font-weight:800;margin-left:6px}
        .mod-badges{display:flex;align-items:center;gap:8px}
        .progress-mini{width:130px;height:6px;border-radius:999px;background:#e6eefc;overflow:hidden;border:1px solid #e0e7ff}
        .progress-mini > span{display:block;height:100%;background:linear-gradient(90deg,#1d4ed8,#2563eb)}
        .lock-ico{color:#64748b;margin-right:6px}
        .module.locked .module-title{color:#0f172a}
        .module.locked .progress-mini{background:#e5e7eb;border-color:#e5e7eb}
        .module.locked .progress-mini > span{background:#9ca3af}
        .toggle-icon{border:none;background:transparent;color:#0f3b8f;cursor:pointer}
        .toggle-icon i{transition:transform .15s ease}
        .topic{background:#f9fafb; transition:background .15s ease;}
        .topic:hover{background:#f3f6fb}
        .topic.active{background:#e8f0ff}
        .topic .title{display:flex;align-items:center;gap:8px}
        .topic .title::before{content:'◯';color:#9ca3af;font-size:.8rem}
        .topic.active .title::before{content:'▸';color:#0f3b8f}
        .sub-item{border-radius:12px;display:flex;align-items:flex-start;gap:8px}
        .sub-item::before{content:'•';color:#94a3b8;line-height:1.2}
        .sub-item.active{background:#eef2ff;border-left:3px solid var(--blue-500)}
<<<<<<< HEAD
        .mc .mc-option{background:#fff;border:1px solid #e6edf5}
        .mc .mc-option:hover{background:#f5f8ff}
        .mc .mc-option.selected{background:#eef2ff;border-color:#c7d2fe}
        .mc-actions{gap:10px}
        .btn-ghost{border:1px solid #e2e8f0;border-radius:12px;padding:12px 14px;background:#fff;font-weight:700}
=======
>>>>>>> fc1b73832febb5eb8213c8b0091e514ff787652b
        .pane{
            border-radius:16px;
            box-shadow:0 14px 30px rgba(15,23,42,.14);
            border:1px solid #e6edf5;
        }
        .field{
            border-radius:14px;
            box-shadow:0 1px 2px rgba(15,23,42,.04);
        }
        .chip{padding:6px 12px;color:#0f3b8f;border:1px solid #dbeafe;background:#eef2ff}
        .btn-green{
            box-shadow:0 10px 20px rgba(37,99,235,.2);
        }
        /* Pro input styling for Identification/Essay */
        .q-input{
            width:100%;
            border:1px solid #dbe4f3;
            border-radius:14px;
            padding:12px 14px;
            background:linear-gradient(180deg,#ffffff 0%, #f8fbff 100%);
            box-shadow:inset 0 1px 2px rgba(15,23,42,.04), 0 8px 18px rgba(15,23,42,.08);
            color:#0f172a;
            transition:border-color .15s ease, box-shadow .2s ease, background .2s ease;
        }
        .q-input::placeholder{ color:#94a3b8; }
        .q-input:focus{
            outline:none;
            border-color:#60a5fa;
            box-shadow:0 0 0 3px rgba(96,165,250,.25), inset 0 1px 2px rgba(15,23,42,.06), 0 12px 24px rgba(15,23,42,.12);
            background:#fff;
        }
        .field.question[data-kind="id"] .mc-actions,
        .field.question[data-kind="essay"] .mc-actions{
            margin-top:12px;
            display:flex;
            gap:10px;
            justify-content:flex-end;
        }
        .topbar > div:nth-child(2){
            display:none;
        }
        #videoWrap video{border-radius:14px;box-shadow:var(--shadow-sm)}
        .back-btn{
            width:34px;height:34px;border-radius:999px;
            border:1px solid #dbe2ee;background:#fff;color:#0f3b8f;
            display:inline-flex;align-items:center;justify-content:center;
            text-decoration:none;box-shadow:0 2px 6px rgba(15,23,42,.08);
        }
        .back-btn:hover{background:#f8fafc}
        @media (max-width: 980px){
            .layout{height:auto}
            .sidebar{display:none}
            .topbar{left:0}
            .content{padding-top:64px}
        }
    </style>
</head>
<body class="{{ isset($viewOnly) && $viewOnly ? 'view-only' : '' }}">
    <header class="app-header">
        <div class="app-header-left">
            <img class="app-header-logo" src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
        </div>
        <div class="app-header-right" style="display:flex;align-items:center;gap:16px">
            @php
                $role = auth()->user()->role ?? null;
                $isCoach = in_array($role, ['trainer','coach'], true);
                $backUrl = $isCoach ? route('trainer.courses.enter', $course) : route('trainee.courses.show', $course);
            @endphp
            <a href="{{ $backUrl }}" style="color:#0f3b8f"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </header>
    @php
        $role = auth()->user()->role ?? null;
        $IS_COACH = in_array($role, ['trainer','coach'], true);
    @endphp
    <div style="background:#fff;border-bottom:1px solid #e5e7eb;padding:10px 16px;display:flex;align-items:center;gap:10px">
        <div style="font-weight:800;color:#0f172a">Classroom</div>
    </div>
    <div class="layout" id="modulesPane" style="{{ $IS_COACH ? '' : '' }}">
        <aside class="sidebar">
            <h3>
                <span style="display:inline-flex;align-items:center;gap:12px"><i class="fas fa-list-ul"></i> Course Outline</span>
                <a class="back-slim" href="{{ $backUrl }}" aria-label="Back"><i class="fas fa-arrow-left"></i></a>
            </h3>
            <div class="search"><input id="outlineSearch" type="text" placeholder="Search course outline"></div>
            <div id="outline" class="outline"></div>
        </aside>
        <main class="content">
            <div class="pane">
                <div id="videoWrap" style="margin-bottom:12px;"></div>
                <h2 id="contentTitle">Select a topic</h2>
                <div id="contentBody" style="min-height:320px;"></div>
            </div>
            @if(!(isset($viewOnly) && $viewOnly))
                <div id="reflectionModal" style="position:fixed;inset:0;background:rgba(0,0,0,.4);display:none;align-items:center;justify-content:center;z-index:80">
                    <div style="background:#fff;border-radius:14px;border:1px solid var(--border);width:min(720px,92vw);max-height:86vh;overflow:auto;padding:16px">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <div style="font-weight:800;color:#111827">Reflection</div>
                            <button id="reflectClose" style="border:none;background:none;font-size:1.1rem;cursor:pointer">✕</button>
                        </div>
                        <div id="reflectContext" class="muted" style="margin-bottom:8px"></div>
                        <form id="reflectForm">
                            <div class="field">
                                <div style="font-weight:700;margin-bottom:4px">What did you learn?</div>
                                <textarea name="learned" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your reflection here"></textarea>
                            </div>
                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                <button type="button" id="reflectSkip" class="btn-ghost" style="border:1px solid var(--border);border-radius:12px;padding:10px 14px;font-weight:700;background:#fff;color:#334155">Skip</button>
                                <button type="submit" class="btn-blue" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:10px 14px;font-weight:700">Submit</button>
                            </div>
                        </form>
                        <div id="reflectSummary" style="display:none;margin-top:12px;background:#f8fafc;border:1px solid var(--border);border-radius:12px;padding:12px"></div>
                    </div>
                </div>
            @endif
        </main>
    </div>
    <!-- Responses pane removed -->
<!-- Incomplete gate modal -->
<div id="gateOverlay" style="position:fixed;inset:0;background:rgba(15,23,42,.45);display:none;align-items:center;justify-content:center;z-index:3000">
  <div style="width:min(520px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 14px 30px rgba(0,0,0,.18);overflow:hidden">
    <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;font-weight:800">Incomplete</div>
    <div style="padding:14px 16px">
      <div>Please answer all questions and submit your reflection before marking this subtopic done.</div>
    </div>
    <div style="padding:12px 16px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end">
      <button id="gateClose" class="btn-blue">OK</button>
    </div>
  </div>
</div>
    <script>
    (function(){
        // Simplified: keep modules pane visible (responses feature removed)
        const paneM = document.getElementById('modulesPane');
        if(paneM){ paneM.style.display='grid'; }
    })();
        const storageBaseUrl = "{{ asset('storage') }}";
        const course = @json($course);
        const USER_ROLE = "{{ auth()->user()->role ?? '' }}";
        const IS_TRAINER = (USER_ROLE==='trainer' || USER_ROLE==='coach');
        // Ensure modules is an array (some DBs return JSON as string)
        if (typeof course.modules === 'string') {
            try { course.modules = JSON.parse(course.modules || '[]') || []; } catch(e){ course.modules = []; }
        }
        const status = @json($status);
        const isEnrolled = status === 'active';
        const viewOnly = @json($viewOnly ?? false);
        const csrf = "{{ csrf_token() }}";
        let reflectionMap = {};
        const ENFORCE_LOCKS_ALL = !!viewOnly;

        function isVideo(path){ return /\.(mp4|webm|ogg)$/i.test(path||''); }
        function renderVideo(){
            const wrap=document.getElementById('videoWrap');
            wrap.innerHTML='';
            if(course.video_path && isVideo(course.video_path)){
                wrap.innerHTML = `<video controls style="width:100%;max-height:360px;border-radius:8px"><source src="${storageBaseUrl}/${course.video_path}"></video>`;
            } else if(course.video_url){
                const url = course.video_url;
                if(isVideo(url)){
                    wrap.innerHTML = `<video controls style="width:100%;max-height:360px;border-radius:8px"><source src="${url}"></video>`;
                }
            }
        }
        function showLockedContent(mi){
            const m = (course.modules||[])[mi]||{};
            const title = `${mi+1}. ${m.title||'Locked Module'}`;
            const body = `
                <div class="lock" style="background:#e6eef7;border:2px dashed #bcd2ea;border-radius:12px;color:#223;display:flex;align-items:center;justify-content:center;min-height:360px;">
                    <div style="text-align:center;max-width:520px;padding:18px">
                        <div style="font-size:3rem;margin-bottom:10px;color:#ef4444;"><i class="fas fa-lock"></i></div>
                        <div style="font-weight:800;font-size:1.25rem;margin-bottom:6px;">Locked Content</div>
                        <div style="color:#445;">The content of this page is not visible because this module is currently locked. Your trainer can unlock this when it’s time to work on it.</div>
                    </div>
                </div>`;
            const titleEl = document.getElementById('contentTitle');
            const bodyEl = document.getElementById('contentBody');
            if(titleEl) titleEl.textContent = title;
            if(bodyEl) bodyEl.innerHTML = body;
        }
        async function renderOutline(){
            const el=document.getElementById('outline');
            el.innerHTML='';
            let mods = Array.isArray(course.modules)?course.modules:[];
            if(!mods.length){
                try{
                    const r = await fetch("{{ route('courses.modules.json', $course) }}", {credentials:'same-origin'});
                    const j = r.ok ? await r.json() : null;
                    if(j && j.ok && Array.isArray(j.modules)){ mods = j.modules; course.modules = mods; }
                }catch(e){}
            }
            mods.forEach((m,mi)=>{
                const mod = document.createElement('div');
                mod.className='module';
                const st = (m && m.status) ? m.status : 'unlocked';
                const isLocked = st==='locked';
                mod.innerHTML = `
                    <div class="module-header" data-mi="${mi}">
                        <div class="module-title"><span>${isLocked ? '<i class="fas fa-lock lock-ico"></i>' : ''}Module ${mi+1}: ${m.title||'Untitled'}</span></div>
                        <div class="mod-badges">
                            <div class="progress-mini"><span id="bar_${mi}"></span></div>
                            <span class="module-kpi" id="kpi_${mi}"></span>
                            <button class="toggle-icon" aria-label="Toggle module"><i class="fas fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <div class="topics"></div>
                `;
                if(isLocked){ mod.classList.add('locked'); }
                const topicsCt = mod.querySelector('.topics');
                const lockedForUser = (st==='locked') && (ENFORCE_LOCKS_ALL || !IS_TRAINER);
                (m.topics||[]).forEach((t,ti)=>{
                    const tEl = document.createElement('div');
                    tEl.className='topic';
                    tEl.setAttribute('data-mi',mi);
                    tEl.setAttribute('data-ti',ti);
                    const titleTxt = (typeof t==='string')?t:(t.title||'Topic');
                    const num = `${mi+1}.${ti}`;
                    let html = `<div class="topic-head">
                        <i class="fas fa-circle" style="font-size:.6rem;color:#9ca3af"></i>
                        <span class="title">${num}. ${titleTxt}</span>
                        <span class="count" id="cnt_${mi}_${ti}"></span>
                        <button class="toggle" aria-label="Toggle subtopics"><i class="fas fa-chevron-down"></i></button>
                    </div>`;
                    if (Array.isArray(t.subtopics) && t.subtopics.length){
                        const items = t.subtopics.map((s,si)=>`<div class="sub-item" data-si="${si}">
                            <span>${mi+1}.${ti}.${si+1}a ${(s.title||'Subtopic')}</span>
                        </div>`).join('');
                        html += `<div class="subs" aria-hidden="true">${items}</div>`;
                    }
                    tEl.innerHTML = html;
                    const head = tEl.querySelector('.topic-head');
                    const toggleBtn = tEl.querySelector('.toggle');
                    const subsEl = tEl.querySelector('.subs');
                    if(toggleBtn && subsEl){
                        toggleBtn.addEventListener('click',(e)=>{
                            e.stopPropagation();
                            const open = subsEl.style.display==='block';
                            subsEl.style.display = open ? 'none' : 'block';
                            const icon = toggleBtn.querySelector('i');
                            if(icon){ icon.className = open ? 'fas fa-chevron-down' : 'fas fa-chevron-up'; }
                        });
                    }
                    head.addEventListener('click', (e)=>{
                        if (lockedForUser) { 
                            showLockedContent(mi);
                            e.stopPropagation(); 
                            return; 
                        }
                        document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
                        tEl.classList.add('active');
                        openTopic(mi,ti);
                        e.stopPropagation();
                    });
                    if(!viewOnly){
                        tEl.querySelectorAll('.sub-item').forEach(n=>{
                            n.addEventListener('click',(e)=>{
                                if (lockedForUser) { 
                                    showLockedContent(mi);
                                    e.stopPropagation(); 
                                    return; 
                                }
                                const si = parseInt(n.getAttribute('data-si'),10);
                                document.querySelectorAll('.sub-item').forEach(x=>x.classList.remove('active'));
                                n.classList.add('active');
                                openTopic(mi,ti);
                                openSubtopic(mi,ti,si);
                                promptReflection(mi,ti,si);
                                e.stopPropagation();
                            });
                        });
                    }
                    topicsCt.appendChild(tEl);
                });
                // Append Module Exam entry if present
                if (m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length) {
                    const tEl = document.createElement('div');
                    tEl.className='topic';
                    tEl.setAttribute('data-mi',mi);
                    tEl.setAttribute('data-ti','exam');
                    const num = `${mi+1}.E`;
                    const qCount = m.exam.questions.length;
                    const badge = `<span class="count" style="display:inline-block">${qCount} Qs</span>`;
                    tEl.innerHTML = `<div class="topic-head">
                        <i class="fas fa-circle" style="font-size:.6rem;color:#9ca3af"></i>
                        <span class="title">${num}. Module Exam</span>
                        ${badge}
                    </div>`;
                    const head = tEl.querySelector('.topic-head');
                    head.addEventListener('click', (e)=>{
                        if (lockedForUser) { 
                            showLockedContent(mi);
                            e.stopPropagation(); 
                            return; 
                        }
                        document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
                        tEl.classList.add('active');
                        openExam(mi);
                        e.stopPropagation();
                    });
                    topicsCt.appendChild(tEl);
                }
                mod.querySelector('.module-header').addEventListener('click',()=>{
                    const currentStatus = (mods[mi] && mods[mi].status) ? mods[mi].status : 'unlocked';
                    const locked = (currentStatus==='locked') && (ENFORCE_LOCKS_ALL || !IS_TRAINER);
                    if(locked){
                        const open = topicsCt.style.display==='block';
                        topicsCt.style.display = open?'none':'block';
                        const chev = mod.querySelector('.toggle-icon i'); if(chev){ chev.style.transform = open?'rotate(0deg)':'rotate(180deg)'; }
                        showLockedContent(mi);
                        return;
                    }
                    const open = topicsCt.style.display==='block';
                    topicsCt.style.display = open?'none':'block';
                    const chev = mod.querySelector('.toggle-icon i'); if(chev){ chev.style.transform = open?'rotate(0deg)':'rotate(180deg)'; }
                });
                el.appendChild(mod);
                // initialize progress
                if(!viewOnly){ updateProgressFor(mi); }
            });
            document.getElementById('outlineSearch').addEventListener('input', (e)=>{
                const q=e.target.value.trim().toLowerCase();
                el.querySelectorAll('.module').forEach(mod=>{
                    const title = mod.querySelector('.module-title').textContent.toLowerCase();
                    let any=false;
                    mod.querySelectorAll('.topic').forEach(t=>{
                        const txt=t.textContent.toLowerCase();
                        const show = !q || txt.includes(q) || title.includes(q);
                        t.style.display = show?'block':'none';
                        any = any || show;
                    });
                    mod.style.display = any?'block':'none';
                });
            });
        }
        // Progress (client-side only)
        function doneKey(mi,ti,si){ return `c_${course.id||'x'}_${mi}_${ti}_${si}`; }
        function isSubtopicDone(mi,ti,si){
            try{ return localStorage.getItem(doneKey(mi,ti,si)) === '1'; }catch(e){ return false; }
        }
        function setSubtopicDone(mi,ti,si,val){
            try{ localStorage.setItem(doneKey(mi,ti,si), val ? '1':'0'); }catch(e){}
        }
        function renderDoneStates(mi,ti,topicEl){
            const m = (course.modules||[])[mi]||{};
            const t = (m.topics||[])[ti]||{};
            const subs = Array.isArray(t.subtopics)?t.subtopics:[];
            let doneCount = 0;
            topicEl.querySelectorAll('.sub-item').forEach(n=>{
                const si = parseInt(n.getAttribute('data-si'),10);
                const isDone = hasReflection(mi,ti,si);
                if(isDone){ doneCount++; n.classList.add('done'); }
                else { n.classList.remove('done'); }
            });
            const cnt = topicEl.querySelector(`#cnt_${mi}_${ti}`);
            if(cnt) cnt.textContent = subs.length ? `${doneCount} / ${subs.length}` : '';
        }
        function updateProgressFor(mi){
            const mod = document.querySelectorAll('.module')[mi];
            if(!mod) return;
            const topics = mod.querySelectorAll('.topic');
            let total=0, done=0;
            topics.forEach((tEl)=>{
                const ti = parseInt(tEl.getAttribute('data-ti'),10);
                renderDoneStates(mi,ti,tEl);
                const subs = tEl.querySelectorAll('.sub-item');
                total += subs.length;
                subs.forEach((sEl)=>{
                    const si = parseInt(sEl.getAttribute('data-si'),10);
                    if(hasReflection(mi,ti,si)) done++;
                });
            });
            const pct = total ? Math.round((done/total)*100) : 0;
            const bar = mod.querySelector(`#bar_${mi}`); if(bar) bar.style.width = pct+'%';
            const kpi = mod.querySelector(`#kpi_${mi}`); if(kpi) kpi.textContent = total ? `${pct}%` : '';
            if(pct===100){ promptCatchUpReflections(mi); }
        }
        function updateAllProgress(){
            const modules = document.querySelectorAll('.module');
            modules.forEach((_, idx)=> updateProgressFor(idx));
        }
        function openTopic(mi,ti){
            document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
            const node = document.querySelector(`.topic[data-mi="${mi}"][data-ti="${ti}"]`);
            if(node) node.classList.add('active');
            const m = (course.modules||[])[mi]||{};
            const t = (m.topics||[])[ti]||{};
            document.getElementById('contentTitle').textContent = `${mi+1}.${ti}. ${(typeof t==='string')?t:(t.title||'Topic')}`;
            if(!isEnrolled && !viewOnly){
                document.getElementById('contentBody').innerHTML = `<div class="lock"><div><div style="font-size:3rem;text-align:center;margin-bottom:8px;"><i class="fas fa-lock"></i></div><div style="text-align:center;color:#334;">Locked Content</div><div style="text-align:center;color:#556;max-width:420px;margin:8px auto 0;">You must be enrolled to view this topic’s materials and questions.</div></div></div>`;
                return;
            }
            // Respect module lock for trainees
            const isTrainer = IS_TRAINER;
            const currentStatus = ((course.modules||[])[mi] && (course.modules||[])[mi].status) ? (course.modules||[])[mi].status : 'unlocked';
            if(((ENFORCE_LOCKS_ALL || !isTrainer) && currentStatus==='locked')){
                showLockedContent(mi);
                return;
            }
            const subs = Array.isArray(t.subtopics) ? t.subtopics : null;
            if(subs && subs.length){
                const body = document.getElementById('contentBody');
                body.innerHTML = subs.map((s,si)=>{
                    const sid = `sub_${mi}_${ti}_${si}`;
                    const label = `${mi+1}.${ti}.${si+1}a ${s.title||'Subtopic'}`;
                    return `<section class="subgroup" id="${sid}" data-mi="${mi}" data-ti="${ti}" data-si="${si}">
                        <div class="subheader"><span>${label}</span></div>
                        <div class="subfields" id="${sid}_fields"></div>
                    </section>`;
                }).join('');
                // Render each subtopic's fields
                subs.forEach((s,si)=>{
                    const container = document.getElementById(`sub_${mi}_${ti}_${si}_fields`);
                    const fields = ('fields' in s) ? s.fields : (s.fields_json ? (typeof s.fields_json==='string'?JSON.parse(s.fields_json):s.fields_json) : []);
                    renderFieldsInto(container, fields, mi, ti, si);
                });
                // After rendering, sync progress visuals in outline
                const topicEl = document.querySelector(`.topic[data-mi="${mi}"][data-ti="${ti}"]`);
                if(topicEl) renderDoneStates(mi,ti,topicEl);
                return;
            }
            const fields = ('fields' in t) ? t.fields : (t.fields_json ? (typeof t.fields_json==='string'?JSON.parse(t.fields_json):t.fields_json) : []);
            renderFieldsInto(document.getElementById('contentBody'), fields, mi, ti);
        }
        function openExam(mi){
            const m = (course.modules||[])[mi]||{};
            const ex = m.exam||{};
            const qs = Array.isArray(ex.questions)? ex.questions : [];
            const titleEl = document.getElementById('contentTitle');
            const bodyEl = document.getElementById('contentBody');
            if(titleEl) titleEl.textContent = `${mi+1}.E Module Exam`;
            if(!qs.length){
                if(bodyEl) bodyEl.innerHTML = `<div class="field" style="background:#f8fafc;">No questions added.</div>`;
                return;
            }
            function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
            const html = qs.map((q,qi)=>{
                const kind = q.type || 'multiple_choice';
                const showTrainerAnswer = (IS_TRAINER===true);
                if(kind==='multiple_choice'){
                    const opts = (q.choices||q.options||[]).map((o,oi)=>{
                        const isAns = Number.isInteger(q.answer_index) && oi===q.answer_index;
                        const chip = showTrainerAnswer && isAns ? '<span class="chip">Answer</span>' : '';
                        return `<div class="mc-option${isAns&&showTrainerAnswer?' trainer-answer':''}" data-idx="${oi}"><span class="mc-radio"></span><span class="mc-label">${esc(o)}</span> ${chip}</div>`;
                    }).join('');
                    if(showTrainerAnswer){
                        return `<div class="field question"><div class="q-title">${qi+1}. ${esc(q.text||q.title||'Question')}</div><div class="mc" data-answer="${Number.isInteger(q.answer_index)?q.answer_index:''}">${opts}</div></div>`;
                    }
                    return `<div class="field question" data-kind="mc">
                        <div class="q-title">${qi+1}. ${esc(q.text||q.title||'Question')}</div>
                        <div class="mc" data-answer="${Number.isInteger(q.answer_index)?q.answer_index:''}">${opts}</div>
                    </div>`;
                }else if(kind==='identification'){
                    const ans = q.answer||'';
                    if(showTrainerAnswer){
                        const extra = ans ? `<div class="chip">Answer</div> ${esc(ans)}` : '<div class="muted">No answer provided</div>';
                        return `<div class="field question"><div class="q-title">${qi+1}. ${esc(q.text||q.title||'Identification')}</div>${extra}</div>`;
                    }
                    const dataAns = String(JSON.stringify(ans? [ans]:[])).replace(/"/g,'&quot;');
                    return `<div class="field question" data-kind="id">
                        <div class="q-title">${qi+1}. ${esc(q.text||q.title||'Identification')}</div>
                        <input class="q-input input" type="text" placeholder="Your answer" data-answers="${dataAns}">
                    </div>`;
                }else if(kind==='true_false'){
                    const val = (q.answer===true)?'true':(q.answer===false?'false':'');
                    if(showTrainerAnswer){
                        const opts = ['True','False'].map(v=>{
                            const isAns = (v.toLowerCase()===val);
                            const chip = isAns ? '<span class="chip">Answer</span>' : '';
                            return `<div class="tf-option${isAns?' trainer-answer':''}"><span class="mc-radio"></span><span>${v}</span> ${chip}</div>`;
                        }).join('');
                        return `<div class="field question"><div class="q-title">${qi+1}. ${esc(q.text||q.title||'True or False')}</div><div class="tf">${opts}</div></div>`;
                    }
                    const opts2 = ['True','False'].map(v=>{
                        return `<div class="tf-option" data-val="${v.toLowerCase()}"><span class="mc-radio"></span><span>${v}</span></div>`;
                    }).join('');
                    return `<div class="field question" data-kind="tf">
                        <div class="q-title">${qi+1}. ${esc(q.text||q.title||'True or False')}</div>
                        <div class="tf" data-answer="${val}">${opts2}</div>
                    </div>`;
                }else{
                    return `<div class="field"><div class="q-title">${qi+1}. ${esc(q.text||q.title||'Question')}</div><div class="muted">Unsupported question type.</div></div>`;
                }
            }).join('');
            const timerMins = parseInt(ex.timer_minutes||0,10) || 0;
            const passPct = (ex.passing_score!=null && ex.passing_score!=='') ? (parseInt(ex.passing_score,10)||0) : null;
            const attemptLim = (ex.attempt_limit!=null && ex.attempt_limit!=='') ? (parseInt(ex.attempt_limit,10)||0) : null;
            const header = `
                <div class="subheader">
                    <span>${esc(m.title||'Module')}: ${esc(ex.title||'Module Exam')}</span>
                    <div style="display:flex;align-items:center;gap:8px">
                        <span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-list" style="margin-right:6px;color:#002C76"></i> ${qs.length} question${qs.length===1?'':'s'}</span>
                        ${timerMins ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-clock" style="margin-right:6px;color:#002C76"></i> <span id="examTimer"></span></span>` : ``}
                    </div>
                </div>`;
            if(bodyEl){
                const preface = IS_TRAINER ? '' : `
                    <div id="examPreface" style="margin:12px 0;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:linear-gradient(180deg,#f8fbff 0%, #f5f7fb 100%);box-shadow:0 10px 22px rgba(15,23,42,.06)">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:10px">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;border:1px solid #dbeafe"><i class="fas fa-circle-info" style="color:#0f3b8f"></i></div>
                                <div style="font-weight:900;color:#0f172a;letter-spacing:-.01em">Exam Instructions</div>
                            </div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap">
                                <span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-list" style="margin-right:6px;color:#0f3b8f"></i> ${qs.length} item${qs.length===1?'':'s'}</span>
                                ${timerMins ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-clock" style="margin-right:6px;color:#0f3b8f"></i> ${timerMins} min</span>` : `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-infinity" style="margin-right:6px;color:#0f3b8f"></i> No time limit</span>`}
                                ${passPct!=null ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-check-circle" style="margin-right:6px;color:#0f3b8f"></i> Passing ${passPct}%</span>` : ``}
                                ${attemptLim && attemptLim>0 ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-rotate" style="margin-right:6px;color:#0f3b8f"></i> ${attemptLim} attempt${attemptLim===1?'':'s'}</span>` : ``}
                            </div>
                        </div>
                        <div style="color:#334155;margin:0 0 12px 0">
                            <ul style="margin:0 0 0 18px;line-height:1.6">
                                <li>Answer all questions to the best of your knowledge.</li>
                                <li>Your timer will start when you press Start.</li>
                            </ul>
                        </div>
                        <div style="display:flex;justify-content:center">
                            <button id="examStart" class="btn-blue" style="padding:12px 28px;border-radius:16px;box-shadow:0 10px 24px rgba(37,99,235,.22)">Start</button>
                        </div>
                    </div>`;
                const bodyWrap = `<div id="examBody" style="display:none">${html}${IS_TRAINER ? '' : `<div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px"><button id="examReset" class="btn-ghost" style="display:none">Reset Exam</button><button id="examSubmitAll" class="btn-blue">Submit Exam</button></div>`}</div>`;
                const confirmOverlay = IS_TRAINER ? '' : `
                <div id="examConfirm" style="position:fixed;inset:0;background:rgba(2,6,23,.55);backdrop-filter:blur(2px);display:none;align-items:center;justify-content:center;z-index:4000">
                  <div style="width:min(560px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:20px;box-shadow:0 30px 60px rgba(2,6,23,.28);overflow:hidden">
                    <div style="padding:16px 18px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:12px;background:linear-gradient(180deg,#f5f7ff 0%,#ffffff 100%)">
                      <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:40px;height:40px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;border:1px solid #dbeafe">
                          <i class="fas fa-clipboard-check" style="color:#0f3b8f"></i>
                        </div>
                        <div style="font-weight:900;color:#0f172a;letter-spacing:-.01em">Submit My Assessment</div>
                      </div>
                    </div>
                    <div style="padding:16px 18px">
                      <div id="examConfirmSummary" style="margin:6px 0 12px;color:#334155;font-weight:700"></div>
                      <label style="display:flex;align-items:center;gap:10px;margin:10px 0;padding:10px 12px;border:1px solid #dbeafe;border-radius:12px;background:#eef2ff">
                        <input id="examConfirmChk" type="checkbox"> <span style="font-weight:700;color:#0f172a">I confirm my submission.</span>
                      </label>
                    </div>
                    <div style="padding:14px 18px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:10px;background:#fff">
                      <button id="examConfirmCancel" class="btn-ghost" style="padding:12px 16px;border-radius:12px">Cancel</button>
                      <button id="examConfirmGo" class="btn-blue" style="padding:12px 18px;border-radius:12px;min-width:120px" disabled>Submit</button>
                    </div>
                  </div>
                </div>`;
                bodyEl.innerHTML = header + `<div id="examResult" style="display:none;margin:10px 0;padding:12px;border:1px solid #e5e7eb;border-radius:12px;background:#f8fafc;font-weight:800"></div>` + preface + bodyWrap + confirmOverlay;
            }
            if(!IS_TRAINER){
                const keyBase = `exam_${course.id}_${mi}`;
                const resultBox = document.getElementById('examResult');
                const prefaceBox = document.getElementById('examPreface');
                const bodyBox = document.getElementById('examBody');
                const closeBtn = document.getElementById('examClose');
                function saveAnswers(){
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    const answers = blocks.map(b=>{
                        const kind = b.getAttribute('data-kind') || 'mc';
                        if(kind==='mc'){
                            const sel = b.querySelector('.mc .mc-option.selected');
                            return sel ? parseInt(sel.getAttribute('data-idx'),10) : null;
                        }else if(kind==='id'){
                            const inp = b.querySelector('.q-input'); return (inp?.value||'').trim();
                        }else if(kind==='tf'){
                            const sel = b.querySelector('.tf .tf-option.selected'); return sel ? sel.getAttribute('data-val') : null;
                        }
                        return null;
                    });
                    try{ localStorage.setItem(keyBase+'_answers', JSON.stringify(answers)); }catch(e){}
                }
                function restoreAnswers(){
                    let arr = null;
                    try{ arr = JSON.parse(localStorage.getItem(keyBase+'_answers')||'null'); }catch(e){ arr=null; }
                    if(!Array.isArray(arr)) return;
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    blocks.forEach((b,i)=>{
                        const kind = b.getAttribute('data-kind') || 'mc';
                        const val = arr[i];
                        if(kind==='mc'){
                            if(Number.isInteger(val)){
                                const opt = b.querySelector(`.mc .mc-option[data-idx="${val}"]`);
                                if(opt){ opt.classList.add('selected'); }
                            }
                        }else if(kind==='id'){
                            const inp = b.querySelector('.q-input'); if(inp){ inp.value = val || ''; }
                        }else if(kind==='tf'){
                            const opt = b.querySelector(`.tf .tf-option[data-val="${val}"]`); if(opt){ opt.classList.add('selected'); }
                        }
                    });
                }
                function setFrozen(val){
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    blocks.forEach(b=>{
                        if(val){
                            b.style.pointerEvents='none';
                            const inp=b.querySelector('.q-input'); if(inp){ inp.disabled=true; }
                        }else{
                            b.style.pointerEvents='auto';
                            const inp=b.querySelector('.q-input'); if(inp){ inp.disabled=false; }
                        }
                    });
                }
                function computeGrade(){
                    const answers = JSON.parse(localStorage.getItem(keyBase+'_answers')||'[]') || [];
                    let total = qs.length, correct = 0;
                    for(let i=0;i<qs.length;i++){
                        const q = qs[i]||{};
                        const kind = q.type || 'multiple_choice';
                        const a = answers[i];
                        if(kind==='multiple_choice'){
                            if(Number.isInteger(q.answer_index) && Number.isInteger(a) && a===q.answer_index) correct++;
                        }else if(kind==='true_false'){
                            const val = q.answer===true?'true':(q.answer===false?'false':'');
                            if(a && String(a).toLowerCase()===val) correct++;
                        }else if(kind==='identification'){
                            const ansList = Array.isArray(q.answers) ? q.answers : (q.answer ? [q.answer] : []);
                            const ok = ansList.some(x=> String(x||'').trim().toLowerCase() === String(a||'').trim().toLowerCase());
                            if(ok) correct++;
                        }
                    }
                    const pct = total ? Math.round((correct/total)*100) : 0;
                    return {correct,total,pct};
                }
                bodyEl.querySelectorAll('.field.question[data-kind="mc"] .mc .mc-option').forEach(opt=>{
                    opt.addEventListener('click', ()=>{
                        const wrap = opt.closest('.mc');
                        const submitted = localStorage.getItem(keyBase+'_submitted')==='1';
                        if(submitted) return;
                        wrap.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected'));
                        opt.classList.add('selected');
                        saveAnswers();
                    });
                });
                bodyEl.querySelectorAll('.field.question[data-kind="tf"] .tf .tf-option').forEach(opt=>{
                    opt.addEventListener('click', ()=>{
                        const tf = opt.parentElement;
                        const submitted = localStorage.getItem(keyBase+'_submitted')==='1';
                        if(submitted) return;
                        tf.querySelectorAll('.tf-option').forEach(o=>o.classList.remove('selected'));
                        opt.classList.add('selected');
                        saveAnswers();
                    });
                });
                bodyEl.querySelectorAll('.field.question[data-kind="id"] .q-input').forEach(inp=>{
                    inp.addEventListener('input', ()=>{ if(localStorage.getItem(keyBase+'_submitted')!=='1'){ saveAnswers(); } });
                });
                const submitAll = bodyEl.querySelector('#examSubmitAll');
                const resetBtn = bodyEl.querySelector('#examReset');
                let timerIv = null;
                function handleSubmit(){
                    saveAnswers();
                    const {correct,total,pct} = computeGrade();
                    if(submitAll){ submitAll.disabled = true; submitAll.textContent = 'Submitted'; }
                    if(resetBtn){ resetBtn.style.display = 'inline-flex'; }
                    try{ localStorage.setItem(keyBase+'_submitted','1'); }catch(e){}
                    setFrozen(true);
                    // stop timer and mark as submitted
                    const tElDone = document.getElementById('examTimer');
                    if(timerIv){ clearInterval(timerIv); timerIv = null; }
                    if(tElDone){ tElDone.textContent = 'Done'; }
                    // Show centered result panel and hide questions
                    if(resultBox){
                        const passed = (typeof passPct === 'number') ? (pct >= passPct) : null;
                        const statusTxt = passed===null ? '' : (passed ? 'You passed the exam.' : 'You did not pass the exam.');
                        const statusColor = passed===null ? '#334155' : (passed ? '#059669' : '#b91c1c');
                        resultBox.style.display='block';
                        resultBox.style.background = '#fff';
                        resultBox.style.border = '1px solid #e5e7eb';
                        resultBox.style.boxShadow = '0 24px 48px rgba(2,6,23,.06)';
                        resultBox.style.borderRadius = '16px';
                        resultBox.innerHTML = `
                          <div style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:16px">
                            <svg viewBox="0 0 100 60" width="320" height="180" style="display:block">
                              <path d="M10,60 A40,40 0 1 1 90,60" fill="none" stroke="#e5e7eb" stroke-width="12" stroke-linecap="round"></path>
                              <path id="examGaugePath" d="M10,60 A40,40 0 1 1 90,60" fill="none" stroke="${passed===false ? '#ef4444' : '#002C76'}" stroke-width="12" stroke-linecap="round" stroke-dasharray="0 999"></path>
                              <text x="50" y="45" text-anchor="middle" font-size="18" font-weight="900" fill="#0f172a">${pct}%</text>
                            </svg>
                            <div style="font-weight:800;color:#0f172a">You have scored <span>${pct}%</span>.</div>
                            ${statusTxt ? `<div style="color:${statusColor};font-weight:800">${statusTxt}</div>` : ''}
                            <div style="color:#334155">Select Reset to retake the exam. You can also review your answers.</div>
                            <div style="display:flex;gap:10px;margin-top:6px">
                              <button id="examReset2" class="btn-ghost" style="padding:10px 16px;border-radius:12px">Reset</button>
                              <button id="examReview" class="btn-blue" style="padding:10px 16px;border-radius:12px">Review Assessment</button>
                            </div>
                          </div>`;
                        const gauge = resultBox.querySelector('#examGaugePath');
                        if(gauge && gauge.getTotalLength){
                            const L = gauge.getTotalLength();
                            const frac = Math.max(0, Math.min(1, pct/100));
                            gauge.setAttribute('stroke-dasharray', `${L} ${L}`);
                            gauge.setAttribute('stroke-dashoffset', String((1-frac)*L));
                        }
                        if(bodyBox){ bodyBox.style.display='none'; }
                        const r2 = document.getElementById('examReset2');
                        if(r2){
                          r2.onclick = ()=>{
                            if(typeof resetBtn?.onclick === 'function'){ resetBtn.onclick(); }
                            else { location.reload(); }
                          };
                        }
                        const rv = document.getElementById('examReview');
                        if(rv){
                          rv.onclick = ()=>{
                            resultBox.style.display='none';
                            if(bodyBox){ bodyBox.style.display=''; }
                            revealAnswers();
                          };
                        }
                      }
                }
                function revealAnswers(){
                    // Show correct answers in-body and lock interactions
                    const blocks = Array.from(bodyBox.querySelectorAll('.field.question'));
                    let ua = null;
                    try{ ua = JSON.parse(localStorage.getItem(keyBase+'_answers')||'[]'); }catch(e){ ua = []; }
                    blocks.forEach((b, i)=>{
                        const q = qs[i] || {};
                        const kind = (q.type||'multiple_choice');
                        b.style.pointerEvents = 'none';
                        if(kind==='multiple_choice'){
                            const ans = Number.isInteger(q.answer_index) ? q.answer_index : null;
                            const mc = b.querySelector('.mc');
                            if(mc!=null && ans!=null){
                                const opt = mc.querySelector(`.mc-option[data-idx="${ans}"]`);
                                if(opt){
                                    opt.classList.add('trainer-answer');
                                    if(!opt.querySelector('.chip')){
                                        const chip=document.createElement('span');
                                        chip.className='chip';
                                        chip.textContent='Answer';
                                        chip.style.marginLeft='6px';
                                        opt.appendChild(chip);
                                    }
                                }
                                // Mark user's selected answer and correctness
                                const selIdx = (Array.isArray(ua) && Number.isInteger(ua[i])) ? ua[i] : null;
                                if(selIdx!==null){
                                    const selOpt = mc.querySelector(`.mc-option[data-idx="${selIdx}"]`);
                                    if(selOpt){
                                        selOpt.classList.add('selected');
                                        mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                                        if(ans!==null && selIdx===ans){ selOpt.classList.add('submitted-correct'); }
                                        else { selOpt.classList.add('submitted-wrong'); }
                                    }
                                }
                            }
                        } else if(kind==='true_false'){
                            const val = q.answer===true ? 'true' : (q.answer===false ? 'false' : '');
                            const tf = b.querySelector('.tf');
                            if(tf && val){
                                const opt = tf.querySelector(`.tf-option[data-val="${val}"]`);
                                if(opt){
                                    opt.classList.add('trainer-answer');
                                    if(!opt.querySelector('.chip')){
                                        const chip=document.createElement('span');
                                        chip.className='chip';
                                        chip.textContent='Answer';
                                        chip.style.marginLeft='6px';
                                        opt.appendChild(chip);
                                    }
                                }
                                // Mark user's selected and correctness
                                const selVal = (Array.isArray(ua) && typeof ua[i]==='string') ? ua[i] : null;
                                if(selVal){
                                    const selOpt = tf.querySelector(`.tf-option[data-val="${selVal}"]`);
                                    if(selOpt){
                                        selOpt.classList.add('selected');
                                        tf.querySelectorAll('.tf-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                                        if(selVal===val){ selOpt.classList.add('submitted-correct'); }
                                        else { selOpt.classList.add('submitted-wrong'); }
                                    }
                                }
                            }
                        } else if(kind==='identification'){
                            const ansList = Array.isArray(q.answers) ? q.answers : (q.answer ? [q.answer] : []);
                            if(ansList.length){
                                const info = document.createElement('div');
                                info.className='muted';
                                info.style.marginTop='8px';
                                const your = (Array.isArray(ua) && ua[i]) ? String(ua[i]) : '';
                                let isOk = false;
                                if(your){
                                    isOk = ansList.some(a => String(a||'').trim().toLowerCase() === your.trim().toLowerCase());
                                }
                                const yourLine = your ? `<div style="margin-top:6px;color:${isOk? '#059669':'#b91c1c'}"><b>Your answer:</b> ${your}</div>` : '';
                                info.innerHTML = '<span class="chip">Correct:</span> '+ ansList.map(a=>String(a)).join(' / ') + yourLine;
                                b.appendChild(info);
                            }
                            const inp=b.querySelector('.q-input'); if(inp){ inp.disabled=true; }
                        }
                    });
                }
                if(closeBtn){
                    closeBtn.onclick = ()=>{
                        // Back to outline and reset started state (but keep answers)
                        if(prefaceBox){ prefaceBox.style.display=''; }
                        if(bodyBox){ bodyBox.style.display='none'; }
                        if(resultBox){ resultBox.style.display='none'; }
                        try{
                            localStorage.removeItem(keyBase+'_started');
                            localStorage.removeItem(keyBase+'_start');
                        }catch(e){}
                        const titleEl = document.getElementById('contentTitle');
                        const contentEl = document.getElementById('contentBody');
                        if(titleEl) titleEl.textContent = `${mi+1}.E Module Exam`;
                        if(contentEl){ contentEl.scrollIntoView({behavior:'smooth', block:'start'}); }
                    };
                }
                function updateConfirmSummary(){
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    let answered=0;
                    blocks.forEach(b=>{
                        const kind=b.getAttribute('data-kind')||'mc';
                        if(kind==='mc'){
                            const sel=b.querySelector('.mc .mc-option.selected'); if(sel) answered++;
                        }else if(kind==='id'){
                            const val=(b.querySelector('.q-input')?.value||'').trim(); if(val) answered++;
                        }else if(kind==='tf'){
                            const sel=b.querySelector('.tf .tf-option.selected'); if(sel) answered++;
                        }
                    });
                    const total=blocks.length;
                    const el=document.getElementById('examConfirmSummary');
                    if(el){ el.innerHTML = `You answered <b>${answered}/${total}</b> items. Submit now?`; }
                }
                if(submitAll){
                    submitAll.onclick = ()=>{
                        const ov=document.getElementById('examConfirm');
                        const chk=document.getElementById('examConfirmChk');
                        const go=document.getElementById('examConfirmGo');
                        const cancel=document.getElementById('examConfirmCancel');
                        const close=document.getElementById('examConfirmClose');
                        if(!ov) { handleSubmit(); return; }
                        updateConfirmSummary();
                        ov.style.display='flex';
                        if(chk && go){ go.disabled = !chk.checked; chk.onchange = ()=>{ go.disabled = !chk.checked; }; }
                        if(cancel){ cancel.onclick = ()=>{ ov.style.display='none'; }; }
                        if(close){ close.onclick = ()=>{ ov.style.display='none'; }; }
                        if(go){ go.onclick = ()=>{ ov.style.display='none'; handleSubmit(); }; }
                    };
                }
                if(resetBtn){
                    resetBtn.onclick = ()=>{
                        try{
                            localStorage.removeItem(keyBase+'_answers');
                            localStorage.removeItem(keyBase+'_submitted');
                            localStorage.removeItem(keyBase+'_start');
                            localStorage.removeItem(keyBase+'_started');
                        }catch(e){}
                        location.reload();
                    };
                }
                restoreAnswers();
                // Start gate
                function showExamBody(){
                    if(prefaceBox) prefaceBox.style.display='none';
                    if(bodyBox) bodyBox.style.display='';
                }
                const started = localStorage.getItem(keyBase+'_started')==='1';
                if(started){ showExamBody(); }
                const startBtn = document.getElementById('examStart');
                if(startBtn){
                    startBtn.onclick = ()=>{
                        showExamBody();
                        try{
                            localStorage.setItem(keyBase+'_started','1');
                            if(!localStorage.getItem(keyBase+'_start')) localStorage.setItem(keyBase+'_start', String(Date.now()));
                        }catch(e){}
                    };
                }
                if(localStorage.getItem(keyBase+'_submitted')==='1'){
                    handleSubmit();
                }
                if(timerMins>0){
                    const tEl = document.getElementById('examTimer');
                    // If already submitted, don't run timer; mark as Done
                    if(localStorage.getItem(keyBase+'_submitted')==='1'){
                        if(tEl){ tEl.textContent = 'Done'; }
                        timerIv = null;
                        return;
                    }
                    function ensureStart(){
                        const started = localStorage.getItem(keyBase+'_started')==='1';
                        let start = 0;
                        try{ start = parseInt(localStorage.getItem(keyBase+'_start')||'0',10) || 0; }catch(e){ start=0; }
                        if(started && !start){
                            start = Date.now();
                            try{ localStorage.setItem(keyBase+'_start', String(start)); }catch(e){}
                        }
                        return {started, start};
                    }
                    function tick(){
                        const st = ensureStart();
                        const hasBegun = st.started && st.start>0;
                        const end = st.start + timerMins*60*1000;
                        const left = hasBegun ? Math.max(0, end - Date.now()) : (timerMins*60*1000);
                        const m = Math.floor(left/60000), s = Math.floor((left%60000)/1000);
                        if(tEl){ tEl.innerHTML = `${m}m ${s.toString().padStart(2,'0')}s`; }
                        if(hasBegun && left<=0){
                            if(localStorage.getItem(keyBase+'_submitted')!=='1'){ handleSubmit(); }
                            if(timerIv){ clearInterval(timerIv); timerIv=null; }
                        }
                    }
                    tick();
                    timerIv = setInterval(tick, 1000);
                }
            }
        }
        function openSubtopic(mi,ti,si){
            const section = document.getElementById(`sub_${mi}_${ti}_${si}`);
            if(section){ section.scrollIntoView({behavior:'smooth', block:'start'}); }
        }
        function sanitizeContent(html){
            try{
                let s = String(html||'');
                s = s.replace(/<(img|source|iframe)[^>]+(src|href)=["']blob:[^"']+["'][^>]*>/gi,'');
                s = s.replace(/(src|href)=["']blob:[^"']+["']/gi,'$1="#"');
                return s;
            }catch(e){ return html||''; }
        }
        function renderFieldsInto(container, fields, mi, ti, si=null){
            if(!fields || !fields.length){
                container.innerHTML = `<div class="field" style="background:#f8fafc;">No fields added.</div>`;
                return;
            }
            container.innerHTML = fields.map((f,i)=>{
                if(f.type==='text'){
                    const safe = sanitizeContent(f.html||'');
                    return `<div class="field">${safe}</div>`;
                } else if(f.type==='question' && f.question){
                    const q=f.question; 
                    const answer = (Number.isInteger(q.answer_index) ? q.answer_index : '');
                    const fbC = q.feedback_correct || '';
                    const fbI = q.feedback_incorrect || '';
                    const opts=(q.options||[]).map((o,idx)=>{
                        const isAns = (IS_TRAINER && Number.isInteger(answer) && idx===answer);
                        const chip = isAns ? '<span class="chip">Answer</span>' : '';
                        return `<div class="mc-option${isAns?' trainer-answer':''}" data-idx="${idx}"><span class="mc-radio"></span><span class="mc-label">${o}</span> ${chip}</div>`;
                    }).join('');
                    if(viewOnly){
                        return `<div class="field question" data-kind="mc">
                            <div class="q-title">${q.title||'Question'}</div>
                            <div class="mc" data-answer="${answer}">${opts}</div>
                        </div>`;
                    } else {
                        const kind = (q.type||'multiple_choice');
                        if(kind==='multiple_choice'){
                            return `<div class="field question" data-kind="mc">
                                <div class="q-title">${q.title||'Question'}</div>
                                <div class="mc" data-answer="${answer}" data-fb-correct="${fbC?.replace?.(/"/g,'&quot;') || ''}" data-fb-incorrect="${fbI?.replace?.(/"/g,'&quot;') || ''}">${opts}</div>
                                <div class="mc-actions">
                                    <button class="btn-green" data-act="submit" disabled>Submit</button>
                                    <button class="btn-green" data-act="feedback" style="display:none">Show feedback</button>
                                    <button class="btn-green" data-act="reset" style="display:none">Reset</button>
                                </div>
                                <div class="mc-feedback" style="display:none;"></div>
                            </div>`;
                        } else if(kind==='identification'){
                            const idAnswers = Array.isArray(q.answers) ? q.answers : (q.answer ? [q.answer] : []);
                            if(IS_TRAINER){
                                const list = idAnswers.length ? idAnswers.map(a=>`<span class="chip">Answer</span> ${a}`).join('<br>') : '<div class="muted">No answer provided</div>';
                                return `<div class="field question" data-kind="id">
                                    <div class="q-title">${q.title||'Identification'}</div>
                                    <div>${list}</div>
                                </div>`;
                            } else {
                                const dataAns = String(JSON.stringify(idAnswers)).replace(/"/g,'&quot;');
                                return `<div class="field question" data-kind="id">
                                    <div class="q-title">${q.title||'Identification'}</div>
                                    <input class="q-input input" type="text" placeholder="Your answer" data-answers="${dataAns}">
                                    <div class="mc-actions" style="margin-top:8px">
                                        <button class="btn-green" data-act="submit" disabled>Submit</button>
                                        <button class="btn-green" data-act="reset" style="display:none">Reset</button>
                                        <button class="btn-green" data-act="edit" style="display:none">Edit Answer</button>
                                    </div>
                                    <div class="mc-feedback" style="display:none;"></div>
                                </div>`;
                            }
                        } else if(kind==='essay'){
                            if(IS_TRAINER){
                                const essayAns = q.answer || q.expected_answer || '';
                                const rubric = q.rubric || '';
                                return `<div class="field question" data-kind="essay">
                                    <div class="q-title">${q.title||'Essay'}</div>
                                    ${essayAns ? `<div style="margin-bottom:6px"><span class="chip">Answer</span> ${essayAns}</div>` : '<div class="muted" style="margin-bottom:6px">No answer provided</div>'}
                                    ${rubric ? `<div><span class="chip">Rubric</span> ${rubric}</div>` : ''}
                                </div>`;
                            } else {
                                return `<div class="field question" data-kind="essay">
                                    <div class="q-title">${q.title||'Essay'}</div>
                                    <textarea class="q-input input" rows="4" placeholder="Write your response"></textarea>
                                    <div class="mc-actions" style="margin-top:8px">
                                        <button class="btn-green" data-act="submit" disabled>Submit</button>
                                        <button class="btn-green" data-act="edit" style="display:none">Edit Answer</button>
                                    </div>
                                    <div class="mc-feedback" style="display:none;"></div>
                                </div>`;
                            }
                        } else if(kind==='true_false'){
                            const tfAns = (q.answer===false) ? 'false' : 'true';
                            return `<div class="field question" data-kind="tf">
                                <div class="q-title">${q.title||'True or False'}</div>
                                <div class="tf" data-answer="${tfAns}">
                                    <div class="tf-option${IS_TRAINER && tfAns==='true' ? ' trainer-answer' : ''}" data-val="true"><span class="mc-radio"></span><span class="mc-label">True</span>${IS_TRAINER && tfAns==='true' ? ' <span class="chip">Answer</span>' : ''}</div>
                                    <div class="tf-option${IS_TRAINER && tfAns==='false' ? ' trainer-answer' : ''}" data-val="false"><span class="mc-radio"></span><span class="mc-label">False</span>${IS_TRAINER && tfAns==='false' ? ' <span class="chip">Answer</span>' : ''}</div>
                                </div>
                                <div class="mc-actions" style="margin-top:8px">
                                    <button class="btn-green" data-act="submit" disabled>Submit</button>
                                    <button class="btn-green" data-act="reset" style="display:none">Reset</button>
                                </div>
                            </div>`;
                        } else {
                            return `<div class="field question"><div class="q-title">${q.title||'Question'}</div></div>`;
                        }
                    }
                } else if(f.type==='reflection'){
                    const header = 'What did you learn?';
                    if(viewOnly){
                        return `<div class="field" style="background:#f8fafc">
                            <div class="muted">${header}</div>
                        </div>`;
                    } else {
                        const key = `${mi}_${ti}_${si ?? 0}`;
                        return `<div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="${si ?? 0}">
                            <div style="font-weight:700;margin-bottom:6px">${header}</div>
                            <textarea class="reflect-input" data-ref="${key}" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your personal reflection here"></textarea>
                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                <button type="button" class="btn-blue" data-act="submit-ref" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:8px 12px">Done</button>
                            </div>
                            <div class="reflect-summary" style="display:none;margin-top:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:10px"></div>
                        </div>`;
                    }
                } else {
                    return `<div class="field">${JSON.stringify(f)}</div>`;
                }
            }).join('');
            // Ensure a reflection block is always present at the end of a subtopic (editable view)
            if(!viewOnly){
                const hasRef = Array.isArray(fields) && fields.some(f => f && f.type === 'reflection');
                if(!hasRef){
                    const key = `${mi}_${ti}_${si ?? 0}`;
                    container.innerHTML += `
                        <div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="${si ?? 0}">
                            <div style="font-weight:700;margin-bottom:6px">What did you learn?</div>
                            <textarea class="reflect-input" data-ref="${key}" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your personal reflection here"></textarea>
                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                <button type="button" class="btn-blue" data-act="submit-ref" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:8px 12px">Done</button>
                            </div>
                            <div class="reflect-summary" style="display:none;margin-top:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:10px"></div>
                        </div>`;
                }
            }
            if(!viewOnly){
                container.querySelectorAll('.reflection-inline').forEach(block=>{
                    const bMi = parseInt(block.getAttribute('data-mi'),10);
                    const bTi = parseInt(block.getAttribute('data-ti'),10);
                    const bSi = parseInt(block.getAttribute('data-si'),10);
                    const submitBtn = block.querySelector('[data-act="submit-ref"]');
                    const input = block.querySelector('.reflect-input');
                    const summary = block.querySelector('.reflect-summary');
                    const key = `${bMi}_${bTi}_${bSi}`;
                    // Initialize state if already submitted
                    if(hasReflection(bMi,bTi,bSi)){
                        if(submitBtn){ submitBtn.textContent = 'Submitted'; submitBtn.disabled = true; }
                        if(input){ input.disabled = true; }
                    }
                    if(submitBtn){
                        submitBtn.onclick = async ()=>{
                            const containerEl = document.getElementById('contentBody');
                            const ready = areAllQuestionsSubmitted(containerEl);
                            const hasText = !!(input && input.value && input.value.trim());
                            if(!ready || !hasText){
                                var ov=document.getElementById('gateOverlay');
                                if(ov){ ov.style.display='flex'; }
                                if(!hasText){ input.focus(); }
                                return;
                            }
                            if(!input.value.trim()){ input.focus(); return; }
                            const questions = [{id:'learned', text:'What did you learn?'}];
                            const answers = { learned: input.value||'' };
                            try{
                                const res = await fetch("{{ route('courses.reflect.store', $course) }}", {
                                    method:'POST',
                                    headers:{'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/json'},
                                    credentials:'same-origin',
                                    body: JSON.stringify({
                                        module_index: bMi,
                                        topic_index: bTi,
                                        sub_index: bSi,
                                        questions,
                                        answers
                                    })
                                });
                                if(res.ok){
                                    markReflection(bMi,bTi,bSi);
                                    setSubtopicDone(bMi,bTi,bSi,true);
                                    const tEl = document.querySelector(`.topic[data-mi="${bMi}"][data-ti="${bTi}"]`);
                                    if(tEl){ renderDoneStates(bMi,bTi,tEl); updateProgressFor(bMi); }
                                    summary.style.display='block';
                                    summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                        <div><b>What you learned:</b> ${answers.learned?answers.learned:'(none)'}</div>
                                        <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="retry" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Retry</button></div>`;
                                    input.disabled = true;
                                    submitBtn.disabled = true;
                                    submitBtn.textContent = 'Done';
                                    const retryBtn = summary.querySelector('[data-act="retry"]');
                                    if(retryBtn){
                                        retryBtn.onclick = ()=>{
                                            input.disabled = false;
                                            submitBtn.disabled = false;
                                            submitBtn.textContent = 'Done';
                                            summary.style.display='none';
                                            input.focus();
                                            // Roll back progress until resubmitted
                                            if(typeof setSubtopicDone === 'function'){ setSubtopicDone(bMi,bTi,bSi,false); }
                                            if(typeof unmarkReflection === 'function'){ unmarkReflection(bMi,bTi,bSi); }
                                            const tEl2 = document.querySelector(`.topic[data-mi="${bMi}"][data-ti="${bTi}"]`);
                                            if(tEl2){ renderDoneStates(bMi,bTi,tEl2); updateProgressFor(bMi); }
                                        };
                                    }
                                    try{ localStorage.setItem('course_progress_broadcast', String(Date.now())); }catch(e){}
                                }
                            }catch(e){}
                        };
                    }
                });
            }
            // Initialize MC interactions
            if(!viewOnly){
                container.querySelectorAll('.field.question[data-kind="mc"]').forEach(initMultipleChoice);
                container.querySelectorAll('.field.question[data-kind="id"]').forEach(initIdentification);
                container.querySelectorAll('.field.question[data-kind="essay"]').forEach(initEssay);
                container.querySelectorAll('.field.question[data-kind="tf"]').forEach(initTrueFalse);
                updateReflectionGate(container);
            }
        }
        async function loadReflectionMap(){
            try{
                const res = await fetch("{{ route('courses.reflections.map', $course) }}", {credentials:'same-origin'});
                if(res.ok){ const j = await res.json(); reflectionMap = j.map || {}; updateAllProgress(); }
            }catch(e){}
        }
        function reflectKey(mi,ti,si){ return `${mi}_${ti}_${si}`; }
        function hasReflection(mi,ti,si){ return !!reflectionMap[reflectKey(mi,ti,si)]; }
        function markReflection(mi,ti,si){ reflectionMap[reflectKey(mi,ti,si)] = true; }
        function unmarkReflection(mi,ti,si){ delete reflectionMap[reflectKey(mi,ti,si)]; }
        function promptReflection(mi,ti,si){
            if(viewOnly) return;
            if(hasReflection(mi,ti,si)) return;
            const area = document.querySelector(`textarea.reflect-input[data-ref="${mi}_${ti}_${si}"]`);
            if(area){
                area.focus();
                area.scrollIntoView({behavior:'smooth', block:'center'});
            }
        }
        function promptCatchUpReflections(mi){
            const m = (course.modules||[])[mi]||{};
            const topics = Array.isArray(m.topics)?m.topics:[];
            const queue = [];
            topics.forEach((t,ti)=>{
                const subs = Array.isArray(t.subtopics)?t.subtopics:[];
                subs.forEach((s,si)=>{
                    if(!hasReflection(mi,ti,si)){
                        queue.push({mi,ti,si,label:`${mi+1}.${ti}.${si+1}a ${(s.title||'Subtopic')}`});
                    }
                });
            });
            if(queue.length){ runReflectionQueue(queue); }
        }
        function runReflectionQueue(items){
            if(!items.length) return;
            const {mi,ti,si,label} = items.shift();
            openReflectionModal(mi,ti,si,label, ()=> runReflectionQueue(items));
        }
        function openReflectionModal(mi,ti,si,label, onDone){
            const modal = document.getElementById('reflectionModal');
            const ctx = document.getElementById('reflectContext');
            const form = document.getElementById('reflectForm');
            const skipBtn = document.getElementById('reflectSkip');
            const closeBtn = document.getElementById('reflectClose');
            const summary = document.getElementById('reflectSummary');
            ctx.textContent = `Reflect on ${label}`;
            summary.style.display='none'; summary.innerHTML='';
            form.reset();
            modal.style.display='flex';
            const cleanup=()=>{
                modal.style.display='none';
                if(onDone) onDone();
            };
            skipBtn.onclick = cleanup;
            closeBtn.onclick = cleanup;
            form.onsubmit = async (e)=>{
                e.preventDefault();
                const fd = new FormData(form);
                const questions = [{id:'learned', text:'What did you learn?'}];
                const answers = { learned: fd.get('learned')||'' };
                try{
                    const res = await fetch("{{ route('courses.reflect.store', $course) }}", {
                        method:'POST',
                        headers:{'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/json'},
                        credentials:'same-origin',
                        body: JSON.stringify({
                            module_index: mi,
                            topic_index: ti,
                            sub_index: si,
                            questions,
                            answers
                        })
                    });
                    if(res.ok){
                        markReflection(mi,ti,si);
                        summary.style.display='block';
                        summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Thanks! Summary</div>
                        <div><b>What you learned:</b> ${answers.learned?answers.learned:'(none)'}</div>`;
                        setTimeout(()=>{ modal.style.display='none'; if(onDone) onDone(); }, 1200);
                    } else {
                        modal.style.display='none';
                        if(onDone) onDone();
                    }
                }catch(err){
                    modal.style.display='none';
                    if(onDone) onDone();
                }
            };
        }
        function initMultipleChoice(block){
            const mc = block.querySelector('.mc');
            const feedback = block.querySelector('.mc-feedback');
            const answerStr = mc.getAttribute('data-answer');
            const answer = answerStr === '' ? null : parseInt(answerStr,10);
            const submitBtn = block.querySelector('[data-act="submit"]');
            const resetBtn = block.querySelector('[data-act="reset"]');
            const feedbackBtn = block.querySelector('[data-act="feedback"]');
            const correctBtn = null;
            const setSubmitted = (val)=>{
                mc.dataset.submitted = val ? '1' : '0';
                if(val){
                    submitBtn.style.display='none';
                    feedbackBtn.style.display='inline-block';
                }else{
                    submitBtn.style.display='inline-block';
                    feedbackBtn.style.display='none';
                    if(resetBtn) resetBtn.style.display='none';
                }
                const cont = document.getElementById('contentBody');
                if(cont) updateReflectionGate(cont);
            };
            setSubmitted(false);
            mc.querySelectorAll('.mc-option').forEach(opt=>{
                opt.addEventListener('click', ()=>{
                    if(mc.dataset.submitted==='1') return;
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected'));
                    opt.classList.add('selected');
                    submitBtn.disabled = false;
                });
            });
            if(submitBtn){
                submitBtn.addEventListener('click', ()=>{
                    const sel = mc.querySelector('.mc-option.selected');
                    if(!sel) return;
                    const idx = parseInt(sel.getAttribute('data-idx'),10);
                    setSubmitted(true);
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                    if(answer !== null && !Number.isNaN(answer)){
                        if(idx === answer){
                            sel.classList.add('submitted-correct');
                            if(resetBtn) resetBtn.style.display='none';
                        } else {
                            sel.classList.add('submitted-wrong');
                            if(resetBtn) resetBtn.style.display='inline-block';
                        }
                    } else {
                        if(resetBtn) resetBtn.style.display='none';
                    }
                });
            }
            if(resetBtn){
                resetBtn.addEventListener('click', ()=>{
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected','correct'));
                    feedback.style.display='none'; feedback.textContent='';
                    submitBtn.disabled = true;
                    setSubmitted(false);
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                    if(resetBtn) resetBtn.style.display='none';
                });
            }
            if(feedbackBtn){
                feedbackBtn.addEventListener('click', ()=>{
                    const sel = mc.querySelector('.mc-option.selected');
                    if(!sel){ feedback.textContent='Select an option first.'; feedback.style.display='block'; return; }
                    const idx = parseInt(sel.getAttribute('data-idx'),10);
                    const fbC = mc.getAttribute('data-fb-correct') || '';
                    const fbI = mc.getAttribute('data-fb-incorrect') || '';
                    if(answer === null || Number.isNaN(answer)){
                        feedback.textContent='Answer recorded.';
                    } else {
                        if(idx===answer){
                            feedback.textContent = fbC ? `Correct! ${fbC}` : 'Correct!';
                        } else {
                            feedback.textContent = fbI ? `Incorrect. ${fbI}` : 'Incorrect.';
                        }
                    }
                    feedback.style.display='block';
                });
            }
            /* removed correct answer reveal */
        }
        function initIdentification(block){
            const input = block.querySelector('.q-input');
            const submitBtn = block.querySelector('[data-act="submit"]');
            const resetBtn = block.querySelector('[data-act="reset"]');
            const editBtn = block.querySelector('[data-act="edit"]');
            const feedback = block.querySelector('.mc-feedback');
            let answers = [];
            try{ answers = JSON.parse(input?.dataset?.answers || '[]'); }catch(e){ answers = []; }
            const setSubmitted = (val)=>{
                block.dataset.submitted = val ? '1' : '0';
                if(val){ submitBtn.disabled = true; if(input) input.disabled = true; }
                else { submitBtn.disabled = !input.value.trim(); if(input) input.disabled = false; }
                const cont = document.getElementById('contentBody');
                if(cont) updateReflectionGate(cont);
            };
            setSubmitted(false);
            if(input){
                input.addEventListener('input', ()=>{ if(block.dataset.submitted!=='1'){ submitBtn.disabled = !input.value.trim(); const cont = document.getElementById('contentBody'); if(cont) updateReflectionGate(cont); } });
            }
            if(submitBtn){
                submitBtn.addEventListener('click', ()=>{ 
                    const val = (input.value||'').trim();
                    if(!val) return; 
                    setSubmitted(true);
                    if(answers && answers.length){
                        const correct = answers.some(a => String(a||'').trim().toLowerCase() === val.toLowerCase());
                        if(feedback){
                            feedback.textContent = correct ? 'Correct!' : 'Incorrect.';
                            feedback.style.display = 'block';
                        }
                        if(resetBtn){ resetBtn.style.display = correct ? 'none' : 'inline-block'; }
                        if(editBtn){ editBtn.style.display = 'inline-block'; }
                    }
                });
            }
            if(resetBtn){
                resetBtn.addEventListener('click', ()=>{ 
                    input.value=''; 
                    if(feedback){ feedback.style.display='none'; feedback.textContent=''; }
                    resetBtn.style.display='none';
                    if(editBtn){ editBtn.style.display='none'; }
                    setSubmitted(false); 
                    input.focus(); 
                });
            }
            if(editBtn){
                editBtn.addEventListener('click', ()=>{
                    block.dataset.submitted = '0';
                    if(input){ input.disabled = false; input.focus(); }
                    if(submitBtn){ submitBtn.disabled = !input.value.trim(); }
                    if(feedback){ feedback.style.display='none'; }
                    if(resetBtn){ resetBtn.style.display='none'; }
                    const cont = document.getElementById('contentBody');
                    if(cont) updateReflectionGate(cont);
                });
            }
        }
        function initEssay(block){
            const input = block.querySelector('.q-input');
            const submitBtn = block.querySelector('[data-act="submit"]');
            const resetBtn = block.querySelector('[data-act="reset"]');
            const editBtn = block.querySelector('[data-act="edit"]');
            const feedback = block.querySelector('.mc-feedback');
            const setSubmitted = (val)=>{
                block.dataset.submitted = val ? '1' : '0';
                if(val){ submitBtn.disabled = true; if(input) input.disabled = true; }
                else { submitBtn.disabled = !input.value.trim(); if(input) input.disabled = false; }
                const cont = document.getElementById('contentBody');
                if(cont) updateReflectionGate(cont);
            };
            setSubmitted(false);
            if(input){
                input.addEventListener('input', ()=>{ if(block.dataset.submitted!=='1'){ submitBtn.disabled = !input.value.trim(); const cont = document.getElementById('contentBody'); if(cont) updateReflectionGate(cont); } });
            }
            if(submitBtn){
                submitBtn.addEventListener('click', ()=>{ 
                    if(!input.value.trim()) return; 
                    setSubmitted(true); 
                    if(feedback){ 
                        feedback.textContent = 'Submitted. Please wait for the coach to check.'; 
                        feedback.style.display='block'; 
                    }
                    if(editBtn){ editBtn.style.display='inline-block'; }
                });
            }
            if(resetBtn){
                resetBtn.addEventListener('click', ()=>{ input.value=''; setSubmitted(false); input.focus(); });
            }
            if(editBtn){
                editBtn.addEventListener('click', ()=>{
                    block.dataset.submitted = '0';
                    if(input){ input.disabled = false; input.focus(); }
                    if(submitBtn){ submitBtn.disabled = !input.value.trim(); }
                    if(feedback){ feedback.style.display='none'; }
                    const cont = document.getElementById('contentBody');
                    if(cont) updateReflectionGate(cont);
                });
            }
        }
        function initTrueFalse(block){
            const tf = block.querySelector('.tf');
            const submitBtn = block.querySelector('[data-act="submit"]');
            const resetBtn = block.querySelector('[data-act="reset"]');
            const setSubmitted = (val)=>{
                block.dataset.submitted = val ? '1' : '0';
                if(val){ submitBtn.disabled = true; }
                else { submitBtn.disabled = tf.querySelector('.tf-option.selected') ? false : true; }
                const cont = document.getElementById('contentBody');
                if(cont) updateReflectionGate(cont);
            };
            setSubmitted(false);
            tf.querySelectorAll('.tf-option').forEach(opt=>{
                opt.addEventListener('click', ()=>{
                    if(block.dataset.submitted==='1') return;
                    tf.querySelectorAll('.tf-option').forEach(o=>o.classList.remove('selected'));
                    opt.classList.add('selected');
                    submitBtn.disabled = false;
                    const cont = document.getElementById('contentBody');
                    if(cont) updateReflectionGate(cont);
                });
            });
            if(submitBtn){
                submitBtn.addEventListener('click', ()=>{ 
                    const sel = tf.querySelector('.tf-option.selected');
                    if(!sel) return;
                    setSubmitted(true);
                    const selected = sel.getAttribute('data-val');
                    const ans = tf.getAttribute('data-answer');
                    tf.querySelectorAll('.tf-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                    if(ans){
                        if(selected === ans){
                            sel.classList.add('submitted-correct');
                            if(resetBtn) resetBtn.style.display='none';
                        } else {
                            sel.classList.add('submitted-wrong');
                            if(resetBtn) resetBtn.style.display='inline-block';
                        }
                    } else {
                        if(resetBtn) resetBtn.style.display='none';
                    }
                });
            }
            if(resetBtn){
                resetBtn.addEventListener('click', ()=>{
                    tf.querySelectorAll('.tf-option').forEach(o=>o.classList.remove('selected'));
                    submitBtn.disabled = true;
                    setSubmitted(false);
                    if(resetBtn) resetBtn.style.display='none';
                });
            }
        }
        function areAllQuestionsSubmitted(container){
            const blocks = Array.from(container.querySelectorAll('.field.question'));
            return blocks.every(b=>{
                const kind = b.getAttribute('data-kind');
                if(kind==='mc'){
                    const mc = b.querySelector('.mc');
                    return !!mc && mc.dataset.submitted==='1';
                } else {
                    return b.dataset.submitted==='1';
                }
            });
        }
        function updateReflectionGate(container){
            const ready = areAllQuestionsSubmitted(container);
            container.querySelectorAll('.reflection-inline').forEach(ref=>{
                const btn = ref.querySelector('[data-act="submit-ref"]');
                const input = ref.querySelector('.reflect-input');
                const hasText = !!(input && input.value && input.value.trim());
                if(btn){ btn.disabled = !(ready && hasText); }
                if(input){
                    input.addEventListener('input', ()=>{ if(btn){ btn.disabled = !(areAllQuestionsSubmitted(container) && !!input.value.trim()); } });
                }
            });
        }
        // Auto-refresh module lock statuses every 15s
        (function(){
            function applyModuleStatuses(mods){
                if(!Array.isArray(mods)) return;
                for(let i=0;i<mods.length;i++){
                    if(!course.modules || !course.modules[i]) continue;
                    course.modules[i].status = mods[i].status || 'unlocked';
                    const modEl = document.querySelectorAll('.module')[i];
                    if(modEl){
                        const title = modEl.querySelector('.module-title span');
                        if(title){
                            const hasLock = title.innerHTML.indexOf('fa-lock')>-1;
                            const shouldLock = (mods[i].status==='locked');
                            if(shouldLock && !hasLock){
                                title.innerHTML = '<i class="fas fa-lock" style="color:#64748b"></i> ' + title.innerText.replace(/^(\s*\uF023\s*)?/,'');
                            }else if(!shouldLock && hasLock){
                                title.innerHTML = title.innerText;
                            }
                        }
                    }
                }
            }
            function tick(){
                fetch("{{ route('courses.modules.status', $course) }}", {credentials:'same-origin'})
                    .then(r=>r.ok?r.json():null)
                    .then(j=>{ if(j&&j.ok&&Array.isArray(j.modules)){ applyModuleStatuses(j.modules); }})
                    .catch(()=>{});
            }
            setInterval(tick, 15000);
        })();
        (function(){
            var close=document.getElementById('gateClose');
            var ov=document.getElementById('gateOverlay');
            if(close){ close.addEventListener('click', function(e){ e.preventDefault(); if(ov){ ov.style.display='none'; } }); }
            document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ if(ov){ ov.style.display='none'; } } });
        })();
        renderVideo();
        if(!viewOnly){ loadReflectionMap(); }
        renderOutline();
        const firstTopic = (course.modules&&course.modules[0]&&course.modules[0].topics&&course.modules[0].topics[0])? [0,0]: null;
        if(firstTopic){ openTopic(0,0); }
    </script>
</body>
</html>
