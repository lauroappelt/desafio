<?php

namespace App\Services;

use App\DTOs\CreateTransferenceDTO;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class CreateTransferenceService
{
    public function __construct(
        private TransferenceValidatorService $validatorService,
        private WalletService $walletService,
        private TransactionNotificationService $notificationService,
        private CreateTransactionService $createTransactionService,
    ) {

    }

    public function creatNewTransference(CreateTransferenceDTO $data)
    {
        DB::beginTransaction();

        $this->validateTransference($data);

        $creditOperation = $this->walletService->incrementWalletBalance($data->ammount, $data->destinationWallet);
        $debitOperation = $this->walletService->decrementWalletBalance($data->ammount, $data->originWallet);

        $transaction = $this->createTransactionService->createTransaction($debitOperation->id, $creditOperation->id);

        DB::commit();

        $this->notify($transaction);
    }

    public function validateTransference(CreateTransferenceDTO $data)
    {
        $this->validatorService->validate($data);
    }

    private function notify(Transaction $transaction): void
    {
        $this->notificationService->notify($transaction);
    }
}
