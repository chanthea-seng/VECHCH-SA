<?php

namespace App\Http\Resources;

use App\Http\Resources\Service\ServiceFullResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'instruction' => $this->instruction,
            'service' => new ServiceFullResource($this->whenLoaded('services')),
        ];
    }
}
