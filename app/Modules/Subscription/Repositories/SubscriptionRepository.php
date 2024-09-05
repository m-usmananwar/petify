<?php

namespace App\Modules\Subscription\Repositories;

use App\Models\Subscription;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionRepository;
use App\Repositories\BaseRepository;

class SubscriptionRepository extends BaseRepository implements ISubscriptionRepository
{
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }
}