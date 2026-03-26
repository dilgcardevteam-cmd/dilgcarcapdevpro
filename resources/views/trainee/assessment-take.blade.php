<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Take Assessment</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:900px;margin:20px auto;padding:0 16px}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
.title{font-weight:800;margin:0 0 8px 0}
.muted{color:var(--muted)}
.q{border:1px solid var(--border);border-radius:12px;padding:12px;margin-bottom:10px;background:#fff}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.input{border:1px solid var(--border);border-radius:10px;padding:10px;width:100%}
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);display:none;align-items:center;justify-content:center;z-index:2000}
.box{width:520px;max-width:calc(100% - 32px);background:#fff;border:1px solid var(--border);border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.2);overflow:hidden}
.box-hd{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid var(--border);font-weight:800}
.box-bd{padding:14px 16px}
.box-ft{padding:12px 16px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end}
</style>
</head>
<body>
<div class="page">
  <div class="card">
    <div class="title">{{ $assessment->title }} <span class="muted">• {{ ucfirst($assessment->type) }}</span></div>
    @if(session('success'))<div class="muted" style="margin-bottom:8px">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="muted" style="margin-bottom:8px;color:#b91c1c;font-weight:700">{{ session('error') }}</div>@endif
    @php $hasQuestions = is_array($questions) && count($questions) > 0; @endphp
    @unless($hasQuestions)
      <div class="muted" style="margin:8px 0">No questions are available for this assessment. Please inform your coach.</div>
    @endunless
    <form id="takeForm" method="POST" action="{{ route('trainee.assessments.submit', $assessment) }}">
      @csrf
      @foreach(($questions ?? []) as $i => $q)
        <div class="q">
          <div style="font-weight:700">{{ $i+1 }}. {{ $q['text'] ?? '' }}</div>
          @if(($q['type'] ?? '') === 'multiple_choice')
            @foreach(($q['choices'] ?? []) as $k => $choice)
              <label style="display:flex;gap:8px;align-items:center;margin-top:6px">
                <input type="radio" name="answers[{{ $i }}]" value="{{ $k }}"> <span>{{ $choice }}</span>
              </label>
            @endforeach
          @elseif(($q['type'] ?? '') === 'identification')
            <input class="input" type="text" name="answers[{{ $i }}]" placeholder="Your answer">
          @elseif(($q['type'] ?? '') === 'true_false')
            <label style="display:flex;gap:8px;align-items:center;margin-top:6px"><input type="radio" name="answers[{{ $i }}]" value="true"> True</label>
            <label style="display:flex;gap:8px;align-items:center;margin-top:6px"><input type="radio" name="answers[{{ $i }}]" value="false"> False</label>
          @else
            <textarea class="input" name="answers[{{ $i }}]" rows="4" placeholder="Write your response"></textarea>
          @endif
        </div>
      @endforeach
      <div style="display:flex;justify-content:flex-end">
        <button id="openConfirm" type="button" class="btn btn-blue" @if(!$hasQuestions) disabled @endif><i class="fas fa-paper-plane"></i> Submit</button>
      </div>
    </form>
  </div>
</div>
<div id="confirmOverlay" class="overlay">
  <div class="box" role="dialog" aria-modal="true">
    <div class="box-hd">Submit Assessment</div>
    <div class="box-bd">
      <div id="confirmText">Are you sure you want to submit your answers now?</div>
    </div>
    <div class="box-ft">
      <button id="cancelConfirm" class="btn">Cancel</button>
      <button id="doSubmit" class="btn btn-blue">Submit</button>
    </div>
  </div>
  </div>
<script>
var btn=document.getElementById('openConfirm');
var ov=document.getElementById('confirmOverlay');
var cancelBtn=document.getElementById('cancelConfirm');
var doBtn=document.getElementById('doSubmit');
var form=document.getElementById('takeForm');
function openConfirm(){
  if(!ov) return;
  ov.style.display='flex';
}
function closeConfirm(){
  if(!ov) return;
  ov.style.display='none';
}
if(btn){ btn.addEventListener('click', function(){
  openConfirm();
}); }
if(cancelBtn){ cancelBtn.addEventListener('click', function(e){ e.preventDefault(); closeConfirm(); }); }
if(doBtn){ doBtn.addEventListener('click', function(e){
  e.preventDefault();
  doBtn.disabled=true;
  if(form){ form.submit(); }
}); }
document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ closeConfirm(); } });
</script>
</body>
</html>

