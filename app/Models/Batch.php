<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function batchStudents()
    {
        return $this->hasMany(BatchStudent::class, 'batch_id');
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(User::class, 'batch_students', 'batch_id', 'user_id')
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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function showcaseProjects()
    {
        return $this->hasMany(ShowcaseProject::class);
    }
}
