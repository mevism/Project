<?php

use Illuminate\Support\Facades\Route;
use Modules\Lecturer\Http\Controllers\LecturerController;
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

Route::prefix('lecturer')->group(function() {
    Route::get('/', 'LecturerController@index');
    Route::get('/viewworkload', [LecturerController::class, 'viewworkload']) ->name ('lecturer.viewWorkload');
    Route::get('/qualifications', [LecturerController::class, 'qualifications']) ->name ('lecturer.qualifications');
    Route::get('/add-qualifications', [LecturerController::class, 'addqualifications'])->name('lecturer.addqualifications');
    Route::post('/store-Qualifications', [LecturerController::class, 'storeQualifications'])->name('lecturer.storeQualifications');
    Route::get('/my-areas-of-teaching', [LecturerController::class, 'teachingAreas'])->name('lecturer.teachingAreas');
    Route::get('/add-teaching-areas', [LecturerController::class, 'addTeachingAreas'])->name('lecturer.addTeachingAreas');
    Route::get('/store-teaching-areas', [LecturerController::class, 'storeTeachingAreas'])->name('lecturer.storeTeachingAreas');
});
