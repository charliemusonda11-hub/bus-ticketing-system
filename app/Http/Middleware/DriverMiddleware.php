<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class DriverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
  public function handle(Request $request, Closure $next)
{
    if (Auth::check() && Auth::user()->role === 'driver') {
        return $next($request);
    }
    abort(403, 'Unauthorized – Driver access only.');
}
}
