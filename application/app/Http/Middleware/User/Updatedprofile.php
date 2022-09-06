<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Application\Emails\VerifyEmails;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;

class Updatedprofile
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
        if (Auth::user()->email_verified_at === NULL){

            VerifyEmail::create([
                'applicant_id' => Auth::user()->id,
                'verification_code' => Str::random(100),
            ]);

            $app = Auth::user();

            Mail::to($app->email)->send(new VerifyEmails($app));

            Auth::logout();

            return redirect()->route('root')->with('warning', 'Visit your email to verify your account');

        }

        if (Auth::user()->phone_verification === NULL){
            $verification_code = rand(1, 999999);

            $number = Auth::user()->mobile;

            VerifyUser::create([
                'applicant_id' => Auth::user()->id,
                'verification_code' => $verification_code,
            ]);

            return redirect(route('application.reverify'))->with(['info' => 'Enter the code send to your phone', 'code' => $verification_code, 'phone' => $number]);
        }

        if (Auth::user()->user_status === 0){
            return redirect()->route('application.details')->with('warning', 'First update your user profile to continue');
        }

        return $next($request);
    }
}
