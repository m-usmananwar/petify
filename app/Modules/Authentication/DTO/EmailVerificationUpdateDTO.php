<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;
use App\Enum\VerificationEnum;

class EmailVerificationUpdateDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email
    )
    {
        
    }
}