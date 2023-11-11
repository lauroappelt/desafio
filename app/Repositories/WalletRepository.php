<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function __construct(
        private Wallet $wallet
    ) {

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
