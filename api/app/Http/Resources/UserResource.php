<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $baseData = [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'local_fullname' => $this->local_fullname,
            'phone_number' => $this->phone_number,
            'avatar' => asset($this->avatar === 'user/no_avatar.jpg'
                ? 'storage/user/no_avatar.jpg'
                : "storage/" . $this->avatar),
            'dob' => DateHelper::calculateAgeInKhmer($this->dob),
            'gender' => $this->gender,
            'email' => $this->email,
            'status' => $this->status ?? 'active',
            'role_id' => $this->role_id,
            'created_at' => DateHelper::translateDateToKhmer($this->created_at),
        ];

        if ($this->relationLoaded('doctorProfile') && $this->doctorProfile) {
            $baseData['doctor_profile'] = [
                'center_name' => $this->doctorProfile->center->name ?? 'N/A',
                'specialist_name' => $this->doctorProfile->specialist->name ?? 'N/A',
                'department_name' => $this->doctorProfile->department->name ?? 'N/A',
                'address' => $this->address ?? 'N/A',
            ];
        }

        return $baseData;
    }
}
