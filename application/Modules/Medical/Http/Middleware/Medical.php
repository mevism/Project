<?php

namespace Modules\Medical\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Medical
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
        if (!Auth::guard('user')->check() || !Auth::guard('user')->user()->role_id === 8){
            abort(403)->with('error', 'Only medical staff members are allowed');
        }
        return $next($request);
    }
}
