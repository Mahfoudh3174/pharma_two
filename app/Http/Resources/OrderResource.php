<?php

namespace App\Http\Resources;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'reference' => $this->reference,
            'reject_reason' => $this->reject_reason ?? null,
            'shipping_price' => $this->shipping_price??0,
            'total_amount' => $this->total_amount??0,
            'type' => $this->type ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pharmacy' =>new PharmacyResource($this->whenLoaded('pharmacy')),
            'medications' =>MedicationResource::collection($this->whenLoaded('medications')),
        ];
    }
}
