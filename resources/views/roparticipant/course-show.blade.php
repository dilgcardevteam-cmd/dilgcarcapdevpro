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
        .app-header{background:#fff;min-height:80px;padding:10px 20px;box-shadow:0 2px 4px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:20}
        .app-header-left{display:flex;align-items:center;gap:12px}
        .app-header-logo{height:48px}
        .app-header-right a{color:#1a1a1a;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:6px}
        .round-btn{width:40px;height:40px;border-radius:50%;border:1px solid #dfe3ea;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#0f3b8f}
        .topbar{display:flex;align-items:center;justify-content:space-between;background:#fff;border-bottom:1px solid var(--border);padding:10px 16px;position:sticky;top:80px;z-index:10}
        .back{color:#0d6efd;text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid var(--border);border-radius:999px;background:#fff}
        .layout{display:grid;grid-template-columns:320px 1fr;height:calc(100vh - 56px)}
        .sidebar{border-right:1px solid var(--border);background:var(--blue);display:flex;flex-direction:column}
        .sidebar h3{margin:12px 12px 8px;color:#fff;font-size:1rem}
        .search{padding:0 12px 12px}
        .search input{width:90%;padding:8px 12px;border:1px solid rgba(255,255,255,0.25);border-radius:8px;background:#fff}
        .outline{overflow:auto;padding:8px 8px 16px}
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
        .subs{margin:8px 0 6px 0;padding:10px;border:1px solid var(--border);border-radius:10px;display:none;background:#f8fafc;box-shadow:0 2px 6px rgba(0,0,0,0.05)}
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
        .pane{background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px}
        .pane h2{margin:6px 0 14px;color:#111827;font-size:1.75rem;font-weight:800;letter-spacing:-0.015em}
        .lock{display:flex;align-items:center;justify-content:center;height:420px;background:#e6eef7;border:2px dashed #bcd2ea;border-radius:12px;color:#223}
        .chips{display:flex;gap:8px;flex-wrap:wrap}
        .chip{background:#f1f5f9;border-radius:999px;border:1px solid var(--border);padding:4px 8px}
        .field{border:1px solid var(--border);border-radius:14px;margin:12px 0;padding:20px;background:#fff;min-height:96px}
        #contentBody .field:nth-child(even){background:#f8fafc}
        .subgroup{margin:10px 0 18px}
        .subheader{background:#f8fafc;border:1px solid var(--border);border-radius:8px;padding:10px 12px;font-weight:700;color:#111827;font-size:1.1rem;display:flex;align-items:center;justify-content:space-between}
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
        .mc .mc-option.selected .mc-radio{border-color:#fff;background:transparent;box-shadow:inset 0 0 0 6px #06b6d4, 0 0 0 2px #fff}
        .mc-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:16px}
        .btn-green{flex:1;min-width:160px;background:var(--b);color:#fff;border:none;border-radius:12px;padding:14px 16px;font-weight:700;cursor:pointer}
        .btn-green:disabled{background:#e5e7eb;color:#9ca3af;cursor:not-allowed}
        .mc-feedback{margin-top:8px;font-weight:700}
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
        .topbar{
            padding:8px 20px;
            min-height:56px;
            background:#fff;
            border-bottom:1px solid #e5e7eb;
            box-shadow:0 2px 6px rgba(15,23,42,.06);
            position:fixed;
            top:0;
            left:250px;
            right:0;
            z-index:30;
        }
        .layout{height:100vh;grid-template-columns:250px 1fr}
        .content{padding-top:72px}
        .sidebar{
            background:#002C76;
            border-right:1px solid rgba(255,255,255,.12);
            padding-top:0;
            
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
            gap:12px;
            color:#fff;
            border-bottom:1px solid rgba(255,255,255,.12);
            border-left:4px solid var(--green);
            background:rgba(255,255,255,.08);
        }
        .search{padding:10px 16px 6px;display:flex;justify-content:center}
        .search input{
            width:92%;
            padding:9px 12px;
            border-radius:12px;
            border:1px solid rgba(255,255,255,.35);
            box-shadow:inset 0 1px 1px rgba(0,0,0,.04);
        }
        .outline{padding:6px 12px 16px}
        .module{
            border-radius:12px;
            box-shadow:0 6px 12px rgba(15,23,42,.1);
            margin:10px 6px;
            border:1px solid #dbe2ee;
            overflow:hidden;
        }
        .module-header{
            background:#ffffff;
            border-radius:12px 12px 0 0;
            padding:12px 14px;
        }
        .module-title{font-weight:800;color:#0f172a}
        .module-kpi{color:var(--muted)}
        .module-bar{background:#e6eefc}
        .module-bar > span{background:linear-gradient(90deg,#1d4ed8,#2563eb)}
        .topic{background:#f1f5f9}
        .topic.active{background:#dbeafe}
        .sub-item{border-radius:12px}
        .sub-item.active{background:#eef2ff;border-left:3px solid var(--blue-500)}
        .pane{
            border-radius:16px;
            box-shadow:0 12px 24px rgba(15,23,42,.12);
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
        .topbar > div:nth-child(2){
            font-weight:800;
            font-size:1.6rem;
            color:var(--blue-700);
            letter-spacing:-.01em;
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
    
    <div class="topbar">
        <div>
            <a class="back-btn" href="{{ $backUrl }}" aria-label="Back"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div style="font-weight:700; font-size:1.60rem; color:var(--blue)">{{ $course->name }}</div>
        <div></div>
    </div>
    <div class="layout">
        <aside class="sidebar">
            <h3><i class="fas fa-list-ul"></i> Course Outline</h3>
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
    <script>
        const storageBaseUrl = "{{ asset('storage') }}";
        const course = @json($course);
        const status = @json($status);
        const isEnrolled = status === 'active';
        const viewOnly = @json($viewOnly ?? false);
        const csrf = "{{ csrf_token() }}";
        let reflectionMap = {};
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
        function renderOutline(){
            const el=document.getElementById('outline');
            el.innerHTML='';
            const mods = Array.isArray(course.modules)?course.modules:[];
            mods.forEach((m,mi)=>{
                const mod = document.createElement('div');
                mod.className='module';
                mod.innerHTML = `
                    <div class="module-header" data-mi="${mi}">
                        <div class="module-title"><span>Module ${mi+1}: ${m.title||'Untitled'}</span><span class="module-kpi" id="kpi_${mi}"></span></div>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="module-bar"><span id="bar_${mi}"></span></div>
                    <div class="topics"></div>
                `;
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
                    const open = topicsCt.style.display==='block';
                    topicsCt.style.display = open?'none':'block';
                    mod.querySelector('.module-header i').style.transform = open?'rotate(0deg)':'rotate(180deg)';
                });
                el.appendChild(mod);
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
                subs.forEach((s,si)=>{
                    const container = document.getElementById(`sub_${mi}_${ti}_${si}_fields`);
                    const fields = ('fields' in s) ? s.fields : (s.fields_json ? (typeof s.fields_json==='string'?JSON.parse(s.fields_json):s.fields_json) : []);
                    renderFieldsInto(container, fields, mi, ti, si);
                });
                // Append a single Topic-level reflection at the end
                const key = `${mi}_${ti}_-1`;
                body.insertAdjacentHTML('beforeend', `
                    <section class="subgroup" id="topic_ref_${mi}_${ti}" data-mi="${mi}" data-ti="${ti}" data-si="-1">
                        <div class="subheader"><span>${mi+1}.${ti}. Reflection</span></div>
                        <div class="subfields">
                            <div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="-1">
                                <div style="font-weight:700;margin-bottom:6px">What did you learn?</div>
                                <textarea class="reflect-input" data-ref="${key}" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your personal reflection here"></textarea>
                                <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                    <button type="button" class="btn-blue" data-act="submit-ref" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:8px 12px">Submit</button>
                                </div>
                                <div class="reflect-summary" style="display:none;margin-top:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:10px"></div>
                            </div>
                        </div>
                    </section>
                `);
                // Bind
                (function(){
                    const container = document.getElementById('contentBody');
                    container.querySelectorAll('.reflection-inline').forEach(block=>{
                        const bMi = parseInt(block.getAttribute('data-mi'),10);
                        const bTi = parseInt(block.getAttribute('data-ti'),10);
                        const submitBtn = block.querySelector('[data-act="submit-ref"]');
                        const input = block.querySelector('.reflect-input');
                        const summary = block.querySelector('.reflect-summary');
                        const k = `${bMi}_${bTi}_-1`;
                        if(hasReflection(bMi,bTi,-1)){
                            const prev = reflectionMap[k];
                            if(input && prev && typeof prev==='object' && prev.learned){ input.value = prev.learned; }
                            if(submitBtn){ submitBtn.textContent='Submitted'; submitBtn.disabled=true; }
                            if(input){ input.disabled=true; }
                            if(summary && prev && prev.learned){
                                summary.style.display='block';
                                summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                    <div><b>What you learned:</b> ${prev.learned}</div>
                                    <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="reset-ref" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Reset</button></div>`;
                                const resetBtn = summary.querySelector('[data-act="reset-ref"]');
                                if(resetBtn){
                                    resetBtn.onclick = ()=>{
                                        input.disabled=false;
                                        if(submitBtn){ submitBtn.disabled=false; submitBtn.textContent='Submit'; if(submitBtn.parentElement){ submitBtn.parentElement.style.display='flex'; } }
                                        summary.style.display='none';
                                        unmarkReflection(bMi,bTi,-1);
                                        input.focus();
                                    };
                                }
                            }
                        }
                        if(submitBtn){
                            submitBtn.onclick = async ()=>{
                                if(!input.value.trim()){ input.focus(); return; }
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
                                        summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                            <div><b>What you learned:</b> ${answers.learned?answers.learned:'(none)'}</div>
                                            <div style="margin-top:8px"><button type="button" class="btn-ghost" data-act="reset-ref" style="border:1px solid var(--border);border-radius:12px;padding:8px 12px;background:#fff">Reset</button></div>`;
                                        input.disabled=true; submitBtn.disabled=true; submitBtn.textContent='Submitted';
                                        input.style.display='none';
                                        if(submitBtn.parentElement){ submitBtn.parentElement.style.display='none'; }
                                        try{ localStorage.setItem('course_progress_broadcast', String(Date.now())); }catch(e){}
                                        const resetBtn = summary.querySelector('[data-act="reset-ref"]');
                                        if(resetBtn){
                                            resetBtn.onclick = ()=>{
                                                input.disabled=false; input.style.display='';
                                                submitBtn.disabled=false; submitBtn.textContent='Submit';
                                                if(submitBtn.parentElement){ submitBtn.parentElement.style.display='flex'; }
                                                summary.style.display='none';
                                                unmarkReflection(bMi,bTi,-1);
                                                input.focus();
                                            };
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
                })();
                const topicEl = document.querySelector(`.topic[data-mi="${mi}"][data-ti="${ti}"]`);
                if(topicEl) renderDoneStates(mi,ti,topicEl);
                return;
            }
            const fields = ('fields' in t) ? t.fields : (t.fields_json ? (typeof t.fields_json==='string'?JSON.parse(t.fields_json):t.fields_json) : []);
            renderFieldsInto(document.getElementById('contentBody'), fields, mi, ti);
        }
        function openSubtopic(mi,ti,si){
            const section = document.getElementById(`sub_${mi}_${ti}_${si}`);
            if(section){ section.scrollIntoView({behavior:'smooth', block:'start'}); }
        }
        function renderFieldsInto(container, fields, mi, ti, si=null){
            if(!fields || !fields.length){
                container.innerHTML = `<div class="field" style="background:#f8fafc;">No fields added.</div>`;
                return;
            }
            container.innerHTML = fields.map((f,i)=>{
                if(f.type==='text'){
                    return `<div class="field">${f.html||''}</div>`;
                } else if(f.type==='question' && f.question){
                    const q=f.question; 
                    const answer = (Number.isInteger(q.answer_index) ? q.answer_index : '');
                    const fbC = q.feedback_correct || '';
                    const fbI = q.feedback_incorrect || '';
                    const opts=(q.options||[]).map((o,idx)=>`<div class="mc-option" data-idx="${idx}"><span class="mc-radio"></span><span class="mc-label">${o}</span></div>`).join('');
                    if(viewOnly){
                        return `<div class="field question" data-kind="mc">
                            <div class="q-title">${q.title||'Question'}</div>
                            <div class="mc" data-answer="${answer}">${opts}</div>
                        </div>`;
                    } else {
                        return `<div class="field question" data-kind="mc">
                            <div class="q-title">${q.title||'Question'}</div>
                            <div class="mc" data-answer="${answer}" data-fb-correct="${fbC?.replace?.(/"/g,'&quot;') || ''}" data-fb-incorrect="${fbI?.replace?.(/"/g,'&quot;') || ''}">${opts}</div>
                            <div class="mc-actions">
                                <button class="btn-green" data-act="submit" disabled>Submit</button>
                                <button class="btn-green" data-act="feedback" style="display:none">Show feedback</button>
                                <button class="btn-green" data-act="reset">Reset</button>
                            </div>
                            <div class="mc-feedback" style="display:none;"></div>
                        </div>`;
                    }
                } else if(f.type==='reflection'){
                    const header = 'What did you learn?';
                    if(viewOnly){
                        return `<div class="field" style="background:#f8fafc">
                            <div class="muted">${header}</div>
                        </div>`;
                    } else {
                        // Only add when rendering TOPIC-level (no subtopics)
                        if(si!==null && si!==undefined){ return ''; }
                        const key = `${mi}_${ti}_-1`;
                        return `<div class="field reflection-inline" data-mi="${mi}" data-ti="${ti}" data-si="-1">
                            <div style="font-weight:700;margin-bottom:6px">${header}</div>
                            <textarea class="reflect-input" data-ref="${key}" rows="4" style="width:100%;border:1px solid var(--border);border-radius:10px;padding:10px" placeholder="Write your personal reflection here"></textarea>
                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                                <button type="button" class="btn-blue" data-act="submit-ref" style="background:#0f3b8f;color:#fff;border:none;border-radius:12px;padding:8px 12px">Submit</button>
                            </div>
                            <div class="reflect-summary" style="display:none;margin-top:10px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:10px"></div>
                        </div>`;
                    }
                } else {
                    return `<div class="field">${JSON.stringify(f)}</div>`;
                }
            }).join('');
            if(!viewOnly){
                container.querySelectorAll('.reflection-inline').forEach(block=>{
                    const bMi = parseInt(block.getAttribute('data-mi'),10);
                    const bTi = parseInt(block.getAttribute('data-ti'),10);
                    const bSi = parseInt(block.getAttribute('data-si'),10);
                    const submitBtn = block.querySelector('[data-act="submit-ref"]');
                    const input = block.querySelector('.reflect-input');
                    const summary = block.querySelector('.reflect-summary');
                    const key = `${bMi}_${bTi}_${bSi}`;
                    if(hasReflection(bMi,bTi,bSi)){
                        const prev = reflectionMap[key];
                        if(input && prev && typeof prev==='object' && prev.learned){ input.value = prev.learned; }
                        if(submitBtn){ submitBtn.textContent = 'Submitted'; submitBtn.disabled = true; }
                        if(input){ input.disabled = true; }
                        if(summary && prev && typeof prev==='object' && prev.learned){
                            summary.style.display='block';
                            summary.innerHTML = `<div style="font-weight:700;margin-bottom:6px">Submitted</div>
                                <div><b>What you learned:</b> ${prev.learned}</div>`;
                        }
                    }
                    if(submitBtn){
                        submitBtn.onclick = async ()=>{
                            if(!input.value.trim()){ input.focus(); return; }
                            const questions = [{id:'learned', text:'What did you learn?'}];
                            const answers = { learned: input.value||'' };
                            try{
                                const res = await fetch("{{ route('courses.reflect.store', $course) }}", {
                                    method:'POST',
                                    headers:{'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/json'},
                                    credentials:'same-origin',
                                    body: JSON.stringify({
                                        module_index: bMi, topic_index: bTi, sub_index: bSi, questions, answers
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
                                    submitBtn.textContent = 'Submitted';
                                    const retryBtn = summary.querySelector('[data-act="retry"]');
                                    if(retryBtn){
                                        retryBtn.onclick = ()=>{
                                            input.disabled = false;
                                            submitBtn.disabled = false;
                                            submitBtn.textContent = 'Submit';
                                            summary.style.display='none';
                                            input.focus();
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
            if(!viewOnly){
                container.querySelectorAll('.field.question[data-kind="mc"]').forEach(initMultipleChoice);
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
        function markReflection(mi,ti,si){ reflectionMap[reflectKey(mi,ti,si)] = { submitted:true }; }
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
            const setSubmitted = (val)=>{
                mc.dataset.submitted = val ? '1' : '0';
                if(val){
                    submitBtn.style.display='none';
                    feedbackBtn.style.display='inline-block';
                }else{
                    submitBtn.style.display='inline-block';
                    feedbackBtn.style.display='none';
                }
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
                        } else {
                            sel.classList.add('submitted-wrong');
                        }
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
        }
        renderVideo();
        (async function initPage(){
            if(!viewOnly){
                try{ await loadReflectionMap(); }catch(e){}
            }
            renderOutline();
            const firstTopic = (course.modules&&course.modules[0]&&course.modules[0].topics&&course.modules[0].topics[0])? [0,0]: null;
            if(firstTopic){ openTopic(0,0); }
        })();
    </script>
</body>
</html>
