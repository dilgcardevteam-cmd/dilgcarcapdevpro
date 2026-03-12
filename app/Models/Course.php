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
    ];

    protected $casts = [
        'modules' => 'array',
        'is_published' => 'boolean',
    ];

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
