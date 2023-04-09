<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_posts()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('posts.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_post_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $response = $this->actingAs($user)->get(route('posts.show', $post->id));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_post_can_store()
    {
        $this->withoutDeprecationHandling();

        $user = User::factory()->create();
        $data = ['title' => 'title new', 'content' => 'content', 'user_id' => $user->id];

        $response = $this->actingAs($user)->post(route('posts.store'), $data);


        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_post_can_update()
    {

        $user = User::factory()->create();
        $old_post = Post::factory()->create();
        $data = ['title' => 'title', 'content' => 'content', 'user_id' => $user->id];
        $response = $this->actingAs($user)->put(route('posts.update', $old_post), $data);
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_post_can_delete()
    {

        $user = User::factory()->create();
        $post  = Post::factory()->create();


        $response = $this->actingAs($user)->put(route('posts.destroy', $post->id));
        $response->assertOk();
    }
}
