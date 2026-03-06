<section id="help-support" class="content-section {{ request('tab') == 'help-support' ? 'active' : '' }}">
    <style>
        .help-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
        .help-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 12px 28px rgba(15,23,42,.08);padding:18px;transition:transform .2s ease, box-shadow .2s ease;border-top-width:2px;border-top-color:#c7d2fe}
        .help-card:hover{transform:translateY(-2px);box-shadow:0 18px 36px rgba(15,23,42,.12)}
        .help-head{display:flex;align-items:center;gap:10px;margin-bottom:8px;color:#0b3b8f;font-weight:800}
        .help-sub{color:#64748b;font-size:.9rem}
        .help-actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
        .help-chip{display:inline-flex;align-items:center;gap:8px;background:#ffffff;color:#0b3b8f;border:1px solid #c7d2fe;border-radius:999px;padding:8px 12px;font-weight:800;cursor:pointer;text-decoration:none;box-shadow:0 6px 14px rgba(2,6,23,.06);transition:all .18s ease}
        .help-chip i{color:#0b3b8f}
        .help-chip:hover{background:#eef2ff;border-color:#a5b4fc;box-shadow:0 10px 22px rgba(2,6,23,.12);transform:translateY(-1px)}
        .help-list{list-style:none;margin:0;padding:0;display:grid;gap:8px;color:#64748b}
        .help-link{color:#0b3b8f;font-weight:700;text-decoration:none}
        .help-hero{background:linear-gradient(135deg,#081C3A 0%,#0B2C74 50%,#1e88e5 100%);color:#fff;border-radius:20px;box-shadow:0 24px 48px rgba(2,6,23,.26);padding:22px;display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;position:relative;overflow:hidden}
        .help-hero:before{content:"";position:absolute;inset:-40px -60px auto auto;width:280px;height:280px;border-radius:50%;background:radial-gradient(closest-side,rgba(255,255,255,.25),transparent);filter:blur(10px);pointer-events:none}
        .help-hero-title{font-weight:800;letter-spacing:-.01em}
        .help-hero-sub{opacity:.95;font-size:.95rem}
        .help-search{display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:999px;padding:12px 16px;box-shadow:0 12px 24px rgba(2,6,23,.12);margin:16px 0}
        .help-search input{border:none;outline:none;width:100%;font-weight:800;color:#0b3b8f}
        .help-search input::placeholder{color:#94a3b8}
        .suggest-row{display:flex;gap:8px;flex-wrap:wrap;margin:6px 0 14px}
        .suggest-chip{display:inline-flex;align-items:center;gap:6px;border:1px solid #e5e7eb;border-radius:999px;padding:6px 10px;background:#f8fafc;color:#0b3b8f;font-weight:800;cursor:pointer}
        .faq-item{border:1px solid #e5e7eb;border-radius:12px;overflow:hidden}
        .faq-head{background:#f8fafc;padding:10px 12px;cursor:pointer;font-weight:800;color:#0b3b8f;display:flex;align-items:center;justify-content:space-between}
        .faq-body{display:none;padding:12px;color:#64748b;background:#fff}
        .kb-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px}
        .kb-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:14px;box-shadow:0 10px 24px rgba(15,23,42,.08)}
        .kb-title{color:#0b3b8f;font-weight:800}
        .team-heading{grid-column:1/-1;text-align:center;font-weight:900;color:#0b2c74;font-size:1.25rem;letter-spacing:-.01em}
        .team-supervisor{grid-column:1/-1;justify-self:center;max-width:520px}
        .team-avatar{width:42px;height:42px;border-radius:50%;object-fit:cover;border:3px solid #e5e7eb;background:#f1f5f9}
    </style>
    <div class="settings-bar">
        <h2 style="margin:0;color:#002C76">Help & Support</h2>
    </div>
    <div class="help-hero">
        <div>
            <div class="help-hero-title">Need Assistance?</div>
            <div class="help-hero-sub">Search FAQs or view troubleshooting tips. Click a team card to view profile.</div>
        </div>
        <div class="help-search" style="min-width:280px">
            <i class="fas fa-search" style="color:#0b3b8f"></i>
            <input id="helpSearchInput" type="text" placeholder="Search Help (e.g. password, enroll, certificate)">
        </div>
    </div>
    <div class="suggest-row" id="helpSuggest"></div>
    <div class="help-grid">
        <div class="help-card">
            <div class="help-head"><i class="fas fa-question-circle"></i> Quick FAQs</div>
            <div class="faq-item" data-tags="password profile security reset">
                <div class="faq-head">How to reset password? <i class="fas fa-chevron-down"></i></div>
                <div class="faq-body">Go to Profile → Change Password. Use a strong passphrase.</div>
            </div>
            <div class="faq-item" data-tags="enroll course registration">
                <div class="faq-head">How to enroll in a course? <i class="fas fa-chevron-down"></i></div>
                <div class="faq-body">Open Courses → select course → Enroll button.</div>
            </div>
            <div class="faq-item" data-tags="account pending approval">
                <div class="faq-head">Why is my account pending? <i class="fas fa-chevron-down"></i></div>
                <div class="faq-body">Your registrar must approve your account; please wait or contact support.</div>
            </div>
        </div>
        <div class="help-card">
            <div class="help-head"><i class="fas fa-rocket"></i> Getting Started</div>
            <div class="category-row">
                <a class="help-chip" href="{{ url('/dashboard') }}?tab=user-management"><i class="fas fa-users"></i> Manage Users</a>
                <a class="help-chip" href="{{ url('/dashboard') }}?tab=course-management"><i class="fas fa-book"></i> Manage Courses</a>
                <a class="help-chip" href="{{ url('/dashboard') }}?tab=system-settings"><i class="fas fa-cogs"></i> System Settings</a>
            </div>
        </div>
        <div class="help-card">
            <div class="help-head"><i class="fas fa-wrench"></i> Troubleshooting</div>
            <ul class="help-list">
                <li>Clear browser cache if UI looks outdated.</li>
                <li>Ensure you selected the correct office scope (CO/RO/PO).</li>
                <li>Import PSGC data in System Settings for accurate regional mapping.</li>
            </ul>
        </div>
        <div class="help-card team-heading">DILG-CAR Developer Team</div>
        <div class="help-card team-member" data-name="Mark Ezekiel Zareno" data-role="Developer, System Architect" data-avatar="{{ asset('images/team/mark_ezekiel_zareno.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/mark_ezekiel_zareno.jpg') }}" alt="Mark Ezekiel Zareno" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Mark Ezekiel Zareno</div>
            <div class="help-sub">Developer, System Architect</div>
        </div>
        <div class="help-card team-member" data-name="Josiah Carrera" data-role="Developer, System Architect" data-avatar="{{ asset('images/team/josiah_carrera.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/josiah_carrera.jpg') }}" alt="Josiah Carrera" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Josiah Carrera</div>
            <div class="help-sub">Developer, System Architect</div>
        </div>
        <div class="help-card team-member" data-name="Rahm Soriano" data-role="UI/UX Designer, Developer" data-avatar="{{ asset('images/team/rahm_soriano.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/rahm_soriano.jpg') }}" alt="Rahm Soriano" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Rahm Soriano</div>
            <div class="help-sub">UI/UX Designer, Developer</div>
        </div>
        <div class="help-card team-member" data-name="Kevin Aquino" data-role="UI/UX Designer, Developer & QA Tester" data-avatar="{{ asset('images/team/kevin_aquino.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/kevin_aquino.jpg') }}" alt="Kevin Aquino" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Kevin Aquino</div>
            <div class="help-sub">UI/UX Designer, Developer & QA Tester</div>
        </div>
        <div class="help-card team-member" data-name="Kathleen Charm Daroy" data-role="UI/UX Designer, System Analyst" data-avatar="{{ asset('images/team/kathleen_charm_daroy.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/kathleen_charm_daroy.jpg') }}" alt="Kathleen Charm Daroy" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Kathleen Charm Daroy</div>
            <div class="help-sub">UI/UX Designer, System Analyst</div>
        </div>
        <div class="help-card team-member" data-name="Patrick Medrano" data-role="Developer, Database Administrator" data-avatar="{{ asset('images/team/patrick_medrano.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/patrick_medrano.jpg') }}" alt="Patrick Medrano" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> Patrick Medrano</div>
            <div class="help-sub">Developer, Database Administrator</div>
        </div>
        <div class="help-card team-member team-supervisor" data-name="DILG-CAR Team Supervisor" data-role="Team Supervisor" data-avatar="{{ asset('images/team/supervisor.jpg') }}">
            <div class="help-head"><img class="team-avatar" src="{{ asset('images/team/supervisor.jpg') }}" alt="DILG-CAR Team Supervisor" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'"> DILG-CAR Team Supervisor</div>
            <div class="help-sub">Team Supervisor</div>
        </div>
    </div>
    <div id="teamProfileModal" style="display:none;position:fixed;inset:0;z-index:1600">
        <div id="teamBackdrop" style="position:absolute;inset:0;background:rgba(2,6,23,.5)"></div>
        <div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:min(520px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 24px 60px rgba(2,6,23,.24);overflow:hidden">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #e5e7eb;background:#f8fafc">
                <div style="font-weight:800;color:#0b2c74">Profile</div>
                <button id="teamClose" style="border:none;background:transparent;cursor:pointer;color:#64748b;font-size:1.25rem;line-height:1">×</button>
            </div>
            <div style="padding:18px;display:flex;align-items:center;gap:16px">
                <img id="teamAvatar" src="{{ asset('images/user.png') }}" alt="Avatar" style="width:84px;height:84px;border-radius:50%;object-fit:cover;border:3px solid #e5e7eb;background:#f1f5f9">
                <div style="flex:1;min-width:0">
                    <div id="teamName" style="font-weight:900;font-size:1.1rem;color:#0b2c74"></div>
                    <div id="teamRole" style="color:#475569;margin-top:4px"></div>
                    <div style="margin-top:12px">
                        <a id="teamPublicLink" href="#" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid #c7d2fe;border-radius:999px;text-decoration:none;color:#0b2c74;font-weight:800"><i class="fas fa-id-card"></i> View Public Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function(){
            var input=document.getElementById('helpSearchInput');
            var items=[].slice.call(document.querySelectorAll('#help-support .faq-item'));
            var teamCards=[].slice.call(document.querySelectorAll('#help-support .team-member'));
            var suggest=document.getElementById('helpSuggest');
            var TEAM_LINKS={
                'Mark Ezekiel Zareno':'https://web-portfolio-project-delta.vercel.app/about.html',
                'Josiah Carrera':'#',
                'Rahm Soriano':'https://rahmyls-fproject.vercel.app/#projects',
                'Kevin Aquino':'https://aquinokevs.github.io/my-portfolio/',
                'Kathleen Charm Daroy':'https://myfinalprojectelective3.vercel.app/?brid=aBn8sPL39MT8662jS-3s3Q#projects',
                'Patrick Medrano':'https://project01-myportfolio.vercel.app/#',
                'DILG-CAR Team Supervisor':'#'
            };
            var tModal=document.getElementById('teamProfileModal');
            var tBackdrop=document.getElementById('teamBackdrop');
            var tClose=document.getElementById('teamClose');
            var tName=document.getElementById('teamName');
            var tRole=document.getElementById('teamRole');
            var tAvatar=document.getElementById('teamAvatar');
            var tLink=document.getElementById('teamPublicLink');
            function toggle(el){
                var body=el.querySelector('.faq-body'); var shown=body.style.display==='block';
                body.style.display=shown?'none':'block';
            }
            items.forEach(function(it){ it.querySelector('.faq-head').addEventListener('click', function(){ toggle(it); }); });
            if(input){
                input.addEventListener('input', function(){
                    var q=(this.value||'').toLowerCase().trim();
                    items.forEach(function(it){
                        var t=(it.getAttribute('data-tags')||'').toLowerCase();
                        var show=!q || t.indexOf(q)>=0;
                        it.style.display=show?'':'none';
                    });
                });
            }
            function openTeam(name, role, avatar){
                if(!tModal) return;
                if(tName) tName.textContent=name||'';
                if(tRole) tRole.textContent=role||'';
                if(tAvatar){ tAvatar.src=avatar||'{{ asset('images/user.png') }}'; tAvatar.onerror=function(){ this.onerror=null; this.src='{{ asset('images/user.png') }}'; }; }
                if(tLink){ tLink.href=TEAM_LINKS[name] || '#'; }
                tModal.style.display='block';
            }
            function closeTeam(){ if(tModal) tModal.style.display='none'; }
            teamCards.forEach(function(card){
                card.style.cursor='pointer';
                card.addEventListener('click', function(){
                    var n=card.getAttribute('data-name')||'';
                    var r=card.getAttribute('data-role')||'';
                    var a=card.getAttribute('data-avatar')||'';
                    openTeam(n,r,a);
                });
            });
            if(suggest){
                var tags=['password','enroll','roles','account','PSGC','reports','courses','print certificate'];
                tags.forEach(function(t){
                    var a=document.createElement('a');
                    a.className='suggest-chip';
                    a.textContent=t;
                    a.href='#';
                    a.addEventListener('click', function(e){ e.preventDefault(); if(input){ input.value=t; input.dispatchEvent(new Event('input',{bubbles:true})); input.focus(); }});
                    suggest.appendChild(a);
                });
            }
            if(tBackdrop) tBackdrop.addEventListener('click', closeTeam);
            if(tClose) tClose.addEventListener('click', closeTeam);
            document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeTeam(); });

            // Annotation mode (only when ?annotate=1)
            var qs = new URLSearchParams(window.location.search);
            if(qs.get('annotate')==='1'){
                var btn=document.createElement('button');
                btn.textContent='Export Annotated';
                btn.style.cssText='position:fixed;right:16px;bottom:16px;z-index:2000;background:#0b2c74;color:#fff;border:none;border-radius:10px;padding:10px 14px;font-weight:800;box-shadow:0 10px 24px rgba(2,6,23,.24);cursor:pointer';
                document.body.appendChild(btn);
                var overlay=document.createElement('div');
                overlay.id='hs-annot-overlay';
                overlay.style.cssText='position:absolute;left:0;top:0;right:0;bottom:0;pointer-events:none;z-index:1500';
                document.body.appendChild(overlay);
                function mark(el,label){
                    if(!el) return;
                    var r=el.getBoundingClientRect();
                    var d=document.createElement('div');
                    d.className='hs-annot';
                    d.style.cssText='position:absolute;border:3px solid #ef4444;border-radius:12px;box-shadow:0 8px 22px rgba(239,68,68,.25);';
                    d.style.left=(window.scrollX+r.left-6)+'px';
                    d.style.top=(window.scrollY+r.top-6)+'px';
                    d.style.width=(r.width+12)+'px';
                    d.style.height=(r.height+12)+'px';
                    var lab=document.createElement('div');
                    lab.textContent=label;
                    lab.style.cssText='position:absolute;left:0;top:-28px;background:#ef4444;color:#fff;padding:4px 8px;border-radius:8px;font-weight:800;font-size:.85rem';
                    d.appendChild(lab);
                    overlay.appendChild(d);
                }
                function annotateAll(){
                    overlay.innerHTML='';
                    var root=document.getElementById('help-support');
                    if(!root) return;
                    root.scrollIntoView({behavior:'instant',block:'start'});
                    mark(document.querySelector('#help-support .settings-bar h2'),'Header Title');
                    mark(document.querySelector('#help-support .help-hero'),'Banner Card');
                    mark(document.querySelector('#help-support .help-search'),'Search Bar');
                    var cards=[].slice.call(document.querySelectorAll('#help-support .help-grid .help-card'));
                    if(cards[0]) mark(cards[0],'Quick FAQs');
                    if(cards[1]) mark(cards[1],'Getting Started');
                    if(cards[2]) mark(cards[2],'Troubleshooting');
                    mark(document.querySelector('#help-support .team-heading'),'Developer Team Title');
                    document.querySelectorAll('#help-support .team-member').forEach(function(cm,i){ mark(cm,'Team Member '+(i+1)); });
                }
                btn.addEventListener('click', function(){
                    annotateAll();
                    var tgt=document.getElementById('help-support');
                    if(!tgt) return;
                    var script=document.createElement('script');
                    script.onload=function(){
                        html2canvas(tgt,{scale:2,useCORS:true}).then(function(canvas){
                            var a=document.createElement('a');
                            a.href=canvas.toDataURL('image/png');
                            var role=(window.APP_ROLE||'user');
                            a.download='help_support_'+role+'.png';
                            a.click();
                        });
                    };
                    script.src='https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
                    document.body.appendChild(script);
                });
            }
        })();
    </script>
</section>
