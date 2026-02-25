<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assessment</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9;--warn:#0b7a33}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:1000px;margin:20px auto;padding:0 16px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{color:var(--brand);text-decoration:none;display:inline-flex;gap:8px;align-items:center;border:1px solid var(--border);padding:8px 12px;border-radius:999px;background:#fff}
.tabs{display:flex;gap:6px}
.tab{padding:10px 14px;border-radius:10px;border:1px solid transparent;background:#fff;cursor:pointer}
.tab.active{background:var(--brand);color:#fff;border-color:var(--brand)}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
.q{border:1px solid var(--border);border-radius:10px;padding:12px;margin-bottom:10px}
.muted{color:var(--muted)}
.table{width:100%;border-collapse:collapse}
.table th,.table td{border-bottom:1px solid var(--border);padding:10px;text-align:left}
.chip{display:inline-flex;align-items:center;gap:8px;border:1px solid #cfe0ff;background:#e8f0ff;color:#0f3b8f;border-radius:999px;padding:6px 10px;font-weight:700}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:8px 12px;font-weight:700;cursor:pointer}
.btn-ghost{background:#fff;border:1px solid var(--border)}
.btn-blue{background:var(--brand);color:#fff}
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);display:none;align-items:center;justify-content:center;z-index:2000}
.box{width:640px;max-width:calc(100% - 32px);background:#fff;border:1px solid var(--border);border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.2);overflow:hidden}
.box-hd{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid var(--border);font-weight:800}
.box-bd{padding:14px 16px;max-height:70vh;overflow:auto}
.input{width:100%;border:1px solid var(--border);border-radius:10px;padding:8px 10px}
.edit-row{display:flex;gap:10px;flex-wrap:wrap;margin:6px 0}
.inline-warn{position:fixed;right:16px;bottom:16px;background:#fff;border:2px solid var(--warn);box-shadow:0 8px 24px rgba(0,0,0,.15);border-radius:14px;padding:10px 12px;display:none;align-items:center;gap:10px;z-index:1500}
.error{color:#b91c1c;margin-top:6px}
</style>
</head>
<body>
<div class="page">
  <div class="topbar">
    <div>
      @if(session('success'))
        <div style="margin-bottom:6px;padding:8px 12px;border:1px solid #cce6d6;background:#e8fff0;border-radius:10px;color:#065f46;font-weight:700">{{ session('success') }}</div>
      @endif
      <div id="titleView" style="font-weight:800;font-size:1.2rem">{{ $assessment->title }}</div>
      <div id="metaView" class="muted">{{ ucfirst($assessment->type) }} @if($assessment->due_date) • Due: {{ \Carbon\Carbon::parse($assessment->due_date)->format('M j, g:i A') }} @endif</div>
    </div>
    <div style="display:flex;gap:8px;align-items:center">
      <a class="back" href="{{ route('trainer.courses.assessments.edit', ['course'=>$course, 'assessment'=>$assessment]) }}"><i class="fas fa-pen"></i> Edit Assessment</a>
      <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
  </div>
  <div class="tabs" role="tablist">
    <button id="tabQ" class="tab active" type="button">Questions</button>
    <button id="tabR" class="tab" type="button">Responses ({{ $responses->count() }})</button>
  </div>
  <div id="paneQ" class="card" role="tabpanel" aria-labelledby="tabQ" style="margin-top:10px">
    @if(empty($questions) || count($questions)===0)
      <div class="muted">No questions.</div>
    @else
      @foreach($questions as $i => $q)
        <div class="q">
          <div style="font-weight:700">{{ $i+1 }}. {{ $q['text'] ?? '' }}</div>
          <div class="muted" style="margin-top:6px">{{ strtoupper(str_replace('_',' ', $q['type'] ?? '')) }}</div>
          @if(($q['type'] ?? '') === 'multiple_choice')
            <div style="margin-top:6px">
              @foreach(($q['choices'] ?? []) as $k => $choice)
                <div>{{ chr(65+$k) }}. {{ $choice }} @if(isset($q['answer_index']) && $k === (int)$q['answer_index']) <span class="chip">Answer</span> @endif</div>
              @endforeach
            </div>
          @elseif(($q['type'] ?? '') === 'identification')
            <div style="margin-top:6px"><span class="chip">Answer</span> {{ $q['answer'] ?? '' }}</div>
          @elseif(($q['type'] ?? '') === 'true_false')
            <div style="margin-top:6px"><span class="chip">Answer</span> {{ !empty($q['answer']) ? 'True' : 'False' }}</div>
          @endif
        </div>
      @endforeach
    @endif
    <!-- Inline editor removed per request -->
  </div>
  <div id="paneR" class="card" role="tabpanel" aria-labelledby="tabR" style="display:none;margin-top:10px">
    @if($responses->isEmpty())
      <div class="muted">No responses yet.</div>
    @else
      <table class="table">
        <thead><tr><th>Learner</th><th>Score</th><th>Submitted</th><th></th></tr></thead>
        <tbody>
          @foreach($responses as $g)
            <tr>
              <td>{{ $g->user->name ?? 'User' }}</td>
              <td>{{ number_format((float)($g->score ?? 0), 2) }}%</td>
              <td>{{ \Carbon\Carbon::parse($g->updated_at)->format('M j, g:i A') }}</td>
              <td><button class="btn btn-ghost" data-answers='{{ $g->feedback ?? "{}" }}' data-user='{{ $g->user->name ?? "User" }}'>View</button></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
<div id="answersOverlay" class="overlay">
  <div class="box">
    <div class="box-hd"><span id="ansTitle">Answers</span><button id="ansClose" class="btn btn-ghost"><i class="fas fa-xmark"></i></button></div>
    <div class="box-bd" id="ansBody"></div>
  </div>
</div>
<!-- Confirm bar removed when using separate edit page -->
<script>
function showPane(id){
  var tabs=['Q','R'];
  tabs.forEach(function(t){
    var tb=document.getElementById('tab'+t), pn=document.getElementById('pane'+t);
    if(t===id){ tb.classList.add('active'); pn.style.display='block'; } else { tb.classList.remove('active'); pn.style.display='none'; }
  });
}
document.getElementById('tabQ').addEventListener('click', function(){ showPane('Q'); });
document.getElementById('tabR').addEventListener('click', function(){ showPane('R'); });
var overlay=document.getElementById('answersOverlay');
function closeAns(){ overlay.style.display='none'; }
document.getElementById('ansClose').addEventListener('click', function(e){ e.preventDefault(); closeAns(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeAns(); });
document.querySelectorAll('#paneR .btn.btn-ghost').forEach(function(btn){
  btn.addEventListener('click', function(){
    var body=document.getElementById('ansBody');
    var data = {};
    try{ data = JSON.parse(this.getAttribute('data-answers') || '{}'); }catch(e){ data={}; }
    var user = this.getAttribute('data-user') || 'User';
    var answers = (data.answers || {});
    var html = '';
    if(Array.isArray(answers)){
      for(var i=0;i<answers.length;i++){
        html += '<div class="q"><div><strong>Q'+(i+1)+'</strong></div><div>'+String(answers[i])+'</div></div>';
      }
    }else{
      var keys = Object.keys(answers);
      if(keys.length===0){ html = '<div class="muted">No answers captured.</div>'; }
      keys.forEach(function(k){
        html += '<div class="q"><div><strong>Q'+(parseInt(k,10)+1)+'</strong></div><div>'+String(answers[k])+'</div></div>';
      });
    }
    document.getElementById('ansTitle').textContent = user + ' • Answers';
    body.innerHTML = html;
    overlay.style.display = 'flex';
  });
});
// Inline editing removed
</script>
</body>
</html>



