<?php

namespace App\Http\Middleware;

use Closure;

class MileApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->token == null) {
            return redirect('/fail');
        }
        return $next($request);
    }
}
