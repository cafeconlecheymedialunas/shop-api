<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Resources\ColorCollection;
use App\Http\Resources\ColorResource;

class ColorController extends Controller
{

    public function index()
    {
        $colors = Color::paginate(10);
        return new ColorCollection($colors);
    }

    public function store(ColorRequest $request)
    {
        $color = Color::create($request->all());
        return new ColorResource($color);
    }

    public function show(Color $color)
    {
        return new ColorResource($color);
    }

    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->all());
        return new ColorResource($color);
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return response(null, 202);
    }
}
