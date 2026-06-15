<?php

namespace App\Services;

use App\Models\Transaction;
use App\DTO\TransferDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exceptions\WalletNotFoundException;
use App\Exceptions\InsufficientBalanceException;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;

class TransferService {

    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly TransactionRepositoryInterface $transactionRepository
    ) {}

    public function transfer(TransferDTO $dto): Transaction {

        if($dto ->senderId === $dto->receiverId){
            throw new \InvalidArgumentException('Não é permitido realizar transferências para si próprio.');
        }

        if($dto->amount <= 0){
            throw new \InvalidArgumentException('O valor da transferência deve ser maior que zero.');
        }
        
        return DB::transaction(function () use ($dto) {

            if ($dto->senderId < $dto->receiverId) {
                $senderWallet = $this->walletRepository->findByUserIdForUpdate($dto->senderId);
                $receiverWallet = $this->walletRepository->findByUserIdForUpdate($dto->receiverId);
            } else {
                $receiverWallet = $this->walletRepository->findByUserIdForUpdate($dto->receiverId);
                $senderWallet = $this->walletRepository->findByUserIdForUpdate($dto->senderId);
            }

            if (! $senderWallet) {
                throw new WalletNotFoundException('Carteira do remetente não encontrada.');
            }

            if (! $receiverWallet) {
                throw new WalletNotFoundException('Carteira do destinatário não encontrada.');
            }

            if ((float) $senderWallet->balance < $dto->amount) {
                throw new InsufficientBalanceException;
            }

            $newSenderBalance = (float) $senderWallet->balance - $dto->amount;
            $newReceiverBalance = (float) $receiverWallet->balance + $dto->amount;

            $this->walletRepository->updateBalance($senderWallet, $newSenderBalance);
            $this->walletRepository->updateBalance($receiverWallet, $newReceiverBalance);

            return $this->transactionRepository->create([
                'uuid' => (string) Str::uuid(),
                'type' => 'transfer',
                'amount' => $dto->amount,
                'sender_id' => $dto->senderId,
                'receiver_id' => $dto->receiverId,
                'status' => 'completed',
            ]);
        });
    }
}