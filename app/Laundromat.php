<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laundromat extends Model
{
    
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'status',
        'user_id'
    ];

    public function owner() {
        return $this->belongsTo(\App\User::class);
    }

    public function transactions() {
        return $this->hasMany(\App\Transaction::class);
    }

}
