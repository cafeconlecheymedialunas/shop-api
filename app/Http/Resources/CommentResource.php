<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
                'type' => 'comment',
                'attributes' => [

                    'title' => $this->title,
                    'comment' => $this->comment
                ]
            ],

            'relationships' => [
                'post' => setRelationshipData('post', $this->post),
                'user' => setRelationshipData('user', $this->user)
            ],
            'links' => [
                'self' => route("comments.show", (int)$this->id)
            ]

        ];
    }
}
