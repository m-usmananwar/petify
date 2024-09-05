<?php

namespace App\Helpers;

class CurrencyConvertor
{
    public static function usdToCents(int $amount): int
    {
        return round($amount * 100);
    }

    public static function centsToUsd(int $amount): int
    {
        return round($amount / 100);
    }
}