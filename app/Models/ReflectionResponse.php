<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReflectionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'module_index',
        'topic_index',
        'sub_index',
        'questions_json',
        'answers_json',
    ];

    protected $casts = [
        'questions_json' => 'array',
        'answers_json' => 'array',
    ];
}

