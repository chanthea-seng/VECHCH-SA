<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\DateHelper;

class ServiceFullResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'local_name' => $this->local_name,
            'description' => $this->description,
            'local_description' => $this->local_description,
            'instruction' => html_entity_decode($this->instruction, ENT_QUOTES, 'UTF-8'),
            'service_type' => $this->service_type,
            'local_created_at' => DateHelper::translateDateToKhmer($this->created_at),
            'created_at' => Carbon::parse($this->created_at)->format('d F Y'),
            'sub_services' => $this->subServices,
            'service_images' => $this->serviceImages->map(function ($image) {
                return ['url' => asset('storage/' . $image->image_path)];
            }),
        ];
    }
}
