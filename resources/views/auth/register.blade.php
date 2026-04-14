@extends('layouts.auth')

@section('content')
<style>
    .split-container {
        display: flex;
        flex: 1;
        min-height: calc(100vh - 110px); /* Adjust based on header height */
    }

    .split-left {
        flex: 1.5; /* Larger left side */
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .split-left img {
        max-width: 85%;
        max-height: 100%;
        object-fit: cover;
    }

    .split-right {
        flex: 1;
        background: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 600px;
        margin: 0 auto; /* Center on mobile if stacked */
    }

    .login-header {
        margin-bottom: 30px;
    }

    .login-header h2 {
        font-size: 2rem;
        font-weight: 400;
        margin-bottom: 10px;
        color: #000000;
    }

    .login-header p {
        color: #000000;
        font-size: 1rem;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .btn-primary {
        background-color: #002C76;
        color: white;
        padding: 12px;
        width: 100%;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background-color: #001a47;
    }

    .divider {
        margin: 20px 0;
        text-align: center;
        position: relative;
        color: #000000;
        font-size: 14px;
    }
    
    .divider::before, .divider::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: #eee;
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .google-btn {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 25px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: 500;
        color: #000000;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .google-btn img {
        height: 20px;
        margin-right: 10px;
    }

    .back-link {
        color: #000000;
        text-decoration: none;
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        font-weight: 500;
        align-self: flex-start;
    }
    
    .back-link i {
        margin-right: 8px;
    }
    
    .signup-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #000000;
    }

    @media (max-width: 768px) {
        .split-container {
            flex-direction: column;
        }
        .split-left {
            display: none;
        }
        .split-right {
            padding: 20px;
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<div class="split-container">
    <div class="split-right">
        <a href="/" class="back-link"><i class="fas fa-arrow-left"></i> Go back</a>

        <div class="login-header">
            <h2>Create Account</h2>
            <p>Please fill in the details to sign up.</p>
        </div>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px;">
                <ul style="padding-left: 20px; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" style="display: block; margin-bottom: 8px; font-size: 14px; color: #000000;">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email" style="display: block; margin-bottom: 8px; font-size: 14px; color: #000000;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="password" style="display: block; margin-bottom: 8px; font-size: 14px; color: #000000;">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Create a password">
            </div>

            <div class="form-group">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-size: 14px; color: #000000;">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Confirm your password">
            </div>

            <button type="submit" class="btn-primary">Sign Up</button>

            <div class="divider">Or continue with</div>

            <a href="{{ route('auth.google.redirect') }}" class="google-btn">
                <img src="{{ asset('images/google-logo-icon-.png') }}" alt="Google">
                Sign up with Google
            </a>

            <div class="signup-link">
                Already have an account? <a href="{{ route('login') }}" style="color: #000000; font-weight: bold; text-decoration: none;">Login</a>
            </div>
        </form>
    </div>

    <div class="split-left">
        <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CAPDEV PRO">
    </div>
</div>
@endsection
