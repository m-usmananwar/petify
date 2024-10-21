<?php

namespace App\Modules\Subscription\Services;

use App\Enum\PaymentGatewayEnum;
use App\Modules\Subscription\DTO\BuySubscriptionDTO;
use App\Modules\PaymentModule\Factory\PaymentGatewayFactory;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionRepository;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionPlanRepository;

class SubscriptionService
{

    public function __construct(private readonly ISubscriptionRepository $repository, private readonly ISubscriptionPlanRepository $planRepository) {}

    public function buySubscription(BuySubscriptionDTO $dto)
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        $subscription = $paymentHandler->buySubscription($dto->subscriptionPlanId, $dto->paymentMethodId);

        return $subscription;
    }

    public function cancelSubscription()
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        return $paymentHandler->cancelSubscription();
    }
}
