<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::controller(\App\Http\Controllers\Api\Authentication\AuthenticationController::class)->group(function () {
        Route::post('/signin', 'signInAction');
        Route::post('/register', 'registerAction');
        Route::post('/verify-email', 'emailVerificationAction');
        Route::post('/resend-verification-email', 'resendEmailVerificationAction');
        Route::post('/forgot-password', 'forgotPasswordAction');
        Route::post('/verify-forgot-password', 'verifyForgotPasswordAction');
    });
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reset-password', [\App\Http\Controllers\Api\Authentication\AuthenticationController::class, 'resetPasswordAction']);

    Route::controller(\App\Http\Controllers\Api\Subscription\SubscriptionController::class)->prefix('subscription/')->group(function () {
        Route::post('buy', 'buySubscriptionAction');
        Route::post('cancel', 'cancelSubscriptionAction');
    });
});
