<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Assessment</title>
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
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px;box-shadow:0 2px 6px rgba(0,0,0,.04);margin-top:12px;transition:box-shadow .2s ease,border-color .2s ease}
.row{display:flex;gap:12px;flex-wrap:wrap}
.field{flex:1 1 260px;display:flex;flex-direction:column;gap:6px}
.label{font-weight:700;color:#1f2937}
.input,.select,.textarea{border:1px solid var(--border);border-radius:12px;padding:10px;background:#fff;transition:border-color .15s ease,box-shadow .2s ease}
.input:hover,.select:hover,.textarea:hover{border-color:#c7d2fe;box-shadow:0 0 0 4px rgba(15,59,143,.08)}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.btn-ghost{background:#fff;border:1px solid var(--border);color:#334155}
.q-list{display:grid;gap:12px;margin-top:12px}
.q-item{border:1px solid var(--border);border-radius:12px;padding:12px;background:#fff;transition:transform .15s ease, box-shadow .2s ease, border-color .2s ease}
.q-item:hover{transform:translateY(-2px);box-shadow:0 10px 18px rgba(0,0,0,.08);border-color:#c7d2fe}
.choice{display:flex;gap:8px;align-items:center;margin-top:6px}
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
<header class="header">
  <div class="header-left">
    <button class="header-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div id="header-section-title" class="header-section-title">Create Assessment</div>
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
    <h1 style="margin:0;font-size:1.4rem">Create Assessment</h1>
    <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
  </div>

  <div class="card">
    <form id="assessmentForm" action="{{ route('trainer.create-assessment') }}" method="POST">
      @csrf
      <input type="hidden" name="course_id" value="{{ $course->id }}">
      <input type="hidden" id="questions_json" name="questions_json">
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
      <div class="card" style="margin-top:12px">
        <div style="font-weight:800;color:#002C76;display:flex;align-items:center;justify-content:space-between">
          <span>Quiz Settings</span>
          <span style="color:#64748b;font-weight:600">Configure behavior</span>
        </div>
        <div class="row" style="margin-top:8px">
          <div class="field">
            <label class="label">Time Limit (minutes)</label>
            <input class="input" type="number" min="0" id="setTimeLimit" name="time_limit" placeholder="e.g., 30">
          </div>
          <div class="field">
            <label class="label">Passing Score (%)</label>
            <input class="input" type="number" min="0" max="100" id="setPassing" name="passing_score" placeholder="e.g., 70">
          </div>
          <div class="field">
            <label class="label">Attempt Limit</label>
            <input class="input" type="number" min="0" id="setAttempts" name="attempt_limit" placeholder="0 = unlimited">
          </div>
        </div>
        <div class="row">
          <label class="field" style="flex:0 0 auto;display:flex;align-items:center;gap:8px">
            <input type="checkbox" id="setShuffleQ" name="shuffle_questions"> <span class="label">Shuffle Questions</span>
          </label>
          <label class="field" style="flex:0 0 auto;display:flex;align-items:center;gap:8px">
            <input type="checkbox" id="setShuffleC" name="shuffle_choices"> <span class="label">Shuffle Choices</span>
          </label>
        </div>
      </div>
      <div class="q-list" id="questionsList"></div>
      <div id="qNav" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin:10px 0"></div>
      <div id="qb-form-inputs" style="display:none"></div>
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
          <div class="choice"><input type="text" class="input" placeholder="Choice A"><input type="radio" name="mcCorrect" value="0"><span>Correct</span><button type="button" class="btn btn-ghost" data-act="remove-choice" style="padding:6px 8px">X</button></div>
          <div class="choice"><input type="text" class="input" placeholder="Choice B"><input type="radio" name="mcCorrect" value="1"><span>Correct</span><button type="button" class="btn btn-ghost" data-act="remove-choice" style="padding:6px 8px">X</button></div>
          <div class="choice"><input type="text" class="input" placeholder="Choice C"><input type="radio" name="mcCorrect" value="2"><span>Correct</span><button type="button" class="btn btn-ghost" data-act="remove-choice" style="padding:6px 8px">X</button></div>
          <div class="choice"><input type="text" class="input" placeholder="Choice D"><input type="radio" name="mcCorrect" value="3"><span>Correct</span><button type="button" class="btn btn-ghost" data-act="remove-choice" style="padding:6px 8px">X</button></div>
          <div style="margin-top:8px"><button type="button" class="btn btn-ghost" id="btnAddChoice"><i class="fas fa-plus"></i> Add Choice</button></div>
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
          <button type="button" class="btn btn-ghost" id="previewBtn"><i class="fas fa-eye"></i> Preview Assessment</button>
        </div>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;margin-top:12px">
        <span id="saveBankStatus" class="muted" style="display:none"></span>
        <button id="saveBankBtn" class="btn btn-ghost" type="button"><i class="fas fa-save"></i> Save to Test Bank</button>
        <button id="createSubmit" class="btn btn-blue" type="submit"><i class="fas fa-check"></i> Create Assessment</button>
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
var qType=document.getElementById('qType');
function syncQBoxes(){
  var type=qType.value;
  document.getElementById('choicesBox').style.display= type==='multiple_choice'?'block':'none';
  document.getElementById('tfBox').style.display= type==='true_false'?'block':'none';
  document.getElementById('idBox').style.display= type==='identification'?'block':'none';
  document.getElementById('essayBox').style.display= type==='essay'?'block':'none';
}
qType.addEventListener('change',syncQBoxes);syncQBoxes();
var questions=[]; var editingIndex=-1; var activeIndex=-1;
function ensureInputsBox(){
  var box=document.getElementById('qb-form-inputs');
  if(!box){ box=document.createElement('div'); box.id='qb-form-inputs'; box.style.display='none'; document.getElementById('assessmentForm').appendChild(box); }
  return box;
}
function buildGroup(idx, q){
  var div=document.createElement('div');
  div.className='qb-input-group';
  div.dataset.index=String(idx);
  var t=(q && q.type)||'multiple_choice';
  var html='';
  html+='<input type="hidden" name="questions['+idx+'][type]" value="'+t+'">';
  html+='<input type="text" name="questions['+idx+'][question]" value="'+((q&&q.text)||'')+'">';
  if(t==='multiple_choice'){
    var opts=(q&&q.choices)||['','','',''];
    html+='<input type="text" name="questions['+idx+'][options][]" value="'+(opts[0]||'')+'">';
    html+='<input type="text" name="questions['+idx+'][options][]" value="'+(opts[1]||'')+'">';
    html+='<input type="text" name="questions['+idx+'][options][]" value="'+(opts[2]||'')+'">';
    html+='<input type="text" name="questions['+idx+'][options][]" value="'+(opts[3]||'')+'">';
    var ca = (q && typeof q.answer_index==='number') ? String(q.answer_index) : '';
    html+='<input type="hidden" name="questions['+idx+'][correct_answer]" value="'+ca+'">';
  }else if(t==='identification'){
    html+='<input type="text" name="questions['+idx+'][answer]" value="'+((q&&q.answer)||'')+'">';
  }else if(t==='true_false'){
    var av = (q && q.answer!=null) ? (q.answer===true?'true':'false') : '';
    html+='<input type="text" name="questions['+idx+'][answer]" value="'+av+'">';
  }
  div.innerHTML=html;
  return div;
}
function syncGroupsFromQuestions(){
  var box=ensureInputsBox();
  box.innerHTML='';
  for(var i=0;i<questions.length;i++){
    box.appendChild(buildGroup(i, questions[i]));
  }
}
function renderNav(){
  var nav=document.getElementById('qNav'); if(!nav) return;
  nav.innerHTML='';
  var prev=document.createElement('button'); prev.className='btn btn-ghost'; prev.textContent='Previous';
  prev.onclick=function(){ setActive(Math.max(0, activeIndex-1)); };
  nav.appendChild(prev);
  for(var i=0;i<=questions.length;i++){
    (function(i0){
      var b=document.createElement('button'); b.className='btn btn-ghost'; b.textContent=(i0+1);
      b.style.fontWeight = (i0===activeIndex? '800':'700');
      b.onclick=function(){
        if(i0<questions.length){ editQuestion(i0); activeIndex=i0; renderNav(); }
        else { cancelEdit(); activeIndex=i0; renderNav(); var t=document.getElementById('qText'); if(t){ t.focus(); } }
      };
      nav.appendChild(b);
    })(i);
  }
  var next=document.createElement('button'); next.className='btn btn-ghost'; next.textContent='Next';
  next.onclick=function(){ setActive(Math.min(questions.length, activeIndex+1)); };
  nav.appendChild(next);
}
function setActive(i){
  if(i<questions.length){ editQuestion(i); }
  else { cancelEdit(); }
  activeIndex=i;
  renderNav();
}
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
    div.innerHTML='<div class=\"qi-title\" style=\"font-weight:700;cursor:pointer\">'+(i+1)+'. '+q.text+'</div>'
      +'<div class=\"muted\" style=\"margin-top:6px\">'+meta+(extra? ' • '+extra:'')+'</div>'
      +'<div style=\"margin-top:8px;display:flex;gap:8px\">'
      +'<button data-act=\"edit\" class=\"btn btn-ghost\">Edit</button>'
      +'<button data-act=\"remove\" class=\"btn btn-ghost\">Remove</button>'
      +'</div>';
    div.querySelector('.qi-title').addEventListener('click',function(e){e.preventDefault(); editQuestion(i);});
    div.querySelector('[data-act=\"edit\"]').addEventListener('click',function(e){e.preventDefault(); e.stopPropagation(); editQuestion(i);});
    div.querySelector('[data-act=\"remove\"]').addEventListener('click',function(e){e.preventDefault(); e.stopPropagation(); questions.splice(i,1); renderQuestions(); syncGroupsFromQuestions();});
    list.appendChild(div);
  });
  document.getElementById('questions_json').value=JSON.stringify(questions);
  var builder=document.getElementById('builderCard');
  if(builder){ builder.scrollIntoView({behavior:'smooth',block:'start'}); }
  var q=document.getElementById('qText'); if(q){ q.focus(); }
  syncGroupsFromQuestions();
  renderNav();
}
function cancelEdit(){
  editingIndex=-1;
  var btn=document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML='<i class=\"fas fa-plus\"></i> Add Question'; }
  var c=document.getElementById('cancelEditBtn'); if(c){ c.style.display='none'; }
  document.getElementById('qText').value='';
  document.querySelectorAll('#choicesBox .choice input[type=text]').forEach(function(i){i.value=''});
  document.querySelectorAll('#choicesBox input[type=radio]').forEach(function(r){r.checked=false});
  document.getElementById('idAnswer').value='';
  document.getElementById('tfAnswer').value='true';
  renderNav();
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
  var btn = document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML = '<i class=\"fas fa-save\"></i> Update Question'; }
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
  var btn=document.getElementById('addQuestionBtn'); if(btn){ btn.innerHTML='<i class=\"fas fa-plus\"></i> Add Question'; }
  var c=document.getElementById('cancelEditBtn'); if(c){ c.style.display='none'; }
  activeIndex = questions.length; renderNav();
});
document.getElementById('assessmentForm').addEventListener('submit',function(e){
  document.getElementById('questions_json').value=JSON.stringify(questions);
  try{
    if(!Array.isArray(questions) || questions.length===0){
      e.preventDefault();
      alert('Please add at least one question before creating the assessment.');
      return false;
    }
  }catch(err){}
});
document.addEventListener('click', function(e){
  if(e.target && e.target.id==='btnAddChoice'){
    var rows=document.querySelectorAll('#choicesBox .choice');
    var idx=rows.length;
    var row=document.createElement('div'); row.className='choice';
    row.innerHTML='<input type="text" class="input" placeholder="Choice '+String.fromCharCode(65+idx)+'"><input type="radio" name="mcCorrect" value="'+idx+'"><span>Correct</span><button type="button" class="btn btn-ghost" data-act="remove-choice" style="padding:6px 8px">X</button>';
    var box=document.getElementById('choicesBox');
    box.insertBefore(row, box.lastElementChild);
  }
  if(e.target && e.target.getAttribute('data-act')==='remove-choice'){
    var row=e.target.closest('.choice'); if(!row) return;
    var box=document.getElementById('choicesBox');
    row.remove();
    var radios=box.querySelectorAll('input[type=radio]');
    radios.forEach(function(r,i){ r.value=i; });
  }
});
var obsTarget=document.getElementById('questionsList');
if(obsTarget){
  new MutationObserver(function(){ renderNav(); }).observe(obsTarget, {childList:true});
}
document.getElementById('previewBtn').addEventListener('click', function(){
  var overlay=document.createElement('div');
  overlay.style.cssText='position:fixed;inset:0;background:rgba(2,6,23,.7);z-index:4000;display:flex;align-items:center;justify-content:center';
  var box=document.createElement('div');
  box.style.cssText='background:#fff;border-radius:14px;border:1px solid #e5e7eb;max-width:900px;width:92vw;max-height:82vh;overflow:auto;padding:16px';
  var html='<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><div style="font-weight:800;color:#0f3b8f">Preview Assessment</div><button class="btn btn-ghost" id="pvClose">Close</button></div>';
  html+='<div style="display:grid;gap:12px">';
  questions.forEach(function(q,i){
    html+='<div class="card"><div style="font-weight:800;color:#0f3b8f">'+(i+1)+'. '+(q.text||'')+'</div>';
    if(q.type==='multiple_choice'){ (q.choices||[]).forEach(function(c){ html+='<div style="display:flex;align-items:center;gap:8px;margin-top:6px"><input type="radio"> <span>'+(c||'')+'</span></div>'; }); }
    else if(q.type==='true_false'){ html+='<div style="display:flex;gap:12px;margin-top:6px"><label><input type="radio"> True</label><label><input type="radio"> False</label></div>'; }
    else if(q.type==='identification'){ html+='<input type="text" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;margin-top:6px">'; }
    else { html+='<textarea rows="3" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;margin-top:6px"></textarea>'; }
    html+='</div>';
  });
  html+='</div>';
  box.innerHTML=html;
  overlay.appendChild(box);
  document.body.appendChild(overlay);
  box.querySelector('#pvClose').onclick=function(){ overlay.remove(); };
});
async function fetchBank(){
  const list=document.getElementById('bankList');
  if(list){ list.innerHTML='<div class=\"muted\">Loading…</div>'; }
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
  }catch(e){}
}
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
      grid.innerHTML='<div class=\"muted\" style=\"grid-column:1/-1;text-align:center;padding:20px\">No items created yet.</div>';
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
