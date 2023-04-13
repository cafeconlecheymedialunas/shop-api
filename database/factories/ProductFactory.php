<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'price' => fake()->numberBetween(1500, 6000),
            'sale_price' => fake()->numberBetween(1000, 4000),
            'size' => fake()->randomElement(config("defaultfieldvalues.products.size")),
            'description' => fake()->text(),
            'additional_info' => fake()->text(),
            'tech_details' => fake()->text(),

        ];
    }
}
