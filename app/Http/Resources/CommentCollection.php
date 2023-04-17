<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'version' => '1.0',
            'links' => [
                'self' => route('comments.index')
            ]
        ];
    }

    public function with($request)
    {
        return [
            "included" => [
                "users" => $this->collection->pluck("user")->unique()->values()->all(),
                "posts" => $this->collection->pluck("post")->unique()->values()->all(),
            ]
        ];
    }
}
