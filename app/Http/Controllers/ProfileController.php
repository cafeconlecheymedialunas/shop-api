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
        $profiles = Profile::paginate(10);
        return new ProfileCollection($profiles);
    }

    public function store(ProfileRequest $request)
    {
        $profile = Profile::create($request->all());

        return new ProfileResource($profile);
    }

    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        $profile->update($request->all());

        return new ProfileResource($profile);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response(null, 204);
    }
}
