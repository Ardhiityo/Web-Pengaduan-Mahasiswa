<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_faculty', 'faculty_id', 'user_id');
    }
}
