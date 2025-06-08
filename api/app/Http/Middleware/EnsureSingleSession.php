<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSingleSession
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user) {
            $currentToken = $request->bearerToken();
            $tokenExists = $user->tokens()->where('token', hash('sha256', $currentToken))->exists();

            if (!$tokenExists) {
                return response()->json([
                    'result' => false,
                    'message' => 'Session expired due to new login'
                ], 401);
            }
        }
        return $next($request);
    }
}
