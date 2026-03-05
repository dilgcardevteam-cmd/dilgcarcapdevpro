<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course - CAPDEV PRO</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
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
        .header { background:#fff; height:80px; display:flex; align-items:center; justify-content:space-between; padding:0 24px; box-shadow:0 2px 4px rgba(0,0,0,0.05); position:sticky; top:0; z-index:100; }
        .header-left { display:flex; align-items:center; gap:12px; }
        .header-title img { height:40px; display:block; }
        .header-right { display:flex; align-items:center; gap:10px; }
        body { font-family: 'DM Sans', sans-serif; margin: 0; padding: 0; background-color: var(--bg); color: var(--text); }
        .page-container { max-width: 1120px; margin: 40px auto; padding: 0 20px 40px; }
        .back-link { text-decoration: none; color: #007bff; display: inline-flex; align-items: center; margin-bottom: 20px; font-size: 0.9rem; }
        .back-link i { margin-right: 8px; }
        h1 { color: #001f54; margin: 0 0 16px; letter-spacing: -0.02em; }
        .card { background: var(--surface); border-radius: 16px; box-shadow: 0 8px 22px rgba(15,23,42,0.06); padding: 24px; border:1px solid var(--border); }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; margin-bottom: 6px; color: #001f54; font-weight: 600; font-size:.95rem; }
        .form-group input[type="text"], .form-group input[type="url"], .form-group select, textarea,
        .section input[type="text"], .section input[type="url"], .section select, .section textarea {
            width: 100%; max-width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 10px; font-family: inherit; background:#fff; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group input[type="text"]:focus, .form-group input[type="url"]:focus, .form-group select:focus, textarea:focus,
        .section input[type="text"]:focus, .section input[type="url"]:focus, .section select:focus, .section textarea:focus {
            outline: none; border-color: var(--brand); box-shadow: 0 0 0 4px rgba(13,110,253,0.12);
        }
        .two-col { display:grid; grid-template-columns: 1.2fr 1fr; gap: 20px; align-items:start; }
        .two-col .left textarea { min-height: 110px; resize: none; }
        .section { background:#fbfcff; border:1px solid #eef2ff; border-radius:14px; padding:16px; overflow: hidden; }
        .section-title { display:flex; align-items:center; gap:10px; font-weight:800; color:#0f172a; margin:0 0 8px; font-size:1rem; }
        .hint { font-size:.85rem; color:#6b7280; margin-top:6px; }
        .preview-thumb { margin-top:8px; width: 180px; height: 104px; border:1px dashed #cbd5e1; border-radius:12px; display:flex; align-items:center; justify-content:center; background:#f8fafc; overflow:hidden; }
        .preview-thumb img { max-width:100%; max-height:100%; display:block; }
        .inline { display:flex; align-items:center; gap:10px; }
        @media (max-width: 900px){ .two-col { grid-template-columns: 1fr; } }
        .actions { text-align: right; margin-top: 18px; display: flex; gap: 12px; justify-content: flex-end; align-items:center; }
        .btn { border: none; padding: 10px 18px; border-radius: 12px; cursor: pointer; color: white; transition: transform .05s ease, box-shadow .15s ease, background-color .15s ease; }
        .btn:active { transform: translateY(1px); }
        .btn-cancel { background-color: #6b7280; }
        .btn-cancel:hover { background-color:#4b5563; }
        .btn-submit { background-color: var(--success); box-shadow: 0 6px 16px rgba(16, 64, 185, 0.25); }
        .btn-submit:hover { background-color: var(--success-600); box-shadow: 0 8px 20px rgba(16,185,129,0.32); }
        .btn-small { padding: 8px 12px; border-radius: 5px; }
        .btn-primary { background-color: #0d6efd; }
        .btn-blue { background:#0038A7; }
        .btn-blue:hover { background:#002f8c; }
        .module-wrapper { background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.05); }
        .module-header { display:flex;align-items:center;justify-content:space-between;padding:12px 14px; }
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
        .tab.disabled { opacity: 0.5; cursor: not-allowed; filter: grayscale(0.2); }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .progress { margin-bottom: 12px; }
        .progress-track { width: 100%; height: 10px; border-radius: 999px; background: #e2e8f0; border: 1px solid #dbe2ea; overflow: hidden; }
        .progress-fill { width: 0; height: 100%; background: linear-gradient(90deg, #0d6efd 0%, #00a859 100%); transition: width .25s ease; }
        .progress-status { margin-top: 6px; font-size: .82rem; color: #475569; font-weight: 700; }
        .progress-steps { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-top: 10px; }
        .step { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 10px; background: #f8fafc; color: #334155; font-weight: 700; font-size: .84rem; border: 1px solid #e5e7eb; transition: all .2s ease; }
        .step-index { width: 24px; height: 24px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: #e2e8f0; color: #334155; font-size: .78rem; font-weight: 800; flex: 0 0 24px; }
        .step.done { background: #ecfeff; color: #0f766e; border-color: #99f6e4; }
        .step.done .step-index { background: #10b981; color: #ffffff; }
        @media (max-width: 640px){ .progress-steps { grid-template-columns: 1fr; } }
        .error-text { color: #dc2626; font-size: 0.85rem; margin-top: 6px; }
        .editor-toolbar { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px; }
        .editor-toolbar button { padding: 6px 8px; border: 1px solid #e5e7eb; background: #f8fafc; border-radius: 6px; cursor: pointer; }
        .editor { border: 1px solid #ddd; border-radius: 6px; padding: 10px; min-height: 120px; background: #fff; }
        .materials-panel { background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-top:8px; }
        .fields-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-top:10px; position:relative; }
        .panel-add-btn { margin-top:8px; margin-left:auto; width:34px; height:34px; border-radius:999px; border:1px solid #d1d5db; background:#ffffff; color:#0038A7; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .panel-add-btn:hover { background:#f1f5ff; border-color:#b9c6ff; }
        .delete-btn { background:none; border:1px solid #dc3545; color:#dc3545; padding:8px; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:1rem; transition:all 0.2s ease; }
        .delete-btn:hover { background:#dc3545; color:white; box-shadow:0 2px 6px rgba(220, 53, 69, 0.2); }
        .field-block { border:1px dashed #cbd5e1; border-radius:8px; padding:10px; margin-bottom:10px; background:#fafafa; }
        .field-block.selected-field { outline:2px solid #6366f1; }
        .q-block { border:1px solid #e5e7eb; border-radius:8px; padding:10px; margin-bottom:10px; background:#fafafa; }
        .q-header { display:flex; flex-direction:column; gap:8px; align-items:stretch; }
        .q-header input[type="text"] { flex:1; padding:8px; border:1px solid #ddd; border-radius:6px; }
        .q-type { padding:8px; border:1px solid #ddd; border-radius:6px; width:220px; align-self:flex-end; }
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
        #dynamicMenu .dm-panel { display:none; min-width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:14px; box-shadow:0 12px 28px rgba(0,0,0,0.12); padding:8px; }
        #dynamicMenu .dm-panel.open { display:block; }
        #dynamicMenu .dm-group-label { font-size:12px; color:#6b7280; padding:6px 10px; }
        #dynamicMenu .dm-item { width:100%; display:flex; align-items:center; gap:10px; padding:10px 12px; border:none; background:#fff; cursor:pointer; border-radius:10px; }
        #dynamicMenu .dm-item:hover { background:#f1f5f9; }
        #dynamicMenu .dm-item i { width:18px; text-align:center; color:#374151; }
        #dynamicMenu .dm-sep { height:1px; background:#e5e7eb; margin:6px 8px; }
        #dynamicMenu.visible { opacity: 1; pointer-events: auto; }
        #dynamicMenu[aria-hidden="true"] { opacity: 0; pointer-events: none; }
        #dynamicMenu[data-context="module-header"] .rail-btn[data-type="field"] { display: none; }
        #dynamicMenu.is-editing .dm-rail { display:none; }
        .active-section { outline:2px solid #6366f1; border-radius:10px; }
        .toggle { display:inline-flex; align-items:center; gap:6px; }
        body.embedded-create {
            background-color: transparent;
        }
        body.embedded-create .page-container {
            max-width: 100%;
            margin: 0;
            padding: 6px 10px 12px;
        }
    </style>
    @if($errors->create_course->any())
        <script>
            // Keep a minimal place to show validation errors as alert for now
            window.addEventListener('DOMContentLoaded', function(){
                alert('Please fix the errors and submit again.');
            });
        </script>
    @endif
</head>
<body class="{{ request()->boolean('embedded') ? 'embedded-create' : '' }}">
    @if(empty($forTrainer) && !request()->boolean('embedded'))
    <header class="header">
        <div class="header-left">
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('dashboard', ['tab' => 'course-management']) }}" class="back-link" style="margin:0;">Back to Course Management</a>
        </div>
    </header>
    @endif
    <div class="page-container">
        <h1>Add Course</h1>
        <div class="card" aria-live="polite">
            <div class="progress" role="status" aria-live="polite" aria-label="Course setup progress">
                <div class="progress-track" aria-hidden="true">
                    <div id="courseProgressFill" class="progress-fill"></div>
                </div>
                <div id="courseProgressText" class="progress-status">0% complete</div>
                <div class="progress-steps">
                    <span id="step1" class="step"><span class="step-index">1</span><span>Details</span></span>
                    <span id="step2" class="step"><span class="step-index">2</span><span>Modules</span></span>
                </div>
            </div>
            <div class="tabs" role="tablist">
                <button id="tabBtn1" class="tab active" role="tab" aria-controls="tab1" aria-selected="true">Course Details</button>
                <button id="tabBtn2" class="tab disabled" role="tab" aria-controls="tab2" aria-selected="false" tabindex="-1">Modules Management</button>
            </div>
            @if($errors->create_course->any())
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach ($errors->create_course->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="courseForm" action="{{ !empty($forTrainer) ? route('trainer.courses.store') : route('courses.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if(request()->boolean('embedded'))
                    <input type="hidden" name="embedded" value="1">
                @endif
                <div id="tab1" class="tab-content active">
                    <div class="two-col">
                        <div class="left">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-book"></i> Course Name</div>
                                <input id="name" type="text" name="name" required maxlength="100" aria-describedby="nameError" placeholder="Add a short, clear title">
                                <div id="nameError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-align-left"></i> Course Description</div>
                                <textarea id="description" name="description" rows="4" maxlength="1000" required aria-describedby="descError" placeholder="Describe what learners will achieve"></textarea>
                                <div id="descError" class="error-text" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-layer-group"></i> Subject Area Category</div>
                                <select id="subject_area" name="subject_area" required aria-describedby="subjectError">
                                    <option value="" disabled selected>Select Subject Area</option>
                                    <option value="Core Governance & Administration">Core Governance & Administration</option>
                                    <option value="Finance & Compliance">Finance & Compliance</option>
                                    <option value="Digital Transformation">Digital Transformation</option>
                                    <option value="ICT & Technical Skills">ICT & Technical Skills</option>
                                    <option value="Human Capital & Leadership">Human Capital & Leadership</option>
                                    <option value="Community & Development Planning">Community & Development Planning</option>
                                    <option value="Economic & Business Development">Economic & Business Development</option>
                                    <option value="Social Governance">Social Governance</option>
                                </select>
                                <div id="subjectError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-image"></i> Course Image</div>
                                <input id="image" type="file" name="image" accept="image/*" required aria-describedby="imageError">
                                <div id="imageError" class="error-text" style="display:none;"></div>
                                <div class="preview-thumb" id="imagePreview"><span style="color:#94a3b8;">No image selected</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="saveDraftBtn">Save Draft</button>
                        <button type="button" class="btn btn-submit" id="nextToModules">Next</button>
                    </div>
                </div>
                <div id="tab2" class="tab-content">
                    <div class="form-group">
                        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom:8px;">
                            <label style="margin:0;">Modules & Topics</label>
                        </div>
                        <div id="modulesContainer" style="display:flex;flex-direction:column;gap:10px;"></div>
                        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
                            <button type="button" class="btn btn-primary" style="width:48px;height:48px;border-radius:50%;padding:0;display:flex;align-items:center;justify-content:center;font-size:24px;box-shadow:0 4px 12px rgba(13,110,253,0.3);" title="Add Module" onclick="dmAddModule()" aria-label="Add Module"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-primary" style="width:48px;height:48px;border-radius:50%;padding:0;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 4px 12px rgba(13,110,253,0.3);" title="Add Course Exam" onclick="dmAddExam()" aria-label="Add Course Exam"><i class="fas fa-file-circle-question"></i></button>
                        </div>
                        <div id="modulesError" class="error-text" style="display:none;"></div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="backToDetails">Back</button>
                        <div>
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn2">Save Draft</button>
                            <button type="submit" class="btn {{ !empty($forTrainer) ? 'btn-blue' : 'btn-blue' }}" id="submitBtn">{{ !empty($forTrainer) ? 'Submit to Admin' : 'Add Course' }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="dynamicMenu" aria-hidden="true">
        <div class="dm-container" aria-label="Dynamic field menu">
            <div class="dm-rail" role="toolbar" aria-orientation="vertical" aria-label="Section tools">
                <button type="button" class="rail-btn" data-type="field" title="Add Text" aria-label="Add Text" onclick="dmAddTextInput()"><i class="fas fa-font"></i><span class="rail-label">Add Text</span></button>
                <button type="button" class="rail-btn" data-type="field" title="Add Image" aria-label="Add Image" onclick="dmAddImageUpload()"><i class="fas fa-image"></i><span class="rail-label">Add Image (upload)</span></button>
                <button type="button" class="rail-btn" data-type="field" title="Add Video" aria-label="Add Video" onclick="dmAddVideoUpload()"><i class="fas fa-video"></i><span class="rail-label">Add Video (upload)</span></button>
                <button type="button" class="rail-btn" data-type="field" title="Add Question" aria-label="Add Question" onclick="dmAddQuestion()"><i class="fas fa-dot-circle"></i><span class="rail-label">Add Questions</span></button>
                <button type="button" class="rail-btn" data-type="structure" title="Add Topic" aria-label="Add Topic" onclick="dmAddTopic()"><i class="fas fa-stream"></i><span class="rail-label">Add Topic</span></button>
                <button type="button" class="rail-btn" data-type="structure" title="Add Module" aria-label="Add Module" onclick="dmAddModule()"><i class="fas fa-layer-group"></i><span class="rail-label">Add Module</span></button>
            </div>
            </div>
        </div>
    </div>
    <div id="dmHelp" style="position:absolute;left:-9999px;top:-9999px;">Use Tab/Shift+Tab to move between menu buttons. Press Enter or Space to activate.</div>
    <script>
        function createModule() {
            const container = document.getElementById('modulesContainer');
            const index = container.children.length; // number based on current modules
            const wrapper = document.createElement('div');
            wrapper.className = 'module-wrapper';
            wrapper.innerHTML = `
                <div class="module-header">
                    <div class="module-title">
                        <div class="module-index">${index+1}</div>
                        <span class="module-number-label">Module ${index+1}:</span>
                        <input class="module-title-input" type="text" name="modules[${index}][title]" placeholder="Module title" required>
                    </div>
                    <div class="module-actions">
                        <button type="button" class="panel-add-btn" title="Add field" aria-label="Add field" onclick="openRailFromAdd(this, event)"><i class="fas fa-plus"></i></button>
                        <button type="button" class="delete-btn" title="Delete module" onclick="removeModule(this, event)"><i class="fas fa-trash-alt"></i></button>
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
                        <span style="color:#6b7280;width:40px;">${moduleIndex+1}.${idx}</span>
                        <input type="text" name="modules[${moduleIndex}][topics][${idx}][title]" placeholder="Topic title" required maxlength="80" style="flex:1;">
                    </div>
                    <div style="display:flex;gap:8px;">
                        <button type="button" class="btn btn-small" style="background:#0038A7;" onclick="addSubtopicRow(this)">Add Subtopic</button>
                        <button type="button" class="delete-btn" title="Delete topic" onclick="removeTopicRow(this)"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="subtopics" style="display:flex;flex-direction:column;gap:8px;"></div>
            `;
            topics.appendChild(row);
            updateProgress();
        }
        function addSubtopicRow(btnOrRow){
            const topicRow = (btnOrRow && btnOrRow.closest) ? btnOrRow.closest('.topic-row') : btnOrRow;
            if(!topicRow) return;
            const wrapper = topicRow.closest('.module-wrapper');
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const topicsContainer = wrapper.querySelector('.topics');
            const topicIndex = Array.from(topicsContainer.children).indexOf(topicRow);
            const subs = topicRow.querySelector('.subtopics');
            const sIdx = subs.children.length;
            const sub = document.createElement('div');
            sub.className = 'subtopic-row';
            sub.style.cssText = 'border:1px dashed #e5e7eb;border-radius:8px;padding:10px;background:#fff';
            sub.innerHTML = `
                <div style="display:flex;align-items:center;gap:10px;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;flex:1;">
                        <span style="color:#6b7280;width:60px;">${moduleIndex+1}.${topicIndex}.${sIdx+1}</span>
                        <input type="text" name="modules[${moduleIndex}][topics][${topicIndex}][subtopics][${sIdx}][title]" placeholder="Subtopic title" required maxlength="80" style="flex:1;">
                    </div>
                    <button type="button" class="delete-btn" title="Delete subtopic" onclick="this.closest('.subtopic-row').remove(); reindexSubtopics(${moduleIndex}, ${topicIndex}, this);"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="fields-panel" style="margin-top:8px;">
                    <div class="field-list"></div>
                    <textarea name="modules[${moduleIndex}][topics][${topicIndex}][subtopics][${sIdx}][fields_json]" style="display:none"></textarea>
                </div>
                <button type="button" class="panel-add-btn" title="Add field" aria-label="Add field" onclick="openRailFromAdd(this, event)"><i class="fas fa-plus"></i></button>
            `;
            subs.appendChild(sub);
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
            if(lastTopic){
                addSubtopicRow(lastTopic);
                const lastPanel = lastTopic.querySelector('.subtopic-row:last-of-type .fields-panel');
                if(lastPanel){
                    addTextField(lastPanel);
                    const lastField = lastPanel.querySelector('.field-block:last-of-type');
                    if(lastField && typeof setActiveAnchor === 'function'){ setActiveAnchor(lastField); }
                } else if(typeof setActiveAnchor === 'function'){ setActiveAnchor(lastTopic); }
            }
        }
        function removeTopicRow(btn){
            if(!confirm('Remove this topic and its fields?')) return;
            const row = btn.closest('.topic-row');
            const topics = row.parentElement;
            row.remove();
            reindexTopics(topics);
            updateProgress();
        }
        function reindexTopics(container){
            const wrapper = container.closest('.module-wrapper');
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const rows = Array.from(container.children);
            rows.forEach((row, idx) => {
                row.querySelector('span').textContent = `${moduleIndex+1}.${idx}`;
                const titleInput = row.querySelector('input[type=text]');
                titleInput.name = `modules[${moduleIndex}][topics][${idx}][title]`;
                reindexSubtopics(moduleIndex, idx, row);
            });
        }
        function reindexSubtopics(moduleIndex, topicIndex, topicRow){
            const subs = topicRow.querySelector('.subtopics');
            if(!subs) return;
            const items = Array.from(subs.children);
            items.forEach((sub, sIdx)=>{
                const label = sub.querySelector('span');
                if(label) label.textContent = `${moduleIndex+1}.${topicIndex}.${sIdx+1}`;
                const input = sub.querySelector('input[type=text]');
                if(input) input.name = `modules[${moduleIndex}][topics][${topicIndex}][subtopics][${sIdx}][title]`;
                const ta = sub.querySelector('textarea[name$="[fields_json]"]');
                if(ta) ta.name = `modules[${moduleIndex}][topics][${topicIndex}][subtopics][${sIdx}][fields_json]`;
            });
        }
        function removeModule(btn, event){
            event.stopPropagation();
            const wrapper = btn.closest('.module-wrapper');
            wrapper.remove();
            reindexModules();
            updateProgress();
        }
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
                    // Reindex topics inside
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
        function insertLink(btn){
            const url = prompt('Enter URL');
            if(!url) return;
            const editor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            document.execCommand('createLink', false, url);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function insertTable(btn){
            const rows = parseInt(prompt('Rows'), 10) || 2;
            const cols = parseInt(prompt('Columns'), 10) || 2;
            let html = '<table style="width:100%;border-collapse:collapse;" border="1">';
            for(let r=0;r<rows;r++){ html += '<tr>'; for(let c=0;c<cols;c++){ html += '<td style="padding:6px;">&nbsp;</td>'; } html += '</tr>'; }
            html += '</table>';
            const editor = btn.closest('.text-block')?.querySelector('.editor') || btn.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            document.execCommand('insertHTML', false, html);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function triggerImagePicker(btn){
            const input = btn.parentElement.querySelector('input[type=file]');
            input.click();
        }
        function insertImageFromInput(input){
            const file = input.files && input.files[0];
            if(!file) return;
            const types = ['image/jpeg','image/png','image/gif'];
            if (!types.includes(file.type) || file.size > 5 * 1024 * 1024) {
                alert('Invalid image. Max 5MB. JPG, PNG, GIF only.');
                input.value = '';
                return;
            }
            const editor = input.closest('.text-block')?.querySelector('.editor') || input.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            const placeholder = `<div style="padding:8px;border:1px dashed #cbd5e1;border-radius:8px;margin:6px 0;background:#f8fafc;">
                <strong>Image selected:</strong> ${file.name}
                <div style="font-size:12px;color:#64748b;">Will be handled outside text fields</div>
            </div>`;
            document.execCommand('insertHTML', false, placeholder);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        function triggerVideoPicker(btn){
            const input = btn.parentElement.querySelector('input[type=file][data-video]');
            input.click();
        }
        function insertVideoFromFile(input){
            const file = input.files && input.files[0];
            if(!file) return;
            const types = ['video/mp4','video/webm','video/ogg'];
            if (!types.includes(file.type) || file.size > 200 * 1024 * 1024) {
                alert('Invalid video. Max 200MB. MP4/WebM/Ogg only.');
                input.value = '';
                return;
            }
            const editor = input.closest('.text-block')?.querySelector('.editor') || input.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            const placeholder = `<div style="padding:8px;border:1px dashed #cbd5e1;border-radius:8px;margin:6px 0;background:#f8fafc;">
                <strong>Video selected:</strong> ${file.name}
                <div style="font-size:12px;color:#64748b;">Will be handled outside text fields</div>
            </div>`;
            document.execCommand('insertHTML', false, placeholder);
            syncFieldsJSON(editor.closest('.fields-panel'));
        }
        // Fields builder
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
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
        }
        function moveFieldDown(btn){
            const block = btn.closest('.field-block');
            const panel = block.closest('.fields-panel');
            if(block.nextElementSibling){ block.parentElement.insertBefore(block.nextElementSibling, block); }
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
        }
        function ensureReflectionLast(panel){
            if(!panel) return;
            const list = panel.querySelector('.field-list');
            if(!list) return;
            const reflections = Array.from(list.querySelectorAll('.field-block[data-type="reflection"]'));
            reflections.forEach(r => list.appendChild(r));
        }
        // Removed quickAdd* helpers in favor of unified dynamic menu
        function addTextField(origin){
            const panel = (origin && origin.classList && origin.classList.contains('fields-panel'))
                ? origin
                : origin.closest ? origin.closest('.fields-panel') : null;
            const list = panel.querySelector('.field-list');
            const block = document.createElement('div');
            block.className = 'field-block text-block';
            block.setAttribute('data-type','text');
            block.innerHTML = `
                <div class="editor-toolbar" style="display:none">
                    <input type="file" accept="image/png,image/jpeg,image/gif" onchange="insertImageFromInput(this)">
                    <input type="file" accept="video/mp4,video/webm,video/ogg" data-video="1" onchange="insertVideoFromFile(this)">
                </div>
                <div class="editor" contenteditable="true" aria-label="Text field editor"></div>
                <div class="q-actions" style="position:relative;">
                    <div class="right">
                        <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate field"><i class="fas fa-clone"></i></button>
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete field"><i class="fas fa-trash"></i></button>
                        <span class="divider"></span>
                        <div class="field-move-controls" aria-label="Move field actions">
                            <button type="button" class="field-move-btn" onclick="moveFieldUp(this)" title="Move up" aria-label="Move up"><i class="fas fa-arrow-up"></i></button>
                            <button type="button" class="field-move-btn" onclick="moveFieldDown(this)" title="Move down" aria-label="Move down"><i class="fas fa-arrow-down"></i></button>
                        </div>
                    </div>
                </div>
            `;
            list.appendChild(block);
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            if(origin && origin.closest){
                const menuWrap = origin.closest('.add-menu');
                if(menuWrap) menuWrap.style.display='none';
            }
            ensureReflectionLast(panel);
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
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
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
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete question"><i class="fas fa-trash"></i></button>
                            <span class="divider"></span>
                            <div class="field-move-controls" aria-label="Move field actions">
                                <button type="button" class="field-move-btn" onclick="moveFieldUp(this)" title="Move up" aria-label="Move up"><i class="fas fa-arrow-up"></i></button>
                                <button type="button" class="field-move-btn" onclick="moveFieldDown(this)" title="Move down" aria-label="Move down"><i class="fas fa-arrow-down"></i></button>
                            </div>
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
            if(origin && origin.closest){
                const menuWrap = origin.closest('.add-menu');
                if(menuWrap) menuWrap.style.display='none';
            }
            ensureReflectionLast(panel);
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
                    <input type="file" accept="image/png,image/jpeg,image/gif" onchange="insertImageFromInput(this)">
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
            ensureReflectionLast(panel);
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
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
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
                        <div class="left">
                            <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)">Duplicate</button>
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)">Delete</button>
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
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
            block.scrollIntoView({behavior:'smooth', block:'center'});
        }
        function duplicateField(btn){
            const panel = btn.closest('.fields-panel');
            const block = btn.closest('.field-block');
            const clone = block.cloneNode(true);
            block.parentElement.insertBefore(clone, block.nextSibling);
            // Rebind events
            clone.querySelectorAll('button').forEach(b=>{
                if(b.textContent==='Delete'){ b.onclick = function(){ deleteField(this); }; }
                if(b.textContent==='Duplicate'){ b.onclick = function(){ duplicateField(this); }; }
                if(b.textContent==='Image'){ b.onclick = function(){ triggerImagePicker(this); }; }
                if(b.textContent==='Video'){ b.onclick = function(){ triggerVideoPicker(this); }; }
                if(b.textContent==='Link'){ b.onclick = function(){ insertLink(this); }; }
                if(b.textContent==='Table'){ b.onclick = function(){ insertTable(this); }; }
            });
            const inputFile = clone.querySelector('input[type=file]');
            if(inputFile){ inputFile.onchange = function(){ insertImageFromInput(this); }; }
            const videoFile = clone.querySelector('input[type=file][data-video]');
            if(videoFile){ videoFile.onchange = function(){ insertVideoFromFile(this); }; }
            clone.querySelectorAll('.q-type').forEach(sel=>{
                sel.addEventListener('change', function(){
                    setupDefaultOptions(clone);
                    syncFieldsJSON(panel);
                });
            });
            // Reset radio group for correct answer in clone
            const newGroup = `correct-${Date.now()}-${Math.floor(Math.random()*1000)}`;
            clone.setAttribute('data-correct', newGroup);
            clone.querySelectorAll('.q-correct').forEach(r => { r.name = newGroup; r.checked = false; });
            clone.addEventListener('input', ()=> syncFieldsJSON(panel));
            clone.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(clone); });
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
        }
        function deleteField(btn){
            const panel = btn.closest('.fields-panel');
            btn.closest('.field-block').remove();
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
        }
        function syncFieldsJSON(panel){
            const blocks = Array.from(panel.querySelectorAll('.field-block'));
            const nonRef = [];
            const ref = [];
            blocks.forEach(b=>{
                const t = b.getAttribute('data-type');
                if(t === 'text'){
                    const html = b.querySelector('.editor').innerHTML;
                    nonRef.push({ type:'text', html });
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
                    } else if(type === 'identification'){
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
                    nonRef.push({ type:'question', question: q });
                } else if(t === 'reflection'){
                    ref.push({ 
                        type:'reflection', 
                        prompts:['What did you learn?'] 
                    });
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
                    nonRef.push({ type:'exam', timer_minutes: duration, questions: qs });
                }
            });
            const fields = nonRef.concat(ref);
            const textarea = panel.querySelector('textarea[name$="[fields_json]"]');
            textarea.value = JSON.stringify(fields);
        }
        // Legacy question helpers reused by question field
        function addQuestionBlock(btn){
            const panel = btn.closest('.questions-panel');
            const list = panel.querySelector('.q-list');
            const block = document.createElement('div');
            block.className = 'q-block';
            block.innerHTML = `
                <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:end">
                    <label class="q-col" style="display:block">
                        <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                        <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                    </label>
                    <label class="q-col" style="display:block">
                        <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                        <select class="q-type">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="identification">Identification</option>
                            <option value="true_false">True or False</option>
                            <option value="essay">Essay</option>
                        </select>
                    </label>
                </div>
                <div class="q-options"></div>
                <div class="q-actions">
                    <div class="left">
                        <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateQuestion(this)">Duplicate</button>
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteQuestion(this)">Delete</button>
                    </div>
                    <label class="toggle"><input type="checkbox" class="q-required"> Required</label>
                </div>
            `;
            list.appendChild(block);
            __bindAutosizeTextareas(block);
            setupDefaultOptions(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncQuestionsJSON(panel);
            });
            block.addEventListener('input', ()=> syncQuestionsJSON(panel));
            syncQuestionsJSON(panel);
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
            const fieldsPanel = container.closest('.fields-panel');
            if(fieldsPanel){
                row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> syncFieldsJSON(fieldsPanel)));
            } else {
                row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> syncQuestionsJSON(container.closest('.questions-panel'))));
            }
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
                    const panel = container.closest('.fields-panel') || container.closest('.questions-panel');
                    if(panel && panel.classList.contains('fields-panel')) {
                        syncFieldsJSON(panel);
                    } else if(panel) {
                        syncQuestionsJSON(panel);
                    }
                });
            }
            // Always append to ensure it sits after the last option (e.g., after Choice D)
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
                const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
            });
            container.appendChild(row);
            const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
            row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> {
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
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
                const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
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
                const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
            });
            container.appendChild(row);
            const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
            row.querySelectorAll('input').forEach(i => i.addEventListener('input', ()=> {
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
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
                const fp = container.closest('.fields-panel') || container.closest('.questions-panel');
                if(fp && fp.classList.contains('fields-panel')) syncFieldsJSON(fp); else if(fp) syncQuestionsJSON(fp);
            });
            container.appendChild(link);
        }
        function removeOptionRow(btn){
            const container = btn.closest('.q-options');
            btn.closest('.q-option-row').remove();
            const panel = container.closest('.fields-panel') || container.closest('.questions-panel');
            if(panel && panel.classList.contains('fields-panel')) {
                syncFieldsJSON(panel);
            } else if(panel) {
                syncQuestionsJSON(panel);
            }
        }
        function duplicateQuestion(btn){
            const block = btn.closest('.q-block');
            const clone = block.cloneNode(true);
            block.parentElement.insertBefore(clone, block.nextSibling);
            // Re-bind events
            clone.querySelectorAll('button').forEach(b=>{
                if(b.textContent==='X'){ b.onclick = function(){ removeOptionRow(this); }; }
                if(b.textContent==='Delete'){ b.onclick = function(){ deleteQuestion(this); }; }
                if(b.textContent==='Duplicate'){ b.onclick = function(){ duplicateQuestion(this); }; }
            });
            clone.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(clone);
                syncQuestionsJSON(clone.closest('.questions-panel'));
            });
            clone.addEventListener('input', ()=> syncQuestionsJSON(clone.closest('.questions-panel')));
            syncQuestionsJSON(clone.closest('.questions-panel'));
        }
        function deleteQuestion(btn){
            const panel = btn.closest('.questions-panel');
            btn.closest('.q-block').remove();
            syncQuestionsJSON(panel);
        }
        function syncQuestionsJSON(panel){
            const list = panel.querySelectorAll('.q-block');
            const questions = [];
            list.forEach(b=>{
                const type = b.querySelector('.q-type').value;
                const title = b.querySelector('.q-title').value || 'Untitled Question';
                const required = false;
                const q = { type, title, required };
                if(type === 'multiple_choice'){
                    const opts = Array.from(b.querySelectorAll('.q-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                    q.options = opts;
                } else if(type === 'true_false'){
                    q.options = ['True','False'];
                } else if(type === 'identification'){
                    const answers = Array.from(b.querySelectorAll('.q-blanks .q-blank-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                    q.answers = answers;
                } else if(type === 'essay'){
                    const rb = b.querySelector('.q-essay')?.value || '';
                    if(rb) q.rubric = rb;
                }
                questions.push(q);
            });
            const textarea = panel.querySelector('textarea[name$="[questions_json]"]');
            textarea.value = JSON.stringify(questions);
        }
        function validateDetails(){
            let ok = true;
            const name = document.getElementById('name');
            const desc = document.getElementById('description');
            const subj = document.getElementById('subject_area');
            const image = document.getElementById('image');
            const setError = (el, msgId, msg) => { const n = document.getElementById(msgId); if(msg){ n.style.display='block'; n.textContent = msg; el.setAttribute('aria-invalid', 'true'); } else { n.style.display='none'; n.textContent=''; el.removeAttribute('aria-invalid'); } };
            if(!name.value.trim() || name.value.length > 100){ ok = false; setError(name,'nameError','Name is required (max 100).'); } else setError(name,'nameError','');
            if(!desc.value.trim() || desc.value.length > 1000){ ok = false; setError(desc,'descError','Description is required, max 1000 characters.'); } else setError(desc,'descError','');
            if(!subj.value){ ok = false; setError(subj,'subjectError','Select a subject area.'); } else setError(subj,'subjectError','');
            if(!image.files || !image.files[0]){
                ok = false; 
                setError(image,'imageError','Image is required.');
            } else {
                const f = image.files[0];
                const okType = f.type && f.type.startsWith('image/');
                const okSize = f.size <= 5*1024*1024;
                if(!okType || !okSize){
                    ok = false;
                    setError(image,'imageError','Image must be JPG/PNG/GIF/WebP and ≤ 5MB.');
                } else {
                    setError(image,'imageError','');
                }
            }
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
            });
            const err = document.getElementById('modulesError');
            if(!ok){ err.style.display='block'; err.textContent='Add at least one module with topic titles (max 80 chars).'; } else { err.style.display='none'; err.textContent=''; }
            return ok;
        }
        function isDetailsStepComplete(){
            const name = document.getElementById('name');
            const desc = document.getElementById('description');
            const subj = document.getElementById('subject_area');
            const image = document.getElementById('image');

            const validName = !!name && !!name.value.trim() && name.value.trim().length <= 100;
            const validDesc = !!desc && !!desc.value.trim() && desc.value.trim().length <= 1000;
            const validSubj = !!subj && !!subj.value;

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
        function updateProgress(){
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const progressFill = document.getElementById('courseProgressFill');
            const progressText = document.getElementById('courseProgressText');
            const detailsDone = isDetailsStepComplete();
            const modulesDone = isModulesStepComplete();

            step1.classList.toggle('done', detailsDone);
            step2.classList.toggle('done', modulesDone);

            const completedCount = (detailsDone ? 1 : 0) + (modulesDone ? 1 : 0);
            const percent = Math.round((completedCount / 2) * 100);
            if (progressFill) progressFill.style.width = `${percent}%`;
            if (progressText) progressText.textContent = `${percent}% complete (${completedCount}/2 steps)`;

            const tab2Btn = document.getElementById('tabBtn2');
            const enable = detailsDone;
            tab2Btn.classList.toggle('disabled', !enable);
            tab2Btn.setAttribute('aria-disabled', enable ? 'false' : 'true');
            tab2Btn.setAttribute('tabindex', enable ? '0' : '-1');
        }
        function switchTo(tab){
            document.getElementById('tab1').classList.toggle('active', tab===1);
            document.getElementById('tab2').classList.toggle('active', tab===2);
            document.getElementById('tabBtn1').classList.toggle('active', tab===1);
            document.getElementById('tabBtn2').classList.toggle('active', tab===2);
            document.getElementById('tabBtn1').setAttribute('aria-selected', tab===1 ? 'true':'false');
            document.getElementById('tabBtn2').setAttribute('aria-selected', tab===2 ? 'true':'false');
            if(tab === 2){ ensureDefaultModule(); }
        }
        function ensureDefaultModule(){
            updateProgress();
        }
        function bindTabs(){
            document.getElementById('tabBtn1').addEventListener('click', ()=> switchTo(1));
            document.getElementById('tabBtn2').addEventListener('click', ()=>{
                if(validateDetails()) switchTo(2);
            });
            document.getElementById('nextToModules').addEventListener('click', ()=>{
                if(validateDetails()) switchTo(2); updateProgress();
            });
            document.getElementById('backToDetails').addEventListener('click', ()=> switchTo(1));
            // Removed Create Module button; creation handled via toolbar only
            ['name','description','subject_area','image'].forEach(id=>{
                const el = document.getElementById(id);
                el.addEventListener('input', updateProgress);
                el.addEventListener('change', updateProgress);
            });
            document.getElementById('courseForm').addEventListener('submit', (e)=>{
                updateProgress();
                if(!validateDetails() || !validateModules()){ e.preventDefault(); switchTo(!validateDetails()?1:2); }
            });
        }
        function draftKey(){ return 'draft_course_create'; }
        function saveDraft(){
            const form = document.getElementById('courseForm');
            const data = new FormData(form);
            const obj = {};
            data.forEach((v,k)=>{ if(!(v instanceof File)) obj[k]=v; });
            localStorage.setItem(draftKey(), JSON.stringify(obj));
            alert('Draft saved.');
        }
        function restoreDraft(){
            const raw = localStorage.getItem(draftKey());
            if(!raw) return;
            try{
                const obj = JSON.parse(raw);
                ['name','description','subject_area'].forEach(k=>{
                    if(obj[k] !== undefined){ const el = document.querySelector(`[name="${k}"]`); if(el) el.value = obj[k]; }
                });
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
            document.getElementById('saveDraftBtn').addEventListener('click', saveDraft);
            document.getElementById('saveDraftBtn2').addEventListener('click', saveDraft);
            updateProgress();
            __bindAutosizeTextareas(document);
            initDynamicMenu();
            const img = document.getElementById('image');
            if(img){
                img.addEventListener('change', function(){
                    const p = document.getElementById('imagePreview');
                    const f = img.files && img.files[0];
                    if(!f){ p.innerHTML = '<span style="color:#94a3b8;">No image selected</span>'; return; }
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
        });

        // Dynamic Menu (follows active field)
        let DM_STATE = {
            el: null,
            currentAnchor: null,
            menuTrigger: null,
            context: null,
            hovering: false,
            hoverTimer: null,
            raf: null,
            lastPos: {x: -1, y: -1}
        };
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
                // Close panel on outside click
                if(!dm.contains(e.target) && panel && trigger) closePanel();
                // Clear selection and hide toolbar if click does not target a selectable anchor or the toolbar
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

            // Keyboard navigation: allow Tab/Shift+Tab naturally; add key handlers for Enter/Space
            dm.addEventListener('keydown', (e)=>{
                if((e.key === 'Enter' || e.key === ' ') && e.target.classList.contains('dm-btn')){
                    e.preventDefault();
                    e.target.click();
                }
            });

            // Disable hover-based hide behavior; visibility is controlled by selection only
            dm.addEventListener('mouseenter', ()=>{});
            dm.addEventListener('mouseleave', ()=>{});

            // Track focus changes
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

            // Reposition on scroll/resize (capture for nested scrollables)
            const onScrollOrResize = ()=> { disableAnimTemporarily(); requestDMReposition(); };
            window.addEventListener('resize', onScrollOrResize, {passive:true});
            document.addEventListener('scroll', onScrollOrResize, {passive:true, capture:true});
            // Extra listeners to keep it stuck during fast scrolling and keyboard scroll
            document.addEventListener('wheel', onScrollOrResize, {passive:true, capture:true});
            document.addEventListener('touchmove', onScrollOrResize, {passive:true, capture:true});
            document.addEventListener('keydown', (e)=> {
                if(['PageDown','PageUp','ArrowDown','ArrowUp','Home','End',' '].includes(e.key)){
                    disableAnimTemporarily();
                    requestDMReposition();
                }
            }, {capture:true});

            // MutationObserver for dynamically added fields
            const mo = new MutationObserver((mutations)=>{
                for(const m of mutations){
                    for(const node of m.addedNodes){
                        if(!(node instanceof HTMLElement)) continue;
                        if(node.matches && (node.matches('.field-block, .q-title, .q-option, .editor, .module-title-input') || node.querySelector('.field-block'))){
                            // Rely on event delegation; just ensure any immediately-focused element is handled
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
            // Ignore hidden/disabled
            if(target.closest('[disabled], [aria-disabled="true"]')) return null;
            let field = target.closest('.field-block');
            if(field) return field;
            const subRow = target.closest('.subtopic-row');
            if(subRow) return subRow;
            // Fallbacks: topic input or module title as anchors
            const topicRow = target.closest('.topic-row');
            if(topicRow) return topicRow;
            const moduleHeader = target.closest('.module-header');
            if(moduleHeader) return moduleHeader;
            return null;
        }
        function setActiveAnchor(anchor, opts){
            if(!anchor || !isVisible(anchor)) { hideDM(); return; }
            const options = opts || {};
            // Visual feedback
            document.querySelectorAll('.active-section').forEach(el=> el.classList.remove('active-section'));
            anchor.classList.add('active-section');
            DM_STATE.currentAnchor = anchor;
            if(Object.prototype.hasOwnProperty.call(options, 'menuTrigger')){
                DM_STATE.menuTrigger = options.menuTrigger || null;
            }
            if(Object.prototype.hasOwnProperty.call(options, 'context')){
                DM_STATE.context = options.context || null;
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
            DM_STATE.context = null;
            hideDM();
        }
        function isVisible(el){
            const rects = el.getClientRects();
            if(!rects || rects.length === 0) return false;
            const style = window.getComputedStyle(el);
            if(style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') return false;
            return true;
        }
        function getAnchorRect(anchor){
            const rect = anchor.getBoundingClientRect();
            return {
                left: rect.left + window.scrollX,
                top: rect.top + window.scrollY,
                width: rect.width,
                height: rect.height
            };
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
            const context = anchor ? anchor.className.split(' ')[0] : 'default';
            if(anchor){
                setActiveAnchor(anchor, { showMenu: true, menuTrigger: btn, context: context });
            }else{
                DM_STATE.menuTrigger = btn;
                DM_STATE.context = context;
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
            const fieldName = deriveFieldLabel(anchor) || 'field';
            dm.querySelectorAll('.dm-btn').forEach(b=>{
                const base = b.getAttribute('title') || 'Action';
                b.setAttribute('aria-label', `Dynamic menu for ${fieldName}: ${base}`);
            });
            dm.style.zIndex = '2000';
            dm.classList.add('visible');
            dm.setAttribute('aria-hidden','false');
            if(DM_STATE.context){
                dm.setAttribute('data-context', DM_STATE.context);
            }else{
                dm.removeAttribute('data-context');
            }
            updateDMEditingMode(document.activeElement);
            requestDMReposition();
        }
        function hideDM(){
            const dm = DM_STATE.el;
            dm.classList.remove('visible');
            dm.classList.remove('is-editing');
            dm.setAttribute('aria-hidden','true');
            dm.removeAttribute('data-context');
        }
        function deriveFieldLabel(anchor){
            if(anchor.matches('.field-block')){
                const title = anchor.querySelector('.q-title');
                if(title && title.value) return title.value;
                if(anchor.classList.contains('text-block')) return 'Text block';
                return 'Question';
            }
            if(anchor.matches('.topic-row')) return anchor.querySelector('input[type="text"]')?.value || 'Topic';
            if(anchor.matches('.module-header')) return anchor.querySelector('.module-title-input')?.value || 'Module';
            return 'field';
        }
        // Helper function to expand the module accordion
        function expandModuleAccordion(element){
            if(!element) return;
            const moduleWrapper = element.closest('.module-wrapper');
            if(!moduleWrapper) return;
            const body = moduleWrapper.querySelector('.module-body');
            const chevronBtn = moduleWrapper.querySelector('.chevron-btn');
            if(body && body.style.display !== 'block'){
                body.style.display = 'block';
                if(chevronBtn){
                    const icon = chevronBtn.querySelector('i');
                    if(icon) icon.style.transform = 'rotate(180deg)';
                }
            }
        }
        // Helper function to ensure a fields panel exists
        function ensureFieldsPanel(){
            let panel = document.querySelector('.fields-panel');
            if(panel) return panel;
            
            // Create module if doesn't exist
            const container = document.getElementById('modulesContainer');
            if(!container || container.children.length === 0){
                createModule();
            }
            
            // Create topic if doesn't exist
            const moduleWrapper = document.querySelector('.module-wrapper:last-of-type');
            if(!moduleWrapper) return null;
            
            const moduleBody = moduleWrapper.querySelector('.module-body');
            if(moduleBody.style.display !== 'block'){
                moduleBody.style.display = 'block';
                const chevron = moduleWrapper.querySelector('.chevron-btn i');
                if(chevron) chevron.style.transform = 'rotate(180deg)';
            }
            
            let topicRow = moduleBody.querySelector('.topic-row');
            if(!topicRow){
                addTopicInput(moduleBody);
                topicRow = moduleBody.querySelector('.topic-row:last-of-type');
            }
            
            // Create subtopic if doesn't exist
            let subtopicRow = topicRow?.querySelector('.subtopic-row');
            if(!subtopicRow){
                addSubtopicRow(topicRow);
                subtopicRow = topicRow?.querySelector('.subtopic-row:last-of-type');
            }
            
            panel = subtopicRow?.querySelector('.fields-panel');
            return panel;
        }
        // Dynamic menu action hooks
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
            
            // If still no panel, ensure structure exists
            if(!panel){
                panel = ensureFieldsPanel();
            }
            
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                setSelectedField(last);
                if(last) setActiveAnchor(last);
                expandModuleAccordion(panel);
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
            
            // If still no panel, ensure structure exists
            if(!panel){
                panel = ensureFieldsPanel();
            }
            
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                const input = last.querySelector('input[type=file]:not([data-video])');
                if(input) input.click();
                setSelectedField(last);
                expandModuleAccordion(panel);
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
            
            // If still no panel, ensure structure exists
            if(!panel){
                panel = ensureFieldsPanel();
            }
            
            if(panel){
                addTextField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                const input = last.querySelector('input[type=file][data-video]');
                if(input) input.click();
                setSelectedField(last);
                expandModuleAccordion(panel);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
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
            
            // If still no panel, ensure structure exists
            if(!panel){
                panel = ensureFieldsPanel();
            }
            
            if(panel){
                addQuestionField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                setSelectedField(last);
                if(last) setActiveAnchor(last);
                expandModuleAccordion(panel);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        function addReflectionField(panel){
            const list = panel.querySelector('.field-list');
            const block = document.createElement('div');
            block.className = 'field-block';
            block.setAttribute('data-type','reflection');
            block.innerHTML = `
                <div class="q-block">
                    <div class="q-header" style="font-weight:700;">Reflection</div>
                    <div class="refl-questions" style="margin:8px 0 4px 0; color:#111827;">
                        <div>• What did you learn?</div>
                    </div>
                </div>
            `;
            list.appendChild(block);
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            syncFieldsJSON(panel);
            block.scrollIntoView({behavior:'smooth', block:'center'});
        }
        function ensureModuleExam(wrapper){
            const body = wrapper.querySelector('.module-body');
            const host = body.querySelector('.module-exam');
            const hidden = body.querySelector('.module-exam-json');
            if(host.dataset.bound==='1') return host;
            host.dataset.bound = '1';
            host.innerHTML = `
                <div class="q-block">
                    <div class="q-header" style="display:flex;align-items:end;gap:12px;justify-content:space-between">
                        <div style="font-weight:800;color:#0B2C74">Exam</div>
                        <label style="display:flex;align-items:center;gap:8px">
                            <span style="font-weight:700;color:#111827">Timer (minutes)</span>
                            <input type="number" min="1" max="600" class="exam-duration" placeholder="e.g., 30" style="width:110px;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                        </label>
                    </div>
                    <div class="exam-questions" style="margin-top:10px">
                        <div class="exam-q-list"></div>
                        <div class="exam-q-builder" style="margin-top:10px;border-top:1px dashed #e5e7eb;padding-top:10px">
                            <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:end">
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                                    <textarea class="eq-text q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                                </label>
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                                    <select class="eq-type">
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="identification">Identification</option>
                                        <option value="true_false">True or False</option>
                                    </select>
                                </label>
                            </div>
                            <div class="eq-choices" style="margin-top:8px"></div>
                            <div class="eq-id" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <input class="eq-id-answer" type="text" placeholder="Enter answer" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-tf" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <select class="eq-tf-answer" style="padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="actions" style="display:flex;justify-content:center;gap:8px;margin-top:10px">
                                <button type="button" class="btn btn-ghost eq-add"><i class="fas fa-plus"></i> Add Question</button>
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
            renderChoices();
            function syncBuilderBoxes(){
                const t = host.querySelector('.eq-type').value;
                host.querySelector('.eq-choices').style.display = (t==='multiple_choice') ? 'block':'none';
                host.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                host.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                if(t==='multiple_choice' && host.querySelectorAll('.eq-option').length===0){ renderChoices(); }
            }
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
                if(!text) return;
                let obj = null;
                if(t==='multiple_choice'){
                    const opts = Array.from(host.querySelectorAll('.eq-option')).map(i=>i.value.trim()).filter(Boolean);
                    if(opts.length<2) return;
                    const checked = host.querySelector('.eq-correct:checked');
                    const ans = checked ? parseInt(checked.value,10) : 0;
                    obj = { type:'multiple_choice', text, choices: opts, answer_index: ans };
                }else if(t==='identification'){
                    const ans = (host.querySelector('.eq-id-answer').value||'').trim();
                    obj = { type:'identification', text, answer: ans };
                }else if(t==='true_false'){
                    const ans = host.querySelector('.eq-tf-answer').value === 'true';
                    obj = { type:'true_false', text, answer: ans };
                }
                const listEl = host.querySelector('.exam-q-list');
                const idx = listEl.children.length + 1;
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx+'. '+obj.text+'</div>'
                    + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                host.querySelector('.eq-text').value='';
                host.querySelectorAll('.eq-option').forEach(i=> i.value='');
                const r = host.querySelector('.eq-correct'); if(r) r.checked=false;
                host.querySelector('.eq-id-answer').value='';
                host.querySelector('.eq-tf-answer').value='true';
                syncExamJSON();
            });
            syncBuilderBoxes(); syncExamJSON();
            expandModuleAccordion(body);
            return host;
        }
        function createCourseExam(afterEl, prefill){
            const container = document.getElementById('modulesContainer');
            const idx = container.children.length;
            const wrap = document.createElement('div');
            wrap.className = 'exam-wrapper';
            wrap.innerHTML = `
                <div class="exam-header" style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid #e5e7eb;border-radius:10px;background:#fff">
                    <div style="font-weight:800;color:#0B2C74;display:flex;align-items:center;gap:8px;"><i class="fas fa-file-circle-question"></i> Course Exam</div>
                    <div>
                        <button type="button" class="delete-btn" title="Delete exam" onclick="this.closest('.exam-wrapper').remove(); reindexModules();"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="q-block">
                    <div class="q-header" style="display:flex;align-items:end;gap:12px;justify-content:space-between">
                        <div style="font-weight:800;color:#0B2C74">Course Exam</div>
                        <label style="display:flex;align-items:center;gap:8px">
                            <span style="font-weight:700;color:#111827">Timer (minutes)</span>
                            <input type="number" min="1" max="600" class="exam-duration" placeholder="e.g., 30" style="width:110px;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                        </label>
                    </div>
                    <div class="exam-questions" style="margin-top:10px">
                        <div class="exam-q-list"></div>
                        <div class="exam-q-builder" style="margin-top:10px;border-top:1px dashed #e5e7eb;padding-top:10px">
                            <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:end">
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                                    <textarea class="eq-text q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                                </label>
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                                    <select class="eq-type">
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="identification">Identification</option>
                                        <option value="true_false">True or False</option>
                                    </select>
                                </label>
                            </div>
                            <div class="eq-choices" style="margin-top:8px"></div>
                            <div class="eq-id" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <input class="eq-id-answer" type="text" placeholder="Enter answer" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-tf" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <select class="eq-tf-answer" style="padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="actions" style="display:flex;justify-content:center;gap:8px;margin-top:10px">
                                <button type="button" class="btn btn-ghost eq-add"><i class="fas fa-plus"></i> Add Question</button>
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
            __bindAutosizeTextareas(wrap);
            function renderChoices(){
                const wrapChoices = wrap.querySelector('.eq-choices');
                wrapChoices.innerHTML = '';
                const group = 'course_exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
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
            function syncBuilderBoxes(){
                const t = wrap.querySelector('.eq-type').value;
                wrap.querySelector('.eq-choices').style.display = (t==='multiple_choice') ? 'block':'none';
                wrap.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                wrap.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                if(t==='multiple_choice' && wrap.querySelectorAll('.eq-option').length===0){ renderChoices(); }
            }
            function syncExamJSON(){
                const duration = parseInt(wrap.querySelector('.exam-duration')?.value || '0', 10) || 0;
                const list = wrap.querySelectorAll('.exam-q-list .q-item');
                const qs = [];
                list.forEach(node=>{
                    try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && obj.text){ qs.push(obj); } }catch(e){}
                });
                wrap.querySelector('.exam-json').value = JSON.stringify({ timer_minutes: duration, questions: qs });
            }
            wrap.querySelector('.eq-type').addEventListener('change', ()=>{ syncBuilderBoxes(); syncExamJSON(); });
            wrap.addEventListener('input', syncExamJSON);
            wrap.addEventListener('change', syncExamJSON);
            wrap.querySelector('.eq-add').addEventListener('click', function(){
                const t = wrap.querySelector('.eq-type').value;
                const text = (wrap.querySelector('.eq-text').value||'').trim();
                if(!text) return;
                let obj = null;
                if(t==='multiple_choice'){
                    const opts = Array.from(wrap.querySelectorAll('.eq-option')).map(i=>i.value.trim()).filter(Boolean);
                    if(opts.length<2) return;
                    const checked = wrap.querySelector('.eq-correct:checked');
                    const ans = checked ? parseInt(checked.value,10) : 0;
                    obj = { type:'multiple_choice', text, choices: opts, answer_index: ans };
                }else if(t==='identification'){
                    const ans = (wrap.querySelector('.eq-id-answer').value||'').trim();
                    obj = { type:'identification', text, answer: ans };
                }else if(t==='true_false'){
                    const ans = wrap.querySelector('.eq-tf-answer').value === 'true';
                    obj = { type:'true_false', text, answer: ans };
                }
                const listEl = wrap.querySelector('.exam-q-list');
                const idx2 = listEl.children.length + 1;
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx2+'. '+obj.text+'</div>'
                    + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                wrap.querySelector('.eq-text').value='';
                wrap.querySelectorAll('.eq-option').forEach(i=> i.value='');
                const r = wrap.querySelector('.eq-correct'); if(r) r.checked=false;
                wrap.querySelector('.eq-id-answer').value='';
                wrap.querySelector('.eq-tf-answer').value='true';
                syncExamJSON();
            });
            renderChoices(); syncBuilderBoxes(); syncExamJSON();
            if(prefill){
                try{
                    wrap.querySelector('.exam-duration').value = prefill.timer_minutes || '';
                    const listEl = wrap.querySelector('.exam-q-list');
                    (prefill.questions||[]).forEach((q, i2)=>{
                        const node = document.createElement('div');
                        node.className = 'q-item';
                        node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(i2+1)+'. '+(q.text||q.title||'')+'</div>'
                            + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>';
                        node.dataset.payload = JSON.stringify(q);
                        listEl.appendChild(node);
                    });
                    syncExamJSON();
                }catch(e){}
            }
            reindexModules();
            return wrap;
        }
        function dmAddReflection(){
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
                addReflectionField(panel);
                const last = panel.querySelector('.field-block:last-of-type');
                setSelectedField(last);
                if(last) setActiveAnchor(last);
            }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }
        // Removed dmAddImage/dmAddVideo (toolbar restricted to four buttons)
        function dmAddTopic(){
            const anchor = DM_STATE.currentAnchor;
            const wrapper = anchor?.closest('.module-wrapper');
            const moduleBody = wrapper ? wrapper.querySelector('.module-body') : document.querySelector('.module-wrapper .module-body');
            if(moduleBody){
                expandModuleAccordion(moduleBody);
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
            const lastBody = document.querySelector('.module-wrapper:last-of-type .module-body');
            if(lastBody){
                lastBody.style.display = 'block';
                const lastChevron = document.querySelector('.module-wrapper:last-of-type .chevron-btn');
                if(lastChevron){
                    const icon = lastChevron.querySelector('i');
                    if(icon) icon.style.transform = 'rotate(180deg)';
                }
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
            } else if(container && container.lastElementChild){
                afterEl = container.lastElementChild;
            }
            const host = createCourseExam(afterEl);
            if(host) { host.scrollIntoView({behavior:'smooth', block:'center'}); }
            const p = document.getElementById('dmPanel'); if(p) p.classList.remove('open');
            clearActiveAnchor();
        }

        // Simple test harness (invoke in console: DynamicMenuTests.runAll())
        window.DynamicMenuTests = {
            testAddTopicToModule2(){
                // Setup two modules
                const container = document.getElementById('modulesContainer');
                container.innerHTML = '';
                createModule(); createModule();
                const secondHeader = document.querySelectorAll('.module-header')[1];
                setActiveAnchor(secondHeader);
                dmAddTopic();
                const secondBody = document.querySelectorAll('.module-body')[1];
                const t = secondBody.querySelector('.topic-row:last-of-type input[type="text"]');
                const ok = !!t && /\bmodules\[1\]\[topics\]\[\d+\]\[title\]/.test(t.name);
                console.log('TEST dmAddTopic -> Module 2 assignment:', ok ? 'PASS' : 'FAIL', t?.name);
                return ok;
            },
            testPositions(){
                const dm = document.getElementById('dynamicMenu');
                const fields = Array.from(document.querySelectorAll('.field-block, .topic-row, .module-header')).slice(0,6);
                const results = [];
                let i = 0;
                function next(){
                    if(i >= fields.length) { console.log('DM test positions:', results); return; }
                    const f = fields[i++];
                    f.scrollIntoView({behavior:'instant', block:'center'});
                    setActiveAnchor(f);
                    setTimeout(()=>{
                        const r = dm.getBoundingClientRect();
                        const v = {w:innerWidth,h:innerHeight};
                        const ok = (r.left>=0 && r.top>=0 && r.right<=v.w && r.bottom<=v.h);
                        results.push({target:f.className, ok, pos:{l:r.left,t:r.top}});
                        next();
                    }, 400);
                }
                next();
            },
            testPerformance(n=60){
                const t0 = performance.now();
                for(let i=0;i<n;i++) requestDMReposition();
                const t1 = performance.now();
                console.log('DM reposition batch time(ms):', (t1-t0).toFixed(2));
            },
            testStickOnScroll(){
                const dm = document.getElementById('dynamicMenu');
                const target = document.querySelector('.field-block') || document.querySelector('.topic-row') || document.querySelector('.module-header');
                if(!target){ console.warn('No anchor found for testStickOnScroll'); return; }
                target.scrollIntoView({behavior:'instant', block:'center'});
                setActiveAnchor(target);
                const start = target.getBoundingClientRect();
                window.scrollBy({top: 200, behavior:'instant'});
                setTimeout(()=>{
                    const after = target.getBoundingClientRect();
                    const r = dm.getBoundingClientRect();
                    const expectedXRight = Math.round(after.right + 12);
                    const expectedXLeft = Math.round(after.left - r.width - 12);
                    const dx = Math.min(Math.abs(r.left - expectedXRight), Math.abs(r.left - expectedXLeft));
                    const centeredY = Math.round(after.top + after.height/2 - r.height/2);
                    const dy = Math.abs(r.top - centeredY);
                    console.log('DM stick test dx,dy=', dx, dy, 'pass=', (dx<=8 && dy<=12));
                }, 300);
            },
            runAll(){ this.testPositions(); this.testPerformance(80); }
        };
    </script>
</body>
</html>
