<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use App\Modules\PaymentModule\Helpers\StripeHelper;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $stripeHelper = new StripeHelper;

        $plans = [
            [ 'name' => Subscription::MONTHLY_PLAN, 'amount' => 10, 'meta' => ['stripe_price_id' => $stripeHelper->createStripeProductPrice(['name' => Subscription::MONTHLY_PLAN, 'amount' => 10, 'interval' => Subscription::INTERVAL_MONTH])->id]],
            [ 'name' => Subscription::YEARLY_PLAN, 'amount' => 100, 'meta' => ['stripe_price_id' => $stripeHelper->createStripeProductPrice(['name' => Subscription::YEARLY_PLAN, 'amount' => 100, 'interval' => Subscription::INTERVAL_YEAR])->id]],
        ];

        foreach($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
