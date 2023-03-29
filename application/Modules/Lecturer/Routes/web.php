<?php

use Illuminate\Support\Facades\Route;
use Modules\Lecturer\Http\Controllers\LecturerController;
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

Route::prefix('lecturer')->group(function() {
    Route::get('/', 'LecturerController@index');
    Route::get('/view-workload', [LecturerController::class, 'viewworkload']) ->name ('lecturer.viewWorkload');
    Route::get('/qualifications', [LecturerController::class, 'qualifications']) ->name ('lecturer.qualifications');
    Route::get('/add-qualifications', [LecturerController::class, 'addqualifications'])->name('lecturer.addqualifications');
    Route::post('/store-Qualifications', [LecturerController::class, 'storeQualifications'])->name('lecturer.storeQualifications');
    Route::get('/edit-Qualifications/{id}', [LecturerController::class, 'editQualifications'])->name('lecturer.editQualifications');
    Route::post('/update-Qualifications/{id}', [LecturerController::class, 'updateQualifications'])->name('lecturer.updateQualifications');
    Route::get('/delete-Qualification/{id}', [LecturerController::class, 'deleteQualification'])->name('lecturer.deleteQualification');
    Route::get('/my-areas-of-teaching', [LecturerController::class, 'teachingAreas'])->name('lecturer.teachingAreas');
    Route::get('/add-teaching-areas', [LecturerController::class, 'addTeachingAreas'])->name('lecturer.addTeachingAreas');
    Route::post('/store-teaching-areas', [LecturerController::class, 'storeTeachingAreas'])->name('lecturer.storeTeachingAreas');
    Route::get('/lecture-view-yearly-workloads/{id}', [LecturerController::class, 'yearlyWorkloads'])->name('lecturer.yearlyWorkloads');
    Route::get('/lecture-view-semester-workload/{year}/{semester}', [LecturerController::class, 'semesterWorkload'])->name('lecturer.semesterWorkload');
    Route::get('/view-examination', [LecturerController::class, 'examination']) ->name ('lecturer.examination');
    Route::get('/view-yearly-exams/{id}', [LecturerController::class, 'yearlyExams'])->name('lecturer.yearlyExams');
    Route::get('/view-semester-exams/{year}/{semester}', [LecturerController::class, 'semesterExamination'])->name('lecturer.semesterExamination');
    Route::any('/get-students-per-unit/{id}/{unit_id}', [LecturerController::class, 'getClassStudents'])->name('lecturer.studentList');
    Route::get('/get-student-exam-marks', [LecturerController::class, 'getStudentExam'])->name('lecturer.getStudentExams');
    Route::any('/lecturer-save-student-marks', [LecturerController::class, 'storeMarks'])->name('lecturer.storeMarks');
    Route::any('/lecturer-update-student-marks', [LecturerController::class, 'updateMarks'])->name('lecturer.updateMarks');


    Route::get('/delete-teaching-area/{id}',[LecturerController::class, 'deleteTeachingArea'])->name('lecturer.deleteTeachingArea');
    Route::get('/myProfile' , [LecturerController::class, 'myProfile'])->name('lecturer.myProfile');
    Route::get('/edit-Myprofile', [LecturerController::class, 'editMyprofile'])->name('lecturer.editMyprofile');
    Route::post('/update-Myprofile/{id}', [LecturerController::class, 'updateMyprofile'])->name('lecturer.updateMyprofile');
    Route::post('/change-Password/{id}', [LecturerController::class, 'changePassword'])->name('lecturer.changePassword');
    Route::get('/qualification-Remark' , [LecturerController::class, 'qualificationRemark'])->name('lecturer.qualificationRemark');

});
