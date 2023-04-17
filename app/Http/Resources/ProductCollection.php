<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
  
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'version' => '1.0',
            'links' => [
                'self' => route('products.index')
            ]
        ];
    }

    public function with($request)
    {
        return [
            "included" => [
                "orders" => $this->collection->pluck("orders")->unique()->values()->all(),
                "categories" => $this->collection->pluck("categories")->unique()->values()->all(),
                "tags" => $this->collection->pluck("tags")->unique()->values()->all(),
                "ratings" => $this->collection->pluck("ratings")->unique()->values()->all(),
                "colors" => $this->collection->pluck("colors")->unique()->values()->all(),
            ]
        ];
    }
}
