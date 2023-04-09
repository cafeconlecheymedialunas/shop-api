<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;


class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_profiles()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profiles.index'));
        return $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'includes',
                'version',
                // /'links',
            ]

        );
    }

    public function test_a_profile_exist()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $profile = Profile::factory()->create();
        $response = $this->actingAs($user)->get(route('profiles.show', $profile->id));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_profile_can_store()
    {
        $this->withoutDeprecationHandling();

        $user = User::factory()->create();
        $data = [
            'last_name' => fake()->name(),
            'address_street' => fake()->address(),
            'address_apparment' => '4f',
            'address_town' => fake()->city(),
            'address_state' => fake('en_US')->state(),
            'address_country' => fake()->country(),
            'address_postcode' => fake()->numerify('ar#####'),
            'phone' => fake()->phoneNumber(),
            'user_id' => $user->id
        ];
        $response = $this->actingAs($user)->post(route('profiles.store'), $data);
        $response->assertStatus(201)->assertJsonStructure(
            [
                'data',
                //'links'
            ]
        );
    }

    public function test_a_profile_can_update()
    {

        $user = User::factory()->create();
        $old_profile = Profile::factory()->create();
        $data = [
            'last_name' => fake()->name(),
            'address_street' => fake()->address(),
            'address_apparment' => '4f',
            'address_town' => fake()->city(),
            'address_state' => fake('en_US')->state(),
            'address_country' => fake()->country(),
            'address_postcode' => fake()->numerify('ar#####'),
            'phone' => fake()->phoneNumber(),
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->put(route('profiles.update', $old_profile), $data);
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data',
                'links'
            ]
        );
    }

    public function test_a_profile_can_delete()
    {

        $user = User::factory()->create();
        $profile  = Profile::factory()->create();


        $response = $this->actingAs($user)->put(route('profiles.destroy', $profile->id));
        $response->assertOk();
    }
}
