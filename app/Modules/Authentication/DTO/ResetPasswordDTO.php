<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;

class ResetPasswordDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $currentPassword,
        public readonly string $newPassword,
        public readonly string $confirmNewPassword,
    )
    {
        
    }
}