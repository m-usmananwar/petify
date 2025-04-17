<?php

namespace App\Modules\WalletTransaction\Services;

use App\Enum\PaymentGatewayEnum;
use App\Enum\TransactionTypeEnum;
use App\Modules\Wallet\DTO\BuyCoinDTO;
use App\Modules\PaymentModule\Factory\PaymentGatewayFactory;
use App\Modules\Wallet\Repositories\Interfaces\IWalletRepository;

final class WalletService
{
    public function __construct(private readonly IWalletRepository $walletRepository) {}

    public function buyCoins(BuyCoinDTO $dto): void
    {
        $paymentHandler = PaymentGatewayFactory::paymentHandler(PaymentGatewayEnum::STRIPE->value);

        $coins = $dto->coins;
        $amount = $coins / 200;

        $paymentHandler->buyCoins($amount, $dto->paymentMethodId);

        $userWallet = $this->walletRepository->findOneBy(['user_id' => currentUserId()]);
        $userWallet->addBalance($coins);

        $userWallet->addTransaction($coins, TransactionTypeEnum::CREDIT->value);
    }
}
