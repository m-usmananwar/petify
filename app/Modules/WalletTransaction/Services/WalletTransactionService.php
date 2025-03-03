<?php

namespace App\Modules\WalletTransaction\Services;

use App\Modules\Wallet\Repositories\Interfaces\IWalletRepository;
use App\Modules\WalletTransaction\Repositories\Interfaces\IWalletTransactionRepository;
use App\Traits\GenericExceptions;
use Illuminate\Pagination\LengthAwarePaginator;

final class WalletTransactionService
{
    use GenericExceptions;

    public function __construct(
        private readonly IWalletTransactionRepository $walletTransactionRepository,
        private readonly IWalletRepository $walletRepository
    ) {}

    public function index(array $filters): LengthAwarePaginator
    {
        $userWallet = $this->walletRepository->findOneBy(['user_id' => currentUserId()]);
        if (!$userWallet) $this->throwNotFoundException('Wallet not found');

        $filters['wallet_id'] = $userWallet->id;
        return $this->walletTransactionRepository->getPaginatedWith($filters);
    }
}
