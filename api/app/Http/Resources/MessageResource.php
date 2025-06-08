<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'file' => $this->file ?: null,
            'is_seen' => $this->is_seen,
            'created_at' => $this->created_at->format('g:i A'),
            'sender_id' => $this->sender_id,
        ];
        // return [
        //     'id' => $this->id,
        //     'message' => $this->message,
        //     'file' => $this->file,
        //     'conversation_id' => $this->conversation_id,
        //     'is_seen' => $this->is_seen,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'sender_id' => $this->sender_id,
        //     'conversation' => [
        //         'id' => $this->conversation->id,
        //         'sender_id' => $this->conversation->sender_id,
        //         'receiver_id' => $this->conversation->receiver_id,
        //         'created_at' => $this->conversation->created_at,
        //         'updated_at' => $this->conversation->updated_at,
        //     ],
        // ];
    }
}
