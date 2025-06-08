<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateDoctorProfile
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'specialty' => 'sometimes|string|max:255',
            'license_number' => 'sometimes|string|max:100',
            'bio' => 'sometimes|string|max:1000',
        ]);

        return $next($request);
    }
}
