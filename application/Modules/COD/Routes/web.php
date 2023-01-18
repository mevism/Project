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
use Modules\COD\Http\Controllers\CODController;

Route::prefix('department')->middleware( ['is_cod'])->group( function() {
        Route::get('/cod', [CODController::class, 'index'])->name('cod.dashboard');
        Route::get('/applications', [CODController::class, 'applications'])->name('cod.applications');
        Route::get('/viewApplication/{id}', [CODController::class, 'viewApplication'])->name('cod.viewApplication');
        Route::get('/previewApplication/{id}', [CODController::class, 'previewApplication'])->name('cod.previewApplication');
        Route::get('/batch', [CODController::class, 'batch'])->name('cod.batch');
        Route::post('/batchSubmit', [CODController::class, 'batchSubmit'])->name('cod.batchSubmit');
        Route::get('/acceptApplication/{id}', [CODController::class, 'acceptApplication'])->name('cod.acceptApplication');
        Route::post('/rejectApplication/{id}', [CODController::class, 'rejectApplication'])->name('cod.rejectApplication');
        Route::post('/reverseApplication/{id}', [CODController::class, 'reverseApplication'])->name('cod.reverseApplication');

        Route::get('/admissions', [CODController::class, 'admissions'])->name('cod.Admissions');
        Route::get('/review/{id}', [CODController::class, 'reviewAdmission'])->name('cod.reviewAdmission');
        Route::get('/accept/{id}', [CODController::class, 'acceptAdmission'])->name('cod.acceptAdmission');
        Route::post('/reject/{id}', [CODController::class, 'rejectAdmission'])->name('cod.rejectAdmission');
        Route::post('/withhold/{id}', [CODController::class, 'withholdAdmission'])->name('cod.withholdAdmission');
        Route::get('/submit/{id}', [CODController::class, 'submitAdmission'])->name('cod.submitAdmission');
        Route::get('/submitAdmJab/{id}', [CODController::class, 'submitAdmJab'])->name('cod.submitAdmJab');


        Route::get('/create-class-pattern/{id}', [CODController::class, 'classPattern'])->name('cod.classPattern');
        Route::post('/submit-class-pattern', [CODController::class, 'storeClassPattern'])->name('cod.storeClassPattern');
        Route::post('/update-class-pattern/{id}', [CODController::class, 'updateClassPattern'])->name('cod.updateClassPattern');
        Route::get('/delete-class-pattern/{id}', [CODController::class, 'deleteClassPattern'])->name('cod.deleteClassPattern');
        Route::get('/view-classes-per-intake/{intake}', [CODController::class, 'viewIntakeClasses'])->name('department.viewIntakeClasses');
        Route::get('/view-semester-units-per-class/{id}', [CODController::class, 'viewSemesterUnits'])->name('department.viewSemesterUnits');
        Route::get('/add-semester-unit-per-class/{id}/{unit}', [CODController::class, 'addSemesterUnit'])->name('department.addSemesterUnit');
        Route::get('/drop-semester-unit-per-class/{id}', [CODController::class, 'dropSemesterUnit'])->name('department.dropSemesterUnit');


        Route::get('/courses', [CODController::class, 'courses'])->name('department.courses');


        Route::get('/intakes', [CODController::class, 'intakes'])->name('department.intakes');
        Route::get('/addCourse/{id}', [CODController::class, 'intakeCourses'])->name('department.intakeCourses');
        Route::post('/addAvailableCourses', [CODController::class, 'addAvailableCourses'])->name('department.addAvailableCourses');
        Route::get('/downstream', [CODController::class, 'downstream'])->name('raw.route');


        Route::get('/getClasses', [CODController::class, 'deptClasses'])->name('department.classes');
        Route::get('/classList/{id}', [CODController::class, 'classList'])->name('department.classList');


        Route::get('/admitStudent/{id}', [CODController::class, 'admitStudent'])->name('department.admitStudent');

        Route::get('/exam-results', [CODController::class, 'examResults'])->name('department.examResults');
        Route::get('/add-exam-results', [CODController::class, 'addResults'])->name('department.addResults');
        Route::post('/submit-exam-results', [CODController::class, 'submitResults'])->name('department.submitResults');
        Route::get('/edit-exam-results/{id}', [CODController::class, 'editResults'])->name('department.editResults');
        Route::post('/update-exam-results/{id}', [CODController::class, 'updateResults'])->name('department.updateResults');

        Route::get('/all-course-transfer-requests', [CODController::class, 'transferRequests'])->name('department.courseTransfers');
        Route::get('/view-student-transfer-request/{id}', [CODController::class, 'viewTransferRequest'])->name('department.viewTransferRequest');
        Route::get('/view-student-uploaded-document/{id}', [CODController::class, 'viewUploadedDocument'])->name('department.viewUploadedDocument');
        Route::get('/accept-student-transfer-request/{id}', [CODController::class, 'acceptTransferRequest'])->name('department.acceptTransferRequest');
        Route::post('/decline-student-transfer-request/{id}', [CODController::class, 'declineTransferRequest'])->name('department.declineTransferRequest');
        Route::get('/generate-list-of-all-transfer-requests/{year}', [CODController::class, 'requestedTransfers'])->name('department.requestedTransfers');
        Route::get('/view-yearly-course-transfer-requests/{year}', [CODController::class, 'viewYearRequests'])->name('department.viewYearRequests');

        Route::get('/view-list-of-departmental-academic-leave-transfers', [CODController::class, 'academicLeave'])->name('department.academicLeave');
        Route::get('/view-yearly-departmental-academic-leave-transfers/{year}', [CODController::class, 'yearlyAcademicLeave'])->name('department.yearlyLeaves');
        Route::get('/view-academic-leave-request/{id}', [CODController::class, 'viewLeaveRequest'])->name('department.viewLeaveRequest');
        Route::get('/accept-academic-leave/deferment-request/{id}', [CODController::class, 'acceptLeaveRequest'])->name('department.acceptLeaveRequest');
        Route::post('/decline-academic-leave/deferment-request/{id}', [CODController::class, 'declineLeaveRequest'])->name('department.declineLeaveRequest');


        Route::get('/get-readmission-requests-per-academic-year', [CODController::class, 'readmissions'])->name('department.readmissions');
        Route::get('/get-annual-readmission-requests-per-department/{year}', [CODController::class, 'yearlyReadmissions'])->name('department.yearlyReadmissions');
        Route::get('/get-intake-readmission-requests-per-department/{intake}/{year}', [CODController::class, 'intakeReadmissions'])->name('department.intakeReadmissions');


//        Route::get('/getAcademicFile/{id}', 'CODController@viewAcademicFile');

});
