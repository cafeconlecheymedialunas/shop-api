<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ["name", "description", "image"];

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categoryable');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'categoryable');
    }
}
