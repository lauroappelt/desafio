<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Validations\ShopkeeperValidation;
use App\Validations\BalanceValidation;
use App\Validations\ExternalAuthorizationValidation;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function __construct(
        private Transaction $transaction,
        private WalletService $walletService,
        private TransactionValidatorService $validationService,
    ) {

    }

    public function createTransaction(array $data): void
    {
        DB::beginTransaction();

        $this->validateTransacation($data);

        $this->createTransaction($data);

        $this->walletService->decrementWalletBalance($data['ammount'], $data['payer']);
        $this->walletService->incrementWalletBalance($data['ammount'], $data['payee']);

        DB::commit();
    }

    private function validateTransacation(array $data): void
    {
        $this->validationService->add(new ShopkeeperValidation())
            ->add(new BalanceValidation())
            ->add(new ExternalAuthorizationValidation());

        $this->validationService->validate($data);
    }

    public function create(array $data): Transaction
    {
        $data['id'] = Uuid::uuid4();
        return $this->transaction->create($data);
    }
}
