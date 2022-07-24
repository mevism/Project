<?php

namespace Modules\Hostel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Accommodation
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
        if (!Auth::guard('user')->check() || !Auth::guard('user')->user()->role_id === 5){

            abort(403);
        }
        return $next($request);
    }
}
