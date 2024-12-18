<?php

namespace App\Models\Traits\Auction;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AuctionRelation
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }
}
