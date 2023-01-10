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
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

// logout route
Route::get('logout-user', function(Request $request)
{
	Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/login');
})->name('logout-user');
Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as'=>'admin.'], function(){
		// dashboard route  
		Route::get('dashboard', function () { 
			return redirect()->route('admin.blogs.index');
			return view('admin.dashboard.index'); 
		})->name('dashboard');
		Route::get('blogs/index', [AdminBlogController::class,'index'])->name('blogs.index');
		Route::get('blogs/create', [AdminBlogController::class,'create'])->name('blogs.create');
		Route::post('blogs/store', [AdminBlogController::class,'store'])->name('blogs.store');
		Route::get('blogs/{blog}/edit', [AdminBlogController::class,'edit'])->name('blogs.edit');
		Route::post('blogs/update/{blog}', [AdminBlogController::class,'update'])->name('blogs.update');
		Route::get('blogs/check', [AdminBlogController::class,'check'])->name('blogs.check');
		Route::post('blog/show', [AdminBlogController::class,'show'])->name('blog.show');
		Route::get('blog/show/{blog}', [AdminBlogController::class,'showPage'])->name('blog.page.show');
		Route::post('blog/destroy/data', [AdminBlogController::class,'destroy'])->name('blog.destroy.id');
});


Route::group(['middleware' => 'admin'], function(){
	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);

});