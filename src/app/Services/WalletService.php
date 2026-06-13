<?php

namespace App\Services;

use App\Models\Wallet;
use App\Repositories\WalletRepositoryInterface;
use App\Exceptions\WalletNotFoundException;

class WalletService
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository
        
    ){}

    public function getWallet(int $userId): Wallet
    {

        $wallet = $this->walletRepository->findByUserId($userId);

        if (! $wallet) {
            throw new WalletNotFoundException;
        }

        return $wallet;
    }
}
