<?php

namespace App\Http\Controllers\Api\V1\Auction;

use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Auction\Services\AuctionService;
use App\Http\Controllers\Api\V1\Auction\Requests\CreateAuctionRequest;
use App\Http\Controllers\Api\V1\Auction\Requests\UpdateAuctionRequest;

class AuctionController extends Controller
{
    public function __construct(private readonly AuctionService $auctionService) {}

    public function index()
    {
        //
    }

    public function store(CreateAuctionRequest $request): ApiResponse
    {
        try {
            $this->auctionService->store($request->toDto());

            return ApiResponse::success(['message' => 'Auction created successfully.']);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function show($id): ApiResponse
    {
        try {
            $auction = $this->auctionService->get($id);

            return ApiResponse::success($auction);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function update(UpdateAuctionRequest $request, $id): ApiResponse
    {
        try {
            $this->auctionService->update($request->toDto(), $id);

            return ApiResponse::success(['message' => 'Auction udpated successfully']);
        } catch(\Exception $exception) {
            throw $exception;
        }
    }

    public function destroy($id)
    {
        //
    }
}
