<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
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
        $color = new Color($request->all());
        $color->save();
        $color->products()->sync($request->products);
        return new ColorResource($color);
    }

    public function show(Color $color)
    {
        return new ColorResource($color);
    }

    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->all());
        $color->products()->sync($request->products);
       
        return new ColorResource($color);
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return response(null, 202);
    }
}
