<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
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
            'coupon_id' => function () {
                return \App\Models\Coupon::factory()->create()->id;
            },
            "status" => fake()->randomElement(config("defaultfieldvalues.orders.status")),
            "order_notes" => fake()->text(),
            "total" =>fake()->randomNumber(),
            "payment" => fake()->word(),

        ];
    }
}
