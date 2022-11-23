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
    Route::get('/showVoteheads', 'CoursesController@showVoteheads')->name('courses.showVoteheads');
    Route::post('/storeVoteheads', 'CoursesController@storeVoteheads')->name('courses.storeVoteheads');
    Route::get('/editVotehead/{id}', 'CoursesController@editVotehead')->name('courses.editVotehead');
    Route::get('/destroyVotehead/{id}', 'CoursesController@destroyVotehead')->name('courses.destroyVotehead');
    Route::put('/updateVotehead/{id}', 'CoursesController@updateVotehead')->name('courses.updateVotehead');

    Route::get('/exportkuccps', 'CoursesController@exportkuccps')->name('courses.exportkuccps');
    Route::get('/importExportViewkuccps','CoursesController@importExportViewkuccps')->name('courses.importExportViewkuccps');
    Route::post('/importkuccps','CoursesController@importkuccps')->name('courses.importkuccps');
    Route::get('/preview/{id}', 'CoursesController@preview')->name('courses.preview');
    Route::get('/viewApplication/{id}', 'CoursesController@viewApplication')->name('courses.viewApplication');
    Route::get('/acceptApplication/{id}', 'CoursesController@acceptApplication')->name('courses.acceptApplication');
    Route::post('/rejectApplication/{id}', 'CoursesController@rejectApplication')->name('courses.rejectApplication');

    Route::get('/importExportclusterWeights','CoursesController@importExportclusterWeights')->name('courses.importExportclusterWeights');
    Route::post('/importclusterWeights','CoursesController@importclusterWeights')->name('courses.importclusterWeights');

    Route::get('/importUnitProgramms','CoursesController@importUnitProgramms')->name('courses.importUnitProgramms');
    Route::post('/importUnitProgramms','CoursesController@importUnitProg')->name('courses.importUnitProg');

    Route::get('/importUnit','CoursesController@importUnit')->name('courses.importUnit');
    Route::post('/importUnit','CoursesController@importUnits')->name('courses.importUnits');
    
    Route::get('/importExportCourses','CoursesController@importExportCourses')->name('courses.importExportCourses');
    Route::post('/importCourses','CoursesController@importCourses')->name('courses.importCourses');

    Route::get('/createUnits/{id}','CoursesController@createUnits')->name('courses.createUnits');
    Route::post('/storeCreatedUnits', 'CoursesController@storeCreatedUnits')->name('courses.storeCreatedUnits');

    Route::get('/archived', 'CoursesController@archived')->name('courses.archived');
    Route::get('/applications', 'CoursesController@applications')->name('courses.applications');
    Route::get('/showKuccps', 'CoursesController@showKuccps')->name('courses.showKuccps');
    Route::get('/offer', 'CoursesController@offer')->name('courses.offer');
    Route::get('/profile', 'CoursesController@profile')->name('courses.profile');
    Route::get('/destroyCoursesAvailable/{id}', 'CoursesController@destroyCoursesAvailable')->name('courses.destroyCoursesAvailable');
    Route::post('/acceptedMail', 'CoursesController@acceptedMail')->name('courses.acceptedMail');


    //routes on intakes
    Route::get('/', 'CoursesController@index')->name('courses.index');
    Route::get('approveIndex', 'CoursesController@approveIndex')->name('courses.approveIndex');
    Route::get('/addIntake/{id}', 'CoursesController@addIntake')->name('courses.addIntake');
    Route::post('/storeIntake/{id}', 'CoursesController@storeIntake')->name('courses.storeIntake');
    Route::get('/showIntake', 'CoursesController@showIntake')->name('courses.showIntake');
    Route::get('/editIntake/{id}', 'CoursesController@editIntake')->name('courses.editIntake');
    Route::put('/updateIntake/{id}', 'CoursesController@updateIntake')->name('courses.updateIntake');
    Route::get('/destroyIntake/{id}', 'CoursesController@destroyIntake')->name('courses.destroyIntake');
    Route::get('/viewIntake/{id}', 'CoursesController@viewIntake')->name('courses.viewIntake');
    Route::get('/viewCourse/{id}', 'CoursesController@viewCourse')->name('courses.viewCourse');
    Route::put('/statusIntake/{id}', 'CoursesController@statusIntake')->name('courses.statusIntake');
    Route::get('/editstatusIntake/{id}', 'CoursesController@editstatusIntake')->name('courses.editstatusIntake');


    Route::get('/addYear', 'CoursesController@addYear')->name('courses.addYear');
    Route::get('/academicYear', 'CoursesController@academicYear')->name('courses.academicYear');
    Route::post('/storeYear', 'CoursesController@storeYear')->name('courses.storeYear');
    Route::get('/destroyYear/{id}', 'CoursesController@destroyYear')->name('courses.destroyYear');
    Route::get('/showSemester/{id}', 'CoursesController@showSemester')->name('courses.showSemester');


    //routes on school
    Route::get('/addSchool', 'CoursesController@addSchool')->name('courses.addSchool');
    Route::post('/storeSchool', 'CoursesController@storeSchool')->name('courses.storeSchool');
    Route::get('/showSchool', 'CoursesController@showSchool')->name('courses.showSchool');
    Route::get('/editSchool/{id}', 'CoursesController@editSchool')->name('courses.editSchool');
    Route::put('/updateSchool/{id}', 'CoursesController@updateSchool')->name('courses.updateSchool');
    Route::get('/destroySchool/{id}', 'CoursesController@destroySchool')->name('courses.destroySchool');

    //routes on departments
    Route::get('/addDepartment', 'CoursesController@addDepartment')->name('courses.addDepartment');
    Route::post('/storeDepartment', 'CoursesController@storeDepartment')->name('courses.storeDepartment');
    Route::get('/showDepartment', 'CoursesController@showDepartment')->name('courses.showDepartment');
    Route::get('/editDepartment/{id}', 'CoursesController@editDepartment')->name('courses.editDepartment');
    Route::put('/updateDepartment/{id}', 'CoursesController@updateDepartment')->name('courses.updateDepartment');
    Route::get('/destroyDepartment/{id}', 'CoursesController@destroyDepartment')->name('courses.destroyDepartment');

    //routes on courses
    Route::get('/addCourse', 'CoursesController@addCourse')->name('courses.addCourse');
    Route::post('/storeCourse', 'CoursesController@storeCourse')->name('courses.storeCourse');
    Route::get('/showCourse', 'CoursesController@showCourse')->name('courses.showCourse');
    Route::get('/editCourse/{id}', 'CoursesController@editCourse')->name('courses.editCourse');
    Route::get('/syllabus/{id}', 'CoursesController@syllabus')->name('courses.syllabus');
    Route::put('/updateCourse/{id}', 'CoursesController@updateCourse')->name('courses.updateCourse');
    Route::get('/destroyCourse/{id}', 'CoursesController@destroyCourse')->name('courses.destroyCourse');

    //routes on attendance/ mode of study
    Route::get('/addAttendance', 'CoursesController@addAttendance')->name('courses.addAttendance');
    Route::post('/storeAttendance', 'CoursesController@storeAttendance')->name('courses.storeAttendance');
    Route::get('/showAttendance', 'CoursesController@showAttendance')->name('courses.showAttendance');
    Route::get('/editAttendance/{id}', 'CoursesController@editAttendance')->name('courses.editAttendance');
    Route::put('/updateAttendance/{id}', 'CoursesController@updateAttendance')->name('courses.updateAttendance');
    Route::get('/destroyAttendance/{id}', 'CoursesController@destroyAttendance')->name('courses.destroyAttendance');


    //routes on classes
    Route::get('/addClasses', 'CoursesController@addClasses')->name('courses.addClasses');
    Route::post('/storeClasses', 'CoursesController@storeClasses')->name('courses.storeClasses');
    Route::get('/showClasses', 'CoursesController@showClasses')->name('courses.showClasses');
    Route::get('/editClasses/{id}', 'CoursesController@editClasses')->name('courses.editClasses');
    Route::put('/updateClasses/{id}', 'CoursesController@updateClasses')->name('courses.updateClasses');
    Route::get('/destroyClasses/{id}', 'CoursesController@destroyClasses')->name('courses.destroyClasses');

    //routes on admissions
    Route::get('admissions', [CoursesController::class, 'admissions'])->name('courses.admissions');
    Route::get('admit/{id}', [CoursesController::class, 'admitStudent'])->name('courses.admitStudent');
    Route::get('studentId{id}', [CoursesController::class, 'studentID'])->name('courses.studentID');
    Route::post('storeStudentId{id}', [CoursesController::class, 'storeStudentId'])->name('courses.storeStudentId');
    Route::get('admissionsJab', [CoursesController::class, 'admissionsJab'])->name('courses.admissionsJab');
    Route::get('rejectAdmissions/{id}', [CoursesController::class, 'rejectAdmission'])->name('courses.rejectAdmissions');
    Route::get('admit/{id}', [CoursesController::class, 'admitStudent'])->name('courses.admitStudent');
    Route::get('studentId{id}', [CoursesController::class, 'studentID'])->name('courses.studentID');
    Route::post('storeStudentId{id}', [CoursesController::class, 'storeStudentId'])->name('courses.storeStudentId');

    Route::get('/send', [CoursesController::class, 'accepted'])->name('courses.accepted');
    Route::any('/fetchSubjects', [CoursesController::class, 'fetchSubjects'])->name('courses.fetchSubjects');
    Route::any('/fetchDept', [CoursesController::class, 'fetchDept'])->name('courses.fetchDept');

    //routes on events
    Route::get('/addEvent', 'CoursesController@addEvent')->name('courses.addEvent');
    Route::get('/showEvent', 'CoursesController@showEvent')->name('courses.showEvent');
    Route::post('/storeEvent', 'CoursesController@storeEvent')->name('courses.storeEvent');
    Route::get('/destroyEvent/{id}', 'CoursesController@destroyEvent')->name('courses.destroyEvent');
    Route::put('/updateEvent/{id}', 'CoursesController@updateEvent')->name('courses.updateEvent');
    Route::get('/editEvent/{id}', 'CoursesController@editEvent')->name('courses.editEvent');

    //routes oncalender ofevents
    Route::get('/addCalenderOfEvents', 'CoursesController@addCalenderOfEvents')->name('courses.addCalenderOfEvents');
    Route::get('/showCalenderOfEvents', 'CoursesController@showCalenderOfEvents')->name('courses.showCalenderOfEvents');
    Route::post('/storeCalenderOfEvents', 'CoursesController@storeCalenderOfEvents')->name('courses.storeCalenderOfEvents');
    Route::get('/destroyCalenderOfEvents/{id}', 'CoursesController@destroyCalenderOfEvents')->name('courses.destroyCalenderOfEvents');
    Route::put('/updateCalenderOfEvents/{id}', 'CoursesController@updateCalenderOfEvents')->name('courses.updateCalenderOfEvents');
    Route::get('/editCalenderOfEvents/{id}', 'CoursesController@editCalenderOfEvents')->name('courses.editCalenderOfEvents');


    Route::get('/transfer', [CoursesController::class, 'transfer'])->name('courses.transfer');
    Route::get('/batchTransfer', [CoursesController::class, 'batchTransfer'])->name('courses.batchTransfer');
   
});


