<?php

namespace App\Http\Middleware\User;

use AfricasTalking\SDK\AfricasTalking;
use App\Http\Apis\AppApis;
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
    protected $appApi;

    public function __construct(AppApis $appApi){
        $this->appApi = $appApi;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\auth()->guard('web')->user()->email_verified_at == NULL){

//           return \auth()->guard('web')->user();

            VerifyEmail::create([
                'applicant_id' => \auth()->guard('web')->user()->applicant_id,
                'verification_code' => Str::random(100),
            ]);

            $app = \auth()->guard('web')->user();

            Mail::to($app->applicantContact->email)->send(new VerifyEmails($app));

            \auth()->guard('web')->logout();

            return redirect()->route('root')->with('warning', 'Visit your email to verify your account');

        }

        if (\auth()->guard('web')->user()->phone_verification == NULL){

            $verification_code = rand(1, 999999);

            VerifyUser::create([
                'applicant_id' => \auth()->guard('web')->user()->applicant_id,
                'verification_code' => $verification_code,
            ]);

            $phoneNumber =  auth()->guard('web')->user()->applicantContact->mobile;
            $message = 'Welcome to TUM online course application platform. Your verification code '. $verification_code. '. Please do not share this code with anyone.';
            $this->appApi->sendSMS($phoneNumber, $message);
            return redirect(route('application.reverify'))->with(['info' => 'Enter the code send to your phone']);
        }

        if (\auth()->guard('web')->user()->user_status == 0){
            return redirect()->route('application.details')->with('warning', 'First update your user profile to continue');
        }

        return $next($request);
    }
}
