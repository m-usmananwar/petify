<?php

namespace App\Modules\Bid\Services;

use App\Models\Bid;
use App\Modules\Bid\DTO\PlaceBidDTO;
use App\Modules\Bid\Repositories\Interfaces\IBidRepository;

final class BidService
{
    public function __construct(private readonly IBidRepository $bidRepository)
    {
        
    }

    public function placeBid(PlaceBidDTO $dto): Bid
    {
        $data['biddable_type'] = $dto->biddleableType;
        $data['biddable_id'] = $dto->biddleableId;
        $data['amount'] = $dto->amount;
        $data['bidder'] = currentUserId();
        
        $bid = $this->bidRepository->save($data);

        return $bid;
    }
}