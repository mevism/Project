<?php

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

Route::prefix('courses')->middleware(['admin'])->group(function() {
    

    
    Route::get('/showSemFee', 'CoursesController@showSemFee')->name('courses.showSemFee');
    Route::get('/semFee', 'CoursesController@semFee')->name('courses.semFee');
    Route::post('/storeSemFee', 'CoursesController@storeSemFee')->name('courses.storeSemFee');
    Route::get('/viewSemFee/{id}', 'CoursesController@viewSemFee')->name('courses.viewSemFee');
    Route::get('/printFee/{id}', 'CoursesController@printFee')->name('courses.printFee');

    //routes on fee
    Route::get('/voteheads', 'CoursesController@voteheads')->name('courses.voteheads');
    Route::get('/show-voteheads', 'CoursesController@showVoteheads')->name('courses.showVoteheads');
    Route::post('/store-voteheads', 'CoursesController@storeVoteheads')->name('courses.storeVoteheads');
    Route::get('/edit-votehead/{id}', 'CoursesController@editVotehead')->name('courses.editVotehead');
    Route::get('/destroy-votehead/{id}', 'CoursesController@destroyVotehead')->name('courses.destroyVotehead');
    Route::put('/update-votehead/{id}', 'CoursesController@updateVotehead')->name('courses.updateVotehead');

    Route::get('/export-kuccps', 'CoursesController@exportkuccps')->name('courses.exportkuccps');
    Route::get('/import-export-view-kuccps','CoursesController@importExportViewkuccps')->name('courses.importExportViewkuccps');
    Route::post('/import-kuccps','CoursesController@importkuccps')->name('courses.importkuccps');
    Route::get('/preview/{id}', 'CoursesController@preview')->name('courses.preview');
    Route::get('/view-application/{id}', 'CoursesController@viewApplication')->name('courses.viewApplication');
    Route::get('/accept-application/{id}', 'CoursesController@acceptApplication')->name('courses.acceptApplication');
    Route::post('/reject-application/{id}', 'CoursesController@rejectApplication')->name('courses.rejectApplication');

    Route::get('/import-export-cluster-weights','CoursesController@importExportclusterWeights')->name('courses.importExportclusterWeights');
    Route::post('/import-cluster-weights','CoursesController@importclusterWeights')->name('courses.importclusterWeights');

    Route::get('/import-unit-programms','CoursesController@importUnitProgramms')->name('courses.importUnitProgramms');
    Route::post('/import-unit-programms','CoursesController@importUnitProg')->name('courses.importUnitProg');

    Route::get('/importUnit','CoursesController@importUnit')->name('courses.importUnit');
    Route::post('/importUnit','CoursesController@importUnits')->name('courses.importUnits');
    
    Route::get('/importExportCourses','CoursesController@importExportCourses')->name('courses.importExportCourses');
    Route::post('/importCourses','CoursesController@importCourses')->name('courses.importCourses');

    Route::get('/create-units/{id}','CoursesController@createUnits')->name('courses.createUnits');
    Route::post('/store-created-units', 'CoursesController@storeCreatedUnits')->name('courses.storeCreatedUnits');

    Route::get('/archived', 'CoursesController@archived')->name('courses.archived');
    Route::get('/applications', 'CoursesController@applications')->name('courses.applications');
    Route::get('/show-kuccps', 'CoursesController@showKuccps')->name('courses.showKuccps');
    Route::get('/offer', 'CoursesController@offer')->name('courses.offer');
    Route::get('/profile', 'CoursesController@profile')->name('courses.profile');
    Route::get('/destroy-courses-available/{id}', 'CoursesController@destroyCoursesAvailable')->name('courses.destroyCoursesAvailable');
    Route::post('/accepted-mail', 'CoursesController@acceptedMail')->name('courses.acceptedMail');


    //routes on intakes
    Route::get('/', 'CoursesController@index')->name('courses.index');
    Route::get('approve-index', 'CoursesController@approveIndex')->name('courses.approveIndex');
    Route::get('/add-intake/{id}', 'CoursesController@addIntake')->name('courses.addIntake');
    Route::post('/store-intake/{id}', 'CoursesController@storeIntake')->name('courses.storeIntake');
    Route::get('/show-intake', 'CoursesController@showIntake')->name('courses.showIntake');
    Route::get('/edit-intake/{id}', 'CoursesController@editIntake')->name('courses.editIntake');
    Route::put('/update-intake/{id}', 'CoursesController@updateIntake')->name('courses.updateIntake');
    Route::get('/destroy-intake/{id}', 'CoursesController@destroyIntake')->name('courses.destroyIntake');
    Route::get('/view-intake/{id}', 'CoursesController@viewIntake')->name('courses.viewIntake');
    Route::get('/view-course/{id}', 'CoursesController@viewCourse')->name('courses.viewCourse');
    Route::put('/status-intake/{id}', 'CoursesController@statusIntake')->name('courses.statusIntake');
    Route::get('/edit-status-intake/{id}', 'CoursesController@editstatusIntake')->name('courses.editstatusIntake');


    Route::get('/add-year', 'CoursesController@addYear')->name('courses.addYear');
    Route::get('/academic-year', 'CoursesController@academicYear')->name('courses.academicYear');
    Route::post('/store-year', 'CoursesController@storeYear')->name('courses.storeYear');
    Route::get('/destroy-year/{id}', 'CoursesController@destroyYear')->name('courses.destroyYear');
    Route::get('/show-semester/{id}', 'CoursesController@showSemester')->name('courses.showSemester');


    //routes on school
    Route::get('/add-school', 'CoursesController@addSchool')->name('courses.addSchool');
    Route::post('/store-school', 'CoursesController@storeSchool')->name('courses.storeSchool');
    Route::get('/show-school', 'CoursesController@showSchool')->name('courses.showSchool');
    Route::get('/edit-school/{id}', 'CoursesController@editSchool')->name('courses.editSchool');
    Route::put('/update-school/{id}', 'CoursesController@updateSchool')->name('courses.updateSchool');
    Route::get('/destroy-school/{id}', 'CoursesController@destroySchool')->name('courses.destroySchool');

    //routes on departments
    Route::get('/add-department', 'CoursesController@addDepartment')->name('courses.addDepartment');
    Route::post('/store-department', 'CoursesController@storeDepartment')->name('courses.storeDepartment');
    Route::get('/show-department', 'CoursesController@showDepartment')->name('courses.showDepartment');
    Route::get('/edit-department/{id}', 'CoursesController@editDepartment')->name('courses.editDepartment');
    Route::put('/update-department/{id}', 'CoursesController@updateDepartment')->name('courses.updateDepartment');
    Route::get('/destroy-department/{id}', 'CoursesController@destroyDepartment')->name('courses.destroyDepartment');

    //routes on courses
    Route::get('/add-course', 'CoursesController@addCourse')->name('courses.addCourse');
    Route::post('/store-course', 'CoursesController@storeCourse')->name('courses.storeCourse');
    Route::get('/show-course', 'CoursesController@showCourse')->name('courses.showCourse');
    Route::get('/edit-course/{id}', 'CoursesController@editCourse')->name('courses.editCourse');
    Route::get('/syllabus/{id}', 'CoursesController@syllabus')->name('courses.syllabus');
    Route::put('/update-course/{id}', 'CoursesController@updateCourse')->name('courses.updateCourse');
    Route::get('/destroy-course/{id}', 'CoursesController@destroyCourse')->name('courses.destroyCourse');

    //routes on attendance/ mode of study
    Route::get('/add-attendance', 'CoursesController@addAttendance')->name('courses.addAttendance');
    Route::post('/store-attendance', 'CoursesController@storeAttendance')->name('courses.storeAttendance');
    Route::get('/show-attendance', 'CoursesController@showAttendance')->name('courses.showAttendance');
    Route::get('/edit-attendance/{id}', 'CoursesController@editAttendance')->name('courses.editAttendance');
    Route::put('/update-attendance/{id}', 'CoursesController@updateAttendance')->name('courses.updateAttendance');
    Route::get('/destroy-attendance/{id}', 'CoursesController@destroyAttendance')->name('courses.destroyAttendance');


    //routes on classes
    Route::get('/add-classes', 'CoursesController@addClasses')->name('courses.addClasses');
    Route::post('/store-classes', 'CoursesController@storeClasses')->name('courses.storeClasses');
    Route::get('/show-classes', 'CoursesController@showClasses')->name('courses.showClasses');
    Route::get('/edit-classes/{id}', 'CoursesController@editClasses')->name('courses.editClasses');
    Route::put('/update-classes/{id}', 'CoursesController@updateClasses')->name('courses.updateClasses');
    Route::get('/destroy-classes/{id}', 'CoursesController@destroyClasses')->name('courses.destroyClasses');

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
    Route::get('/add-event', 'CoursesController@addEvent')->name('courses.addEvent');
    Route::get('/show-event', 'CoursesController@showEvent')->name('courses.showEvent');
    Route::post('/store-event', 'CoursesController@storeEvent')->name('courses.storeEvent');
    Route::get('/destroy-event/{id}', 'CoursesController@destroyEvent')->name('courses.destroyEvent');
    Route::put('/update-event/{id}', 'CoursesController@updateEvent')->name('courses.updateEvent');
    Route::get('/edit-event/{id}', 'CoursesController@editEvent')->name('courses.editEvent');

    //routes oncalender ofevents
    Route::get('/add-calender-of-events', 'CoursesController@addCalenderOfEvents')->name('courses.addCalenderOfEvents');
    Route::get('/show-calender-of-events', 'CoursesController@showCalenderOfEvents')->name('courses.showCalenderOfEvents');
    Route::post('/store-calender-of-events', 'CoursesController@storeCalenderOfEvents')->name('courses.storeCalenderOfEvents');
    Route::get('/destroy-calender-of-events/{id}', 'CoursesController@destroyCalenderOfEvents')->name('courses.destroyCalenderOfEvents');
    Route::put('/update-calender-of-events/{id}', 'CoursesController@updateCalenderOfEvents')->name('courses.updateCalenderOfEvents');
    Route::get('/edit-calender-of-events/{id}', 'CoursesController@editCalenderOfEvents')->name('courses.editCalenderOfEvents');


    Route::get('/transfer', [CoursesController::class, 'transfer'])->name('courses.transfer');
    Route::get('/batchTransfer', [CoursesController::class, 'batchTransfer'])->name('courses.batchTransfer');
    Route::get('/schoolPreview/{id}', [CoursesController::class, 'schoolPreview'])->name('courses.schoolPreview');
    Route::get('/departmentPreview/{id}', [CoursesController::class, 'departmentPreview'])->name('courses.departmentPreview');
    Route::get('/coursePreview/{id}', [CoursesController::class, 'coursePreview'])->name('courses.coursePreview');
   

    Route::post('/acceptedTransfers', 'CoursesController@acceptedTransfers')->name('courses.acceptedTransfers');
    Route::get('/transfer-requests', [CoursesController::class, 'yearly'])->name('courses.yearly');
    Route::get('/transfer/{year}', [CoursesController::class, 'transfer'])->name('courses.transfer');
    Route::get('/generate-requests-transfer-report/{year}', [CoursesController::class, 'requestedTransfers'])->name('courses.requestedTransfers');

    Route::get('/leave-requests', [CoursesController::class, 'leaves'])->name('courses.leaves');
    Route::get('/academic-leave/{year}', [CoursesController::class, 'academicLeave'])->name('courses.academicLeave');
    // Route::get('/generate-requests-academic-leave-report/{year}', [CoursesController::class, 'requestedAcademicLeaves'])->name('courses.requestedAcademicLeaves');
    Route::post('/accepted-academic-leaves', 'CoursesController@acceptedAcademicLeaves')->name('courses.acceptedAcademicLeaves');


    Route::get('/readmission-requests', [CoursesController::class, 'readmissions'])->name('courses.readmissions');
    Route::get('/yearly-readmissions/{year}', [CoursesController::class, 'yearlyReadmissions'])->name('courses.yearlyReadmissions');
    Route::post('/accepted-readmissions', 'CoursesController@acceptedReadmissions')->name('courses.acceptedReadmissions');

});


