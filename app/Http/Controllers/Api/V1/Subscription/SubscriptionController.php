<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use Exception;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Subscription\Services\SubscriptionService;
use App\Http\Controllers\Api\V1\Subscription\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionService $service) {}

    public function buySubscriptionAction(SubscriptionRequest $request): ApiResponse
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

    public function resumeSubscriptionAction(): ApiResponse
    {
        try {
            $this->service->resumeSubscription();

            return ApiResponse::success(['message' => 'Subscription resumed successfully.']);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function changeSubscriptionPlanAction(SubscriptionRequest $request): ApiResponse
    {
        try {
            $this->service->changeSubscriptionPlan($request->toDto());

            return ApiResponse::success(['message' => 'Subscription plan changed successfully.']);
        } catch (Exception $exception) {
            throw $exception;
        }   
    }

    public function changeSubscriptionPlanAndPaymentMethodAction(SubscriptionRequest $request): ApiResponse
    {
        try {
            $this->service->changeSubscriptionPlanAndPaymentMethod($request->toDto());

            return ApiResponse::success(['message' => 'Subscription plan and payment method changed successfully.']);
        } catch (Exception $exception) {
            throw $exception;
        }   
    }
}
