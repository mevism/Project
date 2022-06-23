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
        Route::get('/cod/applications', [CODController::class, 'applications'])->name('cod.applications');
        Route::get('/cod/viewApplication/{id}', [CODController::class, 'viewApplication'])->name('cod.viewApplication');
        Route::get('/cod/batch', [CODController::class, 'batch'])->name('cod.batch');
        Route::post('/cod/batchSubmit', [CODController::class, 'batchSubmit'])->name('cod.batchSubmit');
        Route::get('/cod/acceptApplication/{id}', [CODController::class, 'acceptApplication'])->name('cod.acceptApplication');
        Route::post('/cod/rejectApplication/{id}', [CODController::class, 'rejectApplication'])->name('cod.rejectApplication');
    });
});
