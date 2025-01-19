<?php

namespace App\Models\Traits\Auction;

use App\Models\Bid;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait AuctionRelation
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }
}
