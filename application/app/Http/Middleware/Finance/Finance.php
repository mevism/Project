<?php

namespace App\Http\Middleware\Finance;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Finance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('user')->check() || !Auth::guard('user')->user()->roles->first()->id == 3){

            abort(403);
        }
        return $next($request);
    }
}
