<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Http\Request;

class AdminRestrictMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isAdmin()) {    
            return $next($request);
        }

        abort(403);
    }
}
