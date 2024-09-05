<?php

namespace App\Modules\PaymentModule\Factory;

use Illuminate\Support\Facades\App;
use App\Modules\PaymentModule\Factory\PaymentGateways\StripePaymentGateway;

class PaymentGatewayFactory
{
    const STRIPE_GATEWAY = 'stripe';

    private static array  $paymentGatewayMap =  [
        self::STRIPE_GATEWAY => StripePaymentGateway::class,
    ];


    public static function paymentHandler($gateway)
    {
        $handler = self::$paymentGatewayMap[$gateway];

        return App::make($handler);
    }
}