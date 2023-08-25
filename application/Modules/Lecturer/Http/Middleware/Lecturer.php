<?php

namespace Modules\Lecturer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lecturer
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
        if (!auth()->guard('user')->check() || !auth()->guard('user')->user()->roles->first()->id == 10){
            return redirect()->back()->with('error', 'An authorized access dined');
        }
        return $next($request);
    }
}
