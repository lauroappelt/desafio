<?php

namespace App\Repositories;

use App\Models\Wallet;
use Ramsey\Uuid\Uuid;

class WalletRepository
{
    public function __construct(
        private Wallet $wallet
    ) {

    }

    public function createWallet(array $data)
    {
        $data['id'] = Uuid::uuid4();

        $this->wallet->create($data);

        return $data;
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
}
