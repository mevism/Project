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
    Route::post('/year-exam', [ExaminationController::class, 'yearExams'])->name('examination.yearExams');
    Route::any('/semester-exam', [ExaminationController::class, 'semesterExams'])->name('examination.semesterExams');
    Route::post('/preview-exam-marks', [ExaminationController::class, 'previewExam'])->name('examination.previewExam');
    Route::post('/receive-exam', [ExaminationController::class, 'receiveExam'])->name('examination.receiveExam');
    Route::post('/process-exam', [ExaminationController::class, 'processExam'])->name('examination.processExam');
    Route::any('/save-processed-exam-marks/', [ExaminationController::class, 'processMarks'])->name('examination.updateMarks');
    Route::post('/submit-exam-marks/', [ExaminationController::class, 'submitMarks'])->name('examination.submitMarks');

});
