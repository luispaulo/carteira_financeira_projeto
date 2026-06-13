<?php

namespace App\Repositories;

use App\Models\Wallet;

class EloquentWalletRepository implements WalletRepositoryInterface
{

    public function createForUser(int $userId): Wallet
    {
        return Wallet::create([
            'user_id' => $userId,
            'balance' => 0.00,
        ]);
    }

    public function findByUserId(int $userId): ?Wallet
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function updateBalance(Wallet $wallet, float $amount): bool
    {
        $wallet->balance = $amount;

        return $wallet->save();
    }
}
