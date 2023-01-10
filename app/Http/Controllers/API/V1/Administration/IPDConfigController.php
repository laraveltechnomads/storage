<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\IPD\AdmissionTypeMaster;
use App\Models\API\V1\IPD\BedAmenityMaster;
use App\Models\API\V1\IPD\BedMaster;
use App\Models\API\V1\IPD\BedReleaseCheck;
use App\Models\API\V1\IPD\BlockMaster;
use App\Models\API\V1\IPD\ClassMaster;
use App\Models\API\V1\IPD\DischargeDestinationMaster;
use App\Models\API\V1\IPD\DischargeTemplateMaster;
use App\Models\API\V1\IPD\DischargeType;
use App\Models\API\V1\IPD\FloorMaster;
use App\Models\API\V1\IPD\IdentityMaster;
use App\Models\API\V1\IPD\PatientVitalMaster;
use App\Models\API\V1\IPD\ReferenceType;
use App\Models\API\V1\IPD\RoomAmenityMaster;
use App\Models\API\V1\IPD\RoomMaster;
use App\Models\API\V1\IPD\WardMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IPDConfigController extends Controller
{
    public function searchListBuildingMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = BlockMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Block Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateBuildingMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:block_masters',
                    'description' => 'required|unique:block_masters',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:block_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required|unique:block_masters,code,'.@$request['id'],
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = BlockMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Block Master add successfully',$data, $code = 200);
                }else{
                    $find_block = BlockMaster::find($request['id']);
                    if($find_block){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_block->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_block->id,
                            'code' => $find_block->code,
                            'description' => $find_block->description,
                            'status' => $find_block->status
                        ];
                        return sendDataHelper('Block Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListFloorMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = FloorMaster::join('block_masters','block_masters.id','=','floor_masters.block_id');
            if(isset($search))
            {
                $description->where('floor_masters.description', 'like', "%{$search}%");
            }
            $response = $description->select('floor_masters.id','floor_masters.code','floor_masters.block_id','block_masters.description as building','floor_masters.description','floor_masters.room_amenities','floor_masters.status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Floor Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function findRoomBedMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = RoomAmenityMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description')->whereStatus(1)->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Floor Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateFloorMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:floor_masters',
                    'description' => 'required|unique:floor_masters',
                    'block_id' => 'required',
                    'room_amenities' => 'sometimes|required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:floor_masters,code,'.@$request['id'],
                    'block_id' => 'sometimes|required',
                    'description' => 'sometimes|required|unique:floor_masters,description,'.@$request['id'],
                    'room_amenities' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    if(@$request['room_amenities']){
                        $request['room_amenities'] = implode(",",@$request['room_amenities']);
                    }
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = FloorMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'block_id' => $block_master->block_id,
                        'room_amenities' => $block_master->room_amenities,
                        'status' => 1
                    ];
                    return sendDataHelper('Floor Master add successfully',$data, $code = 200);
                }else{
                    $find_floor = FloorMaster::find($request['id']);
                    if($find_floor){
                        if(isset($request['status'])){
                            $store['status'] = $request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['block_id']){
                            $store['block_id'] = $request['block_id'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if(@$request['room_amenities']){
                            $store['room_amenities'] = implode(",",@$request['room_amenities']);
                        }
                        $store['status'] = @$request['status'];
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_floor->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_floor->id,
                            'code' => $find_floor->code,
                            'description' => $find_floor->description,
                            'block_id' => $find_floor->block_id,
                            'room_amenities' => $find_floor->room_amenities,
                            'status' => $find_floor->status
                        ];
                        return sendDataHelper('Floor Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListWardMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = WardMaster::join('units','units.id','=','ward_masters.unit_id')
            ->join('floor_masters','floor_masters.id','=','ward_masters.floor_id')
            ->join('ward_types','ward_types.id','=','ward_masters.ward_type_id')
            ->join('block_masters','block_masters.id','=','ward_masters.block_id');
            if(isset($search))
            {
                $description->where('ward_masters.description', 'like', "%{$search}%");
            }
            $response = $description->select(
                'ward_masters.id',
                'ward_masters.code',
                'ward_masters.status',
                'ward_masters.description',
                'block_masters.description as block_name',
                'block_masters.id as block_id',
                'floor_masters.description as floor_name',
                'floor_masters.id as floor_id',
                'ward_types.description as ward_type',
                'ward_types.id as ward_type_id',
                'units.clinic_name as unit',
                'units.id as unit_id'
            )->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Ward Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateWardMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:ward_masters',
                    'description' => 'required|unique:ward_masters',
                    'unit_id' => 'required',
                    'block_id' => 'required',
                    'floor_id' => 'required',
                    'ward_type_id' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:ward_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required|unique:ward_masters,description,'.@$request['id'],
                    'status' => 'sometimes|required',
                    'unit_id' => 'sometimes|required',
                    'block_id' => 'sometimes|required',
                    'floor_id' => 'sometimes|required',
                    'ward_type_id' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $add['created_unit_id'] = Auth::guard('client')->user()->id;
                    $add['added_by'] = Auth::guard('client')->user()->fname;
                    $add['added_on'] = Auth::guard('client')->user()->fname;
                    $add['added_date_time'] = now();
                    $add['added_utc_date_time'] = now();
                    $add['added_windows_login_name'] = gethostname();
                    $add['code'] = $request['code'];
                    $add['description'] = $request['description'];
                    $add['unit_id'] = $request['unit_id'];
                    $add['block_id'] = $request['block_id'];
                    $add['floor_id'] = $request['floor_id'];
                    $add['ward_type_id'] = $request['ward_type_id'];
                    $block_master = WardMaster::create($add);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Ward Master add successfully',$data, $code = 200);
                }else{
                    $find_ward = WardMaster::find($request['id']);
                    if($find_ward){
                        if(@$request['unit_id']){
                            $store['unit_id'] = $request['unit_id'];
                        }
                        if(@$request['block_id']){
                            $store['block_id'] = $request['block_id'];
                        }
                        if(@$request['floor_id']){
                            $store['floor_id'] = $request['floor_id'];
                        }
                        if(@$request['ward_type_id']){
                            $store['ward_type_id'] = $request['ward_type_id'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['block_id']){
                            $store['block_id'] = $request['block_id'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_ward->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_ward->id,
                            'code' => $find_ward->code,
                            'description' => $find_ward->description,
                            'status' => $find_ward->status
                        ];
                        return sendDataHelper('Ward Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListRoomMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = RoomMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','amenity_ids as amenity_id','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Room Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateRoomMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:room_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:room_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = RoomMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Room Master add successfully',$data, $code = 200);
                }else{
                    $find_room = RoomMaster::find($request['id']);
                    if($find_room){
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_room->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_room->id,
                            'code' => $find_room->code,
                            'description' => $find_room->description,
                            'status' => $find_room->status
                        ];
                        return sendDataHelper('Room Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListAmenitiesMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = RoomAmenityMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Room Amenities Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateAmenitiesMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:room_amenity_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:room_amenity_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = RoomAmenityMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Room Amenities Master add successfully',$data, $code = 200);
                }else{
                    $find_room = RoomAmenityMaster::find($request['id']);
                    if($find_room){
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if (isset($request['status'])) {
                            $store['status'] = @$request['status'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_room->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_room->id,
                            'code' => $find_room->code,
                            'description' => $find_room->description,
                            'status' => $find_room->status
                        ];
                        return sendDataHelper('Room Amenities Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListClassMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = ClassMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','c_code as code','description','deposit_for_ipd','deposit_for_ot','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Class Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateClassMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:class_masters,c_code',
                    'description' => 'required|unique:class_masters,description',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'required|unique:class_masters,c_code,'.@$request['id'],
                    'description' => 'required|unique:class_masters,description,'.@$request['id'],
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $add['description'] = @$request['description'];
                    $add['c_code'] = @$request['code'];
                    $add['added_date_time'] = now();
                    $add['added_utc_date_time'] = now();
                    $add['added_windows_login_name'] = gethostname();
                    $block_master = ClassMaster::create($add);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->c_code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Class Master add successfully',$data, $code = 200);
                }else{
                    $find_class = ClassMaster::find($request['id']);
                    if($find_class){
                        if(@$request['code']){
                            $store['c_code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if (isset($request['status'])) {
                            $store['status'] = @$request['status'];
                        }
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_class->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_class->id,
                            'code' => $find_class->c_code,
                            'description' => $find_class->description,
                            'status' => $find_class->status
                        ];
                        return sendDataHelper('Class Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListBedMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $search = @$request['description']; 
                }
            }
            $description = BedMaster::join('class_masters','class_masters.id','=','bed_masters.bed_class_id')
            ->join('room_masters','room_masters.id','=','bed_masters.room_id')
            ->join('ward_masters','ward_masters.id','=','bed_masters.ward_id')
            ->join('units','units.id','=','bed_masters.unit_id');

            if(isset($search))
            {
                $description->where('bed_masters.description', 'like', "%{$search}%");
            }
            $response = $description->select('bed_masters.id',
            'bed_masters.code',
            'bed_masters.description',
            'bed_masters.is_non_consus',
            'bed_masters.status',
            'units.clinic_name',
            'units.id as unit_id',
            'ward_masters.description as ward_name',
            'ward_masters.id as ward_id',
            'room_masters.description as room_name',
            'room_masters.id as room_id',
            'class_masters.description as bed_class',
            'class_masters.id as bed_id',
            'bed_masters.status'
            )->get();
           
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Bed Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }  
    }
    public function findWardBedMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            $validation = Validator::make((array)$request,[
                'id' => 'required',
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                $block_master = WardMaster::where(['unit_id'=>$request['id'],'status'=>1])->get(['id','description']);
                if($block_master){
                    return sendDataHelper('Onchange Units Ward List',$block_master, $code = 200);
                }else{
                    return sendDataHelper('Onchange Units Ward List',[], $code = 200);
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addUpdateBedMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:bed_masters',
                    'description' => 'required',
                    'clinic_id' => 'required',
                    'is_central_store' => 'required',
                    'cost_center_code' => 'required',
                    'bed_class_id' => 'required',
                    'is_non_consus' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:bed_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'unit_id' => 'sometimes|required',
                    'room_id' => 'sometimes|required',
                    'ward_id' => 'sometimes|required',
                    'bed_class_id' => 'sometimes|required',
                    'is_non_consus' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = BedMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Bed Master add successfully',$data, $code = 200);
                }else{
                    $find_bed = BedMaster::find($request['id']);
                    if($find_bed){
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if(@$request['deposit_for_ipd']){
                            $store['deposit_for_ipd'] = $request['deposit_for_ipd'];
                        }
                        if(@$request['deposit_for_ot']){
                            $store['deposit_for_ot'] = $request['deposit_for_ot'];
                        }
                        if(@$request['unit_id']){
                            $store['unit_id'] = $request['unit_id'];
                        }
                        if(@$request['block_id']){
                            $store['block_id'] = $request['block_id'];
                        }
                        if(@$request['room_id']){
                            $store['room_id'] = $request['room_id'];
                        }
                        if(@$request['ward_id']){
                            $store['ward_id'] = $request['ward_id'];
                        }
                        if(@$request['bed_class_id']){
                            $store['bed_class_id'] = $request['bed_class_id'];
                        }
                        if (isset($request['status'])) {
                            $store['status'] = @$request['status'];
                        }
                        if (isset($request['is_non_consus'])) {
                            $store['is_non_consus'] = @$request['is_non_consus'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_bed->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_bed->id,
                            'code' => $find_bed->code,
                            'description' => $find_bed->description,
                            'status' => $find_bed->status
                        ];
                        return sendDataHelper('Bed Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListBedAmenitiesMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = BedAmenityMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Bed Amenity Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }  
    }
    public function addUpdateBedAmenitiesMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:bed_amenity_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:bed_amenity_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = BedAmenityMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Bed Amenity Master add successfully',$data, $code = 200);
                }else{
                    $find_bed_aminity = BedAmenityMaster::find($request['id']);
                    if($find_bed_aminity){
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if (isset($request['status'])) {
                            $store['status'] = @$request['status'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_bed_aminity->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_bed_aminity->id,
                            'code' => $find_bed_aminity->code,
                            'description' => $find_bed_aminity->description,
                            'status' => $find_bed_aminity->status
                        ];
                        return sendDataHelper('Bed Amenity Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListDischargeType(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            $des_ids = [];
            $description = DischargeType::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Discharge Type list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateDischargeType(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:discharge_types',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:discharge_types,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = DischargeType::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Discharge Type Master add successfully',$data, $code = 200);
                }else{
                    $find_discharge = DischargeType::find($request['id']);
                    if($find_discharge){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_discharge->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_discharge->id,
                            'code' => $find_discharge->code,
                            'description' => $find_discharge->description,
                            'status' => $find_discharge->status
                        ];
                        return sendDataHelper('Discharge Type Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListDischargeDestiMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = DischargeDestinationMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Discharge Destination Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateDischargeDestiMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:discharge_destination_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:discharge_destination_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = DischargeDestinationMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Discharge Type Master add successfully',$data, $code = 200);
                }else{
                    $find_discharge_desti = DischargeDestinationMaster::find($request['id']);
                    if($find_discharge_desti){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_discharge_desti->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_discharge_desti->id,
                            'code' => $find_discharge_desti->code,
                            'description' => $find_discharge_desti->description,
                            'status' => $find_discharge_desti->status
                        ];
                        return sendDataHelper('Discharge Destination Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListDischargeTemplateMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = DischargeTemplateMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','template','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Discharge Template Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateDischargeTemplateMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:discharge_template_masters',
                    'description' => 'required',
                    'template' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:discharge_template_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'template' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $block_master = DischargeTemplateMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'template' => $block_master->template,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Discharge Template Master add successfully',$data, $code = 200);
                }else{
                    $find_discharge_template = DischargeTemplateMaster::find($request['id']);
                    if($find_discharge_template){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        if(@$request['template']){
                            $store['template'] = $request['template'];
                        }
                        $find_discharge_template->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_discharge_template->id,
                            'code' => $find_discharge_template->code,
                            'template' => $find_discharge_template->template,
                            'description' => $find_discharge_template->description,
                            'status' => $find_discharge_template->status
                        ];
                        return sendDataHelper('Discharge Template Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListAdmissionTypeMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = AdmissionTypeMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");

            }
            $response = $description->select('id','code','description','link_service','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Discharge Template Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateAdmissionTypeMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:admission_type_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:admission_type_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = AdmissionTypeMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Admission Type Master add successfully',$data, $code = 200);
                }else{
                    $find_discharge_template = AdmissionTypeMaster::find($request['id']);
                    if($find_discharge_template){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_discharge_template->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_discharge_template->id,
                            'code' => $find_discharge_template->code,
                            'description' => $find_discharge_template->description,
                            'status' => $find_discharge_template->status
                        ];
                        return sendDataHelper('Admission Type Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchAdmissionTypeMaster(Request $request){
        try {
            // $specialization_id = null;
            // $sub_spe_id = null;
            $service_name = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    // $specialization_id = @$request['specialization_id'];   
                    // $sub_spe_id = @$request['sub_spe_id'];  
                    $service_name = @$request['description']; 
                }
            }
            $description = ServiceMaster::join('specializations','specializations.id','=','service_masters.specialization_id')
            ->join('sub_specializations','sub_specializations.id','=','service_masters.sub_specialization_id');
            // if(isset($specialization_id)){
            //     $description->where('service_masters.specialization_id',$specialization_id);
            // }
            // if(isset($sub_spe_id)){
            //     $description->where('service_masters.sub_specialization_id',$sub_spe_id);
            // }
            if(isset($service_name)){
                $description->where('service_masters.description', 'like', "%{$service_name}%");
            }
            $response = $description->select('service_masters.id','service_masters.description as service_name','service_masters.base_service_rate')->get();
           
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All List of Admission Type Master.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function linkServiceAdmissionTypeMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            $validation = Validator::make((array)$request,[
                'id' => 'required',
                'link_service' => 'required',
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                $admission_type = AdmissionTypeMaster::find($request['id']);
                if($admission_type){
                    $admission_type->update(['link_service' => implode(",",(array)$request['link_service'])]);
                    DB::commit();
                }else{
                    return sendError('please provide valid id.', [], 400);
                }
                // $id = str_replace(array('[',']'),'',implode(" ",(array)$admission_type->link_service));
                // $response = ServiceMaster::join('specializations','specializations.id','=','service_masters.specialization_id')
                // ->join('sub_specializations','sub_specializations.id','=','service_masters.sub_specialization_id')
                // ->whereIn('service_masters.id',explode(',', $id))
                // ->get(['service_masters.id','service_masters.description as service_name','specializations.description as specialization','sub_specializations.description as sub_specialization']);
    
                $response = [
                    'id' => $admission_type->id,
                    'link_service' => $admission_type->link_service,
                ];
                if($response == []){	
                    return sendDataHelper('No content.', $response, $code = 204);	
                }else{	
                    return sendDataHelper('All List of service to link admission.', $response, $code = 200);	
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListbedReleaseCheckList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = BedReleaseCheck::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Bed Release Check List list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdatebedReleaseCheckList(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:bed_release_checks',
                    'description' => 'required',
                    'is_mandatory' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:bed_release_checks,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                    'is_mandatory' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $block_master = BedReleaseCheck::create($request);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Bed Release Check List add successfully',$data, $code = 200);
                }else{
                    $find_bed_release = BedReleaseCheck::find($request['id']);
                    if($find_bed_release){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(isset($request['is_mandatory'])){
                            $store['is_mandatory'] = @$request['is_mandatory'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_bed_release->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_bed_release->id,
                            'code' => $find_bed_release->code,
                            'description' => $find_bed_release->description,
                            'status' => $find_bed_release->status
                        ];
                        return sendDataHelper('Bed Release Check List modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListPatientVital(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = PatientVitalMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");

            }
            $response = $description->get(['id','code','description','status']);
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Reference Entity Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdatePatientVital(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:patient_vital_masters',
                    'description' => 'required',
                    'default_val' => 'required',
                    'min_value' => 'required',
                    'max_value' => 'required',
                    'unit_name' => 'sometimes|required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:patient_vital_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'default_val' => 'sometimes|required',
                    'min_value' => 'sometimes|required',
                    'max_value' => 'sometimes|required',
                    'unit_name' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $patient_vital_master = PatientVitalMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $patient_vital_master->id,
                        'code' => $patient_vital_master->ref_type_code,
                        'description' => $patient_vital_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Patient Vital Master add successfully',$data, $code = 200);
                }else{
                    $find_patient = PatientVitalMaster::find($request['id']);
                    if($find_patient){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['default_val']){
                            $store['default_val'] = $request['default_val'];
                        }
                        if(@$request['min_value']){
                            $store['min_value'] = $request['min_value'];
                        }
                        if(@$request['max_value']){
                            $store['max_value'] = $request['max_value'];
                        }
                        if(@$request['unit_name']){
                            $store['unit_name'] = $request['unit_name'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_patient->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_patient->id,
                            'code' => $find_patient->code,
                            'description' => $find_patient->description,
                            'status' => $find_patient->status
                        ];
                        return sendDataHelper('Patient Vital Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListIdentityMaster(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = IdentityMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");

            }
            $response = $description->get(['id','code','description','status']);
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Identity Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateIdentityMaster(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:identity_masters',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:identity_masters,code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $request['created_unit_id'] = Auth::guard('client')->user()->id;
                    $request['added_by'] = Auth::guard('client')->user()->fname;
                    $request['added_on'] = Auth::guard('client')->user()->fname;
                    $request['added_date_time'] = now();
                    $request['added_utc_date_time'] = now();
                    $request['added_windows_login_name'] = gethostname();
                    $patient_vital_master = IdentityMaster::create($request);
                    DB::commit();
                    $data = [
                        'id' => $patient_vital_master->id,
                        'code' => $patient_vital_master->ref_type_code,
                        'description' => $patient_vital_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Identity Master add successfully',$data, $code = 200);
                }else{
                    $find_identity = IdentityMaster::find($request['id']);
                    if($find_identity){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_identity->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_identity->id,
                            'code' => $find_identity->code,
                            'description' => $find_identity->description,
                            'status' => $find_identity->status
                        ];
                        return sendDataHelper('Identity Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchListReferenceEntity(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = ReferenceType::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");

            }
            $response = $description->get(['id','ref_type_code as code','description','status']);
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Reference Entity Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    public function addUpdateReferenceEntity(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:reference_types,ref_type_code',
                    'description' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:reference_types,ref_type_code,'.@$request['id'],
                    'description' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    $add['ref_type_code'] = $request['code'];
                    $add['description'] = $request['description'];
                    $add['created_unit_id'] = Auth::guard('client')->user()->id;
                    $add['added_by'] = Auth::guard('client')->user()->fname;
                    $add['added_on'] = Auth::guard('client')->user()->fname;
                    $add['added_date_time'] = now();
                    $add['added_utc_date_time'] = now();
                    $add['added_windows_login_name'] = gethostname();
                    $block_master = ReferenceType::create($add);
                    DB::commit();
                    $data = [
                        'id' => $block_master->id,
                        'code' => $block_master->ref_type_code,
                        'description' => $block_master->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Reference Entity Master add successfully',$data, $code = 200);
                }else{
                    $find_reference = ReferenceType::find($request['id']);
                    if($find_reference){
                        if(isset($request['status'])){
                            $store['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $store['ref_type_code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $store['description'] = $request['description'];
                        }
                        $store['updated_unit_id'] = Auth::guard('client')->user()->id;
                        $store['updated_by'] = Auth::guard('client')->user()->fname;
                        $store['updated_date_time'] = now();
                        $store['updated_utc_date_time'] = now();
                        $store['update_windows_login_name'] = gethostname();
                        $find_reference->update($store);
                        DB::commit();
                        $data = [
                            'id' => $find_reference->id,
                            'code' => $find_reference->ref_type_code,
                            'description' => $find_reference->description,
                            'status' => $find_reference->status
                        ];
                        return sendDataHelper('Reference Entity Master modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
