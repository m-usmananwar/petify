<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Api\Authentication\Requests\RegistrationRequest;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Modules\Authentication\Services\AuthenticationService;
use App\Http\Controllers\Api\Authentication\Requests\SignInRequest;

class AuthenticationController extends Controller
{
    public function __construct(private readonly AuthenticationService $service)
    {
        
    }
    
    public function signInAction(SignInRequest $request): ApiResponse
    {
        $user = $this->service->signIn($request->all());
        $userResource = new UserResource($user);

        return ApiResponse::success(array_merge($userResource->toArray($request), [
            'token' => $user->createToken('authToken')->plainTextToken,
        ]));
    }

    public function registerAction(RegistrationRequest $request): ApiResponse
    {
        $user = $this->service->register($request->all());
        $userResource = new UserResource($user);
        
        return ApiResponse::success(array_merge($userResource->toArray($request), [
            'token' => $user->createToken('authToken')->plainTextToken,
        ]));
    }
}
