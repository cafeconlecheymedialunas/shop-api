<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['limit', 'type', 'discount'];

    public function order(){
        return $this->hasOne(Order::class);
    }
}
