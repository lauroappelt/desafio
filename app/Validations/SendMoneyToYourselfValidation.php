<?php
namespace App\Validations;

use App\Exceptions\TransactionException;

class SendMoneyToYourselfValidation implements TransactionValidationInterface
{
    public function validate(array $data): bool
    {
        if ($data['payer'] == $data['payee']) {
            throw new TransactionException("You cannot send money to yourself");
        }

        return true;
    }
}