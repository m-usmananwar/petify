<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;
use App\Enum\VerificationEnum;

class PasswordVerificationDTO extends BaseDTO
{
    public function __construct(
        public readonly string $verificationId,
        public readonly string $verificationCode,
        public readonly VerificationEnum $type = VerificationEnum::PASSWORD
    )
    {
        
    }
}