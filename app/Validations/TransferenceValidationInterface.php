<?php

namespace App\Validations;

use App\DTOs\CreateTransferenceDTO;

interface TransferenceValidationInterface
{
    public function validate(CreateTransferenceDTO $data): bool;
}
