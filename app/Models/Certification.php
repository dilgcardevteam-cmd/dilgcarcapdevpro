<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'file_path',
        'display_on_landing_page',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'certification_user')
            ->withPivot('certificate_number','course_id','issued_at')
            ->withTimestamps();
    }
}
