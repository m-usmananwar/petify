<?php

return [
    'request' => [
        'paginationLength' => 10,
    ],

    'filePaths' => [
        'profileImages' => 'users/@userId/profile-images',
        'auctionMedias' => 'users/@userId/auction-medias',
    ],

    'pusher' => [
        'appKey' => env('PUSHER_APP_KEY'),
        'appId' => env('PUSHER_APP_ID'),
        'appSecret' => env('PUSHER_APP_SECRET'),
    ]
];
