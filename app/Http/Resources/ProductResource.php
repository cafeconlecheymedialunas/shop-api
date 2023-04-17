<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Color;

class ProductResource extends JsonResource
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
                'type' => 'product',
                'attributes' => [

                    'title' => $this->title,
                    'price' => $this->price,
                    'sale_price' => $this->sale_price,
                    'size' => $this->size,
                    'description' => $this->description,
                    'additional_info' => $this->additional_info,
                    'tech_details' => $this->tech_details

                ]
            ],

            'relationships' => [
                'ratings' => setRelationshipData('rating', $this->ratings),
                'tags' => setRelationshipData('tag', $this->tags),
                'categories' => setRelationshipData('category', $this->categories),
                'comments' => setRelationshipData('comment', $this->comments),
                'colors' => setRelationshipData('color', $this->colors),
                'orders' => setRelationshipData('order', $this->orders),
            ],
            'links' => [
                'self' => route('products.show', $this->id)
            ]

        ];
    }
}
