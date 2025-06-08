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

            'quantity' => $this->quantity,
             'total_price' => $this->total_price,
            'medication' => $this->whenLoaded('medication',
             new MedicationResource($this->medication)),
             'pharmacy'=>$this->whenLoaded('pharmacy',
             new PharmacyResource($this->pharmacy))
        ];
    }
}
