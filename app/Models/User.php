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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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

    public function batch()
    {
        return $this->belongsTo(Batch::class);
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
