<?php

namespace App\Repositories;

use App\Models\Wallet;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Collection;

class WalletRepository
{
    public function __construct(
        private Wallet $wallet
    ) {

    }

    public function find(string $id): Wallet
    {
        return $this->wallet->findOrFail($id);
    }

    public function create($data): Wallet
    {
        $data['id'] = Uuid::uuid4();
        return $this->wallet->create($data);
    }

    public function getWithOperations(string $walletId): Collection
    {
        return $this->wallet->with('operation')
            ->where('id', $walletId)
            ->get();
    }

    public function getBalance(string $walletId): int
    {
        return $this->find($walletId)->balance;
    }

    public function incrementBalance(int $ammount, string $walletId): Wallet
    {
        $wallet = $this->find($walletId);
        $wallet->increment('balance', $ammount);
        return $wallet;
    }

    public function decrementBalance(int $ammount, string $walletId): Wallet
    {
        $wallet = $this->find($walletId);
        $wallet->decrement('balance', $ammount);
        return $wallet;
    }

    public function getUserTypeWalletOwner(string $walletId): string
    {
        return $this->find($walletId)->user->user_type;
    }
}
