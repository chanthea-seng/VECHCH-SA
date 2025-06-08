<?php

namespace App\Http\Resources\Booking;
use App\Helpers\GenerateHelper;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelateBookingResource extends JsonResource
{
    public function toArray(Request $request): array
    { {
            return [
                'id' => $this->id,
                'service_type' => $this->service_type,
                'local_name' => $this->local_name,
                'appointment_time' => DateHelper::translateDateToKhmer($this->appointment_time),
                'booking_status' => $this->booking_status,
                'description' => $this->description,
                'is_complete' => $this->is_complete,
                'invoice' => GenerateHelper::generateCode(10),
            ];
        }
    }
}
