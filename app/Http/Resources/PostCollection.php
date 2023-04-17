<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
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
                'self' => route('posts.index')
            ]
        ];
    }

    public function with($request)
    {
        return [
            "included" => [
                "user" => $this->collection->pluck("user")->unique()->values()->all(),
                "categories" => $this->collection->pluck("categories")->unique()->values()->all(),
                "tags" => $this->collection->pluck("tags")->unique()->values()->all(),
                "comments" => $this->collection->pluck("comments")->unique()->values()->all(),
            ]
        ];
    }
}
