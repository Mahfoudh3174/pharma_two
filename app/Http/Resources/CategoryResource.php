<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "ar_name" => $this->ar_name,
            "svg_logo" => $this->svg_logo,
            "medications_count" => $this->whenCounted('medications'),
            "medications" => MedicationResource::collection($this->whenLoaded('medications')),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
