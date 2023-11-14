<?php

namespace App\Services;

use App\Models\Operation;
use App\Repositories\OperationRepository;
use Ramsey\Uuid\Uuid;

class OperationService
{
    public function __construct(
        private OperationRepository $repository
    ) {

    }

    public function createCreditOperation(
        string $walletId,
        int $ammount
    ) {
        return $this->repository->create([
            'wallet_id' => $walletId,
            'operation_type' => Operation::CREDIT,
            'ammount' => $ammount
        ]);
    }

    public function createDebitOperation(
        string $walletId,
        int $ammount
    ) {
        return $this->repository->create([
            'wallet_id' => $walletId,
            'operation_type' => Operation::DEBIT,
            'ammount' => $ammount
        ]);
    }
}
