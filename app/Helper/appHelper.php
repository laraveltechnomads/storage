<?php

use Illuminate\Support\Str;

function project($name){
	if($name == 'app_name')
	{
		return Str::replace('_', ' ', config('app.name'));
	}

	if($name == 'app_favicon_path')
	{
		return env('APP_CDN').'/assets/front/images/logo/favicon.ico';
	}
	if($name == 'app_logo_path')
	{
		return env('APP_CDN').'/assets/front/images/logo/logo.png';
	}
    if ($name == 'app_info_email') {
        return env('APP_API_EMAIL');
    }
	if($name == 'admin_db_name')
	{
		return env('DB_DATABASE_SECOND');
	}

	if($name == 'app_file')
	{
		return env('APP_FILE');
	}
}

/* Role check */
function role($role)
{	
	switch ($role) {
		case config('constants.role.client'):
		  return true;
		  break;
		case config('constants.role.superadmin'):
			return true;
		  break;
		case config('constants.role.subadmin'):
			return true;
		  break;
		default:
			return false;
	}
}

/* Clients select plan duration */ 
function plan_duration()
{
	return [
        'weekly',
        'monthly',
        'quarterly',
        'yearly' 
    ];
}

/* Clients select plan duration */ 
function currency($data)
{
	if($data == 'symbol')
	{
		return '$'; 
	}
	
}

function now_date_time(){
	return date( 'Y-m-d h:i:s', time ());
}
function now_date(){
	return date( 'Y-m-d', time ());
}