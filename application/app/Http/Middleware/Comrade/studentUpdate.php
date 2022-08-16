<?php

namespace App\Http\Middleware\Comrade;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class StudentUpdate
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

        if (in_array(null,$moreProfile)){

            dd('error');

            abort(403);
        }
        return $next($request);
    }
}
