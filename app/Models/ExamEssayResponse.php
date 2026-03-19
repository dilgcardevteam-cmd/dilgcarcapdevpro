<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamEssayResponse extends Model
{
    protected $fillable = [
        'course_id',
        'trainee_id',
        'module_index',
        'question_index',
        'question_text',
        'answer_text',
        'max_points',
        'score',
        'feedback',
        'checked_by_trainer',
        'checked_at',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
        'max_points' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by_trainer');
    }
}
