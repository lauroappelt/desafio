<?php

namespace App\Validations;

use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\InsuficienteBalanceException;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;

class BalanceValidation implements TransferenceValidationInterface
{
    public function __construct(
        private WalletService $walletService
    ) {

    }

    public function validate(CreateTransferenceDTO $data): bool
    {
        if (!$this->walletService->walletHasEnoughBalanceToTransfer($data->ammount, $data->originWallet)) {
            throw new InsuficienteBalanceException("Wallet does not have enough balance");
        }

        return true;
    }
}
