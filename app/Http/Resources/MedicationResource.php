<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicationResource extends JsonResource
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
            'name' => $this->name,
            'generic_name' => $this->generic_name,
            'dosage_form' => $this->dosage_form,
            'strength' => $this->strength,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => new CategoryResource($this->whenLoaded('category')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
