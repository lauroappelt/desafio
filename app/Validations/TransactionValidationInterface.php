<?php

namespace App\Validations;

interface TransactionValidationInterface
{
    public function validate(array $data): void;
}
