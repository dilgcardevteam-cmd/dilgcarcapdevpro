<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Assessment</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:1000px;margin:20px auto;padding:0 16px}
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
                    <input class="input" type="text" name="title" required value="{{ $assessment->title }}">
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
                    <input class="input" type="datetime-local" name="due_date" value="{{ $assessment->due_date ? \Carbon\Carbon::parse($assessment->due_date)->format('Y-m-d\TH:i') : '' }}">
                </div>
            </div>
            <div class="field" style="margin-top:8px">
                <label class="label">Description</label>
                <textarea class="textarea" name="description" rows="3">{{ $assessment->description }}</textarea>
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


