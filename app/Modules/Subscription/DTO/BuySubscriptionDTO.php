<?php

namespace App\Modules\Subscription\DTO;

use App\DTO\BaseDTO;

class BuySubscriptionDTO extends BaseDTO
{
    public function __construct(public readonly string $subscriptionPlanId, public readonly string $paymentMethodId) {}
}