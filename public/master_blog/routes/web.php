<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;

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
@include('authorWeb.php');

// Route::get('/', function(){
//     $blogs = Blog::where('status', 1)->get();
//     return view('front.home', compact('blogs'));

// })->name('/');
Route::get('/', [BlogController::class,'index'])->name('/');


Route::get('dashboard', function(){
    if (auth()->check() &&  auth()->user()->hasRole('role_author') ) {
            return redirect()->route('author.dashboard');
    }else if (auth()->check() &&  auth()->user()->hasRole('role_admin') ) {
            return redirect()->route('admin.dashboard');
    }
    return redirect()->route('/');
});

Route::get('/adminlte', function(){
    return view('adminlte');
})->name('/adminlte');

Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');



Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout'])->name('logout');
	Route::get('/clear-cache', [HomeController::class,'clearCache']);
});


Route::post('tags/store', [TagController::class,'store'])->name('tags.store');
Route::get('check/blog', [BlogController::class,'blogCheck'])->name('blog.check');

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


Route::get('{slug}', [BlogController::class,'blogPageShow'])->name('single.blog.show');
