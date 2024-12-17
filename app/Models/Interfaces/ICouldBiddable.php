<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ICouldBiddable
{
    public function bids(): MorphMany;
}