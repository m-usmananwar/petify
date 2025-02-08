<?php

namespace App\Modules\Auction\DTO;

use App\DTO\BaseDTO;
use App\Enum\AuctionStatusEnum;

class UpdateAuctionDTO extends BaseDTO
{
    public function __construct(
        public readonly int|float $id,
        public readonly string $name,
        public readonly string $color,
        public readonly int $age,
        public readonly string $type,
        public readonly string $tagLine,
        public readonly string $description,
        public readonly float $initialPrice,
        public readonly string $startTime,
        public readonly string $expiryTime,
        public readonly array $medias = [],
        public ?string $owner_id = null,
        public ?string $status = null,
    ) {
        $this->owner_id = $this->owner_id ?? currentUserId();
        $this->status = $this->status ?? AuctionStatusEnum::PENDING->value;
    }
}
