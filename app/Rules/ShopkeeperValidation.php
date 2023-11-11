<?php

namespace App\Rules;

use App\Exceptions\ShopkeeperCannotSendMoneyException;
use App\Models\User;
use App\Models\Wallet;
use App\Rules\TransactionValidationInterface;
use Exception;

class ShopkeeperValidation implements TransactionValidationInterface
{
    public function validate(array $data): void
    {
        $payer = Wallet::findOrFail($data['payer']);

        if ($payer->user->user_type == User::USER_SHOPKEEPER) {
            throw new ShopkeeperCannotSendMoneyException("Shopkeeper cannot send money");
        }
    }
}
