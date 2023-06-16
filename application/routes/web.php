<?php

use App\Http\Controllers\User\UserController;
use App\Http\Middleware\COD\COD;
use App\Http\Middleware\DEAN\DEAN;
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

//Route::middleware('auth')->group(function() {

    Route::view('/', 'userauth.login')->name('root');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [UserController::class, 'signOut'])->name('logout');

//Route::get('/mail', function (){ return view('mail'); });
