<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - CAPDEV PRO</title>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
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

        .course-shell{background:#fff;border:1px solid #e5e7eb;border-radius:18px;box-shadow:0 14px 32px rgba(2,6,23,.08);overflow:hidden}
        .course-head{padding:18px 20px;border-bottom:1px solid #eef2f7;background:linear-gradient(180deg,#ffffff 0%,#fbfdff 100%)}
        .course-head-top{display:flex;align-items:flex-start;justify-content:space-between;gap:14px}
        .course-ident{display:flex;align-items:center;gap:14px;min-width:0}
        .course-icon{width:56px;height:56px;border-radius:16px;background:#eef2ff;color:#1d4ed8;display:flex;align-items:center;justify-content:center;font-size:1.4rem;border:1px solid #e5e7eb;flex:0 0 56px}
        .course-title{margin:0;font-size:1.4rem;font-weight:900;color:#0f172a;letter-spacing:-.02em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:760px}
        .course-meta{margin-top:6px;color:#64748b;font-weight:700;font-size:.9rem;display:flex;flex-wrap:wrap;gap:10px;align-items:center}
        .chip{display:inline-flex;align-items:center;gap:8px;padding:6px 12px;border-radius:999px;font-weight:800;font-size:.84rem;border:1px solid transparent}
        .chip.blue{background:#eff6ff;color:#1d4ed8;border-color:#dbeafe}
        .chip.green{background:#ecfdf5;color:#065f46;border-color:#bbf7d0}
        .chip.orange{background:#fff7ed;color:#9a3412;border-color:#fed7aa}
        .head-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap;justify-content:flex-end}
        .btn{display:inline-flex;align-items:center;gap:10px;border:1px solid #e2e8f0;background:#fff;color:#0f172a;border-radius:12px;padding:10px 14px;font-weight:900;cursor:pointer;text-decoration:none}
        .btn.primary{background:#0B2C74;border-color:#0B2C74;color:#fff}
        .btn.ghost{background:#f8fafc;color:#0f172a}
        .btn.danger{background:#ef4444;border-color:#ef4444;color:#fff}
        .tabs{display:flex;gap:18px;border-top:1px solid #eef2f7;margin-top:14px;padding-top:12px;overflow:auto}
        .tab{border:none;background:transparent;color:#64748b;font-weight:900;padding:10px 6px;cursor:pointer;position:relative;white-space:nowrap}
        .tab.active{color:#1d4ed8}
        .tab.active::after{content:"";position:absolute;left:0;right:0;bottom:-12px;height:3px;border-radius:999px;background:#1d4ed8}
        .course-body{padding:18px 20px}
        .layout{display:grid;grid-template-columns:minmax(0, 2fr) minmax(0, 1.2fr);gap:18px;align-items:start}
        .panel{background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 10px 24px rgba(2,6,23,.06);overflow:hidden}
        .panel-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;border-bottom:1px solid #eef2f7;background:#fff}
        .panel-title{margin:0;font-size:1rem;font-weight:900;color:#0f172a}
        .panel-body{padding:14px 16px}
        .text{white-space:pre-line;color:#334155;line-height:1.7;font-weight:600}
        .tiny-btn{border:1px solid #e2e8f0;background:#fff;border-radius:10px;padding:8px 10px;font-weight:900;cursor:pointer;color:#0f172a;display:inline-flex;align-items:center;gap:8px;text-decoration:none}
        .tiny-btn.blue{background:#eff6ff;border-color:#dbeafe;color:#1d4ed8}
        .preview-wrap{border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;background:#f8fafc}
        .preview-img{width:100%;height:270px;object-fit:cover;display:block}
        .kv{display:grid;gap:10px}
        .kv-row{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid #f1f5f9}
        .kv-row:last-child{border-bottom:none}
        .kv-label{display:flex;align-items:center;gap:10px;color:#475569;font-weight:900;font-size:.86rem}
        .kv-label i{color:#94a3b8}
        .kv-value{color:#0f172a;font-weight:800;font-size:.9rem;text-align:right}
        .stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-top:14px}
        .stat{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:12px 14px;box-shadow:0 10px 24px rgba(2,6,23,.06);display:flex;align-items:center;gap:12px}
        .stat-ico{width:44px;height:44px;border-radius:14px;background:#f1f5f9;color:#0f172a;display:flex;align-items:center;justify-content:center;flex:0 0 44px}
        .stat-ico.blue{background:#eff6ff;color:#1d4ed8}
        .stat-ico.green{background:#ecfdf5;color:#065f46}
        .stat-ico.orange{background:#fff7ed;color:#9a3412}
        .stat-ico.purple{background:#f5f3ff;color:#6d28d9}
        .stat-label{color:#64748b;font-weight:900;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em}
        .stat-value{margin-top:4px;color:#0f172a;font-weight:900}
        .accordion{display:flex;flex-direction:column;gap:10px}
        .acc-item{border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;background:#fff}
        .acc-header{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 14px;cursor:pointer;background:#fff}
        .acc-left{display:flex;align-items:center;gap:12px;min-width:0}
        .acc-badge{width:28px;height:28px;border-radius:999px;background:#1d4ed8;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:.85rem;flex:0 0 28px}
        .acc-name{font-weight:900;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .acc-right{display:flex;align-items:center;gap:10px;flex:0 0 auto}
        .pill{display:inline-flex;align-items:center;justify-content:center;min-width:52px;height:26px;padding:0 10px;border-radius:999px;background:#f1f5f9;color:#334155;font-weight:900;font-size:.78rem;border:1px solid #e2e8f0}
        .acc-body{display:none;padding:0 14px 12px 54px}
        .topic-row{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #f1f5f9}
        .topic-row:last-child{border-bottom:none}
        .topic-num{width:44px;color:#64748b;font-weight:900;font-size:.85rem}
        .topic-title{flex:1;color:#0f172a;font-weight:800;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .topic-actions{display:flex;gap:8px;align-items:center;justify-content:flex-end;flex:0 0 auto}
        .icon-btn{width:34px;height:34px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#0f172a;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;text-decoration:none}
        .icon-btn:hover{background:#f8fafc}
        .topic-subpanel{display:none;margin:10px 0 0 58px;border:1px solid #e5e7eb;border-radius:12px;background:#fff;padding:12px}

        @media (max-width: 900px) {
            .layout{grid-template-columns:1fr}
            .course-title{max-width:100%}
            .stats{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
    </style>
</head>
<body>
    <div class="page-container">
        @php
            $creator = $course->users()->orderBy('course_user.created_at', 'asc')->first();
            $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
            $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
            $createdBy = $creator ? ($creator->name . ' (' . ($creator->role ?? '') . ')') : '—';
            $createdOn = optional($course->created_at)->format('M d, Y') ?: '—';
            $updatedOn = optional($course->updated_at)->format('M d, Y') ?: '—';
            $subjectText = method_exists($course, 'subjectAreaText') ? $course->subjectAreaText() : ($course->subject_area ?? '—');
            $isPublished = (bool) ($course->is_published ?? false);
            $statusText = $isPublished ? 'Published' : 'Unpublished';
            $enrollStart = optional($course->enrollment_start_date)->format('M d, Y');
            $enrollEnd = optional($course->enrollment_end_date)->format('M d, Y');
            $enrollText = ($enrollStart || $enrollEnd) ? (($enrollStart ?: '—') . ' — ' . ($enrollEnd ?: '—')) : 'Not available';
            $modulesArr = is_array($course->modules) ? $course->modules : [];
            $modulesCount = count($modulesArr);
            $participantsCount = $course->users()
                ->whereIn('role', $participantRoles)
                ->wherePivot('status', 'active')
                ->count();
            $previewUrl = route('trainee.courses.show', $course);
            $imageUrl = $course->image_url;
            $ver = \Carbon\Carbon::parse($course->updated_at ?? now())->timestamp;
            $previewImg = $course->image_path ? ($imageUrl.'?v='.$ver) : $imageUrl;
        @endphp

        <div class="course-shell">
            <div class="course-head">
                <div class="course-head-top">
                    <div class="course-ident">
                        <div class="course-icon"><i class="fas fa-book"></i></div>
                        <div style="min-width:0">
                            <h1 class="course-title">{{ $course->name }}</h1>
                            <div class="course-meta">
                                <span>Created by {{ $createdBy }}</span>
                                <span>•</span>
                                <span>Created on {{ $createdOn }}</span>
                            </div>
                            <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                                <span class="chip blue"><i class="fas fa-layer-group"></i> {{ $subjectText }}</span>
                                <span class="chip {{ $isPublished ? 'green' : 'orange' }}"><i class="fas {{ $isPublished ? 'fa-circle-check' : 'fa-eye-slash' }}"></i> {{ $statusText }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="head-actions">
                        <a class="btn ghost" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Back</a>
                        <a class="btn primary" href="{{ $previewUrl }}" target="_blank" rel="noopener"><i class="fas fa-arrow-up-right-from-square"></i> Preview Course</a>
                    </div>
                </div>
                <div class="tabs" role="tablist" aria-label="Course Tabs">
                    <button type="button" class="tab active" data-tab="overview" onclick="switchTab('overview', this)">Overview</button>
                    <button type="button" class="tab" data-tab="modules" onclick="switchTab('modules', this)">Modules &amp; Topics</button>
                    <button type="button" class="tab" data-tab="enrollment" onclick="switchTab('enrollment', this)">Enrollment</button>
                    <button type="button" class="tab" data-tab="reports" onclick="switchTab('reports', this)">Reports</button>
                    <button type="button" class="tab" data-tab="settings" onclick="switchTab('settings', this)">Settings</button>
                </div>
            </div>

            <div class="course-body">
                <div class="layout">
                    <div>
                        <div id="tab-overview" class="tab-pane">
                            <div class="panel" style="margin-bottom:14px">
                                <div class="panel-head">
                                    <h2 class="panel-title">Course Description</h2>
                                    @if(!request()->boolean('readonly'))
                                        <a class="tiny-btn blue" href="{{ route('admin.courses.edit', $course) }}"><i class="fas fa-pen"></i></a>
                                    @endif
                                </div>
                                <div class="panel-body">
                                    <div class="text">{{ $course->description ?: '—' }}</div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-head">
                                    <h2 class="panel-title">Modules &amp; Topics</h2>
                                    <button type="button" class="tiny-btn" id="expandAllBtn" onclick="toggleAllModules()">Expand All</button>
                                </div>
                                <div class="panel-body">
                                    @if(!empty($modulesArr))
                                        <div class="accordion" id="modulesAccordion">
                                            @foreach($modulesArr as $mIndex => $module)
                                                @php $topics = (isset($module['topics']) && is_array($module['topics'])) ? $module['topics'] : []; @endphp
                                                <div class="acc-item">
                                                    <div class="acc-header" onclick="toggleAccBody(this)">
                                                        <div class="acc-left">
                                                            <div class="acc-badge">{{ $mIndex + 1 }}</div>
                                                            <div class="acc-name">Module {{ $mIndex + 1 }}: {{ $module['title'] ?? '' }}</div>
                                                        </div>
                                                        <div class="acc-right">
                                                            <span class="pill">{{ count($topics) }} {{ count($topics) === 1 ? 'Topic' : 'Topics' }}</span>
                                                            <i class="fas fa-chevron-down" style="color:#94a3b8"></i>
                                                        </div>
                                                    </div>
                                                    <div class="acc-body">
                                                        @forelse($topics as $tIndex => $topic)
                                                            <div class="topic-row">
                                                                <div class="topic-num">{{ ($mIndex+1) . '.' . ($tIndex+1) }}</div>
                                                                <div class="topic-title">{{ $topic['title'] ?? '' }}</div>
                                                                <div class="topic-actions">
                                                                    <span class="icon-btn" style="background:#ecfdf5;border-color:#bbf7d0;color:#065f46;cursor:default" title="Included"><i class="fas fa-check"></i></span>
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
                                                                                $viewUrl = $rawUrl;
                                                                            }
                                                                        @endphp
                                                                        <a class="icon-btn" href="{{ $viewUrl }}" target="_blank" rel="noopener" title="View file"><i class="fas fa-arrow-up-right-from-square"></i></a>
                                                                        <a class="icon-btn" href="{{ $rawUrl }}" download title="Download file"><i class="fas fa-download"></i></a>
                                                                    @endif
                                                                    @if(!empty($topic['fields']) || !empty($topic['questions']))
                                                                        <button type="button" class="icon-btn" onclick="toggleTopicPanel(this); event.stopPropagation();" title="View details"><i class="fas fa-ellipsis-vertical"></i></button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if(!empty($topic['fields']))
                                                                <div class="topic-subpanel">
                                                                    @foreach($topic['fields'] as $field)
                                                                        @php $ft = $field['type'] ?? null; @endphp
                                                                        @if($ft === 'text')
                                                                            <div style="margin-bottom:10px;">{!! $field['html'] ?? '' !!}</div>
                                                                        @elseif($ft === 'question')
                                                                            @php $q = $field['question'] ?? []; $t = $q['type'] ?? 'short'; @endphp
                                                                            <div style="margin-bottom:12px;">
                                                                                <div style="font-weight:900;color:#0f172a;">{{ $q['title'] ?? '' }}</div>
                                                                                @if(in_array($t, ['multiple_choice']))
                                                                                    @php $opts = $q['options'] ?? []; $ans = $q['answer_index'] ?? null; @endphp
                                                                                    <ul style="margin:8px 0 0 0;padding-left:18px;color:#334155;font-weight:700;">
                                                                                        @foreach($opts as $i => $opt)
                                                                                            <li style="margin-bottom:6px;">
                                                                                                @if($ans !== null && $ans === $i)
                                                                                                    <span style="color:#16a34a;font-weight:900;">✓</span>
                                                                                                @endif
                                                                                                {{ $opt }}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <div style="color:#64748b;font-weight:700;margin-top:6px;">Free-text response</div>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @elseif(!empty($topic['questions']))
                                                                <div class="topic-subpanel">
                                                                    <div style="font-weight:900;color:#0f172a;margin-bottom:10px;">Questions</div>
                                                                    <ol style="padding-left:18px;margin:0;color:#334155;font-weight:700;">
                                                                        @foreach($topic['questions'] as $q)
                                                                            <li style="margin-bottom:10px;">
                                                                                <div style="font-weight:900;color:#0f172a;">{{ $q['title'] ?? '' }}</div>
                                                                                @php $t = $q['type'] ?? 'multiple_choice'; @endphp
                                                                                @if(in_array($t, ['multiple_choice']))
                                                                                    @php $opts = $q['options'] ?? []; @endphp
                                                                                    <ul style="margin:8px 0 0 0;padding-left:18px;">
                                                                                        @foreach($opts as $opt)
                                                                                            <li style="margin-bottom:6px;">{{ $opt }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <div style="color:#64748b;font-weight:700;margin-top:6px;">Free-text response</div>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="topic-row" style="border-bottom:none">
                                                                <div class="topic-num">—</div>
                                                                <div class="topic-title">No topics</div>
                                                                <div class="topic-actions"></div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div style="color:#64748b;font-weight:800;text-align:center;padding:18px">No modules added yet.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="stats">
                                <div class="stat">
                                    <div class="stat-ico blue"><i class="fas fa-users"></i></div>
                                    <div>
                                        <div class="stat-label">Participants</div>
                                        <div class="stat-value">{{ $participantsCount }}</div>
                                        <div style="color:#64748b;font-weight:800;font-size:.82rem;margin-top:2px">Enrolled</div>
                                    </div>
                                </div>
                                <div class="stat">
                                    <div class="stat-ico green"><i class="fas fa-calendar-check"></i></div>
                                    <div>
                                        <div class="stat-label">Enrollment Date</div>
                                        <div class="stat-value">{{ $enrollStart || $enrollEnd ? $enrollText : '—' }}</div>
                                        <div style="color:#64748b;font-weight:800;font-size:.82rem;margin-top:2px">{{ $enrollStart || $enrollEnd ? '' : 'Not available' }}</div>
                                    </div>
                                </div>
                                <div class="stat">
                                    <div class="stat-ico orange"><i class="fas fa-clock"></i></div>
                                    <div>
                                        <div class="stat-label">Duration</div>
                                        <div class="stat-value">{{ !empty($course->duration) ? $course->duration : '—' }}</div>
                                        <div style="color:#64748b;font-weight:800;font-size:.82rem;margin-top:2px">{{ !empty($course->duration) ? '' : 'Not specified' }}</div>
                                    </div>
                                </div>
                                <div class="stat">
                                    <div class="stat-ico purple"><i class="fas fa-list-check"></i></div>
                                    <div>
                                        <div class="stat-label">Total Modules</div>
                                        <div class="stat-value">{{ $modulesCount }}</div>
                                        <div style="color:#64748b;font-weight:800;font-size:.82rem;margin-top:2px">Modules</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab-modules" class="tab-pane" style="display:none">
                            <div class="panel">
                                <div class="panel-head">
                                    <h2 class="panel-title">Modules &amp; Topics</h2>
                                    <button type="button" class="tiny-btn" onclick="toggleAllModules()">Expand All</button>
                                </div>
                                <div class="panel-body">
                                    @if(!empty($modulesArr))
                                        <div class="accordion">
                                            @foreach($modulesArr as $mIndex => $module)
                                                @php $topics = (isset($module['topics']) && is_array($module['topics'])) ? $module['topics'] : []; @endphp
                                                <div class="acc-item">
                                                    <div class="acc-header" onclick="toggleAccBody(this)">
                                                        <div class="acc-left">
                                                            <div class="acc-badge">{{ $mIndex + 1 }}</div>
                                                            <div class="acc-name">Module {{ $mIndex + 1 }}: {{ $module['title'] ?? '' }}</div>
                                                        </div>
                                                        <div class="acc-right">
                                                            <span class="pill">{{ count($topics) }} {{ count($topics) === 1 ? 'Topic' : 'Topics' }}</span>
                                                            <i class="fas fa-chevron-down" style="color:#94a3b8"></i>
                                                        </div>
                                                    </div>
                                                    <div class="acc-body">
                                                        @forelse($topics as $tIndex => $topic)
                                                            <div class="topic-row">
                                                                <div class="topic-num">{{ ($mIndex+1) . '.' . ($tIndex+1) }}</div>
                                                                <div class="topic-title">{{ $topic['title'] ?? '' }}</div>
                                                                <div class="topic-actions"></div>
                                                            </div>
                                                        @empty
                                                            <div class="topic-row" style="border-bottom:none">
                                                                <div class="topic-num">—</div>
                                                                <div class="topic-title">No topics</div>
                                                                <div class="topic-actions"></div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div style="color:#64748b;font-weight:800;text-align:center;padding:18px">No modules added yet.</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="tab-enrollment" class="tab-pane" style="display:none">
                            <div class="panel">
                                <div class="panel-head">
                                    <h2 class="panel-title">Enrollment</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="kv">
                                        <div class="kv-row">
                                            <div class="kv-label"><i class="fas fa-calendar-check"></i> Enrollment Window</div>
                                            <div class="kv-value">{{ $enrollText }}</div>
                                        </div>
                                        <div class="kv-row">
                                            <div class="kv-label"><i class="fas fa-users"></i> Participants</div>
                                            <div class="kv-value">{{ $participantsCount }}</div>
                                        </div>
                                        <div class="kv-row">
                                            <div class="kv-label"><i class="fas fa-circle-info"></i> Status</div>
                                            <div class="kv-value">{{ $statusText }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab-reports" class="tab-pane" style="display:none">
                            <div class="panel">
                                <div class="panel-head">
                                    <h2 class="panel-title">Reports</h2>
                                </div>
                                <div class="panel-body" style="color:#64748b;font-weight:800;text-align:center;padding:20px">
                                    No reports available yet.
                                </div>
                            </div>
                        </div>

                        <div id="tab-settings" class="tab-pane" style="display:none">
                            <div class="panel">
                                <div class="panel-head">
                                    <h2 class="panel-title">Settings</h2>
                                </div>
                                <div class="panel-body">
                                    @if(!request()->boolean('readonly'))
                                        <div style="display:flex;gap:10px;flex-wrap:wrap">
                                            <a class="btn" href="{{ route('admin.courses.edit', $course) }}"><i class="fas fa-pen"></i> Edit</a>
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST" style="margin:0;" data-confirm-message="Archive this course?" data-confirm-title="Archive Course">
                                                @csrf
                                                @method('DELETE')
                                                @if(request()->boolean('embedded'))
                                                    <input type="hidden" name="embedded" value="1">
                                                @endif
                                                <button type="submit" class="btn danger"><i class="fas fa-box-archive"></i> Archive</button>
                                            </form>
                                        </div>
                                    @else
                                        <div style="color:#64748b;font-weight:800">Read-only mode.</div>
                                    @endif
                                    @if(!empty($course->video_path))
                                        <div style="margin-top:14px">
                                            <div style="font-weight:900;color:#0f172a;margin-bottom:10px">Course Video</div>
                                            <video controls style="width:100%;max-height:420px;border-radius:12px;outline:none;border:1px solid #e5e7eb;background:#000;">
                                                <source src="{{ asset('storage/' . $course->video_path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="panel" style="margin-bottom:14px">
                            <div class="panel-head">
                                <h2 class="panel-title">Course Preview</h2>
                                <a class="tiny-btn blue" href="{{ $previewUrl }}" target="_blank" rel="noopener">Preview Course <i class="fas fa-arrow-up-right-from-square"></i></a>
                            </div>
                            <div class="panel-body">
                                <div class="preview-wrap">
                                    <img class="preview-img" src="{{ $previewImg }}" alt="{{ $course->name }}" onerror="this.onerror=null;this.style.display='none';this.parentElement.style.display='flex';this.parentElement.style.alignItems='center';this.parentElement.style.justifyContent='center';this.parentElement.style.height='270px';this.parentElement.innerHTML='<div style=&quot;color:#94a3b8;font-weight:900;&quot;>No preview</div>';">
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-head">
                                <h2 class="panel-title">Course Details</h2>
                            </div>
                            <div class="panel-body">
                                <div class="kv">
                                    <div class="kv-row">
                                        <div class="kv-label"><i class="fas fa-layer-group"></i> Course Category</div>
                                        <div class="kv-value">{{ $subjectText }}</div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="kv-label"><i class="fas fa-user"></i> Created By</div>
                                        <div class="kv-value">{{ $creator?->name ?? '—' }}</div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="kv-label"><i class="fas fa-calendar-day"></i> Created On</div>
                                        <div class="kv-value">{{ $createdOn }}</div>
                                    </div>
                                    <div class="kv-row">
                                        <div class="kv-label"><i class="fas fa-clock-rotate-left"></i> Last Updated</div>
                                        <div class="kv-value">{{ $updatedOn }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function switchTab(key, el){
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            if(el) el.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(p => p.style.display = 'none');
            const pane = document.getElementById('tab-' + key);
            if(pane) pane.style.display = '';
        }
        function toggleAccBody(header){
            const body = header.nextElementSibling;
            const icon = header.querySelector('i.fas.fa-chevron-down');
            if (!body) return;
            const open = body.style.display === 'block';
            body.style.display = open ? 'none' : 'block';
            if (icon) icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
        }
        function toggleTopicPanel(btn){
            const row = btn.closest('.topic-row');
            if(!row) return;
            const panel = row.nextElementSibling;
            if(!panel || !panel.classList.contains('topic-subpanel')) return;
            const open = panel.style.display === 'block';
            panel.style.display = open ? 'none' : 'block';
        }
        function toggleAllModules(){
            const items = document.querySelectorAll('#modulesAccordion .acc-item');
            if(!items.length) return;
            let openCount = 0;
            items.forEach(it => {
                const body = it.querySelector('.acc-body');
                if(body && body.style.display === 'block') openCount++;
            });
            const shouldOpen = openCount !== items.length;
            items.forEach(it => {
                const header = it.querySelector('.acc-header');
                const body = it.querySelector('.acc-body');
                const icon = it.querySelector('.acc-header i.fas.fa-chevron-down');
                if(!body) return;
                body.style.display = shouldOpen ? 'block' : 'none';
                if (icon) icon.style.transform = shouldOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            });
            const b = document.getElementById('expandAllBtn');
            if(b) b.textContent = shouldOpen ? 'Collapse All' : 'Expand All';
        }
    </script>
</body>
</html>
