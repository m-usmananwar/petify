<?php

namespace App\Modules\Authentication\Services;

use App\Models\User;
use Faker\Core\File;
use App\Helpers\FileHandler;
use Illuminate\Support\Facades\Hash;
use App\Modules\Authentication\DTO\SignInDTO;
use App\Modules\Authentication\DTO\RegistrationDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Modules\Authentication\DTO\EmailVerificationDTO;
use App\Modules\Authentication\DTO\EmailVerificationUpdateDTO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Modules\Authentication\Repositories\Interfaces\IVerificationRepository;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;
use PhpParser\Node\Stmt\Nop;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class AuthenticationService
{
    public function __construct(
        private readonly IAuthenticationRepository $repository,
        private readonly IVerificationRepository $verificationRepository
        )
    {
        
    }

    public function signIn(SignInDTO $dto): User
    {
        $user = $this->repository->findOneBy(['email' => $dto->email]);

        if(!$user) {
            throw new NotFoundHttpException('User not found against this email address');
        }

        if(!$user->email_verified_at) {
            throw new AccessDeniedHttpException('Email address not verified');
        }

        if(!Hash::check($dto->password, $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        return $user;
    }

    public function register(RegistrationDTO $dto): void
    {
        $data['first_name'] = $dto->firstName;
        $data['last_name'] = $dto->lastName;
        $data['username'] = $dto->userName;
        $data['contact_no'] = $dto->contactNo;
        $data['email'] = $dto->email;
        $data['password'] = Hash::make($dto->password);

        $user = $this->repository->save($data);

        $filePath = FileHandler::generateUserSpecificPath($user->id, config('general.filePaths.profileImages'));

        $uploadedFilePath = FileHandler::uploadFile($dto->image, $filePath);

        $user->image = $uploadedFilePath;
        $user->save();
        
        $user->resetEmailVerification();
    }

    public function verifyEmail(EmailVerificationDTO $dto): User
    {
        $verification = $this->verificationRepository->findOneBy(['unique_id' => $dto->verificationId, 'type' => $dto->type]);

        if(!$verification) {
            throw new NotFoundHttpException('Verification not found');
        }

        $user = $this->repository->findOneBy(['id' => $verification->user_id]);

        if($user->isVerified()) {
            throw new AccessDeniedHttpException('User already verified');
        }

        $userVerification = $user->verifyEmail($dto->verificationCode);     

        if(!$userVerification) {
            throw new HttpResponseException(
                response()->json([
                    'message' => "Invalid verification code.",
                    'debugger' => "Invalid verification code."
                ], 422)
            );
        } else if($userVerification === 'expired') {
            throw new HttpResponseException(
                response()->json([
                    'message' => "Verification code has expired.",
                    'debugger' => "Verification code has expired. Please send the verification email again."
                ], 422)
            );
        } else if($userVerification === 'failed_attempts') {
            throw new HttpResponseException(
                response()->json([
                    'message' => "Too many failed attempts.",
                    'debugger' => "Too many failed attempts. Please send the verification email again."
                ], 422)
            );
        }
        
        return $user;
    }

    public function resendEmailVerification(EmailVerificationUpdateDTO $dto): void
    {
        $user = $this->repository->findOneBy(['email' => $dto->email]);

        if(!$user) {
            throw new NotFoundHttpException('User not found against this email address');
        }

        if($user->isVerified()) {
            throw new AccessDeniedException('User already verified');
        }

        $user->resetEmailVerification();
    }
}