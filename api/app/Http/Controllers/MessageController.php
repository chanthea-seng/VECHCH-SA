<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\ConversationeResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'message' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,application/pdf', 'max:2048'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'message' => $request->message,
            'file' => $filePath,
            'sender_id' => auth()->id(),
            'is_seen' => false,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function getMessages($conversation_id)
    {
        $conversation = Conversation::with(['sender', 'receiver'])
            ->where('id', $conversation_id)
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->firstOrFail();

        // Mark messages as seen (for the receiver)
        Message::where('conversation_id', $conversation_id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_seen', false)
            ->update(['is_seen' => true]);

        // Retrieve messages with sender relationship (no receiver needed)
        $messages = Message::with(['conversation', 'sender'])
            ->where('conversation_id', $conversation_id)
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $data = [
            'conversation' => new ConversationeResource($conversation),
            // 'conversation' => [
            //     'id' => $conversation->id,
            //     'sender' => $conversation->sender ? [
            //         'id' => $conversation->sender->id,
            //         'fullname' => $conversation->sender->fullname,
            //         'local_fullname' => $conversation->sender->local_fullname,
            //         'avatar' => asset('storage/' . $conversation->sender->avatar),
            //     ] : null,
            // 'receiver_id' => $conversation->receiver_id,
            // 'receiver_id' => $conversation->receiver ? [
            //     'fullname' => $conversation->receiver->fullname,
            //     'local_fullname' => $conversation->receiver->local_fullname,
            //     'avatar' => $conversation->receiver->avatar,
            // ] : null,
            // 'created_at' => $conversation->created_at,
            // ],
            'messages' => MessageResource::collection($messages),

            'pagination' => [
                'current_page' => $messages->currentPage(),
                'total_pages' => $messages->lastPage(),
                'total_items' => $messages->total(),
                'per_page' => $messages->perPage(),
            ]
        ];

        return $this->res_success('Get Message success', $data);
    }
    // public function getMessages($conversation_id)
    // {
    //     // Mark messages as seen
    //     Message::where('conversation_id', $conversation_id)
    //         ->where('sender_id', auth()->id())
    //         ->update(['is_seen' => true]);

    //     // Retrieve messages with pagination
    //     $messages = Message::with('conversation')
    //         ->where('conversation_id', $conversation_id)
    //         ->whereHas('conversation', function ($query) {
    //             $query->where('sender_id', auth()->id())
    //                 ->orWhere('receiver_id', auth()->id());
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);

    //     return $this->res_paginate('Messages retrieved successfully', MessageResource::collection($messages), $messages);
    // }
}
