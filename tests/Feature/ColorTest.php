<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Color;

class ColorTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_colors()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('colors.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_color_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $color = Color::factory()->create();
        $response = $this->actingAs($user)->get(route('colors.show', $color->id));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_color_can_store()
    {
        $this->withoutDeprecationHandling();
        $data = ['hex_code' => '#fffff', 'label' => 'Blanco'];
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('colors.store'), $data);

        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_color_can_update()
    {

        $user = User::factory()->create();
        $old_color = Color::factory()->create();
        $data = ['hex_code' => 'red', 'label' => 'Red'];
        $response = $this->actingAs($user)->put(route('colors.update', $old_color), $data);
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_color_can_delete()
    {

        $user = User::factory()->create();
        $color  = Color::factory()->create();


        $response = $this->actingAs($user)->delete(route('colors.destroy', $color->id));
        $response->assertStatus(202);
    }
}
