<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
