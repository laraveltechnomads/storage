<?php

return [
    'emptyData'         => new \stdClass(),
    'validResponse'     => [
        // 'success'    => true,
        'statusCode' => 200,
    ],
    'invalidResponse'   => [
        // 'success'    => false,
        'statusCode' => 400,
    ],
    'invalidToken'      => [
        // 'success'    => false,
        'statusCode' => 401,
        'message'    => 'Unauthorized User!',
    ],

    'u_type'         => [
        'admin'     => 'ADM',
        'user'      => 'USR',
        'church' => 'CHR',
    ],

    'is_active'         => [
        'notActive' => 0,
        'active'    => 1,
    ],

    'is_block'          => [
        'notBlock' => 0,
        'block'    => 1,
    ],
    'notification_type' => [
        'new'       => [ "key" => "new", "name" => "Registration", "message" => "New user registered" ],
        'like'      => [ "key" => "like", "name" => "Post liked", "message" => "Liked on your post" ],
        'comment'   => [ "key" => "comment", "name" => "Post commented", "message" => "Commented on your post" ],
        'request'   => [ "key" => "request", "name" => "Request sent", "message" => "Request sent" ],
        'accept'    => [ "key" => "accept", "name" => "Request accepted", "message" => "Request accepted" ],
        'received'  => [ "key" => "received", "name" => "Request received", "message" => "Request received" ],
        'rejected'  => [ "key" => "rejected", "name" => "Request rejected", "message" => "Request rejected" ],
        'chat'  => [ "key" => "chat", "name" => "Request chat", "message" => "Request chat" ],
    ],
    'favourite' => [
        'messages'      => [ "key" => "messages" , "name" => "Messages" , "message" => "Messages from chat" ],
        'posts'         => [ "key" => "posts" , "name" => "Posts" , "message" => "Posts from news feed (posted by any user)" ],
        'songs'         => [ "key" => "songs" , "name" => "Songs" , "message" => "Songs" ],
        'diary_posts'   => [ "key" => "diary_posts" , "name" => "Diary posts" , "message" => "Diary posts" ],
        'bible_verses'  => [ "key" => "bible_verses" , "name" => "Bible verses" , "message" => "Bible verses" ],
        'calendar_events'=> [ "key" => "calendar_events" , "name" => "Calendar events" , "message" => "Calendar events" ],
        'users'         => [ "key" => "users" , "name" => "Users" , "message" => "Users" ],
    ],
    'chat'          => [
        'agoraAppId' => env('AGORA_APP_ID', null),
        'agoraAppCertificate' => env('AGORA_APP_CERTIFICATE', null)
    ],
    'FCM_SERVER_KEY' => env('FCM_SERVER_KEY', null),
    'SERVER_API_KEY' => env('FCM_SERVER_KEY', null),

    'document_size_limit' => 1000,

    #local
    #'share_form_link' => 'http://localhost/github/bible_chat/public',

    #hostapp_live
    #'share_form_link' => 'https://bibleappbackend.hostappshere.co.in/public'

    #live_aws
    #'share_form_link' => 'https://himessiah.com'


];
