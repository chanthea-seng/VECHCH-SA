<?php

namespace App\Http\Resources\Booking;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\SubServiceResource;
use App\Helpers\DateHelper;

class BookingCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'local_name' => $this->local_name,
            'dob' => DateHelper::calculateAgeInKhmer($this->dob),
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'appointment_time' => DateHelper::translateDateToKhmer($this->appointment_time, true),
            'appointment' => Carbon::parse($this->appointment_time)->format('d/m/Y H:i'),
            'description' => $this->description,
            'service_type' => $this->service_type,
            'booking_status' => $this->booking_status,
            'is_complete' => boolval($this->is_complete),
            'is_remove' => boolval($this->is_remove),
            // 'created_at' => DateHelper::translateDateToKhmer($this->created_at),
            'submit' => Carbon::parse($this->created_at)->format('d/m/Y H:i A'),
            'user' => [
                'id' => $this->user->id,
                'fullname' => $this->user->fullname,
                'avatar' => asset($this->user->avatar === 'user/no_avatar.jpg'
                    ? 'storage/user/no_avatar.jpg'
                    : "storage/" . $this->user->avatar),
                'email' => $this->user->email,
            ],
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'sub_service' => new SubServiceResource($this->whenLoaded('subService')),
        ];
    }
}
