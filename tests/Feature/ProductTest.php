<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Color;
use App\Models\Product;
use App\Models\Tag;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_products()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('products.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_product_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();

        $product = Product::factory()->create();
        $response = $this->actingAs($user)->get(route('products.show', $product->id));

        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_product_can_store()
    {
        $this->withoutDeprecationHandling();
        $colors = Color::factory(3)->create()->pluck('id');
        $tags = Tag::factory(3)->create()->pluck('id');
        $data = [
            'title' => 'Title',
            'price' => 3400,
            'sale_price' => 2300,
            'size' => 'XS',
            'description' => 'ASDDDDDDDDDDDDDDDDDDDDDDD',
            'additional_info' => 'ASDDDDDDDDDDDDDDDDDDDDDDDDD',
            'tech_details' => 'WREEWRWREWREWR',
            'colors' => $colors
        ];
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('products.store'), $data);


        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_product_can_update()
    {

        $user = User::factory()->create();
        $old_product = Product::factory()->create();
        $colors = Color::factory(3)->create()->pluck('id');
        $tags = Tag::factory(3)->create()->pluck('id');
        $data = [
            'title' => 'Title',
            'price' => 3400,
            'sale_price' => 2300,
            'size' => 'XS',
            'description' => 'ASDDDDDDDDDDDDDDDDDDDDDDD',
            'additional_info' => 'ASDDDDDDDDDDDDDDDDDDDDDDDDD',
            'tech_details' => 'WREEWRWREWREWR',
            'colors' => $colors,
            'tags' => $tags
        ];
        $response = $this->actingAs($user)->put(route('products.update', $old_product->id), $data);

        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_product_can_delete()
    {

        $user = User::factory()->create();
        $product  = Product::factory()->create();


        $response = $this->actingAs($user)->put(route('products.destroy', $product->id));
        $response->assertOk();
    }
}
