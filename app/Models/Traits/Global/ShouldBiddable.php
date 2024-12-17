<?php

namespace App\Models\Traits\Global;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldBiddable
{
    public function bids(): MorphMany
    {
        return $this->morphMany(Bid::class, 'biddable');
    }
}