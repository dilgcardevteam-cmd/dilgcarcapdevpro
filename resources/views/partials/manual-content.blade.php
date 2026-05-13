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
                        <div class="manual-sub-item">
                            <div class="manual-sub-info">
                                <h4>Adding New Users</h4>
                                <p>Learn how to create user profiles and assign appropriate system roles.</p>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="manual-role-badge">{{ $roleLabel }}</span>
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
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
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
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
                                <button class="btn-view-manual"><i class="fas fa-eye"></i> View</button>
                            </div>
                        </div>
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

