<?php

namespace App\Http\Controllers\Api\V1\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\App;
use App\Modules\Authentication\DTO\ResetPasswordDTO;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;

class ResetPasswordRequest extends BaseRequest
{
    public function DTO(): string
    {
        return ResetPasswordDTO::class;
    }

    public function rules()
    {
        return [
            'email' => $this->validateEmail(), 
            'currentPassword' => ['bail', 'required', 'string', 'min:8', 'max:255'],
            'newPassword' => ['bail', 'required', 'string', 'min:8', 'max:255'],
            'confirmNewPassword' => ['bail', 'required', 'string', 'min:8', 'max:255', 'same:newPassword'],
        ];
    }

    private function validateEmail()
    {
        return [
            'bail',
            'required',
            'exists:users,email',
            function($attribute, $value, $fail) {
                $user = App::make(IAuthenticationRepository::class)->findOneBy(['email' => $value]);
                if(empty($user)) {
                    $fail('User not found against this email');
                    return;
                }
                if(!$user->isVerified()) {
                    $fail('Email address is not verified');
                    return;
                }
            }
        ];
    }
}
