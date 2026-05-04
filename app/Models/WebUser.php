<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebUser extends Model
{
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $table = 'webuser';
    public $timestamps = false;
    
    protected $fillable = ['email', 'usertype'];
    
    public function getUserTypeAttribute()
    {
        return match($this->attributes['usertype'] ?? null) {
            'a' => 'admin',
            'd' => 'doctor',
            'p' => 'patient',
            default => 'unknown',
        };
    }
}