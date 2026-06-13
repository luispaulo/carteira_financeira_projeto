<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\TransactionRepositoryInterface;

class TransactionService {

    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository
    ) {}

    public function getUserTransactions(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->transactionRepository->getAllPaginatedForUser($userId, $filters, $perPage);
    }
}