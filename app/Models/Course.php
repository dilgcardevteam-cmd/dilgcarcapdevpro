<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'subject_area',
        'academic_year',
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
        'certification_id',
        'course_type',
        'access_code',
        'academic_year_id',
    ];

    /**
     * Get the academic year for the course.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

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
        $pivotColumns = ['status'];
        if (Schema::hasColumn('course_user', 'current_module')) {
            $pivotColumns[] = 'current_module';
        }
        if (Schema::hasColumn('course_user', 'progress_percentage')) {
            $pivotColumns[] = 'progress_percentage';
        }
        if (Schema::hasColumn('course_user', 'retake_requested')) {
            $pivotColumns[] = 'retake_requested';
        }
        if (Schema::hasColumn('course_user', 'retake_approved')) {
            $pivotColumns[] = 'retake_approved';
        }

        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot($pivotColumns)
            ->withTimestamps();
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
        $gradedAssessments = 0;
        foreach ($this->assessments as $assessment) {
            $latestGrade = $assessment->grades()
                ->where('user_id', $user->id)
                ->orderBy('score', 'desc') // Check highest score
                ->first();
            
            if ($latestGrade) {
                $passingScore = $assessment->passing_score ?? 70; // default 70 if not set
                if ($latestGrade->score >= $passingScore) {
                    $gradedAssessments++;
                }
            }
        }

        // Also calculate topic completion from ReflectionResponses
        $mods = is_array($this->modules) ? $this->modules : [];
        $reflectionRows = \App\Models\ReflectionResponse::where('user_id', $user->id)
            ->where('course_id', $this->id)
            ->get(['module_index', 'topic_index', 'answers_json']);
        
        $topicDoneSet = [];
        foreach ($reflectionRows as $r) {
            $answers = is_array($r->answers_json) ? $r->answers_json : [];
            $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                ? trim($answers['learned'])
                : '';
            if ($val === '') continue;
            $topicDoneSet["{$r->module_index}_{$r->topic_index}"] = true;
        }

        $totalTopics = 0;
        $doneTopics = 0;
        foreach ($mods as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $totalTopics += count($topics);
            foreach ($topics as $ti => $_t) {
                if (!empty($topicDoneSet["{$mi}_{$ti}"])) {
                    $doneTopics++;
                }
            }
        }

        $totalItems = $totalAssessments + $totalTopics;
        $completedItems = $gradedAssessments + $doneTopics;

        if ($totalItems === 0) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
                'topics_completed' => 0,
                'topics_total' => 0,
                'assessments_completed' => 0,
                'assessments_total' => 0,
            ];
        }

        return [
            'completed' => $completedItems,
            'total' => $totalItems,
            'percentage' => ($completedItems / $totalItems) * 100,
            'topics_completed' => $doneTopics,
            'topics_total' => $totalTopics,
            'assessments_completed' => $gradedAssessments,
            'assessments_total' => $totalAssessments,
        ];
    }
}
