<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }
}
