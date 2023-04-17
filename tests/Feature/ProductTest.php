<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;

use Illuminate\Support\Facades\Artisan;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_products()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('products.index'));

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has('data', 10)
                ->has('included.tags', 10)
                ->has('included.categories', 10)
                ->has('included.orders', 10)
                ->has('included.ratings', 10)
                ->has('included.colors', 10)

                ->where('meta.last_page', 3)
                ->where('meta.total', 30)
                ->has('version')
                ->has('links')
                ->etc()
        );
    }

    public function test_a_product_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");
        $profile_id = 1;
        $response = $this->actingAs(User::first())->get(route('products.show', $profile_id));
        $profile = Product::find($profile_id);
      
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id',$profile_id)
                ->where('data.type', "product")
                ->where('data.attributes.title', $profile->title)
                ->where('data.attributes.price', $profile->price)
                ->where('data.attributes.sale_price', $profile->sale_price)
                ->where('data.attributes.size', $profile->size)
                ->where('data.attributes.description', $profile->description)
                ->where('data.attributes.additional_info', $profile->additional_info)
                ->where('data.attributes.tech_details', $profile->tech_details)
                ->where('links.self', route("products.show",$profile_id))
                ->etc()
        );
    }

    public function test_a_product_can_store()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $data = [
            'title' => fake()->title(),
            'price' => fake()->numberBetween(1500, 6000),
            'sale_price' => fake()->numberBetween(1000, 4000),
            'size' => fake()->randomElement(config("defaultfieldvalues.products.size")),
            'description' => fake()->text(),
            'additional_info' => fake()->text(),
            'tech_details' => fake()->text(),
            'tags' => [1, 2, 3],
            'categories' => [1, 2, 3],

            'colors' => [1, 2, 3],
        ];


        $response = $this->actingAs(User::first())->post(route('products.store'), $data);
        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 31)
                ->where('data.type', "product")
                ->where('data.attributes.title', $data["title"])
                ->where('data.attributes.price', $data["price"])
                ->where('data.attributes.sale_price', $data["sale_price"])
                ->where('data.attributes.size', $data["size"])
                ->where('data.attributes.description', $data["description"])
                ->where('data.attributes.additional_info', $data["additional_info"])
                ->where('data.attributes.tech_details', $data["tech_details"])

                ->where('links.self', route("products.show", 31))
                ->etc()
        );

        $this->assertDatabaseHas("products", [
            "id" => 31
        ]);
    }

    public function test_a_product_can_update()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");

        $data = [
            'title' => fake()->title(),
            'price' => fake()->numberBetween(1500, 6000),
            'sale_price' => fake()->numberBetween(1000, 4000),
            'size' => fake()->randomElement(config("defaultfieldvalues.products.size")),
            'description' => fake()->text(),
            'additional_info' => fake()->text(),
            'tech_details' => fake()->text(),
            'tags' => [1, 2, 3],
            'categories' => [1, 2, 3],
            'colors' => [1, 2, 3],
        ];


        $response = $this->actingAs(User::first())->put(route('products.update', Product::first()), $data);
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 1)
                ->where('data.type', "product")
                ->where('data.attributes.title', $data["title"])
                ->where('data.attributes.price', $data["price"])
                ->where('data.attributes.sale_price', $data["sale_price"])
                ->where('data.attributes.size', $data["size"])
                ->where('data.attributes.description', $data["description"])
                ->where('data.attributes.additional_info', $data["additional_info"])
                ->where('data.attributes.tech_details', $data["tech_details"])


                ->where('links.self', route("products.show", 1))
                ->etc()
        );
    }

    public function test_a_product_can_delete()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $product  = Product::factory()->create();


        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("products", [
            "id" => $product->id
        ]);
    }
}
