<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $discussion->title }} · Discussion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root{--brand:#0d6efd;--muted:#64748b;--border:#e5e7eb;--bg:#f4f6f9}
        body{margin:0;background:var(--bg);color:#0f172a;font-family:'DM Sans', sans-serif}
        :root{--app-sidebar-w:250px;--app-header-h:80px}
        .with-app-side{padding-left:var(--app-sidebar-w)}
        .app-side{position:fixed;left:0;top:var(--app-header-h);bottom:0;width:var(--app-sidebar-w);background:#002C76;color:#fff;z-index:25;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,.12)}
        .app-side .app-side-header{display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.12)}
        .app-side .app-initial{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.25);font-weight:800}
        .app-side a{color:rgba(255,255,255,.9);text-decoration:none;display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid rgba(255,255,255,.06)}
        .app-side a:hover{background:rgba(255,255,255,.08)}
        @media (max-width: 900px){ .with-app-side{padding-left:0}.app-side{display:none} }
        .app-header{background:#fff;min-height:80px;padding:10px 20px;box-shadow:0 2px 4px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:20}
        .app-header-left{display:flex;align-items:center;gap:12px}
        .app-header-logo{height:48px}
        .app-header-right a{color:#1a1a1a;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:6px}
        .page{max-width:960px;margin:20px auto;padding:0 16px}
        .card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:20px;box-shadow:0 10px 24px rgba(17,24,39,.06);animation:slideUp .35s ease both}
        .muted{color:var(--muted)}
        .btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
        .btn-blue{background:var(--brand);color:#fff}
        .btn-disabled{background:#e5e7eb;color:#9aa4b2;cursor:not-allowed}
        .cm{display:flex;gap:12px;align-items:flex-start;padding:14px 0;border-bottom:1px dashed var(--border);animation:fadeIn .25s ease both}
        .cm:last-child{border-bottom:none}
        .cm-avatar{width:36px;height:36px;border-radius:50%;background:#eef2ff;color:#0f3b8f;display:flex;align-items:center;justify-content:center;font-weight:800;flex:0 0 36px}
        .cm-body{flex:1}
        .cm-head{display:flex;align-items:center;gap:8px}
        .cm-name{font-weight:800}
        .cm-time{color:var(--muted);font-size:.85rem}
        .cm-text{margin:6px 0;white-space:pre-wrap}
        .cm-actions{display:flex;gap:10px;align-items:center}
        .cm-children{margin-left:22px;border-left:2px solid var(--border);padding-left:14px}
        textarea{width:100%;min-height:120px;border:1px solid var(--border);border-radius:12px;padding:12px;resize:vertical;background:#fff}
        textarea:focus{outline:2px solid rgba(13,110,253,.25);outline-offset:2px}
        .topic-title{font-size:1.9rem;font-weight:900;letter-spacing:-0.02em}
        .topic-meta{color:var(--muted);margin:6px 0}
        .reply-author{font-weight:700}
        .back-link{color:#0f3b8f;text-decoration:none;display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border:1px solid #cfe0ff;border-radius:999px;background:#e8f0ff;font-weight:800;transition:transform .15s ease, box-shadow .2s ease}
        .back-link:hover{transform:translateY(-1px);box-shadow:0 10px 20px rgba(15,59,143,.12)}
        .counter{font-size:.85rem;color:var(--muted)}
        .chip-action{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:8px 12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:transform .15s ease, box-shadow .2s ease}
        .chip-action:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(15,59,143,.12)}
        .chip-action.pulse{animation:pop .25s ease}
        @keyframes slideUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:.0}to{opacity:1}}
        @keyframes pop{0%{transform:scale(1)}50%{transform:scale(1.06)}100%{transform:scale(1)}}
        .chip-action{background:#e8f0ff;color:#0f3b8f;border:1px solid #cfe0ff;border-radius:999px;padding:6px 10px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
        .link-action{color:#0f3b8f;text-decoration:none;font-weight:600}
    </style>
</head>
<body>
    @php
            $ctx = request()->query('ctx');
            $isTrainer = (auth()->user()->role ?? '') === 'trainer';
            $backUrl = ($ctx === 'trainer' || $isTrainer)
                ? route('trainer.courses.enter', $discussion->course)
                : route('trainee.courses.show', $discussion->course);
    @endphp
    <div class="app-header">
        <div class="app-header-left">
            <img class="app-header-logo" src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro" onerror="this.style.display='none'">
            <div style="font-weight:800;color:#0f172a">{{ $discussion->course->name }}</div>
        </div>
        <div class="app-header-right">
            <a href="{{ $backUrl }}" class="back-link">Back to Classroom <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    @php
        $baseUrl = ($ctx === 'trainer' || $isTrainer)
            ? route('trainer.courses.enter', $discussion->course)
            : route('trainee.courses.show', $discussion->course);
    @endphp
    <div class="app-side" aria-label="Sidebar">
        <div class="app-side-header">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover">
            <div style="font-weight:700">{{ auth()->user()->name ?? 'User' }}</div>
        </div>
        <a href="{{ $baseUrl }}?tab=stream"><i class="fas fa-rss"></i> <span>Stream</span></a>
        <a href="{{ $baseUrl }}?tab=classwork"><i class="fas fa-tasks"></i> <span>Classwork</span></a>
        <a href="{{ $baseUrl }}?tab=forum"><i class="fas fa-comments"></i> <span>Forum</span></a>
        <a href="{{ $baseUrl }}?tab=people"><i class="fas fa-users"></i> <span>People</span></a>
        <a href="{{ $baseUrl }}?tab=grades"><i class="fas fa-clipboard-check"></i> <span>Grades</span></a>
    </div>
    <div class="with-app-side">
    <div class="page">
        @php
            $ctx = request()->query('ctx');
            $isTrainer = (auth()->user()->role ?? '') === 'trainer';
            $forumUrl = ($ctx === 'trainer' || $isTrainer)
                ? route('trainer.courses.enter', $discussion->course).'?tab=forum'
                : route('trainee.courses.show', $discussion->course).'?tab=forum';
        @endphp
        <div style="margin-bottom:12px">
            <a href="{{ $forumUrl }}" class="back-link"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card" style="margin-bottom:12px;">
            <div class="topic-title">{{ $discussion->title }}</div>
            <div class="topic-meta">
                {{ \Carbon\Carbon::parse($discussion->created_at)->format('M j, g:i A') }} by
                <a href="{{ route('users.profile', $discussion->user) }}" style="color:#0f3b8f;text-decoration:none">{{ $discussion->user->name ?? 'User' }}</a>
            </div>
            @php $isUrlBody = filter_var(($discussion->body ?? ''), FILTER_VALIDATE_URL); @endphp
            <div style="margin-top:8px;white-space:pre-wrap">
                @if($isUrlBody)
                    <a href="{{ $discussion->body }}" target="_blank" rel="noopener" style="color:#0f3b8f;text-decoration:underline">{{ $discussion->body }}</a>
                @else
                    {{ $discussion->body }}
                @endif
            </div>
            @if(!empty($discussion->image_path))
            <div style="margin-top:12px">
                <img src="{{ asset('storage/'.$discussion->image_path) }}" alt="Discussion image" style="max-width:100%;height:auto;max-height:520px;display:block;margin:0 auto;border-radius:12px;border:1px solid var(--border);object-fit:contain">
            </div>
            @endif
            <div style="display:flex;gap:12px;align-items:center;margin-top:12px">
                <button id="btnDLike" type="button" class="chip-action" onclick="reactDiscussion('{{ route('discussions.react',$discussion) }}','like','dLike','dDislike','btnDLike')"><i class="fas fa-thumbs-up"></i> <span id="dLike">{{ $discussionLikes ?? 0 }}</span></button>
                <button id="btnDDislike" type="button" class="chip-action" onclick="reactDiscussion('{{ route('discussions.react',$discussion) }}','dislike','dLike','dDislike','btnDDislike')"><i class="fas fa-thumbs-down"></i> <span id="dDislike">{{ $discussionDislikes ?? 0 }}</span></button>
                <div class="muted">{{ $commentsCount ?? ($discussion->replies->count() ?? 0) }} comments</div>
            </div>
        </div>
        <div class="card" style="margin-bottom:12px;">
            <div style="font-weight:800;margin-bottom:8px">Comments</div>
            @php
                $render = function($items, $level = 0) use (&$render, $discussion){
                    foreach($items as $r){
                        if(method_exists($r,'trashed') && $r->trashed()){ continue; }
                        $n = $r->user->name ?? 'User';
                        $avatar = $r->user ? $r->user->avatar_url : asset('images/user.png');
                        $likes = ($r->reactions ?? collect())->where('type','like')->count();
                        $dislikes = ($r->reactions ?? collect())->where('type','dislike')->count();
                        $canDelete = auth()->check() && (auth()->id() === ($r->user_id ?? 0));
                        echo '<div class="cm">';
                        echo '<img class="cm-avatar" src="'.e($avatar).'" alt="Avatar" onerror="this.onerror=null;this.src=\''.asset('images/user.png').'\'">';
                        echo '<div class="cm-body">';
                        echo '<div class="cm-head"><div class="cm-name"><a href="'.route('users.profile', $r->user).'">'.e($n).'</a></div><div class="cm-time">'.e(\Carbon\Carbon::parse($r->created_at)->diffForHumans()).'</div></div>';
                        echo '<div class="cm-text">'.e($r->body).'</div>';
                        echo '<div class="cm-actions">';
                        echo '<button type="button" class="chip-action" onclick="reactReply('.$r->id.',\'like\',\'lk'.$r->id.'\',\'dk'.$r->id.'\')"><i class="fas fa-thumbs-up"></i> <span id="lk'.$r->id.'">'.$likes.'</span></button>';
                        echo '<button type="button" class="chip-action" onclick="reactReply('.$r->id.',\'dislike\',\'lk'.$r->id.'\',\'dk'.$r->id.'\')"><i class="fas fa-thumbs-down"></i> <span id="dk'.$r->id.'">'.$dislikes.'</span></button>';
                        echo '<a href="javascript:void(0)" class="link-action" onclick="toggleReplyForm(\'rf'.$r->id.'\')">Reply</a>';
                        if($canDelete){ echo '<a href=\"javascript:void(0)\" class=\"link-action\" onclick=\"deleteReply('.$r->id.')\">Delete</a>'; }
                        echo '</div>';
                        echo '<form id="rf'.$r->id.'" action="'.route('discussions.replies.store',$discussion).'" method="POST" onsubmit="return postChildReply(event, '.$discussion->id.', '.$r->id.', \'ta'.$r->id.'\')" style="display:none;margin-top:8px">';
                        echo csrf_field();
                        echo '<textarea id="ta'.$r->id.'" name="body" rows="2" placeholder="Write a reply..." style="width:100%;border:1px solid var(--border);border-radius:10px;padding:8px"></textarea>';
                        echo '<input type="hidden" name="parent_id" value="'.$r->id.'">';
                        echo '<div style="display:flex;justify-content:flex-end;gap:8px;margin-top:6px"><button type="button" class="btn" onclick="toggleReplyForm(\'rf'.$r->id.'\')">Cancel</button><button type="submit" class="btn btn-blue">Reply</button></div>';
                        echo '</form>';
                        if(($r->children ?? collect())->isNotEmpty()){
                            echo '<div class="cm-children">';
                            $render($r->children, $level+1);
                            echo '</div>';
                        }
                        echo '</div></div>';
                    }
                };
                $top = ($discussion->replies ?? collect())->where('parent_id', null);
                $visibleTop = $top->filter(function($r){
                    return !(method_exists($r,'trashed') && $r->trashed());
                });
            @endphp
            @if(($visibleTop ?? collect())->isEmpty())
                <div class="muted">No comments yet.</div>
            @else
                {!! $render($visibleTop, 0) !!}
            @endif
            <form action="{{ route('discussions.replies.store', $discussion) }}" method="POST" style="margin-top:12px;">
                @csrf
                <label for="replyBody" class="muted" style="display:block;margin-bottom:4px;">Write a comment</label>
                <textarea id="replyBody" name="body" placeholder="Type your comment..." oninput="syncReplyState()"></textarea>
                <div class="counter" id="replyCount" aria-live="polite">0 chars</div>
                <div style="margin-top:8px;display:flex;justify-content:flex-end;gap:8px">
                    <button id="replySubmit" class="btn btn-disabled" type="submit" disabled>Post Comment</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script>
        const csrf = '{{ csrf_token() }}';
        function toggleReplyForm(id){
            var f=document.getElementById(id);
            if(!f) return false;
            f.style.display = (f.style.display==='none'||f.style.display==='') ? 'block' : 'none';
            return false;
        }
        function reactReply(replyId, type, likeId, dislikeId){
            fetch('{{ url('/replies') }}/'+replyId+'/react', {
                method:'POST',
                headers:{'X-CSRF-TOKEN': csrf,'Accept':'application/json','Content-Type':'application/json'},
                body: JSON.stringify({type})
            }).then(function(r){ return r.json(); }).then(function(j){
                if(j && j.ok){
                    var lk=document.getElementById(likeId);
                    var dk=document.getElementById(dislikeId);
                    if(lk) lk.textContent = j.likes;
                    if(dk) dk.textContent = j.dislikes;
                }
            }).catch(function(){});
        }
        function deleteReply(replyId){
            if(!confirm('Delete this reply?')) return;
            fetch('{{ url('/replies') }}/'+replyId, {
                method:'DELETE',
                headers:{'X-CSRF-TOKEN': csrf,'Accept':'application/json'}
            }).then(function(r){
                if(r.ok){ window.location.reload(); }
            }).catch(function(){});
        }
        function postChildReply(ev, discussionId, parentId, taId){
            ev.preventDefault();
            var ta=document.getElementById(taId);
            if(!ta || !ta.value.trim()) return false;
            var fd = new FormData(ev.target);
            fetch('{{ route('discussions.replies.store',$discussion) }}', {
                method:'POST',
                headers:{'X-CSRF-TOKEN': csrf},
                body: fd
            }).then(function(r){
                if(r.ok){ window.location.reload(); }
            }).catch(function(){});
            return false;
        }
        function reactDiscussion(url, type, likeId, dislikeId, btnId){
            fetch(url, {
                method:'POST',
                headers:{'X-CSRF-TOKEN': csrf,'Accept':'application/json','Content-Type':'application/json'},
                body: JSON.stringify({type})
            }).then(function(r){ return r.json(); }).then(function(j){
                if(j && j.ok){
                    var lk=document.getElementById(likeId);
                    var dk=document.getElementById(dislikeId);
                    if(lk) lk.textContent = j.likes;
                    if(dk) dk.textContent = j.dislikes;
                    if(btnId){ var b=document.getElementById(btnId); if(b){ b.classList.remove('pulse'); void b.offsetWidth; b.classList.add('pulse'); } }
                }
            }).catch(function(){});
        }
        function syncReplyState(){
            var t=document.getElementById('replyBody');
            var c=document.getElementById('replyCount');
            var b=document.getElementById('replySubmit');
            var n=t? t.value.length : 0;
            if(c){ c.textContent = n+' chars'; }
            var valid = n>=1;
            if(b){
                b.disabled = !valid;
                b.classList.toggle('btn-blue', valid);
                b.classList.toggle('btn-disabled', !valid);
            }
        }
        document.addEventListener('DOMContentLoaded', syncReplyState);
    </script>
</body>
</html>
