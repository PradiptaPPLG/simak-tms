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

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }
}
