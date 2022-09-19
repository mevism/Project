<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class Twofactorverification
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
        if (!Auth::user()->phone_verified == 1){
            return 'verify phone';
        }
        if (Auth::user()->email_verified_at == NULL){
            return 'verify email';
        }
        return $next($request);
    }
}
