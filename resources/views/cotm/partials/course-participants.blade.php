<div id="tm-course-participants">
    <style>
        :root{--blue:#002C76;--primary-blue:#002C76;--green:#00a859;--bg:#f4f6f9;--text:#111827;--muted:#6b7280;--border:#e5e7eb;--ring:#60a5fa}
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
        .submit{text-align:right}
        .btn{border:none;background:var(--green);color:#fff;padding:12px 18px;border-radius:12px;cursor:pointer;font-weight:600}
        .btn:hover{filter:brightness(0.95)}
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
        .tm-topbar{display:flex;justify-content:flex-start;margin-bottom:14px}
        .tm-back{color:#0d6efd;text-decoration:none;display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border:1px solid var(--border);background:#fff;border-radius:999px;box-shadow:0 1px 2px rgba(0,0,0,.05);transition:all .2s;cursor:pointer}
        .tm-back:hover{background:#f8fafc;border-color:var(--ring);box-shadow:0 0 0 3px rgba(96,165,250,.15)}
    </style>

    <div class="tm-topbar">
        <a class="tm-back" href="{{ route('dashboard', ['tab' => 'trainer-trainee-management']) }}"><i class="fas fa-arrow-left"></i> Back to Training Management</a>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <h3>Course</h3>
        <div class="body">
            @php
                $trainersCount = $course->users
                    ? $course->users->filter(fn($u)=>in_array($u->role,['coach','trainer']))->count()
                    : 0;
                $pendingTraineesCount = $course->users
                    ? $course->users->filter(fn($u)=>in_array($u->role,['trainee','participant']) && optional($u->pivot)->status==='pending')->count()
                    : 0;
                $enrolledTraineesCount = $course->users
                    ? $course->users->filter(fn($u)=>in_array($u->role,['trainee','participant']) && optional($u->pivot)->status==='active')->count()
                    : 0;
            @endphp
            <div style="font-weight:700;color:#002C76;font-size:1.1rem;">{{ $course->name }}</div>
            <div class="meta">
                <span><i class="fas fa-layer-group"></i> {{ $course->subject_area ?: 'Uncategorized' }}</span>
            </div>
            <p class="info">Select coaches and participants to be active in this course. Selecting a participant who previously requested to join will approve them.</p>
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
                        <p>Pending Participants</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(25,135,84,0.12); color:#198754;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $enrolledTraineesCount }}</h3>
                        <p>Enrolled Participants</p>
                    </div>
                </div>
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
                <h3><i class="fas fa-list"></i> Participants Summary</h3>
                <div class="body">
                    @php 
                        $courseTrainees = $course->users
                            ->whereIn('role',['participant','trainee'])
                            ->filter(fn($u)=> in_array(optional($u->pivot)->status, ['pending','active']));
                    @endphp
                    @if($courseTrainees->count())
                        <div class="summary-table cols-4" id="trainee_summary_table">
                            <div class="summary-header">
                                <div class="summary-cell">Name</div>
                                <div class="summary-cell">Account ID</div>
                                <div class="summary-cell">Enrolled At</div>
                                <div class="summary-cell" style="text-align:right">Status</div>
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
                                        <span class="badge {{ $st === 'active' ? 'b-active' : 'b-pending' }}">{{ $st === 'active' ? 'Enrolled' : 'Pending' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="info">No trainees found.</div>
                    @endif
                </div>
            </div>
            <div class="card">
                <h3><i class="fas fa-user-graduate"></i> Participants</h3>
                <div class="body">
                    @php
                        $currentActiveIds = $course->users->whereIn('role',['participant','trainee'])->filter(fn($u)=>$u->pivot && $u->pivot->status==='active')->pluck('id')->toArray();
                        $available = $potentialTrainees->filter(fn($u)=>!in_array($u->id, $currentActiveIds));
                    @endphp
                    <div class="dual">
                        <div>
                            <div class="col-title">Available options</div>
                            <div class="list-head">
                                <div class="count"><span id="avail_sel_count">0</span> of <span id="avail_total_count">{{ count($available) }}</span> items selected</div>
                                <div class="search"><i class="fas fa-search"></i><input id="filter_available" type="text" placeholder="Find by name"></div>
                            </div>
                            <div class="shell">
                                <div id="available_trainees" class="list" aria-label="Available participants">
                                    @foreach($available as $user)
                                        <label class="item" data-id="{{ $user->id }}" data-name="{{ strtolower($user->name) }}">
                                            <input type="checkbox">
                                            <span class="item-label">{{ $user->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="button" onclick="moveSelected('available_trainees','selected_trainees')"><i class="fas fa-chevron-right"></i></button>
                            <button type="button" onclick="moveAll('available_trainees','selected_trainees')"><i class="fas fa-angles-right"></i></button>
                            <button type="button" onclick="moveAll('selected_trainees','available_trainees')"><i class="fas fa-angles-left"></i></button>
                            <button type="button" onclick="moveSelected('selected_trainees','available_trainees')"><i class="fas fa-chevron-left"></i></button>
                        </div>
                        <div>
                            <div class="col-title">Chosen options</div>
                            <div class="list-head">
                                <div class="count"><span id="sel_sel_count">{{ count($currentActiveIds) }}</span> of <span id="sel_total_count">{{ count($currentActiveIds) }}</span> items selected</div>
                                <div class="search"><i class="fas fa-search"></i><input id="filter_selected" type="text" placeholder="Find by name"></div>
                            </div>
                            <div class="shell">
                                <div id="selected_trainees" class="list" aria-label="Selected trainees">
                                    @foreach($potentialTrainees as $user)
                                        @if(in_array($user->id, $currentActiveIds))
                                            <label class="item" data-id="{{ $user->id }}" data-name="{{ strtolower($user->name) }}">
                                                <input type="checkbox">
                                                <span class="item-label">{{ $user->name }}</span>
                                                <input type="hidden" name="trainee_ids[]" value="{{ $user->id }}">
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info">Move participants to Selected to enroll or approve them as active.</div>
                </div>
            </div>
        </div>
        <div class="submit">
            <button type="submit" class="btn"><i class="fas fa-save"></i> Save Participants</button>
        </div>
    </form>

    <script>
        (function(){
            document.querySelectorAll('#tm-course-participants .tab-btn').forEach(btn=>{
                btn.addEventListener('click', ()=>{
                    document.querySelectorAll('#tm-course-participants .tab-btn').forEach(b=>b.classList.remove('active'));
                    document.querySelectorAll('#tm-course-participants .tab-panel').forEach(p=>p.classList.remove('active'));
                    btn.classList.add('active');
                    const id = 'tab-' + btn.dataset.tab;
                    const panel = document.getElementById(id);
                    if(panel) panel.classList.add('active');
                });
            });
        })();
        function moveSelected(fromId,toId){
            const from=document.getElementById(fromId);
            const to=document.getElementById(toId);
            const items=Array.from(from.querySelectorAll('.item input:checked')).map(cb=>cb.closest('.item'));
            items.forEach(it=>{
                it.querySelector('input[type=checkbox]').checked=false;
                to.appendChild(it);
            });
            syncHiddenInputs();
            syncAllCounts();
            applyFilterGeneric('filter_available','available_trainees','avail_total_count');
            applyFilterGeneric('filter_selected','selected_trainees','sel_total_count');
            applyFilterGeneric('filter_available_trainers','available_trainers','avail_total_count_tr');
            applyFilterGeneric('filter_selected_trainers','selected_trainers','sel_total_count_tr');
        }
        function moveAll(fromId,toId){
            const from=document.getElementById(fromId);
            const to=document.getElementById(toId);
            const items=Array.from(from.querySelectorAll('.item'));
            items.forEach(it=>{
                it.querySelector('input[type=checkbox]').checked=false;
                to.appendChild(it);
            });
            syncHiddenInputs();
            syncAllCounts();
            applyFilterGeneric('filter_available','available_trainees','avail_total_count');
            applyFilterGeneric('filter_selected','selected_trainees','sel_total_count');
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
            const tgt=document.getElementById(totalSpanId);
            if(tgt) tgt.textContent=total;
        }
        function updateCounts(listId, selCountId, totalCountId){
            const el=document.getElementById(listId);
            const selectedVisible=Array.from(el.querySelectorAll('.item input:checked')).filter(cb=>cb.closest('.item').style.display!=='none').length;
            const totalVisible=Array.from(el.querySelectorAll('.item')).filter(it=>it.style.display!=='none').length;
            const s1=document.getElementById(selCountId), s2=document.getElementById(totalCountId);
            if(s1) s1.textContent=selectedVisible;
            if(s2) s2.textContent=totalVisible;
        }
        function syncAllCounts(){
            updateCounts('available_trainees','avail_sel_count','avail_total_count');
            updateCounts('selected_trainees','sel_sel_count','sel_total_count');
            updateCounts('available_trainers','avail_sel_count_tr','avail_total_count_tr');
            updateCounts('selected_trainers','sel_sel_count_tr','sel_total_count_tr');
        }
        function syncHiddenInputs(){
            const selTr=document.getElementById('selected_trainers');
            if(selTr){
                selTr.querySelectorAll('input[type=hidden][name="trainer_ids[]"]').forEach(n=>n.remove());
                Array.from(selTr.querySelectorAll('.item')).forEach(it=>{
                    const id=it.getAttribute('data-id');
                    const h=document.createElement('input');
                    h.type='hidden'; h.name='trainer_ids[]'; h.value=id;
                    it.appendChild(h);
                });
            }
            const selT=document.getElementById('selected_trainees');
            if(selT){
                selT.querySelectorAll('input[type=hidden][name="trainee_ids[]"]').forEach(n=>n.remove());
                Array.from(selT.querySelectorAll('.item')).forEach(it=>{
                    const id=it.getAttribute('data-id');
                    const h=document.createElement('input');
                    h.type='hidden'; h.name='trainee_ids[]'; h.value=id;
                    it.appendChild(h);
                });
            }
        }
        // Ensure no items are pre-selected on load for all lists
        ['available_trainers','selected_trainers','available_trainees','selected_trainees'].forEach(function(id){
            var el=document.getElementById(id);
            if(el){ el.querySelectorAll('.item input[type=checkbox]').forEach(function(cb){ cb.checked=false; }); }
        });
    </script>
</div>


