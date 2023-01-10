<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\AuthForgotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RazorpayPaymentController;
use App\Http\Controllers\API\V1\Masters\UniqueController;
use App\Http\Controllers\API\V1\Masters\RoleController;
use App\Http\Controllers\API\V1\Patients\SponserController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

@include('client.php');
@include('user.php');

//encrypt-decrypt
Route::get('encrypt', [Controller::class, 'encryptData']);
Route::get('decrypt', [Controller::class, 'decryptData']);
Route::post('check-encrypt-decrypt', [Controller::class, 'checkEncryptDecrypt']);

//sponser
Route::get('patient-source',[SponserController::class,'patientSource']);
Route::get('company-list',[SponserController::class,'companyList']);


Route::post('couple-sponser',[SponserController::class,'coupleSponser']);


//Client registration 
Route::post('client-registration',[AuthController::class,'clientRegistration']);
Route::post('get-type-reg',[AuthController::class,'getTypeReg']);

Route::post('resend-otp',[AuthController::class,'resendOtp']);

//forget pass -ph
Route::post('forgot/email', [AuthForgotController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot/resendotp', [AuthForgotController::class, 'resedOTP'])->name('forgot.resedotp');
Route::post('forgot/checkotpverification', [AuthForgotController::class, 'checkOTPVerification'])->name('forgot.checkotpverification');
Route::post('forgot/forgotnewpasswordupdate', [AuthForgotController::class, 'newPasswordUpdate'])->name('forgot.change.password');

//forgot pass encrypt -ph
Route::post('encrypt-forgot/email', [AuthForgotController::class, 'encryptForgotPassword'])->name('forgot.password');
Route::post('encrypt-forgot/resendotp', [AuthForgotController::class, 'encryptResedOTP'])->name('forgot.resedotp');
Route::post('encrypt-forgot/checkotpverification', [AuthForgotController::class, 'encryptCheckOTPVerification'])->name('forgot.checkotpverification');
Route::post('encrypt-forgot/forgotnewpasswordupdate', [AuthForgotController::class, 'encryptNewPasswordUpdate'])->name('forgot.change.password');

//razorpay
Route::post('create-order', [RazorpayPaymentController::class, 'createorder']);
Route::post('list-domain', [RazorpayPaymentController::class, 'listdomain']);
Route::post('razorpay-store', [RazorpayPaymentController::class, 'razorpaystore'])->name('razorpay.payment.store');

//all plan,department,store & also add department & store
Route::get('all-plan', [RazorpayPaymentController::class, 'allPlan']);

Route::get('all-department', [RazorpayPaymentController::class, 'alldepartment']);
Route::get('all-store', [RazorpayPaymentController::class, 'allstore']);

Route::post('add-storedep', [RazorpayPaymentController::class, 'addstoredep']);

//update payment on date pause plan
Route::post('pause-plan', [RazorpayPaymentController::class, 'pausePlan']);

//update payment on date update plan
Route::post('resume-plan', [RazorpayPaymentController::class, 'resumePlan']);
//end of date update plan
Route::post('end-update-plan', [RazorpayPaymentController::class, 'endUpdatePlan']);

/* client register*/
Route::group(['prefix' => 'client'], function(){
    Route::post('register', [AuthController::class, 'clientRegister']);
    Route::post('login', [AuthController::class, 'clientLogin']);
});

/* client create users registration*/
Route::group(['prefix' => 'user'], function(){
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::get('plan-features', [AuthController::class, 'planFeatures']);
});

Route::post('get-encrypted-body-param', [UniqueController::class, 'bodyParameterEncrypt']);

//role & permission list
Route::get('role-features',[RoleController::class,'rolefeatures']);

Route::get('check_query', function() {
    try {
       return 'check_query test';
    } catch (\Throwable $th) {
        return $th;
    }
});

Route::get('check-saas',[Controller::class,'checkSaas']);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'master', 'as'=>'master.'], function(){
    Route::post('clinic/details', [UniqueController::class, 'unitClinicDetails']); // master select details
    Route::post('state/details/{country}', [UniqueController::class, 'stateDetails']);  // country id
    Route::post('city/details/{state}', [UniqueController::class, 'cityDetails']);  // state id
    Route::post('selected/{category}/details/{selected_id}', [UniqueController::class, 'selectedDetails']);  // single data show (country, state, city)
    Route::post('file/path/details', [UniqueController::class, 'filePathDetails']);  // file & image path show
});