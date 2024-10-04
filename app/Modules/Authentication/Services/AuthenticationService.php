<?php

namespace App\Modules\Authentication\Services;

use App\Models\User;
use App\Helpers\FileHandler;
use App\Enum\VerificationEnum;
use App\Traits\GenericExceptions;
use Illuminate\Support\Facades\Hash;
use App\Modules\Authentication\DTO\SignInDTO;
use App\Modules\Authentication\DTO\RegistrationDTO;
use App\Modules\Authentication\DTO\ResetPasswordDTO;
use App\Modules\Authentication\DTO\ForgotPasswordDTO;
use App\Modules\Authentication\DTO\EmailVerificationDTO;
use App\Modules\Authentication\DTO\PasswordVerificationDTO;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use App\Modules\Authentication\DTO\EmailVerificationUpdateDTO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Modules\Authentication\Repositories\Interfaces\IVerificationRepository;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;

class AuthenticationService
{
    use GenericExceptions;

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
            $this->throwNotFoundException('User not found against this email address');
        }

        if(!$user->email_verified_at) {
            $this->throwAccessDeniedException('Email address not verified');
        }

        if(!Hash::check($dto->password, $user->password)) {
            $this->throwUnauthorizedException('Invalid credentials');
        }

        return $user;
    }

    public function register(RegistrationDTO $dto): string
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
        
        $user->createAsStripeCustomer();
        
        $verificationId = $user->resetEmailVerification();

        \App\Modules\Authentication\Events\WelcomeEvent::dispatch($user, $user->getVerificationCode());

        return $verificationId;
    }

    public function verifyEmail(EmailVerificationDTO $dto): User
    {
        $verification = $this->verificationRepository->findOneBy(['unique_id' => $dto->verificationId, 'type' => $dto->type]);

        if(!$verification) {
            $this->throwNotFoundException('Verification not found');
        }

        $user = $this->repository->findOneBy(['id' => $verification->user_id]);

        if($user->isVerified()) {
            $this->throwAccessDeniedException('User already verified');
        }

        $userVerification = $user->verifyEmail($dto->verificationCode);     

        if(!$userVerification) {
            $this->throwUnauthorizedException('Invalid verification code', 422);
        } else if($userVerification === 'expired') {
            $this->throwUnauthorizedException('Verification code has expired. Please send the verification email again.', 422);
        } else if($userVerification === 'failed_attempts') {
            $this->throwUnauthorizedException('Too many failed attempts. Please send the verification email again', 422);
        }
        
        return $user;
    }

    public function resendEmailVerification(EmailVerificationUpdateDTO $dto): string
    {
        $user = $this->repository->findOneBy(['email' => $dto->email]);

        if(!$user) {
            throw new NotFoundHttpException('User not found against this email address');
        }

        if($user->isVerified()) {
            throw new AccessDeniedException('User already verified');
        }

        $verificationId = $user->resetEmailVerification();

        \App\Modules\Authentication\Events\OTPVerificationEvent::dispatch($user, $user->getVerificationCode(), VerificationEnum::EMAIL);

        return $verificationId;
    }

    public function forgotPassword(ForgotPasswordDTO $dto): string
    {
        $user = $this->repository->findOneBy(['email' => $dto->email]);

        if(!$user) {
            $this->throwNotFoundException('User not found against this email address');
        }

        if(!$user->isVerified()) {
            $this->throwAccessDeniedException('Email address not verified');
        }

        $verificationId = $user->resetPasswordVerification();

        \App\Modules\Authentication\Events\OTPVerificationEvent::dispatch($user, $user->getPasswordResetCode(), VerificationEnum::PASSWORD);

        return $verificationId;
    }

    public function verifyForgotPassword(PasswordVerificationDTO $dto): User
    {
        $verification = $this->verificationRepository->findOneBy(['unique_id' => $dto->verificationId, 'type' => $dto->type]);

        if(!$verification) {
            $this->throwNotFoundException('Verification not found');
        }

        $user = $this->repository->findOneBy(['id' => $verification->user_id]);

        $userVerification = $user->verifyPassword($dto->verificationCode);

        if(!$userVerification) {
            $this->throwUnauthorizedException('Invalid verification code', 422);
        } else if($userVerification === 'expired') {
            $this->throwUnauthorizedException('Verification code has expired. Please send the verification email again.', 422);
        } else if($userVerification === 'failed_attempts') {
            $this->throwUnauthorizedException('Too many failed attempts. Please send the verification email again', 422);
        }

        return $user;
    }

    public function resetPassword(ResetPasswordDTO $dto): void
    {
        $user = $this->repository->findOneBy(['email' => $dto->email]);

        if(!$user) {
            $this->throwNotFoundException('User not found against this email address');
        }

        if(!$user->isVerified()) {
            $this->throwAccessDeniedException('Email address not verified');
        }

        if(!Hash::check($dto->currentPassword, $user->password)) {
            $this->throwUnauthorizedException('Invalid current password');
        }

        if (Hash::check($dto->newPassword, $user->password)) {
            $this->throwInvalidArgumentException('You cannot use the same password as the current password');
        }

        $user->password = Hash::make($dto->newPassword);
        $user->save();    
    }
}