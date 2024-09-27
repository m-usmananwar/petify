<?php

use Illuminate\Http\Request;
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
    Route::post('/signin', [\App\Http\Controllers\Api\Authentication\AuthenticationController::class, 'signInAction']);
    Route::post('/register', [\App\Http\Controllers\Api\Authentication\AuthenticationController::class, 'registerAction']);
    Route::post('/verify-email', [\App\Http\Controllers\Api\Authentication\AuthenticationController::class, 'emailVerificationAction']);
    Route::post('/resend-verification-email', [\App\Http\Controllers\Api\Authentication\AuthenticationController::class, 'resendEmailVerificationAction']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
