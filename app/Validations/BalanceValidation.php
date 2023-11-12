<?php

namespace App\Validations;

use App\Exceptions\InsuficienteBalanceException;
use App\Models\Wallet;
use Exception;

class BalanceValidation implements TransactionValidationInterface
{
    public function validate(array $data): void
    {
        $payer = Wallet::findOrFail($data['payer']);

        if ($payer->balance < $data['ammount']) {
            throw new InsuficienteBalanceException("Wallet does not have enough balance");
        }
    }
}
