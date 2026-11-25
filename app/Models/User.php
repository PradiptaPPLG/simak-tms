<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }
        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }
        return asset($this->avatar);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'routine_off_days' => 'array',
        ];
    }

    /**
     * Check if a specific date is a configured routine off day
     */
    public function isOffDay($date): bool
    {
        if (empty($this->routine_off_days) || !is_array($this->routine_off_days)) {
            return false;
        }
        $dayOfWeekIso = \Carbon\Carbon::parse($date)->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu
        return in_array($dayOfWeekIso, $this->routine_off_days) || in_array((string)$dayOfWeekIso, $this->routine_off_days);
    }

    /**
     * Check whether student has ever configured their routine off days
     */
    public function hasConfiguredOffDays(): bool
    {
        return !is_null($this->routine_off_days);
    }

    /**
     * Human-readable day names of routine off days
     */
    public function getOffDaysLabelsAttribute(): array
    {
        $map = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        $days = (array)($this->routine_off_days ?? []);
        $labels = [];
        foreach ($days as $d) {
            if (isset($map[(int)$d])) {
                $labels[] = $map[(int)$d];
            }
        }
        return $labels;
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->profile_hash)) {
                $user->profile_hash = static::generateUniqueProfileHash();
            }
        });
    }

    /**
     * Generate 16-character secure, non-sequential profile hash
     */
    public static function generateUniqueProfileHash(): string
    {
        $appKey = config('app.key') ?: 'simak_tms_secret_key';
        do {
            $hash = substr(hash_hmac('sha256', 'simak_usr_' . uniqid((string)mt_rand(), true), $appKey), 0, 16);
        } while (static::where('profile_hash', $hash)->exists());

        return $hash;
    }

    /**
     * Accessor for profile_hash with deterministic fallback
     */
    public function getProfileHashAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        $appKey = config('app.key') ?: 'simak_tms_secret_key';
        return substr(hash_hmac('sha256', 'simak_user_' . $this->id . '_' . ($this->account_id ?? 'acc'), $appKey), 0, 16);
    }

    /**
     * Accessor for canonical public profile URL
     */
    public function getProfileUrlAttribute(): string
    {
        return url('/profile/' . $this->profile_hash);
    }

    public function getHashedIdentifier(): string
    {
        return $this->profile_hash;
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function batchEnrollments()
    {
        return $this->hasMany(BatchStudent::class, 'user_id');
    }

    public function enrolledBatches()
    {
        return $this->belongsToMany(Batch::class, 'batch_students', 'user_id', 'batch_id')
            ->withPivot([
                'id',
                'mentor_id',
                'institution_name',
                'major',
                'role_title',
                'status',
                'technical_skill',
                'discipline',
                'teamwork',
                'initiative',
                'final_score',
                'grade',
                'mentor_notes',
                'certificate_number',
                'issue_date',
                'is_published',
            ])
            ->withTimestamps();
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'mentor_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'mentor_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function journals()
    {
        return $this->hasMany(DailyJournal::class);
    }

    public function showcaseProjects()
    {
        return $this->hasMany(ShowcaseProject::class, 'creator_id');
    }

    public function projects()
    {
        return $this->hasMany(ShowcaseProject::class, 'creator_id');
    }

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }
}
