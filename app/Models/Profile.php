<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'address_street',
        'address_apparment',
        'address_town',
        'address_state',
        'address_country',
        'address_postcode',
        'phone',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
