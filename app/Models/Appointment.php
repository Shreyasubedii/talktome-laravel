<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'appoid';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'appointment';
    public $timestamps = false;
    
    protected $fillable = ['pid', 'apponum', 'scheduleid', 'appodate'];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'pid', 'pid');
    }
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'scheduleid', 'scheduleid');
    }
}