<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - CAPDEV PRO</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --surface: #ffffff;
            --border: #e5e7eb;
            --muted: #6b7280;
            --text: #0f172a;
            --brand: #0d6efd;
            --brand-600: #2563eb;
            --success: #10b981;
            --success-600: #059669;
            --bg: #f4f6f9;
        }
        body { font-family: 'DM Sans', sans-serif; margin: 0; padding: 0; background-color: var(--bg); color: var(--text); }
        .page-container { max-width: 1120px; margin: 40px auto; padding: 0 20px 40px; }
        h1 { color: #001f54; margin: 0 0 16px; letter-spacing: -0.02em; }
        .card { background: var(--surface); border-radius: 16px; box-shadow: 0 8px 22px rgba(15,23,42,0.06); padding: 24px; border:1px solid var(--border); }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; color: #001f54; font-weight: 500; }
        .form-group input[type="text"], .form-group input[type="url"], .form-group select, textarea,
        .section input[type="text"], .section input[type="url"], .section select, .section textarea {
            width: 100%; max-width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 10px; font-family: inherit; background:#fff; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group input[type="text"]:focus, .form-group input[type="url"]:focus, .form-group select:focus, textarea:focus,
        .section input[type="text"]:focus, .section input[type="url"]:focus, .section select:focus, .section textarea:focus {
            outline: none; border-color: var(--brand); box-shadow: 0 0 0 4px rgba(13,110,253,0.12);
        }
        .actions { text-align: right; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end; }
        .btn { border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; color: white; }
        .btn-cancel { background-color: #6c757d; }
        .btn-submit { background-color: var(--success); }
        .btn-submit:hover { background-color: var(--success-600); }
        .btn-small { padding: 8px 12px; border-radius: 5px; }
        .btn-primary { background-color: #0d6efd; }
        .two-col { display:grid; grid-template-columns: 1.2fr 1fr; gap: 20px; align-items:start; }
        .two-col .left textarea { min-height: 110px; resize: none; }
        .section { background:#fbfcff; border:1px solid #eef2ff; border-radius:14px; padding:16px; overflow: hidden; }
        .section-title { display:flex; align-items:center; gap:10px; font-weight:800; color:#0f172a; margin:0 0 8px; font-size:1rem; }
        .hint { font-size:.85rem; color:#6b7280; margin-top:6px; }
        .preview-thumb { margin-top:8px; width: 180px; height: 104px; border:1px dashed #cbd5e1; border-radius:12px; display:flex; align-items:center; justify-content:center; background:#f8fafc; overflow:hidden; }
        .preview-thumb img { max-width:100%; max-height:100%; display:block; }
        .inline { display:flex; align-items:center; gap:10px; }
        @media (max-width: 900px){ .two-col { grid-template-columns: 1fr; } }
        .module-wrapper { background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.05); }
        .module-header { display:flex;align-items:center;justify-content:space-between;padding:12px 14px; }
        .exam-meta-row { display:flex; justify-content:space-between; align-items:center; gap:16px; width:100%; }
        .exam-meta-timer { display:inline-flex; align-items:center; gap:8px; flex-shrink:0; margin:0; }
        .exam-meta-timer-label { font-weight:700; color:#111827; white-space:nowrap; }
        .exam-meta-timer-input { width:110px; padding:8px; border:1px solid #e5e7eb; border-radius:8px; }
        .exam-meta-title { margin-left:auto; font-weight:800; color:#0B2C74; text-align:right; }
        .module-title { display:flex;align-items:center;gap:12px;margin:0;color:#001f54;font-size:1rem; flex: 1; min-width: 0; }
        .module-index { width:28px;height:28px;border-radius:50%;background:#00a859;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700; }
        .module-number-label { white-space: nowrap; font-weight: 600; color: #001f54; }
        .module-title-input { flex: 1; min-width: 0; padding: 8px 10px; border: 1px solid #ddd; border-radius: 6px; }
        .module-actions { display:flex; align-items:center; gap:8px; }
        .chevron-btn { background:#f1f5f9; color:#111827; border:none; width:32px; height:32px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
        .chevron-btn i { transition: transform .2s ease; }
        .module-body { display:none;padding:10px 14px 14px 52px; position:relative; }
        .module-body .topics { max-width: 820px; margin: 0 auto; }
        .topic-row { display:flex; flex-direction:column; align-items:stretch; gap:8px; padding:12px; border:1px dashed #e5e7eb; border-radius:8px; background:#f9fafb; }
        .topic-row > span { color:#6b7280; }
        .topic-row input[type="text"] { width: 100%; }
        .module-body .add-topic-btn { display:block; margin:10px auto 0; }
        .quick-toolbar { display:none; }
        .quick-btn { display:none; }
        .badge-file { font-size: 0.8rem; color:#555; }
        .tabs { display: inline-flex; gap: 8px; margin: 8px 0 16px; padding:6px; background:#eef2ff; border-radius:12px; border:1px solid #e5e7eb; }
        .tab { padding: 10px 14px; border-radius: 10px; border: 1px solid transparent; background: transparent; cursor: pointer; color:#0f172a; }
        .tab:hover { background:#fff; border-color:#e5e7eb; }
        .tab.active { background: var(--brand); color: #fff; border-color: var(--brand); box-shadow: 0 6px 12px rgba(13,110,253,0.25); }
        .tab.disabled { opacity: 0.5; cursor: not-allowed; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .progress { margin-bottom: 12px; }
        .progress-track { width: 100%; height: 10px; border-radius: 999px; background: #e2e8f0; border: 1px solid #dbe2ea; overflow: hidden; }
        .progress-fill { width: 0; height: 100%; background: linear-gradient(90deg, #0d6efd 0%, #00a859 100%); transition: width .25s ease; }
        .progress-status { margin-top: 6px; font-size: .82rem; color: #475569; font-weight: 700; }
        .progress-steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-top: 10px; }
        .step { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 10px; background: #f8fafc; color: #334155; font-weight: 700; font-size: .84rem; border: 1px solid #e5e7eb; transition: all .2s ease; }
        .step-index { width: 24px; height: 24px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: #e2e8f0; color: #334155; font-size: .78rem; font-weight: 800; flex: 0 0 24px; }
        .step.done { background: #ecfeff; color: #0f766e; border-color: #99f6e4; }
        .step.done .step-index { background: #10b981; color: #ffffff; }
        @media (max-width: 640px){
            .progress-steps { grid-template-columns: 1fr; }
            .exam-meta-row { flex-wrap:wrap; align-items:flex-start; }
            .exam-meta-title { width:100%; margin-left:0; text-align:left; }
        }
        .summary-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .summary-section { margin-bottom: 24px; }
        .summary-section:last-child { margin-bottom: 0; }
        .summary-title { font-size: 1rem; font-weight: 800; color: #002C76; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; }
        .summary-content { color: #334155; font-size: 0.95rem; line-height: 1.6; }
        .summary-label { font-weight: 700; color: #64748b; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 4px; display: block; }
        .summary-module { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 12px; }
        .summary-module-title { font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .summary-topic { margin-left: 20px; padding-left: 12px; border-left: 2px solid #e2e8f0; margin-bottom: 6px; font-size: 0.9rem; }
        .summary-subtopic { margin-left: 20px; color: #64748b; font-size: 0.85rem; }
        .summary-cert-preview { display: flex; align-items: center; gap: 16px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .summary-cert-img { width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb; }
        .error-text { color: #dc2626; font-size: 0.85rem; margin-top: 6px; }
        .editor-toolbar { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px; }
        .editor-toolbar button { padding: 6px 8px; border: 1px solid #e5e7eb; background: #f8fafc; border-radius: 6px; cursor: pointer; }
        .editor { border: 1px solid #ddd; border-radius: 6px; padding: 10px; min-height: 120px; background: #fff; }
        .materials-panel { background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-top:8px; }
        .fields-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-top:10px; position:relative; }
        .panel-add-btn { margin-top:8px; margin-left:auto; width:34px; height:34px; border-radius:999px; border:1px solid #d1d5db; background:#ffffff; color:#0038A7; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .panel-add-btn:hover { background:#f1f5ff; border-color:#b9c6ff; }
        .field-block { border:1px dashed #cbd5e1; border-radius:8px; padding:10px; margin-bottom:10px; background:#fafafa; }
        .field-block.selected-field { outline:2px solid #6366f1; }
        .q-block { border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-bottom:10px; background:#fafafa; }
        .q-header { display:flex; flex-direction:column; gap:8px; align-items:stretch; }
        .q-header input[type="text"] { flex:1; padding:8px; border:1px solid #ddd; border-radius:6px; }
        .q-type { padding:8px; border:1px solid #ddd; border-radius:6px; width:220px; align-self:flex-end; }
        .q-type { padding:8px; border:1px solid #ddd; border-radius:6px; }
        .q-options { margin-top:10px; display:flex; flex-direction:column; gap:8px; }
        .q-option-row { display:flex; gap:8px; align-items:center; }
        .q-option-row input[type="text"] { flex:1; padding:8px; border:1px solid #ddd; border-radius:6px; }
        .q-actions { display:flex; align-items:center; margin-top:10px; gap:12px; }
        .q-actions .left { display:flex; gap:8px; align-items:center; }
        .q-actions .right { display:flex; gap:8px; align-items:center; margin-left:auto; }
        .q-actions .divider { width:1px; height:20px; background:#e5e7eb; }
        .field-move-controls { display:inline-flex; align-items:center; gap:6px; }
        .field-move-btn { width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; background:#f8fafc; border-radius:8px; color:#334155; cursor:pointer; }
        .field-move-btn:hover { background:#eef2ff; border-color:#c7d2fe; color:#1e3a8a; }
        #dynamicMenu { position: absolute; top: 0; left: 0; transform: translate(0,0); transition: transform 360ms cubic-bezier(0.2, 0, 0, 1), opacity 200ms; z-index: 2000; opacity: 0; pointer-events: none; }
        #dynamicMenu.no-anim { transition: none !important; }
        #dynamicMenu .dm-container { display:flex; align-items:flex-start; gap:8px; }
        #dynamicMenu .dm-rail { display:flex; flex-direction:column; gap:10px; padding:10px; border:1px solid #dbe4f3; background:linear-gradient(180deg,#ffffff 0%, #f8fbff 100%); border-radius:14px; box-shadow:0 14px 30px rgba(15,23,42,0.18); min-width: 240px; opacity:0; transform:translateX(14px) scale(.98); transition:opacity .22s ease, transform .28s cubic-bezier(.2,.65,.2,1); }
        #dynamicMenu.visible .dm-rail { opacity:1; transform:translateX(0) scale(1); }
        #dynamicMenu .rail-btn { width:100%; min-height:44px; border-radius:10px; display:flex; align-items:center; justify-content:flex-start; gap:10px; border:1px solid #e5e7eb; background:#ffffff; cursor:pointer; color:#111827; padding:0 12px; text-align:left; transition:transform .15s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease; }
        #dynamicMenu .rail-btn:hover { background:#f1f5ff; border-color:#c8d4ff; transform:translateY(-1px); box-shadow:0 8px 18px rgba(37,99,235,.15); }
        #dynamicMenu .rail-label { font-size:.92rem; font-weight:700; color:#0f172a; }
        .exam-header { cursor: grab; }
        .exam-wrapper.dragging { opacity:.6; transform: scale(.995); }
        #modulesContainer .drop-placeholder { height:0; border-top:3px solid #3b82f6; border-radius:2px; margin:6px 0; }
        .field-move-controls { display:none !important; }
        .drag-handle.field-move-btn{ width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; background:#f8fafc; border-radius:8px; color:#334155; cursor:grab; }
        .drag-handle.field-move-btn:hover{ background:#eef2ff; border-color:#c7d2fe; color:#1e3a8a; }
        .pill-btn { width:auto !important; height:auto !important; padding:8px 12px !important; gap:8px !important; border-radius:12px !important; background:#fff !important; box-shadow:0 3px 8px rgba(0,0,0,.06) !important; }
        .pill-btn i { margin-right:6px; }
        .field-block.dragging{ opacity:.7; }
        .fields-panel .drop-placeholder{ height:0; border-top:2px solid #3b82f6; margin:6px 0; }
        .kebab-btn{ width:34px;height:34px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;color:#111827;display:flex;align-items:center;justify-content:center;cursor:pointer; }
        .kebab-btn:hover{ background:#f8fafc; }
        .kebab-menu{ position:absolute; right:0; top:100%; margin-top:6px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 10px 24px rgba(0,0,0,.12); display:none; min-width:180px; z-index:50; }
        .kebab-menu.open{ display:block; }
        .kebab-item{ display:flex; gap:10px; align-items:center; padding:10px 12px; cursor:pointer; color:#111827; }
        .kebab-item:hover{ background:#f1f5f9; }
        #dynamicMenu .dm-panel { display:none; min-width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:14px; box-shadow:0 12px 28px rgba(0,0,0,0.12); padding:8px; }
        #dynamicMenu .dm-panel.open { display:block; }
        #dynamicMenu .dm-group-label { font-size:12px; color:#6b7280; padding:6px 10px; }
        #dynamicMenu .dm-item { width:100%; display:flex; align-items:center; gap:10px; padding:10px 12px; border:none; background:#fff; cursor:pointer; border-radius:10px; }
        #dynamicMenu .dm-item:hover { background:#f1f5f9; }
        #dynamicMenu .dm-item i { width:18px; text-align:center; color:#374151; }
        #dynamicMenu .dm-sep { height:1px; background:#e5e7eb; margin:6px 8px; }
        #dynamicMenu.visible { opacity: 1; pointer-events: auto; }
        #dynamicMenu[aria-hidden="true"] { opacity: 0; pointer-events: none; }
        #dynamicMenu.is-editing .dm-rail { display:none; }
        .active-section { outline:2px solid #6366f1; border-radius:10px; }
        .toggle { display:inline-flex; align-items:center; gap:6px; }
        .preview { margin:8px 0 0; font-size:0.85rem; color:#6b7280; }
        html, body { scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar, body::-webkit-scrollbar { width: 0; height: 0; }
        #subjectAreaDropdown { scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
        #subjectAreaDropdown::-webkit-scrollbar { width: 10px; height: 10px; }
        #subjectAreaDropdown::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; border: 2px solid #ffffff; }
        #subjectAreaDropdown::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        #subjectAreaDropdown::-webkit-scrollbar-track { background: transparent; }
    </style>
    @if($errors->update_course->any())
        <script>
            window.addEventListener('DOMContentLoaded', function(){
                alert('Please fix the errors and submit again.');
            });
        </script>
    @endif
    <script>
        window.isEdit = true;
    </script>
</head>
<body>
    <header class="header" style="background:#fff; height:80px; display:flex; align-items:center; justify-content:space-between; padding:0 24px; box-shadow:0 2px 4px rgba(0,0,0,0.05); position:sticky; top:0; z-index:100;">
        <div class="header-left">
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro" style="height:40px; display:block;">
            </div>
        </div>
        <div class="header-right" style="display:flex; gap:10px;">
            <a href="{{ route('dashboard', ['tab' => 'draft-courses']) }}" class="back-link" style="margin:0; background-color: #f8fafc; color: #002C76; border: 1px solid #002C76; padding: 8px 16px; border-radius: 5px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <i class="fas fa-file-pen"></i> Draft Courses
            </a>
            <a href="{{ route('dashboard', ['tab' => 'course-management']) }}" class="back-link" style="margin:0; background-color: #002C76; color: white; padding: 8px 16px; border-radius: 5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <i class="fas fa-arrow-left"></i> Back to Course Management
            </a>
        </div>
    </header>
    <div class="page-container">
        <h1>Edit Course</h1>
        <div class="card" aria-live="polite">
            <div class="progress" role="status" aria-live="polite" aria-label="Course setup progress">
                <div class="progress-track" aria-hidden="true">
                    <div id="courseProgressFill" class="progress-fill"></div>
                </div>
                <div id="courseProgressText" class="progress-status">0% complete</div>
                <div class="progress-steps">
                    <span id="step1" class="step"><span class="step-index">1</span><span>Details</span></span>
                    <span id="step2" class="step"><span class="step-index">2</span><span>Modules</span></span>
                    <span id="step3" class="step"><span class="step-index">3</span><span>Certificate</span></span>
                    <span id="step4" class="step"><span class="step-index">4</span><span>Finalize</span></span>
                </div>
            </div>
            <div class="tabs" role="tablist">
                <button id="tabBtn1" class="tab active" role="tab" aria-controls="tab1" aria-selected="true">Course Details</button>
                <button id="tabBtn2" class="tab" role="tab" aria-controls="tab2" aria-selected="false" tabindex="0">Modules Management</button>
                <button id="tabBtn3" class="tab" role="tab" aria-controls="tab3" aria-selected="false" tabindex="0">Certificate</button>
                <button id="tabBtn4" class="tab disabled" role="tab" aria-controls="tab4" aria-selected="false" tabindex="-1">Finalize</button>
            </div>
            @if($errors->update_course->any())
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach ($errors->update_course->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="courseForm" action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div id="tab1" class="tab-content active">
                    <div class="two-col">
                        <div class="left">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-book"></i> Course Name</div>
                                <input id="name" type="text" name="name" required maxlength="100" aria-describedby="nameError" value="{{ old('name', $course->name) }}" placeholder="Add a short, clear title">
                                <div id="nameError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-align-left"></i> Course Description</div>
                                <textarea id="description" name="description" rows="4" maxlength="1000" required aria-describedby="descError" placeholder="Describe what learners will achieve">{{ old('description', $course->description) }}</textarea>
                                <div id="descError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-image"></i> Course Image (optional)</div>
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <button type="button" class="btn btn-cancel" onclick="document.getElementById('image').click()" style="padding:8px 16px; font-size:0.85rem; margin:0; background:#f1f5f9; border:1px solid #e2e8f0; color:#475569; font-weight:600;">Choose File</button>
                                    <span id="fileNameDisplay" style="color:#64748b; font-size:0.85rem;">No file chosen</span>
                                </div>
                                <input id="image" type="file" name="image" accept="image/*" aria-describedby="imageError" style="display:none;">
                                <input type="hidden" id="image_draft_data" name="image_draft_data">
                                <div id="imageError" class="error-text" style="display:none;"></div>
                                <div class="preview-thumb" id="imagePreview">
                                    @if($course->image_path)
                                        <img src="{{ $course->image_url }}" alt="Course Image">
                                    @else
                                        <span style="color:#94a3b8;">No image selected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-layer-group"></i> Subject Area Category</div>
                                @php
                                    $subjectAreas = [
                                        'Core Governance & Administration',
                                        'Finance & Compliance',
                                        'Digital Transformation',
                                        'ICT & Technical Skills',
                                        'Human Capital & Leadership',
                                        'Community & Development Planning',
                                        'Economic & Business Development',
                                        'Social Governance',
                                    ];
                                    $existing = is_string($course->subject_area) ? $course->subject_area : '';
                                    $existingSelected = array_filter(array_map('trim', explode(',', $existing)));
                                    $sel = old('subject_area', $existingSelected);
                                    if (!is_array($sel)) {
                                        $sel = is_string($sel) ? array_filter(array_map('trim', explode(',', $sel))) : [];
                                    }
                                @endphp
                                <div id="subject_area_group" style="position:relative;">
                                    <button type="button" id="subjectAreaToggle" class="pro-input" style="width:100%;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;background:#fff;" aria-haspopup="listbox" aria-expanded="false">
                                        <span id="subjectAreaToggleLabel">Select Subject Area</span>
                                        <i class="fas fa-chevron-down" style="color:#64748b;"></i>
                                    </button>
                                    <div id="subjectAreaDropdown" style="display:none;position:absolute;top:calc(100% + 8px);left:0;right:0;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;padding:12px;box-shadow:0 18px 40px rgba(2,6,23,.12);z-index:50;max-height:320px;overflow:auto;">
                                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:10px;">
                                            @foreach($subjectAreas as $area)
                                                <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;cursor:pointer;user-select:none;">
                                                    <input type="checkbox" name="subject_area[]" value="{{ $area }}" {{ in_array($area, $sel, true) ? 'checked' : '' }}>
                                                    <span style="font-weight:700;color:#0f172a">{{ $area }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div style="position:sticky;bottom:-12px;margin-top:12px;padding-top:12px;background:linear-gradient(180deg, rgba(255,255,255,0) 0%, #ffffff 40%);">
                                            <div style="display:flex;justify-content:flex-end;">
                                                <button type="button" id="subjectAreaDoneBtn" class="btn btn-submit" style="padding:10px 16px;border-radius:12px;">Done</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="subjectError" class="error-text" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="actions" style="justify-content: flex-end; gap: 10px;">
                        <button type="button" class="btn btn-cancel" id="saveDraftBtn" onclick="saveDraft()">Save Draft</button>
                        <button type="button" class="btn btn-submit" id="nextToModules">Next</button>
                    </div>
                </div>
                <div id="tab2" class="tab-content">
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label style="margin-bottom:8px; display:block; font-weight:700; color:#002C76;">Materials & Sources</label>
                        <div class="materials-panel" style="border: 2px dashed #cbd5e1; border-radius: 12px; padding: 24px; text-align: center; background: #f8fafc; transition: all 0.2s ease;">
                            <div id="materialsList" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                                @if($course->materials && count($course->materials) > 0)
                                    @foreach($course->materials as $material)
                                        @php
                                            $fileName = $material->file_path ? basename($material->file_path) : ($material->title ?: 'Material');
                                            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                            $icon = 'fa-file';
                                            $color = '#64748b';
                                            if($ext == 'pdf') { $icon = 'fa-file-pdf'; $color = '#ef4444'; }
                                            elseif(in_array($ext, ['doc', 'docx'])) { $icon = 'fa-file-word'; $color = '#2563eb'; }
                                            elseif(in_array($ext, ['xls', 'xlsx'])) { $icon = 'fa-file-excel'; $color = '#10b981'; }
                                            elseif(in_array($ext, ['ppt', 'pptx'])) { $icon = 'fa-file-powerpoint'; $color = '#f97316'; }
                                        @endphp
                                        <div style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.88rem; color: #1e293b; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                                            <i class="fas {{ $icon }}" style="color: {{ $color }}; font-size: 1.1rem;"></i>
                                            <div style="display: flex; flex-direction: column; line-height: 1.2; text-align: left;">
                                                <span style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $fileName }}</span>
                                                <span style="color: #0d6efd; font-size: 0.7rem; font-weight: 500;">Existing Material</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div style="color: #94a3b8; font-size: 0.9rem; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                        <i class="fas fa-file-circle-plus" style="font-size: 2rem; color: #e2e8f0;"></i>
                                        <span>No materials uploaded yet (Optional)</span>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn" onclick="document.getElementById('course_materials').click()" style="padding:10px 24px; font-size:0.9rem; margin:0; background:#ffffff; border:1.5px solid #e2e8f0; color:#002C76; font-weight:700; border-radius:10px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-paperclip" style="margin-right:8px;"></i>Attach Files (PDF, Docs, Sheets)
                            </button>
                            <input id="course_materials" type="file" name="materials[]" multiple style="display:none;" onchange="handleMaterialsUpload(this)">
                            <p style="margin-top: 12px; font-size: 0.75rem; color: #64748b; font-weight: 500;">Supported: PDF, DOCX, XLSX, PPTX (Max 10MB each)</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom:8px;">
                            <label style="margin:0;">Modules & Topics</label>
                        </div>
                    <div id="modulesContainer" style="display:flex;flex-direction:column;gap:10px;"></div>
                    <div id="modulesError" class="error-text" style="display:none;"></div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="backToDetails">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn2" onclick="saveDraft()">Save Draft</button>
                            <button type="button" class="btn btn-submit" id="nextToCertificate">Next</button>
                        </div>
                    </div>
                </div>
                <div id="tab3" class="tab-content">
                    <div class="section">
                        <div class="section-title" style="display:flex; justify-content:space-between; align-items:center;">
                            <span><i class="fas fa-certificate"></i> Select Certificate Template</span>
                            <a href="javascript:void(0)" onclick="confirmGoToCertifications('{{ route('dashboard', ['tab' => 'certification-management']) }}')" style="color:#0d6efd; font-size:0.85rem; font-weight:600; text-decoration:none;">
                                <i class="fas fa-external-link-alt" style="margin-right:4px;"></i>Go to Certifications
                            </a>
                        </div>
                        <p style="color:#64748b; font-size:0.9rem; margin-bottom:16px;">Choose the certificate template that will be issued to participants upon completion of this course.</p>
                        
                        <div class="certificate-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:20px;">
                            @forelse($certifications as $cert)
                                <label class="cert-card {{ $course->certification_id == $cert->id ? 'selected' : '' }}" style="cursor:pointer; position:relative; border:2px solid {{ $course->certification_id == $cert->id ? '#0d6efd' : '#e5e7eb' }}; border-radius:12px; overflow:hidden; transition:all 0.2s ease; background: {{ $course->certification_id == $cert->id ? '#f0f7ff' : '#fff' }};">
                                    <input type="radio" name="certification_id" value="{{ $cert->id }}" {{ $course->certification_id == $cert->id ? 'checked' : '' }} style="position:absolute; opacity:0;" onchange="updateCertSelection(this)">
                                    <div class="cert-preview" style="height:160px; background:#f8fafc; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                        @if($cert->file_path)
                                            <img src="{{ route('media.public', ['path' => $cert->file_path]) }}" alt="{{ $cert->name }}" style="width:100%; height:100%; object-fit:cover;">
                                        @else
                                            <i class="fas fa-certificate" style="font-size:3rem; color:#e2e8f0;"></i>
                                        @endif
                                    </div>
                                    <div class="cert-info" style="padding:12px; border-top:1px solid #e5e7eb;">
                                        <div style="font-weight:700; color:#1e293b; margin-bottom:4px;">{{ $cert->name }}</div>
                                        <div style="font-size:0.75rem; color:#64748b;">Category: {{ $cert->category }}</div>
                                    </div>
                                    <div class="cert-check" style="position:absolute; top:8px; right:8px; width:24px; height:24px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #e5e7eb; color:#0d6efd; font-size:12px; visibility: {{ $course->certification_id == $cert->id ? 'visible' : 'hidden' }};">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </label>
                            @empty
                                <div style="grid-column: 1/-1; text-align:center; padding:40px; background:#f8fafc; border:2px dashed #e2e8f0; border-radius:12px;">
                                    <i class="fas fa-certificate" style="font-size:3rem; color:#e2e8f0; margin-bottom:12px; display:block;"></i>
                                    <div style="color:#64748b; font-weight:600;">No certificate templates available.</div>
                                    <div style="font-size:0.85rem; color:#94a3b8; margin-top:4px;">Please <a href="{{ route('dashboard', ['tab' => 'certification-management']) }}" target="_top" style="color:#0d6efd; text-decoration:underline;">add templates in Certificate Management</a> first.</div>
                                </div>
                            @endforelse
                        </div>
                        <div id="certError" class="error-text" style="display:none; margin-top:10px;">Please select a certificate template.</div>
                    </div>

                    <div class="actions" style="justify-content: space-between; margin-top:30px;">
                        <button type="button" class="btn btn-cancel" id="backToModules">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn3" onclick="saveDraft()">Save Draft</button>
                            <button type="button" class="btn btn-submit" id="nextToFinalize">Next</button>
                        </div>
                    </div>
                </div>
                <div id="tab4" class="tab-content">
                    <div class="summary-card">
                        <div class="summary-section">
                            <div class="summary-title"><i class="fas fa-info-circle"></i> Course Overview</div>
                            <div class="summary-content">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <span class="summary-label">Course Name</span>
                                        <div id="summaryName" style="font-weight: 700; font-size: 1.1rem; color: #0f172a;"></div>
                                        
                                        <span class="summary-label" style="margin-top: 12px;">Subject Area</span>
                                        <div id="summarySubject"></div>
                                    </div>
                                    <div id="summaryImageWrapper">
                                        <span class="summary-label">Course Image</span>
                                        <div id="summaryImagePreview" style="width: 100%; height: 120px; background: #f1f5f9; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #94a3b8;">No image</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="summary-label" style="margin-top: 12px;">Description</span>
                                <div id="summaryDescription" style="white-space: pre-wrap;"></div>
                            </div>
                        </div>

                        <div class="summary-section">
                            <div class="summary-title"><i class="fas fa-layer-group"></i> Modules & Topics</div>
                            <div id="summaryModules" class="summary-content">
                                <!-- Modules will be listed here -->
                            </div>
                        </div>

                        <div class="summary-section">
                            <div class="summary-title"><i class="fas fa-certificate"></i> Selected Certificate</div>
                            <div id="summaryCertificate" class="summary-content">
                                <!-- Selected cert will be shown here -->
                                <div style="color: #64748b; font-style: italic;">No certificate selected.</div>
                            </div>
                        </div>
                    </div>

                    <div class="actions" style="justify-content: space-between; margin-top:30px;">
                        <button type="button" class="btn btn-cancel" id="backToCertificate">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn4" onclick="saveDraft()">Save Draft</button>
                            <button type="submit" class="btn btn-submit" id="submitBtn">Update Course</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="draftSavedModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2300">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(420px,92vw);padding:24px;text-align:center;">
            <div style="width:60px;height:60px;background:#dcfce7;color:#16a34a;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.8rem;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div style="font-size:1.2rem;font-weight:800;color:#0f172a;margin-bottom:12px;">Draft Saved Successfully</div>
            <p style="color:#64748b;font-size:0.95rem;margin-bottom:24px;line-height:1.5;">You can find it in the "Draft Courses" section of Course Management.</p>
            <div style="display:flex;justify-content:center;">
                <button type="button" class="btn btn-submit" onclick="closeDraftSavedModal()" style="padding:10px 40px;background-color:#0d6efd;">OK</button>
            </div>
        </div>
    </div>
    <div id="confirmCertModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(420px,92vw);padding:24px;text-align:center;">
            <div style="font-size:1.2rem;font-weight:800;color:#0f172a;margin-bottom:12px;">Confirm Navigation</div>
            <p style="color:#64748b;font-size:0.95rem;margin-bottom:24px;line-height:1.5;">The courses will be saved on drafts. Are you sure you want to go to certifications?</p>
            <div style="display:flex;justify-content:center;gap:12px;">
                <button type="button" class="btn btn-cancel" onclick="closeConfirmCertModal()" style="padding:10px 24px;">Cancel</button>
                <button type="button" class="btn btn-submit" id="confirmCertBtn" style="padding:10px 24px;background-color:#0d6efd;">Confirm</button>
            </div>
        </div>
    </div>
    <div id="correctModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(420px,92vw);padding:16px">
            <div style="font-weight:800;color:#0f172a;margin-bottom:10px;">Set Correct Answer</div>
            <div class="cm-list" style="border:1px solid #e5e7eb;border-radius:10px;padding:8px;"></div>
            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                <button type="button" class="btn btn-small" style="background:#6b7280" onclick="correctModalCancel()">Cancel</button>
                <button type="button" class="btn btn-small" style="background:#0d6efd" onclick="correctModalOK()">OK</button>
            </div>
        </div>
    </div>
    <div id="videoModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(520px,92vw);padding:16px">
            <div style="font-weight:800;color:#0f172a;margin-bottom:10px;">Embed Video</div>
            <label style="display:block">
                <div style="font-size:12px;color:#6b7280;margin-bottom:6px">Paste a YouTube, Vimeo, or direct video URL</div>
                <input id="videoUrl" type="text" placeholder="https://..." style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </label>
            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                <button type="button" class="btn btn-small" style="background:#6b7280" onclick="videoModalCancel()">Cancel</button>
                <button type="button" class="btn btn-small" style="background:#0d6efd" onclick="videoModalOK()">Insert</button>
            </div>
        </div>
    </div>
    <div id="tableModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(420px,92vw);padding:16px">
            <div style="font-weight:800;color:#0f172a;margin-bottom:10px;">Insert Table</div>
            <div style="display:flex;gap:12px">
                <label style="flex:1">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Rows</div>
                    <input id="tblRows" type="number" min="1" max="20" value="2" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </label>
                <label style="flex:1">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Columns</div>
                    <input id="tblCols" type="number" min="1" max="12" value="2" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </label>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                <button type="button" class="btn btn-small" style="background:#6b7280" onclick="tableModalCancel()">Cancel</button>
                <button type="button" class="btn btn-small" style="background:#0d6efd" onclick="tableModalOK()">Insert</button>
            </div>
        </div>
    </div>
    <div id="splitModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(440px,92vw);padding:16px">
            <div style="font-weight:800;color:#0f172a;margin-bottom:10px;">Split Cells</div>
            <div style="display:flex;gap:12px">
                <label style="flex:1">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Number of columns</div>
                    <input id="splitCols" type="number" min="1" max="12" value="2" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </label>
                <label style="flex:1">
                    <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Number of rows</div>
                    <input id="splitRows" type="number" min="1" max="20" value="1" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                </label>
            </div>
            <label style="display:flex;align-items:center;gap:8px;margin-top:10px;">
                <input id="splitMerge" type="checkbox"> <span style="font-size:14px;color:#334155">Merge cells before split</span>
            </label>
            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                <button type="button" class="btn btn-small" style="background:#6b7280" onclick="document.getElementById('splitModal').style.display='none'">Cancel</button>
                <button type="button" class="btn btn-small" style="background:#0d6efd" onclick="splitModalOK()">OK</button>
            </div>
        </div>
    </div>
    <div id="dynamicMenu" aria-hidden="true">
        <div class="dm-container" aria-label="Dynamic field menu">
            <div class="dm-rail" role="toolbar" aria-orientation="vertical" aria-label="Section tools">
                <button type="button" class="rail-btn" title="Add Field" aria-label="Add Field" onclick="dmAddTextInput()"><i class="fas fa-font"></i><span class="rail-label">Add Field</span></button>
                <button type="button" class="rail-btn" title="Add Question" aria-label="Add Question" onclick="dmAddQuestion()"><i class="fas fa-dot-circle"></i><span class="rail-label">Add Questions</span></button>
                <button type="button" class="rail-btn" title="Add Topic" aria-label="Add Topic" onclick="dmAddTopic()"><i class="fas fa-stream"></i><span class="rail-label">Add Topic</span></button>
                <button type="button" class="rail-btn" title="Add Module" aria-label="Add Module" onclick="dmAddModule()"><i class="fas fa-layer-group"></i><span class="rail-label">Add Module</span></button>
            </div>
            </div>
    </div>
    </div>
    <div id="dmHelp" style="position:absolute;left:-9999px;top:-9999px;">Use Tab/Shift+Tab to move between menu buttons. Press Enter or Space to activate.</div>
    @include('admin.partials.question-builder-shared')
    <script>
        function handleMaterialsUpload(input) {
            const list = document.getElementById('materialsList');
            const files = input.files;
            
            if (files.length === 0) {
                // Keep existing materials if no new files selected
                return;
            }

            // Append new files to the list (visual only)
            Array.from(files).forEach((file, index) => {
                const extension = file.name.split('.').pop().toLowerCase();
                let icon = 'fa-file';
                let color = '#64748b';

                if (extension === 'pdf') { icon = 'fa-file-pdf'; color = '#ef4444'; }
                else if (['doc', 'docx'].includes(extension)) { icon = 'fa-file-word'; color = '#2563eb'; }
                else if (['xls', 'xlsx'].includes(extension)) { icon = 'fa-file-excel'; color = '#10b981'; }
                else if (['ppt', 'pptx'].includes(extension)) { icon = 'fa-file-powerpoint'; color = '#f97316'; }

                const badge = document.createElement('div');
                badge.style.cssText = `
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 10px 16px;
                    background: #ffffff;
                    border: 1.5px solid #10b981;
                    border-radius: 10px;
                    font-size: 0.88rem;
                    color: #1e293b;
                    font-weight: 600;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                    transition: transform 0.2s ease;
                `;
                badge.onmouseover = () => badge.style.transform = 'translateY(-2px)';
                badge.onmouseout = () => badge.style.transform = 'translateY(0)';
                
                badge.innerHTML = `
                    <i class="fas ${icon}" style="color: ${color}; font-size: 1.1rem;"></i>
                    <div style="display: flex; flex-direction: column; line-height: 1.2; text-align: left;">
                        <span style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</span>
                        <span style="color: #10b981; font-size: 0.7rem; font-weight: 500;">New: ${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                    </div>
                `;
                list.appendChild(badge);
            });
        }

        function createModule() {
            const container = document.getElementById('modulesContainer');
            const index = container.children.length;
            const wrapper = document.createElement('div');
            wrapper.className = 'module-wrapper';
            wrapper.innerHTML = `
                <div class="module-header">
                    <div class="module-title">
                        <div class="module-index">${index+1}</div>
                        <span class="module-number-label">Module ${index+1}:</span>
                        <input class="module-title-input" type="text" name="modules[${index}][title]" placeholder="Module title" required>
                    </div>
                    <div class="module-actions" style="position:relative;display:flex;align-items:center;gap:8px;">
                        <button type="button" class="kebab-btn" title="More actions" onclick="openKebab(this)">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </button>
                        <div class="kebab-menu">
                            <div class="kebab-item" onclick="kebabAddTopic(this)"><i class="fas fa-stream"></i> Add Topic</div>
                            <div class="kebab-item" onclick="kebabAddModule(this)"><i class="fas fa-layer-group"></i> Add Module</div>
                            <div class="kebab-item" onclick="kebabDeleteModule(this)"><i class="fas fa-trash-alt"></i> Delete Section</div>
                        </div>
                        <button type="button" class="chevron-btn" onclick="toggleChevron(this)"><i class="fas fa-chevron-down"></i></button>
                    </div>
                </div>
                <div class="module-body">
                    <div class="topics"></div>
                    <div class="module-exam" style="margin:12px 0 6px 0"></div>
                    <textarea class="module-exam-json" name="modules[${index}][exam_json]" style="display:none"></textarea>
                </div>
            `;
            container.appendChild(wrapper);
            reindexModules();
            updateProgress();
        }
        function toggleChevron(btn){
            const body = btn.closest('.module-wrapper').querySelector('.module-body');
            if (!body) return;
            const open = (body.style.display === 'block');
            body.style.display = open ? 'none' : 'block';
            const icon = btn.querySelector('i');
            if (icon) icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
        }
        function addTopicInput(ctx) {
            const body = ctx && ctx.classList && ctx.classList.contains('module-body') ? ctx
                        : ctx && ctx.closest ? ctx.closest('.module-body')
                        : null;
            const wrapper = body ? body.closest('.module-wrapper')
                        : (ctx && ctx.closest ? ctx.closest('.module-wrapper') : null);
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const topics = body.querySelector('.topics');
            const idx = topics.children.length;
            const row = document.createElement('div');
            row.className = 'topic-row';
            row.innerHTML = `
                <div style="display:flex;align-items:center;gap:10px;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;flex:1;">
                        <span style="color:#6b7280;width:40px;">${moduleIndex+1}.${idx+1}</span>
                        <input type="text" name="modules[${moduleIndex}][topics][${idx}][title]" placeholder="Topic title" required maxlength="80" style="flex:1;">
                    </div>
                    <div style="position:relative;display:flex;gap:8px;align-items:center;">
                        <button type="button" class="kebab-btn" title="More actions" onclick="openKebab(this)">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </button>
                        <div class="kebab-menu">
                            <div class="kebab-item" onclick="kebabAddSubtopic(this)"><i class="fas fa-plus"></i> Add Subtopic</div>
                            <div class="kebab-item" onclick="kebabDeleteTopic(this)"><i class="fas fa-trash-alt"></i> Delete Topic</div>
                        </div>
                    </div>
                </div>
                <div class="fields-panel">
                    <div class="field-list"></div>
                    <textarea name="modules[${moduleIndex}][topics][${idx}][fields_json]" style="display:none"></textarea>
                </div>
                <button type="button" class="panel-add-btn" title="Add field" aria-label="Add field" onclick="openRailFromAdd(this, event)"><i class="fas fa-plus"></i></button>
            `;
            topics.appendChild(row);
            updateProgress();
        }
        function addTopicFromHeader(btn){
            const wrapper = btn.closest('.module-wrapper');
            if(!wrapper) return;
            const body = wrapper.querySelector('.module-body');
            if(!body) return;
            body.style.display = 'block';
            addTopicInput(body);
            const lastTopic = body.querySelector('.topic-row:last-of-type');
            if(lastTopic && typeof setActiveAnchor === 'function'){ setActiveAnchor(lastTopic); }
        }
        function removeTopicRow(btn){
            const row = btn.closest('.topic-row');
            const topics = row.parentElement;
            row.remove();
            reindexTopics(topics);
            updateProgress();
        }
        function openKebab(btn){
            const menu = btn.parentElement.querySelector('.kebab-menu');
            document.querySelectorAll('.kebab-menu.open').forEach(m=>{ if(m!==menu) m.classList.remove('open'); });
            if(menu){ menu.classList.toggle('open'); }
            document.addEventListener('click', function onDoc(e){
                if(!menu) return document.removeEventListener('click', onDoc);
                if(!menu.contains(e.target) && e.target!==btn){
                    menu.classList.remove('open'); document.removeEventListener('click', onDoc);
                }
            });
        }
        function kebabAddTopic(el){
            const wrapper = el.closest('.module-wrapper');
            const body = wrapper?.querySelector('.module-body');
            if(body){ body.style.display='block'; addTopicInput(body); }
            el.closest('.kebab-menu').classList.remove('open');
        }
        function kebabAddModule(el){
            createModule(); el.closest('.kebab-menu').classList.remove('open');
        }
        async function kebabDeleteModule(el){
            if(!await window.capdevConfirm('Delete this module?', { title: 'Delete Module', confirmText: 'Delete' })) return;
            const wrapper = el.closest('.module-wrapper'); if(wrapper){ wrapper.remove(); reindexModules(); updateProgress(); }
        }
        function kebabAddSubtopic(el){
            const topicRow = el.closest('.topic-row'); 
            if(topicRow){
                // edit view topics don't have subtopic lists, use fields panel; here we create a subtopic-like area by adding a fields block line? Keep parity with create: add a minimal subtopic row equivalent is not present. Instead, append a fields panel already exists; mimic create by adding a new subtopic section is out-of-scope for edit.
                // fallback: open field add panel
                openRailFromAdd(topicRow.querySelector('.panel-add-btn') || topicRow, null);
            }
            el.closest('.kebab-menu').classList.remove('open');
        }
        async function kebabDeleteTopic(el){
            if(!await window.capdevConfirm('Delete this topic?', { title: 'Delete Topic', confirmText: 'Delete' })) return;
            const topicRow = el.closest('.topic-row'); if(topicRow){ const topics = topicRow.parentElement; topicRow.remove(); reindexTopics(topics); updateProgress(); }
            el.closest('.kebab-menu').classList.remove('open');
        }
        function reindexTopics(container){
            const wrapper = container.closest('.module-wrapper');
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const rows = Array.from(container.children);
            rows.forEach((row, idx) => {
                row.querySelector('span').textContent = `${moduleIndex+1}.${idx+1}`;
                const titleInput = row.querySelector('input[type=text]');
                const qTextarea = row.querySelector('textarea[name$="[fields_json]"]') || row.querySelector('textarea');
                titleInput.name = `modules[${moduleIndex}][topics][${idx}][title]`;
                if(qTextarea){ qTextarea.name = `modules[${moduleIndex}][topics][${idx}][fields_json]`; }
                // Reindex subtopics within this topic, if any
                const subs = Array.from(row.querySelectorAll(':scope .subtopic-row'));
                subs.forEach((sub, si)=>{
                    const idxBadge = sub.querySelector('.subtopic-idx');
                    if(idxBadge) idxBadge.textContent = `${moduleIndex+1}.${idx+1}.${si+1}a`;
                    const sTitle = sub.querySelector('.subtopic-title');
                    const ta = sub.querySelector('textarea[name$="[fields_json]"]');
                    if(sTitle) sTitle.name = `modules[${moduleIndex}][topics][${idx}][subtopics][${si}][title]`;
                    if(ta) ta.name = `modules[${moduleIndex}][topics][${idx}][subtopics][${si}][fields_json]`;
                });
            });
        }
        function addSubtopicRow(topicRow){
            if(!topicRow) return;
            const wrapper = topicRow.closest('.module-wrapper');
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const topicsContainer = wrapper.querySelector('.topics');
            const topicIndex = Array.from(topicsContainer.children).indexOf(topicRow);
            const si = topicRow.querySelectorAll(':scope .subtopic-row').length;
            const sub = document.createElement('div');
            sub.className = 'subtopic-row';
            sub.style.margin = '8px 0 0 32px';
            sub.innerHTML = `
                <div style="display:flex;align-items:center;gap:8px;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;flex:1;">
                        <span class="subtopic-idx" style="color:#64748b;width:60px;">${moduleIndex+1}.${topicIndex+1}.${si+1}a</span>
                        <input type="text" class="subtopic-title" name="modules[${moduleIndex}][topics][${topicIndex}][subtopics][${si}][title]" placeholder="Subtopic title" maxlength="80" style="flex:1;">
                    </div>
                </div>
                <div class="fields-panel" style="margin-left:68px;margin-top:6px">
                    <div class="field-list"></div>
                    <textarea name="modules[${moduleIndex}][topics][${topicIndex}][subtopics][${si}][fields_json]" style="display:none"></textarea>
                </div>
                <button type="button" class="panel-add-btn" title="Add field" aria-label="Add field" onclick="openRailFromAdd(this, event)" style="margin-left:68px"><i class="fas fa-plus"></i></button>
            `;
            // Insert after topic's last child
            topicRow.appendChild(sub);
            // Reindex after insertion
            reindexTopics(topicsContainer);
            updateProgress();
            return sub;
        }
        function removeModule(btn, event){
            event.stopPropagation();
            const wrapper = btn.closest('.module-wrapper');
            wrapper.remove();
            reindexModules();
            updateProgress();
        }
        window.OutlineEditTests = {
            testAddTopicToModule2(){
                const container = document.getElementById('modulesContainer');
                container.innerHTML = '';
                createModule(); createModule();
                const secondHeader = document.querySelectorAll('.module-header')[1];
                setActiveAnchor(secondHeader);
                dmAddTopic();
                const secondBody = document.querySelectorAll('.module-body')[1];
                const t = secondBody.querySelector('.topic-row:last-of-type input[type="text"]');
                const ok = !!t && /\bmodules\[1\]\[topics\]\[\d+\]\[title\]/.test(t.name);
                console.log('EDIT TEST dmAddTopic -> Module 2 assignment:', ok ? 'PASS' : 'FAIL', t?.name);
                return ok;
            }
        };
        function reindexModules(){
            const container = document.getElementById('modulesContainer');
            const modules = Array.from(container.children);
            let moduleCounter = 0;
            modules.forEach((wrapper, i) => {
                if(wrapper.classList.contains('module-wrapper')){
                    moduleCounter++;
                    const idxBadge = wrapper.querySelector('.module-index');
                    idxBadge.textContent = moduleCounter;
                    const numberLabel = wrapper.querySelector('.module-number-label');
                    if (numberLabel) numberLabel.textContent = `Module ${moduleCounter}:`;
                    const titleInput = wrapper.querySelector('.module-title-input');
                    if (titleInput) titleInput.name = `modules[${i}][title]`;
                    const topicsContainer = wrapper.querySelector('.topics');
                    if (topicsContainer) {
                        reindexTopics(topicsContainer);
                    }
                    const examTa = wrapper.querySelector('.module-exam-json');
                    if (examTa) examTa.name = `modules[${i}][exam_json]`;
                } else if(wrapper.classList.contains('exam-wrapper')){
                    const ta = wrapper.querySelector('.exam-json');
                    if(ta) ta.name = `modules[${i}][exam_json]`;
                }
            });
        }
        function execCmd(btn, cmd){
            const editor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            document.execCommand(cmd, false, null);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function applyFontName(sel){
            const editor = sel.closest('.text-block')?.querySelector('.editor');
            if(!editor) return;
            editor.focus();
            document.execCommand('fontName', false, sel.value);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function applyFontSize(sel){
            const editor = sel.closest('.text-block')?.querySelector('.editor');
            if(!editor) return;
            const sizeMap = { '12':2,'14':3,'16':3,'18':4,'20':5,'24':5,'28':6,'32':7 };
            const n = sizeMap[sel.value] || 3;
            editor.focus();
            document.execCommand('fontSize', false, n);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function applyFontSizeStep(btn, step){
            const bar = btn.closest('.editor-toolbar');
            const sel = bar.querySelector('.et-size');
            const sizes = ['12','14','16','18','20','24','28','32'];
            let idx = sizes.indexOf(sel.value);
            idx = Math.min(sizes.length-1, Math.max(0, idx + step));
            sel.value = sizes[idx];
            applyFontSize(sel);
        }
        function applyColor(input){
            const editor = input.closest('.text-block')?.querySelector('.editor');
            if(!editor) return;
            editor.focus();
            document.execCommand('foreColor', false, input.value);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function applyHighlight(input){
            const editor = input.closest('.text-block')?.querySelector('.editor');
            if(!editor) return;
            editor.focus();
            document.execCommand('hiliteColor', false, input.value);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function togglePalette(btn, mode){
            const bar = btn.closest('.editor-toolbar');
            const menu = bar.querySelector('.palette-menu');
            if(!menu) return;
            menu.dataset.mode = mode;
            const theme = ['#000000','#111827','#1f2937','#374151','#4b5563','#6b7280','#9ca3af','#d1d5db','#e5e7eb','#f3f4f6',
                           '#1d4ed8','#2563eb','#3b82f6','#60a5fa','#93c5fd','#0e7490','#10b981','#22c55e','#84cc16','#eab308'];
            const standard = ['#ef4444','#f59e0b','#fde047','#10b981','#06b6d4','#3b82f6','#1d4ed8','#7c3aed','#000000','#9ca3af'];
            const fill = (el, colors)=>{
                el.innerHTML = '';
                colors.forEach(c=>{
                    const b = document.createElement('button');
                    b.type='button';
                    b.style.cssText = 'width:18px;height:18px;border:1px solid #e5e7eb;border-radius:4px;cursor:pointer;background:'+c;
                    b.onclick = ()=> applyPaletteColor(menu, c);
                    el.appendChild(b);
                });
            };
            fill(menu.querySelector('.grid.theme'), theme);
            fill(menu.querySelector('.grid.standard'), standard);
            menu.querySelector('.no-color').onclick = ()=> applyPaletteColor(menu, mode==='hilite' ? 'transparent' : 'inherit');
            menu.style.display = (menu.style.display==='block' ? 'none' : 'block');
            document.addEventListener('click', function onDoc(e){
                if(!menu.contains(e.target) && e.target!==btn){
                    menu.style.display='none';
                    document.removeEventListener('click', onDoc);
                }
            });
        }
        function applyPaletteColor(menu, color){
            const mode = menu.dataset.mode || 'fore';
            const toolbar = menu.closest('.editor-toolbar');
            const editor = toolbar.closest('.text-block')?.querySelector('.editor');
            if(!editor) return;
            editor.focus();
            if(mode==='hilite'){
                document.execCommand('hiliteColor', false, color);
            }else{
                document.execCommand('foreColor', false, color);
            }
            const group = toolbar.querySelector('.color-group');
            if(group){
                const sw = group.querySelector(mode==='hilite' ? 'button:nth-child(2) .swatch' : 'button:nth-child(1) .swatch');
                if(sw){ sw.style.background = color==='inherit'?'#111827':color; }
            }
            menu.style.display='none';
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function toggleEditorTab(btn){
            const bar = btn.closest('.editor-toolbar');
            const active = btn.getAttribute('data-tab');
            bar.querySelectorAll('.et-tab').forEach(t=>{
                if(t===btn){ t.classList.add('active'); t.style.background='#eef2ff'; }
                else { t.classList.remove('active'); t.style.background='#fff'; }
            });
            const textBox = bar.querySelector('.et-text-tools');
            const insBox = bar.querySelector('.et-insert-tools');
            if(active==='text'){ textBox.style.display='flex'; insBox.style.display='none'; }
            else { textBox.style.display='none'; insBox.style.display='flex'; }
        }
        async function insertLink(btn){
            const url = await window.capdevPrompt('Enter URL', '', { title: 'Insert Link', inputLabel: 'URL', confirmText: 'Insert' });
            if(!url) return;
            const editor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            document.execCommand('createLink', false, url);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function insertTable(btn){
            const rows = parseInt(btn.dataset.rows||'2', 10) || 2;
            const cols = parseInt(btn.dataset.cols||'2', 10) || 2;
            let tbl = '<table style="width:100%;border-collapse:collapse;table-layout:fixed;" border="1">';
            for(let r=0;r<rows;r++){ tbl += '<tr>'; for(let c=0;c<cols;c++){ tbl += '<td style="padding:6px;">&nbsp;</td>'; } tbl += '</tr>'; }
            tbl += '</table>';
            const html = `
                <div class="table-wrap" style="position:relative;margin:6px 0;">
                    <div class="t-handle-col" onclick="tableAddColRight(this)" title="Add column" style="position:absolute;right:-12px;top:50%;transform:translateY(-50%);background:#fff;border:1px solid #e5e7eb;border-radius:8px;width:26px;height:26px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.08);cursor:pointer;">+</div>
                    <div class="t-handle-row" onclick="tableAddRowBelow(this)" title="Add row" style="position:absolute;left:50%;bottom:-12px;transform:translateX(-50%);background:#fff;border:1px solid #e5e7eb;border-radius:8px;width:26px;height:26px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,.08);cursor:pointer;">+</div>
                    ${tbl}
                </div>`;
            const editor = (window.__tableTargetEditor) || btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            window.__tableTargetEditor = null;
            editor.focus();
            document.execCommand('insertHTML', false, html);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function bindEditorKeyBehavior(scope){
            const editors = scope.querySelectorAll ? scope.querySelectorAll('.editor') : [];
            editors.forEach(ed=>{
                ed.addEventListener('keydown', function(e){
                    if(e.key !== 'Backspace' && e.key !== 'Delete') return;
                    const panel = ed.closest('.fields-panel');
                    const sel = window.getSelection();
                    if(!sel || sel.rangeCount===0) return;
                    const node = sel.anchorNode ? (sel.anchorNode.nodeType===1 ? sel.anchorNode : sel.anchorNode.parentElement) : ed;
                    let target = node ? node.closest('figure.img-std, .table-wrap') : null;
                    if(!target && e.key==='Backspace'){
                        let prev = node && node.previousElementSibling;
                        while(prev && !prev.matches('figure.img-std, .table-wrap')) prev = prev.previousElementSibling;
                        if(prev) target = prev;
                    }
                    if(target){
                        e.preventDefault();
                        target.remove();
                        syncFieldsJSON(panel);
                    }
                });
            });
        }
        function tableAddRowBelow(el){
            const table = el.parentElement.querySelector('table');
            const cols = table.querySelector('tr')?.children.length || 1;
            const tr = document.createElement('tr');
            for(let i=0;i<cols;i++){ const td=document.createElement('td'); td.style.padding='6px'; td.innerHTML='&nbsp;'; tr.appendChild(td); }
            table.querySelector('tbody') ? table.querySelector('tbody').appendChild(tr) : table.appendChild(tr);
        }
        function tableAddColRight(el){
            const table = el.parentElement.querySelector('table');
            table.querySelectorAll('tr').forEach(tr=>{ const td=document.createElement('td'); td.style.padding='6px'; td.innerHTML='&nbsp;'; tr.appendChild(td); });
        }
        function splitModalOK(){
            const m = document.getElementById('splitModal');
            const cols = parseInt(m.querySelector('#splitCols').value||'1',10);
            const rows = parseInt(m.querySelector('#splitRows').value||'1',10);
            const merge = !!m.querySelector('#splitMerge').checked;
            const cell = window.__ctxCell; if(!cell){ m.style.display='none'; return; }
            const row = cell.parentElement;
            const table = row.parentElement;
            const colIdx = Array.from(row.children).indexOf(cell);
            const toInsertInRow = Math.max(1, cols);
            for(let i=0;i<toInsertInRow;i++){
                const td = (i===0)? cell : document.createElement('td');
                td.style.padding='6px';
                td.innerHTML='&nbsp;';
                if(i>0){ row.insertBefore(td, cell.nextSibling); }
            }
            const totalCols = row.children.length;
            for(let r=1;r<rows;r++){
                const newRow = document.createElement('tr');
                for(let c=0;c<totalCols;c++){
                    const td = document.createElement('td'); td.style.padding='6px'; td.innerHTML='&nbsp;';
                    newRow.appendChild(td);
                }
                table.insertBefore(newRow, row.nextSibling);
            }
            m.style.display='none';
        }
        function openTableModal(btn){
            const editor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            window.__tableTargetEditor = editor;
            const m = document.getElementById('tableModal');
            m.style.display='flex';
            m.querySelector('#tblRows').value = '2';
            m.querySelector('#tblCols').value = '2';
        }
        function tableModalOK(){
            const m = document.getElementById('tableModal');
            const rows = parseInt(m.querySelector('#tblRows').value||'2', 10);
            const cols = parseInt(m.querySelector('#tblCols').value||'2', 10);
            const fakeBtn = { dataset:{ rows:String(rows), cols:String(cols) } };
            insertTable(fakeBtn);
            m.style.display='none';
        }
        function tableModalCancel(){ document.getElementById('tableModal').style.display='none'; window.__tableTargetEditor=null; }
        function triggerImagePicker(btn){
            const input = btn.parentElement.querySelector('input[type=file]');
            input.click();
        }
        function insertImageFromInput(input){
            const file = input.files && input.files[0];
            if(!file) return;
            const types = ['image/jpeg','image/png','image/gif','image/webp','image/bmp','image/tiff'];
            if (!types.includes(file.type) || file.size > 10 * 1024 * 1024) {
                alert('Invalid image. Max 10MB. Common image formats only.');
                input.value = '';
                return;
            }
            const editor = input.closest('.text-block')?.querySelector('.editor') || input.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            const fd = new FormData();
            fd.append('image', file);
            fetch("{{ route('courses.content-image.upload') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: fd
            }).then(r=>r.json()).then(res=>{
                if(!res || !res.ok || !res.url){ alert('Upload failed'); return; }
                const html = `
                <figure class="img-std" contenteditable="false" style="width:100%;max-width:100%;margin:6px 0;">
                    <div style="position:relative;width:100%;border:1px solid #cbd5e1;border-radius:10px;overflow:hidden;background:#f8fafc">
                        <img src="${res.url}" alt="${file.name}" style="width:100%;height:auto;display:block;">
                    </div>
                </figure><p><br></p>`;
                document.execCommand('insertHTML', false, html);
                syncFieldsJSON(editor.closest('.fields-panel'));
            }).catch(()=>alert('Upload error'));
        }
        function openVideoModal(btn){
            window.__videoTargetEditor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            const m = document.getElementById('videoModal');
            m.style.display='flex';
            m.querySelector('#videoUrl').value = '';
        }
        function videoModalOK(){
            const m = document.getElementById('videoModal');
            const url = (m.querySelector('#videoUrl').value||'').trim();
            if(!url){ m.style.display='none'; return; }
            const editor = window.__videoTargetEditor;
            window.__videoTargetEditor = null;
            const embed = toEmbedURL(url);
            const html = `
                <figure class="vid-std" contenteditable="false" style="width:100%;max-width:100%;margin:6px 0;">
                    <div style="position:relative;width:100%;aspect-ratio:16/9;border:1px solid #cbd5e1;border-radius:10px;overflow:hidden;background:#000">
                        <iframe src="${embed}" allowfullscreen style="width:100%;height:100%;border:0;display:block;"></iframe>
                    </div>
                </figure><p><br></p>`;
            editor.focus();
            document.execCommand('insertHTML', false, html);
            syncFieldsJSON(editor.closest('.fields-panel'));
            m.style.display='none';
        }
        function videoModalCancel(){ document.getElementById('videoModal').style.display='none'; window.__videoTargetEditor=null; }
        function toEmbedURL(url){
            try{
                const u = new URL(url);
                if(u.hostname.includes('youtube.com')){
                    const id = u.searchParams.get('v');
                    if(id) return 'https://www.youtube.com/embed/'+id;
                }
                if(u.hostname==='youtu.be'){
                    return 'https://www.youtube.com/embed'+u.pathname;
                }
                if(u.hostname.includes('vimeo.com')){
                    const id = u.pathname.split('/').filter(Boolean).pop();
                    return 'https://player.vimeo.com/video/'+id;
                }
                return url;
            }catch(e){ return url; }
        }
        function openAddMenu(btn){
            const menu = btn.parentElement.querySelector('.add-menu');
            menu.style.display = (menu.style.display==='block') ? 'none' : 'block';
            document.addEventListener('click', function onDoc(e){
                if(!menu.contains(e.target) && e.target !== btn){
                    menu.style.display='none';
                    document.removeEventListener('click', onDoc);
                }
            });
        }
        function setSelectedField(block){
            document.querySelectorAll('.field-block.selected-field').forEach(b=> b.classList.remove('selected-field'));
            block.classList.add('selected-field');
        }
        function moveFieldUp(btn){
            const block = btn.closest('.field-block');
            const panel = block.closest('.fields-panel');
            if(block.previousElementSibling){ block.parentElement.insertBefore(block, block.previousElementSibling); }
            syncFieldsJSON(panel);
        }
        function moveFieldDown(btn){
            const block = btn.closest('.field-block');
            const panel = block.closest('.fields-panel');
            if(block.nextElementSibling){ block.parentElement.insertBefore(block.nextElementSibling, block); }
            syncFieldsJSON(panel);
        }
        function addTextField(origin){
            const panel = (origin && origin.classList && origin.classList.contains('fields-panel'))
                ? origin
                : origin.closest ? origin.closest('.fields-panel') : null;
            const list = panel.querySelector('.field-list');
            const block = document.createElement('div');
            block.className = 'field-block text-block';
            block.setAttribute('data-type','text');
            block.innerHTML = `
                <div class="editor-toolbar" style="display:block;margin-bottom:6px">
                    <div class="et-tabs" style="display:flex;gap:6px;margin-bottom:8px;align-items:center;">
                        <div class="et-undo" style="display:flex;gap:6px;margin-right:8px">
                            <button type="button" class="field-move-btn" onclick="execCmd(this,'undo')" title="Undo"><i class="fas fa-rotate-left"></i></button>
                            <button type="button" class="field-move-btn" onclick="execCmd(this,'redo')" title="Redo"><i class="fas fa-rotate-right"></i></button>
                        </div>
                        <button type="button" class="et-tab active" data-tab="text" onclick="toggleEditorTab(this)" style="padding:6px 10px;border:1px solid #e5e7eb;border-radius:8px;background:#eef2ff;color:#111827;font-weight:700;">Text</button>
                        <button type="button" class="et-tab" data-tab="insert" onclick="toggleEditorTab(this)" style="padding:6px 10px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;color:#111827;font-weight:700;">Insert</button>
                    </div>
                    <div class="et-text-tools" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <select class="et-font" onchange="applyFontName(this)">
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Arial">Arial</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Tahoma">Tahoma</option>
                        <option value="Verdana">Verdana</option>
                    </select>
                    <select class="et-size" onchange="applyFontSize(this)">
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16" selected>16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                        <option value="28">28</option>
                        <option value="32">32</option>
                    </select>
                        <button type="button" class="field-move-btn" onclick="applyFontSizeStep(this,1)" title="Increase Size">A+</button>
                        <button type="button" class="field-move-btn" onclick="applyFontSizeStep(this,-1)" title="Decrease Size">A-</button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'italic')" title="Italic"><i class="fas fa-italic"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'underline')" title="Underline"><i class="fas fa-underline"></i></button>
                    <div class="color-group" style="position:relative;display:inline-flex;gap:6px;align-items:center;">
                        <button type="button" class="field-move-btn" onclick="togglePalette(this,'fore')" title="Font Color" aria-haspopup="true"><span style="display:inline-block;width:16px;height:16px;border:1px solid #cbd5e1;position:relative"><span class="swatch" style="position:absolute;left:2px;right:2px;bottom:2px;height:4px;background:#1d4ed8;"></span></span></button>
                        <button type="button" class="field-move-btn" onclick="togglePalette(this,'hilite')" title="Highlight" aria-haspopup="true"><span style="display:inline-block;width:16px;height:16px;border:1px solid #cbd5e1;position:relative"><span class="swatch" style="position:absolute;left:2px;right:2px;bottom:2px;height:8px;background:#fde047;"></span></span></button>
                        <div class="palette-menu" role="menu" style="display:none;position:absolute;top:36px;left:0;background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 12px 24px rgba(0,0,0,.12);padding:8px;z-index:40;width:240px;">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:6px;">Theme Colors</div>
                            <div class="grid theme" style="display:grid;grid-template-columns:repeat(10,1fr);gap:6px;margin-bottom:8px;"></div>
                            <div style="font-size:12px;color:#6b7280;margin-bottom:6px;">Standard Colors</div>
                            <div class="grid standard" style="display:grid;grid-template-columns:repeat(10,1fr);gap:6px;"></div>
                            <div class="no-color" style="margin-top:8px;display:flex;align-items:center;gap:8px;cursor:pointer;"><span style="width:16px;height:16px;border:1px solid #cbd5e1;position:relative;"><span style="position:absolute;left:-2px;right:-2px;top:7px;height:2px;background:#ef4444;transform:rotate(-20deg);"></span></span><span style="font-size:12px;color:#6b7280">No Color</span></div>
                        </div>
                    </div>
                        <span class="divider"></span>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'insertUnorderedList')" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'insertOrderedList')" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                        <span class="divider"></span>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'justifyLeft')" title="Align Left"><i class="fas fa-align-left"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'justifyCenter')" title="Align Center"><i class="fas fa-align-center"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'justifyRight')" title="Align Right"><i class="fas fa-align-right"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'outdent')" title="Outdent"><i class="fas fa-outdent"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'indent')" title="Indent"><i class="fas fa-indent"></i></button>
                        <button type="button" class="field-move-btn" onclick="execCmd(this,'removeFormat')" title="Clear Formatting"><i class="fas fa-eraser"></i></button>
                    </div>
                    <div class="et-insert-tools" style="display:none;gap:12px;align-items:stretch;flex-wrap:wrap;">
                        <button type="button" class="field-move-btn pill-btn" onclick="openTableModal(this)" title="Insert Table"><i class="fas fa-table"></i><span>Table</span></button>
                        <button type="button" class="field-move-btn pill-btn" onclick="triggerImagePicker(this)" title="Insert Image"><i class="fas fa-image"></i><span>Picture</span></button>
                        <button type="button" class="field-move-btn pill-btn" onclick="openVideoModal(this)" title="Insert Video"><i class="fas fa-video"></i><span>Video</span></button>
                        <input type="file" accept="image/*" onchange="insertImageFromInput(this)" style="display:none">
                    </div>
                </div>
                <div class="editor" contenteditable="true" aria-label="Text field editor"></div>
                <div class="q-actions" style="position:relative;">
                    <div class="right">
                        <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate field"><i class="fas fa-clone"></i></button>
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete field"><i class="fas fa-trash-alt"></i></button>
                        <span class="divider"></span>
                        <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                    </div>
                </div>
            `;
            list.appendChild(block);
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            bindFieldDrag(block);
            syncFieldsJSON(panel);
        }
        function addQuestionField(origin){
            const panel = (origin && origin.classList && origin.classList.contains('fields-panel'))
                ? origin
                : origin.closest ? origin.closest('.fields-panel') : null;
            const list = panel.querySelector('.field-list');
            const block = document.createElement('div');
            block.className = 'field-block';
            block.setAttribute('data-type','question');
            block.setAttribute('data-correct', `correct-${Date.now()}-${Math.floor(Math.random()*1000)}`);
            block.innerHTML = `
                <div class="q-block">
                    <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:end">
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                            <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                        </label>
                        <label class="q-col" style="display:block;padding-left:16px">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
                                <option value="enumeration">Enumeration</option>
                            </select>
                        </label>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-feedback" style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">
                        <textarea class="q-fb-correct" rows="2" placeholder="Feedback when answer is correct (optional)"></textarea>
                        <textarea class="q-fb-incorrect" rows="2" placeholder="Feedback when answer is incorrect (optional)"></textarea>
                    </div>
                    <div class="q-add-under" style="margin-top:10px;">
                        <button type="button" class="btn btn-small" style="background:#0f3b8f;color:#fff" onclick="addQuestionFieldAfter(this)"><i class="fas fa-plus" style="margin-right:6px"></i>Add Question</button>
                    </div>
                    <div class="q-actions">
                        <div class="right" style="position:relative;">
                            <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate question"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete question"><i class="fas fa-trash-alt"></i></button>
                            <span class="divider"></span>
                            <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                        </div>
                    </div>
                </div>
            `;
            list.appendChild(block);
            __bindAutosizeTextareas(block);
            setupDefaultOptions(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncFieldsJSON(panel);
            });
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            bindFieldDrag(block);
            syncFieldsJSON(panel);
        }
        function addTextFieldAfter(btn){
            const current = btn.closest('.field-block');
            const panel = current.closest('.fields-panel');
            const block = document.createElement('div');
            block.className = 'field-block text-block';
            block.setAttribute('data-type','text');
            block.innerHTML = `
                <div class="editor-toolbar" style="display:none">
                    <input type="file" accept="image/*" onchange="insertImageFromInput(this)">
                    <input type="file" accept="video/mp4,video/webm,video/ogg" data-video="1" onchange="insertVideoFromFile(this)">
                </div>
                <div class="editor" contenteditable="true" aria-label="Text field editor"></div>
                <div class="q-actions">
                    <div class="left">
                        <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)">Duplicate</button>
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)">Delete</button>
                    </div>
                </div>
            `;
            current.parentElement.insertBefore(block, current.nextSibling);
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            bindFieldDrag(block);
            syncFieldsJSON(panel);
            block.scrollIntoView({behavior:'smooth', block:'center'});
        }
        function addQuestionFieldAfter(btn){
            const current = btn.closest('.field-block');
            const panel = current.closest('.fields-panel');
            const block = document.createElement('div');
            block.className = 'field-block';
            block.setAttribute('data-type','question');
            block.setAttribute('data-correct', `correct-${Date.now()}-${Math.floor(Math.random()*1000)}`);
            block.innerHTML = `
                <div class="q-block">
                    <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:end">
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                            <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                        </label>
                        <label class="q-col" style="display:block;padding-left:16px">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
                                <option value="enumeration">Enumeration</option>
                            </select>
                        </label>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-feedback" style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">
                        <textarea class="q-fb-correct" rows="2" placeholder="Feedback when answer is correct (optional)"></textarea>
                        <textarea class="q-fb-incorrect" rows="2" placeholder="Feedback when answer is incorrect (optional)"></textarea>
                    </div>
                    <div class="q-add-under" style="margin-top:10px;">
                        <button type="button" class="btn btn-small" style="background:#0f3b8f;color:#fff" onclick="addQuestionFieldAfter(this)"><i class="fas fa-plus" style="margin-right:6px"></i>Add Question</button>
                    </div>
                    <div class="q-actions">
                        <div class="right" style="position:relative;">
                            <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate question"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete question"><i class="fas fa-trash-alt"></i></button>
                            <span class="divider"></span>
                            <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                        </div>
                    </div>
                </div>
            `;
            current.parentElement.insertBefore(block, current.nextSibling);
            __bindAutosizeTextareas(block);
            setupDefaultOptions(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncFieldsJSON(panel);
            });
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            syncFieldsJSON(panel);
            block.scrollIntoView({behavior:'smooth', block:'center'});
        }
        function duplicateField(btn){
            const current = btn.closest('.field-block');
            const panel = current.closest('.fields-panel');
            const clone = current.cloneNode(true);
            current.parentElement.insertBefore(clone, current.nextSibling);
            clone.querySelectorAll('button').forEach(b=>{
                if(b.title==='Delete' || b.innerText==='Delete'){ b.onclick = function(){ deleteField(this); }; }
                if(b.title==='Duplicate' || b.innerText==='Duplicate'){ b.onclick = function(){ duplicateField(this); }; }
            });
            clone.addEventListener('input', ()=> syncFieldsJSON(panel));
            syncFieldsJSON(panel);
            bindEditorEnhancements(clone);
        }
        function bindEditorEnhancements(scope){
            const editors = scope.querySelectorAll ? scope.querySelectorAll('.editor') : [];
            editors.forEach(ed=>{
                ed.addEventListener('contextmenu', function(e){
                    const cell = e.target.closest('td,th');
                    if(!cell) return;
                    e.preventDefault();
                    openTableCtxMenu(e.clientX, e.clientY, cell);
                });
                if(!ed.__resizeBound){
                    ed.__resizeBound = true;
                    attachTableResizeUI(ed);
                }
            });
            bindEditorKeyBehavior(scope);
        }
        function attachTableResizeUI(editor){
            const col = document.createElement('div');
            const row = document.createElement('div');
            col.style.cssText = 'position:absolute;width:3px;background:#3b82f6;cursor:col-resize;display:none;z-index:2000';
            row.style.cssText = 'position:absolute;height:3px;background:#3b82f6;cursor:row-resize;display:none;z-index:2000';
            editor.parentElement.style.position='relative';
            editor.parentElement.appendChild(col);
            editor.parentElement.appendChild(row);
            let target = null, mode = null, startX=0,startY=0,startW=0,startH=0,colIndex=0;
            editor.addEventListener('mousemove', (e)=>{
                const td = e.target.closest('td,th');
                if(!td) { col.style.display='none'; row.style.display='none'; return; }
                const rect = td.getBoundingClientRect();
                const nearRight = Math.abs(e.clientX - rect.right) <= 6;
                const nearBottom = Math.abs(e.clientY - rect.bottom) <= 6;
                const hostRect = editor.parentElement.getBoundingClientRect();
                if(nearRight){
                    col.style.display='block';
                    col.style.left = (rect.right - hostRect.left - 1)+'px';
                    col.style.top = (rect.top - hostRect.top)+'px';
                    col.style.height = (rect.height)+'px';
                } else { col.style.display='none'; }
                if(nearBottom){
                    row.style.display='block';
                    row.style.top = (rect.bottom - hostRect.top - 1)+'px';
                    row.style.left = (rect.left - hostRect.left)+'px';
                    row.style.width = (rect.width)+'px';
                } else { row.style.display='none'; }
            });
            col.addEventListener('mousedown', (e)=>{
                e.preventDefault();
                const td = document.elementFromPoint(e.clientX, e.clientY)?.closest('td,th');
                if(!td) return;
                target = td;
                mode = 'col';
                startX = e.clientX;
                startW = td.offsetWidth;
                colIndex = Array.from(td.parentElement.children).indexOf(td);
                document.addEventListener('mousemove', onDrag);
                document.addEventListener('mouseup', onUp, { once:true });
            });
            row.addEventListener('mousedown', (e)=>{
                e.preventDefault();
                const td = document.elementFromPoint(e.clientX, e.clientY)?.closest('td,th');
                if(!td) return;
                target = td;
                mode = 'row';
                startY = e.clientY;
                startH = td.offsetHeight;
                document.addEventListener('mousemove', onDrag);
                document.addEventListener('mouseup', onUp, { once:true });
            });
            function onDrag(e){
                if(!target) return;
                const tr = target.parentElement;
                const table = tr.parentElement;
                if(mode==='col'){
                    const dx = e.clientX - startX;
                    const w = Math.max(40, startW + dx);
                    table.querySelectorAll('tr').forEach(r=>{
                        const cell = r.children[colIndex];
                        if(cell) cell.style.width = w+'px';
                    });
                }else if(mode==='row'){
                    const dy = e.clientY - startY;
                    const h = Math.max(24, startH + dy);
                    tr.querySelectorAll('td,th').forEach(c=> c.style.height = h+'px');
                }
            }
            function onUp(){
                target = null; mode = null;
                document.removeEventListener('mousemove', onDrag);
            }
        }
        function openTableCtxMenu(x, y, cell){
            let menu = document.getElementById('tblCtx');
            if(!menu){
                menu = document.createElement('div');
                menu.id = 'tblCtx';
                menu.style.cssText = 'position:fixed;z-index:3000;background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 12px 28px rgba(0,0,0,.15);width:220px;padding:8px;';
                document.body.appendChild(menu);
            }
            menu.innerHTML = `
                <div style="font-weight:700;color:#0f172a;padding:8px 10px;display:flex;align-items:center;gap:8px;"><i class="fas fa-table"></i> Insert</div>
                <div style="padding:6px 10px;display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                    <button class="btn btn-small" style="background:#f1f5f9;color:#111827" onclick="ctxIns('row-above')">Row Above</button>
                    <button class="btn btn-small" style="background:#f1f5f9;color:#111827" onclick="ctxIns('row-below')">Row Below</button>
                    <button class="btn btn-small" style="background:#f1f5f9;color:#111827" onclick="ctxIns('col-left')">Col Left</button>
                    <button class="btn btn-small" style="background:#f1f5f9;color:#111827" onclick="ctxIns('col-right')">Col Right</button>
                </div>
                <div style="height:1px;background:#e5e7eb;margin:6px 8px;"></div>
                <button class="btn btn-small" style="margin:6px 10px;background:#f1f5f9;color:#111827;width:calc(100% - 20px)" onclick="ctxSplit()">Split Cell</button>
                <button class="btn btn-small" style="margin:0 10px 6px;background:#dc3545;width:calc(100% - 20px)" onclick="ctxDeleteCell()">Delete Cell</button>
            `;
            menu.style.left = Math.min(window.innerWidth-240, x) + 'px';
            menu.style.top = Math.min(window.innerHeight-180, y) + 'px';
            menu.style.display = 'block';
            window.__ctxCell = cell;
            document.addEventListener('click', function onDoc(){ menu.style.display='none'; document.removeEventListener('click', onDoc); });
        }
        function ctxIns(kind){
            const cell = window.__ctxCell; if(!cell) return;
            const row = cell.parentElement;
            const table = row.parentElement;
            if(kind==='row-above' || kind==='row-below'){
                const r = document.createElement('tr');
                for(let i=0;i<row.children.length;i++){ const td = document.createElement('td'); td.style.padding='6px'; td.innerHTML='&nbsp;'; r.appendChild(td); }
                if(kind==='row-above') table.insertBefore(r, row); else table.insertBefore(r, row.nextSibling);
            }else if(kind==='col-left' || kind==='col-right'){
                const idx = Array.from(row.children).indexOf(cell);
                Array.from(table.querySelectorAll('tr')).forEach(tr=>{
                    const td = document.createElement('td'); td.style.padding='6px'; td.innerHTML='&nbsp;';
                    if(kind==='col-left') tr.insertBefore(td, tr.children[idx]); else tr.insertBefore(td, tr.children[idx].nextSibling);
                });
            }
        }
        function ctxSplit(){
            const m = document.getElementById('splitModal');
            m.style.display='flex';
            m.querySelector('#splitCols').value = '2';
            m.querySelector('#splitRows').value = '1';
            m.querySelector('#splitMerge').checked = false;
        }
        function ctxDeleteCell(){
            const cell = window.__ctxCell; if(!cell) return;
            const row = cell.parentElement;
            cell.remove();
            if(row.children.length===0) row.remove();
        }
        function deleteField(btn){
            const panel = btn.closest('.fields-panel');
            btn.closest('.field-block').remove();
            syncFieldsJSON(panel);
        }
        function bindFieldDrag(block){
            const type = (block.getAttribute('data-type')||'').toLowerCase();
            if(!['text','question'].includes(type)) return;
            const handle = block.querySelector('.drag-handle');
            if(!handle) return;
            const list = block.closest('.fields-panel')?.querySelector('.field-list');
            if(!list) return;
            block.setAttribute('draggable','false');
            function enableDrag(){ block.setAttribute('draggable','true'); block.dataset.dragAllowed='1'; }
            function disableDrag(){ block.setAttribute('draggable','false'); delete block.dataset.dragAllowed; }
            handle.addEventListener('mousedown', enableDrag);
            handle.addEventListener('touchstart', enableDrag, {passive:true});
            handle.setAttribute('draggable','true');
            handle.addEventListener('dragstart', (e)=>{
                enableDrag();
                window.__dragField = block;
                block.classList.add('dragging');
                e.dataTransfer.effectAllowed='move';
                try{ e.dataTransfer.setData('text/plain','field'); }catch(_){}
            });
            handle.addEventListener('dragend', ()=>{
                block.classList.remove('dragging');
                const ph = list.__dropPlaceholder;
                if(ph && ph.parentNode) ph.parentNode.removeChild(ph);
                window.__dragField = null;
                disableDrag();
            });
            block.addEventListener('dragstart', (e)=>{
                if(block.dataset.dragAllowed !== '1'){ e.preventDefault(); disableDrag(); return; }
                window.__dragField = block;
                block.classList.add('dragging');
                e.dataTransfer.effectAllowed='move';
                try{ e.dataTransfer.setData('text/plain','field'); }catch(_){}
            });
            block.addEventListener('dragend', ()=>{
                block.classList.remove('dragging');
                const ph = list.__dropPlaceholder;
                if(ph && ph.parentNode) ph.parentNode.removeChild(ph);
                window.__dragField = null;
                disableDrag();
            });
            if(!list.__dndBound){
                list.__dndBound = true;
                list.addEventListener('dragover', (e)=>{
                    if(!window.__dragField) return;
                    e.preventDefault();
                    const ph = list.__dropPlaceholder || (list.__dropPlaceholder = Object.assign(document.createElement('div'), {className:'drop-placeholder'}));
                    const before = getFieldDropBefore(list, e.clientY);
                    if(before==null){ list.appendChild(ph); } else { list.insertBefore(ph, before); }
                });
                list.addEventListener('drop', (e)=>{
                    if(!window.__dragField) return;
                    e.preventDefault();
                    const before = getFieldDropBefore(list, e.clientY);
                    if(before==null){ list.appendChild(window.__dragField); } else { list.insertBefore(window.__dragField, before); }
                    const ph = list.__dropPlaceholder;
                    if(ph && ph.parentNode) ph.parentNode.removeChild(ph);
                    const panel = list.closest('.fields-panel');
                    syncFieldsJSON(panel);
                    window.__dragField = null;
                });
            }
        }
        function getFieldDropBefore(list, y){
            const els = [...list.querySelectorAll('.field-block:not(.dragging)')].filter(el=> (el.getAttribute('data-type')||'')!=='reflection');
            for(let i=0;i<els.length;i++){
                const box = els[i].getBoundingClientRect();
                if(y < box.top + box.height/2) return els[i];
            }
            return null;
        }
        function setupDefaultOptions(block){
            const type = block.querySelector('.q-type') ? block.querySelector('.q-type').value : 'multiple_choice';
            const options = block.querySelector('.q-options');
            options.innerHTML = '';
            const oldGuide = block.querySelector('.q-correct-guide');
            if(oldGuide) oldGuide.remove();
            function addGuide(text){
                const g = document.createElement('div');
                g.className = 'q-correct-guide';
                g.style.cssText = 'color:#64748b;font-size:.85rem;margin:6px 0 4px 0;';
                g.textContent = text;
                options.parentElement.insertBefore(g, options);
            }
            if(type === 'multiple_choice'){
                addGuide('Mark the circle for the correct answer.');
                addOptionRow(options, 'Choice A');
                addOptionRow(options, 'Choice B');
                addOptionRow(options, 'Choice C');
                addOptionRow(options, 'Choice D');
                ensureAddOptionLink(options);
            } else if(type === 'true_false'){
                addGuide('Mark the circle for the correct answer.');
                addOptionRow(options, 'True');
                addOptionRow(options, 'False');
            } else if(type === 'identification'){
                const box = document.createElement('div');
                box.className = 'q-blanks';
                options.appendChild(box);
                addBlankAnswerRow(box, 'Answer 1');
                addBlankAnswerRow(box, 'Answer 2');
                ensureAddBlankLink(box);
            } else if(type === 'essay'){
                const ta = document.createElement('textarea');
                ta.className = 'q-essay';
                ta.rows = 3;
                ta.placeholder = 'Rubric or guidance (optional)';
                options.appendChild(ta);
            }
        }
        function addOptionRow(container, placeholder){
            const row = document.createElement('div');
            row.className = 'q-option-row';
            const block = container.closest('.field-block') || container.closest('.q-block');
            let group = 'correct-group';
            const fb = container.closest('.field-block');
            if (fb) {
                group = fb.getAttribute('data-correct') || group;
            }
            row.innerHTML = `
                <label style="display:flex;align-items:center;gap:8px;flex:1;">
                    <input type="radio" class="q-correct" name="${group}">
                    <input type="text" class="q-option" placeholder="${placeholder||'Add option'}">
                </label>
                <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="removeOptionRow(this)">X</button>
            `;
            container.appendChild(row);
            row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> {
                const panel = container.closest('.fields-panel');
                if(panel) syncFieldsJSON(panel);
            }));
            ensureAddOptionLink(container);
        }
        function ensureAddOptionLink(container){
            let link = container.querySelector('.add-option-link');
            if(!link){
                link = document.createElement('button');
                link.type='button';
                link.className='add-option-link';
                link.style.cssText='background:none;border:none;color:#0d6efd;cursor:pointer;text-align:left;padding:0;margin-top:4px;';
                link.textContent='Add option';
                link.addEventListener('click', ()=> {
                    addOptionRow(container, '');
                    const panel = container.closest('.fields-panel');
                    if(panel) syncFieldsJSON(panel);
                });
            }
            // Always move link to the end so it appears after the last choice
            container.appendChild(link);
        }
        function addMatchRow(container, leftPH, rightPH){
            const row = document.createElement('div');
            row.className = 'match-row';
            row.style.display = 'grid';
            row.style.gridTemplateColumns = '1fr 1fr auto';
            row.style.gap = '8px';
            row.innerHTML = `
                <input type="text" class="q-left" placeholder="${leftPH||'Left'}">
                <input type="text" class="q-right" placeholder="${rightPH||'Right'}">
                <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;">X</button>
            `;
            row.querySelector('button').addEventListener('click', ()=> {
                row.remove();
                const fp = container.closest('.fields-panel');
                if(fp) syncFieldsJSON(fp);
            });
            container.appendChild(row);
            const fp = container.closest('.fields-panel');
            row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> {
                if(fp) syncFieldsJSON(fp);
            }));
        }
        function ensureAddPairLink(container){
            if(container.querySelector('.add-pair-link')) return;
            const link = document.createElement('button');
            link.type='button';
            link.className='add-pair-link';
            link.style.cssText='background:none;border:none;color:#0d6efd;cursor:pointer;text-align:left;padding:0;margin-top:4px;';
            link.textContent='Add pair';
            link.addEventListener('click', ()=> {
                addMatchRow(container, 'Left', 'Right');
                const fp = container.closest('.fields-panel');
                if(fp) syncFieldsJSON(fp);
            });
            container.appendChild(link);
        }
        function addBlankAnswerRow(container, placeholder){
            const row = document.createElement('div');
            row.className = 'blank-row';
            row.style.display='grid';
            row.style.gridTemplateColumns='1fr auto';
            row.style.gap='8px';
            row.innerHTML = `
                <input type="text" class="q-blank-option" placeholder="${placeholder||'Acceptable answer'}">
                <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;">X</button>
            `;
            row.querySelector('button').addEventListener('click', ()=> {
                row.remove();
                const fp = container.closest('.fields-panel');
                if(fp) syncFieldsJSON(fp);
            });
            container.appendChild(row);
            const fp = container.closest('.fields-panel');
            row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> {
                if(fp) syncFieldsJSON(fp);
            }));
        }
        function ensureAddBlankLink(container){
            if(container.querySelector('.add-blank-link')) return;
            const link = document.createElement('button');
            link.type='button';
            link.className='add-blank-link';
            link.style.cssText='background:none;border:none;color:#0d6efd;cursor:pointer;text-align:left;padding:0;margin-top:4px;';
            link.textContent='Add answer';
            link.addEventListener('click', ()=> {
                addBlankAnswerRow(container, 'Answer');
                const fp = container.closest('.fields-panel');
                if(fp) syncFieldsJSON(fp);
            });
            container.appendChild(link);
        }
        function removeOptionRow(btn){
            const container = btn.closest('.q-options');
            btn.closest('.q-option-row').remove();
            const panel = container.closest('.fields-panel');
            if(panel) syncFieldsJSON(panel);
        }
        function syncFieldsJSON(panel){
            const blocks = panel.querySelectorAll('.field-block');
            const fields = [];
            blocks.forEach(b=>{
                const t = b.getAttribute('data-type');
                if(t === 'text'){
                    const html = b.querySelector('.editor').innerHTML;
                    fields.push({ type:'text', html });
                } else if(t === 'question'){
                    const qb = b.querySelector('.q-block');
                    const type = qb.querySelector('.q-type') ? qb.querySelector('.q-type').value : 'multiple_choice';
                    const title = qb.querySelector('.q-title').value || 'Untitled Question';
                    const required = false;
                    const q = { type, title, required };
                    if(type === 'multiple_choice' || type === 'true_false'){
                        const opts = Array.from(qb.querySelectorAll('.q-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                        q.options = opts.length ? opts : (type==='true_false' ? ['True','False'] : []);
                        const rows = Array.from(qb.querySelectorAll('.q-option-row'));
                        const answerIndex = rows.findIndex(r => r.querySelector('.q-correct') && r.querySelector('.q-correct').checked);
                        if(answerIndex >= 0) q.answer_index = answerIndex;
                    } else if(type === 'matching'){
                        const pairs = [];
                        qb.querySelectorAll('.q-matching .match-row').forEach(r=>{
                            const l = r.querySelector('.q-left')?.value || '';
                            const rt = r.querySelector('.q-right')?.value || '';
                            if(l || rt) pairs.push([l, rt]);
                        });
                        q.pairs = pairs;
                    } else if(type === 'fill_blank'){
                        const answers = Array.from(qb.querySelectorAll('.q-blanks .q-blank-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                        q.answers = answers;
                    } else if(type === 'essay'){
                        const rb = qb.querySelector('.q-essay')?.value || '';
                        if(rb) q.rubric = rb;
                    }
                    const fbC = qb.querySelector('.q-fb-correct')?.value || '';
                    const fbI = qb.querySelector('.q-fb-incorrect')?.value || '';
                    if(fbC) q.feedback_correct = fbC;
                    if(fbI) q.feedback_incorrect = fbI;
                    fields.push({ type:'question', question: q });
                } else if(t === 'exam'){
                    const duration = parseInt(b.querySelector('.exam-duration')?.value || '0', 10) || 0;
                    const list = b.querySelectorAll('.exam-q-list .q-item');
                    const qs = [];
                    list.forEach(node=>{
                        try{
                            const obj = JSON.parse(node.dataset.payload||'{}');
                            if(obj && obj.type && obj.text){ qs.push(obj); }
                        }catch(e){}
                    });
                    fields.push({ type:'exam', timer_minutes: duration, questions: qs });
                }
            });
            const textarea = panel.querySelector('textarea[name$="[fields_json]"]');
            textarea.value = JSON.stringify(fields);
        }
        function getSelectedSubjectAreas(){
            return Array.from(document.querySelectorAll('input[name="subject_area[]"]:checked'))
                .map(i => (i.value || '').trim())
                .filter(v => v !== '');
        }
        function updateSubjectAreaDropdownLabel(){
            const labelEl = document.getElementById('subjectAreaToggleLabel');
            if (!labelEl) return;
            const vals = getSelectedSubjectAreas();
            let label = 'Select Subject Area';
            if (vals.length === 1) label = vals[0];
            else if (vals.length === 2) label = vals.join(', ');
            else if (vals.length > 2) label = vals.slice(0, 2).join(', ') + ' +' + (vals.length - 2);
            labelEl.textContent = label;
        }
        function setSubjectAreaDropdownOpen(open){
            const dd = document.getElementById('subjectAreaDropdown');
            const btn = document.getElementById('subjectAreaToggle');
            if (!dd || !btn) return;
            const wrap = document.getElementById('subject_area_group');
            if (!wrap) return;
            if (open) {
                if (!dd.__origParent) {
                    dd.__origParent = dd.parentElement;
                    dd.__origNext = dd.nextSibling;
                }
                const r = btn.getBoundingClientRect();
                const margin = 8;
                dd.style.display = 'block';
                dd.style.position = 'fixed';
                dd.style.left = Math.max(12, Math.round(r.left)) + 'px';
                dd.style.top = Math.round(r.bottom + margin) + 'px';
                dd.style.width = Math.round(r.width) + 'px';
                dd.style.zIndex = '5000';
                const maxH = Math.max(180, window.innerHeight - (r.bottom + margin) - 16);
                dd.style.maxHeight = Math.round(maxH) + 'px';
                document.body.appendChild(dd);
            } else {
                dd.style.display = 'none';
                dd.style.position = '';
                dd.style.left = '';
                dd.style.top = '';
                dd.style.width = '';
                dd.style.zIndex = '';
                dd.style.maxHeight = '320px';
                if (dd.__origParent) {
                    dd.__origParent.insertBefore(dd, dd.__origNext || null);
                } else {
                    wrap.appendChild(dd);
                }
            }
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
        function bindSubjectAreaDropdown(){
            const wrap = document.getElementById('subject_area_group');
            const btn = document.getElementById('subjectAreaToggle');
            const dd = document.getElementById('subjectAreaDropdown');
            const doneBtn = document.getElementById('subjectAreaDoneBtn');
            if (!wrap || !btn) return;
            updateSubjectAreaDropdownLabel();
            btn.addEventListener('click', function(ev){
                ev.preventDefault();
                ev.stopPropagation();
                const isOpen = btn.getAttribute('aria-expanded') === 'true';
                setSubjectAreaDropdownOpen(!isOpen);
            });
            document.addEventListener('click', function(ev){
                if (btn.contains(ev.target)) return;
                if (dd && dd.contains(ev.target)) return;
                setSubjectAreaDropdownOpen(false);
            });
            document.addEventListener('keydown', function(ev){
                if (ev.key === 'Escape') setSubjectAreaDropdownOpen(false);
            });
            if (dd) {
                dd.addEventListener('click', function(ev){ ev.stopPropagation(); });
            }
            if (doneBtn) {
                doneBtn.addEventListener('click', function(ev){
                    ev.preventDefault();
                    ev.stopPropagation();
                    setSubjectAreaDropdownOpen(false);
                });
            }
            wrap.querySelectorAll('input[name="subject_area[]"]').forEach(cb => {
                cb.addEventListener('change', updateSubjectAreaDropdownLabel);
            });
        }
        function validateDetails(){
            let ok = true;
            const name = document.getElementById('name');
            const desc = document.getElementById('description');
            const subjGroup = document.getElementById('subject_area_group');
            const image = document.getElementById('image');
            const setError = (el, msgId, msg) => { const n = document.getElementById(msgId); if(msg){ n.style.display='block'; n.textContent = msg; el.setAttribute('aria-invalid', 'true'); } else { n.style.display='none'; n.textContent=''; el.removeAttribute('aria-invalid'); } };
            if(!name.value.trim() || name.value.length > 100){ ok = false; setError(name,'nameError','Name is required (max 100).'); } else setError(name,'nameError','');
            if(!desc.value.trim() || desc.value.length > 1000){ ok = false; setError(desc,'descError','Description is required, max 1000 characters.'); } else setError(desc,'descError','');
            if(getSelectedSubjectAreas().length === 0){ ok = false; setError(subjGroup,'subjectError','Select at least one subject area.'); } else setError(subjGroup,'subjectError','');
            setError(image,'imageError','');
            return ok;
        }
        function validateModules(){
            let ok = true;
            const modules = Array.from(document.querySelectorAll('.module-wrapper'));
            if(modules.length === 0){ ok = false; }
            modules.forEach((m,i)=>{
                const title = m.querySelector('.module-title-input');
                if(!title.value.trim() || title.value.length > 80){ ok = false; title.style.borderColor = '#dc2626'; } else title.style.borderColor = '#ddd';
                const topics = Array.from(m.querySelectorAll('.topic-row'));
                topics.forEach((t)=>{
                    const input = t.querySelector('input[type=text]');
                    if(!input.value.trim() || input.value.length > 80){ ok = false; input.style.borderColor = '#dc2626'; } else input.style.borderColor = '#ddd';
                });
                // Validate exam title if exam exists
                const examWrap = m.querySelector('.module-exam, .exam-wrapper');
                if(examWrap){
                    const titleInput = examWrap.querySelector('.exam-title');
                    if(titleInput && !titleInput.value.trim()){
                        ok = false;
                        titleInput.style.borderColor = '#dc2626';
                    } else if(titleInput){
                        titleInput.style.borderColor = '#e5e7eb';
                    }
                }
            });
            const err = document.getElementById('modulesError');
            if(!ok){ err.style.display='block'; err.textContent='Add at least one module with topic titles (max 80 chars). Ensure exam title is set when adding an exam.'; } else { err.style.display='none'; err.textContent=''; }
            return ok;
        }
        function isDetailsStepComplete(){
            const name = document.getElementById('name');
            const desc = document.getElementById('description');
            const image = document.getElementById('image');

            const validName = !!name && !!name.value.trim() && name.value.trim().length <= 100;
            const validDesc = !!desc && !!desc.value.trim() && desc.value.trim().length <= 1000;
            const validSubj = getSelectedSubjectAreas().length > 0;

            if (!validName || !validDesc || !validSubj) return false;

            if (image && image.required) {
                if (!image.files || !image.files[0]) return false;
                const f = image.files[0];
                const okType = !!f.type && f.type.startsWith('image/');
                const okSize = f.size <= 5 * 1024 * 1024;
                if (!okType || !okSize) return false;
            }

            return true;
        }
        function isModulesStepComplete(){
            return document.querySelectorAll('.module-wrapper').length > 0;
        }
        function isCertificateStepComplete(){
            return !!document.querySelector('input[name="certification_id"]:checked');
        }
        function isFinalizeStepComplete(){
            return isDetailsStepComplete() && isModulesStepComplete() && isCertificateStepComplete();
        }
        function updateProgress(){
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');
            const step4 = document.getElementById('step4');
            const progressFill = document.getElementById('courseProgressFill');
            const progressText = document.getElementById('courseProgressText');
            const detailsDone = isDetailsStepComplete();
            const modulesDone = isModulesStepComplete();
            const certificateDone = isCertificateStepComplete();
            const finalizeDone = isFinalizeStepComplete();

            step1.classList.toggle('done', detailsDone);
            step2.classList.toggle('done', modulesDone);
            step3.classList.toggle('done', certificateDone);
            step4.classList.toggle('done', finalizeDone);

            const completedCount = (detailsDone ? 1 : 0) + (modulesDone ? 1 : 0) + (certificateDone ? 1 : 0) + (finalizeDone ? 1 : 0);
            const percent = Math.round((completedCount / 4) * 100);
            if (progressFill) progressFill.style.width = `${percent}%`;
            if (progressText) progressText.textContent = `${percent}% complete (${completedCount}/4 steps)`;

            const tab2Btn = document.getElementById('tabBtn2');
            const tab3Btn = document.getElementById('tabBtn3');
            const tab4Btn = document.getElementById('tabBtn4');
            
            const enable2 = detailsDone;
            if (tab2Btn) {
                tab2Btn.classList.toggle('disabled', !enable2);
                tab2Btn.setAttribute('aria-disabled', enable2 ? 'false' : 'true');
                tab2Btn.setAttribute('tabindex', enable2 ? '0' : '-1');
            }

            const enable3 = detailsDone && modulesDone;
            if (tab3Btn) {
                tab3Btn.classList.toggle('disabled', !enable3);
                tab3Btn.setAttribute('aria-disabled', enable3 ? 'false' : 'true');
                tab3Btn.setAttribute('tabindex', enable3 ? '0' : '-1');
            }

            const enable4 = detailsDone && modulesDone && certificateDone;
            if (tab4Btn) {
                tab4Btn.classList.toggle('disabled', !enable4);
                tab4Btn.setAttribute('aria-disabled', enable4 ? 'false' : 'true');
                tab4Btn.setAttribute('tabindex', enable4 ? '0' : '-1');
            }
        }
        function switchTo(tab){
            if (tab === 4) renderSummary();

            [1,2,3,4].forEach(n => {
                const t = document.getElementById('tab' + n);
                const b = document.getElementById('tabBtn' + n);
                if (t) t.classList.toggle('active', tab === n);
                if (b) {
                    b.classList.toggle('active', tab === n);
                    b.setAttribute('aria-selected', tab === n ? 'true' : 'false');
                    if (tab === n) b.removeAttribute('tabindex');
                    else b.setAttribute('tabindex', '-1');
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        function renderSummary() {
            // Course Details
            document.getElementById('summaryName').textContent = document.getElementById('name').value || '(Untitled Course)';
            document.getElementById('summaryDescription').textContent = document.getElementById('description').value || '(No description)';
            const selectedSubjects = getSelectedSubjectAreas();
            document.getElementById('summarySubject').textContent = selectedSubjects.length ? selectedSubjects.join(', ') : '(No subject area)';
            
            // Image Preview
            const imgPreview = document.getElementById('imagePreview');
            const summaryImgPreview = document.getElementById('summaryImagePreview');
            if (imgPreview && imgPreview.querySelector('img')) {
                summaryImgPreview.innerHTML = `<img src="${imgPreview.querySelector('img').src}" style="width:100%; height:100%; object-fit:cover;">`;
            } else {
                summaryImgPreview.innerHTML = `<span style="color: #94a3b8;">No image</span>`;
            }

            // Modules
            const summaryModules = document.getElementById('summaryModules');
            summaryModules.innerHTML = '';
            const modules = document.querySelectorAll('.module-wrapper');
            if (modules.length === 0) {
                summaryModules.innerHTML = '<div style="color: #64748b; font-style: italic;">No modules added yet.</div>';
            } else {
                modules.forEach((m, i) => {
                    const title = m.querySelector('.module-title-input').value || `Module ${i+1}`;
                    const modDiv = document.createElement('div');
                    modDiv.className = 'summary-module';
                    let topicsHtml = '';
                    m.querySelectorAll('.topic-row').forEach(t => {
                        const tTitle = t.querySelector('input[name*="[title]"]').value || '(Untitled Topic)';
                        topicsHtml += `<div class="summary-topic">${tTitle}`;
                        t.querySelectorAll('.subtopic-row').forEach(s => {
                            const sTitle = s.querySelector('input[name*="[title]"]').value || '(Untitled Subtopic)';
                            topicsHtml += `<div class="summary-subtopic">• ${sTitle}</div>`;
                        });
                        topicsHtml += `</div>`;
                    });
                    modDiv.innerHTML = `<div class="summary-module-title">Module ${i+1}: ${title}</div>${topicsHtml}`;
                    summaryModules.appendChild(modDiv);
                });
            }

            // Certificate
            const summaryCert = document.getElementById('summaryCertificate');
            const selectedCert = document.querySelector('input[name="certification_id"]:checked');
            if (selectedCert) {
                const card = selectedCert.closest('.cert-card');
                const certName = card.querySelector('.cert-info div').textContent;
                const certImg = card.querySelector('.cert-preview img')?.src;
                summaryCert.innerHTML = `
                    <div class="summary-cert-preview" style="display: flex; align-items: center; gap: 16px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        ${certImg ? `<img src="${certImg}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb;">` : `<i class="fas fa-certificate" style="font-size:2rem; color:#e2e8f0;"></i>`}
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">${certName}</div>
                            <div style="font-size: 0.85rem; color: #64748b;">Selected Template</div>
                        </div>
                    </div>
                `;
            } else {
                summaryCert.innerHTML = '<div style="color: #64748b; font-style: italic;">No certificate selected.</div>';
            }
        }
        function ensureDefaultModule(){
            const container = document.getElementById('modulesContainer');
            if(container.children.length > 0) return;
            createModule();
        }
        function updateCertSelection(input) {
            document.querySelectorAll('.cert-card').forEach(card => {
                card.style.borderColor = '#e5e7eb';
                card.style.background = '#fff';
                const check = card.querySelector('.cert-check');
                if(check) check.style.visibility = 'hidden';
            });
            if(input.checked) {
                const card = input.closest('.cert-card');
                card.style.borderColor = '#0d6efd';
                card.style.background = '#f0f7ff';
                const check = card.querySelector('.cert-check');
                if(check) check.style.visibility = 'visible';
            }
            updateProgress();
        }
        function bindTabs(){
            const b1 = document.getElementById('tabBtn1');
            const b2 = document.getElementById('tabBtn2');
            const b3 = document.getElementById('tabBtn3');
            const b4 = document.getElementById('tabBtn4');
            b1 && b1.addEventListener('click', ()=> switchTo(1));
            b2 && b2.addEventListener('click', ()=> { if(validateDetails()) switchTo(2); });
            b3 && b3.addEventListener('click', ()=> { if(validateDetails() && validateModules()) switchTo(3); });
            b4 && b4.addEventListener('click', ()=> { if(validateDetails() && validateModules() && isCertificateStepComplete()) switchTo(4); });
            
            document.getElementById('backToDetails').addEventListener('click', ()=> switchTo(1));
            document.getElementById('backToModules').addEventListener('click', ()=> switchTo(2));
            document.getElementById('backToCertificate').addEventListener('click', ()=> switchTo(3));

            const nxtModules = document.getElementById('nextToModules');
            nxtModules && nxtModules.addEventListener('click', ()=> { if(validateDetails()){ switchTo(2); ensureDefaultModule(); } else { switchTo(1); } });
            const nxtCert = document.getElementById('nextToCertificate');
            nxtCert && nxtCert.addEventListener('click', ()=> { if(validateModules()){ switchTo(3); } else { switchTo(2); } });
            const nxtFinalize = document.getElementById('nextToFinalize');
            nxtFinalize && nxtFinalize.addEventListener('click', ()=> { if(isCertificateStepComplete()){ switchTo(4); } else { const err = document.getElementById('certError'); if(err) err.style.display = 'block'; } });

            ['name','description','image'].forEach(id=>{
                const el = document.getElementById(id);
                el && el.addEventListener('input', updateProgress);
                el && el.addEventListener('change', updateProgress);
            });
            document.querySelectorAll('input[name="subject_area[]"]').forEach(el => {
                el.addEventListener('change', updateProgress);
                el.addEventListener('change', updateSubjectAreaDropdownLabel);
            });
            document.getElementById('courseForm').addEventListener('submit', (e)=>{
                updateProgress();
                if(!validateDetails()) { e.preventDefault(); switchTo(1); return; }
                if(!validateModules()) { e.preventDefault(); switchTo(2); return; }
                if(!isCertificateStepComplete()) { 
                    e.preventDefault(); 
                    switchTo(3);
                    const err = document.getElementById('certError');
                    if(err) err.style.display = 'block';
                    return; 
                }
            });
            // Prevent accidental submit via Enter while editing exam inputs
            const form = document.getElementById('courseForm');
            form.addEventListener('keydown', function(ev){
                if(ev.key !== 'Enter') return;
                const inExam = ev.target.closest('.exam-wrapper') || ev.target.closest('.module-exam') || ev.target.classList.contains('exam-title') || ev.target.classList.contains('exam-desc') || ev.target.classList.contains('exam-duration') || ev.target.classList.contains('eq-text');
                if(inExam){
                    ev.preventDefault();
                }
            });
        }
        function serializeModules() {
            const modules = [];
            const container = document.getElementById('modulesContainer');
            if(!container) return modules;
            Array.from(container.children).forEach((m, i) => {
                try {
                    if (m.classList.contains('module-wrapper')) {
                        const titleInput = m.querySelector('.module-title-input');
                        const title = titleInput ? titleInput.value : '';
                        const topics = [];
                        m.querySelectorAll('.topic-row').forEach((t, j) => {
                            const tTitleInput = t.querySelector('input[name*="[title]"]');
                            const tTitle = tTitleInput ? tTitleInput.value : '';
                            const subtopics = [];
                            t.querySelectorAll('.subtopic-row').forEach((s, k) => {
                                const sTitleInput = s.querySelector('input[name*="[title]"]');
                                const sTitle = sTitleInput ? sTitleInput.value : '';
                                const fieldsArea = s.querySelector('textarea[name*="[fields_json]"]');
                                const fieldsJson = fieldsArea ? fieldsArea.value : '';
                                subtopics.push({ title: sTitle, fields_json: fieldsJson });
                            });
                            topics.push({ title: tTitle, subtopics: subtopics });
                        });
                        const examJsonArea = m.querySelector('.module-exam-json');
                        const examJson = examJsonArea ? examJsonArea.value : '';
                        modules.push({ type: 'module', title: title, topics: topics, exam_json: examJson });
                    } else if (m.classList.contains('exam-wrapper')) {
                        const examJsonArea = m.querySelector('.exam-json');
                        const examJson = examJsonArea ? examJsonArea.value : '';
                        modules.push({ type: 'exam', exam_json: examJson });
                    }
                } catch (err) {
                    console.error('Error serializing module/exam at index ' + i, err);
                }
            });
            return modules;
        }

        function restoreModules(modules) {
            const container = document.getElementById('modulesContainer');
            container.innerHTML = ''; // Clear existing
            
            if (!modules || !Array.isArray(modules)) return;

            modules.forEach((m, i) => {
                if (m.type === 'exam' || (!m.type && m.exam_json && !m.topics)) {
                    // Restore standalone exam
                    let examData = null;
                    try { examData = typeof m.exam_json === 'string' ? JSON.parse(m.exam_json) : m.exam_json; } catch(e) {}
                    createCourseExam(null, examData);
                } else {
                    // Restore module
                    createModule(); 
                    const wrapper = container.lastElementChild;
                    wrapper.querySelector('.module-title-input').value = m.title || '';
                    if (m.exam_json) {
                        wrapper.querySelector('.module-exam-json').value = m.exam_json;
                        // For nested module exams, ensure UI is initialized if it has data
                        let examData = null;
                        try { examData = typeof m.exam_json === 'string' ? JSON.parse(m.exam_json) : m.exam_json; } catch(e) {}
                        if (examData && examData.questions && examData.questions.length > 0) {
                            ensureModuleExam(wrapper, examData);
                        }
                    }

                    const topicsContainer = wrapper.querySelector('.topics');
                    if (m.topics && Array.isArray(m.topics)) {
                        m.topics.forEach((t, j) => {
                            addTopicInput(topicsContainer);
                            const topicRow = topicsContainer.lastElementChild;
                            topicRow.querySelector('input[name*="[title]"]').value = t.title || '';
                            
                            const subtopicsContainer = topicRow.querySelector('.subtopics');
                            if (t.subtopics && Array.isArray(t.subtopics)) {
                                t.subtopics.forEach((s, k) => {
                                    addSubtopicRow(topicRow); 
                                    const subRow = subtopicsContainer.lastElementChild;
                                    subRow.querySelector('input[name*="[title]"]').value = s.title || '';
                                    const fieldsArea = subRow.querySelector('textarea[name*="[fields_json]"]');
                                    fieldsArea.value = s.fields_json || '';
                                    
                                    const panel = subRow.querySelector('.fields-panel');
                                    if (s.fields_json) {
                                        try {
                                            const fields = JSON.parse(s.fields_json);
                                            if (Array.isArray(fields)) {
                                                fields.forEach(f => {
                                                    if (f.type === 'text') {
                                                        addTextField(panel);
                                                        const block = panel.querySelector('.field-block:last-child');
                                                        const editor = block.querySelector('.editor');
                                                        if (editor) editor.innerHTML = f.html || '';
                                                    } else if (f.type === 'question') {
                                                        addQuestionField(panel);
                                                        const block = panel.querySelector('.field-block:last-child');
                                                        const qTitle = block.querySelector('.q-title');
                                                        const qType = block.querySelector('.q-type');
                                                        if (qTitle) qTitle.value = f.question.title || '';
                                                        if (qType) {
                                                            qType.value = f.question.type || 'multiple_choice';
                                                            setupDefaultOptions(block); 
                                                            if (f.question.type === 'multiple_choice' && f.question.options) {
                                                                const optsDiv = block.querySelector('.q-options');
                                                                optsDiv.innerHTML = '';
                                                                f.question.options.forEach((opt, optIdx) => {
                                                                    const div = document.createElement('div');
                                                                    div.className = 'q-option-row';
                                                                    const isCorrect = f.question.correct_answer == optIdx;
                                                                    div.innerHTML = `<input type="radio" name="q-opt-${Date.now()}-${i}-${j}-${k}" ${isCorrect ? 'checked' : ''} disabled><input type="text" class="q-option" value="${opt.replace(/"/g, '&quot;')}" placeholder="Option"><button type="button" class="delete-btn" onclick="this.parentElement.remove(); syncFieldsJSON(this.closest('.fields-panel'))"><i class="fas fa-times"></i></button>`;
                                                                    optsDiv.appendChild(div);
                                                                });
                                                                const addBtn = document.createElement('button');
                                                                addBtn.type = 'button';
                                                                addBtn.className = 'btn-add-option';
                                                                addBtn.innerText = '+ Add Option';
                                                                addBtn.onclick = function() {
                                                                    const div = document.createElement('div');
                                                                    div.className = 'q-option-row';
                                                                    div.innerHTML = `<input type="radio" disabled><input type="text" class="q-option" placeholder="Option"><button type="button" class="delete-btn" onclick="this.parentElement.remove(); syncFieldsJSON(this.closest('.fields-panel'))"><i class="fas fa-times"></i></button>`;
                                                                    optsDiv.insertBefore(div, addBtn);
                                                                };
                                                                optsDiv.appendChild(addBtn);
                                                            } else if (f.question.type === 'true_false') {
                                                                const optsDiv = block.querySelector('.q-options');
                                                                if (optsDiv) {
                                                                    optsDiv.querySelectorAll('input[type="radio"]').forEach((r, rIdx) => {
                                                                        if ((f.question.answer === 'true' && rIdx === 0) || (f.question.answer === 'false' && rIdx === 1)) {
                                                                            r.checked = true;
                                                                        }
                                                                    });
                                                                }
                                                            } else if (f.question.type === 'identification') {
                                                                const ansInput = block.querySelector('.q-id-answer');
                                                                if (ansInput) ansInput.value = f.question.answer || '';
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                        } catch (e) {}
                                    }
                                });
                            }
                        });
                    }
                }
            });
            reindexModules();
        }

        // In case scripts load late in embedded iframe, ensure binding after load
        window.addEventListener('load', function(){ try{ bindTabs(); }catch(e){} });
        function draftKey(){ 
            // Use the key provided by the dashboard if we're editing a specific draft
            return sessionStorage.getItem('draft_course_key') || 'draft_course_edit_{{ $course->id }}'; 
        }
        function confirmGoToCertifications(url) {
            const modal = document.getElementById('confirmCertModal');
            const confirmBtn = document.getElementById('confirmCertBtn');
            modal.style.display = 'flex';
            confirmBtn.onclick = function() {
                // Save draft first without alert/redirect
                const form = document.getElementById('courseForm');
                const data = new FormData(form);
                const obj = {};
                data.forEach((v,k)=>{ if(!(v instanceof File)) obj[k]=v; });
                
                // Save image draft if present
                const imgPreview = document.getElementById('imagePreview');
                const imgTag = imgPreview ? imgPreview.querySelector('img') : null;
                if(imgTag && imgTag.src.startsWith('data:image')) {
                    obj['image_draft_data'] = imgTag.src;
                }
                
                localStorage.setItem(draftKey(), JSON.stringify(obj));
                
                // Navigate
                window.top.location.href = url;
            };
        }
        function closeConfirmCertModal() {
            document.getElementById('confirmCertModal').style.display = 'none';
        }
        function saveDraft(){
            try {
                const form = document.getElementById('courseForm');
                const data = new FormData(form);
                const obj = {};
                
                // Collect only non-module fields to avoid duplication
                data.forEach((v, k) => {
                    if (!(v instanceof File) && !k.startsWith('modules[')) {
                        if (k === 'subject_area[]') {
                            if (!Array.isArray(obj.subject_area)) obj.subject_area = [];
                            obj.subject_area.push(v);
                            return;
                        }
                        obj[k] = v;
                    }
                });
                
                // Save image draft if present
                const imgPreview = document.getElementById('imagePreview');
                const imgTag = imgPreview ? imgPreview.querySelector('img') : null;
                if(imgTag && imgTag.src.startsWith('data:image')) {
                    obj['image_draft_data'] = imgTag.src;
                }
                
                // Save modules correctly via serialization
                obj['modules'] = serializeModules();
                
                const key = draftKey();
                const json = JSON.stringify(obj);
                
                try {
                    localStorage.setItem(key, json);
                    document.getElementById('draftSavedModal').style.display = 'flex';
                } catch (e) {
                    if (e.name === 'QuotaExceededError' || e.name === 'NS_ERROR_DOM_QUOTA_REACHED') {
                        alert('Puno na ang storage ng iyong browser. Subukang magbura ng ibang drafts sa dashboard.');
                    } else {
                        throw e;
                    }
                }
            } catch (err) {
                console.error('Failed to save draft:', err);
                alert('Nagkaroon ng error sa pag-save ng draft: ' + err.message);
            }
        }
        function closeDraftSavedModal() {
            document.getElementById('draftSavedModal').style.display = 'none';
            // Redirect to dashboard and open modal
            window.top.location.href = "{{ route('dashboard') }}?open_drafts=1";
        }
        function restoreDraft(){
            const key = draftKey();
            const raw = localStorage.getItem(key);
            if(!raw) return;
            try{
                const obj = JSON.parse(raw);
                // Restore top-level fields
                ['name','description','video_url','certification_id'].forEach(k=>{
                    if(obj[k] === undefined) return;
                    const el = document.querySelector(`[name="${k}"]`);
                    if(!el) return;
                    el.value = obj[k];
                    if(k === 'certification_id') {
                        const input = document.querySelector(`input[name="certification_id"][value="${obj[k]}"]`);
                        if(input) {
                            input.checked = true;
                            updateCertSelection(input);
                        }
                    }
                });
                if (obj.subject_area !== undefined) {
                    const rawAreas = obj.subject_area;
                    const areas = Array.isArray(rawAreas)
                        ? rawAreas
                        : (typeof rawAreas === 'string' ? rawAreas.split(',').map(s => s.trim()).filter(Boolean) : []);
                    document.querySelectorAll('input[name="subject_area[]"]').forEach(cb => {
                        cb.checked = areas.includes(cb.value);
                    });
                }
                updateSubjectAreaDropdownLabel();
                setSubjectAreaDropdownOpen(false);
                
                // Restore image draft if present
                if(obj['image_draft_data']) {
                    const imgPreview = document.getElementById('imagePreview');
                    const imgDraftInput = document.getElementById('image_draft_data');
                    const fileNameDisplay = document.getElementById('fileNameDisplay');
                    if(imgPreview) {
                        imgPreview.innerHTML = `<img alt="preview" src="${obj['image_draft_data']}">`;
                    }
                    if(imgDraftInput) {
                        imgDraftInput.value = obj['image_draft_data'];
                    }
                    if(fileNameDisplay) {
                        fileNameDisplay.textContent = 'Restored from draft';
                    }
                }
                
                // Restore modules
                if(obj['modules']) {
                    restoreModules(obj['modules']);
                }
                
                updateProgress();
            }catch(e){}
        }
        function __bindAutosizeTextareas(root){
            const nodes = (root || document).querySelectorAll('textarea.q-autosize');
            nodes.forEach(function(el){
                if(el.__autosizeBound) return;
                el.__autosizeBound = true;
                const cs = window.getComputedStyle(el);
                const lh = parseFloat(cs.lineHeight) || 20;
                const min = Number(el.dataset.minLines || 3);
                const max = Number(el.dataset.maxLines || 10);
                const minH = Math.round(lh * min);
                const maxH = Math.round(lh * max);
                function fit(){
                    el.style.height = 'auto';
                    let h = el.scrollHeight;
                    if(h < minH) h = minH;
                    if(h > maxH) { h = maxH; el.style.overflowY = 'auto'; } else { el.style.overflowY = 'hidden'; }
                    el.style.height = h + 'px';
                }
                ['input','change','cut','paste','drop'].forEach(function(evt){
                    el.addEventListener(evt, function(){ setTimeout(fit,0); });
                });
                el.addEventListener('focus', fit);
                fit();
            });
        }
        document.addEventListener('DOMContentLoaded', function(){
            bindTabs();
            restoreDraft();
            bindSubjectAreaDropdown();
            updateProgress();
            __bindAutosizeTextareas(document);
            initDynamicMenu();
            
            const img = document.getElementById('image');
            if(img){
                img.addEventListener('change', function(){
                    const p = document.getElementById('imagePreview');
                    const draftInput = document.getElementById('image_draft_data');
                    const fileNameDisplay = document.getElementById('fileNameDisplay');
                    const f = img.files && img.files[0];
                    if(!f){ 
                        if (draftInput && draftInput.value) {
                            // Keep the draft image preview if no new file is chosen but one existed
                            if (fileNameDisplay) fileNameDisplay.textContent = 'Using draft image';
                        } else {
                            p.innerHTML = '<span style="color:#94a3b8;">No image selected</span>'; 
                            if (fileNameDisplay) fileNameDisplay.textContent = 'No file chosen';
                        }
                        return; 
                    }
                    if (fileNameDisplay) fileNameDisplay.textContent = f.name;
                    if(!(f.type && f.type.startsWith('image/')) || f.size > 5*1024*1024){
                        p.innerHTML = '<span style="color:#dc2626;">Invalid image. Use JPG/PNG/GIF/WebP ≤ 5MB.</span>';
                        const err = document.getElementById('imageError'); err.style.display='block'; err.textContent='Image must be JPG/PNG/GIF/WebP and ≤ 5MB.';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = e => { p.innerHTML = '<img alt="preview" src="'+e.target.result+'">'; };
                    reader.readAsDataURL(f);
                    const err = document.getElementById('imageError'); err.style.display='none'; err.textContent='';
                });
            }

            const existing = {!! json_encode($course->modules ?? [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!};
            populateExistingModules(existing);
            // Ensure the Modules Management tab is active with a default layout similar to create view
            try{ switchTo(2); }catch(e){}
            try{ ensureDefaultModule(); }catch(e){}
            // Ensure a Course Exam wrapper exists for editing even if not previously created
            const container = document.getElementById('modulesContainer');
            if(container && !container.querySelector('.exam-wrapper')){
                try{ createCourseExam(null); }catch(e){}
            }
        });
        let DM_STATE = { el: null, currentAnchor: null, menuTrigger: null, hovering: false, hoverTimer: null, raf: null, lastPos: {x: -1, y: -1} };
        function initDynamicMenu(){
            const dm = document.getElementById('dynamicMenu');
            DM_STATE.el = dm;
            dm.style.transform = 'translate(-9999px, -9999px)';
            dm.setAttribute('aria-hidden','true');
            DM_STATE.animTimer = null;
            function disableAnimTemporarily(){
                dm.classList.add('no-anim');
                if(DM_STATE.animTimer) clearTimeout(DM_STATE.animTimer);
                DM_STATE.animTimer = setTimeout(()=> dm.classList.remove('no-anim'), 150);
            }
            const trigger = document.getElementById('dmTrigger');
            const panel = document.getElementById('dmPanel');
            function openPanel(){
                if(!panel || !trigger) return;
                panel.classList.add('open');
                panel.setAttribute('aria-hidden','false');
                trigger.setAttribute('aria-expanded','true');
                requestDMReposition();
            }
            function closePanel(){
                if(!panel || !trigger) return;
                panel.classList.remove('open');
                panel.setAttribute('aria-hidden','true');
                trigger.setAttribute('aria-expanded','false');
                requestDMReposition();
            }
            if(trigger && panel){
                trigger.addEventListener('click', (e)=>{
                    e.stopPropagation();
                    if(panel.classList.contains('open')) closePanel(); else openPanel();
                });
            }
            document.addEventListener('click', (e)=>{
                if(!dm.contains(e.target) && panel && trigger) closePanel();
                const anchor = resolveAnchorFromTarget(e.target);
                const fromAddBtn = !!(e.target && e.target.closest && e.target.closest('.panel-add-btn'));
                if(!anchor && !dm.contains(e.target) && !fromAddBtn) {
                    clearActiveAnchor();
                }
            });
            dm.addEventListener('keydown', (e)=>{
                if(e.key === 'Escape') {
                    if(panel && trigger){
                        closePanel();
                        trigger.focus();
                    }
                }
            });
            dm.addEventListener('keydown', (e)=>{
                if((e.key === 'Enter' || e.key === ' ') && e.target.classList.contains('dm-btn')){
                    e.preventDefault();
                    e.target.click();
                }
            });
            dm.addEventListener('mouseenter', ()=>{});
            dm.addEventListener('mouseleave', ()=>{});
            document.addEventListener('focusin', (e)=>{
                const fromAddBtn = !!(e.target && e.target.closest && e.target.closest('.panel-add-btn'));
                if(fromAddBtn){
                    updateDMEditingMode(e.target);
                    return;
                }
                const anchor = resolveAnchorFromTarget(e.target);
                if(anchor) {
                    setActiveAnchor(anchor, { showMenu: false });
                }
                updateDMEditingMode(e.target);
            });
            document.addEventListener('focusout', ()=>{
                setTimeout(()=> updateDMEditingMode(document.activeElement), 0);
            });
            document.addEventListener('click', (e)=>{
                const fromAddBtn = !!(e.target && e.target.closest && e.target.closest('.panel-add-btn'));
                if(fromAddBtn){
                    updateDMEditingMode(e.target);
                    return;
                }
                const anchor = resolveAnchorFromTarget(e.target);
                if(anchor) {
                    setActiveAnchor(anchor, { showMenu: false });
                }
                updateDMEditingMode(e.target);
            });
            const onScrollOrResize = ()=> { disableAnimTemporarily(); requestDMReposition(); };
            window.addEventListener('resize', onScrollOrResize, {passive:true});
            document.addEventListener('scroll', onScrollOrResize, {passive:true, capture:true});
            document.addEventListener('wheel', onScrollOrResize, {passive:true, capture:true});
            document.addEventListener('touchmove', onScrollOrResize, {passive:true, capture:true});
            document.addEventListener('keydown', (e)=> {
                if(['PageDown','PageUp','ArrowDown','ArrowUp','Home','End',' '].includes(e.key)){
                    disableAnimTemporarily();
                    requestDMReposition();
                }
            }, {capture:true});
            const mo = new MutationObserver((mutations)=>{
                for(const m of mutations){
                    for(const node of m.addedNodes){
                        if(!(node instanceof HTMLElement)) continue;
                        if(node.matches && (node.matches('.field-block, .q-title, .q-option, .editor, .module-title-input') || node.querySelector('.field-block'))){
                            if(document.activeElement && node.contains(document.activeElement)){
                                const anchor = resolveAnchorFromTarget(document.activeElement);
                                if(anchor){ setActiveAnchor(anchor, { showMenu: false }); }
                            }
                        }
                    }
                }
            });
            mo.observe(document.body, {childList:true, subtree:true});
        }
        function resolveAnchorFromTarget(target){
            if(!(target instanceof HTMLElement)) return null;
            if(target.closest('[disabled], [aria-disabled="true"]')) return null;
            let field = target.closest('.field-block');
            if(field) return field;
            const subRow = target.closest('.subtopic-row');
            if(subRow) return subRow;
            const topicRow = target.closest('.topic-row');
            if(topicRow) return topicRow;
            const moduleHeader = target.closest('.module-header');
            if(moduleHeader) return moduleHeader;
            return null;
        }
        function setActiveAnchor(anchor, opts){
            if(!anchor || !isVisible(anchor)) { hideDM(); return; }
            const options = opts || {};
            document.querySelectorAll('.active-section').forEach(el=> el.classList.remove('active-section'));
            anchor.classList.add('active-section');
            DM_STATE.currentAnchor = anchor;
            if(Object.prototype.hasOwnProperty.call(options, 'menuTrigger')){
                DM_STATE.menuTrigger = options.menuTrigger || null;
            }
            DM_STATE.lastPos = {x:-1, y:-1};
            positionDM();
            if(options.showMenu !== true){
                DM_STATE.menuTrigger = null;
                hideDM();
                return;
            }
            showDM(anchor);
        }
        function clearActiveAnchor(){
            document.querySelectorAll('.active-section').forEach(el=> el.classList.remove('active-section'));
            DM_STATE.currentAnchor = null;
            DM_STATE.menuTrigger = null;
            hideDM();
        }
        function isVisible(el){
            const rects = el.getClientRects();
            if(!rects || rects.length === 0) return false;
            const style = window.getComputedStyle(el);
            if(style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') return false;
            return true;
        }
        function positionDM(){
            const dm = DM_STATE.el;
            if(!DM_STATE.currentAnchor || !isVisible(DM_STATE.currentAnchor)) return;
            const margin = 12;
            const rect = DM_STATE.currentAnchor.getBoundingClientRect();
            const dmRect = dm.getBoundingClientRect();
            const viewportLeft = window.scrollX;
            const viewportRight = window.scrollX + window.innerWidth;
            const viewportTop = window.scrollY;
            const viewportBottom = window.scrollY + window.innerHeight;

            let targetX;
            let targetY;
            if(DM_STATE.menuTrigger && isVisible(DM_STATE.menuTrigger)){
                const tRect = DM_STATE.menuTrigger.getBoundingClientRect();
                targetX = tRect.left + window.scrollX;
                targetY = tRect.bottom + 8 + window.scrollY;
            }else{
                targetX = viewportRight - dmRect.width - margin;
                targetY = rect.top + rect.height/2 - dmRect.height/2 + window.scrollY;
            }
            targetX = Math.max(viewportLeft + margin, Math.min(targetX, viewportRight - dmRect.width - margin));
            targetY = Math.max(viewportTop + margin, Math.min(targetY, viewportBottom - dmRect.height - margin));
            const roundX = Math.round(targetX);
            const roundY = Math.round(targetY);
            if(DM_STATE.lastPos.x === roundX && DM_STATE.lastPos.y === roundY) return;
            DM_STATE.lastPos = {x: roundX, y: roundY};
            dm.style.transform = `translate(${roundX}px, ${roundY}px)`;
        }
        function requestDMReposition(){
            if(DM_STATE.raf) return;
            DM_STATE.raf = requestAnimationFrame(()=>{
                DM_STATE.raf = null;
                positionDM();
            });
        }
        function openRailFromAdd(btn, event){
            if(event){
                event.preventDefault();
                event.stopPropagation();
            }
            const isVisible = !!(DM_STATE.el && DM_STATE.el.classList.contains('visible'));
            if(isVisible && DM_STATE.menuTrigger === btn){
                clearActiveAnchor();
                return;
            }
            const anchor = btn.closest('.subtopic-row') || btn.closest('.topic-row') || btn.closest('.module-header');
            if(anchor){
                setActiveAnchor(anchor, { showMenu: true, menuTrigger: btn });
            }else{
                DM_STATE.menuTrigger = btn;
                showDM(document.querySelector('.topic-row') || document.querySelector('.module-header') || document.body);
            }
            if(DM_STATE.el){
                DM_STATE.el.classList.remove('is-editing');
            }
        }
        function updateDMEditingMode(target){
            const dm = DM_STATE.el;
            if(!dm){ return; }
            const editable = target instanceof HTMLElement
                ? target.closest('input[type="text"], textarea, [contenteditable="true"], .module-title-input, .q-title, .q-option')
                : null;
            if(editable && DM_STATE.currentAnchor && DM_STATE.currentAnchor.contains(editable)){
                dm.classList.add('is-editing');
            }else{
                dm.classList.remove('is-editing');
            }
        }
        function showDM(anchor){
            const dm = DM_STATE.el;
            dm.style.zIndex = '2000';
            dm.classList.add('visible');
            dm.setAttribute('aria-hidden','false');
            updateDMEditingMode(document.activeElement);
            requestDMReposition();
        }
        function hideDM(){
            const dm = DM_STATE.el;
            dm.classList.remove('visible');
            dm.classList.remove('is-editing');
            dm.setAttribute('aria-hidden','true');
        }
        function dmAddTextInput(){ 
            const sel = document.querySelector('.field-block.selected-field');
            if(sel){
                const btn = sel.querySelector('.inline-add button:first-child');
                if(btn) return addTextFieldAfter(btn);
            }
            const anchor = DM_STATE.currentAnchor;
            let panel = anchor?.closest('.subtopic-row')?.querySelector('.fields-panel')
                    || anchor?.querySelector?.('.fields-panel')
                    || anchor?.closest('.topic-row')?.querySelector('.subtopic-row:last-of-type .fields-panel')
                    || document.querySelector('.fields-panel');
            if(!panel && anchor?.closest('.topic-row')){
                addSubtopicRow(anchor.closest('.topic-row'));
                panel = anchor.closest('.topic-row').querySelector('.subtopic-row:last-of-type .fields-panel');
            }
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                setSelectedField(last);
                if(last) setActiveAnchor(last);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function dmAddImageUpload(){
            const anchor = DM_STATE.currentAnchor;
            let panel = anchor?.closest('.subtopic-row')?.querySelector('.fields-panel')
                    || anchor?.querySelector?.('.fields-panel')
                    || anchor?.closest('.topic-row')?.querySelector('.subtopic-row:last-of-type .fields-panel')
                    || document.querySelector('.fields-panel');
            if(!panel && anchor?.closest('.topic-row')){
                addSubtopicRow(anchor.closest('.topic-row'));
                panel = anchor.closest('.topic-row').querySelector('.subtopic-row:last-of-type .fields-panel');
            }
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                const input = last.querySelector('input[type=file]:not([data-video])');
                if(input) input.click();
                setSelectedField(last);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function dmAddVideoUpload(){
            const anchor = DM_STATE.currentAnchor;
            let panel = anchor?.closest('.subtopic-row')?.querySelector('.fields-panel')
                    || anchor?.querySelector?.('.fields-panel')
                    || anchor?.closest('.topic-row')?.querySelector('.subtopic-row:last-of-type .fields-panel')
                    || document.querySelector('.fields-panel');
            if(!panel && anchor?.closest('.topic-row')){
                addSubtopicRow(anchor.closest('.topic-row'));
                panel = anchor.closest('.topic-row').querySelector('.subtopic-row:last-of-type .fields-panel');
            }
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                const input = last.querySelector('input[type=file][data-video]');
                if(input) input.click();
                setSelectedField(last);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function ensureModuleExam(wrapper, prefill){
            const body = wrapper.querySelector('.module-body');
            const host = body.querySelector('.module-exam');
            const hidden = body.querySelector('.module-exam-json');
            if(host.dataset.bound==='1') return host;
            host.dataset.bound = '1';
            host.innerHTML = `
                <div class="q-block">
                    <div class="q-header exam-meta-row">
                        <label class="exam-meta-timer">
                            <span class="exam-meta-timer-label">Timer (minutes)</span>
                            <input type="number" min="1" max="600" class="exam-duration exam-meta-timer-input" placeholder="e.g., 30">
                        </label>
                        <div class="exam-meta-title">Exam</div>
                    </div>
                    <div class="exam-questions" style="margin-top:10px">
                        <div class="exam-nav" style="display:flex;align-items:center;gap:8px;overflow-x:auto;padding:8px;border:1px solid #e5e7eb;border-radius:10px;background:#f8fafc;">
                            <div class="nav-track" style="display:flex;align-items:center;gap:6px;flex:1;min-width:0;"></div>
                        </div>
                        <div class="exam-q-list" style="display:none"></div>
                        <div class="exam-q-builder" style="margin-top:10px;border-top:1px dashed #e5e7eb;padding-top:10px">
                            <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:32px;align-items:end">
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                                    <textarea class="eq-text q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;" required></textarea>
                                </label>

                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                                    <select class="eq-type">
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="identification">Identification</option>
                                        <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
                                <option value="enumeration">Enumeration</option>
                                    </select>
                                </label>
                            </div>
                            <div class="eq-choices" style="margin-top:8px"></div>
                            <div class="eq-id" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <input class="eq-id-answer" type="text" placeholder="Enter answer" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px" required>
                            </div>
                            <div class="eq-tf" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <select class="eq-tf-answer" style="padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="eq-points" style="margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Points</label>
                                <input class="eq-common-points" type="number" min="1" step="0.01" placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-essay" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Points</label>
                                <input class="eq-essay-points" type="number" min="1" step="0.01" placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-enum" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Correct Answers</label>
                                <div class="eq-enum-answers" style="display:grid;gap:8px"></div>
                                <button type="button" class="btn btn-small eq-enum-add" style="margin-top:8px;background:#eef2ff;color:#0f3b8f;border:1px solid #c7d2fe;border-radius:8px;padding:8px 12px">Add Answer</button>
                                <label class="q-label" style="margin:10px 0 6px">Points</label>
                                <input class="eq-enum-points" type="number" min="1" step="0.01" placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                    <div class="actions" style="display:flex;justify-content:center;gap:8px;margin-top:10px">
                        <button type="button" class="btn btn-small eq-add" style="background:#0f3b8f;color:#fff;border:none;border-radius:8px;padding:8px 12px"><i class="fas fa-plus" style="margin-right:6px"></i> Add Question</button>
                        <button type="button" class="btn btn-small eq-del" style="background:#dc3545;color:#fff;border:none;border-radius:8px;padding:8px 12px;opacity:.45;cursor:default" disabled onclick="deleteActiveExamQuestion(this)">Delete</button>
                    </div>
                        </div>
                    </div>
                </div>
            `;
            __bindAutosizeTextareas(host);
            function renderChoices(){
                const wrap = host.querySelector('.eq-choices');
                wrap.innerHTML = '';
                const group = 'exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
                ['Choice A','Choice B','Choice C','Choice D'].forEach((ph,i)=>{
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.innerHTML = `
                        <label style="display:flex;align-items:center;gap:8px;flex:1;">
                            <input type="radio" class="eq-correct" name="${group}" value="${i}">
                            <input type="text" class="eq-option" placeholder="${ph}">
                        </label>
                    `;
                    wrap.appendChild(row);
                });
            }
            function renderEnumerationAnswers(values){
                const wrap = host.querySelector('.eq-enum-answers');
                if(!wrap) return;
                wrap.innerHTML = '';
                const entries = Array.isArray(values) && values.length ? values : ['', ''];
                entries.forEach(value=>{
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.innerHTML = `
                        <input type="text" class="eq-enum-answer" placeholder="Correct answer" value="${String(value || '').replace(/"/g,'&quot;')}" style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                        <button type="button" class="btn btn-small eq-enum-remove" style="background:#e5e7eb;color:#111827;border-radius:8px;padding:8px 12px">Remove</button>
                    `;
                    wrap.appendChild(row);
                });
            }
            renderChoices();
            function syncBuilderBoxes(){
                const t = host.querySelector('.eq-type').value;
                host.querySelector('.eq-choices').style.display = (t==='multiple_choice') ? 'block':'none';
                host.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                host.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                host.querySelector('.eq-points').style.display = (t==='essay' || t==='enumeration') ? 'none':'block';
                host.querySelector('.eq-essay').style.display = (t==='essay') ? 'block':'none';
                host.querySelector('.eq-enum').style.display = (t==='enumeration') ? 'block':'none';
                // Toggle required attributes to match type
                const qText = host.querySelector('.eq-text');
                const idAns = host.querySelector('.eq-id-answer');
                if(qText){ qText.required = true; }
                if(idAns){ idAns.required = (t==='identification'); }
                if(t==='multiple_choice' && host.querySelectorAll('.eq-option').length===0){ renderChoices(); }
                if(t==='enumeration' && host.querySelectorAll('.eq-enum-answer').length===0){ renderEnumerationAnswers(); }
            }
            host.addEventListener('click', function(e){
                const addBtn = e.target.closest('.eq-enum-add');
                if(addBtn){
                    e.preventDefault();
                    const current = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    current.push('');
                    renderEnumerationAnswers(current);
                    syncExamJSON();
                    return;
                }
                const removeBtn = e.target.closest('.eq-enum-remove');
                if(removeBtn){
                    e.preventDefault();
                    const current = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    const row = removeBtn.closest('.q-option-row');
                    const idx = Array.from(host.querySelectorAll('.eq-enum-answers .q-option-row')).indexOf(row);
                    const next = current.filter((_, i)=> i !== idx);
                    renderEnumerationAnswers(next.length ? next : ['', '']);
                    syncExamJSON();
                }
            });
            function syncExamJSON(){
                const duration = parseInt(host.querySelector('.exam-duration')?.value || '0', 10) || 0;
                const list = host.querySelectorAll('.exam-q-list .q-item');
                const qs = [];
                list.forEach(node=>{
                    try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && obj.text){ qs.push(obj); } }catch(e){}
                });
                hidden.value = JSON.stringify({ timer_minutes: duration, questions: qs });
            }
            host.querySelector('.eq-type').addEventListener('change', ()=>{ syncBuilderBoxes(); syncExamJSON(); });
            host.addEventListener('input', syncExamJSON);
            host.addEventListener('change', syncExamJSON);
            host.querySelector('.eq-add').addEventListener('click', function(){
                const t = host.querySelector('.eq-type').value;
                const text = (host.querySelector('.eq-text').value||'').trim();
                if(!text){ alert('Please enter a question.'); return; }
                let obj = null;
                if(t==='multiple_choice'){
                    const opts = Array.from(host.querySelectorAll('.eq-option')).map(i=>i.value.trim()).filter(Boolean);
                    if(opts.length<2){ alert('Please add at least two choices.'); return; }
                    const checked = host.querySelector('.eq-correct:checked');
                    if(!checked){ alert('Please mark the correct choice.'); return; }
                    const ans = parseInt(checked.value,10);
                    const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'multiple_choice', text, choices: opts, answer_index: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='identification'){
                    const ans = (host.querySelector('.eq-id-answer').value||'').trim();
                    if(!ans){ alert('Please enter the answer for Identification.'); return; }
                    const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'identification', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='true_false'){
                    const ans = host.querySelector('.eq-tf-answer').value === 'true';
                    const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'true_false', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='essay'){
                    const maxPointsVal = host.querySelector('.eq-essay-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'essay', text, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='enumeration'){
                    const answers = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=>i.value.trim()).filter(Boolean);
                    if(!answers.length){ alert('Please add at least one correct answer.'); return; }
                    const maxPointsVal = host.querySelector('.eq-enum-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'enumeration', text, answers, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }
                const listEl = host.querySelector('.exam-q-list');
                const idx = listEl.children.length + 1;
                const node = document.createElement('div');
                node.className = 'q-item';
                node.setAttribute('data-question-index', String(idx-1));
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx+'. '+obj.text+'</div>'
                    + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>'
                    + '<button type="button" class="btn btn-small" style="background:#dc3545;margin-top:6px" onclick="removeExamItem(this)">Delete</button>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                host.querySelector('.eq-text').value='';
                host.querySelectorAll('.eq-option').forEach(i=> i.value='');
                host.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                host.querySelector('.eq-id-answer').value='';
                host.querySelector('.eq-tf-answer').value='true';
                const commonPoints = host.querySelector('.eq-common-points'); if(commonPoints) commonPoints.value='';
                const essayPoints = host.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value='';
                renderEnumerationAnswers();
                const enumPoints = host.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value='';
                syncExamJSON();
                updateExamNavigator.call(host.closest('.exam-wrapper'));
                setActiveExamIndex(listEl.children.length);
            });
            syncBuilderBoxes(); syncExamJSON();

            if(prefill){
                try{
                    host.querySelector('.exam-duration').value = prefill.timer_minutes || '';
                    const listEl = host.querySelector('.exam-q-list');
                    listEl.innerHTML = '';
                    (prefill.questions||[]).forEach((q, i2)=>{
                        const node = document.createElement('div');
                        node.className = 'q-item';
                        node.setAttribute('data-question-index', String(i2));
                        node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(i2+1)+'. '+(q.text||q.title||'')+'</div>'
                            + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>'
                            + '<button type="button" class="btn btn-small" style="background:#dc3545;margin-top:6px" onclick="removeExamItem(this)">Delete</button>';
                        node.dataset.payload = JSON.stringify(q);
                        listEl.appendChild(node);
                    });
                    if(typeof updateExamNavigator === 'function'){
                        updateExamNavigator.call(wrapper);
                    }
                    syncExamJSON();
                    if(prefill.questions && prefill.questions.length > 0) setActiveExamIndex(0);
                }catch(e){}
            }
            return host;
        }

        function removeExamItem(btn){
            const node = btn.closest('.q-item');
            const listEl = node.parentElement;
            const wrap = btn.closest('.exam-wrapper') || btn.closest('.module-wrapper');
            node.remove();
            Array.from(listEl.children).forEach((n,i)=>{
                const t = n.querySelector('.qi-title');
                if(t){
                    const payload = JSON.parse(n.dataset.payload||'{}');
                    t.textContent = (i+1)+'. '+(payload.text||'');
                    n.setAttribute('data-question-index', String(i));
                }
            });
            if(typeof updateExamNavigator === 'function'){
                updateExamNavigator.call(wrap);
            }
            // Trigger sync
            const host = wrap.querySelector('.module-exam') || wrap;
            if(host.dataset.bound==='1'){
                const hidden = host.querySelector('.module-exam-json') || wrap.querySelector('.exam-json');
                const duration = parseInt(host.querySelector('.exam-duration')?.value || '0', 10) || 0;
                const qs = [];
                listEl.querySelectorAll('.q-item').forEach(it=>{
                    try{ const obj = JSON.parse(it.dataset.payload||'{}'); if(obj.text) qs.push(obj); }catch(e){}
                });
                if(hidden) hidden.value = JSON.stringify({ timer_minutes: duration, questions: qs });
            }
            setActiveExamIndex(0);
        }
        function openCorrectAnswerModal(wrap, proceed){
            window.__correctWrap = wrap;
            window.__correctProceed = proceed;
            const m = document.getElementById('correctModal');
            const list = m.querySelector('.cm-list');
            list.innerHTML = '';
            const opts = Array.from(wrap.querySelectorAll('.eq-option')).map((i,idx)=> ({ text:(i.value||['Choice A','Choice B','Choice C','Choice D'][idx]), idx }));
            opts.forEach(o=>{
                const row = document.createElement('label');
                row.style.cssText = 'display:flex;align-items:center;gap:8px;padding:6px';
                row.innerHTML = `<input type="radio" name="cm-choice" value="${o.idx}"><span>${o.text}</span>`;
                list.appendChild(row);
            });
            m.style.display='flex';
        }
        function correctModalOK(){
            const m = document.getElementById('correctModal');
            const sel = m.querySelector('input[name="cm-choice"]:checked');
            if(!sel) return;
            const wrap = window.__correctWrap;
            const radios = Array.from(wrap.querySelectorAll('.eq-correct'));
            radios.forEach(r=> r.checked=false);
            const idx = parseInt(sel.value,10);
            if(radios[idx]) radios[idx].checked = true;
            m.style.display='none';
            const cb = window.__correctProceed;
            window.__correctWrap = null; window.__correctProceed = null;
            if(typeof cb === 'function') cb();
        }
        function correctModalCancel(){
            const m = document.getElementById('correctModal');
            m.style.display='none';
            window.__correctWrap = null; window.__correctProceed = null;
        }
        function dmAddQuestion(){
            const sel = document.querySelector('.field-block.selected-field');
            if(sel){
                const qBtn = sel.querySelectorAll('.inline-add button')[1];
                if(qBtn) return addQuestionFieldAfter(qBtn);
            }
            const anchor = DM_STATE.currentAnchor;
            let panel = anchor?.closest('.subtopic-row')?.querySelector('.fields-panel')
                    || anchor?.querySelector?.('.fields-panel')
                    || anchor?.closest('.topic-row')?.querySelector('.subtopic-row:last-of-type .fields-panel')
                    || document.querySelector('.fields-panel');
            if(!panel && anchor?.closest('.topic-row')){
                addSubtopicRow(anchor.closest('.topic-row'));
                panel = anchor.closest('.topic-row').querySelector('.subtopic-row:last-of-type .fields-panel');
            }
            if(panel){
                addQuestionField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                setSelectedField(last);
                if(last) setActiveAnchor(last);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function dmAddExam(){
            const anchor = DM_STATE.currentAnchor;
            const container = document.getElementById('modulesContainer');
            let afterEl = null;
            if(anchor){
                afterEl = anchor.closest('.module-wrapper') || anchor.closest('.exam-wrapper');
            } else if(container.lastElementChild){
                afterEl = container.lastElementChild;
            }
            const host = createCourseExam(afterEl);
            if(host) { host.scrollIntoView({behavior:'smooth', block:'center'}); }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function createCourseExam(afterEl, prefill){
            const container = document.getElementById('modulesContainer');
            const idx = container.children.length;
            const wrap = document.createElement('div');
            wrap.className = 'exam-wrapper';
            wrap.style.cssText = 'margin-bottom:24px; background:#fff; border:1px solid #e2e8f0; border-radius:16px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); overflow:hidden;';
            wrap.innerHTML = `
                <div class="exam-header" style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                    <div style="font-weight:800;color:#002C76;display:flex;align-items:center;gap:10px;font-size:1.1rem;">
                        <i class="fas fa-file-signature" style="color:#10b981;"></i> Module Exam
                    </div>
                    <div style="display:flex;align-items:center;gap:12px">
                        <button type="button" class="chevron-btn" onclick="toggleExamChevron(this)" style="background:none;border:none;color:#64748b;cursor:pointer;padding:5px;transition:all .2s;"><i class="fas fa-chevron-down"></i></button>
                        <button type="button" class="delete-btn" onclick="this.closest('.exam-wrapper').remove(); reindexModules();" style="background:none;border:none;color:#ef4444;cursor:pointer;padding:5px;transition:all .2s;"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="q-block" style="padding:24px;">
                    <!-- General Settings -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid #f1f5f9;">
                        <div style="grid-column:span 2;">
                            <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Exam Title</label>
                            <input class="exam-title" type="text" placeholder="e.g., Module 1 Final Assessment" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;transition:border-color .2s;">
                        </div>
                        <div style="grid-column:span 2;">
                            <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Exam Description or Instructions</label>
                            <textarea class="exam-desc" rows="2" placeholder="Briefly describe what this exam covers..." style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;resize:vertical;transition:border-color .2s;"></textarea>
                        </div>
                        <div>
                            <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Timer (Minutes)</label>
                            <div style="position:relative;">
                                <i class="far fa-clock" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;"></i>
                                <input type="number" min="1" max="600" class="exam-duration" placeholder="30" style="width:100%;padding:12px 16px 12px 40px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>
                        </div>
                        <div>
                            <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Passing Rate (%)</label>
                            <div style="position:relative;">
                                <i class="fas fa-percentage" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;"></i>
                                <input type="number" min="1" max="100" class="exam-passing-score" placeholder="75" style="width:100%;padding:12px 16px 12px 40px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>
                        </div>
                    </div>

                    <div class="exam-questions">
                        <!-- Navigation Bar -->
                        <div class="exam-nav" style="display:flex;align-items:center;gap:12px;overflow-x:auto;padding:4px 4px 16px;margin-bottom:20px;border-bottom:1px solid #f1f5f9;">
                            <div class="nav-track" style="display:flex;align-items:center;gap:10px;flex:1;min-width:0;"></div>
                        </div>

                        <div class="exam-q-list" style="display:none"></div>
                        <div class="exam-form-inputs" style="display:none"></div>

                        <!-- Question Builder Card -->
                        <div class="exam-q-builder" style="background:#f8fafc;padding:20px;border-radius:16px;border:1px solid #e2e8f0;">
                            <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:20px;">
                                <div>
                                    <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Question Text</label>
                                    <textarea class="eq-text q-autosize" placeholder="Type your question here..." rows="3" style="width:100%;padding:14px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;resize:none;outline:none;transition:all .2s;"></textarea>
                                </div>
                                <div>
                                    <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Question Type</label>
                                    <select class="eq-type" style="width:100%;padding:12px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;background:#fff;outline:none;cursor:pointer;">
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="identification">Identification</option>
                                        <option value="true_false">True or False</option>
                                        <option value="essay">Essay</option>
                                        <option value="enumeration">Enumeration</option>
                                    </select>
                                </div>
                            </div>

                            <div class="eq-choices" style="display:grid;gap:12px;margin-bottom:20px;"></div>

                            <div class="eq-id" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Correct Answer</label>
                                <input class="eq-id-answer" type="text" placeholder="Enter the correct answer" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="eq-tf" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Correct Answer</label>
                                <select class="eq-tf-answer" style="width:100%;padding:12px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;background:#fff;outline:none;cursor:pointer;">
                                    <option value="" selected disabled>Select True or False</option>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>

                            <div class="eq-points" style="margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Points</label>
                                <input class="eq-common-points" type="number" min="1" step="0.01" placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="eq-essay" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Points</label>
                                <input class="eq-essay-points" type="number" min="1" step="0.01" placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="eq-enum" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Correct Answers</label>
                                <div class="eq-enum-answers" style="display:grid;gap:10px;"></div>
                                <button type="button" class="eq-enum-add" style="margin-top:12px;background:#eef2ff;color:#002C76;border:1.5px dashed #c7d2fe;border-radius:12px;padding:10px;width:100%;font-weight:700;cursor:pointer;transition:all .2s;"><i class="fas fa-plus-circle"></i> Add Answer Entry</button>
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin:16px 0 8px;">Points</label>
                                <input class="eq-enum-points" type="number" min="1" step="0.01" placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="actions" style="display:flex;justify-content:flex-end;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid #e2e8f0;">
                                <button type="button" class="eq-del" style="padding:10px 20px;border-radius:10px;border:1.5px solid #fee2e2;background:#fff;color:#ef4444;font-weight:700;cursor:pointer;transition:all .2s;opacity:.5;" disabled onclick="deleteActiveExamQuestion(this)">Delete Question</button>
                                <button type="button" class="eq-add" style="padding:10px 24px;border-radius:10px;border:none;background:#002C76;color:#fff;font-weight:700;cursor:pointer;box-shadow:0 4px 6px -1px rgba(0, 44, 118, 0.2);transition:all .2s;"><i class="fas fa-save" style="margin-right:8px"></i> Save Question</button>
                            </div>
                        </div>
                    </div>
                </div>
                <textarea class="exam-json" name="modules[${idx}][exam_json]" style="display:none"></textarea>
            `;
            if(afterEl && afterEl.parentElement === container){
                container.insertBefore(wrap, afterEl.nextSibling);
            }else{
                container.appendChild(wrap);
            }
            wrap.setAttribute('draggable','true');
            wrap.addEventListener('dragstart', (e)=>{
                window.__dragExam = wrap; 
                wrap.classList.add('dragging'); 
                // auto-minimize during drag
                const body = wrap.querySelector('.q-block');
                const icon = wrap.querySelector('.chevron-btn i');
                const wasOpen = (body.style.display === '' || body.style.display === 'block');
                wrap.dataset.prevOpen = wasOpen ? '1' : '0';
                body.style.display = 'none';
                if(icon) icon.style.transform = 'rotate(0deg)';
                e.dataTransfer.effectAllowed='move'; 
                try{ e.dataTransfer.setData('text/plain','exam'); }catch(_){} 
            });
            wrap.addEventListener('dragend', ()=>{
                wrap.classList.remove('dragging'); 
                const body = wrap.querySelector('.q-block');
                const icon = wrap.querySelector('.chevron-btn i');
                if(wrap.dataset.prevOpen === '1'){ body.style.display = 'block'; if(icon) icon.style.transform = 'rotate(180deg)'; }
                window.__dragExam=null; 
                const ph = cont.__dropPlaceholder; if(ph && ph.parentNode){ ph.parentNode.removeChild(ph); } 
            });
            const cont = document.getElementById('modulesContainer');
            if(!cont.__dndBound){
                cont.__dndBound = true;
                cont.addEventListener('dragover', (e)=>{
                    if(!window.__dragExam) return;
                    e.preventDefault();
                    const ph = cont.__dropPlaceholder || (cont.__dropPlaceholder = Object.assign(document.createElement('div'), {className:'drop-placeholder'}));
                    const before = getDropBeforeElement(cont, e.clientY);
                    if(before==null){ cont.appendChild(ph); }
                    else { cont.insertBefore(ph, before); }
                });
                cont.addEventListener('drop', (e)=>{
                    if(window.__dragExam){
                        e.preventDefault();
                        const ph = cont.__dropPlaceholder;
                        const before = getDropBeforeElement(cont, e.clientY);
                        if(before==null){ cont.appendChild(window.__dragExam); }
                        else { cont.insertBefore(window.__dragExam, before); }
                        if(ph && ph.parentNode){ ph.parentNode.removeChild(ph); }
                        reindexModules();
                        window.__dragExam=null;
                    }
                });
            }
            __bindAutosizeTextareas(wrap);
            function renderChoices(){
                const wrapChoices = wrap.querySelector('.eq-choices');
                wrapChoices.innerHTML = '';
                const group = 'course_exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
                ['Choice A','Choice B','Choice C','Choice D'].forEach((ph,i)=>{
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex; align-items:center; gap:12px; background:#fff; padding:8px 16px; border:1.5px solid #e2e8f0; border-radius:12px; transition:all .2s;';
                    row.innerHTML = `
                        <label style="display:flex;align-items:center;gap:12px;flex:1;cursor:pointer;margin:0;">
                            <input type="radio" class="eq-correct" name="${group}" value="${i}" style="width:18px;height:18px;accent-color:#10b981;cursor:pointer;">
                            <input type="text" class="eq-option" placeholder="${ph}" style="flex:1;border:none;outline:none;font-size:0.95rem;font-weight:600;background:transparent;padding:4px 0;">
                        </label>
                    `;
                    // Add focus effect to row
                    const input = row.querySelector('.eq-option');
                    input.addEventListener('focus', () => row.style.borderColor = '#002C76');
                    input.addEventListener('blur', () => row.style.borderColor = '#e2e8f0');
                    wrapChoices.appendChild(row);
                });
            }
            function ensureEnumerationRows(wrap, values){
                const answerWrap = wrap.querySelector('.eq-enum-answers');
                if(!answerWrap) return;
                answerWrap.innerHTML = '';
                const entries = Array.isArray(values) && values.length ? values : ['', ''];
                entries.forEach(value=>{
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex; align-items:center; gap:10px; margin-bottom:8px;';
                    row.innerHTML = `
                        <input type="text" class="eq-enum-answer" placeholder="Correct answer" value="${String(value || '').replace(/"/g,'&quot;')}" style="flex:1;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                        <button type="button" class="eq-enum-remove" style="background:#fff;color:#ef4444;border:1.5px solid #fee2e2;border-radius:10px;padding:10px 14px;cursor:pointer;transition:all .2s;"><i class="fas fa-times"></i></button>
                    `;
                    answerWrap.appendChild(row);
                });
            }
            wrap.addEventListener('click', function(e){
                const addBtn = e.target.closest('.eq-enum-add');
                if(addBtn){
                    e.preventDefault();
                    e.stopPropagation();
                    const current = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    current.push('');
                    ensureEnumerationRows(wrap, current);
                    return;
                }
                const removeBtn = e.target.closest('.eq-enum-remove');
                if(removeBtn){
                    e.preventDefault();
                    e.stopPropagation();
                    const rows = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    const row = removeBtn.closest('.q-option-row');
                    const idx = Array.from(wrap.querySelectorAll('.eq-enum-answers .q-option-row')).indexOf(row);
                    const next = rows.filter((_, i)=> i !== idx);
                    ensureEnumerationRows(wrap, next.length ? next : ['', '']);
                    const ev = new Event('input', { bubbles:true });
                    wrap.dispatchEvent(ev);
                }
            });
            function syncBuilderBoxes(){
                const t = wrap.querySelector('.eq-type').value;
                wrap.querySelector('.eq-choices').style.display = (t==='multiple_choice') ? 'block':'none';
                wrap.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                wrap.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                wrap.querySelector('.eq-essay').style.display = (t==='essay') ? 'block':'none';
                wrap.querySelector('.eq-enum').style.display = (t==='enumeration') ? 'block':'none';
                if(t==='multiple_choice' && wrap.querySelectorAll('.eq-option').length===0){ renderChoices(); }
                if(t==='enumeration' && wrap.querySelectorAll('.eq-enum-answer').length===0){ ensureEnumerationRows(wrap); }
            }
            function syncExamJSON(){
                const duration = parseInt(wrap.querySelector('.exam-duration')?.value || '0', 10) || 0;
                const title = (wrap.querySelector('.exam-title')?.value || '').trim();
                const description = (wrap.querySelector('.exam-desc')?.value || '').trim();
                const passingScore = parseInt(wrap.querySelector('.exam-passing-score')?.value || '75', 10) || 75;
                const list = wrap.querySelectorAll('.exam-q-list .q-item');
                const qs = [];
                list.forEach(node=>{
                    try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && obj.text){ qs.push(obj); } }catch(e){}
                });
                const val = JSON.stringify({ title, description, timer_minutes: duration, passing_score: passingScore, questions: qs });
                wrap.querySelector('.exam-json').value = val;
                try{ localStorage.setItem('exam_draft_edit_{{ $course->id }}', val); }catch(e){}
            }
            function resetTypeSpecificFields(){
                const t = wrap.querySelector('.eq-type').value;
                // Clear choices and correct flags
                const choiceWrap = wrap.querySelector('.eq-choices');
                if(choiceWrap){
                    choiceWrap.querySelectorAll('.eq-option').forEach(i=> i.value='');
                    choiceWrap.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                }
                // Clear identification and true/false answers
                const idAns = wrap.querySelector('.eq-id-answer'); if(idAns) idAns.value = '';
                const tfSel = wrap.querySelector('.eq-tf-answer'); if(tfSel) tfSel.value = 'true';
                const commonPoints = wrap.querySelector('.eq-common-points'); if(commonPoints) commonPoints.value = '';
                const essayPoints = wrap.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value = '';
                ensureEnumerationRows(wrap);
                const enumPoints = wrap.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value = '';
                // Update payload for active item to a blank object of the selected type
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                const idx = getActiveExamIndex(wrap);
                if(idx < items.length){
                    const text = (wrap.querySelector('.eq-text').value||'').trim();
                    let obj = null;
                    if(t==='multiple_choice'){
                        obj = { type:'multiple_choice', text, choices:['','','',''], answer_index: null, max_points: '' };
                    }else if(t==='identification'){
                        obj = { type:'identification', text, answer: '', max_points: '' };
                    }else if(t==='true_false'){
                        obj = { type:'true_false', text, answer: true, max_points: '' };
                    }else if(t==='essay'){
                        const maxPointsVal = wrap.querySelector('.eq-essay-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'essay', text, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='enumeration'){
                        const maxPointsVal = wrap.querySelector('.eq-enum-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'enumeration', text, answers:['', ''], max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    } else {
                        obj = { type:String(t||'multiple_choice'), text };
                    }
                    const node = items[idx];
                    node.dataset.payload = JSON.stringify(obj);
                }
            }
            wrap.querySelector('.eq-type').addEventListener('change', ()=>{
                resetTypeSpecificFields();
                syncBuilderBoxes();
                syncExamJSON();
                scheduleAutoSave(wrap);
            });
            wrap.addEventListener('input', ()=>{ syncExamJSON(); scheduleAutoSave(wrap); });
            wrap.addEventListener('change', ()=>{ syncExamJSON(); scheduleAutoSave(wrap); });
            wrap.querySelector('.eq-add').addEventListener('click', function(){
                const t = wrap.querySelector('.eq-type').value;
                const text = (wrap.querySelector('.eq-text').value||'').trim();
                if(!text) return;
                const activeIdx = getActiveExamIndex(wrap);
                let obj = null;
                if(t==='multiple_choice'){
                    const opts = Array.from(wrap.querySelectorAll('.eq-option')).map(i=>i.value.trim()).filter(Boolean);
                    if(opts.length<2) return;
                    const checked = wrap.querySelector('.eq-correct:checked');
                    if(!checked){
                        openCorrectAnswerModal(wrap, ()=> wrap.querySelector('.eq-add').click());
                        return;
                    }
                    const ans = parseInt(checked.value,10);
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'multiple_choice', text, choices: opts, answer_index: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='identification'){
                    const ans = (wrap.querySelector('.eq-id-answer').value||'').trim();
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'identification', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='true_false'){
                    const ans = wrap.querySelector('.eq-tf-answer').value === 'true';
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'true_false', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='essay'){
                    const maxPointsVal = wrap.querySelector('.eq-essay-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'essay', text, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='enumeration'){
                    const answers = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=>i.value.trim()).filter(Boolean);
                    const maxPointsVal = wrap.querySelector('.eq-enum-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'enumeration', text, answers, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }
                const currentNode = wrap.querySelectorAll('.exam-q-list .q-item')[activeIdx];
                if (currentNode) {
                    currentNode.dataset.payload = JSON.stringify(obj);
                }
                const listEl = wrap.querySelector('.exam-q-list');
                const idx = listEl.children.length + 1;
                let blankObj = null;
                if(t==='multiple_choice'){
                    blankObj = { type:'multiple_choice', text:'', choices:['','','',''], answer_index: null, max_points: '' };
                }else if(t==='identification'){
                    blankObj = { type:'identification', text:'', answer: '', max_points: '' };
                }else if(t==='true_false'){
                    blankObj = { type:'true_false', text:'', answer: true, max_points: '' };
                }else if(t==='essay'){
                    blankObj = { type:'essay', text:'', max_points: '' };
                }else if(t==='enumeration'){
                    blankObj = { type:'enumeration', text:'', answers:['', ''], max_points: '' };
                } else {
                    blankObj = { type:String(t||'multiple_choice'), text:'' };
                }
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx+'. </div>'
                    + '<div class="muted" style="margin-top:6px">'+blankObj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(blankObj);
                listEl.appendChild(node);
                wrap.querySelector('.eq-text').value='';
                wrap.querySelectorAll('.eq-option').forEach(i=> i.value='');
                wrap.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                wrap.querySelector('.eq-id-answer').value='';
                wrap.querySelector('.eq-tf-answer').value='true';
                const commonPoints2 = wrap.querySelector('.eq-common-points'); if(commonPoints2) commonPoints2.value='';
                const essayPoints = wrap.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value='';
                ensureEnumerationRows(wrap);
                const enumPoints = wrap.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value='';
                syncBuilderBoxes();
                syncExamJSON();
                updateExamNavigator.call(wrap);
                setActiveExamIndex(wrap, Math.max(0, listEl.children.length-1));
            });
            renderChoices(); syncBuilderBoxes(); syncExamJSON();
            if(prefill){
                try{
                    wrap.querySelector('.exam-duration').value = prefill.timer_minutes || '';
                    const pass = wrap.querySelector('.exam-passing-score'); if(pass) pass.value = prefill.passing_score || '';
                    if(prefill.title) wrap.querySelector('.exam-title').value = prefill.title;
                    if(prefill.description) wrap.querySelector('.exam-desc').value = prefill.description;
                    const listEl = wrap.querySelector('.exam-q-list');
                    (prefill.questions||[]).forEach((q, i2)=>{
                        const node = document.createElement('div');
                        node.className = 'q-item';
                        node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(i2+1)+'. '+(q.text||q.title||'')+'</div>'
                            + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>';
                        node.dataset.payload = JSON.stringify(q);
                        listEl.appendChild(node);
                    });
                    // Build navigator and load first question into builder
                    if(typeof updateExamNavigator === 'function'){
                        const ctx = wrap.closest('.exam-wrapper') || wrap;
                        try{ updateExamNavigator.call(ctx); }catch(e){}
                    }
                    syncExamJSON();
                    try{ setActiveExamIndex(wrap, 0); }catch(e){}
                }catch(e){}
            }
            reindexModules();
            return wrap;
        }
            function updateExamNavigator(){
            const wrap = this.classList?.contains('exam-wrapper') ? this : document.querySelector('.exam-wrapper'); 
            const nav = wrap.querySelector('.exam-nav');
            if(!nav) return;
            const track = nav.querySelector('.nav-track');
            const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
            track.innerHTML = '';
            items.forEach((_, i)=>{
                const b = window.CAPDEVQuestionBuilderShared.createNavQuestionButton(i, (ev)=> { ev.preventDefault(); setActiveExamIndex(wrap, i); });
                track.appendChild(b);
            });
            const addButton = window.CAPDEVQuestionBuilderShared.createNavAddButton((ev)=>{
                ev.preventDefault();
                wrap.querySelector('.eq-add')?.click();
            });
            track.appendChild(addButton);
            setActiveExamIndex(wrap, getActiveExamIndex(wrap)); 
        }
        function getActiveExamIndex(wrap){
            const track = wrap.querySelector('.nav-track');
            const blocks = Array.from(track.querySelectorAll('.nav-question'));
            const idx = blocks.findIndex(b=> b.classList.contains('active'));
            return idx>=0 ? idx : 0;
        }
        function setActiveExamIndex(wrapOrIndex, maybeIndex){
            const wrap = wrapOrIndex && wrapOrIndex.classList && wrapOrIndex.classList.contains('exam-wrapper')
                ? wrapOrIndex
                : (document.querySelector('.exam-wrapper') || document);
            const i = wrap === wrapOrIndex ? maybeIndex : wrapOrIndex;
            const nav = wrap.querySelector('.exam-nav');
            const track = nav.querySelector('.nav-track');
            const blocks = Array.from(track.querySelectorAll('.nav-question'));
            const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
            // Do not auto-focus builder to avoid focus jumping while typing elsewhere
            const clamped = Math.max(0, Math.min(items.length-1, i));
            const delBtn = wrap.querySelector('.eq-del');
            if(delBtn){
                const viewingExisting = clamped < items.length;
                delBtn.disabled = !viewingExisting;
                delBtn.style.opacity = viewingExisting ? '1' : '.45';
                delBtn.style.cursor = viewingExisting ? 'pointer' : 'default';
            }
            blocks.forEach((b,bi)=>{
                window.CAPDEVQuestionBuilderShared.applyQuestionButtonState(b, bi===clamped);
            });
            populateBuilderFromItem(wrap, clamped);
        }
        function recalcExamJSON(wrap){
            const duration = parseInt(wrap.querySelector('.exam-duration')?.value || '0', 10) || 0;
            const title = (wrap.querySelector('.exam-title')?.value || '').trim();
            const description = (wrap.querySelector('.exam-desc')?.value || '').trim();
            const passingScore = parseInt(wrap.querySelector('.exam-passing-score')?.value || '75', 10) || 75;
            const list = wrap.querySelectorAll('.exam-q-list .q-item');
            const qs = [];
            list.forEach(node=>{
                try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && (obj.text||obj.title)){ qs.push(obj); } }catch(e){}
            });
            const hidden = wrap.querySelector('.exam-json');
            if(hidden) hidden.value = JSON.stringify({ title, description, timer_minutes: duration, passing_score: passingScore, questions: qs });
        }
        function populateBuilderFromItem(wrap, idx){
            const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
            const node = items[idx];
            if(!node) return;
            let payload = {};
            try{ payload = JSON.parse(node.dataset.payload||'{}'); }catch(e){}
            const text = String(payload.text||'');
            const type = String(payload.type||'multiple_choice');
            wrap.querySelector('.eq-text').value = text;
            const typeSel = wrap.querySelector('.eq-type');
            if(typeSel){ typeSel.value = type; }
            showBuilderBoxes(wrap);
            if(type==='multiple_choice'){
                ensureChoiceRows(wrap);
                const choices = Array.isArray(payload.choices) ? payload.choices
                                 : Array.isArray(payload.options) ? payload.options
                                 : [];
                const rows = Array.from(wrap.querySelectorAll('.eq-choices .q-option-row'));
                rows.forEach((row,i)=>{
                    const inp = row.querySelector('.eq-option');
                    if(inp) inp.value = choices[i] || '';
                });
                const radios = Array.from(wrap.querySelectorAll('.eq-correct'));
                radios.forEach(r=> r.checked = false);
                const ai = typeof payload.answer_index==='number' ? payload.answer_index : 0;
                if(radios[ai]) radios[ai].checked = true;
                const commonPoints = wrap.querySelector('.eq-common-points');
                if(commonPoints){
                    const maxPoints = payload.max_points;
                    commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='identification'){
                const ans = String(payload.answer||'');
                wrap.querySelector('.eq-id-answer').value = ans;
                const commonPoints = wrap.querySelector('.eq-common-points');
                if(commonPoints){
                    const maxPoints = payload.max_points;
                    commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='true_false'){
                wrap.querySelector('.eq-tf-answer').value = payload.answer===false ? 'false' : 'true';
                const commonPoints = wrap.querySelector('.eq-common-points');
                if(commonPoints){
                    const maxPoints = payload.max_points;
                    commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='essay'){
                const essayPoints = wrap.querySelector('.eq-essay-points');
                if(essayPoints){
                    const maxPoints = payload.max_points;
                    essayPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='enumeration'){
                ensureEnumerationRows(wrap, Array.isArray(payload.answers) ? payload.answers : []);
                const enumPoints = wrap.querySelector('.eq-enum-points');
                if(enumPoints){
                    const maxPoints = payload.max_points;
                    enumPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }
        }
            function showBuilderBoxes(wrap){
            const t = wrap.querySelector('.eq-type').value;
            const boxChoices = wrap.querySelector('.eq-choices');
            const boxId = wrap.querySelector('.eq-id');
            const boxTf = wrap.querySelector('.eq-tf');
            const boxPoints = wrap.querySelector('.eq-points');
            const boxEssay = wrap.querySelector('.eq-essay');
            const boxEnum = wrap.querySelector('.eq-enum');
            if(boxChoices) boxChoices.style.display = (t==='multiple_choice') ? 'block' : 'none';
            if(boxId) boxId.style.display = (t==='identification') ? 'block' : 'none';
            if(boxTf) boxTf.style.display = (t==='true_false') ? 'block' : 'none';
            if(boxPoints) boxPoints.style.display = (t==='essay' || t==='enumeration') ? 'none' : 'block';
            if(boxEssay) boxEssay.style.display = (t==='essay') ? 'block' : 'none';
            if(boxEnum) boxEnum.style.display = (t==='enumeration') ? 'block' : 'none';
            if(t==='multiple_choice'){
                const rows = wrap.querySelectorAll('.eq-choices .q-option-row');
                if(rows.length===0) ensureChoiceRows(wrap);
            }
            if(t==='enumeration' && wrap.querySelectorAll('.eq-enum-answer').length===0){
                ensureEnumerationRows(wrap);
            }
        }
        function ensureChoiceRows(wrap){
            const wrapChoices = wrap.querySelector('.eq-choices');
            if(!wrapChoices) return;
            if(wrapChoices.querySelectorAll('.q-option-row').length>0) return;
            const group = 'exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
            ['Choice A','Choice B','Choice C','Choice D'].forEach((ph,i)=>{
                const row = document.createElement('div');
                row.className = 'q-option-row';
                row.innerHTML = `
                    <label style="display:flex;align-items:center;gap:8px;flex:1;">
                        <input type="radio" class="eq-correct" name="${group}" value="${i}">
                        <input type="text" class="eq-option" placeholder="${ph}">
                    </label>
                `;
                wrapChoices.appendChild(row);
            });
        }
        document.addEventListener('click', function(e){
            const wrap = e.target.closest('.exam-wrapper');
            if(!wrap) return;
            const addBtn = e.target.closest('.eq-enum-add');
            if(addBtn){
                e.preventDefault();
                const current = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                current.push('');
                ensureEnumerationRows(wrap, current);
                const ev = new Event('input', { bubbles:true });
                wrap.dispatchEvent(ev);
                return;
            }
            const removeBtn = e.target.closest('.eq-enum-remove');
            if(removeBtn){
                e.preventDefault();
                const rows = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                const row = removeBtn.closest('.q-option-row');
                const idx = Array.from(wrap.querySelectorAll('.eq-enum-answers .q-option-row')).indexOf(row);
                const next = rows.filter((_, i)=> i !== idx);
                ensureEnumerationRows(wrap, next.length ? next : ['', '']);
                const ev = new Event('input', { bubbles:true });
                wrap.dispatchEvent(ev);
            }
        });
        (function bindBuilderLiveUpdate(){
            window.__EXAM_DIRTY = new Set();
            document.addEventListener('input', function(e){
                const wrap = e.target.closest('.exam-wrapper'); if(!wrap) return;
                const idx = getActiveExamIndex(wrap);
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                if(idx >= items.length) return;
                const t = wrap.querySelector('.eq-type').value;
                const text = (wrap.querySelector('.eq-text').value||'').trim();
                let obj = null;
                if(t==='multiple_choice'){
                    const opts = Array.from(wrap.querySelectorAll('.eq-option')).map(i=>i.value.trim());
                    const checked = wrap.querySelector('.eq-correct:checked');
                    const ans = checked ? parseInt(checked.value,10) : 0;
                    const maxPoints = Number(wrap.querySelector('.eq-common-points')?.value || 1);
                    obj = { type:'multiple_choice', text, choices: opts, answer_index: ans, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
                }else if(t==='identification'){
                    const ans = (wrap.querySelector('.eq-id-answer').value||'').trim();
                    const maxPoints = Number(wrap.querySelector('.eq-common-points')?.value || 1);
                    obj = { type:'identification', text, answer: ans, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
                }else if(t==='true_false'){
                    const ans = wrap.querySelector('.eq-tf-answer').value === 'true';
                    const maxPoints = Number(wrap.querySelector('.eq-common-points')?.value || 1);
                    obj = { type:'true_false', text, answer: ans, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
                }else if(t==='essay'){
                    const maxPoints = Number(wrap.querySelector('.eq-essay-points')?.value || 1);
                    obj = { type:'essay', text, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
                }else if(t==='enumeration'){
                    const answers = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=>i.value.trim()).filter(Boolean);
                    const maxPoints = Number(wrap.querySelector('.eq-enum-points')?.value || 1);
                    obj = { type:'enumeration', text, answers, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
                }
                const node = items[idx];
                node.dataset.payload = JSON.stringify(obj);
                const title = node.querySelector('.qi-title');
                if(title){ title.textContent = (idx+1)+'. '+(obj.text||''); }
                recalcExamJSON(wrap);
                scheduleAutoSave(wrap);
                try{ window.__EXAM_DIRTY.add(idx); }catch(_){}
            }, { passive:true });
            document.addEventListener('change', function(e){
                const wrap = e.target.closest('.exam-wrapper'); if(!wrap) return;
                recalcExamJSON(wrap);
                scheduleAutoSave(wrap);
                try{ const idx = getActiveExamIndex(wrap); window.__EXAM_DIRTY.add(idx); }catch(_){}
            }, { passive:true });
        })();
        // Debounced auto-save (5s after typing) and explicit Save button
        function scheduleAutoSave(wrap){
            if(!wrap) return;
            clearTimeout(wrap.__saveTimer);
            wrap.__saveTimer = setTimeout(()=> doAjaxSaveExam(wrap), 5000);
        }
        function doAjaxSaveExam(wrap){
            try{
                recalcExamJSON(wrap);
                const hidden = wrap.querySelector('.exam-json');
                if(!hidden) return;
                const payload = hidden.value || '';
                fetch('{{ url('/courses/'.$course->id.'/exam') }}', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}','Accept':'application/json'},
                    body: JSON.stringify({ exam_json: payload, dirty: Array.from(window.__EXAM_DIRTY||[]) })
                }).then(()=>{
                    const nav = wrap.querySelector('.exam-nav');
                    if(nav && !nav.querySelector('.save-chip')){
                        const chip = document.createElement('span');
                        chip.className='save-chip';
                        chip.textContent='Saved';
                        chip.style.cssText='margin-left:8px;color:#059669;font-weight:700';
                        nav.appendChild(chip);
                        setTimeout(()=>{ chip.remove(); }, 1800);
                    }
                    window.__EXAM_DIRTY && window.__EXAM_DIRTY.clear();
                }).catch(()=>{
                    // silent fail
                });
            }catch(_){}
        }
        document.addEventListener('click', function(e){
            const btn = e.target.closest('.eq-save'); if(!btn) return;
            const wrap = btn.closest('.exam-wrapper'); if(!wrap) return;
            e.preventDefault();
            doAjaxSaveExam(wrap);
        });
        // 30-second periodic auto-save for modified questions
        setInterval(function(){
            const wrap = document.querySelector('.exam-wrapper');
            if(!wrap || !window.__EXAM_DIRTY || window.__EXAM_DIRTY.size===0) return;
            doAjaxSaveExam(wrap);
        }, 30000);
        function deleteActiveExamQuestion(btn){
            const wrap = btn.closest('.exam-wrapper');
            const listEl = wrap.querySelector('.exam-q-list');
            const active = getActiveExamIndex(wrap);
            const items = Array.from(listEl.children);
            if(items.length===0) return;
            const target = items[Math.min(active, items.length-1)];
            target.remove();
            Array.from(listEl.children).forEach((n,i)=>{
                const t = n.querySelector('.qi-title');
                if(t){ const payload = JSON.parse(n.dataset.payload||'{}'); t.textContent = (i+1)+'. '+(payload.text||''); }
            });
            updateExamNavigator.call(wrap);
            recalcExamJSON(wrap);
            setActiveExamIndex(Math.max(0, active-1));
        }
        function getDropBeforeElement(container, y){
            const els = [...container.querySelectorAll('.module-wrapper, .exam-wrapper:not(.dragging)')];
            for(let i=0;i<els.length;i++){
                const el = els[i];
                const box = el.getBoundingClientRect();
                if(y < box.top + box.height/2) return el;
            }
            return null;
        }
        function toggleExamChevron(btn){
            const wrapper = btn.closest('.exam-wrapper');
            const body = wrapper.querySelector('.q-block');
            const icon = btn.querySelector('i');
            const open = (body.style.display === '' || body.style.display === 'block');
            body.style.display = open ? 'none' : 'block';
            if(icon) icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
        }
        function moveOutlineItemUp(btn){
            const wrapper = btn.closest('.exam-wrapper');
            const container = document.getElementById('modulesContainer');
            if(wrapper && wrapper.previousElementSibling){
                container.insertBefore(wrapper, wrapper.previousElementSibling);
                reindexModules();
            }
        }
        function moveOutlineItemDown(btn){
            const wrapper = btn.closest('.exam-wrapper');
            const container = document.getElementById('modulesContainer');
            if(wrapper && wrapper.nextElementSibling){
                container.insertBefore(wrapper.nextElementSibling, wrapper);
                reindexModules();
            }
        }
        function dmAddTopic(){
            const anchor = DM_STATE.currentAnchor;
            const wrapper = anchor?.closest('.module-wrapper');
            const moduleBody = wrapper ? wrapper.querySelector('.module-body') : document.querySelector('.module-wrapper .module-body');
            if(moduleBody){
                addTopicInput(moduleBody);
                const lastTopic = moduleBody.querySelector('.topic-row:last-of-type');
                if(lastTopic) setActiveAnchor(lastTopic);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function dmAddModule(){ 
            createModule(); 
            const lastHeader = document.querySelector('.module-wrapper:last-of-type .module-header');
            if(lastHeader) setActiveAnchor(lastHeader);
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open'); 
            clearActiveAnchor();
        }
        function populateExistingModules(mods){
            if(!Array.isArray(mods)) return;
            const container = document.getElementById('modulesContainer');
            container.innerHTML = '';
            mods.forEach((mod, mi)=>{
                if(mod && mod.exam && (!Array.isArray(mod.topics) || mod.topics.length===0)){
                    createCourseExam(null, mod.exam);
                    return;
                }
                createModule();
                const wrapper = container.lastElementChild;
                const titleInput = wrapper.querySelector('.module-title-input');
                titleInput.value = mod.title || '';
                const body = wrapper.querySelector('.module-body');
                body.style.display = 'block';
                if(mod.exam){
                    const host = ensureModuleExam(wrapper);
                    if(host){
                        const hidden = wrapper.querySelector('.module-exam-json');
                        try{ hidden.value = JSON.stringify(mod.exam); }catch(e){}
                        const dur = host.querySelector('.exam-duration'); if(dur) dur.value = mod.exam.timer_minutes || '';
                        const pass = host.querySelector('.exam-passing-score'); if(pass) pass.value = mod.exam.passing_score || '';
                        const listEl = host.querySelector('.exam-q-list');
                        (mod.exam.questions||[]).forEach((q, idx)=>{
                            const node = document.createElement('div');
                            node.className = 'q-item';
                            node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(idx+1)+'. '+(q.text||q.title||'')+'</div>'
                                + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>';
                            node.dataset.payload = JSON.stringify(q);
                            listEl.appendChild(node);
                        });
                        // Build navigator blocks for existing questions
                        if(typeof updateExamNavigator === 'function'){
                            const ctx = host.closest('.exam-wrapper') || wrapper;
                            try{ updateExamNavigator.call(ctx); }catch(e){}
                        }
                    }
                }
                const topics = Array.isArray(mod.topics) ? mod.topics : [];
                topics.forEach((t, ti)=>{
                    addTopicInput(body);
                    const topicRow = body.querySelector('.topic-row:last-of-type');
                    topicRow.querySelector('input[type="text"]').value = t.title || '';
                    const hasSubs = Array.isArray(t.subtopics) && t.subtopics.length > 0;
                    if(hasSubs){
                        t.subtopics.forEach((s)=>{
                            addSubtopicRow(topicRow);
                            const sub = topicRow.querySelector('.subtopic-row:last-of-type');
                            const sInput = sub.querySelector('input[type="text"]');
                            sInput.value = s.title || '';
                            const panel = sub.querySelector('.fields-panel');
                            const fields = Array.isArray(s.fields) ? s.fields : [];
                            fields.forEach(f=>{
                                if(f.type === 'text'){
                                    addTextField(panel);
                                    const last = panel.querySelector('.field-block:last-of-type .editor');
                                    if(last) last.innerHTML = f.html || '';
                                } else if(f.type === 'question'){
                                    addQuestionField(panel);
                                    const block = panel.querySelector('.field-block:last-of-type');
                                    const q = f.question || {};
                                    block.querySelector('.q-title').value = q.title || '';
                                    const opts = block.querySelector('.q-options');
                                    opts.innerHTML = '';
                                    const arr = Array.isArray(q.options) ? q.options : [];
                                    arr.forEach((opt, idx)=>{
                                        addOptionRow(opts, '');
                                        const row = opts.querySelectorAll('.q-option-row')[idx];
                                        if(row){ row.querySelector('.q-option').value = opt; }
                                    });
                                    if(arr.length === 0){ addOptionRow(opts, 'Option 1'); addOptionRow(opts, ''); }
                                    const rows = Array.from(opts.querySelectorAll('.q-option-row'));
                                    if(Number.isInteger(q.answer_index) && rows[q.answer_index]){
                                        const r = rows[q.answer_index].querySelector('.q-correct');
                                        if(r) r.checked = true;
                                    }
                                    const fbc = block.querySelector('.q-fb-correct');
                                    const fbi = block.querySelector('.q-fb-incorrect');
                                    if(fbc) fbc.value = q.feedback_correct || '';
                                    if(fbi) fbi.value = q.feedback_incorrect || '';
                                }
                            });
                            syncFieldsJSON(panel);
                        });
                    } else {
                        addSubtopicRow(topicRow);
                        const sub = topicRow.querySelector('.subtopic-row:last-of-type');
                        const panel = sub.querySelector('.fields-panel');
                        const fields = Array.isArray(t.fields) ? t.fields : [];
                        fields.forEach(f=>{
                            if(f.type === 'text'){
                                addTextField(panel);
                                const last = panel.querySelector('.field-block:last-of-type .editor');
                                if(last) last.innerHTML = f.html || '';
                            } else if(f.type === 'question'){
                                addQuestionField(panel);
                                const block = panel.querySelector('.field-block:last-of-type');
                                const q = f.question || {};
                                block.querySelector('.q-title').value = q.title || '';
                                const opts = block.querySelector('.q-options');
                                opts.innerHTML = '';
                                const arr = Array.isArray(q.options) ? q.options : [];
                                arr.forEach((opt, idx)=>{
                                    addOptionRow(opts, '');
                                    const row = opts.querySelectorAll('.q-option-row')[idx];
                                    if(row){ row.querySelector('.q-option').value = opt; }
                                });
                                if(arr.length === 0){ addOptionRow(opts, 'Option 1'); addOptionRow(opts, ''); }
                                const rows = Array.from(opts.querySelectorAll('.q-option-row'));
                                if(Number.isInteger(q.answer_index) && rows[q.answer_index]){
                                    const r = rows[q.answer_index].querySelector('.q-correct');
                                    if(r) r.checked = true;
                                }
                                const fbc = block.querySelector('.q-fb-correct');
                                const fbi = block.querySelector('.q-fb-incorrect');
                                if(fbc) fbc.value = q.feedback_correct || '';
                                if(fbi) fbi.value = q.feedback_incorrect || '';
                            }
                        });
                        syncFieldsJSON(panel);
                    }
                });
            });
            reindexModules();
            updateProgress();
        }
    </script>
</body>
</html>
