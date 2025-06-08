<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('sanctum');
        if(!$user)
        {
            return response()->json(
                [
                    'result' => false,
                    'message' => 'Plase login',
                    'data' => []
                ], 401
            );
        }
        return $next($request);
    }
}
