<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Assessment</title>
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
.main-content{flex:1;padding:30px;overflow:auto;background:var(--bg)}
.page{max-width:1000px;margin:0 auto;padding:0 16px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{color:var(--brand);text-decoration:none;display:inline-flex;gap:8px;align-items:center;border:1px solid var(--border);padding:8px 12px;border-radius:999px;background:#fff}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px;box-shadow:0 2px 6px rgba(0,0,0,.04);margin-top:12px}
.row{display:flex;gap:12px;flex-wrap:wrap}
.field{flex:1 1 260px;display:flex;flex-direction:column;gap:6px}
.label{font-weight:700;color:#1f2937}
.input,.select,.textarea{border:1px solid var(--border);border-radius:12px;padding:10px;background:#fff}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.btn-ghost{background:#fff;border:1px solid var(--border);color:#334155}
.q-list{display:grid;gap:12px;margin-top:12px}
.q-item{border:1px solid var(--border);border-radius:12px;padding:12px;background:#fff}
.choice{display:flex;gap:8px;align-items:center;margin-top:6px}
.choice input[type=text]{flex:1}
.actions{display:flex;justify-content:space-between;gap:8px;margin-top:12px}
</style>
</head>
<body>
<header class="header">
  <div class="header-left">
    <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div id="header-section-title" class="header-section-title">Edit Assessment</div>
  </div>
</header>
<div class="dashboard-container">
  <div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro">
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
        <h1 style="margin:0;font-size:1.4rem">Edit Assessment</h1>
        <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
    </div>

    <div class="card">
        <form id="assessmentForm" action="{{ route('trainer.assessments.update', $assessment) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="field">
                    <label class="label">Title</label>
                    <input class="input" type="text" name="title" required value="{{ old('title', $assessment->title ?? '') }}">
                </div>
                <div class="field">
                    <label class="label">Type</label>
                    <select class="select" name="type" required>
                        <option value="seatwork" @if($assessment->type==='seatwork') selected @endif>Seatwork</option>
                        <option value="quiz" @if($assessment->type==='quiz') selected @endif>Quiz</option>
                        <option value="exam" @if($assessment->type==='exam') selected @endif>Exam</option>
                    </select>
                </div>
                <div class="field">
                    <label class="label">Due Date</label>
                    <input class="input" type="datetime-local" name="due_date" value="{{ old('due_date', $assessment->due_date ? \Carbon\Carbon::parse($assessment->due_date)->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="field" style="margin-top:8px">
                <label class="label">Description</label>
                <textarea class="textarea" name="description" rows="3">{{ old('description', $assessment->description ?? '') }}</textarea>
            </div>
            <div class="card" style="margin-top:12px">
                <div style="font-weight:800;color:#002C76;display:flex;align-items:center;justify-content:space-between">
                    <span>Exam Settings</span>
                    <span class="muted">Used for pass/fail and retake rules</span>
                </div>
                <div class="row" style="margin-top:8px">
                    <div class="field">
                        <label class="label">Passing Rate (%)</label>
                        <input class="input" type="number" min="1" max="100" name="passing_score" value="{{ old('passing_score', $assessment->passing_score ?? '') }}" placeholder="e.g., 75">
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:12px">
                <div class="muted">Questions are shown for reference. To change questions, create a new version or edit via the builder on the Create Classwork page and replace this assessment.</div>
                <div class="q-list" id="questionsList"></div>
            </div>

            <div class="actions">
                <a class="btn btn-ghost" href="{{ route('trainer.courses.enter', $course) }}">Cancel</a>
                <button class="btn btn-blue" type="submit"><i class="fas fa-save"></i> Save</button>
            </div>
        </form>
    </div>
  </div>
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
<script>
var questions = @json($assessment->questions_json ?? []);
function renderQuestions(){
  var list=document.getElementById('questionsList');
  list.innerHTML='';
  if(!Array.isArray(questions) || questions.length===0){ list.innerHTML='<div class="muted">No questions to display.</div>'; return; }
  questions.forEach(function(q,i){
    var div=document.createElement('div');
    div.className='q-item';
    var meta=q.type ? String(q.type).replace('_',' ').toUpperCase() : 'QUESTION';
    var extra='';
    if(q.type==='multiple_choice'){extra='Choices: '+(q.choices||[]).join(' | ')+' • Answer: '+(q.choices && (q.answer_index!=null)? q.choices[q.answer_index] : '');}
    if(q.type==='identification'){extra='Answer: '+(q.answer||'');}
    if(q.type==='true_false'){extra='Answer: '+(q.answer? 'True':'False');}
    div.innerHTML='<div style="font-weight:700">'+(i+1)+'. '+(q.text||'')+'</div><div class="muted" style="margin-top:6px">'+meta+(extra? ' • '+extra:'')+'</div>';
    list.appendChild(div);
  });
}
renderQuestions();
</script>
</body>
</html>
