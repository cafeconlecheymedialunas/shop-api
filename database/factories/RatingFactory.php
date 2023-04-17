<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::first()->id;
            },
            'product_id' => function () {
                return \App\Models\Product::first()->id;
            },
            "rating" =>fake()->randomElement(config("defaultfieldvalues.ratings.rating")),
            "comment" => fake()->text()
        ];
    }
}
