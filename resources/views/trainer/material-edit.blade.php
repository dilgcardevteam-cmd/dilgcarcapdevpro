<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Material</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:900px;margin:20px auto;padding:0 16px}
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
</body>
</html>


