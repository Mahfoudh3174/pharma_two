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
        'pivot_quantity' => $this->pivot->quantity ?? null,
        'total_price' => $this->pivot->total_price ?? null,
            'price' => $this->price,
            'imageUrl' => $this->image ?? null,
            'quantity' => $this->quantity,
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pharmacy' => new PharmacyResource($this->whenLoaded('pharmacy')),
        ];
    }
}
