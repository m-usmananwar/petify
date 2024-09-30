<?php

namespace App\Http\Controllers\Api\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Authentication\DTO\EmailVerificationUpdateDTO;

class EmailVerificationUpdateRequest extends BaseRequest
{
    public function DTO():string
    {
        return EmailVerificationUpdateDTO::class;
    }

    public function rules():array
    {
        return [
            'email' => ['bail','required', 'exists:users,email'],
        ];
    }
}
