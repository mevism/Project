<?php

namespace App\Http\Middleware\Applicant;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Isverified
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
        if (Auth::user()->user_status == 1){
            return redirect()->route('application.applicant')->with('warning', 'First update your user profile to continue');
        }

        return $next($request);
    }
}
