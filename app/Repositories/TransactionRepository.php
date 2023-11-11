<?php

namespace App\Repositories;

use App\Models\Transaction;
use Ramsey\Uuid\Uuid;

class TransactionRepository
{
    public function __construct(
        private Transaction $transaction
    ) {

    }

    public function createTransaction(array $data): bool
    {
        $data['id'] =    Uuid::uuid4();
        $this->transaction->create($data);

        return true;
    }
}
