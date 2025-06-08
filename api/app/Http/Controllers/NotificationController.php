<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index(Request $req)
    {
        $req->validate([
            'per_page' => ['nullable', 'integer'],
            'is_read' => ['nullable', 'boolean'],
            'type' => ['nullable', 'integer', 'min:0', 'max:3']
        ]);
        $user = Auth::user();
        if (!$user || $user->role_id !== 3) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        $notifications = Notification::with(['booking']);
        $per_page = $req->filled('per_page') ? $req->input('per_page') : 6;

        if ($req->filled('is_read')) {
            $notifications = $notifications->where('is_read', true);
        }
        if ($req->filled('type')) {
            $notifications = $notifications->where('type', $req->input('type'));
        }
        $notifications = $notifications->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit($per_page)->get();

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return $this->res_success('', [
            'data' => NotificationResource::collection($notifications),
            'unread' => $unreadCount
        ]);
    }

    public function markAsRead(Request $request, $id)
    {

        $user = Auth::user();
        if (!$user || $user->role_id !== 3) {
            return response()->json([
                'result' => false,
                'error' => 'Hello'
            ], 403);
        }

        $request->merge(['id' => $id]);
        $request->validate(['id' => ['required', 'integer', 'min:1', 'exists:notifications,id']]);
        $notification = Notification::where('id', $id)->where('user_id', $user->id)->first();
        Log::info($notification);

        if (!$notification) {
            return response()->json([
                'result' => false,
                'error' => 'Notification not found'
            ], 404);
        }

        $notification->update(['is_read' => 1]);
        $notification->save();
        Log::info($notification);

        return response()->json([
            'result' => true,
            'message' => 'Notification marked as read',
            'data' => $notification
        ]);
    }
}

