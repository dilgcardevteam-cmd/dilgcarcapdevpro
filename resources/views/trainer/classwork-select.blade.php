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
.page{max-width:800px;margin:20px auto;padding:0 16px}
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
<div class="page">
  <div class="topbar">
    <h1 style="margin:0;font-size:1.4rem">Create Classwork</h1>
    <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
  </div>
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
</body>
</html>


