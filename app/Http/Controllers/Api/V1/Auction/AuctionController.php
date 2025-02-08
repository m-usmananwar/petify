<?php

namespace App\Http\Controllers\Api\V1\Auction;

use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Auction\Services\AuctionService;
use App\Http\Controllers\Api\V1\Auction\Requests\CreateAuctionRequest;
use App\Http\Controllers\Api\V1\Auction\Requests\DeleteAuctionRequest;
use App\Http\Controllers\Api\V1\Auction\Requests\UpdateAuctionRequest;
use App\Http\Resources\AuctionCollection;
use App\Http\Resources\AuctionResource;
use Illuminate\Http\JsonResponse;

class AuctionController extends Controller
{
    public function __construct(private readonly AuctionService $auctionService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->input();

            $auctions = $this->auctionService->index($filters);
            $response = [];

            if ($auctions) $response = new AuctionCollection($auctions);
            return response()->json($response);
        } catch (\Exception $exception) {
            throw $exception;
        }
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

            if ($auction) $auction = new AuctionResource($auction);

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
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function destroy(DeleteAuctionRequest $request, $id)
    {
        try {
            $this->auctionService->delete($id);

            return ApiResponse::success(['message' => 'Auction deleted successfully']);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
