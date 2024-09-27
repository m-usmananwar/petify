<?php

namespace App\Http\Controllers\Api\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Authentication\DTO\EmailVerificationDTO;

class EmailVerificationRequest extends BaseRequest
{
    public function DTO():string
    {
        return EmailVerificationDTO::class;
    }

    public function rules():array
    {
        return [
            'verificationId' => ['bail','required', 'exists:verifications,unique_id'],
            'verificationCode' => ['bail', 'required', 'numeric'],
        ];
    }
}
