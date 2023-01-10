<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use Carbon\Carbon;

class SongsController extends Controller
{
    /** all songs list. */
    public function list(Request $request)
    {
        $search = Null;
        if($request->search)
        {
            $search = $request->search;
        }
        $songs = Song::where('song_name', 'like', '%'.$search.'%')->orderBy('updated_at', 'desc')->get();
        foreach($songs as $key =>  $song){
            $songs[$key]['isFavourite'] = FavouriteCheckHelper(config('constants.favourite.songs.key'), $song->id);
        }
        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$songs,
        ], config('constants.validResponse.statusCode'));
    }

}