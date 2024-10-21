<?php

namespace App\Modules\PaymentModule\Factory\PaymentGateways;

use Laravel\Cashier\Subscription;

interface IPaymentGateway
{
    public function buySubscription(int $subscriptionPlanId, string $paymentMethodId): Subscription;
    public function changeSubscriptionPlan(string $stripePriceId, string $paymentMethodId): Subscription;
    public function changeSubscriptionPlanAndPaymentMethod(string $stripePriceId, string $paymentMethodId): Subscription;
    public function cancelSubscription(): Subscription;
    public function resumeSubscription(): Subscription;
    public function subscribeTrialWithoutCard(string $userId): Subscription;
}
