<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} · Class</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        .header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:var(--header-height);box-sizing:border-box;z-index:1000;position:fixed;top:0;left:var(--sidebar-width);right:0}
        .header-left{display:flex;align-items:center}
        .header-toggle,
        .sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
        .header-toggle:hover,
        .sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
        .header-right{display:flex;align-items:center;gap:15px}
        .header-section-title{margin-left:12px;font-size:1.08rem;color:var(--primary-blue);font-weight:700;letter-spacing:-.01em}
        .profile-menu{position:relative}
        .user-profile{display:flex;align-items:center;gap:10px;color:var(--dark-text)}
        .profile-dropdown{position:absolute;top:44px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
        .profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
        .profile-dropdown .dropdown-item:hover{background:#f8fafc}
        .profile-dropdown .danger{color:#b91c1c}
        .dashboard-container{display:flex;flex:1;overflow:hidden;margin-top:var(--header-height);margin-left:var(--sidebar-width);height:calc(100vh - var(--header-height))}
        .sidebar{width:var(--sidebar-width);background-color:var(--primary-blue);color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
        .sidebar.collapsed{width:var(--sidebar-collapsed-width)}
        .sidebar-toggle{background:none;border:none;color:#fff;padding:15px;cursor:pointer;text-align:right;font-size:1.2rem}
        .nav-menu{list-style:none;padding:0;margin:0;flex:1}
        .nav-item{border-bottom:1px solid rgba(255,255,255,.1)}
        .nav-link{display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,.85);text-decoration:none;transition:all .3s;cursor:pointer}
        .nav-link:hover,.nav-link.active{background-color:rgba(255,255,255,.1);color:#fff;border-left:4px solid var(--primary-green)}
        .nav-icon{width:25px;font-size:1.1rem;text-align:center;margin-right:15px}
        .nav-text{display:inline}
        .sidebar.collapsed .nav-text{display:none}
        .sidebar.collapsed .nav-link{justify-content:center;padding:15px}
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
        .page{max-width:1220px;margin:22px auto 42px;padding:0 18px}
        .hero{background:#fff;border:1px solid #dbe2ee;border-radius:18px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,.08)}
        .hero-top{position:relative;height:230px;background:#e9eef9;display:flex;align-items:center;justify-content:center}
        .hero-top img{width:100%;height:100%;object-fit:cover}
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
        .progress-ring{width:64px;height:64px;border-radius:50%;background:conic-gradient(var(--brand) var(--deg,0deg), #e5e7eb 0);display:flex;align-items:center;justify-content:center;color:#0f3b8f;font-weight:800}
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
        function toggleSidebar(){
            var s=document.getElementById('sidebar');
            if(s){ s.classList.toggle('collapsed'); }
            document.body.classList.toggle('sidebar-collapsed');
            try{
                var LOGO_MAIN = "{{ asset('images/ddd-removebg-preview.png') }}";
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
                } else {
                }
            }catch(e){
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
            <div class="header-title" style="padding:12px 20px;border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center">
                <img id="sidebarLogo" src="{{ asset('images/ddd-removebg-preview.png') }}" alt="CapDev Pro" style="height:60px">
            </div>
            <div style="padding:12px 20px;display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,.1);">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <span class="nav-text">Classroom</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-text">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-bullhorn nav-icon"></i>
                        <span class="nav-text">Announcements</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-content">
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
                        <img src="{{ $hero }}" alt="Course banner">
                    @endif
                </div>
                <div class="hero-body">
                    @if (trim((string) $course->subjectAreaText()) !== '')
                        <span class="chip"><i class="fas fa-layer-group"></i> {{ $course->subjectAreaText() }}</span>
                    @endif
                    <div class="title">{{ $course->name }}</div>
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
                        @if(!empty($course->description))
                            <div class="muted">{{ $course->description }}</div>
                        @else
                            <div class="muted">No description provided.</div>
                        @endif
                    </div>
                    <div class="split">
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
                                $canPostAnnouncement = !empty($asTrainer)
                                    || (\Illuminate\Support\Facades\Auth::check() && in_array((\Illuminate\Support\Facades\Auth::user()->role ?? null), ['trainer', 'coach'], true))
                                    || ($course->users && $course->users->contains(function ($u) use ($currentUserId) {
                                        return (int) $u->id === (int) $currentUserId
                                            && in_array(($u->role ?? null), ['trainer', 'coach'], true);
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
            <div id="panePeople" class="card" role="tabpanel" aria-labelledby="tabBtnPeople" style="display:none">
                @php
                    $trainers = $course->users->where('role','trainer');
                    $classmates = $course->users->where('role','trainee');
                @endphp
                <div class="people">
                    <div>
                        <div style="font-weight:800;margin-bottom:8px;">Coaches</div>
                        <ul>
                            @forelse($trainers as $t)
                                <li style="padding:0;border:none;background:transparent;margin:0;">
                                    <button type="button" class="participant-item-btn" onclick="openParticipantView(@json($t->name), @json($t->email), 'Coach')">
                                        <i class="fas fa-user-tie" style="color:#0f3b8f;"></i> {{ $t->name }}
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
                                    <button type="button" class="participant-item-btn" onclick="openParticipantView(@json($s->name), @json($s->email), 'Classmate')">
                                        <i class="fas fa-user" style="color:#0f3b8f;"></i> {{ $s->name }}
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
    </div>
    <div id="participantViewModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="participantViewTitle">
        <div class="participant-view-modal">
            <div class="participant-view-header">
                <h3 id="participantViewTitle" class="participant-view-title">Participant Details</h3>
                <button type="button" class="participant-view-close" onclick="closeParticipantView()" aria-label="Close">&times;</button>
            </div>
            <div class="participant-view-body">
                <div class="participant-view-row">
                    <label class="participant-view-label">Full Name</label>
                    <div id="participantViewName" class="participant-view-value">—</div>
                </div>
                <div class="participant-view-row">
                    <label class="participant-view-label">Role</label>
                    <div id="participantViewRole" class="participant-view-value">—</div>
                </div>
                <div class="participant-view-row">
                    <label class="participant-view-label">Email</label>
                    <div id="participantViewEmail" class="participant-view-value">—</div>
                </div>
            </div>
        </div>
    </div>
    <div id="discussionModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="discussionTitle">
        <div class="modal discussion-modal">
            <div class="discussion-modal-header">
                <div class="discussion-modal-title"><i class="fas fa-pen"></i> Compose a discussion</div>
                <button type="button" class="discussion-close" onclick="document.getElementById('discussionModal').style.display='none'">×</button>
                <div class="discussion-modal-sub">Post a text, image, or link discussion for the class.</div>
            </div>
            <form id="discussionForm" action="{{ route('courses.discussions.store', $course) }}" method="POST" enctype="multipart/form-data" onsubmit="return submitDiscussion(event)">
                @csrf
                <div class="discussion-modal-body">
                    <label class="discussion-label" for="discussionTitle">Title</label>
                    <input id="discussionTitle" type="text" class="pro-input" name="title" placeholder="Short title" maxlength="200" oninput="updateDiscussionCounts()">
                    <div class="disc-tabs" role="tablist">
                        <button id="discTabText" class="disc-tab active" type="button" onclick="setDiscussionMode('text')" role="tab" aria-selected="true"><i class="fas fa-font"></i> Text</button>
                        <button id="discTabMedia" class="disc-tab" type="button" onclick="setDiscussionMode('media')" role="tab" aria-selected="false" tabindex="-1"><i class="fas fa-image"></i> Image</button>
                        <button id="discTabLink" class="disc-tab" type="button" onclick="setDiscussionMode('link')" role="tab" aria-selected="false" tabindex="-1"><i class="fas fa-link"></i> Link</button>
                    </div>
                    <input type="hidden" id="discussionMode" value="text">
                    <div id="discFieldsText">
                        <label class="discussion-label" for="discussionBody">Body</label>
                        <textarea id="discussionBody" class="pro-textarea" name="body" placeholder="Write your discussion here…" oninput="updateDiscussionCounts()"></textarea>
                        <div id="titleCount" class="counter" aria-live="polite">0/200</div>
                        <div id="bodyCount" class="counter" aria-live="polite">0 chars</div>
                    </div>
                    <div id="discFieldsMedia" style="display:none">
                        <input type="file" name="image" id="discussionImage" class="discussion-file" accept="image/*" onchange="updateDiscussionCounts()">
                        <div class="muted" id="discFileName" style="margin-top:6px"></div>
                    </div>
                    <div id="discFieldsLink" style="display:none">
                        <input type="text" id="discussionLink" class="pro-input" placeholder="https://example.com" oninput="updateDiscussionCounts()">
                    </div>
                    <div id="discussionError" class="error-text" role="alert"></div>
                </div>
                <div class="discussion-modal-actions">
                    <div class="round-set">
                        <button class="round-btn" type="button" title="Attach image" onclick="setDiscussionMode('media')"><i class="fas fa-image"></i></button>
                        <button class="round-btn" type="button" title="Insert link" onclick="setDiscussionMode('link')"><i class="fas fa-link"></i></button>
                    </div>
                    <div class="post-cta">
                        <button id="discussionSubmit" class="btn btn-disabled" type="submit" disabled>Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
        const storageBaseUrl = "{{ asset('storage') }}";
        const course = @json($course);
        const status = @json($status);
        const isEnrolled = status === 'active';
        const csrf = "{{ csrf_token() }}";
        function toggleProfileMenu(e){
            e.stopPropagation();
            var d = document.getElementById('profileDropdown');
            if(!d) return;
            d.style.display = (d.style.display==='block') ? 'none' : 'block';
        }
        function renderModuleProgress(mods, doneCountFn){
            var list = document.getElementById('moduleProgressList');
            if(!list) return;
            list.innerHTML='';
            (mods||[]).forEach(function(m, i){
                var subs = 0;
                (m.topics||[]).forEach(function(t){ subs += Array.isArray(t.subtopics)?t.subtopics.length:0; });
                var done = doneCountFn(i);
                var pct = subs ? Math.round((done/subs)*100) : 0;
                var bar = '<div class="progress-bar"><div style="width:'+pct+'%"></div></div>';
                var row = '<div style="margin:6px 0">'+(m.title||('Module '+(i+1)))+' <span class="muted">('+done+'/'+subs+')</span>'+bar+'</div>';
                list.insertAdjacentHTML('beforeend', row);
            });
        }
        function renderStreamProgress(mods, doneSet){
            var total=0, done=0;
            (mods||[]).forEach(function(m,mi){
                (m.topics||[]).forEach(function(t,ti){
                    var subs = Array.isArray(t.subtopics)?t.subtopics:[];
                    total += subs.length;
                    subs.forEach(function(_,si){
                        if(doneSet[mi+'_'+ti+'_'+si]) done++;
                    });
                });
            });
            var pct = total ? Math.round((done/total)*100) : 0;
            var ring = document.getElementById('overallRing');
            var det = document.getElementById('overallDetail');
            if(ring){ 
                ring.style.setProperty('--deg', pct*3.6+'deg'); 
                ring.textContent = pct+'%';
                if(pct >= 100){
                    ring.style.cursor = 'pointer';
                    ring.title = 'Click to see congratulations!';
                } else {
                    ring.style.cursor = 'default';
                    ring.title = '';
                }
            }
            if(det){ det.textContent = total ? '('+done+' / '+total+' complete)' : ''; }
            renderModuleProgress(mods, function(i){
                var sum=0, d=0;
                var tps = (mods[i]||{}).topics||[];
                tps.forEach(function(t,ti){
                    var subs = Array.isArray(t.subtopics)?t.subtopics:[];
                    sum += subs.length;
                    subs.forEach(function(_,si){
                        if(doneSet[i+'_'+ti+'_'+si]) d++;
                    });
                });
                return d;
            });
        }
        (function initProgress(){
            var ring = document.getElementById('overallRing');
            if(ring){
                ring.addEventListener('click', function(){
                    var currentPct = parseInt(ring.textContent);
                    if(currentPct >= 100 && typeof showCongrats === 'function'){
                        showCongrats();
                    }
                });
            }
            var doneSet = {};
            fetch('{{ route('courses.reflections.map', $course) }}', {credentials:'same-origin'})
                .then(function(r){ return r.json(); })
                .then(function(j){
                    var map = j.map || {};
                    Object.keys(map).forEach(function(k){ doneSet[k] = true; });
                    renderStreamProgress(course.modules||[], doneSet);
                })
                .catch(function(){
                    renderStreamProgress(course.modules||[], doneSet);
                });
        })();
    </script>
    </body>
    </html>
