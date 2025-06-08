<?php

namespace App\Http\Resources\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\DateHelper;
use Carbon\Carbon;

class BookingReourceNotification extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_time' => DateHelper::translateDateToKhmer($this->appointment_time),
            'submit' => Carbon::parse($this->created_at)->format('d/m/Y H:i A'),
            'doctor' => $this->doctor ? [
                'id' => $this->doctor->id,
                'fullname' => $this->doctor->fullname,
                'local_fullname' => $this->doctor->local_fullname,
                'avatar' => asset($this->doctor->avatar === 'user/no_avatar.jpg'
                    ? 'storage/user/no_avatar.jpg'
                    : "storage/" . $this->doctor->avatar),
            ] : [],
        ];
    }
}
