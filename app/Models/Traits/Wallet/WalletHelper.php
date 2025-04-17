<?php

namespace App\Models\Traits\Wallet;

trait WalletHelper
{
    public function addBalance(float $amount): void
    {
        $this->balance += $amount;
        $this->save();
    }

    public function subtractBalance(float $amount): void
    {
        $this->balance -= $amount;
        $this->save();
    }


    public function addTransaction(float $amount, string $type): void
    {
        $this->transactions()->create([
            'amount' => $amount,
            'transaction_type' => $type,
        ]);
    }
}
