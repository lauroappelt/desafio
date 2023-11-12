<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function __construct(
        private Transaction $transaction,
        private WalletService $walletService,
        private TransactionValidatorService $validationService,
        private TransactionNotificationService $notificationService,
    ) {

    }

    public function createTransaction(array $data): void
    {
        DB::beginTransaction();

        $this->validateTransacation($data);

        $transaction = $this->create($data);

        $this->walletService->decrementWalletBalance($data['ammount'], $data['payer']);
        $this->walletService->incrementWalletBalance($data['ammount'], $data['payee']);

        DB::commit();

        $this->notify($transaction);
    }

    private function validateTransacation(array $data): void
    {
        $this->validationService->validate($data);
    }

    private function create(array $data): Transaction
    {
        $data['id'] = Uuid::uuid4();
        return $this->transaction->create($data);
    }

    private function notify(Transaction $transaction)
    {
        $this->notificationService->notify($transaction);
    }
}
