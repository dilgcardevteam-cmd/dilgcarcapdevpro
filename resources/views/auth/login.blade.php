@extends('layouts.auth')

@section('content')
<style>
    /* Sliding Form CSS - Inverted Logic to match design preference */
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        background: #f6f5f7;
        font-family: 'DM Sans', sans-serif;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        height: calc(100vh - var(--auth-header-height));
        min-height: calc(100vh - var(--auth-header-height));
    }

    .auth-bg-video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    /* 
       Standard Snippet: sign-in-container is Default Left.
       We want Default (No Class) to be Register Route (Form Left).
       So Register Form goes here.
    */
    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
        padding: 12px;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    /* 
       Standard Snippet: sign-up-container is Active Right.
       We want Active (Class Added) to be Login Route (Form Right).
       So Login Form goes here.
    */
    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
        padding: 12px;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% {
            opacity: 0;
            z-index: 1;
        }
        50%, 100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: transparent;
        color: #333; 
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-panel img {
        max-width: 80%;
        height: auto;
        margin-bottom: 20px;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .overlay-panel.overlay-right {
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        padding: 0 40px;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    h1 {
        font-weight: bold;
        margin: 0 0 10px 0;
        color: #333;
    }

    p {
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
        color: #000000ff;
    }

    .overlay-quote {
        font-family: 'DM Sans', sans-serif;
        font-size: 18px;
        font-weight: bold;
        line-height: 1.4;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-style: normal;
        color: #002C76;
    }

    span {
        font-size: 12px;
        color: #666;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 5px; 
        border: 1px solid #002C76;
        background-color: #002C76;
        color: #FFFFFF;
        font-size: 14px; 
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        cursor: pointer;
        margin-top: 10px;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        background-color: transparent;
        border-color: #002C76;
        color: #002C76; 
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 30px;
        height: 100%;
        text-align: center;
        overflow-y: auto; /* Allow scrolling if form is long */
    }

    .register-form {
        align-items: center;
        justify-content: center;
        padding: 20px 28px 16px;
        text-align: center;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(0, 44, 118, 0.16), 0 8px 18px rgba(15, 23, 42, 0.09);
        background: #ffffff;
    }

    .register-form h1,
    .login-form h1 {
        margin: 0;
        font-size: 28px;
        line-height: 1.2;
        color: #0f172a;
    }

    .login-form {
        align-items: center;
        justify-content: center;
        padding: 20px 28px 16px;
        text-align: center;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(0, 44, 118, 0.16), 0 8px 18px rgba(15, 23, 42, 0.09);
        background: #ffffff;
    }

    .form-inner {
        width: 100%;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #d4deef;
        border-radius: 14px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.88);
    }

    .form-inner .form-group,
    .form-inner .row,
    .form-inner .section-title,
    .form-inner .form-subtitle,
    .form-inner .register-alert,
    .form-inner .mobile-toggle {
        width: 100%;
    }

    .form-subtitle {
        margin: 6px 0 12px;
        font-size: 13px;
        line-height: 1.5;
        color: #475569;
    }

    .section-title {
        margin: 2px 0;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #002C76;
        font-weight: 700;
        text-align: center;
        width: 100%;
    }

    .section-title-center {
        text-align: center;
    }

    .register-form .section-title {
        text-align: left;
    }

    .register-form h1,
    .register-form .form-subtitle {
        width: 100%;
        text-align: left;
    }

    input, select {
        background-color: #fff;
        border: 1px solid #ddd; 
        padding: 9px 12px;
        margin: 5px 0;
        width: 100%;
        border-radius: 5px;
    }
    
    input:focus, select:focus {
        border-color: #002C76;
        outline: none;
    }

    .form-group {
        width: 100%;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .login-form .login-field-spacing {
        width: calc(100% - 100px);
        max-width: calc(560px - 100px);
        margin-left: 50px;
        margin-right: 50px;
    }
    
    .form-group label {
        font-size: 12px;
        font-weight: bold;
        margin-left: 5px;
        color: #333;
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

    .field-with-icon input,
    .field-with-icon select {
        padding-left: 40px;
    }

    .password-field {
        position: relative;
    }

    .password-input {
        padding-left: 40px;
        padding-right: 44px;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        padding: 0;
        margin: 0;
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
    }

    .password-toggle:focus {
        outline: none;
        color: #1d4ed8;
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

    .password-toggle .icon-eye-off {
        display: none;
    }

    .password-toggle[data-visible="true"] .icon-eye {
        display: none;
    }

    .password-toggle[data-visible="true"] .icon-eye-off {
        display: inline;
    }

    .google-btn {
        width: 100%;
        min-height: 40px;
        padding: 8px 14px;
        border: 1px solid #dadce0;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        color: #1f2937;
        margin-top: 8px;
        margin-bottom: 8px;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .google-btn img {
        width: 18px;
        height: 18px;
        margin-right: 0;
        object-fit: contain;
    }

    .google-btn:hover {
        border-color: #c7d2fe;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12);
        transform: translateY(-1px);
    }

    .google-btn:active {
        transform: translateY(0);
    }

    .google-btn-compact {
        width: 230px;
        margin-left: auto;
        margin-right: auto;
    }

    .register-submit.login-submit-compact {
        width: 230px;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }
    
    .row {
        display: flex;
        gap: 10px;
        width: 100%;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .col {
        flex: 1;
    }

    .row-3 .col {
        min-width: 0;
    }

    .field-hint {
        margin: 2px 0 0;
        font-size: 11px;
        color: #64748b;
    }

    .register-alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin: 0 0 12px;
        font-size: 14px;
        width: 100%;
    }

    .register-submit {
        width: 230px;
        margin: 10px auto 0;
        display: block;
    }

    .or-separator {
        text-align: center;
        margin: 12px 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .or-separator-login {
        text-align: center;
        margin: 8px 0;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .mobile-toggle-clickable {
        cursor: pointer;
    }

    .forgot-password-link {
        align-self: flex-end;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .login-form .forgot-password-link {
        margin-right: 50px;
    }

    .form-subtitle,
    .register-alert {
        width: 100%;
        text-align: center;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
    }

    .register-form input,
    .register-form select,
    .login-form input {
        border-color: #d4deef;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.85), 0 1px 2px rgba(15, 23, 42, 0.05);
    }

    .register-form input:focus,
    .register-form select:focus,
    .login-form input:focus {
        border-color: #1d4ed8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12), 0 8px 14px rgba(15, 23, 42, 0.12);
    }

    @media (max-width: 768px) {
        .container {
            height: auto;
            min-height: calc(100vh - var(--auth-header-height));
            border-radius: 0;
        }

        .form-container {
            position: relative;
            width: 100%;
            height: auto;
        }

        .sign-in-container,
        .sign-up-container {
            left: 0;
            top: 0;
            bottom: auto;
            width: 100%;
            height: auto;
            transform: none !important;
            opacity: 1;
        }

        .sign-in-container {
            display: block;
        }

        .sign-up-container {
            display: none;
        }

        .container.right-panel-active .sign-in-container {
            display: none;
        }

        .container.right-panel-active .sign-up-container {
            display: block;
        }

        .overlay-container {
            display: none;
        }

        .sign-in-container {
            padding: 12px;
        }

        .sign-up-container {
            padding: 12px;
        }

        .register-form,
        .login-form {
            justify-content: flex-start;
            padding: 24px 18px 18px;
            border-radius: 14px;
            box-shadow: 0 12px 26px rgba(0, 44, 118, 0.14), 0 4px 10px rgba(15, 23, 42, 0.08);
        }

        .login-form .forgot-password-link {
            margin-right: 0;
        }

        .login-form .login-field-spacing {
            width: 100%;
            max-width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        form {
            height: auto;
            min-height: 100%;
            overflow-y: visible;
        }

        .row {
            flex-direction: column;
            gap: 8px;
            max-width: 100%;
        }

        .mobile-toggle {
            display: block !important;
            text-align: center;
            margin-top: 12px !important;
        }

        .google-btn-compact {
            width: 100%;
        }

        .register-submit,
        .register-submit.login-submit-compact {
            width: 100%;
        }
    }

    /* Modal Styles */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 2000; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.5); 
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; 
        padding: 30px;
        border: 1px solid #888;
        width: min(400px, 92vw);
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        position: relative;
        animation: animatetop 0.4s;
    }

    @keyframes animatetop {
        from {top: -300px; opacity: 0}
        to {top: 0; opacity: 1}
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    
    .modal-icon {
        margin-bottom: 20px;
    }
    
    .modal-title {
        color: #333;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .modal-message {
        color: #666;
        font-size: 16px;
        margin-bottom: 25px;
        line-height: 1.5;
    }
    
    .modal-btn {
        background-color: #002C76;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .modal-btn:hover {
        background-color: #001f52;
    }

    @media (max-width: 768px) {
        .modal-content {
            margin: 20vh auto;
            padding: 20px;
        }
    }
</style>

<div class="container {{ (isset($action) && $action == 'login' && !old('name')) ? 'right-panel-active' : '' }}" id="container">
    <video class="auth-bg-video" autoplay muted loop playsinline>
        <source src="{{ asset('bckgrnd.mp4') }}" type="video/mp4">
    </video>
    
    <!-- 
        "Sign Up Container" (Right Side when Active) 
        CONTAINS: LOGIN FORM
    -->
    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="form-inner">
            <h1>Log In</h1>
            <p class="form-subtitle">Sign in with your registered email and password to continue.</p>


            @if($errors->any() && !old('first_name') && !old('last_name'))
                @php $lock = session('lockout_seconds'); @endphp
                <div class="register-alert">
                    @if($lock)
                        Too many login attempts. Please try again for <span id="lockMsgCountdown"></span>.
                    @else
                        {{ $errors->first() }}
                    @endif
                </div>
            @endif

            <div class="section-title">Login Credentials</div>
            <div class="form-group login-field-spacing">
                <div class="field-with-icon">
                    <span class="field-icon">
                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 4h16v16H4z"></path>
                            <path d="m22 6-10 7L2 6"></path>
                        </svg>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
                </div>
            </div>
            <div class="form-group login-field-spacing">
                <div class="password-field">
                    <span class="field-icon">
                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input id="password" type="password" name="password" class="password-input" placeholder="Password" required />
                    <button type="button" class="password-toggle" data-target="password" data-visible="false" aria-label="Show password">
                        <svg class="feather-icon icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="feather-icon icon-eye-off" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.77 21.77 0 0 1 5.06-6.94"></path>
                            <path d="M22.54 11.88A21.86 21.86 0 0 0 20.21 8.7"></path>
                            <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                            <path d="M1 1l22 22"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot your password?</a>
            @endif
            
            <button type="submit" class="register-submit login-submit-compact">Log In</button>
            <p class="or-separator-login">or</p>
            <a href="{{ route('auth.google.redirect') }}" class="google-btn google-btn-compact">
                <img src="{{ asset('images/google-logo-icon-.png') }}" alt="Google">
                Log in with Google
            </a>

             <!-- Mobile Toggle -->
             <p class="mobile-toggle" style="display:none; margin-top: 10px;">
                Don't have an account? <a href="#" id="mobile-signup">Sign Up</a>
            </p>
            </div>
        </form>
    </div>

    <!-- 
        "Sign In Container" (Left Side Default)
        CONTAINS: REGISTER FORM
    -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('register') }}" class="register-form" id="registerForm">
            @csrf
            <div class="form-inner">
            <h1>Create Account</h1>
            <p class="form-subtitle">Complete your details to submit an account request for approval.</p>
            
            @if($errors->any() && (old('name') || old('first_name') || old('last_name')))
                <div class="register-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="section-title">Personal Information</div>
            <div class="row row-3">
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.8 12.8 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.8 12.8 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </span>
                            <input id="mobile_number" type="tel" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" />
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle Name (Optional)" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <select id="gender" name="gender">
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Sex</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Prefer not to say" {{ old('gender') === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required />
                        </div>
                    </div>
                </div>
            </div>

            <input id="name" type="hidden" name="name" value="{{ old('name') }}" />

            <div class="section-title" style="margin-top: 15px;">Address Information</div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </span>
                            <select id="region" name="region" required>
                                <option value="" disabled selected>Select Region</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </span>
                            <select id="province" name="province" required disabled>
                                <option value="" disabled selected>Select Province</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </span>
                            <select id="city" name="city" required disabled>
                                <option value="" disabled selected>Select City/Municipality</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="field-with-icon">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </span>
                            <select id="barangay" name="barangay" required disabled>
                                <option value="" disabled selected>Select Barangay</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-title" style="margin: 10px 0;">Login Credentials</div>
            <div class="form-group">
                <div class="field-with-icon">
                    <span class="field-icon">
                        <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 4h16v16H4z"></path>
                            <path d="m22 6-10 7L2 6"></path>
                        </svg>
                    </span>
                    <input id="email-register" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="password-field">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input id="password-register" type="password" name="password" class="password-input" placeholder="Password" required />
                            <button type="button" class="password-toggle" data-target="password-register" data-visible="false" aria-label="Show password">
                                <svg class="feather-icon icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="feather-icon icon-eye-off" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.77 21.77 0 0 1 5.06-6.94"></path>
                                    <path d="M22.54 11.88A21.86 21.86 0 0 0 20.21 8.7"></path>
                                    <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                                    <path d="M1 1l22 22"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="password-field">
                            <span class="field-icon">
                                <svg class="feather-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="password-input" placeholder="Confirm Password" required />
                            <button type="button" class="password-toggle" data-target="password_confirmation" data-visible="false" aria-label="Show password">
                                <svg class="feather-icon icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="feather-icon icon-eye-off" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.77 21.77 0 0 1 5.06-6.94"></path>
                                    <path d="M22.54 11.88A21.86 21.86 0 0 0 20.21 8.7"></path>
                                    <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
                                    <path d="M1 1l22 22"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="register-submit">Sign Up</button>
            <p class="or-separator">or</p>

            <a href="http://127.0.0.1:8000/auth/google/redirect" class="google-btn google-btn-compact">
                <img src="http://127.0.0.1:8000/images/google-logo-icon-.png" alt="Google">
                Sign up with Google
            </a>
            
            <!-- Mobile Toggle -->
            <p class="mobile-toggle mobile-toggle-clickable" id="mobile-signin-text" style="display:none; margin-top: 10px;">
                Already have an account? <a href="{{ route('login') }}" id="mobile-signin">Sign In</a>
            </p>
            </div>
        </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CAPDEV PRO">
                <button class="ghost" id="signIn">Sign Up</button> 
            </div>
            <div class="overlay-panel overlay-right">
                <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CAPDEV PRO">
                <button class="ghost" id="signUp">Log In</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeSuccessModal()">&times;</span>
        <div class="modal-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" fill="#28a745"/>
            </svg>
        </div>
        <div class="modal-title">Success!</div>
        <div class="modal-message" id="modalMessage">
            {{ session('success') }}
        </div>
        <button class="modal-btn" onclick="closeSuccessModal()">OK</button>
    </div>
</div>

<script>
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('successModal').style.display = 'block';
        });
    @endif

    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('successModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const mobileSignUpLink = document.getElementById('mobile-signup');
    const mobileSignInLink = document.getElementById('mobile-signin');
    const mobileSignInText = document.getElementById('mobile-signin-text');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
        window.history.pushState({path: '/login'}, '', '/login');
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
        window.history.pushState({path: '/register'}, '', '/register');
    });

    if (mobileSignUpLink) {
        mobileSignUpLink.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = "{{ route('register') }}";
        });
    }

    if (mobileSignInLink) {
        mobileSignInLink.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = "{{ route('login') }}";
        });
    }

    if (mobileSignInText) {
        mobileSignInText.addEventListener('click', () => {
            window.location.href = "{{ route('login') }}";
        });
    }

    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.getAttribute('data-target');
            const passwordInput = targetId ? document.getElementById(targetId) : null;

            if (!passwordInput) {
                return;
            }

            const shouldShow = passwordInput.type === 'password';
            passwordInput.type = shouldShow ? 'text' : 'password';
            toggle.dataset.visible = shouldShow ? 'true' : 'false';
            toggle.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
        });
    });

    const lockSeconds = {{ session('lockout_seconds', 'null') }};
    (function(){
        if(!lockSeconds) return;
        var pwd = document.getElementById('password');
        var submit = document.querySelector('.login-submit-compact');
        var toggle = document.querySelector('.password-toggle');
        var counterEl = document.getElementById('lockMsgCountdown');
        if(pwd){ pwd.disabled = true; }
        if(submit){ submit.disabled = true; submit.style.opacity = '0.6'; submit.style.cursor = 'not-allowed'; }
        if(toggle){ toggle.disabled = true; toggle.style.opacity = '0.6'; toggle.style.cursor = 'not-allowed'; }
        var remain = Number(lockSeconds);
        function fmt(s){ var m=Math.floor(s/60), r=s%60; return (m<10?'0':'')+m+':'+(r<10?'0':'')+r; }
        function tick(){
            if(!counterEl) return;
            counterEl.textContent = fmt(remain);
            if(remain<=0){ clearInterval(iv); counterEl.textContent='00:00'; }
            remain--;
        }
        if(counterEl){ tick(); var iv=setInterval(tick,1000); }
        setTimeout(function(){
            if(pwd){ pwd.disabled = false; }
            if(submit){ submit.disabled = false; submit.style.opacity = ''; submit.style.cursor = ''; }
            if(toggle){ toggle.disabled = false; toggle.style.opacity = ''; toggle.style.cursor = ''; }
        }, Number(lockSeconds) * 1000);
    })();

    // Address Cascading Logic
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const firstNameInput = document.getElementById('first_name');
        const middleNameInput = document.getElementById('middle_name');
        const lastNameInput = document.getElementById('last_name');
        const hiddenNameInput = document.getElementById('name');
        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');
        const oldRegion = @json(old('region'));
        const oldProvince = @json(old('province'));
        const oldCity = @json(old('city'));
        const oldBarangay = @json(old('barangay'));

        function composeFullName() {
            const parts = [
                firstNameInput?.value?.trim() || '',
                middleNameInput?.value?.trim() || '',
                lastNameInput?.value?.trim() || '',
            ].filter(Boolean);

            if (hiddenNameInput) {
                hiddenNameInput.value = parts.join(' ').replace(/\s+/g, ' ').trim();
            }
        }

        if (firstNameInput && lastNameInput && hiddenNameInput) {
            [firstNameInput, middleNameInput, lastNameInput].forEach((input) => {
                if (input) {
                    input.addEventListener('input', composeFullName);
                }
            });

            // Backward-compatibility for older validation responses returning only `name`.
            if (!firstNameInput.value && !lastNameInput.value && hiddenNameInput.value) {
                const parts = hiddenNameInput.value.trim().split(/\s+/);
                if (parts.length >= 2) {
                    firstNameInput.value = parts.shift();
                    lastNameInput.value = parts.pop();
                    middleNameInput.value = parts.join(' ');
                }
            }

            composeFullName();
        }

        if (registerForm) {
            registerForm.addEventListener('submit', composeFullName);
        }

        function loadProvincesByRegion(regionCode, selectedProvince = null, selectedCity = null, selectedBarangay = null) {
            provinceSelect.innerHTML = '<option value="" disabled selected>Select Province</option>';
            provinceSelect.disabled = true;
            citySelect.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';
            citySelect.disabled = true;
            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
            barangaySelect.disabled = true;

            if (!regionCode) return;

            fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`)
                .then(response => response.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));

                    // NCR has no provinces. Keep region value as province to satisfy required field.
                    if (data.length === 0 && regionCode === '130000000') {
                        const option = document.createElement('option');
                        option.value = regionSelect.value;
                        option.dataset.code = regionCode;
                        option.dataset.isRegion = 'true';
                        option.textContent = regionSelect.value;
                        option.selected = true;
                        provinceSelect.appendChild(option);
                        provinceSelect.disabled = false;
                        fetchCities(regionCode, true, selectedCity, selectedBarangay);
                        return;
                    }

                    data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.name;
                        option.dataset.code = province.code;
                        option.textContent = province.name;
                        if (selectedProvince && selectedProvince === province.name) {
                            option.selected = true;
                        }
                        provinceSelect.appendChild(option);
                    });
                    provinceSelect.disabled = false;

                    if (selectedProvince && selectedCity) {
                        const selectedProvinceOption = provinceSelect.options[provinceSelect.selectedIndex];
                        const selectedProvinceCode = selectedProvinceOption?.dataset?.code || '';
                        if (selectedProvinceCode) {
                            fetchCities(selectedProvinceCode, false, selectedCity, selectedBarangay);
                        }
                    }
                })
                .catch(error => console.error('Error fetching provinces:', error));
        }

        function loadBarangays(cityCode, selectedBarangay = null) {
            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
            barangaySelect.disabled = true;

            if (!cityCode) return;

            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`)
                .then(response => response.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    data.forEach(barangay => {
                        const option = document.createElement('option');
                        option.value = barangay.name;
                        option.textContent = barangay.name;
                        if (selectedBarangay && selectedBarangay === barangay.name) {
                            option.selected = true;
                        }
                        barangaySelect.appendChild(option);
                    });
                    barangaySelect.disabled = false;
                })
                .catch(error => console.error('Error fetching barangays:', error));
        }

        // Region Change
        regionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const regionCode = selectedOption?.dataset?.code || '';
            loadProvincesByRegion(regionCode);
        });

        // Fetch Regions
        fetch('https://psgc.gitlab.io/api/regions/')
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));
                data.forEach(region => {
                    const option = document.createElement('option');
                    option.value = region.name;
                    option.dataset.code = region.code;
                    option.textContent = `${region.name} (${region.regionName})`;
                    if (oldRegion && oldRegion === region.name) {
                        option.selected = true;
                    }
                    regionSelect.appendChild(option);
                });

                if (oldRegion) {
                    const selectedRegionOption = regionSelect.options[regionSelect.selectedIndex];
                    const selectedRegionCode = selectedRegionOption?.dataset?.code || '';
                    if (selectedRegionCode) {
                        loadProvincesByRegion(selectedRegionCode, oldProvince || null, oldCity || null, oldBarangay || null);
                    }
                }
            })
            .catch(error => console.error('Error fetching regions:', error));

        // Province Change
        provinceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceCode = selectedOption.dataset.code;
            const isRegion = selectedOption.dataset.isRegion === 'true';

            // Reset City and Barangay
            citySelect.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';
            citySelect.disabled = true;
            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
            barangaySelect.disabled = true;

            if (provinceCode) {
                fetchCities(provinceCode, isRegion);
            }
        });

        // City Change
        citySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cityCode = selectedOption.dataset.code;

            if (cityCode) {
                loadBarangays(cityCode);
            }
        });

        function fetchCities(code, isRegion, selectedCity = null, selectedBarangay = null) {
            let url = isRegion 
                ? `https://psgc.gitlab.io/api/regions/${code}/cities-municipalities/`
                : `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`;

            citySelect.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';
            citySelect.disabled = true;
            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
            barangaySelect.disabled = true;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    let selectedCityCode = '';
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.dataset.code = city.code; // Store code for fetching barangays
                        option.textContent = city.name;
                        if (selectedCity && selectedCity === city.name) {
                            option.selected = true;
                            selectedCityCode = city.code;
                        }
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;

                    if (selectedCityCode) {
                        loadBarangays(selectedCityCode, selectedBarangay);
                    }
                })
                .catch(error => console.error('Error fetching cities:', error));
        }
    });
</script>
@endsection
