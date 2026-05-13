    <!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certify Trainees</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #002C76;
            --light-text: #58585b;
            --dark-text: #333333;
        }
        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
            box-sizing: border-box;
            z-index: 1000;
        }
        .header-left { display:flex; align-items:center; }
        .header-title img { height:50px; }
        .header-right { display:flex; align-items:center; gap:15px; position:relative; }
        .profile-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 20px rgba(0,0,0,.08);
            border-radius: 10px;
            width: 220px;
            display: none;
            z-index: 2000;
        }
        .profile-dropdown .dropdown-item {
            display:flex; align-items:center; gap:10px;
            padding:10px 12px; color:#333; text-decoration:none;
        }
        .profile-dropdown .dropdown-item:hover { background:#f8fafc; }
        .profile-dropdown .dropdown-item.danger { color:#b91c1c; }
        .muted { color:#6b7280; }
        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 16px 5px 5px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .user-profile-header:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background-color: #f8fafc;
        }
        .user-profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .user-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-profile-initial {
            font-weight: 800;
            color: #64748b;
            font-size: 1.1rem;
        }
        .user-profile-header .fa-chevron-down {
            font-size: 0.8rem;
            color: #64748b;
            transition: transform 0.2s ease;
        }
        .user-profile-header:hover .fa-chevron-down {
            color: #1e293b;
        }
    </style>
</head>
<body style="font-family: 'DM Sans', sans-serif; background:#f3f4f6; color:#111827;">
    <header class="header">
        <div class="header-left">
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
            </div>
        </div>
        <div class="header-right">
            <div class="profile-menu">
                <div class="user-profile-header" onclick="toggleProfileMenu(event)">
                    <div class="user-profile-avatar">
                        @if(Auth::user()->profile_picture)
                            <img id="header_profile_image" src="{{ Auth::user()->avatar_url }}" alt="Profile" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
                            <span id="header_profile_initial" class="user-profile-initial" style="display: none;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @else
                            <img id="header_profile_image" src="" alt="Profile" style="display: none;">
                            <span id="header_profile_initial" class="user-profile-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div id="profileDropdown" class="profile-dropdown">
                    <a class="dropdown-item" href="{{ route('dashboard', ['tab' => 'profile-section']) }}">
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
    <div style="max-width:1100px;margin:20px auto;padding:0 12px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
            <h1 style="margin:0;color:#0f3b8f">Certification <strong>Management</strong></h1>
            <a href="{{ route('dashboard',['tab'=>'certification-management']) }}" style="text-decoration:none">
                <button style="display:inline-flex;align-items:center;gap:8px;background:#0f3b8f;color:#fff;border:none;border-radius:8px;padding:8px 12px;cursor:pointer">
                    <i class="fas fa-arrow-left"></i> Back to Certificates
                </button>
            </a>
        </div>
        @if(session('success_certification'))
            <div style="margin-bottom:12px;padding:10px 12px;border:1px solid #c1e7d2;background:#f0fff6;border-radius:10px;color:#065f46;font-weight:700">
                {{ session('success_certification') }}
            </div>
        @endif
        @if(session('error_certification'))
            <div style="margin-bottom:12px;padding:10px 12px;border:1px solid #f5c2c7;background:#fff5f5;border-radius:10px;color:#842029;font-weight:700">
                {{ session('error_certification') }}
            </div>
        @endif
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:16px">
            <div style="display:flex;gap:12px">
                @php $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp; @endphp
                <img src="{{ $course->image_path ? asset('storage/'.$course->image_path).'?v='.$ver : 'https://via.placeholder.com/300x160?text=No+Image' }}" alt="{{ $course->name }}" style="width:220px;height:140px;object-fit:cover;border-right:1px solid #e5e7eb">
                <div style="padding:12px 16px;flex:1">
                    <div style="font-size:1.3rem;font-weight:800;color:#0f3b8f">{{ $course->name }}</div>
                    <div style="color:#6b7280;margin-top:6px">{{ $course->subject_area ?? 'Uncategorized' }}</div>
                    <div style="margin-top:8px;color:#334155"><strong>Trainer(s):</strong>
                        @php $tn = $trainers->pluck('name')->implode(', '); @endphp
                        {{ $tn ?: 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Inline certificate grid removed in favor of modal-based selection --}}

        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:16px">
            <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:10px">
                <div style="font-weight:800;color:#0f3b8f">Certificate Template</div>
                <button type="button" onclick="openCertSelectModal()" style="display:inline-flex;align-items:center;gap:8px;background:#0f3b8f;color:#fff;border:none;border-radius:8px;padding:8px 12px;cursor:pointer">
                    <i class="fas fa-list"></i> Select Certificate
                </button>
            </div>
            <div style="padding:16px;display:flex;gap:18px;align-items:stretch;flex-wrap:wrap">
                <div style="flex:0 1 520px;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 8px 20px rgba(2,6,23,.06);padding:10px;position:relative;min-height:120px">
                    <div id="certSelectedPlaceholder" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#6b7280">Select a certificate to preview</div>
                    <img id="certSelectedPreview" alt="Selected Certificate Preview" style="display:none;width:100%;height:auto;border-radius:8px">
                </div>
                <div style="flex:1;min-width:280px;display:flex;align-items:stretch;justify-content:center;align-self:stretch">
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 8px 20px rgba(2,6,23,.06);padding:18px 20px;text-align:center;max-width:520px;width:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%">
                        <div id="certSelectedName" style="font-weight:900;color:#0f3b8f;font-size:1.35rem;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">No certificate selected yet</div>
                        <div id="certSelectedTypeWrap" style="margin-top:10px">
                            <span id="certSelectedType" style="display:none;align-self:center;background:#eef2ff;color:#0f3b8f;border:1px solid #dbeafe;border-radius:999px;padding:8px 14px;font-weight:800;font-size:1rem">—</span>
                        </div>
                        <div id="certSelectedNoPreview" style="display:none;margin-top:10px;color:#6b7280">Preview not available for this file type.</div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="selectedCertId" name="certification_id" form="bulkCertForm" value="">

        <form method="POST" action="{{ route('admin.certifications.course.certify', $course) }}" id="bulkCertForm" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);overflow:hidden;margin-bottom:16px">
            @csrf
            <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;display:flex;flex-wrap:wrap;gap:12px;align-items:center">
                <label style="display:inline-flex;align-items:center;gap:8px;color:#0f3b8f">
                    <input type="checkbox" name="only_completed" value="1" onchange="filterOnlyCompleted(this)">
                    Only show 100% completed
                </label>
                <div style="margin-left:auto">
                    <button type="submit" style="padding:8px 14px;background:#0f3b8f;color:#fff;border:none;border-radius:8px;cursor:pointer"><i class="fas fa-certificate"></i> Certify Selected</button>
                </div>
            </div>
            <div style="padding:0">
                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="background:#f8fafc;border-bottom:1px solid #e5e7eb;color:#0f3b8f">
                            <th style="padding:10px;width:48px"><input type="checkbox" onclick="toggleAll(this)"></th>
                            <th style="padding:10px;text-align:left">Name</th>
                            <th style="padding:10px;text-align:left">Account ID</th>
                            <th style="padding:10px;text-align:left">Email</th>
                            <th style="padding:10px;text-align:right">Completion</th>
                        </tr>
                    </thead>
                    <tbody id="traineeTbody">
                        @forelse($trainees as $t)
                            @php $pct = $progress[$t->id] ?? 0; @endphp
                            <tr data-pct="{{ $pct }}" style="border-bottom:1px solid #f1f5f9">
                                <td style="padding:10px;text-align:center">
                                    <input type="checkbox" name="user_ids[]" value="{{ $t->id }}" {{ $pct < 100 ? 'disabled' : '' }} title="{{ $pct < 100 ? 'Requires 100% completion' : '' }}">
                                </td>
                                <td style="padding:10px">{{ $t->name }}</td>
                                <td style="padding:10px;font-family:monospace">{{ $t->account_id ?? '-' }}</td>
                                <td style="padding:10px">{{ $t->email }}</td>
                                <td style="padding:10px;text-align:right;font-weight:700;color:#0f3b8f">{{ $pct }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding:12px;color:#6b7280">No enrolled trainees.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,.06);overflow:hidden">
            <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;gap:10px">
                <div style="font-weight:800;color:#0f3b8f">Already Certified</div>
                <div id="certifiedCount" class="muted" style="color:#6b7280"></div>
            </div>
            <div style="padding:0">
                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="background:#f8fafc;border-bottom:1px solid #e5e7eb;color:#0f3b8f">
                            <th style="padding:10px;text-align:left">Name</th>
                            <th style="padding:10px;text-align:left">Account ID</th>
                            <th style="padding:10px;text-align:left">Email</th>
                            <th style="padding:10px;text-align:left">Certificate #</th>
                            <th style="padding:10px;text-align:right">Date</th>
                            <th style="padding:10px;text-align:right">Completion</th>
                            <th style="padding:10px;text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="certifiedTbody">
                        <tr><td colspan="7" style="padding:12px;color:#6b7280">Loading already-certified users for this course…</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="selectCertModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:4000;align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:14px;max-width:960px;width:92%;max-height:90vh;overflow:auto;box-shadow:0 16px 40px rgba(0,0,0,.2)">
                <div style="padding:12px 16px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between">
                    <div style="font-weight:800;color:#0f3b8f">Select Certificate</div>
                    <button type="button" onclick="closeCertSelectModal()" style="border:none;background:#fff;border-radius:8px;padding:6px 10px;cursor:pointer">×</button>
                </div>
                <div style="padding:14px">
                    @if(($certifications ?? collect())->isEmpty())
                        <div style="color:#6b7280">No certificates available. Create one under Certificates → Create Certificate.</div>
                    @else
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px">
                            @foreach($certifications as $c)
                                @php
                                    $ext = strtolower(pathinfo($c->file_path ?? '', PATHINFO_EXTENSION));
                                    $isImg = in_array($ext, ['png','jpg','jpeg']);
                                @endphp
                                <div onclick="chooseCert({{ $c->id }}, '{{ addslashes($c->name) }}', '{{ addslashes($c->category ?? '—') }}', '{{ route('media.public', ['path' => $c->file_path]) }}')" style="border:2px solid #e5e7eb;border-radius:12px;overflow:hidden;cursor:pointer;transition:border-color .18s ease;background:#fff">
                                    <div style="height:140px;display:flex;align-items:center;justify-content:center;background:#f8fafc;border-bottom:1px solid #e5e7eb">
                                        @if($isImg)
                                            <img src="{{ route('media.public', ['path' => $c->file_path]) }}" alt="{{ $c->name }}" style="max-width:100%;max-height:100%;object-fit:cover">
                                        @else
                                            <div style="text-align:center;color:#0f3b8f;font-weight:800">
                                                <i class="fas fa-file-{{ $ext==='pdf'?'pdf':'alt' }}" style="font-size:2rem"></i><div>{{ strtoupper($ext) }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="padding:10px 12px;display:flex;align-items:center;justify-content:space-between;gap:8px">
                                        <div style="font-weight:800;color:#002C76;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $c->name }}">{{ $c->name }}</div>
                                        <span style="display:inline-block;background:#eef2ff;color:#0f3b8f;border-radius:6px;padding:4px 8px;font-weight:800;font-size:.75rem">{{ $c->category ?? '—' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div style="padding:12px 16px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end">
                    <button type="button" onclick="closeCertSelectModal()" style="padding:8px 12px;border:1px solid #e5e7eb;background:#fff;border-radius:8px;cursor:pointer">Close</button>
                </div>
            </div>
        </div>
        <div id="certModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:3000;align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:12px;min-width:360px;max-width:90%;box-shadow:0 8px 24px rgba(0,0,0,.18);overflow:hidden">
                <div style="padding:16px;border-bottom:1px solid #e5e7eb">
                    <div style="font-weight:800;color:#0f3b8f">Certificate</div>
                </div>
                <div style="padding:16px;display:grid;gap:10px">
                    <div>
                        <label style="font-weight:700;color:#0f3b8f">Certificate #</label>
                        <input id="certNumberInput" type="text" maxlength="20" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                    </div>
                    <div>
                        <label style="font-weight:700;color:#0f3b8f">Date</label>
                        <input id="certDateInput" type="date" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                    </div>
                </div>
                <div style="padding:12px 16px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:8px">
                    <button type="button" onclick="closeCertModal()" style="padding:8px 12px;border:1px solid #e5e7eb;background:#fff;border-radius:8px;cursor:pointer">Close</button>
                    <button id="saveCertBtn" type="button" onclick="saveCertChanges()" style="padding:8px 12px;background:#0f3b8f;color:#fff;border:none;border-radius:8px;cursor:pointer">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        function toggleProfileMenu(e){
            e.stopPropagation();
            var dd=document.getElementById('profileDropdown');
            if(dd){ dd.style.display = dd.style.display==='block' ? 'none' : 'block'; }
            document.addEventListener('click', hideProfileMenu, { once:true });
        }
        function hideProfileMenu(){ var dd=document.getElementById('profileDropdown'); if(dd){ dd.style.display='none'; } }
        function showProfile(){ window.location.href='{{ route('dashboard', ['tab' => 'profile-section']) }}'; }
        function toggleAll(cb){
            document.querySelectorAll('#traineeTbody input[type="checkbox"][name="user_ids[]"]').forEach(function(x){
                if(!x.disabled){ x.checked = cb.checked; }
            });
        }
        function filterOnlyCompleted(box){
            var v = box && box.checked;
            document.querySelectorAll('#traineeTbody tr[data-pct]').forEach(function(row){
                var pct = parseInt(row.getAttribute('data-pct') || '0', 10) || 0;
                row.style.display = (v && pct < 100) ? 'none' : '';
            });
        }
        function loadStatus(){
            var url = "{{ route('admin.certifications.course.status', $course) }}";
            fetch(url, {headers:{'Accept':'application/json'}}).then(function(r){ return r.ok ? r.json() : Promise.reject(); }).then(function(j){
                var notCert = Array.isArray(j.not_certified) ? j.not_certified : [];
                var have = Array.isArray(j.certified) ? j.certified : [];
                var tb = document.getElementById('traineeTbody');
                var html = '';
                if(!notCert.length){ html = '<tr><td colspan="5" style="padding:12px;color:#6b7280">No users to certify.</td></tr>'; }
                notCert.forEach(function(t){
                    var name = (t.name||'').replace(/</g,'&lt;');
                    var acct = (t.account_id||'-').replace(/</g,'&lt;');
                    html += '<tr data-pct="'+(t.percent||0)+'" style="border-bottom:1px solid #f1f5f9">'+
                            '<td style="padding:10px;text-align:center"><input type="checkbox" '+((t.percent||0)<100?'disabled title="Requires 100% completion"':'')+' name="user_ids[]" value="'+t.id+'"></td>'+
                            '<td style="padding:10px">'+name+'</td>'+
                            '<td style="padding:10px;font-family:monospace">'+acct+'</td>'+
                            '<td style="padding:10px">'+(t.email||'')+'</td>'+
                            '<td style="padding:10px;text-align:right;font-weight:700;color:#0f3b8f">'+(t.percent||0)+'%</td>'+
                            '</tr>';
                });
                tb.innerHTML = html;
                var cb = document.getElementById('certifiedTbody');
                var ch = '';
                if(!have.length){ ch = '<tr><td colspan="7" style="padding:12px;color:#6b7280">No already-certified users for this course.</td></tr>'; }
                have.forEach(function(t){
                    var name = (t.name||'').replace(/</g,'&lt;');
                    var acct = (t.account_id||'-').replace(/</g,'&lt;');
                    ch += '<tr style="border-bottom:1px solid #f1f5f9">'+
                          '<td style="padding:10px">'+name+'</td>'+
                          '<td style="padding:10px;font-family:monospace">'+acct+'</td>'+
                          '<td style="padding:10px">'+(t.email||'')+'</td>'+
                          '<td style="padding:10px;font-family:monospace">'+(t.certificate_number||'')+'</td>'+
                          '<td style="padding:10px;text-align:right">'+(t.issued_at||'')+'</td>'+
                          '<td style="padding:10px;text-align:right;font-weight:700;color:#0f3b8f">'+(t.percent||0)+'%</td>'+
                          '<td style="padding:10px;text-align:right;white-space:nowrap">'+
                              '<button type="button" onclick=\'openCertModal(' + JSON.stringify(t.certificate_number||"") + ', ' + JSON.stringify(t.issued_at||"") + ', true, '+t.id+', '+(t.certification_id||'null')+')\' style="padding:6px 10px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;margin-right:6px">View</button>'+
                              '<button type="button" onclick=\'openCertModal(' + JSON.stringify(t.certificate_number||"") + ', ' + JSON.stringify(t.issued_at||"") + ', false, '+t.id+', '+(t.certification_id||'null')+')\' style="padding:6px 10px;background:#0f3b8f;color:#fff;border:none;border-radius:6px;cursor:pointer;margin-right:6px">Edit</button>'+
                              '<button type="button" onclick="confirmRevokeCert('+t.id+','+(t.certification_id||'null')+')" style="padding:6px 10px;background:#b91c1c;color:#fff;border:none;border-radius:6px;cursor:pointer">Revoke</button>'+
                          '</td>'+
                          '</tr>';
                });
                cb.innerHTML = ch;
                var cnt = document.getElementById('certifiedCount');
                if(cnt){ cnt.textContent = have.length ? have.length+' users' : ''; }
            }).catch(function(){});
        }
        var EDIT_CTX = { userId: null, certId: null };
        function openCertModal(number, date, readOnly, userId, certId){
            if(!userId || !certId){ return; }
            EDIT_CTX.userId = userId; EDIT_CTX.certId = certId;
            var m = document.getElementById('certModal');
            var n = document.getElementById('certNumberInput');
            var d = document.getElementById('certDateInput');
            var btn = document.getElementById('saveCertBtn');
            n.value = number || '';
            d.value = date || '';
            n.disabled = !!readOnly;
            d.disabled = !!readOnly;
            btn.style.display = readOnly ? 'none' : 'inline-block';
            m.style.display = 'flex';
        }
        function closeCertModal(){ var m=document.getElementById('certModal'); if(m){ m.style.display='none'; } }
        function saveCertChanges(){
            if(!EDIT_CTX.userId || !EDIT_CTX.certId){ return; }
            var urlTmpl = "{{ route('admin.certifications.course.cert.update', [$course, 'user' => '__UID__']) }}";
            var url = urlTmpl.replace('__UID__', EDIT_CTX.userId);
            var num = document.getElementById('certNumberInput').value || '';
            var dat = document.getElementById('certDateInput').value || '';
            fetch(url, {
                method:'POST',
                headers:{'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept':'application/json','Content-Type':'application/json'},
                body: JSON.stringify({ certification_id: EDIT_CTX.certId, certificate_number: num, issued_at: dat })
            }).then(function(r){ return r.json(); }).then(function(j){
                if(j && j.ok){ closeCertModal(); loadStatus(); }
                else { alert(j.message || 'Update failed'); }
            }).catch(function(){ alert('Update failed'); });
        }
        async function confirmRevokeCert(userId, certId){
            if(!userId || !certId){ return; }
            if(!await window.capdevConfirm('Revoke this certification?', { title: 'Revoke Certification', confirmText: 'Revoke' })) return;
            var urlTmpl = "{{ route('admin.certifications.course.cert.delete', [$course, 'user' => '__UID__']) }}";
            var url = urlTmpl.replace('__UID__', userId);
            fetch(url, { method:'DELETE', headers:{'X-CSRF-TOKEN': CSRF_TOKEN,'Accept':'application/json','Content-Type':'application/json'}, body: JSON.stringify({ certification_id: certId }) })
                .then(function(r){ return r.json(); })
                .then(function(j){ if(j && j.ok){ loadStatus(); } else { alert(j.message || 'Revoke failed'); } })
                .catch(function(){ alert('Revoke failed'); });
        }
        loadStatus();
        function openCertSelectModal(){
            var m=document.getElementById('selectCertModal'); if(m){ m.style.display='flex'; }
        }
        function closeCertSelectModal(){
            var m=document.getElementById('selectCertModal'); if(m){ m.style.display='none'; }
        }
        function chooseCert(id, name, category, url){
            var hid=document.getElementById('selectedCertId');
            var nameEl=document.getElementById('certSelectedName');
            var typeEl=document.getElementById('certSelectedType');
            if(hid){ hid.value = id; }
            if(nameEl){ nameEl.textContent = name || 'Certificate'; }
            if(typeEl){ typeEl.textContent = category || '—'; typeEl.style.display='inline-flex'; }
            // attempt to show preview image
            var img=document.getElementById('certSelectedPreview');
            var ph=document.getElementById('certSelectedPlaceholder');
            var noPrev=document.getElementById('certSelectedNoPreview');
            if(img){
                if(ph){ ph.style.display='flex'; }
                img.onerror = function(){ if(noPrev){ noPrev.style.display='block'; } img.style.display='none'; if(ph){ ph.style.display='none'; } };
                img.onload = function(){ img.style.display='block'; if(noPrev){ noPrev.style.display='none'; } if(ph){ ph.style.display='none'; } };
                img.src = url;
            }
            closeCertSelectModal();
        }
    </script>
</body>
</html>
