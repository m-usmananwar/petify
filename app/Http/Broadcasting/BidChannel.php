<?php

namespace App\Http\Broadcasting;

use App\Models\Bid;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BidChannel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Bid $bid) {}

    public function broadcastOn()
    {
        return new PrivateChannel("bid.{$this->bid->biddable_type}.{$this->bid->biddable_id}");
    }

    public function broadcastAs()
    {
        return 'BidChannel';
    }
}
