<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;
use Illuminate\Http\UploadedFile;

class RegistrationDTO extends BaseDTO
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $userName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $contactNo,
        public readonly ?UploadedFile $image,
    )
    {
        
    }
}