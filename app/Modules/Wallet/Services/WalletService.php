<?php

namespace App\Modules\WalletTransaction\Services;

use App\Modules\Wallet\Repositories\Interfaces\IWalletRepository;

final class WalletService
{
    public function __construct(private readonly IWalletRepository $walletRepository) {}
}
