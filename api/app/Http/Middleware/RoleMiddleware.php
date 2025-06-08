<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated',
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You don\'t have the required role'
                ], 403);
            }
            abort(403, 'Unauthorized action - Insufficient permissions');
        }

        return $next($request);
    }
}
