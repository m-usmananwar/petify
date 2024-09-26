<?php

namespace App\Modules\Authentication\DTO;

use App\DTO\BaseDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationDTO extends BaseDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $username,
        public readonly string $password,
        public readonly string $contact_no,
        public readonly ?UploadedFile $image,
    )
    {
        
    }
}