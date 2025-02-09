<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\ICouldBiddable;
use App\Models\Interfaces\ICouldMediaable;
use App\Models\Traits\Auction\AuctionScope;
use App\Models\Traits\Auction\AuctionHelper;
use App\Models\Traits\Global\ShouldBiddable;
use App\Models\Traits\Global\ShouldMediaable;
use App\Models\Traits\Auction\AuctionRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model implements ICouldBiddable, ICouldMediaable
{
    use HasFactory,
        AuctionRelation,
        AuctionScope,
        AuctionHelper,
        ShouldBiddable,
        ShouldMediaable;

    protected $fillable = [
        'name',
        'color',
        'age',
        'type',
        'status',
        'owner_id',
        'tag_line',
        'description',
        'initial_price',
        'start_time',
        'expiry_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'expiry_time' => 'datetime'
    ];
}
