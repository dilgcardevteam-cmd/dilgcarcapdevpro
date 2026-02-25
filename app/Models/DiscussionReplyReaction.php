<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscussionReplyReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_reply_id',
        'user_id',
        'type', // like | dislike
    ];

    public function reply()
    {
        return $this->belongsTo(DiscussionReply::class, 'discussion_reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
