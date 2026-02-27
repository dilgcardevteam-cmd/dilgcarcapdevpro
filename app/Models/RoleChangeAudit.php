<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleChangeAudit extends Model
{
    protected $fillable = [
        'user_id',
        'actor_id',
        'from_role',
        'to_role',
        'meta_json',
    ];
}
