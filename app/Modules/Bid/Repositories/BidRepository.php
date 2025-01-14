<?php

namespace App\Modules\Bid\Repositories;

use App\Models\Bid;
use App\Repositories\BaseRepository;
use App\Modules\Bid\Repositories\Interfaces\IBidRepository;

class BidRepository extends BaseRepository implements IBidRepository
{
    public function __construct(Bid $model)
    {
        parent::__construct($model);
    }
}