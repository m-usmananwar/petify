<?php

namespace App\Models\Traits\Global;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasWallet
{
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function canPay($amount): bool
    {
        return $this->wallet->balance >= $amount;
    }
}
