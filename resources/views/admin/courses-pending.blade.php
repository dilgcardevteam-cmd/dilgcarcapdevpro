<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Courses - CAPDEV PRO</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'DM Sans', sans-serif; margin:0; background:#f4f6f9; color:#0f172a; }
        .header { background:#fff; height:80px; display:flex; align-items:center; justify-content:space-between; padding:0 24px; box-shadow:0 2px 4px rgba(0,0,0,0.05); position:sticky; top:0; z-index:100; }
        .header-title img { height:40px; display:block; }
        .back-link { text-decoration:none; color:#0d6efd; }
        .page { max-width:1100px; margin: 32px auto; padding: 0 20px 40px; }
        h1 { margin:0 0 16px; color:#002C76; letter-spacing:-0.02em; }
        .toolbar { display:flex; gap:10px; margin-bottom:16px; }
        .btn { border:none; padding:10px 16px; border-radius:10px; cursor:pointer; color:#fff; }
        .btn-back { background:#6b7280; text-decoration:none; display:inline-flex; align-items:center; }
        .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap:16px; }
        .card { background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.05); overflow:hidden; }
        .card img { width:100%; height:150px; object-fit:cover; }
        .card-body { padding:14px; }
        .title { margin:0 0 6px; color:#002C76; font-size:1.05rem; }
        .desc { color:#6b7280; font-size:.9rem; margin:0 0 10px; }
        .actions { display:flex; gap:8px; }
        .btn-view { background:#17a2b8; }
        .btn-approve { background:#28a745; }
        .empty { color:#6b7280; font-style:italic; }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-title">
            <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
        </div>
        <div>
            <a href="{{ route('dashboard', ['tab' => 'course-management']) }}" class="back-link">Back to Course Management</a>
        </div>
    </header>
    <div class="page">
        <h1>Pending Courses</h1>
        @if($pendingCourses->isEmpty())
            <p class="empty">There are no submitted courses.</p>
        @else
            <div class="grid">
                @foreach($pendingCourses as $course)
                    @php
                        $submitter = $course->users->first(function ($u) {
                            return in_array(strtolower((string) $u->role), [
                                'coach',
                                'trainer',
                                'central_office_coach',
                                'regional_office_coach',
                                'provincial_office_coach',
                            ], true);
                        });
                    @endphp
                    <div class="card">
                        <img src="{{ $course->image_url }}" alt="{{ $course->name }}">
                        <div class="card-body">
                            <h3 class="title">{{ $course->name }}</h3>
                            <p class="desc">{{ Str::limit($course->description, 100) }}</p>
                            @if($submitter)
                                <p class="desc" style="margin-top:6px;"><i class="fas fa-user"></i> Submitted by {{ $submitter->name }}</p>
                            @endif
                            <div class="actions">
                                <a class="btn btn-view" href="{{ route('admin.courses.show', $course) }}">View</a>
                                <form action="{{ route('courses.restore', $course->id) }}" method="POST" onsubmit="return confirm('Approve this course? It will be moved to Active.')">
                                    @csrf
                                    <button type="submit" class="btn btn-approve">Approve</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
