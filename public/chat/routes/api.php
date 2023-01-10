<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;

use App\Http\Controllers\API\AuthUserController;
use App\Http\Controllers\API\AuthForgotController;
use App\Http\Controllers\API\ChurchController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('login', [PassportController::class, 'login']);
// Route::post('register', [PassportController::class, 'register']);

// Route::middleware('auth:api')->group(function () {
// 	Route::get('user', [PassportController::class, 'details']);
// 	Route::post('user', function(){
// 		return response()->json(['user' => auth()->user()], 200);
// 	});
// });


Route::post('register', [AuthUserController::class, 'register'])->name('register');
Route::post('login', [AuthUserController::class, 'login'])->name('login');

Route::post('forgot/email', [AuthForgotController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot/resendotp', [AuthForgotController::class, 'resedOTP'])->name('forgot.resedotp');
Route::post('forgot/checkotpverification', [AuthForgotController::class, 'checkOTPVerification'])->name('forgot.checkotpverification');
Route::post('forgot/forgotnewpasswordupdate', [AuthForgotController::class, 'newPasswordUpdate'])->name('forgot.change.password');

Route::post('userprofile', [AuthUserController::class, 'userProfile'])->name('userprofile');

//use api to get church list without token for android & ios application
Route::get('church/list', [ChurchController::class, 'churchList'])->name('churchlist');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});