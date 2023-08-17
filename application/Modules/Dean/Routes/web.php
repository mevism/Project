<?php

use Modules\Dean\Http\Controllers\DeanController;
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

Route::prefix('dean')->middleware(['web', 'auth:user', 'is_dean'])->group(function() {

        Route::get('/dean', [DeanController::class, 'index'])->name('dean.dashboard');
        Route::get('/applications', [DeanController::class, 'applications'])->name('dean.applications');
        Route::get('/viewApplication/{id}', [DeanController::class, 'viewApplication'])->name('dean.viewApplication');
        Route::get('/previewApplication/{id}', [DeanController::class, 'previewApplication'])->name('dean.previewApplication');
        Route::get('/batch', [DeanController::class, 'batch'])->name('dean.batch');
        Route::post('/batchSubmit', [DeanController::class, 'batchSubmit'])->name('dean.batchSubmit');
        Route::get('/acceptApplication/{id}', [DeanController::class, 'acceptApplication'])->name('dean.acceptApplication');
        Route::post('/rejectApplication/{id}', [DeanController::class, 'rejectApplication'])->name('dean.rejectApplication');

        Route::get('/transfer/{id}', [DeanController::class, 'transfer'])->name('dean.transfer');
        Route::get('/batchTransfer', [DeanController::class, 'batchTransfer'])->name('dean.batchTransfer');
        Route::get('/viewTransfer/{id}', [DeanController::class, 'viewTransfer'])->name('dean.viewTransfer');
        Route::get('/preview/{id}', [DeanController::class, 'preview'])->name('dean.preview');
        Route::post('/rejectTransfer/{id}', [DeanController::class, 'rejectTransfer'])->name('dean.rejectTransfer');
        Route::get('/acceptTransfer/{id}', [DeanController::class, 'acceptTransfer'])->name('dean.acceptTransfer');


        Route::get('/acceptTransferRequest/{id}', [DeanController::class, 'acceptTransferRequest'])->name('dean.acceptTransferRequest');
        Route::post('/declineTransferRequest/{id}', [DeanController::class, 'declineTransferRequest'])->name('dean.declineTransferRequest');
        Route::get('/viewUploadedDocument/{id}', [DeanController::class, 'viewUploadedDocument'])->name('dean.viewUploadedDocument');
        Route::get('/transferRequests', [DeanController::class, 'yearly'])->name('dean.yearly');
        Route::get('/generate-transfer-requests-report/{year}', [DeanController::class, 'requestedTransfers'])->name('dean.requestedTransfers');

        Route::get('/view-list-of-academic-leaves', [DeanController::class, 'academicLeave'])->name('dean.academicLeave');
        Route::get('/view-yearly-academic-leave/{id}', [DeanController::class, 'yearlyAcademicLeave'])->name('dean.yearlyLeaves');
        Route::get('/view-academic-leave-request/{id}', [DeanController::class, 'viewLeaveRequest'])->name('dean.viewLeaveRequest');
        Route::get('/accept-academic-leave/deferment-request/{id}', [DeanController::class, 'acceptLeaveRequest'])->name('dean.acceptLeaveRequest');
        Route::post('/decline-academic-leave/deferment-request/{id}', [DeanController::class, 'declineLeaveRequest'])->name('dean.declineLeaveRequest');

        Route::get('/view-yearly-readmissions', [DeanController::class, 'readmissions'])->name('dean.readmissions');
        Route::get('/view-yearly-readmissions/{id}', [DeanController::class, 'yearlyReadmissions'])->name('dean.yearlyReadmissions');
        Route::get('/get-intake-readmission-requests/{id}', [DeanController::class, 'intakeReadmissions'])->name('dean.intakeReadmissions');
        Route::get('/view-selected-readmission-request/{id}', [DeanController::class, 'selectedReadmission'])->name('dean.selectedReadmission');
        Route::post('/accept-selected-readmission-request/{id}', [DeanController::class, 'acceptReadmission'])->name('dean.acceptReadmission');
        Route::post('/decline-selected-readmission-request/{id}', [DeanController::class, 'declineReadmission'])->name('dean.declineReadmission');

        Route::get('/yearly-workload/{id}', [DeanController::class, 'yearlyWorkload'])->name('dean.workload');
        Route::get('/semester-workloads/{id}', [DeanController::class, 'semesterWorkload'])->name('dean.SemesterWorkload');
        Route::get('/print-workload/{id}', [DeanController::class, 'printWorkload'])->name('dean.printWorkload');
        Route::get('/view-workload/{id}', [DeanController::class, 'viewWorkload'])->name('dean.viewWorkload');
        Route::get('/approve-workload/{id}', [DeanController::class, 'approveWorkload'])->name('dean.approveWorkload');
        Route::post('/decline-workload/{id}', [DeanController::class, 'declineWorkload'])->name('dean.declineWorkload');
        Route::get('/published-workload/{id}', [DeanController::class, 'workloadPublished'])->name('dean.workloadPublished');
        Route::get('/revert-workload/{id}', [DeanController::class, 'revertWorkload'])->name('dean.revertWorkload');
        Route::get('/submit-workload/{id}', [DeanController::class, 'submitWorkload'])->name('dean.submitWorkload');
        Route::get('/view-workloads', [DeanController::class, 'viewWorkloads'])->name('dean.viewWorkloads');


        Route::get('/yearly-exams', [DeanController::class, 'yearlyExams'])->name('dean.yearlyExams');
        Route::get('/exams/{id}', [DeanController::class, 'exams'])->name('dean.exams');
        Route::get('/view-yearly-exams/{id}', [DeanController::class, 'viewYearlyExams'])->name('dean.viewYearlyExams');
        Route::get('/approve-marks/{id}', [DeanController::class, 'approveExamMarks'])->name('dean.approveExamMarks');
        Route::post('/decline-marks/{id}', [DeanController::class, 'declineExams'])->name('dean.declineExams');
        Route::get('/submit-marks/{id}', [DeanController::class, 'submitExamMarks'])->name('dean.submitExamMarks');
        Route::get('/publish-results/{id}', [DeanController::class, 'publishResults'])->name('dean.publishResults');
        Route::get('/revert-marks/{id}', [DeanController::class, 'revertExamMarks'])->name('dean.revertExamMarks');
        Route::get('/download-exam-results/{sem}/{year}', [DeanController::class, 'downloadExamResults'])->name('dean.downloadExamResults');

});

