<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['cors'])->group(function () {

    Route::middleware(['guest'])->group(function () {
        Route::controller(\App\Http\Controllers\Api\V1\Authentication\AuthenticationController::class)->group(function () {
            Route::post('/signin', 'signInAction');
            Route::post('/register', 'registerAction');
            Route::post('/verify-email', 'emailVerificationAction');
            Route::post('/resend-verification-email', 'resendEmailVerificationAction');
            Route::post('/forgot-password', 'forgotPasswordAction');
            Route::post('/verify-forgot-password', 'verifyForgotPasswordAction');
        });
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/authenticate-pusher', [\App\Http\Controllers\Api\V1\Pusher\PusherController::class, 'authenticate']);

        Route::post('/reset-password', [\App\Http\Controllers\Api\V1\Authentication\AuthenticationController::class, 'resetPasswordAction']);

        Route::controller(\App\Http\Controllers\Api\V1\Subscription\SubscriptionController::class)->prefix('subscription/')->group(function () {
            Route::post('buy', 'buySubscriptionAction');
            Route::post('change-plan', 'changeSubscriptionPlanAction');
            Route::post('change-plan-and-payment-method', 'changeSubscriptionPlanAndPaymentMethodAction');
            Route::post('resume', 'resumeSubscriptionAction');
            Route::post('cancel', 'cancelSubscriptionAction');
        });

        Route::apiResource('auctions', \App\Http\Controllers\Api\V1\Auction\AuctionController::class)->except('index');
        Route::apiResource('bids', \App\Http\Controllers\Api\V1\Bid\BidController::class)->only(['index', 'store']);
    });


    $middleware = [];

    if (Request::header('Authorization')) $middleware = array_merge($middleware, ['auth:sanctum']);

    Route::middleware($middleware)->group(function () {
        Route::get('auctions', [\App\Http\Controllers\Api\V1\Auction\AuctionController::class, 'index']);
    });
});
