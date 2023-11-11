<?php

namespace App\Services;

use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use App\Rules\ShopkeeperValidation;
use App\Rules\BalanceValidation;
use App\Rules\ExternalAuthorizationValidation;

class CreateTransactionService
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private WalletRepository $walletRepository,
        private TransactionValidatorService $validationService,
    ) {

    }

    public function createTransaction(array $data): void
    {
        DB::beginTransaction();

        $this->validationService->add(new ShopkeeperValidation())
            ->add(new BalanceValidation())
            ->add(new ExternalAuthorizationValidation());

        $this->validationService->validate($data);

        $this->transactionRepository->createTransaction($data);

        $this->walletRepository->decrementWalletBalance($data['ammount'], $data['payer']);
        $this->walletRepository->incrementWalletBalance($data['ammount'], $data['payee']);

        DB::commit();
    }
}
