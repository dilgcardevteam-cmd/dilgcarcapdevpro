<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'type',
        'description',
        'due_date',
        'questions_json',
        'passing_score',
        'max_attempts',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'questions_json' => 'array',
        'passing_score' => 'integer',
        'max_attempts' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
