<?php

namespace App\Modules\Bid\Repositories\Interfaces;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\IBaseRepository;

interface IBidRepository extends IBaseRepository
{
    public function getAllBids(string $biddableType, int|string $biddableId): Collection;

    public function getLatestBid(string $biddableType, int|string $biddableId): Bid;
}
