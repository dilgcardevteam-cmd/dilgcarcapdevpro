<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateGenerationAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_source',
        'recipient_name',
        'course_name',
        'certificate_number',
        'issued_at',
        'generated_by',
    ];
}

