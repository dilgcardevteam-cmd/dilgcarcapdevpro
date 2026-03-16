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
    ];

    protected $casts = [
        'modules' => 'array',
        'is_published' => 'boolean',
        'enrollment_start_at' => 'date',
        'enrollment_end_at' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

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
}
