<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Church\ChurchController;
use App\Http\Controllers\UniqueController;

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

@include('adminWeb.php');
@include('churchWeb.php');
@include('uniqWeb.php');

Route::get('privacypolicy-{lang}', [UniqueController::class, 'privacyPolicy'])->name('privacypolicy');

Route::get('/', function (Request $request) {
    if(auth()->check())
    {
        if(auth()->user()->isAdmin()){
    	     return redirect()->route('admin.dashboard');
        }elseif (auth()->user()->isChurch()) {
            return redirect()->route('church.dashboard');
        }
        Auth::logout();
    }
    return redirect('privacypolicy-en');
    // return redirect()->route('login');
})->name('/');

// Auth::routes(['except' => 'password.reset']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


Route::get('email/resend/otp', [ForgotPasswordController::class, 'resedOTP'])->name('email.resend.otp');
Route::get('email/password/reset', [ForgotPasswordController::class , 'showEmailVerification'])->name('email.verification');
Route::post('email/verification', [ForgotPasswordController::class , 'checkOTPVerification'])->name('email.verification.check');
Route::get('new/password', [ForgotPasswordController::class , 'newPasswordPage'])->name('new.password.page');
Route::post('new/password', [ForgotPasswordController::class , 'newPasswordUpdate'])->name('new.password.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('adminlte', function () {
    return abort(404);
    return view('adminlte');
});

Route::get('/logout', [LoginController::class,'logout'])->name('logout');

Route::get('/cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');  
    Artisan::call('clear-compiled');

   return "Cleared!";
});

Route::get('/migrate', function() {

    return Artisan::call('migrate',
        array(
        '--path' => 'database/migrations',
        '--database' => 'mysql',
        '--force' => true));
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return "Storage link generated successfully.";
});

Route::view('welcome', 'welcome');