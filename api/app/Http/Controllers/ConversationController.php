<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationeResource;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function createConversation(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->input('receiver_id');

        $conversation = Conversation::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
        ]);

        return response()->json($conversation);
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        // if ($user->role_id == 1) {
        //     return response()->json([
        //         'result' => false,
        //         'message' => 'Permission denied: You cannot delete this.'
        //     ], 403);
        // }
        $conversations = Conversation::with([
            'messages' => function ($query) {
                $query->latest()->limit(1);
            },
            'sender',
            'receiver'
        ])
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->get();
        // return response()->json($conversations);
        return $this->res_success('Get successfully', ConversationeResource::collection($conversations));

    }
    public function getSenderId()
    {
        // rets
        $user = Auth::id();
        return response()->json([
            'result' => true,
            'message' => 'Get success',
            'data' => [
                'id' => $user
            ]
        ]);
    }
    public function findOrCreate(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->input('receiver_id');

        $conversation = Conversation::where('sender_id', $receiver_id)
            ->orWhere('receiver_id', $receiver_id)->first();

        if ($conversation) {
            return $this->res_success('get conversation successfully', $conversation->id);
        }

        $conversation = Conversation::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
        ]);

        return response()->json(['conversation_id' => $conversation->id]);
    }
}

