<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    public function faculty()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}
