<?php

use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\BalanceUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FormReviewUserController;
use App\Http\Controllers\Admin\TopupUserController;
use App\Http\Controllers\Admin\UserRefundController;
use App\Http\Controllers\Admin\UserTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DarkSwitcherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\BankController;
use App\Http\Controllers\User\FormReviewController;
use App\Http\Controllers\User\OpenTicketController;
use App\Http\Controllers\User\RefundController;
use App\Http\Controllers\User\UserTopupController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('dark-mode-switcher', [DarkSwitcherController::class, 'switcher'])->name('dark-mode-switcher');


Route::group(['middleware' => ['auth','active_user']], function() { 
    Route::group(['prefix' => 'message'], function () { 
        Route::get('/user/{query}', [ChatController::class, 'user']);
        Route::get('/user-message/{id}', [ChatController::class, 'message']);
        Route::get('/user-messages/{id}/read', [ChatController::class, 'read']);
        Route::post('/user-message', [ChatController::class, 'send']);
        Route::get('/user-from/{id}', [ChatController::class, 'getUserFrom']);
    });
});


Route::group(['prefix' => 'apps'], function() {
    Route::get('/login',[AuthController::class, 'login'])->name('login.view');
    Route::get('/register',[AuthController::class, 'registerView'])->name('register.view');
    Route::get('/forgot-password',[AuthController::class, 'forgotPasswordView'])->name('forgotPassword.view');
    Route::get('/resend-verification',[AuthController::class, 'resenEmailView'])->name('resenEmail.view');
    Route::post('/login-process',[AuthController::class, 'loginProcess'])->name('login.process');
    Route::post('/logout-process',[AuthController::class, 'logout'])->name('logout.process');
    Route::post('/register-process',[AuthController::class, 'register'])->name('register.process');
    Route::post('/resend-verification-process',[AuthController::class, 'resendVerification'])->name('resendVerification.process');
    Route::post('/send-forgot-password-process',[AuthController::class, 'sendForgotPassword'])->name('sendForgotPassword.process');
    Route::post('/change-password-new',[AuthController::class, 'changePasswordNew'])->name('changePasswordNew');
    Route::get('/verify-link-email',[AuthController::class, 'verifyEmailLink'])->name('verifyEmailLink.process');
    Route::get('/verify-link-forgot-password',[AuthController::class, 'getForgotPasswordLink'])->name('getForgotPasswordLink.process');

    Route::group(['middleware' => ['auth','active_user']], function() {
        Route::get('/count-notif',[DashboardController::class, 'countNotification'])->name('countNotification');
        Route::post('/read-notif',[DashboardController::class, 'readAllNotif'])->name('readAllNotif');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/count-chat', [DashboardController::class, 'countNotReadChat'])->name('countNotReadChat');


        
        Route::group(['middleware' => ['role:member'], 'prefix' => 'user'], function() {
            Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
            Route::get('/form-review',[FormReviewController::class, 'index'])->name('form-review.user.index');
            Route::post('/form-post',[FormReviewController::class, 'submitForm'])->name('submitForm');
            Route::get('/topup',[UserTopupController::class, 'topupView'])->name('topupView');
            Route::get('/topup-history',[UserTopupController::class, 'topupHistory'])->name('topupHistory');
            Route::get('/balance-history',[UserTopupController::class, 'historyBalance'])->name('historyBalance');
            Route::post('/upload-invoice',[UserTopupController::class, 'uploadInvoice'])->name('uploadInvoice');
            Route::post('/delete-invoice',[UserTopupController::class, 'deleteInvoice'])->name('deleteInvoice');
            Route::get('/dollar',[UserTopupController::class, 'getDollarKurs'])->name('getDollarKurs');
            Route::get('/get-bank-admin/{id}',[UserTopupController::class, 'getBankAdmin'])->name('getBankAdmin');
            Route::post('/topup-process',[UserTopupController::class,'topupProcess'])->name('topupProcess');
            Route::get('/history-refund',[RefundController::class, 'historyRefund'])->name('historyRefund');
            Route::get('/refund-user',[RefundController::class, 'index'])->name('index.refund');
            Route::post('/refund',[RefundController::class, 'refund'])->name('refund');
            Route::get('/user-bank',[BankController::class, 'index'])->name('user.bank.index');
            Route::get('/user-bank/{id}',[BankController::class, 'detailBank'])->name('user.bank.detail');
            Route::post('/add-user-bank' ,[BankController::class, 'addBank'])->name('addBank.user');
            Route::delete('/delete-user-bank/{id}', [BankController::class, 'deleteBank'])->name('deleteBank.user');

            Route::get('/my-ticket',[OpenTicketController::class, 'myTicket'])->name('myTicket');
            Route::get('/open-ticket',[OpenTicketController::class, 'createTicket'])->name('createTicket');
            Route::get('/detail-my-ticket/{id}',[OpenTicketController::class, 'detailTicket'])->name('detailTicket');
            Route::post('/open-ticket-create',[OpenTicketController::class, 'storeTicket'])->name('storeTicket');
        });

        Route::group(['middleware' => ['role:superadmin'], 'prefix' => 'admin'], function() {
            Route::get('/dashboard',[AdminDashboardController::class, 'index'])->name('dashboard.admin');
            Route::get('/topup-user}',[TopupUserController::class, 'topupHistory'])->name('topupHistory.admin');
            Route::put('/update-topup/{uuid}',[TopupUserController::class, 'updateTopup'])->name('updateTopup.admin');

            Route::get('/form-pending',[FormReviewUserController::class, 'index'])->name('form-pending.index');
            Route::get('/form-accepted',[FormReviewUserController::class, 'indexAccepted'])->name('form-accept.index');
            Route::get('/form-rejected',[FormReviewUserController::class, 'indexRejected'])->name('form-reject.index');
            Route::get('/detail-form/{id}',[FormReviewUserController::class, 'detailForm'])->name('detailForm');
            Route::put('/form-confirmation/{id}',[FormReviewUserController::class, 'updateForm'])->name('form-confirmation');

            Route::get('/user-balance-control', [BalanceUserController::class, 'index'])->name('balance-control.index');
            Route::post('/user-balance-update', [BalanceUserController::class, 'controlBalance'])->name('controlBalance');
            Route::put('/user-status-update/{uuid}', [BalanceUserController::class, 'updateStatusUser'])->name('updateStatusUser');
            Route::get('/detail-user/{uuid}', [BalanceUserController::class, 'detail'])->name('detail');

            Route::get('/mail-setting', [AdminSettingController::class, 'mailSetting'])->name('mailSetting');
            Route::get('/topup-setting', [AdminSettingController::class, 'topupSetting'])->name('topupSetting');
            Route::get('/app-setting', [AdminSettingController::class, 'appSetting'])->name('appSetting');
            // Route::get('/app-setting', [AdminSettingController::class, 'appSetting'])->name('appSetting');
            Route::get('/bank-setting', [AdminSettingController::class, 'listBank'])->name('listBank');
            Route::get('/detailbank-setting/{id}', [AdminSettingController::class, 'detailBankAdmin'])->name('detailBankAdmin');
            Route::delete('/deletebank-setting/{id}', [AdminSettingController::class, 'deleteBankAdmin'])->name('deleteBankAdmin');
            Route::post('/addbank-setting', [AdminSettingController::class, 'addBankAdmin'])->name('addBankAdmin');
            Route::post('/updatebank-setting/{id}', [AdminSettingController::class, 'updateBankAdmin'])->name('updateBankAdmin');
            Route::post('/save-email-setting', [AdminSettingController::class, 'saveEmailSetting'])->name('saveEmailSetting');
            Route::post('/save-app-setting', [AdminSettingController::class, 'saveAppSetting'])->name('saveAppSetting');
            Route::post('/save-topup-setting', [AdminSettingController::class, 'saveTopupSetting'])->name('saveTopupSetting');
            Route::post('/upload-logo',[AdminSettingController::class, 'uploadLogo'])->name('uploadLogo');
            Route::post('/delete-logo',[AdminSettingController::class, 'deleteLogo'])->name('deleteLogo');

            Route::get('/refund-history',[UserRefundController::class, 'index'])->name('refund-user.index');
            Route::post('/upload-invoice-refund',[UserRefundController::class, 'uploadBankSleep'])->name('uploadInvoice.refund');
            Route::post('/delete-invoice-refund',[UserRefundController::class, 'deleteInvoice'])->name('deleteInvoice.refund');
            Route::put('/reject-refund/{uuid}',[UserRefundController::class, 'rejectRefund'])->name('rejectRefund');
            Route::post('/approve-refund/{uuid}',[UserRefundController::class, 'approveRefund'])->name('approveRefund');

            Route::get('list-user-ticket', [UserTicketController::class, 'userTicket'])->name('userTicket.index');
            Route::get('detail-user-ticket/{id}', [UserTicketController::class, 'detailTicketUser'])->name('detailTicketUser');
            Route::put('update-status-ticket/{id}', [UserTicketController::class, 'updateTicket'])->name('updateTicket');
        });
    });
});
