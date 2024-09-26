<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;

class SignInDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    )
    {
        
    }
}