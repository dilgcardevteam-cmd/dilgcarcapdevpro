@extends('layouts.auth')

@section('content')
<style>
    .auth-center{
        min-height: calc(100vh - var(--auth-header-height));
        display:flex;align-items:center;justify-content:center;padding:32px;background:
            radial-gradient(1200px 500px at 10% -20%, rgba(127,183,61,.12), transparent 60%),
            radial-gradient(900px 400px at 90% -20%, rgba(0,44,118,.14), transparent 58%),
            #f7f8fb;
    }
    .forgot-card{
        width:min(560px,92vw);
        border-radius:18px;
        background:linear-gradient(180deg,#ffffff,#fbfcff);
        border:1px solid rgba(0,44,118,.08);
        box-shadow:0 28px 60px rgba(15,23,42,.14),0 12px 24px rgba(15,23,42,.08),inset 0 1px 0 rgba(255,255,255,.7);
        padding:26px 22px 22px;
    }
    .forgot-card h1{
        margin:10px 0 2px 0;
        text-align:center;
        font-weight:900;
        letter-spacing:-.02em;
        font-size:1.6rem;
        background:linear-gradient(90deg,#0b57d0,#7fb73d);
        -webkit-background-clip:text;
        background-clip:text;
        color:transparent
    }
    .forgot-subtitle{margin:6px 0 18px;text-align:center;color:#334155;font-size:.98rem}
    .section-title{font-weight:800;letter-spacing:.12em;text-transform:uppercase;font-size:.82rem;color:#1e3a8a;text-align:center;margin:10px auto 8px}
    .field-with-icon{position:relative;display:flex;align-items:center}
    .field-with-icon .field-icon{position:absolute;left:10px;color:#64748b}
    .field-with-icon input{
        width:100%;
        padding:12px 12px 12px 42px;
        border:1px solid #d4deef;
        border-radius:12px;
        background:#ffffff;
        box-shadow:inset 0 1px 0 rgba(255,255,255,.85),0 2px 6px rgba(15,23,42,.06);
        transition:border-color .2s, box-shadow .2s, transform .06s;
    }
    .field-with-icon input:hover{transform:translateY(-1px)}
    .field-with-icon input:focus{border-color:#1d4ed8;box-shadow:0 0 0 3px rgba(29,78,216,.12),0 10px 20px rgba(15,23,42,.12);outline:none}
    .register-alert{background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin:0 0 12px;font-size:14px;text-align:center}
    .register-submit{
        display:block;width:240px;margin:12px auto 0;
        color:#fff;border:none;border-radius:999px;padding:12px 18px;font-weight:800;cursor:pointer;
        background:linear-gradient(90deg,#001a47,#0b57d0);
        box-shadow:0 10px 18px rgba(11,87,208,.25);
        transition:filter .2s, transform .06s;
    }
    .back-link{display:block;text-align:center;margin-top:12px}
    .forgot-icon{width:18px;height:18px}
    .otp-boxes{display:flex;gap:10px;justify-content:center;margin:8px 0}
    .otp-boxes input{
        width:46px;height:52px;text-align:center;border:1px solid #d4deef;border-radius:12px;font-size:22px;
        box-shadow:inset 0 1px 0 rgba(255,255,255,.85),0 2px 6px rgba(15,23,42,.06);
        transition:border-color .2s, box-shadow .2s, transform .06s;
    }
    .otp-boxes input.filled{border-color:#7fb73d}
    .otp-boxes input:focus{border-color:#1d4ed8;box-shadow:0 0 0 3px rgba(29,78,216,.12),0 10px 20px rgba(15,23,42,.12);outline:none}
    .otp-countdown{text-align:center;margin-top:8px;color:#1e3a8a;font-weight:700}
    .forgot-logo{display:flex;justify-content:center;margin-bottom:6px}
    .forgot-logo img{height:46px}
    .back-btn{
        display:block;width:120px;margin:10px auto 0;background:#f1f5f9;color:#0f172a;
        border:1px solid #e2e8f0;border-radius:999px;padding:10px 16px;font-weight:700;text-align:center;text-decoration:none;
        transition:background .2s, transform .06s
    }
    .steps{display:flex;justify-content:center;gap:8px;margin:6px 0 4px}
    .step{padding:6px 10px;border-radius:999px;font-size:.7rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;border:1px solid #e2e8f0;color:#475569;background:#f8fafc}
    .step.active{border-color:#0b57d0;color:#0b57d0;background:#e8effd}
</style>
<div class="auth-center">
    <div class="forgot-card">
        <div class="forgot-logo">
            <img src="{{ asset('images/Capdev pro.png') }}" alt="CAPDEV PRO">
        </div>
        @php 
            $otpEmail = session('otp_email'); 
            $verifiedEmail = session('otp_verified_email'); 
            $activeStep = $verifiedEmail ? 3 : ($otpEmail ? 2 : 1);
        @endphp
        <div class="steps">
            <span class="step {{ $activeStep===1 ? 'active' : '' }}">Email</span>
            <span class="step {{ $activeStep===2 ? 'active' : '' }}">OTP</span>
            <span class="step {{ $activeStep===3 ? 'active' : '' }}">Password</span>
        </div>
        <h1>Forgot Password</h1>
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
                <a href="{{ route('login') }}" class="back-btn">Back</a>
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
                        if (this.value) this.classList.add('filled'); else this.classList.remove('filled');
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
                        for (var i=0;i<digits.length;i++){digits[i].value = text[i] || ''; digits[i].classList.toggle('filled', !!text[i]);}
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


