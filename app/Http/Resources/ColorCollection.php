<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ColorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'version' => '1.0',
            'links' => [
                'self' => route('colors.index')
            ]
        ];
        
    }

    public function with($request)
    {
        return [
            "included" => [
                "products" => $this->collection->pluck("products")->unique()->values()->all()
            ]
        ];
    }
}
