<?php

namespace App\Services;

use App\Exceptions\ResourceNotFound;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Wallet;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        private OperationService $operationService
    ) {

    }

    public function createWallet(array $data): Wallet
    {
        $data['id'] = Uuid::uuid4();
        return Wallet::create($data);
    }

    public function getWalletSummary(string $walletId): Collection
    {
        return Wallet::with('operation')
            ->where('id', $walletId)
            ->get();
    }

    public function addBalanceToWallet(string $walletId, int $ammount)
    {
        DB::beginTransaction();

        try {
            $this->incrementWalletBalance($ammount, $walletId);
        } catch (ModelNotFoundException $notFoundException) {
            throw new ResourceNotFound("Wallet does not exists!");
            
        }

        DB::commit();
    }

    public function incrementWalletBalance(int $ammount, string $walletId): Operation
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->increment('balance', $ammount);

        return $this->operationService->createCreditOperation($walletId, $ammount);
    }

    public function decrementWalletBalance(int $ammount, string $walletId): Operation
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->decrement('balance', $ammount);

        return $this->operationService->createDebitOperation($walletId, $ammount);
    }

    public function walletHasEnoughBalanceToTransfer(int $ammout, string $walletId): bool
    {
        $wallet = Wallet::findOrFail($walletId);

        return $wallet->balance >= $ammout;
    }

    public function walletBelongsToShopkeeper(string $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);

        return $wallet->user->user_type == User::USER_SHOPKEEPER;
    }
}
