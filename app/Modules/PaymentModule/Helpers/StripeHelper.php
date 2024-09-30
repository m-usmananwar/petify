<?php

namespace App\Modules\PaymentModule\Helpers;

use Stripe\Price;
use Stripe\Balance;
use Stripe\Product;
use Stripe\StripeClient;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use App\Helpers\CurrencyConvertor;

class StripeHelper
{
    private static ?StripeClient $stripe = null;

    public static function getClient(): StripeClient
    {
        if(self::$stripe == null) {
            self::$stripe = new StripeClient(config('cashier.secret'));
        }

        return self::$stripe;
    }

    public static function createIntent(int $amount, array $description = null): PaymentIntent
    {
        $client = self::getClient();

        $data = [
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card']
        ];

        if($description) $data['description'] = $description;

        return $client->paymentIntents->create($data);
    }

    public static function checkout(int $amount, string $paymentMethodId): PaymentIntent
    {
        $client = self::getClient();

        $intent = self::createIntent($amount);

        return $client->paymentIntents->confirm(
            $intent->id,
            ['payment_method' => $paymentMethodId]
        );
    }

    public static function createStripeProduct($name): Product
    {
        $client = self::getClient();

        return $client->products->create([
            'name' => $name,
        ]);
    }

    public static function createStripeProductPrice(array $data): Price
    {
        $client = self::getClient();

        $stripeProduct = self::createStripeProduct($data['name']);

        return $client->prices->create([
            'unit_amount' => CurrencyConvertor::usdToCents($data['amount']),
            'currency' => 'usd',
            'recurring' => ['interval' => $data['interval'], 'interval_count' => 1],
            'nickname' => $data['name'],
            'product' => $stripeProduct->id,
        ]);
    }

    public static function retrieveSubscription(int $subscriptionId): Subscription
    {
        $client = self::getClient();

        return $client->subscriptions->retrieve($subscriptionId, []);
    }

    public static function updateSubscription(int $subscriptionId, array $options = []):Subscription
    {
        $client = self::getClient();

        return $client->subscriptions->update($subscriptionId, $options);
    }

    public static function retrieveStripeBalance(): Balance
    {
        $client = self::getClient();
        
        return $client->balance->retrieve();
    }
}