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
            'last_name' => fake()->name(),
            'address_street' => fake()->address(),
            'address_apparment' => '4f',
            'address_town' => fake()->city(),
            'address_state' => fake('en_US')->state(),
            'address_country' => fake()->country(),
            'address_postcode' => fake()->numerify('ar#####'),
            'phone' => fake()->phoneNumber(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
