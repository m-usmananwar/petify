<?php

namespace App\Http\Controllers\Api\V1\Wallet\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Wallet\DTO\BuyCoinDTO;

class BuyCoinRequest extends BaseRequest
{
    public function DTO(): string
    {
        return BuyCoinDTO::class;
    }

    public function rules(): array
    {
        return [
            'paymentMethodId' => ['bail', 'required', 'string'],
            'coins' => ['bail', 'required', 'numeric', 'min:200'],
        ];
    }
}
