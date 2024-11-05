<?php

namespace App\Modules\PaymentModule\Factory;

use App\Enum\PaymentGatewayEnum;
use Illuminate\Support\Facades\App;
use App\Modules\PaymentModule\Factory\PaymentGateways\StripePaymentGateway;

class PaymentGatewayFactory
{
    private static array  $paymentGatewayMap =  [
        PaymentGatewayEnum::STRIPE->value => StripePaymentGateway::class,
    ];


    public static function paymentHandler($gateway)
    {
        $handler = self::$paymentGatewayMap[$gateway];

        return App::make($handler);
    }
}