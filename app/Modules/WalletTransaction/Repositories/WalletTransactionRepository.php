<?php

namespace App\Modules\WalletTransaction\Repositories;

use App\Models\WalletTransaction;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\WalletTransaction\Repositories\Interfaces\IWalletTransactionRepository;

final class WalletTransactionRepository extends BaseRepository implements IWalletTransactionRepository
{
    public function __construct(WalletTransaction $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedWith(array $data = [], array $with = []): LengthAwarePaginator
    {
        $paginationLength = $data['per_page'] ?? config('general.request.paginationLength');

        $query = $this->model::where(['wallet_id', $data['wallet_id']])->with($with);

        $this->model->timestamps ? $query->latest() : $query->latest($this->primaryKey);

        return $query->paginate($paginationLength);
    }
}
