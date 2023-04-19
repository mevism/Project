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

use Modules\Examination\Http\Controllers\ExaminationController;

Route::prefix('examination')->group(function() {

    Route::get('/', 'ExaminationController@index')->name('examination');
    Route::get('/exams', [ExaminationController::class, 'registration'])->name('examination.registration');
    Route::get('/semester-exam/{year}/{semester}', [ExaminationController::class, 'semesterExams'])->name('examination.semesterExams');
    Route::get('/preview-exam-marks/{class}/{code}', [ExaminationController::class, 'previewExam'])->name('examination.previewExam');
    Route::get('/receive-exam/{class}/{code}', [ExaminationController::class, 'receiveExam'])->name('examination.receiveExam');

});
