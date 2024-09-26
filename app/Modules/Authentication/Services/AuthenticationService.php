<?php

namespace App\Modules\Authentication\Services;

use App\Helpers\FileHandler;
use App\Models\User;
use App\Modules\Authentication\DTO\RegistrationDTO;
use App\Modules\Authentication\DTO\SignInDTO;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;
use Faker\Core\File;

class AuthenticationService
{
    public function __construct(private readonly IAuthenticationRepository $repository)
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

    public function register(RegistrationDTO $dto): User
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
        
        return $user;
    }
}