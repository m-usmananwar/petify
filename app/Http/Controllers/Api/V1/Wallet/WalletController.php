<?php

namespace App\Http\Controllers\Api\V1\Wallet;

use Pusher\Pusher;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\WalletTransaction\Services\WalletTransactionService;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function __construct(private readonly WalletTransactionService $walletTransactionService) {}


    public function index(Request $request): JsonResponse
    {
        $filters = $request->input();
        $walletTransactions = $this->walletTransactionService->index($filters);
        return response()->json($walletTransactions);
    }
}
