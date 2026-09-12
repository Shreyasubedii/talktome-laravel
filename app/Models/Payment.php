<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id', 'payment_method', 'payment_status',
        'amount', 'esewa_transaction_id', 'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appoid');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'pid');
    }
}