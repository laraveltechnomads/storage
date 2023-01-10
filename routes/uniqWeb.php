<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('uniq', function () {
	return "uniq!";
});

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