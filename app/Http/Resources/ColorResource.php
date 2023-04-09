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

                    'hex_color' => $this->hex_color,
                    'label' => $this->label

                ]
            ],

            'relationships' => [
                'user' => setRelationshipData('user', $this->user),
                'book' => setRelationshipData('book', $this->book)
            ],
            'links' => [
                'self' => route('colors.show', $this->id)
            ]

        ];
    }
}
