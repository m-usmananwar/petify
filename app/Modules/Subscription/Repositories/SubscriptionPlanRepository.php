<?php

namespace App\Modules\Subscription\Repositories;

use App\Models\SubscriptionPlan;
use App\Modules\Subscription\Repositories\Interfaces\ISubscriptionPlanRepository;
use App\Repositories\BaseRepository;

class SubscriptionPlanRepository extends BaseRepository implements ISubscriptionPlanRepository
{
    public function __construct(SubscriptionPlan $model)
    {
        parent::__construct($model);
    }
}