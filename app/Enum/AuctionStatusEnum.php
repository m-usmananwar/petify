<?php

namespace App\Enum;

enum AuctionStatusEnum: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case BLOCKED_BY_ADMIN = 'blocked-by-admin';
}