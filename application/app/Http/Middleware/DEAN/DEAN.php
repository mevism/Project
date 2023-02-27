<?php

namespace App\Http\Middleware\DEAN;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DEAN
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
        if (!Auth::guard('user')->check() || !Auth::guard('user')->user()->roles->first()->id == 4){

            return redirect()->back()->with('error', 'Oops!! An Unauthorised attempt');
        }
        return $next($request);
    }
}
