<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\ICouldBiddable;
use App\Models\Interfaces\ICouldMediaable;
use App\Models\Traits\Global\ShouldBiddable;
use App\Models\Traits\Auction\AuctionRelation;
use App\Models\Traits\Global\ShouldMediaable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model implements ICouldBiddable, ICouldMediaable
{
    use HasFactory,
        AuctionRelation,
        ShouldBiddable,
        ShouldMediaable;

    protected $fillable = [
        'name',
        'color',
        'age',
        'type',
        'status',
        'owner',
        'tag_line',
        'description',
        'initial_price',
        'start_time',
        'expire_time',
    ];
}
