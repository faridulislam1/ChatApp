<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperTokenMiddleware
{
      public function handle(Request $request, Closure $next)
    {
        $superToken = env('SUPER_TOKEN');
        $providedToken = $request->header('Token');

        if ($providedToken && $providedToken === $superToken) {
         
            $request->attributes->set('super_access', true);
        }

        return $next($request);
    }
}
