<?php

namespace App\Models\Traits\Auction;

use Illuminate\Contracts\Database\Query\Builder;

trait AuctionScope
{
    public function scopeEagerLoadRelations($query, array $relations = []): Builder
    {
        $query->with($relations);

        return $query;
    }
}
