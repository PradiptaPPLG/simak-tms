<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
