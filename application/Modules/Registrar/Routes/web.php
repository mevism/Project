<?php

use Modules\Registrar\Entities\School;
use Modules\Registrar\Http\Controllers\CoursesController;

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

Route::prefix('registry')->middleware(['web', 'auth:user', 'is_admin'])->group(function() {
    Route::get('/show-semester-fee', [CoursesController::class, 'showSemFee'])->name('courses.showSemFee');
    Route::get('/semFee/{id}', [CoursesController::class, 'semFee'])->name('courses.semFee');
    Route::post('/store-semester-fee', [CoursesController::class, 'storeSemFee'])->name('courses.storeSemFee');
    Route::get('/view-semester-fee/{id}', [CoursesController::class, 'viewSemFee'])->name('courses.viewSemFee');
    Route::get('/print-fee/{id}', [CoursesController::class, 'printFee'])->name('courses.printFee');
    Route::get('/view-course-fee-structures/{id}', [CoursesController::class, 'courseFeeStures'])->name('courses.courseFeeStructure');
    //chargeable voteheads
    Route::get('/add-chargeable-voteheads', [CoursesController::class,'addChargeableVotehead'])->name('courses.addChargeableVotehead');
    Route::get('/chargeable-voteheads', [CoursesController::class,'showChargeableVoteheads'])->name('courses.showChargeableVoteheads');
    Route::get('get-chargeable-voteheads', [CoursesController::class,'getChargeableVoteheads'])->name('courses.getChargeableVoteheads');
    Route::post('/stores-voteheads', [CoursesController::class,'storeChargeableVoteheads'])->name('courses.storeChargeableVoteheads');
    Route::get('/delete-chargeable-voteheads/{id}', [CoursesController::class,'destroyChargeableVotehead'])->name('courses.destroyChargeableVotehead');

    //routes on fee
    Route::get('/voteheads', [CoursesController::class, 'voteheads'])->name('courses.voteheads');
    Route::get('/get-voteheads-from-api', [CoursesController::class, 'getVoteheads'])->name('courses.getVoteheads');
    Route::get('/show-voteheads', [CoursesController::class, 'showVoteheads'])->name('courses.showVoteheads');
    Route::post('/store-voteheads', [CoursesController::class, 'storeVoteheads'])->name('courses.storeVoteheads');
    Route::get('/edit-votehead/{id}', [CoursesController::class, 'editVotehead'])->name('courses.editVotehead');
    Route::get('/destroy-votehead/{id}', [CoursesController::class, 'destroyVotehead'])->name('courses.destroyVotehead');
    Route::put('/update-votehead/{id}', [CoursesController::class, 'updateVotehead'])->name('courses.updateVotehead');

    Route::get('/export-kuccps', [CoursesController::class, 'exportkuccps'])->name('courses.exportkuccps');
    Route::get('/import-export-view-kuccps',[CoursesController::class, 'importExportViewkuccps'])->name('courses.importExportViewkuccps');
    Route::post('/import-kuccps',[CoursesController::class, 'importkuccps'])->name('courses.importkuccps');
    Route::get('/preview/{id}', [CoursesController::class, 'preview'])->name('courses.preview');
    Route::get('/view-application/{id}', [CoursesController::class, 'viewApplication'])->name('courses.viewApplication');
    Route::get('/accept-application/{id}', [CoursesController::class, 'acceptApplication'])->name('courses.acceptApplication');
    Route::post('/reject-application/{id}', [CoursesController::class, 'rejectApplication'])->name('courses.rejectApplication');

    Route::get('/import-export-cluster-weights',[CoursesController::class, 'importExportclusterWeights'])->name('courses.importExportclusterWeights');
    Route::post('/import-cluster-weights',[CoursesController::class, 'importclusterWeights'])->name('courses.importclusterWeights');

    Route::get('/import-unit-programms',[CoursesController::class, 'importUnitProgramms'])->name('courses.importUnitProgramms');
    Route::post('/import-unit-programms',[CoursesController::class, 'importUnitProg'])->name('courses.importUnitProg');

    Route::get('/import-unit',[CoursesController::class, 'importUnit'])->name('courses.importUnit');
    Route::post('/import-unit',[CoursesController::class, 'importUnits'])->name('courses.importUnits');

    Route::get('/import-export-courses',[CoursesController::class, 'importExportCourses'])->name('courses.importExportCourses');
    Route::post('/import-courses',[CoursesController::class, 'importCourses'])->name('courses.importCourses');

    Route::get('/create-units/{id}',[CoursesController::class, 'createUnits'])->name('courses.createUnits');
    Route::post('/store-created-units', [CoursesController::class, 'storeCreatedUnits'])->name('courses.storeCreatedUnits');

    Route::get('/archived', [CoursesController::class, 'archived'])->name('courses.archived');
    Route::get('/applications', [CoursesController::class, 'applications'])->name('courses.applications');
    Route::get('/show-kuccps', [CoursesController::class, 'showKuccps'])->name('courses.showKuccps');
    Route::get('/offer', [CoursesController::class, 'offer'])->name('courses.offer');
    Route::get('/profile', [CoursesController::class, 'profile'])->name('courses.profile');
    Route::get('/destroy-courses-available/{id}', [CoursesController::class, 'destroyCoursesAvailable'])->name('courses.destroyCoursesAvailable');
    Route::post('/accepted-mail', [CoursesController::class, 'acceptedMail'])->name('courses.acceptedMail');


    //routes on intakes
    Route::get('/', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('approve-index', [CoursesController::class, 'approveIndex'])->name('courses.approveIndex');
    Route::get('/add-intake/{id}', [CoursesController::class, 'addIntake'])->name('courses.addIntake');
    Route::post('/store-intake/{id}', [CoursesController::class, 'storeIntake'])->name('courses.storeIntake');
    Route::get('/show-intake', [CoursesController::class,'showIntake'])->name('courses.showIntake');
    Route::get('/edit-intake/{id}', [CoursesController::class, 'editIntake'])->name('courses.editIntake');
    Route::post('/update-intake/{id}', [CoursesController::class, 'updateIntake'])->name('courses.updateIntake');
    Route::get('/destroy-intake/{id}', [CoursesController::class, 'destroyIntake'])->name('courses.destroyIntake');
    Route::get('/view-intake/{id}', [CoursesController::class, 'viewIntake'])->name('courses.viewIntake');
    Route::get('/view-course/{id}', [CoursesController::class, 'viewCourse'])->name('courses.viewCourse');
    Route::post('/status-intake/{id}', [CoursesController::class,'statusIntake'])->name('courses.statusIntake');
    Route::get('/edit-status-intake/{id}', [CoursesController::class, 'editstatusIntake'])->name('courses.editstatusIntake');


    Route::get('/add-year', [CoursesController::class, 'addYear'])->name('courses.addYear');
    Route::get('/academic-year', [CoursesController::class, 'academicYear'])->name('courses.academicYear');
    Route::post('/store-year', [CoursesController::class, 'storeYear'])->name('courses.storeYear');
    Route::get('/destroy-year/{id}', [CoursesController::class, 'destroyYear'])->name('courses.destroyYear');
    Route::get('/show-semester/{id}', [CoursesController::class, 'showSemester'])->name('courses.showSemester');
    Route::get('/edit-academic-year/{id}', [CoursesController::class, 'editAcademicYear'])->name('courses.editAcademicYear');
    Route::post('/update-academic-year/{id}', [CoursesController::class, 'updateAcademicYear'])->name('courses.updateAcademicYear');

    //routes on school
    Route::get('/add-school', [CoursesController::class,'addSchool'])->name('courses.addSchool');
    Route::post('/store-school', [CoursesController::class,'storeSchool'])->name('courses.storeSchool');
    Route::get('/show-school', [CoursesController::class,'showSchool'])->name('courses.showSchool');
    Route::get('/edit-school/{id}', [CoursesController::class, 'editSchool'])->name('courses.editSchool');
    Route::put('/update-school/{id}', [CoursesController::class,'updateSchool'])->name('courses.updateSchool');
    Route::get('/destroy-school/{id}', [CoursesController::class,'destroySchool'])->name('courses.destroySchool');

    //routes on departments
    Route::get('/add-department', [CoursesController::class,'addDepartment'])->name('courses.addDepartment');
    Route::post('/store-department', [CoursesController::class,'storeDepartment'])->name('courses.storeDepartment');
    Route::get('/show-department', [CoursesController::class,'showDepartment'])->name('courses.showDepartment');
    Route::get('/edit-department/{id}', [CoursesController::class,'editDepartment'])->name('courses.editDepartment');
    Route::put('/update-department/{id}', [CoursesController::class,'updateDepartment'])->name('courses.updateDepartment');

    //routes on courses
    Route::get('/add-course', [CoursesController::class,'addCourse'])->name('courses.addCourse');
    Route::post('/store-course', [CoursesController::class,'storeCourse'])->name('courses.storeCourse');
    Route::get('/show-course', [CoursesController::class,'showCourse'])->name('courses.showCourse');
    Route::get('/edit-course/{id}', [CoursesController::class,'editCourse'])->name('courses.editCourse');
    Route::get('/syllabus/{course_id}', [CoursesController::class,'syllabus'])->name('courses.syllabus');
    Route::put('/update-course/{id}', [CoursesController::class,'updateCourse'])->name('courses.updateCourse');

    //routes on attendance/ mode of study
    Route::get('/add-attendance', [CoursesController::class, 'addAttendance'])->name('courses.addAttendance');
    Route::post('/store-attendance', [CoursesController::class, 'storeAttendance'])->name('courses.storeAttendance');
    Route::get('/show-attendance', [CoursesController::class, 'showAttendance'])->name('courses.showAttendance');
    Route::get('/edit-attendance/{id}', [CoursesController::class, 'editAttendance'])->name('courses.editAttendance');
    Route::put('/update-attendance/{id}', [CoursesController::class, 'updateAttendance'])->name('courses.updateAttendance');
    Route::get('/destroy-attendance/{id}', [CoursesController::class,' destroyAttendance'])->name('courses.destroyAttendance');


    //routes on classes
    Route::get('/add-classes', [CoursesController::class, 'addClasses'])->name('courses.addClasses');
    Route::post('/store-classes', [CoursesController::class, 'storeClasses'])->name('courses.storeClasses');
    Route::get('/show-classes', [CoursesController::class, 'showClasses'])->name('courses.showClasses');
    Route::get('/edit-classes/{id}', [CoursesController::class, 'editClasses'])->name('courses.editClasses');
    Route::put('/update-classes/{id}', [CoursesController::class, 'updateClasses'])->name('courses.updateClasses');
    Route::get('/destroy-classes/{id}', [CoursesController::class, 'destroyClasses'])->name('courses.destroyClasses');

    //routes on admissions
    Route::get('admissions', [CoursesController::class, 'admissions'])->name('courses.admissions');
    Route::get('admit/{id}', [CoursesController::class, 'admitStudent'])->name('courses.admitStudent');
    Route::get('student-Id{id}', [CoursesController::class, 'studentID'])->name('courses.studentID');
    Route::post('store-studentId{id}', [CoursesController::class, 'storeStudentId'])->name('courses.storeStudentId');
    Route::get('admissions-jab', [CoursesController::class, 'admissionsJab'])->name('courses.admissionsJab');
    Route::get('reject-admissions/{id}', [CoursesController::class, 'rejectAdmission'])->name('courses.rejectAdmissions');
    Route::get('admit/{id}', [CoursesController::class, 'admitStudent'])->name('courses.admitStudent');
    Route::get('student-Id{id}', [CoursesController::class, 'studentID'])->name('courses.studentID');
    Route::post('store-student-Id{id}', [CoursesController::class, 'storeStudentId'])->name('courses.storeStudentId');

    Route::get('/send', [CoursesController::class, 'accepted'])->name('courses.accepted');
    Route::any('/fetch-subjects', [CoursesController::class, 'fetchSubjects'])->name('courses.fetchSubjects');
    Route::any('/fetch-department', [CoursesController::class, 'fetchDept'])->name('courses.fetchDept');

    //routes on events
    Route::get('/add-event', [CoursesController::class, 'addEvent'])->name('courses.addEvent');
    Route::get('/show-event', [CoursesController::class, 'showEvent'])->name('courses.showEvent');
    Route::post('/store-event', [CoursesController::class, 'storeEvent'])->name('courses.storeEvent');
    Route::get('/destroy-event/{id}', [CoursesController::class, 'destroyEvent'])->name('courses.destroyEvent');
    Route::put('/update-event/{id}', [CoursesController::class, 'updateEvent'])->name('courses.updateEvent');
    Route::get('/edit-event/{id}', [CoursesController::class, 'editEvent'])->name('courses.editEvent');

    //routes oncalender ofevents
    Route::get('/add-calender-of-events', [CoursesController::class, 'addCalenderOfEvents'])->name('courses.addCalenderOfEvents');
    Route::get('/show-calender-of-events', [CoursesController::class, 'showCalenderOfEvents'])->name('courses.showCalenderOfEvents');
    Route::post('/store-calender-of-events', [CoursesController::class, 'storeCalenderOfEvents'])->name('courses.storeCalenderOfEvents');
    Route::get('/destroy-calender-of-events/{id}', [CoursesController::class, 'destroyCalenderOfEvents'])->name('courses.destroyCalenderOfEvents');
    Route::put('/update-calender-of-events/{id}', [CoursesController::class, 'updateCalenderOfEvents'])->name('courses.updateCalenderOfEvents');
    Route::get('/edit-calender-of-events/{id}', [CoursesController::class, 'editCalenderOfEvents'])->name('courses.editCalenderOfEvents');


    Route::get('/transfer', [CoursesController::class, 'transfer'])->name('courses.transfer');
    Route::get('/batch-transfer', [CoursesController::class, 'batchTransfer'])->name('courses.batchTransfer');
    Route::get('/school-preview/{id}', [CoursesController::class, 'schoolPreview'])->name('courses.schoolPreview');
    Route::get('/department-preview/{id}', [CoursesController::class, 'departmentPreview'])->name('courses.departmentPreview');
    Route::get('/course-preview/{id}', [CoursesController::class, 'coursePreview'])->name('courses.coursePreview');


    Route::post('/accepted-transfers', [CoursesController::class, 'acceptedTransfers'])->name('courses.acceptedTransfers');
    Route::get('/transfer-requests', [CoursesController::class, 'yearly'])->name('courses.yearly');
    Route::get('/transfer/{year}', [CoursesController::class, 'transfer'])->name('courses.transfer');
    Route::get('/generate-requests-transfer-report/{year}', [CoursesController::class, 'requestedTransfers'])->name('courses.requestedTransfers');

    Route::get('/leave-requests', [CoursesController::class, 'leaves'])->name('courses.leaves');
    Route::get('/academic-leave/{year}', [CoursesController::class, 'academicLeave'])->name('courses.academicLeave');
    // Route::get('/generate-requests-academic-leave-report/{year}', [CoursesController::class, 'requestedAcademicLeaves'])->name('courses.requestedAcademicLeaves');
    Route::post('/accepted-academic-leaves', [CoursesController::class, 'acceptedAcademicLeaves'])->name('courses.acceptedAcademicLeaves');


    Route::get('/readmission-requests', [CoursesController::class, 'readmissions'])->name('courses.readmissions');
    Route::get('/yearly-readmissions/{year}', [CoursesController::class, 'yearlyReadmissions'])->name('courses.yearlyReadmissions');
    Route::post('/accepted-readmissions', [CoursesController::class, 'acceptedReadmissions'])->name('courses.acceptedReadmissions');

    Route::get('/workload', [CoursesController::class, 'workload'])->name('courses.workload');
    Route::get('/school-workload/{year}', [CoursesController::class, 'schoolWorkload'])->name('courses.schoolWorkload');
    Route::get('/departmental-workload/{id}', [CoursesController::class, 'departmentalWorkload'])->name('courses.departmentalWorkload');
    Route::get('/view-workload/{id}', [CoursesController::class, 'viewWorkload'])->name('courses.viewWorkload');
    Route::get('/approve-workload/{id}', [CoursesController::class, 'approveWorkload'])->name('courses.approveWorkload');
    Route::post('/decline-workload/{id}', [CoursesController::class, 'declineWorkload'])->name('courses.declineWorkload');
    Route::get('/view-workload/{id}', [CoursesController::class, 'viewWorkload'])->name('courses.viewWorkload');
    Route::get('/print-workload/{id}', [CoursesController::class, 'printWorkload'])->name('courses.printWorkload');
    Route::get('/revert-workload/{id}', [CoursesController::class, 'revertWorkload'])->name('courses.revertWorkload');
    Route::get('/submit-workload/{id}', [CoursesController::class, 'submitWorkload'])->name('courses.submitWorkload');


    Route::get('/exam-marks-yearly', [CoursesController::class, 'yearlyExamMarks'])->name('courses.yearlyExamMarks');
    Route::get('/school-exam-marks/{id}', [CoursesController::class, 'schoolExamMarks'])->name('courses.schoolExamMarks');
    Route::get('/semester-exam-marks/{id}', [CoursesController::class, 'semesterExamMarks'])->name('courses.semesterExamMarks');
    Route::get('/view-semester-exam-marks/{id}', [CoursesController::class, 'viewExamMarks'])->name('courses.viewExamMarks');
    Route::get('/approve-exam-marks/{id}', [CoursesController::class, 'approveExamMarks'])->name('courses.approveExamMarks');
    Route::post('/decline-exam-marks/{id}', [CoursesController::class, 'declineExamMarks'])->name('courses.declineExamMarks');
    Route::get('/download-exam-marks/{id}', [CoursesController::class, 'downloadExamMarks'])->name('courses.downloadExamMarks');
    Route::get('/reverse-exam-marks-to-dean/{id}', [CoursesController::class, 'revertExamMarks'])->name('courses.revertExamMarks');
    Route::get('/submit-exam-marks-to-dean/{id}', [CoursesController::class, 'submitExamMarks'])->name('courses.submitExamMarks');

});


