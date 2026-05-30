<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
     protected $fillable = [
        'patient_id',
        'journal_text',
        'word_count',
        'primary_emotion',
        'secondary_emotion',
        'emotion_scores',
        'journal_date'
    ];

    protected $casts = [
        'emotion_scores' => 'array',
    ];
}