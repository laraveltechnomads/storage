<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\WorkUs;
use DB;

class ContactUsController extends Controller
{
    /* create contact us details */
    public function store(Request $request)
    {
        return self::createAndUpdateContactUs($request);
    }

    //unique createAndUpdateChurch
    public function createAndUpdateContactUs($request)
    {
        $data = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required'
        ]);
        $data['description'] = $request->description ?? Null;
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try
        {   
            if($request->is_contact_us)
            {
                $contactUs = ContactUs::create($data);
                $list = 'ContactUs'; 
            }else{
                $contactUs = WorkUs::create($data);
                $list= 'Work with Us';
            }
            DB::commit();

            if($contactUs)
            {
                return response([
                    'success' => config('constants.validResponse.statusCode'),
                    'message' => 'Details submitted successfully.',
                    'list' => $list,
                    'data' => $contactUs
                ], config('constants.validResponse.statusCode'));
            }
            return response([
                'success' => config('constants.invalidResponse.statusCode'),
                'message' => 'Details submitted unsuccessfully.',
                'list' => $list,
                'data'    => [],
            ], config('constants.invalidResponse.statusCode'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }
    }
}
