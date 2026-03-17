<section id="help-support" class="content-section {{ (request('tab') == 'help-support' || request('tab') == 'help_support') ? 'active' : '' }}">
    <style>
        .help-dashboard{
            --help-blue:#123f96;
            --help-blue-dark:#0a2b74;
            --help-blue-soft:#eef4ff;
            --help-border:#d6e2ff;
            --help-text:#24344d;
            --help-muted:#5f708c;
            --help-shadow:0 18px 45px rgba(15,23,42,.08);
            display:grid;
            gap:22px;
            position:relative;
            padding-bottom:26px;
        }
        .help-alert{
            padding:14px 18px;
            border-radius:16px;
            font-weight:700;
            box-shadow:0 12px 24px rgba(15,23,42,.06);
        }
        .help-alert.success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
        .help-alert.error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
        .help-alert ul{margin:8px 0 0 18px;padding:0}
        .help-hero{
            background:linear-gradient(135deg,#ffffff 0%,#f6faff 100%);
            border:1px solid var(--help-border);
            border-radius:26px;
            padding:24px 28px 22px;
            box-shadow:var(--help-shadow);
        }
        .help-hero h3{
            margin:0 0 10px;
            color:var(--help-blue-dark);
            font-size:2rem;
            line-height:1.05;
            font-weight:900;
            letter-spacing:-.03em;
        }
        .help-hero p{
            margin:0;
            max-width:980px;
            color:var(--help-text);
            font-size:1.03rem;
            line-height:1.7;
        }
        .help-hero strong{color:var(--help-blue-dark)}
        .help-hero-link{
            display:inline-flex;
            align-items:center;
            gap:8px;
            border:none;
            background:transparent;
            padding:0;
            color:var(--help-blue-dark);
            font:inherit;
            font-weight:900;
            letter-spacing:.01em;
            cursor:pointer;
            text-decoration:none;
        }
        .help-hero-link:hover{text-decoration:underline}
        .help-actions-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
        .help-vm-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}
        .help-vm-card{
            background:#fff;
            border:1px solid #dfe9fb;
            border-radius:30px;
            box-shadow:var(--help-shadow);
            overflow:hidden;
            transition:border-color .28s ease, box-shadow .28s ease;
            align-self:start;
        }
        .help-vm-card.vision{border-color:#ffd8d8}
        .help-vm-card.values{border-color:#ffe1a8;background:linear-gradient(180deg,#fffef8 0%,#fff8db 100%)}
        .help-vm-toggle{
            width:100%;
            border:none;
            background:transparent;
            padding:18px 20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            text-align:left;
            cursor:pointer;
        }
        .help-vm-head{
            display:flex;
            align-items:center;
            gap:14px;
            flex:1;
            min-width:0;
        }
        .help-vm-icon{
            width:56px;
            height:56px;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.45rem;
            flex:0 0 56px;
        }
        .help-vm-icon.vision{background:#fff1f1;color:#e02d2d}
        .help-vm-icon.mission{background:#edf4ff;color:#1a3f8b}
        .help-vm-icon.values{background:#fffdf3;color:#d97706}
        .help-vm-title{
            margin:0;
            font-size:1.05rem;
            line-height:1.15;
            font-weight:900;
            letter-spacing:-.02em;
        }
        .help-vm-title.vision{color:#e02d2d}
        .help-vm-title.mission{color:var(--help-blue-dark)}
        .help-vm-title.values{color:#c96a09}
        .help-vm-chevron{
            width:40px;
            height:40px;
            border-radius:50%;
            border:1px solid #d7e4fb;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:var(--help-blue-dark);
            background:#f8fbff;
            flex:0 0 40px;
            transition:transform .28s ease, background-color .2s ease, color .2s ease;
        }
        .help-vm-body{
            display:grid;
            grid-template-rows:0fr;
            overflow:hidden;
            opacity:0;
            transition:grid-template-rows .38s ease, opacity .28s ease, padding .38s ease;
            padding:0 24px;
        }
        .help-vm-card.open .help-vm-body{
            grid-template-rows:1fr;
            opacity:1;
            padding:0 24px 24px;
        }
        .help-vm-body-inner{
            min-height:0;
        }
        .help-vm-card.open .help-vm-chevron{
            transform:rotate(180deg);
            background:var(--help-blue-dark);
            color:#fff;
        }
        .help-vm-card.values.open .help-vm-chevron{
            background:#c96a09;
            color:#fff;
        }
        .help-vm-copy{
            margin:0;
            color:#334155;
            font-size:1rem;
            line-height:1.7;
            max-width:95%;
        }
        .help-values-chips{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px}
        .help-values-chip{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:110px;
            padding:10px 18px;
            border-radius:999px;
            border:1px solid #f5b73b;
            color:#b95f06;
            background:#fffdf2;
            font-weight:800;
            letter-spacing:.01em;
        }
        .help-action-btn{
            display:flex;align-items:center;justify-content:center;gap:10px;min-height:62px;padding:14px 18px;
            border-radius:18px;border:2px solid var(--help-blue);background:#fff;color:var(--help-blue);font-size:1rem;
            font-weight:900;letter-spacing:.03em;cursor:pointer;text-decoration:none;transition:transform .18s ease, box-shadow .18s ease, background-color .18s ease;
            box-shadow:0 8px 20px rgba(18,63,150,.08)
        }
        .help-action-btn:hover{background:var(--help-blue-soft);transform:translateY(-2px);box-shadow:0 14px 28px rgba(18,63,150,.14)}
        .help-section-heading{margin:6px 0 0;color:var(--help-blue-dark);font-size:1.55rem;font-weight:900;letter-spacing:-.02em}
        .help-support-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;align-items:start}
        .support-card{
            background:#fff;border:1px solid #e4ecfb;border-radius:24px;padding:24px;box-shadow:var(--help-shadow);
            display:flex;flex-direction:column;gap:18px;min-height:260px
        }
        .support-card h4{margin:0;color:var(--help-blue-dark);font-size:1.28rem;font-weight:900}
        .support-card p{margin:0;color:var(--help-muted);line-height:1.65;font-size:.98rem}
        .support-list{display:grid;gap:12px;margin:0;padding:0;list-style:none}
        .support-list li{display:flex;align-items:center;gap:12px;color:var(--help-text);font-weight:700}
        .support-list i{
            width:26px;height:26px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;
            background:linear-gradient(135deg,#25a0ff 0%,#1249d8 100%);box-shadow:0 8px 18px rgba(37,160,255,.22);font-size:.8rem;flex:0 0 26px
        }
        .support-meta{display:grid;gap:10px}
        .support-meta-row{display:flex;align-items:flex-start;gap:12px;color:var(--help-text);line-height:1.6}
        .support-meta-row i{width:20px;color:var(--help-blue);margin-top:4px}
        .support-meta-row strong{display:block;color:var(--help-blue-dark);font-size:.85rem;letter-spacing:.04em}
        .support-card .help-cta{margin-top:auto}
        .help-cta{
            border:none;border-radius:18px;min-height:56px;padding:14px 20px;font-size:1rem;font-weight:900;color:#fff;
            background:linear-gradient(135deg,#39a0ff 0%,#1c63eb 55%,#0f3ba6 100%);box-shadow:0 16px 26px rgba(28,99,235,.25);
            cursor:pointer;transition:transform .18s ease, box-shadow .18s ease
        }
        .help-cta:hover{transform:translateY(-2px);box-shadow:0 22px 34px rgba(28,99,235,.3)}
        .help-faq-list{display:grid;gap:14px}
        .faq-item{background:#fff;border:1px solid #dde8fb;border-radius:20px;box-shadow:0 10px 28px rgba(15,23,42,.06);overflow:hidden}
        .faq-question{
            width:100%;border:none;background:transparent;display:flex;align-items:center;justify-content:space-between;gap:18px;
            padding:20px 22px;text-align:left;cursor:pointer
        }
        .faq-question span{color:var(--help-blue-dark);font-size:1rem;font-weight:800}
        .faq-icon{
            width:38px;height:38px;border-radius:50%;border:1px solid #cfe0ff;display:inline-flex;align-items:center;justify-content:center;
            background:#f8fbff;color:var(--help-blue);font-size:1rem;transition:transform .18s ease, background-color .18s ease, color .18s ease;flex:0 0 38px
        }
        .faq-answer{
            max-height:0;
            overflow:hidden;
            padding:0 22px;
            color:var(--help-muted);
            line-height:1.75;
            font-size:.96rem;
            opacity:0;
            transform:translateY(-6px);
            transition:max-height .35s ease, padding .35s ease, opacity .28s ease, transform .28s ease
        }
        .faq-item.open .faq-answer{
            max-height:220px;
            padding:0 22px 22px;
            opacity:1;
            transform:translateY(0);
        }
        .faq-item.open .faq-icon{background:var(--help-blue);color:#fff;transform:rotate(45deg)}
        .help-fab{
            position:fixed;right:28px;bottom:28px;width:62px;height:62px;border:none;border-radius:50%;
            background:linear-gradient(135deg,#1f8fff 0%,#124bd8 100%);color:#fff;font-size:1.35rem;box-shadow:0 18px 36px rgba(18,75,216,.3);
            cursor:pointer;z-index:1200;transition:transform .18s ease, box-shadow .18s ease
        }
        .help-fab:hover{transform:translateY(-3px);box-shadow:0 24px 42px rgba(18,75,216,.36)}
        .support-modal{display:none;position:fixed;inset:0;z-index:2100}
        .support-modal.is-open{display:block}
        .support-modal-backdrop{position:absolute;inset:0;background:rgba(2,6,23,.58)}
        .support-modal-panel{
            position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
            width:min(640px,92vw);max-height:88vh;overflow:auto;background:#fff;border-radius:24px;
            border:1px solid #dbe4ff;box-shadow:0 28px 60px rgba(2,6,23,.28);padding:24px
        }
        .support-modal-close{
            position:absolute;top:12px;right:14px;border:none;background:transparent;color:var(--help-blue);
            font-size:1.7rem;line-height:1;cursor:pointer
        }
        .support-modal-panel h3{margin:0 0 8px;color:var(--help-blue-dark);font-size:1.6rem;font-weight:900}
        .support-modal-panel p{margin:0 0 18px;color:var(--help-muted);line-height:1.6}
        .support-form{display:grid;gap:14px}
        .support-form label{display:grid;gap:8px;color:var(--help-blue-dark);font-weight:800}
        .support-form input,.support-form textarea{
            width:100%;border:1px solid #cfe0ff;border-radius:16px;padding:14px 16px;background:#f8fbff;
            font:inherit;color:var(--help-text);outline:none
        }
        .support-form input:focus,.support-form textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.14);background:#fff}
        .support-form textarea{min-height:160px;resize:vertical}
        .support-form-actions{display:flex;justify-content:flex-end;gap:12px}
        .support-secondary-btn{
            border:1px solid #cbd5e1;background:#fff;color:#334155;border-radius:14px;padding:12px 18px;font-weight:800;cursor:pointer
        }
        .about-modal{display:none;position:fixed;inset:0;z-index:2000}
        .about-backdrop{position:absolute;inset:0;background:rgba(2,6,23,.58)}
        .about-panel{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:min(760px,92vw);max-height:86vh;overflow:auto;background:#fff;border-radius:24px;border:1px solid #dbe4ff;box-shadow:0 26px 52px rgba(2,6,23,.32);padding:24px 28px 28px}
        .about-close{position:absolute;top:10px;right:14px;border:none;background:transparent;color:var(--help-blue);font-size:1.8rem;line-height:1;cursor:pointer}
        .about-icon{width:62px;height:62px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;background:linear-gradient(135deg,#1f8fff 0%,#123f96 100%);color:#fff;font-size:1.45rem}
        .about-title{margin:0;text-align:center;color:var(--help-blue-dark);font-size:2rem;line-height:1.1;font-weight:900}
        .about-sub{margin:10px auto 0;max-width:620px;text-align:center;color:#334155;font-size:1.15rem;font-style:italic;line-height:1.45}
        .about-sub strong{color:var(--help-blue)}
        .about-copy{margin:16px auto 0;max-width:670px;text-align:center;color:#334155;font-size:1rem;line-height:1.7}
        .about-team{margin-top:18px;text-align:center}
        .about-team h4{margin:0;color:var(--help-blue-dark);font-size:1.35rem;font-weight:900;letter-spacing:.02em}
        .about-team p{margin:8px 0 0;color:#475569;font-size:1rem;line-height:1.6}
        .about-members{margin-top:10px;color:#1d4ed8;font-weight:800;font-size:.98rem;line-height:1.5}
        .about-members div{margin:2px 0}
        .about-date{margin-top:6px;color:#64748b;font-size:.92rem}
        .about-member-link{color:#1d4ed8;text-decoration:none;font-weight:800;letter-spacing:.01em}
        .about-member-link:hover{text-decoration:underline;color:#173fb8}
        @media (max-width: 980px){
            .help-actions-row,.help-support-grid{grid-template-columns:1fr}
            .help-vm-grid{grid-template-columns:1fr}
            .help-hero{padding:24px 22px}
            .help-hero h3{font-size:1.7rem}
            .help-vm-toggle{padding:16px 16px}
            .help-vm-head{gap:12px}
            .help-vm-icon{width:50px;height:50px;flex:0 0 50px;font-size:1.25rem}
            .help-vm-title{font-size:1rem}
            .help-vm-body{padding:0 18px}
            .help-vm-card.open .help-vm-body{padding:0 18px 20px}
            .help-vm-copy{max-width:100%}
            .about-panel{padding:20px 16px}
            .about-title{font-size:1.55rem}
            .about-sub{font-size:1rem}
            .about-copy{font-size:.95rem;text-align:left}
            .about-team h4{font-size:1.15rem}
            .about-team p{font-size:.92rem}
            .about-members{font-size:.9rem}
        }
        @media (max-width: 640px){
            .faq-question{padding:18px}
            .faq-answer{padding:0 18px 18px}
            .help-fab{right:18px;bottom:18px;width:56px;height:56px}
        }
    </style>

    <div class="help-dashboard">
        @if(session('success_help_support'))
            <div class="help-alert success">{{ session('success_help_support') }}</div>
        @endif

        @if(session('error_help_support'))
            <div class="help-alert error">{{ session('error_help_support') }}</div>
        @endif

        @if($errors->supportRequest->any())
            <div class="help-alert error">
                Please review the support form and try again.
                <ul>
                    @foreach($errors->supportRequest->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="help-hero">
            <h3>Help and Support</h3>
            <p>
                Detailed team and system information is hidden for a cleaner page. Click
                <button type="button" id="openAboutSiteInline" class="help-hero-link">ABOUT THIS SITE <i class="fas fa-arrow-up-right-from-square"></i></button>
                to view the full details in a modal.
            </p>
        </div>

        <div class="help-vm-grid">
            <article class="help-vm-card mission">
                <button type="button" class="help-vm-toggle" aria-expanded="false">
                    <span class="help-vm-head">
                        <span class="help-vm-icon mission"><i class="far fa-clipboard"></i></span>
                        <span class="help-vm-title mission">Mission</span>
                    </span>
                    <span class="help-vm-chevron"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="help-vm-body">
                    <div class="help-vm-body-inner">
                        <p class="help-vm-copy">
                            The Department shall ensure peace and order, public safety and security, uphold excellence in local governance and enable resilient and inclusive communities.
                        </p>
                    </div>
                </div>
            </article>

            <article class="help-vm-card vision">
                <button type="button" class="help-vm-toggle" aria-expanded="false">
                    <span class="help-vm-head">
                        <span class="help-vm-icon vision"><i class="far fa-eye"></i></span>
                        <span class="help-vm-title vision">Vision</span>
                    </span>
                    <span class="help-vm-chevron"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="help-vm-body">
                    <div class="help-vm-body-inner">
                        <p class="help-vm-copy">
                            A highly trusted Department and Partner in nurturing local governments and sustaining peaceful, safe, progressive, resilient, and inclusive communities towards a comfortable and secure life for Filipinos by 2040.
                        </p>
                    </div>
                </div>
            </article>

            <article class="help-vm-card values">
                <button type="button" class="help-vm-toggle" aria-expanded="false">
                    <span class="help-vm-head">
                        <span class="help-vm-icon values"><i class="far fa-handshake"></i></span>
                        <span class="help-vm-title values">Shared Values</span>
                    </span>
                    <span class="help-vm-chevron"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="help-vm-body">
                    <div class="help-vm-body-inner">
                        <p class="help-vm-copy">
                            Ang DILG ay Matino, Mahusay at Maaasahan.
                        </p>
                        <div class="help-values-chips">
                            <span class="help-values-chip">Matino</span>
                            <span class="help-values-chip">Mahusay</span>
                            <span class="help-values-chip">Maaasahan</span>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <h2 class="help-section-heading">Need Assistance?</h2>

        <div class="help-support-grid">
            <article class="support-card">
                <div>
                    <h4>Contact Support</h4>
                    <p>Reach out directly during office hours for follow-ups, guidance, and general assistance.</p>
                </div>
                <div class="support-meta">
                    <div class="support-meta-row">
                        <i class="far fa-envelope"></i>
                        <div>
                            <strong>EMAIL</strong>
                            <span>{{ env('SUPPORT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'dilgcarcapdevpro@gmail.com')) }}</span>
                        </div>
                    </div>
                    <div class="support-meta-row">
                        <i class="far fa-clock"></i>
                        <div>
                            <strong>HOURS</strong>
                            <span>Monday - Friday · 7:00 AM - 7:00 PM</span>
                        </div>
                    </div>
                </div>
                <button type="button" id="sendSupportEmail" class="help-cta">Send Email</button>
            </article>
            <article id="faqSection" class="support-card">
                <div>
                    <h4>Frequently Asked Questions</h4>
                    <p>Quick answers to the most common support questions inside the dashboard.</p>
                </div>
                <div class="help-faq-list">
                    <div class="faq-item">
                        <button type="button" class="faq-question" aria-expanded="false">
                            <span>How do I recover my account?</span>
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            Use the account recovery option on the login page or contact {{ env('SUPPORT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'dilgcarcapdevpro@gmail.com')) }} so the team can verify your account and assist with secure access restoration.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button type="button" class="faq-question" aria-expanded="false">
                            <span>How do I submit a report?</span>
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            Open the relevant dashboard module, complete the required report fields, then review and submit. If the report page is unavailable, contact support for guidance.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button type="button" class="faq-question" aria-expanded="false">
                            <span>Who do I contact for system errors?</span>
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            Send the error details, screenshots, and the time the issue happened to {{ env('SUPPORT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'dilgcarcapdevpro@gmail.com')) }}, or use the request form for faster issue tracking.
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <div class="help-actions-row">
            <button type="button" id="openDataPrivacyNotice" class="help-action-btn"><i class="fas fa-shield-halved"></i> DATA PRIVACY NOTICE</button>
            <button type="button" id="openPrivacyPolicy" class="help-action-btn"><i class="fas fa-file-contract"></i> PRIVACY POLICY</button>
            <button type="button" id="openAboutSite" class="help-action-btn"><i class="fas fa-circle-info"></i> ABOUT THIS SITE</button>
        </div>
    </div>

    <button type="button" id="helpFab" class="help-fab" aria-label="Open help shortcuts">
        <i class="fas fa-question"></i>
    </button>

    <div id="supportRequestModal" class="support-modal {{ $errors->supportRequest->any() ? 'is-open' : '' }}" aria-hidden="{{ $errors->supportRequest->any() ? 'false' : 'true' }}">
        <div class="support-modal-backdrop" id="supportRequestBackdrop"></div>
        <div class="support-modal-panel" role="dialog" aria-modal="true" aria-labelledby="supportRequestTitle">
            <button type="button" class="support-modal-close" id="supportRequestClose" aria-label="Close">x</button>
            <h3 id="supportRequestTitle">Submit Support Request</h3>
            <p id="supportRequestDescription">Share the issue or concern and the support team will receive your request.</p>

            <form method="POST" action="{{ route('help.support.request') }}" class="support-form">
                @csrf
                <input type="hidden" name="request_type" id="supportRequestType" value="{{ old('request_type', 'ticket') }}">

                <label>
                    Subject
                    <input
                        type="text"
                        name="subject"
                        id="supportRequestSubject"
                        maxlength="150"
                        value="{{ old('subject') }}"
                        placeholder="Enter a short summary"
                        required
                    >
                </label>

                <label>
                    Message
                    <textarea
                        name="message"
                        id="supportRequestMessage"
                        maxlength="5000"
                        placeholder="Describe your issue or concern in detail"
                        required
                    >{{ old('message') }}</textarea>
                </label>

                <div class="support-form-actions">
                    <button type="button" class="support-secondary-btn" id="supportRequestCancel">Cancel</button>
                    <button type="submit" class="help-cta" id="supportRequestSubmit">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <div id="dataPrivacyModal" class="about-modal" aria-hidden="true">
        <div class="about-backdrop" id="dataPrivacyBackdrop"></div>
        <div class="about-panel" role="dialog" aria-modal="true" aria-labelledby="dataPrivacyTitle">
            <button type="button" class="about-close" id="dataPrivacyClose" aria-label="Close">x</button>
            <div class="about-icon"><i class="far fa-info-circle"></i></div>
            <h2 id="dataPrivacyTitle" class="about-title" style="color:#dc2626">DATA PRIVACY NOTICE</h2>
            <p class="about-copy">
                CAPDEV PRO collects and processes personal data that users provide during account registration and system use, such as name, email, office assignment, role, PSGC location details, and course participation records.
                This information is used only for legitimate platform functions including account management, training delivery, certification tracking, analytics, system security, and official reporting.
            </p>
            <p class="about-copy" style="margin-top:10px">
                Data is stored in secured systems with controlled access and audit monitoring, and is retained only for the period required by operational needs and applicable government records rules.
                You may request access, correction, or lawful deletion of your personal data by contacting the CAPDEV PRO administrator or the designated DILG-CAR Data Protection Officer.
            </p>
        </div>
    </div>

    <div id="aboutSiteModal" class="about-modal" aria-hidden="true">
        <div class="about-backdrop" id="aboutSiteBackdrop"></div>
        <div class="about-panel" role="dialog" aria-modal="true" aria-labelledby="aboutSiteTitle">
            <button type="button" class="about-close" id="aboutSiteClose" aria-label="Close">x</button>
            <div class="about-icon"><i class="far fa-info-circle"></i></div>
            <h2 id="aboutSiteTitle" class="about-title">ABOUT THIS SITE</h2>
            <p class="about-sub">Isa ka bang <strong>MATINO, MAHUSAY</strong>, at <strong>MAAASAHAN</strong> na manggagawang Pilipino?</p>
            <p class="about-copy">CAPDEV PRO streamlines capability development and training management for DILG-CAR users through a seamless platform for enrollment, course progress monitoring, certifications, analytics, and support services.</p>

            <div class="about-team">
                <h4>DEVELOPMENT TEAM</h4>
                <p>Universidad de Dagupan<br>Arellano St., Pantal, Dagupan City, 2400<br>Pangasinan, Philippines<br>BS Information Technology<br>On-the-Job Training (OJT) Trainees</p>
                <div class="about-date">(February 2026 - May 2026)</div>
                <div class="about-members">
                    <div><a class="about-member-link" href="https://web-portfolio-project-delta.vercel.app/about.html" target="_blank" rel="noopener noreferrer">MARK EZEKIEL ZARENO</a></div>
                    <div><a class="about-member-link" href="#" target="_blank" rel="noopener noreferrer">JOSIAH CARRERA</a></div>
                    <div><a class="about-member-link" href="https://rahmyls-fproject.vercel.app/#projects" target="_blank" rel="noopener noreferrer">RAHM SORIANO</a></div>
                    <div><a class="about-member-link" href="https://aquinokevs.github.io/my-portfolio/" target="_blank" rel="noopener noreferrer">KEVIN AQUINO</a></div>
                    <div><a class="about-member-link" href="https://myfinalprojectelective3.vercel.app/?brid=aBn8sPL39MT8662jS-3s3Q#projects" target="_blank" rel="noopener noreferrer">KATHLEEN CHARM DAROY</a></div>
                    <div><a class="about-member-link" href="https://project01-myportfolio.vercel.app/#" target="_blank" rel="noopener noreferrer">PATRICK MEDRANO</a></div>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyPolicyModal" class="about-modal" aria-hidden="true">
        <div class="about-backdrop" id="privacyPolicyBackdrop"></div>
        <div class="about-panel" role="dialog" aria-modal="true" aria-labelledby="privacyPolicyTitle">
            <button type="button" class="about-close" id="privacyPolicyClose" aria-label="Close">x</button>
            <div class="about-icon"><i class="far fa-lock"></i></div>
            <h2 id="privacyPolicyTitle" class="about-title" style="color:#dc2626">PRIVACY POLICY</h2>
            <p class="about-copy">
                CAPDEV PRO protects personal data in accordance with the Data Privacy Act of 2012 and applicable government data management standards.
                Personal information collected through the platform is processed only for legitimate purposes such as user authentication, training administration, certification records, platform analytics, and service improvement.
            </p>
            <p class="about-copy" style="margin-top:10px">
                Access to personal data is limited to authorized personnel on a need-to-know basis, with technical and organizational safeguards in place to prevent unauthorized use, disclosure, or alteration.
                Users may request access, correction, or valid deletion of their records through the CAPDEV PRO administrator or designated DILG-CAR Data Protection Officer.
            </p>
        </div>
    </div>

    <script>
        (function(){
            var dataPrivacyModal=document.getElementById('dataPrivacyModal');
            var openDataPrivacyBtn=document.getElementById('openDataPrivacyNotice');
            var closeDataPrivacyBtn=document.getElementById('dataPrivacyClose');
            var dataPrivacyBackdrop=document.getElementById('dataPrivacyBackdrop');
            var privacyPolicyModal=document.getElementById('privacyPolicyModal');
            var openPrivacyPolicyBtn=document.getElementById('openPrivacyPolicy');
            var closePrivacyPolicyBtn=document.getElementById('privacyPolicyClose');
            var privacyPolicyBackdrop=document.getElementById('privacyPolicyBackdrop');
            var modal=document.getElementById('aboutSiteModal');
            var openBtn=document.getElementById('openAboutSite');
            var openInlineBtn=document.getElementById('openAboutSiteInline');
            var closeBtn=document.getElementById('aboutSiteClose');
            var backdrop=document.getElementById('aboutSiteBackdrop');
            var ticketBtn=document.getElementById('createSupportTicket');
            var emailBtn=document.getElementById('sendSupportEmail');
            var helpFab=document.getElementById('helpFab');
            var faqItems=document.querySelectorAll('#help-support .faq-item');
            var vmCards=document.querySelectorAll('#help-support .help-vm-card');
            var supportRequestModal=document.getElementById('supportRequestModal');
            var supportRequestBackdrop=document.getElementById('supportRequestBackdrop');
            var supportRequestClose=document.getElementById('supportRequestClose');
            var supportRequestCancel=document.getElementById('supportRequestCancel');
            var supportRequestType=document.getElementById('supportRequestType');
            var supportRequestTitle=document.getElementById('supportRequestTitle');
            var supportRequestDescription=document.getElementById('supportRequestDescription');
            var supportRequestSubject=document.getElementById('supportRequestSubject');
            var supportRequestMessage=document.getElementById('supportRequestMessage');
            var supportRequestSubmit=document.getElementById('supportRequestSubmit');

            function openSupportRequestModal(type){
                if(!supportRequestModal) return;
                var isContact = type === 'contact';
                if(supportRequestType) supportRequestType.value = isContact ? 'contact' : 'ticket';
                if(supportRequestTitle) supportRequestTitle.textContent = isContact ? 'Contact Support' : 'Create Support Ticket';
                if(supportRequestDescription) supportRequestDescription.textContent = isContact
                    ? 'Send a direct support message and the team will follow up with you.'
                    : 'Submit a support ticket for technical issues, account problems, or system concerns.';
                if(supportRequestSubject && !supportRequestSubject.value){
                    supportRequestSubject.value = isContact ? 'Support inquiry' : 'Technical support ticket';
                }
                if(supportRequestMessage) supportRequestMessage.placeholder = isContact
                    ? 'Tell us what you need help with and include any relevant details.'
                    : 'Describe the issue, what happened, and any steps to reproduce it.';
                if(supportRequestSubmit) supportRequestSubmit.textContent = isContact ? 'Send Message' : 'Submit Ticket';
                supportRequestModal.classList.add('is-open');
                supportRequestModal.setAttribute('aria-hidden','false');
                setTimeout(function(){ if(supportRequestSubject) supportRequestSubject.focus(); }, 20);
            }

            function closeSupportRequestModal(){
                if(!supportRequestModal) return;
                supportRequestModal.classList.remove('is-open');
                supportRequestModal.setAttribute('aria-hidden','true');
            }

            function openDataPrivacyModal(){
                if(!dataPrivacyModal) return;
                dataPrivacyModal.style.display='block';
                dataPrivacyModal.setAttribute('aria-hidden','false');
            }

            function closeDataPrivacyModal(){
                if(!dataPrivacyModal) return;
                dataPrivacyModal.style.display='none';
                dataPrivacyModal.setAttribute('aria-hidden','true');
            }

            function openPrivacyPolicyModal(){
                if(!privacyPolicyModal) return;
                privacyPolicyModal.style.display='block';
                privacyPolicyModal.setAttribute('aria-hidden','false');
            }

            function closePrivacyPolicyModal(){
                if(!privacyPolicyModal) return;
                privacyPolicyModal.style.display='none';
                privacyPolicyModal.setAttribute('aria-hidden','true');
            }

            function openModal(){
                if(!modal) return;
                modal.style.display='block';
                modal.setAttribute('aria-hidden','false');
            }

            function closeModal(){
                if(!modal) return;
                modal.style.display='none';
                modal.setAttribute('aria-hidden','true');
            }

            if(openDataPrivacyBtn) openDataPrivacyBtn.addEventListener('click', openDataPrivacyModal);
            if(closeDataPrivacyBtn) closeDataPrivacyBtn.addEventListener('click', closeDataPrivacyModal);
            if(dataPrivacyBackdrop) dataPrivacyBackdrop.addEventListener('click', closeDataPrivacyModal);
            if(openPrivacyPolicyBtn) openPrivacyPolicyBtn.addEventListener('click', openPrivacyPolicyModal);
            if(closePrivacyPolicyBtn) closePrivacyPolicyBtn.addEventListener('click', closePrivacyPolicyModal);
            if(privacyPolicyBackdrop) privacyPolicyBackdrop.addEventListener('click', closePrivacyPolicyModal);
            if(openBtn) openBtn.addEventListener('click', openModal);
            if(openInlineBtn) openInlineBtn.addEventListener('click', openModal);
            if(closeBtn) closeBtn.addEventListener('click', closeModal);
            if(backdrop) backdrop.addEventListener('click', closeModal);
            if(ticketBtn) ticketBtn.addEventListener('click', function(){ openSupportRequestModal('ticket'); });
            if(emailBtn) emailBtn.addEventListener('click', function(){ openSupportRequestModal('contact'); });
            if(helpFab) helpFab.addEventListener('click', function(){
                var target=document.getElementById('faqSection');
                if(target) target.scrollIntoView({ behavior:'smooth', block:'start' });
            });
            if(supportRequestBackdrop) supportRequestBackdrop.addEventListener('click', closeSupportRequestModal);
            if(supportRequestClose) supportRequestClose.addEventListener('click', closeSupportRequestModal);
            if(supportRequestCancel) supportRequestCancel.addEventListener('click', closeSupportRequestModal);
            vmCards.forEach(function(card){
                var toggle=card.querySelector('.help-vm-toggle');
                if(!toggle) return;
                toggle.addEventListener('click', function(){
                    var isOpen=card.classList.contains('open');
                    card.classList.toggle('open', !isOpen);
                    toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                });
            });
            faqItems.forEach(function(item){
                var trigger=item.querySelector('.faq-question');
                if(!trigger) return;
                trigger.addEventListener('click', function(){
                    var isOpen=item.classList.contains('open');
                    faqItems.forEach(function(other){
                        other.classList.remove('open');
                        var otherTrigger=other.querySelector('.faq-question');
                        if(otherTrigger) otherTrigger.setAttribute('aria-expanded','false');
                    });
                    if(!isOpen){
                        item.classList.add('open');
                        trigger.setAttribute('aria-expanded','true');
                    }
                });
            });
            document.addEventListener('keydown', function(e){
                if(e.key==='Escape'){
                    closeSupportRequestModal();
                    closeDataPrivacyModal();
                    closePrivacyPolicyModal();
                    closeModal();
                }
            });
        })();
    </script>
</section>
