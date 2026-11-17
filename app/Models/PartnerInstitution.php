<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerInstitution extends Model
{
    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(User::class, 'school_origin', 'name');
    }
}
