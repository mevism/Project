<?php

use Modules\Medical\Http\Controllers\MedicalController;

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

Route::prefix('medical')->middleware(['web', 'auth:user'])->group(function() {
//    Route::get('/', 'MedicalController@index');
        Route::get('/', [MedicalController::class, 'index'])->name('medical.dashboard');
        Route::get('/admission', [MedicalController::class, 'admissions'])->name('medical.admissions');
        Route::get('/reviewAdmission/{id}', [MedicalController::class, 'reviewAdmission'])->name('medical.reviewAdmission');
        Route::get('/acceptAdmission/{id}', [MedicalController::class, 'acceptAdmission'])->name('medical.acceptAdmission');
        Route::post('/rejectAdmission/{id}', [MedicalController::class, 'rejectAdmission'])->name('medical.rejectAdmission');
        Route::post('/withholdAdmission/{id}', [MedicalController::class, 'withholdAdmission'])->name('medical.withholdAdmission');
        Route::get('/submitAdmission/{id}', [MedicalController::class, 'submitAdmission'])->name('medical.submitAdmission');
});
