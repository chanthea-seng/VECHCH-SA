<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized. Token may be missing or invalid.',
            ], 401);
        }

        $request->validate([
            'current_password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'result' => false,
                'message' => 'Current password is incorrect',
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Password reset successfully',
        ]);
    }
    public function info(Request $request)
    {
        $request->validate([
            'fullname' => ['nullable', 'string', 'max:255'],
            'local_fullname' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]{7,15}$/'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        try {
            $user = Auth::user();
            $user->fill($request->only(['fullname', 'local_fullname', 'phone_number', 'dob', 'gender', 'email']));
            $user->save();

            return response()->json([
                'result' => true,
                'message' => 'User updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred while updating user info.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $req, $id)
    {
        $user = Auth::user();

        if ($user->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        ;
        $user = User::findOrFail($id);
        $user->delete();
        return $this->res_success('Delete account success');
    }

    public function updateAvatar(Request $request)
    {
        $loginID = Auth::id();

        $request->validate([
            'avatar' => ['nullable', 'mimetypes:image/jpeg,image/png,image/jpg', 'max:2048'],
        ]);

        $user = User::findOrFail($loginID);
        $defaultAvatar = 'user/no_avatar.jpg';

        // Handle avatar reset or removal
        if (!$request->hasFile('avatar')) {
            // Only delete and reset if not already the default avatar
            if ($user->avatar && $user->avatar !== $defaultAvatar) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->avatar = $defaultAvatar;
                $user->save();

                return response()->json([
                    'result' => true,
                    'message' => 'Avatar reset successfully',
                    'avatar_url' => asset("storage/{$user->avatar}")
                ]);
            }

            // If already default avatar, just return success
            return response()->json([
                'result' => true,
                'message' => 'No changes made to avatar',
                'avatar_url' => asset("storage/{$user->avatar}")
            ]);
        }

        // Handle new avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists and isn't default
            if ($user->avatar && $user->avatar !== $defaultAvatar) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            $path = $request->file('avatar')->store('user', 'public');
            $user->update(['avatar' => $path]);

            return response()->json([
                'result' => true,
                'message' => 'Avatar updated successfully',
                'avatar_url' => asset("storage/{$user->avatar}")
            ]);
        }
    }


    public function deleteAvatar(Request $request)
    {
        $loginID = Auth::id();
        $request->validate([
            // 'id' => ['required', 'integer', 'min:1', 'exists:users,id'],
        ]);

        $user = User::findOrFail($loginID);

        // Check if user exists and has an avatar to delete
        if ($user && $user->avatar !== 'user/no_avatar.jpg') {
            // Delete the old avatar if it exists in storage
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Update the user's avatar to default
            $user->avatar = 'user/no_avatar.jpg';
            $user->save();

            return response()->json([
                'result' => true,
                'message' => 'Avatar reset successfully',
                //'avatar' => $user->avatar
            ]);
        }

        return response()->json([
            'result' => false,
            'message' => 'No avatar to reset or already using default avatar',
            //'avatar' => $user->avatar
        ]);
    }
}
