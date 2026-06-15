<?php

namespace App\Repositories;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function createForUser(int $userId): Wallet;

    public function findByUserId(int $userId): ?Wallet;

    public function updateBalance(Wallet $wallet, float $amount): bool;

    public function findByUserIdForUpdate(int $userId): ?Wallet;
}