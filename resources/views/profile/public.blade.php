<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} · Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root{--border:#e5e7eb;--muted:#64748b}
        body{margin:0;background:#f4f6f9;color:#0f172a;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,'DM Sans',sans-serif}
        .card{background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 24px rgba(15,23,42,.06);padding:16px;margin:16px auto;max-width:800px}
        .head{display:flex;align-items:center;gap:16px}
        .avatar{width:84px;height:84px;border-radius:50%;object-fit:cover;border:3px solid #0f3b8f}
        .name{font-weight:800;font-size:1.2rem}
        .meta{color:var(--muted)}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px}
        .cell{padding:10px;border:1px dashed var(--border);border-radius:10px;background:#fafafa}
        .cell .label{font-size:.85rem;color:var(--muted);margin-bottom:4px}
    </style>
    </head>
<body>
    <div class="card">
        <div class="head">
            <img class="avatar" src="{{ $user->avatar_url }}" alt="Avatar" onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}'">
            <div>
                <div class="name">{{ $user->name }}</div>
                <div class="meta">{{ ucfirst($user->role ?? 'user') }}</div>
            </div>
        </div>
        <div class="grid">
            <div class="cell">
                <div class="label">Email</div>
                <div>{{ $user->email }}</div>
            </div>
            <div class="cell">
                <div class="label">Location</div>
                <div>{{ trim(($user->city ?? '').(($user->city && $user->province)?', ':'').($user->province ?? '')) ?: '-' }}</div>
            </div>
            <div class="cell">
                <div class="label">Joined</div>
                <div>{{ \Carbon\Carbon::parse($user->created_at)->format('M j, Y') }}</div>
            </div>
            <div class="cell">
                <div class="label">Account ID</div>
                <div>{{ $user->account_id ?? '-' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
