<?php

namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favourite;
use App\Models\FavouriteType;
use App\Models\Song;
use App\Models\Diary;
use App\Models\Post;
use App\Models\Event;
use DB;
use File;
use App\Models\PostComment;

Class FavouriteUtil
{
    public function favouriteAddRemove($request, $type_name, $select_id)
    {
        DB::beginTransaction();
        try
        {
            $favouriteType = FavouriteType::where('favourite_type', $type_name)->first();
            if(isset($favouriteType))
            {
                $user = auth()->user();
                if(config('constants.favourite.bible_verses.key') == 'bible_verses' && $request->bookId && $request->verseName)
                {
                    if(!$request->bookId && !$request->verseName)
                    {
                        return response([
                            'success' => false,
                            'message' => 'Record not found.',
                            'data' => config('constants.emptyData')
                        ], config('constants.validResponse.statusCode'));
                    }else{
                        $select_id = NULL;
                        $favourite = Favourite::where('user_id', auth()->user()->id)->where('favourite_type', $type_name)->where('bookId', $request->bookId)->where('verseName', $request->verseName)->first();
                    }
                }else{
                    $favourite = Favourite::where('user_id', auth()->user()->id)->where('favourite_type', $type_name)->where('select_id', $select_id)->first();
                }

                if(isset($favourite))
                {
                    $favourite->delete();
                    $msg = 'remove';
                }else{
                    Favourite::create([
                        'user_id' => $user->id,
                        'favourite_type' => $favouriteType->favourite_type,
                        'select_id' => $select_id,
                        'chapterId' => $request->chapterId ?? NULL,
                        'versionId' => $request->versionId ?? NULL,
                        'bookId' => $request->bookId ?? NULL,
                        'languageId' => $request->languageId ?? NULL,
                        'verseName' => $request->verseName ?? NULL
                    ]);
                    $msg = 'add';
                }
            
                DB::commit();
                if(config('constants.favourite.bible_verses.key') ==  $type_name)
                {
                    return response([
                        'success' => true,
                        'message' => 'Favourite '.$msg.' success',
                        'chapterId' => $request->chapterId ?? '',
                        'versionId' => $request->versionId ?? '',
                        'bookId' => $request->bookId ?? '',
                        'languageId' => $request->languageId ?? '',
                        'verseName' => $request->verseName ?? '',
                        'data' => config('constants.emptyData')
                    ], config('constants.validResponse.statusCode'));
                }else{
                    return response([
                        'success' => true,
                        'message' => 'Favourite '.$msg.' success',
                        'data' => config('constants.emptyData')
                    ], config('constants.validResponse.statusCode'));
                }
                
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'chapterId' => $request->chapterId ?? '',
                'versionId' => $request->versionId ?? '',
                'bookId' => $request->bookId ?? '',
                'languageId' => $request->languageId ?? '',
                'verseName' => $request->verseName ?? '',
                'data'    => config('constants.emptyData')
            ], config('constants.invalidResponse.statusCode'));
        }  
    } 

    // favourites selected favourite type list
    public function favouriteList($request, $type_name)
    {
        try
        {
            $response = [];
            $favouriteType = FavouriteType::where('favourite_type', $type_name)->first();
            if(isset($favouriteType))
            {   
                $msg = '';
                if($favouriteType->favourite_type == config('constants.favourite.'.$type_name.'.key') )
                {
                    $msg = config('constants.favourite.'.$type_name.'.name');
                }
                $user = auth()->user();
                $favourites = Favourite::where('user_id', $user->id)->where('favourite_type', $type_name)->get(); 
                if(isset($favourites) )
                {
                    if($type_name == config('constants.favourite.songs.key'))
                    {
                        $response = self::songs($favourites);
                    }
                    if($type_name == config('constants.favourite.diary_posts.key'))
                    {
                        $response = self::diary_posts($favourites);
                    }
                    if($type_name == config('constants.favourite.posts.key'))
                    {
                        $response = self::posts($favourites);
                    }
                    if($type_name == config('constants.favourite.calendar_events.key'))
                    {
                        $response = self::calendar_events($favourites);
                    }
                    if($type_name == config('constants.favourite.bible_verses.key'))
                    {
                        $response = self::bible_verses($favourites);
                    }
                    if($type_name == config('constants.favourite.users.key'))
                    {
                        $response = self::users($favourites);
                    }
                }

                // foreach($favourites as $fav)
                // { 
                //     $arr = [
                //         'favourite_id' => $fav->id,
                //         'user_id' =>  $fav->user_id,
                //         'favourite_type' => $fav->favourite_type,
                //         'select_id' => $fav->select_id
                //     ];
                //     array_push($response, $arr);
                // }
                return response([
                    'success' => true,
                    'message' => 'Favourite '.$msg.' List',
                    'data' => $response,
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

     /* All favourites List */
    public function allFavouritesList($request)
    {
        try
        {
            $response = [];
            $user = auth()->user();
            $favourites = Favourite::where('user_id', $user->id)->get(); 
            foreach($favourites as $fav)
            { 
                if(config('constants.favourite.bible_verses.key') == $fav->favourite_type)
                {
                    $arr = [
                        'favourite_id' => $fav->id,
                        'user_id' =>  $fav->user_id,
                        'favourite_type' => $fav->favourite_type,
                        'select_id' => $fav->select_id,
                        'chapterId' => $fav->chapterId,
                        'versionId' => $fav->versionId,
                        'bookId' => $fav->bookId,
                        'languageId' => $fav->languageId,
                        'verseName' => $fav->verseName
                    ];
                }else{
                    $arr = [
                        'favourite_id' => $fav->id,
                        'user_id' =>  $fav->user_id,
                        'favourite_type' => $fav->favourite_type,
                        'select_id' => $fav->select_id
                    ];
                }
                array_push($response, $arr);
            }
            return response([
                'success' => true,
                'message' => 'Favourites List',
                'data' => $response,
            ], config('constants.validResponse.statusCode'));
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }  
    }

    /* songs list favorites*/
    public function songs($favourites)
    {
        
        $song_ids =$favourites->pluck('select_id');
        $songs = Song::whereIn('id', $song_ids)->orderBy('updated_at', 'desc')->get();
        $response = [];
        foreach($songs as $key =>  $song){
            $arr = [
                'id' => $song->id,
                'song_name' =>  $song->song_name,
                'song_link' => $song->song_link,
                'created_at' => $song->created_at,
                'isFavourite' => FavouriteCheckHelper(config('constants.favourite.songs.key'), $song->id)
            ];
            array_push($response, $arr);
        }
        return $response;
    }

    public function diary_posts($favourites)
    {
        $diary_post_ids =$favourites->pluck('select_id');
        $diaryDetail = Diary::whereIn('id', $diary_post_ids)->orderBy('updated_at', 'desc')->get();
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
        return $response;
    }

    public function posts($favourites)
    {
        $post_ids =$favourites->pluck('select_id');
        $postDetail = Post::whereIn('id', $post_ids)->with(['postMedia','like' => function($like){
            $like->where('user_id',auth()->user()->id);
        }])->orderBy('updated_at', 'desc')->get();

        $response = [];
        foreach($postDetail as $post){
            $postMedia =[];
            foreach($post->postMedia as $media){
                $mediatArr = [
                    'media_id' => $media->id,
                    'media_name' => responseMediaLink($media->media_name,'post'),
                    'media_type' => $media->media_type
                ];
                array_push($postMedia, $mediatArr);
            }
            $is_like = 0;
            foreach($post->like as $media){
                $is_like = 1;
            }

            $existImage = store_pic_path(). $post->user->pic;
            if (File::exists($existImage)) {
                $post->user->pic = profile_pic_path().$post->user->pic;
            }
            $church_name = $post->user->church_name;
            if($post->user->churchData)
            {
                $church_name = $post->user->churchData->church_name;
            }
            $postArr = [
                'post_id'    => $post->id,
                'title'    => $post->title,
                'isFavourite' => FavouriteCheckHelper(config('constants.favourite.posts.key'), $post->id),
                'description'    => $post->description,
                'likes'    => $post->likes,
                'comments' => PostComment::where('post_id', $post->id)->count(),
                'created_at' => $post->created_at,
                'time_show' => dayMonthNameYear($post->created_at),
                'post_media' => $postMedia,
                'is_liked' => $is_like,
                'user_name' => $post->user->name,
                'user_email' => $post->user->email,
                'uniqid' => $post->user->uniqid,
                'pic' => $post->user->pic,
                'church_name' => $church_name,
            ];
            array_push($response, $postArr);
        }
        return $response;
    }


    public function calendar_events($favourites)
    {
        $calendar_event_ids =$favourites->pluck('select_id');
        $eventsList = Event::whereIn('id', $calendar_event_ids)->get();
        $response = [];
        foreach($eventsList as $key =>  $event){
            $event['isFavourite'] = FavouriteCheckHelper(config('constants.favourite.calendar_events.key'), $event->id);
        }
        return $eventsList;
    }

    public function bible_verses($favourites)
    {
        return $bible_versesList = $favourites;
    }

    /* users list favorites*/
    public function users($favourites)
    {
        $users_ids =$favourites->pluck('select_id');
        $users = User::whereIn('id', $users_ids)->get();
        
        $response = [];
        foreach($users as $key =>  $user){
            $existImage = store_pic_path(). $user->pic;
            if (File::exists($existImage)) {
                $user->pic = profile_pic_path().$user->pic;
            }
            
            $arr = [
                'id' => $user->id,
                'user_name' =>  $user->name,
                'first_name' =>  $user->first_name,
                'last_name' => $user->last_name,
                'uniqid' => $user->uniqid,
                'profile_pic' => $user->pic,
                'is_favourite' => FavouriteCheckHelper(config('constants.favourite.users.key'), $user->id)
            ];
            array_push($response, $arr);
        }
        return $response;
    }
}