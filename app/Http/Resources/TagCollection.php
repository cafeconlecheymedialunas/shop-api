<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'version' => '1.0',
            'links' => [
                'self' => route('tags.index')
            ]
        ];
    }

    public function with($request)
    {
        return [
            "included" => [
                "products" => $this->collection->pluck("products")->unique()->values()->all(),
                "posts" => $this->collection->pluck("posts")->unique()->values()->all(),
            ]
        ];
    }
}
