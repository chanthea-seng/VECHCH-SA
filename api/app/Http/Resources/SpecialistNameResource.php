<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialistNameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'specialist_name' => $this->doctorProfile && $this->doctorProfile->specialist
                ? $this->doctorProfile->specialist->name
                : null,
        ];
    }
}
