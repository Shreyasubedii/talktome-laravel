<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'history';
    public $timestamps = false;
    
    protected $fillable = ['user_id', 'problem', 'matched_specialties', 'matched_specialties_ids', 'recommended_doctors'];
    
    public function user()
    {
        return $this->belongsTo(Patient::class, 'user_id', 'pid');
    }
}