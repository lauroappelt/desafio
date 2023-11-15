<?php

namespace App\Services;

use App\Exceptions\ResourceNotFound;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Wallet;
use App\Models\Operation;
use App\Repositories\WalletRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        private WalletRepository $repository,
        private OperationService $operationService
    ) {

    }

    public function createWallet(array $data): Wallet
    {
        return $this->repository->create($data);
    }

    public function getWalletSummary(string $walletId): Collection
    {
        return $this->repository->getWithOperations($walletId);
    }

    public function addBalanceToWallet(string $walletId, int $ammount)
    {
        DB::transaction(function () use ($walletId, $ammount) {
            try {
                $this->incrementWalletBalance($ammount, $walletId);
            } catch (ModelNotFoundException $notFoundException) {
                throw new ResourceNotFound("Wallet does not exists!");
            }
        });
    }

    public function incrementWalletBalance(int $ammount, string $walletId): Operation
    {
        $this->repository->incrementBalance($ammount, $walletId);
        return $this->operationService->createCreditOperation($walletId, $ammount);
    }

    public function decrementWalletBalance(int $ammount, string $walletId): Operation
    {
        $this->repository->decrementBalance($ammount, $walletId);
        return $this->operationService->createDebitOperation($walletId, $ammount);
    }

    public function walletHasEnoughBalanceToTransfer(int $ammout, string $walletId): bool
    {
        return $this->repository->getBalance($walletId) >= $ammout;
    }

    public function walletBelongsToShopkeeper(string $walletId)
    {
        return $this->repository->getUserTypeWalletOwner($walletId) == User::USER_SHOPKEEPER;
    }
}
