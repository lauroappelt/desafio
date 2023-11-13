<?php

namespace App\Services;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Wallet;
use App\DTOs\AddBalanceDTO;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        private Wallet $wallet,
        private OperationService $operationService
    ) {

    }

    public function addBalanceToWallet(AddBalanceDTO $data)
    {
        DB::beginTransaction();

        $this->incrementWalletBalance($data->ammount, $data->walletId);
        
        DB::commit();
    }

    public function createWallet(array $data): Wallet
    {
        $data['id'] = Uuid::uuid4();
        return $this->wallet->create($data);
    }

    public function incrementWalletBalance(int $ammount, string $id): Operation
    {
        $this->wallet->where('id', $id)->increment('balance', $ammount);

        return $this->operationService->createCreditOperation($id, $ammount);
    }

    public function decrementWalletBalance(int $ammount, string $id): Operation
    {
        $this->wallet->where('id', $id)->decrement('balance', $ammount);

        return $this->operationService->createDebitOperation($id, $ammount);
    }

    public function walletHasEnoughBalanceToTransfer(int $ammout, string $id): bool
    {
        $wallet = $this->wallet->find($id);

        return $wallet->balance >= $ammout;
    }

    public function walletBelongsToShopkeeper(string $id)
    {
        $wallet = $this->wallet->find($id);

        return $wallet->user->user_type == User::USER_SHOPKEEPER;
    }
}
