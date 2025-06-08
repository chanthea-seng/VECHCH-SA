<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function upgradeToManager(Request $request, $id)
    {
        $admin = auth()->user();
        if ($admin->role_id !== 1) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->update(['role_id' => 2]);

        return response()->json([
            'message' => 'User upgraded to Manager'
        ], 200);
    }
}
