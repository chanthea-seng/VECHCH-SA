<?php

namespace App\Http\Resources;
use App\Helpers\DateHelper;
use App\Http\Resources\Booking\BookingReourceNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'is_read' => $this->is_read,
            'is_approve' => $this->is_approve,
            // 'created_at' => DateHelper::translateDateToKhmer($this->created_at, true),
            'created_at' => DateHelper::translateRelativeTimeToKhmer($this->created_at),
            'book' => new BookingReourceNotification($this->booking) ?: null,

            // 'updated_at' => $this->updated_at,
        ];
    }
}
