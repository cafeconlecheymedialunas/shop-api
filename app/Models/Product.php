<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'sale_price',
        'size',
        'description',
        'additional_info',
        'tech_details',
        'color_id'
    ];

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withTimestamps();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
