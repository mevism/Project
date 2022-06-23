<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Route::prefix('application')->group(function () {
        Route::get('/', 'ApplicationController@login')->name('application.login');
        Route::post('/signin', 'ApplicationController@signin')->name('application.signin');
        Route::get('/register', 'ApplicationController@register')->name('application.register');
        Route::post('/signup', 'ApplicationController@signup')->name('application.signup');
        Route::get('/reloadCaptcha', 'ApplicationController@reloadCaptcha')->name('application.reloadCaptcha');
        Route::post('/verifiedphone', 'ApplicationController@phoneVerification')->name('application.phoneverification');
        Route::post('/phone/verification', 'ApplicationController@phonereverification')->name('application.phonereverification');
        Route::get('/verification', 'ApplicationController@reverify')->name('application.reverify');
        Route::get('/verifyemail/{verification_code}', 'ApplicationController@emailVerification')->name('application.emailverification');
        Route::get('/confirmed', 'ApplicationController@checkverification')->name('application.verification');
        Route::get('/verifyphone', 'ApplicationController@verifyemail')->name('application.phoneverify');
        Route::get('/details', 'ApplicationController@details')->name('application.details')->middleware('auth');
        Route::get('/verifyphone', 'ApplicationController@phoneverify')->name('application.phone');



        Route::get('/logout', 'ApplicationController@logout')->name('application.logout');

        Route::group(['middleware' => ['auth', 'is_verified']], function (){
            Route::post('/updateDetails', 'ApplicationController@makeupdate')->name('application.updateDetails');
        });

        Route::group(['middleware' => ['user_updated', 'auth']], function (){
            Route::get('/applicant', 'ApplicationController@dashboard')->name('application.applicant');
            Route::get('/course', 'ApplicationController@myCourses')->name('applicant.course');
            Route::get('/courses', 'ApplicationController@allCourses')->name('applicant.courses');
            Route::get('/apply', 'ApplicationController@apply')->name('applicant.apply');
            Route::get('/applyNow/{course}', 'ApplicationController@applyNow')->name('application.apply');;
            Route::get('/viewCourse/{course}', 'ApplicationController@viewCourse')->name('application.viewOne');;
            Route::post('/submitApplication', 'ApplicationController@application')->name('application.save');
            Route::get('/profile', 'ApplicationController@myProfile')->name('applicant.profile');
            Route::post('/submit/Application', 'ApplicationController@application')->name('application.submit');
            Route::get('/application/edit/{id}', 'ApplicationController@applicationEdit')->name('application.edit');
        });

    });

