<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'limit' =>  fake()->dateTime('YYYY-MM-DD HH:MM:SS'),
            'type' => fake()->randomElement(config("defaultfieldvalues.coupons.type")),

            'discount' => fake()->randomNumber(5)
        ];
    }
}
