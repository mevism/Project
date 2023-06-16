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

//Route::prefix('user')->group(function() {
//    Route::get('/', 'UserController@index');
//});


//use Illuminate\Routing\Route;
use Modules\User\Http\Controllers\UserController;

Route::prefix('user')
//    ->middleware(['user', 'auth', 'admin'])
    ->group(function() {
    Route::get('/system-users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/fetchUser', [UserController::class,'fetchById'])->name('admin.userById');
    Route::get('/add-new-system-user', [UserController::class, 'addNewUser'])->name('admin.addNewUser');
    Route::post('/import-users-from-hr', [UserController::class, 'importUsers'])->name('admin.importUsers');
    Route::get('/get-departments-in-a-division', [UserController::class, 'divisionDepartment'])->name('admin.divisionDepartment');
    Route::get('/get-selected-department', [UserController::class, 'getDepartment'])->name('admin.getDepartment');
    Route::get('/update-selected-user/{id}', [UserController::class, 'addUserRole'])->name('admin.addUserRole');
    Route::post('/add-new-user-role/{id}', [UserController::class, 'storeUserRole'])->name('admin.storeUserRole');
});
