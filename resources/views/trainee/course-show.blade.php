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
        .mc-actions [data-act="feedback"]{background:#fff;color:#0f3b8f;border:1px solid #c7d2fe}
        .mc-actions [data-act="reset"]{background:#0f3b8f;color:#fff}
        .mc-feedback{margin-top:8px;font-weight:700;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:10px;padding:10px}
        .btn-blue{
            background:linear-gradient(90deg,#002C76 0%, #0f3b8f 100%);
            color:#fff;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer;
            box-shadow:0 10px 20px rgba(37,99,235,.22);
            transition:transform .15s ease, box-shadow .2s ease, filter .2s ease;
        }
        .btn-blue:hover{ transform:translateY(-1px); box-shadow:0 14px 24px rgba(0,44,118,.28); filter:brightness(1.03); }
        .btn-blue:disabled{ background:#e5e7eb;color:#9ca3af;cursor:not-allowed; box-shadow:none; }
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
            background:rgba(255,255,255,.08);
        }
        .back-slim{width:28px;height:28px;border-radius:999px;border:1px solid rgba(255,255,255,.35);display:inline-flex;align-items:center;justify-content:center;color:#fff;background:rgba(255,255,255,.08)}
        .back-slim:hover{background:rgba(255,255,255,.18)}
        .search{padding:10px 16px 6px;display:flex;justify-content:center}
        .search input{
            width:92%;
            padding:12px 16px;
            border-radius:12px;
            border:1px solid #cfe0ff;
            outline:none;
            background:#ffffff;
            color:#0f172a;
            transition:border-color .15s ease, box-shadow .15s ease;
        }
        .search input::placeholder{color:#94a3b8}
        .search input:focus{border-color:#84b8ff; box-shadow:0 0 0 4px rgba(37,99,235,.12)}
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
        .module-left{flex:1;display:flex;flex-direction:column;gap:6px}
        .progress-mini{width:100%;height:4px;border-radius:999px;background:#e5e7eb;overflow:hidden;border:0}
        .progress-mini > span{display:block;height:100%;background:#22c55e;width:0%}
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
        
        /* Sidebar Tabs */
        .sidebar-tabs {
            display: flex;
            background: #002C76;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        .sidebar-tab {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #94a3b8;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent;
        }
        .sidebar-tab:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }
        .sidebar-tab.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .sidebar-tab i {
            font-size: 1.1rem;
        }
        .tab-content {
            display: none;
            height: calc(100vh - 56px);
            overflow-y: auto;
        }
        .tab-content.active {
            display: block;
        }
        .resource-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            margin: 8px 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #fff;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .resource-item:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-1px);
        }
        .resource-icon {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff; /* White icon as requested */
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .resource-download {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.5);
            font-size: 1rem;
            transition: all 0.2s ease;
            border-radius: 8px;
        }
        .resource-item:hover .resource-download {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }
        .resource-info {
            flex: 1;
            min-width: 0;
        }
        .resource-title {
            font-weight: 700;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #fff;
            margin-bottom: 2px;
        }
        .resource-meta {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        
        /* Specific icon backgrounds like the image */
        .icon-pdf { background: #ef4444; }
        .icon-doc { background: #3b82f6; }
        .icon-xls { background: #22c55e; }
        .icon-ppt { background: #f97316; }
        .icon-img { background: #a855f7; }
        .icon-vid { background: #6366f1; }
        .icon-other { background: #64748b; }

        .mc .mc-option{background:#fff;border:1px solid #e6edf5}
        .mc .mc-option:hover{background:#f5f8ff}
        .mc .mc-option.selected{background:#eef2ff;border-color:#c7d2fe}
        .mc-actions{gap:10px}
        .btn-ghost{border:1px solid #e2e8f0;border-radius:12px;padding:12px 14px;background:#fff;font-weight:700}
        .pane{
            border-radius:24px;
            box-shadow:0 20px 44px rgba(15,23,42,.08);
            border:1px solid #e6edf5;
            background:linear-gradient(180deg,#ffffff 0%, #fbfcff 100%);
            padding:20px 22px 24px;
        }
        .pane h2{
            margin:6px 0 18px;
            font-size:2.35rem;
            font-weight:900;
            line-height:1.02;
            letter-spacing:-0.045em;
            color:#0f172a;
        }
        .field{
            border-radius:20px;
            box-shadow:0 8px 20px rgba(15,23,42,.05);
            border:1px solid #e7edf6;
            margin:14px 0;
            background:linear-gradient(180deg,#ffffff 0%, #fbfdff 100%);
        }
        .chip{padding:8px 14px;color:#0f3b8f;border:1px solid #dbeafe;background:#eef4ff;font-weight:800;box-shadow:inset 0 1px 0 rgba(255,255,255,.45)}
        .btn-green{
            box-shadow:0 10px 20px rgba(37,99,235,.2);
        }
        .question .q-title{
            font-size:1.55rem;
            font-weight:900;
            margin:4px 0 18px;
            color:#111827;
            letter-spacing:-0.03em;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
        }
        .q-title-text{flex:1;min-width:0}
        .qtype-pill{
            flex:0 0 auto;
            font-size:.72rem;
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:.08em;
            padding:7px 10px;
            border-radius:999px;
            background:#f1f5f9;
            border:1px solid #e2e8f0;
            color:#334155;
            white-space:nowrap;
        }
        .mc .mc-option,
        .tf .tf-option{
            border-radius:18px;
            padding:18px 18px;
            margin:12px 0;
            background:linear-gradient(180deg,#ffffff 0%, #f8fbff 100%);
            box-shadow:0 6px 16px rgba(15,23,42,.04);
        }
        .mc .mc-option:hover,
        .tf .tf-option:hover{
            border-color:#d6e4ff;
            background:#f4f8ff;
        }
        .mc .mc-option.selected,
        .tf .tf-option.selected{
            background:linear-gradient(180deg,#eef4ff 0%, #e8f0ff 100%);
            border-color:#c7d7ff;
        }
        .mc .mc-label,
        .tf .mc-label{
            font-size:1.05rem;
            font-weight:700;
            color:#172554;
        }
        .mc .mc-radio{
            width:26px;
            height:26px;
            border:2px solid #b5c4da;
        }
        .mc[data-mode="multiple_choice_multiple"] .mc-radio{
            border-radius:7px;
        }
        .mc[data-mode="multiple_choice_multiple"] .mc-option.selected .mc-radio{
            position:relative;
            background:#2563eb;
            border-color:#2563eb;
            box-shadow:none;
        }
        .mc[data-mode="multiple_choice_multiple"] .mc-option.selected .mc-radio::after{
            content:'✓';
            position:absolute;
            inset:0;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:16px;
            font-weight:900;
            line-height:1;
        }
        .mc[data-mode="multiple_choice_multiple"] .mc-option.choice-disabled{
            opacity:.48;
            cursor:not-allowed;
            background:#f8fafc;
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
        textarea.q-input{
            min-height:152px;
            resize:vertical;
        }
        .q-input::placeholder{ color:#94a3b8; }
        .q-input:focus{
            outline:none;
            border-color:#60a5fa;
            box-shadow:0 0 0 3px rgba(96,165,250,.25), inset 0 1px 2px rgba(15,23,42,.06), 0 12px 24px rgba(15,23,42,.12);
            background:#fff;
        }
        .field .muted{
            font-size:1rem;
            line-height:1.6;
            color:#5b6b82;
        }
        #contentBody{
            display:grid;
            gap:18px;
            min-height:320px;
        }
        .subheader{
            background:linear-gradient(180deg,#f8fbff 0%, #f1f6ff 100%);
            border:1px solid #dfe9f8;
            border-radius:16px;
            padding:15px 18px;
            font-size:1.08rem;
            font-weight:800;
            color:#173b83;
            box-shadow:0 8px 18px rgba(15,23,42,.04);
        }
        .field.question[data-kind="id"] .mc-actions,
        .field.question[data-kind="essay"] .mc-actions{
            margin-top:12px;
            display:flex;
            gap:10px;
            justify-content:flex-end;
        }
        .field.question[data-kind="enum"] .q-input{
            min-height:56px;
        }
        .topbar > div:nth-child(2){
            display:none;
        }
        #videoWrap video{border-radius:14px;box-shadow:var(--shadow-sm)}
        .back-btn{
            min-width:98px;height:42px;border-radius:14px;
            border:1px solid #dbe2ee;background:#fff;color:#0f3b8f;
            display:inline-flex;align-items:center;justify-content:center;gap:8px;
            padding:0 16px;text-decoration:none;box-shadow:0 8px 18px rgba(15,23,42,.06);font-weight:800;
        }
        .back-btn:hover{background:#f8fafc;border-color:#cfdceb}
        @media (max-width: 980px){
            .layout{height:auto}
            .sidebar{display:none}
            .topbar{left:0}
            .content{padding-top:64px}
            .pane{
                padding:16px 16px 20px;
                border-radius:20px;
            }
            .pane h2{
                font-size:1.9rem;
            }
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
                $isCoach = in_array($role, ['trainer','coach'], true) || \Illuminate\Support\Str::endsWith((string) $role, '_coach');
                $backUrl = $isCoach ? route('trainer.courses.enter', $course) : route('trainee.courses.show', $course);
            @endphp
            <a href="{{ $backUrl }}" style="color:#0f3b8f"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </header>
    @php
        $role = auth()->user()->role ?? null;
        $IS_COACH = in_array($role, ['trainer','coach'], true) || \Illuminate\Support\Str::endsWith((string) $role, '_coach');
    @endphp
    <!-- removed classroom subheader -->
    @if(!$course->can_access && !($IS_COACH ?? false))
        <div style="position:fixed;inset:0;background:rgba(255,255,255,0.95);z-index:1000;display:flex;align-items:center;justify-content:center;padding:24px;text-align:center;">
            <div style="max-width:480px;">
                <div style="width:80px;height:80px;background:#fef3c7;color:#92400e;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2 style="font-size:2rem;font-weight:900;color:#1e293b;margin-bottom:16px;letter-spacing:-0.025em;">Course Not Yet Started</h2>
                <p style="color:#64748b;font-size:1.1rem;line-height:1.6;margin-bottom:32px;">
                    This course is scheduled to start on <strong style="color:#0f172a;">{{ $course->start_date->format('F d, Y') }}</strong>. 
                    Please come back then to access the learning materials and modules.
                </p>
                <a href="{{ route('dashboard') }}" style="display:inline-flex;align-items:center;gap:10px;background:#002C76;color:#fff;text-decoration:none;padding:14px 32px;border-radius:14px;font-weight:800;font-size:1rem;transition:all 0.2s;box-shadow:0 10px 15px -3px rgba(0,44,118,0.3);">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    @endif
    <div class="layout" id="modulesPane">
        <aside class="sidebar">
            <div style="display: flex; align-items: center; background: #002C76; border-bottom: 1px solid rgba(255,255,255,0.12); padding: 0 12px;">
                <div class="sidebar-tabs" style="display:flex; border-bottom: none; flex: 1;">
                    <div class="sidebar-tab active" data-tab="outlineTab" style="padding: 16px 8px;">
                        <i class="fas fa-book"></i>
                        <span style="font-size: 0.85rem;">Course Outline</span>
                    </div>
                    <div class="sidebar-tab" data-tab="resourcesTab" style="padding: 16px 8px;">
                        <i class="fas fa-file-alt"></i>
                        <span style="font-size: 0.85rem;">Resources</span>
                    </div>
                </div>
            </div>

            <div id="outlineTab" class="tab-content active">
                <div class="search" style="padding: 14px 12px 6px;">
                    <input type="text" id="outlineSearch" placeholder="Search topics..." style="width: 100%;">
                </div>
                <div id="outline" class="outline" style="padding-top: 4px;"></div>
            </div>

            <div id="resourcesTab" class="tab-content">
                <div class="outline" style="padding-top: 14px;">
                    @forelse($course->materials as $material)
                        @php
                            $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                            $icon = 'fa-file-alt';
                            $bgClass = 'icon-other';
                            
                            if(in_array($ext, ['pdf'])) { $icon = 'fa-file-pdf'; $bgClass = 'icon-pdf'; }
                            elseif(in_array($ext, ['doc','docx'])) { $icon = 'fa-file-word'; $bgClass = 'icon-doc'; }
                            elseif(in_array($ext, ['xls','xlsx'])) { $icon = 'fa-file-excel'; $bgClass = 'icon-xls'; }
                            elseif(in_array($ext, ['ppt','pptx'])) { $icon = 'fa-file-powerpoint'; $bgClass = 'icon-ppt'; }
                            elseif(in_array($ext, ['jpg','jpeg','png','gif'])) { $icon = 'fa-file-image'; $bgClass = 'icon-img'; }
                            elseif(in_array($ext, ['mp4','webm','avi'])) { $icon = 'fa-file-video'; $bgClass = 'icon-vid'; }
                        @endphp
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="resource-item">
                            <div class="resource-icon {{ $bgClass }}">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="resource-info">
                                <div class="resource-title">{{ $material->title }}</div>
                                <div class="resource-meta">{{ strtoupper($ext) ?: $material->type }}</div>
                            </div>
                            <div class="resource-download">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    @empty
                        <div style="padding: 40px 20px; text-align: center; color: rgba(255,255,255,0.4);">
                            <i class="fas fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 12px;"></i>
                            <div style="font-weight: 700;">No resources available</div>
                            <div style="font-size: 0.85rem; margin-top: 4px;">Uploaded files will appear here.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </aside>
        <main class="content">
            <div class="pane" style="position: relative;">
                <a href="{{ $backUrl }}" aria-label="Back to Classroom" style="position: absolute; top: 22px; right: 22px; color: #0f3b8f; text-decoration: none; font-weight: 700; font-size: 0.9rem; padding: 8px 16px; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,.1); z-index: 10;">
                    Back to Classroom
                </a>
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
        const isCoachRole = (role) => role === 'trainer' || role === 'coach' || /_coach$/.test(String(role || ''));
        const IS_TRAINER = isCoachRole(USER_ROLE);
        const IS_TRAINEE_USER = (function(){
            const roles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
            return roles.indexOf(USER_ROLE) > -1;
        })();
        // Ensure modules is an array (some DBs return JSON as string)
        if (typeof course.modules === 'string') {
            try { course.modules = JSON.parse(course.modules || '[]') || []; } catch(e){ course.modules = []; }
        }
        const status = @json($status);
        const isEnrolled = status === 'active';
        const viewOnly = @json($viewOnly ?? false);
        let allowedModuleIndex = @json($allowedModuleIndex ?? null);
        const finalExamModuleIndex = @json($finalExamModuleIndex ?? null);
        let finalExamUnlocked = @json($finalExamUnlocked ?? false);
        const csrf = "{{ csrf_token() }}";
        let reflectionMap = {};
        const ENFORCE_LOCKS_ALL = false;

        function redirectToAllowedModule(message){
            if(allowedModuleIndex === null || allowedModuleIndex === undefined){ return; }
            const targetMi = Number(allowedModuleIndex);
            const target = new URL(window.location.href);
            target.searchParams.set('mi', String(targetMi));
            try{
                window.history.replaceState({}, '', target.toString());
            }catch(e){}

            const modules = Array.isArray(course.modules) ? course.modules : [];
            const targetModule = modules[targetMi] || {};
            const targetTopics = Array.isArray(targetModule.topics) ? targetModule.topics : [];
            const hasExam = !!(targetModule.exam && Array.isArray(targetModule.exam.questions) && targetModule.exam.questions.length);

            document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));

            if(targetTopics.length > 0){
                const moduleNode = document.querySelectorAll('.module')[targetMi];
                const topicsCt = moduleNode?.querySelector('.topics');
                if(topicsCt){ topicsCt.style.display = 'block'; }
                const chev = moduleNode?.querySelector('.toggle-icon i');
                if(chev){ chev.style.transform = 'rotate(180deg)'; }
                openTopic(targetMi, 0);
                return;
            }

            if(hasExam){
                openExam(targetMi);
            }
        }

        function canAccessModule(mi){
            recalculateClientAccessState();
            if(!IS_TRAINEE_USER || allowedModuleIndex === null || allowedModuleIndex === undefined){ return true; }
            return mi <= allowedModuleIndex;
        }

        function canAccessFinalExam(mi){
            recalculateClientAccessState();
            if(!IS_TRAINEE_USER || finalExamModuleIndex === null || finalExamModuleIndex === undefined){ return true; }
            if(mi !== finalExamModuleIndex){ return true; }
            return !!finalExamUnlocked;
        }

        async function syncServerAccessState(){
            try{
                const res = await fetch("{{ route('courses.access-state', $course) }}", {credentials:'same-origin'});
                if(!res.ok) return false;
                const data = await res.json();
                if(!data?.ok) return false;
                if(data.allowed_module_index !== null && data.allowed_module_index !== undefined){
                    allowedModuleIndex = Number(data.allowed_module_index);
                }
                finalExamUnlocked = !!data.final_exam_unlocked;
                return true;
            }catch(e){
                return false;
            }
        }

        function isClientModuleCompleted(mi){
            const module = (Array.isArray(course.modules) ? course.modules : [])[mi] || {};
            const topics = Array.isArray(module.topics) ? module.topics : [];
            if(!topics.length) return false;
            return topics.every((_, ti)=> hasReflection(mi, ti, -1));
        }

        function recalculateClientAccessState(){
            const modules = Array.isArray(course.modules) ? course.modules : [];
            const contentIndexes = [];
            modules.forEach((module, index)=>{
                const topics = Array.isArray(module?.topics) ? module.topics : [];
                if(topics.length){ contentIndexes.push(index); }
            });

            if(!contentIndexes.length){
                if(finalExamModuleIndex !== null && finalExamModuleIndex !== undefined){
                    allowedModuleIndex = finalExamModuleIndex;
                    finalExamUnlocked = true;
                }
                return;
            }

            let nextAllowed = contentIndexes[0];
            let completedAll = true;
            for(const moduleIndex of contentIndexes){
                if(isClientModuleCompleted(moduleIndex)){
                    nextAllowed = moduleIndex;
                    continue;
                }
                nextAllowed = moduleIndex;
                completedAll = false;
                break;
            }

            if(completedAll){
                nextAllowed = contentIndexes[contentIndexes.length - 1];
            }

            allowedModuleIndex = nextAllowed;
            finalExamUnlocked = completedAll;
        }

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
                const isLocked = false;
                const isExamOnly = (m && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length) && (!Array.isArray(m.topics) || m.topics.length===0);
                const baseTitle = m.title || (isExamOnly ? 'Module Exam' : 'Untitled');
                const titleStr = isExamOnly ? (m.exam && m.exam.title ? `Module Exam: ${m.exam.title}` : baseTitle) : `Module ${mi+1}: ${baseTitle}`;
                mod.innerHTML = `
                    <div class="module-header" data-mi="${mi}">
                        <div class="module-left">
                            <div class="module-title"><span>${isLocked ? '<i class="fas fa-lock lock-ico"></i> ' : ''}${titleStr}</span></div>
                            <div class="progress-mini"><span id="bar_${mi}"></span></div>
                        </div>
                        <div class="mod-badges">
                            <span class="module-kpi" id="kpi_${mi}"></span>
                            <button class="toggle-icon" aria-label="Toggle module"><i class="fas fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <div class="topics"></div>
                `;
                // Locks disabled
                const topicsCt = mod.querySelector('.topics');
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
                        document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
                        tEl.classList.add('active');
                        openTopic(mi,ti);
                        e.stopPropagation();
                    });
                    if(!viewOnly){
                        tEl.querySelectorAll('.sub-item').forEach(n=>{
                            n.addEventListener('click',(e)=>{
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
                mod.querySelector('.module-header').addEventListener('click',()=>{
                    // Locks disabled
                    const open = topicsCt.style.display==='block';
                    topicsCt.style.display = open?'none':'block';
                    const chev = mod.querySelector('.toggle-icon i'); if(chev){ chev.style.transform = open?'rotate(0deg)':'rotate(180deg)'; }
                });
                el.appendChild(mod);
                // initialize progress
                if(!viewOnly){ updateProgressFor(mi); }
                // Add a separate Module Exam block only when the exam is embedded within a content module
                // Skip when this is an exam-only module to avoid duplication
                if (!isExamOnly && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length) {
                    const modEx = document.createElement('div');
                    modEx.className = 'module';
                    const exTitle = m.exam.title ? `Module Quiz: ${m.exam.title}` : 'Module Quiz';
                    modEx.innerHTML = `
                        <div class="module-header" data-mi="${mi}">
                            <div class="module-left">
                                <div class="module-title"><span>${isLocked ? '<i class="fas fa-lock lock-ico"></i> ' : ''}${exTitle}</span></div>
                                <div class="progress-mini"><span id="bar_ex_${mi}"></span></div>
                            </div>
                            <div class="mod-badges">
                                <span class="module-kpi" id="kpi_ex_${mi}"></span>
                                <button class="toggle-icon" aria-label="Toggle module"><i class="fas fa-chevron-down"></i></button>
                            </div>
                        </div>
                        <div class="topics"></div>
                    `;
                    const exTopics = modEx.querySelector('.topics');
                    const exHead = modEx.querySelector('.module-header');
                    // Create a single exam "topic" row for consistent UX
                    const tEl = document.createElement('div');
                    tEl.className='topic';
                    tEl.setAttribute('data-mi',mi);
                    tEl.setAttribute('data-ti','exam');
                    const num = `${mi+1}.Q`;
                    const qCount = m.exam.questions.length;
                    const badge = `<span class="count" style="display:inline-block">${qCount}</span>`;
                    tEl.innerHTML = `<div class="topic-head">
                        <i class="fas fa-circle" style="font-size:.6rem;color:#9ca3af"></i>
                        <span class="title">${num}. ${m.exam.title ? ('Module Quiz: '+m.exam.title) : 'Module Quiz'}</span>
                        ${badge}
                    </div>`;
                    const head = tEl.querySelector('.topic-head');
                    head.addEventListener('click', (e)=>{
                        document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
                        tEl.classList.add('active');
                        openExam(mi);
                        e.stopPropagation();
                    });
                    exTopics.appendChild(tEl);
                    exHead.addEventListener('click',()=>{
                        const open = exTopics.style.display==='block';
                        exTopics.style.display = open?'none':'block';
                        const chev = modEx.querySelector('.toggle-icon i'); if(chev){ chev.style.transform = open?'rotate(0deg)':'rotate(180deg)'; }
                    });
                    el.appendChild(modEx);
                }
            });
            const outlineSearch = document.getElementById('outlineSearch');
            if(outlineSearch){
                outlineSearch.addEventListener('input', (e)=>{
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
            // Topic-level reflection is completion criterion
            const isTopicDone = hasReflection(mi,ti,-1);
            topicEl.classList.toggle('done', !!isTopicDone);
            const cnt = topicEl.querySelector(`#cnt_${mi}_${ti}`);
            if(cnt) cnt.textContent = isTopicDone ? 'Done' : 'Pending';
        }
        function updateProgressFor(mi){
            const mod = document.querySelectorAll('.module')[mi];
            if(!mod) return;
            // Special case: exam-only modules should use exam score for the progress mini-bar
            const m = (course.modules||[])[mi]||{};
            const isExamOnly = (m && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length)
                && (!Array.isArray(m.topics) || m.topics.length===0);
            if(isExamOnly){
                // Default empty until we confirm a submitted attempt
                const bar = mod.querySelector(`#bar_${mi}`); if(bar) bar.style.width = '0%';
                const kpi = mod.querySelector(`#kpi_${mi}`); if(kpi) kpi.textContent = '';
                updateExamBarFor(mi, `bar_${mi}`, `kpi_${mi}`, m.exam);
                return;
            }

            const topics = mod.querySelectorAll('.topic');
            let total=topics.length, done=0;
            topics.forEach((tEl)=>{
                const ti = tEl.getAttribute('data-ti');
                if (ti === 'exam') return; // handle exam separately below
                const tiInt = parseInt(ti, 10);
                renderDoneStates(mi,tiInt,tEl);
                if(hasReflection(mi,tiInt,-1)) done++;
            });

            // If module has an embedded exam, include it in progress ONLY if it's a standalone exam module.
            // Embedded exams (quizzes) in content modules are now optional for progress percentage.
            const hasExam = m && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length;
            if (hasExam && isExamOnly) {
                total++;
                const attempt = examAttemptCache[mi];
                const passCfg = (m.exam.passing_score!=null && m.exam.passing_score!=='') ? (parseInt(m.exam.passing_score,10)||0) : 70;
                if (attempt && (Number(attempt.final_pct ?? attempt.pct ?? attempt.objective_pct ?? 0) >= passCfg)) {
                    done++;
                }
            }

            const pct = total ? Math.round((done/total)*100) : 0;
            const bar = mod.querySelector(`#bar_${mi}`); if(bar) bar.style.width = pct+'%';
            const kpi = mod.querySelector(`#kpi_${mi}`); if(kpi) kpi.textContent = total ? `${pct}%` : '';
            if(pct===100){ /* no catch-up for topics */ }
        }

        // Exam progress bars:
        // - Keep at 0% until there is a submitted attempt
        // - Only fill when score >= 75% (or >= passing_score if defined)
        const examAttemptCache = {};
        async function fetchExamAttempt(mi){
            if(Object.prototype.hasOwnProperty.call(examAttemptCache, mi)) return examAttemptCache[mi];
            try{
                const r = await fetch("{{ url('/courses/'.$course->id.'/module-exam/attempt') }}?mi="+encodeURIComponent(mi), {credentials:'same-origin'});
                const j = r.ok ? await r.json() : null;
                examAttemptCache[mi] = (j && j.ok && j.attempt) ? j.attempt : null;
                return examAttemptCache[mi];
            }catch(e){
                examAttemptCache[mi] = null;
                return null;
            }
        }
        async function updateExamBarFor(mi, barId, kpiId, examCfg){
            const bar = document.getElementById(barId);
            const kpi = document.getElementById(kpiId);
            if(bar) bar.style.width = '0%';
            if(kpi) kpi.textContent = '';

            const attempt = await fetchExamAttempt(mi);
            if(!attempt) return;

            // module-exam/attempt returns summary fields at the top-level of attempt
            const finalPct = Number(attempt?.final_pct ?? attempt?.pct ?? attempt?.objective_pct ?? 0) || 0;
            const passCfg = (examCfg && examCfg.passing_score!=null && examCfg.passing_score!=='')
                ? (parseInt(examCfg.passing_score,10) || 0)
                : 70;
            const isPassed = finalPct >= passCfg;
            if(kpi) kpi.textContent = `${finalPct}%`;
            if(bar) {
                bar.style.width = `${finalPct}%`;
                if (!isPassed) {
                    bar.style.background = '#9ca3af'; // Grey for not passed
                } else {
                    bar.style.background = '#22c55e'; // Green for passed
                }
            }
        }

        async function updateAllExamBars(){
            const mods = Array.isArray(course.modules)?course.modules:[];
            for(let mi=0; mi<mods.length; mi++){
                const m = mods[mi]||{};
                const hasExam = m && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length;
                const hasTopics = Array.isArray(m.topics) && m.topics.length>0;
                // Embedded exams create bar_ex_* elements
                if(hasExam && hasTopics){
                    await updateExamBarFor(mi, `bar_ex_${mi}`, `kpi_ex_${mi}`, m.exam);
                }
                // Exam-only modules are handled by updateProgressFor(), but we also call here as a safety net
                if(hasExam && !hasTopics){
                    await updateExamBarFor(mi, `bar_${mi}`, `kpi_${mi}`, m.exam);
                }
                if(!viewOnly){ updateProgressFor(mi); }
            }
        }
        function updateAllProgress(){
            const modules = document.querySelectorAll('.module');
            modules.forEach((_, idx)=> updateProgressFor(idx));
            recalculateClientAccessState();
        }

        // Tab switching logic
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.sidebar-tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.getAttribute('data-tab');
                    
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    tab.classList.add('active');
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });

        async function openTopic(mi,ti){
            if(!canAccessModule(mi)){
                await syncServerAccessState();
                if(!canAccessModule(mi)){
                    redirectToAllowedModule('You can only access your current module.');
                    return;
                }
            }
            document.querySelectorAll('.topic').forEach(n=>n.classList.remove('active'));
            const node = document.querySelector(`.topic[data-mi="${mi}"][data-ti="${ti}"]`);
            if(node) node.classList.add('active');
            const m = (course.modules||[])[mi]||{};
            const t = (m.topics||[])[ti]||{};
            document.getElementById('contentTitle').textContent = `${mi+1}.${ti}. ${(typeof t==='string')?t:(t.title||'Topic')}`;
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
                // Append a single Topic-level reflection at the end
                const key = `${mi}_${ti}_-1`;
                const reflectionHTML = `
                    <section class="subgroup" id="topic_ref_${mi}_${ti}" data-mi="${mi}" data-ti="${ti}" data-si="-1">
                        <div class="subheader"><span>${mi+1}.${ti}. Reflection</span></div>
                        <div class="subfields">
                            <div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="-1">
                                <div style="font-weight:700;margin-bottom:6px">What did you learn?</div>
                                <textarea class="reflect-input" data-ref="${key}" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your personal reflection here"></textarea>
                                <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                    <button type="button" class="btn-blue" data-act="submit-ref" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:8px 12px">Done</button>
                                </div>
                                <div class="reflect-summary" style="display:none;margin-top:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:10px"></div>
                            </div>
                        </div>
                    </section>`;
                body.insertAdjacentHTML('beforeend', reflectionHTML);
                // Bind reflection behaviors on the topic-level block
                (function(){
                    const container = document.getElementById('contentBody');
                    container.querySelectorAll('.reflection-inline').forEach(block=>{
                        const bMi = parseInt(block.getAttribute('data-mi'),10);
                        const bTi = parseInt(block.getAttribute('data-ti'),10);
                        const bSi = parseInt(block.getAttribute('data-si'),10); // -1
                        const submitBtn = block.querySelector('[data-act="submit-ref"]');
                        const input = block.querySelector('.reflect-input');
                        const summary = block.querySelector('.reflect-summary');
                        const k = `${bMi}_${bTi}_-1`;
                        if(hasReflection(bMi,bTi,-1)){
                            const prev = reflectionMap[k];
                            if(input && prev && typeof prev==='object' && prev.learned){ input.value = prev.learned; }
                            if(submitBtn){ submitBtn.textContent='Submitted'; submitBtn.disabled=true; }
                            if(input){ input.disabled=true; }
                            if(summary && prev && typeof prev==='object' && prev.submitted){
                                summary.style.display='block';
                                summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div><div><b>What you learned:</b> ${prev.learned ? prev.learned : '(none)'}</div>`;
                            }
                        }
                        if(submitBtn){
                            submitBtn.onclick = async ()=>{
                                const containerEl = document.getElementById('contentBody');
                                const ready = areAllQuestionsSubmitted(containerEl);
                                if(!ready){ var ov=document.getElementById('gateOverlay'); if(ov){ ov.style.display='flex'; } return; }
                                const questions = [{id:'learned', text:'What did you learn?'}];
                                const answers = { learned: input.value||'' };
                                try{
                                    submitBtn.disabled = true;
                                    const res = await fetch("{{ route('courses.reflect.store', $course) }}", {
                                        method:'POST',
                                        headers:{'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/json'},
                                        credentials:'same-origin',
                                        body: JSON.stringify({ module_index:bMi, topic_index:bTi, sub_index:-1, questions, answers })
                                    });
                                    if(res.ok){
                                        markReflection(bMi,bTi,-1);
                                        summary.style.display='block';
                                        summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted<\/div>
                                            <div><b>What you learned:<\/b> ${answers.learned?answers.learned:'(none)'}<\/div>
                                            <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="reset-ref" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Reset<\/button><\/div>`;
                                        input.disabled=true; submitBtn.disabled=true; submitBtn.textContent='Done';
                                        input.style.display='none';
                                        const actions = submitBtn.parentElement; if(actions){ actions.style.display='none'; }
                                        updateProgressFor(bMi);
                                        await syncServerAccessState();
                                        try{ localStorage.setItem('course_progress_broadcast', String(Date.now())); }catch(e){}
                                        const resetBtn = summary.querySelector('[data-act="reset-ref"]');
                                        if(resetBtn){
                                            resetBtn.onclick = ()=>{
                                                input.disabled=false;
                                                submitBtn.disabled=false;
                                                submitBtn.textContent='Done';
                                                summary.style.display='none';
                                                input.style.display='';
                                                if(actions){ actions.style.display='flex'; }
                                                unmarkReflection(bMi,bTi,-1);
                                                updateProgressFor(bMi);
                                                syncServerAccessState();
                                                input.focus();
                                    };
                                }
                                
                                // Check for 100% completion
                                const j = await res.json().catch(()=>null);
                                if(j && j.completed) {
                                    showCongrats();
                                }
                            } else {
                                const j = await res.json().catch(()=>null);
                                alert(j && j.error ? j.error : 'Submission failed. Please try again.');
                                submitBtn.disabled = false;
                            }
                                }catch(e){
                                    alert('Network error while submitting. Please try again.');
                                    submitBtn.disabled = false;
                                }
                            };
                        }
                    });
                    updateReflectionGate(container);
                })();
                // Final pass to ensure values are populated from reflectionMap
                (function(){
                    const blocks = document.querySelectorAll('#contentBody .reflection-inline');
                    blocks.forEach(b=>{
                        const mi2 = parseInt(b.getAttribute('data-mi'),10);
                        const ti2 = parseInt(b.getAttribute('data-ti'),10);
                        const key2 = `${mi2}_${ti2}_-1`;
                        const prev2 = reflectionMap[key2];
                        const input2 = b.querySelector('.reflect-input');
                        const btn2 = b.querySelector('[data-act="submit-ref"]');
                        const sum2 = b.querySelector('.reflect-summary');
                        if(prev2 && typeof prev2==='object' && prev2.submitted){
                            if(input2){ input2.value = prev2.learned || ''; input2.disabled = true; input2.style.display='none'; }
                            if(btn2){ btn2.textContent = 'Submitted'; btn2.disabled = true; if(btn2.parentElement){ btn2.parentElement.style.display='none'; } }
                            if(sum2){
                                sum2.style.display='block';
                                sum2.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                    <div><b>What you learned:</b> ${prev2.learned ? prev2.learned : '(none)'}</div>
                                    <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="reset-ref" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Reset</button></div>`;
                                const resetBtn = sum2.querySelector('[data-act="reset-ref"]');
                                if(resetBtn){
                                    resetBtn.onclick = ()=>{
                                        if(input2){ input2.disabled=false; input2.style.display=''; input2.focus(); }
                                        if(btn2){ btn2.disabled=false; btn2.textContent='Done'; if(btn2.parentElement){ btn2.parentElement.style.display='flex'; } }
                                        sum2.style.display='none';
                                        unmarkReflection(mi2,ti2,-1);
                                        updateProgressFor(mi2);
                                    };
                                }
                            }
                        }
                    });
                })();
                // After rendering, sync progress visuals in outline
                const topicEl = document.querySelector(`.topic[data-mi="${mi}"][data-ti="${ti}"]`);
                if(topicEl) renderDoneStates(mi,ti,topicEl);
                return;
            }
            const fields = ('fields' in t) ? t.fields : (t.fields_json ? (typeof t.fields_json==='string'?JSON.parse(t.fields_json):t.fields_json) : []);
            renderFieldsInto(document.getElementById('contentBody'), fields, mi, ti);
            // Ensure topic-level reflection populated for topics without subtopics as well
            (function(){
                const blocks = document.querySelectorAll('#contentBody .reflection-inline');
                blocks.forEach(b=>{
                    const mi2 = parseInt(b.getAttribute('data-mi'),10);
                    const ti2 = parseInt(b.getAttribute('data-ti'),10);
                    const key2 = `${mi2}_${ti2}_-1`;
                    const prev2 = reflectionMap[key2];
                    const input2 = b.querySelector('.reflect-input');
                    const btn2 = b.querySelector('[data-act="submit-ref"]');
                    const sum2 = b.querySelector('.reflect-summary');
                    if(prev2 && typeof prev2==='object' && prev2.submitted){
                        if(input2){ input2.value = prev2.learned || ''; input2.disabled = true; input2.style.display='none'; }
                        if(btn2){ btn2.textContent = 'Submitted'; btn2.disabled = true; if(btn2.parentElement){ btn2.parentElement.style.display='none'; } }
                        if(sum2){
                            sum2.style.display='block';
                            sum2.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                <div><b>What you learned:</b> ${prev2.learned ? prev2.learned : '(none)'}</div>
                                <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="reset-ref" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Reset</button></div>`;
                            const resetBtn = sum2.querySelector('[data-act="reset-ref"]');
                            if(resetBtn){
                                resetBtn.onclick = ()=>{
                                    if(input2){ input2.disabled=false; input2.style.display=''; input2.focus(); }
                                    if(btn2){ btn2.disabled=false; btn2.textContent='Done'; if(btn2.parentElement){ btn2.parentElement.style.display='flex'; } }
                                    sum2.style.display='none';
                                    unmarkReflection(mi2,ti2,-1);
                                    updateProgressFor(mi2);
                                };
                            }
                        }
                    }
                });
            })();
        }
        async function openExam(mi){
            console.log('openExam initiated for module index:', mi);
            if(!canAccessFinalExam(mi)){
                await syncServerAccessState();
                if(!canAccessFinalExam(mi)){
                    redirectToAllowedModule('Complete all modules before taking the final exam.');
                    return;
                }
            }
            const m = (course.modules||[])[mi]||{};
            const ex = m.exam||{};
            const timerMode = ex.timer_mode || (ex.timer_minutes > 0 ? 'timed' : 'untimed');
            const timerMins = timerMode === 'timed' ? (parseInt(ex.timer_minutes||0,10) || 0) : 0;
            const qs = Array.isArray(ex.questions)? ex.questions : [];
            const titleEl = document.getElementById('contentTitle');
            const bodyEl = document.getElementById('contentBody');
            
            // Distinguish between Quiz and Exam title based on whether module has topics
            const isExamOnly = (m && m.exam && Array.isArray(m.exam.questions) && m.exam.questions.length) && (!Array.isArray(m.topics) || m.topics.length===0);
            const labelPrefix = isExamOnly ? 'Module Exam' : 'Module Quiz';
            const labelShort = isExamOnly ? 'E' : 'Q';
            
            if(titleEl) titleEl.textContent = `${mi+1}.${labelShort} ${labelPrefix}`;
            if(!qs.length){
                if(bodyEl) bodyEl.innerHTML = `<div class="field" style="background:#f8fafc;">No questions added.</div>`;
                return;
            }
            function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
            function isMultipleChoiceQuestion(kind){ return ['multiple_choice', 'multiple_choice_single', 'multiple_choice_multiple'].includes(String(kind || '')); }
            function normalizeMcKind(kind){ return String(kind || '') === 'multiple_choice_multiple' ? 'multiple_choice_multiple' : 'multiple_choice_single'; }
            function questionTypeLabel(kind){
                const t = String(kind || '');
                if(isMultipleChoiceQuestion(t)){
                    return normalizeMcKind(t) === 'multiple_choice_multiple'
                        ? 'Multiple Choice (Multiple Answers)'
                        : 'Multiple Choice (Single Answer)';
                }
                if(t === 'true_false') return 'True/False';
                if(t === 'identification') return 'Identification';
                if(t === 'enumeration') return 'Enumeration';
                if(t === 'essay') return 'Essay';
                if(!t) return 'Question';
                return t.replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase());
            }
            function questionHeading(qi, q, fallback, typeLabel){
                const text = `${qi+1}. ${esc(q.text||q.title||fallback)}`;
                return `<div class="q-title"><span class="q-title-text">${text}</span><span class="qtype-pill">${esc(typeLabel)}</span></div>`;
            }
            function mcCorrectIndexes(q){
                const choices = Array.isArray(q.choices) ? q.choices : (Array.isArray(q.options) ? q.options : []);
                let raw = Array.isArray(q.correct_answers) ? q.correct_answers.slice() : [];
                if(!raw.length && q.correct_answer !== undefined && q.correct_answer !== null && q.correct_answer !== '') raw = [q.correct_answer];
                if(!raw.length && q.answer_index !== undefined && q.answer_index !== null && q.answer_index !== '') raw = [q.answer_index];
                return Array.from(new Set(raw.map(value => {
                    if(!isNaN(Number(value))) return Number(value);
                    const text = String(value || '').trim();
                    if(/^[A-Za-z]$/.test(text)) return text.toUpperCase().charCodeAt(0) - 65;
                    return choices.findIndex(choice => String(choice || '').trim().toLowerCase() === text.toLowerCase());
                }).filter(index => Number.isInteger(index) && index >= 0 && index < choices.length)));
            }
            const html = qs.map((q,qi)=>{
                const kind = q.type || 'multiple_choice';
                const showTrainerAnswer = (IS_TRAINER===true);
                if(isMultipleChoiceQuestion(kind)){
                    const mcKind = normalizeMcKind(kind);
                    const correctIndexes = mcCorrectIndexes(q);
                    const typeLabel = (mcKind === 'multiple_choice_multiple' || correctIndexes.length > 1)
                        ? 'Multiple Choice (Multiple Answers)'
                        : 'Multiple Choice (Single Answer)';
                    const heading = questionHeading(qi, q, 'Question', typeLabel);
                    const opts = (q.choices||q.options||[]).map((o,oi)=>{
                        const isAns = correctIndexes.includes(oi);
                        const chip = showTrainerAnswer && isAns ? '<span class="chip">Answer</span>' : '';
                        return `<div class="mc-option${isAns&&showTrainerAnswer?' trainer-answer':''}" data-idx="${oi}"><span class="mc-radio"></span><span class="mc-label">${esc(o)}</span> ${chip}</div>`;
                    }).join('');
                    const helper = mcKind === 'multiple_choice_multiple' ? '<div class="muted" style="margin-bottom:8px">Select all that apply.</div>' : '';
                    if(showTrainerAnswer){
                        return `<div class="field question">${heading}${helper}<div class="mc" data-mode="${mcKind}" data-answer="${correctIndexes.join(',')}">${opts}</div></div>`;
                    }
                    return `<div class="field question" data-kind="mc">
                        ${heading}
                        ${helper}
                        <div class="mc" data-mode="${mcKind}" data-answer="${correctIndexes.join(',')}">${opts}</div>
                    </div>`;
                }else if(kind==='identification'){
                    const heading = questionHeading(qi, q, 'Identification', questionTypeLabel(kind));
                    const ans = q.answer||'';
                    if(showTrainerAnswer){
                        const extra = ans ? `<div class="chip">Answer</div> ${esc(ans)}` : '<div class="muted">No answer provided</div>';
                        return `<div class="field question">${heading}${extra}</div>`;
                    }
                    const dataAns = String(JSON.stringify(ans? [ans]:[])).replace(/"/g,'&quot;');
                    return `<div class="field question" data-kind="id">
                        ${heading}
                        <div class="muted" style="margin-bottom:8px">This item is checked manually.</div>
                        <input class="q-input input" type="text" placeholder="Your answer" data-answers="${dataAns}">
                    </div>`;
                }else if(kind==='enumeration'){
                    const heading = questionHeading(qi, q, 'Enumeration', questionTypeLabel(kind));
                    const answers = Array.isArray(q.answers) ? q.answers : [];
                    const maxPoints = Number(q.max_points || 1) || 1;
                    if(showTrainerAnswer){
                        const list = answers.length
                            ? `<div style="display:grid;gap:6px;margin-top:8px">${answers.map((answer, index)=>`<div><span class="chip">Answer ${index + 1}</span> ${esc(answer)}</div>`).join('')}</div>`
                            : '<div class="muted">No correct answers configured.</div>';
                        return `<div class="field question" data-kind="enum">
                            ${heading}
                            ${list}
                            <div style="margin-top:8px"><span class="chip">Max Points</span> ${maxPoints}</div>
                        </div>`;
                    }
                    // If trainee, show input fields. Use maxPoints to determine how many boxes.
                    const inputCount = Math.max(answers.length, maxPoints);
                    const inputFields = [];
                    for(let i=0; i<inputCount; i++){
                        inputFields.push(`<input class="q-input input enum-input" type="text" placeholder="Answer ${i + 1}" data-enum-index="${i}" style="margin-bottom:8px">`);
                    }
                    return `<div class="field question" data-kind="enum">
                        ${heading}
                        <div class="muted" style="margin-bottom:8px">Provide one answer per field. This item is checked manually.</div>
                        <div class="enum-list" style="display:grid;gap:2px">
                            ${inputFields.join('')}
                        </div>
                    </div>`;
                }else if(kind==='essay'){
                    const heading = questionHeading(qi, q, 'Essay', questionTypeLabel(kind));
                    const maxPoints = Number(q.max_points || 1) || 1;
                    if(showTrainerAnswer){
                        return `<div class="field question" data-kind="essay">
                            ${heading}
                            <div class="muted">Essay question. Review trainee submissions in the results panel.</div>
                            <div style="margin-top:8px"><span class="chip">Max Points</span> ${maxPoints}</div>
                        </div>`;
                    }
                    return `<div class="field question" data-kind="essay">
                        ${heading}
                        <textarea class="q-input input" rows="6" placeholder="Write your answer here" style="width:100%;resize:vertical"></textarea>
                        <div class="muted" style="margin-top:8px">This item will be checked manually.</div>
                    </div>`;
                }else if(kind==='true_false'){
                    const heading = questionHeading(qi, q, 'True or False', questionTypeLabel(kind));
                    const val = (q.answer===true)?'true':(q.answer===false?'false':'');
                    if(showTrainerAnswer){
                        const opts = ['True','False'].map(v=>{
                            const isAns = (v.toLowerCase()===val);
                            const chip = isAns ? '<span class="chip">Answer</span>' : '';
                            return `<div class="tf-option${isAns?' trainer-answer':''}"><span class="mc-radio"></span><span>${v}</span> ${chip}</div>`;
                        }).join('');
                        return `<div class="field question">${heading}<div class="tf">${opts}</div></div>`;
                    }
                    const opts2 = ['True','False'].map(v=>{
                        return `<div class="tf-option" data-val="${v.toLowerCase()}"><span class="mc-radio"></span><span>${v}</span></div>`;
                    }).join('');
                    return `<div class="field question" data-kind="tf">
                        ${heading}
                        <div class="tf" data-answer="${val}">${opts2}</div>
                    </div>`;
                }else{
                    const heading = questionHeading(qi, q, 'Question', questionTypeLabel(kind));
                    return `<div class="field">${heading}<div class="muted">Unsupported question type.</div></div>`;
                }
            }).join('');
            const passPct = (ex.passing_score!=null && ex.passing_score!=='') ? (parseInt(ex.passing_score,10)||0) : null;
            // Optional trainer-only Results button
            const resultsBtn = IS_TRAINER ? '<button id="examResultsBtn" class="btn-ghost" style="padding:8px 12px;border-radius:10px;border:1px solid #dbe4ef;background:#fff;font-weight:800">View Results</button>' : '';
            const titleText = ex.title ? `Module Exam: ${esc(ex.title)}` : 'Module Exam';
            const header = `
                <div class="subheader">
                    <span>${titleText}</span>
                    <div style="display:flex;align-items:center;gap:8px">
                        <span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-list" style="margin-right:6px;color:#002C76"></i> ${qs.length} question${qs.length===1?'':'s'}</span>
                        ${timerMins && timerMode === 'timed' ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-clock" style="margin-right:6px;color:#002C76"></i> <span id="examTimer"></span></span>` : ``}
                        ${resultsBtn}
                    </div>
                </div>`;
            if(bodyEl){
                const preface = IS_TRAINER ? '' : `
                    <div id="examLoading" style="margin:12px 0;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:linear-gradient(180deg,#f8fbff 0%, #f5f7fb 100%);box-shadow:0 10px 22px rgba(15,23,42,.06);text-align:center;font-weight:800;color:#334155">
                        Loading exam status...
                    </div>
                    <div id="examPreface" style="display:none;margin:12px 0;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:linear-gradient(180deg,#f8fbff 0%, #f5f7fb 100%);box-shadow:0 10px 22px rgba(15,23,42,.06)">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:10px">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;border:1px solid #dbeafe"><i class="fas fa-circle-info" style="color:#0f3b8f"></i></div>
                                <div style="font-weight:900;color:#0f172a;letter-spacing:-.01em">Exam Instructions</div>
                            </div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap">
                                <span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-list" style="margin-right:6px;color:#0f3b8f"></i> ${qs.length} item${qs.length===1?'':'s'}</span>
                                ${timerMins && timerMode === 'timed' ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-clock" style="margin-right:6px;color:#0f3b8f"></i> ${timerMins} min</span>` : `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-infinity" style="margin-right:6px;color:#0f3b8f"></i> No time limit</span>`}
                                ${passPct!=null ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-check-circle" style="margin-right:6px;color:#0f3b8f"></i> Passing ${passPct}%</span>` : ``}
                            </div>
                        </div>
                        <div style="color:#334155;margin:0 0 12px 0">
                            <ul style="margin:0 0 0 18px;line-height:1.6">
                                <li>Answer all questions to the best of your knowledge.</li>
                                <li>Your timer will start when you press Start.</li>
                                <li>The exam will request fullscreen mode and monitor tab switching while you are taking it.</li>
                            </ul>
                        </div>
                        <div style="display:flex;justify-content:center">
                            <button id="examStart" class="btn-blue" style="padding:12px 28px;border-radius:16px;box-shadow:0 10px 24px rgba(37,99,235,.22)">Start Fullscreen Exam</button>
                        </div>
                    </div>`;
                const bodyWrap = `<div id="examBody" style="display:none">${html}${IS_TRAINER ? '' : `<div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px"><button id="examSubmitAll" class="btn-blue">Submit Exam</button></div>`}</div>`;
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
                const warningOverlay = IS_TRAINER ? '' : `
                <div id="examViolationOverlay" style="position:fixed;inset:0;background:rgba(15,23,42,.62);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:4100">
                  <div style="width:min(560px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:20px;box-shadow:0 30px 60px rgba(2,6,23,.28);overflow:hidden">
                    <div style="padding:16px 18px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:12px;background:linear-gradient(180deg,#fff7ed 0%,#ffffff 100%)">
                      <div style="width:40px;height:40px;border-radius:12px;background:#fff7ed;border:1px solid #fdba74;display:flex;align-items:center;justify-content:center">
                        <i class="fas fa-triangle-exclamation" style="color:#c2410c"></i>
                      </div>
                      <div>
                        <div style="font-weight:900;color:#0f172a;letter-spacing:-.01em">Stay Inside The Exam</div>
                        <div id="examViolationCount" style="color:#9a3412;font-weight:700;font-size:.95rem"></div>
                      </div>
                    </div>
                    <div style="padding:16px 18px">
                      <div id="examViolationMessage" style="margin:6px 0 12px;color:#334155;font-weight:700;line-height:1.6"></div>
                    </div>
                    <div style="padding:14px 18px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:10px;background:#fff">
                      <button id="examViolationContinue" class="btn-blue" style="padding:12px 18px;border-radius:12px;min-width:160px">Return To Exam</button>
                    </div>
                  </div>
                </div>`;
                bodyEl.innerHTML = header + `<div id="examResult" style="display:none;margin:10px 0;padding:12px;border:1px solid #e5e7eb;border-radius:12px;background:#f8fafc;font-weight:800"></div>` + preface + bodyWrap + confirmOverlay + warningOverlay;
            }
            if(!IS_TRAINER){
                const keyBase = `exam_${course.id}_${mi}`;
                const fullscreenHost = document.documentElement;
                const examWarningThreshold = 1;
                const examAutoSubmitThreshold = 3;
                const examSignature = JSON.stringify(qs.map(q => ({
                    type: String(q.type || ''),
                    text: String(q.text || q.title || ''),
                    max_points: q.max_points ?? null,
                    answer_index: q.answer_index ?? null,
                    answer: q.answer ?? null,
                    answers: Array.isArray(q.answers) ? q.answers : [],
                    choices: Array.isArray(q.choices) ? q.choices : (Array.isArray(q.options) ? q.options : [])
                })));
                try{
                    const prevSignature = localStorage.getItem(keyBase+'_signature');
                    if(prevSignature !== examSignature){
                        localStorage.removeItem(keyBase+'_answers');
                        localStorage.removeItem(keyBase+'_submitted');
                        localStorage.removeItem(keyBase+'_start');
                        localStorage.removeItem(keyBase+'_started');
                        localStorage.removeItem(keyBase+'_integrity');
                        localStorage.setItem(keyBase+'_signature', examSignature);
                    }
                }catch(e){}
                function emptyExamIntegrity(){
                    return {
                        violations: 0,
                        warning_threshold: examWarningThreshold,
                        auto_submit_threshold: examAutoSubmitThreshold,
                        auto_submitted: false,
                        last_reason: null,
                        events: []
                    };
                }
                function readExamIntegrity(){
                    try{
                        const parsed = JSON.parse(localStorage.getItem(keyBase+'_integrity') || 'null');
                        if(parsed && typeof parsed === 'object'){
                            return {
                                violations: Math.max(0, parseInt(parsed.violations || 0, 10) || 0),
                                warning_threshold: Math.max(1, parseInt(parsed.warning_threshold || examWarningThreshold, 10) || examWarningThreshold),
                                auto_submit_threshold: Math.max(1, parseInt(parsed.auto_submit_threshold || examAutoSubmitThreshold, 10) || examAutoSubmitThreshold),
                                auto_submitted: !!parsed.auto_submitted,
                                last_reason: parsed.last_reason || null,
                                events: Array.isArray(parsed.events) ? parsed.events.slice(-20) : []
                            };
                        }
                    }catch(e){}
                    return emptyExamIntegrity();
                }
                function writeExamIntegrity(next){
                    const normalized = {
                        violations: Math.max(0, parseInt(next?.violations || 0, 10) || 0),
                        warning_threshold: Math.max(1, parseInt(next?.warning_threshold || examWarningThreshold, 10) || examWarningThreshold),
                        auto_submit_threshold: Math.max(1, parseInt(next?.auto_submit_threshold || examAutoSubmitThreshold, 10) || examAutoSubmitThreshold),
                        auto_submitted: !!next?.auto_submitted,
                        last_reason: next?.last_reason || null,
                        events: Array.isArray(next?.events) ? next.events.slice(-20) : []
                    };
                    try{ localStorage.setItem(keyBase+'_integrity', JSON.stringify(normalized)); }catch(e){}
                    return normalized;
                }
                function resetExamIntegrity(){
                    lastViolationAt = 0;
                    return writeExamIntegrity(emptyExamIntegrity());
                }
                const resultBox = document.getElementById('examResult');
                const prefaceBox = document.getElementById('examPreface');
                const loadingBox = document.getElementById('examLoading');
                const bodyBox = document.getElementById('examBody');
                const closeBtn = document.getElementById('examClose');
                const violationOverlay = document.getElementById('examViolationOverlay');
                const violationCountEl = document.getElementById('examViolationCount');
                const violationMessageEl = document.getElementById('examViolationMessage');
                const violationContinueBtn = document.getElementById('examViolationContinue');
                let examModeActive = false;
                let suppressNextVisibilityViolation = false;
                let isHandlingExamSubmit = false;
                let lastViolationAt = 0;
                let timerIv = null;
                let latestExamSummary = null;
                async function requestExamFullscreen(){
                    try{
                        if(document.fullscreenElement){
                            console.log('Already in fullscreen or fullscreenElement is true.');
                            return true;
                        }
                        if(!fullscreenHost?.requestFullscreen){
                            console.warn('Fullscreen API not supported by fullscreenHost.');
                            return true; // Or false, depending on desired fallback behavior
                        }
                        console.log('Attempting to request fullscreen...');
                        await fullscreenHost.requestFullscreen();
                        console.log('Fullscreen request successful.');
                        return true;
                    }catch(e){
                        console.error('Fullscreen request failed:', e);
                        return false;
                    }
                }
                async function exitExamFullscreen(){
                    try{
                        if(document.fullscreenElement && document.exitFullscreen){
                            await document.exitFullscreen();
                        }
                    }catch(e){}
                }
                function hideViolationOverlay(){
                    if(violationOverlay){ violationOverlay.style.display = 'none'; }
                }
                async function resumeExamFromViolation(){
                    hideViolationOverlay();
                    const entered = await requestExamFullscreen();
                    if(!entered){
                        setTimeout(()=>{ triggerExamViolation('fullscreen_required'); }, 120);
                    }
                }
                async function triggerExamViolation(reason){
                    if(!examModeActive || isHandlingExamSubmit){
                        return;
                    }
                    const nowTs = Date.now();
                    if((nowTs - lastViolationAt) < 1200){
                        return;
                    }
                    lastViolationAt = nowTs;
                    const integrity = readExamIntegrity();
                    const nextCount = integrity.violations + 1;
                    const next = writeExamIntegrity({
                        ...integrity,
                        violations: nextCount,
                        last_reason: reason,
                        events: [...integrity.events, {
                            type: reason,
                            at: new Date().toISOString(),
                            count: nextCount
                        }]
                    });
                    const reasons = {
                        hidden: 'You switched away from the exam tab.',
                        blur: 'The exam window lost focus.',
                        fullscreen_exit: 'You exited fullscreen during the exam.',
                        fullscreen_required: 'Fullscreen must stay enabled while the exam is active.'
                    };
                    if(nextCount >= examAutoSubmitThreshold){
                        writeExamIntegrity({
                            ...next,
                            auto_submitted: true,
                            last_reason: reason
                        });
                        if(violationOverlay){
                            violationOverlay.style.display = 'flex';
                        }
                        if(violationCountEl){
                            violationCountEl.textContent = `Violation ${nextCount} of ${examAutoSubmitThreshold}`;
                        }
                        if(violationMessageEl){
                            violationMessageEl.innerHTML = `${reasons[reason] || 'You left the protected exam mode.'}<br><br>You reached the maximum violation limit. The exam will be submitted now.`;
                        }
                        if(violationContinueBtn){
                            violationContinueBtn.disabled = true;
                            violationContinueBtn.textContent = 'Submitting...';
                        }
                        handleSubmit(true);
                        return;
                    }
                    if(violationOverlay){
                        violationOverlay.style.display = 'flex';
                    }
                    if(violationCountEl){
                        violationCountEl.textContent = `Violation ${nextCount} of ${examAutoSubmitThreshold}`;
                    }
                    if(violationMessageEl){
                        violationMessageEl.innerHTML = `${reasons[reason] || 'You left the protected exam mode.'}<br><br>Please return to fullscreen to continue. Another ${examAutoSubmitThreshold - nextCount} violation${examAutoSubmitThreshold - nextCount === 1 ? '' : 's'} will trigger auto-submit.`;
                    }
                    if(violationContinueBtn){
                        violationContinueBtn.disabled = false;
                        violationContinueBtn.textContent = 'Return To Exam';
                    }
                }
                function onExamVisibilityChange(){
                    if(!examModeActive || suppressNextVisibilityViolation || isHandlingExamSubmit){
                        return;
                    }
                    if(document.hidden){
                        triggerExamViolation('hidden');
                    }
                }
                function onExamBlur(){
                    if(!examModeActive || suppressNextVisibilityViolation || isHandlingExamSubmit){
                        return;
                    }
                    triggerExamViolation('blur');
                }
                function onExamFullscreenChange(){
                    if(!examModeActive || suppressNextVisibilityViolation || isHandlingExamSubmit){
                        return;
                    }
                    if(!document.fullscreenElement){
                        triggerExamViolation('fullscreen_exit');
                    } else {
                        hideViolationOverlay();
                    }
                }
                function enableExamMonitoring(){
                    if(examModeActive){
                        return;
                    }
                    examModeActive = true;
                    document.addEventListener('visibilitychange', onExamVisibilityChange);
                    window.addEventListener('blur', onExamBlur);
                    document.addEventListener('fullscreenchange', onExamFullscreenChange);
                }
                function disableExamMonitoring(){
                    hideViolationOverlay();
                    if(!examModeActive){
                        return;
                    }
                    examModeActive = false;
                    document.removeEventListener('visibilitychange', onExamVisibilityChange);
                    window.removeEventListener('blur', onExamBlur);
                    document.removeEventListener('fullscreenchange', onExamFullscreenChange);
                }
                if(violationContinueBtn){
                    violationContinueBtn.addEventListener('click', ()=>{ resumeExamFromViolation(); });
                }
                function saveAnswers(){
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    const answers = blocks.map(b=>{
                        const kind = b.getAttribute('data-kind') || 'mc';
                        if(kind==='mc'){
                            const mc = b.querySelector('.mc');
                            const selections = Array.from(b.querySelectorAll('.mc .mc-option.selected')).map(opt => parseInt(opt.getAttribute('data-idx'),10)).filter(Number.isInteger);
                            return mc?.dataset.mode === 'multiple_choice_multiple' ? selections : (selections.length ? selections[0] : null);
                        }else if(kind==='id'){
                            const inp = b.querySelector('.q-input'); return (inp?.value||'').trim();
                        }else if(kind==='enum'){
                            return Array.from(b.querySelectorAll('.enum-input')).map(inp => (inp?.value || '').trim());
                        }else if(kind==='essay'){
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
                            const values = Array.isArray(val) ? val : (Number.isInteger(val) ? [val] : []);
                            values.forEach(idx => {
                                const opt = b.querySelector(`.mc .mc-option[data-idx="${idx}"]`);
                                if(opt){ opt.classList.add('selected'); }
                            });
                            const mc = b.querySelector('.mc[data-mode="multiple_choice_multiple"]');
                            if(mc){
                                const expectedCount = String(mc.dataset.answer || '')
                                    .split(',')
                                    .map(v => parseInt(v, 10))
                                    .filter(v => Number.isInteger(v)).length;
                                const limitReached = expectedCount && mc.querySelectorAll('.mc-option.selected').length >= expectedCount;
                                mc.querySelectorAll('.mc-option').forEach(option => {
                                    option.classList.toggle('choice-disabled', limitReached && !option.classList.contains('selected'));
                                });
                            }
                        }else if(kind==='id'){
                            const inp = b.querySelector('.q-input'); if(inp){ inp.value = val || ''; }
                        }else if(kind==='enum'){
                            const arr = Array.isArray(val) ? val : [];
                            b.querySelectorAll('.enum-input').forEach((inp, idx)=>{
                                inp.value = arr[idx] || '';
                            });
                        }else if(kind==='essay'){
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
                            b.querySelectorAll('.q-input').forEach(inp=>{ inp.disabled = true; });
                        }else{
                            b.style.pointerEvents='auto';
                            b.querySelectorAll('.q-input').forEach(inp=>{ inp.disabled = false; });
                        }
                    });
                }
                function normalizeEnumAnswers(values){
                    const arr = Array.isArray(values) ? values : [];
                    const seen = new Set();
                    const out = [];
                    arr.forEach(value=>{
                        const cleaned = String(value || '').trim().replace(/\s+/g, ' ').toLowerCase();
                        if(!cleaned || seen.has(cleaned)) return;
                        seen.add(cleaned);
                        out.push(cleaned);
                    });
                    return out;
                }
                function isManualExamKind(kind){
                    return ['essay', 'enumeration', 'identification'].includes(String(kind || ''));
                }
                function manualExamKindLabel(kind){
                    const labels = { essay: 'Essay', enumeration: 'Enumeration', identification: 'Identification' };
                    return labels[String(kind || '')] || 'Manual';
                }
                function computeGrade(){
                    const answers = JSON.parse(localStorage.getItem(keyBase+'_answers')||'[]') || [];
                    let total = 0, correct = 0;
                    let manualTotal = 0;
                    for(let i=0;i<qs.length;i++){
                        const q = qs[i]||{};
                        const kind = q.type || 'multiple_choice';
                        const a = answers[i];
                        if(isManualExamKind(kind)){
                            manualTotal++;
                            continue;
                        }
                        if(isMultipleChoiceQuestion(kind)){
                            const maxPoints = Number(q.max_points || 1) || 1;
                            total += maxPoints;
                            const correctIndexes = mcCorrectIndexes(q).sort((x,y)=>x-y);
                            const submittedIndexes = (Array.isArray(a) ? a : (Number.isInteger(a) ? [a] : [])).filter(Number.isInteger).sort((x,y)=>x-y);
                            const exact = correctIndexes.length === submittedIndexes.length && correctIndexes.every((value, idx) => value === submittedIndexes[idx]);
                            if(exact) correct += maxPoints;
                            else if(normalizeMcKind(kind) === 'multiple_choice_multiple' && correctIndexes.length){
                                const correctSet = new Set(correctIndexes);
                                const matched = submittedIndexes.filter(index => correctSet.has(index)).length;
                                correct += (matched / correctIndexes.length) * maxPoints;
                            }
                        }else if(kind==='true_false'){
                            const maxPoints = Number(q.max_points || 1) || 1;
                            total += maxPoints;
                            const val = q.answer===true?'true':(q.answer===false?'false':'');
                            if(a && String(a).toLowerCase()===val) correct += maxPoints;
                        }
                    }
                    const pct = total ? Math.round((correct/total)*100) : 0;
                    return {correct:Number(correct.toFixed(2)),total:Number(total.toFixed(2)),pct,manualTotal};
                }
                bodyEl.querySelectorAll('.field.question[data-kind="mc"] .mc .mc-option').forEach(opt=>{
                    opt.addEventListener('click', ()=>{
                        const wrap = opt.closest('.mc');
                        const submitted = localStorage.getItem(keyBase+'_submitted')==='1';
                        if(submitted) return;
                        if(wrap.dataset.mode === 'multiple_choice_multiple'){
                            const expectedCount = String(wrap.dataset.answer || '')
                                .split(',')
                                .map(v => parseInt(v, 10))
                                .filter(v => Number.isInteger(v)).length;
                            const selectedCount = wrap.querySelectorAll('.mc-option.selected').length;
                            if(expectedCount && selectedCount >= expectedCount && !opt.classList.contains('selected')) return;
                            opt.classList.toggle('selected');
                            const limitReached = expectedCount && wrap.querySelectorAll('.mc-option.selected').length >= expectedCount;
                            wrap.querySelectorAll('.mc-option').forEach(option => {
                                option.classList.toggle('choice-disabled', limitReached && !option.classList.contains('selected'));
                            });
                        }else{
                            wrap.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected'));
                            opt.classList.add('selected');
                        }
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
                bodyEl.querySelectorAll('.field.question[data-kind="essay"] .q-input').forEach(inp=>{
                    inp.addEventListener('input', ()=>{ if(localStorage.getItem(keyBase+'_submitted')!=='1'){ saveAnswers(); } });
                });
                bodyEl.querySelectorAll('.field.question[data-kind="enum"] .q-input').forEach(inp=>{
                    inp.addEventListener('input', ()=>{ if(localStorage.getItem(keyBase+'_submitted')!=='1'){ saveAnswers(); } });
                });
                const submitAll = bodyEl.querySelector('#examSubmitAll');
                const resetBtn = null;
                async function handleSubmit(triggeredByViolation = false){
                    if(isHandlingExamSubmit){
                        return;
                    }
                    isHandlingExamSubmit = true;
                    saveAnswers();
                    const {correct,total,pct,manualTotal} = computeGrade();
                    if(submitAll){ submitAll.disabled = true; submitAll.textContent = 'Submitting...'; }
                    let serverSummary = null;
                    let serverCompleted = false;
                    if(!IS_TRAINER){
                        try{
                            const answersStr = localStorage.getItem(keyBase+'_answers')||'[]';
                            const resp = await fetch("{{ url('/courses/'.$course->id.'/module-exam/submit') }}", {
                                method:'POST',
                                headers:{
                                    'Content-Type':'application/json',
                                    'Accept':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                },
                                credentials:'same-origin',
                                body: JSON.stringify({
                                    mi: mi,
                                    answers: JSON.parse(answersStr),
                                    duration_ms: 0,
                                    exam_integrity: writeExamIntegrity({
                                        ...readExamIntegrity(),
                                        auto_submitted: triggeredByViolation || readExamIntegrity().auto_submitted
                                    })
                                })
                            });
                            const raw = await resp.text();
                            let j = null;
                            try{ j = raw ? JSON.parse(raw) : null; }catch(e){ j = null; }
                            if(!j || !j.ok){
                                const msg = j && j.error
                                    ? j.error
                                    : `Exam submission failed. HTTP ${resp.status}${raw && !j ? ' - ' + raw.slice(0, 180) : ''}`;
                                if(submitAll){ submitAll.disabled = false; submitAll.textContent = 'Submit Exam'; }
                                isHandlingExamSubmit = false;
                                alert(msg);
                                return;
                            }
                            serverSummary = j.summary || null;
                            serverCompleted = !!j.completed;
                        }catch(_){
                            if(submitAll){ submitAll.disabled = false; submitAll.textContent = 'Submit Exam'; }
                            isHandlingExamSubmit = false;
                            alert('Exam submission failed. Please check your connection and try again.');
                            return;
                        }
                    }
                    if(submitAll){ submitAll.disabled = true; submitAll.textContent = 'Submitted'; }
                    try{ localStorage.setItem(keyBase+'_submitted','1'); }catch(e){}
                    setFrozen(true);
                    // stop timer and mark as submitted
                    const tElDone = document.getElementById('examTimer');
                    if(timerIv){ clearInterval(timerIv); timerIv = null; }
                    if(tElDone){ tElDone.textContent = 'Done'; }
                    // Show centered result panel and hide questions
                    if(resultBox){
                        renderExamSummary(serverSummary || {
                            final_pct: pct,
                            objective_correct: correct,
                            objective_total: total,
                            objective_pct: pct,
                            essay_pending_count: manualTotal,
                            essay_checked_count: 0,
                            manual_pending_count: manualTotal,
                            manual_checked_count: 0,
                            status: manualTotal > 0 ? 'pending_review' : 'completed',
                            status_label: manualTotal > 0 ? 'Pending Manual Review' : 'Completed',
                            items: [],
                            exam_integrity: readExamIntegrity(),
                            violation_count: readExamIntegrity().violations,
                            auto_submitted: readExamIntegrity().auto_submitted
                        });
                    }
                    if(serverCompleted) {
                        showCongrats();
                    }
                    disableExamMonitoring();
                    suppressNextVisibilityViolation = true;
                    await exitExamFullscreen();
                    setTimeout(()=>{ suppressNextVisibilityViolation = false; }, 400);
                    isHandlingExamSubmit = false;
                }
                async function renderExamSummary(summary){
                    let retakeRequested = summary?.retake_requested ?? false;
                    let retakeApproved = summary?.retake_approved ?? false;

                    // If we don't have retake info in summary, try to fetch it
                    if (summary && summary.passed === false && typeof summary.retake_requested === 'undefined') {
                        try {
                            const r = await fetch("{{ route('courses.module-exam.attempt', $course) }}?mi="+encodeURIComponent(mi), {credentials:'same-origin'});
                            const j = await r.json();
                            if (j && j.ok) {
                                retakeRequested = !!j.retake_requested;
                                retakeApproved = !!j.retake_approved;
                            }
                        } catch(e) {}
                    }

                    latestExamSummary = summary || null;
                    if(!resultBox){ return; }
                    const finalPct = Number(summary?.final_pct ?? 0) || 0;
                    const objectiveCorrect = Number(summary?.objective_correct ?? 0) || 0;
                    const objectiveTotal = Number(summary?.objective_total ?? 0) || 0;
                    const manualPending = Number(summary?.manual_pending_count ?? summary?.essay_pending_count ?? 0) || 0;
                    const manualChecked = Number(summary?.manual_checked_count ?? summary?.essay_checked_count ?? 0) || 0;
                    const status = summary?.status || 'completed';
                    const statusLabel = summary?.status_label || 'Completed';
                    const violationCount = Number(summary?.violation_count ?? summary?.exam_integrity?.violations ?? 0) || 0;
                    const wasAutoSubmitted = !!(summary?.auto_submitted ?? summary?.exam_integrity?.auto_submitted);
                    const effectivePassingScore = summary?.passing_score != null && summary?.passing_score !== ''
                        ? (parseInt(summary.passing_score, 10) || 0)
                        : ((typeof passPct === 'number') ? passPct : null);
                    const allowPassFail = status === 'completed';
                    const passed = allowPassFail
                        ? (typeof summary?.passed === 'boolean'
                            ? summary.passed
                            : ((typeof effectivePassingScore === 'number' && effectivePassingScore > 0)
                                ? (finalPct >= effectivePassingScore)
                                : null))
                        : null;
                    const canRetake = status === 'completed' && passed === false;
                    const statusTxt = status === 'pending_review'
                        ? 'Your manually checked answers are waiting for teacher/admin review.'
                        : status === 'partially_graded'
                            ? 'Your objective items are graded. Manual-checking items are still under review.'
                            : (passed===null ? '' : (passed ? 'You passed the exam.' : 'You did not pass the exam.'));
                    const statusColor = status === 'pending_review'
                        ? '#b45309'
                        : status === 'partially_graded'
                            ? '#0f3b8f'
                            : (passed===null ? '#334155' : (passed ? '#059669' : '#b91c1c'));
                        
                        let retakeButtonHtml = '';
                        if (canRetake) {
                            if (retakeApproved) {
                                retakeButtonHtml = `<button id="examRetake" class="btn-blue" style="padding:10px 16px;border-radius:12px">Retake Exam</button>`;
                            } else if (retakeRequested) {
                                retakeButtonHtml = `<button class="btn-ghost" disabled style="padding:10px 16px;border-radius:12px;border:1px solid #cbd5e1;background:#f1f5f9;font-weight:800;color:#64748b;cursor:not-allowed">Waiting for trainer approval</button>`;
                            } else {
                                retakeButtonHtml = `<button id="examRequestRetake" class="btn-ghost" style="padding:10px 16px;border-radius:12px;border:1px solid #cbd5e1;background:#fff;font-weight:800">Request Retake</button>`;
                            }
                        }

                        resultBox.style.display='block';
                        resultBox.style.background = '#ffffff';
                        resultBox.style.border = '1px solid #e5e7eb';
                        resultBox.style.boxShadow = '0 16px 32px rgba(2,6,23,.08)';
                        resultBox.style.borderRadius = '16px';
                        resultBox.style.width = '100%';
                        resultBox.style.maxWidth = '720px';
                        resultBox.style.margin = '0 auto';
                        resultBox.innerHTML = `
                          <div style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:16px">
                            <svg viewBox="0 0 100 60" style="display:block;max-width:420px;width:100%;height:auto">
                              <path d="M10,60 A40,40 0 1 1 90,60" fill="none" stroke="#e5e7eb" stroke-width="12" stroke-linecap="round"></path>
                              <path id="examGaugePath" d="M10,60 A40,40 0 1 1 90,60" fill="none" stroke="${status==='pending_review' ? '#f59e0b' : (passed===false ? '#ef4444' : '#002C76')}" stroke-width="12" stroke-linecap="round" stroke-dasharray="0 999"></path>
                              <text x="50" y="45" text-anchor="middle" font-size="18" font-weight="900" fill="#0f172a">${finalPct}%</text>
                            </svg>
                            <div style="font-weight:800;color:#0f172a">Current score: <span>${finalPct}%</span>.</div>
                            <div style="font-size:0.95rem;font-weight:800;color:${statusColor}">${statusLabel}</div>
                            ${statusTxt ? `<div style="color:${statusColor};font-weight:800">${statusTxt}</div>` : ''}
                            <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;margin-top:6px">
                              <span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-check" style="margin-right:6px;color:#0f3b8f"></i> ${objectiveCorrect}/${objectiveTotal} Objective score</span>
                              ${manualPending ? `<span class="chip" style="background:#fff7ed;border:1px solid #fdba74;color:#b45309"><i class="fas fa-pen-nib" style="margin-right:6px;"></i> ${manualPending} pending manual review</span>` : ``}
                              ${manualChecked ? `<span class="chip" style="background:#ecfdf5;border:1px solid #86efac;color:#166534"><i class="fas fa-check-double" style="margin-right:6px;"></i> ${manualChecked} manually checked</span>` : ``}
                              ${effectivePassingScore!=null ? `<span class="chip" style="background:#eef2ff;border:1px solid #dbeafe"><i class="fas fa-flag-checkered" style="margin-right:6px;color:#0f3b8f"></i> Passing ${effectivePassingScore}%</span>` : ``}
                              ${violationCount ? `<span class="chip" style="background:#fff7ed;border:1px solid #fdba74;color:#9a3412"><i class="fas fa-triangle-exclamation" style="margin-right:6px;"></i> ${violationCount} integrity violation${violationCount===1?'':'s'}</span>` : ``}
                            </div>
                            ${wasAutoSubmitted ? `<div style="color:#9a3412;font-weight:800;margin-top:2px">This attempt was auto-submitted after repeated focus/fullscreen violations.</div>` : ``}
                            <div style="color:#334155;margin-top:6px">
                                ${passed === false ? 'You can review your attempt below. (Correct answers are hidden until you pass)' : 'You can review your answers below.'}
                            </div>
                            <div style="display:flex;gap:10px;margin-top:6px">
                              <button id="examReview" class="btn-blue" style="padding:10px 16px;border-radius:12px">Review Assessment</button>
                              ${retakeButtonHtml}
                            </div>
                          </div>`;
                        const gauge = resultBox.querySelector('#examGaugePath');
                        if(gauge && gauge.getTotalLength){
                            const L = gauge.getTotalLength();
                            const frac = Math.max(0, Math.min(1, finalPct/100));
                            gauge.setAttribute('stroke-dasharray', `${L} ${L}`);
                            gauge.setAttribute('stroke-dashoffset', String((1-frac)*L));
                        }
                        if(bodyBox){ bodyBox.style.display='none'; }
                        // No reset action; only allow review
                        const rv = document.getElementById('examReview');
                        if(rv){
                          rv.onclick = ()=>{
                            resultBox.style.display='none';
                            if(bodyBox){ bodyBox.style.display=''; }
                            // Only show correct answers if passed OR if trainer (trainer should always see answers)
                            const showCorrect = IS_TRAINER || passed === true;
                            revealAnswers(showCorrect);
                            // Create/show Back button for review mode
                            let topBar = document.getElementById('reviewTopBar');
                            if(!topBar && bodyBox){
                                topBar = document.createElement('div');
                                topBar.id = 'reviewTopBar';
                                topBar.style.cssText = 'position:sticky;top:0;z-index:60;display:none;padding:8px 0;margin-bottom:8px;background:linear-gradient(180deg,#f8fbff 0%, #ffffff 100%);border-bottom:1px solid #e5e7eb';
                                topBar.innerHTML = '<button id="reviewBackBtn" class="btn-ghost" style="padding:8px 12px;border-radius:10px;border:1px solid #dbe4ef;background:#fff;font-weight:800;display:inline-flex;align-items:center;gap:8px"><i class="fas fa-arrow-left"></i> Back</button>';
                                bodyBox.prepend(topBar);
                            }
                            if(topBar){ 
                                topBar.style.display='block'; 
                                const backBtn = topBar.querySelector('#reviewBackBtn');
                                if(backBtn){
                                    backBtn.onclick = ()=>{
                                        if(resultBox){ resultBox.style.display='block'; }
                                        if(bodyBox){ bodyBox.style.display='none'; }
                                        topBar.style.display='none';
                                        try{ resultBox.scrollIntoView({behavior:'smooth', block:'start'}); }catch(_){}
                                    };
                                }
                            }
                          };
                        }
                        const retakeBtn = document.getElementById('examRetake');
                        if(retakeBtn){
                            retakeBtn.onclick = async ()=>{
                                retakeBtn.disabled = true;
                                retakeBtn.textContent = 'Preparing...';
                                try{
                                    const resp = await fetch("{{ route('courses.module-exam.restart', $course) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        credentials: 'same-origin',
                                        body: JSON.stringify({ mi })
                                    });
                                    const data = await resp.json().catch(()=>null);
                                    if(data?.ok){
                                        prepareExamRetake();
                                        // Return to the exam start gate so fullscreen only begins on explicit Start.
                                        try {
                                            localStorage.removeItem(keyBase + '_started');
                                            localStorage.removeItem(keyBase + '_start');
                                        } catch (e) {}
                                        return;
                                    }
                                    if(data?.error){
                                        alert(data.error);
                                    }
                                }catch(e){
                                    alert('Failed to start exam retake.');
                                }
                                retakeBtn.disabled = false;
                                retakeBtn.textContent = 'Retake Exam';
                            };
                        }

                        const requestRetakeBtn = document.getElementById('examRequestRetake');
                        if (requestRetakeBtn) {
                            requestRetakeBtn.onclick = async () => {
                                requestRetakeBtn.disabled = true;
                                requestRetakeBtn.textContent = 'Requesting...';
                                try {
                                    const resp = await fetch("{{ route('courses.module-exam.request-retake', $course) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        credentials: 'same-origin',
                                        body: JSON.stringify({ mi })
                                    });
                                    const data = await resp.json().catch(() => null);
                                    if (data?.ok) {
                                        renderExamSummary({...summary, retake_requested: true, retake_approved: false});
                                    } else {
                                        alert(data?.error || 'Failed to request retake.');
                                        requestRetakeBtn.disabled = false;
                                        requestRetakeBtn.textContent = 'Request Retake';
                                    }
                                } catch (e) {
                                    alert('Failed to request retake.');
                                    requestRetakeBtn.disabled = false;
                                    requestRetakeBtn.textContent = 'Request Retake';
                                }
                            };
                        }
                }
                function revealAnswers(showCorrect = false){
                    // Show correct answers in-body and lock interactions
                    const blocks = Array.from(bodyBox.querySelectorAll('.field.question'));
                    let ua = null;
                    try{ ua = JSON.parse(localStorage.getItem(keyBase+'_answers')||'[]'); }catch(e){ ua = []; }
                    blocks.forEach((b, i)=>{
                        const q = qs[i] || {};
                        const kind = (q.type||'multiple_choice');
                        b.style.pointerEvents = 'none';
                        if(isMultipleChoiceQuestion(kind)){
                            const correctIndexes = mcCorrectIndexes(q);
                            const mc = b.querySelector('.mc');
                            if(mc!=null && correctIndexes.length){
                                if(showCorrect){
                                    correctIndexes.forEach(ans => {
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
                                    });
                                }
                                // Mark user's selected answer and correctness
                                const selectedIndexes = Array.isArray(ua?.[i]) ? ua[i] : (Number.isInteger(ua?.[i]) ? [ua[i]] : []);
                                if(selectedIndexes.length){
                                    const correctSet = new Set(correctIndexes);
                                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                                    selectedIndexes.forEach(selIdx => {
                                        const opt = mc.querySelector(`.mc-option[data-idx="${selIdx}"]`);
                                        if(opt){
                                            opt.classList.add('selected');
                                            opt.classList.add(correctSet.has(selIdx) ? 'submitted-correct' : 'submitted-wrong');
                                        }
                                    });
                                }
                            }
                        } else if(kind==='true_false'){
                            const val = q.answer===true ? 'true' : (q.answer===false ? 'false' : '');
                            const tf = b.querySelector('.tf');
                            if(tf && val){
                                if(showCorrect){
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
                            const response = latestExamSummary?.items?.find?.(item => Number(item.question_index) === i && item.type === 'identification') || null;
                            const inp=b.querySelector('.q-input');
                            const your = (Array.isArray(ua) && ua[i]) ? String(ua[i]) : '';
                            if(inp){
                                inp.disabled = true;
                                inp.value = your;
                            }
                            const info = document.createElement('div');
                            info.className='muted';
                            info.style.marginTop='8px';
                            const feedback = response?.feedback ? `<div style="margin-top:6px"><b>Teacher feedback:</b> ${response.feedback}</div>` : '';
                            const scoreInfo = response?.status === 'checked'
                                ? `<div><span class="chip">Checked</span> ${response.score ?? 0}/${response.max_points ?? 1}</div>`
                                : '<div><span class="chip">Pending Review</span> Identification is checked manually.</div>';
                            info.innerHTML = `${scoreInfo}${feedback}`;
                            b.appendChild(info);
                        } else if(kind==='enumeration'){
                            const response = latestExamSummary?.items?.find?.(item => Number(item.question_index) === i && item.type === 'enumeration') || null;
                            const inputs = Array.from(b.querySelectorAll('.enum-input'));
                            const yourAnswers = Array.isArray(ua?.[i]) ? ua[i] : [];
                            inputs.forEach((input, idx)=>{
                                input.disabled = true;
                                input.value = yourAnswers[idx] || '';
                            });
                            const info = document.createElement('div');
                            info.className='muted';
                            info.style.marginTop='8px';
                            const scoreLine = response
                                ? (response.status === 'checked'
                                    ? `<div><span class="chip">Checked</span> ${response.score ?? 0}/${response.max_points ?? 1}</div>`
                                    : '<div><span class="chip">Pending Review</span> Enumeration is checked manually.</div>')
                                : '<div><span class="chip">Pending Review</span> Enumeration is checked manually.</div>';
                            const feedback = response?.feedback ? `<div style="margin-top:6px"><b>Teacher feedback:</b> ${response.feedback}</div>` : '';
                            info.innerHTML = `${scoreLine}${feedback}`;
                            b.appendChild(info);
                        } else if(kind==='essay'){
                            const response = latestExamSummary?.items?.find?.(item => Number(item.question_index) === i && item.type === 'essay') || null;
                            const textarea = b.querySelector('.q-input');
                            if(textarea){
                                textarea.disabled = true;
                                if(Array.isArray(ua) && typeof ua[i] === 'string'){
                                    textarea.value = ua[i];
                                }
                            }
                            const info = document.createElement('div');
                            info.className='muted';
                            info.style.marginTop='8px';
                            const feedback = response?.feedback ? `<div style="margin-top:6px"><b>Teacher feedback:</b> ${response.feedback}</div>` : '';
                            const scoreInfo = response?.status === 'checked'
                                ? `<div><span class="chip">Checked</span> ${response.score ?? 0}/${response.max_points ?? 1}</div>`
                                : '<div><span class="chip">Pending Review</span> Essay is checked manually.</div>';
                            info.innerHTML = `${scoreInfo}${feedback}`;
                            b.appendChild(info);
                        }
                    });
                }
                if(closeBtn){
                    closeBtn.onclick = async ()=>{
                        // Back to outline and reset started state (but keep answers)
                        disableExamMonitoring();
                        suppressNextVisibilityViolation = true;
                        await exitExamFullscreen();
                        setTimeout(()=>{ suppressNextVisibilityViolation = false; }, 400);
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
                        }else if(kind==='enum'){
                            const vals = Array.from(b.querySelectorAll('.enum-input')).map(inp => (inp?.value || '').trim()).filter(Boolean);
                            if(vals.length) answered++;
                        }else if(kind==='essay'){
                            const val=(b.querySelector('.q-input')?.value||'').trim(); if(val) answered++;
                        }else if(kind==='tf'){
                            const sel=b.querySelector('.tf .tf-option.selected'); if(sel) answered++;
                        }
                    });
                    const total=blocks.length;
                    const el=document.getElementById('examConfirmSummary');
                    if(el){ el.innerHTML = `You answered <b>${answered}/${total}</b> items. Submit now?`; }
                }
                function findMissingExamAnswer(){
                    const blocks = Array.from(bodyEl.querySelectorAll('.field.question'));
                    for(let i = 0; i < blocks.length; i++){
                        const b = blocks[i];
                        const kind = b.getAttribute('data-kind') || 'mc';
                        if(kind === 'mc'){
                            const sel = b.querySelector('.mc .mc-option.selected');
                            if(!sel) return `Question ${i + 1} has no selected answer.`;
                        }else if(kind === 'id'){
                            const val = (b.querySelector('.q-input')?.value || '').trim();
                            if(!val) return `Question ${i + 1} is blank.`;
                        }else if(kind === 'enum'){
                            const vals = Array.from(b.querySelectorAll('.enum-input')).map(inp => (inp?.value || '').trim());
                            if(vals.some(v => !v)) return `Question ${i + 1} needs all enumeration answers filled in.`;
                        }else if(kind === 'essay'){
                            const val = (b.querySelector('.q-input')?.value || '').trim();
                            if(!val) return `Question ${i + 1} essay answer cannot be empty.`;
                        }else if(kind === 'tf'){
                            const sel = b.querySelector('.tf .tf-option.selected');
                            if(!sel) return `Question ${i + 1} has no selected answer.`;
                        }
                    }
                    return null;
                }
                if(submitAll){
                    submitAll.onclick = ()=>{
                        const missingMessage = findMissingExamAnswer();
                        if(missingMessage){
                            alert(missingMessage);
                            return;
                        }
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
                function showExamLoading(){
                    disableExamMonitoring();
                    if(resultBox){ resultBox.style.display='none'; }
                    if(prefaceBox){ prefaceBox.style.display='none'; }
                    if(bodyBox){ bodyBox.style.display='none'; }
                    if(loadingBox){ loadingBox.style.display=''; }
                }
                function hideExamLoading(){
                    if(loadingBox){ loadingBox.style.display='none'; }
                }
                function showExamPreface(){
                    disableExamMonitoring();
                    hideExamLoading();
                    if(resultBox){ resultBox.style.display='none'; }
                    if(prefaceBox){ prefaceBox.style.display=''; }
                    if(bodyBox){ bodyBox.style.display='none'; }
                }
                function showExamBody(){
                    hideExamLoading();
                    if(prefaceBox) prefaceBox.style.display='none';
                    if(bodyBox) bodyBox.style.display='';
                    enableExamMonitoring();
                }
                function prepareExamRetake(){
                    try{
                        localStorage.removeItem(keyBase+'_answers');
                        localStorage.removeItem(keyBase+'_submitted');
                        localStorage.removeItem(keyBase+'_started');
                        localStorage.removeItem(keyBase+'_start');
                        localStorage.setItem(keyBase+'_retake_mode', '1');
                    }catch(e){}
                    resetExamIntegrity();
                    disableExamMonitoring();
                    latestExamSummary = null;
                    setFrozen(false);
                    try{
                        // 1. Clear text inputs and textareas
                        bodyBox.querySelectorAll('input[type="text"], textarea').forEach(inp => { 
                            inp.value = ''; 
                            inp.disabled = false;
                        });
                        
                        // 2. Clear radio buttons if any (though we use classes)
                        bodyBox.querySelectorAll('input[type="radio"]').forEach(inp => { 
                            inp.checked = false; 
                        });

                        // 3. Clear multiple choice and true/false selections and classes
                        bodyBox.querySelectorAll('.mc-option, .tf-option').forEach(opt => {
                            opt.classList.remove('selected', 'trainer-answer', 'submitted-correct', 'submitted-wrong');
                            // Remove any dynamically added "Answer" chips
                            const chip = opt.querySelector('.chip');
                            if (chip) chip.remove();
                        });

                        // 4. Remove any dynamically added feedback or status elements
                        bodyBox.querySelectorAll('.field.question').forEach(q => {
                            q.style.pointerEvents = 'auto';
                            // Remove extra info added during revealAnswers (identification/enumeration/essay feedback)
                            const extraInfo = q.querySelectorAll('.muted, div[style*="color"]');
                            extraInfo.forEach(info => {
                                // Only remove if it was added dynamically (not part of original question structure)
                                if (info.parentElement === q && !info.classList.contains('q-title')) {
                                    info.remove();
                                }
                            });
                        });

                        // 5. Hide the top bar from review mode if it exists
                        const topBar = document.getElementById('reviewTopBar');
                        if (topBar) topBar.style.display = 'none';

                    }catch(e){
                        console.error('Error clearing exam for retake:', e);
                    }
                    if(submitAll){
                        submitAll.disabled = false;
                        submitAll.textContent = 'Submit Exam';
                    }
                    if(resultBox){ resultBox.style.display='none'; }
                    showExamPreface();
                }
                function markAttemptAsSubmitted(summary){
                    try{
                        localStorage.setItem(keyBase+'_submitted','1');
                        localStorage.removeItem(keyBase+'_retake_mode');
                        localStorage.removeItem(keyBase+'_started');
                        localStorage.removeItem(keyBase+'_start');
                    }catch(e){}
                    disableExamMonitoring();
                    hideExamLoading();
                    if(submitAll){ submitAll.disabled = true; submitAll.textContent = 'Submitted'; }
                    setFrozen(true);
                    if(prefaceBox){ prefaceBox.style.display='none'; }
                    if(bodyBox){ bodyBox.style.display='none'; }
                    if(resultBox){ renderExamSummary(summary); }
                    const tEl = document.getElementById('examTimer');
                    if(tEl){ tEl.textContent = 'Done'; }
                    if(timerIv){ clearInterval(timerIv); timerIv = null; }
                }
                function loadExistingAttempt(){
                    return fetch("{{ url('/courses/'.$course->id.'/module-exam/attempt') }}?mi="+encodeURIComponent(mi), {credentials:'same-origin'})
                        .then(r=>r.json())
                        .then(j=>{
                            if(j && j.ok && j.attempt){
                                markAttemptAsSubmitted(j.attempt);
                                return true;
                            } else {
                                // Force cleanup if server says no attempt but localStorage says yes
                                if (localStorage.getItem(keyBase+'_submitted') === '1') {
                                    console.log('Server has no record, but localStorage says submitted. Forcing reset...');
                                    localStorage.removeItem(keyBase+'_submitted');
                                    localStorage.removeItem(keyBase+'_answers');
                                    localStorage.removeItem(keyBase+'_started');
                                    localStorage.removeItem(keyBase+'_start');
                                }
                            }
                            return false;
                        })
                        .catch(()=>false);
                }
                const startBtn = document.getElementById('examStart');
                if(startBtn){
                    console.log('Start button found, attaching event listener.');
                    startBtn.addEventListener('click', async () => {
                        console.log('Start Exam button clicked!');
                        if(localStorage.getItem(keyBase+'_submitted')==='1'){ 
                            console.log('Exam already submitted according to localStorage.');
                            return; 
                        }
                        
                        resetExamIntegrity();
                        const enteredFullscreen = await requestExamFullscreen();
                        console.log('Entered Fullscreen Result:', enteredFullscreen);
                        
                        showExamBody();
                        try{
                            localStorage.removeItem(keyBase+'_retake_mode');
                            localStorage.setItem(keyBase+'_started','1');
                            if(!localStorage.getItem(keyBase+'_start')) localStorage.setItem(keyBase+'_start', String(Date.now()));
                        }catch(e){
                            console.error('Error updating localStorage:', e);
                        }
                        
                        if(!enteredFullscreen){
                            console.warn('Fullscreen was not entered, triggering violation.');
                            setTimeout(()=>{ triggerExamViolation('fullscreen_required'); }, 120);
                        }
                    });
                } else {
                    console.error('Start button (examStart) not found in the DOM.');
                }
                showExamLoading();
                loadExistingAttempt().then(foundAttempt=>{
                    if(foundAttempt){ return; }
                    const submitted = localStorage.getItem(keyBase+'_submitted')==='1';
                    const retakeMode = localStorage.getItem(keyBase+'_retake_mode')==='1';
                    const started = !submitted && localStorage.getItem(keyBase+'_started')==='1';
                    if(retakeMode){
                        showExamPreface();
                    }
                    else if(started){
                        showExamBody();
                    }
                    else {
                        showExamPreface();
                    }
                }).catch(()=>{
                    showExamPreface();
                });
                if(timerMins>0 && timerMode === 'timed'){
                    const tEl = document.getElementById('examTimer');
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
                        if(localStorage.getItem(keyBase+'_submitted')==='1'){
                            if(tEl){ tEl.textContent = 'Done'; }
                            if(timerIv){ clearInterval(timerIv); timerIv = null; }
                            return;
                        }
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
            } else {
                const bodyBox = document.getElementById('examBody');
                if(bodyBox){ bodyBox.style.display=''; }
                // Wire trainer results button
                const btn = document.getElementById('examResultsBtn');
                if(btn){
                    btn.addEventListener('click', ()=>{
                        let wrap = document.getElementById('examResultsWrap');
                        if(!wrap){
                            wrap = document.createElement('div');
                            wrap.id = 'examResultsWrap';
                            wrap.style.cssText='margin:12px 0;padding:12px;border:1px solid #e5e7eb;border-radius:12px;background:#f8fafc';
                            bodyEl.prepend(wrap);
                        }
                        wrap.innerHTML = '<div class="muted">Loading results…</div>';
                        fetch("{{ url('/courses/'.$course->id.'/module-exam/results') }}?mi="+encodeURIComponent(mi), {credentials:'same-origin'})
                            .then(r=>r.json()).then(j=>{
                                if(!j || !j.ok || !Array.isArray(j.items) || j.items.length===0){
                                    wrap.innerHTML = '<div class="muted">No submissions yet.</div>'; return;
                                }
                                const rows = j.items.map(it=>`<tr>
                                  <td>${esc(it.name||'')}</td>
                                  <td>${esc(it.email||'')}</td>
                                  <td style="text-align:right;font-weight:800">${it.pct}%</td>
                                  <td>${esc((it.correct||0)+'/'+(it.total||0))}</td>
                                  <td>${esc(it.status_label||'Completed')}</td>
                                  <td>${it.violation_count ? `<span class="chip" style="background:#fff7ed;border:1px solid #fdba74;color:#9a3412">${it.violation_count}${it.auto_submitted ? ' auto' : ''}</span>` : '<span class="muted">0</span>'}</td>
                                  <td>${esc((it.submitted_at||'').replace('T',' ').replace('Z',''))}</td>
                                  <td style="text-align:right"><button type="button" class="btn-ghost trainer-review-btn" data-user-id="${it.user_id}" style="padding:8px 12px;border-radius:10px;border:1px solid #dbe4ef;background:#fff;font-weight:800">Review</button></td>
                                </tr>`).join('');
                                wrap.innerHTML = '<div style="font-weight:800;margin-bottom:6px">Module Exam Results</div>'
                                  + '<div style="overflow:auto"><table style="width:100%;border-collapse:collapse">'
                                  + '<thead><tr style="text-align:left;border-bottom:1px solid #e5e7eb"><th>Name</th><th>Email</th><th>Score</th><th>Objective</th><th>Status</th><th>Integrity</th><th>Submitted</th><th></th></tr></thead>'
                                  + '<tbody>'+rows+'</tbody></table></div>';
                                wrap.querySelectorAll('.trainer-review-btn').forEach(reviewBtn=>{
                                    reviewBtn.addEventListener('click', ()=>{
                                        const targetUserId = reviewBtn.getAttribute('data-user-id');
                                        const panelId = 'essayReviewPanel_'+targetUserId;
                                        let panel = wrap.querySelector('#'+panelId);
                                        if(panel){ panel.remove(); return; }
                                        panel = document.createElement('div');
                                        panel.id = panelId;
                                        panel.style.cssText = 'margin-top:12px;padding:14px;border:1px solid #dbe4ef;border-radius:14px;background:#ffffff';
                                        panel.innerHTML = '<div class="muted">Loading submission…</div>';
                                        wrap.appendChild(panel);
                                        fetch("{{ url('/courses/'.$course->id.'/module-exam/attempt') }}?mi="+encodeURIComponent(mi)+'&user_id='+encodeURIComponent(targetUserId), {credentials:'same-origin'})
                                            .then(r=>r.json())
                                            .then(detail=>{
                                                if(!detail || !detail.ok || !detail.attempt){
                                                    panel.innerHTML = '<div class="muted">Failed to load attempt.</div>';
                                                    return;
                                                }
                                                const attempt = detail.attempt;
                                                const manualItems = (attempt.items||[]).filter(item => isManualExamKind(item.type));
                                                if(!manualItems.length){
                                                    panel.innerHTML = '<div class="muted">This attempt has no manual-checking items.</div>';
                                                    return;
                                                }
                                                panel.innerHTML = `
                                                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px">
                                                        <div>
                                                            <div style="font-weight:800;color:#0f172a">${esc(attempt.user_name||'Trainee')}</div>
                                                            <div class="muted">${esc(attempt.user_email||'')}</div>
                                                        </div>
                                                        <div style="font-weight:800;color:#0f3b8f">${esc(attempt.status_label||'Pending Manual Review')}</div>
                                                    </div>
                                                    <div class="essay-review-list" style="display:grid;gap:12px;">
                                                        ${manualItems.map(item=>`
                                                            <div class="topic-detail-card" data-question-index="${item.question_index}">
                                                                <div style="font-size:0.75rem;font-weight:800;color:#2563eb;text-transform:uppercase;margin-bottom:6px">${manualExamKindLabel(item.type)} Question ${Number(item.question_index)+1}</div>
                                                                <div style="font-size:0.95rem;font-weight:700;color:#1e293b;margin-bottom:10px">${esc(item.text||'Question')}</div>
                                                                <div style="margin-bottom:10px;padding:12px;border:1px solid #e5e7eb;border-radius:10px;background:#f8fafc;white-space:pre-wrap">${esc(item.answer_text||'No answer submitted.')}</div>
                                                                <div style="display:grid;grid-template-columns:minmax(140px,180px) 1fr;gap:12px;align-items:start">
                                                                    <label style="display:grid;gap:6px">
                                                                        <span style="font-size:0.8rem;font-weight:700;color:#475569">Score / ${item.max_points ?? 1}</span>
                                                                        <input type="number" min="0" max="${item.max_points ?? 1}" step="0.01" class="essay-score-input input" value="${item.score ?? ''}">
                                                                    </label>
                                                                    <label style="display:grid;gap:6px">
                                                                        <span style="font-size:0.8rem;font-weight:700;color:#475569">Feedback</span>
                                                                        <textarea class="essay-feedback-input input" rows="3" placeholder="Optional feedback">${esc(item.feedback||'')}</textarea>
                                                                    </label>
                                                                </div>
                                                                <div style="margin-top:8px;font-size:0.82rem;font-weight:700;color:${item.status==='checked' ? '#166534' : '#b45309'}">${item.status==='checked' ? 'Checked' : 'Pending Review'}</div>
                                                            </div>
                                                        `).join('')}
                                                    </div>
                                                    <div style="display:flex;justify-content:flex-end;margin-top:14px">
                                                        <button type="button" class="btn-blue essay-review-save" style="padding:10px 16px;border-radius:12px">Save Manual Review</button>
                                                    </div>
                                                `;
                                                const saveBtn = panel.querySelector('.essay-review-save');
                                                if(saveBtn){
                                                    saveBtn.addEventListener('click', ()=>{
                                                        const reviewCards = Array.from(panel.querySelectorAll('[data-question-index]'));
                                                        const reviews = [];
                                                        for (const card of reviewCards) {
                                                            const scoreInput = card.querySelector('.essay-score-input');
                                                            const rawValue = scoreInput?.value ?? '';
                                                            const score = Number(rawValue || 0);
                                                            const max = Number(scoreInput?.getAttribute('max') || 1);
                                                            if (!Number.isFinite(score) || score < 0) {
                                                                alert('Manual score must be 0 or higher.');
                                                                scoreInput?.focus();
                                                                return;
                                                            }
                                                            if (Number.isFinite(max) && score > max) {
                                                                alert(`Manual score cannot exceed ${max}.`);
                                                                scoreInput?.focus();
                                                                return;
                                                            }
                                                            reviews.push({
                                                                question_index: Number(card.getAttribute('data-question-index')),
                                                                score,
                                                                feedback: card.querySelector('.essay-feedback-input')?.value || ''
                                                            });
                                                        }
                                                        saveBtn.disabled = true;
                                                        saveBtn.textContent = 'Saving...';
                                                        fetch("{{ url('/courses/'.$course->id.'/module-exam/review') }}", {
                                                            method:'POST',
                                                            credentials:'same-origin',
                                                            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                                                            body: JSON.stringify({mi: mi, user_id: Number(targetUserId), reviews})
                                                        }).then(async r=>{
                                                            const saved = await r.json().catch(()=>null);
                                                            if(saved && saved.ok){
                                                                panel.insertAdjacentHTML('afterbegin', '<div style="margin-bottom:12px;padding:10px 12px;border:1px solid #86efac;border-radius:10px;background:#f0fdf4;color:#166534;font-weight:800">Manual review saved.</div>');
                                                                btn.click();
                                                                btn.click();
                                                            }else{
                                                                alert(saved && saved.error ? saved.error : 'Failed to save manual review.');
                                                            }
                                                        }).catch(()=>{
                                                            alert('Failed to save manual review.');
                                                        }).finally(()=>{
                                                            saveBtn.disabled = false;
                                                            saveBtn.textContent = 'Save Manual Review';
                                                        });
                                                    });
                                                }
                                            })
                                            .catch(()=>{
                                                panel.innerHTML = '<div class="muted">Failed to load submission.</div>';
                                            });
                                    });
                                });
                            }).catch(()=>{ wrap.innerHTML = '<div class="muted">Failed to load results.</div>'; });
                    });
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
                s = s.replace(/<(img|source|iframe)[^>]+(src|href)=["']https?:\/\/[^"']*googleusercontent\.com[^"']*["'][^>]*>/gi,'');
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
                    const kind = (q.type||'multiple_choice');
                    const options = Array.isArray(q.options) ? q.options : [];
                    if(!IS_TRAINER && ['multiple_choice', 'multiple_choice_single', 'multiple_choice_multiple'].includes(kind) && options.length === 0){
                        return '';
                    }
                    const typeLabel = (function(){
                        if(kind==='multiple_choice_multiple') return 'Multiple Choice (Multiple Answers)';
                        if(kind==='multiple_choice_single' || kind==='multiple_choice') return 'Multiple Choice (Single Answer)';
                        if(kind==='true_false') return 'True/False';
                        if(kind==='identification') return 'Identification';
                        if(kind==='enumeration') return 'Enumeration';
                        if(kind==='essay') return 'Essay';
                        if(!kind) return 'Question';
                        return String(kind).replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase());
                    })();
                    const qTitle = `<div class="q-title"><span class="q-title-text">${q.title||'Question'}</span><span class="qtype-pill">${typeLabel}</span></div>`;
                    const isMultipleAnswer = kind === 'multiple_choice_multiple';
                    const correctIndexes = (function(){
                        let raw = Array.isArray(q.correct_answers) ? q.correct_answers.slice() : [];
                        if(!raw.length && q.correct_answer !== undefined && q.correct_answer !== null && q.correct_answer !== '') raw = [q.correct_answer];
                        if(!raw.length && q.answer_index !== undefined && q.answer_index !== null && q.answer_index !== '') raw = [q.answer_index];
                        return Array.from(new Set(raw.map(value => {
                            if(!isNaN(Number(value))) return Number(value);
                            const text = String(value || '').trim();
                            if(/^[A-Za-z]$/.test(text)) return text.toUpperCase().charCodeAt(0) - 65;
                            return options.findIndex(choice => String(choice || '').trim().toLowerCase() === text.toLowerCase());
                        }).filter(index => Number.isInteger(index) && index >= 0 && index < options.length)));
                    })();
                    const answer = correctIndexes.join(',');
                    const fbC = q.feedback_correct || '';
                    const fbI = q.feedback_incorrect || '';
                    const opts=options.map((o,idx)=>{
                        const isAns = (IS_TRAINER && correctIndexes.includes(idx));
                        const chip = isAns ? '<span class="chip">Answer</span>' : '';
                        return `<div class="mc-option${isAns?' trainer-answer':''}" data-idx="${idx}"><span class="mc-radio"></span><span class="mc-label">${o}</span> ${chip}</div>`;
                    }).join('');
                    const mcMode = isMultipleAnswer ? 'multiple_choice_multiple' : 'multiple_choice_single';
                    const helper = isMultipleAnswer ? '<div class="muted" style="margin-bottom:8px">Select all that apply.</div>' : '';
                    if(viewOnly){
                        return `<div class="field question" data-kind="mc">
                            ${qTitle}
                            ${helper}
                            <div class="mc" data-mode="${mcMode}" data-answer="${answer}">${opts}</div>
                        </div>`;
                    } else {
                        if(['multiple_choice', 'multiple_choice_single', 'multiple_choice_multiple'].includes(kind)){
                            return `<div class="field question" data-kind="mc">
                                ${qTitle}
                                ${helper}
                                <div class="mc" data-mode="${mcMode}" data-answer="${answer}" data-fb-correct="${fbC?.replace?.(/"/g,'&quot;') || ''}" data-fb-incorrect="${fbI?.replace?.(/"/g,'&quot;') || ''}">${opts}</div>
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
                                    ${qTitle}
                                    <div>${list}</div>
                                </div>`;
                            } else {
                                const dataAns = String(JSON.stringify(idAnswers)).replace(/"/g,'&quot;');
                                return `<div class="field question" data-kind="id">
                                    ${qTitle}
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
                                    ${qTitle}
                                    ${essayAns ? `<div style="margin-bottom:6px"><span class="chip">Answer</span> ${essayAns}</div>` : '<div class="muted" style="margin-bottom:6px">No answer provided</div>'}
                                    ${rubric ? `<div><span class="chip">Rubric</span> ${rubric}</div>` : ''}
                                </div>`;
                            } else {
                                return `<div class="field question" data-kind="essay">
                                    ${qTitle}
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
                                ${qTitle}
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
                            return `<div class="field question">${qTitle}</div>`;
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
            // Ensure a reflection block only for TOPIC-level content (no subtopics)
            if(!viewOnly && (typeof si==='undefined' || si===null)){
                const hasRef = Array.isArray(fields) && fields.some(f => f && f.type === 'reflection');
                if(!hasRef){
                    const key = `${mi}_${ti}_-1`;
                    container.innerHTML += `
                        <div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="-1">
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
                    const key = `${bMi}_${bTi}_${(isNaN(bSi)?-1:bSi)}`;
                    // Initialize state if already submitted; prefill text if available
                    if(hasReflection(bMi,bTi,bSi)){
                        const prev = reflectionMap[key] || reflectionMap[`${bMi}_${bTi}_-1`];
                        if(input && prev && typeof prev==='object' && prev.learned){ input.value = prev.learned; }
                        if(submitBtn){ submitBtn.textContent = 'Submitted'; submitBtn.disabled = true; }
                        if(input){ input.disabled = true; }
                        if(summary && prev && typeof prev==='object' && prev.submitted){
                            summary.style.display='block';
                            summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                <div><b>What you learned:</b> ${prev.learned ? prev.learned : '(none)'}</div>`;
                        }
                    }
                    if(submitBtn){
                        submitBtn.onclick = async ()=>{
                            const containerEl = document.getElementById('contentBody');
                            const ready = areAllQuestionsSubmitted(containerEl);
                            if(!ready){
                                var ov=document.getElementById('gateOverlay');
                                if(ov){ ov.style.display='flex'; }
                                return;
                            }
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
                                        sub_index: (isNaN(bSi)?-1:bSi),
                                        questions,
                                        answers
                                    })
                                });
                                if(res.ok){
                                    markReflection(bMi,bTi,bSi);
                                    setSubtopicDone(bMi,bTi,bSi,true);
                                    const tEl = document.querySelector(`.topic[data-mi="${bMi}"][data-ti="${bTi}"]`);
                                    if(tEl){ renderDoneStates(bMi,bTi,tEl); updateProgressFor(bMi); }
                                    recalculateClientAccessState();
                                    await syncServerAccessState();
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
                                            recalculateClientAccessState();
                                            syncServerAccessState();
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
                if(res.ok){ const j = await res.json(); reflectionMap = j.map || {}; updateAllProgress(); recalculateClientAccessState(); await syncServerAccessState(); }
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
        function promptCatchUpReflections(mi){ /* deprecated for topic-level reflections */ }
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
                        await syncServerAccessState();
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
            const isMultipleAnswer = mc.dataset.mode === 'multiple_choice_multiple';
            const answers = String(answerStr || '')
                .split(',')
                .map(v => parseInt(v, 10))
                .filter(v => Number.isInteger(v));
            const submitBtn = block.querySelector('[data-act="submit"]');
            const resetBtn = block.querySelector('[data-act="reset"]');
            const feedbackBtn = block.querySelector('[data-act="feedback"]');
            const correctBtn = null;
            const selectedIndexes = () => Array.from(mc.querySelectorAll('.mc-option.selected'))
                .map(opt => parseInt(opt.getAttribute('data-idx'), 10))
                .filter(v => Number.isInteger(v));
            const syncChoiceLimit = () => {
                if(!isMultipleAnswer || !answers.length || mc.dataset.submitted === '1') return;
                const limitReached = selectedIndexes().length >= answers.length;
                mc.querySelectorAll('.mc-option').forEach(option => {
                    option.classList.toggle('choice-disabled', limitReached && !option.classList.contains('selected'));
                });
            };
            const selectedMatchesAnswers = () => {
                const selected = selectedIndexes().sort((a, b) => a - b);
                const expected = answers.slice().sort((a, b) => a - b);
                return selected.length === expected.length && selected.every((value, index) => value === expected[index]);
            };
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
                    if(isMultipleAnswer){
                        const limitReached = answers.length && selectedIndexes().length >= answers.length;
                        if(limitReached && !opt.classList.contains('selected')) return;
                        opt.classList.toggle('selected');
                    } else {
                        mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected'));
                        opt.classList.add('selected');
                    }
                    submitBtn.disabled = selectedIndexes().length === 0;
                    syncChoiceLimit();
                });
            });
            if(submitBtn){
                submitBtn.addEventListener('click', ()=>{
                    const selected = Array.from(mc.querySelectorAll('.mc-option.selected'));
                    if(!selected.length) return;
                    const isCorrect = answers.length ? selectedMatchesAnswers() : null;
                    setSubmitted(true);
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                    if(answers.length){
                        if(isCorrect){
                            selected.forEach(opt => opt.classList.add('submitted-correct'));
                            if(resetBtn) resetBtn.style.display='none';
                        } else {
                            selected.forEach(opt => opt.classList.add('submitted-wrong'));
                            if(resetBtn) resetBtn.style.display='inline-block';
                        }
                    } else {
                        if(resetBtn) resetBtn.style.display='none';
                    }
                });
            }
            if(resetBtn){
                resetBtn.addEventListener('click', ()=>{
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('selected','correct','choice-disabled'));
                    feedback.style.display='none'; feedback.textContent='';
                    submitBtn.disabled = true;
                    setSubmitted(false);
                    mc.querySelectorAll('.mc-option').forEach(o=>o.classList.remove('submitted-correct','submitted-wrong'));
                    if(resetBtn) resetBtn.style.display='none';
                });
            }
            if(feedbackBtn){
                feedbackBtn.addEventListener('click', ()=>{
                    if(!selectedIndexes().length){ feedback.textContent='Select an option first.'; feedback.style.display='block'; return; }
                    const fbC = mc.getAttribute('data-fb-correct') || '';
                    const fbI = mc.getAttribute('data-fb-incorrect') || '';
                    if(!answers.length){
                        feedback.textContent='Answer recorded.';
                    } else {
                        if(selectedMatchesAnswers()){
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
                    if(!mc || mc.querySelectorAll('.mc-option').length === 0) return true;
                    return !!mc && mc.dataset.submitted==='1';
                } else {
                    if(!b.querySelector('.q-input') && !b.querySelector('.tf-option')) return true;
                    return b.dataset.submitted==='1';
                }
            });
        }
        function updateReflectionGate(container){
            const ready = areAllQuestionsSubmitted(container);
            container.querySelectorAll('.reflection-inline').forEach(ref=>{
                const btn = ref.querySelector('[data-act="submit-ref"]');
                if(btn){ btn.disabled = !ready; }
            });
        }
        (function(){
            var close=document.getElementById('gateClose');
            var ov=document.getElementById('gateOverlay');
            if(close){ close.addEventListener('click', function(e){ e.preventDefault(); if(ov){ ov.style.display='none'; } }); }
            document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ if(ov){ ov.style.display='none'; } } });
        })();
        renderVideo();
        function getQueryParam(n){
            try{
                var u = new URLSearchParams(window.location.search);
                return u.get(n);
            }catch(e){ return null; }
        }
        (async function initPage(){
            if(!viewOnly){
                try{ await loadReflectionMap(); }catch(e){}
            }
            await renderOutline();
            // Ensure exam progress bars are not full by default and only fill on pass (>= 75 or passing_score)
            try{ await updateAllExamBars(); }catch(e){}
            let mi = parseInt(getQueryParam('mi')||'0', 10);
            if(!Number.isFinite(mi) || mi<0) mi = 0;
            const mods = Array.isArray(course.modules)?course.modules:[];
            if(mods[mi]){
                const isExamOnly = !!(mods[mi].exam && Array.isArray(mods[mi].exam.questions) && mods[mi].exam.questions.length) && (!Array.isArray(mods[mi].topics) || mods[mi].topics.length===0);
                const modEl = document.querySelectorAll('.module')[mi];
                const topicsCt = modEl ? modEl.querySelector('.topics') : null;
                if(topicsCt){ topicsCt.style.display='block'; }
                const chev = modEl ? modEl.querySelector('.toggle-icon i') : null; if(chev){ chev.style.transform='rotate(180deg)'; }
                if(isExamOnly){
                    openExam(mi);
                }else{
                    openTopic(mi,0);
                }
            } else {
                const firstTopic = (mods[0]&&mods[0].topics&&mods[0].topics[0])? [0,0]: null;
                if(firstTopic){ openTopic(0,0); }
            }
        })();
    </script>
    <div id="congratsModal" style="position:fixed;inset:0;background:rgba(0,0,0,.6);display:none;align-items:center;justify-content:center;z-index:3000;backdrop-filter:blur(4px);">
        <div style="background:#fff;border-radius:24px;width:min(500px,90vw);padding:40px;text-align:center;position:relative;z-index:3002;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="width:80px;height:80px;background:linear-gradient(135deg, #FFD700 0%, #FDB931 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 10px 15px -3px rgba(255, 215, 0, 0.3);">
                <i class="fas fa-trophy" style="font-size:40px;color:#fff;"></i>
            </div>
            <h2 style="font-size:2rem;font-weight:800;color:#1e293b;margin-bottom:8px;line-height:1.2;">Congratulations!</h2>
            <p style="color:#64748b;font-size:1.1rem;margin-bottom:24px;">You have successfully completed<br><strong style="color:#0f3b8f;">{{ $course->name }}</strong></p>
            <div style="background:#f8fafc;border-radius:12px;padding:16px;margin-bottom:32px;border:1px solid #e2e8f0;">
                <p style="margin:0;color:#475569;font-size:0.95rem;">Your certificate is now available.</p>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <a href="{{ route('dashboard', ['tab' => 'certificates']) }}" class="btn-blue" style="padding:14px;border-radius:12px;font-weight:700;text-decoration:none;display:block;font-size:1rem;text-align:center">
                    <i class="fas fa-certificate" style="margin-right:8px;"></i> View Certificate
                </a>
                <button type="button" onclick="document.getElementById('congratsModal').style.display='none'" style="background:transparent;border:none;color:#64748b;font-weight:600;cursor:pointer;padding:10px;">Close</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        function showCongrats() {
            const modal = document.getElementById('congratsModal');
            if(modal) {
                modal.style.display = 'flex';
                // Fire multiple bursts using global confetti
                const duration = 5 * 1000;
                const animationEnd = Date.now() + duration;
                const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 4000 };

                function randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                }

                const interval = setInterval(function() {
                    const timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    const particleCount = 50 * (timeLeft / duration);
                    // since particles fall down, start a bit higher than random
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
                    confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
                }, 250);

                // Add two big initial bursts from bottom corners
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: { y: 0.6, x: 0 },
                    zIndex: 4000
                });
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: { y: 0.6, x: 1 },
                    zIndex: 4000
                });
            }
        }
        
        // Check if we should show congrats on load (e.g. after redirect)
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('show_course_congrats_{{ $course->id }}') === '1') {
                showCongrats();
                localStorage.removeItem('show_course_congrats_{{ $course->id }}');
            }
        });
    </script>
</body>
</html>
