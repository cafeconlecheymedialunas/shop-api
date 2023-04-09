<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Color::factory(10)->create();
        \App\Models\Tag::factory(10)->create();

        \App\Models\Product::factory(10)->create()->each(function ($product) {
            $product->colors()->saveMany(\App\Models\Color::factory(10)->make());
            $product->tags()->saveMany(\App\Models\Tag::factory(10)->make());
        });
        \App\Models\Coupon::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
