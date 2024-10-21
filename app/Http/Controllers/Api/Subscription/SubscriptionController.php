<?php

namespace App\Http\Controllers\Api\Subscription;

use Exception;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Subscription\Services\SubscriptionService;
use App\Http\Controllers\Api\Subscription\Requests\BuySubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionService $service) {}

    public function buySubscriptionAction(BuySubscriptionRequest $request): ApiResponse
    {
        try {
            $this->service->buySubscription($request->toDto());

            return ApiResponse::success(['message' => 'Subscription purchased successfully.']);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function cancelSubscriptionAction(): ApiResponse
    {
        try {
            $this->service->cancelSubscription();

            return ApiResponse::success(['message' => 'Subscription cancelled successfully.']);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
