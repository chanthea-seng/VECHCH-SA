<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'conversation_id' => $this->id,
            'message' => new MessageResource($this->messages->first()) ?: null,
            'sender' => $this->sender ? [
                'id' => $this->sender->id,
                'fullname' => $this->sender->fullname,
                'local_fullname' => $this->sender->local_fullname,
                'avatar' => asset('storage/' . $this->sender->avatar),
            ] : null,
            // 'receiver_id' => $this->receiver_id,
            'receiver' => $this->receiver ? [
                'fullname' => $this->receiver->fullname,
                'local_fullname' => $this->receiver->local_fullname,
                'avatar' => asset('storage/' . $this->receiver->avatar),
            ] : null,
            'created_at' => $this->created_at->format('H:i A'),
        ];
    }
}
