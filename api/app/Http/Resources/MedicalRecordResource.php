<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\DateHelper;
use App\Helpers\ScheduleHelper;
use App\Http\Resources\Booking\BookingCardResource;
use Carbon\Carbon;
use App\Helpers\GenerateHelper;

class MedicalRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $booking = $this->whenLoaded('booking');
        $patientAge = $booking && $booking->dob ? DateHelper::calculateAgeInKhmer($booking->dob) : null;

        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'doctor_id' => $this->doctor_id,
            'message' => $this->message,
            'created_at' => DateHelper::translateDateToKhmer($this->created_at, true),
            'created' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'updated_at' => DateHelper::translateDateToKhmer($this->updated_at, true),
            'patient_age' => $patientAge,
            'booking' => new BookingCardResource($booking),
            'invoice' => GenerateHelper::generateCode(10),
            'doctor' => new UserResource($this->whenLoaded('doctor')),
            'examinations' => ExaminationResource::collection($this->whenLoaded('examinations')),
            'prescriptions' => PrescriptionResource::collection($this->whenLoaded('prescriptions')),
        ];
    }
}
