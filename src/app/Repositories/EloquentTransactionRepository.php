<?php 

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentTransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function findById(int $id): ?Transaction
    {
        return Transaction::find($id);
    }

    public function findByUuid(string $uuid): ?Transaction
    {
        return Transaction::where('uuid', $uuid)->first();
    }

    public function getAllPaginatedForUser(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Transaction::query()
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            });

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query->with([
            'sender:id,name,email',
            'receiver:id,name,email',
            'reverseTransaction:id,uuid',
        ])
            ->orderBy($filters['order_by'] ?? 'created_at', $filters['order_dir'] ?? 'desc')
            ->paginate($perPage);
    }

    public function updateStatus(Transaction $transaction, string $status): bool
    {
        $transaction->status = $status;

        return $transaction->save();
    }
}
