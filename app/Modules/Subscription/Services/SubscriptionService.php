<?php

namespace App\Modules\Subscription\Services;

use App\Enum\PaymentGatewayEnum;
use App\Modules\Subscription\DTO\SubscriptionDTO;
use App\Modules\PaymentModule\Factory\PaymentGatewayFactory;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionRepository;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionPlanRepository;

final class SubscriptionService
{

    public function __construct(private readonly ISubscriptionRepository $repository, private readonly ISubscriptionPlanRepository $planRepository) {}

    public function buySubscription(SubscriptionDTO $dto)
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

    public function resumeSubscription()
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        return $paymentHandler->resumeSubscription();
    }

    public function changeSubscriptionPlan(SubscriptionDTO $dto)
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        return $paymentHandler->changeSubscriptionPlan($dto->subscriptionPlanId, $dto->paymentMethodId);
    }

    public function changeSubscriptionPlanAndPaymentMethod(SubscriptionDTO $dto)
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        return $paymentHandler->changeSubscriptionPlanAndPaymentMethod($dto->subscriptionPlanId, $dto->paymentMethodId);
    }
}
