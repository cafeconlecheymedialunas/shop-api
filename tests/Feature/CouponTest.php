<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Order;

use Illuminate\Support\Facades\Artisan;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_coupons()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $this->actingAs(User::first())->get(route('coupons.index'))
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has('data', 10)
                    ->has('included.orders', 10)
                    ->where('meta.last_page', 1)
                    ->where('meta.total', 10)
                    ->has('version')
                    ->has('links')
                    ->etc()
            );
    }

    public function test_a_coupon_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $this->actingAs(User::first())->get(route('coupons.show', Coupon::first()->id))
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has("links")
                    ->where('data.id', 1)
                    ->where('data.type', "coupon")
                    ->where('links.self', route("coupons.show", 1))
                    ->etc()
            );
    }

    public function test_a_coupon_can_store()
    {

        Artisan::call("migrate:fresh --seed");

        $data = [
            'limit' => '2023-04-13 14:31:01',
            'type' => 'fixed',
            'discount' => 1000,
            "order" => Order::first()->id
        ];

        $response = $this->actingAs(User::first())->post(route('coupons.store'), $data);

        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->has("relationships.order")
                ->where('data.id', 11)
                ->where('data.type', "coupon")
                ->where('relationships.order.id', 1)
                ->where('links.self', route("coupons.show", 11))
                ->etc()
        );

        $this->assertDatabaseHas("coupons", [
            "id" => 11
        ]);
    }

    public function test_a_coupon_can_update()
    {
        Artisan::call("migrate:fresh --seed");

        $user = User::factory()->create();

        $data = [
            'limit' =>  '2023-04-13 14:31:01',
            'type' => 'fixed',
            'discount' => 1000,
            "order" => Order::first()->id
        ];

        $this->actingAs($user)->put(route('coupons.update', 1), $data)
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has("links")
                    ->where('data.id', 1)
                    ->where('data.attributes.limit', $data["limit"])
                    ->where('data.attributes.type', $data["type"])
                    ->where('data.attributes.discount', $data["discount"])
                    ->where('data.type', "coupon")
                    ->where('links.self', route("coupons.show", 1))
                    ->etc()
            );
    }

    public function test_a_coupon_can_delete()
    {

        $user = User::factory()->create();

        $coupon  = Coupon::factory()->create();

        $this->actingAs($user)->delete(route('coupons.destroy', $coupon->id))
            ->assertStatus(202);

        $this->assertDatabaseMissing("coupons", [
            "id" => $coupon->id
        ]);
    }
}
