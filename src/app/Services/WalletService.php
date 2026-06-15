<?php

namespace App\Services;

use App\Models\Wallet;
use App\DTO\DepositDTO;
use App\Models\Transaction;
use App\Repositories\WalletRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use App\Exceptions\WalletNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class WalletService
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        
    ){}

    public function getWallet(int $userId): Wallet
    {

        $wallet = $this->walletRepository->findByUserId($userId);

        if (! $wallet) {
            throw new WalletNotFoundException;
        }

        return $wallet;
    }

    public function deposit(DepositDTO $dto): Transaction
    {
        if($dto->amount <= 0) {
            throw new \InvalidArgumentException('O valor do depósito deve ser maior que zero.');
        }

        return DB::transaction(function () use ($dto) {
            $wallet = $this->walletRepository->findByUserIdForUpdate($dto->userId);

            if (! $wallet) {
                throw new WalletNotFoundException;
            }

            $newBalance = (float) $wallet->balance + $dto->amount;

            $this->walletRepository->updateBalance($wallet, $newBalance);

            return $this->transactionRepository->create([
                'uuid' => (string) Str::uuid(),
                'type' => 'deposit',
                'amount' => $dto->amount,
                'sender_id' => null,
                'receiver_id' => $dto->userId,
                'status' => 'completed',
            ]);
        });
    }
}
