<?php

namespace App\Services;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Wallet;

class WalletService
{
    public function __construct(
        private Wallet $wallet
    ) {

    }

    public function createWallet(array $data)
    {
        $data['id'] = Uuid::uuid4();
        return $this->wallet->create($data);
    }

    public function incrementWalletBalance(int $ammount, string $id): bool
    {
        $this->wallet->where('id', $id)->increment('balance', $ammount);

        return true;
    }

    public function decrementWalletBalance(int $ammount, string $id): bool
    {
        $this->wallet->where('id', $id)->decrement('balance', $ammount);

        return true;
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
