<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;


use Illuminate\Support\Facades\Artisan;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_profiles()
    {

        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");

        $response = $this->actingAs(User::first())->get(route('profiles.index'));

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has('data', 10)
                ->has('included.user', 10)

                ->where('meta.last_page', 1)
                ->where('meta.total', 10)
                ->has('version')
                ->has('links')
                ->etc()
        );
    }

    public function test_a_profile_exist()
    {
        $this->withoutDeprecationHandling();

        Artisan::call("migrate:fresh --seed");
        $profile_id = 1;
        $response = $this->actingAs(User::first())->get(route('profiles.show', $profile_id));
        $profile = Profile::find($profile_id);

        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', $profile_id)
                ->where('data.type', "profile")
                ->where('data.attributes.first_name', $profile->first_name)
                ->where('data.attributes.last_name', $profile->last_name)
                ->where('data.attributes.address_street', $profile->address_street)
                ->where('data.attributes.address_appartment', $profile->address_appartment)
                ->where('data.attributes.address_town', $profile->address_town)
                ->where('data.attributes.address_state', $profile->address_state)
                ->where('data.attributes.address_country', $profile->address_country)
                ->where('data.attributes.address_postcode', $profile->address_postcode)
                ->where('data.attributes.phone', $profile->phone)
                ->where('links.self', route("profiles.show", $profile_id))
                ->etc()
        );
    }

    public function test_a_profile_can_store()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            'first_name' => fake()->text(50),
            'last_name' => fake()->text(50),
            "avatar" => "https://picsum.photos/seed/picsum/200/300",
            'address_street' => fake()->text(50),
            'address_appartment' => "4 f contrafrente",
            'address_town' => fake()->text(50),
            'address_state' => fake()->text(50),
            'address_country' => fake()->text(50),
            'address_postcode' => "1872",
            'phone' => "1538764374",
            "user" => $user->id
        ];


        $response = $this->actingAs($user)->post(route('profiles.store'), $data);
        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 11)
                ->where('data.type', "profile")
                ->where('data.attributes.first_name', $data["first_name"])
                ->where('data.attributes.last_name', $data["last_name"])
                ->where('data.attributes.address_street', $data["address_street"])
                ->where('data.attributes.address_appartment', $data["address_appartment"])
                ->where('data.attributes.address_town', $data["address_town"])
                ->where('data.attributes.address_state', $data["address_state"])
                ->where('data.attributes.address_country', $data["address_country"])
                ->where('data.attributes.address_postcode', $data["address_postcode"])
                ->where('data.attributes.phone', $data["phone"])

                ->where('links.self', route("profiles.show", 11))
                ->etc()
        );

        $this->assertDatabaseHas("profiles", [
            "id" => 11
        ]);
    }

    public function test_a_profile_can_update()
    {
        $this->withoutDeprecationHandling();
        Artisan::call("migrate:fresh --seed");
        $user = User::first();
        $data = [
            'first_name' => fake()->text(50),
            'last_name' => fake()->text(50),
            'address_street' => fake()->text(50),
            "avatar" => "https://picsum.photos/seed/picsum/200/300",
            'address_appartment' => "4 f cfte",
            'address_town' => fake()->text(50),
            'address_state' => fake()->text(50),
            'address_country' => fake()->text(50),
            'address_postcode' => "1872",
            'phone' => "1538764374",
            "user" => $user->id
        ];


        $response = $this->actingAs($user)->put(route('profiles.update', 1), $data);
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has("links")
                ->where('data.id', 1)
                ->where('data.type', "profile")
                ->where('data.attributes.first_name', $data["first_name"])
                ->where('data.attributes.last_name', $data["last_name"])
                ->where('data.attributes.address_street', $data["address_street"])
                ->where('data.attributes.address_appartment', $data["address_appartment"])
                ->where('data.attributes.address_town', $data["address_town"])
                ->where('data.attributes.address_state', $data["address_state"])
                ->where('data.attributes.address_country', $data["address_country"])
                ->where('data.attributes.address_postcode', $data["address_postcode"])
                ->where('data.attributes.phone', $data["phone"])


                ->where('links.self', route("profiles.show", 1))
                ->etc()
        );
    }

    public function test_a_profile_can_delete()
    {
        $this->withoutDeprecationHandling();
        $user = User::factory()->create();
        $profile  = Profile::factory()->create();


        $response = $this->actingAs($user)->delete(route('profiles.destroy', $profile->id));
        $response->assertStatus(202);
        $this->assertDatabaseMissing("profiles", [
            "id" => $profile->id
        ]);
    }
}
