<?php

namespace App\Modules\Auction\DTO;

use App\DTO\BaseDTO;
use App\Enum\AuctionStatusEnum;

class CreateAuctionDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $color,
        public readonly int $age,
        public readonly string $type,
        public readonly string $tagLine,
        public readonly string $description,
        public readonly float $initialPrice,
        public readonly string $startTime,
        public readonly string $expiryTime,
        public readonly array $medias,
        public ?string $owner = null,
        public ?string $status = null,
    ) {
        $this->owner = $this->owner ?? currentUserId();
        $this->status = $this->status ?? AuctionStatusEnum::PENDING->value;
    }
}
