<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [

            'data' => [
                'id' => $this->id,
                'type' => 'post',
                'attributes' => [

                    'title' => $this->title,
                    'content' => $this->content

                ]
            ],

            'relationships' => [
                'user' => setRelationshipData('user', $this->user),
                'tags' => setRelationshipData('tag', $this->tags),
                'categories' => setRelationshipData('category', $this->categories),
                'comments' => setRelationshipData('comment', $this->comments),
            ],
            'links' => [
                'self' => route('posts.show', $this->id)
            ]

        ];
    }
}
