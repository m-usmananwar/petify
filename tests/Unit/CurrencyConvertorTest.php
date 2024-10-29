<?php

namespace Tests\Unit;

use App\Helpers\CurrencyConvertor;
use PHPUnit\Framework\TestCase;

class CurrencyConvertorTest extends TestCase
{
    public function test_usd_are_converted_to_cents()
    {
        $result = CurrencyConvertor::usdToCents(1);

        $this->assertEquals(100, $result);
    }

    public function test_cents_are_converted_to_usd()
    {
        $result = CurrencyConvertor::centsToUsd(100);

        $this->assertEquals(1, $result);
    }
}
