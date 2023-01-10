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
use App\Http\Controllers\Author\AuthorBlogController;

Route::group(['middleware' => 'author', 'prefix' => 'author', 'as'=>'author.'], function(){
		// dashboard route  
		Route::get('dashboard', function () { 
			return redirect()->route('author.blogs.index');
			return view('author.dashboard.index'); 
		})->name('dashboard');
		Route::get('blogs/index', [AuthorBlogController::class,'index'])->name('blogs.index');
		Route::get('blogs/create', [AuthorBlogController::class,'create'])->name('blogs.create');
		Route::post('blogs/store', [AuthorBlogController::class,'store'])->name('blogs.store');
		Route::get('blogs/{blog}/edit', [AuthorBlogController::class,'edit'])->name('blogs.edit');
		Route::post('blogs/update/{blog}', [AuthorBlogController::class,'update'])->name('blogs.update');
		Route::get('blogs/check', [AuthorBlogController::class,'check'])->name('blogs.check');
		Route::post('blog/show', [AuthorBlogController::class,'show'])->name('blog.show');
		Route::get('blog/show/{blog}', [AuthorBlogController::class,'showPage'])->name('blog.page.show');
		Route::post('blog/destroy/data', [AuthorBlogController::class,'destroy'])->name('blog.destroy.id');
});