@php
    $role = Auth::user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin', 'central_office_admin', 'regional_office_admin', 'provincial_office_admin']);
    $isTM = in_array($role, ['cotm', 'registrar', 'training_manager', 'central_office_training_manager', 'regional_office_training_manager', 'provincial_office_training_manager']);
    $isCoach = in_array($role, ['trainer', 'coach', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach']);
    $isParticipant = in_array($role, ['trainee', 'participant', 'roparticipant', 'central_office_participants', 'regional_office_participants', 'provincial_office_participants']);
    
    // Helper to get role label
    $roleLabel = 'User';
    if ($isAdmin) $roleLabel = 'Administrator';
    elseif ($isTM) $roleLabel = 'Training Manager';
    elseif ($isCoach) $roleLabel = 'Coach';
    elseif ($isParticipant) $roleLabel = 'Participant';
@endphp

<style>
    .manual-wrapper {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 25px;
        font-family: 'DM Sans', sans-serif;
    }

    .manual-main-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .manual-title-area h1 {
        font-size: 28px;
        color: #0f172a;
        margin: 0 0 8px 0;
    }

    .manual-title-area p {
        color: #64748b;
        margin: 0;
    }

    .manual-search {
        position: relative;
        width: calc(100% - 40px);
        margin: 0 20px 20px 20px;
    }

    .manual-search input {
        width: 100%;
        padding: 10px 1px 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #fff;
    }

    .manual-search i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    /* Tabs styling */
    .manual-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .manual-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
    }

    .manual-tab.active {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #2563eb;
    }

    /* Accordion styling */
    .manual-accordion-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .manual-accordion-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .manual-accordion-header {
        display: flex;
        align-items: center;
        padding: 20px;
        cursor: pointer;
        user-select: none;
    }

    .manual-accordion-icon {
        width: 40px;
        height: 40px;
        background: #eff6ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        margin-right: 15px;
    }

    .manual-accordion-title-box {
        flex: 1;
    }

    .manual-accordion-title {
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        font-size: 16px;
    }

    .manual-accordion-desc {
        font-size: 13px;
        color: #64748b;
        margin: 4px 0 0 0;
    }

    .manual-accordion-chevron {
        color: #94a3b8;
        transition: transform 0.3s ease;
    }

    .manual-accordion-item.open .manual-accordion-chevron {
        transform: rotate(180deg);
    }

    .manual-accordion-content {
        display: none;
        padding: 0 20px 20px 75px;
        border-top: 1px solid #f1f5f9;
    }

    .manual-accordion-item.open .manual-accordion-content {
        display: block;
    }

    .manual-sub-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .manual-sub-item:last-child {
        border-bottom: none;
    }

    .manual-sub-info h4 {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .manual-sub-info p {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    .manual-role-badge {
        font-size: 11px;
        padding: 2px 8px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 4px;
        margin-right: 15px;
    }

    .btn-view-manual {
        font-size: 12px;
        padding: 6px 12px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #334155;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view-manual:hover {
        background: #f8fafc;
    }

    /* Manual Viewer Styles */
    .manual-viewer-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin: 10px 0 20px 0;
        padding: 20px;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .viewer-content {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .viewer-image-container {
        width: 100%;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        border: 1px solid #f1f5f9;
        cursor: grab;
    }

    .viewer-image-container:active {
        cursor: grabbing;
    }

    .viewer-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.1s linear; /* Faster transition for scroll zoom */
        user-select: none;
        -webkit-user-drag: none;
    }

    .viewer-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid #e2e8f0;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .viewer-nav-btn:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }

    .viewer-nav-btn:disabled {
        opacity: 0;
        pointer-events: none;
    }

    .viewer-nav-btn.prev { left: 15px; }
    .viewer-nav-btn.next { right: 15px; }

    .viewer-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px 0;
    }

    .viewer-nav-group {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .viewer-action-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .viewer-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .viewer-btn:hover {
        background: #eff6ff;
        color: #3b82f6;
        border-color: #3b82f6;
    }

    .viewer-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8fafc;
    }

    .viewer-counter {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        min-width: 60px;
        text-align: center;
    }

    /* Fullscreen Styles (Modal-like) */
    .viewer-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: #0f172a !important; /* Solid dark blue/black */
        z-index: 999999 !important;
        padding: 0 !important; /* Remove padding to maximize space */
        display: flex !important;
        flex-direction: column !important;
        border: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
    }

    .viewer-fullscreen .viewer-content {
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .viewer-fullscreen .viewer-image-container {
        flex: 1;
        height: 100%;
        width: 100%;
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px; /* Space for nav arrows and close button */
    }

    .viewer-fullscreen .viewer-controls {
        position: absolute;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(30, 41, 59, 0.8);
        padding: 12px 24px;
        border-radius: 40px;
        width: auto;
        min-width: 250px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        z-index: 1000001;
    }

    .viewer-fullscreen .viewer-counter {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .viewer-fullscreen .viewer-btn {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        width: 42px;
        height: 42px;
        font-size: 16px;
    }

    .viewer-fullscreen .viewer-btn:hover {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .viewer-fullscreen .viewer-nav-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.4);
        width: 50px;
        height: 50px;
        font-size: 20px;
        backdrop-filter: blur(4px);
        position: fixed; /* Fix position relative to viewport */
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }

    .viewer-fullscreen .viewer-nav-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .viewer-fullscreen .viewer-nav-btn.prev {
        left: 20px;
    }

    .viewer-fullscreen .viewer-nav-btn.next {
        right: 20px;
    }

    .close-fullscreen {
        position: absolute;
        top: 25px;
        right: 25px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 1000002;
        transition: all 0.2s ease;
        font-size: 20px;
        backdrop-filter: blur(4px);
    }

    .viewer-fullscreen .close-fullscreen {
        display: flex;
    }

    .close-fullscreen:hover {
        background: #ef4444;
        border-color: #ef4444;
    }

    /* Sidebar cards */
    .manual-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
    }

    .sidebar-card-icon {
        width: 36px;
        height: 36px;
        background: #eff6ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        margin-bottom: 15px;
    }

    .sidebar-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 10px 0;
    }

    .sidebar-card p {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    .role-guide-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 15px;
    }

    .role-guide-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-guide-icon {
        font-size: 14px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .role-guide-info h4 {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin: 0;
    }

    .role-guide-info p {
        font-size: 11px;
        color: #94a3b8;
    }

    .doc-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 15px;
    }

    .doc-action-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        color: #475569;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .doc-action-btn:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .doc-action-btn i {
        color: #3b82f6;
    }

    /* Layout controls */
    .manual-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .btn-manual-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #334155;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-manual-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
</style>

<div class="manual-container">
    <div class="manual-top-bar">
        <button onclick="showContent('dashboard-home', document.querySelector('[onclick*=\'dashboard-home\']'))" class="btn-manual-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </button>
    </div>

    <div class="manual-wrapper">
        <div class="manual-main">
            <div class="manual-main-header">
                <div class="manual-title-area">
                    <h1>System Manual</h1>
                    <p>Comprehensive guides and documentation for all CAPDEVPRO users.</p>
                </div>
            </div>

            <div class="manual-tabs">
                <div class="manual-tab active"><i class="fas fa-user"></i> {{ $roleLabel }}</div>
            </div>

            <div class="manual-accordion-list">
                <!-- Getting Started (Always Visible) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon"><i class="fas fa-play"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Getting Started</h3>
                            <p class="manual-accordion-desc">Learn the basics of the system and get started quickly.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>System Overview</h4>
                                <p>A comprehensive overview of the CAPDEVPRO platform and its core functionalities.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Logging In</h4>
                                <p>Step-by-step instructions on how to access your account securely.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($isAdmin || $isTM)
                <!-- User Management -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-users-cog"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">User Management</h3>
                            <p class="manual-accordion-desc">Manage system users, define roles, and configure permissions.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div id="viewer-user-adding" class="manual-viewer-box" style="display: none;"></div>

                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Editing Users</h4>
                                <p>Manage existing user information, update roles, and modify account status.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual" data-manual="user-editing"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                        <div id="viewer-user-editing" class="manual-viewer-box" style="display: none;"></div>
                    </div>
                </div>
                @endif

                @if($isTM)
                <!-- Training Management (TM only) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #fdf2f2; color: #ef4444;"><i class="fas fa-tasks"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Training Management</h3>
                            <p class="manual-accordion-desc">Oversee training programs, track participants, and manage schedules.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Program Scheduling</h4>
                                <p>Instructions for setting up and managing training timelines and events.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($isAdmin || $isTM)
                <!-- Course Management -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #fefce8; color: #eab308;"><i class="fas fa-book-open"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Course Management</h3>
                            <p class="manual-accordion-desc">Develop learning paths, organize content, and manage course categories.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Creating a Course</h4>
                                <p>Detailed guide on building and publishing new courses within the system.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual" data-manual="course-management"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                        <div id="viewer-course-management" class="manual-viewer-box" style="display: none;"></div>
                    </div>
                </div>
                @endif

                @if($isAdmin || $isTM || $isCoach)
                <!-- Certifications -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #fff7ed; color: #f97316;"><i class="fas fa-certificate"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Certifications</h3>
                            <p class="manual-accordion-desc">Design templates, manage issuance, and verify learner certificates.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Template Designer</h4>
                                <p>How to utilize the visual builder for creating custom certificate designs.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual" data-manual="certifications"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                        <div id="viewer-certifications" class="manual-viewer-box" style="display: none;"></div>
                    </div>
                </div>
                @endif

                @if($isCoach)
                <!-- My Courses (Coach only) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #f5f3ff; color: #8b5cf6;"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">My Courses</h3>
                            <p class="manual-accordion-desc">Access and manage your assigned training cohorts and sessions.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Course Dashboard</h4>
                                <p>Guide to using the specialized dashboard for course instructors.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Course Utilities (Coach only) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #f0f9ff; color: #0ea5e9;"><i class="fas fa-tools"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Course Utilities</h3>
                            <p class="manual-accordion-desc">Utilize tools for grading, assessment, and learner interaction.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Material Upload</h4>
                                <p>Procedures for uploading and organizing instructional resources.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Announcements (Coach only) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #fdf2f2; color: #ef4444;"><i class="fas fa-bullhorn"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Announcements</h3>
                            <p class="manual-accordion-desc">Communicate important updates and alerts to your trainees.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Creating Announcements</h4>
                                <p>How to draft and broadcast notifications to specific course groups.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($isParticipant)
                <!-- Classroom (Participant only) -->
                <div class="manual-accordion-item">
                    <div class="manual-accordion-header" onclick="toggleManualAccordion(this)">
                        <div class="manual-accordion-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-laptop-code"></i></div>
                        <div class="manual-accordion-title-box">
                            <h3 class="manual-accordion-title">Classroom</h3>
                            <p class="manual-accordion-desc">Engage with course content, complete assignments, and track your learning progress.</p>
                        </div>
                        <i class="fas fa-chevron-down manual-accordion-chevron"></i>
                    </div>
                    <div class="manual-accordion-content">
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Navigating Lessons</h4>
                                <p>Instructions for accessing modules and interacting with classroom resources.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="manual-sidebar">
            <div class="manual-search" style="margin-bottom: 20px;">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search manual...">
            </div>
            
            <div class="sidebar-card">
                <div class="sidebar-card-icon"><i class="fas fa-book-open"></i></div>
                <h3>About This Manual</h3>
                <p>This manual is role-based and provides relevant information for your specific access level in the system.</p>
            </div>

            <div class="sidebar-card">
                <h3>User Roles Guide</h3>
                <div class="role-guide-list">
                    <div class="role-guide-item">
                        <div class="role-guide-icon" style="color: #3b82f6;"><i class="fas fa-shield-alt"></i></div>
                        <div class="role-guide-info">
                            <h4>Administrator</h4>
                            <p>Full system access and configuration</p>
                        </div>
                    </div>
                    <div class="role-guide-item">
                        <div class="role-guide-icon" style="color: #8b5cf6;"><i class="fas fa-briefcase"></i></div>
                        <div class="role-guide-info">
                            <h4>Training Manager</h4>
                            <p>Manage training programs and participants</p>
                        </div>
                    </div>
                    <div class="role-guide-item">
                        <div class="role-guide-icon" style="color: #10b981;"><i class="fas fa-user-tie"></i></div>
                        <div class="role-guide-info">
                            <h4>Coach</h4>
                            <p>Handle training sessions and assessments</p>
                        </div>
                    </div>
                    <div class="role-guide-item">
                        <div class="role-guide-icon" style="color: #f59e0b;"><i class="fas fa-user"></i></div>
                        <div class="role-guide-info">
                            <h4>Participant</h4>
                            <p>Access learning materials and track progress</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <h3>Document Actions</h3>
                <div class="doc-actions">
                    <a href="#" class="doc-action-btn">
                        <i class="fas fa-download"></i>
                        Download Manual (PDF)
                    </a>
                    <a href="#" class="doc-action-btn">
                        <i class="fas fa-print"></i>
                        Print Current Section
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const manualImages = {
        'user-editing': [
            '/Manual/Admin Manual/User Management/8.png',
            '/Manual/Admin Manual/User Management/9.png',
            '/Manual/Admin Manual/User Management/10.png',
            '/Manual/Admin Manual/User Management/11.png',
            '/Manual/Admin Manual/User Management/12.png',
            '/Manual/Admin Manual/User Management/13.png',
            '/Manual/Admin Manual/User Management/14.png',
            '/Manual/Admin Manual/User Management/15.png',
            '/Manual/Admin Manual/User Management/16.png'
        ],
        'user-adding': [], // Placeholder
        'course-management': [
            '/Manual/Admin Manual/Course Management/17.png',
            '/Manual/Admin Manual/Course Management/18.png',
            '/Manual/Admin Manual/Course Management/19.png',
            '/Manual/Admin Manual/Course Management/20.png',
            '/Manual/Admin Manual/Course Management/21.png',
            '/Manual/Admin Manual/Course Management/22.png',
            '/Manual/Admin Manual/Course Management/23.png',
            '/Manual/Admin Manual/Course Management/24.png',
            '/Manual/Admin Manual/Course Management/25.png',
            '/Manual/Admin Manual/Course Management/26.png',
            '/Manual/Admin Manual/Course Management/27.png',
            '/Manual/Admin Manual/Course Management/28.png',
            '/Manual/Admin Manual/Course Management/29.png',
            '/Manual/Admin Manual/Course Management/30.png',
            '/Manual/Admin Manual/Course Management/31.png',
            '/Manual/Admin Manual/Course Management/32.png',
            '/Manual/Admin Manual/Course Management/33.png',
            '/Manual/Admin Manual/Course Management/34.png',
            '/Manual/Admin Manual/Course Management/35.png',
            '/Manual/Admin Manual/Course Management/36.png',
            '/Manual/Admin Manual/Course Management/37.png'
        ],
        'certifications': [
            '/Manual/Admin Manual/Certifications/38.png',
            '/Manual/Admin Manual/Certifications/39.png',
            '/Manual/Admin Manual/Certifications/40.png',
            '/Manual/Admin Manual/Certifications/41.png',
            '/Manual/Admin Manual/Certifications/42.png'
        ]
    };

    const viewers = {};

    class ManualViewer {
        constructor(id, images) {
            this.container = document.getElementById(`viewer-${id}`);
            this.images = images;
            this.currentIndex = 0;
            this.zoomLevel = 1;
            this.isFullscreen = false;
            this.init();
        }

        init() {
            if (this.images.length === 0) {
                this.container.innerHTML = '<p style="text-align:center;color:#64748b;padding:20px;">No images available for this section.</p>';
                return;
            }

            this.render();
            this.attachEvents();
        }

        render() {
            this.container.innerHTML = `
                <div class="viewer-content">
                    <div class="close-fullscreen" title="Close Fullscreen"><i class="fas fa-times"></i></div>
                    <div class="viewer-image-container">
                        <button class="viewer-nav-btn prev" ${this.currentIndex === 0 ? 'disabled' : ''} title="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <img src="${this.images[this.currentIndex]}" alt="Step ${this.currentIndex + 1}" style="transform: translate(0px, 0px) scale(${this.zoomLevel})">
                        <button class="viewer-nav-btn next" ${this.currentIndex === this.images.length - 1 ? 'disabled' : ''} title="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="viewer-controls">
                        <div class="viewer-nav-group">
                            <div class="viewer-counter">${this.currentIndex + 1} / ${this.images.length}</div>
                        </div>
                        <div class="viewer-action-group">
                            <button class="viewer-btn zoom-out-btn" title="Zoom Out"><i class="fas fa-search-minus"></i></button>
                            <button class="viewer-btn zoom-in-btn" title="Zoom In"><i class="fas fa-search-plus"></i></button>
                            <button class="viewer-btn fullscreen-btn" title="Toggle Fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                </div>
            `;
        }

        attachEvents() {
            const prevBtn = this.container.querySelector('.viewer-nav-btn.prev');
            const nextBtn = this.container.querySelector('.viewer-nav-btn.next');
            const zoomInBtn = this.container.querySelector('.zoom-in-btn');
            const zoomOutBtn = this.container.querySelector('.zoom-out-btn');
            const fullscreenBtn = this.container.querySelector('.fullscreen-btn');
            const closeFullscreenBtn = this.container.querySelector('.close-fullscreen');
            const imgContainer = this.container.querySelector('.viewer-image-container');
            const img = this.container.querySelector('img');

            prevBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                this.navigate(-1);
            });
            nextBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                this.navigate(1);
            });
            zoomInBtn?.addEventListener('click', () => this.zoom(0.2));
            zoomOutBtn?.addEventListener('click', () => this.zoom(-0.2));
            fullscreenBtn?.addEventListener('click', () => this.toggleFullscreen());
            closeFullscreenBtn?.addEventListener('click', () => this.toggleFullscreen(false));

            // Panning logic
            let isDragging = false;
            let startX, startY;
            this.translateX = 0;
            this.translateY = 0;

            imgContainer.addEventListener('mousedown', (e) => {
                if (this.zoomLevel <= 1 || e.target.closest('.viewer-nav-btn')) return;
                isDragging = true;
                startX = e.pageX - this.translateX;
                startY = e.pageY - this.translateY;
                imgContainer.style.cursor = 'grabbing';
            });

            window.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                this.translateX = e.pageX - startX;
                this.translateY = e.pageY - startY;
                this.updateImageTransform(this.translateX, this.translateY);
            });

            window.addEventListener('mouseup', () => {
                isDragging = false;
                if (imgContainer) {
                    imgContainer.style.cursor = this.zoomLevel > 1 ? 'grab' : 'default';
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (this.container.style.display === 'none') return;
                
                if (e.key === 'ArrowLeft') this.navigate(-1);
                if (e.key === 'ArrowRight') this.navigate(1);
                if (e.key === 'Escape' && this.isFullscreen) this.toggleFullscreen(false);
            });
        }

        navigate(direction) {
            const newIndex = this.currentIndex + direction;
            if (newIndex >= 0 && newIndex < this.images.length) {
                this.currentIndex = newIndex;
                this.zoomLevel = 1;
                this.resetPanning();
                this.updateViewer();
            }
        }

        zoom(delta) {
            this.zoomLevel = Math.max(0.5, Math.min(5, this.zoomLevel + delta));
            if (this.zoomLevel <= 1) this.resetPanning();
            this.updateViewer();
        }

        resetPanning() {
            this.translateX = 0;
            this.translateY = 0;
        }

        updateImageTransform(tx = 0, ty = 0) {
            const img = this.container.querySelector('img');
            if (img) {
                img.style.transform = `translate(${tx}px, ${ty}px) scale(${this.zoomLevel})`;
            }
        }

        toggleFullscreen(force) {
            this.isFullscreen = force !== undefined ? force : !this.isFullscreen;
            if (this.isFullscreen) {
                this.originalParent = this.container.parentElement;
                this.nextSibling = this.container.nextSibling;
                document.body.appendChild(this.container);
                this.container.classList.add('viewer-fullscreen');
                document.body.style.overflow = 'hidden';
            } else {
                if (this.originalParent) {
                    this.originalParent.insertBefore(this.container, this.nextSibling);
                }
                this.container.classList.remove('viewer-fullscreen');
                document.body.style.overflow = '';
            }
            this.resetPanning();
            this.updateViewer();
        }

        updateViewer() {
            const img = this.container.querySelector('img');
            const counter = this.container.querySelector('.viewer-counter');
            const prevBtn = this.container.querySelector('.viewer-nav-btn.prev');
            const nextBtn = this.container.querySelector('.viewer-nav-btn.next');
            const imgContainer = this.container.querySelector('.viewer-image-container');

            if (img) {
                img.src = this.images[this.currentIndex];
                this.updateImageTransform(this.translateX || 0, this.translateY || 0);
            }
            if (counter) counter.innerText = `${this.currentIndex + 1} / ${this.images.length}`;
            if (prevBtn) prevBtn.disabled = this.currentIndex === 0;
            if (nextBtn) nextBtn.disabled = this.currentIndex === this.images.length - 1;
            if (imgContainer) imgContainer.style.cursor = this.zoomLevel > 1 ? 'grab' : 'default';
        }
    }

    document.querySelectorAll('.btn-view-manual').forEach(btn => {
        btn.addEventListener('click', function() {
            const manualId = this.getAttribute('data-manual');
            if (!manualId) return; // Ignore buttons without data-manual for now

            const viewerContainer = document.getElementById(`viewer-${manualId}`);
            if (!viewerContainer) return;
            
            // Toggle logic
            if (viewerContainer.style.display === 'block') {
                viewerContainer.style.display = 'none';
                this.innerHTML = '<i class="fas fa-eye"></i> View';
            } else {
                // Close all other viewers first
                document.querySelectorAll('.manual-viewer-box').forEach(v => {
                    v.style.display = 'none';
                    const correspondingBtn = document.querySelector(`.btn-view-manual[data-manual="${v.id.replace('viewer-', '')}"]`);
                    if (correspondingBtn) correspondingBtn.innerHTML = '<i class="fas fa-eye"></i> View';
                });

                viewerContainer.style.display = 'block';
                this.innerHTML = '<i class="fas fa-eye-slash"></i> Close';

                if (!viewers[manualId]) {
                    viewers[manualId] = new ManualViewer(manualId, manualImages[manualId] || []);
                }
            }
        });
    });

    function toggleManualAccordion(header) {
        const item = header.parentElement;
        const list = item.parentElement;
        const allItems = list.querySelectorAll('.manual-accordion-item');
        
        // Close other items
        allItems.forEach(otherItem => {
            if (otherItem !== item && otherItem.classList.contains('open')) {
                otherItem.classList.remove('open');
            }
        });

        // Toggle current item
        item.classList.toggle('open');
    }
</script>

