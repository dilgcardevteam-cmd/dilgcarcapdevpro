<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\DiscussionReplyReaction;
use App\Models\DeletionAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class DiscussionController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|min:5|max:200',
            'body' => 'required|string|min:10',
            'image' => 'nullable|image|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('discussion_images', 'public');
        }
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'body' => $data['body'],
            'image_path' => $imagePath,
        ]);

        $isTrainerCtx = $request->boolean('as_trainer') || (auth()->check() && (auth()->user()->role ?? '') === 'trainer');
        $params = ['discussion' => $discussion];
        if ($isTrainerCtx) { $params['ctx'] = 'trainer'; }
        $redirect = route('discussions.show', $params);
        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'discussion' => $discussion->only(['id','title','body','created_at']),
                'redirect' => $redirect,
            ]);
        }
        return redirect($redirect)->with('success', 'Discussion created.');
    }

    public function show(Discussion $discussion)
    {
        $relations = ['user','course','replies.user','replies.children.user'];
        if (Schema::hasTable('discussion_reply_reactions')) {
            $relations[] = 'replies.reactions';
            $relations[] = 'replies.children.reactions';
        }
        $discussion->load($relations);
        $hasTable = Schema::hasTable('discussion_reactions');
        $likes = 0;
        $dislikes = 0;
        if ($hasTable) {
            $likes = \App\Models\DiscussionReaction::where('discussion_id',$discussion->id)->where('type','like')->count();
            $dislikes = \App\Models\DiscussionReaction::where('discussion_id',$discussion->id)->where('type','dislike')->count();
        }
        $commentsCount = \App\Models\DiscussionReply::where('discussion_id', $discussion->id)
            ->whereNull('parent_id')
            ->whereNull('deleted_at')
            ->count();
        $userReact = null;
        if ($hasTable && auth()->check()) {
            $userReact = \App\Models\DiscussionReaction::where('discussion_id',$discussion->id)
                ->where('user_id', auth()->id())
                ->value('type');
        }
        return view('trainee.discussions.show', [
            'discussion' => $discussion,
            'discussionLikes' => $likes,
            'discussionDislikes' => $dislikes,
            'userDiscussionReaction' => $userReact,
            'commentsCount' => $commentsCount,
        ]);
    }

    public function reply(Request $request, Discussion $discussion)
    {
        $data = $request->validate([
            'body' => 'required|string|min:1',
            'parent_id' => 'nullable|exists:discussion_replies,id',
        ]);
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'body' => $data['body'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);
        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'reply' => $reply->only(['id','body','created_at']),
            ]);
        }
        return back()->with('success', 'Reply posted.');
    }

    public function react(Request $request, DiscussionReply $reply)
    {
        $data = $request->validate([
            'type' => 'required|in:like,dislike',
        ]);
        $existing = DiscussionReplyReaction::where('discussion_reply_id', $reply->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($existing && $existing->type === $data['type']) {
            $existing->delete();
        } else {
            DiscussionReplyReaction::updateOrCreate(
                ['discussion_reply_id'=>$reply->id,'user_id'=>auth()->id()],
                ['type'=>$data['type']]
            );
        }
        $likes = DiscussionReplyReaction::where('discussion_reply_id',$reply->id)->where('type','like')->count();
        $dislikes = DiscussionReplyReaction::where('discussion_reply_id',$reply->id)->where('type','dislike')->count();
        return response()->json(['ok'=>true,'likes'=>$likes,'dislikes'=>$dislikes]);
    }

    public function reactDiscussion(Request $request, Discussion $discussion)
    {
        $data = $request->validate([
            'type' => 'required|in:like,dislike',
        ]);
        if (!Schema::hasTable('discussion_reactions')) {
            return response()->json(['ok'=>true,'likes'=>0,'dislikes'=>0,'message'=>'Reactions unavailable'], 200);
        }
        $user = auth()->user();
        if (!$user) {
            return response()->json(['ok'=>false,'message'=>'Unauthorized'], 401);
        }
        $existing = \App\Models\DiscussionReaction::where('discussion_id', $discussion->id)
            ->where('user_id', $user->id)
            ->first();
        if ($existing && $existing->type === $data['type']) {
            $existing->delete();
        } else {
            \App\Models\DiscussionReaction::updateOrCreate(
                ['discussion_id'=>$discussion->id,'user_id'=>$user->id],
                ['type'=>$data['type']]
            );
        }
        $likes = \App\Models\DiscussionReaction::where('discussion_id',$discussion->id)->where('type','like')->count();
        $dislikes = \App\Models\DiscussionReaction::where('discussion_id',$discussion->id)->where('type','dislike')->count();
        return response()->json(['ok'=>true,'likes'=>$likes,'dislikes'=>$dislikes]);
    }

    public function destroy(DiscussionReply $reply, Request $request)
    {
        $user = auth()->user();
        if (!$user || ($user->id !== $reply->user_id)) {
            if ($request->wantsJson()) {
                return response()->json(['ok'=>false,'message'=>'You can only delete your own reply.'], 403);
            }
            abort(403);
        }
        $reply->delete();
        DeletionAudit::create([
            'course_id' => optional($reply->discussion)->course_id,
            'actor_id' => $user->id,
            'entity_type' => 'reply',
            'entity_id' => $reply->id,
            'action' => 'soft_delete',
            'meta_json' => null,
        ]);
        if ($request->wantsJson()) {
            return response()->json(['ok'=>true]);
        }
        return back()->with('success','Reply deleted.');
    }

    public function destroyDiscussion(Discussion $discussion, Request $request)
    {
        $user = auth()->user();
        if (!$user || ($user->id !== $discussion->user_id)) {
            if ($request->wantsJson()) {
                return response()->json(['ok'=>false,'message'=>'You can only delete your own discussion.'], 403);
            }
            abort(403);
        }
        // Soft delete only; keep media so the entry can remain visible in forum
        $discussion->delete();
        DeletionAudit::create([
            'course_id' => $discussion->course_id,
            'actor_id' => $user->id,
            'entity_type' => 'discussion',
            'entity_id' => $discussion->id,
            'action' => 'soft_delete',
            'meta_json' => null,
        ]);
        if ($request->wantsJson()) {
            return response()->json(['ok'=>true]);
        }
        return back()->with('success','Discussion deleted.');
    }

    public function forceDestroyDiscussion(Discussion $discussion, Request $request)
    {
        $user = auth()->user();
        if (!$user || ($user->role ?? '') !== 'admin') {
            if ($request->wantsJson()) {
                return response()->json(['ok'=>false,'message'=>'Only admins can permanently delete discussions.'], 403);
            }
            abort(403);
        }
        // Remove related replies and reactions
        DiscussionReply::withTrashed()->where('discussion_id', $discussion->id)->each(function($r){
            \App\Models\DiscussionReplyReaction::where('discussion_reply_id', $r->id)->delete();
            $r->forceDelete();
        });
        if (!empty($discussion->image_path)) {
            Storage::disk('public')->delete($discussion->image_path);
        }
        $discussion->forceDelete();
        DeletionAudit::create([
            'course_id' => $discussion->course_id,
            'actor_id' => $user->id,
            'entity_type' => 'discussion',
            'entity_id' => $discussion->id,
            'action' => 'force_delete',
            'meta_json' => null,
        ]);
        return $request->wantsJson() ? response()->json(['ok'=>true]) : back()->with('success','Discussion permanently deleted.');
    }

    public function updates(Request $request, \App\Models\Course $course)
    {
        $since = $request->query('since');
        $q = DeletionAudit::where('course_id', $course->id)->orderBy('id','asc');
        if ($since) {
            $q->where('created_at','>', $since);
        }
        $rows = $q->limit(100)->get(['id','entity_type','entity_id','action','created_at']);
        $payload = [
            'discussions_soft_deleted' => $rows->where('entity_type','discussion')->where('action','soft_delete')->pluck('entity_id')->unique()->values(),
            'discussions_force_deleted' => $rows->where('entity_type','discussion')->where('action','force_delete')->pluck('entity_id')->unique()->values(),
            'replies_soft_deleted' => $rows->where('entity_type','reply')->where('action','soft_delete')->pluck('entity_id')->unique()->values(),
            'since' => optional($rows->last())->created_at?->toISOString(),
        ];
        return response()->json($payload);
    }
}
