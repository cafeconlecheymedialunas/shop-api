<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Color;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;

class ColorTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_colors()
    {
        $this->withoutDeprecationHandling();
      
        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('colors.index'));
  
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                 ->has('data',10)
                 ->has('included.products',10)
                 ->where('meta.last_page',9)
                 ->where('meta.total',90)
                 ->has('version')
                 ->has('links')
                 ->etc()
        );
        
    }

    public function test_a_color_exist()
    {
        $this->withoutDeprecationHandling();
       
        Artisan::call("migrate:fresh --seed");
        
        $response = $this->actingAs(User::first())->get(route('colors.show', Color::first()->id));
       
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id',1)
                ->where('data.type',"color")
                ->where('links.self',route("colors.show",1))
                ->etc()
        );
    }

    public function test_a_color_can_store()
    {
        $this->withoutDeprecationHandling();
   
      
        Artisan::call("migrate:fresh --seed");
        $data = [
            'hex_code' => '#fffff', 
            'label' => 'Blanco',
            "products" => [
                1,2,3
            ]
        ];
        $color_id = (int) Color::count() +1;
        $response = $this->actingAs(User::first())->post(route('colors.store'), $data);

        $response->assertCreated()->assertJson(fn (AssertableJson $json) =>
        $json->has('data')
            ->has("links")
            ->has("relationships.products",3)
            ->where('data.id',$color_id)
            ->where('data.type',"color")
            ->where('relationships.products.0.id',1)
            ->where('links.self',route("colors.show",$color_id))
            ->etc()
        );

        $this->assertDatabaseHas("colors",[
            "id" => $color_id
        ]);
    }

    public function test_a_color_can_update()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $old_color = Color::factory()->create();
        $data = ['hex_code' => '#fffff', 'label' => 'Blanco'];

        $response = $this->actingAs($user)->put(route('colors.update', $old_color), $data);
     
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data')
            ->has("links")
            ->where('data.id',$old_color->id)
            ->where('data.attributes.hex_code',$data["hex_code"])
            ->where('data.attributes.label',$data["label"])
            ->where('data.type',"color")
            ->where('links.self',route("colors.show",$old_color->id))
            ->etc()
        );
    }

    public function test_a_color_can_delete()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $color  = Color::factory()->create();


        $response = $this->actingAs($user)->delete(route('colors.destroy', $color->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("colors",[
            "id" => $color->id
        ]);
    }
}
