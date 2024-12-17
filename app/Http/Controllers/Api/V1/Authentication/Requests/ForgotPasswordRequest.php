<?php

namespace App\Http\Controllers\Api\V1\Authentication\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\App;
use App\Modules\Authentication\DTO\ForgotPasswordDTO;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;

class ForgotPasswordRequest extends BaseRequest
{
    public function DTO(): string
    {
        return ForgotPasswordDTO::class;
    }

    public function rules()
    {
        return [
            'email' => $this->validateEmail()
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
