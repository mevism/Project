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

//Route::prefix('workload')->group(function() {
//    Route::get('/', 'WorkloadController@index');
//});


use Modules\Workload\Http\Controllers\WorkloadController;

Route::get('/department-workload', [WorkloadController::class, 'workloads'])->name('department.workload');
