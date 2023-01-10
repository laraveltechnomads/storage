<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminSongsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminNotifyController;
use App\Http\Controllers\Admin\AdminChurchController;

Route::get('check/song', [AdminSongsController::class,'songCheck'])->name('songs.check');



Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as'=>'admin.'], function(){
		// dashboard route  
		Route::get('dashboard', function () { 
			return view('admin.dashboard.index'); 
		})->name('dashboard');

		Route::resource('songs', AdminSongsController::class);
		Route::resource('churches', AdminChurchController::class);
		Route::resource('users', AdminUserController::class);
		
		Route::get('church/destroy/{id}', [AdminChurchController::class, 'churchDestroyDirect'])->name('church.massDestroy');

		Route::get('songs/check', [AdminSongsController::class,'check'])->name('songs.check');
		
		Route::post('songs/destroy/data', [AdminSongsController::class,'songDestroy'])->name('songs.destroy.id');
		Route::post('church/destroy/data', [AdminChurchController::class,'churchDestroy'])->name('church.destroy.id');
		Route::post('user/activeInactive/data', [AdminUserController::class,'userStatus'])->name('user.status.id');
		Route::post('church/status/change/data', [AdminChurchController::class,'statusChangeChurchTable'])->name('church.status.change.id');

		//all Notification page
		Route::get('all/notifications', [AdminNotifyController::class,'index'])->name('notifications.list');
		Route::post('single/notification/delete', [AdminNotifyController::class,'deleteNotification'])->name('single.notification.delete');
		Route::get('bell-notifications', [AdminNotifyController::class, 'bellNotifications'])->name('get.bell-notifications');
});
