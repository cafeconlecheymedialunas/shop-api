<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Order;

use Illuminate\Support\Facades\Artisan;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_posts()
    {
        $this->withoutDeprecationHandling();
      
        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('posts.index'));

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                 ->has('data',10)
                 ->has('included.tags',10)
                 ->has('included.categories',10)
                 ->has('included.comments',10)
                 ->has('included.user',10)
                 ->where('meta.last_page',1)
                 ->where('meta.total',10)
                 ->has('version')
                 ->has('links')
                 ->etc()
        );
        
    }

    public function test_a_post_exist()
    {
        $this->withoutDeprecationHandling();
       
        Artisan::call("migrate:fresh --seed");
        
        $response = $this->actingAs(User::first())->get(route('posts.show', Post::first()->id));
       
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id',1)
                ->where('data.type',"post")
                ->where('links.self',route("posts.show",1))
                ->etc()
        );
    }

    public function test_a_post_can_store()
    {

        Artisan::call("migrate:fresh --seed");
        $data = [
            'title' => 'title',
            'content' => 'content',
            'user' => 1,
            'categories' => [1,2,3],
            'comment' => 1,
            'tags' => [1,2,3],
        ];
 
   
        $response = $this->actingAs(User::first())->post(route('posts.store'), $data);
        $response->assertCreated()->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
            ->has("links")
            ->has("relationships.tags")
            ->where('data.id',11)
            ->where('data.type',"post",3)
            ->has('relationships.tags',3)
            ->has('relationships.categories',3)
           
            
            ->where('links.self',route("posts.show",11))
            ->etc()
        );

        $this->assertDatabaseHas("posts",[
            "id" =>11
        ]);

       
    }

    public function test_a_post_can_update()
    {

        Artisan::call("migrate:fresh --seed");
     
        $data = [
            'title' => 'title',
            'content' => 'content',
            'user' => 1,
            'categories' => [1,2,3],
            'comment' => 1,
            'tags' => [1,2,3],
        ];
 

        $response = $this->actingAs(User::first())->put(route('posts.update', 1), $data);
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data')
            ->has("links")
            ->where('data.id',1)
            ->where('data.attributes.title',$data["title"])
            ->where('data.attributes.content',$data["content"])
           
            ->where('data.type',"post")
            ->where('links.self',route("posts.show",1))
            ->etc()
        );
    }

    public function test_a_post_can_delete()
    {

        $user = User::factory()->create();
        $post  = Post::factory()->create();


        $response = $this->actingAs($user)->delete(route('posts.destroy', $post->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("posts",[
            "id" => $post->id
        ]);
    }
}
