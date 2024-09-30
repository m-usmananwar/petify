<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Response\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Modules\Authentication\Services\AuthenticationService;
use App\Http\Controllers\Api\Authentication\Requests\SignInRequest;
use App\Http\Controllers\Api\Authentication\Requests\RegistrationRequest;
use App\Http\Controllers\Api\Authentication\Requests\ForgotPasswordRequest;
use App\Http\Controllers\Api\Authentication\Requests\EmailVerificationRequest;
use App\Http\Controllers\Api\Authentication\Requests\PasswordVerificationRequest;
use App\Http\Controllers\Api\Authentication\Requests\EmailVerificationUpdateRequest;
use App\Http\Controllers\Api\Authentication\Requests\ResetPasswordRequest;

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
    {   try{
            DB::beginTransaction();
            $verificationId = $this->service->register($request->toDto());
            DB::commit();

            return ApiResponse::success(['message' => 'Registration successful. Check your email for a code to verify your account.', 'verificationId' => $verificationId]);
        } catch (\Exception $e) {
            DB::rollBack();
            DB::commit();
            throw $e;
        }
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
        $verificationId = $this->service->resendEmailVerification($request->toDto());

        return ApiResponse::success(['message' => 'Verification email sent.', 'verificationId' => $verificationId]);
    }

    public function forgotPasswordAction(ForgotPasswordRequest $request): ApiResponse
    {
        $verificationId = $this->service->forgotPassword($request->toDto());

        return ApiResponse::success(['message' => 'Password reset email sent.', 'verificationId' => $verificationId]);
    }

    public function verifyForgotPasswordAction(PasswordVerificationRequest $request): ApiResponse
    {
        $user = $this->service->verifyForgotPassword($request->toDto());

        $userResource = new UserResource($user);

        return ApiResponse::success(array_merge($userResource->toArray($request), [
            "token" => $user->createToken('authToken')->plainTextToken
        ]));
    }

    public function resetPasswordAction(ResetPasswordRequest $request): ApiResponse
    {
        $this->service->resetPassword($request->toDto());

        return ApiResponse::success(['message' => 'Password reset successfully.']);
    }
}
