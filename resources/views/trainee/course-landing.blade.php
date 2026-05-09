<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} · Class</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('images/ddd-removebg-preview.png') }}">
    <link rel="preload" as="image" href="{{ asset('images/logo1.png') }}">
    <style>
        :root{
            --brand:#0d6efd;
            --brand-600:#2563eb;
            --bg:#f4f6f9;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;
            --chip:#0b3a88;
        }
        body{margin:0;background:var(--bg);color:var(--text);font-family:'DM Sans', sans-serif;}
        :root{--primary-blue:#002C76;--primary-green:#7fb73d;--dark-text:#333333;--light-text:#58585b;--bg-color:#f4f6f9;--sidebar-width:250px;--sidebar-collapsed-width:70px;--header-height:80px}
        .header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:var(--header-height);box-sizing:border-box;z-index:1000;position:fixed;top:0;left:var(--sidebar-width);right:0;transition:left .25s ease;will-change:left}
        .header-left{display:flex;align-items:center}
        .header-toggle,
        .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .header-toggle:hover,
        .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
        .header-right{display:flex;align-items:center;gap:15px}
        .header-section-title{margin-left:12px;font-size:1.08rem;color:var(--primary-blue);font-weight:700;letter-spacing:-.01em}
        .back-to-courses-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:10px 14px;color:var(--primary-blue);text-decoration:none;font-weight:800;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .back-to-courses-btn:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
        .back-to-courses-row{display:flex;align-items:center;justify-content:flex-start;margin:0 0 16px}
        .profile-menu{position:relative}
        .user-profile{display:flex;align-items:center;gap:10px;color:var(--dark-text)}
        .profile-dropdown{position:absolute;top:44px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        .dashboard-container{display:flex;flex:1;overflow:hidden;margin-top:var(--header-height);margin-left:var(--sidebar-width);height:calc(100vh - var(--header-height));transition:margin-left .25s ease;will-change:margin-left}
        /* Collapse sync: when body has sidebar-collapsed, shift header and container */
        body.sidebar-collapsed .header{ left: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .dashboard-container{ margin-left: var(--sidebar-collapsed-width); }
        .sidebar{width:var(--sidebar-width);background-color:var(--primary-blue);color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
        .sidebar.collapsed{width:var(--sidebar-collapsed-width)}
        .sidebar-toggle{background:none;border:none;color:#fff;padding:15px;cursor:pointer;text-align:right;font-size:1.2rem}
        .nav-menu{list-style:none;padding:0;margin:0;flex:1}
        .nav-item{border-bottom:none}
        .nav-link{display:flex;align-items:center;padding:12px 20px;color:rgba(255,255,255,.9);text-decoration:none;transition:background-color .2s ease,color .2s ease;cursor:pointer}
        .nav-link:hover,.nav-link.active{background-color:rgba(255,255,255,.12);color:#fff}
        .nav-icon{width:25px;font-size:1.1rem;text-align:center;margin-right:15px}
        .nav-text{display:inline}
        .sidebar.collapsed .nav-text{display:none}
        .sidebar.collapsed .nav-link{justify-content:center;padding:12px 0}
        .sidebar.collapsed .nav-icon{margin-right:0}
        .main-content{flex:1;padding:24px;overflow-y:auto;background:linear-gradient(180deg,#f7f9fc 0%,#f2f5fa 100%)}
        .back-link{display:inline-flex;align-items:center;color:var(--primary-blue);text-decoration:none;font-weight:500;cursor:pointer}
        .back-link i{margin-right:8px}
        :root{--app-sidebar-w:250px;--app-header-h:80px}
        .with-app-side{padding-left:var(--app-sidebar-w)}
        .side-collapsed{--app-sidebar-w:70px}
        .app-side{position:fixed;left:0;top:var(--app-header-h);bottom:0;width:var(--app-sidebar-w);background:#002C76;color:#fff;z-index:25;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,.12)}
        .app-side .app-side-header{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.12)}
        .app-side .app-initial{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.25);font-weight:800}
        .app-side a{color:rgba(255,255,255,.9);text-decoration:none;display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:none}
        .app-side a:hover{background:rgba(255,255,255,.08)}
        .app-side.collapsed .app-side-header div:nth-child(2){display:none}
        .app-side.collapsed a span{display:none}
        .app-side.collapsed a{justify-content:center}
        .app-side.collapsed .app-initial{margin:0 auto}
        @media (max-width: 900px){ .with-app-side{padding-left:0}.app-side{display:none}.app-side.side-open{display:flex;box-shadow:0 18px 38px rgba(0,0,0,.25)} }
        .app-header{background:#fff;min-height:80px;padding:10px 20px;box-shadow:0 2px 4px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:20}
        .app-header-left{display:flex;align-items:center;gap:12px}
        .app-header-logo{height:48px}
        .app-header-right a{color:#1a1a1a;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:6px}
        .page{max-width:1220px;margin:22px auto 42px;padding:0 18px}
        .hero{background:#fff;border:1px solid #dbe2ee;border-radius:18px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,.08)}
        .hero-top{position:relative;height:230px;background:#e9eef9;display:flex;align-items:center;justify-content:center}
        .hero-top img{width:100%;height:100%;object-fit:cover}
        .hero-edit{position:absolute;right:12px;bottom:12px;display:flex;gap:8px}
        .hero-btn{display:inline-flex;align-items:center;gap:6px;border:none;border-radius:12px;padding:8px 12px;font-weight:800;cursor:pointer;background:#0f3b8f;color:#fff;box-shadow:0 8px 18px rgba(15,23,42,.16)}
        .hero-btn.ghost{background:#fff;color:#0f3b8f;border:1px solid #cfe0ff}
        .hero-btn:hover{filter:brightness(1.05)}
        .img-modal{position:fixed;inset:0;background:rgba(15,23,42,.6);display:none;align-items:center;justify-content:center;z-index:70}
        .img-modal .wrap{width:92%;max-width:980px;background:#fff;border:1px solid #dbe4ef;border-radius:16px;box-shadow:0 22px 48px rgba(15,23,42,.25);overflow:hidden}
        .img-modal .head{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-bottom:1px solid #e5e7eb;background:#f8fafc}
        .img-modal .body{padding:12px;display:grid;grid-template-columns:2fr 1fr;gap:12px}
        .img-modal .foot{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-top:1px solid #e5e7eb;background:#f8fafc}
        .img-canvas{max-width:100%;max-height:60vh}
        .file-input{display:none}
        .preview-wrap{display:flex;flex-direction:column;gap:10px}
        .preview-label{font-weight:800;color:#0f3b8f}
        .ratio-bar{display:flex;flex-wrap:wrap;gap:8px}
        .ratio-btn{padding:8px 12px;border-radius:10px;border:1px solid #cfe0ff;background:#fff;color:#0f3b8f;font-weight:800;cursor:pointer}
        .ratio-btn.active{background:#0f3b8f;color:#fff;border-color:#0f3b8f}
        .img-preview{position:relative;width:100%;aspect-ratio:16/9;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;background:#f1f5f9}
        .img-preview::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(15,23,42,.08) 0%,rgba(15,23,42,.35) 100%);pointer-events:none}
        .hero-top::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(15,23,42,.08) 0%,rgba(15,23,42,.35) 100%);pointer-events:none}
        .chip{display:inline-flex;align-items:center;gap:6px;background:#eef2ff;color:#0f3b8f;border:1px solid #dbeafe;border-radius:999px;padding:6px 10px;font-weight:700}
        .hero-body{padding:20px 22px}
        .title{margin:6px 0 12px;font-size:2rem;letter-spacing:-0.02em;color:#0f3b8f;line-height:1.2}
        .tabs{display:inline-flex;gap:8px;margin:12px 0 0;padding:6px;background:#eef2ff;border-radius:12px;border:1px solid var(--border)}
        .tab{padding:10px 14px;border-radius:10px;border:1px solid transparent;background:transparent;cursor:pointer;color:#0f172a}
        .tab:hover{background:#fff;border-color:#e5e7eb}
        .tab.active{background:var(--brand);color:#fff;border-color:var(--brand);box-shadow:0 6px 12px rgba(13,110,253,0.25)}
        .content{margin-top:16px}
        .card{background:#fff;border:1px solid #dbe2ee;border-radius:16px;padding:18px;box-shadow:0 8px 24px rgba(15,23,42,.06)}
        .stream-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px dashed var(--border)}
        .stream-item:last-child{border-bottom:none}
        .avatar{width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f}
        .muted{color:var(--muted);font-size:.9rem}
        .split{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        @media (max-width: 900px){ .split{grid-template-columns:1fr} }
        .container-box{background:#fff;border:1px solid #dde5f1;border-radius:14px;padding:16px;box-shadow:0 4px 14px rgba(15,23,42,.04)}
        /* Outline CTA redesign */
        .outline-cta{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px;border:1px solid #dbe2ee;border-radius:16px;background:#fff;box-shadow:0 10px 28px rgba(15,23,42,.06)}
        .outline-cta .cta-left{display:flex;align-items:center;gap:14px}
        .outline-cta .cta-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#eef3ff 0%, #e6edff 100%);border:1px solid #cfe0ff;color:#0f3b8f}
        .outline-cta .cta-title{font-weight:900;color:#0f172a;letter-spacing:-.01em}
        .outline-cta .cta-desc{color:#64748b;margin-top:2px}
        .btn-cta{display:inline-flex;align-items:center;gap:8px;background:#0f3b8f;color:#fff;text-decoration:none;border:none;border-radius:12px;padding:12px 18px;font-weight:800;box-shadow:0 10px 24px rgba(15,23,42,.12);cursor:pointer}
        .btn-cta:hover{background:#0b2c74}
        .section-head{display:flex;align-items:center;gap:12px;margin-bottom:8px;font-weight:800;color:#0f3b8f}
        .ann-actions{display:flex;align-items:center;gap:12px;margin-bottom:10px}
        .chip-action{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:8px 12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
        .chip-stat{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:8px 12px;font-weight:700;display:inline-flex;align-items:center;gap:8px;cursor:default}
        .link-action{color:#0f3b8f;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-weight:600}
        .announce-card{background:#f3f7ff;border:1px solid #d9e4f7;border-radius:16px;overflow:hidden;box-shadow:0 4px 12px rgba(15,23,42,.05)}
        .announce-card{position:relative}
        .announce-head{display:flex;align-items:center;gap:10px;padding:12px 16px}
        .announce-ava{width:36px;height:36px;border-radius:50%;background:#d1e3ff;color:#144d9a;font-weight:700;display:flex;align-items:center;justify-content:center}
        .announce-meta .name{font-weight:700;color:#0f172a}
        .announce-meta .time{font-size:.85rem;color:var(--muted)}
        .announce-dots{margin-left:auto;color:#111;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer}
        .announce-dots:hover{background:#f3f4f6}
        .announce-body{padding:0 16px 12px 64px;color:#111}
        .dots-menu{position:absolute;top:36px;right:10px;background:#eef3fb;border:1px solid #dbe4f3;border-radius:12px;box-shadow:0 10px 24px rgba(0,0,0,.12);display:none;min-width:180px;z-index:1000;overflow:hidden}
        .dots-item{display:flex;align-items:center;gap:10px;padding:12px 16px;min-height:40px;color:#0f172a;text-decoration:none;font-weight:600;line-height:1.2}
        .dots-item i{color:#334155}
        .dots-item:hover{background:#e7eefb}
        .dots-menu button.dots-item{border:none;background:none;width:100%;text-align:left;cursor:pointer;font:inherit}
        .ann-list{max-height:none;overflow:visible}
        .ann-list.scrollable{max-height:600px;overflow-y:auto;padding-right:4px}
        .btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:12px 14px;font-weight:700;cursor:pointer}
        .btn-blue{background:var(--brand);color:#fff}
        .btn-blue:hover{background:var(--brand-600)}
        .people{display:grid;grid-template-columns: 1fr 1fr;gap:16px}
        .people ul{list-style:none;margin:0;padding:0}
        .people li{padding:10px;border:1px solid var(--border);border-radius:10px;margin-bottom:8px;background:#f8fafc}
        .participant-item-btn{width:100%;display:flex;align-items:center;gap:10px;padding:10px;border:1px solid var(--border);border-radius:10px;margin-bottom:8px;background:#f8fafc;color:#0f172a;cursor:pointer;text-align:left;font:inherit;transition:all .2s ease}
        .participant-item-btn:hover{background:#edf3ff;border-color:#c7d7f8}
        .participant-view-modal{width:460px;max-width:calc(100% - 30px);background:#fff;border:1px solid #dbe4ef;border-radius:14px;box-shadow:0 20px 45px rgba(15,23,42,.25);overflow:hidden}
        .participant-view-header{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #e5e7eb;background:#f8fafc}
        .participant-view-title{margin:0;font-size:1rem;color:#0f3b8f;font-weight:800}
        .participant-view-close{border:1px solid #d1d5db;background:#fff;border-radius:8px;width:32px;height:32px;cursor:pointer;font-size:1.1rem;color:#475569}
        .participant-view-close:hover{background:#f1f5f9;color:#0f172a}
        .participant-view-body{padding:14px 16px}
        .participant-view-row{margin-bottom:10px}
        .participant-view-label{display:block;font-size:.75rem;letter-spacing:.06em;text-transform:uppercase;color:#64748b;font-weight:700;margin-bottom:4px}
        .participant-view-value{color:#0f172a;font-weight:600}
        @media (max-width: 800px){ .people{grid-template-columns: 1fr} }
        .progress-wrap{display:flex;align-items:center;gap:16px}
        .progress-ring{
            width:72px;height:72px;border-radius:50%;
            background:
                radial-gradient(#fff 62%, transparent 63%),
                conic-gradient(var(--brand) var(--deg,0deg), #e5e7eb 0);
            display:flex;align-items:center;justify-content:center;
            color:#0f3b8f;font-weight:900;font-size:1rem;
            border:1px solid #e5e7eb;box-shadow:0 4px 12px rgba(15,23,42,.06);
        }
        .progress-bar{height:10px;background:#e5e7eb;border-radius:999px;overflow:hidden}
        .progress-bar > div{height:100%;background:var(--brand);width:0;border-radius:999px;transition:width .4s ease}
        .discussion{margin-top:16px}
        .discussion .post{display:flex;gap:10px;padding:12px 0;border-bottom:1px dashed var(--border)}
        .discussion textarea{width:100%;min-height:70px;border:1px solid var(--border);border-radius:10px;padding:10px;resize:vertical}
        .modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);display:none;align-items:center;justify-content:center;z-index:50}
        .modal{width:680px;max-width:calc(100% - 32px);background:#fff;border:1px solid #dbe4ef;border-radius:16px;box-shadow:0 22px 48px rgba(15,23,42,.25);overflow:hidden}
        .modal-editor{padding:14px 16px 0;background:#f8fafc}
        .modal-editor textarea{width:100%;min-height:140px;border:none;outline:none;background:transparent;font-size:1.05rem;color:#0f172a;resize:vertical}
        .modal-toolbar{display:flex;align-items:center;gap:12px;padding:10px 16px;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:#fff}
        .tool-btn{width:32px;height:32px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;display:inline-flex;align-items:center;justify-content:center;cursor:pointer}
        .tool-btn:hover{background:#f3f4f6}
        .modal-actions{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:#fff}
        .round-btn{width:40px;height:40px;border-radius:50%;border:1px solid #dfe3ea;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#0f3b8f}
        .round-set{display:flex;align-items:center;gap:8px}
        .post-cta{display:flex;align-items:center;gap:8px}
        .btn-disabled{background:#e5e7eb;color:#94a3b8;cursor:not-allowed}
        .counter{font-size:.85rem;color:#64748b}
        .error-text{color:#b91c1c;font-size:.9rem;margin-top:6px}
        .forum-list{display:flex;flex-direction:column;gap:12px}
        .forum-card{display:block;border:1px solid #dbe4f0;background:#fff;border-radius:12px;padding:14px 16px;transition:box-shadow .2s ease, transform .08s ease,border-color .2s ease;border-left:4px solid #d8deea}
        .forum-card:hover{box-shadow:0 10px 20px rgba(15,23,42,.08);transform:translateY(-1px)}
        .forum-card.selected{outline:3px solid #0f3b8f;outline-offset:0;border-color:#bfd7ff}
        .asm-details{display:none;margin-top:10px;background:#f1f6ff;border:1px solid #d6e4ff;border-radius:10px;padding:12px;color:#0f172a}
        .forum-title{font-weight:700;color:#0f172a}

        /* Professional Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal.active { 
            display: flex; 
            opacity: 1;
        }
        .modal-content {
            background-color: white;
            padding: 0;
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px);
            transition: transform 0.3s ease;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .modal.active .modal-content {
            transform: translateY(0);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            background: linear-gradient(180deg, #f8fbff 0%, #f3f7ff 100%);
            border-bottom: 1px solid #e2e8f0;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f3b8f;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .close-modal {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid #e2e8f0;
            font-size: 1.2rem;
            cursor: pointer;
            color: #64748b;
            transition: all 0.2s;
        }
        .close-modal:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .modal-body {
            padding: 24px;
        }
        .modal-footer {
            padding: 16px 24px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .form-group { 
            margin-bottom: 20px; 
        }
        .form-label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 700; 
            color: #334155; 
            font-size: 0.9rem; 
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .form-control-pro { 
            width: 100%; 
            padding: 12px 14px 12px 40px; 
            border: 1px solid #d1d5db; 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 1rem;
            color: #1e293b;
            transition: all 0.2s;
            background-color: #ffffff;
        }
        .form-control-pro:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: #fff;
        }
        .form-help {
            display: block;
            margin-top: 6px;
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.4;
        }

        /* Course Status Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 8px;
        }
        .status-upcoming { background-color: #fef3c7; color: #92400e; }
        .status-ongoing { background-color: #dcfce7; color: #166534; }
        .status-completed { background-color: #fee2e2; color: #991b1b; }
        .status-not-set { background-color: #f3f4f6; color: #374151; }

        .course-schedule-info {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 15px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .course-schedule-info div { display: flex; align-items: center; gap: 8px; }
        .course-schedule-info i { color: #0f3b8f; }

        .disc-tabs{display:flex;gap:4px;border-bottom:1px solid var(--border);margin:10px 0 12px}
        .disc-tab{position:relative;padding:10px 14px;font-weight:700;color:#64748b;background:transparent;border:none;cursor:pointer;border-radius:8px 8px 0 0;display:inline-flex;align-items:center;gap:8px}
        .disc-tab:hover{background:#f2f6ff;color:#0f3b8f}
        .disc-tab.active{color:#0f3b8f;background:#eef4ff}
        .disc-tab.active::after{content:'';position:absolute;left:12px;right:12px;bottom:-1px;height:3px;background:#0f3b8f;border-radius:2px}
        .pro-input{width:100%;font-size:1.05rem;color:#0f172a;border:1px solid var(--border);border-radius:12px;padding:12px 14px;outline:none;background:#fff}
        .pro-input:focus{border-color:#bcd2ff;box-shadow:0 0 0 4px rgba(37,99,235,0.12)}
        .pro-textarea{width:100%;min-height:140px;font-size:1rem;color:#0f172a;resize:vertical;border:1px solid var(--border);border-radius:12px;padding:12px 14px;background:#fff}
        .pro-textarea:focus{border-color:#bcd2ff;box-shadow:0 0 0 4px rgba(37,99,235,0.12)}
        .forum-meta{color:var(--muted);font-size:.9rem;margin-top:4px}
        .modal-editor input[type="text"]{border:1px solid var(--border);background:#fff;border-radius:10px;padding:10px}
        .modal-editor textarea{border:1px solid var(--border);background:#fff;border-radius:10px;padding:10px}
        .modal-editor input[type="text"]:focus,.modal-editor textarea:focus{outline:2px solid rgba(13,110,253,.25);outline-offset:2px}
        .discussion-modal{width:760px;max-width:calc(100% - 28px);border:1px solid #d7e3f5;box-shadow:0 24px 56px rgba(15,23,42,.28)}
        #discussionModal .discussion-modal-header{padding:14px 18px;border-bottom:1px solid #e2e8f0;background:linear-gradient(180deg,#f8fbff 0%,#f3f7ff 100%)}
        #discussionModal .discussion-modal-title{margin:0;font-size:1.05rem;font-weight:800;color:#0f3b8f;display:flex;align-items:center;gap:8px}
        #discussionModal .discussion-modal-sub{margin-top:4px;color:#64748b;font-size:.9rem}
        #discussionModal .discussion-close{position:absolute;right:14px;top:12px;width:34px;height:34px;border:1px solid #dbe3ef;border-radius:10px;background:#fff;color:#475569;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:1.2rem;line-height:1}
        #discussionModal .discussion-close:hover{background:#f1f5f9;color:#0f172a}
        #discussionModal .discussion-modal-body{padding:16px 18px 8px;background:#fff}
        #discussionModal .discussion-label{display:block;margin-bottom:6px;font-weight:700;color:#475569;font-size:.9rem}
        #discussionModal #discussionTitle,
        #discussionModal #discussionBody{border:1px solid #d8e1ee;border-radius:12px;padding:12px;box-sizing:border-box}
        #discussionModal #discussionTitle:focus,
        #discussionModal #discussionBody:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.15)}
        #discussionModal .discussion-file{display:block;width:100%;padding:10px;border:1px dashed #cbd5e1;border-radius:10px;background:#f8fafc}
        #discussionModal .discussion-modal-actions{padding:12px 18px;border-top:1px solid #e2e8f0;background:#f8fafc}
        #discussionModal #discussionSubmit{min-width:156px;justify-content:center}
        .main-content::-webkit-scrollbar{width:10px}
        .main-content::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:999px}
        .main-content::-webkit-scrollbar-track{background:transparent}
        @media (max-width: 900px){
            .main-content{padding:14px}
            .page{padding:0 10px;margin-top:14px}
            .hero-top{height:180px}
            .hero-body{padding:14px}
            .title{font-size:1.45rem}
            .tabs{width:100%;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));}
            .tab{width:100%}
        }
    </style>
    <script>
        var currentEditCard = null;
        var isTrainer = {!! json_encode(!empty($asTrainer)) !!};
        var csrfToken = "{{ csrf_token() }}";
        function toggleSidebar(){
            var s=document.getElementById('sidebar');
            if(s){ s.classList.toggle('collapsed'); }
            document.body.classList.toggle('sidebar-collapsed');
            try{
                var LOGO_MAIN = isTrainer ? "{{ asset('images/capdev_pro_w-removebg-preview.png') }}" : "{{ asset('images/ddd-removebg-preview.png') }}";
                var LOGO_SMALL = "{{ asset('images/logo1.png') }}";
                var sl = document.getElementById('sidebarLogo');
                var collapsed = document.body.classList.contains('sidebar-collapsed');
                if(sl){ sl.src = collapsed ? LOGO_SMALL : LOGO_MAIN; }
            }catch(e){}
        }
        function buildAnnouncementHtml(body, time, trainerLetter, trainerName){
            body = body.replace(/</g,'&lt;');
            return ''
                + '<div class="announce-card" style="margin-bottom:12px">'
                +   '<div class="announce-head">'
                +     '<div class="announce-ava">'+trainerLetter+'</div>'
                +     '<div class="announce-meta"><div class="name">'+trainerName+'</div><div class="time">'+time+'</div></div>'
                +     '<div class="announce-dots"><i class="fas fa-ellipsis-v"></i></div>'
                +   '</div>'
                +   '<div class="dots-menu">'
                +     '<a href="#" class="dots-item" data-action="edit">Edit</a>'
                +     '<a href="#" class="dots-item" data-action="delete">Delete</a>'
                +     '<a href="#" class="dots-item" data-action="repost">Repost</a>'
                +   '</div>'
                +   '<div class="announce-body">'+body+'</div>'
                + '</div>';
        }
        function updateAnnPreviewLimit(){
            var preview = document.getElementById('annPreview');
            if(!preview) return;
            var cards = preview.querySelectorAll('.announce-card');
            for(let i=3;i<cards.length;i++){ cards[i].remove(); }
        }
        function updateAnnListScroll(){
            var listBody = document.getElementById('annListBody');
            if(!listBody) return;
            var count = listBody.querySelectorAll('.announce-card').length;
            if(count>3){ listBody.classList.add('scrollable'); } else { listBody.classList.remove('scrollable'); }
        }
        function switchTo(id){
            document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
            document.querySelectorAll('.content > .card').forEach(c=>c.style.display='none');
            document.getElementById('tabBtn'+id).classList.add('active');
            document.getElementById('pane'+id).style.display='block';
        }
        function toggleAppSide(){
            var side=document.querySelector('.app-side');
            var body=document.body;
            if(window.innerWidth<=900){
                if(side){ side.classList.toggle('side-open'); }
            }else{
                if(side){ side.classList.toggle('collapsed'); }
                if(body){ body.classList.toggle('side-collapsed'); }
            }
        }
        document.addEventListener('DOMContentLoaded', function(){
            try{
                var params = new URLSearchParams(window.location.search);
                var tab = params.get('tab');
                var map = {
                    'stream':'Stream',
                    'classwork':'Classwork',
                    'forum':'Forum',
                    'people':'People'
                };
                if(tab){
                    var norm = map[String(tab).toLowerCase()] || tab;
                    if(['Stream','Classwork','Forum','People'].includes(norm)){
                        switchTo(norm);
                        return;
                    }
                    // supports direct fragment like ?tab=2 where 2=Classwork, keep optional
                } else {
                    // no tab provided; default below
                }
            }catch(e){
                // fallback below
            }
            switchTo('Stream');
            var f=document.getElementById('flashSuccess'); if(f){ setTimeout(function(){ if(document.body.contains(f)){ f.remove(); } }, 2500); }
        });
        function filterDiscussions(){
            var q = (document.getElementById('discussionSearch')||{}).value || '';
            q = q.trim().toLowerCase();
            var list = document.getElementById('courseDiscussions');
            if(!list) return;
            var cards = list.querySelectorAll('.forum-card');
            cards.forEach(function(card){
                var title = (card.querySelector('.forum-title')||{}).textContent || '';
                var body = '';
                var bodyEl = card.querySelector('[data-disc-body]');
                if(bodyEl) body = bodyEl.textContent || bodyEl.innerText || '';
                var show = !q || title.toLowerCase().includes(q) || body.toLowerCase().includes(q);
                card.style.display = show ? 'block' : 'none';
            });
        }
        function openDiscussionModal(){
            var c=document.getElementById('discussionComposer');
            var list=document.getElementById('courseDiscussions');
            var t=document.getElementById('discussionTitle');
            var b=document.getElementById('discussionBody');
            if(c){c.style.display='block';}
            if(list){list.style.display='none';}
            if(t){t.value='';}
            if(b){b.value='';}
            try{ setDiscussionMode('text'); }catch(e){}
            updateDiscussionCounts();
            var e=document.getElementById('discussionError'); if(e){e.textContent='';}
            if(c){ c.scrollIntoView({behavior:'smooth', block:'start'}); }
        }
        function closeDiscussionModal(){
            var c=document.getElementById('discussionComposer');
            var list=document.getElementById('courseDiscussions');
            if(c){c.style.display='none';}
            if(list){list.style.display='block';}
        }
        function openParticipantView(name, email, role){
            var m = document.getElementById('participantViewModal');
            var n = document.getElementById('participantViewName');
            var r = document.getElementById('participantViewRole');
            var e = document.getElementById('participantViewEmail');
            if(n){ n.textContent = name || '-'; }
            if(r){ r.textContent = role || '-'; }
            if(e){ e.textContent = email || '-'; }
            if(m){ m.style.display = 'flex'; }
        }
        function closeParticipantView(){
            var m = document.getElementById('participantViewModal');
            if(m){ m.style.display = 'none'; }
        }
        function updateDiscussionCounts(){
            var mode=(document.getElementById('discussionMode')||{}).value||'text';
            var t=document.getElementById('discussionTitle');
            var tc=document.getElementById('titleCount');
            var submit=document.getElementById('discussionSubmit');
            var tlen = t ? t.value.length : 0;
            if(tc){ tc.textContent = tlen + '/200'; }
            var titleFilled = t ? t.value.trim().length > 0 : false;
            var valid=false;
            if(mode==='text'){
                var b=document.getElementById('discussionBody');
                var bc=document.getElementById('bodyCount');
                var blen = b ? b.value.length : 0;
                if(bc){ bc.textContent = blen + ' chars'; }
                var bodyFilled = b ? b.value.trim().length >= 10 : false;
                valid = titleFilled && bodyFilled;
            } else if(mode==='media'){
                var file=document.getElementById('discussionImage');
                var hasFile = file && file.files && file.files.length>0;
                var nameEl=document.getElementById('discFileName');
                if(nameEl){ nameEl.textContent = hasFile ? ('Selected: '+(file.files[0]?.name||'1 file')) : ''; }
                valid = titleFilled && hasFile;
            } else if(mode==='link'){
                var link=document.getElementById('discussionLink');
                var url = link ? link.value.trim() : '';
                var isUrl = /^https?:\/\/[^\s]+$/i.test(url);
                valid = titleFilled && isUrl;
            }
            if(submit){
                submit.disabled = !valid;
                submit.classList.toggle('btn-blue', valid);
                submit.classList.toggle('btn-disabled', !valid);
            }
        }
        function setDiscussionMode(mode){
            var m=document.getElementById('discussionMode'); if(m){ m.value=mode; }
            var t1=document.getElementById('discFieldsText');
            var t2=document.getElementById('discFieldsMedia');
            var t3=document.getElementById('discFieldsLink');
            if(t1) t1.style.display = (mode==='text') ? 'block':'none';
            if(t2) t2.style.display = (mode==='media') ? 'block':'none';
            if(t3) t3.style.display = (mode==='link') ? 'block':'none';
            var tabs=[['discTabText','text'],['discTabMedia','media'],['discTabLink','link']];
            tabs.forEach(function(pair){
                var el=document.getElementById(pair[0]);
                if(!el) return;
                var active = (pair[1]===mode);
                el.classList.toggle('active', active);
                el.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            updateDiscussionCounts();
        }
        async function submitDiscussion(ev){
            ev.preventDefault();
            var form = document.getElementById('discussionForm');
            var btn = document.getElementById('discussionSubmit');
            var err = document.getElementById('discussionError');
            if(!form||!btn) return;
            err.textContent='';
            btn.disabled=true; btn.textContent='Submitting…'; btn.classList.add('btn-disabled'); btn.classList.remove('btn-blue');
            try{
                var fd = new FormData(form);
                var mode=(document.getElementById('discussionMode')||{}).value||'text';
                if(mode==='media'){
                    var titleVal = (document.getElementById('discussionTitle')||{}).value||'Media post';
                    fd.set('body', titleVal);
                } else if(mode==='link'){
                    var url = (document.getElementById('discussionLink')||{}).value||'';
                    fd.set('body', url);
                }
                var token = form.querySelector('input[name=\"_token\"]').value;
                var res = await fetch(form.action, {
                    method:'POST',
                    headers:{'Accept':'application/json','X-CSRF-TOKEN':token},
                    body: fd
                });
                if(!res.ok){
                    let msg = 'Network error';
                    try{ const j = await res.json(); msg = j.message || JSON.stringify(j); }catch{}
                    throw new Error(msg);
                }
                const data = await res.json();
                if(data.redirect){
                    // Optimistic add to list
                    var list = document.getElementById('courseDiscussions');
                    if(list){
                        var item = document.createElement('div');
                        item.className='forum-card';
                        item.innerHTML = '<div class=\"forum-title\"><a href=\"'+data.redirect+'\" style=\"text-decoration:none;color:#0f172a\">'+(data.discussion?.title||'New discussion')+'</a></div><div class=\"forum-meta\">Just now</div>';
                        list.prepend(item);
                    }
                    closeDiscussionModal();
                    showSuccessToast('Discussion created.');
                    setTimeout(function(){ window.location.href = data.redirect; }, 350);
                    return;
                }
            }catch(e){
                err.textContent = e.message || 'Failed to create discussion. Please try again.';
            }finally{
                btn.textContent='Submit';
                updateDiscussionCounts();
            }
        }
        function handleAnnouncementSubmit(ev){
            ev.preventDefault();
            var form = ev.target;
            var title = document.getElementById('announceTitle');
            var body = document.getElementById('announceText');
            if(!form || !title || !body) return false;
            if(title.value.trim()==='' || body.value.trim()===''){
                updatePostButton();
                return false;
            }
            closeAnnouncementModal();
            showSuccessToast('Announcement posted.');
            setTimeout(function(){ form.submit(); }, 350);
            return false;
        }
        function showAnnouncementsList(){
            var main=document.getElementById('streamMain');
            var list=document.getElementById('annListPanel');
            if(main&&list){main.style.display='none';list.style.display='block';}
        }
        function backToStreamMain(){
            var main=document.getElementById('streamMain');
            var list=document.getElementById('annListPanel');
            if(main&&list){list.style.display='none';main.style.display='block';}
        }
        function openAnnouncementModal(){
            var m=document.getElementById('announceModal');
            var t=document.getElementById('announceText');
            var ttl=document.getElementById('announceTitle');
            if(m){m.style.display='flex';}
            if(t){t.value='';}
            if(ttl){ttl.value=''; ttl.focus();}
            updatePostButton();
        }
        function toggleEdit(key){
            var f=document.getElementById('edit-'+key);
            if(!f)return;
            f.style.display = (f.style.display==='none'||f.style.display==='') ? 'block' : 'none';
        }
        function toggleMenu(id, ev){
            if(ev){ ev.stopPropagation(); }
            document.querySelectorAll('.dots-menu').forEach(function(m){ if(m.id!==id){ m.style.display='none'; } });
            var el=document.getElementById(id);
            if(!el)return;
            el.style.display = (el.style.display==='none'||el.style.display==='') ? 'block' : 'none';
        }
        document.addEventListener('click', function(){
            document.querySelectorAll('.dots-menu').forEach(function(m){ m.style.display='none'; });
        });
        document.addEventListener('click', function(e){
            var del = e.target.closest && e.target.closest('.dots-item[data-delete]');
            if(del){
                e.preventDefault();
                e.stopPropagation();
                document.querySelectorAll('.dots-menu').forEach(function(m){ m.style.display='none'; });
                var type = del.getAttribute('data-delete') || '';
                var url = del.getAttribute('data-url') || '';
                var id = del.getAttribute('data-id') || '';
                // Fallback compose URL if missing/empty to avoid accidental DELETE on current route
                try{
                    if(!url){
                        if(type==='material' && id){ url = '/trainer/materials/'+id; }
                        if(type==='assessment' && id){ url = '/trainer/assessments/'+id; }
                    }
                    if(url && !/^https?:\/\//i.test(url)){
                        url = new URL(url, window.location.origin).toString();
                    }
                }catch(_e){}
                if(!url){ alert('Delete URL missing. Please refresh and try again.'); return; }
                if(type==='material'){ handleDeleteMaterial(url, id); }
                else if(type==='assessment'){ handleDeleteAssessment(url, id); }
            }
        });
        var createBtn = document.getElementById('createCwBtn');
        var createMenu = document.getElementById('createCwMenu');
        if(createBtn && createMenu){
            createBtn.addEventListener('click', function(ev){
                ev.preventDefault(); ev.stopPropagation();
                document.querySelectorAll('.dots-menu').forEach(function(m){ if(m!==createMenu){ m.style.display='none'; } });
                createMenu.style.display = (createMenu.style.display==='none' || createMenu.style.display==='') ? 'block' : 'none';
            });
        }
        function onAssessmentCardClick(ev, id){
            var isMenu = ev.target.closest && (ev.target.closest('.announce-dots') || ev.target.closest('.dots-menu') || ev.target.closest('form'));
            if(isMenu) return;
            if(isTrainer){
                var card = document.getElementById('asm-card-'+id);
                var href = card && card.getAttribute('data-view-href');
                if(href){ window.location.href = href; return; }
            }
            document.querySelectorAll('.forum-card.selected').forEach(function(card){
                card.classList.remove('selected');
            });
            document.querySelectorAll('.asm-details').forEach(function(d){ d.style.display='none'; });
            var card = document.getElementById('asm-card-'+id);
            var det = document.getElementById('asm-det-'+id);
            if(card){ card.classList.add('selected'); }
            if(det){ det.style.display='block'; }
        }
        function onMaterialCardClick(ev, id){
            var isMenu = ev.target.closest && (ev.target.closest('.announce-dots') || ev.target.closest('.dots-menu') || ev.target.closest('form'));
            if(isMenu) return;
            var card = document.getElementById('mat-card-'+id);
            var href = card && card.getAttribute('data-href');
            if(href){ window.location.href = href; }
        }
        var __pendingDelete = null;
        function openDeleteConfirm(title, message, onConfirm){
            var modal = document.getElementById('deleteConfirmModal');
            if(!modal) return;
            modal.querySelector('.del-title').textContent = title || 'Confirm Delete';
            modal.querySelector('.del-message').textContent = message || 'Are you sure you want to delete this item?';
            var ok = modal.querySelector('#deleteConfirmBtn');
            var cancel = modal.querySelector('#deleteCancelBtn');
            ok.onclick = function(){ modal.style.display='none'; if(typeof onConfirm==='function'){ onConfirm(); } };
            cancel.onclick = function(){ modal.style.display='none'; __pendingDelete=null; };
            modal.onclick = function(e){ if(e.target === modal){ modal.style.display='none'; __pendingDelete=null; } };
            modal.style.display='flex';
        }
        function showSuccessToast(text){
            var slot = document.getElementById('runtimeSuccessSlot');
            if(!slot){
                var page = document.querySelector('.page');
                slot = document.createElement('div');
                slot.id = 'runtimeSuccessSlot';
                if(page){ page.insertBefore(slot, page.firstChild); }
            }
            var html = '<div id="runtimeSuccess" class="card" style="margin-bottom:12px;color:#0b7a33;border-color:#c1e7d2;background:#f0fff6;display:flex;justify-content:space-between;align-items:center">'
                + '<span>'+ (text || 'Success') +'</span>'
                + '<button type="button" aria-label="Close" onclick="var x=document.getElementById(\'runtimeSuccess\'); if(x){x.remove();}" style="border:none;background:transparent;color:#065f46;font-weight:800;cursor:pointer;padding:6px 8px">×</button>'
                + '</div>';
            slot.innerHTML = html;
            setTimeout(function(){ var x=document.getElementById('runtimeSuccess'); if(x && document.body.contains(x)){ x.remove(); } }, 2500);
        }
        function handleDeleteMaterial(url, id){
            openDeleteConfirm('Delete Material','This will permanently remove the material from Classwork.', function(){
                var form = new URLSearchParams();
                form.append('_method','DELETE');
                fetch(url, {
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json','Content-Type':'application/x-www-form-urlencoded'},
                    body: form.toString()
                }).then(function(res){
                    if(res.ok){
                        var card = document.getElementById('mat-card-'+id);
                        if(card) card.remove();
                        switchTo('Classwork');
                        try{ localStorage.setItem('classwork:diff', JSON.stringify({t:'material', op:'remove', id:String(id), ts:Date.now()})); }catch(_e){}
                        var f=document.getElementById('flashSuccess'); if(f){ f.remove(); }
                        showSuccessToast('Material deleted.');
                    }else{
                        res.json().then(function(j){ alert(j.message||'Failed to delete material'); }).catch(function(){ alert('Failed to delete material'); });
                    }
                }).catch(function(){ alert('Failed to delete material'); });
            });
        }
        function handleDeleteAssessment(url, id){
            openDeleteConfirm('Delete Assessment','This will permanently remove the assessment from Classwork.', function(){
                var form = new URLSearchParams();
                form.append('_method','DELETE');
                fetch(url, {
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json','Content-Type':'application/x-www-form-urlencoded'},
                    body: form.toString()
                }).then(function(res){
                    if(res.ok){
                        var card = document.getElementById('asm-card-'+id);
                        if(card) card.remove();
                        switchTo('Classwork');
                        try{ localStorage.setItem('classwork:diff', JSON.stringify({t:'assessment', op:'remove', id:String(id), ts:Date.now()})); }catch(_e){}
                        var f=document.getElementById('flashSuccess'); if(f){ f.remove(); }
                        showSuccessToast('Assessment deleted.');
                    }else{
                        res.json().then(function(j){ alert(j.message||'Failed to delete assessment'); }).catch(function(){ alert('Failed to delete assessment'); });
                    }
                }).catch(function(){ alert('Failed to delete assessment'); });
            });
        }
        window.addEventListener('storage', function(e){
            if(e && e.key==='classwork:diff' && e.newValue){
                try{
                    var payload = JSON.parse(e.newValue);
                    if(payload && payload.op==='remove' && payload.id && payload.t){
                        var cardId = (payload.t==='material' ? 'mat-card-' : 'asm-card-') + payload.id;
                        var card = document.getElementById(cardId);
                        if(card){ card.remove(); }
                        switchTo('Classwork');
                    }
                }catch(_e){}
            }
        });
        function closeAnnouncementModal(){
            var m=document.getElementById('announceModal');
            if(m){m.style.display='none';}
        }
        function updatePostButton(){
            var t=document.getElementById('announceText');
            var ttl=document.getElementById('announceTitle');
            var b=document.getElementById('postBtn');
            if(!t||!b) return;
            var has=(t.value.trim().length>0) && (ttl && ttl.value.trim().length>0);
            b.disabled=!has;
            b.classList.toggle('btn-blue',has);
            b.classList.toggle('btn-disabled',!has);
        }
        function insertAnnouncement(body){
            var trainerLetter='T';
            var trainerName='Coach';
            var preview=document.getElementById('annPreview');
            var listPanel=document.getElementById('annListPanel');
            var time=new Date().toLocaleTimeString([], {hour:'numeric', minute:'2-digit'});
            var cardHtml = buildAnnouncementHtml(body, time, trainerLetter, trainerName);
            if(preview){
                if(preview.children.length && preview.querySelector('.muted')){ preview.innerHTML=''; }
                preview.insertAdjacentHTML('afterbegin', cardHtml);
                updateAnnPreviewLimit();
            }
            if(listPanel){
                var container=listPanel.querySelector('#annListBody');
                if(container){
                    if(container.querySelector('.muted')){ container.innerHTML=''; }
                    container.insertAdjacentHTML('afterbegin', cardHtml);
                    updateAnnListScroll();
                }
            }
        }
        function postAnnouncement(){
            var t=document.getElementById('announceText');
            if(!t||t.value.trim()===''){return;}
            var body=t.value.trim();
            if(currentEditCard){
                var bodyEl = currentEditCard.querySelector('.announce-body');
                if(bodyEl){ bodyEl.textContent = body; }
                currentEditCard = null;
            }else{
                insertAnnouncement(body);
            }
            closeAnnouncementModal();
        }
        function toggleProfileMenu(e){
            e.stopPropagation();
            var d = document.getElementById('profileDropdown');
            if(!d) return;
            d.style.display = (d.style.display==='block') ? 'none' : 'block';
        }
        document.addEventListener('DOMContentLoaded', function(){
            
            updateAnnListScroll();
            document.addEventListener('click', function(e){
                var dots = e.target.closest('.announce-dots');
                if(dots){
                    var card = dots.closest('.announce-card');
                    document.querySelectorAll('.dots-menu').forEach(m=>m.style.display='none');
                    var menu = card && card.querySelector('.dots-menu');
                    if(menu){ menu.style.display = menu.style.display==='block'?'none':'block'; }
                    e.stopPropagation();
                    return;
                }
                var item = e.target.closest('.dots-item');
                if(item){
                    e.preventDefault();
                    var action = item.dataset.action;
                    var card = item.closest('.announce-card');
                    if(action==='edit'){
                        var t = document.getElementById('announceText');
                        currentEditCard = card;
                        if(t){ t.value = card.querySelector('.announce-body')?.textContent || ''; }
                        openAnnouncementModal();
                    }else if(action==='delete'){
                        card.remove();
                        updateAnnListScroll();
                        updateAnnPreviewLimit();
                    }else if(action==='repost'){
                        var body = card.querySelector('.announce-body')?.textContent || '';
                        insertAnnouncement(body);
                    }
                    document.querySelectorAll('.dots-menu').forEach(m=>m.style.display='none');
                    return;
                }
                document.querySelectorAll('.dots-menu').forEach(m=>m.style.display='none');
            });
            document.addEventListener('click', function(ev){
                var menu = document.querySelector('.profile-menu');
                var d = document.getElementById('profileDropdown');
                if(menu && d && !menu.contains(ev.target)){
                    d.style.display = 'none';
                }
                if(ev.target && ev.target.id === 'participantViewModal'){
                    closeParticipantView();
                }
            });
            document.addEventListener('keydown', function(ev){
                if(ev.key === 'Escape'){
                    closeParticipantView();
                }
            });
        });
    </script>
    @if(!empty($asTrainer))
    <script>
        (function(){
            function init(){
                var list=document.getElementById('moduleAccessList');
                if(!list) return;
                // Toast (after body exists)
                var toast=document.createElement('div');
                toast.id='toast';
                toast.style.cssText='position:fixed;right:16px;bottom:16px;background:#0b2c74;color:#fff;padding:12px 14px;border-radius:12px;box-shadow:0 14px 30px rgba(2,6,23,.28);z-index:2000;display:none;font-weight:800';
                document.body.appendChild(toast);
                function showToast(msg){
                    toast.textContent=msg;
                    toast.style.display='block';
                    clearTimeout(toast.__t); toast.__t=setTimeout(()=>{toast.style.display='none';},1800);
                }
                // Direct handler to avoid container interference
                window.modToggle = function(btn){
                    var card = btn.closest('.forum-card');
                    var mi = btn.getAttribute('data-mi') || (card ? card.getAttribute('data-mi') : null);
                    if(mi==null) return false;
                    var next = btn.getAttribute('data-status')||'locked';
                    fetch("{{ route('trainer.modules.set-status', ['course'=>$course, 'index'=>'__IDX__']) }}".replace('__IDX__', mi), {
                        method:'POST',
                        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json','Content-Type':'application/json'},
                        credentials:'same-origin',
                        body: JSON.stringify({status: next})
                    }).then(function(r){ return r.json(); })
                    .then(function(j){
                        if(j && j.ok){
                            var st = j.status;
                            var statusEl = card.querySelector('.mod-status');
                            if(statusEl) statusEl.textContent = (st||'').charAt(0).toUpperCase() + (st||'').slice(1);
                            btn.setAttribute('data-status', st==='locked' ? 'unlocked':'locked');
                            btn.innerHTML = '<i class="fas fa-exchange-alt"></i> ' + (st==='locked'?'Unlock':'Lock');
                            var titleWrap = card.querySelector('.forum-card > div:first-child');
                            if(titleWrap){
                                var html = titleWrap.innerHTML;
                                if(st==='locked'){ html = html.replace(/fa-unlock/g,'fa-lock'); }
                                else { html = html.replace(/fa-lock/g,'fa-unlock'); }
                                titleWrap.innerHTML = html;
                            }
                            showToast('Module ' + (st==='locked'?'locked':'unlocked') + ' successfully');
                        }else{
                            alert(j && j.error ? j.error : 'Failed to update status');
                        }
                    }).catch(function(){ alert('Network error'); });
                    return false;
                };
                // Delegation fallback
                list.addEventListener('click', function(ev){
                    var btn = ev.target.closest('.mod-toggle');
                    if(!btn || !list.contains(btn)) return;
                    ev.preventDefault();
                    window.modToggle(btn);
                });
            }
            if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded', init); }
            else { init(); }
        })();
    </script>
    @endif
    </head>
    <body>
    <div id="deleteConfirmModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="delTitle">
        <div class="modal">
            <div class="modal-editor" style="padding:16px">
                <div id="delTitle" class="del-title" style="font-weight:800;margin-bottom:6px">Confirm Delete</div>
                <div class="del-message muted">Are you sure?</div>
            </div>
            <div class="modal-actions">
                <button id="deleteCancelBtn" class="btn btn-ghost" type="button"><i class="fas fa-xmark"></i> Cancel</button>
                <button id="deleteConfirmBtn" class="btn btn-blue" type="button"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
    <header class="header">
        <div class="header-left">
            <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div id="headerSectionTitle" class="header-section-title">Classroom</div>
        </div>
        <div class="header-right">
            <div class="profile-menu">
                <div class="user-profile" onclick="toggleProfileMenu(event)" style="cursor: pointer;">
                    <img src="{{ Auth::user()->avatar_url }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
                    <i class="fas fa-chevron-down" style="font-size:.85rem;color:#666"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <a class="dropdown-item" href="{{ route('profile.setup') }}">
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
        <div class="sidebar" id="sidebar">
            <div class="header-title" style="padding:12px 20px;display:flex;align-items:center;justify-content:center">
                <img id="sidebarLogo" src="{{ !empty($asTrainer) ? asset('images/capdev_pro_w-removebg-preview.png') : asset('images/ddd-removebg-preview.png') }}" alt="CapDev Pro" style="height:60px">
            </div>
            <div style="padding:8px 20px;display:flex;align-items:center;gap:12px;">
            </div>
            <ul class="nav-menu">
                @if(!empty($asTrainer))
                <li class="nav-item">
                    <div class="nav-link" style="cursor:default;opacity:.95;font-weight:700">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span class="nav-text">Coach Portal</span>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'coach']) }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'coach', 'tab' => 'my-courses']) }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">My Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'coach', 'tab' => 'course-utilities']) }}" class="nav-link">
                        <i class="fas fa-screwdriver-wrench nav-icon"></i>
                        <span class="nav-text">Course Utilities</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'certification-management']) }}" class="nav-link">
                        <i class="fas fa-certificate nav-icon"></i>
                        <span class="nav-text">Certifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'coach', 'tab' => 'calendar']) }}" class="nav-link">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-text">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'coach', 'tab' => 'announcements']) }}" class="nav-link">
                        <i class="fas fa-bullhorn nav-icon"></i>
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'participant']) }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'classroom']) }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">Classroom</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'calendar']) }}" class="nav-link">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-text">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['portal' => 'participant', 'tab' => 'announcements']) }}" class="nav-link">
                        <i class="fas fa-bullhorn nav-icon"></i>
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="main-content">
            <div class="back-to-courses-row">
                <a class="back-to-courses-btn" href="{{ !empty($asTrainer) ? route('dashboard', ['portal' => 'coach', 'tab' => 'my-courses']) : route('dashboard', ['portal' => 'participant', 'tab' => 'classroom']) }}">
                    <i class="fas fa-arrow-left"></i>
                    Back to My Course
                </a>
            </div>
            @if (session('success'))
                <div id="flashSuccess" class="card" role="status" style="margin-bottom:12px;color:#0b7a33;border-color:#c1e7d2;background:#f0fff6;display:flex;justify-content:space-between;align-items:center">
                    <span>{{ session('success') }}</span>
                    <button type="button" aria-label="Close" onclick="var f=document.getElementById('flashSuccess'); if(f){f.remove();}" style="border:none;background:transparent;color:#065f46;font-weight:800;cursor:pointer;padding:6px 8px">×</button>
                </div>
            @endif
            <div class="hero">
                <div class="hero-top">
                    @php
                        $hero = $course->image_path ? $course->image_url : null;
                    @endphp
                    @if ($hero)
                        <img id="courseHeroImage" src="{{ $hero }}" alt="Course banner">
                    @endif
                    {{-- image preview & crop controls removed --}}
                </div>
                <div class="hero-body">
                    @if (trim((string) $course->subjectAreaText()) !== '')
                        <span class="chip"><i class="fas fa-layer-group"></i> {{ $course->subjectAreaText() }}</span>
                    @endif
                    
                    @php
                        $status = $course->enrollment_status;
                        $statusClass = match($status) {
                            'Upcoming' => 'status-upcoming',
                            'Open for Enrollment' => 'status-ongoing',
                            'Enrollment Closed', 'Expired' => 'status-completed',
                            default => 'status-not-set'
                        };
                    @endphp
                    <div style="margin-top: 10px;">
                        <div class="status-badge {{ $statusClass }}">{{ $status }}</div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                        <div style="flex: 1; min-width: 300px;">
                            <div class="title">{{ $course->name }}</div>
                            <div class="course-schedule-info">
                                <div><i class="fas fa-calendar-alt"></i> Enrollment Start: {{ $course->enrollment_start_date ? $course->enrollment_start_date->format('M d, Y') : 'Not set' }}</div>
                                <div><i class="fas fa-clock"></i> Enrollment End: {{ $course->enrollment_end_date ? $course->enrollment_end_date->format('M d, Y') : 'Not set' }}</div>
                            </div>
                            
                            @if(!empty($asTrainer) && $course->course_type === 'controlled' && $course->access_code)
                                <div class="course-code" style="background: #f0fdf4; color: #166534; padding: 6px 12px; border-radius: 10px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; border: 1px solid #bbf7d0; box-shadow: 0 2px 4px rgba(22, 101, 52, 0.05);">
                                    <i class="fas fa-key" style="font-size: 0.8rem;"></i>
                                    <span>Access Code: </span>
                                    <span class="access-code-masked" style="letter-spacing: 2px;">••••••••</span>
                                    <span class="access-code-visible" style="display: none;">{{ $course->access_code }}</span>
                                    <button type="button" class="toggle-access-code" onclick="toggleAccessCode(this)" style="background: none; border: none; padding: 0; margin-left: 6px; color: #166534; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; outline: none;" title="Show/Hide Access Code">
                                        <i class="fas fa-eye" style="font-size: 0.95rem;"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                        @if(!empty($asTrainer))
                            @php
                                $managedCoachRoles = ['trainer','coach','central_office_coach','regional_office_coach','provincial_office_coach'];
                                // Check if user is the creator OR is in the coaches list resolved by controller
                                $isCreator = $course->trainer_id === auth()->id();
                                $isInCoaches = isset($coaches) && $coaches->pluck('id')->contains(auth()->id());
                                $isAttached = $course->users->pluck('id')->contains(auth()->id());
                            @endphp
                            @if(in_array(auth()->user()->role, $managedCoachRoles, true) && ($isCreator || $isInCoaches || $isAttached))
                                <div style="display: flex; gap: 10px;">
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="tabs" role="tablist">
                        <button id="tabBtnStream" class="tab active" onclick="switchTo('Stream')" role="tab" aria-controls="paneStream" aria-selected="true">Stream</button>
                        <button id="tabBtnClasswork" class="tab" onclick="switchTo('Classwork')" role="tab" aria-controls="paneClasswork" aria-selected="false" tabindex="-1">Classwork</button>
                        <button id="tabBtnForum" class="tab" onclick="switchTo('Forum')" role="tab" aria-controls="paneForum" aria-selected="false" tabindex="-1">Forum</button>
                        <button id="tabBtnPeople" class="tab" onclick="switchTo('People')" role="tab" aria-controls="panePeople" aria-selected="false" tabindex="-1">Participants</button>
                    </div>
                </div>
            </div>
        <div class="content">
            <div id="paneStream" class="card" role="tabpanel" aria-labelledby="tabBtnStream">
                <div id="streamMain">
                    <div class="container-box" style="margin-bottom:16px;">
                        <div class="section-head">
                            <div class="avatar"><i class="fas fa-align-left"></i></div>
                            <div>About this course</div>
                        </div>

                        {{-- Enrollment Status and Action for Trainees --}}
                        @if(empty($asTrainer))
                            <div style="margin-top: 15px; padding: 15px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                                    <div>
                                        <div style="font-weight: 800; color: #1e293b; margin-bottom: 4px;">Enrollment Status</div>
                                        @if($course->isEnrollable())
                                            <span class="status-badge status-ongoing" style="margin: 0;">
                                                <i class="fas fa-check-circle"></i> Enrollment Open
                                            </span>
                                            <div class="muted" style="font-size: 0.8rem; margin-top: 4px;">
                                                Closes: {{ $course->enrollment_end_date ? $course->enrollment_end_date->format('M d, Y') : 'TBA' }}
                                            </div>
                                        @else
                                            <span class="status-badge status-completed" style="margin: 0;">
                                                <i class="fas fa-times-circle"></i> Enrollment Closed
                                            </span>
                                            @if($course->enrollment_start_date && now()->startOfDay()->lt($course->enrollment_start_date->copy()->startOfDay()))
                                                <div class="muted" style="font-size: 0.8rem; margin-top: 4px;">
                                                    Opens: {{ $course->enrollment_start_date->format('M d, Y') }}
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    @php
                                        $isEnrolled = $course->users && $course->users->contains(auth()->id());
                                    @endphp

                                    @if($isEnrolled)
                                        <button class="hero-btn" style="background: #10b981; cursor: default;" disabled>
                                            <i class="fas fa-check"></i> Already Enrolled
                                        </button>
                                    @else
                                        <form action="{{ route('courses.join', $course) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="hero-btn {{ !$course->isEnrollable() ? 'disabled' : '' }}" {{ !$course->isEnrollable() ? 'disabled' : '' }}>
                                                <i class="fas fa-user-plus"></i> Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(!empty($course->description))
                            <div class="muted">{{ $course->description }}</div>
                        @else
                            <div class="muted">No description provided.</div>
                        @endif
                    </div>
                    <div class="split">
                        @if(empty($asTrainer))
                        <div class="container-box">
                            @php $completion = $completion ?? 0; @endphp
                            <div class="section-head" style="color:var(--text);font-weight:700;">
                                <div style="width:36px;height:36px;border-radius:50%;background:#e8fff0;display:flex;align-items:center;justify-content:center;color:#0b7a33"><i class="fas fa-check-circle"></i></div>
                                <div>Total completion</div>
                            </div>
                            <div class="progress-wrap">
                                <div class="progress-ring" id="overallRing" style="--deg: {{ $completion*3.6 }}deg">{{ $completion }}%</div>
                                <div style="flex:1;">
                                    <div class="muted" style="margin-bottom:6px;">Overall progress <span id="overallDetail" class="muted" style="margin-left:6px"></span></div>
                                </div>
                            </div>
                            <div id="moduleProgressList" style="margin-top:10px"></div>
                        </div>
                        @endif
                        <div class="container-box">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                <div class="section-head" style="margin:0;color:var(--text);font-weight:700;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f"><i class="fas fa-bullhorn"></i></div>
                                    <div>Announcements</div>
                                </div>
                                <a class="link-action" href="javascript:void(0)" onclick="showAnnouncementsList()"><i class="fas fa-list-ul"></i> View all</a>
                            </div>
                            @php
                                $currentUserId = \Illuminate\Support\Facades\Auth::id();
                                $currentUserRole = \Illuminate\Support\Facades\Auth::user()->role ?? null;
                                $isCoachRole = in_array($currentUserRole, ['trainer', 'coach'], true) || \Illuminate\Support\Str::endsWith((string) $currentUserRole, '_coach');
                                $canPostAnnouncement = !empty($asTrainer)
                                    || (\Illuminate\Support\Facades\Auth::check() && $isCoachRole)
                                    || ($course->users && $course->users->contains(function ($u) use ($currentUserId) {
                                        return (int) $u->id === (int) $currentUserId
                                            && (in_array(($u->role ?? null), ['trainer', 'coach'], true) || \Illuminate\Support\Str::endsWith((string) ($u->role ?? null), '_coach'));
                                    }));
                            @endphp
                            @if($canPostAnnouncement)
                                <div class="ann-actions">
                                    <button class="chip-action" onclick="currentEditCard=null; openAnnouncementModal()"><i class="fas fa-pen"></i> New announcement</button>
                                </div>
                            @endif
                            @php
                                $trainer = optional($course->users->firstWhere('role','trainer'))->name ?? 'Coach';
                                $announcements = $announcements ?? collect();
                            @endphp
                            <div id="annPreview">
                                @if($announcements->isEmpty())
                                    <div class="muted">No Announcements</div>
                                @else
                                    @php $preview = $announcements->take(3); @endphp
                                    @foreach($preview as $ann)
                                    <div class="announce-card">
                                        <div class="announce-head">
                                            <div class="announce-ava">{{ mb_substr($trainer,0,1) }}</div>
                                            <div class="announce-meta">
                                                <div class="name">{{ $trainer }}</div>
                                                <div class="time">{{ \Carbon\Carbon::now()->format('g:i A') }}</div>
                                            </div>
                                            <div class="announce-dots"><i class="fas fa-ellipsis-v"></i></div>
                                        </div>
                                        <div class="dots-menu">
                                            <a href="#" class="dots-item" data-action="edit">Edit</a>
                                            <a href="#" class="dots-item" data-action="delete">Delete</a>
                                            <a href="#" class="dots-item" data-action="repost">Repost</a>
                                        </div>
                                        <div class="announce-body">
                                            <div style="font-weight:700;margin-bottom:6px;">{{ is_object($ann) ? $ann->title : ($ann['title'] ?? '') }}</div>
                                            <div>{{ is_object($ann) ? $ann->body : (is_string($ann) ? $ann : ($ann['body'] ?? '')) }}</div>
                                        </div>
                                        @if(is_object($ann))
                                            <div style="padding:0 16px 12px 64px;">
                                                @if($ann->comments && $ann->comments->count())
                                                    @foreach($ann->comments as $c)
                                                        <div style="margin-top:8px;display:flex;gap:8px;align-items:flex-start;">
                                                            <div class="avatar" style="width:28px;height:28px">{{ mb_substr($c->user->name ?? 'U',0,1) }}</div>
                                                            <div>
                                                                <div style="font-weight:700">{{ $c->user->name ?? 'User' }}</div>
                                                                <div class="muted">{{ \Carbon\Carbon::parse($c->created_at)->format('M j, g:i A') }}</div>
                                                                <div>{{ $c->body }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <form action="{{ route('class-announcements.comments.store', $ann) }}" method="POST" style="margin-top:8px;">
                                                    @csrf
                                                    <div style="display:flex;gap:8px;align-items:flex-start">
                                                        <textarea name="body" placeholder="Add a comment..." style="flex:1;min-height:60px;border:1px solid var(--border);border-radius:10px;padding:8px"></textarea>
                                                        <button class="btn btn-blue" type="submit">Post</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Open discussion removed from Stream -->
                </div>
                <div id="annListPanel" style="display:none">
                    <div class="container-box" style="margin-bottom:10px;display:flex;justify-content:space-between;align-items:center">
                        <div class="section-head" style="margin:0;color:var(--text);font-weight:700;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f"><i class="fas fa-bullhorn"></i></div>
                            <div>All announcements</div>
                        </div>
                        <a class="link-action" href="javascript:void(0)" onclick="backToStreamMain()"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    @php
                        $trainer = optional($course->users->firstWhere('role','trainer'))->name ?? 'Coach';
                        $announcements = $announcements ?? collect();
                    @endphp
                    @if($announcements->isEmpty())
                        <div class="container-box"><div class="muted">No Announcements</div></div>
                    @else
                        <div id="annListBody" class="ann-list">
                        @foreach($announcements as $ann)
                            <div class="announce-card" style="margin-bottom:12px">
                                <div class="announce-head">
                                    <div class="announce-ava">{{ mb_substr($trainer,0,1) }}</div>
                                    <div class="announce-meta">
                                        <div class="name">{{ $trainer }}</div>
                                        <div class="time">{{ \Carbon\Carbon::now()->format('g:i A') }}</div>
                                    </div>
                                    <div class="announce-dots"><i class="fas fa-ellipsis-v"></i></div>
                                </div>
                                <div class="dots-menu">
                                    <a href="#" class="dots-item" data-action="edit">Edit</a>
                                    <a href="#" class="dots-item" data-action="delete">Delete</a>
                                    <a href="#" class="dots-item" data-action="repost">Repost</a>
                                </div>
                                <div class="announce-body">
                                    <div style="font-weight:700;margin-bottom:6px;">{{ is_object($ann) ? $ann->title : ($ann['title'] ?? '') }}</div>
                                    <div>{{ is_object($ann) ? $ann->body : (is_string($ann) ? $ann : ($ann['body'] ?? '')) }}</div>
                                </div>
                                @if(is_object($ann))
                                <div style="padding:0 16px 12px 64px;">
                                    @if($ann->comments && $ann->comments->count())
                                        @foreach($ann->comments as $c)
                                            <div style="margin-top:8px;display:flex;gap:8px;align-items:flex-start;">
                                                <div class="avatar" style="width:28px;height:28px">{{ mb_substr($c->user->name ?? 'U',0,1) }}</div>
                                                <div>
                                                    <div style="font-weight:700">{{ $c->user->name ?? 'User' }}</div>
                                                    <div class="muted">{{ \Carbon\Carbon::parse($c->created_at)->format('M j, g:i A') }}</div>
                                                    <div>{{ $c->body }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <form action="{{ route('class-announcements.comments.store', $ann) }}" method="POST" style="margin-top:8px;">
                                        @csrf
                                        <div style="display:flex;gap:8px;align-items:flex-start">
                                            <textarea name="body" placeholder="Add a comment..." style="flex:1;min-height:60px;border:1px solid var(--border);border-radius:10px;padding:8px"></textarea>
                                            <button class="btn btn-blue" type="submit">Post</button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div id="paneClasswork" class="card" role="tabpanel" aria-labelledby="tabBtnClasswork" style="display:none">
                <!-- Container 1: Course Outline -->
                <div class="outline-cta" style="margin-bottom:12px;">
                    <div class="cta-left">
                        <div class="cta-icon"><i class="fas fa-list-ul"></i></div>
                        <div>
                            <div class="cta-title">Course Outline</div>
                            <div class="cta-desc">Browse modules, topics, and activities in the outline view.</div>
                        </div>
                    </div>
                    @php
                        $role = \Illuminate\Support\Facades\Auth::user()->role ?? null;
                        $coachCtx = !empty($asTrainer) || in_array($role, ['trainer','coach'], true) || \Illuminate\Support\Str::endsWith((string) $role, '_coach');
                        $outlineUrl = $coachCtx
                            ? route('trainer.courses.view', $course)
                            : route('trainee.courses.outline', $course);
                    @endphp
                    <a href="{{ $outlineUrl }}" class="btn-cta" aria-label="Open Course Outline"><i class="fas fa-list"></i> Course Outline</a>
                </div>

                <!-- Container 2: Materials and Assessments -->
                @php
                    $currentRole = \Illuminate\Support\Facades\Auth::user()->role ?? null;
                    $isTrainer = !empty($asTrainer) || (\Illuminate\Support\Facades\Auth::check() && (in_array($currentRole, ['trainer', 'coach'], true) || \Illuminate\Support\Str::endsWith((string) $currentRole, '_coach')));
                @endphp
                @if(!empty($asTrainer))
                <div class="container-box" id="progressContainer" style="margin-bottom:12px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <div class="section-head" style="margin:0;color:var(--text);font-weight:700;">
                            <div style="width:40px;height:40px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);"><i class="fas fa-table"></i></div>
                            <div style="font-size: 1.25rem; font-weight: 800; color: #1e293b;">Participant Progress</div>
                        </div>
                        <button id="notifyIncompleteBtn" class="btn-cta" style="background-color: #C9282D; padding: 12px 20px; font-size: 0.875rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);">
                            <i class="fas fa-bell"></i>
                            Notify Incomplete Participants
                        </button>
                    </div>
                    <div id="participantProgressFull" class="card" style="padding:0; border-radius: 12px; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);">
                        <div id="progressTableScroller" style="overflow:auto;border-bottom:1px solid #e2e8f0">
                            <table id="progressTable" style="border-collapse:collapse;width:100%;min-width:960px">
                                <thead style="background-color: #f1f5f9;"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                
            </div>
            <div id="paneForum" class="card" role="tabpanel" aria-labelledby="tabBtnForum" style="display:none">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="font-weight:800;color:#0f3b8f;display:flex;align-items:center;gap:8px"><i class="fas fa-comments"></i> Forum</div>
                        <div class="pro-input" style="padding:6px 10px;border-radius:999px;display:flex;align-items:center;gap:8px">
                            <i class="fas fa-search" style="color:#64748b"></i>
                            <input id="discussionSearch" type="search" placeholder="Search discussions" style="border:none;outline:none;background:transparent;width:200px;font:inherit;color:inherit" oninput="filterDiscussions()">
                        </div>
                    </div>
                    <button class="btn btn-blue" type="button" onclick="openDiscussionModal()"><i class="fas fa-plus"></i> Create Discussion</button>
                </div>
                <!-- Inline discussion composer -->
                <div id="discussionComposer" class="card" style="display:none;margin-bottom:12px;">
                    <h3 style="font-weight:800;color:#0f3b8f;display:flex;align-items:center;gap:8px;margin:0 0 6px">
                        <i class="fas fa-comments"></i> Create Discussion
                    </h3>
                    <div class="muted" style="margin-bottom:10px">Start a meaningful conversation with your class.</div>
                    <form id="discussionForm" action="{{ route('courses.discussions.store',$course) }}" method="POST" enctype="multipart/form-data" onsubmit="submitDiscussion(event)">
                        @csrf
                        @if(!empty($asTrainer))
                            <input type="hidden" name="as_trainer" value="1">
                        @endif
                        <input type="hidden" id="discussionMode" name="mode" value="text">
                        <div class="disc-tabs" role="tablist" aria-label="Create discussion input type">
                            <button type="button" id="discTabText" class="disc-tab active" role="tab" aria-selected="true" onclick="setDiscussionMode('text')"><i class="fas fa-font"></i> Text</button>
                            <button type="button" id="discTabMedia" class="disc-tab" role="tab" aria-selected="false" onclick="setDiscussionMode('media')"><i class="fas fa-images"></i> Images & Video</button>
                            <button type="button" id="discTabLink" class="disc-tab" role="tab" aria-selected="false" onclick="setDiscussionMode('link')"><i class="fas fa-link"></i> Link</button>
                        </div>
                        <label for="discussionTitle" class="discussion-label">Title</label>
                        <input id="discussionTitle" name="title" type="text" maxlength="200" oninput="updateDiscussionCounts()" placeholder="Enter a clear, concise title" class="pro-input">
                        <div class="counter" id="titleCount" aria-live="polite">0/200</div>
                        <div id="discFieldsText">
                            <label for="discussionBody" class="discussion-label">Body</label>
                            <textarea id="discussionBody" name="body" oninput="updateDiscussionCounts()" placeholder="Write at least 10 characters..." class="pro-textarea"></textarea>
                            <div class="counter" id="bodyCount" aria-live="polite">0 chars</div>
                        </div>
                        <div id="discFieldsMedia" style="display:none">
                            <div class="discussion-label" style="margin-bottom:8px">Upload</div>
                            <div id="discDrop" onclick="document.getElementById('discussionImage').click()" style="border:2px dashed #cbd5e1;border-radius:12px;padding:24px;text-align:center;color:#64748b;cursor:pointer">Drag and Drop or upload media</div>
                            <input id="discussionImage" name="image" class="discussion-file" type="file" accept="image/*" style="display:block;margin-top:8px" onchange="updateDiscussionCounts()">
                            <div class="muted" id="discFileName" style="margin-top:6px"></div>
                        </div>
                        <div id="discFieldsLink" style="display:none">
                            <label for="discussionLink" class="discussion-label">Link URL</label>
                            <input id="discussionLink" type="url" placeholder="https://example.com/article" oninput="updateDiscussionCounts()" class="pro-input">
                        </div>
                        <div id="discussionError" class="error-text" role="alert"></div>
                        <div class="post-cta" style="margin-top:12px;display:flex;gap:10px;justify-content:flex-end">
                            <a href="javascript:void(0)" onclick="closeDiscussionModal()" class="link-action">Cancel</a>
                            <button id="discussionSubmit" class="btn btn-disabled" type="submit" disabled>Create Discussion</button>
                        </div>
                    </form>
                </div>
                <div id="courseDiscussions" class="forum-list">
                    @if(($discussions ?? collect())->isEmpty())
                        <div class="muted">No discussions yet. Be the first to start one.</div>
                    @else
                        @foreach($discussions as $d)
                        @if(!(method_exists($d,'trashed') && $d->trashed()))
                        <div class="forum-card" id="disc-card-{{ $d->id }}" style="display:block; position:relative; cursor:pointer" data-disc-id="{{ $d->id }}" data-href="{{ route('discussions.show', ['discussion'=>$d]) }}">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                                <div style="display:flex;align-items:flex-start;gap:12px">
                                    @php $poster = $d->user; $n = $poster->name ?? 'User'; @endphp
                                    <img src="{{ $poster?->avatar_url }}" alt="Avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex:0 0 36px" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
                                    <div>
                                        <div class="forum-title" style="margin-bottom:4px">{{ $d->title }}</div>
                                        <div class="forum-meta">
                                            {{ \Carbon\Carbon::parse($d->created_at)->diffForHumans() }} by
                                            <a href="{{ route('users.profile', $poster) }}" style="color:#0f3b8f;text-decoration:none">{{ $n }}</a>
                                            • {{ $d->replies_count ?? ($d->replies->count() ?? 0) }} comments
                                        </div>
                                    </div>
                                </div>
                                @php $canDeleteDiscussion = auth()->check() && (auth()->id() === ($d->user_id ?? 0)); @endphp
                                @if($canDeleteDiscussion)
                                <div><a href="javascript:void(0)" class="link-action" onclick="deleteDiscussion('{{ route('discussions.destroy',$d) }}')"><i class="fas fa-trash"></i> Delete</a></div>
                                @endif
                            </div>
                            @if(!empty($d->image_path))
                                <div style="margin-top:8px">
                                    <img src="{{ asset('storage/'.$d->image_path) }}" alt="discussion image" style="max-width:100%;height:auto;max-height:420px;display:block;margin:0 auto;border-radius:10px;border:1px solid var(--border);object-fit:contain">
                                </div>
                            @endif
                            @php
                                $isUrlBody = filter_var(($d->body ?? ''), FILTER_VALIDATE_URL);
                            @endphp
                            <div style="margin-top:8px" data-disc-body>
                                @if($isUrlBody)
                                    <a href="{{ $d->body }}" target="_blank" rel="noopener" style="color:#0f3b8f;text-decoration:underline">{{ $d->body }}</a>
                                @else
                                    {{ $d->body }}
                                @endif
                            </div>
                            @php
                                $discLikeCount = 0; $discDislikeCount = 0;
                                if(\Illuminate\Support\Facades\Schema::hasTable('discussion_reactions')){
                                    $discLikeCount = \App\Models\DiscussionReaction::where('discussion_id',$d->id)->where('type','like')->count();
                                    $discDislikeCount = \App\Models\DiscussionReaction::where('discussion_id',$d->id)->where('type','dislike')->count();
                                }
                                $commentLikes = 0; $commentDislikes = 0;
                                foreach(($d->replies ?? collect()) as $r){
                                    if(!(method_exists($r,'trashed') && $r->trashed())){
                                        $commentLikes += ($r->reactions ?? collect())->where('type','like')->count();
                                        $commentDislikes += ($r->reactions ?? collect())->where('type','dislike')->count();
                                    }
                                    if(($r->children ?? collect())->isNotEmpty()){
                                        foreach($r->children as $c){
                                            if(!(method_exists($c,'trashed') && $c->trashed())){
                                                $commentLikes += ($c->reactions ?? collect())->where('type','like')->count();
                                                $commentDislikes += ($c->reactions ?? collect())->where('type','dislike')->count();
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <div style="padding-top:10px;margin-top:10px;border-top:1px solid var(--border);display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                                <button type="button" class="chip-action" style="display:inline-flex;align-items:center;gap:6px;border:1px solid var(--border);background:#fff;border-radius:999px;padding:6px 10px;cursor:pointer"
                                    onclick="reactDiscussion(event, {{ $d->id }}, 'like', 'disc-like-{{ $d->id }}', 'disc-dislike-{{ $d->id }}')">
                                    <i class="fas fa-thumbs-up"></i> <span id="disc-like-{{ $d->id }}">{{ $discLikeCount }}</span>
                                </button>
                                <button type="button" class="chip-action" style="display:inline-flex;align-items:center;gap:6px;border:1px solid var(--border);background:#fff;border-radius:999px;padding:6px 10px;cursor:pointer"
                                    onclick="reactDiscussion(event, {{ $d->id }}, 'dislike', 'disc-like-{{ $d->id }}', 'disc-dislike-{{ $d->id }}')">
                                    <i class="fas fa-thumbs-down"></i> <span id="disc-dislike-{{ $d->id }}">{{ $discDislikeCount }}</span>
                                </button>
                                <span class="chip-stat" style="display:inline-flex;align-items:center;gap:6px"><i class="fas fa-comments"></i> {{ $d->replies_count ?? ($d->replies->count() ?? 0) }}</span>
                                <a class="link-action" href="{{ route('discussions.show', ['discussion'=>$d]) }}" onclick="event.stopPropagation();" style="margin-left:auto"><i class="fas fa-eye"></i> View</a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div id="panePeople" class="card" role="tabpanel" aria-labelledby="tabBtnPeople" style="display:none">
                @php
                    // Prefer controller-provided lists for robust role coverage
                    $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
                    $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
                    $trainers = isset($coaches) ? collect($coaches) : $course->users->whereIn('role', $coachRoles);
                    $classmates = isset($classmates) ? collect($classmates) : $course->users->whereIn('role', $participantRoles);
                @endphp
                <div class="people">
                    <div>
                        <div style="font-weight:800;margin-bottom:8px;">Coaches</div>
                        <ul>
                            @php $meId = auth()->id(); @endphp
                            @forelse($trainers as $t)
                                <li style="padding:0;border:none;background:transparent;margin:0;">
                                    <button type="button" class="participant-item-btn" onclick="openParticipantView(@json($t->name), @json($t->email), 'Coach')" @if($meId && $t->id===$meId) style="background:#eef2ff;border:1px solid #cbd5e1" @endif>
                                        <i class="fas fa-user-tie" style="color:#0f3b8f;"></i> {{ $t->name }} @if($meId && $t->id===$meId) <span class="chip">You</span> @endif
                                    </button>
                                </li>
                            @empty
                                <li class="muted">No coaches listed.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <div style="font-weight:800;margin-bottom:8px;">Classmates</div>
                        <ul>
                            @forelse($classmates as $s)
                                <li style="padding:0;border:none;background:transparent;margin:0;">
                                    <button type="button" class="participant-item-btn" onclick="openParticipantView(@json($s->name), @json($s->email), 'Classmate')" @if($meId && $s->id===$meId) style="background:#eef2ff;border:1px solid #cbd5e1" @endif>
                                        <i class="fas fa-user" style="color:#0f3b8f;"></i> {{ $s->name }} @if($meId && $s->id===$meId) <span class="chip">You</span> @endif
                                    </button>
                                </li>
                            @empty
                                <li class="muted">No classmates listed.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Image Preview / Crop Modal -->
        <div id="imageModal" class="img-modal" role="dialog" aria-modal="true" aria-labelledby="imgModalTitle">
            <div class="wrap">
                <div class="head">
                    <div id="imgModalTitle" class="section-head" style="margin:0">Course Image</div>
                    <button class="round-btn" onclick="closeImageModal()" aria-label="Close">×</button>
                </div>
                <div class="body" id="imgModalBody">
                    <img id="previewImage" class="img-canvas" alt="Preview" />
                    <div class="preview-wrap">
                        <div class="preview-label">Display Preview</div>
                        <div class="ratio-bar">
                            <button class="ratio-btn active" data-ratio="1.7777777778" onclick="setAspect(this)">16:9</button>
                            <button class="ratio-btn" data-ratio="1" onclick="setAspect(this)">1:1</button>
                            <button class="ratio-btn" data-ratio="1.3333333333" onclick="setAspect(this)">4:3</button>
                            <button class="ratio-btn" data-ratio="free" onclick="setAspect(this)">Free</button>
                        </div>
                        <div class="img-preview" id="livePreview"></div>
                    </div>
                </div>
                <div class="foot">
                    <button class="back" onclick="closeImageModal()"><i class="fas fa-arrow-left"></i> Back</button>
                    <div id="imgActions" style="display:none;gap:8px">
                        <button class="btn btn-blue" onclick="uploadCropped()">Save Image</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- cropper assets removed --}}
        <script>
            let cropper = null;
            function openImagePreview(){
                const img = document.getElementById('courseHeroImage');
                const p = document.getElementById('previewImage');
                p.src = img?.src || '';
                document.getElementById('imgModalTitle').textContent = 'Course Image';
                document.getElementById('imgActions').style.display = 'none';
                document.getElementById('imageModal').style.display = 'flex';
            }
            function openCropperExisting(){
                const img = document.getElementById('courseHeroImage');
                const p = document.getElementById('previewImage');
                p.src = img?.src || '';
                document.getElementById('imgModalTitle').textContent = 'Crop Image';
                document.getElementById('imageModal').style.display = 'flex';
                document.getElementById('imgActions').style.display = 'flex';
                setTimeout(()=>{
                    if(cropper){ cropper.destroy(); }
                    cropper = new Cropper(p, {
                        aspectRatio: 16/9,
                        viewMode: 1,
                        background: false,
                        autoCropArea: 1,
                        guides: true,
                        center: true,
                        highlight: true,
                        preview: '#livePreview',
                        movable: true,
                        zoomable: true,
                        responsive: true
                    });
                    activateRatioBtn(document.querySelector('.ratio-btn[data-ratio="1.7777777778"]'));
                }, 50);
            }
            function openCropperFromFile(input){
                const file = input.files && input.files[0];
                if(!file) return;
                const url = URL.createObjectURL(file);
                const p = document.getElementById('previewImage');
                p.onload = () => { URL.revokeObjectURL(url); };
                p.src = url;
                document.getElementById('imgModalTitle').textContent = 'Crop Image';
                document.getElementById('imageModal').style.display = 'flex';
                document.getElementById('imgActions').style.display = 'flex';
                setTimeout(()=>{
                    if(cropper){ cropper.destroy(); }
                    cropper = new Cropper(p, {
                        aspectRatio: 16/9,
                        viewMode: 1,
                        background: false,
                        autoCropArea: 1,
                        guides: true,
                        center: true,
                        highlight: true,
                        preview: '#livePreview',
                        movable: true,
                        zoomable: true,
                        responsive: true
                    });
                    activateRatioBtn(document.querySelector('.ratio-btn[data-ratio="1.7777777778"]'));
                }, 50);
            }
            function closeImageModal(){
                document.getElementById('imageModal').style.display = 'none';
                if(cropper){ cropper.destroy(); cropper = null; }
                const input = document.getElementById('heroFileInput');
                if (input) input.value = '';
            }
            function setAspect(btn){
                if(!cropper) return;
                const val = btn.getAttribute('data-ratio');
                if(val === 'free'){ cropper.setAspectRatio(NaN); }
                else { cropper.setAspectRatio(parseFloat(val)); }
                activateRatioBtn(btn);
                const lp = document.getElementById('livePreview');
                if (val === 'free'){ lp.style.aspectRatio = 'auto'; }
                else { lp.style.aspectRatio = parseFloat(val); }
            }
            function activateRatioBtn(btn){
                document.querySelectorAll('.ratio-btn').forEach(b=>b.classList.remove('active'));
                if(btn) btn.classList.add('active');
            }
            function uploadCropped(){
                if(!cropper) return;
                const ratioBtn = document.querySelector('.ratio-btn.active');
                let w = 1600, h = 900;
                if(ratioBtn){
                    const r = ratioBtn.getAttribute('data-ratio');
                    if(r === '1'){ w = 1200; h = 1200; }
                    else if(r === '1.3333333333'){ w = 1600; h = 1200; }
                    else if(r === 'free'){ w = undefined; h = undefined; }
                }
                const canvas = cropper.getCroppedCanvas(w && h ? {width:w,height:h} : {});
                canvas.toBlob(function(blob){
                    const fd = new FormData();
                    fd.append('image', blob, 'course.jpg');
                    fetch("{{ url('/trainer/courses/'.$course->id.'/image') }}", {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: fd
                    }).then(r => r.json()).then(res=>{
                        if(res && res.ok){
                            const hero = document.getElementById('courseHeroImage');
                            if(hero){ hero.src = res.url; }
                            closeImageModal();
                        } else {
                            alert('Upload failed');
                        }
                    }).catch(()=>alert('Upload error'));
                }, 'image/jpeg', 0.92);
            }
            // image preview/crop disabled
        </script>
    </div>
    <div id="participantViewModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="participantViewTitle">
        <div class="participant-view-modal">
            <div class="participant-view-header">
                <h3 id="participantViewTitle" class="participant-view-title">Participant Details</h3>
                <button type="button" class="participant-view-close" onclick="closeParticipantView()" aria-label="Close">&times;</button>
            </div>
            <div class="participant-view-body">
                <div class="participant-view-row">
                    <span class="participant-view-label">Name</span>
                    <div id="participantViewName" class="participant-view-value">-</div>
                </div>
                <div class="participant-view-row">
                    <span class="participant-view-label">Role</span>
                    <div id="participantViewRole" class="participant-view-value">-</div>
                </div>
                <div class="participant-view-row" style="margin-bottom:0;">
                    <span class="participant-view-label">Email</span>
                    <div id="participantViewEmail" class="participant-view-value">-</div>
                </div>
            </div>
        </div>
    </div>
    <div id="announceModal" class="modal-overlay">
        <div class="modal">
            <form method="POST" action="{{ route('courses.class-announcements.store', $course) }}" onsubmit="handleAnnouncementSubmit(event)">
            @csrf
            <div class="modal-editor">
                <input type="text" name="title" id="announceTitle" placeholder="Title" oninput="updatePostButton()" style="width:100%;font-size:1.1rem;color:#0f172a;margin-bottom:6px;">
                <textarea id="announceText" name="body" placeholder="Announce something to your class" oninput="updatePostButton()"></textarea>
            </div>
            <div class="modal-toolbar">
                <button class="tool-btn" type="button"><strong>B</strong></button>
                <button class="tool-btn" type="button" style="font-style:italic">I</button>
                <button class="tool-btn" type="button" style="text-decoration:underline">U</button>
                <button class="tool-btn" type="button"><i class="fas fa-list-ul"></i></button>
                <button class="tool-btn" type="button"><i class="fas fa-strikethrough"></i></button>
            </div>
            <div class="modal-actions">
                <div class="round-set">
                    <button class="round-btn" type="button"><i class="fas fa-shapes"></i></button>
                    <button class="round-btn" type="button"><i class="fas fa-video"></i></button>
                    <button class="round-btn" type="button"><i class="fas fa-upload"></i></button>
                    <button class="round-btn" type="button"><i class="fas fa-link"></i></button>
                </div>
                <div class="post-cta">
                    <a href="javascript:void(0)" onclick="closeAnnouncementModal()" class="link-action">Cancel</a>
                    <button id="postBtn" class="btn btn-disabled" type="submit" disabled>Post</button>
                    <button class="tool-btn" type="button"><i class="fas fa-caret-down"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Removed modal; using inline composer above -->
    <script>
        (function startDiscussionUpdates(){
            var lastTs = null;
            var url = '{{ route('courses.discussions.updates', $course) }}';
            function tick(){
                var qs = lastTs ? ('?since='+encodeURIComponent(lastTs)) : '';
                fetch(url+qs, {headers:{'Accept':'application/json'}}).then(r=>r.json()).then(function(data){
                    if(!data) return;
                    (data.discussions_force_deleted||[]).forEach(function(id){
                        var el = document.getElementById('disc-card-'+id);
                        if(el) el.remove();
                    });
                    (data.discussions_soft_deleted||[]).forEach(function(id){
                        var el = document.getElementById('disc-card-'+id);
                        if(el){
                            var note = el.querySelector('.deleted-note');
                            if(!note){
                                var n = document.createElement('div');
                                n.className = 'muted deleted-note';
                                n.textContent = 'This discussion was deleted by its author.';
                                n.style.marginTop = '8px';
                                el.appendChild(n);
                            }
                        }
                    });
                    (data.replies_soft_deleted||[]).forEach(function(id){
                        var el = document.getElementById('reply-'+id);
                        if(el){
                            var already = el.querySelector('.reply-deleted-note');
                            if(!already){
                                var n = document.createElement('div');
                                n.className = 'muted reply-deleted-note';
                                n.textContent = 'This reply was deleted by its author.';
                                n.style.margin = '4px 0 6px';
                                el.appendChild(n);
                            }
                        }
                    });
                    if(data.since){ lastTs = data.since; }
                }).catch(function(){});
            }
            setInterval(tick, 8000);
        })();
        function toggleReplyForm(id){
            var el=document.getElementById(id);
            if(!el) return;
            el.style.display = (el.style.display==='none'||el.style.display==='') ? 'block':'none';
        }
        function postReply(e, discussionId, parentId, taId){
            e.preventDefault();
            var ta = document.getElementById(taId);
            if(!ta || !ta.value.trim()) return false;
            var form = e.target;
            var data = new FormData(form);
            if(parentId){ data.set('parent_id', parentId); }
            fetch(form.action, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json'},
                body: data
            }).then(r=>r.json()).then(function(res){
                if(res && res.ok){
                    window.location.reload(); // simplest: reload to reflect new nested structure
                }else{
                    alert('Failed to post reply');
                }
            }).catch(function(){ alert('Failed to post reply'); });
            return false;
        }
        function reactReply(replyId, type, likeId, dislikeId){
            fetch('{{ url('/replies') }}/'+replyId+'/react', {
                method:'POST',
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json','Content-Type':'application/json'},
                body: JSON.stringify({type:type})
            }).then(r=>r.json()).then(function(res){
                if(res && res.ok){
                    var lk=document.getElementById(likeId);
                    var dk=document.getElementById(dislikeId);
                    if(lk) lk.textContent = res.likes;
                    if(dk) dk.textContent = res.dislikes;
                }
            }).catch(function(){});
        }
        function reactDiscussion(ev, id, type, likeId, dislikeId){
            if(ev && ev.stopPropagation) ev.stopPropagation();
            var token = (document.querySelector('#discussionForm input[name=\"_token\"]')||{}).value || '{{ csrf_token() }}';
            fetch('{{ url('/discussions') }}/'+id+'/react', {
                method:'POST',
                headers:{'X-CSRF-TOKEN': token, 'Accept':'application/json','Content-Type':'application/json'},
                body: JSON.stringify({type:type})
            }).then(r=>r.json()).then(function(res){
                if(res && res.ok){
                    var lk=document.getElementById(likeId);
                    var dk=document.getElementById(dislikeId);
                    if(lk) lk.textContent = res.likes;
                    if(dk) dk.textContent = res.dislikes;
                }
            }).catch(function(){});
        }
        async function deleteReply(replyId){
            if(!await window.capdevConfirm('Delete this reply?', { title: 'Delete Reply', confirmText: 'Delete' })) return;
            fetch('{{ url('/replies') }}/'+replyId, {
                method:'DELETE',
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
            }).then(function(r){
                if(r.ok){ window.location.reload(); return; }
                if(r.status===403){
                    r.json().then(function(j){ alert(j.message || 'You can only delete your own reply.'); }).catch(function(){ alert('You can only delete your own reply.'); });
                } else {
                    alert('Failed to delete reply');
                }
            }).catch(function(){ alert('Failed to delete reply'); });
        }
        function deleteDiscussion(url){
            openDeleteConfirm('Delete Discussion','This will permanently remove the discussion.', function(){
                var form = new URLSearchParams();
                form.append('_method','DELETE');
                fetch(url, {
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json','Content-Type':'application/x-www-form-urlencoded'},
                    body: form.toString()
                }).then(function(r){
                    if(r.ok){
                        return r.json().catch(function(){ return { ok:true }; });
                    }
                    if(r.status===403){
                        return r.json().then(function(j){ throw new Error(j.message || 'You can only delete your own discussion.'); });
                    }
                    // Handle redirect-as-success edge cases
                    if(r.redirected){ return { ok:true }; }
                    throw new Error('Failed to delete discussion');
                }).then(function(j){
                    if(j && j.ok){
                        showSuccessToast('Discussion deleted.');
                        setTimeout(function(){ window.location.reload(); }, 600);
                    } else {
                        throw new Error('Failed to delete discussion');
                    }
                }).catch(function(err){
                    alert(err && err.message ? err.message : 'Failed to delete discussion');
                });
            });
        }
        // Navigate to discussion when a card is clicked (except on controls/links/forms)
        document.addEventListener('DOMContentLoaded', function(){
            var list = document.getElementById('courseDiscussions');
            if(!list) return;
            list.addEventListener('click', function(ev){
                var isControl = ev.target.closest('.link-action, .chip-action, form, textarea, button, a');
                if(isControl) return;
                var card = ev.target.closest('.forum-card[data-href]');
                if(card && card.dataset.href){
                    window.location.href = card.dataset.href;
                }
            });
        });
        // Live progress refresh for overall and per-module breakdown
        (function(){
            var ring = document.getElementById('overallRing');
            var detail = document.getElementById('overallDetail');
            var list = document.getElementById('moduleProgressList');
            if(!ring) return;

            ring.addEventListener('click', function(){
                var currentPct = parseInt(ring.textContent);
                if(currentPct >= 100 && typeof showCongrats === 'function'){
                    showCongrats();
                }
            });

            var url = "{{ route('courses.progress.json', $course) }}";
            var outlineUrl = "{{ route('trainee.courses.outline', $course) }}";
            function refreshProgress(){
                fetch(url, {credentials:'same-origin'}).then(function(r){
                    if(!r.ok) return null;
                    return r.json();
                }).then(function(j){
                    if(!j) return;
                    var pct = (j.overall && typeof j.overall.percent==='number') ? j.overall.percent : {{ $completion }};
                    var done = (j.overall && j.overall.done) || 0;
                    var total = (j.overall && j.overall.total) || 0;
                    ring.style.setProperty('--deg', (pct*3.6)+'deg');
                    ring.textContent = pct+'%';
                    if(pct >= 100){
                        ring.style.cursor = 'pointer';
                        ring.title = 'Click to see congratulations!';
                    } else {
                        ring.style.cursor = 'default';
                        ring.title = '';
                    }
                    if(detail){ 
                        let parts = [];
                        if(j.overall.topics_total > 0) parts.push(j.overall.topics_done + '/' + j.overall.topics_total + ' topics');
                        if(j.overall.assessments_total > 0) parts.push(j.overall.assessments_done + '/' + j.overall.assessments_total + ' assessments');
                        detail.textContent = parts.length ? '(' + parts.join(', ') + ')' : '';
                    }
                    if(list && Array.isArray(j.modules)){
                        list.innerHTML = j.modules.map(function(m, idx){
                            var isExam = !!m.is_exam;
                            var header = isExam
                                ? ('Module Exam: ' + (m.exam_title || m.title || ''))
                                : ('Module ' + (idx+1) + ': ' + (m.title || ''));
                            var p = Math.max(0, Math.min(100, m.percent || 0));
                            var d = m.done || 0;
                            var t = m.total || 0;
                            var body = isExam
                                ? '<div style="padding:12px 14px;color:#0f3b8f;font-weight:800"><span style="color:#6b7280;font-weight:700">Exam</span></div>'
                                : '<div style="padding:12px 14px">'+
                                  '<div style="height:10px;background:#e5e7eb;border-radius:999px;overflow:hidden;margin:6px 0 10px 0">'+
                                    '<div style="height:100%;width:'+p+'%;background:#22c55e;border-radius:999px"></div>'+
                                  '</div>'+
                                  '<div style="display:flex;align-items:center;justify-content:space-between;color:#0f3b8f;font-weight:800">'+
                                    '<span style="color:#6b7280;font-weight:700">'+d+'/'+t+' topics</span>'+
                                    '<span>'+p+'%</span>'+
                                  '</div>'+
                                '</div>';
                            var href = outlineUrl + '?mi=' + encodeURIComponent(idx);
                            return ''+
                            '<a href="'+href+'" style="text-decoration:none;color:inherit;display:block">'+
                              '<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 8px 20px rgba(2,6,23,.06);overflow:hidden;margin:10px 0">'+
                                '<div style="background:#0f3b8f;color:#fff;font-weight:800;padding:12px 14px">'+
                                  header+
                                '</div>'+ body +
                              '</div>'+
                            '</a>';
                        }).join('');
                    }
                }).catch(function(){});
            }
            refreshProgress();
            setInterval(refreshProgress, 15000);
            window.addEventListener('storage', function(e){
                if(e && e.key === 'course_progress_broadcast'){ refreshProgress(); }
            });
        })();
    </script>
    <script>
        function showParticipantProgress(){
            const hero = document.querySelector('.hero');
            const content = document.querySelector('.content');
            const full = document.getElementById('participantProgressFull');
            if(hero){ hero.style.display='none'; }
            if(content){
                Array.from(content.children).forEach(ch=>{
                    if(ch.id !== 'participantProgressFull'){ ch.style.display='none'; }
                });
            }
            if(full){ full.style.display='block'; }
            renderParticipantProgress();
        }
        function showAccessControl(){
            const hero = document.querySelector('.hero');
            const content = document.querySelector('.content');
            const full = document.getElementById('participantProgressFull');
            if(hero){ hero.style.display=''; }
            if(full){ full.style.display='none'; }
            // Restore Classwork tab as the visible pane
            const paneClass = document.getElementById('paneClasswork');
            if(content){
                Array.from(content.children).forEach(ch=> ch.style.display='none');
            }
            if(paneClass){ paneClass.style.display='block'; }
        }
        function gradeCell(v, pass){
            if(v==null) return `<td style="text-align:center;background:#f8fafc;color:#64748b">--/100</td>`;
            const pct = parseInt(v,10)||0;
            let bg='#eef7ee', color='#166534', border='#bbf7d0';
            if(pass!=null){
                if(pct>=pass){ bg='#ecfdf5'; color='#065f46'; border='#bbf7d0'; }
                else{ bg='#fef2f2'; color='#991b1b'; border='#fecaca'; }
            }
            return `<td style="text-align:center;background:${bg};color:${color};border-bottom:1px solid #e5e7eb;border-left:1px solid ${border};border-right:1px solid ${border}">${pct}/100</td>`;
        }
        function isManualExamKind(kind){
            return ['essay', 'enumeration', 'identification'].includes(String(kind || ''));
        }
        function manualExamKindLabel(kind){
            const labels = { essay: 'Essay', enumeration: 'Enumeration', identification: 'Identification' };
            return labels[String(kind || '')] || 'Manual';
        }
        function ensureEssayReviewModal(){
            let modal = document.getElementById('essayReviewModal');
            if(modal) return modal;
            modal = document.createElement('div');
            modal.id = 'essayReviewModal';
            modal.style.cssText = 'position:fixed;inset:0;background:rgba(15,23,42,.55);display:none;align-items:center;justify-content:center;z-index:5000;padding:20px';
            modal.innerHTML = `
                <div style="width:min(980px,96vw);max-height:90vh;overflow:auto;background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 30px 60px rgba(2,6,23,.28)">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;padding:16px 18px;border-bottom:1px solid #e5e7eb">
                        <div>
                            <div style="font-weight:900;color:#0f172a" id="essayReviewTitle">Exam Submission</div>
                            <div class="muted" id="essayReviewMeta"></div>
                        </div>
                        <button type="button" id="essayReviewClose" class="btn btn-ghost" style="border-radius:12px">Close</button>
                    </div>
                    <div id="essayReviewBody" style="padding:18px"></div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('#essayReviewClose').onclick = ()=>{ modal.style.display = 'none'; };
            modal.addEventListener('click', (e)=>{ if(e.target === modal){ modal.style.display = 'none'; } });
            return modal;
        }
        async function openEssayReviewModal(userId, moduleIndex, examTitle){
            const modal = ensureEssayReviewModal();
            const titleEl = modal.querySelector('#essayReviewTitle');
            const metaEl = modal.querySelector('#essayReviewMeta');
            const bodyEl = modal.querySelector('#essayReviewBody');
            titleEl.textContent = examTitle || 'Exam Submission';
            metaEl.textContent = 'Loading submission...';
            bodyEl.innerHTML = '<div class="muted">Loading submission...</div>';
            modal.style.display = 'flex';
            try{
                const res = await fetch("{{ route('courses.module-exam.attempt', $course) }}?mi="+encodeURIComponent(moduleIndex)+"&user_id="+encodeURIComponent(userId), {credentials:'same-origin'});
                const data = res.ok ? await res.json() : null;
                if(!data || !data.ok || !data.attempt){
                    metaEl.textContent = '';
                    bodyEl.innerHTML = '<div class="muted">Failed to load submission.</div>';
                    return;
                }
                const attempt = data.attempt;
                titleEl.textContent = `${examTitle || 'Module Exam'} - ${attempt.user_name || 'Participant'}`;
                metaEl.textContent = `${attempt.status_label || 'Completed'} | Submitted ${attempt.submitted_at ? String(attempt.submitted_at).replace('T',' ').replace('Z','') : 'N/A'}`;
                bodyEl.innerHTML = `
                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px">
                        <span class="chip">${attempt.final_pct ?? 0}%</span>
                        <span class="chip">${attempt.objective_correct ?? 0}/${attempt.objective_total ?? 0} objective</span>
                        ${(attempt.manual_pending_count ?? attempt.essay_pending_count) ? `<span class="chip" style="background:#fff7ed;border-color:#fdba74;color:#b45309">${attempt.manual_pending_count ?? attempt.essay_pending_count} pending manual review</span>` : ''}
                    </div>
                    <div style="display:grid;gap:14px">
                        ${(attempt.items || []).map(item=>{
                            if(isManualExamKind(item.type)){
                                return `
                                    <div class="forum-card" data-question-index="${item.question_index}">
                                        <div style="font-size:0.78rem;font-weight:800;color:#2563eb;text-transform:uppercase;margin-bottom:6px">${manualExamKindLabel(item.type)}</div>
                                        <div style="font-size:1rem;font-weight:800;color:#0f172a;margin-bottom:10px">${item.text || 'Manual Question'}</div>
                                        <div style="padding:12px;border:1px solid #e5e7eb;border-radius:12px;background:#f8fafc;white-space:pre-wrap;margin-bottom:12px">${item.answer_text || 'No answer submitted.'}</div>
                                        <div style="display:grid;grid-template-columns:minmax(150px,180px) 1fr;gap:12px">
                                            <label style="display:grid;gap:6px">
                                                <span class="muted" style="font-weight:700">Score / ${item.max_points ?? 1}</span>
                                                <input type="number" min="0" max="${item.max_points ?? 1}" step="0.01" class="essay-score-input" value="${item.score ?? ''}" style="padding:10px;border:1px solid #e5e7eb;border-radius:10px">
                                            </label>
                                            <label style="display:grid;gap:6px">
                                                <span class="muted" style="font-weight:700">Feedback</span>
                                                <textarea class="essay-feedback-input" rows="3" style="padding:10px;border:1px solid #e5e7eb;border-radius:10px">${item.feedback || ''}</textarea>
                                            </label>
                                        </div>
                                        <div style="margin-top:8px;font-size:0.82rem;font-weight:800;color:${item.status === 'checked' ? '#166534' : '#b45309'}">${item.status === 'checked' ? 'Checked' : 'Pending Review'}</div>
                                    </div>
                                `;
                            }
                            const answerText = item.answer == null ? 'No answer' : String(item.answer);
                            return `
                                <div class="forum-card">
                                    <div style="font-size:0.78rem;font-weight:800;color:#64748b;text-transform:uppercase;margin-bottom:6px">${String(item.type || 'question').replace(/_/g,' ')}</div>
                                    <div style="font-size:1rem;font-weight:800;color:#0f172a;margin-bottom:8px">${item.text || 'Question'}</div>
                                    <div class="muted">Answer: ${answerText}</div>
                                    <div style="margin-top:6px;font-weight:800;color:${item.is_correct ? '#166534' : '#b91c1c'}">${item.is_correct ? 'Correct' : 'Incorrect'}</div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px">
                        <button type="button" id="essayReviewSaveBtn" class="btn btn-blue" style="border-radius:12px">Save Review</button>
                    </div>
                `;
                const saveBtn = bodyEl.querySelector('#essayReviewSaveBtn');
                if(saveBtn){
                    saveBtn.onclick = async ()=>{
                        const reviewCards = Array.from(bodyEl.querySelectorAll('[data-question-index]'));
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
                        try{
                            const saveRes = await fetch("{{ route('courses.module-exam.review', $course) }}", {
                                method:'POST',
                                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                                credentials:'same-origin',
                                body: JSON.stringify({mi: moduleIndex, user_id: userId, reviews})
                            });
                            const saved = await saveRes.json().catch(()=>null);
                            if(saved && saved.ok){
                                await openEssayReviewModal(userId, moduleIndex, examTitle);
                                renderParticipantProgress();
                            }else{
                                alert(saved && saved.error ? saved.error : 'Failed to save review.');
                            }
                        }catch(e){
                            alert('Failed to save review.');
                        }finally{
                            saveBtn.disabled = false;
                            saveBtn.textContent = 'Save Review';
                        }
                    };
                }
            }catch(e){
                metaEl.textContent = '';
                bodyEl.innerHTML = '<div class="muted">Failed to load submission.</div>';
            }
        }
        function renderExamProgressCell(user, plan, score){
            const pct = score?.exam_pct;
            const statusLabel = score?.exam_status === 'pending_review'
                ? 'Pending Review'
                : score?.exam_status === 'partially_graded'
                    ? 'Partially Graded'
                    : score?.exam_passed === true
                        ? 'Passed'
                        : score?.exam_passed === false
                            ? 'Failed'
                            : score?.exam_status === 'completed'
                                ? (score?.exam_status_label || 'Completed')
                        : 'No Submission';
            const statusColor = score?.exam_status === 'pending_review'
                ? '#b45309'
                : score?.exam_status === 'partially_graded'
                    ? '#0f3b8f'
                    : score?.exam_passed === false
                        ? '#b91c1c'
                        : '#166534';
            const manualPendingCount = score?.manual_pending_count ?? score?.essay_pending_count ?? 0;
            const pendingBadge = manualPendingCount > 0
                ? `<div style="margin-top:6px;font-size:0.72rem;font-weight:800;color:#b45309">${manualPendingCount} pending manual review</div>`
                : '';
            const canReview = score?.exam_has_submission === true || score?.exam_status || score?.exam_pct != null;
            const reviewBtn = canReview
                ? `<button type="button" class="btn btn-ghost js-review-attempt-btn" data-user-id="${user.user_id}" data-module-index="${plan.mi}" data-exam-title="${String(plan.title || 'Module Exam').replace(/"/g, '&quot;')}" style="margin-top:8px;border-radius:10px;padding:6px 10px;cursor:pointer;position:relative;z-index:2; font-weight: 600; color: #475569; background-color: #f1f5f9; border: 1px solid #e2e8f0;">View Attempt</button>`
                : `<button type="button" class="btn btn-ghost" style="margin-top:8px;border-radius:10px;padding:6px 10px;opacity:.55;cursor:not-allowed" disabled title="The trainee has not submitted this exam yet.">No Attempt Yet</button>`;
            
            let retakeBtn = '';
            if (score?.exam_passed === false) {
                if (score?.retake_approved) {
                    retakeBtn = `<div style="margin-top:8px;font-size:0.72rem;font-weight:800;color:#0f3b8f">Retake Approved</div>`;
                } else if (score?.retake_requested) {
                    retakeBtn = `<button type="button" class="btn btn-blue js-allow-retake-btn" data-user-id="${user.user_id}" data-module-index="${plan.mi}" style="margin-top:8px;border-radius:10px;padding:6px 10px;font-size:0.7rem;background:#0f3b8f">Allow Retake</button>`;
                }
            }

            return gradeCell(pct, plan.pass ?? null).replace('</td>', `${pendingBadge}<div style="display: inline-block; padding: 4px 12px; border-radius: 9999px; font-weight: 600; color: ${statusColor}; background-color: ${statusColor}1a;">${statusLabel}</div>${reviewBtn}${retakeBtn}</td>`);
        }
        async function renderParticipantProgress(){
            const info = document.getElementById('progressInfo');
            const thead = document.querySelector('#progressTable thead');
            const tbody = document.querySelector('#progressTable tbody');
            if(thead){ thead.innerHTML=''; }
            if(tbody){ tbody.innerHTML=''; }
            if(info){ info.textContent='Loading participant progress…'; }
            try{
                const r = await fetch("{{ route('trainer.courses.participants-progress', $course) }}", {credentials:'same-origin'});
                const j = r.ok ? await r.json() : null;
                if(!j || !j.ok){ if(info) info.textContent='Failed to load.'; return; }
                const mods = Array.isArray(j.modules)?j.modules:[];
                const users = Array.isArray(j.users)?j.users:[];
                const h1 = ['<th style="position:sticky;left:0;background:#f1f5f9;z-index:2;text-align:left;padding:12px 16px;border-bottom:1px solid #e2e8f0; font-weight: 600; color: #475569;">Participant\'s Name</th>'];
                const colPlan = [];
                mods.forEach((m, idx)=>{
                    const baseTitle = (m && m.title) ? m.title : `Module ${idx+1}`;
                    if((m?.total_subs||0) > 0){
                        h1.push(`<th style="text-align:center;padding:12px 16px;border-bottom:1px solid #e2e8f0; font-weight: 600; color: #475569;">Module ${idx+1}: ${baseTitle}</th>`);
                        colPlan.push({type:'module', mi: idx});
                    }
                    const examTitle = (m && m.exam_title) ? m.exam_title : '';
                    if(examTitle){
                        h1.push(`<th style="text-align:center;padding:12px 16px;border-bottom:1px solid #e2e8f0; font-weight: 600; color: #475569;">Module Exam: ${examTitle}</th>`);
                        colPlan.push({type:'exam', mi: idx, pass: m?.passing_score ?? null, title: examTitle});
                    }
                });
                h1.push(`<th style="text-align:center;padding:12px 16px;border-bottom:1px solid #e2e8f0; font-weight: 600; color: #475569;">Notify</th>`);
                if(thead){ thead.innerHTML = `<tr>${h1.join('')}</tr>`; }
                const rows = users.map(u=>{
                    const first = `<td style="position:sticky;left:0;background:#fff;z-index:1;padding:12px 16px;border-bottom:1px solid #e2e8f0;font-weight:700;color:#1e293b">${u.name||('User '+u.user_id)}</td>`;
                    const cells = colPlan.map(plan=>{
                        const s = u.scores?.[plan.mi] || {};
                        if(plan.type==='module'){
                            const hasTotal = (mods[plan.mi]?.total_subs||0) > 0;
                            if(!hasTotal) return `<td style="text-align:center;background:#f8fafc;color:#64748b">--%</td>`;
                            const pct = (s.module_pct==null) ? null : (parseInt(s.module_pct,10)||0);
                            if(pct===null) return `<td style="text-align:center;background:#f8fafc;color:#64748b">--%</td>`;
                            return `<td style="text-align:center;background:#fff;color:#166534;border-bottom:1px solid #e2e8f0"><div style="width: 100%; background-color: #e2e8f0; border-radius: 9999px;"><div style="width: ${pct}%; background-color: #22c55e; color: #fff; border-radius: 9999px; text-align: center; font-weight: 600;">${pct}%</div></div></td>`;
                        }else{
                            return renderExamProgressCell(u, plan, s);
                        }
                    }).join('');
                    const notifyBtn = `<td style="text-align:center;border-bottom:1px solid #e2e8f0">
                        <button onclick="notifyIndividual(${u.user_id}, this)" class="btn-cta" style="background-color: #C9282D; padding: 8px 12px; font-size: 0.8rem; border-radius: 6px;">
                            <i class="fas fa-bell"></i> Notify
                        </button>
                    </td>`;
                    return `<tr>${first}${cells}${notifyBtn}</tr>`;
                }).join('');
                if(tbody){
                    if(users.length === 0){
                        const span = colPlan.length + 1; // +1 for name column
                        tbody.innerHTML = `<tr><td colspan="${span}" style="text-align:center;padding:16px;color:#64748b;border-top:1px solid #e5e7eb;border-bottom:1px solid #e5e7eb;background:#ffffff">No Participants Yet</td></tr>`;
                    } else {
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.js-review-attempt-btn').forEach(btn => {
                            btn.addEventListener('click', ()=>{
                                const userId = Number(btn.getAttribute('data-user-id'));
                                const moduleIndex = Number(btn.getAttribute('data-module-index'));
                                const examTitle = btn.getAttribute('data-exam-title') || 'Module Exam';
                                openEssayReviewModal(userId, moduleIndex, examTitle);
                            });
                        });
                        tbody.querySelectorAll('.js-allow-retake-btn').forEach(btn => {
                            btn.addEventListener('click', async ()=>{
                                const userId = Number(btn.getAttribute('data-user-id'));
                                const moduleIndex = Number(btn.getAttribute('data-module-index'));
                                if (!await window.capdevConfirm('Allow this participant to retake the exam?', { title: 'Allow Retake', confirmText: 'Allow' })) return;
                                
                                btn.disabled = true;
                                btn.textContent = 'Allowing...';
                                try {
                                    const resp = await fetch("{{ route('courses.module-exam.approve-retake', $course) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ user_id: userId, mi: moduleIndex })
                                    });
                                    const data = await resp.json();
                                    if (data && data.ok) {
                                        renderParticipantProgress();
                                    } else {
                                        alert(data.error || 'Failed to approve retake.');
                                        btn.disabled = false;
                                        btn.textContent = 'Allow Retake';
                                    }
                                } catch (e) {
                                    alert('Failed to approve retake.');
                                    btn.disabled = false;
                                    btn.textContent = 'Allow Retake';
                                }
                            });
                        });
                    }
                }
                if(info){ info.textContent=''; }
            }catch(e){
                if(info){ info.textContent='Failed to load.'; }
            }
        }
        document.addEventListener('DOMContentLoaded', function(){
            if(document.getElementById('progressTable')){
                renderParticipantProgress();
            }
        });
    </script>
    <script>
        function toggleAccessCode(button) {
            const parent = button.closest('.course-code');
            const masked = parent.querySelector('.access-code-masked');
            const visible = parent.querySelector('.access-code-visible');
            const icon = button.querySelector('i');

            if (masked.style.display === 'none') {
                masked.style.display = 'inline';
                visible.style.display = 'none';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                masked.style.display = 'none';
                visible.style.display = 'inline';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        async function notifyIndividual(userId, btn) {
            if (await window.capdevConfirm('Send an email reminder to this participant about their incomplete activities?', { title: 'Send Reminder', confirmText: 'Send' })) {
                const originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch("{{ route('trainer.courses.notify-incomplete', $course) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ user_id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    alert(data.message);
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    console.error('Error:', error);
                    alert('An error occurred while sending the notification.');
                });
            }
        }

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
    </script>

<script>
document.getElementById('notifyIncompleteBtn').addEventListener('click', async function() {
    // Show a confirmation dialog
    if (await window.capdevConfirm('Are you sure you want to send email reminders to all participants with incomplete activities?', { title: 'Send Reminders', confirmText: 'Send' })) {
        // Disable the button to prevent multiple clicks
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

        // Send an AJAX request to the server
        fetch("{{ route('trainer.courses.notify-incomplete', $course) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Re-enable the button and restore its original text
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-bell"></i> Notify Incomplete Participants';

            // Show a success message
            alert(data.message);
        })
        .catch(error => {
            // Re-enable the button and restore its original text
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-bell"></i> Notify Incomplete Participants';

            // Show an error message
            console.error('Error:', error);
            alert('An error occurred while sending notifications.');
        });
    }
});
</script>

</body>
</html>
 
