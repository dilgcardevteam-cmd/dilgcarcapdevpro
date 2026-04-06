<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class AcademicYear extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'year_start',
        'year_end',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the courses for the academic year.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
