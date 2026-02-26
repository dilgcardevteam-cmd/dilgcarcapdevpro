@extends('layouts.auth')

@section('content')
<style>
    .auth-center{
        min-height: calc(100vh - var(--auth-header-height));
        display:flex;align-items:center;justify-content:center;padding:20px;background:#f6f5f7;
    }
    .forgot-card{
        width:min(520px,92vw);
        border-radius:14px;
        background:#fff;
        box-shadow:0 12px 26px rgba(0,44,118,.14),0 4px 10px rgba(15,23,42,.08);
        padding:24px 18px 18px;
    }
    .forgot-card h1{margin:0 0 6px 0;color:#333;font-weight:800;letter-spacing:-.02em;text-align:center}
    .forgot-subtitle{margin:6px 0 18px;text-align:center;color:#000000ff;font-size:.95rem}
    .section-title{font-weight:800;letter-spacing:.12em;text-transform:uppercase;font-size:.82rem;color:#1e3a8a;text-align:center;margin:10px auto 8px}
    .field-with-icon{position:relative;display:flex;align-items:center}
    .field-with-icon .field-icon{position:absolute;left:10px;color:#64748b}
    .field-with-icon input{width:100%;padding:12px 12px 12px 42px;border:1px solid #d4deef;border-radius:10px;box-shadow:inset 0 1px 0 rgba(255,255,255,.85),0 1px 2px rgba(15,23,42,.05)}
    .field-with-icon input:focus{border-color:#1d4ed8;box-shadow:0 0 0 3px rgba(29,78,216,.12),0 8px 14px rgba(15,23,42,.12);outline:none}
    .register-alert{background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin:0 0 12px;font-size:14px;text-align:center}
    .register-submit{display:block;width:230px;margin:12px auto 0;background:#001a47;color:#fff;border:none;border-radius:10px;padding:12px 16px;font-weight:800;cursor:pointer}
    .register-submit:hover{background:#06235b}
    .back-link{display:block;text-align:center;margin-top:12px}
    .forgot-icon{width:18px;height:18px}
</style>
<div class="auth-center">
    <div class="forgot-card">
        <h1>Forgot Password</h1>
        <p class="forgot-subtitle">Enter your email address to receive a password reset link.</p>

        @if (session('status'))
            <div class="register-alert" style="background:#ecfdf5;color:#065f46;border-color:#a7f3d0">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="register-alert">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="section-title">Email Address</div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="field-with-icon">
                <span class="field-icon"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus />
            </div>
            <button type="submit" class="register-submit">Send Reset Link</button>
        </form>
    </div>
</div>
@endsection
