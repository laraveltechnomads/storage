<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diary;
use Carbon\Carbon;
use App\Models\Favourite;
use DB;

class DiaryController extends Controller
{
    /** all diary list. */
    public function list(Request $request){
        $diaryDetail = Diary::where('user_id',auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        $response = [];
        foreach($diaryDetail as $diary){
            $diaryArr = [
                'diary_id'    => $diary->id,
                'title'       => $diary->title,
                'description' => $diary->description,
                'image'       => responseMediaLink($diary->image,'diary'),
                'created_at'  => $diary->created_at,
                'isFavourite' => FavouriteCheckHelper(config('constants.favourite.diary_posts.key'), $diary->id)
            ];
            array_push($response, $diaryArr);
        }
        
        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$response,
        ], config('constants.validResponse.statusCode'));
    }

    public function create(Request $request) {
        DB::beginTransaction();
        try {

            $file = '';
            if($request->hasFile('image')) {
                $file = uploadFile($request->file('image'), 'diary');
            }
            Diary::create([
                'user_id'     => auth()->user()->id,
                'title'       => $request->title,
                'description' => $request->description,
                'image'       => $file,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Diary created successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function update(Request $request) {
        DB::beginTransaction();
        try {
            $diary = Diary::where('id', $request->diary_id)->first();

            if(!$diary) {  return dataNotFound();   }

            $file = $diary->image;
            if ($request->hasFile('image')) {
                removeFile($file, 'diary');

                $file = uploadFile($request->file('image'), 'diary');
            }

            Diary::where('id', $request->diary_id)->update([
                'title'       => $request->title,
                'description' => $request->description,
                'image' => $file,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Diary updated successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function delete(Request $request) {
        DB::beginTransaction();
        try {
            $diary = Diary::where('id', $request->diary_id)->first();
            $file = $diary->image;
            removeFile($diary->image, 'diary');
            
            Diary::where('id', $request->diary_id)->delete();
            DB::commit();
            return response()->json([
                'message' => 'Diary deleted successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

}