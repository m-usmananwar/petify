<?php
namespace App\Http\Controllers\Api\Subscription\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Subscription\DTO\BuySubscriptionDTO;


class BuySubscriptionRequest extends BaseRequest
{
    public function DTO(): string
    {
        return BuySubscriptionDTO::class;
    }
    
    public function rules()
    {
        return [
            'subscriptionPlanId' => ['bail','required', 'exists:subscription_plans,id'],
            'paymentMethodId' => ['bail','required', 'string'],
        ];
    }
}