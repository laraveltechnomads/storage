<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RazorpayPaymentController;
use App\Models\API\V1\Master\AppointmentStatus;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

@include('admin.php');
@include('uniqWeb.php');

Route::get('/', function (Request $request) {
   return abort(404); 
})->name('/');


Route::get('razorpay-payment/{id}', [RazorpayPaymentController::class, 'index']);

Route::post('payment', [RazorpayPaymentController::class,'payment'])->name('payment');

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

Route::get('dob/{dob}', function (Request $request, $dob) {
    $date_of_birth = $dob ?? "2022-03-14 12:00:00";
    return get_age($date_of_birth);
})->name('dob');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
