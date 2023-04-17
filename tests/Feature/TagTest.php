<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;


use Illuminate\Support\Facades\Artisan;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_tags()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('tags.index'));

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

    public function test_a_tag_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");
        $tag = Tag::first();
        $response = $this->actingAs(User::first())->get(route('tags.show', $tag->id));


      
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id',$tag->id)
                ->where('data.type', "tag")
                ->where('data.attributes.name', $tag->name)
                ->where('links.self', route("tags.show",$tag->id))
                ->etc()
        );
    }

    public function test_a_tag_can_store()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            'name' => fake()->name(),
            "posts" => [1,2,3],
            "products" => [1,2,3]
        ];
        $tag_last = Tag::count() + 1;


        $response = $this->actingAs($user)->post(route('tags.store'), $data);
       
        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', $tag_last)
                ->where('data.type', "tag")
                ->where('data.attributes.name', $data["name"])
       

                ->where('links.self', route("tags.show",  $tag_last))
                ->etc()
        );

        $this->assertDatabaseHas("tags", [
            "id" =>  $tag_last
        ]);
    }

    public function test_a_tag_can_update()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            'name' => fake()->name(),
            "posts" => [1,2,6],
            "products" => [4,5,3]
        ];


        $response = $this->actingAs($user)->put(route('tags.update', 1), $data);
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 1)
                ->where('data.type', "tag")
                ->where('data.attributes.name', $data["name"])


                ->where('links.self', route("tags.show", 1))
                ->etc()
        );
    }

    public function test_a_tag_can_delete()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $tag  = Tag::factory()->create();


        $response = $this->actingAs($user)->delete(route('tags.destroy', $tag->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("tags", [
            "id" => $tag->id
        ]);
    }
}
