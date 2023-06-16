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


use Modules\Hostel\Http\Controllers\HostelController;

Route::prefix('hostel')
//    ->middleware(['user', 'auth', 'hostels'])
    ->group(function() {
//    Route::get('/', 'HostelController@index');
        Route::get('/', [HostelController::class, 'index'])->name('hostel.dashboard');
        Route::get('/allocations', [HostelController::class, 'allocations'])->name('hostel.allocations');

});
