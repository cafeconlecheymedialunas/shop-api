<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->text(50),
            'last_name' => fake()->text(50),
            "avatar" => "https://picsum.photos/seed/picsum/200/300",
            'address_street' => fake()->text(50),
            'address_appartment' => "4 f",
            'address_town' => fake()->text(50),
            'address_state' => fake()->text(50),
            'address_country' => fake()->text(50),
            'address_postcode' => "1872",
            'phone' => "1538764374",
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
