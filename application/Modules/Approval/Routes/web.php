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

Route::prefix('approval')->group(function() {
    Route::get('/', 'ApprovalController@login')->name('application.login');

    Route::group(['middleware' => ['cod']], function (){
        Route::get('/home', 'ApprovalController@dashboard')->name('approval.cod');
        Route::get('/pending', 'ApprovalController@pending')->name('approval.pending');
        Route::get('/approved', 'ApprovalController@approved')->name('approval.approved');
        Route::get('/rejected', 'ApprovalController@rejected')->name('approval.rejected');
        Route::get('/courses', 'ApprovalController@courses')->name('approval.courses');
        Route::get('/attendance', 'ApprovalController@attendance')->name('approval.attendance');
        Route::get('/years', 'ApprovalController@years')->name('approval.years');
        Route::get('/search', 'ApprovalController@search')->name('approval.search');
        Route::get('/report', 'ApprovalController@report')->name('approval.report');
        Route::get('/graph', 'ApprovalController@graph');
        Route::get('/pendingView', 'ApprovalController@viewPending');
        Route::get('/getIntakes', 'ApprovalController@getIntakes');
        Route::get('/allCourses', 'ApprovalController@allCourses');

        Route::post('/getYears', 'ApprovalController@getYears');
        Route::post('/getAttendance', 'ApprovalController@getAttendance');
        Route::post('/fetchData', 'ApprovalController@fetchData');
        Route::post('/getApplications', 'ApprovalController@candidate');
        Route::post('/getApplication', 'ApprovalController@getApplication');
        Route::post('/approveApplication', 'ApprovalController@approve');
        Route::post('/approveApplications', 'ApprovalController@approves');
        Route::post('/rejectApplication', 'ApprovalController@reject');
        Route::post('/getCandidate', 'ApprovalController@searchValue');
        Route::post('/push', 'ApprovalController@push');
        Route::post('/getCourses', 'ApprovalController@getCourses');
        Route::post('/addCourses', 'ApprovalController@addCourses');
        Route::post('/addAttendances', 'ApprovalController@addAttendances');
        Route::post('/allYears', 'ApprovalController@allYears');
        Route::post('/addCourse', 'ApprovalController@addCourse');
        Route::post('/addYears', 'ApprovalController@addYears');
        Route::post('/addAttendance', 'ApprovalController@addAttendance');
        Route::post('/removeCourses', 'ApprovalController@removeCourses');
        Route::post('/removeAttendance', 'ApprovalController@removeAttendance');
        Route::post('/removeYears', 'ApprovalController@removeYears');
        Route::post('/getReport', 'ApprovalController@getReport');
        Route::post('/searchCourses', 'ApprovalController@searchCourses');
        Route::post('/printApplications', 'ApprovalController@printApplications');
        Route::post('/classSession', 'ApprovalController@classSession');
        Route::post('/removeSession', 'ApprovalController@removeSession');

    });
});
