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

use Modules\Administrator\Http\Controllers\AdministratorController;

Route::prefix('administrator')->group(function() {
//    Route::get('/', 'AdministratorController@index');

    Route::get('/show-all-university-departments', [AdministratorController::class, 'showAllDepartment'])->name('admin.showDepartment');
    Route::get('/add-a-department', [AdministratorController::class, 'addDepartment'])->name('admin.addDepartment');
    Route::post('/store-a-department', [AdministratorController::class, 'storeDepartment'])->name('admin.storeDepartment');
    Route::post('/update-a-department', [AdministratorController::class, 'updateDepartment'])->name('admin.updateDepartment');
    Route::get('/edit-a-department', [AdministratorController::class, 'editDepartment'])->name('admin.editDepartment');

});
