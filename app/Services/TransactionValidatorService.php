<?php

namespace App\Services;

use App\Models\Transaction;
use App\validations\TransactionValidationInterface;

class TransactionValidatorService
{
    private $validations = [];

    public function add(TransactionValidationInterface $validation): TransactionValidatorService
    {
        $this->validations[] = $validation;
        return $this;
    }

    public function validate(array $data): void
    {
        foreach ($this->validations as $validation) {
            $validation->validate($data);
        }
    }
}
