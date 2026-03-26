<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'assessment_id',
        'user_id',
        'score',
        'feedback',
        'attempt_no',
        'is_retake',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'attempt_no' => 'integer',
        'is_retake' => 'boolean',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
