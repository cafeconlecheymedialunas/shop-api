<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
                'type' => 'category',
                'attributes' => [

                    'name' => $this->name,
                    'description' => $this->description,
                    'image' => $this->image
                ]
            ],

            'relationships' => [
                'posts' => setRelationshipData('post', $this->posts),
                'products' => setRelationshipData('product', $this->products)
            ],
            'links' => [
                'self' => route('categories.show', $this->id)
            ]

        ];
    }
}
