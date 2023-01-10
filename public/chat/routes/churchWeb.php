<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Church\ChurchController;
use App\Http\Controllers\Auth\ChurchAuthController;
use App\Http\Controllers\Admin\ContactUsController;

// Route::get('/church/login', [ChurchAuthController::class, 'showLoginForm'])->name('church.login.get');
// Route::post('/church/login', [ChurchAuthController::class, 'login'])->name('church.login');
// Route::get('/church/logout', [ChurchAuthController::class, 'logout'])->name('church.logout');

Route::group(['middleware' => 'church', 'prefix' => 'church', 'as'=>'church.'], function(){
	
	Route::get('dashboard', [ChurchController::class,'dashboard'])->name('dashboard');
	// Route::resource('churches', ChurchController::class);	
	Route::get('check', [ChurchController::class,'churchCheck'])->name('check');
	Route::get('edit', [ChurchController::class,'edit'])->name('edit');
	Route::get('show', [ChurchController::class,'show'])->name('show');
	Route::post('update/{id}', [ChurchController::class,'update'])->name('update');

	Route::get('contact-us/index', [ContactUsController::class,'contactIndex'])->name('contactus.index');
		Route::get('contact-us/message/view/{ContactUs}', [ContactUsController::class,'contactMessageView'])->name('contactus.message.view');
		Route::post('single/contactUs/delete', [ContactUsController::class,'deleteContactUs'])->name('single.contactus.delete');
		
		Route::get('work-with-us/index', [ContactUsController::class,'workUsIndex'])->name('workus.index');
		Route::get('work-with-us/message/view/{WorkUs}', [ContactUsController::class,'workUsMessageView'])->name('workus.message.view');
		Route::post('single/work-with-us/delete', [ContactUsController::class,'deleteWorkWithUs'])->name('single.work.with.us.delete');
});