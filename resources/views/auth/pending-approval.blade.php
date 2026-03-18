@extends('layouts.auth')

@section('content')
<style>
    .pending-shell{
        min-height: calc(100vh - var(--auth-header-height));
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px 18px;
        background:
            radial-gradient(circle at top left, rgba(37, 99, 235, 0.12), transparent 24%),
            radial-gradient(circle at bottom right, rgba(251, 191, 36, 0.12), transparent 22%),
            linear-gradient(180deg,#f8fbff 0%,#eef4ff 100%);
        font-family:'DM Sans',sans-serif;
    }
    .pending-shell *,
    .pending-shell *::before,
    .pending-shell *::after{
        box-sizing:border-box;
    }
    .pending-card{
        position:relative;
        overflow:hidden;
        width:min(780px,100%);
        background:rgba(255,255,255,.96);
        border:1px solid #dbe6fb;
        border-radius:32px;
        box-shadow:0 30px 70px rgba(15,23,42,.12);
        padding:28px 30px 24px;
        text-align:center;
    }
    .pending-card::before{
        content:"";
        position:absolute;
        inset:0 auto auto 0;
        width:220px;
        height:220px;
        background:radial-gradient(circle, rgba(37,99,235,.12) 0%, rgba(37,99,235,0) 70%);
        pointer-events:none;
    }
    .pending-kicker{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:8px 14px;
        border-radius:999px;
        background:#eff6ff;
        color:#0b2c74;
        font-size:.9rem;
        font-weight:800;
        letter-spacing:-.01em;
    }
    .pending-icon{
        width:78px;
        height:78px;
        margin:16px auto 14px;
        border-radius:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#fff7d6 0%,#ffe08a 100%);
        color:#a16207;
        font-size:1.9rem;
        box-shadow:0 16px 30px rgba(245, 158, 11, .18);
    }
    .pending-title{
        margin:0;
        color:#0b2c74;
        font-size:clamp(1.9rem, 4.4vw, 2.7rem);
        font-weight:900;
        letter-spacing:-.045em;
        line-height:1.02;
    }
    .pending-copy{
        max-width:34ch;
        margin:12px auto 0;
        color:#475569;
        font-size:.98rem;
        line-height:1.65;
    }
    .pending-status-wrap{
        margin-top:18px;
        display:flex;
        justify-content:center;
    }
    .pending-status{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:10px 16px;
        border-radius:999px;
        background:#fff7ed;
        color:#9a3412;
        border:1px solid #fed7aa;
        font-weight:800;
        box-shadow:0 10px 18px rgba(154, 52, 18, .08);
    }
    .pending-note{
        margin:18px auto 0;
        max-width:42ch;
        padding:13px 15px;
        border-radius:18px;
        background:#f8fbff;
        border:1px solid #dbe7fb;
        color:#0f766e;
        line-height:1.55;
    }
    .pending-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
        margin-top:20px;
        text-align:left;
    }
    .pending-info{
        padding:15px 16px 14px;
        border-radius:20px;
        background:#fcfdff;
        border:1px solid #e2e8f0;
    }
    .pending-info span{
        display:block;
        margin-bottom:8px;
        color:#64748b;
        font-size:.78rem;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
    }
    .pending-info strong{
        color:#0f172a;
        font-size:.96rem;
        line-height:1.48;
    }
    .pending-actions{
        display:flex;
        justify-content:center;
        gap:14px;
        margin-top:22px;
        flex-wrap:wrap;
    }
    .pending-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:174px;
        min-height:48px;
        padding:11px 20px;
        border-radius:18px;
        font-weight:800;
        text-decoration:none;
        border:1px solid #d1d9ea;
        background:#fff;
        color:#334155;
        transition:transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    .pending-btn:hover{
        transform:translateY(-1px);
        box-shadow:0 16px 26px rgba(15,23,42,.08);
    }
    .pending-btn.primary{
        border-color:#1842b8;
        background:linear-gradient(135deg,#4ea3ff 0%,#1842b8 100%);
        color:#fff;
        box-shadow:0 18px 30px rgba(24,66,184,.18);
    }
    @media (max-width: 720px){
        .pending-shell{
            padding:16px 12px;
        }
        .pending-card{
            padding:24px 18px 20px;
            border-radius:26px;
        }
        .pending-grid{
            grid-template-columns:1fr;
        }
        .pending-actions{
            flex-direction:column;
        }
        .pending-btn{
            width:100%;
        }
    }
</style>

<div class="pending-shell">
    <div class="pending-card">
        <div class="pending-kicker">
            <i class="fas fa-shield-check"></i>
            Account authenticated
        </div>
        <div class="pending-icon"><i class="fas fa-user-clock"></i></div>
        <h1 class="pending-title">Pending Approval</h1>
        <p class="pending-copy">
            Your account has been authenticated and your profile has been submitted successfully.
            Please wait for the administrator to review your account and assign the correct office role before you can access Training Management.
        </p>
        <div class="pending-status-wrap">
            <div class="pending-status"><i class="fas fa-hourglass-half"></i> Status: Pending</div>
        </div>

        @if(session('success_pending_approval'))
            <div class="pending-note">{{ session('success_pending_approval') }}</div>
        @endif

        <div class="pending-grid">
            <div class="pending-info">
                <span>Current Stage</span>
                <strong>Your profile is now waiting in the admin review queue for validation and office assignment.</strong>
            </div>
            <div class="pending-info">
                <span>Next Access</span>
                <strong>Training Management access will be enabled only after approval and office role assignment.</strong>
            </div>
        </div>

        <div class="pending-actions">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="pending-btn primary">Back to Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
