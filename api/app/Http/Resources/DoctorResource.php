<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->fullname,
            'local_fullname' => $this->local_fullname,
            'avatar' => asset($this->avatar == 'user/no_avatar.jpg'
                ? 'storage/user/no_avatar.jpg'
                : "storage/" . $this->avatar),
        ];
    }
}
