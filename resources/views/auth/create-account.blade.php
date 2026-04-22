@extends('layouts.auth')

@section('content')
@php
    $isReviewMode = $isReviewMode ?? false;
    $profileRegion = old('region', $user->region);
    $profileProvince = old('province', $user->province);
    $profileCity = old('city', $user->city);
    $profileBarangay = old('barangay', $user->barangay);
@endphp

<style>
    .create-account-shell {
        min-height: calc(100vh - var(--auth-header-height));
        padding: 20px 18px 26px;
        background:
            radial-gradient(circle at top left, rgba(127, 183, 61, 0.12), transparent 28%),
            radial-gradient(circle at top right, rgba(0, 44, 118, 0.08), transparent 26%),
            linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        font-family: 'DM Sans', sans-serif;
    }

    .create-account-shell *,
    .create-account-shell *::before,
    .create-account-shell *::after {
        box-sizing: border-box;
    }

    .create-account-wrap {
        width: min(1080px, 100%);
        margin: 0 auto;
    }

    .create-account-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    .create-account-intro,
    .create-account-status,
    .create-account-card {
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid #dbe7fb;
        border-radius: 28px;
        box-shadow: 0 22px 45px rgba(15, 23, 42, 0.08);
    }

    .create-account-intro {
        padding: 24px 24px 20px;
    }

    .create-account-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border-radius: 999px;
        background: #eff6ff;
        color: #0b2c74;
        font-size: 0.92rem;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .create-account-title {
        margin: 14px 0 8px;
        color: #0b2c74;
        font-size: clamp(1.8rem, 4.5vw, 2.65rem);
        font-weight: 900;
        letter-spacing: -0.04em;
        line-height: 1.02;
    }

    .create-account-copy {
        margin: 0;
        color: #475569;
        font-size: 0.98rem;
        line-height: 1.7;
        max-width: 58ch;
    }

    .create-account-status {
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
    }

    .create-account-status h2 {
        margin: 0;
        color: #0f172a;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .create-account-status p {
        margin: 0;
        color: #475569;
        line-height: 1.65;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: fit-content;
        padding: 10px 15px;
        border-radius: 999px;
        background: #fff7ed;
        color: #9a3412;
        border: 1px solid #fed7aa;
        font-weight: 800;
    }

    .status-list {
        display: grid;
        gap: 10px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .status-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #334155;
        line-height: 1.6;
    }

    .status-list i {
        margin-top: 3px;
        color: #2563eb;
    }

    .create-account-card {
        padding: 22px;
    }

    .create-account-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .create-account-card-title {
        margin: 0;
        color: #0b2c74;
        font-size: 1.42rem;
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .create-account-card-subtitle {
        margin: 6px 0 0;
        color: #64748b;
        line-height: 1.6;
    }

    .create-account-account {
        min-width: 220px;
        padding: 12px 15px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #dbe7fb;
    }

    .create-account-account span {
        display: block;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .create-account-account strong {
        display: block;
        margin-top: 6px;
        color: #0f172a;
        font-size: 1rem;
        word-break: break-word;
    }

    .create-account-alert {
        padding: 12px 14px;
        border-radius: 16px;
        margin-bottom: 14px;
        border: 1px solid transparent;
        line-height: 1.65;
    }

    .create-account-alert.info {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .create-account-alert.error {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    .create-account-section {
        margin-top: 24px;
    }

    .section-title {
        margin: 0 0 12px;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #002C76;
        font-weight: 700;
        text-align: left;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        column-gap: 22px;
        row-gap: 8px;
        margin-bottom: 10px;
        margin-left: 0;
        margin-right: 0;
    }

    .row-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .row-3 .col {
        width: auto;
    }

    .col {
        flex: 1;
        min-width: 0;
        padding-left: 0;
        padding-right: 0;
    }

    .form-group {
        width: 100%;
        margin-bottom: 6px;
    }

    .field-with-icon {
        position: relative;
    }

    .field-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        width: 18px;
        height: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .feather-icon {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .field-with-icon input,
    .field-with-icon select {
        width: 100%;
        max-width: 100%;
        min-height: 50px;
        padding: 0 16px 0 40px;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #0f172a;
        font-size: 0.96rem;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .field-with-icon input:focus,
    .field-with-icon select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    .field-with-icon input[readonly] {
        background: #f8fafc;
        color: #64748b;
    }

    .field-with-icon.is-readonly input,
    .field-with-icon.is-readonly select {
        background: #f8fafc;
        color: #475569;
        border-color: #dbe4f0;
        pointer-events: none;
    }

    .field-with-icon select:disabled {
        background: #ffffff;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .require {
        color: #dc2626;
    }

    .create-account-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .create-account-note {
        color: #64748b;
        line-height: 1.6;
        max-width: 48ch;
    }

    .create-account-btn,
    .create-account-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 20px;
        border-radius: 16px;
        font-weight: 800;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .create-account-btn {
        border: 0;
        background: linear-gradient(135deg, #4ea3ff 0%, #1842b8 100%);
        color: #fff;
        box-shadow: 0 18px 30px rgba(24, 66, 184, 0.18);
        cursor: pointer;
    }

    .create-account-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 22px 34px rgba(24, 66, 184, 0.24);
    }

    .create-account-link {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #334155;
    }

    @media (max-width: 960px) {
        .create-account-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 720px) {
        .create-account-shell {
            padding: 16px 12px 22px;
        }

        .create-account-intro,
        .create-account-status,
        .create-account-card {
            border-radius: 22px;
        }

        .create-account-intro,
        .create-account-status,
        .create-account-card {
            padding: 18px 16px;
        }

        .row,
        .row-3 {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .create-account-actions {
            align-items: stretch;
        }

        .row-3 .col {
            width: 100%;
        }

        .create-account-btn,
        .create-account-link {
            width: 100%;
        }
    }
</style>

<div class="create-account-shell">
    <div class="create-account-wrap">
        <div class="create-account-hero">
            <div class="create-account-intro">
                <div class="create-account-kicker">
                    <i class="fas {{ $isReviewMode ? 'fa-user-pen' : 'fa-user-check' }}"></i>
                    {{ $isReviewMode ? 'Pending account review' : 'Google account authenticated' }}
                </div>
                <h1 class="create-account-title">{{ $isReviewMode ? 'Review your submitted profile' : 'Complete your account setup' }}</h1>
                <p class="create-account-copy">
                    {{ $isReviewMode
                        ? 'Your submitted details are now locked while your account is waiting for approval. You can review them below for reference.'
                        : 'You\'re almost done. Fill in your profile details so the admin team can review your account and assign the correct office role before giving access to Training Management.' }}
                </p>
            </div>

            <div class="create-account-status">
                <div>
                    <h2>What happens next</h2>
                    <p>{{ $isReviewMode
                        ? 'Your profile is already on file and waiting for approval. The details below are view-only while the admin completes the approval process.'
                        : 'Your Google sign-in only verified your identity. Access to TM stays locked until your profile is complete and approved.' }}</p>
                </div>
                <div class="status-pill">
                    <i class="fas fa-hourglass-half"></i>
                    Status: {{ $isReviewMode ? 'Pending approval' : 'Awaiting profile submission' }}
                </div>
                <ul class="status-list">
                    <li><i class="fas fa-check-circle"></i><span>{{ $isReviewMode ? 'Review your submitted profile information below.' : 'Complete the required profile information below.' }}</span></li>
                    <li><i class="fas fa-check-circle"></i><span>{{ $isReviewMode ? 'Editing is disabled while your request is pending.' : 'Your account will be saved with pending status after submission.' }}</span></li>
                    <li><i class="fas fa-check-circle"></i><span>An admin will assign your proper office role later.</span></li>
                </ul>
            </div>
        </div>

        <div class="create-account-card">
            <div class="create-account-card-head">
                <div>
                    <h2 class="create-account-card-title">{{ $isReviewMode ? 'Review Profile' : 'Create Account' }}</h2>
                    <p class="create-account-card-subtitle">
                        {{ $isReviewMode ? 'Your submitted information is available here for viewing only while your account is pending approval.' : 'Please complete all required fields marked with ' }}
                        @if(!$isReviewMode)<span class="require">*</span>.@endif
                    </p>
                </div>
                <div class="create-account-account">
                    <span>Authenticated Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>
            </div>

            @if(session('profile_required'))
                <div class="create-account-alert info">
                    Please complete your profile before you can continue to the dashboard.
                </div>
            @endif

            @if ($errors->any())
                <div class="create-account-alert error">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="createAccountForm" action="{{ route('profile.setup.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="info">

                <div class="create-account-section">
                    <div class="section-title">Personal Information</div>
                    <div class="row row-3">
                        <div class="col">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $firstParsed) }}" placeholder="First Name" {{ $isReviewMode ? 'readonly tabindex=-1' : 'required' }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.8 12.8 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.8 12.8 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                    </span>
                                    <input id="mobile_number" type="tel" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" placeholder="Mobile Number" inputmode="numeric" pattern="[0-9]*" maxlength="11" {{ $isReviewMode ? 'readonly tabindex=-1' : 'required' }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                        </svg>
                                    </span>
                                    <select id="field_of_work" name="field_of_work" {{ $isReviewMode ? 'disabled tabindex=-1' : 'required' }}>
                                        <option value="" disabled {{ old('field_of_work', $user->field_of_work) ? '' : 'selected' }}>Select Field of Work</option>
                                        @php
                                            $fields = [
                                                'Administrative Clerk', 'Budget Assistant', 'Treasury/Cashier Staff',
                                                'Civil Engineering Assistant', 'Project Monitoring Staff', 'Site Inspector',
                                                'IT Support Technician', 'Systems Developer Assistant', 'Web/Systems Administrator',
                                                'Barangay Health Worker Assistant', 'Medical Records Clerk', 'Social Welfare Assistant',
                                                'Traffic Enforcer Assistant', 'Emergency Response Staff', 'Inspection Officer Assistant',
                                                'Legal Research Assistant', 'Ordinance Drafting Assistant', 'Compliance Monitoring Staff',
                                                'Business Permit Assistant', 'Investment Promotion Assistant', 'MSME Support Staff',
                                                'Agricultural Technician Assistant', 'Environmental Monitoring Staff', 'Waste Management Assistant',
                                                'Daycare/Community Education Assistant', 'Scholarship Program Assistant', 'Community Development Worker'
                                            ];
                                        @endphp
                                        @foreach($fields as $field)
                                            <option value="{{ $field }}" {{ old('field_of_work', $user->field_of_work) === $field ? 'selected' : '' }}>{{ $field }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name', $middleParsed) }}" placeholder="Middle Name (Optional)" {{ $isReviewMode ? 'readonly tabindex=-1' : '' }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <select id="gender" name="gender" {{ $isReviewMode ? 'disabled tabindex=-1' : 'required' }}>
                                        <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Select Sex</option>
                                        <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Prefer not to say" {{ old('gender', $user->gender) === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $lastParsed) }}" placeholder="Last Name" {{ $isReviewMode ? 'readonly tabindex=-1' : 'required' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="field-with-icon is-readonly">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M4 4h16v16H4z"></path>
                                            <path d="m22 6-10 7L2 6"></path>
                                        </svg>
                                    </span>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email Address" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M3 7h18M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                        </svg>
                                    </span>
                                    <select id="agency" name="agency" {{ $isReviewMode ? 'disabled tabindex=-1' : 'required' }}>
                                        <option value="" disabled {{ old('agency', $user->agency) ? '' : 'selected' }}>Select Agency/LGU</option>
                                        <option value="DILG" {{ old('agency', $user->agency) === 'DILG' ? 'selected' : '' }}>DILG</option>
                                        <option value="LGU" {{ old('agency', $user->agency) === 'LGU' ? 'selected' : '' }}>LGU</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="create-account-section">
                    <div class="section-title">Address Information</div>
                    <div class="row">
                        <div class="col" id="setup-region-container">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </span>
                                    <select id="setup_region" name="region" data-selected="{{ $profileRegion }}" {{ $isReviewMode ? 'disabled tabindex=-1' : 'required' }}>
                                        <option value="" disabled {{ $profileRegion ? '' : 'selected' }}>Select Region</option>
                                        @if($profileRegion)
                                            <option value="{{ $profileRegion }}" selected>{{ $profileRegion }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col" id="setup-province-container">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </span>
                                    <select id="setup_province" name="province" data-selected="{{ $profileProvince }}" {{ $isReviewMode ? 'disabled tabindex=-1' : ($profileRegion ? 'required' : 'disabled') }}>
                                        <option value="" disabled {{ $profileProvince ? '' : 'selected' }}>Select Province</option>
                                        @if($profileProvince)
                                            <option value="{{ $profileProvince }}" selected>{{ $profileProvince }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col" id="setup-city-container">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </span>
                                    <select id="setup_city" name="city" data-selected="{{ $profileCity }}" {{ $isReviewMode ? 'disabled tabindex=-1' : (($profileProvince || $profileRegion) ? 'required' : 'disabled') }}>
                                        <option value="" disabled {{ $profileCity ? '' : 'selected' }}>Select City/Municipality</option>
                                        @if($profileCity)
                                            <option value="{{ $profileCity }}" selected>{{ $profileCity }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col" id="setup-barangay-container">
                            <div class="form-group">
                                <div class="field-with-icon {{ $isReviewMode ? 'is-readonly' : '' }}">
                                    <span class="field-icon">
                                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </span>
                                    <select id="setup_barangay" name="barangay" data-selected="{{ $profileBarangay }}" {{ $isReviewMode ? 'disabled tabindex=-1' : ($profileCity ? 'required' : 'disabled') }}>
                                        <option value="" disabled {{ $profileBarangay ? '' : 'selected' }}>Select Barangay</option>
                                        @if($profileBarangay)
                                            <option value="{{ $profileBarangay }}" selected>{{ $profileBarangay }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div class="create-account-actions">
                <div class="create-account-note">
                    {{ $isReviewMode ? 'Your account will remain pending while the admin reviews your submitted details.' : 'After submission, your account will be marked as pending while waiting for admin approval.' }}
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="create-account-link">Back to Login</button>
                    </form>
                    @if(!$isReviewMode)
                        <button type="submit" form="createAccountForm" class="create-account-btn">Submit for Approval</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function initSetupLocationDropdowns() {
    const BUREAUS = [
        'Bureau of Local Government Development',
        'Bureau of Local Government Supervision',
        'Bureau of Fire Protection',
        'Bureau of Jail Management and Penology',
        'Local Government Academy',
    ];
    const SERVICES = [
        'Administrative Service',
        'Financial and Management Service',
        'Legal Service',
        'Planning Service',
        'Public Affairs and Communication Service',
    ];

    const agencySelect = document.getElementById('agency');
    const regionSelect = document.getElementById('setup_region');
    const provinceSelect = document.getElementById('setup_province');
    const citySelect = document.getElementById('setup_city');
    const barangaySelect = document.getElementById('setup_barangay');
    const provinceContainer = document.getElementById('setup-province-container');
    const cityContainer = document.getElementById('setup-city-container');
    const barangayContainer = document.getElementById('setup-barangay-container');

    if (!agencySelect || !regionSelect || !provinceSelect || !citySelect || !barangaySelect) return;
    if (regionSelect.dataset.initialized === 'true') return;
    regionSelect.dataset.initialized = 'true';

    const selectedRegion = regionSelect.dataset.selected || '';
    const selectedProvince = provinceSelect.dataset.selected || '';
    const selectedCity = citySelect.dataset.selected || '';
    const selectedBarangay = barangaySelect.dataset.selected || '';

    const resetSelect = (selectElement, placeholder) => {
        selectElement.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
    };

    const setSelectState = (selectElement, disabled) => {
        selectElement.disabled = disabled;
    };

    const setContainerVisibility = (container, visible) => {
        if (!container) return;
        container.style.display = visible ? '' : 'none';
    };

    function applyAgencyMode() {
        const isDILG = agencySelect.value === 'DILG';
        if (isDILG) {
            setContainerVisibility(provinceContainer, false);
            setContainerVisibility(cityContainer, false);
            setContainerVisibility(barangayContainer, false);
        } else {
            setContainerVisibility(provinceContainer, true);
            setContainerVisibility(cityContainer, true);
            setContainerVisibility(barangayContainer, true);
        }
    }

    function populateRegionOrLevelOptions(preserveSelection = false) {
        const mode = agencySelect.value || 'LGU';
        regionSelect.innerHTML = '';

        if (mode === 'DILG') {
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.disabled = true;
            placeholder.selected = true;
            placeholder.textContent = 'Select Level';
            regionSelect.appendChild(placeholder);

            ['DILG Central Office', 'DILG Regional Office', 'DILG Provincial Office'].forEach(label => {
                const option = document.createElement('option');
                option.value = label;
                option.textContent = label;
                if (preserveSelection && selectedRegion === label) {
                    option.selected = true;
                    placeholder.selected = false;
                }
                regionSelect.appendChild(option);
            });

            setSelectState(regionSelect, false);
            setContainerVisibility(provinceContainer, false);
            setContainerVisibility(cityContainer, false);
            setContainerVisibility(barangayContainer, false);
            resetSelect(provinceSelect, 'Select Office');
            resetSelect(citySelect, 'Select City/Municipality');
            resetSelect(barangaySelect, 'Select Barangay');
            setSelectState(provinceSelect, true);
            setSelectState(citySelect, true);
            setSelectState(barangaySelect, true);
            return;
        }

        resetSelect(regionSelect, 'Select Region');
        setSelectState(regionSelect, false);
        fetch(`{{ url('/psgc/regions') }}`)
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));

                let selectedRegionCode = '';
                let matched = false;
                data.forEach(region => {
                    const option = document.createElement('option');
                    option.value = region.name;
                    option.dataset.code = region.code;
                    option.textContent = region.name;
                    if (preserveSelection && selectedRegion === region.name) {
                        option.selected = true;
                        selectedRegionCode = region.code;
                        matched = true;
                    }
                    regionSelect.appendChild(option);
                });

                if (selectedRegion && !matched) {
                    addFallbackOption(regionSelect, selectedRegion);
                }

                if (selectedRegionCode) {
                    loadProvincesByRegion(selectedRegionCode, selectedProvince || null, selectedCity || null, selectedBarangay || null);
                }
            })
            .catch(() => {
                if (selectedRegion) addFallbackOption(regionSelect, selectedRegion);
            });
    }

    function populateOfficeByLevel(levelLabel) {
        resetSelect(provinceSelect, 'Select Office');
        setSelectState(provinceSelect, true);
        resetSelect(citySelect, 'Select City/Municipality');
        setSelectState(citySelect, true);
        resetSelect(barangaySelect, 'Select Barangay');
        setSelectState(barangaySelect, true);

        setContainerVisibility(provinceContainer, false);
        setContainerVisibility(cityContainer, false);
        setContainerVisibility(barangayContainer, false);

        if (!levelLabel) return;

        if (levelLabel === 'DILG Central Office') {
            ['Bureaus', 'Services'].forEach(label => {
                const option = document.createElement('option');
                option.value = label;
                option.textContent = label;
                provinceSelect.appendChild(option);
            });
            setSelectState(provinceSelect, false);
            resetSelect(citySelect, 'Select Bureaus/Services');
            setSelectState(citySelect, true);
            setContainerVisibility(provinceContainer, true);
            setContainerVisibility(cityContainer, true);
            return;
        }

        if (levelLabel === 'DILG Regional Office') {
            resetSelect(provinceSelect, 'Select Region');
            fetch(`{{ url('/psgc/regions') }}`)
                .then(response => response.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    data.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.name;
                        option.dataset.code = region.code;
                        option.textContent = region.name;
                        provinceSelect.appendChild(option);
                    });
                    setSelectState(provinceSelect, false);
                    setContainerVisibility(provinceContainer, true);
                });
            return;
        }

        if (levelLabel === 'DILG Provincial Office') {
            resetSelect(provinceSelect, 'Select Office');
            fetch(`{{ url('/psgc/regions') }}`)
                .then(response => response.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    data.forEach(region => {
                        const option = document.createElement('option');
                        option.value = `${region.name} Office`;
                        option.dataset.code = region.code;
                        option.textContent = `DILG ${region.name} Office`;
                        provinceSelect.appendChild(option);
                    });
                    setSelectState(provinceSelect, false);
                    setContainerVisibility(provinceContainer, true);
                });
        }
    }

    const addFallbackOption = (selectElement, value, label = value) => {
        if (!value) return null;
        const option = document.createElement('option');
        option.value = value;
        option.textContent = label;
        option.selected = true;
        selectElement.appendChild(option);
        return option;
    };

    function loadBarangays(cityCode, selectedBarangayValue = null) {
        resetSelect(barangaySelect, 'Select Barangay');
        setSelectState(barangaySelect, !cityCode);

        if (!cityCode) {
            if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            return;
        }

        fetch(`{{ url('/psgc/cities') }}/${cityCode}/barangays`)
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));
                let matched = false;
                data.forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay.name;
                    option.textContent = barangay.name;
                    if (selectedBarangayValue && selectedBarangayValue === barangay.name) {
                        option.selected = true;
                        matched = true;
                    }
                    barangaySelect.appendChild(option);
                });

                if (selectedBarangayValue && !matched) {
                    addFallbackOption(barangaySelect, selectedBarangayValue);
                }
            })
            .catch(() => {
                if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            });
    }

    function fetchCities(code, isRegion, selectedCityValue = null, selectedBarangayValue = null) {
        const url = isRegion
            ? `{{ url('/psgc/regions') }}/${code}/cities`
            : `{{ url('/psgc/provinces') }}/${code}/cities`;

        resetSelect(citySelect, 'Select City/Municipality');
        resetSelect(barangaySelect, 'Select Barangay');
        setSelectState(citySelect, !code);
        setSelectState(barangaySelect, true);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                setSelectState(citySelect, false);
                data.sort((a, b) => a.name.localeCompare(b.name));
                let selectedCityCode = '';
                let matched = false;

                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.dataset.code = city.code;
                    option.textContent = city.name;
                    if (selectedCityValue && selectedCityValue === city.name) {
                        option.selected = true;
                        selectedCityCode = city.code;
                        matched = true;
                    }
                    citySelect.appendChild(option);
                });

                if (selectedCityValue && !matched) {
                    addFallbackOption(citySelect, selectedCityValue);
                }

                if (selectedCityCode) {
                    loadBarangays(selectedCityCode, selectedBarangayValue);
                } else if (selectedBarangayValue) {
                    addFallbackOption(barangaySelect, selectedBarangayValue);
                }
            })
            .catch(() => {
                if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            });
    }

    function loadProvincesByRegion(regionCode, selectedProvinceValue = null, selectedCityValue = null, selectedBarangayValue = null) {
        const isDILGMode = agencySelect.value === 'DILG';
        resetSelect(provinceSelect, 'Select Province');
        resetSelect(citySelect, 'Select City/Municipality');
        resetSelect(barangaySelect, 'Select Barangay');
        setSelectState(provinceSelect, !regionCode);
        setSelectState(citySelect, true);
        setSelectState(barangaySelect, true);

        if (!regionCode) {
            if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
            if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
            if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            return;
        }

        fetch(`{{ url('/psgc/regions') }}/${regionCode}/provinces`)
            .then(response => response.json())
            .then(data => {
                setSelectState(provinceSelect, false);
                data.sort((a, b) => a.name.localeCompare(b.name));

                if (data.length === 0 && regionCode === '130000000') {
                    const option = addFallbackOption(
                        provinceSelect,
                        isDILGMode ? `${regionSelect.value} Office` : regionSelect.value,
                        isDILGMode ? `${regionSelect.value} Office` : regionSelect.value
                    );
                    if (option) {
                        option.dataset.code = regionCode;
                        option.dataset.isRegion = 'true';
                    }
                    if (!isDILGMode) {
                        fetchCities(regionCode, true, selectedCityValue, selectedBarangayValue);
                    }
                    return;
                }

                let selectedProvinceCode = '';
                let matched = false;
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = isDILGMode ? `${province.name} Office` : province.name;
                    option.dataset.code = province.code;
                    option.textContent = isDILGMode ? `${province.name} Office` : province.name;
                    if (selectedProvinceValue && (selectedProvinceValue === province.name || selectedProvinceValue === `${province.name} Office`)) {
                        option.selected = true;
                        selectedProvinceCode = province.code;
                        matched = true;
                    }
                    provinceSelect.appendChild(option);
                });

                if (selectedProvinceValue && !matched) {
                    addFallbackOption(provinceSelect, selectedProvinceValue);
                }

                if (selectedProvinceCode && !isDILGMode) {
                    fetchCities(selectedProvinceCode, false, selectedCityValue, selectedBarangayValue);
                } else if (selectedCityValue) {
                    addFallbackOption(citySelect, selectedCityValue);
                    if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
                }
            })
            .catch(() => {
                if (selectedProvinceValue) addFallbackOption(provinceSelect, selectedProvinceValue);
                if (selectedCityValue) addFallbackOption(citySelect, selectedCityValue);
                if (selectedBarangayValue) addFallbackOption(barangaySelect, selectedBarangayValue);
            });
    }

    agencySelect.addEventListener('change', function() {
        applyAgencyMode();
        populateRegionOrLevelOptions(false);
    });

    regionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const isDILGMode = agencySelect.value === 'DILG';
        if (isDILGMode) {
            populateOfficeByLevel(selectedOption ? selectedOption.value : '');
            return;
        }
        const regionCode = selectedOption?.dataset?.code || '';
        loadProvincesByRegion(regionCode);
    });

    provinceSelect.addEventListener('change', function() {
        if (agencySelect.value === 'DILG') {
            const levelLabel = regionSelect.options[regionSelect.selectedIndex]?.value || '';
            if (levelLabel === 'DILG Central Office') {
                const category = this.value;
                resetSelect(citySelect, category === 'Bureaus' ? 'Select Bureaus' : 'Select Services');
                const list = category === 'Bureaus' ? BUREAUS : SERVICES;
                list.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    citySelect.appendChild(option);
                });
                setSelectState(citySelect, false);
                setContainerVisibility(cityContainer, true);
                setContainerVisibility(barangayContainer, false);
                return;
            }

            resetSelect(citySelect, 'Select City/Municipality');
            resetSelect(barangaySelect, 'Select Barangay');
            setSelectState(citySelect, true);
            setSelectState(barangaySelect, true);
            setContainerVisibility(cityContainer, false);
            setContainerVisibility(barangayContainer, false);
            return;
        }

        const selectedOption = this.options[this.selectedIndex];
        const provinceCode = selectedOption?.dataset?.code || '';
        const isRegion = selectedOption?.dataset?.isRegion === 'true';
        if (!provinceCode) {
            resetSelect(citySelect, 'Select City/Municipality');
            resetSelect(barangaySelect, 'Select Barangay');
            setSelectState(citySelect, true);
            setSelectState(barangaySelect, true);
            return;
        }
        fetchCities(provinceCode, isRegion);
    });

    citySelect.addEventListener('change', function() {
        if (agencySelect.value === 'DILG') {
            return;
        }
        const selectedOption = this.options[this.selectedIndex];
        const cityCode = selectedOption?.dataset?.code || '';
        loadBarangays(cityCode);
    });

    applyAgencyMode();
    populateRegionOrLevelOptions(true);
}

document.addEventListener('DOMContentLoaded', initSetupLocationDropdowns);
</script>
@endsection
