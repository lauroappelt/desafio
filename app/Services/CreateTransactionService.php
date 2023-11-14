<?php

namespace App\Services;

use App\Models\Transaction;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function createTransaction(string $originOperationId, string $destinationOperationId): Transaction
    {
        $transactionId = Uuid::uuid4();
        return Transaction::create([
            'id' => $transactionId,
            'origin' => $originOperationId,
            'destination' => $destinationOperationId,
        ]);
    }
}
