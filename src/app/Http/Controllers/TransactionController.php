<?php

namespace App\Http\Controllers;



use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TransactionResource;
use App\Services\ReversalService;

class TransactionController extends Controller {

    public function __construct(
        private readonly TransactionService $transactionService,
        private readonly ReversalService $reversalService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['type', 'status', 'date_from', 'date_to', 'order_by', 'order_dir']);
        $perPage = (int) $request->input('per_page', 15);

        $paginator = $this->transactionService->getUserTransactions(
            $request->user()->id,
            $filters,
            $perPage
        );

        return response()->json([
            'success' => true,
            'message' => 'Transações listadas com sucesso.',
            'data' => TransactionResource::collection($paginator->items()),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(Request $request, int  $id): JsonResponse {
        $transaction = $this->transactionService->getTransactionDetail($id, $request->user()->id);

        return response()->json([
            'success' => true,
            'data' => new TransactionResource($transaction),
        ]);
    }

    public function reverse(Request $request, int $id): JsonResponse {
        $transaction = $this->transactionService->getTransactionDetail($id, $request->user()->id);

        $reversal = $this->reversalService->reverse($transaction->id);

        return response()->json([
            'success' => true,
            'data' => new TransactionResource($reversal),
        ]);
    }    
}