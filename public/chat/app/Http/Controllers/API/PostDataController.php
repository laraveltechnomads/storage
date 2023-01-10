<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\PostComment;
use App\Models\Like;
use Carbon\Carbon;
use App\Notifications\LikeNotification;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\File;
use App\Models\BlackList;
use App\Models\Church;
use Illuminate\Support\Facades\DB;

class PostDataController extends Controller
{
    /** all post list. */
    public function list(Request $request){
        // return $request;
        
        $postDetail = Post::orderBy('updated_at', 'desc');
        $search = $request->search ?? Null;
        if($request->post_id)
        {
            $post_id = $request->post_id;
            $postDetail->orWhere(function($queryPost) use($post_id)
            {
                $queryPost->where('id', $post_id);
            });

            $search = NULL;
        }

        $postDetail->whereHas('user', function ($query) use ($search){
            $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('first_name', 'like', '%'.$search.'%')
            ->orWhere('last_name', 'like', '%'.$search.'%');
        })
        ->with(['postMedia','like' => function($like){
            $like->where('user_id',auth()->user()->id);
        },'user' => function($query) use ($search){
            $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('first_name', 'like', '%'.$search.'%')
            ->orWhere('last_name', 'like', '%'.$search.'%');
        }])
        ->with('like')
        ->where('user_id',auth()->user()->id);
        $postDetail = $postDetail->get();
        // $postDetail = Post::orderBy('created_at','desc');

        // return $postDetail;
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
            $is_like = (count($post->like) > 0) ? 1 : 0;

            // foreach($post->like as $media){
            //     $is_like = 1;
            // }

            $existImage = store_pic_path(). $post->user->pic;
            if (File::exists($existImage)) {
                $post->user->pic = profile_pic_path().$post->user->pic;
            }

            $postArr = [
                'post_id'    => $post->id,
                'title'    => $post->title,
                'isFavourite' => FavouriteCheckHelper(config('constants.favourite.posts.key'), $post->id),
                'description'    => $post->description,
                'likes'    => $post->likes,
                'shares'    => $post->shares,
                'comments' => PostComment::where('post_id', $post->id)->count(),
                'created_at' => $post->created_at,
                'time_show' => dayMonthNameYear($post->created_at),
                'post_media' => $postMedia,
                'is_liked' => $is_like,
                'user_name' => $post->user->name,
                'user_email' => $post->user->email,
                'uniqid' => $post->user->uniqid,
                'pic' => $post->user->pic,
                'church_name' => $post->user->church_name ? $post->user->church_name : Church::value('church_name'),
            ];
            array_push($response, $postArr);
        }
        
        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$response,
        ], config('constants.validResponse.statusCode'));
    }

    public function homePostList(Request $request){
        
        $blackList = BlackList::where('member_id', auth()->user()->id)->pluck('user_id');
        // return  $postDetail = Post::orderBy('updated_at', 'desc')->count();
        $postDetail = Post::orderBy('updated_at', 'desc');
        if($request->post_id)
        {
            $postDetail->where('id', $request->post_id);
        }
       
        $postDetail->whereNotIn('user_id', $blackList);
        if($request->post_id)
        {
            $post_id = $request->post_id;
            $postDetail->orWhere(function($queryPost) use($post_id)
            {
                $queryPost->where('id', $post_id);
            });
        }

        $postDetail->with('postMedia');
        $postDetail->with('like', function($like){
            $like->where('user_id',auth()->user()->id);
        });

        $postDetail = $postDetail->get();

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


            $postArr = [
                'post_id'    => $post->id,
                'title'    => $post->title,
                'post_member_id'    => $post->user->id,
                'isFavourite' => FavouriteCheckHelper(config('constants.favourite.posts.key'), $post->id),
                'description'    => $post->description,
                'likes'    => $post->likes,
                'shares'    => $post->shares,
                'comments' => PostComment::where('post_id', $post->id)->count(),
                'is_liked'   => $is_like,
                'created_at' => $post->created_at,
                'time_show' => $post->created_at,
                'post_media' => $postMedia,
                'user_name' => $post->user->name,
                'user_email' => $post->user->email,
                'uniqid' => $post->user->uniqid,
                'pic' => $post->user->pic,
                'church_name' => $post->user->church_name ? $post->user->church_name : Church::value('church_name'),
                'church_id'    => $post->user->church_id,
            ];
            array_push($response, $postArr);
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
            $post_id = Post::insertGetId([
                'user_id'    => auth()->user()->id,
                'title'     => $request->title,
                'description'  => $request->description,
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ]);

            if ($request->hasFile('media')) {
                foreach($request->file('media') as $key => $file){
                    $type = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $file = uploadFile($file, 'post', $key);
                    PostMedia::create([
                        'post_id' => $post_id,
                        'media_name' => $file,
                        'media_type' => $type,
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'message' => 'Post created successfully.',
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
            
            if ($request->hasFile('media')) {
                $post = PostMedia::where('post_id', $request->post_id)->get();
                
                foreach($post as $file){
                   removeFile($file->media_name, 'post');
                }
                PostMedia::where('post_id', $request->post_id)->delete();

                foreach($request->file('media') as $key => $file){
                    $type = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $file = uploadFile($file, 'post', $key);
                    PostMedia::create([
                        'post_id' => $request->post_id,
                        'media_name' => $file,
                        'media_type' => $type,
                    ]);
                }
            }

            Post::where('id', $request->post_id)->update([
                'title'       => $request->title,
                'description' => $request->description
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Post updated successfully.',
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
        try {

            $post = PostMedia::where('post_id', $request->post_id)->get();
            foreach($post as $file){
                removeFile($file->media_name, 'post');
            }
            PostMedia::where('post_id', $request->post_id)->delete();
            PostComment::where('post_id', $request->post_id)->delete();
            
            Post::where('id', $request->post_id)->delete();


            return response()->json([
                'message' => 'Post deleted successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }


    //like module
    public function addLike(Request $request) {
        DB::beginTransaction();
        try {
            $post = Post::where('id', $request->post_id)->first();
            $likeAl = Like::where('post_id', $request->post_id)->where('user_id', auth()->user()->id)->first();
            if(!$likeAl && $post)
            {
                Post::where('id', $post->id)->update([
                    'likes'    => $post->likes + 1,
                ]);

                Like::create(['post_id' => $post->id,'user_id' => auth()->user()->id]);
                DB::commit();
            
                $userOther = userTable($post->user_id);
                if($userOther)
                {
                    $notifyData = array(
                        'user' => auth()->user(),
                        'post' => $post,
                        'type' => 'like',
                        'message' => 'Liked on your post'
                    );
                    $userOther->notify(new LikeNotification($notifyData) );
                
                    if($userOther->device_token)
                    {
                        $fcm_token = $userOther->device_token;
                        $title='Liked on your post';
                        $message = $post->title;
                        app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $userOther->id);
                    }
                }
            }

            return response()->json([
                'message' => 'Like created successfully.',
                'data'    => config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }
    }

    public function removeLike(Request $request) {
        DB::beginTransaction();
        try {
            $likeAl = Like::where('post_id', $request->post_id)->where('user_id', auth()->user()->id)->first();
            if($likeAl)
            {
                $post = Post::where('id', $request->post_id)->first();
                if($post->likes <= 0)
                {
                    $like = 0;
                }else{
                    $like = $post->likes - 1;
                }

                $post_id = Post::where('id', $request->post_id)->update([
                    'likes'    => $like,
                ]);

                Like::where(['post_id'=> $request->post_id ,'user_id'=> auth()->user()->id])->forceDelete();
                DB::commit();
            }

            return response()->json([
                'message' => 'Like removed successfully.',
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

    //comment module
    public function getComment(Request $request) {
        try {
            $post_comment = PostComment::with('user')->where('post_id', $request->post_id)->get();


            $postComment = [];
            foreach($post_comment as $comment){
                $existImage = store_pic_path(). $comment->user->pic;
                if (File::exists($existImage)) {
                    $comment->user->pic = profile_pic_path().$comment->user->pic;
                }
                $postArr = [
                    'comment_id'    => $comment->id,
                    'comment'    => $comment->comment,
                    'created_at'    => $comment->created_at,
                    'user_id'    => $comment->user->id,
                    'pic' => $comment->user->pic,
                    'user_name'    => $comment->user->name,
                    'post_id'    => $comment->post_id,
                ];
                array_push($postComment, $postArr);
            }

            return response()->json([
                'message' => 'success',
                'data'    => $postComment,
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function addComment(Request $request) {
        try {
            $comment_id = PostComment::insertGetId([
                'post_id'    => $request->post_id,
                'user_id'    => auth()->user()->id,
                'comment'     => $request->comment,
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ]);

            $post_comment = PostComment::with('user')->where('id', $comment_id)->first();

            $postArr = [
                'comment_id'    => $comment_id,
                'comment'    => $post_comment->comment,
                'created_at'    => $post_comment->created_at,
                'user_id'    => $post_comment->user->id,
                'user_name'    => $post_comment->user->name,
                'post_id'    => $post_comment->post_id
            ];
            $post = Post::where('id', $request->post_id)->first();
            if($post)
            {
                $userOther = userTable($post->user_id);
                if($userOther)
                {
                    $notifyData = array(
                        'user' => auth()->user(),
                        'post' => $post,
                        'type' => 'comment',
                        'message' => 'Commented on your post'
                    );
                    $userOther->notify(new CommentNotification($notifyData) );
                    if($userOther->device_token)
                    {
                        $fcm_token = $userOther->device_token;
                        $title='Post Commented';
                        $message = $post->title;
                        app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $userOther->id);
                    }
                }
            }

            return response()->json([
                'message' => 'Comment created successfully.',
                'data'    => $postArr,
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function editComment(Request $request) {
        try {

            PostComment::where('id',$request->comment_id)->update([
                'comment'     => $request->comment,
            ]);

            return response()->json([
                'message' => 'Comment updated successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function removeComment(Request $request) {
        try {
            PostComment::where('id', $request->comment_id)->delete();

            return response()->json([
                'message' => 'Comment deleted successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    /* share post count store */
    public function addShare(Request $request) {
        DB::beginTransaction();
        try {
            $post = Post::find($request->post_id);
            $post->increment('shares');
            DB::commit();
            return response()->json([
                'message' => 'Share count add successfully.',
                'data'    => config('constants.emptyData')
            ], config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }
    }
}