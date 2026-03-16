<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'subject_area',
        'video_url',
        'image_path',
        'modules',
        'video_path',
        'is_published',
        'enrollment_start_at',
        'enrollment_end_at',
        'trainer_id',
        'start_date',
        'end_date',
        'trainer_ready',
        'enrollment_start',
        'enrollment_end',
    ];

    protected $casts = [
        'modules' => 'array',
        'is_published' => 'boolean',
        'enrollment_start_at' => 'date',
        'enrollment_end_at' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'trainer_ready' => 'boolean',
        'enrollment_start' => 'datetime',
        'enrollment_end' => 'datetime',
    ];

    /**
     * Check if the course is currently enrollable.
     */
    public function isEnrollable()
    {
        if (!$this->is_published) {
            return false;
        }

        // If trainer hasn't set their schedule yet, we fallback to Registrar's schedule if available,
        // or just check trainer_ready flag based on your new double-gated requirement.
        if (!$this->trainer_ready) {
            return false;
        }

        $now = now();
        
        // Use the enrollment dates set by Registrar (which are saved in enrollment_start/end via the new method)
        if ($this->enrollment_start && $now->lt($this->enrollment_start)) {
            return false;
        }

        if ($this->enrollment_end && $now->gt($this->enrollment_end)) {
            return false;
        }

        return true;
    }

    /**
     * Get the trainer/creator of the course.
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Get the dynamic status of the course based on its duration.
     */
    public function getCourseStatusAttribute()
    {
        $now = now()->startOfDay();
        
        if (!$this->start_date || !$this->end_date) {
            return 'Schedule not set';
        }

        if ($now->lt($this->start_date)) {
            return 'Upcoming';
        }

        if ($now->gte($this->start_date) && $now->lte($this->end_date)) {
            return 'Ongoing';
        }

        if ($now->gt($this->end_date)) {
            return 'Completed';
        }

        return 'Unknown';
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot('status')->withTimestamps();
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function getCourseProgress(User $user)
    {
        $totalAssessments = $this->assessments()->count();
        if ($totalAssessments === 0) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
            ];
        }

        $gradedAssessments = 0;
        foreach ($this->assessments as $assessment) {
            if ($assessment->grades()->where('user_id', $user->id)->exists()) {
                $gradedAssessments++;
            }
        }

        return [
            'completed' => $gradedAssessments,
            'total' => $totalAssessments,
            'percentage' => ($gradedAssessments / $totalAssessments) * 100,
        ];
    }
}
