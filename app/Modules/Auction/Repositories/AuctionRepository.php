<?php

namespace App\Modules\Auction\Repositories;

use App\Models\Auction;
use App\Repositories\BaseRepository;
use App\Modules\Auction\Repositories\Interfaces\IAuctionRepository;

final class AuctionRepository extends BaseRepository implements IAuctionRepository 
{
    public function __construct(Auction $model)
    {
        parent::__construct($model);
    }
}