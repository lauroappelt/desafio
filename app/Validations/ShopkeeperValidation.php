<?php

namespace App\Validations;

use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\ShopkeeperCannotSendMoneyException;
use App\Models\User;
use App\Models\Wallet;
use App\Validations\TransactionValidationInterface;
use App\Services\WalletService;
use Exception;

class ShopkeeperValidation implements TransferenceValidationInterface
{
    public function __construct(
        private WalletService $walletService
    ) {

    }

    public function validate(CreateTransferenceDTO $data): bool
    {
        if ($this->walletService->walletBelongsToShopkeeper($data->originWallet)) {
            throw new ShopkeeperCannotSendMoneyException("Shopkeeper cannot send money");
        }

        return true;
    }
}
