<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileCollection extends ResourceCollection
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
                'self' => route('profiles.index')
            ]
        ];
    }
    public function with($request)
    {
        return [
            "included" => [
               "user" => $this->collection->pluck("user")->unique()->values()->all()
            ]
        ];
    }
}
