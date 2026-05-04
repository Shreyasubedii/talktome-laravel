<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'aemail';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $table = 'admin';
    public $timestamps = false;
    
    protected $fillable = ['aemail', 'apassword'];

    public function getAuthPassword()
    {
        return $this->apassword;
    }

    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }
}