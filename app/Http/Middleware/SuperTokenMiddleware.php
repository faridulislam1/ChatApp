<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperTokenMiddleware
{
    public function handle(Request $request, Closure $next)
{
    $superToken = config('app.super_token'); 
    $providedToken = $request->header('Token'); 

    if ($providedToken && $providedToken === $superToken) {
        $request->attributes->set('super_access', true);
    } else {
        $request->attributes->set('super_access', false);
        $request->attributes->set('error_message', 'Invalid or missing super token.');
    }

    return $next($request);
}

}
