<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'docid';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'doctor';
    public $timestamps = false;
    
    protected $fillable = ['docemail', 'docname', 'docpassword', 'docnic', 'doctel', 'specialties'];

    public function getAuthPassword()
    {
        return $this->docpassword;
    }

    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }


    
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialties', 'id');
    }
    
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'docid', 'docid');
    }
    
    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Schedule::class, 'docid', 'scheduleid', 'docid', 'scheduleid');
    }
}