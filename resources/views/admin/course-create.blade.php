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
        .exam-meta-row { display:flex; justify-content:space-between; align-items:center; gap:16px; width:100%; }
        .exam-meta-timer { display:inline-flex; align-items:center; gap:8px; flex-shrink:0; margin:0; }
        .exam-meta-timer-label { font-weight:700; color:#111827; white-space:nowrap; }
        .exam-meta-timer-input { width:110px; padding:8px; border:1px solid #e5e7eb; border-radius:8px; }
        .exam-meta-title { margin-left:auto; font-weight:800; color:#0B2C74; text-align:right; }
        .module-title { display:flex;align-items:center;gap:12px;margin:0;color:#001f54;font-size:1rem; flex: 1; min-width: 0; }
        .module-index { width:28px;height:28px;border-radius:50%;background:#00a859;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700; }
        .module-number-label { white-space: nowrap; font-weight: 600; color: #001f54; }
        .exam-header { cursor: grab; }
        .exam-wrapper.dragging { opacity:.6; transform: scale(.995); }
        #modulesContainer .drop-placeholder { height:0; border-top:3px solid #3b82f6; border-radius:2px; margin:6px 0; }
        .kebab-btn{ width:34px;height:34px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;color:#111827;display:flex;align-items:center;justify-content:center;cursor:pointer; }
        .kebab-btn:hover{ background:#f8fafc; }
        .kebab-menu{ position:absolute; right:0; top:100%; margin-top:6px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 10px 24px rgba(0,0,0,.12); display:none; min-width:180px; z-index:50; }
        .kebab-menu.open{ display:block; }
        .kebab-item{ display:flex; gap:10px; align-items:center; padding:10px 12px; cursor:pointer; color:#111827; }
        .kebab-item:hover{ background:#f1f5f9; }
        .module-title-input { flex: 1; min-width: 0; padding: 8px 10px; border: 1px solid #ddd; border-radius: 6px; }
        .module-actions { display:flex; align-items:center; gap:8px; }
        .chevron-btn { background:#f1f5f9; color:#111827; border:none; width:32px; height:32px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
        .chevron-btn i { transition: transform .2s ease; }
        .module-body { display:none;padding:10px 14px 14px 52px; position:relative; }
        .module-body .topics { max-width: 820px; margin: 0 auto; }
        .topic-row { display:flex; flex-direction:column; align-items:stretch; gap:8px; padding:12px; border:1px dashed #e5e7eb; border-radius:8px; background:#f9fafb; }
        .topic-row > span { color:#6b7280; }
        .topic-row input[type="text"] { width: 100%; }
        .topic-row.quiz-row { border-style: solid; border-color: rgba(59,130,246,.35); background: #f8fbff; }
        .section-drag-handle{ width:18px; height:28px; display:inline-flex; align-items:center; justify-content:center; border:none; background:transparent; color:#94a3b8; cursor:grab; padding:0; border-radius:6px; user-select:none; flex:0 0 auto; line-height:1; font-size:16px; }
        .section-drag-handle:hover{ background:#eef2ff; color:#1e3a8a; }
        .topic-row.dragging{ opacity:.6; }
        .section-pill{display:inline-flex;align-items:center;justify-content:center;height:24px;padding:0 10px;border-radius:999px;font-size:.74rem;font-weight:800;letter-spacing:.02em;border:1px solid transparent;white-space:nowrap}
        .section-pill.quiz{background:#eef2ff;color:#1d4ed8;border-color:rgba(29,78,216,.18)}
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
        .progress-steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-top: 10px; }
        .step { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 10px; background: #f8fafc; color: #334155; font-weight: 700; font-size: .84rem; border: 1px solid #e5e7eb; transition: all .2s ease; }
        .step-index { width: 24px; height: 24px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: #e2e8f0; color: #334155; font-size: .78rem; font-weight: 800; flex: 0 0 24px; }
        .step.done { background: #ecfeff; color: #0f766e; border-color: #99f6e4; }
        .step.done .step-index { background: #10b981; color: #ffffff; }
        .step.active { background: var(--brand); color: #ffffff; border-color: var(--brand); box-shadow: 0 6px 12px rgba(13,110,253,0.25); }
        .step.active .step-index { background: rgba(255,255,255,0.22); color: #ffffff; }
        .step.disabled { opacity: 0.5; cursor: not-allowed; filter: grayscale(0.2); }
        .step:disabled { opacity: 0.5; cursor: not-allowed; }
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
        .field-move-controls { display:none !important; }
        .drag-handle.field-move-btn{ width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; background:#f8fafc; border-radius:8px; color:#334155; cursor:grab; }
        .drag-handle.field-move-btn:hover{ background:#eef2ff; border-color:#c7d2fe; color:#1e3a8a; }
        .field-block.dragging{ opacity:.7; }
        .fields-panel .drop-placeholder{ height:0; border-top:2px solid #3b82f6; margin:6px 0; }
        .field-move-btn { width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d1d5db; background:#f8fafc; border-radius:8px; color:#334155; cursor:pointer; }
        .field-move-btn:hover { background:#eef2ff; border-color:#c7d2fe; color:#1e3a8a; }
        .pill-btn { width:auto !important; height:auto !important; padding:8px 12px !important; gap:8px !important; border-radius:12px !important; background:#fff !important; box-shadow:0 3px 8px rgba(0,0,0,.06) !important; }
        .pill-btn i { margin-right:6px; }
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
        .capdev-question-card { border:0; border-radius:0; background:transparent; overflow:visible; transition:border-color .18s ease, box-shadow .18s ease; }
        .capdev-question-card.is-expanded { box-shadow:none; }
        .q-summary-toggle { width:100%; border:0; background:#f8fbff; color:#0f172a; display:flex; align-items:center; justify-content:space-between; gap:14px; padding:12px 14px; cursor:pointer; text-align:left; font:inherit; }
        .capdev-question-card.is-expanded > .q-summary-toggle { display:none; }
        .capdev-question-card.is-collapsed { border:1px solid #dbe4f3; border-radius:12px; background:#fff; overflow:hidden; }
        .q-summary-main { min-width:0; display:flex; align-items:center; gap:10px; flex:1; }
        .q-summary-number { flex:0 0 auto; color:#002C76; font-weight:800; font-size:.86rem; }
        .q-summary-preview { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:#1f2937; font-weight:700; }
        .q-summary-meta { flex:0 0 auto; border-radius:999px; background:#eaf2ff; color:#0f3b8f; font-size:.76rem; font-weight:800; padding:5px 9px; }
        .q-summary-chevron { color:#64748b; transition:transform .2s ease; }
        .capdev-question-card.is-collapsed .q-summary-chevron { transform:rotate(-90deg); }
        .q-collapse-body { max-height:1600px; opacity:1; padding:0; transition:max-height .24s ease, opacity .18s ease, padding .2s ease; }
        .capdev-question-card.is-collapsed .q-collapse-body { max-height:0; opacity:0; padding-top:0; padding-bottom:0; overflow:hidden; }
        .q-minimize-row{ display:flex; justify-content:flex-end; padding:10px 10px 0 10px; }
        .q-minimize-btn{ width:34px; height:34px; border-radius:10px; border:1px solid #e5e7eb; background:#ffffff; color:#0f3b8f; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; }
        .q-minimize-btn:hover{ background:#f1f5ff; border-color:#c8d4ff; }
        @media (max-width:640px) { .q-summary-toggle { align-items:flex-start; flex-direction:column; } .q-summary-meta { align-self:flex-start; } }
        .course-create-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }
        .course-create-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border: 1px solid #dbe4f3;
            border-radius: 8px;
            background: #ffffff;
            color: #002C76;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
            transition: background-color 0.16s ease, border-color 0.16s ease, box-shadow 0.16s ease, transform 0.16s ease;
        }
        .course-create-back:hover {
            background: #f8fbff;
            border-color: #b8cae6;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }
        .course-create-back i {
            font-size: 0.95rem;
        }
        .course-create-page-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -0.01em;
        }
        @media (max-width: 640px) {
            .course-create-topline {
                align-items: flex-start;
                flex-direction: column;
            }
        }
        body.embedded-create {
            background-color: transparent;
        }
        body.embedded-create .page-container {
            max-width: 100%;
            margin: 0;
            padding: 6px 10px 12px;
        }
        html, body { scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar, body::-webkit-scrollbar { width: 0; height: 0; }
        #subjectAreaDropdown { scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
        #subjectAreaDropdown::-webkit-scrollbar { width: 10px; height: 10px; }
        #subjectAreaDropdown::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; border: 2px solid #ffffff; }
        #subjectAreaDropdown::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        #subjectAreaDropdown::-webkit-scrollbar-track { background: transparent; }
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
    @php
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $tmRoles = ['training_manager', 'central_office_training_manager', 'regional_office_training_manager', 'provincial_office_training_manager'];
        $courseManagementBackRoute = in_array($actorRole, $tmRoles, true)
            ? route('dashboard', ['portal' => 'tm', 'tab' => 'course-management'])
            : route('dashboard', ['tab' => 'course-management']);
    @endphp
    <header class="header">
        <div class="header-left">
            <div class="header-title">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro">
            </div>
        </div>
        <div class="header-right" style="display:flex; gap:10px; align-items:center;">
            <span id="autoSaveIndicator" style="font-size: 0.8rem; color: #64748b; font-style: italic; display: none;"><span id="autoSaveLabel">Saved in drafts</span> <span id="autoSaveTime"></span></span>
            <a href="{{ $courseManagementBackRoute }}" class="back-link js-confirm-back" style="margin:0; background-color: #002C76; color: white; padding: 8px 16px; border-radius: 5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <i class="fas fa-arrow-left"></i> Back to Course Management
            </a>
        </div>
    </header>
    @endif
    <div class="page-container">
        <div class="card" aria-live="polite">
            @if(!request()->boolean('embedded'))
                @php
                    $actorRole = strtolower((string) (auth()->user()->role ?? ''));
                    $tmRoles = ['training_manager', 'central_office_training_manager', 'regional_office_training_manager', 'provincial_office_training_manager'];
                    $courseCreateBackRoute = !empty($forTrainer)
                        ? route('dashboard', ['portal' => 'coach', 'tab' => 'course-utilities'])
                        : (in_array($actorRole, $tmRoles, true)
                            ? route('dashboard', ['portal' => 'tm', 'tab' => 'course-management'])
                            : route('dashboard', ['tab' => 'course-management']));
                @endphp
                <div class="course-create-topline">
                    <h1 class="course-create-page-title">Create Course</h1>
                    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;justify-content:flex-end;">
                        <button type="button" id="openImportLibraryBtn" class="btn btn-cancel" style="padding:10px 14px;border-radius:10px;background:#f8fafc;border:1px solid #002C76;color:#002C76;font-weight:800;">
                            Import from Course Library
                        </button>
                        <a href="{{ $courseCreateBackRoute }}" class="course-create-back js-confirm-back" style="margin:0;">
                            <i class="fas fa-arrow-left"></i>
                            <span>{{ !empty($forTrainer) ? 'Back to Course Utilities' : 'Back to Course Management' }}</span>
                        </a>
                    </div>
                </div>
            @endif
            <div class="progress" role="status" aria-live="polite" aria-label="Course setup progress">
                <div class="progress-track" aria-hidden="true">
                    <div id="courseProgressFill" class="progress-fill"></div>
                </div>
                <div id="courseProgressText" class="progress-status">0% complete</div>
                <div class="progress-steps" role="tablist" aria-label="Course setup steps">
                    <button type="button" id="step1" class="step active" role="tab" aria-controls="tab1" aria-selected="true"><span class="step-index">1</span><span>Details</span></button>
                    <button type="button" id="step2" class="step disabled" role="tab" aria-controls="tab2" aria-selected="false" aria-disabled="true" disabled><span class="step-index">2</span><span>Modules</span></button>
                    <button type="button" id="step3" class="step disabled" role="tab" aria-controls="tab3" aria-selected="false" aria-disabled="true" disabled><span class="step-index">3</span><span>Certificate</span></button>
                    <button type="button" id="step4" class="step disabled" role="tab" aria-controls="tab4" aria-selected="false" aria-disabled="true" disabled><span class="step-index">4</span><span>Finalize</span></button>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;margin:10px 0 0;">
                <span id="draftStatusText" style="display:none;align-items:center;gap:8px;background:#f8fafc;border:1px solid #e2e8f0;color:#475569;border-radius:999px;padding:6px 10px;font-weight:800;font-size:0.8rem;"></span>
            </div>
            @if($errors->create_course->any())
                <div id="serverCreateErrors" style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach ($errors->create_course->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>document.addEventListener('DOMContentLoaded', function(){ try{ if(typeof switchTo==='function') switchTo(2);}catch(e){} });</script>
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
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-image"></i> Course Image</div>
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <button type="button" class="btn btn-cancel" onclick="document.getElementById('image').click()" style="padding:8px 16px; font-size:0.85rem; margin:0; background:#f1f5f9; border:1px solid #e2e8f0; color:#475569; font-weight:600;">Choose File</button>
                                    <span id="fileNameDisplay" style="color:#64748b; font-size:0.85rem;">No file chosen</span>
                                </div>
                                <input id="image" type="file" name="image" accept="image/*" required aria-describedby="imageError" style="display:none;">
                                <input type="hidden" id="image_draft_data" name="image_draft_data">
                                <div id="imageError" class="error-text" style="display:none;"></div>
                                <div class="preview-thumb" id="imagePreview"><span style="color:#94a3b8;">No image selected</span></div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="section">
                                <div class="section-title"><i class="fas fa-calendar-check"></i> Academic Year</div>
                                @php
                                    $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
                                @endphp
                                @if($activeYear)
                                    <input type="text" name="academic_year_display" class="pro-input" value="{{ $activeYear->year_start }}" readonly style="background:#f8fafc">
                                    <input type="hidden" name="academic_year" value="{{ $activeYear->year_start }}">
                                    <input type="hidden" name="academic_year_id" value="{{ $activeYear->id }}">
                                @else
                                    <div style="background:#fff5f5; border:1px solid #feb2b2; color:#c53030; padding:10px; border-radius:10px; font-size:.9rem; font-weight:700">
                                        <i class="fas fa-exclamation-triangle"></i> No active academic year set. Please contact Superadmin.
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const submitBtns = document.querySelectorAll('.btn-submit, #saveDraftBtn, #nextToModules');
                                            submitBtns.forEach(btn => {
                                                btn.disabled = true;
                                                btn.title = 'Please set an active academic year first.';
                                                btn.style.opacity = '0.5';
                                                btn.style.cursor = 'not-allowed';
                                            });
                                        });
                                    </script>
                                @endif
                                <div id="academicYearError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section">
                                <div class="section-title"><i class="fas fa-tags"></i> Course Type</div>
                                <div style="display:flex; gap:16px;">
                                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                        <input type="radio" name="course_type" value="free" required>
                                        <span>Free</span>
                                    </label>
                                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                        <input type="radio" name="course_type" value="controlled" required>
                                        <span>Controlled</span>
                                    </label>
                                </div>
                                <div id="courseTypeError" class="error-text" style="display:none;"></div>
                            </div>
                            <div class="section" style="margin-top:12px;">
                                <div class="section-title"><i class="fas fa-layer-group"></i> Subject Area Category</div>
                                @php
                                    $subjectAreas = \App\Models\Course::subjectAreaOptions();
                                    $sel = old('subject_area', []);
                                    if (!is_array($sel)) {
                                        $sel = is_string($sel) ? \App\Models\Course::decodeSubjectAreas($sel) : [];
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
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top:12px;">
                                <div class="section">
                                    <div class="section-title"><i class="fas fa-calendar-plus"></i> Course Start Date</div>
                                    <div style="position:relative;">
                                        <input type="date" name="start_date" id="start_date" style="width:100%; padding:12px 16px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:0.95rem; font-weight:600; background:#fff; outline:none; cursor:pointer;">
                                    </div>
                                    <div id="startDateError" class="error-text" style="display:none;"></div>
                                </div>
                                <div class="section">
                                    <div class="section-title"><i class="fas fa-calendar-times"></i> Course Expiration Date</div>
                                    <div style="position:relative;">
                                        <input type="date" name="course_expiration_date" id="course_expiration_date" style="width:100%; padding:12px 16px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:0.95rem; font-weight:600; background:#fff; outline:none; cursor:pointer;">
                                    </div>
                                    <div id="expirationError" class="error-text" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions" style="justify-content: flex-end; gap: 10px;">
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
                            <button type="button" class="btn btn-primary" style="width:48px;height:48px;border-radius:50%;padding:0;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 4px 12px rgba(13,110,253,0.3);" title="Add Module Exam" onclick="dmAddExam()" aria-label="Add Module Exam"><i class="fas fa-file-circle-question"></i></button>
                        </div>
                        <div id="modulesError" class="error-text" style="display:none;"></div>
                    </div>
                    <div class="actions" style="justify-content: space-between;">
                        <button type="button" class="btn btn-cancel" id="backToDetails">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn2">Save Draft</button>
                            <button type="button" class="btn btn-submit" id="nextToCertificate">Next</button>
                        </div>
                    </div>
                </div>
                <div id="tab3" class="tab-content">
                    <div class="section">
                        <div class="section-title" style="display:flex; justify-content:space-between; align-items:center;">
                            <span><i class="fas fa-certificate"></i> Select Certificate Template</span>
                            <a href="javascript:void(0)" onclick="confirmGoToCertifications('{{ route('dashboard', ['portal' => 'admin', 'tab' => 'certification-management']) }}')" style="color:#0d6efd; font-size:0.85rem; font-weight:600; text-decoration:none;">
                                <i class="fas fa-external-link-alt" style="margin-right:4px;"></i>Go to Certifications
                            </a>
                        </div>
                        <p style="color:#64748b; font-size:0.9rem; margin-bottom:16px;">Choose the certificate template that will be issued to participants upon completion of this course.</p>
                        
                        <div class="certificate-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:20px;">
                            @forelse($certifications as $cert)
                                <label class="cert-card" style="cursor:pointer; position:relative; border:2px solid #e5e7eb; border-radius:12px; overflow:hidden; transition:all 0.2s ease;">
                                    <input type="radio" name="certification_id" value="{{ $cert->id }}" style="position:absolute; opacity:0;" onchange="updateCertSelection(this)">
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
                                    <div class="cert-check" style="position:absolute; top:8px; right:8px; width:24px; height:24px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #e5e7eb; color:#0d6efd; font-size:12px; visibility:hidden;">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </label>
                            @empty
                                <div style="grid-column: 1/-1; text-align:center; padding:40px; background:#f8fafc; border:2px dashed #e2e8f0; border-radius:12px;">
                                    <i class="fas fa-certificate" style="font-size:3rem; color:#e2e8f0; margin-bottom:12px; display:block;"></i>
                                    <div style="color:#64748b; font-weight:600;">No certificate templates available.</div>
                                    <div style="font-size:0.85rem; color:#94a3b8; margin-top:4px;">Please <a href="{{ route('dashboard', ['portal' => 'admin', 'tab' => 'certification-management']) }}" target="_top" style="color:#0d6efd; text-decoration:underline;">add templates in Certificate Management</a> first.</div>
                                </div>
                            @endforelse
                        </div>
                        <div id="certError" class="error-text" style="display:none; margin-top:10px;">Please select a certificate template.</div>
                    </div>

                    <div class="actions" style="justify-content: space-between; margin-top:30px;">
                        <button type="button" class="btn btn-cancel" id="backToModules">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn3">Save Draft</button>
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

                                        <span class="summary-label" style="margin-top: 12px;">Academic Year</span>
                                        <div id="summaryAcademicYear"></div>

                                        <span class="summary-label" style="margin-top: 12px;">Course Type</span>
                                        <div id="summaryCourseType"></div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top:12px;">
                                            <div>
                                                <span class="summary-label">Start Date</span>
                                                <div id="summaryStart" style="font-weight: 700; color: #1e293b;">Not Set</div>
                                            </div>
                                            <div>
                                                <span class="summary-label">Expiration Date</span>
                                                <div id="summaryExpiration" style="font-weight: 700; color: #1e293b;">Not Set</div>
                                            </div>
                                        </div>
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

                    <div class="actions" style="justify-content: space-between; margin-top:30px; position:sticky; bottom:0; background:rgba(255,255,255,.92); backdrop-filter:blur(6px); padding:12px 0; border-top:1px solid #eef2f7;">
                        <button type="button" class="btn btn-cancel" id="backToCertificate">Back</button>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn btn-cancel" id="saveDraftBtn4">Save Draft</button>
                            <button type="submit" class="btn btn-blue" id="submitBtn" disabled>{{ !empty($forTrainer) ? 'Submit Course' : 'Accept Course' }}</button>
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
            <div style="font-size:1.2rem;font-weight:800;color:#0f172a;margin-bottom:12px;">Saved in Drafts</div>
            <p style="color:#64748b;font-size:0.95rem;margin-bottom:24px;line-height:1.5;">You can find it in the Draft Courses section.</p>
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
    <div id="confirmBackModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2200">
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(460px,92vw);padding:24px;text-align:center;">
            <div style="font-size:1.2rem;font-weight:800;color:#0f172a;margin-bottom:12px;">Confirm Back</div>
            <p style="color:#64748b;font-size:0.95rem;margin-bottom:24px;line-height:1.5;">All changes will be saved in drafts.</p>
            <div style="display:flex;justify-content:center;gap:12px;">
                <button type="button" class="btn btn-cancel" onclick="closeConfirmBackModal()" style="padding:10px 24px;">Cancel</button>
                <button type="button" class="btn btn-submit" id="confirmBackBtn" style="padding:10px 24px;background-color:#0d6efd;">Back</button>
            </div>
        </div>
    </div>
    <div id="importLibraryModal" style="position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:2350">
        <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 18px 40px rgba(0,0,0,.18);width:min(1040px,95vw);max-height:85vh;overflow:hidden;display:flex;flex-direction:column;">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;background:#fff;">
                <div style="font-weight:900;color:#002C76;font-size:1.1rem;">Import from Course Library</div>
                <button type="button" id="closeImportLibraryBtn" style="border:none;background:transparent;color:#64748b;font-size:28px;line-height:1;cursor:pointer;">&times;</button>
            </div>
            <div style="padding:14px 20px;border-bottom:1px solid #eef2f7;background:#f8fafc;display:flex;gap:12px;align-items:center;">
                <div style="position:relative;flex:1;">
                    <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.85rem;"></i>
                    <input type="text" id="importLibrarySearch" placeholder="Search course library..." style="width:100%;padding:10px 12px 10px 36px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.9rem;font-weight:500;outline:none;background:#fff;">
                </div>
                <div style="color:#64748b;font-weight:700;font-size:0.85rem;white-space:nowrap;">Click a course to import</div>
            </div>
            <div style="padding:20px;overflow:auto;background:#f8fafc;flex:1;">
                <div id="importLibraryGrid" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;">
                    @php
                        $importCourses = isset($libraryCourses) ? $libraryCourses : collect([]);
                    @endphp
                    @forelse($importCourses as $c)
                        @php
                            $cImg = !empty($c->image_path) ? $c->image_url : null;
                            $cCreator = $c->users()->orderBy('course_user.created_at', 'asc')->first();
                        @endphp
                        <button type="button" class="import-course-card" data-course-id="{{ $c->id }}" data-name="{{ strtolower($c->name) }}" style="text-align:left;border:none;background:#fff;border-radius:12px;overflow:hidden;cursor:pointer;box-shadow:0 4px 10px rgba(0,0,0,.06);padding:0;display:flex;flex-direction:column;min-height:240px;">
                            @if($cImg)
                                <img src="{{ $cImg }}" alt="{{ $c->name }}" style="width:100%;height:120px;object-fit:cover;">
                            @else
                                <div style="width:100%;height:120px;background:#eef4ff;"></div>
                            @endif
                            <div style="padding:12px 12px 14px;display:flex;flex-direction:column;gap:6px;flex:1;">
                                <div style="font-weight:900;color:#0f172a;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $c->name }}</div>
                                <div style="color:#64748b;font-size:0.85rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;">{{ $c->description }}</div>
                                <div style="margin-top:auto;color:#64748b;font-size:0.8rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Created by: {{ $cCreator ? $cCreator->name : 'N/A' }}</div>
                            </div>
                        </button>
                    @empty
                        <div style="grid-column:1/-1;color:#64748b;font-weight:700;text-align:center;padding:28px;background:#fff;border:1px dashed #e5e7eb;border-radius:12px;">No courses available in the library.</div>
                    @endforelse
                </div>
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
    <div id="dynamicMenu" aria-hidden="true">
        <div class="dm-container" aria-label="Dynamic field menu">
            <div class="dm-rail" role="toolbar" aria-orientation="vertical" aria-label="Section tools">
                <button type="button" class="rail-btn" data-type="field" title="Add Field" aria-label="Add Field" onclick="dmAddTextInput()"><i class="fas fa-font"></i><span class="rail-label">Add Field</span></button>
                <button type="button" class="rail-btn" data-type="structure" title="Add Topic" aria-label="Add Topic" onclick="dmAddTopic()"><i class="fas fa-stream"></i><span class="rail-label">Add Topic</span></button>
                <button type="button" class="rail-btn" data-type="structure" title="Add Quiz" aria-label="Add Quiz" onclick="dmAddQuiz()"><i class="fas fa-circle-question"></i><span class="rail-label">Add Quiz</span></button>
                <button type="button" class="rail-btn" data-type="structure" title="Add Module" aria-label="Add Module" onclick="dmAddModule()"><i class="fas fa-layer-group"></i><span class="rail-label">Add Module</span></button>
            </div>
            </div>
    </div>
    </div>
    <div id="dmHelp" style="position:absolute;left:-9999px;top:-9999px;">Use Tab/Shift+Tab to move between menu buttons. Press Enter or Space to activate.</div>
    @include('admin.partials.question-builder-shared')
    <script>
        // IndexedDB for storing draft files (survives refresh)
        const DB_NAME = 'CourseDraftsDB';
        const STORE_NAME = 'draftFiles';
        
        async function openDB() {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(DB_NAME, 1);
                request.onupgradeneeded = (e) => {
                    const db = e.target.result;
                    if (!db.objectStoreNames.contains(STORE_NAME)) {
                        db.createObjectStore(STORE_NAME);
                    }
                };
                request.onsuccess = (e) => resolve(e.target.result);
                request.onerror = (e) => reject(e.target.error);
            });
        }

        async function saveFileToDB(key, files) {
            const db = await openDB();
            const tx = db.transaction(STORE_NAME, 'readwrite');
            const store = tx.objectStore(STORE_NAME);
            // Store as an array of {name, type, blob}
            const fileDatas = await Promise.all(Array.from(files).map(async f => {
                return {
                    name: f.name,
                    type: f.type,
                    blob: f // Blobs are supported in IndexedDB
                };
            }));
            store.put(fileDatas, key);
            return new Promise((resolve, reject) => {
                tx.oncomplete = () => resolve();
                tx.onerror = () => reject(tx.error);
            });
        }

        async function getFilesFromDB(key) {
            const db = await openDB();
            const tx = db.transaction(STORE_NAME, 'readonly');
            const store = tx.objectStore(STORE_NAME);
            const request = store.get(key);
            return new Promise((resolve, reject) => {
                request.onsuccess = () => resolve(request.result);
                request.onerror = () => reject(request.error);
            });
        }

        async function deleteFilesFromDB(key) {
            const db = await openDB();
            const tx = db.transaction(STORE_NAME, 'readwrite');
            const store = tx.objectStore(STORE_NAME);
            store.delete(key);
            return new Promise((resolve, reject) => {
                tx.oncomplete = () => resolve();
                tx.onerror = () => reject(tx.error);
            });
        }

        function handleMaterialsUpload(input) {
            const list = document.getElementById('materialsList');
            const files = input.files;
            
            if (files.length === 0) {
                list.innerHTML = `
                    <div style="color: #94a3b8; font-size: 0.9rem; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <i class="fas fa-file-circle-plus" style="font-size: 2rem; color: #e2e8f0;"></i>
                        <span>No materials uploaded yet (Optional)</span>
                    </div>`;
                deleteFilesFromDB(draftKey() + '_materials');
                return;
            }

            // Save to IndexedDB so it survives refresh
            saveFileToDB(draftKey() + '_materials', files).catch(err => console.error('DB Save Error:', err));

            renderMaterialsList(files);
        }

        function renderMaterialsList(files, isRestored = false) {
            const list = document.getElementById('materialsList');
            list.innerHTML = '';
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
                    border: 1.5px solid #e2e8f0;
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
                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                        <span style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</span>
                        <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 500;">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        ${isRestored ? '<span style="color: #10b981; font-size: 0.65rem; font-weight: 700;">(Restored from draft)</span>' : ''}
                    </div>
                `;
                list.appendChild(badge);
            });
        }

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
                    <div class="module-actions" style="position:relative;display:flex;align-items:center;gap:8px;">
                        <button type="button" class="kebab-btn" title="More actions" onclick="openKebab(this)">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </button>
                        <div class="kebab-menu">
                            <div class="kebab-item" onclick="kebabAddTopic(this)"><i class="fas fa-stream"></i> Add Topic</div>
                            <div class="kebab-item" onclick="kebabAddQuiz(this)"><i class="fas fa-circle-question"></i> Add Quiz</div>
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
            scheduleAutoSave();
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
                        <button type="button" class="section-drag-handle" draggable="true" title="Drag to reorder" aria-label="Drag to reorder">⋮⋮</button>
                        <span class="section-idx" style="color:#6b7280;width:40px;">${moduleIndex+1}.${idx}</span>
                        <input type="hidden" class="section-kind" name="modules[${moduleIndex}][topics][${idx}][kind]" value="topic">
                        <input type="text" name="modules[${moduleIndex}][topics][${idx}][title]" placeholder="Topic title" required maxlength="80" style="flex:1;">
                    </div>
                    <div style="position:relative;display:flex;gap:8px;align-items:center;">
                        <button type="button" class="kebab-btn" title="More actions" onclick="openKebab(this)">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </button>
                        <div class="kebab-menu">
                            <div class="kebab-item" onclick="kebabAddSubtopic(this)"><i class="fas fa-plus"></i> Add Subtopic</div>
                            <div class="kebab-item" onclick="kebabAddQuizAfter(this)"><i class="fas fa-circle-question"></i> Add Quiz</div>
                            <div class="kebab-item" onclick="kebabDeleteTopic(this)"><i class="fas fa-trash-alt"></i> Delete Topic</div>
                        </div>
                    </div>
                </div>
                <div class="subtopics" style="display:flex;flex-direction:column;gap:8px;"></div>
            `;
            topics.appendChild(row);
            updateProgress();
            scheduleAutoSave();
        }

        function addQuizInput(ctx) {
            const body = ctx && ctx.classList && ctx.classList.contains('module-body') ? ctx
                        : ctx && ctx.closest ? ctx.closest('.module-body')
                        : null;
            const wrapper = body ? body.closest('.module-wrapper')
                        : (ctx && ctx.closest ? ctx.closest('.module-wrapper') : null);
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const topics = body.querySelector('.topics');
            const idx = topics.children.length;
            const row = document.createElement('div');
            row.className = 'topic-row quiz-row';
            row.dataset.sectionKind = 'quiz';
            row.innerHTML = `
                <div style="display:flex;align-items:center;gap:10px;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:8px;flex:1;min-width:0;">
                        <button type="button" class="section-drag-handle" draggable="true" title="Drag to reorder" aria-label="Drag to reorder">⋮⋮</button>
                        <span class="section-idx" style="color:#6b7280;width:40px;flex:0 0 auto;">${moduleIndex+1}.${idx}</span>
                        <input type="hidden" class="section-kind" name="modules[${moduleIndex}][topics][${idx}][kind]" value="quiz">
                        <input type="text" name="modules[${moduleIndex}][topics][${idx}][title]" placeholder="Quiz title" required maxlength="80" style="flex:1;min-width:0;">
                    </div>
                    <div style="position:relative;display:flex;gap:8px;align-items:center;">
                        <span class="section-pill quiz">Quiz</span>
                        <button type="button" class="kebab-btn" title="More actions" onclick="openKebab(this)">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </button>
                        <div class="kebab-menu">
                            <div class="kebab-item" onclick="kebabDeleteTopic(this)"><i class="fas fa-trash-alt"></i> Delete Quiz</div>
                        </div>
                    </div>
                </div>
                <div class="fields-panel" style="margin-top:8px;">
                    <div class="field-list"></div>
                    <textarea name="modules[${moduleIndex}][topics][${idx}][fields_json]" style="display:none"></textarea>
                </div>
                <button type="button" class="panel-add-btn" title="Add Question" aria-label="Add Question" onclick="addQuestionToQuizRow(this, event)" style="width:auto;height:auto;border-radius:999px;padding:12px 18px;border:1px solid #0f3b8f;background:#0f3b8f;color:#fff;font-weight:800;display:inline-flex;align-items:center;gap:8px;">
                    Add Question
                </button>
            `;
            topics.appendChild(row);
            updateProgress();
            scheduleAutoSave();
        }

        function addQuestionToQuizRow(btn, event){
            if(event){
                event.preventDefault();
                event.stopPropagation();
            }
            const row = btn && btn.closest ? btn.closest('.quiz-row') : null;
            const panel = row ? row.querySelector('.fields-panel') : null;
            if(!panel) return;
            addQuestionField(panel);
            try{ syncFieldsJSON(panel); }catch(e){}
            updateProgress();
            scheduleAutoSave();
            const last = panel.querySelector('.field-block:last-of-type');
            if(last && typeof setActiveAnchor === 'function'){ setActiveAnchor(last); }
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
        async function removeTopicRow(btn){
            const row = btn.closest('.topic-row');
            const kind = String(row?.dataset.sectionKind || row?.querySelector('.section-kind')?.value || 'topic');
            const label = kind === 'quiz' ? 'Quiz' : 'Topic';
            if(!await window.capdevConfirm(`Remove this ${label.toLowerCase()} and its fields?`, { title: `Remove ${label}`, confirmText: 'Remove' })) return;
            const topics = row.parentElement;
            row.remove();
            reindexTopics(topics);
            updateProgress();
            scheduleAutoSave();
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
        function kebabAddQuiz(el){
            const wrapper = el.closest('.module-wrapper');
            const body = wrapper?.querySelector('.module-body');
            if(body){ body.style.display='block'; addQuizInput(body); }
            el.closest('.kebab-menu').classList.remove('open');
        }
        function kebabAddModule(el){
            createModule(); el.closest('.kebab-menu').classList.remove('open');
        }
        async function kebabDeleteModule(el){
            if(!await window.capdevConfirm('Delete this module?', { title: 'Delete Module', confirmText: 'Delete' })) return;
            const wrapper = el.closest('.module-wrapper'); if(wrapper){ wrapper.remove(); reindexModules(); updateProgress(); scheduleAutoSave(); }
        }
        function kebabAddSubtopic(el){
            const topicRow = el.closest('.topic-row'); if(topicRow){ addSubtopicRow(topicRow); }
            el.closest('.kebab-menu').classList.remove('open');
        }
        function kebabAddQuizAfter(el){
            const topicRow = el.closest('.topic-row');
            const body = topicRow?.closest('.module-body');
            const topics = body?.querySelector('.topics');
            if(topicRow && body && topics){
                addQuizInput(body);
                const newRow = topics.lastElementChild;
                if(newRow){
                    topics.insertBefore(newRow, topicRow.nextSibling);
                    reindexTopics(topics);
                    if(typeof setActiveAnchor === 'function') setActiveAnchor(newRow);
                }
                updateProgress();
                scheduleAutoSave();
            }
            el.closest('.kebab-menu').classList.remove('open');
        }
        async function kebabDeleteTopic(el){
            const topicRow = el.closest('.topic-row');
            const kind = String(topicRow?.dataset.sectionKind || topicRow?.querySelector('.section-kind')?.value || 'topic');
            const label = kind === 'quiz' ? 'Quiz' : 'Topic';
            if(!await window.capdevConfirm(`Delete this ${label.toLowerCase()}?`, { title: `Delete ${label}`, confirmText: 'Delete' })) return;
            if(topicRow){ const topics = topicRow.parentElement; topicRow.remove(); reindexTopics(topics); updateProgress(); scheduleAutoSave(); }
            el.closest('.kebab-menu').classList.remove('open');
        }
        function reindexTopics(container){
            const wrapper = container.closest('.module-wrapper');
            const moduleIndex = Array.from(wrapper.parentElement.children).indexOf(wrapper);
            const rows = Array.from(container.children);
            rows.forEach((row, idx) => {
                const idxEl = row.querySelector('.section-idx') || row.querySelector('span');
                if (idxEl) idxEl.textContent = `${moduleIndex+1}.${idx}`;
                const titleInput = row.querySelector('input[type=text]');
                const kindInput = row.querySelector('input.section-kind');
                const kind = String(row.dataset.sectionKind || (kindInput ? kindInput.value : '') || 'topic');
                row.dataset.sectionKind = kind === 'quiz' ? 'quiz' : 'topic';
                row.classList.toggle('quiz-row', row.dataset.sectionKind === 'quiz');
                if (titleInput) {
                    titleInput.name = `modules[${moduleIndex}][topics][${idx}][title]`;
                    titleInput.placeholder = row.dataset.sectionKind === 'quiz' ? 'Quiz title' : 'Topic title';
                }
                if (kindInput) kindInput.name = `modules[${moduleIndex}][topics][${idx}][kind]`;
                const ta = row.querySelector('textarea[name$="[fields_json]"]');
                if (ta && row.dataset.sectionKind === 'quiz') {
                    ta.name = `modules[${moduleIndex}][topics][${idx}][fields_json]`;
                }
                if (row.querySelector('.subtopics')) {
                    reindexSubtopics(moduleIndex, idx, row);
                }
            });
        }
        function bindSectionReorderDnd(){
            if (window.__capdevSectionDndBound) return;
            window.__capdevSectionDndBound = true;
            const state = { row: null, container: null };
            document.addEventListener('dragstart', function(e){
                const handle = e.target && e.target.closest ? e.target.closest('.section-drag-handle') : null;
                if(!handle) return;
                const row = handle.closest('.topic-row');
                const container = row ? row.parentElement : null;
                if(!row || !container || !container.classList.contains('topics')) return;
                state.row = row;
                state.container = container;
                row.classList.add('dragging');
                try { e.dataTransfer.effectAllowed = 'move'; } catch (err) {}
                try { e.dataTransfer.setData('text/plain', 'section'); } catch (err) {}
            });
            document.addEventListener('dragend', function(){
                if(state.row) state.row.classList.remove('dragging');
                state.row = null;
                state.container = null;
            });
            document.addEventListener('dragover', function(e){
                if(!state.row || !state.container) return;
                const container = e.target && e.target.closest ? e.target.closest('.topics') : null;
                if(!container || container !== state.container) return;
                e.preventDefault();
                const overRow = e.target && e.target.closest ? e.target.closest('.topic-row') : null;
                if(!overRow || overRow === state.row) return;
                const rect = overRow.getBoundingClientRect();
                const before = e.clientY < (rect.top + rect.height / 2);
                container.insertBefore(state.row, before ? overRow : overRow.nextSibling);
            });
            document.addEventListener('drop', function(e){
                if(!state.row || !state.container) return;
                const container = e.target && e.target.closest ? e.target.closest('.topics') : null;
                if(!container || container !== state.container) return;
                e.preventDefault();
                state.row.classList.remove('dragging');
                reindexTopics(container);
                updateProgress();
                scheduleAutoSave();
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
            const wrap = btn.closest('.editor-toolbar');
            const sel = wrap.querySelector('.et-size');
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
                        // if caret at start of a block, check previous siblings
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
            // Merge placeholder: no colspans in current simple table, ignore
            // Replace current cell with 'cols' cells
            const toInsertInRow = Math.max(1, cols);
            for(let i=0;i<toInsertInRow;i++){
                const td = (i===0)? cell : document.createElement('td');
                td.style.padding='6px';
                td.innerHTML='&nbsp;';
                if(i>0){ row.insertBefore(td, cell.nextSibling); }
            }
            // Add rows below if rows>1
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
            const input = btn.parentElement.querySelector('input[accept^="image"]');
            input.click();
        }
        function triggerPDFPicker(btn){
            const input = btn.parentElement.querySelector('input[accept="application/pdf"]');
            input.click();
        }
        function insertPDFFromInput(input){
            const file = input.files && input.files[0];
            if(!file) return;
            if (file.type !== 'application/pdf' || file.size > 10 * 1024 * 1024) {
                alert('Only PDF files up to 10MB are allowed.');
                input.value = '';
                return;
            }
            const editor = input.closest('.text-block')?.querySelector('.editor') || input.closest('.materials-panel')?.querySelector('.editor');
            editor.focus();
            
            // Show loading indicator
            const btn = input.parentElement.querySelector('button[title="Insert PDF"]');
            const originalIcon = btn ? btn.innerHTML : '';
            if(btn) btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Uploading...</span>';

            const fd = new FormData();
            fd.append('pdf', file);
            fetch("{{ route('courses.content-pdf.upload') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: fd
            }).then(r=>r.json()).then(res=>{
                if(btn) btn.innerHTML = originalIcon;
                if(!res || !res.ok || !res.url){ alert('Upload failed'); return; }
                
                // Insert as a nice link with icon and preview iframe
                const html = `
                <div class="pdf-container" contenteditable="false" style="margin:12px 0;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;background:#fff;">
                    <div style="padding:12px 16px;background:#f8fafc;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <i class="fas fa-file-pdf" style="color:#ef4444;font-size:1.2rem;"></i>
                            <span style="font-weight:600;color:#1e293b;">${res.name || 'Document.pdf'}</span>
                        </div>
                        <a href="${res.url}" target="_blank" class="btn btn-small" style="background:#0f3b8f;color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                            <i class="fas fa-external-link-alt"></i> Open PDF
                        </a>
                    </div>
                    <div style="aspect-ratio:4/3;width:100%;background:#525659;">
                        <iframe src="${res.url}#toolbar=0" style="width:100%;height:100%;border:0;"></iframe>
                    </div>
                </div><p><br></p>`;
                
                document.execCommand('insertHTML', false, html);
                syncFieldsJSON(editor.closest('.fields-panel'));
                input.value = ''; // Reset input
            }).catch(err=>{
                if(btn) btn.innerHTML = originalIcon;
                console.error('PDF upload error:', err);
                alert('Upload error');
            });
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
                        <div class="et-fontsize" style="display:inline-flex;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                        <select class="et-font" onchange="applyFontName(this)" style="border:0;padding:6px 8px;">
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Arial">Arial</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Tahoma">Tahoma</option>
                        <option value="Verdana">Verdana</option>
                    </select>
                        <select class="et-size" onchange="applyFontSize(this)" style="border:0;border-left:1px solid #e5e7eb;padding:6px 8px;width:72px;">
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16" selected>16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                        <option value="28">28</option>
                        <option value="32">32</option>
                    </select>
                        </div>
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
                        <button type="button" class="field-move-btn pill-btn" onclick="triggerPDFPicker(this)" title="Insert PDF"><i class="fas fa-file-pdf"></i><span>PDF</span></button>
                        <input type="file" accept="image/*" onchange="insertImageFromInput(this)" style="display:none">
                        <input type="file" accept="application/pdf" onchange="insertPDFFromInput(this)" style="display:none">
                    </div>
                </div>
                <div class="editor" contenteditable="true" aria-label="Text field editor" style="min-height:120px;border:1px solid #e5e7eb;border-radius:10px;padding:10px;"></div>
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
            bindEditorEnhancements(block);
            if(origin && origin.closest){
                const menuWrap = origin.closest('.add-menu');
                if(menuWrap) menuWrap.style.display='none';
            }
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
        }
        function capdevQuestionCardShell(bodyHtml){
            return `
                <div class="q-block capdev-question-card is-expanded">
                    <button type="button" class="q-summary-toggle" onclick="toggleQuestionCard(this)" aria-expanded="true">
                        <span class="q-summary-main">
                            <span class="q-summary-number">Question</span>
                            <span class="q-summary-preview">Untitled question</span>
                        </span>
                        <span class="q-summary-meta">Multiple Choice</span>
                        <i class="fas fa-chevron-down q-summary-chevron" aria-hidden="true"></i>
                    </button>
                    <div class="q-collapse-body">
                        <div class="q-minimize-row">
                            <button type="button" class="q-minimize-btn" onclick="toggleQuestionCard(this)" title="Minimize" aria-label="Minimize"><i class="fas fa-chevron-up" aria-hidden="true"></i></button>
                        </div>
                        ${bodyHtml}
                    </div>
                </div>
            `;
        }
        function questionTypeLabel(value){
            return String(value || 'multiple_choice_single').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
        }
        function updateQuestionCardSummary(block){
            if(!block) return;
            const index = Array.from(block.parentElement?.querySelectorAll('.field-block[data-type="question"]') || []).indexOf(block) + 1;
            const number = block.querySelector('.q-summary-number');
            const preview = block.querySelector('.q-summary-preview');
            const meta = block.querySelector('.q-summary-meta');
            const text = (block.querySelector('.q-title')?.value || '').trim();
            const type = block.querySelector('.q-type')?.value || 'multiple_choice_single';
            if(number) number.textContent = index > 0 ? `Question ${index}` : 'Question';
            if(preview) preview.textContent = text || 'Untitled question';
            if(meta) meta.textContent = questionTypeLabel(type);
        }
        function collapseQuestionCard(block){
            const card = block?.querySelector('.capdev-question-card');
            const toggle = block?.querySelector('.q-summary-toggle');
            if(!card) return;
            updateQuestionCardSummary(block);
            card.classList.remove('is-expanded');
            card.classList.add('is-collapsed');
            if(toggle) toggle.setAttribute('aria-expanded', 'false');
        }
        function expandQuestionCard(block){
            const card = block?.querySelector('.capdev-question-card');
            const toggle = block?.querySelector('.q-summary-toggle');
            if(!card) return;
            const panel = block.closest('.fields-panel');
            panel?.querySelectorAll('.field-block[data-type="question"]').forEach(other => {
                if(other !== block) collapseQuestionCard(other);
            });
            card.classList.remove('is-collapsed');
            card.classList.add('is-expanded');
            if(toggle) toggle.setAttribute('aria-expanded', 'true');
            updateQuestionCardSummary(block);
        }
        function toggleQuestionCard(button){
            const block = button.closest('.field-block');
            const card = button.closest('.capdev-question-card');
            if(!block || !card) return;
            if(card.classList.contains('is-collapsed')) expandQuestionCard(block);
            else collapseQuestionCard(block);
        }
        function bindQuestionCard(block, panel){
            updateQuestionCardSummary(block);
            block.addEventListener('input', () => updateQuestionCardSummary(block));
            block.addEventListener('change', () => updateQuestionCardSummary(block));
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
            block.innerHTML = capdevQuestionCardShell(`
                    <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start">
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                            <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                        </label>
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice_single">Multiple Choice (Single Answer)</option>
                                <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
                                <option value="enumeration">Enumeration</option>
                            </select>
                        </label>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-actions">
                        <div class="right" style="position:relative;">
                            <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate question"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete question"><i class="fas fa-trash-alt"></i></button>
                            <span class="divider"></span>
                            <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                        </div>
                    </div>
            `);
            list.appendChild(block);
            __bindAutosizeTextareas(block);
            setupDefaultOptions(block);
            bindQuestionCard(block, panel);
            expandQuestionCard(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncFieldsJSON(panel);
            });
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            bindFieldDrag(block);
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
                        <div class="et-fontsize" style="display:inline-flex;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                        <select class="et-font" onchange="applyFontName(this)" style="border:0;padding:6px 8px;">
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Arial">Arial</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Tahoma">Tahoma</option>
                        <option value="Verdana">Verdana</option>
                    </select>
                        <select class="et-size" onchange="applyFontSize(this)" style="border:0;border-left:1px solid #e5e7eb;padding:6px 8px;width:72px;">
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16" selected>16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                        <option value="28">28</option>
                        <option value="32">32</option>
                    </select>
                        </div>
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
                        <button type="button" class="field-move-btn pill-btn" onclick="triggerPDFPicker(this)" title="Insert PDF"><i class="fas fa-file-pdf"></i><span>PDF</span></button>
                        <input type="file" accept="image/*" onchange="insertImageFromInput(this)" style="display:none">
                        <input type="file" accept="application/pdf" onchange="insertPDFFromInput(this)" style="display:none">
                    </div>
                </div>
                <div class="editor" contenteditable="true" aria-label="Text field editor" style="min-height:120px;border:1px solid #e5e7eb;border-radius:10px;padding:10px;"></div>
                <div class="q-actions" style="position:relative;">
                    <div class="right">
                        <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate field"><i class="fas fa-clone"></i></button>
                        <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete field"><i class="fas fa-trash-alt"></i></button>
                        <span class="divider"></span>
                        <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                    </div>
                </div>
            `;
            current.parentElement.insertBefore(block, current.nextSibling);
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            block.addEventListener('click', (e)=> { if(!e.target.closest('.field-move-controls')) setSelectedField(block); });
            ensureReflectionLast(panel);
            syncFieldsJSON(panel);
            block.scrollIntoView({behavior:'smooth', block:'center'});
            bindEditorEnhancements(block);
        }
        function addQuestionFieldAfter(btn){
            const current = btn.closest('.field-block');
            const panel = current.closest('.fields-panel');
            const block = document.createElement('div');
            block.className = 'field-block';
            block.setAttribute('data-type','question');
            block.setAttribute('data-correct', `correct-${Date.now()}-${Math.floor(Math.random()*1000)}`);
            block.innerHTML = capdevQuestionCardShell(`
                    <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start">
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                            <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                        </label>
                        <label class="q-col" style="display:block">
                            <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                            <select class="q-type">
                                <option value="multiple_choice_single">Multiple Choice (Single Answer)</option>
                                <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
                                <option value="identification">Identification</option>
                                <option value="true_false">True or False</option>
                                <option value="essay">Essay</option>
                                <option value="enumeration">Enumeration</option>
                            </select>
                        </label>
                    </div>
                    <div class="q-options"></div>
                    <div class="q-actions">
                        <div class="right" style="position:relative;">
                            <button type="button" class="btn btn-small" style="background:#e5e7eb;color:#111827;" onclick="duplicateField(this)" title="Duplicate" aria-label="Duplicate question"><i class="fas fa-clone"></i></button>
                            <button type="button" class="btn btn-small" style="background:#dc3545;" onclick="deleteField(this)" title="Delete" aria-label="Delete question"><i class="fas fa-trash-alt"></i></button>
                            <span class="divider"></span>
                            <button type="button" class="field-move-btn drag-handle" title="Drag" aria-label="Drag field"><i class="fas fa-grip-vertical"></i></button>
                        </div>
                    </div>
            `);
            current.parentElement.insertBefore(block, current.nextSibling);
            __bindAutosizeTextareas(block);
            setupDefaultOptions(block);
            bindQuestionCard(block, panel);
            collapseQuestionCard(current);
            expandQuestionCard(block);
            const qInput = block.querySelector('.q-title'); if(qInput){ qInput.focus(); }
            block.querySelector('.q-type').addEventListener('change', function(){
                setupDefaultOptions(block);
                syncFieldsJSON(panel);
            });
            block.addEventListener('input', ()=> syncFieldsJSON(panel));
            bindFieldDrag(block);
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
                const t = (b.title||'').toLowerCase();
                const txt = (b.innerText||'').toLowerCase();
                if(t==='delete' || txt==='delete'){ b.onclick = function(){ deleteField(this); }; }
                if(t==='duplicate' || txt==='duplicate'){ b.onclick = function(){ duplicateField(this); }; }
                if(txt==='image'){ b.onclick = function(){ triggerImagePicker(this); }; }
                if(txt==='video'){ b.onclick = function(){ openVideoModal(this); }; }
                if(txt==='link'){ b.onclick = function(){ insertLink(this); }; }
                if(txt==='table'){ b.onclick = function(){ insertTable(this); }; }
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
            if(clone.getAttribute('data-type') === 'question'){
                bindQuestionCard(clone, panel);
                expandQuestionCard(clone);
            }
            bindFieldDrag(clone);
            ensureReflectionLast(panel);
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
            ensureReflectionLast(panel);
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
            // Make the handle itself draggable for more reliable UX
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
                // collapse any open editors? keep as-is
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
                    ensureReflectionLast(panel);
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
                    updateQuestionCardSummary(b);
                    const qb = b.querySelector('.q-block');
                    const type = qb.querySelector('.q-type') ? qb.querySelector('.q-type').value : 'multiple_choice_single';
                    const title = qb.querySelector('.q-title').value || 'Untitled Question';
                    const required = false;
                    const q = { type, title, required };
                    if(isMultipleChoiceType(type) || type === 'true_false'){
                        const opts = Array.from(qb.querySelectorAll('.q-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                        q.options = opts.length ? opts : (type==='true_false' ? ['True','False'] : []);
                        const rows = Array.from(qb.querySelectorAll('.q-option-row'));
                        const answerIndexes = rows.map((r, index) => (r.querySelector('.q-correct') && r.querySelector('.q-correct').checked) ? index : null).filter(index => index !== null);
                        if(isMultipleChoiceType(type)){
                            q.type = normalizeMcType(type);
                            q.correct_answers = answerIndexes.map(choiceIndexToLetter);
                            if(q.type === 'multiple_choice_single' && answerIndexes.length) q.answer_index = answerIndexes[0];
                        }else if(answerIndexes.length){
                            q.answer_index = answerIndexes[0];
                        }
                    } else if(type === 'identification'){
                        const ans = String(qb.querySelector('.q-id-answer')?.value || '').trim().toUpperCase();
                        const desc = String(qb.querySelector('.q-id-desc')?.value || '').trim();
                        if(ans) q.answer = ans;
                        if(desc) q.description = desc;
                    } else if(type === 'essay'){
                        const rb = qb.querySelector('.q-essay')?.value || '';
                        if(rb) q.instructions = rb;
                    } else if(type === 'enumeration'){
                        const answers = Array.from(qb.querySelectorAll('.q-enum-answer')).map(i=> String(i.value || '').trim().toUpperCase()).filter(v=> v !== '');
                        const desc = String(qb.querySelector('.q-enum-desc')?.value || '').trim();
                        if(answers.length) q.answers = answers;
                        if(desc) q.description = desc;
                    }
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
            scheduleAutoSave();
        }
        // Legacy question helpers reused by question field
        function addQuestionBlock(btn){
            const panel = btn.closest('.questions-panel');
            const list = panel.querySelector('.q-list');
            const block = document.createElement('div');
            block.className = 'q-block';
            block.innerHTML = `
                <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start">
                    <label class="q-col" style="display:block">
                        <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                        <textarea class="q-title q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                    </label>
                    <label class="q-col" style="display:block">
                        <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                        <select class="q-type">
                            <option value="multiple_choice_single">Multiple Choice (Single Answer)</option>
                            <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
                            <option value="identification">Identification</option>
                            <option value="true_false">True or False</option>
                            <option value="essay">Essay</option>
                            <option value="enumeration">Enumeration</option>
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
            const type = block.querySelector('.q-type') ? block.querySelector('.q-type').value : 'multiple_choice_single';
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
            if(isMultipleChoiceType(type)){
                addGuide(type === 'multiple_choice_multiple' ? 'Select all correct answers.' : 'Select one correct answer.');
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
                addGuide('Note: Answer will be saved in UPPERCASE as the standard answer.');
                const fieldsPanel = options.closest('.fields-panel');
                const ans = document.createElement('input');
                ans.type = 'text';
                ans.className = 'q-id-answer';
                ans.placeholder = 'Answer';
                ans.style.cssText = 'width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px;font-weight:700;text-transform:uppercase;';
                ans.addEventListener('input', function(){
                    const start = typeof ans.selectionStart === 'number' ? ans.selectionStart : null;
                    const end = typeof ans.selectionEnd === 'number' ? ans.selectionEnd : null;
                    const up = String(ans.value || '').toUpperCase();
                    if(ans.value !== up) ans.value = up;
                    if(start != null && end != null){
                        try{ ans.setSelectionRange(start, end); }catch(_) {}
                    }
                    if(fieldsPanel) syncFieldsJSON(fieldsPanel);
                });
                options.appendChild(ans);
                const note = document.createElement('div');
                note.style.cssText = 'color:#64748b;font-size:.82rem;font-weight:700;margin:6px 0 10px 0;';
                options.appendChild(note);
                const desc = document.createElement('textarea');
                desc.className = 'q-id-desc';
                desc.rows = 2;
                desc.placeholder = 'Description (optional)';
                desc.style.cssText = 'width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px;';
                desc.addEventListener('input', ()=> { if(fieldsPanel) syncFieldsJSON(fieldsPanel); });
                options.appendChild(desc);
            } else if(type === 'essay'){
                addGuide('Manual checking required. Optional rubric or instructions.');
                const ta = document.createElement('textarea');
                ta.className = 'q-essay';
                ta.rows = 3;
                ta.placeholder = 'Rubric or guidance for students (optional)';
                ta.style.width = '100%';
                options.appendChild(ta);
            } else if(type === 'enumeration'){
                addGuide('Add the standard answers (saved in UPPERCASE).');
                const fieldsPanel = options.closest('.fields-panel');
                const wrap = document.createElement('div');
                wrap.className = 'q-enum-answers';
                wrap.style.cssText = 'display:flex;flex-direction:column;gap:8px;';
                function addRow(value){
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex;gap:8px;align-items:center;';
                    row.innerHTML = `
                        <input type="text" class="q-enum-answer" placeholder="Answer" style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px;font-weight:700;text-transform:uppercase;">
                        <button type="button" class="btn btn-small q-enum-remove" style="background:#e5e7eb;color:#111827;">Remove</button>
                    `;
                    const input = row.querySelector('.q-enum-answer');
                    input.value = String(value || '').toUpperCase();
                    input.addEventListener('input', function(){
                        const start = typeof input.selectionStart === 'number' ? input.selectionStart : null;
                        const end = typeof input.selectionEnd === 'number' ? input.selectionEnd : null;
                        const up = String(input.value || '').toUpperCase();
                        if(input.value !== up) input.value = up;
                        if(start != null && end != null){
                            try{ input.setSelectionRange(start, end); }catch(_) {}
                        }
                        if(fieldsPanel) syncFieldsJSON(fieldsPanel);
                    });
                    row.querySelector('.q-enum-remove').addEventListener('click', function(){
                        const rows = wrap.querySelectorAll('.q-option-row');
                        if(rows.length <= 1) return;
                        row.remove();
                        if(fieldsPanel) syncFieldsJSON(fieldsPanel);
                    });
                    wrap.appendChild(row);
                }
                addRow('');
                addRow('');
                options.appendChild(wrap);
                const addBtn = document.createElement('button');
                addBtn.type='button';
                addBtn.className='add-option-link';
                addBtn.style.cssText='background:none;border:none;color:#0d6efd;cursor:pointer;text-align:left;padding:0;margin-top:4px;font-weight:800;';
                addBtn.textContent='Add answer';
                addBtn.addEventListener('click', ()=> { addRow(''); if(fieldsPanel) syncFieldsJSON(fieldsPanel); });
                options.appendChild(addBtn);
                const note = document.createElement('div');
                note.style.cssText = 'color:#64748b;font-size:.82rem;font-weight:700;margin:6px 0 10px 0;';
                note.textContent = 'Note: Answers will be saved in UPPERCASE as the standard answer.';
                options.appendChild(note);
                const desc = document.createElement('textarea');
                desc.className = 'q-enum-desc';
                desc.rows = 2;
                desc.placeholder = 'Description (optional)';
                desc.style.cssText = 'width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px;';
                desc.addEventListener('input', ()=> { if(fieldsPanel) syncFieldsJSON(fieldsPanel); });
                options.appendChild(desc);
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
                    <input type="${container.closest('.q-block')?.querySelector('.q-type')?.value === 'multiple_choice_multiple' ? 'checkbox' : 'radio'}" class="q-correct" name="${group}">
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
                if(isMultipleChoiceType(type)){
                    const opts = Array.from(b.querySelectorAll('.q-option')).map(i=>i.value).filter(v=>v && v.trim()!=='');
                    q.options = opts;
                    q.type = normalizeMcType(type);
                    const correctIndexes = Array.from(b.querySelectorAll('.q-option-row')).map((row, index) => row.querySelector('.q-correct')?.checked ? index : null).filter(index => index !== null);
                    q.correct_answers = correctIndexes.map(choiceIndexToLetter);
                    if(q.type === 'multiple_choice_single' && correctIndexes.length) q.answer_index = correctIndexes[0];
                } else if(type === 'true_false'){
                    q.options = ['True','False'];
                } else if(type === 'identification'){
                    const ans = String(b.querySelector('.q-id-answer')?.value || '').trim().toUpperCase();
                    const desc = String(b.querySelector('.q-id-desc')?.value || '').trim();
                    if(ans) q.answer = ans;
                    if(desc) q.description = desc;
                } else if(type === 'essay'){
                    const rb = b.querySelector('.q-essay')?.value || '';
                    if(rb) q.instructions = rb;
                } else if(type === 'enumeration'){
                    const answers = Array.from(b.querySelectorAll('.q-enum-answer')).map(i=> String(i.value || '').trim().toUpperCase()).filter(v=> v !== '');
                    const desc = String(b.querySelector('.q-enum-desc')?.value || '').trim();
                    if(answers.length) q.answers = answers;
                    if(desc) q.description = desc;
                }
                questions.push(q);
            });
            const textarea = panel.querySelector('textarea[name$="[questions_json]"]');
            textarea.value = JSON.stringify(questions);
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
            const courseType = document.querySelector('input[name="course_type"]:checked');
            if(!courseType){ ok = false; setError(document.querySelector('input[name="course_type"]'),'courseTypeError','Select a course type.'); } else { setError(document.querySelector('input[name="course_type"]'),'courseTypeError',''); }
            
            const imageDraft = document.getElementById('image_draft_data');
            if((!image.files || !image.files[0]) && (!imageDraft || !imageDraft.value)){
                ok = false; 
                setError(image,'imageError','Image is required.');
            } else if(image.files && image.files[0]) {
                const f = image.files[0];
                const okType = f.type && f.type.startsWith('image/');
                const okSize = f.size <= 5*1024*1024;
                if(!okType || !okSize){
                    ok = false;
                    setError(image,'imageError','Image must be JPG/PNG/GIF/WebP and ≤ 5MB.');
                } else {
                    setError(image,'imageError','');
                }
            } else {
                setError(image,'imageError','');
            }
            return ok;
        }
        function validateModules(){
            let ok = true;
            const messages = [];
            const modules = Array.from(document.querySelectorAll('.module-wrapper'));
            if(modules.length === 0){ ok = false; messages.push('Add at least one module.'); }
            modules.forEach((m,i)=>{
                const title = m.querySelector('.module-title-input');
                if(!title.value.trim() || title.value.length > 80){ ok = false; title.style.borderColor = '#dc2626'; messages.push('Module '+(i+1)+': title is required (max 80).'); } else title.style.borderColor = '#ddd';
                const topics = Array.from(m.querySelectorAll('.topic-row'));
                topics.forEach((t)=>{
                    const input = t.querySelector('input[type=text]');
                    if(!input.value.trim() || input.value.length > 80){ ok = false; input.style.borderColor = '#dc2626'; messages.push('Module '+(i+1)+': each topic needs a title (max 80).'); } else input.style.borderColor = '#ddd';
                });
                // Validate any module-level exams: require title if exam exists
                const examWrap = m.querySelector('.module-exam, .exam-wrapper');
                if(examWrap){
                    const titleInput = examWrap.querySelector('.exam-title');
                    if(titleInput && !titleInput.value.trim()){
                        ok = false;
                        titleInput.style.borderColor = '#dc2626';
                        messages.push('Module '+(i+1)+': exam title is required.');
                    } else if(titleInput){
                        titleInput.style.borderColor = '#e5e7eb';
                    }
                }
            });
            const err = document.getElementById('modulesError');
            if(!ok){ 
                err.style.display='block';
                err.innerHTML = '<ul style="margin:0;padding-left:18px">'+messages.map(m=>'<li>'+m+'</li>').join('')+'</ul>';
            } else { 
                err.style.display='none'; 
                err.textContent=''; 
            }
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
                const draft = document.getElementById('image_draft_data');
                const hasFile = image.files && image.files[0];
                const hasDraft = draft && draft.value;
                if (!hasFile && !hasDraft) return false;
                
                if (hasFile) {
                    const f = image.files[0];
                    const okType = !!f.type && f.type.startsWith('image/');
                    const okSize = f.size <= 5 * 1024 * 1024;
                    if (!okType || !okSize) return false;
                }
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
            const finalizeDone = detailsDone && modulesDone && certificateDone;

            step1.classList.toggle('done', detailsDone);
            step2.classList.toggle('done', modulesDone);
            step3.classList.toggle('done', certificateDone);
            step4.classList.toggle('done', finalizeDone);

            const completedCount = (detailsDone ? 1 : 0) + (modulesDone ? 1 : 0) + (certificateDone ? 1 : 0) + (finalizeDone ? 1 : 0);
            const percent = Math.round((completedCount / 4) * 100);
            if (progressFill) progressFill.style.width = `${percent}%`;
            if (progressText) progressText.textContent = `${percent}% complete (${completedCount}/4 steps)`;

            const enable2 = detailsDone;
            step2.classList.toggle('disabled', !enable2);
            step2.disabled = !enable2;
            step2.setAttribute('aria-disabled', enable2 ? 'false' : 'true');

            const enable3 = detailsDone && modulesDone;
            step3.classList.toggle('disabled', !enable3);
            step3.disabled = !enable3;
            step3.setAttribute('aria-disabled', enable3 ? 'false' : 'true');

            const enable4 = detailsDone && modulesDone && certificateDone;
            step4.classList.toggle('disabled', !enable4);
            step4.disabled = !enable4;
            step4.setAttribute('aria-disabled', enable4 ? 'false' : 'true');

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = !enable4;
                submitBtn.style.opacity = enable4 ? '1' : '0.6';
            }
        }
        const COURSE_CREATE_TAB_QUERY = 'course-create';
        const COURSE_CREATE_STEP_KEY = 'course_create_current_step';
        const COURSE_CREATE_TAB_KEY = 'course_create_current_tab';
        const IS_EMBEDDED_CREATE = @json(request()->boolean('embedded'));
        const STEP_NAME_BY_TAB = {
            1: 'details',
            2: 'modules',
            3: 'certificate',
            4: 'finalize',
        };
        const TAB_BY_STEP_NAME = Object.fromEntries(Object.entries(STEP_NAME_BY_TAB).map(([tab, step]) => [step, Number(tab)]));
        let CURRENT_TAB = 1;
        function normalizeCourseCreateTab(tab) {
            const num = Number(tab);
            return STEP_NAME_BY_TAB[num] ? num : null;
        }
        function getStepNameForTab(tab) {
            return STEP_NAME_BY_TAB[normalizeCourseCreateTab(tab)] || STEP_NAME_BY_TAB[1];
        }
        function getTabFromStepName(step) {
            return TAB_BY_STEP_NAME[String(step || '').trim().toLowerCase()] || null;
        }
        function persistCurrentStepState(tab) {
            const normalizedTab = normalizeCourseCreateTab(tab) || 1;
            const step = getStepNameForTab(normalizedTab);
            try {
                sessionStorage.setItem(COURSE_CREATE_TAB_KEY, String(normalizedTab));
                sessionStorage.setItem(COURSE_CREATE_STEP_KEY, step);
            } catch (e) {}
            try {
                const url = new URL(window.location.href);
                url.searchParams.set('tab', COURSE_CREATE_TAB_QUERY);
                url.searchParams.set('step', step);
                window.history.replaceState({ step }, '', url.toString());
            } catch (e) {}
            if (IS_EMBEDDED_CREATE) {
                try {
                    const topUrl = new URL(window.top.location.href);
                    topUrl.searchParams.set('tab', COURSE_CREATE_TAB_QUERY);
                    topUrl.searchParams.set('step', step);
                    window.top.history.replaceState({ step }, '', topUrl.toString());
                } catch (e) {}
            }
        }
        function getRequestedTabFromUrl() {
            try {
                const url = new URL(window.location.href);
                return getTabFromStepName(url.searchParams.get('step'));
            } catch (e) {
                return null;
            }
        }
        function resolveInitialCourseCreateTab(fallbackTab = null) {
            const urlTab = getRequestedTabFromUrl();
            if (urlTab) return urlTab;
            try {
                const sessionTab = normalizeCourseCreateTab(sessionStorage.getItem(COURSE_CREATE_TAB_KEY));
                if (sessionTab) return sessionTab;
                const sessionStepTab = getTabFromStepName(sessionStorage.getItem(COURSE_CREATE_STEP_KEY));
                if (sessionStepTab) return sessionStepTab;
            } catch (e) {}
            return normalizeCourseCreateTab(fallbackTab) || 1;
        }
        function switchTo(tab, options = {}){
            const normalizedTab = normalizeCourseCreateTab(tab) || 1;
            const { scroll = true, persist = true, scheduleSave = true } = options;
            CURRENT_TAB = normalizedTab;
            if (normalizedTab === 4) renderSummary();

            [1,2,3,4].forEach(n => {
                const t = document.getElementById('tab' + n);
                const s = document.getElementById('step' + n);
                if (t) t.classList.toggle('active', normalizedTab === n);
                if (s) {
                    s.classList.toggle('active', normalizedTab === n);
                    s.setAttribute('aria-selected', normalizedTab === n ? 'true' : 'false');
                }
            });

            if(normalizedTab === 2){ ensureDefaultModule(); }
            updateProgress();
            if (persist) persistCurrentStepState(normalizedTab);
            if (scroll) window.scrollTo({ top: 0, behavior: 'smooth' });
            if (scheduleSave) scheduleAutoSave();
        }
        function renderSummary() {
            // Course Details
            document.getElementById('summaryName').textContent = document.getElementById('name').value || '(Untitled Course)';
            document.getElementById('summaryDescription').textContent = document.getElementById('description').value || '(No description)';
            const selectedSubjects = getSelectedSubjectAreas();
            document.getElementById('summarySubject').textContent = selectedSubjects.length ? selectedSubjects.join(', ') : '(No subject area)';
            document.getElementById('summaryAcademicYear').textContent = document.querySelector('input[name="academic_year"]').value || '(Not set)';
            const courseType = document.querySelector('input[name="course_type"]:checked');
            document.getElementById('summaryCourseType').textContent = courseType ? courseType.value.charAt(0).toUpperCase() + courseType.value.slice(1) : '(No course type selected)';
            
            const startDate = document.getElementById('start_date').value;
            if (startDate) {
                const d = new Date(startDate);
                document.getElementById('summaryStart').textContent = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            } else {
                document.getElementById('summaryStart').textContent = 'Not Set';
            }

            const expInput = document.getElementById('course_expiration_date');
            const expSummary = document.getElementById('summaryExpiration');
            if (expInput && expSummary) {
                const expDate = expInput.value;
                if (expDate) {
                    const d = new Date(expDate);
                    expSummary.textContent = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                } else {
                    expSummary.textContent = 'Not Set';
                }
            }

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
            updateProgress();
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
            document.getElementById('step1').addEventListener('click', ()=> switchTo(1));
            document.getElementById('step2').addEventListener('click', ()=>{
                if(validateDetails()) switchTo(2);
            });
            document.getElementById('step3').addEventListener('click', ()=>{
                if(validateDetails() && validateModules()) switchTo(3);
            });
            document.getElementById('step4').addEventListener('click', ()=>{
                if(validateDetails() && validateModules() && isCertificateStepComplete()) switchTo(4);
            });
            document.getElementById('nextToModules').addEventListener('click', ()=>{
                if(validateDetails()) { switchTo(2); updateProgress(); }
            });
            document.getElementById('nextToCertificate').addEventListener('click', ()=>{
                if(validateModules()) { switchTo(3); updateProgress(); }
            });
            document.getElementById('nextToFinalize').addEventListener('click', ()=>{
                if(isCertificateStepComplete()) { switchTo(4); updateProgress(); }
                else {
                    const err = document.getElementById('certError');
                    if(err) err.style.display = 'block';
                }
            });
            document.getElementById('backToDetails').addEventListener('click', ()=> switchTo(1));
            document.getElementById('backToModules').addEventListener('click', ()=> switchTo(2));
            document.getElementById('backToCertificate').addEventListener('click', ()=> switchTo(3));

            document.getElementById('saveDraftBtn').addEventListener('click', () => saveDraft(false));
            document.getElementById('saveDraftBtn2').addEventListener('click', () => saveDraft(false));
            document.getElementById('saveDraftBtn3').addEventListener('click', () => saveDraft(false));
            document.getElementById('saveDraftBtn4').addEventListener('click', () => saveDraft(false));

            ['name','description','image'].forEach(id=>{
                const el = document.getElementById(id);
                if(el) {
                    el.addEventListener('input', updateProgress);
                    el.addEventListener('change', updateProgress);
                }
            });
            document.querySelectorAll('input[name="subject_area[]"]').forEach(el => {
                el.addEventListener('change', updateProgress);
                el.addEventListener('change', updateSubjectAreaDropdownLabel);
            });
            document.getElementById('courseForm').addEventListener('submit', (e)=>{
                updateProgress();
                if(!validateDetails()) { e.preventDefault(); switchTo(1); return; }
                if(!validateModules()) { e.preventDefault(); switchTo(2); return; }
                const examError = validateExamQuestionPayloads();
                if(examError) {
                    e.preventDefault();
                    switchTo(2);
                    focusExamValidationTarget(examError);
                    alert(examError.message || 'Please review your exam questions.');
                    return;
                }
                if(!isCertificateStepComplete()) { 
                    e.preventDefault(); 
                    switchTo(3);
                    const err = document.getElementById('certError');
                    if(err) err.style.display = 'block';
                    return; 
                }
            });
            // Prevent accidental submit when pressing Enter inside exam builders/inputs
            const form = document.getElementById('courseForm');
            form.addEventListener('keydown', function(ev){
                if(ev.key !== 'Enter') return;
                const inExam = ev.target.closest('.exam-wrapper') || ev.target.closest('.module-exam') || ev.target.classList.contains('exam-title') || ev.target.classList.contains('exam-desc') || ev.target.classList.contains('exam-duration') || ev.target.classList.contains('eq-text');
                if(inExam){
                    ev.preventDefault();
                }
            });
        }
        function validateExamQuestionPayloads(){
            const fields = Array.from(document.querySelectorAll('.exam-json, .module-exam-json'));
            for(const field of fields){
                const raw = String(field.value || '').trim();
                if(!raw) continue;
                let payload = null;
                try { payload = JSON.parse(raw); } catch(e) {
                    return { message: 'Exam data is invalid. Please review your questions.', field };
                }
                const questions = Array.isArray(payload.questions) ? payload.questions : [];
                for(let i = 0; i < questions.length; i++){
                    const q = questions[i] || {};
                    if(!String(q.text || q.title || '').trim()) {
                        return {
                            message: `Question ${i + 1} text is required.`,
                            field,
                            questionIndex: i,
                            target: 'text'
                        };
                    }
                    if(isMultipleChoiceType(q.type)){
                        const validation = validateMultipleChoicePayload(Object.assign({}, q, { type: normalizeMcType(q.type) }));
                        if(validation.message) {
                            return Object.assign(validation, {
                                message: `Question ${i + 1}: ${validation.message}`,
                                field,
                                questionIndex: i
                            });
                        }
                    }
                }
            }
            return null;
        }
        function focusExamValidationTarget(error){
            if(!error || !error.field) return;
            setTimeout(() => {
                document.querySelectorAll('.exam-validation-highlight').forEach(el => {
                    el.classList.remove('exam-validation-highlight');
                    el.style.boxShadow = '';
                    el.style.background = '';
                    el.style.borderRadius = '';
                });

                const field = error.field;
                const moduleWrapper = field.closest('.module-wrapper');
                const examWrap = field.closest('.exam-wrapper') || moduleWrapper?.querySelector('.module-exam');
                if(!examWrap) return;

                if(examWrap.classList.contains('exam-wrapper') && typeof setActiveExamIndex === 'function' && Number.isInteger(error.questionIndex)){
                    setActiveExamIndex(examWrap, error.questionIndex, { focusBuilder: false });
                } else if(Number.isInteger(error.questionIndex)) {
                    const navButton = examWrap.querySelectorAll('.nav-question')[error.questionIndex];
                    if(navButton) navButton.click();
                }

                setTimeout(() => {
                    let focusEl = examWrap.querySelector('.eq-text');
                    if(error.target === 'choices' || (Array.isArray(error.choiceIndexes) && error.choiceIndexes.length)){
                        const rows = Array.from(examWrap.querySelectorAll('.eq-choices .q-option-row'));
                        const badIndexes = Array.isArray(error.choiceIndexes) ? error.choiceIndexes : [];
                        badIndexes.forEach(index => {
                            const row = rows[index];
                            if(!row) return;
                            row.classList.add('exam-validation-highlight');
                            row.style.boxShadow = '0 0 0 3px rgba(220,38,38,.22)';
                            row.style.background = '#fef2f2';
                            row.style.borderRadius = '8px';
                        });
                        const firstBadRow = rows[badIndexes[0]];
                        focusEl = firstBadRow?.querySelector('.eq-option')
                            || examWrap.querySelector('.eq-choices .eq-correct')
                            || examWrap.querySelector('.eq-choices .eq-option')
                            || focusEl;
                    }

                    examWrap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    if(focusEl){
                        focusEl.focus({ preventScroll: true });
                        if(typeof focusEl.select === 'function') focusEl.select();
                    }
                }, 80);
            }, 80);
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
                            const kindInput = t.querySelector('.section-kind');
                            const kind = String(t.dataset.sectionKind || (kindInput ? kindInput.value : '') || 'topic');
                            const tTitleInput = t.querySelector('input[name*="[title]"]');
                            const tTitle = tTitleInput ? tTitleInput.value : '';
                            if (kind === 'quiz' || t.classList.contains('quiz-row')) {
                                const fieldsArea = t.querySelector('textarea[name*="[fields_json]"]');
                                const fieldsJson = fieldsArea ? fieldsArea.value : '';
                                topics.push({ kind: 'quiz', title: tTitle, fields_json: fieldsJson, subtopics: [] });
                            } else {
                                const subtopics = [];
                                t.querySelectorAll('.subtopic-row').forEach((s, k) => {
                                    const sTitleInput = s.querySelector('input[name*="[title]"]');
                                    const sTitle = sTitleInput ? sTitleInput.value : '';
                                    const fieldsArea = s.querySelector('textarea[name*="[fields_json]"]');
                                    const fieldsJson = fieldsArea ? fieldsArea.value : '';
                                    subtopics.push({ title: sTitle, fields_json: fieldsJson });
                                });
                                topics.push({ kind: 'topic', title: tTitle, subtopics: subtopics });
                            }
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

            function hydrateFields(panel, fieldsJson) {
                if (!panel || !fieldsJson) return;
                try {
                    const fields = JSON.parse(fieldsJson);
                    if (!Array.isArray(fields)) return;
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
                                qType.value = isMultipleChoiceType(f.question.type) ? normalizeMcType(f.question.type) : (f.question.type || 'multiple_choice_single');
                                setupDefaultOptions(block);
                                if (isMultipleChoiceType(f.question.type) && Array.isArray(f.question.options) && f.question.options.length > 0) {
                                    const optsDiv = block.querySelector('.q-options');
                                    optsDiv.innerHTML = '';
                                    const correctIndexes = normalizeCorrectAnswerIndexes({
                                        choices: f.question.options,
                                        correct_answers: f.question.correct_answers,
                                        correct_answer: f.question.correct_answer,
                                        answer_index: f.question.answer_index
                                    });
                                    f.question.options.forEach((opt, optIdx) => {
                                        addOptionRow(optsDiv, '');
                                        const row = optsDiv.querySelectorAll('.q-option-row')[optIdx];
                                        if(row){
                                            const input = row.querySelector('.q-option');
                                            const radio = row.querySelector('.q-correct');
                                            if(input) input.value = opt;
                                            if(radio && correctIndexes.includes(optIdx)) radio.checked = true;
                                        }
                                    });
                                    ensureAddOptionLink(optsDiv);
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
                                    if (ansInput) ansInput.value = String(f.question.answer || '').toUpperCase();
                                    const descInput = block.querySelector('.q-id-desc');
                                    if (descInput) descInput.value = String(f.question.description || '');
                                } else if (f.question.type === 'enumeration') {
                                    const answers = Array.isArray(f.question.answers) ? f.question.answers : [];
                                    const wrap = block.querySelector('.q-enum-answers');
                                    if (wrap) {
                                        wrap.innerHTML = '';
                                        const vals = answers.length ? answers : ['', ''];
                                        vals.forEach(v => {
                                            const row = document.createElement('div');
                                            row.className = 'q-option-row';
                                            row.style.cssText = 'display:flex;gap:8px;align-items:center;';
                                            row.innerHTML = `
                                                <input type="text" class="q-enum-answer" placeholder="Answer" style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px;font-weight:700;text-transform:uppercase;">
                                                <button type="button" class="btn btn-small q-enum-remove" style="background:#e5e7eb;color:#111827;">Remove</button>
                                            `;
                                            const input = row.querySelector('.q-enum-answer');
                                            input.value = String(v || '').toUpperCase();
                                            row.querySelector('.q-enum-remove').addEventListener('click', function(){
                                                const rows = wrap.querySelectorAll('.q-option-row');
                                                if(rows.length <= 1) return;
                                                row.remove();
                                                syncFieldsJSON(panel);
                                            });
                                            input.addEventListener('input', function(){
                                                const start = typeof input.selectionStart === 'number' ? input.selectionStart : null;
                                                const end = typeof input.selectionEnd === 'number' ? input.selectionEnd : null;
                                                const up = String(input.value || '').toUpperCase();
                                                if(input.value !== up) input.value = up;
                                                if(start != null && end != null){
                                                    try{ input.setSelectionRange(start, end); }catch(_) {}
                                                }
                                                syncFieldsJSON(panel);
                                            });
                                            wrap.appendChild(row);
                                        });
                                    }
                                    const descInput = block.querySelector('.q-enum-desc');
                                    if (descInput) descInput.value = String(f.question.description || '');
                                }
                            }
                            updateQuestionCardSummary(block);
                            collapseQuestionCard(block);
                        }
                    });
                } catch (e) {}
            }

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
                            const kind = String((t && t.kind) ? t.kind : ((t && t.fields_json) ? 'quiz' : 'topic'));
                            if (kind === 'quiz') {
                                addQuizInput(topicsContainer);
                                const quizRow = topicsContainer.lastElementChild;
                                quizRow.querySelector('input[name*="[title]"]').value = t.title || '';
                                const ta = quizRow.querySelector('textarea[name*="[fields_json]"]');
                                if (ta) ta.value = t.fields_json || '';
                                hydrateFields(quizRow.querySelector('.fields-panel'), t.fields_json || '');
                            } else {
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
                                        hydrateFields(subRow.querySelector('.fields-panel'), s.fields_json || '');
                                    });
                                }
                            }
                        });
                    }
                }
            });
            reindexModules();
        }

        function draftKey(){ 
            // Use the key provided by the dashboard or generated for this session
            let key = sessionStorage.getItem('draft_course_key');
            if(!key){
                // Stable key for "new course" creation to survive refresh even if sessionStorage is flaky
                key = 'draft_course_active_new_u_{{ auth()->id() }}_r_{{ strtolower((string) (auth()->user()->role ?? "user")) }}';
                sessionStorage.setItem('draft_course_key', key);
            }
            return key; 
        }
        function confirmGoToCertifications(url) {
            const modal = document.getElementById('confirmCertModal');
            const confirmBtn = document.getElementById('confirmCertBtn');
            modal.style.display = 'flex';
            confirmBtn.onclick = function() {
                saveDraft(true);
                window.top.location.href = url;
            };
        }
        function closeConfirmCertModal() {
            document.getElementById('confirmCertModal').style.display = 'none';
        }
        function confirmBackNavigation(url) {
            const modal = document.getElementById('confirmBackModal');
            const confirmBtn = document.getElementById('confirmBackBtn');
            if (!modal || !confirmBtn) {
                saveDraft(true);
                window.top.location.href = url;
                return;
            }
            modal.style.display = 'flex';
            confirmBtn.onclick = function() {
                saveDraft(true);
                window.top.location.href = url;
            };
        }
        function closeConfirmBackModal() {
            const modal = document.getElementById('confirmBackModal');
            if (modal) modal.style.display = 'none';
        }
        let autoSaveTimer = null;
        function scheduleAutoSave() {
            if (autoSaveTimer) clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft(true); // true means silent save
            }, 2000); // Auto-save after 2 seconds of inactivity
        }

        function updateClearDraftButtonVisibility() {
            const btn = document.getElementById('clearDraftBtn');
            if (!btn) return;
            const key = draftKey();
            btn.style.display = localStorage.getItem(key) ? 'inline-flex' : 'none';
        }

        async function clearCurrentDraft() {
            if (!await window.capdevConfirm('Sigurado ka bang gusto mong burahin ang draft na ito? Mawawala ang lahat ng iyong nasimulan.', { title: 'Burahin ang Draft', confirmText: 'Burahin', cancelText: 'Cancel' })) return;
            const key = draftKey();
            localStorage.removeItem(key);
            deleteFilesFromDB(key + '_materials');
            sessionStorage.removeItem('draft_course_key');
            sessionStorage.removeItem(COURSE_CREATE_TAB_KEY);
            sessionStorage.removeItem(COURSE_CREATE_STEP_KEY);
            window.location.reload();
        }

        function setDraftStatus(mode, timeText = '') {
            const el = document.getElementById('draftStatusText');
            if (!el) return;
            if (mode === 'saving') {
                el.style.display = 'inline-flex';
                el.innerHTML = '<i class="fas fa-spinner fa-spin" style="color:#64748b"></i><span>Saving...</span>';
                return;
            }
            if (mode === 'saved') {
                const safeTime = String(timeText || '').trim();
                el.style.display = 'inline-flex';
                el.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981"></i><span>Saved in drafts' + (safeTime ? (' · ' + safeTime) : '') + '</span>';
                return;
            }
            el.style.display = 'none';
            el.innerHTML = '';
        }

        function saveDraft(silent = false){
            try {
                setDraftStatus('saving');
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
                obj['current_tab'] = CURRENT_TAB;
                obj['current_step'] = getStepNameForTab(CURRENT_TAB);
                
                // Save materials metadata
                const materialsInput = document.getElementById('course_materials');
                if (materialsInput && materialsInput.files.length > 0) {
                    obj['materials_metadata'] = Array.from(materialsInput.files).map(f => ({
                        name: f.name,
                        size: f.size
                    }));
                }
                
                const key = draftKey();
                const json = JSON.stringify(obj);
                
                try {
                    localStorage.setItem(key, json);
                    updateClearDraftButtonVisibility();

                    const now = new Date();
                    const stamp = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    setDraftStatus('saved', stamp);
                    
                    // Show auto-save indicator
                    const indicator = document.getElementById('autoSaveIndicator');
                    const timeSpan = document.getElementById('autoSaveTime');
                    if (indicator && timeSpan) {
                        indicator.style.opacity = '1';
                        timeSpan.textContent = stamp;
                        indicator.style.display = 'inline';
                        // Fade out after 3 seconds
                        setTimeout(() => {
                            indicator.style.opacity = '0.5';
                        }, 2000);
                        if (IS_EMBEDDED_CREATE) {
                            try {
                                window.parent.postMessage({ type: 'course_draft_saved', time: stamp }, '*');
                            } catch (e) {}
                        }
                    }

                    if (!silent) {
                        document.getElementById('draftSavedModal').style.display = 'flex';
                    } else {
                        console.log('Draft auto-saved');
                    }
                    return { ok: true, time: stamp };
                } catch (e) {
                    if (e.name === 'QuotaExceededError' || e.name === 'NS_ERROR_DOM_QUOTA_REACHED') {
                        if (!silent) alert('Puno na ang storage ng iyong browser. Subukang magbura ng ibang drafts sa dashboard.');
                    } else {
                        throw e;
                    }
                }
            } catch (err) {
                console.error('Failed to save draft:', err);
                if (!silent) alert('Nagkaroon ng error sa pag-save ng draft: ' + err.message);
            }
            setDraftStatus('hidden');
            return { ok: false };
        }
        function closeDraftSavedModal() {
            document.getElementById('draftSavedModal').style.display = 'none';
            // Redirect to dashboard and open modal
            window.top.location.href = "{{ route('dashboard') }}?open_drafts=1";
        }
        function restoreDraft(){
            const key = draftKey();
            const raw = localStorage.getItem(key);
            if(!raw) return null;
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
                
                // Restore materials metadata and ACTUAL files from IndexedDB
                getFilesFromDB(key + '_materials').then(fileDatas => {
                    if (fileDatas && Array.isArray(fileDatas)) {
                        const materialsInput = document.getElementById('course_materials');
                        if (materialsInput) {
                            const dt = new DataTransfer();
                            const files = fileDatas.map(fd => {
                                return new File([fd.blob], fd.name, { type: fd.type });
                            });
                            files.forEach(f => dt.items.add(f));
                            materialsInput.files = dt.files;
                            
                            // Re-render UI
                            renderMaterialsList(dt.files, true);
                        }
                    } else if (obj['materials_metadata'] && Array.isArray(obj['materials_metadata'])) {
                        // Fallback if DB is empty but metadata exists (original red text behavior)
                        const list = document.getElementById('materialsList');
                        if(list) {
                            list.innerHTML = '';
                            obj['materials_metadata'].forEach(file => {
                                const extension = file.name.split('.').pop().toLowerCase();
                                let icon = 'fa-file';
                                let color = '#64748b';
                                if (extension === 'pdf') { icon = 'fa-file-pdf'; color = '#ef4444'; }
                                else if (['doc', 'docx'].includes(extension)) { icon = 'fa-file-word'; color = '#2563eb'; }
                                else if (['xls', 'xlsx'].includes(extension)) { icon = 'fa-file-excel'; color = '#10b981'; }
                                else if (['ppt', 'pptx'].includes(extension)) { icon = 'fa-file-powerpoint'; color = '#f97316'; }

                                const badge = document.createElement('div');
                                badge.style.cssText = `display:flex;align-items:center;gap:10px;padding:10px 16px;background:#ffffff;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.88rem;color:#1e293b;font-weight:600;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);transition:transform 0.2s ease;`;
                                badge.innerHTML = `
                                    <i class="fas ${icon}" style="color: ${color}; font-size: 1.1rem;"></i>
                                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <span style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</span>
                                        <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 500;">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                                        <span style="color: #dc2626; font-size: 0.65rem; font-weight: 700;">(Re-attach for submission)</span>
                                    </div>
                                `;
                                list.appendChild(badge);
                            });
                        }
                    }
                }).catch(err => console.error('Error restoring files from DB:', err));

                // Restore modules
                if(obj['modules']) {
                    restoreModules(obj['modules']);
                }

                updateProgress();
                validateDetails();
                return normalizeCourseCreateTab(obj['current_tab']) || getTabFromStepName(obj['current_step']);
            }catch(e){
                return null;
            }
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
            bindSectionReorderDnd();
            let restoredDraftTab = null;

            document.querySelectorAll('a.js-confirm-back').forEach(a => {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    confirmBackNavigation(a.href);
                });
            });
            
            // Check if there's an existing draft for this session or a specific load request
            const key = draftKey();
            const hasDraft = !!localStorage.getItem(key);
            const loadDraftSignal = sessionStorage.getItem('load_draft');
            
            // Respect '0' as a signal NOT to load any draft
            if (loadDraftSignal === '0') {
                sessionStorage.removeItem(COURSE_CREATE_TAB_KEY);
                sessionStorage.removeItem(COURSE_CREATE_STEP_KEY);
            } else if (loadDraftSignal === '1' || hasDraft) {
                restoredDraftTab = restoreDraft();
            }
            
            // Clear the load_draft signal after processing
            sessionStorage.removeItem('load_draft');
            bindSubjectAreaDropdown();
            
            updateProgress();
            switchTo(resolveInitialCourseCreateTab(restoredDraftTab), { scroll: false, scheduleSave: false });
            __bindAutosizeTextareas(document);
            initDynamicMenu();
            updateClearDraftButtonVisibility();
            window.addEventListener('popstate', function(){
                const requestedTab = getRequestedTabFromUrl();
                if (requestedTab) {
                    switchTo(requestedTab, { persist: false, scroll: false, scheduleSave: false });
                }
            });
            
            const clearBtn = document.getElementById('clearDraftBtn');
            if (clearBtn) clearBtn.onclick = clearCurrentDraft;
            
            // Auto-save listeners
            const form = document.getElementById('courseForm');
            if (form) {
                form.addEventListener('input', scheduleAutoSave);
                form.addEventListener('change', scheduleAutoSave);
                let isSubmitting = false;
                let periodicAutoSave = null;
                try {
                    periodicAutoSave = window.setInterval(() => {
                        if (isSubmitting) return;
                        saveDraft(true);
                    }, 15000);
                } catch (e) {}
                window.addEventListener('beforeunload', function () {
                    if (isSubmitting) return;
                    saveDraft(true);
                });
                
                // Special case for editor content (since it doesn't always trigger 'input' on the form)
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.editor-toolbar button') || e.target.closest('.dm-item')) {
                        scheduleAutoSave();
                    }
                });
                
                // Clear draft on successful submit
                form.addEventListener('submit', () => {
                    isSubmitting = true;
                    const key = draftKey();
                    // We'll clear it after a short delay to ensure the form actually submits
                    setTimeout(() => {
                        localStorage.removeItem(key);
                        deleteFilesFromDB(key + '_materials');
                        sessionStorage.removeItem('draft_course_key');
                        sessionStorage.removeItem(COURSE_CREATE_TAB_KEY);
                        sessionStorage.removeItem(COURSE_CREATE_STEP_KEY);
                        try { if (periodicAutoSave) window.clearInterval(periodicAutoSave); } catch (e) {}
                    }, 1000);
                });
            }

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
                    // Clear draft data when a new file is chosen
                    if(draftInput) draftInput.value = '';
                    const reader = new FileReader();
                    reader.onload = e => { p.innerHTML = '<img alt="preview" src="'+e.target.result+'">'; };
                    reader.readAsDataURL(f);
                    const err = document.getElementById('imageError'); err.style.display='none'; err.textContent='';
                });
            }

            const importModal = document.getElementById('importLibraryModal');
            const openImportBtn = document.getElementById('openImportLibraryBtn');
            const closeImportBtn = document.getElementById('closeImportLibraryBtn');
            const importSearch = document.getElementById('importLibrarySearch');
            const importCards = document.querySelectorAll('.import-course-card');
            function setImportOpen(open){
                if (!importModal) return;
                importModal.style.display = open ? 'flex' : 'none';
                if (open && importSearch) {
                    importSearch.value = '';
                    importSearch.focus();
                    importCards.forEach(card => { card.style.display = ''; });
                }
            }
            try { window.openImportLibraryModal = function(){ setImportOpen(true); }; } catch (e) {}
            if (openImportBtn) openImportBtn.addEventListener('click', () => setImportOpen(true));
            if (closeImportBtn) closeImportBtn.addEventListener('click', () => setImportOpen(false));
            if (importModal) importModal.addEventListener('click', (e) => { if (e.target === importModal) setImportOpen(false); });
            if (importSearch) {
                importSearch.addEventListener('input', function(){
                    const q = String(importSearch.value || '').toLowerCase().trim();
                    importCards.forEach(card => {
                        const name = String(card.getAttribute('data-name') || '');
                        card.style.display = q ? (name.includes(q) ? '' : 'none') : '';
                    });
                });
            }

            async function importFromCourseLibrary(courseId){
                try {
                    const res = await fetch(`/courses/${courseId}/details-ajax`, { headers: { 'Accept': 'application/json' } });
                    const data = await res.json();
                    if (!data || !data.ok || !data.course) return;
                    const c = data.course;
                    const nameEl = document.getElementById('name');
                    const descEl = document.getElementById('description');
                    const videoEl = document.getElementById('video_url');
                    if (nameEl) nameEl.value = c.name || '';
                    if (descEl) descEl.value = c.description || '';
                    if (videoEl) videoEl.value = c.video_url || '';

                    const courseType = String(c.course_type || c.type || '').toLowerCase();
                    if (courseType) {
                        const ct = document.querySelector(`input[name="course_type"][value="${courseType}"]`);
                        if (ct) ct.checked = true;
                    }

                    const startEl = document.getElementById('start_date');
                    const expEl = document.getElementById('course_expiration_date');
                    if (startEl && c.start_date) startEl.value = String(c.start_date).slice(0, 10);
                    if (expEl && c.course_expiration_date) expEl.value = String(c.course_expiration_date).slice(0, 10);

                    const rawSubject = c.subject_area;
                    let subjects = [];
                    if (Array.isArray(rawSubject)) subjects = rawSubject;
                    else if (typeof rawSubject === 'string') {
                        const s = rawSubject.trim();
                        if (s.startsWith('[')) {
                            try { subjects = JSON.parse(s) || []; } catch (e) {}
                        } else {
                            subjects = s.split(',').map(x => x.trim()).filter(Boolean);
                        }
                    }
                    if (subjects.length) {
                        document.querySelectorAll('input[name="subject_area[]"]').forEach(cb => {
                            cb.checked = subjects.includes(cb.value);
                        });
                        updateSubjectAreaDropdownLabel();
                    }

                    const rawModules = Array.isArray(c.modules) ? c.modules : [];
                    const mapped = rawModules.map(m => {
                        const type = String(m.type || '').toLowerCase();
                        if (type === 'exam' || (m.exam_json && !m.topics)) {
                            const ex = (m.exam_json != null)
                                ? (typeof m.exam_json === 'string' ? m.exam_json : JSON.stringify(m.exam_json))
                                : (m.exam != null ? JSON.stringify(m.exam) : '');
                            return { type: 'exam', exam_json: ex };
                        }
                        const topics = Array.isArray(m.topics) ? m.topics.map(t => {
                            const subs = Array.isArray(t.subtopics) ? t.subtopics.map(s => {
                                let fj = s.fields_json;
                                if (fj == null && Array.isArray(s.fields)) fj = JSON.stringify(s.fields);
                                if (fj != null && typeof fj !== 'string') {
                                    try { fj = JSON.stringify(fj); } catch (e) { fj = ''; }
                                }
                                return { title: s.title || '', fields_json: fj || '' };
                            }) : [];
                            return { title: t.title || '', subtopics: subs };
                        }) : [];
                        const ex = (m.exam_json != null)
                            ? (typeof m.exam_json === 'string' ? m.exam_json : JSON.stringify(m.exam_json))
                            : (m.exam != null ? JSON.stringify(m.exam) : '');
                        return { type: 'module', title: m.title || '', topics: topics, exam_json: ex };
                    });
                    if (mapped.length) {
                        restoreModules(mapped);
                    } else {
                        ensureDefaultModule();
                    }

                    try {
                        const imgUrl = c.image_path;
                        if (imgUrl) {
                            const imgPreview = document.getElementById('imagePreview');
                            const imgDraftInput = document.getElementById('image_draft_data');
                            const fileNameDisplay = document.getElementById('fileNameDisplay');
                            const r = await fetch(imgUrl);
                            const blob = await r.blob();
                            const reader = new FileReader();
                            reader.onload = () => {
                                const base64 = String(reader.result || '');
                                if (imgPreview) imgPreview.innerHTML = `<img alt="preview" src="${base64}">`;
                                if (imgDraftInput) imgDraftInput.value = base64;
                                if (fileNameDisplay) fileNameDisplay.textContent = 'Imported from library';
                                scheduleAutoSave();
                            };
                            reader.readAsDataURL(blob);
                        }
                    } catch (e) {}

                    updateProgress();
                    scheduleAutoSave();
                    setImportOpen(false);
                    switchTo(1);
                } catch (e) {}
            }
            importCards.forEach(card => {
                card.addEventListener('click', () => {
                    const id = Number(card.getAttribute('data-course-id'));
                    if (!id) return;
                    importFromCourseLibrary(id);
                });
            });
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
        function isMultipleChoiceType(type){
            return ['multiple_choice', 'multiple_choice_single', 'multiple_choice_multiple'].includes(String(type || ''));
        }
        function normalizeMcType(type){
            return String(type || 'multiple_choice_single') === 'multiple_choice_multiple' ? 'multiple_choice_multiple' : 'multiple_choice_single';
        }
        function choiceIndexToLetter(index){
            return String.fromCharCode(65 + Number(index || 0));
        }
        function normalizeCorrectAnswerIndexes(payload){
            const choices = Array.isArray(payload?.choices) ? payload.choices : (Array.isArray(payload?.options) ? payload.options : []);
            let raw = Array.isArray(payload?.correct_answers) ? payload.correct_answers.slice() : [];
            if(raw.length === 0 && payload?.correct_answer !== undefined && payload.correct_answer !== null && payload.correct_answer !== '') raw = [payload.correct_answer];
            if(raw.length === 0 && payload?.answer_index !== undefined && payload.answer_index !== null && payload.answer_index !== '') raw = [payload.answer_index];
            const indexes = [];
            raw.forEach(value => {
                if(value === null || value === undefined || value === '') return;
                if(!isNaN(Number(value))){
                    indexes.push(Number(value));
                    return;
                }
                const s = String(value).trim();
                if(/^[A-Za-z]$/.test(s)){
                    indexes.push(s.toUpperCase().charCodeAt(0) - 65);
                    return;
                }
                const found = choices.findIndex(choice => String(choice || '').trim().toLowerCase() === s.toLowerCase());
                if(found >= 0) indexes.push(found);
            });
            return Array.from(new Set(indexes)).filter(index => Number.isInteger(index) && index >= 0 && index < choices.length);
        }
        function buildMultipleChoicePayload(type, text, choices, correctIndexes, maxPoints){
            const mcType = normalizeMcType(type);
            const uniqueIndexes = Array.from(new Set(correctIndexes.filter(index => Number.isInteger(index))));
            const payload = {
                type: mcType,
                text,
                choices,
                correct_answers: uniqueIndexes.map(choiceIndexToLetter),
                max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints
            };
            if(mcType === 'multiple_choice_single'){
                payload.answer_index = uniqueIndexes.length ? uniqueIndexes[0] : null;
            }
            return payload;
        }
        function validateMultipleChoicePayload(obj){
            const choices = Array.isArray(obj?.choices) ? obj.choices.map(choice => String(choice || '').trim()) : [];
            const filled = choices.filter(Boolean);
            const seenChoices = new Map();
            const duplicateDescriptions = [];
            const duplicateIndexes = [];
            choices.forEach((choice, index) => {
                if(!choice) return;
                const key = choice.toLowerCase();
                const label = choiceIndexToLetter(index);
                if(seenChoices.has(key)){
                    const first = seenChoices.get(key);
                    duplicateDescriptions.push(`choices ${first.label} and ${label} are both "${choice}"`);
                    duplicateIndexes.push(first.index, index);
                    return;
                }
                seenChoices.set(key, { label, choice, index });
            });
            const correct = Array.isArray(obj?.correct_answers) ? obj.correct_answers : [];
            if(filled.length < 2) return { message: 'Add at least two non-empty choices.', target: 'choices' };
            if(duplicateDescriptions.length) {
                return {
                    message: `Duplicate ${duplicateDescriptions.join('; ')}.`,
                    target: 'choices',
                    choiceIndexes: Array.from(new Set(duplicateIndexes))
                };
            }
            if(obj.type === 'multiple_choice_single' && correct.length !== 1) return { message: 'Select exactly one correct answer.', target: 'choices' };
            if(obj.type === 'multiple_choice_multiple' && correct.length < 1) return { message: 'Select at least one correct answer.', target: 'choices' };
            return {};
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
                            <span class="exam-meta-timer-label">Timer Mode</span>
                            <select class="exam-timer-mode exam-meta-timer-input">
                                <option value="timed">Timed</option>
                                <option value="untimed">No Timer</option>
                            </select>
                            <div class="exam-untimed-helper" style="display:none;font-size:0.7rem;color:#64748b;margin-top:4px;">This exam has no time limit.</div>
                        </label>
                        <label class="exam-meta-timer exam-duration-wrapper">
                            <span class="exam-meta-timer-label">Timer (minutes)</span>
                            <input type="number" min="1" max="600" class="exam-duration exam-meta-timer-input" placeholder="e.g., 30">
                        </label>
                        <label class="exam-meta-timer">
                            <span class="exam-meta-timer-label">Passing Rate (%)</span>
                            <input type="number" min="1" max="100" class="exam-passing-score exam-meta-timer-input" placeholder="e.g., 75">
                        </label>
                        <div class="exam-meta-title">Exam</div>
                    </div>
                    <div class="exam-questions" style="margin-top:10px">
                        <div class="exam-nav" style="display:flex;align-items:center;gap:8px;overflow-x:auto;padding:8px;border:1px solid #e5e7eb;border-radius:10px;background:#f8fafc;">
                            <div class="nav-track" style="display:flex;align-items:center;gap:6px;flex:1;min-width:0;"></div>
                        </div>
                        <div class="exam-q-list" style="display:none"></div>
                        <div class="exam-form-inputs" style="display:none"></div>
                        <div class="exam-q-builder" style="margin-top:10px;border-top:1px dashed #e5e7eb;padding-top:10px">
                            <div class="q-header" style="display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start">
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question</div>
                                    <textarea class="eq-text q-autosize" placeholder="Enter question" rows="3" data-min-lines="3" data-max-lines="10" style="resize:none;transition:height .15s ease;overflow:hidden;"></textarea>
                                </label>
                                <label class="q-col" style="display:block">
                                    <div class="q-label" style="font-weight:700;color:#111827;margin-bottom:6px">Question Type</div>
                                    <select class="eq-type">
                                        <option value="multiple_choice_single">Multiple Choice (Single Answer)</option>
                                        <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
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
                                <input class="eq-id-answer" type="text" placeholder="Enter answer" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-tf" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Answer</label>
                                <select class="eq-tf-answer" style="padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                                    <option value="" selected disabled>Select answer</option>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="eq-points" style="margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Points</label>
                                <input class="eq-common-points" type="number" min="1" step="0.01" required placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-essay" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Points</label>
                                <input class="eq-essay-points" type="number" min="1" step="0.01" required placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="eq-enum" style="display:none;margin-top:8px">
                                <label class="q-label" style="margin-bottom:6px">Correct Answers</label>
                                <div class="eq-enum-answers" style="display:grid;gap:8px"></div>
                                <button type="button" class="btn btn-small eq-enum-add" style="margin-top:8px;background:#eef2ff;color:#0f3b8f;border:1px solid #c7d2fe;border-radius:8px;padding:8px 12px">Add Answer</button>
                                <label class="q-label" style="margin:10px 0 6px">Points</label>
                                <input class="eq-enum-points" type="number" min="1" step="0.01" required placeholder="Enter points" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                            </div>
                            <div class="actions" style="display:flex;justify-content:center;gap:8px;margin-top:10px">
                                <button type="button" class="btn btn-ghost eq-add"><i class="fas fa-plus"></i> Add Question</button>
                                <button type="button" class="btn btn-ghost eq-del" disabled>Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            __bindAutosizeTextareas(host);
            function renderEnumerationAnswers(values){
                const answerWrap = host.querySelector('.eq-enum-answers');
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
            function syncBuilderBoxes(){
                const t = host.querySelector('.eq-type').value;
                host.querySelector('.eq-choices').style.display = isMultipleChoiceType(t) ? 'block':'none';
                host.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                host.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                host.querySelector('.eq-points').style.display = (t==='essay' || t==='enumeration') ? 'none':'block';
                host.querySelector('.eq-essay').style.display = (t==='essay') ? 'block':'none';
                host.querySelector('.eq-enum').style.display = (t==='enumeration') ? 'block':'none';
                if(isMultipleChoiceType(t) && host.querySelectorAll('.eq-option').length===0){ ensureChoiceRows(host); }
                if(t==='enumeration' && host.querySelectorAll('.eq-enum-answer').length===0){ renderEnumerationAnswers(); }
                window.CAPDEVQuestionBuilderShared.syncPointsValidation(host);
            }
            host.addEventListener('click', function(e){
                const addBtn = e.target.closest('.eq-enum-add');
                if(addBtn && addBtn.closest('.standalone-exam-container') === host){
                    e.preventDefault();
                    e.stopPropagation();
                    const current = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    current.push('');
                    renderEnumerationAnswers(current);
                    return;
                }
                const removeBtn = e.target.closest('.eq-enum-remove');
                if(removeBtn && removeBtn.closest('.standalone-exam-container') === host){
                    e.preventDefault();
                    e.stopPropagation();
                    const rows = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    const row = removeBtn.closest('.q-option-row');
                    const idx = Array.from(host.querySelectorAll('.eq-enum-answers .q-option-row')).indexOf(row);
                    const next = rows.filter((_, i)=> i !== idx);
                    renderEnumerationAnswers(next.length ? next : ['', '']);
                    const ev = new Event('input', { bubbles:true });
                    host.dispatchEvent(ev);
                }
            });
            host.querySelector('.exam-timer-mode').addEventListener('change', (e)=>{
                const mode = e.target.value;
                const wrapper = host.querySelector('.exam-duration-wrapper');
                const helper = host.querySelector('.exam-untimed-helper');
                const input = host.querySelector('.exam-duration');
                if(mode === 'untimed'){
                    wrapper.style.display = 'none';
                    helper.style.display = 'block';
                    input.required = false;
                } else {
                    wrapper.style.display = 'block';
                    helper.style.display = 'none';
                    input.required = true;
                }
                syncExamJSON();
            });
            function syncExamJSON(){
                const timerMode = host.querySelector('.exam-timer-mode').value;
                const duration = timerMode === 'timed' ? (parseInt(host.querySelector('.exam-duration')?.value || '0', 10) || 0) : 0;
                const passingScore = parseInt(host.querySelector('.exam-passing-score')?.value || '75', 10) || 75;
                const list = host.querySelectorAll('.exam-q-list .q-item');
                const qs = [];
                list.forEach(node=>{
                    try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && obj.text){ qs.push(obj); } }catch(e){}
                });
                hidden.value = JSON.stringify({ timer_minutes: duration, timer_mode: timerMode, passing_score: passingScore, questions: qs });
            }
            host.querySelector('.eq-type').addEventListener('change', ()=>{ syncBuilderBoxes(); syncExamJSON(); });
            host.addEventListener('input', syncExamJSON);
            host.addEventListener('change', syncExamJSON);
            function ensureInputsBox(){
                let box = host.querySelector('.exam-form-inputs');
                if(!box){
                    box = document.createElement('div');
                    box.className = 'exam-form-inputs';
                    box.style.display = 'none';
                    const container = host.querySelector('.exam-questions');
                    if(container) container.appendChild(box);
                }
                return box;
            }
            function buildGroup(idx, type){
                const div = document.createElement('div');
                div.className = 'exam-input-group';
                div.dataset.index = String(idx);
                const t = String(type||'multiple_choice_single');
                let html = '';
                html += '<input type="hidden" name="questions['+idx+'][type]" value="'+t+'">';
                html += '<input type="text" name="questions['+idx+'][question]" value="">';
                if(isMultipleChoiceType(t)){
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="hidden" name="questions['+idx+'][correct_answers][]" value="">';
                }else if(t==='identification'){
                    html += '<input type="text" name="questions['+idx+'][answer]" value="">';
                }else if(t==='true_false'){
                    html += '<input type="text" name="questions['+idx+'][answer]" value="">';
                }
                div.innerHTML = html;
                return div;
            }
            function addGroupFor(type){
                const box = ensureInputsBox();
                const idx = box.querySelectorAll('.exam-input-group').length;
                const g = buildGroup(idx, type);
                box.appendChild(g);
                return g;
            }
            function updateGroup(idx, obj){
                const box = ensureInputsBox();
                const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                const g = groups[idx];
                if(!g) return;
                const base = 'questions['+idx+']';
                const q = g.querySelector('input[name="'+base+'[question]"]'); if(q) q.value = obj.text||'';
                const t = g.querySelector('input[name="'+base+'[type]"]'); if(t) t.value = obj.type||'multiple_choice_single';
                if(isMultipleChoiceType(obj.type)){
                    const opts = g.querySelectorAll('input[name="'+base+'[options][]"]');
                    const arr = Array.isArray(obj.choices)?obj.choices:['','','',''];
                    opts.forEach((o,i)=>{ o.value = arr[i]||''; });
                    const ca = g.querySelector('input[name="'+base+'[correct_answers][]"]') || g.querySelector('input[name="'+base+'[correct_answer]"]');
                    if(ca) ca.value = Array.isArray(obj.correct_answers) ? obj.correct_answers.join(',') : '';
                }else{
                    const ans = g.querySelector('input[name="'+base+'[answer]"]');
                    if(ans){
                        if(obj.type==='identification'){ ans.value = obj.answer||''; }
                        else if(obj.type==='true_false'){ ans.value = obj.answer==null?'':(obj.answer===true?'true':'false'); }
                        else { ans.value=''; }
                    }
                }
            }
            function populateFromItem(idx){
                const items = Array.from(host.querySelectorAll('.exam-q-list .q-item'));
                const node = items[idx]; if(!node) return;
                let payload = {}; try{ payload = JSON.parse(node.dataset.payload||'{}'); }catch(e){}
                const text = String(payload.text||'');
                const type = String(payload.type||'multiple_choice_single');
                const txt = host.querySelector('.eq-text'); if(txt) txt.value = text;
                const sel = host.querySelector('.eq-type'); if(sel) sel.value = isMultipleChoiceType(type) ? normalizeMcType(type) : type;
                syncBuilderBoxes();
                if(isMultipleChoiceType(type)){
                    if(host.querySelectorAll('.eq-option').length===0){ ensureChoiceRows(host); }
                    const rows = Array.from(host.querySelectorAll('.eq-choices .q-option-row'));
                    const choices = Array.isArray(payload.choices) ? payload.choices : (Array.isArray(payload.options) ? payload.options : []);
                    rows.forEach((row,i)=>{ const inp=row.querySelector('.eq-option'); if(inp) inp.value=choices[i]||''; });
                    const correctIndexes = normalizeCorrectAnswerIndexes(Object.assign({}, payload, { choices }));
                    const inputs = Array.from(host.querySelectorAll('.eq-correct'));
                    inputs.forEach(input => { input.checked = correctIndexes.includes(Number(input.value)); });
                }else if(type==='identification'){
                    const ans = String(payload.answer||''); const a = host.querySelector('.eq-id-answer'); if(a) a.value = ans;
                    const commonPoints = host.querySelector('.eq-common-points');
                    if(commonPoints){
                        const maxPoints = payload.max_points;
                        commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                    }
                }else if(type==='true_false'){
                    const a = host.querySelector('.eq-tf-answer'); if(a) a.value = payload.answer===false ? 'false' : 'true';
                    const commonPoints = host.querySelector('.eq-common-points');
                    if(commonPoints){
                        const maxPoints = payload.max_points;
                        commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                    }
                }else if(type==='essay'){
                    const essayPoints = host.querySelector('.eq-essay-points');
                    if(essayPoints){
                        const maxPoints = payload.max_points;
                        essayPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                    }
                }else if(type==='enumeration'){
                    renderEnumerationAnswers(Array.isArray(payload.answers) ? payload.answers : []);
                    const enumPoints = host.querySelector('.eq-enum-points');
                    if(enumPoints){
                        const maxPoints = payload.max_points;
                        enumPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                    }
                }
            }
            function clearBuilderBox(){
                const t = host.querySelector('.eq-text'); if(t) t.value='';
                host.querySelectorAll('.eq-option').forEach(i=> i.value='');
                host.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                const id = host.querySelector('.eq-id-answer'); if(id) id.value='';
                const tf = host.querySelector('.eq-tf-answer'); if(tf) tf.value='';
                const commonPoints = host.querySelector('.eq-common-points'); if(commonPoints) commonPoints.value='';
                const essayPoints = host.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value='';
                renderEnumerationAnswers();
                const enumPoints = host.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value='';
                const focus = host.querySelector('.eq-text'); if(focus) focus.focus();
            }
            function getActiveIndex(){
                const track = host.querySelector('.nav-track');
                if(!track){
                    const items = Array.from(host.querySelectorAll('.exam-q-list .q-item'));
                    return Math.max(0, items.length - 1);
                }
                const blocks = Array.from(track.querySelectorAll('.nav-question'));
                const idx = blocks.findIndex(b=> b.classList.contains('active'));
                return idx>=0 ? idx : 0;
            }
            function setActiveIndex(i, options){
                options = options || {};
                const shouldFocusBuilder = options.focusBuilder !== false;
                const nav = host.querySelector('.exam-nav');
                const track = nav ? nav.querySelector('.nav-track') : null;
                const items = Array.from(host.querySelectorAll('.exam-q-list .q-item'));
                if(items.length===0) return;
                const clamped = Math.max(0, Math.min(items.length, i));
                if(nav && track){
                    const blocks = Array.from(track.querySelectorAll('.nav-question'));
                    blocks.forEach((b,bi)=>{
                        window.CAPDEVQuestionBuilderShared.applyQuestionButtonState(b, bi===clamped);
                    });
                }
                const delBtn = host.querySelector('.eq-del');
                if(delBtn){
                    const viewingExisting = clamped < items.length;
                    delBtn.disabled = !viewingExisting;
                    delBtn.style.opacity = viewingExisting ? '1' : '.45';
                    delBtn.style.cursor = viewingExisting ? 'pointer' : 'default';
                }
                if(clamped < items.length){
                    populateFromItem(clamped);
                } else {
                    const tVal = host.querySelector('.eq-type') ? host.querySelector('.eq-type').value : 'multiple_choice_single';
                    let obj = null;
                    if(isMultipleChoiceType(tVal)){
                        obj = buildMultipleChoicePayload(tVal, '', ['', '', '', ''], [], '');
                    }else if(tVal==='identification'){
                        obj = { type:'identification', text:'', answer: '', max_points: '' };
                    }else if(tVal==='true_false'){
                        obj = { type:'true_false', text:'', answer: null, max_points: '' };
                    } else {
                        obj = { type:String(tVal||'multiple_choice_single'), text:'', max_points: '' };
                    }
                    const listEl = host.querySelector('.exam-q-list');
                    const node = document.createElement('div');
                    node.className = 'q-item';
                    node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(items.length+1)+'. '+obj.text+'</div>'
                        + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                    node.dataset.payload = JSON.stringify(obj);
                    listEl.appendChild(node);
                    addGroupFor(obj.type);
                    updateNav();
                    populateFromItem(items.length);
                    if(shouldFocusBuilder){
                        const txt2 = host.querySelector('.eq-text'); if(txt2){ setTimeout(()=> txt2.focus(), 0); }
                    }
                    return;
                }
                if(shouldFocusBuilder){
                    const txt = host.querySelector('.eq-text'); if(txt){ setTimeout(()=> txt.focus(), 0); }
                }
            }
            function updateNav(){
                const nav = host.querySelector('.exam-nav');
                if(!nav) return;
                const track = nav.querySelector('.nav-track');
                if(!track) return;
                const items = Array.from(host.querySelectorAll('.exam-q-list .q-item'));
                track.innerHTML = '';
                items.forEach((_, i)=>{
                    const b = window.CAPDEVQuestionBuilderShared.createNavQuestionButton(i, ()=> setActiveIndex(i));
                    track.appendChild(b);
                });
                const addButton = window.CAPDEVQuestionBuilderShared.createNavAddButton(()=> host.querySelector('.eq-add')?.click());
                track.appendChild(addButton);
                setActiveIndex(getActiveIndex());
            }
            
            // Prefill logic
            if(prefill){
                try{
                    const normalizedPrefill = normalizeExamPrefill(prefill);
                    const timerMode = normalizedPrefill?.timer_mode || (normalizedPrefill?.timer_minutes > 0 ? 'timed' : 'untimed');
                    const modeEl = host.querySelector('.exam-timer-mode');
                    if(modeEl) modeEl.value = timerMode;
                    const wrapper = host.querySelector('.exam-duration-wrapper');
                    const input = host.querySelector('.exam-duration');
                    if(timerMode === 'untimed'){
                        if(wrapper) wrapper.style.display = 'none';
                        if(input) { input.required = false; input.value = ''; }
                    } else {
                        if(wrapper) wrapper.style.display = 'block';
                        if(input) { input.required = true; input.value = normalizedPrefill?.timer_minutes || ''; }
                    }
                    const pass = host.querySelector('.exam-passing-score'); if(pass) pass.value = normalizedPrefill?.passing_score || '';
                    const listEl = host.querySelector('.exam-q-list');
                    listEl.innerHTML = '';
                    const box = ensureInputsBox();
                    box.innerHTML = '';
                    (normalizedPrefill?.questions || []).forEach((q, i2)=>{
                        const node = document.createElement('div');
                        node.className = 'q-item';
                        node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(i2+1)+'. '+(q.text||'')+'</div>'
                            + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>';
                        node.dataset.payload = JSON.stringify(q);
                        listEl.appendChild(node);
                        addGroupFor(q.type);
                        updateGroup(i2, q);
                    });
                    updateNav();
                    syncExamJSON();
                    if(normalizedPrefill?.questions && normalizedPrefill.questions.length > 0) setActiveIndex(0, { focusBuilder: false });
                }catch(e){}
            }

            const delBtnMod = host.querySelector('.eq-del');
            if(delBtnMod && !delBtnMod.__bound){
                delBtnMod.__bound = true;
                delBtnMod.addEventListener('click', function(){
                    const listEl = host.querySelector('.exam-q-list');
                    const active = getActiveIndex();
                    const items = Array.from(listEl.children);
                    if(items.length===0) return;
                    const target = items[Math.min(active, items.length-1)];
                    target.remove();
                    Array.from(listEl.children).forEach((n,i)=>{
                        const t = n.querySelector('.qi-title');
                        if(t){ const payload = JSON.parse(n.dataset.payload||'{}'); t.textContent = (i+1)+'. '+(payload.text||''); }
                    });
                    const box = ensureInputsBox();
                    const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                    if(groups[Math.min(active, items.length-1)]) groups[Math.min(active, items.length-1)].remove();
                    const left = Array.from(box.querySelectorAll('.exam-input-group'));
                    left.forEach((g,i)=>{
                        g.dataset.index = String(i);
                        Array.from(g.querySelectorAll('input[name]')).forEach(inp=>{
                            inp.name = inp.name.replace(/questions\[\d+\]/, 'questions['+i+']');
                        });
                    });
                    updateNav();
                    syncExamJSON();
                    setActiveIndex(Math.max(0, active-1));
                });
            }
            host.querySelector('.eq-add').addEventListener('click', function(){
                const t = host.querySelector('.eq-type').value;
                // Create a brand-new blank question object (independent state)
                let obj = null;
                if(isMultipleChoiceType(t)){
                    obj = buildMultipleChoicePayload(t, '', ['', '', '', ''], [], '');
                }else if(t==='identification'){
                    obj = { type:'identification', text:'', answer: '', max_points: '' };
                }else if(t==='true_false'){
                    obj = { type:'true_false', text:'', answer: null, max_points: '' };
                }else if(t==='essay'){
                    obj = { type:'essay', text:'', max_points: '' };
                }else if(t==='enumeration'){
                    obj = { type:'enumeration', text:'', answers:['', ''], max_points: '' };
                } else {
                    obj = { type:String(t||'multiple_choice_single'), text:'' };
                }
                const listEl = host.querySelector('.exam-q-list');
                const idx = listEl.children.length + 1;
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx+'. '+obj.text+'</div>'
                    + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                // Clear builder input and set to blank state
                host.querySelector('.eq-text').value='';
                host.querySelectorAll('.eq-option').forEach(i=> i.value='');
                host.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                host.querySelector('.eq-id-answer').value='';
                const tfSel = host.querySelector('.eq-tf-answer'); if(tfSel){ tfSel.value=''; }
                const commonPoints = host.querySelector('.eq-common-points'); if(commonPoints){ commonPoints.value=''; }
                const essayPoints = host.querySelector('.eq-essay-points'); if(essayPoints){ essayPoints.value=''; }
                renderEnumerationAnswers();
                const enumPoints = host.querySelector('.eq-enum-points'); if(enumPoints){ enumPoints.value=''; }
                addGroupFor(obj.type);
                syncExamJSON();
                updateNav();
                setActiveIndex(idx-1);
                // Focus handled by setActiveIndex
            });
            (function bindModuleExamLiveUpdate(){
                document.addEventListener('input', function(e){
                    if(!host.contains(e.target)) return;
                    const idx = getActiveIndex();
                    const items = Array.from(host.querySelectorAll('.exam-q-list .q-item'));
                    if(idx >= items.length) return;
                    const t = host.querySelector('.eq-type').value;
                    const text = (host.querySelector('.eq-text').value||'').trim();
                    let obj = null;
                if(isMultipleChoiceType(t)){
                    const opts = Array.from(host.querySelectorAll('.eq-option')).map(i=>i.value.trim());
                    const checked = Array.from(host.querySelectorAll('.eq-correct:checked')).map(input => parseInt(input.value, 10)).filter(Number.isInteger);
                    const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = buildMultipleChoicePayload(t, text, opts, checked, maxPoints);
                    }else if(t==='identification'){
                        const ans = (host.querySelector('.eq-id-answer').value||'').trim();
                        const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'identification', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='true_false'){
                        const val = host.querySelector('.eq-tf-answer').value;
                        const ans = val === '' ? null : (val === 'true');
                        const maxPointsVal = host.querySelector('.eq-common-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'true_false', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='essay'){
                        const maxPointsVal = host.querySelector('.eq-essay-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'essay', text, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='enumeration'){
                        const answers = Array.from(host.querySelectorAll('.eq-enum-answer')).map(i=>i.value.trim());
                        const maxPointsVal = host.querySelector('.eq-enum-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'enumeration', text, answers, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    } else {
                        obj = { type:String(t||'multiple_choice_single'), text };
                    }
                    const node = items[idx];
                    node.dataset.payload = JSON.stringify(obj);
                    const title = node.querySelector('.qi-title');
                    if(title){ title.textContent = (idx+1)+'. '+(obj.text||''); }
                    updateGroup(idx, obj);
                    syncExamJSON();
                }, { passive:true });
                document.addEventListener('change', function(e){
                    if(!host.contains(e.target)) return;
                    const ev = new Event('input', { bubbles:true });
                    host.dispatchEvent(ev);
                }, { passive:true });
            })();
            syncBuilderBoxes(); syncExamJSON(); updateNav();
            expandModuleAccordion(body);
            return host;
        }
        function normalizeExamQuestionShape(q){
            if(!q || typeof q !== 'object') return null;
            const type = String(q.type || 'multiple_choice_single');
            const text = String(q.text ?? q.title ?? q.question ?? '').trim();
            if(isMultipleChoiceType(type)){
                const mcType = normalizeMcType(type);
                const rawChoices = Array.isArray(q.choices) ? q.choices : (Array.isArray(q.options) ? q.options : []);
                const choices = [0,1,2,3].map(function(i){ return String(rawChoices[i] ?? ''); });
                const correctIndexes = normalizeCorrectAnswerIndexes(Object.assign({}, q, { choices }));
                const maxPoints = Number(q.max_points ?? 1);
                return buildMultipleChoicePayload(mcType, text, choices, correctIndexes, (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1);
            }
            if(type === 'identification'){
                const maxPoints = Number(q.max_points ?? 1);
                return { type:'identification', text, answer: String(q.answer ?? q.correct_answer ?? ''), max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
            }
            if(type === 'true_false'){
                let answer = null;
                if(q.answer === true || q.answer === false) answer = q.answer;
                else if(String(q.answer).toLowerCase() === 'true') answer = true;
                else if(String(q.answer).toLowerCase() === 'false') answer = false;
                else if(String(q.correct_answer).toLowerCase() === 'true') answer = true;
                else if(String(q.correct_answer).toLowerCase() === 'false') answer = false;
                const maxPoints = Number(q.max_points ?? 1);
                return { type:'true_false', text, answer, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
            }
            if(type === 'essay'){
                const maxPoints = Number(q.max_points ?? 1);
                return { type:'essay', text, max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
            }
            if(type === 'enumeration'){
                const answers = Array.isArray(q.answers) ? q.answers : (Array.isArray(q.correct_answers) ? q.correct_answers : []);
                const maxPoints = Number(q.max_points ?? 1);
                return { type:'enumeration', text, answers: answers.map(function(answer){ return String(answer ?? ''); }), max_points: (!isNaN(maxPoints) && maxPoints > 0) ? maxPoints : 1 };
            }
            return { type, text, answer: String(q.answer ?? '') };
        }
        function normalizeExamPrefill(prefill){
            if(!prefill || typeof prefill !== 'object') return null;
            const rawQuestions = Array.isArray(prefill.questions) ? prefill.questions : [];
            const timerMinutes = parseInt(prefill.timer_minutes || prefill.duration || 0, 10) || 0;
            return {
                title: String(prefill.title ?? ''),
                description: String(prefill.description ?? ''),
                timer_minutes: timerMinutes,
                timer_mode: prefill.timer_mode || (timerMinutes > 0 ? 'timed' : 'untimed'),
                passing_score: parseInt(prefill.passing_score || 75, 10) || 75,
                questions: rawQuestions.map(normalizeExamQuestionShape).filter(Boolean)
            };
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
                            <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Timer Mode</label>
                            <select class="exam-timer-mode" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;background:#fff;outline:none;cursor:pointer;">
                                <option value="timed">Timed</option>
                                <option value="untimed">No Timer</option>
                            </select>
                            <div class="exam-untimed-helper" style="display:none;font-size:0.7rem;color:#64748b;margin-top:4px;">This exam has no time limit.</div>
                        </div>
                        <div class="exam-duration-wrapper">
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
                                        <option value="multiple_choice_single">Multiple Choice (Single Answer)</option>
                                        <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
                                        <option value="identification">Identification</option>
                                        <option value="true_false">True or False</option>
                                        <option value="essay">Essay</option>
                                        <option value="enumeration">Enumeration</option>
                                    </select>
                                </div>
                            </div>

                            <div class="eq-choices" style="display:grid;gap:12px;margin-bottom:20px;"></div>

                            <div class="eq-id" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Answer</label>
                                <input class="eq-id-answer" type="text" placeholder="Enter answer" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;margin-bottom:8px;">
                                <div style="color:#64748b;font-size:.82rem;font-weight:700;margin:0 0 12px 0;">Note: Answer will be saved in UPPERCASE as the standard answer.</div>
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Description (Optional)</label>
                                <textarea class="eq-id-desc" placeholder="Optional description / notes for this question" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;resize:vertical;" rows="2"></textarea>
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
                                <input class="eq-common-points" type="number" min="1" step="0.01" required placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="eq-essay" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Instructions / Rubric (Optional)</label>
                                <textarea class="eq-essay-notes" placeholder="Optional instructions or rubric for students" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;resize:vertical;margin-bottom:12px;" rows="2"></textarea>
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Points</label>
                                <input class="eq-essay-points" type="number" min="1" step="0.01" required placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                            </div>

                            <div class="eq-enum" style="display:none;margin-bottom:20px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Required Number of Answers</label>
                                <input class="eq-enum-required-count" type="number" min="1" step="1" placeholder="Example: 3" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;margin-bottom:12px;">
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Answers</label>
                                <div class="eq-enum-answers" style="display:grid;gap:8px;margin-bottom:8px;"></div>
                                <button type="button" class="btn btn-small eq-enum-add" style="background:#eef2ff;color:#0f3b8f;border:1px solid #c7d2fe;border-radius:10px;padding:10px 14px;font-weight:800;cursor:pointer;margin-bottom:10px;">Add Answer</button>
                                <div style="color:#64748b;font-size:.82rem;font-weight:700;margin:0 0 12px 0;">Note: Answers will be saved in UPPERCASE as the standard answer.</div>
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Description (Optional)</label>
                                <textarea class="eq-enum-desc" placeholder="Optional description / notes for this question" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;resize:vertical;margin-bottom:12px;" rows="2"></textarea>
                                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Points</label>
                                <input class="eq-enum-points" type="number" min="1" step="0.01" required placeholder="Enter point value" style="width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
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
            // Drag and drop for exam wrapper
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
                const currentType = normalizeMcType(wrap.querySelector('.eq-type')?.value);
                const inputType = currentType === 'multiple_choice_multiple' ? 'checkbox' : 'radio';
                const helperText = currentType === 'multiple_choice_multiple' ? 'Select all that apply' : 'Select one correct answer';
                const currentChoices = Array.from(wrapChoices.querySelectorAll('.eq-option')).map(input => input.value);
                const currentCorrect = Array.from(wrapChoices.querySelectorAll('.eq-correct:checked')).map(input => Number(input.value));
                wrapChoices.innerHTML = '';
                const group = 'course_exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
                function choiceLabel(i){
                    return 'Choice ' + (i < 26 ? String.fromCharCode(65 + i) : String(i + 1));
                }
                function reindexChoiceRows(){
                    const rows = Array.from(wrapChoices.querySelectorAll('.q-option-row'));
                    rows.forEach((r, idx)=>{
                        const opt = r.querySelector('.eq-option');
                        if(opt) opt.placeholder = choiceLabel(idx);
                        const correct = r.querySelector('.eq-correct');
                        if(correct) correct.value = String(idx);
                    });
                    const canRemove = rows.length > 2;
                    rows.forEach((r)=>{
                        const btn = r.querySelector('.eq-choice-remove-inline');
                        if(!btn) return;
                        btn.disabled = !canRemove;
                        btn.style.opacity = canRemove ? '1' : '.45';
                        btn.style.cursor = canRemove ? 'pointer' : 'default';
                    });
                }
                const helper = document.createElement('div');
                helper.className = 'mc-helper-text';
                helper.style.cssText = 'display:inline-flex;align-items:center;gap:8px;margin-bottom:10px;color:#475569;font-size:.88rem;font-weight:700;';
                helper.innerHTML = '<span style="background:#e0f2fe;color:#0369a1;border-radius:999px;padding:4px 10px;">'+helperText+'</span>';
                wrapChoices.appendChild(helper);
                const count = Math.max(4, currentChoices.length);
                for(let i = 0; i < count; i++){
                    const ph = choiceLabel(i);
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex; align-items:center; gap:12px; background:#fff; padding:8px 16px; border:1.5px solid #e2e8f0; border-radius:12px; transition:all .2s;';
                    row.innerHTML = `
                        <label style="display:flex;align-items:center;gap:12px;flex:1;cursor:pointer;margin:0;">
                            <input type="${inputType}" class="eq-correct" name="${inputType === 'radio' ? group : group+'[]'}" value="${i}" style="width:18px;height:18px;accent-color:#10b981;cursor:pointer;">
                            <input type="text" class="eq-option" placeholder="${ph}" style="flex:1;border:none;outline:none;font-size:0.95rem;font-weight:600;background:transparent;padding:4px 0;">
                        </label>
                        <button type="button" class="eq-choice-remove-inline" style="background:#e5e7eb;color:#111827;border:1px solid #e2e8f0;border-radius:10px;padding:8px 12px;font-weight:800;">Remove</button>
                    `;
                    const optionInput = row.querySelector('.eq-option');
                    const correctInput = row.querySelector('.eq-correct');
                    if(optionInput) optionInput.value = currentChoices[i] || '';
                    if(correctInput) correctInput.checked = currentCorrect.includes(i);
                    // Add focus effect to row
                    const input = row.querySelector('.eq-option');
                    input.addEventListener('focus', () => row.style.borderColor = '#002C76');
                    input.addEventListener('blur', () => row.style.borderColor = '#e2e8f0');
                    row.addEventListener('change', () => {
                        row.style.borderColor = correctInput.checked ? '#10b981' : '#e2e8f0';
                        row.style.background = correctInput.checked ? '#ecfdf5' : '#fff';
                    });
                    const removeBtn = row.querySelector('.eq-choice-remove-inline');
                    if(removeBtn){
                        removeBtn.addEventListener('click', (e)=>{
                            e.preventDefault();
                            e.stopPropagation();
                            if(removeBtn.disabled) return;
                            row.remove();
                            reindexChoiceRows();
                            syncExamJSON();
                        });
                    }
                    wrapChoices.appendChild(row);
                }
                const add = document.createElement('button');
                add.type = 'button';
                add.className = 'eq-choice-add-inline';
                add.textContent = 'Add option';
                add.style.cssText = 'margin-top:10px;background:transparent;border:none;color:#2563eb;font-weight:800;cursor:pointer;padding:0;align-self:flex-start;';
                add.addEventListener('click', (e)=>{
                    e.preventDefault();
                    e.stopPropagation();
                    const i = wrapChoices.querySelectorAll('.q-option-row').length;
                    const ph = choiceLabel(i);
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex; align-items:center; gap:12px; background:#fff; padding:8px 16px; border:1.5px solid #e2e8f0; border-radius:12px; transition:all .2s;';
                    row.innerHTML = `
                        <label style="display:flex;align-items:center;gap:12px;flex:1;cursor:pointer;margin:0;">
                            <input type="${inputType}" class="eq-correct" name="${inputType === 'radio' ? group : group+'[]'}" value="${i}" style="width:18px;height:18px;accent-color:#10b981;cursor:pointer;">
                            <input type="text" class="eq-option" placeholder="${ph}" style="flex:1;border:none;outline:none;font-size:0.95rem;font-weight:600;background:transparent;padding:4px 0;">
                        </label>
                        <button type="button" class="eq-choice-remove-inline" style="background:#e5e7eb;color:#111827;border:1px solid #e2e8f0;border-radius:10px;padding:8px 12px;font-weight:800;">Remove</button>
                    `;
                    const input = row.querySelector('.eq-option');
                    const correctInput = row.querySelector('.eq-correct');
                    input.addEventListener('focus', () => row.style.borderColor = '#002C76');
                    input.addEventListener('blur', () => row.style.borderColor = '#e2e8f0');
                    row.addEventListener('change', () => {
                        row.style.borderColor = correctInput.checked ? '#10b981' : '#e2e8f0';
                        row.style.background = correctInput.checked ? '#ecfdf5' : '#fff';
                    });
                    const removeBtn = row.querySelector('.eq-choice-remove-inline');
                    if(removeBtn){
                        removeBtn.addEventListener('click', (e)=>{
                            e.preventDefault();
                            e.stopPropagation();
                            if(removeBtn.disabled) return;
                            row.remove();
                            reindexChoiceRows();
                            syncExamJSON();
                        });
                    }
                    wrapChoices.insertBefore(row, add);
                    reindexChoiceRows();
                    try { input.focus(); } catch (err) {}
                    syncExamJSON();
                });
                wrapChoices.appendChild(add);
                reindexChoiceRows();
            }
            function renderEnumerationAnswers(values){
                const answerWrap = wrap.querySelector('.eq-enum-answers');
                if(!answerWrap) return;
                answerWrap.innerHTML = '';
                const entries = Array.isArray(values) && values.length ? values : ['', ''];
                entries.forEach(value=>{
                    const row = document.createElement('div');
                    row.className = 'q-option-row';
                    row.style.cssText = 'display:flex; align-items:center; gap:10px;';
                    row.innerHTML = `
                        <input type="text" class="eq-enum-answer" placeholder="Correct answer" value="${String(value || '').replace(/"/g,'&quot;')}" style="flex:1;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:0.95rem;font-weight:600;outline:none;">
                        <button type="button" class="eq-enum-remove" style="background:#fff;color:#ef4444;border:1.5px solid #fee2e2;border-radius:10px;padding:10px 14px;cursor:pointer;transition:all .2s;"><i class="fas fa-times"></i></button>
                    `;
                    answerWrap.appendChild(row);
                });
            }
            function syncBuilderBoxes(){
                const t = wrap.querySelector('.eq-type').value;
                wrap.querySelector('.eq-choices').style.display = isMultipleChoiceType(t) ? 'block':'none';
                wrap.querySelector('.eq-id').style.display = (t==='identification') ? 'block':'none';
                wrap.querySelector('.eq-tf').style.display = (t==='true_false') ? 'block':'none';
                wrap.querySelector('.eq-points').style.display = (t==='essay' || t==='enumeration') ? 'none':'block';
                wrap.querySelector('.eq-essay').style.display = (t==='essay') ? 'block':'none';
                wrap.querySelector('.eq-enum').style.display = (t==='enumeration') ? 'block':'none';
                if(isMultipleChoiceType(t)){ renderChoices(); }
                if(t==='enumeration' && wrap.querySelectorAll('.eq-enum-answer').length===0){ renderEnumerationAnswers(); }
            }
            wrap.addEventListener('click', function(e){
                const addBtn = e.target.closest('.eq-enum-add');
                if(addBtn){
                    e.preventDefault();
                    e.stopPropagation();
                    const current = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> i.value);
                    current.push('');
                    renderEnumerationAnswers(current);
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
                    renderEnumerationAnswers(next.length ? next : ['', '']);
                    const ev = new Event('input', { bubbles:true });
                    wrap.dispatchEvent(ev);
                }
            });
            wrap.querySelector('.exam-timer-mode').addEventListener('change', (e)=>{
                const mode = e.target.value;
                const wrapper = wrap.querySelector('.exam-duration-wrapper');
                const helper = wrap.querySelector('.exam-untimed-helper');
                const input = wrap.querySelector('.exam-duration');
                if(mode === 'untimed'){
                    wrapper.style.display = 'none';
                    helper.style.display = 'block';
                    input.required = false;
                } else {
                    wrapper.style.display = 'block';
                    helper.style.display = 'none';
                    input.required = true;
                }
                syncExamJSON();
            });
            function syncExamJSON(){
                const timerMode = wrap.querySelector('.exam-timer-mode').value;
                const duration = timerMode === 'timed' ? (parseInt(wrap.querySelector('.exam-duration')?.value || '0', 10) || 0) : 0;
                const title = (wrap.querySelector('.exam-title')?.value || '').trim();
                const description = (wrap.querySelector('.exam-desc')?.value || '').trim();
                const passingScore = parseInt(wrap.querySelector('.exam-passing-score')?.value || '75', 10) || 75;
                const list = wrap.querySelectorAll('.exam-q-list .q-item');
                const qs = [];
                list.forEach(node=>{
                    try{ const obj = JSON.parse(node.dataset.payload||'{}'); if(obj && obj.type && obj.text){ qs.push(obj); } }catch(e){}
                });
                wrap.querySelector('.exam-json').value = JSON.stringify({ title, description, timer_minutes: duration, timer_mode: timerMode, passing_score: passingScore, questions: qs });
            }
            function resetTypeSpecificFields(){
                // Clear type-specific inputs so they never carry over from other questions
                const t = wrap.querySelector('.eq-type').value;
                // Always clear choices and correct flags
                const choiceWrap = wrap.querySelector('.eq-choices');
                if(choiceWrap){
                    choiceWrap.querySelectorAll('.eq-option').forEach(i=> i.value='');
                    choiceWrap.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
                }
                // Clear identification and true/false answers
                const idAns = wrap.querySelector('.eq-id-answer'); if(idAns) idAns.value = '';
                const tfSel = wrap.querySelector('.eq-tf-answer'); if(tfSel) tfSel.value = '';
                const commonPoints = wrap.querySelector('.eq-common-points'); if(commonPoints) commonPoints.value = '';
                const essayPoints = wrap.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value = '';
                renderEnumerationAnswers();
                const enumPoints = wrap.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value = '';
                // Update payload for active item to a blank object of the selected type
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                const idx = getActiveExamIndex(wrap);
                if(idx < items.length){
                    const text = (wrap.querySelector('.eq-text').value||'').trim();
                    let obj = null;
                if(isMultipleChoiceType(t)){
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = buildMultipleChoicePayload(t, text, ['', '', '', ''], [], maxPoints);
                    }else if(t==='identification'){
                        const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'identification', text, answer: '', max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='true_false'){
                        const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'true_false', text, answer: null, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='essay'){
                        const maxPointsVal = wrap.querySelector('.eq-essay-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'essay', text, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    }else if(t==='enumeration'){
                        const maxPointsVal = wrap.querySelector('.eq-enum-points')?.value;
                        const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                        obj = { type:'enumeration', text, answers:['', ''], max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                    } else {
                        obj = { type:String(t||'multiple_choice_single'), text };
                    }
                    const node = items[idx];
                    node.dataset.payload = JSON.stringify(obj);
                    updateExamInputGroup(idx, obj);
                }
            }
            wrap.querySelector('.eq-type').addEventListener('change', ()=>{
                resetTypeSpecificFields();
                syncBuilderBoxes();
                recalcExamJSON(wrap);
            });
            wrap.addEventListener('input', syncExamJSON);
            wrap.addEventListener('change', syncExamJSON);
            // Allow clicking a question in the list to edit it
            const listClick = wrap.querySelector('.exam-q-list');
            if(listClick && !listClick.__bound){
                listClick.__bound = true;
                listClick.addEventListener('click', (e)=>{
                    const item = e.target.closest('.q-item');
                    if(!item) return;
                    const items = Array.from(listClick.children);
                    const idxClick = items.indexOf(item);
                    if(idxClick>=0) setActiveExamIndex(wrap, idxClick);
                });
            }
            function ensureExamInputsBox(){
                let box = wrap.querySelector('.exam-form-inputs');
                if(!box){
                    box = document.createElement('div');
                    box.className = 'exam-form-inputs';
                    box.style.display = 'none';
                    const host = wrap.querySelector('.exam-questions');
                    if(host) host.appendChild(box);
                }
                return box;
            }
            function buildInputGroup(idx, type){
                const div = document.createElement('div');
                div.className = 'exam-input-group';
                div.dataset.index = String(idx);
                const t = String(type||'multiple_choice_single');
                let html = '';
                html += '<input type="hidden" name="questions['+idx+'][type]" value="'+t+'">';
                html += '<input type="text" name="questions['+idx+'][question]" value="">';
                if(isMultipleChoiceType(t)){
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="text" name="questions['+idx+'][options][]" value="">';
                    html += '<input type="hidden" name="questions['+idx+'][correct_answers][]" value="">';
                }
                if(t==='identification'){
                    html += '<input type="text" name="questions['+idx+'][answer]" value="">';
                }
                if(t==='true_false'){
                    html += '<input type="text" name="questions['+idx+'][answer]" value="">';
                }
                div.innerHTML = html;
                return div;
            }
            function reindexExamInputGroups(){
                const box = ensureExamInputsBox();
                const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                groups.forEach((g,i)=>{
                    g.dataset.index = String(i);
                    Array.from(g.querySelectorAll('input[name]')).forEach(inp=>{
                        inp.name = inp.name.replace(/questions\[\d+\]/, 'questions['+i+']');
                    });
                });
            }
            function addExamInputGroupFor(type){
                const box = ensureExamInputsBox();
                const idx = box.querySelectorAll('.exam-input-group').length;
                const group = buildInputGroup(idx, type);
                box.appendChild(group);
                return group;
            }
            function updateExamInputGroup(idx, obj){
                const box = ensureExamInputsBox();
                const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                const g = groups[idx];
                if(!g) return;
                const t = String(obj.type||'multiple_choice_single');
                const tInput = g.querySelector('input[name="questions['+idx+'][type]"]');
                if(tInput) tInput.value = t;
                const qInput = g.querySelector('input[name="questions['+idx+'][question]"]');
                if(qInput) qInput.value = String(obj.text||'');
                if(isMultipleChoiceType(t)){
                    const opts = g.querySelectorAll('input[name="questions['+idx+'][options][]"]');
                    const arr = Array.isArray(obj.choices)?obj.choices:['','','',''];
                    opts.forEach((o, i)=>{ o.value = arr[i]||''; });
                    const ca = g.querySelector('input[name="questions['+idx+'][correct_answers][]"]');
                    if(ca) ca.value = Array.isArray(obj.correct_answers) ? obj.correct_answers.join(',') : '';
                } else if(t==='identification'){
                    const ans = g.querySelector('input[name="questions['+idx+'][answer]"]');
                    if(ans) ans.value = String(obj.answer||'');
                } else if(t==='true_false'){
                    const ans = g.querySelector('input[name="questions['+idx+'][answer]"]');
                    if(ans) ans.value = (obj.answer==null ? '' : (obj.answer===true?'true':'false'));
                }
            }
            function captureBuilderToActive(){
                const idx = getActiveExamIndex(wrap);
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                if(idx >= items.length) return;
                const t = wrap.querySelector('.eq-type').value;
                const text = (wrap.querySelector('.eq-text').value||'').trim();
                let obj = null;
                if(isMultipleChoiceType(t)){
                    const opts = Array.from(wrap.querySelectorAll('.eq-option')).map(i=>i.value.trim());
                    const checked = Array.from(wrap.querySelectorAll('.eq-correct:checked')).map(input => parseInt(input.value, 10)).filter(Number.isInteger);
                    const maxPointsVal = getBuilderPointsValue(wrap, t);
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = buildMultipleChoicePayload(t, text, opts, checked, maxPoints);
                }else if(t==='identification'){
                    const ans = String(wrap.querySelector('.eq-id-answer')?.value || '').trim().toUpperCase();
                    const desc = String(wrap.querySelector('.eq-id-desc')?.value || '').trim();
                    const maxPointsVal = getBuilderPointsValue(wrap, t);
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'identification', text, answer: ans, description: desc, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='true_false'){
                    const val = wrap.querySelector('.eq-tf-answer').value;
                    const ans = val === '' ? null : (val === 'true');
                    const maxPointsVal = getBuilderPointsValue(wrap, t);
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'true_false', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='essay'){
                    const notes = (wrap.querySelector('.eq-essay-notes').value||'').trim();
                    const maxPointsVal = getBuilderPointsValue(wrap, t);
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'essay', text, instructions: notes, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='enumeration'){
                    const requiredAnswers = Number(wrap.querySelector('.eq-enum-required-count')?.value || 0);
                    const answers = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i => String(i.value || '').trim().toUpperCase()).filter(v => v !== '');
                    const desc = String(wrap.querySelector('.eq-enum-desc')?.value || '').trim();
                    const maxPointsVal = getBuilderPointsValue(wrap, t);
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'enumeration', text, answers: answers.length ? answers : ['',''], required_answers_count: Number.isInteger(requiredAnswers) && requiredAnswers > 0 ? requiredAnswers : '', description: desc, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                } else {
                    obj = { type:String(t||'multiple_choice_single'), text };
                }
                const node = items[idx];
                node.dataset.payload = JSON.stringify(obj);
                const title = node.querySelector('.qi-title'); if(title){ title.textContent = (idx+1)+'. '+(obj.text||''); }
                updateExamInputGroup(idx, obj);
                recalcExamJSON(wrap);
            }
            wrap.querySelector('.eq-add').addEventListener('click', function(){
                if(!validateBuilderQuestion(wrap)) return;
                captureBuilderToActive();
                const t = wrap.querySelector('.eq-type').value;
                // Create a brand new blank question object (independent)
                let obj = null;
                if(isMultipleChoiceType(t)){
                    obj = buildMultipleChoicePayload(t, '', ['', '', '', ''], [], '');
                }else if(t==='identification'){
                    obj = { type:'identification', text:'', answer: '', description: '', max_points: '' };
                }else if(t==='true_false'){
                    obj = { type:'true_false', text:'', answer: null, max_points: '' };
                }else if(t==='essay'){
                    obj = { type:'essay', text:'', instructions: '', max_points: '' };
                }else if(t==='enumeration'){
                    obj = { type:'enumeration', text:'', answers:['', ''], required_answers_count: '', description: '', max_points: '' };
                } else {
                    obj = { type:String(t||'multiple_choice_single'), text:'', max_points: '' };
                }
                const listEl = wrap.querySelector('.exam-q-list');
                const idx2 = listEl.children.length + 1;
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">'+idx2+'. '+obj.text+'</div>'
                    + '<div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                addExamInputGroupFor(obj.type);
                const newIndex = Math.max(0, listEl.children.length - 1);
                updateExamNavigator.call(wrap);
                setActiveExamIndex(wrap, newIndex);
                clearBuilder(wrap);
                const freshNode = listEl.children[newIndex];
                if (freshNode) {
                    freshNode.dataset.payload = JSON.stringify(obj);
                }
                updateExamInputGroup(newIndex, obj);
                recalcExamJSON(wrap);
            });
            function ensureInitialQuestion(){
                const listEl = wrap.querySelector('.exam-q-list');
                if(listEl.children.length>0) return;
                const tSel = wrap.querySelector('.eq-type');
                const tVal = tSel ? tSel.value : 'multiple_choice_single';
                let obj = null;
                if(isMultipleChoiceType(tVal)){ obj = buildMultipleChoicePayload(tVal, '', ['', '', '', ''], [], ''); }
                else if(tVal==='identification'){ obj = { type:'identification', text:'', answer: '', description: '', max_points: '' }; }
                else if(tVal==='true_false'){ obj = { type:'true_false', text:'', answer: null, max_points: '' }; }
                else if(tVal==='essay'){ obj = { type:'essay', text:'', max_points: '' }; }
                else if(tVal==='enumeration'){ obj = { type:'enumeration', text:'', answers:['', ''], required_answers_count: '', description: '', max_points: '' }; }
                else { obj = { type:String(tVal||'multiple_choice_single'), text:'', max_points: '' }; }
                const node = document.createElement('div');
                node.className = 'q-item';
                node.innerHTML = '<div class="qi-title" style="font-weight:700">1. </div><div class="muted" style="margin-top:6px">'+obj.type.replace('_',' ').toUpperCase()+'</div>';
                node.dataset.payload = JSON.stringify(obj);
                listEl.appendChild(node);
                addExamInputGroupFor(obj.type);
                updateExamInputGroup(0, obj);
                updateExamNavigator.call(wrap);
                setActiveExamIndex(wrap, 0, { focusBuilder: false });
            }
            renderChoices(); syncBuilderBoxes(); syncExamJSON(); updateExamNavigator.call(wrap);
            if(prefill){
                try{
                    const normalizedPrefill = normalizeExamPrefill(prefill);
                    const timerMode = normalizedPrefill?.timer_mode || (normalizedPrefill?.timer_minutes > 0 ? 'timed' : 'untimed');
                    const modeEl = wrap.querySelector('.exam-timer-mode');
                    if(modeEl) modeEl.value = timerMode;
                    const wrapper = wrap.querySelector('.exam-duration-wrapper');
                    const helper = wrap.querySelector('.exam-untimed-helper');
                    const input = wrap.querySelector('.exam-duration');
                    if(timerMode === 'untimed'){
                        if(wrapper) wrapper.style.display = 'none';
                        if(helper) helper.style.display = 'block';
                        if(input) { input.required = false; input.value = ''; }
                    } else {
                        if(wrapper) wrapper.style.display = 'block';
                        if(helper) helper.style.display = 'none';
                        if(input) { input.required = true; input.value = normalizedPrefill?.timer_minutes || ''; }
                    }
                    const pass = wrap.querySelector('.exam-passing-score'); if(pass) pass.value = normalizedPrefill?.passing_score || '';
                    if(normalizedPrefill?.title) wrap.querySelector('.exam-title').value = normalizedPrefill.title;
                    if(normalizedPrefill?.description) wrap.querySelector('.exam-desc').value = normalizedPrefill.description;
                    const listEl = wrap.querySelector('.exam-q-list');
                    listEl.innerHTML = '';
                    const box = ensureExamInputsBox();
                    box.innerHTML = '';
                    (normalizedPrefill?.questions || []).forEach((q, i2)=>{
                        const node = document.createElement('div');
                        node.className = 'q-item';
                        node.innerHTML = '<div class="qi-title" style="font-weight:700">'+(i2+1)+'. '+(q.text||'')+'</div>'
                            + '<div class="muted" style="margin-top:6px">'+String(q.type||'').replace('_',' ').toUpperCase()+'</div>';
                        node.dataset.payload = JSON.stringify(q);
                        listEl.appendChild(node);
                        addExamInputGroupFor(q.type||'multiple_choice_single');
                        updateExamInputGroup(i2, q);
                    });
                    syncExamJSON();
                    updateExamNavigator.call(wrap);
                    if(normalizedPrefill?.questions && normalizedPrefill.questions.length > 0){
                        setActiveExamIndex(wrap, 0, { focusBuilder: false });
                    } else {
                        ensureInitialQuestion();
                    }
                }catch(e){}
            } else {
                ensureInitialQuestion();
                const examTitleInput = wrap.querySelector('.exam-title');
                if(examTitleInput){ setTimeout(()=> examTitleInput.focus(), 20); }
            }
            reindexModules();
            return wrap;
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
        function removeExamItem(btn){
            const wrap = btn.closest('.exam-wrapper');
            const listEl = wrap.querySelector('.exam-q-list');
            const item = btn.closest('.q-item');
            const idx = Array.from(listEl.children).indexOf(item);
            item.remove();
            const box = wrap.querySelector('.exam-form-inputs');
            if(box){
                const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                if(groups[idx]) groups[idx].remove();
                const left = Array.from(box.querySelectorAll('.exam-input-group'));
                left.forEach((g,i)=>{
                    g.dataset.index = String(i);
                    Array.from(g.querySelectorAll('input[name]')).forEach(inp=>{
                        inp.name = inp.name.replace(/questions\[\d+\]/, 'questions['+i+']');
                    });
                });
            }
            Array.from(listEl.children).forEach((n,i)=>{
                const t = n.querySelector('.qi-title');
                if(t){ const payload = JSON.parse(n.dataset.payload||'{}'); t.textContent = (i+1)+'. '+(payload.text||''); }
            });
            const nav = wrap.querySelector('.exam-nav');
            if(nav) updateExamNavigator.call(wrap);
            syncExamJSON.call(wrap);
            setActiveExamIndex(wrap, Math.max(0, idx-1));
        }
        function deleteActiveExamQuestion(btn){
            const wrap = btn.closest('.exam-wrapper');
            const listEl = wrap.querySelector('.exam-q-list');
            const active = getActiveExamIndex(wrap);
            const items = Array.from(listEl.children);
            if(items.length===0) return;
            const target = items[Math.min(active, items.length-1)];
            target.remove();
            const box = wrap.querySelector('.exam-form-inputs');
            if(box){
                const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                if(groups[Math.min(active, items.length-1)]) groups[Math.min(active, items.length-1)].remove();
                const left = Array.from(box.querySelectorAll('.exam-input-group'));
                left.forEach((g,i)=>{
                    g.dataset.index = String(i);
                    Array.from(g.querySelectorAll('input[name]')).forEach(inp=>{
                        inp.name = inp.name.replace(/questions\[\d+\]/, 'questions['+i+']');
                    });
                });
            }
            Array.from(listEl.children).forEach((n,i)=>{
                const t = n.querySelector('.qi-title');
                if(t){ const payload = JSON.parse(n.dataset.payload||'{}'); t.textContent = (i+1)+'. '+(payload.text||''); }
            });
            updateExamNavigator.call(wrap);
            recalcExamJSON(wrap);
            setActiveExamIndex(wrap, Math.max(0, active-1));
        }
            function updateExamNavigator(){
            const wrap = this.classList?.contains('exam-wrapper') ? this : null; 
            if(!wrap) return;
            const nav = wrap.querySelector('.exam-nav');
            if(!nav) { return; }
            const track = nav.querySelector('.nav-track');
            if(!track){ return; }
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
            if(!track){
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                return Math.max(0, items.length - 1);
            }
            const blocks = Array.from(track.querySelectorAll('.nav-question'));
            const idx = blocks.findIndex(b=> b.classList.contains('active'));
            return idx>=0 ? idx : 0;
        }
        function setActiveExamIndex(wrap, i, options){
            options = options || {};
            const shouldFocusBuilder = options.focusBuilder !== false;
            if(!wrap) return;
            const nav = wrap.querySelector('.exam-nav');
            const track = nav ? nav.querySelector('.nav-track') : null;
            const blocks = track ? Array.from(track.querySelectorAll('.nav-question')) : [];
            const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
            if(items.length===0) return;
            const clamped = Math.max(0, Math.min(items.length-1, i));
            function ensureBuilderEnabled(w){
                try{
                    w.querySelectorAll('textarea, input[type="text"], select').forEach(el=>{
                        el.removeAttribute('disabled');
                        el.removeAttribute('readonly');
                        el.style.pointerEvents = 'auto';
                    });
                }catch(_){}
            }
            if(nav && track){
                blocks.forEach((b,bi)=>{
                    window.CAPDEVQuestionBuilderShared.applyQuestionButtonState(b, bi===clamped);
                });
            }
            const delBtn = wrap.querySelector('.eq-del');
            if(delBtn){
                const viewingExisting = clamped < items.length;
                delBtn.disabled = !viewingExisting;
                delBtn.style.opacity = viewingExisting ? '1' : '.45';
                delBtn.style.cursor = viewingExisting ? 'pointer' : 'default';
            }
            populateBuilderFromItem(wrap, clamped);
            // Focus builder textarea for immediate typing
            const txt = wrap.querySelector('.eq-text');
            ensureBuilderEnabled(wrap);
            if(shouldFocusBuilder && txt){ setTimeout(()=> txt.focus(), 0); }
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
            const type = String(payload.type||'multiple_choice_single');
            const displayType = isMultipleChoiceType(type) ? normalizeMcType(type) : type;
            wrap.querySelector('.eq-text').value = text;
            const typeSel = wrap.querySelector('.eq-type');
            if(typeSel){ typeSel.value = displayType; }
            showBuilderBoxes(wrap);
            if(isMultipleChoiceType(type)){
                const normalizedType = normalizeMcType(type);
                if(typeSel){ typeSel.value = normalizedType; }
                ensureChoiceRows(wrap);
                const choices = Array.isArray(payload.choices) ? payload.choices
                                 : Array.isArray(payload.options) ? payload.options
                                 : [];
                while(wrap.querySelectorAll('.eq-choices .q-option-row').length < choices.length){
                    wrap.querySelector('.eq-choice-add')?.click();
                }
                const rows = Array.from(wrap.querySelectorAll('.eq-choices .q-option-row'));
                rows.forEach((row,i)=>{
                    const inp = row.querySelector('.eq-option');
                    if(inp) inp.value = choices[i] || '';
                });
                const correctIndexes = normalizeCorrectAnswerIndexes(Object.assign({}, payload, { choices }));
                const inputs = Array.from(wrap.querySelectorAll('.eq-correct'));
                inputs.forEach(input => { input.checked = correctIndexes.includes(Number(input.value)); });
                const commonPoints = wrap.querySelector('.eq-common-points');
                if(commonPoints){
                    const maxPoints = payload.max_points;
                    commonPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='identification'){
                const ans = String(payload.answer || payload.correct_answer || payload.teacher_notes || '').toUpperCase();
                const ansEl = wrap.querySelector('.eq-id-answer'); if(ansEl) ansEl.value = ans;
                const desc = String(payload.description || '');
                const descEl = wrap.querySelector('.eq-id-desc'); if(descEl) descEl.value = desc;
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
                const notes = String(payload.instructions || payload.rubric || '');
                const notesEl = wrap.querySelector('.eq-essay-notes');
                if(notesEl) notesEl.value = notes;
                const essayPoints = wrap.querySelector('.eq-essay-points');
                if(essayPoints){
                    const maxPoints = payload.max_points;
                    essayPoints.value = (maxPoints === '' || maxPoints == null) ? '' : String(maxPoints);
                }
            }else if(type==='enumeration'){
                let answers = Array.isArray(payload.answers) ? payload.answers : [];
                if(!answers.length){
                    const rawGuide = String(payload.expected_guide || payload.guide || '');
                    if(rawGuide){
                        answers = rawGuide.split(',').map(s=> s.trim()).filter(Boolean);
                    }
                }
                if(!answers.length) answers = ['', ''];
                ensureEnumerationRows(wrap, answers.map(a=> String(a || '').toUpperCase()));
                const requiredCount = wrap.querySelector('.eq-enum-required-count');
                if(requiredCount){
                    requiredCount.value = String(payload.required_answers_count || (Array.isArray(payload.answers) ? payload.answers.length : '') || '');
                }
                const desc = String(payload.description || '');
                const descEl = wrap.querySelector('.eq-enum-desc'); if(descEl) descEl.value = desc;
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
            if(boxChoices) boxChoices.style.display = isMultipleChoiceType(t) ? 'block' : 'none';
            if(boxId) boxId.style.display = (t==='identification') ? 'block' : 'none';
            if(boxTf) boxTf.style.display = (t==='true_false') ? 'block' : 'none';
            if(boxPoints) boxPoints.style.display = 'block';
            if(boxEssay) boxEssay.style.display = (t==='essay') ? 'block' : 'none';
            if(boxEnum) boxEnum.style.display = (t==='enumeration') ? 'block' : 'none';
            if(isMultipleChoiceType(t)){
                ensureChoiceRows(wrap);
            } else if (t === 'enumeration') {
                if (wrap.querySelectorAll('.eq-enum-answer').length === 0) {
                    ensureEnumerationRows(wrap, ['', '']);
                }
            }
        }
        function ensureChoiceRows(wrap){
            const wrapChoices = wrap.querySelector('.eq-choices');
            if(!wrapChoices) return;
            const mcType = normalizeMcType(wrap.querySelector('.eq-type')?.value);
            const inputType = mcType === 'multiple_choice_multiple' ? 'checkbox' : 'radio';
            const existing = Array.from(wrapChoices.querySelectorAll('.q-option-row'));
            const existingType = wrapChoices.querySelector('.eq-correct')?.type;
            if(existing.length>0 && existingType === inputType) return;
            const currentChoices = Array.from(wrapChoices.querySelectorAll('.eq-option')).map(input => input.value);
            const currentCorrect = Array.from(wrapChoices.querySelectorAll('.eq-correct:checked')).map(input => Number(input.value));
            wrapChoices.innerHTML = '';
            const group = 'exam_correct_' + Date.now() + '_' + Math.floor(Math.random()*1000);
            const helper = document.createElement('div');
            helper.style.cssText = 'margin:0 0 8px;color:#475569;font-size:.88rem;font-weight:700;';
            helper.innerHTML = '<span style="background:#e0f2fe;color:#0369a1;border-radius:999px;padding:4px 10px;">'+(inputType === 'checkbox' ? 'Select all that apply' : 'Select one correct answer')+'</span>';
            wrapChoices.appendChild(helper);
            const values = currentChoices.length ? currentChoices : ['', '', '', ''];
            values.forEach((value,i)=>{
                const ph = 'Choice ' + String.fromCharCode(65 + i);
                const row = document.createElement('div');
                row.className = 'q-option-row';
                row.style.cssText = 'display:flex;align-items:center;gap:8px;margin-bottom:8px;';
                row.innerHTML = `
                    <label style="display:flex;align-items:center;gap:8px;flex:1;">
                        <input type="${inputType}" class="eq-correct" name="${inputType === 'radio' ? group : group+'[]'}" value="${i}">
                        <input type="text" class="eq-option" placeholder="${ph}">
                    </label>
                    <button type="button" class="btn btn-small eq-choice-remove" style="background:#e5e7eb;color:#111827;border-radius:8px;padding:8px 12px" ${i < 2 ? 'disabled' : ''}>Remove</button>
                `;
                const optionInput = row.querySelector('.eq-option');
                const correctInput = row.querySelector('.eq-correct');
                if(optionInput) optionInput.value = value || '';
                if(correctInput) correctInput.checked = currentCorrect.includes(i);
                wrapChoices.appendChild(row);
            });
            const add = document.createElement('button');
            add.type = 'button';
            add.className = 'btn btn-small eq-choice-add';
            add.style.cssText = 'margin-top:4px;background:#eef2ff;color:#0f3b8f;border:1px solid #c7d2fe;border-radius:8px;padding:8px 12px';
            add.textContent = 'Add Choice';
            wrapChoices.appendChild(add);
        }
        function ensureEnumerationRows(wrap, values){
            const answerWrap = wrap.querySelector('.eq-enum-answers');
            if(!answerWrap) return;
            answerWrap.innerHTML = '';
            const entries = Array.isArray(values) && values.length ? values : ['', ''];
            entries.forEach(value=>{
                const row = document.createElement('div');
                row.className = 'q-option-row';
                row.innerHTML = `
                    <input type="text" class="eq-enum-answer" placeholder="Correct answer" value="${String(value || '').replace(/"/g,'&quot;')}" style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                    <button type="button" class="btn btn-small eq-enum-remove" style="background:#e5e7eb;color:#111827;border-radius:8px;padding:8px 12px">Remove</button>
                `;
                answerWrap.appendChild(row);
            });
        }
        document.addEventListener('click', function(e){
            const wrap = e.target.closest('.exam-wrapper');
            if(!wrap) return;
            const choiceAdd = e.target.closest('.eq-choice-add');
            if(choiceAdd){
                e.preventDefault();
                const box = wrap.querySelector('.eq-choices');
                const rows = Array.from(box.querySelectorAll('.q-option-row'));
                const i = rows.length;
                const firstCorrect = box.querySelector('.eq-correct');
                const inputType = firstCorrect?.type || 'checkbox';
                const name = firstCorrect?.name || ('exam_correct_' + Date.now());
                const row = document.createElement('div');
                row.className = 'q-option-row';
                row.style.cssText = 'display:flex;align-items:center;gap:8px;margin-bottom:8px;';
                row.innerHTML = `
                    <label style="display:flex;align-items:center;gap:8px;flex:1;">
                        <input type="${inputType}" class="eq-correct" name="${name}" value="${i}">
                        <input type="text" class="eq-option" placeholder="Choice ${String.fromCharCode(65 + i)}">
                    </label>
                    <button type="button" class="btn btn-small eq-choice-remove" style="background:#e5e7eb;color:#111827;border-radius:8px;padding:8px 12px">Remove</button>
                `;
                box.insertBefore(row, choiceAdd);
                wrap.dispatchEvent(new Event('input', { bubbles:true }));
                return;
            }
            const choiceRemove = e.target.closest('.eq-choice-remove');
            if(choiceRemove && !choiceRemove.disabled){
                e.preventDefault();
                const row = choiceRemove.closest('.q-option-row');
                if(row){ row.remove(); }
                Array.from(wrap.querySelectorAll('.eq-correct')).forEach((input, i)=>{ input.value = String(i); });
                wrap.dispatchEvent(new Event('input', { bubbles:true }));
                return;
            }
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
        function clearBuilder(wrap){
            wrap.querySelector('.eq-text').value='';
            const rows = Array.from(wrap.querySelectorAll('.eq-choices .q-option-row'));
            rows.forEach(row=>{ const inp=row.querySelector('.eq-option'); if(inp) inp.value=''; });
            wrap.querySelectorAll('.eq-correct').forEach(r=> r.checked=false);
            wrap.querySelector('.eq-id-answer').value='';
            const idDesc = wrap.querySelector('.eq-id-desc'); if(idDesc) idDesc.value = '';
            wrap.querySelector('.eq-tf-answer').value='true';
            const commonPoints = wrap.querySelector('.eq-common-points'); if(commonPoints) commonPoints.value='';
            const essayPoints = wrap.querySelector('.eq-essay-points'); if(essayPoints) essayPoints.value='';
            const essayNotes = wrap.querySelector('.eq-essay-notes'); if(essayNotes) essayNotes.value='';
            const enumRequired = wrap.querySelector('.eq-enum-required-count'); if(enumRequired) enumRequired.value='';
            const enumDesc = wrap.querySelector('.eq-enum-desc'); if(enumDesc) enumDesc.value='';
            ensureEnumerationRows(wrap, ['', '']);
            const enumPoints = wrap.querySelector('.eq-enum-points'); if(enumPoints) enumPoints.value='';
            const builder = wrap.querySelector('.eq-text'); if(builder) builder.focus();
        }
        function getBuilderPointsValue(wrap, type){
            const common = wrap.querySelector('.eq-common-points')?.value || '';
            if(common !== '') return common;
            if(type === 'essay') return wrap.querySelector('.eq-essay-points')?.value || '';
            if(type === 'enumeration') return wrap.querySelector('.eq-enum-points')?.value || '';
            return common;
        }
        function validateBuilderQuestion(wrap){
            const type = wrap.querySelector('.eq-type')?.value || '';
            const pointsValue = getBuilderPointsValue(wrap, type);
            const points = Number(pointsValue);
            if(pointsValue === ''){
                alert('Points is required.');
                (wrap.querySelector('.eq-common-points') || wrap.querySelector('.eq-essay-points') || wrap.querySelector('.eq-enum-points'))?.focus();
                return false;
            }
            if(!Number.isFinite(points) || points < 1){
                alert('Points must be at least 1.');
                (wrap.querySelector('.eq-common-points') || wrap.querySelector('.eq-essay-points') || wrap.querySelector('.eq-enum-points'))?.focus();
                return false;
            }
            if(type === 'identification'){
                const ans = String(wrap.querySelector('.eq-id-answer')?.value || '').trim();
                if(!ans){
                    alert('Answer is required.');
                    wrap.querySelector('.eq-id-answer')?.focus();
                    return false;
                }
            }
            if(type === 'enumeration'){
                const requiredValue = wrap.querySelector('.eq-enum-required-count')?.value || '';
                const required = Number(requiredValue);
                if(requiredValue === '' || !Number.isInteger(required) || required < 1){
                    alert('Required number of answers must be at least 1.');
                    wrap.querySelector('.eq-enum-required-count')?.focus();
                    return false;
                }
                const answers = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> String(i.value || '').trim()).filter(Boolean);
                if(answers.length === 0){
                    alert('At least 1 answer is required.');
                    wrap.querySelector('.eq-enum-answer')?.focus();
                    return false;
                }
                if(required > answers.length){
                    alert('Required number of answers cannot be greater than the number of answers provided.');
                    wrap.querySelector('.eq-enum-required-count')?.focus();
                    return false;
                }
            }
            return true;
        }
        (function bindBuilderLiveUpdate(){
            document.addEventListener('input', function(e){
                const wrap = e.target.closest('.exam-wrapper'); if(!wrap) return;
                if(e.target && (e.target.classList?.contains('eq-id-answer') || e.target.classList?.contains('eq-enum-answer'))){
                    const el = e.target;
                    const start = typeof el.selectionStart === 'number' ? el.selectionStart : null;
                    const end = typeof el.selectionEnd === 'number' ? el.selectionEnd : null;
                    const up = String(el.value || '').toUpperCase();
                    if(el.value !== up) el.value = up;
                    if(start != null && end != null){
                        try{ el.setSelectionRange(start, end); }catch(_) {}
                    }
                }
                const idx = getActiveExamIndex(wrap);
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                if(idx >= items.length) return;
                const t = wrap.querySelector('.eq-type').value;
                const text = (wrap.querySelector('.eq-text').value||'').trim();
                let obj = null;
                if(isMultipleChoiceType(t)){
                    const opts = Array.from(wrap.querySelectorAll('.eq-option')).map(i=>i.value.trim());
                    const checked = Array.from(wrap.querySelectorAll('.eq-correct:checked')).map(input => parseInt(input.value, 10)).filter(Number.isInteger);
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = buildMultipleChoicePayload(t, text, opts, checked, maxPoints);
                }else if(t==='identification'){
                    const ans = String(wrap.querySelector('.eq-id-answer')?.value || '').trim().toUpperCase();
                    const desc = String(wrap.querySelector('.eq-id-desc')?.value || '').trim();
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'identification', text, answer: ans, description: desc, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='true_false'){
                    const val = wrap.querySelector('.eq-tf-answer').value;
                    const ans = val === '' ? null : (val === 'true');
                    const maxPointsVal = wrap.querySelector('.eq-common-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'true_false', text, answer: ans, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='essay'){
                    const notes = (wrap.querySelector('.eq-essay-notes').value||'').trim();
                    const maxPointsVal = wrap.querySelector('.eq-essay-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'essay', text, instructions: notes, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }else if(t==='enumeration'){
                    const requiredAnswers = Number(wrap.querySelector('.eq-enum-required-count')?.value || 0);
                    const answers = Array.from(wrap.querySelectorAll('.eq-enum-answer')).map(i=> String(i.value || '').trim().toUpperCase()).filter(v=> v !== '');
                    const desc = String(wrap.querySelector('.eq-enum-desc')?.value || '').trim();
                    const maxPointsVal = wrap.querySelector('.eq-enum-points')?.value;
                    const maxPoints = maxPointsVal === '' ? '' : Number(maxPointsVal);
                    obj = { type:'enumeration', text, answers: answers.length ? answers : ['',''], required_answers_count: Number.isInteger(requiredAnswers) && requiredAnswers > 0 ? requiredAnswers : '', description: desc, max_points: (maxPoints === '' || isNaN(maxPoints)) ? '' : maxPoints };
                }
                const node = items[idx];
                node.dataset.payload = JSON.stringify(obj);
                const title = node.querySelector('.qi-title');
                if(title){ title.textContent = (idx+1)+'. '+(obj.text||''); }
                recalcExamJSON(wrap);
                const box = wrap.querySelector('.exam-form-inputs');
                if(box){ 
                    (function(){
                        const groups = Array.from(box.querySelectorAll('.exam-input-group'));
                        if(groups[idx]){
                            const iGroup = groups[idx];
                            const base = 'questions['+idx+']';
                            const q = iGroup.querySelector('input[name="'+base+'[question]"]');
                            if(q) q.value = obj.text||'';
                            const tI = iGroup.querySelector('input[name="'+base+'[type]"]');
                            if(tI) tI.value = obj.type||'multiple_choice_single';
                            if(isMultipleChoiceType(obj.type)){
                                const opts = iGroup.querySelectorAll('input[name="'+base+'[options][]"]');
                                const arr = Array.isArray(obj.choices)?obj.choices:['','','',''];
                                opts.forEach((o,i)=>{ o.value = arr[i]||''; });
                                const ca = iGroup.querySelector('input[name="'+base+'[correct_answers][]"]') || iGroup.querySelector('input[name="'+base+'[correct_answer]"]');
                                if(ca) ca.value = Array.isArray(obj.correct_answers) ? obj.correct_answers.join(',') : '';
                            }else{
                                const opts = iGroup.querySelectorAll('input[name="'+base+'[options][]"]');
                                opts.forEach(o=>{ o.value=''; });
                                const ca = iGroup.querySelector('input[name="'+base+'[correct_answer]"]');
                                if(ca) ca.value='';
                                const ans = iGroup.querySelector('input[name="'+base+'[answer]"]');
                                if(ans){ 
                                    if(obj.type==='identification'){ ans.value = obj.answer||''; }
                                    else if(obj.type==='true_false'){ ans.value = obj.answer==null?'':(obj.answer===true?'true':'false'); }
                                    else { ans.value=''; }
                                }
                            }
                        }
                    })();
                }
            }, { passive:true });
            document.addEventListener('change', function(e){
                const wrap = e.target.closest('.exam-wrapper'); if(!wrap) return;
                const idx = getActiveExamIndex(wrap);
                const items = Array.from(wrap.querySelectorAll('.exam-q-list .q-item'));
                if(idx >= items.length) return;
                // reuse input handler to update payload on select/radio change
                const ev = new Event('input', { bubbles:true });
                wrap.dispatchEvent(ev);
            }, { passive:true });
        })();
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
        function dmAddQuiz(){
            const anchor = DM_STATE.currentAnchor;
            const wrapper = anchor?.closest('.module-wrapper');
            const moduleBody = wrapper ? wrapper.querySelector('.module-body') : document.querySelector('.module-wrapper .module-body');
            if(moduleBody){
                expandModuleAccordion(moduleBody);
                addQuizInput(moduleBody);
                const lastQuiz = moduleBody.querySelector('.topic-row.quiz-row:last-of-type');
                if(lastQuiz) setActiveAnchor(lastQuiz);
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
 
