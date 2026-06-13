<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface
{
    public function create(array $data): Transaction;

    public function findById(int $id): ?Transaction;

    public function findByUuid(string $uuid): ?Transaction;

    public function getAllPaginatedForUser(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function updateStatus(Transaction $transaction, string $status): bool;
}
