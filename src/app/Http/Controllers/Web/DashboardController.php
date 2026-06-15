<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WalletService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\DepositRequest;
use App\Exceptions\BusinessException;
use App\DTO\DepositDTO;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use App\DTO\TransferDTO;
use App\Services\ReversalService;

class DashboardController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected TransactionService $transactionService,
        protected TransferService $transferService,
        protected ReversalService $reversalService,
    ) {}

    public function index(Request $request): View
    {
        $userId = $request->user()->id;

        $wallet = $this->walletService->getWallet($userId);

        $users = User::where('id', '!=', $userId)->orderBy('name')->get();

        $filters = $request->only(['type', 'status', 'date_from', 'date_to', 'order_by', 'order_dir']);

        $transactions = $this->transactionService->getUserTransactions($userId, $filters, 10);

        return view('dashboard', compact('wallet', 'users', 'transactions', 'filters'));
    }

    public function deposit(DepositRequest $request): RedirectResponse
    {
        $dto = new DepositDTO(
            userId: $request->user()->id,
            amount: (float) $request->validated('amount')
        );

        try {
            $this->walletService->deposit($dto);

            return redirect()->route('dashboard')
                ->with('success', 'Depósito realizado com sucesso!');
        } catch (BusinessException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function transfer(TransferRequest $request): RedirectResponse
    {
        $dto = new TransferDTO(
            senderId: $request->user()->id,
            receiverId: (int) $request->validated('receiver_id'),
            amount: (float) $request->validated('amount')
        );

        try {
            $this->transferService->transfer($dto);

            return redirect()->route('dashboard')
                ->with('success', 'Transferência realizada com sucesso!');
        } catch (BusinessException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reverse(Request $request, int $id): RedirectResponse
    {
        try {

            $transaction = $this->transactionService->getTransactionDetail($id, $request->user()->id);

            $this->reversalService->reverse($transaction->id);

            return redirect()->route('dashboard')
                ->with('success', 'Transação revertida com sucesso!');
        } catch (BusinessException $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }

}
