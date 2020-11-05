<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $fillable = [
        'transaction_code',
        'weight',
        'price',
        'start_date',
        'end_date',
        'status',
        'laundromat_id',
        'user_id'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function laundromat() {
        return $this->belongsTo(\App\Laundromat::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

}
