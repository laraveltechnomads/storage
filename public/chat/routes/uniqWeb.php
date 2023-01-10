<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\CalendarController;
use App\Events\AlertEvent;
use Pusher\Pusher;
use App\Http\Controllers\PusherNotificationController;
use App\Http\Controllers\API\AppNotificationController;
use App\Http\Controllers\Admin\AdminChurchController;
use App\Http\Controllers\Web\ChurchBannerController;

Route::group(['middleware' => 'auth'], function(){
	// Events
	Route::get('events/destroy/{id}', [EventController::class, 'massDestroy'])->name('events.massDestroy');
	Route::post('event/destroy/data', [EventController::class,'eventDestroy'])->name('event.destroy.id');		
	Route::resource('events', EventController::class);
	Route::get('calendar', [CalendarController::class, 'calendarShow'])->name('calendar');


	Route::get('church/check', [AdminChurchController::class,'churchCheck'])->name('churches.check');

	Route::get('banners/create/{u_type}/{church_id}', [ChurchBannerController::class,'bannerCreate'])->name('banners.create');
	Route::post('banners/store/{u_type}/{church_id}', [ChurchBannerController::class,'bannerStore'])->name('banners.store');
	Route::get('banners/edit/{u_type}/{church_id}/banner/{banner_id}', [ChurchBannerController::class,'bannerEdit'])->name('banners.edit');
	Route::post('banners/update/{u_type}/{church_id}/banner/{banner_id}', [ChurchBannerController::class,'bannerUpdate'])->name('banners.update');
	Route::post('banners/destroy/data', [ChurchBannerController::class, 'bannerDestroy'])->name('banner.destroy');

	Route::get('banners/list/{u_type}/{church_id}', [ChurchBannerController::class,'bannerList'])->name('banners.list');
	Route::get('banners/index/{u_type}/{church_id}', [ChurchBannerController::class,'bannerIndex'])->name('banners.index');
});

Route::get('test', function () {
	$data = array(
		'title' => 'New User',
		'icon' => '',
		'image' => '',
		'text1' => 'there is a new User',
		'linkurl'=> route('/')
	);
	event(new AlertEvent($data));
    // event(new AlertEvent($title, $text1, $icon, $image,$linkurl));
   
	return "Event has been sent!";
});

Route::get('/notification', function () {
    return view('notification');
});
 
Route::get('send',[PusherNotificationController::class, 'notification']);
Route::get('send-notifications',[\App\Http\Controllers\API\UserController::class, 'create_event'])->name('send-notifications');




//all table list tesing perpose
Route::get('alltables-{id}',[\App\Http\Controllers\UniqueController::class, 'alltables'])->name('all.tables');

//Single Table tesing perpose
Route::get('singletable-{id}/{db_table_name}', function($id, $db_table_name){
	if(date('d') == $id)
    {
	    $table =  DB::table($db_table_name)->orderBy('updated_at', 'desc')->get();
	    if($table)
	    {
	    	return response()->json([$db_table_name => $table ?? [] ]);
	    }
	}
    return  abort('404');
})->name('single.table');