<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - CAPDEV PRO</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333333;
        }

        .page-container {
            max-width: 1200px;
            margin: 24px auto;
            padding: 0 20px 40px;
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.5fr);
            gap: 30px;
            align-items: flex-start;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            background-color: #e9f5ff;
            color: #0056b3;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .badge i {
            margin-right: 6px;
        }

        .top-row { background:#fff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.06); padding:20px; margin-bottom:16px; }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 1.1rem;
            color: #001f54;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.95rem;
            color: #495057;
            line-height: 1.6;
        }

        .image-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .image-inner {
            width: 100%;
            position: relative;
            background-color: #f5f5f5;
            min-height: 220px;
            max-height: min(70vh, 560px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-actions.overlay { position:absolute; top:10px; right:10px; display:flex; gap:8px; z-index:5; }
        .image-actions.overlay .btn { box-shadow:0 4px 10px rgba(0,0,0,0.12); }

        .image-inner img {
            display: block;
            max-width: 100%;
            width: auto;
            height: auto;
            max-height: min(70vh, 560px);
            object-fit: contain;
        }

        .image-actions { display:flex; justify-content:flex-end; gap:10px; margin-bottom:10px; }
        .image-actions .btn { display:inline-flex; align-items:center; gap:8px; padding:9px 14px; border-radius:12px; font-size:0.9rem; border:1px solid #e5e7eb; cursor:pointer; text-decoration:none; background:#fff; color:#111827; transition:background .15s ease, box-shadow .15s ease; }
        .image-actions .btn:hover { background:#f8fafc; box-shadow:0 2px 6px rgba(0,0,0,0.06); }
        .btn-edit { background:#eef2ff; color:#1d4ed8; border-color:#dbeafe; }
        .btn-edit:hover { background:#e0e7ff; }
        .btn-archive { background:#fef2f2; color:#b91c1c; border-color:#fee2e2; }
        .btn-archive:hover { background:#fee2e2; }

        .video-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background-color: #00a859;
            color: white;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .video-link i {
            margin-right: 8px;
        }

        .accordion {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .acc-item {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            overflow: visible;
        }
        .acc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            cursor: pointer;
        }
        .acc-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #001f54;
            font-weight: 600;
        }
        .acc-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #00a859;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .acc-body {
            display: none;
            padding: 10px 16px 16px 54px;
        }
        .topic-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
            font-size: 0.95rem;
        }
        .topic-row a {
            color: #0d6efd;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .topic-actions {
            display: inline-flex;
            gap: 8px;
        }
        .topic-actions .btn-link {
            background: #eef2ff;
            color: #1d4ed8;
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .topic-actions .btn-link.download {
            background: #f1f5f9;
            color: #111827;
        }
        .btn-chip { background:#eef2ff; color:#1d4ed8; padding:6px 10px; border-radius:10px; border:1px solid #e5e7eb; display:inline-flex; align-items:center; gap:8px; font-weight:700; font-size:.9rem; cursor:pointer; }
        .btn-chip.icon-only { width:36px; padding:6px; justify-content:center; }

        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .image-inner {
                min-height: 180px;
                max-height: 52vh;
            }

            .image-inner img {
                max-height: 52vh;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="top-row">
            <h1 style="font-size: 1.6rem; color: #001f54; margin: 0 0 6px;">
                {{ $course->name }}
            </h1>
            @php
                $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
            @endphp
            <div style="font-size:0.9rem;color:#6b7280;">
                @if($creator)
                    Created by {{ $creator->name }} ({{ $creator->role }})
                @else
                    Created by —
                @endif
                <div>Created: {{ optional($course->created_at)->format('M d, Y') }}</div>
            </div>
            <div class="badge" style="margin-top:8px;">
                <i class="fas fa-layer-group"></i>
                <span>{{ $course->subject_area }}</span>
            </div>
        </div>

        <div class="layout">
            <div>
                <p style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.08em; color: #6c757d; margin: 0 0 10px;">
                    Course
                </p>
                

                <div class="card">
                    <h2>Course Description</h2>
                    <p style="white-space: pre-line;">
                        {{ $course->description }}
                    </p>
                </div>

                @if(!empty($course->modules))
                <div class="card">
                    <h2>Modules & Topics</h2>
                    <div class="accordion">
                        @foreach($course->modules as $mIndex => $module)
                            <div class="acc-item">
                                <div class="acc-header" onclick="toggleAccBody(this)">
                                    <div class="acc-title">
                                        <span class="acc-badge">{{ $mIndex + 1 }}</span>
                                        <span>Module {{ $mIndex + 1 }}: {{ $module['title'] ?? '' }}</span>
                                    </div>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="acc-body">
                                    @php $topics = $module['topics'] ?? []; @endphp
                                    @foreach($topics as $tIndex => $topic)
                                        <div class="topic-row">
                                            <span style="color:#6b7280; width: 48px;">{{ ($mIndex+1) . '.' . ($tIndex+1) }}</span>
                                            <span style="flex:1;">{{ $topic['title'] ?? '' }}</span>
                                            @if(!empty($topic['file_path']))
                                                @php
                                                    $rawUrl = asset('storage/' . $topic['file_path']);
                                                    $ext = strtolower(pathinfo($topic['file_path'], PATHINFO_EXTENSION));
                                                    $viewUrl = $rawUrl;
                                                    $officeExts = ['doc','docx','ppt','pptx','xls','xlsx'];
                                                    $inlineExts = ['pdf','png','jpg','jpeg','gif','webp','txt','svg'];
                                                    if (in_array($ext, $officeExts)) {
                                                        $viewUrl = 'https://view.officeapps.live.com/op/view.aspx?src=' . urlencode($rawUrl);
                                                    } elseif (!in_array($ext, $inlineExts)) {
                                                        $viewUrl = $rawUrl; // will open in new tab; browser may download if not renderable
                                                    }
                                                @endphp
                                                <span class="topic-actions">
                                                    <a class="btn-link" href="{{ $viewUrl }}" target="_blank" rel="noopener">View</a>
                                                    <a class="btn-link download" href="{{ $rawUrl }}" download>Download</a>
                                                </span>
                                            @endif
                                            @if(!empty($topic['fields']))
                                                <span class="topic-actions">
                                                    <button type="button" class="btn-chip icon-only" onclick="toggleMaterials(this)" aria-label="Toggle fields"><i class="fas fa-chevron-down"></i></button>
                                                </span>
                                            @elseif(!empty($topic['questions']))
                                                <span class="topic-actions">
                                                    <a class="btn-link" href="#" onclick="toggleMaterials(this); return false;">Questions</a>
                                                </span>
                                            @endif
                                        </div>
                                        @if(!empty($topic['fields']))
                                            <div class="card" style="display:none; margin:6px 0 14px 58px; padding:12px;">
                                                @foreach($topic['fields'] as $field)
                                                    @php $ft = $field['type'] ?? null; @endphp
                                                    @if($ft === 'text')
                                                        <div style="margin-bottom:10px;">{!! $field['html'] ?? '' !!}</div>
                                                    @elseif($ft === 'question')
                                                        @php $q = $field['question'] ?? []; $t = $q['type'] ?? 'short'; @endphp
                                                        <div style="margin-bottom:10px;">
                                                            <div style="font-weight:600;">{{ $q['title'] ?? '' }}</div>
                                                            @if(in_array($t, ['multiple_choice']))
                                                                @php $opts = $q['options'] ?? []; $ans = $q['answer_index'] ?? null; @endphp
                                                                <ul style="margin:6px 0 0 0;padding-left:16px;">
                                                                    @foreach($opts as $i => $opt)
                                                                        <li>
                                                                            @if($ans !== null && $ans === $i)
                                                                                <span style="color:#16a34a;font-weight:600;">✓</span>
                                                                            @endif
                                                                            {{ $opt }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <div style="color:#6b7280;margin-top:4px;">Free-text response</div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @elseif(!empty($topic['questions']))
                                            <div class="card" style="display:none; margin:6px 0 14px 58px; padding:12px;">
                                                <div style="margin-top:6px;">
                                                    <h3 style="font-size:1rem;color:#001f54;margin:6px 0;">Questions</h3>
                                                    <ol style="padding-left:18px;">
                                                        @foreach($topic['questions'] as $q)
                                                            <li style="margin-bottom:8px;">
                                                                <div style="font-weight:600;">{{ $q['title'] ?? '' }}</div>
                                                                @php $t = $q['type'] ?? 'multiple_choice'; @endphp
                                                                @if(in_array($t, ['multiple_choice']))
                                                                    @php $opts = $q['options'] ?? []; @endphp
                                                                    <ul style="margin:6px 0 0 0;padding-left:16px;">
                                                                        @foreach($opts as $opt)
                                                                            <li>{{ $opt }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <div style="color:#6b7280;margin-top:4px;">Free-text response</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <div>
                @if(!request()->boolean('readonly'))
                <div class="image-actions">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-edit">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Archive this course?');" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        @if(request()->boolean('embedded'))
                            <input type="hidden" name="embedded" value="1">
                        @endif
                        <button type="submit" class="btn btn-archive">
                            <i class="fas fa-box-archive"></i> Archive
                        </button>
                    </form>
                </div>
                @endif
                <div class="image-wrapper">
                    <div class="image-inner">
                        @php
                            $imageUrl = $course->image_url;
                            $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp;
                        @endphp
                        <img src="{{ $course->image_path ? ($imageUrl.'?v='.$ver) : $imageUrl }}" alt="{{ $course->name }}">
                    </div>
                </div>
                @if(!empty($course->video_path))
                <div class="card">
                    <h2>Course Video</h2>
                    <video controls style="width:100%;max-height:420px;border-radius:8px;outline:none;">
                        <source src="{{ asset('storage/' . $course->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function toggleAccBody(header){
            const body = header.nextElementSibling;
            const icon = header.querySelector('i.fas');
            if (!body) return;
            const open = body.style.display === 'block';
            body.style.display = open ? 'none' : 'block';
            if (icon) icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
        }
        function toggleMaterials(link){
            const container = link.closest('.topic-row').nextElementSibling;
            if(!container) return;
            const open = container.style.display === 'block';
            container.style.display = open ? 'none' : 'block';
        }
    </script>
</body>
</html>
