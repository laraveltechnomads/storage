<?php

use App\Models\API\V1\Master\City;
use App\Models\API\V1\Master\Country;
use App\Models\API\V1\Master\State;
use App\Models\API\V1\Master\TimeSlot;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\API\V1\Master\Unit;

function isAdmin($user): bool
{
    if (!empty($user)) {
        return $user->tokenCan('admin');
    }
    return false;
}
function orderId($id){
    return $id;
}

function dataNotFound($data = NULL)
{
    return response()->json([
        'success' => false,
        'message' => $data,
        'data'    => Config('constants.emptyData'),
    ], 200);
}

function encryptData($decryptMessage)
{   
	$decryptMessage = json_encode($decryptMessage);
	return openssl_encrypt($decryptMessage, env('OPENSSL_CIPHER_NAME'), env('ENCRYPT_KEY'),0, env('ENCRYPT_IV'));
}

function decryptData($encryptedMessage)
{   
	$decrypt = openssl_decrypt($encryptedMessage, env('OPENSSL_CIPHER_NAME'), env('ENCRYPT_KEY'),0, env('ENCRYPT_IV'));
	return json_decode($decrypt, true);
}

function sendErrorHelper($error, $errorMessages = [], $code = 404)
{
    $error =  encryptData($error);
    $errorMessages =  encryptData($errorMessages);
    $response = [
        'success' => false,
        'code' => $code,
        'message' => $error
    ];
    if(!empty($errorMessages)){
        $response['data'] = $errorMessages;
    }
    return response()->json($response, 200);

}

function sendDataHelper($message, $result, $code = 200, $extra = null)
{
    $message =  encryptData($message);
    $result =  encryptData($result);
    $response = [
        'success' => true,
        'code' => $code,
        'message' => $message,
        'data'    => $result
    ];

    if($extra)
    {
        $response['accessToken']  = $extra;
    }
    return response()->json($response, 200);
}

function sendError($error, $errorMessages = [], $code = 404)
{
    $error =  encryptData($error);
    $errorMessages =  encryptData($errorMessages);
    $response = [
        'success' => false,
        'code' => $code,
        'message' => $error
    ];
    if(!empty($errorMessages)){
        $response['data'] = $errorMessages;
    }
    return response()->json($response, 200);
}

// Upload files
function uploadFile($file, $dir, $prefix = null, $id = null, $filecount = null) {
    
    $path = project('app_file').'/'.$dir;    
    is_dir($path) || mkdir($path);

    $ext = $file->getClientOriginalExtension();
    if($ext != ''){
        $fileName = $prefix.'_'.time() . $id . $filecount . '.' . $ext;
    }else{
        $ext = $file->extension();
        $fileName = $prefix.'_'.time() . $id . $filecount . '.' . $ext;
    }
    // Storage::disk('local')->putFileAs($dir, $file, $fileName);
    Storage::disk('cdn_local')->putFileAs($dir, $file, $fileName);
    return $fileName;
}
function deleteFile($name, $dir){
    $path = project('app_file').'/'.$dir;
    if(File::exists($path.'/'.$name)){
        File::delete($path.'/'.$name);
    }
    return true;
}
function uploadBase64Image($img, $type = 'patient')
{
    if(!validateBase64Image($img))
    {
        return false;
    }

    $file = base64_decode($img);
    $safeName = strtotime(now()).'_'.$type.'.'.'png';
    return $safeName;
    // $success = file_put_contents(storage_path().'/app/public/'.$safeName, $file);
    // File::copy(storage_path().'/app/public/'.$safeName,Storage::disk('cdn_local').'/patients/'.$safeName);
    return $safeName;
    
}

//Remove file
function removeFile($file, $dir) {
    $existImage = storage_path().$dir . '/' . $file;
    if (File::exists($existImage)) {
        File::delete($existImage);
    }
}

function store_path()
{
    return env('APP_FILE');
}

/*  Age Show seconds, miniutes, hours, days, months, years
*/
function get_age($date_of_birth)
{
    // $DOB = "2021-03-14 00:00:00";
    $dobDate = Carbon::parse($date_of_birth);
    echo '<br> seconds : ';
    echo  $seconds = $dobDate->diff(Carbon::now())->s;
    echo '<br> minuites : ';
    echo  $minuites = $dobDate->diff(Carbon::now())->i;
    echo '<br> hours : ';
    echo  $hours = $dobDate->diff(Carbon::now())->h;
    echo '<br> days : ';
    echo  $days = $dobDate->diff(Carbon::now())->d;
    echo '<br> months : ';
    echo  $months = $dobDate->diff(Carbon::now())->m;
    echo '<br> years : ';
    echo  $years = $dobDate->diff(Carbon::now())->y;
    echo '<br>';
}

//Returns a boolean
function validateBase64Image($data) {
    //Decode Base 64 data
    $imgData = base64_decode($data);

    //Returns a magic database resource on success or FALSE on failure.
    $fileInfo = finfo_open();
    if(!$fileInfo) {
        return false;
    }

    //Returns a textual description of the string argument, or FALSE if an error occurred.
    //In the case of an image: image/<image extension> e.g. image/jpeg
    $mimeType = finfo_buffer($fileInfo, $imgData, FILEINFO_MIME_TYPE);
    if(!$mimeType) {
        return false;
    }

    //Gets an array
    $mimeArray=explode("/",$mimeType);
    //Validate the file is an image
    if($mimeArray[0]=="image") {
        return true;
    }
    return false;
}

function respValid($request)
{
    $validation = Validator::make($request->all(),[
        'response' => 'required',
        // 'added_by' => 'required',
        // 'added_on' => 'required',
        // 'added_datetime' => 'required|datetime:Y-m-d H:i:s',
        // 'added_utc_date_time' => 'required|datetime:Y-m-d H:i:s',
        // 'added_windows_login_name' => 'required',
        // 'updated_by' => 'required',
        // 'updated_on' => 'required',
        // 'updated_date_time' => 'required|datetime:Y-m-d H:i:s',
        // 'updated_utc_date_time' => 'required|datetime:Y-m-d H:i:s',
        // 'updated_windows_login_name' => 'required'
    ]);

    if($validation->fails()){
        return sendError('Validation Error', $validation->errors()->first());
    }
}

function extraValid($request)
{
    $validation = Validator::make($request->all(),[
        'added_by' => 'required',
        'added_on' => 'required',
        'added_datetime' => 'required|datetime:Y-m-d H:i:s',
        'added_utc_date_time' => 'required|datetime:Y-m-d H:i:s',
        'added_windows_login_name' => 'required',
        'updated_by' => 'required',
        'updated_on' => 'required',
        'updated_date_time' => 'required|datetime:Y-m-d H:i:s',
        'updated_utc_date_time' => 'required|datetime:Y-m-d H:i:s',
        'updated_windows_login_name' => 'required'
    ]);

    if($validation->fails()){
        return sendError('Validation Error', $validation->errors()->first());
    }
}

function country_details($selected_id, $key = Null)
{
    $data = null;
    $details = Country::where('id', $selected_id)->where('status', 1)->first();
    if($details)
    {
        if($key && $key == 'name')
        {
            $data = $details->country_name;
        }else{
            $data = $details;
        }
    }
    return $data;
}
function state_details($selected_id, $key = Null)
{
    $data = null;
    $details = State::where('id', $selected_id)->where('status', 1)->first();
    if($details)
    {
        if($key && $key == 'name')
        {
            $data = $details->state_name;
        }else{
            $data = $details;
        }
    }
    return $data;
}
function city_details($selected_id, $key = Null)
{
    $data = null;
    $details = City::where('id', $selected_id)->where('status', 1)->first();
    if($details)
    {
        if($key && $key == 'name')
        {
            $data = $details->city_name;
        }else{
            $data = $details;
        }
    }
    return $data;
}

function get_patients_path()
{
    return env('APP_CDN').'/app/public/'.patients_path_name().'/';
}

function get_patients_profile__path()
{
    return env('APP_CDN').'/app/public/'.patients_profile_dir().'/';
}

function get_patients_file__path()
{
    return env('APP_CDN').'/app/public/'.patients_file_dir().'/';
}

function patients_path_name()
{
    return 'patients';
}
function patients_profile_dir()
{
    return 'patient_profile';
}

function patients_file_dir()
{
    return 'patient_file';
}

function doctor_profile_dir()
{
    return 'doctor_profile';
}
function doctor_signature_dir()
{
    return 'doctor_signature';
}

function doctor_documents_dir()
{
    return 'doctor_documents';
}

function employee_img_dir()
{
    return 'emp_img';
}

function convertBase64($file, $dir = null, $prefix = null, $id = null, $filecount = null)
{   // img_enc_base64() is manual function you can change the name what you want.
    $folder_path = config('filesystems.disks.cdn_local.root').'/'.patients_profile_dir().'/';
    $image_parts = explode(";base64,", $file);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = $prefix.'_'.time() . rand(0, 100). $id . $filecount . '. '.$image_type;
    $file_path = $folder_path . $file_name;
    file_put_contents($file_path, $image_base64);
    return $file_name;
}

function update_time($time){
    $ap = $time[5].$time[6];
    $ttt = explode(":", $time);
    $th = $ttt['0'];
    $tm = $ttt['1'];
    if($ap=='pm' || $ap=='PM'){
        $th+=12;
        if($th==24){
            $th = 12;
        }
    }
    if($ap=='am' || $ap=='AM'){
        if($th==12){
            $th = '00';
        }
    }
    $newtime = $th.":".$tm[0].$tm[1];
    return $newtime;
    // $time = update_time(date('h:i:s'));    //example
}

function wrongDateHelper()
{
    return strtotime('1970-01-1 00:00:00');
}

function slot_nameHelper($app_slot_id)
{
    $slot_name = TimeSlot::where('id', $app_slot_id)->first();
    return ($slot_name ? $slot_name->description : null);
}

function client_db()
{
    return 'db_multiple_client_4';
}

function queryData($queryData = null)
{
    DB::enableQueryLog();
    $queryData;
    dd(DB::getQueryLog());
}

function isClinic($clinic_id)
{
    return Unit::where('id', $clinic_id)->first();
}

function auth_unit_id()
{
    return auth()->user()->unit_id;
}

function setMailConfig(){

    //Get the data from settings table

    //Set the data in an array variable from settings table
    $mailConfig = [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
        'encryption' => env('MAIL_ENCRYPTION'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'timeout' => null
    ];

    //To set configuration values at runtime, pass an array to the config helper
    config(['mail.mailers.smtp' => $mailConfig]);
}

function allTabledateValid($request)
{
    $validation = Validator::make($request->all(),[
        'added_on' =>'required',
        'added_datetime' => 'required',
        'added_utc_date_time' => 'required',
        'updated_on' => 'required',
        'updated_date_time' => 'required',
        'updated_utc_date_time' => 'required'
    ]);
    if($validation->fails()){
        return sendError('Validation Error', $validation->errors()->first());
    }
}