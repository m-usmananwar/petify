<?php

namespace App\Models;

use App\Models\Traits\Bid\BidRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory,
        BidRelation;

    protected $fillable = [
        'biddable_id',
        'biddable_type',
        'bidder',
        'amount',
    ];

    public static array $biddables = ['Auction'];
}
