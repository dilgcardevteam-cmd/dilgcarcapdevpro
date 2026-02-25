<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentTemplate extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'description',
        'questions_json',
    ];

    protected $casts = [
        'questions_json' => 'array',
    ];
}
