<?php

namespace App\Modules\PaymentModule\Factory\PaymentGateways;

use Stripe\Subscription;

interface IPaymentGateway
{
    public function buySubscription(string $stripePriceId, string $paymentMethodId): Subscription;
    public function changeSubscriptionPlan(string $stripePriceId, string $paymentMethodId): Subscription;
    public function changeSubscriptionPlanAndPaymentMethod(string $stripePriceId, string $paymentMethodId): Subscription;
    public function cancelSubscription(): Subscription;
    public function resumeSubscription(): Subscription;
    public function subscribeTrailWithoutCard(string $userId): Subscription;
}