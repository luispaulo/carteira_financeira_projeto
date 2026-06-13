<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function __construct(
        private readonly WalletService $walletService
    ) {}

    public function show(Request $request): JsonResponse
    {
        $wallet = $this->walletService->getWallet($request->user()->id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'wallet' => $wallet ,
            ],
        ]);
    }
}