<?php

namespace App\Http\Resources\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class BookingMiniCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $gender = $this->gender == 1 ? "Male" : "Female";
        return [
            'id' => $this->id,
            'name' => $this->name,
            'local_name' => $this->local_name,
            'gender' => $gender,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'appointment' => Carbon::parse($this->appointment_time)->format('d/m/Y H:i'),
            'description' => $this->description,
            'service_type' => $this->service_type,
            'booking_status' => $this->booking_status,
            'is_complete' => boolval($this->is_complete),
            'is_remove' => boolval($this->is_remove),
            'submit' => Carbon::parse($this->created_at)->format('d/m/Y H:i A'),
            'user' => [
                'id' => $this->user->id,
                'fullname' => $this->user->fullname,
                'avatar' => asset($this->user->avatar === 'user/no_avatar.jpg'
                    ? 'storage/user/no_avatar.jpg'
                    : "storage/" . $this->user->avatar),
                'email' => $this->user->email,
            ],
        ];
    }
}
