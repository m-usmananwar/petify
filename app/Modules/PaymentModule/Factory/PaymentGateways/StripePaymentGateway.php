<?php

namespace App\Modules\PaymentModule\Factory\PaymentGateways;

use App\Models\Subscription as ModelsSubscription;
use Laravel\Cashier\Subscription;
use App\Modules\PaymentModule\Factory\PaymentGateways\IPaymentGateway;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionPlanRepository;
use Exception;

class StripePaymentGateway implements IPaymentGateway
{
    public function __construct(
        private readonly ISubscriptionPlanRepository $subscriptionPlanRepository,
        private ?string $subscriptionName = null
    ) {
        $this->subscriptionName = config('cashier.subscriptionName');
    }

    public function buySubscription(int $subscriptionPlanId, string $paymentMethodId): Subscription
    {
        $user = currentUser();

        if ($user->subscribed($this->subscriptionName)) {
            throw new \Exception("Great news! You’re already a subscriber.");
        }

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethodId);
        $user->updateDefaultPaymentMethod($paymentMethodId);

        $plan = $this->subscriptionPlanRepository->findOneBy(['id' => $subscriptionPlanId]);

        $subscription = $user->newSubscription($this->subscriptionName, $plan->meta['stripe_price_id'])->add();

        $subscription->fill(['subscription_plan_id' => $plan->id])->save();

        return $subscription;
    }

    public function subscribeTrialWithoutCard(string $userId): Subscription
    {
        $user = currentUser();

        $user->createOrGetStripeCustomer();

        if ($user->subscribed($this->subscriptionName)) {
            throw new \Exception("Great news! You’re already a subscriber.");
        }

        $plan = $this->subscriptionPlanRepository->findOneBy(['name' => ModelsSubscription::MONTHLY_PLAN]);

        if ($user->subscription($this->subscriptionName) && $user->subscription($this->subscriptionName)->ended()) {
            throw new Exception('Unfortunately, you are not eligible for a trial since you were previously an active member.');
        }

        $subscription = $user->newSubscription($this->subscriptionName, $plan->meta['stripe_price_id'])
            ->trialDays(config('cashier.subscriptionTrialDays'))
            ->add();

        return $subscription;
    }

    public function changeSubscriptionPlan(string $subscriptionPlanId, string $paymentMethodId): Subscription
    {
        $user = currentUser();

        if (!$user->subscribed($this->subscriptionName)) {
            throw new \Exception("It looks like you’re not currently subscribed to any plan");
        }

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethodId);

        $plan = $this->subscriptionPlanRepository->findOneBy(['id' => $subscriptionPlanId]);

        if ($user->subscribedToPrice($plan->meta['stripe_price_id'], $this->subscriptionName)) {
            throw new \Exception("It looks like you’re already subscribed to this plan");
        }

        $user->subscription($this->subscriptionName)
            ->fill(['quantity' => 1])->save();

        $subscription = $user->subscription($this->subscriptionName)->swap($plan->meta['stripe_price_id']);

        $subscription->fill('subscription_plan_id', $plan->id)->save();

        return $subscription;
    }

    public function changeSubscriptionPlanAndPaymentMethod(string $subscriptionPlanId, string $paymentMethodId): Subscription
    {
        $user = currentUser();

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethodId);
        $user->updateDefaultPaymentMethod($paymentMethodId);
        
        if (!$user->subscribed($this->subscriptionName)) {
            throw new \Exception("It looks like you’re not currently subscribed to any plan");
        }

        $plan = $this->subscriptionPlanRepository->findOneBy(['id' => $subscriptionPlanId]);

        if ($user->subscribedToPrice($plan->meta['stripe_price_id'], $this->subscriptionName)) {
            throw new \Exception("It looks like you’re already subscribed to this plan");
        }

        $user->subscription($this->subscriptionName)
            ->fill(['quantity' => 1])->save();

        $subscription = $user->subscription($this->subscriptionName)->swap($plan->meta['stripe_price_id']);

        $subscription->fill('subscription_plan_id', $plan->id)->save();

        return $subscription;
    }

    public function cancelSubscription(): Subscription
    {
        $user = currentUser();

        if (!$user->subscribed($this->subscriptionName)) {
            throw new \Exception("It looks like you’re not currently subscribed to any plan");
        }

        if ($user->subscription($this->subscriptionName)->onGracePeriod()) {
            throw new \Exception("You've already unsubscribed from this subscription and are currently in a grace period.");
        }

        return $user->subscription($this->subscriptionName)->cancel();
    }

    public function resumeSubscription(): Subscription
    {
        $user = currentUser();

        if (!$user->subscribed($this->subscriptionName)) {
            throw new \Exception("It looks like you’re not currently subscribed to any plan");
        }

        if (!$user->subscription($this->subscriptionName)->onGracePeriod()) {
            throw new \Exception("You’re not currently in a grace period. Resuming your subscription is only possible during this period.");
        }

        return $user->subscription($this->subscriptionName)->resume();
    }
}
