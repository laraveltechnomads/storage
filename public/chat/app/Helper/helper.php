<?php

use App\Models\User;
use App\Events\AlertEvent;
use App\Events\NewUser;
use App\Models\BlackList;
use App\Models\Church;
use App\Models\Favourite;

function project($name){
	if($name == 'app_name')
	{
		return config('app.name');
		return "Bible Chat";
	}

	if($name == 'app_favicon_path')
	{
		return asset('/assets/admin/images/logo/favicon.ico');
	}
	if($name == 'app_logo_path')
	{
		return asset('/assets/admin/images/logo/logo.png');
	}
}

function song_folder(){
	return public_path('/assets/admin/songs/');
}

function song_path($song_file){
	return asset('/assets/admin/songs/').'/'.$song_file;
}

function churchDestinationPath(){
	return public_path('/assets/admin/images/church/');
}

function church_image_path($church_image){
	return asset('/assets/admin/images/church/').'/'.$church_image;
}

function exception($e)
{
	return response()->json([
	    'message' => $e->getMessage(),
	    'data'    => Config('constants.emptyData'),
	], Config('constants.invalidResponse.statusCode'));
}

// Upload files
function uploadFile($file, $dir, $filecount = null) {
    $ext = $file->getClientOriginalExtension();
    if($ext != ''){
        $fileName = time() . $filecount . '.' . $ext;

    }else{
        $ext = $file->extension();
        $fileName = time() . $filecount . '.' . $ext;

    }

    Storage::disk('public')->putFileAs($dir, $file, $fileName);

    return $fileName;
}

// Response media file
function responseMediaLink($file, $dirfolder) {
    // $fileResponseLink = asset('storage/common/default.png');
    $fileResponseLink = '';

    if ($dirfolder == 'user') {
        $fileResponseLink = asset('storage/common/profile.png');
    }

    if (strpos($file, 'http') !== false) {
        $fileResponseLink = $file;
    } else {
        if ($file != "" || $file != NULL) {
            $fileResponseLink = asset('storage') . '/' . $dirfolder . '/' . $file;
        }
    }

    return $fileResponseLink;
}

//remove file
function removeFile($file, $dir) {
    $existImage = storage_path() . '/app/public/' . $dir . '/' . $file;
    if (File::exists($existImage)) {
        File::delete($existImage);
    }
}

function pushNotificationToAdmin($title,$message = '',$icon='',$image='',$linkurl='') {
    event(new AlertEvent($title, $message,  $icon, $image, $linkurl));
    return true;
}

//times ago calculation
function timeago($date) {
    $timestamp = strtotime($date);	
    
    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        if($strTime[$i] == 'hour')
        {
            return $diff . "h ago ";    
        }
        if($diff == 1 && $strTime[$i] == 'day')
        {
            return "Yesterday";    
        }
        return $diff . " " . $strTime[$i] . "(s) ago ";
    }
 }

 //Long text to short text 
  if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

//fix string 20 characters
if (! function_exists('short_string')) {
    function short_string($str) {
            $rest = substr($str, 0, 20);
            return $rest;
    }
}

function userTable($user_id)
{
    return $userTable = User::withTrashed()->whereIn('u_type', ['USR'])->where('id', $user_id)->first();
}

function logo_pic_path()
{
    return route('/').'/assets/admin/images/logo/favicon.ico';
}

function profile_pic_path()
{
    return route('/').'/storage/pics/';
}

function store_pic_path()
{
    return storage_path() . '/app/public/pics/';
}

function profile_qr_path()
{
    return route('/').'/storage/qrcodes/';
}

function store_qr_path()
{
    return storage_path() . '/app/public/qrcodes/';
}

function group_pic_path()
{
    return route('/').'/storage/chat/';
}

function store_group_pic_path()
{
    return storage_path() . '/app/public/chat/';
}


function store_church_path()
{
    return storage_path() . '/app/public/church/';
}

function church_path()
{
    return asset('/').'storage/church/';
}

function banner_public_path(){
	return asset('/').'storage/banner/';
}

function store_banner_path()
{
    return storage_path() . '/app/public/banner/';
}



function dataNotFound($data = NULL)
{
    return response()->json([
        'message' => $data.' Data not Found.',
        'data'    => Config('constants.emptyData'),
    ], Config('constants.invalidResponse.statusCode'));
}

function dayMonthNameYear($date)
{
    $yesterday = date('Y-m-d', strtotime('-1 days'));
    if($yesterday > date('Y-m-d', strtotime($date) ) )
    {
        $showDate = date('d M, Y', strtotime($date));
    }else{
        $showDate = timeago($date);
    }
    return $showDate;
}

function church_name_helper()
{
    return Church::first()->value('church_name');
}

function single_church_helper()
{
    return Church::first()->id;
}

function single_church_details()
{
    return Church::first();
}



function strRandom($num)
{
    return strtotime("now").Str::random($num);
}

function member($mem_id)
{
    return User::where([['id' ,'=', $mem_id], ['u_type', '=', config('constants.u_type.user') ]])->first();
}

function FavouriteCheckHelper($type_name, $select_id)
{
    $check = Favourite::where('user_id', auth()->user()->id)->where('favourite_type', $type_name)->where('select_id', $select_id)->first();
    if($check){
        return true;
    }else{
        return false;
    }
}
function VOIP_certificate_path()
{
    return public_path('assets/Messiah_VOIP_certificate.pem');
}

