<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use App\DTO\DepositDTO;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\DTO\TransferDTO;
use App\Http\Resources\TransactionResource;
use App\Services\TransferService;

class WalletController extends Controller
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly TransferService $transferService
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

    public function deposit(DepositRequest $request): JsonResponse
    {
        $dto = new DepositDTO(
            userId: $request->user()->id,
            amount: (float) $request->validated('amount')
        );

        $transaction = $this->walletService->deposit($dto);
        
        return response()->json([
            'success' => true,
            'data' => [
                'transaction' => new TransactionResource($transaction) ,
            ],
        ]);
    }

    public function transfer(TransferRequest $request): JsonResponse {

        $dto = new TransferDTO(
            senderId: $request->user()->id,
            receiverId: $request->validated('receiver_id'),
            amount: (float) $request->validated('amount')
        );

        $transaction = $this->transferService->transfer($dto);

        return response()->json([
            'success' => true,
            'data' => [
                'transaction' => new TransactionResource($transaction) ,
            ],
        ]);
    }

}