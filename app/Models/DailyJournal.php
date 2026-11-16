<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyJournal extends Model
{
    protected $guarded = [];

    protected $casts = [
        'journal_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
