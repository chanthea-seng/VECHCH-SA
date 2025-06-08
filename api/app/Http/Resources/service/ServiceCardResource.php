<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\DateHelper;
class ServiceCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'local_name' => $this->local_name,
            'description' => $this->description,
            'local_description' => $this->local_description,
            'service_type' => $this->service_type,
            'sub_services_count' => $this->sub_services_count,
            'sub_services' => $this->subServices,
            'local_created_at' => DateHelper::translateDateToKhmer($this->created_at),
            'created_at' => Carbon::parse($this->created_at)->format('d F Y'),
            'thumbnail' => asset('storage/' . optional($this->serviceImages->first())->image_path),
        ];
    }
}
