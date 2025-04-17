<?php

namespace App\Modules\Wallet\DTO;

use App\DTO\BaseDTO;

class BuyCoinDTO extends BaseDTO
{
    public function __construct(
        public string $paymentMethodId,
        public float $coins,
    ) {}
}
