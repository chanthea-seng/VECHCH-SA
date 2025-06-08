<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'verified' => $this->is_verify,
            'user' => [
                'fullname' => $this->user?->fullname ?? null,
                'local_fullname' => $this->user?->local_fullname ?? null,
                'bio' => $this->biography ?? null,
                'avatar' => $this->user ? asset('storage/' . $this->user->avatar) : asset('storage/user/no_avatar.jpg'),
                'languages' => json_decode($this->spoken_languages ?? '[]', true),
            ],
            'specialist' => [
                'name' => $this->specialist?->name ?? null,
                'local_name' => $this->specialist?->local_name ?? null,
            ],
            'department' => [
                'name' => $this->department?->name ?? null,
                'local_name' => $this->department?->local_name ?? null,
            ],
            'center' => [
                'name' => $this->center?->name ?? null,
                'local_name' => $this->center?->local_name ?? null,
            ],
        ];
    }
}
