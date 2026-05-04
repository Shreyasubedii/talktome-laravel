<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'scheduleid';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'schedule';
    public $timestamps = false;
    
    protected $fillable = ['docid', 'title', 'scheduledate', 'scheduletime', 'nop'];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'docid', 'docid');
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'scheduleid', 'scheduleid');
    }
}