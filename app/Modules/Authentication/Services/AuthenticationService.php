<?php

namespace App\Modules\Authentication\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;


class AuthenticationService
{
    public function __construct(private readonly IAuthenticationRepository $repository)
    {
        
    }

    public function signIn(array $data): User
    {
        $user = $this->repository->findOneBy(['email' => $data['email']]);

        if(!$user) {
            throw new NotFoundHttpException('User not found against this email address');
        }

        if(!$user->email_verified_at) {
            throw new AccessDeniedHttpException('Email address not verified');
        }

        if(!Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        return $user;
    }

    public function register(array $data): User
    {
        $user = $this->repository->save($data);
        
        return $user;
    }
}