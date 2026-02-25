<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_announcement_id',
        'user_id',
        'body',
    ];

    public function announcement()
    {
        return $this->belongsTo(ClassAnnouncement::class, 'class_announcement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
