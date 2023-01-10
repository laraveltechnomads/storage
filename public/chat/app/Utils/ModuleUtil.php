<?php
namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class ModuleUtil
{
    public function getDays()
    {
      return [
            'sunday' => __('lang_v1.sunday'),
            'monday' => __('lang_v1.monday'),
            'tuesday' => __('lang_v1.tuesday'),
            'wednesday' => __('lang_v1.wednesday'),
            'thursday' => __('lang_v1.thursday'),
            'friday' => __('lang_v1.friday'),
            'saturday' => __('lang_v1.saturday')
        ];

    }

    public function uploadFile($request, $file_name, $dir_name, $file_type = 'image')
    {
        //If app environment is demo return null
        if (config('app.env') == 'demo') {
            return null;
        }        

        $uploaded_file_name = null;
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {            

            //Check if mime type is image
            if ($file_type == 'image') {
                if (strpos($request->$file_name->getClientMimeType(), 'image/') === false) {
                    throw new \Exception("Invalid image file");
                }
            }

            if ($file_type == 'document') {
                if (!in_array($request->$file_name->getClientMimeType(), array_keys(config('constants.document_upload_mimes_types')))) {
                    throw new \Exception("Invalid document file");
                }
            }

            
            if ($request->$file_name->getSize() <= config('constants.document_size_limit')) {
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
            }
        }
        return $uploaded_file_name;

    }
}