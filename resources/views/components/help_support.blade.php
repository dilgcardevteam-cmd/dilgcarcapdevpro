<section id="help-support" class="content-section {{ request('tab') == 'help-support' ? 'active' : '' }}">
    <style>
        .help-shell{display:grid;gap:16px}
        .help-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
        .help-card{background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 14px 30px rgba(15,23,42,.08);padding:18px;transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease}
        .help-card:hover{transform:translateY(-3px);box-shadow:0 20px 36px rgba(15,23,42,.12);border-color:#c7d2fe}
        .help-head{display:flex;align-items:center;gap:10px;margin-bottom:8px;color:#0b3b8f;font-weight:900;font-size:1.08rem}
        .help-sub{color:#64748b;font-size:.93rem}
        .help-chip-row{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
        .help-chip{display:inline-flex;align-items:center;gap:8px;background:#fff;color:#0b3b8f;border:1px solid #c7d2fe;border-radius:999px;padding:9px 14px;font-weight:900;cursor:pointer;text-decoration:none;box-shadow:0 6px 14px rgba(2,6,23,.06);transition:all .18s ease}
        .help-chip i{color:#0b3b8f}
        .help-chip:hover{background:#eef2ff;border-color:#a5b4fc;box-shadow:0 12px 22px rgba(2,6,23,.12);transform:translateY(-1px)}
        .help-list{list-style:none;margin:0;padding:0;display:grid;gap:10px;color:#475569}
        .help-list li{position:relative;padding-left:14px}
        .help-list li:before{content:"";position:absolute;left:0;top:.58em;width:6px;height:6px;border-radius:50%;background:#2563eb}
        .help-hero{background:linear-gradient(125deg,#081c3a 0%,#0b2c74 50%,#1d82d8 100%);color:#fff;border-radius:20px;box-shadow:0 24px 48px rgba(2,6,23,.24);padding:22px;display:flex;align-items:center;justify-content:space-between;gap:16px;position:relative;overflow:hidden}
        .help-hero:before{content:"";position:absolute;inset:auto -70px -110px auto;width:280px;height:280px;border-radius:50%;background:radial-gradient(closest-side,rgba(255,255,255,.32),transparent)}
        .help-hero-title{font-weight:900;letter-spacing:-.01em;font-size:1.65rem;line-height:1.05}
        .help-hero-sub{opacity:.95;font-size:.98rem;margin-top:6px;max-width:640px}
        .help-hero-actions{display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:1}
        .help-hero-btn{display:inline-flex;align-items:center;gap:8px;background:#fff;color:#0b3b8f;border:1px solid rgba(255,255,255,.5);border-radius:999px;padding:10px 14px;font-weight:900;text-decoration:none;box-shadow:0 10px 20px rgba(2,6,23,.15)}
        .help-hero-btn:hover{transform:translateY(-1px)}
        .help-search{display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:999px;padding:12px 16px;box-shadow:0 12px 24px rgba(2,6,23,.08)}
        .help-search input{border:none;outline:none;width:100%;font-weight:900;color:#0b3b8f;background:transparent}
        .help-search input::placeholder{color:#94a3b8}
        .suggest-row{display:flex;gap:8px;flex-wrap:wrap}
        .suggest-chip{display:inline-flex;align-items:center;gap:6px;border:1px solid #dbeafe;border-radius:999px;padding:7px 11px;background:#f8fbff;color:#0b3b8f;font-weight:900;cursor:pointer}
        .faq-item{border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:8px}
        .faq-head{background:#f8fafc;padding:10px 12px;cursor:pointer;font-weight:900;color:#0b3b8f;display:flex;align-items:center;justify-content:space-between}
        .faq-body{display:none;padding:12px;color:#475569;background:#fff}
        .vm-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
        .vm-card{background:#fff;border:1px solid #e5e7eb;border-radius:30px;padding:34px 34px 26px;box-shadow:0 10px 26px rgba(15,23,42,.06)}
        .vm-icon{width:76px;height:76px;border-radius:22px;display:flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:22px}
        .vm-icon.vision{background:#fdf2f2;color:#dc2626}
        .vm-icon.mission{background:#eff6ff;color:#0b3b8f}
        .vm-title{font-size:3rem;line-height:1;font-weight:900;letter-spacing:-.02em;margin-bottom:20px}
        .vm-title.vision{color:#dc2626}
        .vm-title.mission{color:#0b3b8f}
        .vm-body{font-size:1.15rem;line-height:1.55;color:#334155;max-width:92%}
        .team-heading{grid-column:1/-1;text-align:center;font-weight:900;color:#0b2c74;font-size:1.25rem;letter-spacing:-.01em;background:linear-gradient(90deg,#f8fbff,#ffffff,#f8fbff)}
        .team-supervisor{grid-column:1/-1;justify-self:center;max-width:560px}
        .team-avatar{width:44px;height:44px;border-radius:50%;object-fit:cover;border:3px solid #e5e7eb;background:#f1f5f9}
        .help-stat-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}
        .help-stat{background:#fff;border:1px solid #dbeafe;border-radius:12px;padding:10px 12px}
        .help-stat .label{font-size:.75rem;color:#64748b;font-weight:800}
        .help-stat .value{font-size:1.2rem;color:#0b3b8f;font-weight:900}
        @media (max-width: 980px){
            .help-hero{flex-direction:column;align-items:flex-start}
            .help-hero-title{font-size:1.4rem}
            .help-stat-row{grid-template-columns:1fr}
            .vm-grid{grid-template-columns:1fr}
            .vm-card{padding:24px 20px}
            .vm-title{font-size:2.2rem}
            .vm-body{font-size:1rem;max-width:100%}
        }
    </style>

    <div class="help-shell">
        <div class="vm-grid">
            <div class="vm-card">
                <div class="vm-icon vision"><i class="far fa-eye"></i></div>
                <div class="vm-title vision">Vision</div>
                <div class="vm-body">
                    A highly trusted Department and Partner in nurturing local governments and sustaining peaceful, safe, progressive, resilient, and inclusive communities towards a comfortable and secure life for Filipinos by 2040.
                </div>
            </div>
            <div class="vm-card">
                <div class="vm-icon mission"><i class="far fa-clipboard"></i></div>
                <div class="vm-title mission">Mission</div>
                <div class="vm-body">
                    The Department shall ensure peace and order, public safety and security, uphold excellence in local governance and enable resilient and inclusive communities.
                </div>
            </div>
        </div>

        <div class="help-grid">
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
    </div>

    <div id="teamProfileModal" style="display:none;position:fixed;inset:0;z-index:1600">
        <div id="teamBackdrop" style="position:absolute;inset:0;background:rgba(2,6,23,.5)"></div>
        <div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:min(520px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 24px 60px rgba(2,6,23,.24);overflow:hidden">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #e5e7eb;background:#f8fafc">
                <div style="font-weight:800;color:#0b2c74">Profile</div>
                <button id="teamClose" style="border:none;background:transparent;cursor:pointer;color:#64748b;font-size:1.25rem;line-height:1">x</button>
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
            var teamCards=[].slice.call(document.querySelectorAll('#help-support .team-member'));
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

            function openTeam(name, role, avatar){
                if(!tModal) return;
                if(tName) tName.textContent=name||'';
                if(tRole) tRole.textContent=role||'';
                if(tAvatar){
                    tAvatar.src=avatar||'{{ asset('images/user.png') }}';
                    tAvatar.onerror=function(){ this.onerror=null; this.src='{{ asset('images/user.png') }}'; };
                }
                if(tLink){ tLink.href=TEAM_LINKS[name] || '#'; }
                tModal.style.display='block';
            }

            function closeTeam(){ if(tModal) tModal.style.display='none'; }

            teamCards.forEach(function(card){
                card.style.cursor='pointer';
                card.addEventListener('click', function(){
                    openTeam(card.getAttribute('data-name')||'', card.getAttribute('data-role')||'', card.getAttribute('data-avatar')||'');
                });
            });

            if(tBackdrop) tBackdrop.addEventListener('click', closeTeam);
            if(tClose) tClose.addEventListener('click', closeTeam);
            document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeTeam(); });
        })();
    </script>
</section>
