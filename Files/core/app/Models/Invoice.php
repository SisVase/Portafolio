<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $casts = ['shipping_address'=> 'object'];

    public function deposit(){
        return $this->hasOne(Deposit::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function tracks(){
        return $this->hasMany(Track::class);
    }

}
