<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Material</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9;--primary-blue:#002C76;--primary-green:#7fb73d;--sidebar-width:250px;--sidebar-collapsed-width:70px;--header-height:80px}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:var(--header-height);box-sizing:border-box;z-index:1000;position:fixed;top:0;left:var(--sidebar-width);right:0}
.header-left{display:flex;align-items:center}
.header-toggle{background:none;border:none;color:var(--primary-blue);font-size:1.3rem;padding:8px 12px;border-radius:6px;cursor:pointer}
.header-toggle:hover{background:#f0f2f7}
.header-section-title{margin-left:12px;font-weight:700;color:var(--primary-blue);font-size:1.2rem;letter-spacing:-.01em}
.profile-menu{position:relative}
.profile-dropdown{position:absolute;top:50px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none}
.profile-dropdown .dropdown-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer}
.profile-dropdown .dropdown-item:hover{background:#f8fafc}
.profile-dropdown .danger{color:#b91c1c}
.profile-trigger{display:flex;align-items:center;gap:8px;cursor:pointer}
.profile-caret{font-size:.9rem;color:#666}
.profile-trigger.open .profile-caret{transform:rotate(180deg);transition:transform .2s}
.dashboard-container{display:flex;flex:1;overflow:hidden;margin-top:var(--header-height);margin-left:var(--sidebar-width);height:calc(100vh - var(--header-height))}
.sidebar{width:var(--sidebar-width);background-color:var(--primary-blue);color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
.sidebar-brand{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)}
.sidebar-logo{height:70px}
.sidebar.collapsed{width:var(--sidebar-collapsed-width)}
.sidebar.collapsed .sidebar-brand{justify-content:center;padding:8px 0}
.sidebar.collapsed .sidebar-logo{height:44px;width:44px;margin:0 auto;display:block;object-fit:contain}
.main-content{flex:1;padding:30px;overflow:auto;background:var(--bg)}
.page{max-width:900px;margin:0 auto;padding:0 16px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{color:var(--brand);text-decoration:none;display:inline-flex;gap:8px;align-items:center;border:1px solid var(--border);padding:8px 12px;border-radius:999px;background:#fff}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px;box-shadow:0 2px 6px rgba(0,0,0,.04);margin-top:12px}
.row{display:flex;gap:12px;flex-wrap:wrap}
.field{flex:1 1 260px;display:flex;flex-direction:column;gap:6px}
.label{font-weight:700;color:#1f2937}
.input,.textarea{border:1px solid var(--border);border-radius:12px;padding:10px;background:#fff}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.btn-ghost{background:#fff;border:1px solid var(--border);color:#334155}
.muted{color:var(--muted)}
</style>
</head>
<body>
<header class="header">
  <div class="header-left">
    <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div id="header-section-title" class="header-section-title">Edit Material</div>
  </div>
  <div class="profile-menu">
    @if(Auth::user()->profile_picture)
      <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" style="width:35px;height:35px;border-radius:50%;object-fit:cover" onclick="toggleProfileMenu()">
    @else
      <div class="user-avatar" style="width:35px;height:35px;background-color:#002C76;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;cursor:pointer" onclick="toggleProfileMenu()">{{ strtoupper(substr(Auth::user()->name ?? 'U',0,1)) }}</div>
    @endif
    <i class="fas fa-chevron-down profile-caret" style="margin-left:8px"></i>
    <div id="profileDropdown" class="profile-dropdown">
      <a class="dropdown-item" href="{{ route('profile.setup') }}"><i class="fas fa-user-cog"></i> <span>Profile</span></a>
      <a class="dropdown-item" href="{{ route('trainer.courses.create') }}"><i class="fas fa-plus-circle"></i> <span>Create Course</span></a>
      <a class="dropdown-item" href="mailto:support@capdevpro.local"><i class="fas fa-life-ring"></i> <span>Help & Support</span></a>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" class="dropdown-item danger" style="width:100%;background:none;border:none;text-align:left;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></form>
    </div>
  </div>
</header>
<div class="dashboard-container">
  <div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
    </div>
    <ul class="nav-menu" style="list-style:none;padding:0;margin:0">
      <li class="nav-item" style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}" class="nav-link" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-tachometer-alt nav-icon" style="width:25px;text-align:center;margin-right:15px"></i><span class="nav-text">Dashboard</span></a></li>
      <li class="nav-item" style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=my-courses" class="nav-link" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-chalkboard-teacher nav-icon" style="width:25px;text-align:center;margin-right:15px"></i><span class="nav-text">My Courses</span></a></li>
      <li class="nav-item" style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=calendar" class="nav-link" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-calendar-alt nav-icon" style="width:25px;text-align:center;margin-right:15px"></i><span class="nav-text">Calendar</span></a></li>
      <li class="nav-item" style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=announcements" class="nav-link" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-bullhorn nav-icon" style="width:25px;text-align:center;margin-right:15px"></i><span class="nav-text">Announcements</span></a></li>
    </ul>
  </div>
  <div class="main-content">
    <div class="page">
        <div class="topbar">
            <h1 style="margin:0;font-size:1.4rem">Edit Material</h1>
            <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
        </div>

        <div class="card">
            <form action="{{ route('trainer.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="field">
                        <label class="label">Title</label>
                        <input class="input" type="text" name="title" required value="{{ $material->title }}">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Description</label>
                    <textarea class="textarea" name="description" rows="3">{{ $material->description }}</textarea>
                </div>
                <div class="field">
                    <label class="label">Current File</label>
                    @if($material->file_path)
                        <a class="back" href="{{ asset('storage/'.$material->file_path) }}" target="_blank"><i class="fas fa-download"></i> {{ basename($material->file_path) }}</a>
                    @else
                        <div class="muted">No file</div>
                    @endif
                </div>
                <div class="field">
                    <label class="label">Replace File (optional)</label>
                    <input class="input" type="file" name="file">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
                    <a class="btn btn-ghost" href="{{ route('trainer.courses.enter', $course) }}">Cancel</a>
                    <button class="btn btn-blue" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
<script>
function toggleSidebar(){
  var s=document.getElementById('sidebar');
  s.classList.toggle('collapsed');
  var collapsed=s.classList.contains('collapsed');
  var logo=document.querySelector('.sidebar-logo');
  if(logo){
    var full=logo.getAttribute('data-full-src');
    var small=logo.getAttribute('data-collapsed-src');
    logo.src=collapsed?small:full;
  }
}
function toggleProfileMenu(){
  var d=document.getElementById('profileDropdown');
  var trigger=document.querySelector('.profile-trigger');
  if(!d) return;
  var open=d.style.display==='block';
  d.style.display=open?'none':'block';
  if(trigger){ trigger.classList.toggle('open', !open); }
}
document.addEventListener('click',function(ev){
  var menu=document.querySelector('.profile-menu');
  var d=document.getElementById('profileDropdown');
  if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}
});
</script>
</body>
</html>
