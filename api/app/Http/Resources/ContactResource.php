<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'avatar' => asset('storage/' . $this->user->avatar),
            'name' => $this->fname . ' ' . $this->lname,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'message' => $this->message,
            'submit_date' => Carbon::parse($this->created_at)->format('d/m/Y H:i A'),
            'submit_short' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
