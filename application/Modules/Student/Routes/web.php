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

use Modules\Student\Http\Controllers\StudentController;

Route::prefix('student')->group(function() {
//    Route::get('/', 'StudentController@index')->name('student');
    Route::group(['middleware' => ['student']], function (){

        Route::get('/', [StudentController::class, 'index'])->name('student');
        Route::get('/profile', [StudentController::class, 'profile'])->name('student_profile');
        Route::get('/change_course', [StudentController::class, 'change_course'])->name('change_course');
        Route::get('/student_profile', [StudentController::class, 'student_profile']);
        Route::get('/checkName', [StudentController::class, 'checkName']);
        Route::post('/platform_courses', [StudentController::class, 'platform_courses']);
        Route::post('/selectCourses', [StudentController::class, 'selectCourses']);
        Route::get('/getCourses', [StudentController::class, 'getCourses']);
        Route::get('/checkChange', [StudentController::class, 'checkChange']);
        Route::get('/getTransferLogs', [StudentController::class, 'getTransferLogs']);
    });
});
