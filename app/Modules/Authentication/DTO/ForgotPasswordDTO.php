<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;

class ForgotPasswordDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
    )
    {
        
    }
}