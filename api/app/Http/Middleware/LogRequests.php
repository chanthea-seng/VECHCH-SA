<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('API Request', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $request->user()?->id ?? 'guest',
            'ip' => $request->ip(),
        ]);

        return $next($request);
    }
}
