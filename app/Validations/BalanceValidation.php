<?php

namespace App\Validations;

use App\Exceptions\InsuficienteBalanceException;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;

class BalanceValidation implements TransactionValidationInterface
{
    public function __construct(
        private WalletService $walletService
    ) {

    }

    public function validate(array $data): void
    {
        if (!$this->walletService->walletHasEnoughBalanceToTransfer($data['ammount'], $data['payer'])) {
            throw new InsuficienteBalanceException("Wallet does not have enough balance");
        }
    }
}
