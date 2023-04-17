<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Http\Resources\ProfileCollection;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with("user")->paginate(10);
        return new ProfileCollection($profiles);
    }

    public function store(ProfileRequest $request)
    {
        $profile = new Profile();
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->address_street = $request->address_street;
        $profile->address_appartment = $request->address_appartment;
        $profile->address_town = $request->address_town;
        $profile->address_state = $request->address_state;
        $profile->address_country = $request->address_country;
        $profile->address_postcode = $request->address_postcode;
        $profile->phone = $request->phone;
        $profile->avatar = $request->avatar;
        $user = User::find($request->user);
        $profile->user()->associate($user);
        $profile->save();
        return new ProfileResource($profile);
    }

    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->address_street = $request->address_street;
        $profile->address_appartment = $request->address_appartment;
        $profile->address_town = $request->address_town;
        $profile->address_state = $request->address_state;
        $profile->address_country = $request->address_country;
        $profile->address_postcode = $request->address_postcode;
        $profile->phone = $request->phone;
        $profile->avatar = $request->avatar;
        $user = User::find($request->user);
        $profile->user()->associate($user);
        $profile->save();

        return new ProfileResource($profile);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response(null, 202);
    }
}
