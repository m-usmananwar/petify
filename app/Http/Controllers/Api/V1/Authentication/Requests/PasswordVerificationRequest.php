<?php

namespace App\Http\Controllers\Api\V1\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Authentication\DTO\PasswordVerificationDTO;

class PasswordVerificationRequest extends BaseRequest
{
    public function DTO():string
    {
        return PasswordVerificationDTO::class;
    }

    public function rules():array
    {
        return [
            'verificationId' => ['bail','required', 'exists:verifications,unique_id'],
            'verificationCode' => ['bail', 'required', 'numeric'],
        ];
    }
}
