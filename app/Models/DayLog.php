<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayLog extends Model
{
    protected $fillable = [
        'patient_id',
        'mood',
        'log_date',

        'mood_score',
        'mood_label',
        'emotion',
        'impact_area'
    ];
    protected $casts = [
        'emotion' => 'array',
        'impact_area' => 'array',
    ];
}