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
                </div>
            </div>
            <div class="tabs" role="tablist">
                <button id="tabBtn1" class="tab active" role="tab" aria-controls="tab1" aria-selected="true">Course Details</button>
                <button id="tabBtn2" class="tab" role="tab" aria-controls="tab2" aria-selected="false" tabindex="-1">Modules Management</button>
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
                        </div>
                        <div class="right">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-layer-group"></i> Subject Area Category</div>
                                @php $sel = old('subject_area', $course->subject_area); @endphp
                                <select id="subject_area" name="subject_area" required aria-describedby="subjectError">
                                    <option value="" disabled>Select Subject Area</option>
                                    <option value="Core Governance & Administration" {{ $sel==='Core Governance & Administration'?'selected':'' }}>Core Governance & Administration</option>
                                    <option value="Finance & Compliance" {{ $sel==='Finance & Compliance'?'selected':'' }}>Finance & Compliance</option>
                                    <option value="Digital Transformation" {{ $sel==='Digital Transformation'?'selected':'' }}>Digital Transformation</option>
                                    <option value="ICT & Technical Skills" {{ $sel==='ICT & Technical Skills'?'selected':'' }}>ICT & Technical Skills</option>
                                    <option value="Human Capital & Leadership" {{ $sel==='Human Capital & Leadership'?'selected':'' }}>Human Capital & Leadership</option>
                                    <option value="Community & Development Planning" {{ $sel==='Community & Development Planning'?'selected':'' }}>Community & Development Planning</option>
                                    <option value="Economic & Business Development" {{ $sel==='Economic & Business Development'?'selected':'' }}>Economic & Business Development</option>
                                    <option value="Social Governance" {{ $sel==='Social Governance'?'selected':'' }}>Social Governance</option>
                                </select>
                                <div id="subjectError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-image"></i> Course Image (optional)</div>
                                <input id="image" type="file" name="image" accept="image/*" aria-describedby="imageError">
                                <div id="imageError" class="error-text" style="display:none;"></div>
                                <div class="preview-thumb" id="imagePreview">
                                    @if($course->image_path)
                                        <img src="{{ asset('storage/'.$course->image_path) }}" alt="Course Image">
                                    @else
                                        <span style="color:#94a3b8;">No image selected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="saveDraftBtn" onclick="saveDraft()">Save Draft</button>
                        <button type="button" class="btn btn-submit" id="nextToModules">Next</button>
                    </div>
                </div>
                <div id="tab2" class="tab-content">
                    <div class="form-group">
                        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom:8px;">
                            <label style="margin:0;">Modules & Topics</label>
                        </div>
                        <div id="modulesContainer" style="display:flex;flex-direction:column;gap:10px;"></div>
                        <div id="modulesError" class="error-text" style="display:none;"></div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="backToDetails">Back</button>
                        <div>
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn2" onclick="saveDraft()">Save Draft</button>
                            <button type="submit" class="btn btn-submit" id="submitBtn">Update Course</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="dynamicMenu" aria-hidden="true">
        <div class="dm-container" aria-label="Dynamic field menu">
            <div class="dm-rail" role="toolbar" aria-orientation="vertical" aria-label="Section tools">
                <button type="button" class="rail-btn" title="Add Text" aria-label="Add Text" onclick="dmAddTextInput()"><i class="fas fa-font"></i><span class="rail-label">Add Text</span></button>
                <button type="button" class="rail-btn" title="Add Image" aria-label="Add Image" onclick="dmAddImageUpload()"><i class="fas fa-image"></i><span class="rail-label">Add Image (upload)</span></button>
                <button type="button" class="rail-btn" title="Add Video" aria-label="Add Video" onclick="dmAddVideoUpload()"><i class="fas fa-video"></i><span class="rail-label">Add Video (upload)</span></button>
                <button type="button" class="rail-btn" title="Add Question" aria-label="Add Question" onclick="dmAddQuestion()"><i class="fas fa-dot-circle"></i><span class="rail-label">Multiple Choice</span></button>
                <button type="button" class="rail-btn" title="Add Topic" aria-label="Add Topic" onclick="dmAddTopic()"><i class="fas fa-stream"></i><span class="rail-label">Add Topic</span></button>
                <button type="button" class="rail-btn" title="Add Module" aria-label="Add Module" onclick="dmAddModule()"><i class="fas fa-layer-group"></i><span class="rail-label">Add Module</span></button>
            </div>
            </div>
        </div>
    </div>
    <div id="dmHelp" style="position:absolute;left:-9999px;top:-9999px;">Use Tab/Shift+Tab to move between menu buttons. Press Enter or Space to activate.</div>
    <script>
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
                    <div class="module-actions">
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="removeModule(this, event)">Remove</button>
                        <button type="button" class="chevron-btn" onclick="toggleChevron(this)"><i class="fas fa-chevron-down"></i></button>
                    </div>
                </div>
                <div class="module-body">
                    <div class="topics"></div>
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
                        <span style="color:#6b7280;width:40px;">${moduleIndex+1}.${idx+1}</span>
                        <input type="text" name="modules[${moduleIndex}][topics][${idx}][title]" placeholder="Topic title" required maxlength="80" style="flex:1;">
                    </div>
                    <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="removeTopicRow(this)">Remove</button>
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
            });
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
            modules.forEach((wrapper, i) => {
                const idxBadge = wrapper.querySelector('.module-index');
                idxBadge.textContent = i+1;
                const numberLabel = wrapper.querySelector('.module-number-label');
                if (numberLabel) numberLabel.textContent = `Module ${i+1}:`;
                const titleInput = wrapper.querySelector('.module-title-input');
                if (titleInput) titleInput.name = `modules[${i}][title]`;
                const topicsContainer = wrapper.querySelector('.topics');
                if (topicsContainer) {
                    reindexTopics(topicsContainer);
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
                    <div class="q-header">
                        <select class="q-type">
                            <option value="multiple_choice">Multiple choice</option>
                        </select>
                        <input type="text" class="q-title" placeholder="Type your question" required>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-feedback" style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">
                        <textarea class="q-fb-correct" rows="2" placeholder="Feedback when answer is correct (optional)"></textarea>
                        <textarea class="q-fb-incorrect" rows="2" placeholder="Feedback when answer is incorrect (optional)"></textarea>
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
            setupDefaultOptions(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncFieldsJSON(panel);
            });
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
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
                    <div class="q-header">
                        <select class="q-type">
                            <option value="multiple_choice">Multiple choice</option>
                        </select>
                        <input type="text" class="q-title" placeholder="Type your question" required>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-feedback" style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">
                        <textarea class="q-fb-correct" rows="2" placeholder="Feedback when answer is correct (optional)"></textarea>
                        <textarea class="q-fb-incorrect" rows="2" placeholder="Feedback when answer is incorrect (optional)"></textarea>
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
        }
        function deleteField(btn){
            const panel = btn.closest('.fields-panel');
            btn.closest('.field-block').remove();
            syncFieldsJSON(panel);
        }
        function setupDefaultOptions(block){
            const type = 'multiple_choice';
            const options = block.querySelector('.q-options');
            options.innerHTML = '';
            addOptionRow(options, 'Option 1');
            addOptionRow(options, '');
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
            if(container.querySelector('.add-option-link')) return;
            const link = document.createElement('button');
            link.type='button';
            link.className='add-option-link';
            link.style.cssText='background:none;border:none;color:#0d6efd;cursor:pointer;text-align:left;padding:0;margin-top:4px;';
            link.textContent='Add option';
            link.addEventListener('click', ()=> {
                addOptionRow(container, '');
                const panel = container.closest('.fields-panel');
                if(panel) syncFieldsJSON(panel);
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
                    const type = 'multiple_choice';
                    const title = qb.querySelector('.q-title').value || 'Untitled Question';
                    const required = false;
                    const q = { type, title, required };
                    const opts = Array.from(qb.querySelectorAll('.q-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                    q.options = opts;
                    const rows = Array.from(qb.querySelectorAll('.q-option-row'));
                    const answerIndex = rows.findIndex(r => r.querySelector('.q-correct') && r.querySelector('.q-correct').checked);
                    if(answerIndex >= 0) q.answer_index = answerIndex;
                    const fbC = qb.querySelector('.q-fb-correct')?.value || '';
                    const fbI = qb.querySelector('.q-fb-incorrect')?.value || '';
                    if(fbC) q.feedback_correct = fbC;
                    if(fbI) q.feedback_incorrect = fbI;
                    fields.push({ type:'question', question: q });
                }
            });
            const textarea = panel.querySelector('textarea[name$="[fields_json]"]');
            textarea.value = JSON.stringify(fields);
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
        }
        function switchTo(tab){
            document.getElementById('tab1').classList.toggle('active', tab===1);
            document.getElementById('tab2').classList.toggle('active', tab===2);
            document.getElementById('tabBtn1').classList.toggle('active', tab===1);
            document.getElementById('tabBtn2').classList.toggle('active', tab===2);
            document.getElementById('tabBtn1').setAttribute('aria-selected', tab===1 ? 'true':'false');
            document.getElementById('tabBtn2').setAttribute('aria-selected', tab===2 ? 'true':'false');
        }
        function ensureDefaultModule(){
            const container = document.getElementById('modulesContainer');
            if(container.children.length > 0) return;
            createModule();
        }
        function bindTabs(){
            document.getElementById('tabBtn1').addEventListener('click', ()=> switchTo(1));
            document.getElementById('tabBtn2').addEventListener('click', ()=> switchTo(2));
            document.getElementById('backToDetails').addEventListener('click', ()=> switchTo(1));
            document.getElementById('nextToModules').addEventListener('click', ()=> { if(validateDetails()){ switchTo(2); ensureDefaultModule(); } });
            ['name','description','subject_area','image'].forEach(id=>{
                const el = document.getElementById(id);
                el && el.addEventListener('input', updateProgress);
                el && el.addEventListener('change', updateProgress);
            });
            document.getElementById('courseForm').addEventListener('submit', (e)=>{
                updateProgress();
                if(!validateDetails() || !validateModules()){ e.preventDefault(); switchTo(!validateDetails()?1:2); }
            });
        }
        function draftKey(){ return 'draft_course_edit_{{ $course->id }}'; }
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
        document.addEventListener('DOMContentLoaded', function(){
            bindTabs();
            restoreDraft();
            updateProgress();
            initDynamicMenu();
            const existing = {!! json_encode($course->modules ?? [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!};
            populateExistingModules(existing);
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
                createModule();
                const wrapper = container.lastElementChild;
                const titleInput = wrapper.querySelector('.module-title-input');
                titleInput.value = mod.title || '';
                const body = wrapper.querySelector('.module-body');
                body.style.display = 'block';
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
