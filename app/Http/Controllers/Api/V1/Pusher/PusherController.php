<?php

namespace App\Http\Controllers\Api\V1\Pusher;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherController extends Controller
{
    public function authenticate(Request $request)
    {
        $socketId = $request['socket_id'];
        $channelName = $request['channel_name'];
        $pusherAppId = config('general.pusher.appId');
        $pusherAppKey = config('general.pusher.appKey');
        $pusherAppSecret = config('general.pusher.appSecret');

        $pusher = new Pusher($pusherAppKey, $pusherAppSecret, $pusherAppId);

        $auth = $pusher->authorizeChannel($channelName, $socketId);

        if ($auth) {
            return response($auth, 200)
                ->header('Content-Type', 'application/json');
        }

        return response()->json(['authentication' => false], 403);
    }
}
