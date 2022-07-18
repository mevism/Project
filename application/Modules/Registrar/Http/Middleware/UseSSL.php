<?php

namespace Modules\Registrar\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
use Redirect;

class UseSSL
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
        if( App::environment('production') ){
            return Redirect::secure($request->path());
        }
        return $next($request);
    }
}
