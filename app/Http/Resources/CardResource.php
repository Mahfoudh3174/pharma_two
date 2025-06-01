<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medication_id' => $this->medication_id,
            'quantity' => $this->quantity,
            'total_price' => $this->medication->price * $this->quantity, 
            'medication' => [
                'name' => $this->medication->name,
                'description' => $this->medication->description,
                'price' => $this->medication->price,
            ],
        ];
    }
}
