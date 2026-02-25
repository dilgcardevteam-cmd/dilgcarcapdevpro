<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Material</title>
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
.input,.textarea{border:1px solid var(--border);border-radius:12px;padding:10px;background:#fff}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.muted{color:#64748b}
</style>
</head>
<body>
<div class="page">
  <div class="topbar">
    <h1 style="margin:0;font-size:1.4rem">Upload Material</h1>
    <a class="back" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back to Classroom</a>
  </div>
  <div class="card">
    <div class="muted" style="margin-bottom:8px">Upload course files here. This does not create an assessment.</div>
    <form action="{{ route('trainer.upload-material') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="course_id" value="{{ $course->id }}">
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
      <div style="display:flex;justify-content:flex-end;margin-top:12px">
        <button class="btn btn-blue" type="submit"><i class="fas fa-upload"></i> Upload Material</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>


