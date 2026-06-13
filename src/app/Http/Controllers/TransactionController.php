<?php

namespace App\Http\Controllers;



use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller {

    public function __construct(
        private readonly TransactionService $transactionService
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
    
}