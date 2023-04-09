<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
                'type' => 'tag',
                'attributes' => [

                    'name' => $this->name

                ]
            ],

            'relationships' => [
                'user' => setRelationshipData('user', $this->user),
                'book' => setRelationshipData('book', $this->book)
            ],
            'links' => [
                'self' => route('tags.show', $this->id)
            ]

        ];
    }
}
