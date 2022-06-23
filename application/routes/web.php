<?php

use Illuminate\Support\Facades\Route;

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

// Example Routes
Route::view('/', 'userauth.login')->name('root');
Route::post('/login', [\App\Http\Controllers\User\UserController::class, 'login'])->name('user.login');
Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'dashboard'])->name('dashboard')->middleware(['student:auth']);
Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'dashboard'])->name('dashboard')->middleware('admin:auth');
Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'dashboard'])->name('dashboard')->middleware('cod:auth');
Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'dashboard'])->name('dashboard')->middleware('dean:auth');
Route::get('/logout', [\App\Http\Controllers\User\UserController::class, 'logout'])->name('logout');

Route::get('/mail', function (){ return view('mail'); });
