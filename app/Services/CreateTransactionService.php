<?php

namespace App\Services;

use App\Models\Transaction;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function createTransaction(string $originOperationId, string $destinationOperationId): Transaction
    {
        $id = Uuid::uuid4();
        return Transaction::create([
            'id' => $id,
            'origin' => $originOperationId,
            'destination' => $destinationOperationId,
        ]);
    }
}
