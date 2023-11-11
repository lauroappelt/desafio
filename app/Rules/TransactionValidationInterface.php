<?php

namespace App\Rules;

interface TransactionValidationInterface
{
    public function validate(array $data): void;
}
