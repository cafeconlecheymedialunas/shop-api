<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CouponResource;


class CouponCollection extends ResourceCollection
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
                'self' => route('products.index')
            ],
            "included" => [
                "orders" => OrderResource::collection($this->collection->pluck("order")->unique()->values()->all())
            ]
        ];
    }
}
