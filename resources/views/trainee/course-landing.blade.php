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
        .header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:var(--header-height);box-sizing:border-box;z-index:1000}
        .header-left{display:flex;align-items:center}
        .header-logo{height:50px;margin-right:20px}
        .header-right{display:flex;align-items:center;gap:15px}
        .dashboard-container{display:flex;flex:1;overflow:hidden}
        .sidebar{width:var(--sidebar-width);background-color:var(--primary-blue);color:#fff;transition:width .3s ease;display:flex;flex-direction:column}
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
        .main-content{flex:1;padding:30px;overflow-y:auto;background-color:var(--bg-color)}
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
        .page{max-width:1100px;margin:18px auto 40px;padding:0 16px}
        .hero{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden}
        .hero-top{position:relative;height:200px;background:#e9eef9;display:flex;align-items:center;justify-content:center}
        .hero-top img{width:100%;height:100%;object-fit:cover}
        .chip{display:inline-flex;align-items:center;gap:6px;background:#eef2ff;color:#0f3b8f;border:1px solid #dbeafe;border-radius:999px;padding:6px 10px;font-weight:700}
        .hero-body{padding:16px}
        .title{margin:4px 0 10px;font-size:1.8rem;letter-spacing:-0.02em;color:#0f3b8f}
        .tabs{display:inline-flex;gap:8px;margin: 10px 0 0;padding:6px;background:#eef2ff;border-radius:12px;border:1px solid var(--border)}
        .tab{padding:10px 14px;border-radius:10px;border:1px solid transparent;background:transparent;cursor:pointer;color:#0f172a}
        .tab:hover{background:#fff;border-color:#e5e7eb}
        .tab.active{background:var(--brand);color:#fff;border-color:var(--brand);box-shadow:0 6px 12px rgba(13,110,253,0.25)}
        .content{margin-top:14px}
        .card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
        .stream-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px dashed var(--border)}
        .stream-item:last-child{border-bottom:none}
        .avatar{width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f}
        .muted{color:var(--muted);font-size:.9rem}
        .split{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        @media (max-width: 900px){ .split{grid-template-columns:1fr} }
        .container-box{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
        .section-head{display:flex;align-items:center;gap:12px;margin-bottom:8px;font-weight:800;color:#0f3b8f}
        .ann-actions{display:flex;align-items:center;gap:12px;margin-bottom:10px}
        .chip-action{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:8px 12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
        .chip-stat{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:8px 12px;font-weight:700;display:inline-flex;align-items:center;gap:8px;cursor:default}
        .link-action{color:#0f3b8f;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-weight:600}
        .announce-card{background:#f3f7ff;border:1px solid var(--border);border-radius:16px;overflow:hidden}
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
        @media (max-width: 800px){ .people{grid-template-columns: 1fr} }
        .progress-wrap{display:flex;align-items:center;gap:16px}
        .progress-ring{width:64px;height:64px;border-radius:50%;background:conic-gradient(var(--brand) var(--deg,0deg), #e5e7eb 0);display:flex;align-items:center;justify-content:center;color:#0f3b8f;font-weight:800}
        .progress-bar{height:10px;background:#e5e7eb;border-radius:999px;overflow:hidden}
        .progress-bar > div{height:100%;background:var(--brand);width:0;border-radius:999px;transition:width .4s ease}
        .discussion{margin-top:16px}
        .discussion .post{display:flex;gap:10px;padding:12px 0;border-bottom:1px dashed var(--border)}
        .discussion textarea{width:100%;min-height:70px;border:1px solid var(--border);border-radius:10px;padding:10px;resize:vertical}
        .modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);display:none;align-items:center;justify-content:center;z-index:50}
        .modal{width:640px;max-width:calc(100% - 32px);background:#fff;border:1px solid var(--border);border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.2);overflow:hidden}
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
        .forum-card{display:block;border:1px solid var(--border);background:#fff;border-radius:12px;padding:14px 16px;transition:box-shadow .2s ease, transform .05s ease,border-color .2s ease;border-left:4px solid #e5e7eb}
        .forum-card:hover{box-shadow:0 6px 16px rgba(0,0,0,.06)}
        .forum-card.selected{outline:3px solid #0f3b8f;outline-offset:0;border-color:#bfd7ff}
        .asm-details{display:none;margin-top:10px;background:#f1f6ff;border:1px solid #d6e4ff;border-radius:10px;padding:12px;color:#0f172a}
        .forum-title{font-weight:700;color:#0f172a}
        .forum-meta{color:var(--muted);font-size:.9rem;margin-top:4px}
        .modal-editor input[type="text"]{border:1px solid var(--border);background:#fff;border-radius:10px;padding:10px}
        .modal-editor textarea{border:1px solid var(--border);background:#fff;border-radius:10px;padding:10px}
        .modal-editor input[type="text"]:focus,.modal-editor textarea:focus{outline:2px solid rgba(13,110,253,.25);outline-offset:2px}
    </style>
    <script>
        var currentEditCard = null;
        var isTrainer = {!! json_encode(!empty($asTrainer)) !!};
        function toggleSidebar(){var s=document.getElementById('sidebar');if(s){s.classList.toggle('collapsed');}}
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
        function openDiscussionModal(){
            var m=document.getElementById('discussionModal');
            var t=document.getElementById('discussionTitle');
            var b=document.getElementById('discussionBody');
            if(m){m.style.display='flex';}
            if(t){t.value='';}
            if(b){b.value='';}
            updateDiscussionCounts();
            var e=document.getElementById('discussionError'); if(e){e.textContent='';}
        }
        function closeDiscussionModal(){
            var m=document.getElementById('discussionModal');
            if(m){m.style.display='none';}
        }
        function updateDiscussionCounts(){
            var t=document.getElementById('discussionTitle');
            var b=document.getElementById('discussionBody');
            var tc=document.getElementById('titleCount');
            var bc=document.getElementById('bodyCount');
            var submit=document.getElementById('discussionSubmit');
            var tlen = t ? t.value.length : 0;
            var blen = b ? b.value.length : 0;
            if(tc){ tc.textContent = tlen + '/200'; }
            if(bc){ bc.textContent = blen + ' chars'; }
            var valid = (tlen>=5 && tlen<=200) && (blen>=10);
            if(submit){
                submit.disabled = !valid;
                submit.classList.toggle('btn-blue', valid);
                submit.classList.toggle('btn-disabled', !valid);
            }
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
                    window.location.href = data.redirect;
                    return;
                }
            }catch(e){
                err.textContent = e.message || 'Failed to create discussion. Please try again.';
            }finally{
                btn.textContent='Submit';
                updateDiscussionCounts();
            }
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
            var trainerName='Trainer';
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
            <img class="header-logo" src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
        </div>
    </header>
    <div class="dashboard-container">
        <div class="sidebar" id="sidebar">
            <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
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
                    @if ($course->image_path)
                        @php $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp; @endphp
                        <img src="{{ asset('storage/'.$course->image_path).'?v='.$ver }}" alt="Course banner">
                    @endif
                </div>
                <div class="hero-body">
                    @if (!empty($course->subject_area))
                        <span class="chip"><i class="fas fa-layer-group"></i> {{ $course->subject_area }}</span>
                    @endif
                    <div class="title">{{ $course->name }}</div>
                    <div class="tabs" role="tablist">
                        <button id="tabBtnStream" class="tab active" onclick="switchTo('Stream')" role="tab" aria-controls="paneStream" aria-selected="true">Stream</button>
                        <button id="tabBtnClasswork" class="tab" onclick="switchTo('Classwork')" role="tab" aria-controls="paneClasswork" aria-selected="false" tabindex="-1">Classwork</button>
                        <button id="tabBtnForum" class="tab" onclick="switchTo('Forum')" role="tab" aria-controls="paneForum" aria-selected="false" tabindex="-1">Forum</button>
                        <button id="tabBtnPeople" class="tab" onclick="switchTo('People')" role="tab" aria-controls="panePeople" aria-selected="false" tabindex="-1">People</button>
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
                                    <div class="progress-bar"><div id="overallBar" style="width: {{ $completion }}%"></div></div>
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
                            <div class="ann-actions">
                                <button class="chip-action" onclick="currentEditCard=null; openAnnouncementModal()"><i class="fas fa-pen"></i> New announcement</button>
                            </div>
                            @php
                                $trainer = optional($course->users->firstWhere('role','trainer'))->name ?? 'Trainer';
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
                        $trainer = optional($course->users->firstWhere('role','trainer'))->name ?? 'Trainer';
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
                <div class="container-box" style="margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <div class="section-head" style="margin:0;color:var(--text);font-weight:700;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f"><i class="fas fa-list-ul"></i></div>
                            <div>Course Outline</div>
                        </div>
                        <a href="{{ route('trainee.courses.outline', $course) }}" class="btn btn-blue"><i class="fas fa-list"></i> Course Outline</a>
                    </div>
                    <div class="muted">Browse modules, topics, and activities in the course outline view.</div>
                </div>

                <!-- Container 2: Materials and Assessments -->
                @php
                    $isTrainer = !empty($asTrainer) || (\Illuminate\Support\Facades\Auth::check() && ((\Illuminate\Support\Facades\Auth::user()->role ?? null) === 'trainer'));
                @endphp
                <div class="container-box">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <div class="section-head" style="margin:0;color:var(--text);font-weight:700;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#e8f0ff;display:flex;align-items:center;justify-content:center;color:#0f3b8f"><i class="fas fa-folder-open"></i></div>
                            <div>Materials & Assessments</div>
                        </div>
                        @if(!empty($asTrainer))
                            <div style="position:relative">
                                <a id="createCwBtn" href="{{ route('trainer.courses.classwork.create', $course) }}" class="btn btn-blue"><i class="fas fa-plus"></i> Create</a>
                                <div id="createCwMenu" class="dots-menu" style="right:0;left:auto;display:none;min-width:220px">
                                    <a href="{{ route('trainer.courses.materials.create', $course) }}" class="dots-item"><i class="fas fa-book"></i> Material</a>
                                    <a href="{{ route('trainer.courses.assessments.create', $course) }}" class="dots-item"><i class="fas fa-clipboard-list"></i> Assessment</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    @php
                        $materials = $course->materials ?? collect();
                        $assessments = $course->assessments ?? collect();
                        $classworks = collect();
                        foreach ($materials as $m) {
                            $classworks->push(['kind'=>'material','model'=>$m,'ts'=>$m->created_at ?? now()]);
                        }
                        foreach ($assessments as $a) {
                            $classworks->push(['kind'=>'assessment','model'=>$a,'ts'=>$a->created_at ?? now()]);
                        }
                        $classworks = $classworks->sortByDesc('ts');
                    @endphp
                    @if($classworks->isEmpty())
                        <div class="muted">No materials or assessments yet.</div>
                    @else
                        <div style="display:grid;gap:10px;">
                        @foreach($classworks as $cw)
                            @if($cw['kind']==='material')
                                @php $m = $cw['model']; @endphp
                                <div class="forum-card" id="mat-card-{{ $m->id }}" style="position:relative" data-href="{{ route('materials.show', $m) }}" onclick="onMaterialCardClick(event, {{ $m->id }})">
                                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                                        <div>
                                            @php $ext = pathinfo($m->file_path ?? '', PATHINFO_EXTENSION); @endphp
                                            <div style="font-weight:700;color:#0f172a">{{ $m->title }}</div>
                                            <div class="muted">{{ strtoupper($ext ?: 'FILE') }}{{ !empty($m->description) ? ' • '.$m->description : '' }}</div>
                                        </div>
                                        <div class="announce-dots" onclick="toggleMenu('mat-menu-{{ $m->id }}', event)"><i class="fas fa-ellipsis-v"></i></div>
                                    </div>
                                    <div id="mat-menu-{{ $m->id }}" class="dots-menu" style="right:8px;display:none">
                                        <a href="{{ route('materials.show', $m) }}" class="dots-item"><i class="fas fa-eye"></i> View</a>
                                        <a href="{{ asset('storage/'.$m->file_path) }}" class="dots-item" target="_blank"><i class="fas fa-download"></i> Download</a>
                                        @if($isTrainer)
                                        <a href="#" class="dots-item" data-delete="material" data-url="{{ route('trainer.materials.destroy', $m) }}" data-id="{{ $m->id }}"><i class="fas fa-trash"></i> Delete</a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                @php $a = $cw['model']; @endphp
                                <div class="forum-card" id="asm-card-{{ $a->id }}" style="position:relative" data-view-href="{{ route('trainer.assessments.show', $a) }}" onclick="onAssessmentCardClick(event, {{ $a->id }})">
                                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                                        <div>
                                            <div style="font-weight:700;color:#0f172a">{{ $a->title }}</div>
                                            <div class="muted">
                                                Type: {{ ucfirst($a->type) }}
                                                @if(!empty($a->due_date)) • Due: {{ \Carbon\Carbon::parse($a->due_date)->format('M j, g:i A') }} @endif
                                                @if($isTrainer)
                                                • <span>{{ is_array($a->questions_json) ? count($a->questions_json) : (json_decode($a->questions_json, true) ? count(json_decode($a->questions_json, true)) : 0) }} questions</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($isTrainer)
                                        <div class="announce-dots" onclick="toggleMenu('asm-menu-{{ $a->id }}', event)"><i class="fas fa-ellipsis-v"></i></div>
                                        @endif
                                    </div>
                                    @if($isTrainer)
                                    <div id="asm-menu-{{ $a->id }}" class="dots-menu" style="right:8px;display:none">
                                        <a href="{{ route('trainer.assessments.show', $a) }}" class="dots-item"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dots-item" data-delete="assessment" data-url="{{ route('trainer.assessments.destroy', $a) }}" data-id="{{ $a->id }}"><i class="fas fa-trash"></i> Delete</a>
                                    </div>
                                    @else
                                    <div id="asm-menu-{{ $a->id }}" class="dots-menu" style="right:8px;display:none">
                                        <a href="{{ route('trainee.assessments.take', $a) }}" class="dots-item"><i class="fas fa-play"></i> Take Assessment</a>
                                    </div>
                                    @endif
                                    <div id="asm-det-{{ $a->id }}" class="asm-details">
                                        <div class="muted" style="margin-bottom:6px">{{ !empty($a->due_date) ? 'Due: '.\Carbon\Carbon::parse($a->due_date)->format('M j, g:i A') : 'No due date' }}</div>
                                        @if(!empty($a->description))
                                        <div>{{ $a->description }}</div>
                                        @else
                                        <div class="muted">No description</div>
                                        @endif
                                        @if(!$isTrainer)
                                        <div style="margin-top:8px"><a class="btn btn-blue" href="{{ route('trainee.assessments.take', $a) }}"><i class="fas fa-play"></i> Take Assessment</a></div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div id="paneForum" class="card" role="tabpanel" aria-labelledby="tabBtnForum" style="display:none">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <div style="font-weight:700">Forum</div>
                    <button class="btn btn-blue" type="button" onclick="openDiscussionModal()"><i class="fas fa-plus"></i> Create Discussion</button>
                </div>
                <div id="courseDiscussions" class="forum-list">
                    @if(($discussions ?? collect())->isEmpty())
                        <div class="muted">No discussions yet. Be the first to start one.</div>
                    @else
                        @foreach($discussions as $d)
                        @if(!(method_exists($d,'trashed') && $d->trashed()))
                        <div class="forum-card" id="disc-card-{{ $d->id }}" style="display:block; position:relative; cursor:pointer" data-disc-id="{{ $d->id }}" data-href="{{ route('discussions.show', ['discussion'=>$d]) }}">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                                <div>
                                    <div class="forum-title" style="margin-bottom:4px">{{ $d->title }}</div>
                                    <div class="forum-meta">
                                        {{ \Carbon\Carbon::parse($d->created_at)->diffForHumans() }} by {{ $d->user->name ?? 'User' }}
                                        • {{ $d->replies_count ?? ($d->replies->count() ?? 0) }} comments
                                    </div>
                                </div>
                                @php $canDeleteDiscussion = auth()->check() && (auth()->id() === ($d->user_id ?? 0)); @endphp
                                @if($canDeleteDiscussion)
                                <div><a href="javascript:void(0)" class="link-action" onclick="deleteDiscussion('{{ route('discussions.destroy',$d) }}')"><i class="fas fa-trash"></i> Delete</a></div>
                                @endif
                            </div>
                            @if(!empty($d->image_path))
                                <div style="margin-top:8px">
                                    <img src="{{ asset('storage/'.$d->image_path) }}" alt="discussion image" style="max-width:100%;border-radius:10px;border:1px solid var(--border)">
                                </div>
                            @endif
                            <div style="margin-top:8px">{{ $d->body }}</div>
                            @php
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
                            <div style="padding-top:10px;margin-top:10px;border-top:1px solid var(--border);display:flex;gap:10px;align-items:center">
                                <span class="chip-stat"><i class="fas fa-thumbs-up"></i> {{ $commentLikes }}</span>
                                <span class="chip-stat"><i class="fas fa-thumbs-down"></i> {{ $commentDislikes }}</span>
                            </div>
                        </div>
                        @endif
                        @endforeach
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
                        <div style="font-weight:800;margin-bottom:8px;">Trainers</div>
                        <ul>
                            @forelse($trainers as $t)
                                <li><i class="fas fa-user-tie" style="color:#0f3b8f;"></i> {{ $t->name }}</li>
                            @empty
                                <li class="muted">No trainers listed.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <div style="font-weight:800;margin-bottom:8px;">Classmates</div>
                        <ul>
                            @forelse($classmates as $s)
                                <li><i class="fas fa-user" style="color:#0f3b8f;"></i> {{ $s->name }}</li>
                            @empty
                                <li class="muted">No classmates listed.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="announceModal" class="modal-overlay">
        <div class="modal">
            <form method="POST" action="{{ route('courses.class-announcements.store', $course) }}">
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
    <div id="discussionModal" class="modal-overlay">
        <div class="modal">
            <form id="discussionForm" action="{{ route('courses.discussions.store',$course) }}" method="POST" enctype="multipart/form-data" onsubmit="submitDiscussion(event)">
                @csrf
                @if(!empty($asTrainer))
                    <input type="hidden" name="as_trainer" value="1">
                @endif
                <div class="modal-editor">
                    <label for="discussionTitle" class="muted" style="display:block;margin-bottom:4px;">Title</label>
                    <input id="discussionTitle" name="title" type="text" maxlength="200" oninput="updateDiscussionCounts()" placeholder="Enter a clear, concise title" style="width:100%;font-size:1.05rem;color:#0f172a;">
                    <div class="counter" id="titleCount" aria-live="polite">0/200</div>
                    <label for="discussionBody" class="muted" style="display:block;margin:10px 0 4px;">Content</label>
                    <textarea id="discussionBody" name="body" oninput="updateDiscussionCounts()" placeholder="Write at least 10 characters..." style="width:100%;min-height:140px;font-size:1rem;color:#0f172a;resize:vertical"></textarea>
                    <div class="counter" id="bodyCount" aria-live="polite">0 chars</div>
                    <label for="discussionImage" class="muted" style="display:block;margin:10px 0 4px;">Image (optional)</label>
                    <input id="discussionImage" name="image" type="file" accept="image/*" style="display:block;">
                    <div id="discussionError" class="error-text" role="alert"></div>
                </div>
                <div class="modal-actions">
                    <div></div>
                    <div class="post-cta">
                        <a href="javascript:void(0)" onclick="closeDiscussionModal()" class="link-action">Cancel</a>
                        <button id="discussionSubmit" class="btn btn-disabled" type="submit" disabled>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
        function deleteReply(replyId){
            if(!confirm('Delete this reply?')) return;
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
                        showSuccessToast('Discussion deleted.');
                        setTimeout(function(){ window.location.reload(); }, 600);
                        return;
                    }
                    if(r.status===403){
                        r.json().then(function(j){ alert(j.message || 'You can only delete your own discussion.'); }).catch(function(){ alert('You can only delete your own discussion.'); });
                    } else {
                        alert('Failed to delete discussion');
                    }
                }).catch(function(){ alert('Failed to delete discussion'); });
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
            var bar = document.getElementById('overallBar');
            var detail = document.getElementById('overallDetail');
            var list = document.getElementById('moduleProgressList');
            if(!ring || !bar) return;
            var url = "{{ route('courses.progress.json', $course) }}";
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
                    bar.style.width = pct+'%';
                    if(detail){ detail.textContent = total ? '('+done+'/'+total+' subtopics)' : ''; }
                    if(list && Array.isArray(j.modules)){
                        list.innerHTML = j.modules.map(function(m){
                            var title = m.title || ('Module '+(m.index+1));
                            var p = m.percent || 0;
                            var d = m.done || 0;
                            var t = m.total || 0;
                            return '<div style="display:flex;align-items:center;gap:10px;margin:6px 0">'+
                                   '<div style="flex:1;font-weight:700;color:#0f3b8f">'+title+'</div>'+
                                   '<div style="width:48px;text-align:right;font-weight:700;color:#0f3b8f">'+p+'%</div>'+
                                   '<div style="flex:2">'+
                                   '<div class="progress-bar" style="height:6px"><div style="width:'+p+'%"></div></div>'+
                                   '<div class="muted" style="font-size:.8rem;margin-top:2px">'+d+'/'+t+'</div>'+
                                   '</div></div>';
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
</body>
</html>
