<?php

namespace App\Http;

use App\Http\Middleware\Admin\Admin;
use App\Http\Middleware\Applicant\Applicant;
use App\Http\Middleware\Applicant\Isverified;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Finance\Finance;
use App\Http\Middleware\Student\Student;
use App\Http\Middleware\COD\COD;
use App\Http\Middleware\DEAN\DEAN;
use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\User\Twofactorverification;
use App\Http\Middleware\User\Updatedprofile;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Modules\Hostel\Http\Middleware\Accommodation;
use Modules\Medical\Http\Middleware\Medical;
use Modules\Registrar\Http\Middleware\UseSSL;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => Admin::class,
        'applicant' => Applicant::class,
        'student' => Student::class,
        'is_cod' => COD::class,
        'dean' => DEAN::class,
        'authenticate' => Authenticate::class,
        'user_updated' => Updatedprofile::class,
        'is_verified' => Isverified::class,
        'finance' => Finance::class,
        'medical' => Medical::class,
        'ssl' => UseSSL::class,
        'hostels' => Accommodation::class,
    ];

}
