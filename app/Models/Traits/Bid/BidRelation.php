<?php

namespace App\Models\Traits\Bid;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BidRelation
{
    public function biddable(): MorphTo
    {
        return $this->morphTo();
    }

    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id', 'id');
    }
}
