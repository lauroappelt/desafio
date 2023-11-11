<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private WalletRepository $walletRepository
    ) {

    }

    public function createTransaction(array $data): void
    {
        DB::beginTransaction();

        $payer = Wallet::findOrFail($data['payer']);
        $payee = Wallet::findOrFail($data['payee']);

        if ($payer->user->user_type == User::USER_SHOPKEEPER) {
            throw new Exception("Shopkeepers cannot send money");
        }

        if ($payer->balance < $data['ammount']) {
            throw new Exception("wallet does not have enough balance");
        }

        $externalAuthorization = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');
        if ($externalAuthorization->status() != 200) {
            throw new Exception("Transaction is not authorized");
        }

        $this->transactionRepository->createTransaction($data);

        $this->walletRepository->decrementWalletBalance($data['ammount'], $payer->id);
        $this->walletRepository->incrementWalletBalance($data['ammount'], $payee->id);

        DB::commit();
    }
}
