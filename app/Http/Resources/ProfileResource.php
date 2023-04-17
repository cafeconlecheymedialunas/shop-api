<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
                'type' => 'profile',
                'attributes' => [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'address_street' => $this->address_street,
                    'address_appartment' => $this->address_appartment,
                    'address_town' => $this->address_town,
                    'address_state' => $this->address_state,
                    'address_country' => $this->address_country,
                    'address_postcode' => $this->address_postcode,
                    'phone' => $this->phone

                ]
            ],

            'relationships' => [
                'user' => setRelationshipData('user', $this->user)
            ],
            'links' => [
                'self' => route('profiles.show', $this->id)
            ]

        ];
    }
}
