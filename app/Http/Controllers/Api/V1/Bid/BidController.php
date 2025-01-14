<?php

namespace App\Http\Controllers\Api\V1\Bid;

use App\Http\Controllers\Api\V1\Bid\Requests\PlaceBidRequest;
use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Modules\Bid\Services\BidService;
use Exception;

class BidController extends Controller
{
    public function __construct(private readonly BidService $bidService) {}

    public function placeBidAction(PlaceBidRequest $request)
    {
        try {
            $this->bidService->placeBid($request->toDto());

            return ApiResponse::success(['message' => 'Bid placed successfully.']);
        } catch(Exception $exception) {
            throw $exception;
        }
    }

}
