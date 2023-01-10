<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Artisan;

@include('adminWeb.php');
@include('homeWeb.php');


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

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('/cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');  
   return "Cleared!";
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return "Storage link generated successfully.";
});

Route::get('/migrate', function() {

    return Artisan::call('migrate',
        array(
        '--path' => 'database/migrations',
        '--database' => 'mysql',
        '--seed' => true,
        '--force' => true));
});
Route::get('/migrate_new', function() {

    return Artisan::call('migrate',
        array(
        '--path' => 'database/migrations',
        '--database' => 'mysql',
        '--seed' => true,
        '--force' => true));
});
