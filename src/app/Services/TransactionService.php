<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Exceptions\TransactionNotFoundException;

class TransactionService {

    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository
    ) {}

    public function getUserTransactions(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->transactionRepository->getAllPaginatedForUser($userId, $filters, $perPage);
    }

    public function getTransactionDetail(int $transactionId, int $userId): Transaction
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        if(!$transaction){
           throw new TransactionNotFoundException;
        }

        if ($transaction->sender_id !== $userId && $transaction->receiver_id !== $userId) {
            throw new TransactionNotFoundException; 
        }

        return $transaction;
    }
}