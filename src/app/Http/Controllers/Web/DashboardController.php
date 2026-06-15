<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WalletService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected TransactionService $transactionService,
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

}
