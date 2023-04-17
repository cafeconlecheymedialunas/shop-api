<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_comments()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $this->actingAs(User::first())->get(route('comments.index'))
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has('data', 10)
                    ->has('included.users')
                    ->has('included.posts')
                    ->where('meta.last_page', 10)
                    ->where('meta.total', 100)
                    ->has('version')
                    ->has('links')
                    ->etc()
            );
    }

    public function test_a_comment_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $comment = Comment::first();

        $this->actingAs(User::first())->get(route('comments.show', 1))
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has("links")
                    ->where('data.id', 1)
                    ->where('data.type', "comment")
                    ->where('data.attributes.title', $comment->title)
                    ->where('links.self', route("comments.show", 1))
                    ->etc()
            );
    }

    public function test_a_comment_can_store()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $user = User::first();

        $data = [
            "title" => "title",
            "comment" => "comment",
            "post" => 1,
            "user" => 1
        ];

        $this->actingAs($user)->post(route('comments.store'), $data)
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has("links")
                    ->where('data.type', "comment")
                    ->where('data.attributes.title', $data["title"])
                    ->where('data.attributes.comment', $data["comment"])
                    ->etc()
            );

        $this->assertDatabaseHas("comments", [
            "id" => 31
        ]);
    }

    public function test_a_comment_can_update()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $user = User::first();

        $post = Post::first();

        $data = [
            "title" => fake()->name(),
            "comment" => fake()->paragraph(),
            "post" => $post->id,
            "user" => $user->id
        ];

        $this->actingAs($user)->put(route('comments.update', $post->id), $data)
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
                    ->has("links")
                    ->where('data.id', 1)
                    ->where('data.type', "comment")
                    ->where('data.attributes.title', $data["title"])
                    ->where('data.attributes.comment', $data["comment"])
                    ->etc()
            );
    }

    public function test_a_comment_can_delete()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $user = User::factory()->create();

        $comment = Comment::first();

        $this->actingAs($user)->delete(route('comments.destroy', $comment->id))
            ->assertStatus(202);

        $this->assertDatabaseMissing("comments", [
            "id" => $comment->id
        ]);
    }
}
