<?php

namespace App\Http\Controllers\Api\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Authentication\DTO\RegistrationDTO;

class RegistrationRequest extends BaseRequest
{

    public function DTO():string
    {
        return RegistrationDTO::class;
    }

    public function rules():array
    {
        return [
            'firstName' => ['bail', 'required', 'string', 'max:255'],
            'lastName' => ['bail', 'required', 'string', 'max:255'],
            'username' => ['bail', 'required', 'unique:users,username', 'max:255'],
            'password' => ['bail', 'required', 'string', 'min:8', 'max:255'],
            'contactNo' => ['bail', 'required', 'string', 'max:255'],
            'image' => ['bail', 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:50000'],
        ];
    }
}
