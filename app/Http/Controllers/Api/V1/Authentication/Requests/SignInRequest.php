<?php

namespace App\Http\Controllers\Api\V1\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Authentication\DTO\SignInDTO;

class SignInRequest extends BaseRequest
{
    public function DTO():string
    {
        return SignInDTO::class;
    }

    public function rules():array
    {
        return [
            'email' => ['required', 'exists:users,email'],
            'password' => ['required'],
        ];
    }
}
