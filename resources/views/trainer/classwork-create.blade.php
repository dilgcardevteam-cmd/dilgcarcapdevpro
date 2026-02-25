<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Classwork</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:1200px;margin:0 auto;padding:0 20px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{color:var(--brand);text-decoration:none;display:inline-flex;gap:8px;align-items:center;border:1px solid var(--border);padding:8px 12px;border-radius:999px;background:#fff}
.tabs{display:flex;border-bottom:1px solid var(--border);gap:8px;margin-bottom:12px}
.tab{border:none;background:none;padding:12px 16px;font-weight:700;color:#334155;cursor:pointer;border-bottom:2px solid transparent}
.tab.active{color:var(--brand);border-color:var(--brand)}
.card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:20px;box-shadow:0 8px 22px rgba(0,0,0,.06);margin-top:14px;transition:box-shadow .2s ease,border-color .2s ease}
.row{display:flex;gap:16px;flex-wrap:wrap}
.field{flex:1 1 320px;display:flex;flex-direction:column;gap:8px}
.label{font-weight:700;color:#1f2937}
.input,.select,.textarea{border:1px solid var(--border);border-radius:12px;padding:12px;background:#fff;transition:border-color .15s ease,box-shadow .2s ease;font-size:1rem}
.input:hover,.select:hover,.textarea:hover{border-color:#c7d2fe;box-shadow:0 0 0 4px rgba(15,59,143,.08)}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.btn-ghost{background:#fff;border:1px solid var(--border);color:#334155}
.q-list{display:grid;gap:12px;margin-top:12px}
.q-item{border:1px solid var(--border);border-radius:12px;padding:12px;background:#fff;transition:transform .15s ease, box-shadow .2s ease, border-color .2s ease}
.q-item:hover{transform:translateY(-2px);box-shadow:0 10px 18px rgba(0,0,0,.08);border-color:#c7d2fe}
.qi-title:hover{color:var(--brand)}
.choice{display:flex;gap:8px;align-items:center;margin-top:6px;transition:background-color .15s ease}
.choice:hover{background:#f8fafc;border-radius:10px}
.choice input[type=text]{flex:1}
.actions{display:flex;justify-content:space-between;gap:8px;margin-top:12px}
/* Test Bank Modal */
.tb-overlay{display:none;position:fixed;z-index:3000;inset:0;background:rgba(15,23,42,.45);}
.tb-box{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);background:#fff;border-radius:14px;border:1px solid var(--border);box-shadow:0 20px 48px rgba(0,0,0,.2);width:min(920px,92vw);max-height:80vh;display:flex;flex-direction:column}
.tb-hd{display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border);font-weight:800}
.tb-body{padding:12px 16px;overflow:auto}
.tb-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px}
.tb-card{border:1px solid var(--border);border-radius:12px;padding:12px;background:#fff;display:flex;flex-direction:column;gap:6px}
.tb-card .muted{color:#64748b}
.tb-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:8px}
</style>
</head>
<body>
<header class="header" style="background:#fff;padding:15px 30px;box-shadow:0 2px 4px rgba(0,0,0,.05);display:flex;align-items:center;justify-content:space-between;height:80px;box-sizing:border-box;z-index:1000;position:fixed;top:0;left:250px;right:0">
  <div style="display:flex;align-items:center">
    <button style="background:none;border:none;color:#002C76;font-size:1.3rem;padding:8px 12px;border-radius:6px;cursor:pointer" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div id="header-section-title" style="margin-left:12px;font-weight:700;color:#002C76;font-size:1.2rem;letter-spacing:-.01em">Create Classwork</div>
  </div>
  <div class="profile-menu" style="position:relative">
    @if(Auth::user()->profile_picture)
      <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" style="width:35px;height:35px;border-radius:50%;object-fit:cover" onclick="toggleProfileMenu()">
    @else
      <div style="width:35px;height:35px;background-color:#002C76;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;cursor:pointer" onclick="toggleProfileMenu()">{{ strtoupper(substr(Auth::user()->name ?? 'U',0,1)) }}</div>
    @endif
    <i class="fas fa-chevron-down profile-caret" style="margin-left:8px"></i>
    <div id="profileDropdown" style="position:absolute;top:50px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12);min-width:220px;z-index:1200;overflow:hidden;display:none">
      <a class="dropdown-item" href="{{ route('profile.setup') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer"><i class="fas fa-user-cog"></i> <span>Profile</span></a>
      <a class="dropdown-item" href="{{ route('trainer.courses.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer"><i class="fas fa-plus-circle"></i> <span>Create Course</span></a>
      <a class="dropdown-item" href="mailto:support@capdevpro.local" style="display:flex;align-items:center;gap:10px;padding:10px 14px;color:#111827;text-decoration:none;cursor:pointer"><i class="fas fa-life-ring"></i> <span>Help & Support</span></a>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="dropdown-item" style="display:flex;align-items:center;gap:10px;padding:10px 14px;color:#b91c1c;background:none;border:none;text-align:left;width:100%"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button>
      </form>
    </div>
  </div>
</header>
<div class="dashboard-container" style="display:flex;flex:1;overflow:hidden;margin-top:80px;margin-left:250px;height:calc(100vh - 80px)">
  <div class="sidebar" id="sidebar" style="width:250px;background-color:#002C76;color:#fff;transition:width .3s ease;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh">
    <div class="sidebar-brand" style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.12)">
      <img class="sidebar-logo" src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-full-src="{{ asset('images/capdev_pro_w-removebg-preview.png') }}" data-collapsed-src="{{ asset('images/logo1.png') }}" alt="CapDev Pro" style="height:70px">
    </div>
    <ul class="nav-menu" style="list-style:none;padding:0;margin:0">
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-tachometer-alt" style="width:25px;text-align:center;margin-right:15px"></i><span>Dashboard</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=my-courses" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-chalkboard-teacher" style="width:25px;text-align:center;margin-right:15px"></i><span>My Courses</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=calendar" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-calendar-alt" style="width:25px;text-align:center;margin-right:15px"></i><span>Calendar</span></a></li>
      <li style="border-bottom:1px solid rgba(255,255,255,0.1)"><a href="{{ route('dashboard') }}?tab=announcements" style="display:flex;align-items:center;padding:15px 25px;color:rgba(255,255,255,0.9);text-decoration:none"><i class="fas fa-bullhorn" style="width:25px;text-align:center;margin-right:15px"></i><span>Announcements</span></a></li>
    </ul>
  </div>
  <div class="main-content" style="flex:1;padding:36px;overflow:auto;background:#f4f6f9">
<div class="page">
    <div class="topbar">
        <h1 style="margin:0;font-size:1.4rem">Create Classwork</h1>
        <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
    </div>

    <div class="tabs">
        <button class="tab active" data-tab="materials">Materials</button>
        <button class="tab" data-tab="assessments">Assessments</button>
    </div>

    <div id="materials" class="card">
        <form action="{{ route('trainer.upload-material') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="muted" style="margin-bottom:8px">Upload course files here. This does not create an assessment.</div>
            <div class="row">
                <div class="field">
                    <label class="label">Material Title</label>
                    <input class="input" type="text" name="title" placeholder="Enter material title" required aria-label="Material Title">
                </div>
                <div class="field">
                    <label class="label">File</label>
                    <input class="input" type="file" name="file" required>
                </div>
            </div>
            <div class="field" style="margin-top:8px">
                <label class="label">Description</label>
                <textarea class="textarea" name="description" rows="3"></textarea>
            </div>
            <div class="actions">
                <div></div>
                <button class="btn btn-blue" type="submit"><i class="fas fa-upload"></i> Upload Material</button>
            </div>
        </form>
    </div>

    <div id="assessments" class="card" style="display:none">
        <form id="assessmentForm" action="{{ route('trainer.create-assessment') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" id="questions_json" name="questions_json">
            <div class="muted" style="margin-bottom:8px">Build an assessment here. This does not upload materials.</div>
            <div class="field" style="margin-bottom:8px">
                <label class="label">Test Bank</label>
                <div class="row" style="align-items:center;justify-content:space-between">
                    <button id="openBankBtn" class="btn btn-ghost" type="button"><i class="fas fa-database"></i> Browse Test Bank</button>
                    <button id="reloadBankTop" class="btn btn-ghost" type="button" style="white-space:nowrap"><i class="fas fa-rotate"></i> Refresh</button>
                </div>
                <div class="muted">Open the modal to reuse saved assessments.</div>
            </div>
            <div class="row">
                <div class="field">
                    <label class="label">Assessment Title</label>
                    <input class="input" type="text" name="title" placeholder="Enter assessment title" required aria-label="Assessment Title">
                </div>
                <div class="field">
                    <label class="label">Type</label>
                    <select class="select" name="type" required>
                        <option value="seatwork">Seatwork</option>
                        <option value="quiz">Quiz</option>
                        <option value="exam">Exam</option>
                    </select>
                </div>
                <div class="field">
                    <label class="label">Due Date</label>
                    <input class="input" type="datetime-local" name="due_date">
                </div>
            </div>
            <div class="field" style="margin-top:8px">
                <label class="label">Description</label>
                <textarea class="textarea" name="description" rows="3"></textarea>
            </div>

            <div class="q-list" id="questionsList"></div>

            <div class="card" id="builderCard" style="margin-top:12px">
                <div class="row">
                    <div class="field">
                        <label class="label">Question</label>
                        <input id="qText" class="input" type="text" placeholder="Enter question">
                    </div>
                    <div class="field">
                        <label class="label">Question Type</label>
                        <select id="qType" class="select">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="identification">Identification</option>
                            <option value="true_false">True or False</option>
                            <option value="essay">Essay</option>
                        </select>
                    </div>
                </div>
                <div id="choicesBox" style="display:block;margin-top:8px">
                    <div class="choice"><input type="text" class="input" placeholder="Choice A"><input type="radio" name="mcCorrect" value="0"><span>Correct</span></div>
                    <div class="choice"><input type="text" class="input" placeholder="Choice B"><input type="radio" name="mcCorrect" value="1"><span>Correct</span></div>
                    <div class="choice"><input type="text" class="input" placeholder="Choice C"><input type="radio" name="mcCorrect" value="2"><span>Correct</span></div>
                    <div class="choice"><input type="text" class="input" placeholder="Choice D"><input type="radio" name="mcCorrect" value="3"><span>Correct</span></div>
                </div>
                <div id="tfBox" style="display:none;margin-top:8px">
                    <label class="label" style="margin-bottom:6px">Answer</label>
                    <select id="tfAnswer" class="select">
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </div>
                <div id="idBox" style="display:none;margin-top:8px">
                    <label class="label" style="margin-bottom:6px">Answer</label>
                    <input id="idAnswer" class="input" type="text" placeholder="Enter answer">
                </div>
                <div id="essayBox" style="display:none;margin-top:8px">
                    <div class="muted">Essay has no preset answer</div>
                </div>
                <div class="actions" style="justify-content:center">
                    <button type="button" class="btn btn-ghost" id="cancelEditBtn" style="display:none"><i class="fas fa-xmark"></i> Cancel</button>
                    <button type="button" class="btn btn-ghost" id="addQuestionBtn"><i class="fas fa-plus"></i> Add Question</button>
                </div>
            </div>

            <div class="actions" style="justify-content:flex-end">
                <div style="display:flex;gap:8px;align-items:center">
                    <span id="saveBankStatus" class="muted" style="display:none"></span>
                    <button id="saveBankBtn" class="btn btn-ghost" type="button"><i class="fas fa-save"></i> Save to Test Bank</button>
                    <button class="btn btn-blue" type="submit"><i class="fas fa-check"></i> Create Assessment</button>
                </div>
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
function toggleProfileMenu(){
  var d=document.getElementById('profileDropdown');
  if(!d) return;
  d.style.display = d.style.display==='block' ? 'none' : 'block';
}
document.addEventListener('click',function(ev){
  var menu=document.querySelector('.profile-menu');
  var d=document.getElementById('profileDropdown');
  if(menu&&d&&!menu.contains(ev.target)){d.style.display='none';}
});
</script>

<!-- Test Bank Modal -->
<div id="bankModal" class="tb-overlay" aria-hidden="true">
  <div class="tb-box" role="dialog" aria-modal="true" aria-labelledby="tbTitle">
    <div class="tb-hd">
      <div id="tbTitle">Select From Test Bank</div>
      <button type="button" id="tbClose" class="btn btn-ghost">Close</button>
    </div>
    <div class="tb-body">
      <div style="margin-bottom:8px;display:flex;gap:8px;align-items:center">
        <input id="tbSearch" class="input" type="text" placeholder="Search saved assessments…" style="flex:1">
        <button id="tbRefresh" class="btn btn-ghost" type="button"><i class="fas fa-rotate"></i> Refresh</button>
      </div>
      <div id="tbGrid" class="tb-grid"></div>
    </div>
    <div class="tb-actions">
      <button type="button" id="tbCancel" class="btn btn-ghost">Cancel</button>
    </div>
  </div>
  </div>

<!-- Delete confirm modal -->
<div id="tbDelOverlay" class="tb-overlay" aria-hidden="true">
  <div class="tb-box" role="dialog" aria-modal="true">
    <div class="tb-hd">Delete From Test Bank</div>
    <div class="tb-body">
      <div id="tbDelText">Are you sure you want to delete this item? This cannot be undone.</div>
    </div>
    <div class="tb-actions">
      <button type="button" id="tbDelCancel" class="btn btn-ghost">Cancel</button>
      <button type="button" id="tbDelConfirm" class="btn btn-blue">Delete</button>
    </div>
  </div>
</div>

<script>
var bankBase = "{{ url('/trainer/test-banks') }}";
var tabs=document.querySelectorAll('.tab');
tabs.forEach(function(t){t.addEventListener('click',function(){
tabs.forEach(function(b){b.classList.remove('active')});
document.getElementById('materials').style.display='none';
document.getElementById('assessments').style.display='none';
var id=t.getAttribute('data-tab');
t.classList.add('active');
document.getElementById(id).style.display='block';
})});
var qType=document.getElementById('qType');
function syncQBoxes(){
var type=qType.value;
document.getElementById('choicesBox').style.display= type==='multiple_choice'?'block':'none';
document.getElementById('tfBox').style.display= type==='true_false'?'block':'none';
document.getElementById('idBox').style.display= type==='identification'?'block':'none';
document.getElementById('essayBox').style.display= type==='essay'?'block':'none';
}
qType.addEventListener('change',syncQBoxes);syncQBoxes();
var questions=[];
var editingIndex = -1;
function renderQuestions(){
var list=document.getElementById('questionsList');
list.innerHTML='';
questions.forEach(function(q,i){
var div=document.createElement('div');
div.className='q-item';
var meta=q.type.replace('_',' ').toUpperCase();
var extra='';
if(q.type==='multiple_choice'){extra='Choices: '+q.choices.join(' | ')+' • Answer: '+q.choices[q.answer_index];}
if(q.type==='identification'){extra='Answer: '+q.answer;}
if(q.type==='true_false'){extra='Answer: '+(q.answer?'True':'False');}
div.innerHTML='<div class="qi-title" style="font-weight:700;cursor:pointer">'+(i+1)+'. '+q.text+'</div>'
  +'<div class="muted" style="margin-top:6px">'+meta+(extra? ' • '+extra:'')+'</div>'
  +'<div style="margin-top:8px;display:flex;gap:8px">'
  +'<button data-act="edit" class="btn btn-ghost">Edit</button>'
  +'<button data-act="remove" class="btn btn-ghost">Remove</button>'
  +'</div>';
div.querySelector('.qi-title').addEventListener('click',function(e){e.preventDefault(); editQuestion(i);});
div.querySelector('[data-act="edit"]').addEventListener('click',function(e){e.preventDefault(); e.stopPropagation(); editQuestion(i);});
div.querySelector('[data-act="remove"]').addEventListener('click',function(e){e.preventDefault(); e.stopPropagation(); questions.splice(i,1); renderQuestions();});
list.appendChild(div);
});
document.getElementById('questions_json').value=JSON.stringify(questions);
// keep the builder in view for rapid entry
var builder=document.getElementById('builderCard');
if(builder){ builder.scrollIntoView({behavior:'smooth',block:'start'}); }
var q=document.getElementById('qText'); if(q){ q.focus(); }
}
function cancelEdit(){
  editingIndex=-1;
  var btn=document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML='<i class="fas fa-plus"></i> Add Question'; }
  var c=document.getElementById('cancelEditBtn'); if(c){ c.style.display='none'; }
  document.getElementById('qText').value='';
  document.querySelectorAll('#choicesBox .choice input[type=text]').forEach(function(i){i.value=''});
  document.querySelectorAll('#choicesBox input[type=radio]').forEach(function(r){r.checked=false});
  document.getElementById('idAnswer').value='';
  document.getElementById('tfAnswer').value='true';
}
document.getElementById('cancelEditBtn').addEventListener('click', function(e){ e.preventDefault(); cancelEdit(); });
function editQuestion(i){
  editingIndex = i;
  var q = questions[i] || {};
  var qInput = document.getElementById('qText');
  qInput.value = q.text || '';
  qType.value = q.type || 'multiple_choice';
  syncQBoxes();
  if(q.type==='multiple_choice'){
    var inputs = document.querySelectorAll('#choicesBox .choice input[type=text]');
    for(var k=0;k<inputs.length;k++){ inputs[k].value = (q.choices && q.choices[k]) ? q.choices[k] : ''; }
    var radios = document.querySelectorAll('#choicesBox input[type=radio]');
    radios.forEach(function(r){ r.checked=false; });
    if(typeof q.answer_index==='number' && radios[q.answer_index]){ radios[q.answer_index].checked = true; }
  }else if(q.type==='identification'){
    document.getElementById('idAnswer').value = q.answer || '';
  }else if(q.type==='true_false'){
    document.getElementById('tfAnswer').value = q.answer ? 'true' : 'false';
  }
  var btn = document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML = '<i class="fas fa-save"></i> Update Question'; }
  var c = document.getElementById('cancelEditBtn'); if(c){ c.style.display='inline-flex'; }
  var builder = document.getElementById('builderCard'); if(builder){ builder.scrollIntoView({behavior:'smooth',block:'start'}); }
  qInput.focus();
}
document.getElementById('addQuestionBtn').addEventListener('click',function(){
var text=document.getElementById('qText').value.trim();
if(!text)return;
var type=qType.value;
if(type==='multiple_choice'){
var inputs=document.querySelectorAll('#choicesBox .choice input[type=text]');
var choices=[];inputs.forEach(function(i){if(i.value.trim())choices.push(i.value.trim())});
var checked=document.querySelector('#choicesBox input[type=radio]:checked');
var ans=checked?parseInt(checked.value,10):0;
if(choices.length<2)return;
var obj={type:'multiple_choice',text:text,choices:choices,answer_index:ans};
if(editingIndex>-1){ questions[editingIndex]=obj; } else { questions.push(obj); }
}else if(type==='identification'){
var ans=document.getElementById('idAnswer').value.trim();var obj={type:'identification',text:text,answer:ans}; if(editingIndex>-1){questions[editingIndex]=obj;} else {questions.push(obj);}
}else if(type==='true_false'){
var ans=document.getElementById('tfAnswer').value==='true';var obj={type:'true_false',text:text,answer:ans}; if(editingIndex>-1){questions[editingIndex]=obj;} else {questions.push(obj);}
}else{
var obj={type:'essay',text:text}; if(editingIndex>-1){questions[editingIndex]=obj;} else {questions.push(obj);}
}
document.getElementById('qText').value='';
document.querySelectorAll('#choicesBox .choice input[type=text]').forEach(function(i){i.value=''});
document.querySelectorAll('#choicesBox input[type=radio]').forEach(function(r){r.checked=false});
document.getElementById('idAnswer').value='';
renderQuestions();
editingIndex=-1;
var btn=document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML='<i class="fas fa-plus"></i> Add Question'; }
var c=document.getElementById('cancelEditBtn'); if(c){ c.style.display='none'; }
});
document.getElementById('assessmentForm').addEventListener('submit',function(){
document.getElementById('questions_json').value=JSON.stringify(questions);
});
async function fetchBank(){
  const list=document.getElementById('bankList');
  if(list){ list.innerHTML='<div class="muted">Loading…</div>'; }
  try{
    const res=await fetch('{{ route('trainer.test-banks.index') }}',{
      method:'GET',
      headers:{
        'Accept':'application/json',
        'X-Requested-With':'XMLHttpRequest'
      },
      credentials:'same-origin'
    });
    const data=await res.json();
    const items=data.items||[];
    window.testBankItems = items;
    if(list){
      if(items.length===0){ list.innerHTML='<div class="muted">No items created yet.</div>'; return; }
      list.innerHTML='';
      items.forEach(function(it){
        const div=document.createElement('div');
        div.className='q-item';
        div.innerHTML='<div style="font-weight:700">'+it.title+' <span class="muted">('+it.type+')</span></div>'
          +'<div class="muted" style="margin-top:6px">'+(it.description||'')+'</div>'
          +'<div style="margin-top:8px;display:flex;gap:8px"><button class="btn btn-ghost">Use</button></div>';
        div.querySelector('button').addEventListener('click',function(){
          try{
            questions = Array.isArray(it.questions_json)? it.questions_json : JSON.parse(it.questions_json||'[]');
            renderQuestions();
            document.querySelector('select[name=\"type\"]').value = it.type;
            document.querySelector('input[name=\"title\"]').value = it.title;
            document.querySelector('textarea[name=\"description\"]').value = it.description||'';
          }catch(e){}
        });
        list.appendChild(div);
      });
    }
  }catch(e){
    if(list){ list.innerHTML='<div class="muted">Failed to load test bank.</div>'; }
  }
}
var rb=document.getElementById('refreshBankBtn'); if(rb){ rb.addEventListener('click',fetchBank); }
document.getElementById('reloadBankTop').addEventListener('click',fetchBank);
document.getElementById('openBankBtn').addEventListener('click', function(){ openBankModal(''); });
document.getElementById('saveBankBtn').addEventListener('click', async function(){
  const btn = this;
  const status = document.getElementById('saveBankStatus');
  function setStatus(text, ok){
    if(!status) return;
    status.style.display='inline';
    status.style.color = ok ? '#0f766e' : '#b91c1c';
    status.textContent = text;
    setTimeout(()=>{ status.style.display='none'; }, 3000);
  }
  try{
    btn.disabled = true;
    renderQuestions();
    const payload = {
      title: document.querySelector('input[name=\"title\"]').value,
      type: document.querySelector('select[name=\"type\"]').value,
      description: document.querySelector('textarea[name=\"description\"]').value,
      questions_json: document.getElementById('questions_json').value
    };
    const res = await fetch('{{ route('trainer.test-banks.store') }}', {
      method:'POST',
      headers:{
        'Accept':'application/json',
        'Content-Type':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}',
        'X-Requested-With':'XMLHttpRequest'
      },
      credentials:'same-origin',
      body: JSON.stringify(payload)
    });
    if(!res.ok){
      if(res.status===401 || res.status===419){
        setStatus('Session expired. Please sign in.', false);
      } else if(res.status===422){
        const j = await res.json().catch(()=>null);
        const msg = j && j.errors ? Object.values(j.errors).flat().join(' ') : 'Failed to save';
        setStatus(msg || 'Failed to save', false);
      } else {
        const txt = await res.text();
        setStatus('Failed to save', false);
        console.warn('Save to Test Bank failed', txt);
      }
    }else{
      setStatus('Saved to Test Bank', true);
      try{ await res.json(); }catch(e){}
      fetchBank();
    }
  }catch(err){
    console.error(err);
    setStatus('Error saving', false);
  }finally{
    btn.disabled = false;
  }
});
fetchBank();

function openBankModal(preselectId){
  var overlay=document.getElementById('bankModal');
  var grid=document.getElementById('tbGrid');
  var items = window.testBankItems||[];
  function render(filter){
    grid.innerHTML='';
    var f=(filter||'').toLowerCase();
    var filtered = items.filter(function(it){
      return !f || (String(it.title||'').toLowerCase().includes(f) || String(it.type||'').toLowerCase().includes(f) || String(it.description||'').toLowerCase().includes(f));
    });
    if(filtered.length===0){
      grid.innerHTML='<div class="muted" style="grid-column:1/-1;text-align:center;padding:20px">No items created yet.</div>';
      return;
    }
    filtered.forEach(function(it){
      var card=document.createElement('div');
      card.className='tb-card';
      card.innerHTML='<div style=\"font-weight:800;color:#0f3b8f\">'+(it.title||'Untitled')+'</div>'
        +'<div class=\"muted\">Type: '+(it.type||'-')+'</div>'
        +'<div class=\"muted\">'+(it.description||'')+'</div>'
        +'<div class=\"tb-actions\"><button class=\"btn btn-ghost\" data-act=\"use\">Use</button><button class=\"btn btn-ghost\" data-act=\"del\">Delete</button></div>';
      card.querySelector('[data-act=use]').addEventListener('click', function(){
        try{
          questions = Array.isArray(it.questions_json)? it.questions_json : JSON.parse(it.questions_json||'[]');
        }catch(e){ questions=[]; }
        renderQuestions();
        var typeSel=document.querySelector('select[name=\"type\"]'); if(typeSel){ typeSel.value = it.type; }
        var titleInp=document.querySelector('input[name=\"title\"]'); if(titleInp){ titleInp.value = it.title; }
        var descTa=document.querySelector('textarea[name=\"description\"]'); if(descTa){ descTa.value = it.description||''; }
        closeBankModal();
      });
      card.querySelector('[data-act=del]').addEventListener('click', function(){
        openDeleteConfirm(it);
      });
      grid.appendChild(card);
    });
  }
  render('');
  var search=document.getElementById('tbSearch'); if(search){ search.value=''; search.oninput=function(){ render(this.value); }; }
  document.getElementById('tbRefresh').onclick = function(){ fetchBank(); render(''); };
  document.getElementById('tbCancel').onclick = closeBankModal;
  document.getElementById('tbClose').onclick = closeBankModal;
  overlay.style.display='block';
  if(preselectId){
    var it=(items||[]).find(function(x){return String(x.id)===String(preselectId);});
    if(it){
      // highlight by filtering with its title
      if(search){ search.value = it.title||''; render(search.value); }
    }
  }
}
function closeBankModal(){
  var overlay=document.getElementById('bankModal'); overlay.style.display='none';
}
document.addEventListener('keydown', function(e){
  if(e.key==='Escape'){ closeBankModal(); }
});

var pendingDelete=null;
function openDeleteConfirm(item){
  pendingDelete = item;
  document.getElementById('tbDelText').textContent = 'Delete \"'+(item.title||'Untitled')+'\" from Test Bank? This cannot be undone.';
  document.getElementById('tbDelOverlay').style.display='block';
}
function closeDeleteConfirm(){
  document.getElementById('tbDelOverlay').style.display='none';
  pendingDelete = null;
}
document.getElementById('tbDelCancel').onclick = closeDeleteConfirm;
document.getElementById('tbDelConfirm').onclick = async function(){
  if(!pendingDelete) return;
  try{
    const res = await fetch(bankBase+'/'+pendingDelete.id, {
      method:'DELETE',
      headers:{
        'Accept':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}',
        'X-Requested-With':'XMLHttpRequest'
      },
      credentials:'same-origin'
    });
    if(res.ok){
      window.testBankItems = (window.testBankItems||[]).filter(function(x){ return String(x.id)!==String(pendingDelete.id); });
      closeDeleteConfirm();
      openBankModal('');
    }else{
      closeDeleteConfirm();
      alert('Failed to delete.');
    }
  }catch(err){
    closeDeleteConfirm();
    alert('Error deleting.');
  }
};
</script>
</body>
</html>
