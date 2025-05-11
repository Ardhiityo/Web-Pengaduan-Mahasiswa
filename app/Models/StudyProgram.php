<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudyProgram extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

    public function faculty()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
