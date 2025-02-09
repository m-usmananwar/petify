<?php

namespace App\Modules\Bid\Repositories;

use App\Models\Bid;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Bid\Repositories\Interfaces\IBidRepository;

class BidRepository extends BaseRepository implements IBidRepository
{
    public function __construct(Bid $model)
    {
        parent::__construct($model);
    }

    public function getAllBids(string $biddableType, int|string $biddableId): Collection
    {
        $bids = $this->model::select('id', 'amount', 'bidder_id')
            ->with(['bidder' => function ($q) {
                $q->select('id', 'first_name', 'last_name', 'image');
            }])
            ->where([
                'biddable_type' => $biddableType,
                'biddable_id'   => $biddableId,
            ])
            ->orderBy('amount', 'DESC')
            ->get();


        return $bids;
    }

    public function getLatestBid(string $biddableType, int|string $biddableId): Bid
    {
        $bid = $this->model::select('id', 'amount', 'bidder_id')
            ->with(['bidder' => function ($q) {
                $q->select('id', 'first_name', 'last_name', 'image');
            }])
            ->where([
                'biddable_type' => $biddableType,
                'biddable_id'   => $biddableId,
            ])
            ->orderBy('amount', 'DESC')
            ->first();


        return $bid;
    }
}
