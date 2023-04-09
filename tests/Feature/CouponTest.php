<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use DateTime;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_coupons()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('coupons.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_coupon_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();

        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($user)->get(route('coupons.show', $coupon->id));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_coupon_can_store()
    {
        $this->withoutDeprecationHandling();

        $user = User::factory()->create();
        $data = [
            'limit' => '2023-04-13 14:31:01',
            'type' => 'fixed',
            'discount' => 1000
        ];
        $response = $this->actingAs($user)->post(route('coupons.store'), $data);
        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_coupon_can_update()
    {

        $user = User::factory()->create();
        $old_coupon = Coupon::factory()->create();
        $data = [
            'limit' =>  '2023-04-13 14:31:01',
            'type' => 'fixed',
            'discount' => 1000
        ];

        $response = $this->actingAs($user)->put(route('coupons.update', $old_coupon), $data);
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_coupon_can_delete()
    {

        $user = User::factory()->create();
        $coupon  = Coupon::factory()->create();


        $response = $this->actingAs($user)->delete(route('coupons.destroy', $coupon->id));
        $response->assertStatus(202);
    }
}
