<?php

namespace App\Http\Resources;

use App\Http\Resources\Doctor\DoctorFullResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class saveDoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'fullname' => $this->user->fullname,
                'local_fullname' => $this->user->local_fullnames,
                // 'phone_number' => $this->phone_number,
                // 'avatar' => asset('storage/' . $this->user->avatar),
                // 'dob' => $this->user->dob,
                // 'gender' => $this->user->gender,
                // 'email' => $this->user->email
            ],
            // 'doctor' => new DoctorFullResource($this->doctor),
            'doctors' => $this->doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'fullname' => $doctor->fullname,
                    'local_fullname' => $doctor->local_fullnames,
                    'avatar' => asset('storage/' . $doctor->avatar), // Changed to $doctor->avatar
                    'languages' => json_decode($doctor->doctorProfile->spoken_languages, true),
                    'email' => $doctor->email,
                    'specialist' => $doctor->doctorProfile && $doctor->doctorProfile->specialist
                        ? [
                            'name' => $doctor->doctorProfile->specialist->name,
                            'local_name' => $doctor->doctorProfile->specialist->local_name,
                        ]
                        : null,
                    'department' => $doctor->doctorProfile && $doctor->doctorProfile->department
                        ? [
                            'name' => $doctor->doctorProfile->department->name,
                            'local_name' => $doctor->doctorProfile->department->local_name,
                        ]
                        : null,
                    'center' => $doctor->doctorProfile && $doctor->doctorProfile->center
                        ? [
                            'name' => $doctor->doctorProfile->center->name,
                            'local_name' => $doctor->doctorProfile->center->local_name,
                        ]
                        : null,
                ];
            })->toArray(), // Convert the mapped collection to an array
        ];
    }
}
