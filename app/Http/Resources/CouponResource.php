<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
                'type' => 'coupon',
                'attributes' => [

                    'limit' => $this->limit,
                    'type' => $this->type,
                    'discount' => $this->discount

                ]
            ],

            'relationships' => [
                'orders' => setRelationshipData('order', $this->orders),
            ],
            'links' => [
                'self' => route('coupons.show', $this->id)
            ]

        ];
    }
}
