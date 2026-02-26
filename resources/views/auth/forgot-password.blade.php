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
    .otp-boxes{display:flex;gap:10px;justify-content:center;margin:8px 0}
    .otp-boxes input{width:44px;height:48px;text-align:center;border:1px solid #d4deef;border-radius:10px;font-size:20px}
    .otp-boxes input:focus{border-color:#1d4ed8;box-shadow:0 0 0 3px rgba(29,78,216,.12),0 8px 14px rgba(15,23,42,.12);outline:none}
    .otp-countdown{text-align:center;margin-top:8px;color:#1e3a8a;font-weight:700}
</style>
<div class="auth-center">
    <div class="forgot-card">
        <h1>Forgot Password</h1>
        @php 
            $otpEmail = session('otp_email'); 
            $verifiedEmail = session('otp_verified_email'); 
        @endphp
        @if($verifiedEmail)
            <p class="forgot-subtitle">OTP verified. Please update your password for {{ $verifiedEmail }}.</p>
        @elseif($otpEmail)
            <p class="forgot-subtitle">We have sent an OTP code to your email: {{ $otpEmail }}</p>
        @else
            <p class="forgot-subtitle">Enter your email address to receive a password reset link.</p>
        @endif

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

        @if($verifiedEmail)
            <div class="section-title">Update Password</div>
            <form method="POST" action="{{ route('password.update.after.otp') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $verifiedEmail }}">
                <div class="field-with-icon" style="margin-bottom:8px">
                    <span class="field-icon"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" name="password" placeholder="New Password" required autofocus />
                </div>
                <div class="field-with-icon">
                    <span class="field-icon"><i class="fas fa-lock"></i></span>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm New Password" required />
                </div>
                <button type="submit" class="register-submit">Update Password</button>
            </form>
        @elseif(!$otpEmail)
            <div class="section-title">Email Address</div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="field-with-icon">
                    <span class="field-icon"><i class="fas fa-envelope"></i></span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus />
                </div>
                <button type="submit" class="register-submit">Send OTP Code</button>
            </form>
        @else
            <div class="section-title">OTP Code</div>
            <form id="otpForm" method="POST" action="{{ route('password.otp.verify') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $otpEmail }}">
                <input type="hidden" id="otpHidden" name="otp" value="">
                <div class="otp-boxes">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" autofocus />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                </div>
                <div id="otpCountdown" class="otp-countdown"></div>
                <button id="otpActionBtn" type="submit" class="register-submit">Verify Code</button>
            </form>
            <script>
            (function(){
                var digits = Array.prototype.slice.call(document.querySelectorAll('.otp-digit'));
                function syncHidden(){
                    document.getElementById('otpHidden').value = digits.map(function(i){return i.value||''}).join('');
                }
                digits.forEach(function(inp, idx){
                    inp.addEventListener('input', function(e){
                        this.value = this.value.replace(/\D/g,'').slice(0,1);
                        if (this.value && idx < digits.length-1) digits[idx+1].focus();
                        syncHidden();
                    });
                    inp.addEventListener('keydown', function(e){
                        if (e.key === 'Backspace' && !this.value && idx>0){digits[idx-1].focus();}
                    });
                    inp.addEventListener('paste', function(e){
                        var text = (e.clipboardData || window.clipboardData).getData('text') || '';
                        text = text.replace(/\D/g,'').slice(0, digits.length);
                        if (!text) return;
                        e.preventDefault();
                        for (var i=0;i<digits.length;i++){digits[i].value = text[i] || '';}
                        syncHidden();
                        var next = text.length<digits.length ? digits[text.length] : digits[digits.length-1];
                        if (next) next.focus();
                    });
                });
                var expiresAt = {{ json_encode(session('otp_expires_at')) }};
                var countdownEl = document.getElementById('otpCountdown');
                var btn = document.getElementById('otpActionBtn');
                var form = document.getElementById('otpForm');
                var verifyAction = "{{ route('password.otp.verify') }}";
                var resendAction = "{{ route('password.otp.resend') }}";
                function fmt(s){var m=Math.floor(s/60),r=s%60;return (m<10?'0':'')+m+':'+(r<10?'0':'')+r;}
                function tick(){
                    var now = Math.floor(Date.now()/1000);
                    var remain = Math.max(0, (expiresAt||0) - now);
                    countdownEl.textContent = remain>0 ? ('Time remaining: ' + fmt(remain)) : 'Time remaining: 00:00';
                    if (remain<=0){
                        btn.textContent = 'Resend OTP';
                        form.setAttribute('action', resendAction);
                    } else {
                        btn.textContent = 'Verify Code';
                        form.setAttribute('action', verifyAction);
                    }
                }
                tick();
                setInterval(tick, 1000);
            })();
            </script>
        @endif
    </div>
</div>
@endsection
