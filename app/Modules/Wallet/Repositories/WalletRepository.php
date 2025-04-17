<?php

namespace App\Modules\Wallet\Repositories;

use App\Models\Wallet;
use App\Modules\Wallet\Repositories\Interfaces\IWalletRepository;
use App\Repositories\BaseRepository;

final class WalletRepository extends BaseRepository implements IWalletRepository
{
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }
}
