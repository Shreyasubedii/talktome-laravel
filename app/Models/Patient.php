<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'pid';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'patient';
    public $timestamps = false;
    
    protected $fillable = ['pemail', 'pname', 'ppassword', 'paddress', 'pnic', 'pdob', 'ptel'];

    public function getAuthPassword()
    {
        return $this->ppassword;
    }

    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }

    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'pid', 'pid');
    }
}