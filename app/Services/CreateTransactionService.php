<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Ramsey\Uuid\Uuid;

class CreateTransactionService
{
    public function __construct(
        private TransactionRepository $repository
    ) {

    }

    public function createTransaction(string $originOperationId, string $destinationOperationId): Transaction
    {
        return $this->repository->create([
            'origin' => $originOperationId,
            'destination' => $destinationOperationId,
        ]);
    }
}
