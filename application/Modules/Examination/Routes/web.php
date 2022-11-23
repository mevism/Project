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

Route::prefix('examination')->group(function() {

    Route::get('/', 'ExaminationController@index')->name('examination');
    Route::get('/registration', 'ExaminationController@registration')->name('examination.registration');

});
