<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'specialties';
    public $timestamps = false;
    
    protected $fillable = ['sname', 'keywords'];
    
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialties', 'id');
    }
}