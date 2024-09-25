<?php

namespace App\Http\Controllers\Api\Authentication\Requests;

use App\Http\Requests\BaseRequest;

class SignInRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'exists:users,email'],
            'password' => ['required'],
        ];
    }
}
