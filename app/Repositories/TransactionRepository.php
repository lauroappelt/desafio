<?php

namespace App\Repositories;

use App\Models\Transaction;
use Ramsey\Uuid\Uuid;

class TransactionRepository implements RepositoryInterface
{
    public function __construct(
        private Transaction $transaction
    ) {

    }

    public function create(array $data): Transaction
    {
        $data['id'] = Uuid::uuid4();
        return $this->transaction->create($data);
    }
}
