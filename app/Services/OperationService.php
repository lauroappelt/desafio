<?php

namespace App\Services;

use App\Models\Operation;
use Ramsey\Uuid\Uuid;

class OperationService
{
    public function createCreditOperation(
        string $walletId,
        int $ammount
    ) {
        $operationId = Uuid::uuid4();

        return Operation::create([
            'id' => $operationId,
            'wallet_id' => $walletId,
            'operation_type' => Operation::CREDIT,
            'ammount' => $ammount
        ]);
    }

    public function createDebitOperation(
        string $walletId,
        int $ammount
    ) {
        $operationId = Uuid::uuid4();

        return Operation::create([
            'id' => $operationId,
            'wallet_id' => $walletId,
            'operation_type' => Operation::DEBIT,
            'ammount' => $ammount
        ]);
    }
}
