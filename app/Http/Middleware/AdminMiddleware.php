<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Allow admin and vendor roles
        if ($user->role === 'admin' || $user->role === 'vendor') {
            return $next($request);
        }

        return response()->json(['message' => 'Only admin or vendor can access this resource'], 403);
    }
}
