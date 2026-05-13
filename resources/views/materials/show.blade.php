<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Material</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{--brand:#0f3b8f;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
.page{max-width:900px;margin:20px auto;padding:0 16px}
.card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
.muted{color:var(--muted)}
.chip{display:inline-flex;align-items:center;gap:8px;border:1px solid #cfe0ff;background:#e8f0ff;color:#0f3b8f;border-radius:999px;padding:6px 10px;font-weight:700}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
.btn-blue{background:var(--brand);color:#fff}
.link{color:var(--brand);text-decoration:none;font-weight:700}
</style>
</head>
<body>
<div class="page">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h1 style="margin:0">{{ $material->title }}</h1>
      <a class="link" href="{{ route('trainer.courses.enter', $course) }}"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    @php
      $ext = pathinfo($material->file_path ?? '', PATHINFO_EXTENSION);
      $type = strtoupper($ext ?: 'FILE');
    @endphp
    <div style="margin:8px 0">
      <span class="chip"><i class="fas fa-file"></i> {{ $type }}</span>
      @if(!empty($material->created_at))
        <span class="muted" style="margin-left:8px">{{ \Carbon\Carbon::parse($material->created_at)->format('M j, Y g:i A') }}</span>
      @endif
    </div>
    @if(!empty($material->description))
      <div style="margin:8px 0">{{ $material->description }}</div>
    @endif
    <div style="margin-top:12px">
      <a class="btn btn-blue" href="{{ asset('storage/'.$material->file_path) }}" target="_blank"><i class="fas fa-download"></i> Download</a>
    </div>
  </div>
</div>
</body>
</html>





