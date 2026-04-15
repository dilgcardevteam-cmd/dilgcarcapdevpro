<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

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
        'agency',
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
        static::saving(function (self $user) {
            $user->normalizeRoleForOffice();
            $user->ensureStandardAccountId();
        });
    }

    public function hasPermission(string $permission): bool
    {
        $rawRole = strtolower($this->role ?? '');
        if ($rawRole === 'super_admin') return true;

        // Try to find the role by slug or display name
        $roleModel = Role::where('name', $this->role)
            ->orWhere('name', $rawRole)
            ->first();
            
        if (!$roleModel) return false;

        return $roleModel->permissions()->where('name', $permission)->exists();
    }

    public function canManageUsers(): bool
    {
        $rawRole = strtolower($this->role ?? '');
        if ($rawRole === 'super_admin') return true;

        if (str_contains($rawRole, 'training_manager') || $rawRole === 'registrar') {
            return $this->hasPermission('view_users_tm');
        }

        return $this->hasPermission('view_users');
    }

    public function canUpdateUsers(): bool
    {
        $rawRole = strtolower($this->role ?? '');
        if ($rawRole === 'super_admin') return true;

        // For Training Managers / Registrars, they specifically need update_users_tm
        if ($rawRole === 'training_manager' || $rawRole === 'registrar' || str_contains($rawRole, '_training_manager')) {
            return $this->hasPermission('update_users_tm');
        }

        // Default for other roles
        return $this->hasPermission('edit_users');
    }

    public function canManageTraining(): bool
    {
        $rawRole = strtolower($this->role ?? '');
        if ($rawRole === 'super_admin') return true;

        // Everyone else must strictly have the 'view_training' permission
        return $this->hasPermission('view_training');
    }

    public function canViewReports(): bool
    {
        $rawRole = strtolower($this->role ?? '');
        if ($rawRole === 'super_admin') return true;

        return $this->hasPermission('view_reports');
    }

    public static function generateAccountId(string $role, ?string $region = null): string
    {
        $yy = now()->format('y');
        $code = self::roleCodeFor($role, $region);
        
        // Loop until we find a unique random ID
        do {
            $randomNum = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $accountId = "{$yy}-{$randomNum}-{$code}";
            $exists = self::where('account_id', $accountId)->exists();
        } while ($exists);

        return $accountId;
    }

    public static function roleCodeFor(string $role, ?string $region = null): string
    {
        $key = strtolower(trim($role));
        $regionKey = strtolower(trim((string) $region));
        $office = '';
        if ($regionKey === 'dilg central office' || str_contains($regionKey, 'central office')) $office = 'co';
        if ($regionKey === 'dilg regional office' || str_contains($regionKey, 'regional office')) $office = 'ro';
        if ($regionKey === 'dilg provincial office' || str_contains($regionKey, 'provincial office')) $office = 'po';

        if ($office !== '') {
            if (in_array($key, ['admin'], true)) return strtoupper($office) . 'A';
            if (in_array($key, ['training_manager', 'registrar'], true)) return strtoupper($office) . 'T';
            if (in_array($key, ['coach', 'trainer'], true)) return strtoupper($office) . 'C';
            if (in_array($key, ['participant', 'trainee'], true)) return strtoupper($office) . 'P';
        }

        $roleCodes = [
            'super_admin' => 'LOA',
            'admin' => 'LOA',
            'training_manager' => 'LOT',
            'coach' => 'LOC',
            'trainer' => 'LOC',
            'participant' => 'LOP',
            'trainee' => 'LOP',

            'central_office_admin' => 'COA',
            'central_office_training_manager' => 'COT',
            'central_office_coach' => 'COC',
            'central_office_participant' => 'COP',
            'central_office_participants' => 'COP',

            'regional_office_admin' => 'ROA',
            'regional_office_training_manager' => 'ROT',
            'regional_office_coach' => 'ROC',
            'regional_office_participant' => 'ROP',
            'regional_office_participants' => 'ROP',

            'provincial_office_admin' => 'POA',
            'provincial_office_training_manager' => 'POT',
            'provincial_office_coach' => 'POC',
            'provincial_office_participant' => 'POP',
            'provincial_office_participants' => 'POP',
        ];

        return $roleCodes[$key] ?? 'UNK';
    }

    public static function isStandardAccountId(?string $accountId): bool
    {
        if ($accountId === null) return false;
        $accountId = trim($accountId);
        if ($accountId === '') return false;
        return (bool) preg_match('/^\d{2}-\d{4}-[A-Z]{3}$/', $accountId);
    }

    public function ensureStandardAccountId(): bool
    {
        $status = strtolower((string) ($this->status ?? ''));
        $role = trim((string) ($this->role ?? ''));
        if ($status !== 'active' || $role === '') {
            return false;
        }

        $expectedCode = self::roleCodeFor($role, $this->region);
        $current = trim((string) ($this->account_id ?? ''));
        if (!self::isStandardAccountId($current)) {
            $this->account_id = self::generateAccountId($role, $this->region);
            return true;
        }

        $parts = explode('-', $current);
        $code = $parts[2] ?? '';
        if ($code !== $expectedCode) {
            $this->account_id = self::generateAccountId($role, $this->region);
            return true;
        }

        return false;
    }

    public function normalizeRoleForOffice(): bool
    {
        $rawRole = strtolower(trim((string) ($this->role ?? '')));
        if ($rawRole === '') return false;

        $changed = false;

        if ($rawRole === 'trainer') {
            $rawRole = 'coach';
            $changed = true;
        }

        if ($rawRole === 'registrar') {
            $rawRole = 'training_manager';
            $changed = true;
        }

        $regionKey = strtolower(trim((string) ($this->region ?? '')));
        $office = '';
        if ($regionKey === 'dilg central office' || str_contains($regionKey, 'central office')) $office = 'central';
        if ($regionKey === 'dilg regional office' || str_contains($regionKey, 'regional office')) $office = 'regional';
        if ($regionKey === 'dilg provincial office' || str_contains($regionKey, 'provincial office')) $office = 'provincial';

        if ($office !== '') {
            $alreadyOfficeRole = str_starts_with($rawRole, 'central_office_')
                || str_starts_with($rawRole, 'regional_office_')
                || str_starts_with($rawRole, 'provincial_office_');

            if (!$alreadyOfficeRole) {
                $mapped = null;
                if ($rawRole === 'admin') $mapped = "{$office}_office_admin";
                if ($rawRole === 'training_manager') $mapped = "{$office}_office_training_manager";
                if ($rawRole === 'coach') $mapped = "{$office}_office_coach";
                if ($rawRole === 'participant' || $rawRole === 'trainee') $mapped = "{$office}_office_participants";

                if ($mapped) {
                    $rawRole = $mapped;
                    $changed = true;
                }
            }
        }

        if ($changed) {
            $this->role = $rawRole;
        }

        return $changed;
    }

    public function courses()
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

        return $this->belongsToMany(Course::class, 'course_user')
            ->withPivot($pivotColumns)
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

    public function hasCompletedOnboardingProfile(): bool
    {
        if (!$this->name || !$this->email || !$this->mobile_number || !$this->gender || !$this->agency || !$this->region || !$this->province) {
            return false;
        }

        if ($this->agency === 'LGU') {
            return !empty($this->city) && !empty($this->barangay);
        }

        if ($this->agency === 'DILG') {
            if ($this->region === 'DILG Central Office') {
                return !empty($this->city);
            }

            return true;
        }

        return false;
    }

    public static function notifyRegistrarsAboutNewUser(User $user): void
    {
        $targetRole = 'registrar'; // Default
        $registrationLevel = trim((string) ($user->region ?? ''));

        if ($user->role === 'central_office_participants' || ($user->agency === 'DILG' && $registrationLevel === 'DILG Central Office')) {
            $targetRole = 'central_office_training_manager';
        } elseif ($user->role === 'regional_office_participants' || ($user->agency === 'DILG' && $registrationLevel === 'DILG Regional Office')) {
            $targetRole = 'regional_office_training_manager';
        } elseif ($user->role === 'provincial_office_participants' || ($user->agency === 'DILG' && $registrationLevel === 'DILG Provincial Office')) {
            $targetRole = 'provincial_office_training_manager';
        }

        // Fetch target approvers for the selected agency/level.
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
        $pic = trim((string) ($this->profile_picture ?? ''));
        if ($pic === '') {
            return asset('images/user.png');
        }

        if (filter_var($pic, FILTER_VALIDATE_URL)) {
            $host = strtolower((string) parse_url($pic, PHP_URL_HOST));
            $blockedHosts = [
                'googleusercontent.com',
                'lh3.googleusercontent.com',
                'lh4.googleusercontent.com',
                'lh5.googleusercontent.com',
                'lh6.googleusercontent.com',
            ];
            foreach ($blockedHosts as $blockedHost) {
                if ($host === $blockedHost || str_ends_with($host, '.' . $blockedHost)) {
                    return asset('images/user.png');
                }
            }

            return $pic;
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
