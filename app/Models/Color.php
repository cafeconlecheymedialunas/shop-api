<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['hex_code', 'label'];

    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
