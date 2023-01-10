<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\PostDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ChurchController;
use App\Http\Controllers\API\SongsController;
use App\Http\Controllers\API\DiaryController;
use App\Http\Controllers\API\CalendarController;
use App\Http\Controllers\API\FriendController;
use App\Http\Controllers\API\AppNotificationController;
use App\Http\Controllers\API\FavouriteController;
use App\Http\Controllers\API\FavouriteTypeController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\AgoraVideoController;
use App\Http\Controllers\API\BlackListController;
use App\Http\Controllers\API\ContactUsController;

/*  Prefix /api/v1/   */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('login', [PassportController::class, 'login']);
// Route::post('register', [PassportController::class, 'register']);

// Route::middleware('auth:api')->group(function () {
// 	Route::get('user', [PassportController::class, 'details']);
// 	Route::post('user', function(){
// 		return response()->json(['user' => auth()->user()], 200);
// 	});
// });

Route::group(['middleware' => ['auth:api', 'user' ] ], function() {
   //middleware group already use in  App\Providers\RouteServiceProvider.php 
   // api prefix use /api/v1/
   // middleware(['api', 'user'])
   // namespace($this->namespace)
     
   	Route::get('user', [UserController::class, 'details'])->name('details');
    Route::post('profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::post('church/website/update', [UserController::class, 'churchWebsiteUpdate'])->name('church.website.update');

    Route::get('church/list', [ChurchController::class, 'churchList'])->name('churchlist');
    Route::get('song/list', [SongsController::class, 'list']);
    
    /* one church members  all posts list & search */
    Route::get('post/homePostList', [PostDataController::class, 'homePostList']);
    Route::get('post/list', [PostDataController::class, 'list']);
    Route::post('post/add', [PostDataController::class, 'create']);
    Route::post('post/edit', [PostDataController::class, 'update']);
    Route::post('post/remove', [PostDataController::class, 'delete']);

    //post filter search
    Route::get('post/list?search', [PostDataController::class, 'list']);

    Route::post('post/like/add', [PostDataController::class, 'addLike']);
    Route::post('post/like/remove', [PostDataController::class, 'removeLike']);

    Route::post('post/comment/list', [PostDataController::class, 'getComment']);
    Route::post('post/comment/add', [PostDataController::class, 'addComment']);
    Route::post('post/comment/edit', [PostDataController::class, 'editComment']);
    Route::post('post/comment/remove', [PostDataController::class, 'removeComment']);

    Route::post('post/share/add', [PostDataController::class, 'addShare']);

    Route::get('diary/list', [DiaryController::class, 'list']);
    Route::post('diary/add', [DiaryController::class, 'create']);
    Route::post('diary/edit', [DiaryController::class, 'update']);
    Route::post('diary/remove', [DiaryController::class, 'delete']);

    Route::post('event/add', [CalendarController::class, 'create']);
    Route::post('event/edit', [CalendarController::class, 'update']);
    Route::post('event/remove', [CalendarController::class, 'delete']);
    Route::get('event/user/calendar/list', [CalendarController::class, 'list']);

    Route::post('getProfileFromUId', [UserController::class, 'getProfileFromUId']);
    Route::get('generateQrCode', [UserController::class, 'generateQrCode']);

    Route::get('friend/suggestionList', [FriendController::class, 'suggestionList']);
    Route::post('friend/sendRequest', [FriendController::class, 'sendRequest']);
    Route::post('friend/requestList', [FriendController::class, 'requestList']);
    Route::post('friend/acceptRequest', [FriendController::class, 'acceptRequest']);
    Route::post('friend/rejectRequest', [FriendController::class, 'rejectRequest']);
    
    Route::post('/save-token', [UserController::class, 'saveToken'])->name('save-token');
    Route::post('/post/like/notification', [UserController::class, 'postLikeNotification'])->name('postLike.notification');
    Route::post('/send-notification', [UserController::class, 'sendNotification'])->name('send.notification');

    //User same church events list 
    Route::get('church/events/list', [CalendarController::class, 'userChurchEvents']);
    Route::get('user/church/events/calendar', [CalendarController::class, 'churchCalendar']);

    //User All Notification
    Route::get('user/notifications', [AppNotificationController::class, 'allNotifications']);
    // user selected notificaion delete
    Route::post('user/notification/delete', [AppNotificationController::class, 'deleteAppNotification']);

    //other users profile list show
    Route::get('other/user/profile/{uniqueId}', [UserController::class, 'otherUserdetails'])->name('other.user.details');

    /* Favourites Module   */
    // user favourite add
    Route::get('user/favourite/name/{type_name}/select/{select_id}', [FavouriteController::class, 'favouriteAddRemove']);
    Route::post('user/favourite/name/{type_name}/select', [FavouriteController::class, 'favouritePostAddRemove']);
    //user single type favourite list show
    Route::get('user/favourite/{type_name}', [FavouriteController::class, 'index']);
    // User All Favourites List show
    Route::get('user/favourites', [FavouriteController::class, 'allFavouritesList']);
    /* Favourites API   */

    /* Chat Module API   */

    //single user group chat create 
    Route::post('user/group/chat/create', [ChatController::class, 'groupChatAdd']);
    //single user all groups list
    Route::get('user/group/chat/list', [ChatController::class, 'groupChatList']);
    // single user group chat members list
    Route::get('user/group/chat/members/list/{group_id}', [ChatController::class, 'groupChatMembersList']);
    //single user selected group list remove
    Route::get('user/group/chat/list/remove/{group_id}', [ChatController::class, 'groupChatListRemove']);
    // Update Group Chat
    Route::post('user/group/chat/update', [ChatController::class, 'updateGroupChat']);
    // Members add Group Chat
    Route::post('user/group/chat/members/add', [ChatController::class, 'membersAddGroupChat']);
    /* Members Exit to Group Chat*/
    Route::post('user/group/chat/members/exit', [ChatController::class, 'membersExitGroupChat']);
    /* Single Members Exit to Group Chat*/
    Route::post('user/group/chat/login/member/exit', [ChatController::class, 'loginMemberExitGroup']);
    /* Admin created other member admin */
    Route::post('user/group/chat/add/admin', [ChatController::class, 'adminAddGroup']);
    
    /* Chat Module API   */

    /*  Agora Chat Video & call token get */
    Route::post('user/agora/chat/token', [AgoraVideoController::class, 'token']);
    /*  Agora Chat Video & call token get */

    /* IOS firebase Chat Video & call notification get */
    Route::post('user/voip/chat/notification', [AppNotificationController::class, 'IOSNotificationNew']);
    /* IOS firebase Chat Video & call notification get */

    /* User select a language */
    Route::post('user/select/language', [UserController::class, 'selectLanguage']);


    /* Church Banner List  */
    Route::get('user/church/banner/list', [ChurchController::class, 'churchBannerList']); 



    /* friend Black all list--------------------------  */
    Route::any('member/black/list', [BlackListController::class, 'getBlackList']);
    Route::any('member/black/addAndRemove', [BlackListController::class, 'addAndRemoveBlackList']);
    // Route::any('foo', function(){});

    /* contact us & work with us */
    Route::post('contact_us_store', [ContactUsController::class, 'store']);
});