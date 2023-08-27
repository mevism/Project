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

use Modules\Epayment\Http\Controllers\EpaymentController;

Route::prefix('epayment')->group(function() {
//    Route::get('/', 'EpaymentController@index');

    Route::get('fetch-student', [EpaymentController::class, 'index'])->name('payment.pullStudent');
    Route::get('fetch-student-by-id', [EpaymentController::class, 'register'])->name('payment.register');
    Route::post('register-student', [EpaymentController::class, 'store'])->name('payment.submitRegistration');
    Route::get('e-citizen-student', [EpaymentController::class, 'estudent'])->name('payment.estudent');
    Route::post('phone-verification', [EpaymentController::class, 'verifications'])->name('payment.verification');
    Route::get('get-new-verification-code', [EpaymentController::class, 'getnewCode'])->name('payment.getNewCode');
    Route::get('estudent', [EpaymentController::class, 'dashboard'])->name('epayment.student');
    Route::get('payment-request', [EpaymentController::class, 'paymentRequest'])->name('epayment.requestPay');
    Route::post('epayment-make-request', [EpaymentController::class, 'makeRequest'])->name('epayment.makeRequest');
});
