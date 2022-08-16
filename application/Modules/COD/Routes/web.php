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
use Modules\COD\Http\Controllers\CODController;

Route::prefix('department')->group(function() {
//    Route::get('/', 'CODController@index');
    Route::group(['middleware' => 'is_cod'], function (){
        Route::get('/cod', [CODController::class, 'index'])->name('cod.dashboard');
        Route::get('/applications', [CODController::class, 'applications'])->name('cod.applications');
        Route::get('/viewApplication/{id}', [CODController::class, 'viewApplication'])->name('cod.viewApplication');
        Route::get('/previewApplication/{id}', [CODController::class, 'previewApplication'])->name('cod.previewApplication');
        Route::get('/batch', [CODController::class, 'batch'])->name('cod.batch');
        Route::post('/batchSubmit', [CODController::class, 'batchSubmit'])->name('cod.batchSubmit');
        Route::get('/acceptApplication/{id}', [CODController::class, 'acceptApplication'])->name('cod.acceptApplication');
        Route::post('/rejectApplication/{id}', [CODController::class, 'rejectApplication'])->name('cod.rejectApplication');

        Route::get('/admission', [CODController::class, 'admissions'])->name('cod.admissions');
        Route::get('/review/{id}', [CODController::class, 'reviewAdmission'])->name('cod.reviewAdmission');
        Route::get('/accept/{id}', [CODController::class, 'acceptAdmission'])->name('cod.acceptAdmission');
        Route::post('/reject/{id}', [CODController::class, 'rejectAdmission'])->name('cod.rejectAdmission');
        Route::get('/submit/{id}', [CODController::class, 'submitAdmission'])->name('cod.submitAdmission');
    });
});
