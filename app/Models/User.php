<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'profile_picture',
        'additional_details',
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
        // Removed auto-generation on creating as per requirement to generate only after approval
    }

    public static function generateAccountId(string $role): string
    {
        $yy = now()->format('y');
        
        $roleCodes = [
            // Normal Users
            'admin' => 'LOA',
            'training_manager' => 'LOT',
            'coach' => 'LOC',
            'participant' => 'LOP',
            'trainee' => 'LOP', // Mapping trainee to LOP as per request pattern
            
            // DILG Central Office
            'central_office_admin' => 'COA',
            'central_office_training_manager' => 'COT',
            'central_office_coach' => 'COC',
            'central_office_participants' => 'COP',
            
            // DILG Regional Office
            'regional_office_admin' => 'ROA',
            'regional_office_training_manager' => 'ROT',
            'regional_office_coach' => 'ROC',
            'regional_office_participants' => 'ROP',
            
            // DILG Provincial Office
            'provincial_office_admin' => 'POA',
            'provincial_office_training_manager' => 'POT',
            'provincial_office_coach' => 'POC',
            'provincial_office_participants' => 'POP',
        ];

        $code = $roleCodes[$role] ?? 'USER';
        
        // Loop until we find a unique random ID
        do {
            $randomNum = str_pad((string)rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $accountId = "{$yy}-{$randomNum}-{$code}";
            $exists = self::where('account_id', $accountId)->exists();
        } while ($exists);

        return $accountId;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withPivot('status')
            ->withTimestamps();
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

    public static function notifyRegistrarsAboutNewUser(User $user): void
    {
        $targetRole = 'registrar'; // Default
        if ($user->role === 'central_office_participants') {
            $targetRole = 'central_office_training_manager';
        } elseif ($user->role === 'regional_office_participants') {
            $targetRole = 'regional_office_training_manager';
        } elseif ($user->role === 'provincial_office_participants') {
            $targetRole = 'provincial_office_training_manager';
        }

        // Fetch target users
        $registrars = self::where('role', $targetRole)->get();

        foreach ($registrars as $registrar) {
            \App\Models\Notification::create([
                'user_id' => $registrar->id,
                'title' => 'New User Registration',
                'message' => "New user {$user->name} has registered and is awaiting approval.",
                'type' => 'registration',
                'related_id' => $user->id,
                'link' => route('dashboard', ['tab' => 'user-management', 'search' => $user->name]),
            ]);
        }
    }

    public function getAvatarUrlAttribute(): string
    {
        $pic = $this->profile_picture;
        if (!$pic) {
            return asset('images/user.png');
        }
        $v = optional($this->updated_at)->timestamp ?? time();
        return asset('storage/' . $pic) . '?v=' . $v;
    }

    public function setAvatarFromUpload($file): void
    {
        if (!$file) return;
        if ($this->profile_picture) {
            Storage::disk('public')->delete($this->profile_picture);
        }
        $path = $file->store('profile_pictures', 'public');
        if (!Storage::disk('public')->exists($path)) {
            throw new \RuntimeException('Failed to save profile image.');
        }
        $this->profile_picture = $path;
    }

    public function setAvatarFromDataUrl(string $dataUrl): void
    {
        if (!preg_match('/^data:image\\/(png|jpeg);base64,/', $dataUrl, $m)) return;
        $data = substr($dataUrl, strpos($dataUrl, ',') + 1);
        $bin = base64_decode($data);
        $ext = $m[1] === 'jpeg' ? 'jpg' : 'png';
        if ($this->profile_picture) {
            Storage::disk('public')->delete($this->profile_picture);
        }
        $path = 'profile_pictures/' . Str::uuid() . '.' . $ext;
        Storage::disk('public')->put($path, $bin);
        if (!Storage::disk('public')->exists($path)) {
            throw new \RuntimeException('Failed to save profile image.');
        }
        $this->profile_picture = $path;
    }
}
