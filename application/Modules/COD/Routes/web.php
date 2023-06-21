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

use App\Http\Middleware\COD\COD;
use Modules\COD\Http\Controllers\CODController;

Route::middleware(['is_cod'])->prefix('department')->group( function() {

        Route::get('/cod', [CODController::class, 'index'])->name('cod.dashboard');
        Route::get('/applications', [CODController::class, 'applications'])->name('cod.applications');
        Route::get('/view-application/{id}', [CODController::class, 'viewApplication'])->name('cod.viewApplication');
        Route::get('/preview-application/{id}', [CODController::class, 'previewApplication'])->name('cod.previewApplication');
        Route::get('/batch', [CODController::class, 'batch'])->name('cod.batch');
        Route::post('/batch-bubmit', [CODController::class, 'batchSubmit'])->name('cod.batchSubmit');
        Route::get('/accept-application/{id}', [CODController::class, 'acceptApplication'])->name('cod.acceptApplication');
        Route::post('/reject-application/{id}', [CODController::class, 'rejectApplication'])->name('cod.rejectApplication');
        Route::post('/reverse-application/{id}', [CODController::class, 'reverseApplication'])->name('cod.reverseApplication');

        Route::get('/admissions', [CODController::class, 'admissions'])->name('cod.Admissions');
        Route::get('/review/{id}', [CODController::class, 'reviewAdmission'])->name('cod.reviewAdmission');
        Route::get('/accept/{id}', [CODController::class, 'acceptAdmission'])->name('cod.acceptAdmission');
        Route::post('/reject/{id}', [CODController::class, 'rejectAdmission'])->name('cod.rejectAdmission');
        Route::post('/withhold/{id}', [CODController::class, 'withholdAdmission'])->name('cod.withholdAdmission');
        Route::get('/submit/{id}', [CODController::class, 'submitAdmission'])->name('cod.submitAdmission');

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
        Route::get('/add-course/{id}', [CODController::class, 'intakeCourses'])->name('department.intakeCourses');
        Route::post('/add-available-courses', [CODController::class, 'addAvailableCourses'])->name('department.addAvailableCourses');
        Route::get('/courses-available-per-intake/{intake}', [CODController::class, 'viewDeptIntakeCourses'])->name('department.availableCourses');

        Route::get('/get-Classes', [CODController::class, 'deptClasses'])->name('department.classes');
        Route::get('/class-List/{id}', [CODController::class, 'classList'])->name('department.classList');


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
        Route::get('/view-selected-readmission-request/{id}', [CODController::class, 'selectedReadmission'])->name('department.selectedReadmission');
        Route::post('/accept-selected-readmission-request/{id}', [CODController::class, 'acceptReadmission'])->name('department.acceptReadmission');
        Route::post('/decline-selected-readmission-request/{id}', [CODController::class, 'declineReadmission'])->name('department.declineReadmission');


//        Route::get('/getAcademicFile/{id}', 'CODController@viewAcademicFile');

    /*Lecturer routes */
    Route::get('/department-lecturers', [CODController::class, 'departmentLectures'])->name('department.lecturers');
    Route::get('/department-lecturers-qualifications', [CODController::class, 'lecturesQualification'])->name('department.lecturesQualification');
    Route::get('/department-view-selected-lecturer-qualification/{id}', [CODController::class, 'viewLecturerQualification'])->name('department.viewQualification');
    Route::get('/department-view-selected-lecturer-teaching-areas/{id}', [CODController::class, 'viewLecturerTeachingArea'])->name('department.viewTeachingArea');
    Route::get('/department-approve-lecturer-qualification/{id}', [CODController::class, 'approveQualification'])->name('department.approveQualification');
    Route::post('/reject-lecturer-qualification-request/{id}', [CODController::class, 'rejectQualification'])->name('department.rejectQualification');
    Route::get('/department-approve-lecturer-teaching-area/{id}', [CODController::class, 'approveTeachingArea'])->name('department.approveTeachingArea');
    Route::post('/department-decline-lecturer-qualification/{id}', [CODController::class, 'declineTeachingArea'])->name('department.declineTeachingArea');


    Route::get('/yearly-results', [CODController::class, 'yearlyResults'])->name('department.yearlyResults');
    Route::get('/semester-results/{year}', [CODController::class, 'semesterResults'])->name('department.semesterResults');
    Route::get('/download-results/{sem}/{year}', [CODController::class, 'downloadResults'])->name('department.downloadResults');
    Route::get('/view-students-results/{class}/{sem}/{year}', [CODController::class, 'viewStudentResults'])->name('department.viewStudentResults');
    Route::get('/submit-exam-results/{sem}/{year}', [CODController::class, 'submitExamResults'])->name('department.submitExamResults');

    Route::get('/course-options/{id}', [CODController::class, 'courseOptions'])->name('department.courseOptions');
    Route::get('/add-course-options/{id}', [CODController::class, 'addCourseOption'])->name('department.addCourseOption');
    Route::get('/edit-course-options/{id}', [CODController::class, 'editCourseOption'])->name('department.editCourseOption');
    Route::post('/store-course-options', [CODController::class, 'storeCourseOption'])->name('department.storeCourseOption');
    Route::post('/update-course-options/{id}', [CODController::class, 'updateCourseOption'])->name('department.updateCourseOption');

});
