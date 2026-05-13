<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Classwork</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9;--sidebar-width:250px;--header-height:80px}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.header{background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:var(--header-height);box-sizing:border-box;z-index:1000;position:fixed;top:0;left:var(--sidebar-width);right:0}
.header-left{display:flex;align-items:center}
.header-toggle,.sidebar-toggle{width:44px;height:44px;background:#fff;border:1px solid #d9e3f2;border-radius:14px;padding:0;cursor:pointer;color:var(--primary-blue);display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 8px 18px rgba(15,23,42,.04);transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background-color .16s ease}
.header-toggle:hover,.sidebar-toggle:hover{background:#f8fbff;border-color:#b8cae6;box-shadow:0 12px 22px rgba(15,23,42,.07);transform:translateY(-1px)}
.header-section-title{margin-left:12px;font-weight:700;color:#002C76;font-size:1.2rem}
.dashboard-container{display:flex;flex:1;overflow:hidden;margin-top:var(--header-height);margin-left:var(--sidebar-width);height:calc(100vh - var(--header-height))}
.sidebar{width:var(--sidebar-width);background-color:#002C76;color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
.sidebar-brand{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)}
.sidebar-logo{height:70px}
.main-content{flex:1;padding:36px;overflow:auto;background:var(--bg)}
.page{max-width:1200px;margin:0 auto;padding:0 20px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{color:var(--brand);text-decoration:none;display:inline-flex;gap:8px;align-items:center;border:1px solid var(--border);padding:8px 12px;border-radius:999px;background:#fff}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px;box-shadow:0 2px 6px rgba(0,0,0,.04);margin-top:12px}
.label{font-weight:700}
.select{border:1px solid var(--border);border-radius:12px;padding:10px;background:#fff;width:100%}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.muted{color:var(--muted)}
</style>
</head>
<body>
<header class="header">
  <div class="header-left">
    <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div id="header-section-title" class="header-section-title">Create Classwork</div>
  </div>
</header>
<div class="dashboard-container">
  <div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img class="sidebar-logo" src="{{ asset('images/CAPDEV PRO WHITE.png') }}" data-full-src="{{ asset('images/CAPDEV PRO WHITE.png') }}" data-collapsed-src="{{ asset('images/CAPDEV PRO WHITE.png') }}" alt="CapDev Pro">
    </div>
    <ul style="list-style:none;padding:0;margin:0">
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-tachometer-alt" style="width:25px;text-align:center;margin-right:15px"></i><span>Dashboard</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=my-courses" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-chalkboard-teacher" style="width:25px;text-align:center;margin-right:15px"></i><span>My Courses</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=calendar" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-calendar-alt" style="width:25px;text-align:center;margin-right:15px"></i><span>Calendar</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=announcements" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-bullhorn" style="width:25px;text-align:center;margin-right:15px"></i><span>Announcements</span></a></li>
    </ul>
  </div>
  <div class="main-content">
    <div class="page">
      <div class="topbar">
        <h1 style="margin:0;font-size:1.4rem">Create Classwork</h1>
        <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
      </div>
<script>
function toggleSidebar(){
  var s=document.getElementById('sidebar');
  s.classList.toggle('collapsed');
  var logo=document.querySelector('.sidebar-logo');
  var collapsed=s.classList.contains('collapsed');
  if(collapsed){
    s.style.width='70px';
    if(logo){ logo.style.height='44px'; logo.style.width='44px'; logo.src=logo.getAttribute('data-collapsed-src'); }
    document.querySelector('.dashboard-container').style.marginLeft='70px';
    document.querySelector('.header').style.left='70px';
  }else{
    s.style.width='250px';
    if(logo){ logo.style.height='70px'; logo.style.width='auto'; logo.src=logo.getAttribute('data-full-src'); }
    document.querySelector('.dashboard-container').style.marginLeft='250px';
    document.querySelector('.header').style.left='250px';
  }
}
</script>
      <div class="card">
    <div class="label" style="margin-bottom:6px">What would you like to create?</div>
    <div class="muted" style="margin-bottom:8px">Choose a type. You can always come back to create the other.</div>
    <select id="cwType" class="select" aria-label="Classwork Type">
      <option value="" selected disabled>Select type…</option>
      <option value="material">Material</option>
      <option value="assessment">Assessment</option>
    </select>
    <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
      <button id="goBtn" class="btn btn-blue" type="button" disabled><i class="fas fa-arrow-right"></i> Continue</button>
    </div>
      </div>
<script>
  (function(){
    var sel=document.getElementById('cwType');
    var go=document.getElementById('goBtn');
    sel.addEventListener('change', function(){ go.disabled = !this.value; });
    go.addEventListener('click', function(){
      if(sel.value==='material'){
        window.location.href = "{{ route('trainer.courses.materials.create', $course) }}";
      }else if(sel.value==='assessment'){
        window.location.href = "{{ route('trainer.courses.assessments.create', $course) }}";
      }
    });
  })();
  </script>
    </div>
  </div>
</div>
</body>
</html>



