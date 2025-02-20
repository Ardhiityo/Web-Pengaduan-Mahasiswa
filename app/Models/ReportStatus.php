<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportStatus extends Model
{
    protected $fillable = [
        'report_id',
        'image',
        'status',
        'description'
    ];

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->translatedFormat('l, j F Y, H:i');
    }

    public function Report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
