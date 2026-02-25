<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeletionAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'actor_id',
        'entity_type',   // discussion|reply
        'entity_id',
        'action',        // soft_delete|force_delete
        'meta_json',
    ];
}
