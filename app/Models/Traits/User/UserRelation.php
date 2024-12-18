<?php

namespace App\Models\Traits\User;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelation
{
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'owner', 'id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'bidder', 'id');
    }
}