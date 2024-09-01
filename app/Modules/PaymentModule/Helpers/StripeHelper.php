<?php

namespace App\Modules\PaymentModule\Helpers;

use Stripe\Balance;
use Stripe\PaymentIntent;
use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;
use Stripe\Subscription;

class StripeHelper
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient('cashier.secret');
    }

    public function createIntent(int $amount, array $description = null): PaymentIntent
    {
        $data = [
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card']
        ];

        if($description) $data['description'] = $description;

        return $this->stripe->paymentIntents->create($data);
    }

    public function checkout(int $amount, string $paymentMethodId): PaymentIntent
    {
        $intent = $this->createIntent($amount);

        return $this->stripe->paymentIntents->confirm(
            $intent->id,
            ['payment_method' => $paymentMethodId]
        );
    }

    public function createStripeProduct($name): Product
    {
        return $this->stripe->products->create([
            'name' => $name,
        ]);
    }

    public function createStripeProductPrice(array $data): Price
    {
        $stripeProduct = $this->createStripeProduct($data['name']);

        return $this->stripe->prices->create([
            'unit_amount' => $data['amount'],
            'recurring' => ['interval' => $data['intervale'], 'interval_count' => 1],
            'nickname' => $data['name'],
            'product' => $stripeProduct->id,
        ]);
    }

    public function retrieveSubscription(int $subscriptionId): Subscription
    {
        return $this->stripe->subscriptions->retrieve($subscriptionId, []);
    }

    public function updateSubscription(int $subscriptionId, array $options = []):Subscription
    {
        return $this->stripe->subscriptions->update($subscriptionId, $options);
    }

    public function retrieveStripeBalance(): Balance
    {
        return $this->stripe->balance->retrieve();
    }
}