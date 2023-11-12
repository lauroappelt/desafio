<?php

namespace App\Validations;

use App\Exceptions\ShopkeeperCannotSendMoneyException;
use App\Models\User;
use App\Models\Wallet;
use App\Validations\TransactionValidationInterface;
use App\Services\WalletService;
use Exception;

class ShopkeeperValidation implements TransactionValidationInterface
{
    public function __construct(
        private WalletService $walletService
    ) {

    }

    public function validate(array $data): void
    {
        if ($this->walletService->walletBelongsToShopkeeper($data['payer'])) {
            throw new ShopkeeperCannotSendMoneyException("Shopkeeper cannot send money");
        }
    }
}
