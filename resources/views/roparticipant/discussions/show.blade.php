<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion</title>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root{--blue:#002C76;--muted:#6b7280;--border:#e5e7eb;--bg:#f4f6f9}
        body{margin:0;background:var(--bg);font-family:'DM Sans',sans-serif;color:#0f172a}
        .wrap{max-width:960px;margin:22px auto;padding:0 16px}
        .card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:16px;box-shadow:0 10px 24px rgba(15,23,42,.06)}
        .title{margin:0 0 8px;font-weight:800;color:var(--blue)}
        .muted{color:#64748b}
        .comment{display:flex;gap:10px;padding:12px 0;border-bottom:1px dashed var(--border)}
        .comment:last-child{border-bottom:none}
        .ava{width:36px;height:36px;border-radius:50%;background:#e0e7ff;display:flex;align-items:center;justify-content:center;color:#1e3a8a;font-weight:800}
        .new-comment{display:flex;gap:10px;margin-top:10px}
        .new-comment textarea{flex:1;min-height:80px;border:1px solid var(--border);border-radius:12px;padding:10px}
        .btn{border:none;border-radius:12px;padding:12px 16px;font-weight:700;cursor:pointer}
        .btn-blue{background:#0f3b8f;color:#fff}
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1 class="title">{{ $discussion->title }}</h1>
        <div class="muted" style="margin-bottom:8px">By {{ $discussion->user->name ?? 'User' }} • {{ $discussion->created_at->diffForHumans() }}</div>
        <div style="white-space:pre-line;margin:10px 0 16px">{{ $discussion->body }}</div>
        <div style="display:flex;gap:14px;align-items:center;margin-bottom:10px">
            <span><i class="fas fa-thumbs-up"></i> {{ $discussionLikes }}</span>
            <span><i class="fas fa-thumbs-down"></i> {{ $discussionDislikes }}</span>
            <span><i class="fas fa-comments"></i> {{ $commentsCount }}</span>
        </div>
        <hr style="border:none;border-top:1px solid var(--border);margin:10px 0">
        @php
            $replies = $discussion->replies()->whereNull('deleted_at')->with('user')->orderBy('created_at','asc')->get();
        @endphp
        <div id="comments">
            @forelse($replies as $r)
                <div class="comment">
                    <div class="ava">{{ strtoupper(mb_substr($r->user->name ?? 'U',0,1)) }}</div>
                    <div>
                        <div style="font-weight:700">{{ $r->user->name ?? 'User' }} <span class="muted" style="font-weight:400">• {{ $r->created_at->diffForHumans() }}</span></div>
                        <div style="white-space:pre-line">{{ $r->body }}</div>
                    </div>
                </div>
            @empty
                <div class="muted">No comments yet.</div>
            @endforelse
        </div>
        <form class="new-comment" method="POST" action="{{ route('discussions.reply', $discussion) }}">
            @csrf
            <textarea name="body" placeholder="Write a comment…"></textarea>
            <button class="btn btn-blue" type="submit">Post</button>
        </form>
    </div>
</div>
</body>
</html>



