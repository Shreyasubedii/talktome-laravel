<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientNotification extends Model
{
    protected $table = 'patient_notifications';

    protected $fillable = [
        'patient_id',
        'type',
        'title',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}