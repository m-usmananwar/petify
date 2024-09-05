<?php

namespace App\Modules\Authentication\Services;

use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;

class AuthenticationService
{
    public function __construct(private readonly IAuthenticationRepository $repository)
    {
        
    }
}