<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:admin', 'prefix' => 'client', 'as'=>'client.', 'guard' => 'client'], function(){
    
});