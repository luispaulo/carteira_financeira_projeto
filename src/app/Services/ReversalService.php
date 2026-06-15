<?php

namespace App\Services;

use App\Repositories\WalletRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Exceptions\TransactionNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exceptions\TransactionAlreadyReversedException;
use App\Exceptions\WalletNotFoundException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\BusinessException;


class ReversalService
{
    public function __construct(
        protected WalletRepositoryInterface $walletRepository,
        protected TransactionRepositoryInterface $transactionRepository,
    ) {}

    public function reverse(int $transactionId): Transaction {
         return DB::transaction(function () use ($transactionId) {

            $originalTransaction = $this->transactionRepository->findById($transactionId);

            if (!$originalTransaction) {
                throw new TransactionNotFoundException;
            }

            if ($originalTransaction->status === 'reversed') {
                throw new TransactionAlreadyReversedException;
            }

            if ($originalTransaction->status !== 'completed') {
                throw new BusinessException('Apenas transações completadas podem ser revertidas.', 400);
            }

            if ($originalTransaction->type === 'reversal') {
                throw new BusinessException('Não é possível reverter uma transação de reversão.', 400);
            }

            if ($originalTransaction->type === 'deposit') {
                $receiverId = $originalTransaction->receiver_id;
                $receiverWallet = $this->walletRepository->findByUserIdForUpdate($receiverId);

                if (! $receiverWallet) {
                    throw new WalletNotFoundException('Carteira não encontrada.');
                }

                if ((float) $receiverWallet->balance < (float) $originalTransaction->amount) {
                    throw new InsufficientBalanceException;
                }

                $newBalance = (float) $receiverWallet->balance - (float) $originalTransaction->amount;
                $this->walletRepository->updateBalance($receiverWallet, $newBalance);

                $reversal = $this->transactionRepository->create([
                    'uuid' => (string) Str::uuid(),
                    'type' => 'reversal',
                    'amount' => $originalTransaction->amount,
                    'sender_id' => $receiverId,
                    'receiver_id' => null,
                    'status' => 'completed',
                    'reversed_transaction_id' => $originalTransaction->id,
                ]);

            } elseif ($originalTransaction->type === 'transfer') {
                $senderId = $originalTransaction->sender_id;
                $receiverId = $originalTransaction->receiver_id;

                if ($senderId < $receiverId) {
                    $senderWallet = $this->walletRepository->findByUserIdForUpdate($senderId);
                    $receiverWallet = $this->walletRepository->findByUserIdForUpdate($receiverId);
                } else {
                    $receiverWallet = $this->walletRepository->findByUserIdForUpdate($receiverId);
                    $senderWallet = $this->walletRepository->findByUserIdForUpdate($senderId);
                }

                if (! $senderWallet || ! $receiverWallet) {
                    throw new WalletNotFoundException;
                }

                if ((float) $receiverWallet->balance < (float) $originalTransaction->amount) {
                    throw new InsufficientBalanceException;
                }

                $newReceiverBalance = (float) $receiverWallet->balance - (float) $originalTransaction->amount;
                $newSenderBalance = (float) $senderWallet->balance + (float) $originalTransaction->amount;

                $this->walletRepository->updateBalance($receiverWallet, $newReceiverBalance);
                $this->walletRepository->updateBalance($senderWallet, $newSenderBalance);

                $reversal = $this->transactionRepository->create([
                    'uuid' => (string) Str::uuid(),
                    'type' => 'reversal',
                    'amount' => $originalTransaction->amount,
                    'sender_id' => $receiverId, 
                    'receiver_id' => $senderId, 
                    'status' => 'completed',
                    'reversed_transaction_id' => $originalTransaction->id,
                ]);
            } else {
                throw new BusinessException('Tipo de transação desconhecido para reversão.', 400);
            }

            $this->transactionRepository->updateStatus($originalTransaction, 'reversed');

            return $reversal;
        });
    }
}