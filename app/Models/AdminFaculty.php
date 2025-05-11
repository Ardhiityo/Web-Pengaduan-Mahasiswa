<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminFaculty extends Pivot
{
    protected $fillable = [
        'user_id',
        'faculty_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
