<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Category;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_categories()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('categories.index'));

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has('data', 10)
                ->has('included.products')
                ->has('included.posts')
                ->where('meta.last_page',12)
                ->where('meta.total', 120)
                ->has('version')
                ->has('links')
                ->etc()
        );
    }

    public function test_a_category_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");
        $category = Category::first();
        $response = $this->actingAs(User::first())->get(route('categories.show', $category->id));


      
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id',$category->id)
                ->where('data.type', "category")
                ->where('data.attributes.name', $category->name)
                ->where('links.self', route("categories.show",$category->id))
                ->etc()
        );
    }

    public function test_a_category_can_store()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            "name" => fake()->name(),
            "description" => fake()->paragraph(),
            "image" => "https://picsum.photos/seed/picsum/200/300",
            "posts" => [1,2,3],
            "products" => [1,2,3]
        ];
        $category_last = Category::count() + 1;


        $response = $this->actingAs($user)->post(route('categories.store'), $data);
       
        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', $category_last)
                ->where('data.type', "category")
                ->where('data.attributes.name', $data["name"])
                ->where('data.attributes.description', $data["description"])
                ->where('data.attributes.image', $data["image"])
       

                ->where('links.self', route("categories.show",  $category_last))
                ->etc()
        );

        $this->assertDatabaseHas("categories", [
            "id" =>  $category_last
        ]);
    }

    public function test_a_category_can_update()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            "name" => fake()->name(),
            "description" => fake()->paragraph(),
            "image" => "https://picsum.photos/seed/picsum/200/300",
            "posts" => [1,2,3],
            "products" => [1,2,3]
        ];


        $response = $this->actingAs($user)->put(route('categories.update', 1), $data);
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 1)
                ->where('data.type', "category")
                ->where('data.attributes.name', $data["name"])
                ->where('data.attributes.description', $data["description"])
                ->where('data.attributes.image', $data["image"])
                ->where('links.self', route("categories.show", 1))
                ->etc()
        );
    }

    public function test_a_category_can_delete()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $category  = Category::factory()->create();


        $response = $this->actingAs($user)->delete(route('categories.destroy', $category->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("categories", [
            "id" => $category->id
        ]);
    }
}
