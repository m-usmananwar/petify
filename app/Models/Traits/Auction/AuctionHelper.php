<?php

namespace App\Models\Traits\Auction;

use DateTime;

trait AuctionHelper
{
    public function highestBid(): float
    {
        return $this->bids->max('amount') ?? 0;
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expiry_time);
    }
}