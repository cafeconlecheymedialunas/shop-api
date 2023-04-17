<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address_street',
        'address_appartment',
        'address_town',
        'address_state',
        'address_country',
        'address_postcode',
        'phone',
        "avatar"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
