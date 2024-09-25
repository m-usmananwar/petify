<?php

namespace App\Http\Controllers\Api\Authentication\Requests;

use App\Http\Requests\BaseRequest;

class RegistrationRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'first_name' => ['bail', 'required', 'string', 'max:255'],
            'last_name' => ['bail', 'required', 'string', 'max:255'],
            'username' => ['bail', 'required', 'unique:users,username', 'max:255'],
            'password' => ['bail', 'required', 'string', 'min:8', 'max:255'],
            'contact_no' => ['bail', 'required', 'string', 'max:255'],
            'image' => ['bail', 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:50000'],
        ];
    }
}
