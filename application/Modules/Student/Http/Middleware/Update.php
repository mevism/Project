<?php

namespace Modules\Student\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class Update
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
        $id = Auth::guard('student')->user()->student_id;
        $student = DB::table('students')
            ->where('id', $id)
            ->get();

        $checkField = ['citizen','county','sub_county','town','address','postal_code'];
        $moreProfile = [];
        foreach($student as $user)
            foreach($user as $key => $value)
                if(in_array($key,$checkField))
                    $moreProfile []= $value;

        if (in_array(null,$moreProfile))
            abort(403);

        return $next($request);
    }
}
