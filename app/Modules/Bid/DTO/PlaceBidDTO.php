<?php

namespace App\Modules\Bid\DTO;

use App\DTO\BaseDTO;

class PlaceBidDTO extends BaseDTO
{
    public function __construct(
        public string $biddableType,
        public int $biddableId,
        public float $amount
    ) {}
}
