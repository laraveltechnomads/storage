<?php

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function changeDateFormate($date,$date_format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function project($name){ 
	if($name == 'app_name')
	{
		return Str::replace('_', ' ', config('app.name'));
	}

	if($name == 'app_favicon_path')
	{
		return env('APP_URL_File').'/assets/admin/images/logo/favicon.ico';
	}
	if($name == 'app_logo_path')
	{
		return env('APP_URL_File').'/storage/company_files';
	}

    if ($name == 'app_info_email') {
        return 'test.user25112020@gmail.com';
    }
    if ($name == 'app_contact_email') {
        return 'info@roltonn.com';
    }

}

// Upload files
function uploadFile($file, $dir, $filecount = null)
{
    $fileName = time() . $filecount . '.' . $file->getClientOriginalExtension();
    Storage::disk('public')->putFileAs($dir, $file, $fileName);
    return $fileName;
}
//remove file
function removeFile($file, $dir) {
    $existImage = storage_path() . '/app/public/' . $dir . '/' . $file;
    if (File::exists($existImage)) {
        File::delete($existImage);
    }
}

/*Category File Show*/
function category_file_show($file)
{
    return asset('/').'storage/uploads/categories/'.$file;
}

/*Category file path*/
function category_public_path()
{
    return public_path('storage/uploads/categories/');
}

/*Category File Show*/
function product_file_show($file)
{
    return asset('/').'storage/uploads/products/'.$file;
}

/*Category file path*/
function product_public_path()
{
    return public_path('storage/uploads/products/');
}

function is_active()
{
    return 1;
}

function is_inactive()
{
    return 0;
}

function is_delete()
{
    return 2;
}

function all_products()
{
    return $products = Product::join('categories','products.cat_id','=','categories.id')
            ->select('products.*','categories.name as cat_name')
            ->where('products.product_status', is_active())
            ->orderBy('products.id','DESC')
            ->get();
}