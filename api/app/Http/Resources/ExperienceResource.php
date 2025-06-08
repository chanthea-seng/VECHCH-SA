<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\DateHelper;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'specialist_id' => $this->specialist_id,
            'specialist' => $this->specialist ? [
                'id' => $this->specialist->id,
                'name' => $this->specialist->name ?? null,
                'local_name' => $this->specialist->local_name ?? null,
            ] : null,
            'organization_name' => $this->organization_name,
            'position' => $this->position,
            'responsibilities' => $this->responsibilities,
            'start_date' => $this->start_date ? $this->start_date->format('Y-m-d') : null,
            'end_date' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
            'start' => $this->start_date ? DateHelper::translateDateToKhmer($this->start_date) : null,
            'end' => $this->end_date ? DateHelper::translateDateToKhmer($this->end_date) : null,
            'is_current' => $this->is_current,
            'location' => $this->location,
            'is_verified' => $this->is_verified,
        ];
    }
}
