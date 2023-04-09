<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Post;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_tags()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tags.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_tag_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $response = $this->actingAs($user)->get(route('tags.show', $tag->id));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_tag_can_store()
    {
        $this->withoutDeprecationHandling();
        $data = [
            'name' => 'Excelelnt',
            'products' => Product::factory(10)->create()->pluck('id'),
            'posts' => Post::factory(10)->create()->pluck('id')
        ];
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('tags.store'), $data);

        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_tag_can_update()
    {

        $user = User::factory()->create();
        $old_tag = Tag::factory()->create();
        $data = [
            'name' => 'Excelelnt',
            'products' => Product::factory(10)->create()->pluck('id'),
            'posts' => Post::factory(10)->create()->pluck('id')
        ];
        $response = $this->actingAs($user)->put(route('tags.update', $old_tag), $data);
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_tag_can_delete()
    {

        $user = User::factory()->create();
        $tag  = Tag::factory()->create();


        $response = $this->actingAs($user)->delete(route('tags.destroy', $tag->id));
        $response->assertStatus(202);
    }
}
