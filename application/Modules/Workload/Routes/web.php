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

//    Route::get('/', 'WorkloadController@index');


use Modules\Workload\Http\Controllers\WorkloadController;

Route::prefix('workload')->middleware(['is_cod'])->group(function() {

    Route::get('/department-workload', [WorkloadController::class, 'workloads'])->name('department.workload');
    Route::get('/yearly-workload/{id}', [WorkloadController::class, 'yearlyWorkloads'])->name('department.yearlyWorkloads');
    Route::get('/semester-workload/{id}', [WorkloadController::class, 'semesterWorkload'])->name('department.semesterWorkloads');
    Route::get('/class-units/{id}', [WorkloadController::class, 'classUnits'])->name('department.classUnits');
    Route::post('/allocate-unit', [WorkloadController::class, 'allocateUnit'])->name('department.allocateUnit');
    Route::get('/view-workloads', [WorkloadController::class, 'viewWorkload'])->name('department.viewWorkload');
    Route::get('/view-workloads-per-year/{id}', [WorkloadController::class, 'viewYearWorkload'])->name('department.viewYearWorkload');
    Route::post('/view-workloads-per-semester', [WorkloadController::class, 'viewSemesterWorkload'])->name('department.viewSemesterWorkload');

    Route::get('/delete-workload/{id}', [WorkloadController::class,'deleteWorkload'])->name('department.deleteWorkload');
    Route::post('/submit-workload', [WorkloadController::class,'submitWorkload'])->name('department.submitWorkload');
    Route::post('/resubmit-workload', [WorkloadController::class,'resubmitWorkload'])->name('department.resubmitWorkload');
    Route::post('/print-workload', [WorkloadController::class,'printWorkload'])->name('department.printWorkload');

});
