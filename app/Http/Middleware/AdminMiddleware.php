<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (!$request->user()|| ($request->user() && $request->user()->role != 'Admin' ))
        {
            return new Response(view('unauthorized')->with('role', 'Admin'));
        }
        return $next($request);
    }

}
