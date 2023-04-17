<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
                'type' => 'color',
                'attributes' => [

                    'hex_code' => $this->hex_code,
                    'label' => $this->label

                ]
            ],

            'relationships' => [
                'products' => setRelationshipData('product', $this->products)
            ],
            'links' => [
                'self' => route('colors.show', $this->id)
            ]

        ];
    }
}
