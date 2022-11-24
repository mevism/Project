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

use Modules\Student\Http\Controllers\StudentController;

Route::prefix('student')->group(function() {

    Route::get('/', [StudentController::class, 'index'])->name('student');
    Route::get('/my-course', [StudentController::class, 'myCourse'])->name('student.mycourses');
    Route::get('/course-transfers', [StudentController::class, 'courseTransfers'])->name('student.coursetransfers');
    Route::get('/request-transfer', [StudentController::class, 'requestTransfer'])->name('student.requesttransfer');
    Route::get('/get-department-courses', [StudentController::class, 'getDeptCourses'])->name('student.getdeptcourse');
    Route::get('/get-courses-classes', [StudentController::class, 'getCourseClasses'])->name('student.getcourseclasses');
    Route::post('/submit-course-transfer-request', [StudentController::class, 'submitRequest'])->name('student.submittransferrequest');
    Route::get('/edit-course-transfer-request/{id}', [StudentController::class, 'editRequest'])->name('student.edittransferrequest');
    Route::post('/update-course-transfer-request/{id}', [StudentController::class, 'updateRequest'])->name('student.updatetransferrequest');
    Route::get('/delete-course-transfer-request/{id}', [StudentController::class, 'deleteRequest'])->name('student.deletetransferrequest');
    Route::get('/store-course-transfer-request/{id}', [StudentController::class, 'storeRequest'])->name('student.storetransferrequest');

    Route::get('/units-registration', [StudentController::class, 'unitRegistration'])->name('student.unitregistration');
    Route::get('/request-semester-registration', [StudentController::class, 'requestSemesterRegistration'])->name('student.requestRegistration');
    Route::post('/submit-semester-registration', [StudentController::class, 'registerSemester'])->name('student.registerSemester');
    Route::get('/view-units-in-selected-semester/{id}', [StudentController::class, 'viewSemesterUnits'])->name('student.viewSemesterUnits');


    Route::get('/request-academic-leave', [StudentController::class, 'academicLeave'])->name('student.requestacademicleave');
    Route::get('/request-deffer-or-academic-leave', [StudentController::class, 'requestLeave'])->name('student.academicleaverequest');
    Route::post('/submit-academic-leave-request', [StudentController::class, 'submitLeaveRequest'])->name('student.submitacademicleaverequest');
    Route::get('/edit-request-deffer-or-academic-leave/{id}', [StudentController::class, 'editLeaveRequest'])->name('student.editleaverequest');
    Route::post('/update-request-deffer-or-academic-leave/{id}', [StudentController::class, 'updateLeaveRequest'])->name('student.updateleaverequest');
    Route::get('/submits-request-deffer-or-academic-leave/{id}', [StudentController::class, 'submitsLeaveRequest'])->name('student.submitsleaverequest');
    Route::get('/delete-request-deffer-or-academic-leave/{id}', [StudentController::class, 'deleteLeaveRequest'])->name('student.deleteleaverequest');



    Route::get('/request-readmission', [StudentController::class, 'requestReadmission'])->name('student.requestreadmission');
    Route::get('/request-course-readmission', [StudentController::class, 'readmissionRequests'])->name('student.readmisionrequest');
    Route::post('/store-readmission-request', [StudentController::class, 'storeReadmissionRequest'])->name('student.storereadmissionrequest');



    Route::get('/discontinuation-status', [StudentController::class , 'discontinuationStatus'])->name('student.discontinuationstatus');
    Route::get('/check-exam-results', [StudentController::class, 'examResults'])->name('student.examresults');
    Route::get('/apply-for-retakes', [StudentController::class, 'applyRetake'])->name('student.retakes');


    Route::get('/generate-fees-statement', [StudentController::class, 'feesStatement'])->name('student.feesstatement');
    Route::get('/get-my-fee-statement', [StudentController::class, 'printStatement'])->name('student.printStatement');


    Route::get('/my-profile', [StudentController::class, 'myProfile'])->name('student.myprofile');

});
