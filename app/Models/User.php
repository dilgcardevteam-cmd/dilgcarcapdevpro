<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'account_id',
        'mobile_number',
        'gender',
        'google_id',
        'password',
        'region',
        'province',
        'city',
        'barangay',
        'date_of_birth',
        'role',
        'status',
        'job_title',
        'profile_picture',
        'additional_details',
        'description',
        'display_type',
        'profile_completed',
        'profile_completed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'profile_completed' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function (User $user) {
            if (empty($user->account_id) && Schema::hasColumn('users', 'account_id')) {
                $user->account_id = self::generateAccountId();
            }
        });
    }

    public static function generateAccountId(): string
    {
        if (!Schema::hasColumn('users', 'account_id')) {
            // Fallback format if migration isn't applied yet (won't be saved due to guard above)
            return now()->format('y') . '-0000-001';
        }
        $yy = now()->format('y');
        $latest = self::where('account_id', 'like', $yy . '-%')
            ->orderBy('account_id', 'desc')
            ->value('account_id');

        $nextNum = 1;
        if ($latest && preg_match('/^\d{2}-(\d{4})-(\d{3})$/', $latest, $m)) {
            $current = intval($m[1] . $m[2]);
            $nextNum = $current + 1;
        }
        $lead4 = str_pad((string) intdiv($nextNum, 1000), 4, '0', STR_PAD_LEFT);
        $tail3 = str_pad((string) ($nextNum % 1000), 3, '0', STR_PAD_LEFT);
        return $yy . '-' . $lead4 . '-' . $tail3;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')->withPivot('status')->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'certification_user')
            ->withPivot('certificate_number','course_id','issued_at')
            ->withTimestamps();
    }
}
