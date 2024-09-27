<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Modules\Authentication\Services\AuthenticationService;
use App\Http\Controllers\Api\Authentication\Requests\SignInRequest;
use App\Http\Controllers\Api\Authentication\Requests\RegistrationRequest;
use App\Http\Controllers\Api\Authentication\Requests\EmailVerificationRequest;
use App\Http\Controllers\Api\Authentication\Requests\EmailVerificationUpdateRequest;

class AuthenticationController extends Controller
{
    public function __construct(private readonly AuthenticationService $service)
    {
        
    }
    
    public function signInAction(SignInRequest $request): ApiResponse
    {
        $user = $this->service->signIn($request->toDto());
        $userResource = new UserResource($user);

        return ApiResponse::success(array_merge($userResource->toArray($request), [
            'token' => $user->createToken('authToken')->plainTextToken,
        ]));
    }

    public function registerAction(RegistrationRequest $request): ApiResponse
    {
        $user = $this->service->register($request->toDto());
        
        return ApiResponse::success(['message' => 'Registration successful. Check your email for a code to verify your account.']);
    }

    public function emailVerificationAction(EmailVerificationRequest $request): ApiResponse
    {
        $user = $this->service->verifyEmail($request->toDto());

        $userResource = new UserResource($user);
        
        return ApiResponse::success(array_merge($userResource->toArray($request), [
            "token" => $user->createToken('authToken')->plainTextToken
        ]));
    }

    public function resendEmailVerificationAction(EmailVerificationUpdateRequest $request): ApiResponse
    {
        $this->service->resendEmailVerification($request->toDto());

        return ApiResponse::success(['message' => 'Verification email sent.']);
    }
}
