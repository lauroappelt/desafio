<?php

namespace App\Services;

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

        $this->wallet->create($data);

        return $data;
    }

    public function incrementWalletBalance(int $ammount, string $id): void
    {
        $this->wallet->where('id', $id)->increment('balance', $ammount);
    }

    public function decrementWalletBalance(int $ammount, string $id): void
    {
        $this->wallet->where('id', $id)->decrement('balance', $ammount);
    }
}
