<?php

namespace App\Modules\Bid\Services;

use App\Models\Bid;
use App\Modules\Bid\DTO\PlaceBidDTO;
use App\Http\Broadcasting\BidChannel;
use App\Modules\Bid\DTO\FetchBidsDTO;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Bid\Repositories\Interfaces\IBidRepository;

final class BidService
{
    public function __construct(private readonly IBidRepository $bidRepository) {}

    public function placeBid(PlaceBidDTO $dto): Bid
    {
        $data['biddable_type'] = $dto->biddableType;
        $data['biddable_id'] = $dto->biddableId;
        $data['amount'] = $dto->amount;
        $data['bidder_id'] = currentUserId();

        $bid = $this->bidRepository->save($data);

        $this->dispatchBidChannelEvent($dto->biddableType, $dto->biddableId);

        return $bid;
    }

    private function dispatchBidChannelEvent($biddableType, $biddableId): void
    {
        $bid = $this->bidRepository->getLatestBid($biddableType, $biddableId);

        event(new BidChannel($bid));
    }

    public function fetchAllBids(FetchBidsDTO $dto): Collection
    {
        return $this->bidRepository->getAllBids($dto->biddableType, $dto->biddableId);
    }
}
