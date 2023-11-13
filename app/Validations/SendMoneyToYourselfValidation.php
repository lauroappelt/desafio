<?php
namespace App\Validations;

use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\TransactionException;

class SendMoneyToYourselfValidation implements TransferenceValidationInterface
{
    public function validate(CreateTransferenceDTO $data): bool
    {
        if ($data->originWallet == $data->destinationWallet) {
            throw new TransactionException("You cannot send money to yourself");
        }

        return true;
    }
}